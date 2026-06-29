import Stripe from 'stripe';
import { env } from '../../config/env';

export class StripeService {
  private stripe: Stripe;

  constructor() {
    this.stripe = new Stripe(env.STRIPE_SECRET_KEY, { apiVersion: '2025-02-24.acacia' });
  }

  /**
   * Creates a PaymentIntent in GBP currency with immediate confirmation.
   * Converts pounds to pence (amount * 100) for Stripe.
   */
  async createPaymentIntent(amountInPounds: number, paymentMethodId: string) {
    return this.stripe.paymentIntents.create({
      amount: Math.round(amountInPounds * 100),
      currency: 'gbp',
      payment_method: paymentMethodId,
      confirm: true,
      return_url: env.STRIPE_RETURN_URL,
    });
  }

  /**
   * Creates a Stripe Checkout Session for card payments in GBP.
   * Converts pounds to pence (amount * 100) for line item pricing.
   */
  async createCheckoutSession(amountInPounds: number, successUrl: string, cancelUrl: string) {
    return this.stripe.checkout.sessions.create({
      payment_method_types: ['card'],
      line_items: [{
        price_data: {
          currency: 'gbp',
          product_data: { name: 'Total Amount' },
          unit_amount: Math.round(amountInPounds * 100),
        },
        quantity: 1,
      }],
      mode: 'payment',
      success_url: successUrl,
      cancel_url: cancelUrl,
    });
  }

  /**
   * Verifies a Stripe webhook signature and returns the parsed event.
   * Throws if the signature is invalid.
   */
  verifyWebhookSignature(payload: Buffer, signature: string): Stripe.Event {
    return this.stripe.webhooks.constructEvent(payload, signature, env.STRIPE_WEBHOOK_SECRET);
  }

  /**
   * Retrieves a Checkout Session by its ID.
   */
  async retrieveSession(sessionId: string) {
    return this.stripe.checkout.sessions.retrieve(sessionId);
  }
}
