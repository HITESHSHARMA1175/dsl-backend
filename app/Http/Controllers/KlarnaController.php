<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


use App\Models\KiBooking;
use App\Models\CheckedService;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Clinic;
use App\Models\Team;

class KlarnaController extends Controller
{
    private $client;
    private $auth;
    private $apiUrl;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->auth = [
            config('services.klarna.username'),
            config('services.klarna.password')
        ];
        $this->apiUrl = config('services.klarna.base_url');
    }
    
    
    public function klarnaIntentCreate(Request $request)
    {  
        
        $billing = [
            "given_name" => $request->billing_first_name,
            "family_name" => $request->billing_last_name,
            "email" => $request->billing_email,
            "phone" => $request->billing_phone,
            "street_address" => $request->billing_address_1,
            "postal_code" => $request->billing_postcode,
            "city" => $request->billing_city,
            "country" => $request->billing_country ?? 'GB' // fallback to GB if not set
        ];
        
        $amount2 = $request->amount2*100;
    
        $response = $this->client->post("{$this->apiUrl}/payments/v1/sessions", [
            'auth' => $this->auth,
            'json' => [
                "acquiring_channel" => "ECOMMERCE",
                "intent" => "buy",
                "purchase_country" => "GB",
                "purchase_currency" => "GBP",
                "locale" => "en-GB",
                "order_amount" => $amount2, // Amount in cents (e.g., £10 = 1000)
                "order_tax_amount" => 0,
                "order_lines" => [
                    [
                        "name" => "Test Product",
                        "quantity" => 1,
                        "unit_price" => $amount2,
                        "total_amount" => $amount2,
                        "tax_rate" => 0,
                        "total_tax_amount" => 0,
                        "type" => "physical", // Required
                    ]
                ],
                "billing_address" => [
                    "given_name" => $request->billing_first_name,
                    "family_name" => $request->billing_last_name,
                    "email" => $request->billing_email,
                    "phone" => $request->billing_phone,
                    "street_address" => $request->billing_address_1,
                    "postal_code" => $request->billing_postcode,
                    "city" => $request->billing_city,
                    "country" => $request->billing_country ?? 'GB' // fallback to GB if not set
                ],
                "merchant_urls" => [
                    "authorization" => route('klarna.authorizeweb')
                ]
            ]
        ]);

        $klarnaSession = json_decode($response->getBody(), true);
        
        /*return response()->json([
            'status' => 'success',
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id'],
            'order_amount' => $amount2
        ]);*/
        
        /*return response()->json([
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id']
        ]);*/
        
        return view('klarna.checkoutweb', [
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id'],
            'order_amount' => $amount2,
            'billing' => $billing
        ]);
    }
    
    public function authorizePaymentweb(Request $request)
    {
        $sessionId = $request->input('session_id');
        $billing = $request->input('billing_address');

        $response = $this->client->post("{$this->apiUrl}/payments/v1/authorizations/{$sessionId}", [
            'auth' => $this->auth,
            'json' => [
                "billing_address" => $billing
            ]
        ]);

        $authResponse = json_decode($response->getBody(), true);

        if ($authResponse['approved'] ?? false) {
            return response()->json([
                'message' => 'Payment authorized',
                'authorization_token' => $authResponse['authorization_token']
            ]);
        }

        return response()->json([
            'message' => 'Payment authorization failed',
            'error' => $authResponse['error'] ?? 'Unknown error'
        ], 400);
    }
    
    public function createOrderWeb(Request $request)
    {
        try {
            $authorizationToken = $request->input('authorization_token');
            $order_amount = $request->input('order_amount');
    
            // Step 1: Create Klarna order
            $response = $this->client->post("{$this->apiUrl}/payments/v1/orders", [
                'auth' => $this->auth,
                'json' => [
                    "authorization_token" => $authorizationToken,
                    "order_amount" => $order_amount,
                    "order_tax_amount" => 0,
                    "order_lines" => [
                        [
                            "name" => "Test Product",
                            "quantity" => 1,
                            "unit_price" => 1,
                            "total_amount" => $order_amount
                        ]
                    ],
                    "merchant_reference1" => "Order_12345"
                ]
            ]);
    
            $orderResponse = json_decode($response->getBody(), true);
            $orderId = $orderResponse['order_id'] ?? null;
    
            // Step 2: Get Klarna order details (billing info)
            $klarnaOrderDetails = $this->client->get("{$this->apiUrl}/ordermanagement/v1/orders/{$orderId}", [
                'auth' => $this->auth,
            ]);
    
            $klarnaOrder = json_decode($klarnaOrderDetails->getBody(), true);
    
            // Extract billing info from Klarna
            $email = $klarnaOrder['customer']['email'] ?? null;
            $billing_email = $klarnaOrder['billing_address']['email'] ?? null;
            $billing_first_name = $klarnaOrder['billing_address']['given_name'] ?? null;
            $billing_last_name = $klarnaOrder['billing_address']['family_name'] ?? null;
            $billing_phone = $klarnaOrder['billing_address']['phone'] ?? null;
            $billing_city = $klarnaOrder['billing_address']['city'] ?? null;
            $billing_postcode = $klarnaOrder['billing_address']['postal_code'] ?? null;
            $billing_address_1 = $klarnaOrder['billing_address']['street_address'] ?? null;
            $billing_country = $klarnaOrder['billing_address']['country'] ?? null;
    
            // Step 3: Load product systems
            $productsystems = CheckedService::with('getCheckedAddon')
                ->where('system_id', session('uuid'))
                ->where('stype', 'product')
                ->get();
    
            if ($productsystems->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful!',
                    'paymentIntent' => 0,
                    'order_id' => $orderId
                ]);
            }
    
            // Step 4: Get or create customer
            $customer = Customer::where("email", $email)->orderByDesc('id')->first();
    
            if (!$customer) {
                $customer = new Customer();
                $customer->first_name = $billing_first_name;
                $customer->last_name = $billing_last_name;
                $customer->mobile = $billing_phone;
                $customer->email = $email;
                $customer->save();
            }
    
            // Step 5: Save Order
            $saveOrder = new Order();
            $saveOrder->user_id = $customer->id;
            $saveOrder->billing_first_name = $billing_first_name;
            $saveOrder->billing_last_name = $billing_last_name;
            $saveOrder->billing_phone = $billing_phone;
            $saveOrder->billing_email = $billing_email;
            $saveOrder->billing_company = null;
            $saveOrder->billing_country = $billing_country;
            $saveOrder->billing_address_1 = $billing_address_1;
            $saveOrder->billing_city = $billing_city;
            $saveOrder->billing_postcode = $billing_postcode;
            $saveOrder->order_amount = $order_amount;
            //$saveOrder->payment_method_id = null;
            $saveOrder->payment_method = 'klarna';
            $saveOrder->cart_details = $productsystems->toJson();
            $saveOrder->payment_method_id = $orderId;
            $saveOrder->save();
    
            // Step 6: Final response
            session()->forget('uuid');
    
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully via Klarna',
                'order_id' => $orderId,
                'local_order_id' => $saveOrder->id
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Step 1: Initiate a Klarna Payment Session and Return View
     */
    public function initiatePayment(Request $request)
    {  
        //dd($this->apiUrl);

        $amount2 = $request->amount2*100;
    
        $response = $this->client->post("{$this->apiUrl}/payments/v1/sessions", [
            'auth' => $this->auth,
            'json' => [
                "acquiring_channel" => "ECOMMERCE",
                "intent" => "buy",
                "purchase_country" => "GB",
                "purchase_currency" => "GBP",
                "locale" => "en-GB",
                "order_amount" => $amount2, // Amount in cents (e.g., £10 = 1000)
                "order_tax_amount" => 0,
                "order_lines" => [
                    [
                        "name" => "Test Product",
                        "quantity" => 1,
                        "unit_price" => $amount2,
                        "total_amount" => $amount2
                    ]
                ],
                "merchant_urls" => [
                    "authorization" => route('klarna.authorize')
                ]
            ]
        ]);

        $klarnaSession = json_decode($response->getBody(), true);
        
        /*return response()->json([
            'status' => 'success',
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id']
        ]);*/
        
        /*return response()->json([
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id']
        ]);*/
        
        return view('klarna.checkout', [
            'client_token' => $klarnaSession['client_token'],
            'session_id' => $klarnaSession['session_id'],
            'order_amount' => $amount2
        ]);
    }

    /**
     * Step 2: Handle Klarna Payment Authorization
     */
    public function authorizePayment(Request $request)
    {
        $sessionId = $request->input('session_id');

        $response = $this->client->post("{$this->apiUrl}/payments/v1/authorizations/{$sessionId}", [
            'auth' => $this->auth,
            'json' => [
                "billing_address" => [
                    "given_name" => "Alice",
                    "family_name" => "Test",
                    "email" => "customer@email.com",
                    "street_address" => "123 Test Street",
                    "postal_code" => "1000",
                    "city" => "London",
                    "country" => "GB"
                ]
            ]
        ]);

        $authResponse = json_decode($response->getBody(), true);

        if ($authResponse['approved'] ?? false) {
            return response()->json([
                'message' => 'Payment authorized',
                'authorization_token' => $authResponse['authorization_token']
            ]);
        }

        return response()->json([
            'message' => 'Payment authorization failed',
            'error' => $authResponse['error'] ?? 'Unknown error'
        ], 400);
    }

    /**
     * Step 3: Create an Order after Successful Authorization
     */
    public function createOrder(Request $request)
    {
        $authorizationToken = $request->input('authorization_token');
        $order_amount = $request->input('order_amount');
        
        $response = $this->client->post("{$this->apiUrl}/payments/v1/orders", [
            'auth' => $this->auth,
            'json' => [
                "authorization_token" => $authorizationToken,
                "order_amount" => $order_amount,
                "order_tax_amount" => 0,
                "order_lines" => [
                    [
                        "name" => "Test Product",
                        "quantity" => 1,
                        "unit_price" => 1,
                        "total_amount" => $order_amount
                    ]
                ],
                "merchant_reference1" => "Order_12345"
            ]
        ]);

        $orderResponse = json_decode($response->getBody(), true);

        return response()->json([
            'message' => 'Order created successfully',
            'order_id' => $orderResponse['order_id']
        ]);
    }
    
    public function success(Request $request)
    {
        $klarnaOrderId = $request->query('order_id');
        if (!$klarnaOrderId) {
            return response()->json([
                'success' => false,
                'message' => 'Missing Klarna order ID.'
            ], 400);
        }
    
        try {
            // Fetch Klarna Order Details
            $client = new Client();
            $response = $client->get("{$this->apiUrl}/ordermanagement/v1/orders/{$klarnaOrderId}", [
                'auth' => $this->auth,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
    
            $klarnaOrder = json_decode($response->getBody(), true);
    
            $email = $klarnaOrder['customer']['email'] ?? null;
            $firstName = $klarnaOrder['billing_address']['given_name'] ?? '';
            $lastName = $klarnaOrder['billing_address']['family_name'] ?? '';
            $mobile = $klarnaOrder['billing_address']['phone'] ?? '';
    
            // 👇 You can now proceed with the same logic to create `KiBooking`, using this Klarna info
            // (like you did in the Stripe version of the success route)
    
            // Example:
            $customer = Customer::where("email", $email)->first();
            if (!$customer) {
                $customer = new Customer();
                $customer->first_name = $firstName;
                $customer->last_name = $lastName;
                $customer->email = $email;
                $customer->mobile = $mobile;
                $customer->save();
            }
    
            $user_id = $customer->id;
    
            // Continue with your booking logic like:
            $systems = CheckedService::with('getCheckedService')
                ->where('system_id', session('uuid'))
                ->where('stype', 'service')
                ->pluck('sid');
    
            $ssessionsystems = CheckedService::where('system_id', session('uuid'))->where('stype', 'service')->pluck('ssession');
            $spricesystems = CheckedService::where('system_id', session('uuid'))->where('stype', 'service')->pluck('sprice');
            $addonsystems = CheckedService::where('system_id', session('uuid'))->where('stype', 'addon')->pluck('sid');
            $totalDuration = Property::whereIn('id', $systems)->sum('duration');
    
            $saveBooking = new KiBooking();
            $saveBooking->user_id = $user_id;
            $saveBooking->service_id = $systems;
            $saveBooking->ssessionsystems = $ssessionsystems;
            $saveBooking->spricesystems = $spricesystems;
            $saveBooking->addon_id = $addonsystems;
            $saveBooking->profession_id = session('professional_id');
            $saveBooking->total_service_duration = $totalDuration;
            $saveBooking->total_addon_duration = $request->total_addon_duration;
            $saveBooking->ddate = date("Y-m-d");
            $saveBooking->slot_id = session('slot_id');
            $saveBooking->slot_date = session('slot_date');
            $saveBooking->slot_time = session('slot_time'); 
            $saveBooking->first_name = $firstName;
            $saveBooking->last_name = $lastName;
            $saveBooking->email = $email;
            $saveBooking->mobile = $mobile;
            $saveBooking->payment_method_id = $klarnaOrderId;
            $saveBooking->payment_method = 'klarna';
            $saveBooking->payment_amount = $klarnaOrder['order_amount'] / 100;
            $saveBooking->is_web = '1';
            $saveBooking->save();
    
            session()->forget('uuid');
    
            $clinics = Clinic::where('id','!=', 0)->get();
            $menudata = $this->menudata;
    
            return view('frontend.klarna-booking-success', compact('menudata','clinics','saveBooking'));
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving Klarna order: ' . $e->getMessage()
            ], 500);
        }
    }
}
