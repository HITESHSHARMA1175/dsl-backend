<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KlarnaService;

class CheckoutController extends Controller
{
    protected $klarnaService;

    public function __construct(KlarnaService $klarnaService)
    {
        $this->klarnaService = $klarnaService;
    }

    public function createOrder()
    {
        $orderData = [
            "purchase_country" => "US",
            "purchase_currency" => "USD",
            "locale" => "en-US",
            "status" => "CHECKOUT_INCOMPLETE",
            "billing_address" => [
                "given_name" => "John",
                "family_name" => "Doe",
                "email" => "john@doe.com",
                "street_address" => "Lombard St 10",
                "postal_code" => "90210",
                "city" => "Beverly Hills",
                "region" => "CA",
                "phone" => "333444555",
                "country" => "US",
            ],
            "order_amount" => 50000,
            "order_tax_amount" => 4545,
            "order_lines" => [
                [
                    "type" => "physical",
                    "reference" => "19-402-USA",
                    "name" => "Red T-Shirt",
                    "quantity" => 5,
                    "unit_price" => 10000,
                    "tax_rate" => 1000,
                    "total_amount" => 50000,
                    "total_tax_amount" => 4545,
                    "product_url" => "https://www.example.com/products/f2a8d7e34",
                    "image_url" => "https://www.exampleobjects.com/product-image-1200x1200.jpg",
                ],
            ],
            "merchant_urls" => [
                "terms" => "https://www.example.com/terms.html",
                "checkout" => "https://www.example.com/checkout.html",
                "confirmation" => "https://www.example.com/confirmation.html",
                "push" => "https://www.example.com/api/push",
            ],
        ];

        $response = $this->klarnaService->createOrder($orderData);

        return response()->json($response);
    }
}
