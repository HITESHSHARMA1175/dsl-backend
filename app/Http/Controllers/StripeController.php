<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;

use App\Models\KiBooking;
use App\Models\CheckedService;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Property;

class StripeController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function stripecheckout()
    {
        return view('stripe.checkout');
    }

    public function processPayment(Request $request)
    {
       
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
        
        
         
        
        // stripe service code
        $response = $this->stripeService->processPayment($request->amount, $request->payment_method_id);
        
        $query = Customer::query();
        $query->where("email","=",$request->billing_email);
        $customer = $query->orderByDesc('id')->first();
        
        if($customer){
            
            $user_id = $customer->id;
            
        }else{
           
            $saveCustomer = new Customer();
            $saveCustomer->first_name = $request->billing_first_name;
            $saveCustomer->last_name = $request->billing_last_name;
            $saveCustomer->mobile = $request->billing_phone;
            $saveCustomer->email = $request->billing_email;
            
            $saveCustomer->save();
            
            $user_id = $saveCustomer->id;
            
        }
       
        
        $saveOrder = new Order();
        $saveOrder->user_id = $user_id;
        $saveOrder->billing_first_name = $request->billing_first_name;
        $saveOrder->billing_last_name = $request->billing_last_name;
        $saveOrder->billing_phone = $request->billing_phone;
        $saveOrder->billing_email = $request->billing_email;
        $saveOrder->billing_company = $request->billing_company;
        $saveOrder->billing_country = $request->billing_country;
        $saveOrder->billing_address_1 = $request->billing_address_1;
        $saveOrder->billing_city = $request->billing_city;
        $saveOrder->billing_postcode = $request->billing_postcode;
        $saveOrder->order_amount = $request->order_amount;
        $saveOrder->payment_method_id = $request->payment_method_id;
        $saveOrder->payment_method = $request->payment_method;
        $saveOrder->cart_details = $productsystems->toJson();
        
        $saveOrder->save();
        
        $data=[
                'order_id'=>$saveOrder->id,
            ];
        
       
        if ($response['success']) {
            session()->forget('uuid');
            return response()->json($response);
        } else {
            return response()->json(['error' => $response['error']], 500);
        }
    }
    
    
    public function bookingProcessPayment(Request $request)
    {
       
        $systems = CheckedService::where('stype', 'service')->where('system_id', session('uuid'))->get();
        if ($systems->isEmpty()) {
            return [
                'success' => true,
                'message' => 'Payment successful!',
                'paymentIntent' => 0
            ];
        }
        
        // stripe service code
        $response = $this->stripeService->processPayment($request->amount, $request->payment_method_id);
        
        $query = Customer::query();
        $query->where("email","=",$request->email);
        $customer = $query->orderByDesc('id')->first();
        
        if($customer){
            
            $user_id = $customer->id;
            
        }else{
           
            $saveCustomer = new Customer();
            $saveCustomer->first_name = $request->first_name;
            $saveCustomer->last_name = $request->last_name;
            $saveCustomer->mobile = $request->mobile;
            $saveCustomer->email = $request->email;
            
            $saveCustomer->save();
            
            $user_id = $saveCustomer->id;
            
        }
       
        
        $systems = CheckedService::with('getCheckedService') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'service')
            ->pluck('sid');
            
        $totalDuration = Property::whereIn('id', $systems)->sum('duration');
            
        $addonsystems = CheckedService::with('getCheckedAddon') // Assuming the relationship is correctly defined
            ->where('system_id', session('uuid'))
            ->where('stype', 'addon')
            ->pluck('sid');
        
        $saveBooking = new KiBooking();
        $saveBooking->user_id = $user_id;
        $saveBooking->service_id = $systems;
        $saveBooking->addon_id = $addonsystems;
        $saveBooking->profession_id = session('professional_id');
        $saveBooking->total_service_duration = $totalDuration;
        $saveBooking->total_addon_duration = $request->total_addon_duration;
        $saveBooking->ddate = $request->date;
        $saveBooking->slot_id = session('slot_id');
        $saveBooking->slot_date = session('slot_date');
        $saveBooking->slot_time = session('slot_time'); 
        $saveBooking->first_name = $request->first_name;
        $saveBooking->last_name = $request->last_name;
        $saveBooking->email = $request->email;
        $saveBooking->mobile = $request->mobile;
        $saveBooking->payment_method_id = $request->payment_method_id;
        $saveBooking->payment_method = $request->payment_method;
        
        $saveBooking->save();
        
        $data=[
                'booking_id'=>$saveBooking->id,
            ];
        
       
        if ($response['success']) {
            session()->forget('uuid');
            return response()->json($response);
        } else {
            return response()->json(['error' => $response['error']], 500);
        }
    }
    
}
