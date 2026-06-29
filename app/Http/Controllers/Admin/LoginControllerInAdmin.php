<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\User;

use Mail;
use App\Mail\ForgotPasswordMail;

class LoginControllerInAdmin extends Controller
{
    function submitlogin(Request $request)
    {
        if ($request->isMethod('get')) {
            if (isset(auth()->user()->id)) {
                return redirect(route('dashboard'));
            } else {
                return view('admin.login');
            }
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => Constants::FAILED_STATUS, 'error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }
        $request->all();
        $ldate = date('d F Y, h:i:s A');
        session()->get('login');
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['status' => Constants::FAILED_STATUS, 'message' => 'Please enter correct Login Credentials.'], 422);
            }
            // return back()->withErrors('Please enter correct Login Credentials.');
        } catch (\Exception $e) {
            return response()->json(['status' => Constants::FAILED_STATUS, 'message' => 'Either something went wrong or invalid access!'], 422);
            // return back()->withErrors(["custom_name" => "Either something went wrong or invalid access!"]);
        }
        return response()->json(['status' => 'success', 'data' => auth()->user(), 'url' => session()->get('previous_url')]);
    }

    function forgotpassword(Request $request)
    {
        if ($request->isMethod('get')) {
            if (isset(auth()->user()->id)) {
                return redirect(route('dashboard'));
            } else {
                return view('admin.forgot-password');
            }
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => Constants::FAILED_STATUS, 'error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }
        $request->all();
        $ldate = date('d F Y, h:i:s A');
        session()->get('login');
        $request->validate([
            'email' => 'required',
        ]);
        
        $user_detail = User::where('email', $request->email)->first();

        try {
            
            if (!$user_detail) {
                return response()->json(['status' => Constants::FAILED_STATUS, 'message' => 'Please enter correct email id.'], 422);
            }
            // return back()->withErrors('Please enter correct Login Credentials.');
        } catch (\Exception $e) {
            return response()->json(['status' => Constants::FAILED_STATUS, 'message' => 'Either something went wrong or invalid access!'], 422);
            // return back()->withErrors(["custom_name" => "Either something went wrong or invalid access!"]);
        }
        
        if ($user_detail) {
           
            $importData = [
                'loginPass'    => $user_detail->password_copy,
                'userName'    => $user_detail->first_name.' '.$user_detail->last_name,
                
            ];
            
            $email=$request->email;
            //$email='akundan55@gmail.com';
            Mail::to($email)->send(new ForgotPasswordMail($importData));
        }
        return response()->json(['status' => 'success', 'message' => 'Your password has been sent on your email.', 'data' => auth()->user(), 'url' => session()->get('previous_url')]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/admin');
    }
}
