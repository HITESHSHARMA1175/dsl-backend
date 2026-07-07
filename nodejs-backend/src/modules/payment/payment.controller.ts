import { Request, Response, NextFunction } from 'express';
import { StripeService } from './stripe.service';
import { KlarnaService } from './klarna.service';
import { prisma } from '../../config/database';
import { env } from '../../config/env';
import { successResponse, errorResponse } from '../../shared/utils/response.util';
import { SendGridService } from '../../shared/services/sendgrid.service';

const stripeService = new StripeService();
const klarnaService = new KlarnaService();
const sendgrid = new SendGridService();

/**
 * Upsert a customer by email and return the customer id.
 */
async function upsertCustomer(billing: {
  email?: string;
  first_name?: string;
  last_name?: string;
  mobile?: string;
}): Promise<number | null> {
  if (!billing.email) return null;
  const existing = await (prisma as any).customer.findFirst({
    where: { email: billing.email },
    orderBy: { id: 'desc' },
  });
  if (existing) return Number(existing.id);
  const created = await (prisma as any).customer.create({
    data: {
      first_name: billing.first_name ?? null,
      last_name: billing.last_name ?? null,
      mobile: billing.mobile ?? null,
      email: billing.email,
    },
  });
  return Number(created.id);
}

/**
 * Persist an Order record from billing + cart details.
 */
async function persistOrder(userId: number | null, billing: any, amount: number, paymentMethod: string, paymentMethodId: string, cartDetails: any) {
  return (prisma as any).order.create({
    data: {
      user_id: userId,
      billing_first_name: billing.first_name ?? billing.billing_first_name ?? null,
      billing_last_name: billing.last_name ?? billing.billing_last_name ?? null,
      billing_phone: billing.phone ?? billing.billing_phone ?? null,
      billing_email: billing.email ?? billing.billing_email ?? null,
      billing_company: billing.company ?? billing.billing_company ?? null,
      billing_country: billing.country ?? billing.billing_country ?? null,
      billing_address_1: billing.address_1 ?? billing.billing_address_1 ?? null,
      billing_city: billing.city ?? billing.billing_city ?? null,
      billing_postcode: billing.postcode ?? billing.billing_postcode ?? null,
      order_amount: Math.round(amount),
      payment_method: paymentMethod,
      payment_method_id: paymentMethodId,
      cart_details: cartDetails ?? null,
      order_status: 'Pending',
      status: 1,
    },
  });
}

/**
 * Persist a KiBooking record from booking data.
 */
async function persistBooking(userId: number | null, data: any, amount: number, paymentMethod: string, paymentMethodId: string) {
  return (prisma as any).kiBooking.create({
    data: {
      user_id: userId,
      service_id: data.service_id ? JSON.stringify(data.service_id) : null,
      addon_id: data.addon_id ? JSON.stringify(data.addon_id) : null,
      profession_id: data.profession_id ?? null,
      total_service_duration: data.total_service_duration ? String(data.total_service_duration) : null,
      total_addon_duration: data.total_addon_duration ? String(data.total_addon_duration) : null,
      ddate: data.ddate ? new Date(data.ddate) : new Date(),
      slot_id: data.slot_id ?? null,
      slot_date: data.slot_date ?? null,
      slot_time: data.slot_time ?? null,
      first_name: data.first_name ?? null,
      last_name: data.last_name ?? null,
      email: data.email ?? null,
      mobile: data.mobile ?? null,
      payment_method: paymentMethod,
      payment_method_id: paymentMethodId,
      payment_amount: String(amount),
      is_web: 1,
      cart_details: data.cart_details ?? null,
    },
  });
}

/**
 * POST /stripe/payment-intent
 * Creates a Stripe PaymentIntent for authenticated customers.
 */
export async function createPaymentIntent(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount, payment_method_id } = req.body;
    const paymentIntent = await stripeService.createPaymentIntent(amount, payment_method_id);
    return res.status(200).json(successResponse(200, 'Payment intent created', paymentIntent));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/checkout-session
 * Creates a Stripe Checkout Session. Builds success/cancel URLs from env or request body.
 */
export async function createCheckoutSession(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount, success_url, cancel_url } = req.body;

    const successUrl = success_url ?? `${env.STRIPE_RETURN_URL}?session_id={CHECKOUT_SESSION_ID}`;
    const cancelUrl = cancel_url ?? env.STRIPE_RETURN_URL;

    const session = await stripeService.createCheckoutSession(amount, successUrl, cancelUrl);
    return res.status(200).json(successResponse(200, 'Checkout session created', session));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/webhook
 * Verifies Stripe webhook signature (raw body) and handles checkout.session.completed events.
 */
