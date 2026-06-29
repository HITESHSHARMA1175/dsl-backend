<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KlarnaPaymentController extends Controller
{
    private $klarnaApiUrl;
    private $klarnaUsername;
    private $klarnaPassword;

    public function __construct()
    {
        // Replace with your Klarna API credentials
        $this->klarnaApiUrl = 'https://api.klarna.com/payments/v1/sessions'; // Klarna test API URL
        $this->klarnaUsername = env('KLARNA_USERNAME'); // Store in .env
        $this->klarnaPassword = env('KLARNA_PASSWORD'); // Store in .env
    }

    public function createPaymentSession(Request $request)
    {
        
        // Klarna API Request Data
        $klarnaData = [
            "acquiring_channel" => "ECOMMERCE",
            "intent" => "buy",
            "purchase_country" => "GB",
            "purchase_currency" => "GBP",
            "locale" => "en-GB",
            "order_amount" => 1,
            "order_tax_amount" => 0,
            "order_lines" => [
                [
                    "name" => "Test Product",
                    "quantity" => 1,
                    "unit_price" => 1,
                    "total_amount" => 1
                ]
            ],
        ];


        // Send API Request to Klarna
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode("{$this->klarnaUsername}:{$this->klarnaPassword}"),
            'Content-Type' => 'application/json'
        ])->post($this->klarnaApiUrl, $klarnaData);

        // Return Klarna API Response
        return response()->json($response->json(), $response->status());
    }
}
