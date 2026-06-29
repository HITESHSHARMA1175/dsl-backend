<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;
use Stripe\Event;
use Stripe\PaymentIntent;

use App\Models\KiBooking;
use App\Models\CheckedService;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\Clinic;
use App\Models\Team;

use Mail;
use App\Mail\KiBookingMail;
use App\Mail\OrderMail;

class StripePaymentController extends Controller
{
    
    
    public function __construct()
    {
        
        // Define category mappings
        $categoriesMap = [
            'categories' => ['parent_id', 0],
            'hair_restoration' => ['main_category', 22],
            'laser_hair_removal' => ['main_category', 3],
            'tattoo_removal' => ['main_category', 23],
            'tattoo_removal_machine' => ['main_category', 24],
            'semi_tattoo_removal_machine' => ['main_category', 25],
            'skin_treatments' => ['main_category', 26],
            'skin_treatments_machine' => ['main_category', 27],
            'ipl_treatments' => ['main_category', 28],
            'skin_combination_packages' => ['main_category', 29],
            'body_treatments' => ['main_category', 30],
            'body_treatments_machines' => ['main_category', 31],
            'body_treatments_area' => ['main_category', 32],
            'body_combination_packages' => ['main_category', 33],
            'medical' => ['main_category', 34],
            'injectables' => ['main_category', 35],
            'medical_team' => ['main_category', 36],
            'dermatology' => ['main_category', 21],
            
            'body_sculpting' => ['main_category', 19],
            'medical_injectables' => ['main_category', 20],
        ];

        // Fetch categories dynamically  
        foreach ($categoriesMap as $key => [$column, $value]) {
            $this->menudata[$key] = PropertyCategory::where($column, $value)->where('status', '1')->get();
        }
        $this->menudata['conditions'] = PropertyCategory::where('is_condition', '1')->where('is_top', '1')->where('status', '1')->orderBy('sorting_order','asc')->get();
        $this->menudata['clinics'] = Clinic::where('id','!=', 0)->get();
        $this->menudata['medical_teams'] = Team::where('id','!=', 0)->where('status','1')->get();
    }
    
    
    public function createPaymentLink(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Create a Stripe Checkout Session
            $session = Session::create([
                'payment_method_types' => ['card', 'paypal', 'klarna'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Total Amount',
                        ],
                        'unit_amount' => $request->amount * 100, // Convert amount to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/payment-cancel'),

            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $session->url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating payment link: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $saveBooking='';
        //$saveBooking = KiBooking::find(201);
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            $clinics = Clinic::where('id','!=', 0)->get();
            $menudata = $this->menudata;
            return view('frontend.booking-success', compact('menudata','clinics','saveBooking'));
        }
        
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($request->session_id);
            //print_r($session->customer_details);
            //print_r($session->customer_details);
            /*return response()->json([
                'success' => true,
                'transaction_id' => $session->payment_intent,
                'customer_email' => $session->customer_details->email ?? null,
                'amount' => $session->amount_total / 100,
                'currency' => $session->currency,
                'status' => $session->payment_status,
            ]);*/
            
            
            
            $query = Customer::query();
            $query->where("email","=",$session->customer_details->email);
            $customer = $query->orderByDesc('id')->first();
            
            if($customer){
                
                $user_id = $customer->id;
                
            }else{
               
                $saveCustomer = new Customer();
                $saveCustomer->first_name = $request->first_name;
                $saveCustomer->last_name = $request->last_name;
                $saveCustomer->mobile = $request->mobile;
                $saveCustomer->email = $session->customer_details->email;
                
                $saveCustomer->save();
                
                $user_id = $saveCustomer->id;
                
            }
            
            $systems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->pluck('sid');
            
            $ssessionsystems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->pluck('ssession');
            
            $spricesystems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->pluck('sprice');
                
            $totalDuration = Property::whereIn('id', $systems)->sum('duration');
                
            $addonsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
                ->where('system_id', session('uuid'))
                ->where('stype', 'addon')
                ->pluck('sid');
                
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
            $saveBooking->first_name = $request->first_name;
            $saveBooking->last_name = $request->last_name;
            $saveBooking->email = $session->customer_details->email;
            $saveBooking->mobile = $request->mobile;
            $saveBooking->payment_method_id = $session->payment_intent;
            $saveBooking->payment_method = 'stripe';
            $saveBooking->payment_amount = $session->amount_total / 100;
            $saveBooking->is_web = '1';
            
            $saveBooking->save();
            
            $email=$session->customer_details->email;
            //$email='akundan55@gmail.com';
            if($email!=''){
            $clientData = [
                    'name'    => $firstName,
                    'bookingid'    => $saveBooking->id,
                    'amount'    => $session->amount_total / 100,
                    'date'    => date("d M Y"),
                    'time'    => date("H:i:s"),
                    
                ];
            Mail::to($email)->send(new KiBookingMail($clientData));
            }
            
            session()->forget('uuid');
            
            $clinics = Clinic::where('id','!=', 0)->get();
            $menudata = $this->menudata;
            return view('frontend.booking-success', compact('menudata','clinics','saveBooking'));
            
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving payment details: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function cancel()
    {
        return response()->json([
            'success' => false,
            'message' => 'Payment was cancelled',
        ]);
    }
    
    public function stripePayment()
    {
        return view('stripe.payment');
    }
    
    public function handleWebhook(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $event = Event::constructFrom($request->all());
    
            if ($event->type === 'checkout.session.completed') {
                $session = $event->data->object;
    
                // Store transaction details in database here
            }
    
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function createPaymentLinkShop(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $fullName = $request->billing_first_name . ' ' . $request->billing_last_name;
    
            $session = Session::create([
                'payment_method_types' => ['card', 'paypal', 'klarna'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => 'Total Amount',
                        ],
                        'unit_amount' => $request->amount * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $request->billing_email,
                'customer_creation' => 'always',
    
                'payment_intent_data' => [
                    'metadata' => [
                        'name' => $fullName,
                        'phone' => $request->billing_phone,
                        'company' => $request->billing_company,
                    ],
                    'shipping' => [
                        'name' => $fullName,
                        'address' => [
                            'line1' => $request->billing_address_1,
                            'city' => $request->billing_city,
                            'postal_code' => $request->billing_postcode,
                            'country' => $request->billing_country,
                        ],
                        'phone' => $request->billing_phone,
                    ],
                ],
    
                'success_url' => url('/payment-success-shop?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/payment-cancel'),
            ]);
    
            return response()->json([
                'success' => true,
                'payment_url' => $session->url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating payment link: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function successshop(Request $request)
    {
        $saveBooking='';
        //$saveBooking = KiBooking::find(201);
        $productsystems = CheckedService::with('getCheckedAddon')->where('system_id', session('uuid'))->where('stype', 'product')->get();
        if ($productsystems->isEmpty()) {
            $menudata = $this->menudata;
            $categories = PropertyCategory::where('parent_id', 0)->get();
            return view('frontend.order-success', compact('menudata','categories'));
        }
        
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($request->session_id);
            $paymentintent = PaymentIntent::retrieve($session->payment_intent);
            
            $nameParts = explode(' ', $paymentintent->metadata->name);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
            
            $productsystems = CheckedService::with('getCheckedAddon') 
                    ->where('system_id', session('uuid'))
                    ->where('stype', 'product')
                    ->get();
            if ($productsystems->isEmpty()) {
                return [
                    'success' => true,
                    'message' => 'Payment successful!',
                    'paymentIntent' => 0
                ];
            }
            
            
            
            $query = Customer::query();
            $query->where("email","=",$session->customer_details->email);
            $customer = $query->orderByDesc('id')->first();
            
            if($customer){
                
                $user_id = $customer->id;
                
            }else{
               
                $saveCustomer = new Customer();
                $saveCustomer->first_name = $firstName;
                $saveCustomer->last_name = $lastName;
                $saveCustomer->mobile = $paymentintent->metadata->phone;
                $saveCustomer->email = $session->customer_details->email;
                
                $saveCustomer->save();
                
                $user_id = $saveCustomer->id;
                
            }
            
            $saveOrder = new Order();
            $saveOrder->user_id = $user_id;
            $saveOrder->billing_first_name = $firstName;
            $saveOrder->billing_last_name = $lastName;
            $saveOrder->billing_phone = $paymentintent->metadata->phone;
            $saveOrder->billing_email = $session->customer_details->email;
            $saveOrder->billing_company = $paymentintent->metadata->company;
            $saveOrder->billing_country = $paymentintent->shipping->address->country;
            $saveOrder->billing_address_1 = $paymentintent->shipping->address->line1;
            $saveOrder->billing_city = $paymentintent->shipping->address->city;
            $saveOrder->billing_postcode = $paymentintent->shipping->address->postal_code;
            $saveOrder->order_amount = $session->amount_total / 100;
            $saveOrder->payment_method_id = $session->payment_intent;
            $saveOrder->payment_method = 'stripe';
            $saveOrder->cart_details = $productsystems->toJson();
            
            $saveOrder->save();
                
            $email=$session->customer_details->email;
            //$email='akundan55@gmail.com';
            if($email!=''){
            $clientData = [
                    'name'    => $firstName,
                    'orderid'    => $saveOrder->id,
                    'amount'    => $session->amount_total / 100,
                    'date'    => date("d M Y"),
                    'time'    => date("H:i:s"),
                    
                ];
            Mail::to($email)->send(new OrderMail($clientData));
            }
            
            session()->forget('uuid');
            
            $menudata = $this->menudata;
            $categories = PropertyCategory::where('parent_id', 0)->get();
            return view('frontend.order-success', compact('menudata','categories'));
            
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving payment details: ' . $e->getMessage(),
            ], 500);
        }
    }
    

    function mailCheck() {
        $toEmail = "jenishghadiya43@gmail.com";
        try {
        Mail::html("
    <h2>Hello </h2>
    <p>Thanks for registering on our platform!</p>
", function ($message) {
    $message->to("jenishghadiya43@gmail.com")
            ->subject('Welcome to Our Platform')
            ->from("hello@dimondskin.com", "MyAwesomeApp");
});

     
    
        // ✅ Redirect or respond
        return response()->json(['status' => 'success', 'message' => 'Email sent.']);
    } catch (\Exception $e) {
        Log::error('Mail sending failed: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Failed to send email.']);
    }
    }
    
}
