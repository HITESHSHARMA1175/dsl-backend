<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Str;

use App\Models\PropertyCategory;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\KiBooking;
use App\Models\Clinic;
use App\Models\Team;

class ProfileController extends Controller
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
    
    public function profile()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        return view('frontend.profile', compact('menudata','categories','customer','addresses'));
    }
    
    public function complete_your_account()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        return view('frontend.complete-your-account', compact('menudata','categories','customer','addresses'));
    }
    
    public function my_account()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        return view('frontend.my-account', compact('menudata','categories','customer','addresses'));
    }
    
    public function booking()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        $orders = KiBooking::where('user_id', $customer->id)->get();
        return view('frontend.booking', compact('menudata','categories','customer','addresses','orders'));
    }
     
    public function course()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        $orders = KiBooking::where('user_id', $customer->id)->get();
        return view('frontend.course', compact('menudata','categories','customer','addresses','orders'));
    }
     
    public function order()
    {
        $menudata = $this->menudata;
        $customer = Auth::guard('customer')->user();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $addresses = CustomerAddress::where('user_id', $customer->id)->get();
        $orders = Order::where('user_id', $customer->id)->get();
        return view('frontend.order', compact('menudata','categories','customer','addresses','orders'));
    }
    
    
    public function updateProfile(Request $request)
    {
        
        $customer = Auth::guard('customer')->user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'mobile' => 'required|mobile|unique:customers,mobile,' . $customer->id,
        ]);
        /*if ($validator->fails()) {
            return response()->json(['status' => 'error', 'error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }*/
        
        
        $saveConsultationForm = Customer::find($customer->id);
        $saveConsultationForm->first_name = $request->first_name;
        $saveConsultationForm->last_name = $request->last_name;
        //$saveConsultationForm->email = $request->email;
        $saveConsultationForm->mobile = $request->mobile;
        $saveConsultationForm->dob = $request->dob;
        $saveConsultationForm->gender = $request->gender;
        
        $saveConsultationForm->save();
        
        if($saveConsultationForm){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
        
    }
     
    public function updateAddress(Request $request)
    {
        
        $customer = Auth::guard('customer')->user();
        
        if($request->address_id!=''){
            $saveCustomerAddress = CustomerAddress::find($request->address_id);
        }else{
            $saveCustomerAddress = new CustomerAddress();
        }
        $saveCustomerAddress->user_id = $customer->id;
        $saveCustomerAddress->address_type = $request->address_type;
        $saveCustomerAddress->country = $request->country;
        $saveCustomerAddress->state = $request->state;
        $saveCustomerAddress->city = $request->city;
        $saveCustomerAddress->address = $request->address;
        
        $saveCustomerAddress->save();
        
        if($saveCustomerAddress){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
        
    }
    
    
}
