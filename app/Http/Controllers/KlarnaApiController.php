<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KlarnaService;
use App\Services\SendGridService;

use App\Models\PropertyCategory;
use App\Models\Clinic;
use App\Models\CheckedService;
use App\Models\Customer;
use App\Models\Order;
use App\Models\KiBooking;
use App\Models\Property;
use App\Models\Team;

use Mail;
use App\Mail\KiBookingMail;
use App\Mail\OrderMail;

class KlarnaApiController extends Controller
{
    protected $klarna;

    public function __construct(KlarnaService $klarna, SendGridService $sendGrid)
    {
        $this->klarna = $klarna;
        $this->sendGrid = $sendGrid;
        
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

    public function createSession(Request $request)
    {
        $payload = $request->validate([
            'purchase_country' => 'required|string',
            'purchase_currency' => 'required|string',
            'order_amount' => 'required|integer',
            'order_lines' => 'required|array',
            'locale' => 'nullable|string',
            'order_tax_amount' => 'nullable|integer',
            'merchant_urls' => 'required|array',
        ]);
        
        //return $payload;

        return response()->json($this->klarna->createSession($payload));
    }

    public function createOrder(Request $request, $token)
    {
        $payload = $request->validate([
            'purchase_country' => 'required|string',
            'purchase_currency' => 'required|string',
            'order_amount' => 'required|integer',
            'order_tax_amount' => 'nullable|integer',
            'order_lines' => 'required|array',
            'merchant_reference1' => 'nullable|string',
        ]);

        return response()->json($this->klarna->createOrder($token, $payload));
    }

    public function cancelAuth($token)
    {
        return response()->json([
            'status' => $this->klarna->cancelAuthorization($token)
        ]);
    }

    public function getSession($sessionId)
    {
        return response()->json($this->klarna->getSession($sessionId));
    }
    
    public function orderSuccess($orderId)
    {
        
        
        $orderDetails = $this->klarna->getOrder($orderId);
        $billingAddress = $orderDetails['billing_address'] ?? null;
      
        if (isset($orderDetails['error'])) {
            return response()->json(['error' => $orderDetails['error']], 400);
        }
        
        
        $order_amount = $orderDetails['order_amount']/100 ?? null;
        $email = $orderDetails['customer']['email'] ?? null;
        $billing_email = $orderDetails['billing_address']['email'] ?? null;
        $billing_first_name = $orderDetails['billing_address']['given_name'] ?? null;
        $billing_last_name = $orderDetails['billing_address']['family_name'] ?? null;
        $billing_phone = $orderDetails['billing_address']['phone'] ?? null;
        $billing_city = $orderDetails['billing_address']['city'] ?? null;
        $billing_postcode = $orderDetails['billing_address']['postal_code'] ?? null;
        $billing_address_1 = $orderDetails['billing_address']['street_address'] ?? null;
        $billing_country = $orderDetails['billing_address']['country'] ?? null;

        // Step 3: Load product systems
        $productsystems = CheckedService::with('getCheckedAddon')
            ->where('system_id', session('uuid'))
            ->where('stype', 'product')
            ->get();

        if ($productsystems->isEmpty()) {
            $menudata = $this->menudata;
            $categories = PropertyCategory::where('parent_id', 0)->get();
            return view('frontend.order-success', compact('menudata','categories'));
        }

        // Step 4: Get or create customer
        if($email!=''){
            $customer = Customer::where("email", $email)->orderByDesc('id')->first();
        }else{
            $customer = Customer::where("email", $billing_email)->orderByDesc('id')->first();
        }
        

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
        
        $email=$customer->email;
        //$email='akundan55@gmail.com';
        if($email!=''){
            $clientData = [
                'name'                => $saveOrder->billing_first_name.' '.$saveOrder->billing_last_name,
                'order_id'            => $saveOrder->id,
                'order_date'          => date('d M Y, H:i:s', strtotime($saveOrder->created_at)),
                'payment_method'      => 'Klarna',
                'payment_status'      => 'Paid',
                'est_delivery_date'   => '22 Oct 2025',
                'order_status'        => 'Processing',
                'status'              => 'Active',
                'update_date'         => now()->format("d M Y, H:i:s"),
                'action_by'           => 'Admin',
            
                // Item details
                'cart_details'        => $saveOrder->cart_details,
                'order_total'        => $saveOrder->order_amount,
                
                // Billing details
                'billing_first_name'  => $saveOrder->billing_first_name,
                'billing_last_name'   => $saveOrder->billing_last_name,
                'billing_company'     => $saveOrder->billing_company,
                'billing_country'     => $saveOrder->billing_country,
                'billing_phone'       => $saveOrder->billing_phone,
                'billing_email'       => $saveOrder->billing_email,
                'billing_address_1'   => $saveOrder->billing_address_1,
                'billing_city'        => $saveOrder->billing_city,
                'billing_postcode'    => $saveOrder->billing_postcode,
            ];
    
    
            $result = $this->sendGrid->sendOrderMail($email, $clientData);
        }

        // Step 6: Final response
        session()->forget('uuid');
        

        //return response()->json($orderDetails);
        
        $menudata = $this->menudata;
        $categories = PropertyCategory::where('parent_id', 0)->get();
        return view('frontend.order-success', compact('menudata','categories'));
    }
    
    public function bookingSuccess($orderId)
    {
        
        
        $orderDetails = $this->klarna->getOrder($orderId);
        $billingAddress = $orderDetails['billing_address'] ?? null;
      
        if (isset($orderDetails['error'])) {
            return response()->json(['error' => $orderDetails['error']], 400);
        }
        
        
        $order_amount = $orderDetails['order_amount']/100 ?? null;
        $email = $orderDetails['customer']['email'] ?? null;
        $billing_email = $orderDetails['billing_address']['email'] ?? null;
        $billing_first_name = $orderDetails['billing_address']['given_name'] ?? null;
        $billing_last_name = $orderDetails['billing_address']['family_name'] ?? null;
        $billing_phone = $orderDetails['billing_address']['phone'] ?? null;
        $billing_city = $orderDetails['billing_address']['city'] ?? null;
        $billing_postcode = $orderDetails['billing_address']['postal_code'] ?? null;
        $billing_address_1 = $orderDetails['billing_address']['street_address'] ?? null;
        $billing_country = $orderDetails['billing_address']['country'] ?? null;

        // Step 3: Load product systems
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
            
        $productsystems = CheckedService::with('getCheckedService')
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->get();

        if ($productsystems->isEmpty()) {
            $saveBooking='';
            $menudata = $this->menudata;
            $categories = PropertyCategory::where('parent_id', 0)->get();
            return view('frontend.booking-success', compact('menudata','categories','saveBooking'));
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
        $saveBooking = new KiBooking();
        $saveBooking->user_id = $customer->id;
        $saveBooking->service_id = $systems;
        $saveBooking->ssessionsystems = $ssessionsystems;
        $saveBooking->spricesystems = $spricesystems;
        $saveBooking->addon_id = $addonsystems;
        $saveBooking->profession_id = session('professional_id');
        $saveBooking->total_service_duration = $totalDuration;
        
        $saveBooking->ddate = date("Y-m-d");
        $saveBooking->slot_id = session('slot_id');
        $saveBooking->slot_date = session('slot_date');
        $saveBooking->slot_time = session('slot_time'); 
        $saveBooking->first_name = $billing_first_name;
        $saveBooking->last_name = $billing_last_name;
        $saveBooking->email = $email;
        $saveBooking->mobile = $billing_phone;
        $saveBooking->payment_method = 'klarna';
        $saveBooking->cart_details = $productsystems->toJson();
        $saveBooking->payment_method_id = $orderId;
        $saveBooking->is_web = '1';
        
        $saveBooking->save();
        
        $email=$session->customer_details->email;
        //$email='akundan55@gmail.com';
        if($email!=''){
            $saveKiBooking = KiBooking::where("id", '217')->orderByDesc('id')->first();
            if($saveKiBooking->clinic_id != ''){
                $getClinic = Clinic::where("id", $saveKiBooking->clinic_id)->orderByDesc('id')->first(); 
                $clinic_name = $getClinic->clinic_name ? $getClinic->clinic_name : '';
                $clinic_address = $getClinic->address ? $getClinic->address : '';
            }else{
                $clinic_name = '';
                $clinic_address = '';
            }
            
            $service_name = '';
            foreach (@$saveKiBooking->getKiBookinService() as $items){
                $service_name .= $items->property_name.', ';
            }
    
                $clientData = [
                    'name'                => $saveKiBooking->first_name.' '.$saveKiBooking->last_name,
                    'booking_id'          => $saveKiBooking->id,
                    'booking_date'        => date('d M Y, H:i:s', strtotime($saveKiBooking->created_at)),
                    'payment_method'      => $saveKiBooking->payment_method,
                    'payment_status'      => 'Paid',
                    'est_delivery_date'   => '22 Oct 2025',
                    'order_status'        => 'Processing',
                    'status'              => 'Active',
                    'update_date'         => now()->format("d M Y, H:i:s"),
                    'action_by'           => 'Admin',
                
                    // Item details
                    'service_name'        => $service_name,
                    'cart_details'        => $saveKiBooking->cart_details,
                    'payment_amount'      => $saveKiBooking->payment_amount,
                    
                    // Billing details
                    'total_service_duration'  => $saveKiBooking->total_service_duration,
                    'slot_date'  => $saveKiBooking->slot_date ? $saveKiBooking->slot_date : $saveKiBooking->selected_date,
                    'slot_time'  => $saveKiBooking->slot_time ? $saveKiBooking->slot_time : $saveKiBooking->selected_time,
                    
                    'clinic_name'  => $clinic_name,
                    'clinic_address'  => $clinic_address,
                    
                ];
    
    
            $result = $this->sendGrid->sendBookingMail($email, $clientData);
        }

        // Step 6: Final response
        session()->forget('uuid');
        

        //return response()->json($orderDetails);
        
        $menudata = $this->menudata;
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $clinics = Clinic::where('id','!=', 0)->get();
        return view('frontend.booking-success', compact('menudata','clinics','saveBooking'));
    }
}
