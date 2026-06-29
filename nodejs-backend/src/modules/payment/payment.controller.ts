import { Request, Response, NextFunction } from 'express';
import { StripeService } from './stripe.service';
import { KlarnaService } from './klarna.service';
import { prisma } from '../../config/database';
import { env } from '../../config/env';
import { successResponse, errorResponse } from '../../shared/utils/response.util';

const stripeService = new StripeService();
const klarnaService = new KlarnaService();

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

      // Create a booking or order record upon successful checkout
      await prisma.kiBooking.create({
        data: {
          payment_method: 'stripe',
          payment_method_id: session.payment_intent ?? session.id,
          payment_amount: amountTotal,
          booking_status: 'confirmed',
          is_web: '1',
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
