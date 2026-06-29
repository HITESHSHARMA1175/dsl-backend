<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Classes\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Models\User; 
use App\Models\Customer; 
use Illuminate\Support\Facades\Auth;

class LoginControllerInApi extends Controller
{
    public function updateCustomerToken(Request $request)
    {
        try {
            if (empty($request->id) || empty($request->device_token)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Mobile no is required field.', 'data' => []]);
            }
            $rules = [
                'id' => 'required',
                'device_token' => 'required',
            ];
    
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first(), 'data' => []]);
            }
            
            $addCustomer = Customer::find($request->id);
            $addCustomer->device_token = $request->device_token;
            $addCustomer->save();
         
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Successfully updated.';
            return $result;
            
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
            //echo 'Caught exception: ',  $e->getMessage(), "\n".'Error on line no.: '.$e->getLine();
        }
    }

    public function customerLogin(Request $request)
    {
        try {
            if (empty($request->mobile)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Mobile no is required field.', 'data' => []]);
            }
            $rules = [
                'mobile' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first(), 'data' => []]);
            }
            $login_user = false;
            $user_type = '';


            if(!empty($request->mobile) && empty($request->userotp)){
                $user = Customer::select('id')->where('mobile', $request->mobile)->first();

                if(isset($user)){
                    $otp='1234';
                    $result['status'] = 200;
                    $result['message'] = 'Otp has been sent on your mobile number.';
                    $result['success'] = true;
                    $data['mobile'] = $request->mobile;
                    $data['otp'] = $otp;
                    $result['data'] = $data;
                    return $result;
                }else{
                    return response()->json(['status' => 200, 'success' => false, 'message' => 'This mobile no is not registerd. Please signup first.']);   
                }
                
            }elseif (!empty($request->mobile) && !empty($request->userotp)) {

                $user = Customer::select('id')->where('mobile', $request->mobile)->where('otp', $request->userotp)->first();

                if(isset($user)){
                    
                    $login_user = true;
                    $user_type = '';
                 
                    $user_detail = Customer::select('id', 'full_name', 'mobile')
                        ->where('id', $user->id)
                        ->first();
                    if (!empty($request->device_token) && !empty($user)) {
                        $save_device_token = Customer::where('id', $user->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    }
                    $success = $user_detail->createToken('remember_token')->plainTextToken;
                    $user->makeHidden(['password', 'remember_token', 'password_copy', 'email_verified_at']);
                    
                    $user_detail->token = !empty($success) ? $success : '';
                    $user_detail->profile = !empty($user_detail->profile) ? asset('uploads/userimage/') . '/' . $user_detail->profile : '';
                    
                    $data = $user_detail;
                    $result['status'] = 200;
                    $result['success'] = true;
                    $result['message'] = 'You Are Successfully Login..!';
                    $result['data'] = $data;
                    
                    return $result;

                }else{
                    return response()->json(['status' => 200, 'success' => false, 'message' => 'Please enter valid otp.']);
                }

                
            }else{
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Something wrong try Again.']);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
            //echo 'Caught exception: ',  $e->getMessage(), "\n".'Error on line no.: '.$e->getLine();
        }
    }

    public function userLogin(Request $request)
    {
        try {
            if (empty($request->username)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Username is required field.', 'data' => []]);
            }
            $rules = [
                'username' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first(), 'data' => []]);
            }
            $login_user = false;
            $user_type = '';


            if(!empty($request->username) && empty($request->password)){
                $user = User::select('id')->where('mobile_no', $request->mobile)->first();

                if(isset($user)){
                    $otp='1234';
                    $result['status'] = 200;
                    $result['message'] = 'Otp has been sent on your mobile number.';
                    $result['success'] = true;
                    $data['mobile'] = $request->mobile;
                    $data['otp'] = $otp;
                    $result['data'] = $data;
                    return $result;
                }else{
                    return response()->json(['status' => 200, 'success' => false, 'message' => 'This mobile no is not registerd. Please signup first.']);   
                }
                
            }elseif (!empty($request->username) && !empty($request->password)) {

                $user = User::select('id')->where('mobile_no', $request->username)->where('password_copy', $request->password)->first();

                if(isset($user)){
                    
                    $login_user = true;
                    $user_type = '';
                 
                    $user_detail = User::select('id', 'first_name', 'last_name', 'email', 'mobile_no', 'profile', 'gender', 'status', 'emp_type')
                        ->where('id', $user->id)
                        ->first();
                    if (!empty($request->device_token) && !empty($user)) {
                        $save_device_token = User::where('id', $user->id)->update(['device_token' => $request->device_token, 'device_type' => $request->device_type]);
                    }
                    $success = $user_detail->createToken('remember_token')->plainTextToken;
                    $user->makeHidden(['password', 'remember_token', 'password_copy', 'email_verified_at']);
                    
                    $user_detail->token = !empty($success) ? $success : '';
                    $user_detail->profile = !empty($user_detail->profile) ? asset('uploads/userimage/') . '/' . $user_detail->profile : '';
                    
                    $data = $user_detail;
                    $result['status'] = 200;
                    $result['success'] = true;
                    $result['message'] = 'You Are Successfully Login..!';
                    $result['data'] = $data;
                    
                    return $result;

                }else{
                    return response()->json(['status' => 200, 'success' => false, 'message' => 'Please enter valid otp.']);
                }

                
            }else{
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Something wrong try Again.']);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
            //echo 'Caught exception: ',  $e->getMessage(), "\n".'Error on line no.: '.$e->getLine();
        }
    }

    public function userRegister(Request $request)
    {
        try {
            if (empty($request->full_name) || empty($request->mobile)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Full name and Mobile no  is required field.', 'data' => []]);
            }
            $rules = [
                'full_name' => 'required',
                'mobile' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first(), 'data' => []]);
            }
            $register_user = false;
            $user_type = '';


            if(!empty($request->full_name) && !empty($request->mobile)){
                $user = User::select('id')->where('mobile_no', $request->mobile)->first();

                if(isset($user)){
                    return response()->json(['status' => 200, 'success' => false, 'message' => 'This Mobile no already exist.']);
                }else{

                    $addUser = new User();
                    $addUser->first_name = $request->full_name;
                    $addUser->mobile_no = $request->mobile;
                    
                    $addUser->save();
                    $register_user = true;
                    
                    $otp='1234';
                    
                    return response()->json(['status' => 200, 'mobile' => $request->mobile, 'otp' => $otp, 'success' => $register_user, 'message' => 'Otp has been sent on your mobile number.']);   
                }
                
            }else{
                return response()->json(['status' => 200, 'success' => false, 'message' => 'Something wrong try Again.']);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
            //echo 'Caught exception: ',  $e->getMessage(), "\n".'Error on line no.: '.$e->getLine();
        }
    }

    public function getProperty(Request $request)
    {
        
            return response()->json(['status' => 500, 'success' => false, 'message' => 'sdf']);
            //echo 'Caught exception: ',  $e->getMessage(), "\n".'Error on line no.: '.$e->getLine();
        
    }
}
