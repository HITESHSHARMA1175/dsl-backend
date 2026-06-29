<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\InventoryCategory;
use App\Models\PropertyRoomInventory;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Tenant;
use App\Models\TenantMemberDetail;
use App\Models\MoveDetail;
use App\Models\MoveDetailRent;
use App\Models\UserLocation;

use Str;

use Exception;

class UserControllerInApi extends Controller
{
    public function myProfile()
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $userDet['id'] = $user->id ?? '';
                $userDet['full_name'] = $user->first_name ?? '';
                $userDet['mobile'] = $user->mobile_no ?? '';
                $userDet['email'] = $user->email ?? '';
                $userDet['profile'] = !empty($user->profile) ? asset('uploads/userimage') . '/' . $user->profile : '';
                $userDet['gender'] = $user->gender ?? '';
                $userDet['dob'] = $user->dob ?? '';
                
                $userDet['address'] = $user->address ?? '';
                $userDet['country'] = @$user->getEmpCountry->name ?? '';
                $userDet['state'] = @$user->getEmpState->name ?? '';
                $userDet['city'] = @$user->getEmpCity->name ?? '';
                $userDet['pincode'] = $user->pincode ?? '';
                
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'My Profile.';
                $result['data'] = $userDet;
            
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function kycDetails()
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $userDet['id'] = $user->id ?? '';
                $userDet['pan_number'] = $user->pan_number ?? '';
                $userDet['upload_pan'] = !empty($user->upload_pan) ? asset('uploads/userimage') . '/' . $user->upload_pan : '';
                $userDet['bank_name'] = $user->bank_name ?? '';
                $userDet['account_name'] = $user->account_name ?? '';
                $userDet['account_no'] = $user->account_no ?? '';
                $userDet['ifcs'] = $user->ifcs ?? '';
                $userDet['aadhar_number'] = $user->aadhar_number ?? '';
                $userDet['upload_aadhaar'] = !empty($user->upload_aadhaar) ? asset('uploads/userimage') . '/' . $user->upload_aadhaar : '';
                $userDet['profile_aadhar'] = !empty($user->profile_aadhar) ? asset('uploads/userimage') . '/' . $user->profile_aadhar : '';
                
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'KYC Details.';
                $result['data'] = $userDet;
            
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getBusinessName()
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $userDet['id'] = $user->id ?? '';
                $userDet['business_name'] = $user->business_name ?? '';
                $userDet['business_type'] = $user->business_type ?? '';
                $userDet['business_category'] = $user->business_category ?? '';
                $userDet['business_email'] = $user->business_email ?? '';
                
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'KYC Details.';
                $result['data'] = $userDet;
            
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function updateKyc(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $addUser = User::find($user->id);
                
                if ($request->type=='Pan Details') {
                    $addUser->pan_number = $request->pan_number;
                    if ($request->hasFile('upload_pan')) {
                        $file = $request->file('upload_pan');
                        $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/userimage'), $FileName);
                        $addUser->upload_pan = $FileName;
                    }
                }
                
                if ($request->type=='Bank Details') {
                    $addUser->bank_name = $request->bank_name;
                    $addUser->account_name = $request->account_name;
                    $addUser->account_no = $request->account_no;
                    $addUser->ifcs = $request->ifcs;
                }
                
                if ($request->type=='Selfie With Aadhar') {
                    $addUser->aadhar_number = $request->aadhar_number;
                    if ($request->hasFile('upload_aadhaar')) {
                        $file = $request->file('upload_aadhaar');
                        $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/userimage'), $FileName);
                        $addUser->upload_aadhaar = $FileName;
                    }
                    if ($request->hasFile('profile_aadhar')) {
                        $file = $request->file('profile_aadhar');
                        $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/userimage'), $FileName);
                        $addUser->profile_aadhar = $FileName;
                    }
                }
                
                $addUser->save();
             
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Successfully updated.';
                
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function updateBusinessName(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $addUser = User::find($user->id);
                
                $addUser->business_name = $request->business_name;
                $addUser->business_type = $request->business_type;
                $addUser->business_category = $request->business_category;
                $addUser->business_email = $request->business_email;
            
                $addUser->save();
             
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Successfully updated.';
                
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function updateUserAddress(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $addUser = User::find($user->id);
                
                $addUser->location_address = $request->location_address;
                $addUser->location_lat = $request->location_lat;
                $addUser->location_lng = $request->location_lng;
                $addUser->location_date = date("Y-m-d");
                $addUser->location_time = date("H:i:s");
                
                $addUser->save();
                
                $leadLocation = new UserLocation();
                $leadLocation->user_id = $addUser->id;
                $leadLocation->location_address = $request->location_address;
                $leadLocation->location_lat = $request->location_lat;
                $leadLocation->location_lng = $request->location_lng;
                $leadLocation->location_date = date("Y-m-d");
                $leadLocation->location_time = date("H:i:s");
                
                $leadLocation->save();
             
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Successfully updated.';
                
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $addUser = User::find($user->id);
                
                $addUser->first_name = $request->first_name;
                $addUser->last_name = $request->last_name;
                if (!empty($request->mobile)) {
                    $addUser->mobile_no = $request->mobile;
                }
                
                if (!empty($request->email)) {
                    $addUser->email = $request->email;
                }
                
                if ($request->hasFile('profile')) {
                    $file = $request->file('profile');
                    $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                    $path = $file->move(public_path('uploads/userimage'), $FileName);
                    $addUser->profile = $FileName;
                }
                
                $addUser->save();
             
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Successfully updated.';
                
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    
    
    public function myPayment(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                if($request->page){
                    $page_id=$request->page;
                }else{
                    $page_id=1;
                }
                
                if($request->type=='Pending'){
                    $type_id='Pending';
                }else{
                    $type_id='Paid';
                }
                
                $rents = MoveDetailRent::where('id', '!=', '')
                    ->where('tenant_id', $user->id)
                    ->where('status', $type_id)
                    ->orderByDesc('id')
                    ->paginate(10, ['*'], 'page', $page_id);
                    
                
                $rentCount = MoveDetailRent::where('id', '!=', '')
                    ->where('tenant_id', $user->id)
                    ->where('status', $type_id)
                    ->count();
                
                $rentList = $rents->map(function ($rent) {
                    
                    $property = Property::where('id', $rent->property_id)->first(); 
                    $movedetails = MoveDetail::where('id', $rent->move_in_id)->first(); 
                    
                    $propertyimages = $property->getPropertyImages;
                    foreach ($propertyimages as $item)
                    {
                        $property_image = asset('uploads/property') . '/' . $item->image;
                    }
                    
                    return [
                        'id' => $rent->id ?? '',
                        'amount' => $rent->this_month ?? '',
                        'month' => $rent->month_a ?? '',
                        'day' => $movedetails->rent_payment_date ?? '',
                        'status' => $rent->status ?? '',
                        'property_name' => $property->property_name ?? '',
                        'property_image' => $property_image ?? '',
                        'country' => @$property->getPropertyCountry->name ?? '',
                        'state' => @$property->getPropertyState->name ?? '',
                        'city' => @$property->getPropertyCity->name ?? '',
                        'pincode' => $property->pincode ?? '',
                        'area' => $property->area ?? '',
                        'street' => $property->street ?? '',
                    ];
                });
                
                $property=   $properties = Property::where('id', $request->property_id)->first();
             
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'My Payment.';
                $result['count'] = $rentCount;
                $result['data'] = $rentList;
            
            }else{
            
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    
    
    


}
