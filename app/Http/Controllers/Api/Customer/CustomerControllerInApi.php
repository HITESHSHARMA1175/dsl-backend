<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Customer;
use App\Models\CustomerEmi;


use Carbon\Carbon;

class CustomerControllerInApi extends Controller
{
    public function emiList(Request $request)
    {
        try {
            $user = auth()->user();

            $customers = Customer::where('id','!=','')->get();
            $customer_data = $customers->map(function ($customer) {
                
               
                return [
                    'id' => $customer->id ?? '',
                    'name' => $customer->full_name ?? '',
                    'image' => 'https://admin.dsl.co.in/assets/img/Logo_SH_Grey.png',
                    'comment' => 'Ask customer to reciept',
                    'received_amount' => 0,
                    'total_amount' => 90257,
                    'status' => 'Pending',
                    
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Emi List.';
            $result['data'] = $customer_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }

    public function buyerList(Request $request)
    {
        try {
            $user = auth()->user();

            $customers = Customer::where('id','!=','')->get();
            $customer_data = $customers->map(function ($customer) {
                
               
                return [
                    'id' => $customer->id ?? '',
                    'name' => $customer->full_name ?? '',
                    'image' => 'https://admin.dsl.co.in/assets/img/Logo_SH_Grey.png',
                    'comment' => 'Ask customer to reciept',
                    'received_amount' => 0,
                    'total_amount' => 90257,
                    'status' => 'Pending',
                    
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'buyer List.';
            $result['data'] = $customer_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function customerEmi(Request $request)
    {
        try {
            $user = auth()->user();

            $customers = Customer::where('id',$request->id)->first();
            $customer_data['id']=$customers->id;
            $customer_data['device_token']=$customers->device_token;
            $customer_data['total_amount']=$customers->total_amount;
            $customer_data['mobile']=$customers->mobile;
            $customer_data['full_name']=$customers->full_name;
            $customer_data['collected_amount']=$customers->collected_amount;
            $customer_data['pending_amount']=$customers->pending_amount;
            
            $emis = CustomerEmi::where('customer_id',$customers->id)->get();
            $emi_data = $emis->map(function ($emi) {
                
                return [
                    'id' => $emi->id ?? '',
                    'emi_amount' => $emi->emi_amount ?? '',
                    'emi_start_date' => $emi->emi_start_date ?? '',
                    'payment_status' => $emi->payment_status ?? '',
                    
                ];
            });
            
            
           
            $data['customer_data'] = $customer_data;
            $data['emi_data'] = $emi_data;
            
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Customer EMI List.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function addMandate(Request $request)
    {
        try {
            
            if (empty($request->total_amount) || empty($request->mobile) || empty($request->full_name)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'All fields  is required field.']);
            }
            
            if($request->id!=''){
                $rules = [
                    'brand_id' => 'required',
                    'model_id' => 'required',
                    'variant_id' => 'required',
                    'colour_id' => 'required',
                    'full_name' => 'required',
                    'mobile' => 'required|digits:10|unique:customers,mobile,' . $request->id,
                ];
            }else{
                $rules = [
                    'brand_id' => 'required',
                    'model_id' => 'required',
                    'variant_id' => 'required',
                    'colour_id' => 'required',
                    'full_name' => 'required',
                    'mobile' => 'required|digits:10|unique:customers,mobile',
                ];
            }
            

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            //return $request->all(); 
            
            $user = auth()->user();
            
            if($request->id!=''){
                $saveLead = Customer::find($request->id);
            }else{
                $saveLead = new Customer();
            }
            $saveLead->brand_id = $request->brand_id;
            $saveLead->model_id = $request->model_id;
            $saveLead->variant_id = $request->variant_id;
            $saveLead->colour_id = $request->colour_id;
            $saveLead->total_amount = $request->total_amount;
            $saveLead->mobile = $request->mobile;
            $saveLead->full_name = $request->full_name;
            $saveLead->bill_details = $request->bill_details;
            $saveLead->collected_amount = 0;
            $saveLead->pending_amount = $request->total_amount;
            
            $saveLead->save();
            
            $customer_data['id']=$saveLead->id;
            $customer_data['brand_id']=$saveLead->brand_id;
            $customer_data['model_id']=$saveLead->model_id;
            $customer_data['variant_id']=$saveLead->variant_id;
            $customer_data['colour_id']=$saveLead->colour_id;
            $customer_data['total_amount']=$saveLead->total_amount;
            $customer_data['mobile']=$saveLead->mobile;
            $customer_data['full_name']=$saveLead->full_name;
            $customer_data['bill_details']=$saveLead->bill_details;
            
            $installments[]=array('ints_number'=>1,'ints_amount'=>round($request->total_amount/1));
            $installments[]=array('ints_number'=>2,'ints_amount'=>round($request->total_amount/2));
            $installments[]=array('ints_number'=>3,'ints_amount'=>round($request->total_amount/3));
            $installments[]=array('ints_number'=>4,'ints_amount'=>round($request->total_amount/4));
            $installments[]=array('ints_number'=>5,'ints_amount'=>round($request->total_amount/5));
            $installments[]=array('ints_number'=>6,'ints_amount'=>round($request->total_amount/6));
            $installments[]=array('ints_number'=>7,'ints_amount'=>round($request->total_amount/7));
            $installments[]=array('ints_number'=>8,'ints_amount'=>round($request->total_amount/8));
            $installments[]=array('ints_number'=>9,'ints_amount'=>round($request->total_amount/9));
            $installments[]=array('ints_number'=>10,'ints_amount'=>round($request->total_amount/10));
            $installments[]=array('ints_number'=>11,'ints_amount'=>round($request->total_amount/11));
            $installments[]=array('ints_number'=>12,'ints_amount'=>round($request->total_amount/12));
            
            $customer_data['installments']=$installments;
            
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Added successfully.';
            $result['data'] = $customer_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function addMandate2(Request $request)
    {
        try {
            
            if (empty($request->id) || empty($request->collect_type) || empty($request->frequency) ||
            empty($request->ints_number) || empty($request->ints_amount) || empty($request->collect_date)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'All fields  is required field.']);
            }
            $rules = [
                'id' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            //return $request->all(); 
            
            $user = auth()->user();
            
            $saveLead = Customer::find($request->id);
            
            $saveLead->collect_type = $request->collect_type;
            $saveLead->frequency = $request->frequency;
            $saveLead->ints_number = $request->ints_number;
            $saveLead->ints_amount = $request->ints_amount;
            $saveLead->collect_date = $request->collect_date;
            
            $saveLead->save();
            
            $OldEmi = CustomerEmi::where('customer_id',$saveLead->id)->delete();
            
            for($i=0; $i<$request->ints_number; $i++){
                
                $saveEmi = new CustomerEmi();
                
                $emi_start_date=date('Y-m-d', strtotime('+'.$i.' month', strtotime($request->collect_date)));
                $emi_end_date=date('Y-m-d', strtotime('+10 days', strtotime($emi_start_date)));
                
                $saveEmi->customer_id = $saveLead->id;
                $saveEmi->emi_amount = $request->ints_amount;
                $saveEmi->emi_start_date = $emi_start_date;
                $saveEmi->emi_end_date = $emi_end_date;
                $saveEmi->payment_status = 'Upcoming';
                
                $saveEmi->save();
            }
            
            $customer_data['id']=$saveLead->id;
            $customer_data['brand_id']=$saveLead->brand_id;
            $customer_data['model_id']=$saveLead->model_id;
            $customer_data['variant_id']=$saveLead->variant_id;
            $customer_data['colour_id']=$saveLead->colour_id;
            $customer_data['total_amount']=$saveLead->total_amount;
            $customer_data['mobile']=$saveLead->mobile;
            $customer_data['full_name']=$saveLead->full_name;
            $customer_data['bill_details']=$saveLead->bill_details;
            
            
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Added successfully.';
            $result['data'] = $customer_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }


}
