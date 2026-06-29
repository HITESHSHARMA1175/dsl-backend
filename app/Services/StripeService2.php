<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Process a payment using Stripe PaymentIntent
     *
     * @param int $amount Amount in dollars
     * @param string $paymentMethodId Stripe Payment Method ID
     * @return array
     */
    public function processPayment($amount, $paymentMethodId)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Convert dollars to cents
                'currency' => 'gbp',
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'return_url' => route('order-success'), // Redirect after payment
                
            ]);

            return [
                'success' => true,
                'message' => 'Payment successful!',
                'paymentIntent' => $paymentIntent
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
