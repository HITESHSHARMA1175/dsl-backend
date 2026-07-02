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
   * Creates a Stripe Checkout Session for a shop order, attaching billing
   * metadata and shipping details to the underlying PaymentIntent.
   */
  async createCheckoutSessionShop(
    amountInPounds: number,
    billing: any,
    successUrl: string,
    cancelUrl: string
  ) {
    const fullName = `${billing.billing_first_name ?? ''} ${billing.billing_last_name ?? ''}`.trim();
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
      customer_email: billing.billing_email,
      payment_intent_data: {
        metadata: {
          name: fullName,
          phone: billing.billing_phone ?? '',
          company: billing.billing_company ?? '',
        },
        shipping: {
          name: fullName,
          address: {
            line1: billing.billing_address_1 ?? '',
            city: billing.billing_city ?? '',
            postal_code: billing.billing_postcode ?? '',
            country: billing.billing_country ?? 'GB',
          },
          phone: billing.billing_phone ?? '',
        },
      },
      success_url: successUrl,
      cancel_url: cancelUrl,
    });
  }

  /**
   * Direct server-side charge using a payment method id (confirmed immediately).
   * Used by process-payment / booking-payment flows.
   */
  async processDirectPayment(amountInPounds: number, paymentMethodId: string) {
    return this.stripe.paymentIntents.create({
      amount: Math.round(amountInPounds * 100),
      currency: 'gbp',
      payment_method: paymentMethodId,
      confirmation_method: 'manual',
      confirm: true,
      return_url: env.STRIPE_RETURN_URL,
    });
  }

  /**
   * Apple Pay charge — confirms a PaymentIntent from an Apple Pay payment method/token.
   */
  async applePayCharge(amountInPounds: number, paymentMethodId: string) {
    return this.stripe.paymentIntents.create({
      amount: Math.round(amountInPounds * 100),
      currency: 'gbp',
      payment_method: paymentMethodId,
      confirm: true,
      return_url: env.STRIPE_RETURN_URL,
    });
  }

  /**
   * Retrieves a PaymentIntent by its ID (used to pull billing metadata after checkout).
   */
  async retrievePaymentIntent(paymentIntentId: string) {
    return this.stripe.paymentIntents.retrieve(paymentIntentId);
  }
}
