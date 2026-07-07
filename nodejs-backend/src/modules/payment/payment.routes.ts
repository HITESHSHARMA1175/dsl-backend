import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  createPaymentIntentSchema,
  createCheckoutSessionSchema,
  createKlarnaSessionSchema,
  createKlarnaOrderSchema,
  checkoutSessionShopSchema,
  confirmOrderSchema,
  processPaymentSchema,
  bookingPaymentSchema,
  confirmBookingSchema,
  applePaySchema,
  klarnaOrderWebSchema,
} from './payment.schema';
import {
  createPaymentIntent,
  createCheckoutSession,
  handleStripeWebhook,
  handleCheckoutSuccess,
  createKlarnaSession,
  createKlarnaOrder,
  cancelKlarnaAuth,
  getKlarnaSession,
  createCheckoutSessionShop,
  confirmOrder,
  processPayment,
  bookingProcessPayment,
  confirmBooking,
  applePay,
  createKlarnaOrderWeb,
} from './payment.controller';

const router = Router();

// --- Stripe routes ---

// Customer auth required — create a direct payment intent
router.post('/stripe/payment-intent', authMiddleware, validate(createPaymentIntentSchema), createPaymentIntent);

// Public — create a checkout session
router.post('/stripe/checkout-session', validate(createCheckoutSessionSchema), createCheckoutSession);

// Public — create a shop checkout session (with billing metadata)
router.post('/stripe/payment-link-shop', validate(checkoutSessionShopSchema), createCheckoutSessionShop);

// Public — Stripe webhook (raw body already handled in app.ts)
router.post('/stripe/webhook', handleStripeWebhook);

// Public — checkout success redirect (retrieve session)
router.get('/stripe/success', handleCheckoutSuccess);

// Public — confirm a paid checkout session and persist Order / Booking
router.post('/stripe/confirm-order', validate(confirmOrderSchema), confirmOrder);
router.post('/stripe/confirm-booking', validate(confirmBookingSchema), confirmBooking);

// Public — direct charge flows that persist Order / Booking
router.post('/stripe/process-payment', validate(processPaymentSchema), processPayment);
router.post('/stripe/booking-payment', validate(bookingPaymentSchema), bookingProcessPayment);

// Public — Apple Pay charge
router.post('/stripe/apple-pay', validate(applePaySchema), applePay);

// --- Klarna routes ---

// Public — create a Klarna payment session
router.post('/klarna/session', validate(createKlarnaSessionSchema), createKlarnaSession);

// Public — create a Klarna order from authorization
router.post('/klarna/order', validate(createKlarnaOrderSchema), createKlarnaOrder);

// Public — create a Klarna order (web) and persist Customer + Order
router.post('/klarna/order-web', validate(klarnaOrderWebSchema), createKlarnaOrderWeb);

// Public — cancel a Klarna authorization
router.delete('/klarna/authorization/:token', cancelKlarnaAuth);

// Public — get Klarna session details
router.get('/klarna/session/:id', getKlarnaSession);

export default router;