export async function handleStripeWebhook(req: Request, res: Response, next: NextFunction) {
  try {
    const signature = req.headers['stripe-signature'] as string;
    if (!signature) {
      return res.status(400).json(errorResponse(400, 'Missing stripe-signature header'));
    }

    const event = stripeService.verifyWebhookSignature(req.body as Buffer, signature);

    if (event.type === 'checkout.session.completed') {
      const session = event.data.object as any;
      const amountTotal = session.amount_total ? session.amount_total / 100 : 0;

      // Create a booking record upon successful checkout
      await (prisma as any).kiBooking.create({
        data: {
          payment_method: 'stripe',
          payment_method_id: session.payment_intent ?? session.id,
          payment_amount: String(amountTotal),
          is_web: 1,
        },
      });
    }

    return res.status(200).json({ received: true });
  } catch (error) {
    next(error);
  }
}

/**
 * GET /stripe/success?session_id=...
 * Retrieves a completed checkout session's details.
 */
export async function handleCheckoutSuccess(req: Request, res: Response, next: NextFunction) {
  try {
    const sessionId = req.query.session_id as string;
    if (!sessionId) {
      return res.status(400).json(errorResponse(400, 'Missing session_id query parameter'));
    }

    const session = await stripeService.retrieveSession(sessionId);
    return res.status(200).json(successResponse(200, 'Checkout session retrieved', session));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/payment-link-shop
 * Creates a Stripe Checkout Session for a shop order with billing metadata.
 */
export async function createCheckoutSessionShop(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount } = req.body;
    const successUrl = `${env.STRIPE_RETURN_URL}?session_id={CHECKOUT_SESSION_ID}`;
    const cancelUrl = env.STRIPE_RETURN_URL;
    const session = await stripeService.createCheckoutSessionShop(amount, req.body, successUrl, cancelUrl);
    return res.status(200).json(successResponse(200, 'Shop checkout session created', { payment_url: session.url, id: session.id }));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/confirm-order
 * Confirms a completed checkout session and persists a shop Order (+ email).
 */
export async function confirmOrder(req: Request, res: Response, next: NextFunction) {
  try {
    const { session_id, cart_details } = req.body;
    const session: any = await stripeService.retrieveSession(session_id);
    if (session.payment_status !== 'paid') {
      return res.status(400).json(errorResponse(400, 'Payment not completed'));
    }

    let billing: any = { email: session.customer_details?.email };
    if (session.payment_intent) {
      const pi: any = await stripeService.retrievePaymentIntent(session.payment_intent);
      const nameParts = (pi.metadata?.name ?? '').split(' ');
      billing = {
        email: session.customer_details?.email,
        first_name: nameParts[0] ?? '',
        last_name: nameParts[1] ?? '',
        phone: pi.metadata?.phone,
        company: pi.metadata?.company,
        country: pi.shipping?.address?.country,
        address_1: pi.shipping?.address?.line1,
        city: pi.shipping?.address?.city,
        postcode: pi.shipping?.address?.postal_code,
      };
    }

    const amount = session.amount_total ? session.amount_total / 100 : 0;
    const userId = await upsertCustomer(billing);
    const order = await persistOrder(userId, billing, amount, 'stripe', session.payment_intent ?? session.id, cart_details);

    if (billing.email) {
      try {
        await sendgrid.sendOrderConfirmation(billing.email, {
          orderId: Number(order.id),
          amount: String(amount),
          date: new Date().toDateString(),
        });
      } catch { /* email failures shouldn't block order creation */ }
    }

    return res.status(201).json(successResponse(201, 'Order placed successfully', order));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/process-payment
 * Direct server-side charge that persists a shop Order (+ email).
 */
export async function processPayment(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount, payment_method_id, cart_details } = req.body;
    const intent: any = await stripeService.processDirectPayment(amount, payment_method_id);

    const userId = await upsertCustomer({
      email: req.body.billing_email,
      first_name: req.body.billing_first_name,
      last_name: req.body.billing_last_name,
      mobile: req.body.billing_phone,
    });
    const order = await persistOrder(userId, req.body, req.body.order_amount ?? amount, req.body.payment_method ?? 'stripe', intent.id, cart_details);

    if (req.body.billing_email) {
      try {
        await sendgrid.sendOrderConfirmation(req.body.billing_email, {
          orderId: Number(order.id),
          amount: String(req.body.order_amount ?? amount),
          date: new Date().toDateString(),
        });
      } catch { /* ignore email failure */ }
    }

    return res.status(201).json(successResponse(201, 'Payment processed and order created', { order, payment_intent: intent.id, status: intent.status }));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/booking-payment
 * Direct server-side charge that persists a KiBooking (+ email).
 */
export async function bookingProcessPayment(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount, payment_method_id } = req.body;
    const intent: any = await stripeService.processDirectPayment(amount, payment_method_id);

    const userId = await upsertCustomer({
      email: req.body.email,
      first_name: req.body.first_name,
      last_name: req.body.last_name,
      mobile: req.body.mobile,
    });
    const booking = await persistBooking(userId, req.body, amount, req.body.payment_method ?? 'stripe', intent.id);

    if (req.body.email) {
      try {
        await sendgrid.sendBookingConfirmation(req.body.email, {
          bookingId: Number(booking.id),
          amount: String(amount),
          date: new Date().toDateString(),
          time: new Date().toTimeString().split(' ')[0],
        });
      } catch { /* ignore email failure */ }
    }

    return res.status(201).json(successResponse(201, 'Payment processed and booking created', { booking, payment_intent: intent.id, status: intent.status }));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/confirm-booking
 * Confirms a completed checkout session and persists a KiBooking (+ email).
 */
export async function confirmBooking(req: Request, res: Response, next: NextFunction) {
  try {
    const { session_id } = req.body;
    const session: any = await stripeService.retrieveSession(session_id);
    if (session.payment_status !== 'paid') {
      return res.status(400).json(errorResponse(400, 'Payment not completed'));
    }

    const amount = session.amount_total ? session.amount_total / 100 : 0;
    const billing = {
      email: session.customer_details?.email ?? req.body.email,
      first_name: req.body.first_name,
      last_name: req.body.last_name,
      mobile: req.body.mobile,
    };
    const userId = await upsertCustomer(billing);
    const booking = await persistBooking(userId, { ...req.body, email: billing.email }, amount, 'stripe', session.payment_intent ?? session.id);

    if (billing.email) {
      try {
        await sendgrid.sendBookingConfirmation(billing.email, {
          bookingId: Number(booking.id),
          amount: String(amount),
          date: new Date().toDateString(),
          time: new Date().toTimeString().split(' ')[0],
        });
      } catch { /* ignore email failure */ }
    }

    return res.status(201).json(successResponse(201, 'Booking confirmed', booking));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /stripe/apple-pay
 * Charges an Apple Pay payment method/token.
 */
export async function applePay(req: Request, res: Response, next: NextFunction) {
  try {
    const { amount, payment_method_id } = req.body;
    const intent = await stripeService.applePayCharge(amount, payment_method_id);
    return res.status(200).json(successResponse(200, 'Apple Pay charge processed', { payment_intent: intent.id, status: intent.status }));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /klarna/session
 * Creates a Klarna payment session with the provided order lines.
 */
export async function createKlarnaSession(req: Request, res: Response, next: NextFunction) {
  try {
    const { order_lines } = req.body;
    const session = await klarnaService.createSession({ order_lines });
    return res.status(200).json(successResponse(200, 'Klarna session created', session));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /klarna/order
 * Creates a Klarna order using an authorization token.
 */
export async function createKlarnaOrder(req: Request, res: Response, next: NextFunction) {
  try {
    const { authorization_token, order_data } = req.body;
    const order = await klarnaService.createOrder(authorization_token, order_data);
    return res.status(200).json(successResponse(200, 'Klarna order created', order));
  } catch (error) {
    next(error);
  }
}

/**
 * DELETE /klarna/authorization/:token
 * Cancels a Klarna authorization by token.
 */
export async function cancelKlarnaAuth(req: Request, res: Response, next: NextFunction) {
  try {
    const token = req.params.token as string;
    await klarnaService.cancelAuthorization(token);
    return res.status(200).json(successResponse(200, 'Klarna authorization cancelled', null));
  } catch (error) {
    next(error);
  }
}

/**
 * GET /klarna/session/:id
 * Retrieves a Klarna session by its ID.
 */
export async function getKlarnaSession(req: Request, res: Response, next: NextFunction) {
  try {
    const id = req.params.id as string;
    const session = await klarnaService.getSession(id);
    return res.status(200).json(successResponse(200, 'Klarna session retrieved', session));
  } catch (error) {
    next(error);
  }
}

/**
 * POST /klarna/order-web
 * Creates a Klarna order from an authorization token, fetches billing from
 * the Klarna order-management API, and persists a Customer + Order locally.
 */
export async function createKlarnaOrderWeb(req: Request, res: Response, next: NextFunction) {
  try {
    const { authorization_token, order_amount, order_lines, cart_details } = req.body;

    const orderResp: any = await klarnaService.createOrderFromAuthorization(authorization_token, {
      order_amount,
      order_tax_amount: 0,
      order_lines: order_lines ?? [
        { name: 'Order', quantity: 1, unit_price: order_amount, total_amount: order_amount },
      ],
      merchant_reference1: `Order_${Date.now()}`,
    });

    const orderId = orderResp.order_id;
    let billing: any = {};
    try {
      const details: any = await klarnaService.getOrderDetails(orderId);
      billing = {
        email: details.customer?.email ?? details.billing_address?.email,
        first_name: details.billing_address?.given_name,
        last_name: details.billing_address?.family_name,
        phone: details.billing_address?.phone,
        city: details.billing_address?.city,
        postcode: details.billing_address?.postal_code,
        address_1: details.billing_address?.street_address,
        country: details.billing_address?.country,
      };
    } catch { /* order-management lookup is best-effort */ }

    const userId = await upsertCustomer(billing);
    const order = await persistOrder(userId, billing, (order_amount ?? 0) / 100, 'klarna', orderId, cart_details);

    return res.status(201).json(successResponse(201, 'Klarna order created', { klarna_order_id: orderId, order }));
  } catch (error) {
    next(error);
  }
}
