<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\PropertyCategory;
use App\Models\Clinic;
use App\Models\Team;


use Mail;
use App\Mail\DataImportMail;
use App\Mail\DataStatusChangeMail;

use App\Services\SendGridService;


class LoginController extends Controller
{
    
    protected $sendGrid;
    
    public function __construct(SendGridService $sendGrid)
    {
        $this->sendGrid = $sendGrid;
        
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
    
    public function login(Request $request)
    {
        
        $menudata = $this->menudata;
        
        if ($request->isMethod('get')) {
            // If the customer is already logged in, redirect to the profile page
            if (Auth::guard('customer')->check()) {
                return redirect()->route('profile');
            }
    
            // Show the login page
            //return view('frontend.login');
            return view('frontend.login', compact('menudata'));
        }
        
        $otp = 1234;
        //$otp = rand(1000, 9999);
        
        $customer = Customer::where('email', $request->email)->first();
        
        if (!$customer) {
            // If the email doesn't exist, insert the record
            $customer = Customer::create([
                'email' => $request->email,
                'otp' => $otp,
            ]);
            
        }
        
        

        // Store OTP and mobile number in session
        session([
            'otp' => $otp,
            'email' => $request->email,
        ]);
        
        $email=$request->email;
        $clientData = [
                'name'    => 'User',
                'otp'    => $otp,
                'mobile'    => 'kundan',
                'status'    => 'kundan',
                'update_date'    => date("d M Y, H:i:s"),
                'action_by'    => 'kundan',
                
            ];
        //Mail::to($email)->send(new DataStatusChangeMail($clientData));
        $result = $this->sendGrid->sendOtpMail($email, $clientData);
        
        return redirect()->route('otp')->with('success', 'Enter OTP');
    }
    
    public function verify_otp(Request $request)
    {
        
        if($request->otp!=session('otp')){
            return redirect()->route('otp')->with('error', 'Incorrect OTP');
        }
        
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Attempt to authenticate the customer
        if (!Auth::guard('customer')->attempt($request->only('email', 'password'))) {
            // Redirect back with an error message if authentication fails
            return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
        
        $email = $request->email;

        $customer = Customer::where("email", $email)->orderByDesc('id')->first(); 
        $clientData = [
            'name'                => $customer->first_name,
            
        ];
        $result = $this->sendGrid->sendWelcomeMail($email, $clientData);
        
        //dd($customer->first_name);
        
        if($customer->first_name == ''){
            // Redirect to the complete account page on successful login
            return redirect()->route('complete-your-account')->with('success', 'You have logged in successfully.');
        }else{
        
            // Redirect to the profile page on successful login
            return redirect()->route('profile')->with('success', 'You have logged in successfully.');
        }
    }
    
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('login');
    }
    
    public function login2()
    {
        return view('frontend.login');
    }
    
    public function otp()
    {
        $menudata = $this->menudata;
        return view('frontend.otp', compact('menudata'));
    }
    
    
}
