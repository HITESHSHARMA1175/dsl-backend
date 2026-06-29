<?php

namespace App\Http\Controllers\Api\SalesCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Lead;
use App\Models\Master;
use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\User;
use App\Models\LeadJourney;
use Str;

class SalesCrmControllerInApi extends Controller
{
   
    public function scheduleVisit(Request $request)
    {
        try {
            
            if (empty($request->property_id) || empty($request->full_name) || empty($request->mobile_no) ||
            empty($request->room_type) || empty($request->availability_date) || empty($request->availability_time)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'All fields  is required field.']);
            }
            $rules = [
                'full_name' => 'required',
                'mobile_no' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            //return $request->all(); 
            
            $user = auth()->user();
            
            //$property=   $properties = Property::where('id', $request->property_id)->first();
                
       
            $saveLead = new Lead();

            $saveLead->user_id = $user->id;
            $saveLead->property_id = $request->property_id;
            $saveLead->room_id = $request->room_id ?? '';
            $saveLead->room_type = $request->room_type;
            $saveLead->room_rent = $request->room_rent ?? 0;
            $saveLead->source = 69;
            $saveLead->status = 'Visits';
            $saveLead->type = 'Schedule Visit';
            if (!empty($request->availability_date)) {
                $saveLead->availability = date('Y-m-d', strtotime($request->availability_date));
            }
            if (!empty($request->availability_time)) {
                //$saveLead->availability_time = date('H:i:s', strtotime($request->availability_time));
                $saveLead->availability_time = $request->availability_time;
            }
            $saveLead->name = $request->full_name;
            $saveLead->mobile_no = $request->mobile_no;
            
            $saveLead->email = $request->email ?? '';
            $saveLead->message = $request->message ?? '';
            $saveLead->save();
            $id=$saveLead->id;
            
            $leadJourney = new LeadJourney();
            $leadJourney->lead = $id;
            $leadJourney->status = 'Visits';
            if (!empty($request->availability_date)) {
                $leadJourney->visit_date = $request->availability_date;
            }
            if (!empty($request->availability_time)) {
                $leadJourney->visit_time = $request->availability_time;
            }
            $leadJourney->property = $request->property_id;
            $leadJourney->field_person = '';
            $leadJourney->remark = $request->message;
            $leadJourney->save();
        

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Added successfully.';
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function tokenCollected(Request $request)
    {
        try {
            
            if (empty($request->property_id) || empty($request->token_amount)) {
                return response()->json(['status' => 200, 'success' => false, 'message' => 'All fields  is required field.']);
            }
            $rules = [
                'token_amount' => 'required',
                'property_id' => 'required',
                'room_id' => 'required',
            ];

            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            //return $request->all(); 
            
            $user = auth()->user();
            
            //$property=   $properties = Property::where('id', $request->property_id)->first();
                
       
            $saveLead = new Lead();

            $saveLead->user_id = $user->id;
            $saveLead->property_id = $request->property_id;
            $saveLead->room_id = $request->room_id;
            $saveLead->bed_id = $request->bed_id;
            $saveLead->room_type = $request->room_type;
            $saveLead->room_rent = $request->room_rent ?? 0;
            $saveLead->token_amount = $request->token_amount ?? 0;
            $saveLead->status = 'Token Collect';
            $saveLead->type = 'Token Collect';
            $saveLead->source = 69;
            if (!empty($request->availability_date)) {
                $saveLead->moveindate = date('Y-m-d', strtotime($request->availability_date));
            }
            
            $saveLead->name = $user->first_name;
            $saveLead->mobile_no = $user->mobile_no;
            $saveLead->email = $user->email ?? '';
            $saveLead->message = 'Rs. '.$request->token_amount.' Paid' ?? '';
            $saveLead->save();
            
            $id=$saveLead->id;
            
            $leadJourney = new LeadJourney();
            $leadJourney->lead = $id;
            $leadJourney->status = 'Token Collect';
    
            $leadJourney->remark = 'Rs. '.$request->token_amount.' Paid';
            $leadJourney->save();
            
            if($request->bed_id!=''){
                
                $savePropertyRoom = PropertyRoom::find($request->room_id);
                
                if($request->bed_id=='1'){
                    
                    $savePropertyRoom->available_b1 = 'No';
                    $savePropertyRoom->available = 'No';
                    
                }elseif($request->bed_id=='2'){
                    
                    $avlRoom = PropertyRoom::where('id', $request->room_id)->where('available_b1', 'No')->first();
                    if($avlRoom->id!=''){
                        $savePropertyRoom->available = 'No';
                    }
                    $savePropertyRoom->available_b2 = 'No';
                    
                }elseif($request->bed_id=='3'){
                    
                    $avlRoom = PropertyRoom::where('id', $request->room_id)->where('available_b1', 'No')->where('available_b2', 'No')->first();
                    if($avlRoom->id!=''){
                        $savePropertyRoom->available = 'No';
                    }
                    $savePropertyRoom->available_b3 = 'No';
                    
                }elseif($request->bed_id=='4'){
                    
                    $avlRoom = PropertyRoom::where('id', $request->room_id)->where('available_b1', 'No')->where('available_b2', 'No')->where('available_b3', 'No')->first();
                    if($avlRoom->id!=''){
                        $savePropertyRoom->available = 'No';
                    }
                    $savePropertyRoom->available_b4 = 'No';
                    
                }
                
                $savePropertyRoom->save();
                
                
                
                
                
            }else{
                
                $savePropertyRoom = PropertyRoom::find($request->room_id);
                $savePropertyRoom->available = 'No';
                $savePropertyRoom->save();
                
            }
        

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Added successfully.';
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getScheduleToken(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $query = Lead::query();
                $query->where("user_id", $user->id)
                      ->where(function($query) {
                          $query->where("type", "Schedule Visit");
                      })->orderBy('id', 'desc');
                
                $leads = $query->get();
               
                $leadCount = $leads->count();
                
                $all_leads=[];
                
                foreach ($leads as $lead)
                {
                    
                    $property = Property::where('id', $lead->property_id)->first();
                    $propertyimages = $property->getPropertyImages;
                    foreach ($propertyimages as $item)
                    {
                        $property_image = asset('uploads/property') . '/' . $item->image;
                    }
                    
                    if($lead->status=='New'){
                        $status='Pending';
                    }else{
                        $status=$lead->status;
                    }
                    
                   
                    $all_leads[] = array(
                                            'id'=>$lead->id,
                                            'type'=>$lead->type,
                                            'status'=>$status,
                                            'property_name' => $property->property_name ?? '',
                                            'property_image' => $property_image ?? '',
                                            'country' => @$property->getPropertyCountry->name ?? '',
                                            'state' => @$property->getPropertyState->name ?? '',
                                            'city' => @$property->getPropertyCity->name ?? '',
                                            'pincode' => $property->pincode ?? '',
                                            'area' => $property->area ?? '',
                                            'street' => $property->street ?? '',
                                           
                                        );
                
                }
                
              
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Schedule Visit List.';
                $result['leadCount'] = $leadCount;
                $result['data'] = $all_leads;
                return $result;
                
            }else{
                
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getTokenCollected(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $query = Lead::query();
                $query->where("user_id", $user->id)
                      ->where(function($query) {
                          $query->where("type", "Token Collect");
                      })->orderBy('id', 'desc');
                
                $leads = $query->get();
               
                $leadCount = $leads->count();
                
                $all_leads=[];
                
                foreach ($leads as $lead)
                {
                    
                    $property = Property::where('id', $lead->property_id)->first();
                    $propertyimages = $property->getPropertyImages;
                    foreach ($propertyimages as $item)
                    {
                        $property_image = asset('uploads/property') . '/' . $item->image;
                    }
                    
                    if($lead->status=='New'){
                        $status='Pending';
                    }else{
                        $status=$lead->status;
                    }
                    
                   
                    $all_leads[] = array(
                                            'id'=>$lead->id,
                                            'type'=>$lead->type,
                                            'status'=>$status,
                                            'property_name' => $property->property_name ?? '',
                                            'property_image' => $property_image ?? '',
                                            'country' => @$property->getPropertyCountry->name ?? '',
                                            'state' => @$property->getPropertyState->name ?? '',
                                            'city' => @$property->getPropertyCity->name ?? '',
                                            'pincode' => $property->pincode ?? '',
                                            'area' => $property->area ?? '',
                                            'street' => $property->street ?? '',
                                           
                                        );
                
                }
                
              
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Token Collected List.';
                $result['leadCount'] = $leadCount;
                $result['data'] = $all_leads;
                return $result;
                
            }else{
                
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getScheduleTokenDetails(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
              
                $lead = Lead::where('id', $request->id)->first();
               
                
                $property = Property::where('id', $lead->property_id)->first();
                $propertyimages = $property->getPropertyImages;
                foreach ($propertyimages as $item)
                {
                    $property_image = asset('uploads/property') . '/' . $item->image;
                }
                
                if($lead->status=='New'){
                    $status='Pending';
                }else{
                    $status=$lead->status;
                }
                
               
                $all_leads = array(
                                        'id'=>$lead->id,
                                        'type'=>$lead->type,
                                        'status'=>$status,
                                        'property_name' => $property->property_name ?? '',
                                        'property_image' => $property_image ?? '',
                                        'country' => @$property->getPropertyCountry->name ?? '',
                                        'state' => @$property->getPropertyState->name ?? '',
                                        'city' => @$property->getPropertyCity->name ?? '',
                                        'pincode' => $property->pincode ?? '',
                                        'area' => $property->area ?? '',
                                        'street' => $property->street ?? '',
                                       
                                    );
            
                $leadJourneys = $lead
                ->getLeadJourney()
                ->orderByDesc('id')
                ->get();
                
                $history=[];
                
                foreach ($leadJourneys as $journey)
                {
                    
                    if($journey->status=='New'){
                        $status='Pending';
                    }else{
                        $status=$journey->status;
                    }
                    
                    if($journey->status=='New'){
                        
                        $history[] = array(
                                        'id'=>$journey->id,
                                        'status'=>'Pending',
                                        'remark'=>$journey->remark,
                                        'created_at'=>$journey->created_at->format('d M Y, l'),
                                        
                                    );
                                    
                    }elseif($journey->status=='Agreement'){
                        
                        $history[] = array(
                                        'id'=>$journey->id,
                                        'status'=>$journey->status,
                                        'remark'=>$journey->remark,
                                        'created_at'=>$journey->created_at->format('d M Y, l'),
                                        'agreement'=>!empty($journey->agreement) ? asset('uploads/users_document') . '/' . $journey->agreement : '',
                                        'police_verification'=>!empty($journey->police_verification) ? asset('uploads/users_document') . '/' . $journey->police_verification : '',
                                        'signatured_agreement'=>!empty($journey->signatured_agreement) ? asset('uploads/users_document') . '/' . $journey->signatured_agreement : '',
                                        
                                    );
                                    
                    }elseif($journey->status=='Visits'){
                        
                        $history[] = array(
                                        'id'=>$journey->id,
                                        'status'=>$journey->status,
                                        'remark'=>$journey->remark,
                                        'created_at'=>$journey->created_at->format('d M Y, l'),
                                        'visit_time'=>$journey->visit_time ?? '',
                                        'visit_date'=>$journey->visit_date ?? '',
                                        'field_person'=>@$journey->getLeadFieldPerson->first_name . ' ' . @$journey->getLeadFieldPerson->last_name ?? '',
                                        
                                    );
                                    
                    }else{
                        
                        $history[] = array(
                                        'id'=>$journey->id,
                                        'status'=>$journey->status,
                                        'remark'=>$journey->remark,
                                        'created_at'=>$journey->created_at->format('d M Y, l'),
                                        
                                    );
                                    
                    }
                    
                }
                
              
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Schedule Visit Or Token Details.';
                $result['data'] = $all_leads;
                $result['history'] = $history;
                return $result;
                
            }else{
                
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['data'] = [];
                
            }

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    

}
