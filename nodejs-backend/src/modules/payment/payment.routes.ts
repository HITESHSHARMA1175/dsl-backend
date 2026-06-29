import { Router } from 'express';
import { authMiddleware } from '../../middleware/auth.middleware';
import { validate } from '../../middleware/validate.middleware';
import {
  createPaymentIntentSchema,
  createCheckoutSessionSchema,
  createKlarnaSessionSchema,
  createKlarnaOrderSchema,
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
} from './payment.controller';

const router = Router();

// --- Stripe routes ---

// Customer auth required — create a direct payment intent
router.post('/stripe/payment-intent', authMiddleware, validate(createPaymentIntentSchema), createPaymentIntent);

// Public — create a checkout session
router.post('/stripe/checkout-session', validate(createCheckoutSessionSchema), createCheckoutSession);

// Public — Stripe webhook (raw body already handled in app.ts)
router.post('/stripe/webhook', handleStripeWebhook);

// Public — checkout success redirect
router.get('/stripe/success', handleCheckoutSuccess);

// --- Klarna routes ---

// Public — create a Klarna payment session
router.post('/klarna/session', validate(createKlarnaSessionSchema), createKlarnaSession);

// Public — create a Klarna order from authorization
router.post('/klarna/order', validate(createKlarnaOrderSchema), createKlarnaOrder);

// Public — cancel a Klarna authorization
router.delete('/klarna/authorization/:token', cancelKlarnaAuth);

// Public — get Klarna session details
router.get('/klarna/session/:id', getKlarnaSession);

export default router;
