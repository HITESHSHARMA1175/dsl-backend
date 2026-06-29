<?php

namespace App\Http\Controllers\Api\SellerCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\SellerLead;
use App\Models\Master;
use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\User;
use App\Models\LeadJourney;
use App\Models\SellerLeadJourney;
use Str;

class SellerCrmControllerInApi extends Controller
{
   
  
    public function assignedSellerData(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
                
                $query = SellerLead::query();
                /*$query->where("assign_emp", $user->id)
                      ->where(function($query) {
                          $query->where("status", "New");
                      })->orderBy('id', 'desc');*/
                      
                $query->where("assign_emp", $user->id)
                      ->orderBy('id', 'desc');      
                
                $leads = $query->get();
               
                $leadCount = $leads->count();
                
                $all_leads=[];
                
                foreach ($leads as $lead)
                {
                    
                    
                    $all_leads[] = array(
                                        'id'=>$lead->id,
                                        'name'=>$lead->name,
                                        'mobile_no'=>$lead->mobile_no,
                                        'alt_mobile_no'=>$lead->alt_mobile_no,
                                        'email'=>$lead->email,
                                        /*'project_name'=>$lead->project_name,
                                        'floor_name'=>$lead->floor_name,
                                        'unit_no'=>$lead->unit_no,
                                        'tower_no'=>$lead->tower_no,
                                        'salable_area'=>$lead->salable_area,
                                        'base_rate'=>$lead->base_rate,
                                        'unit_value'=>$lead->unit_value,
                                        'total_cost'=>$lead->total_cost,
                                        'outstanding_principle'=>$lead->outstanding_principle,
                                        'broker_name'=>$lead->broker_name,*/
                                        'assign_date'=>$lead->assign_date,
                                        
                                    );
                
                }
                
              
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Assigned Seller Data List.';
                $result['dataCount'] = $leadCount;
                $result['data'] = $all_leads;
                return $result;
                
            }else{
                
                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';
                $result['dataCount'] = 0;
                $result['data'] = [];
                
            }

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]); 
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function sellerDataDetails(Request $request)
    {
        try {
            $user = auth()->user();
            
            if(isset($user)){
              
                $lead = SellerLead::where('id', $request->id)->first();
                
                
                $history=[];
                
                $leadJourneys = $lead
                ->getSellerLeadJourney()
                ->orderByDesc('id')
                ->get();
                
                foreach ($leadJourneys as $journey)
                {
                    
                    if($journey->status=='New'){
                        $status='Pending';
                    }else{
                        $status=$journey->status;
                    }
                    
                    $history[] = array(
                                    'id'=>$journey->id,
                                    'status'=>$journey->status,
                                    'call_back_date'=>$journey->call_back_date,
                                    'remark'=>$journey->remark,
                                    'created_at'=>$journey->created_at->format('d M Y, l'),
                                    
                                );
                                    
                    
                    
                }
               
                $all_leads = array(
                                        'id'=>$lead->id,
                                        'name'=>$lead->name,
                                        'mobile_no'=>$lead->mobile_no,
                                        'alt_mobile_no'=>$lead->alt_mobile_no,
                                        'email'=>$lead->email,
                                        'sale_type'=>$lead->sale_type,
                                        'property_category'=>$lead->property_category,
                                        'property_sub_category'=>$lead->property_sub_category,
                                        'property_size'=>$lead->property_size,
                                        'builder_name'=>$lead->builder_name,
                                        'project_name'=>$lead->project_name,
                                        'country_name'=>$lead->country_name,
                                        'state_name'=>$lead->state_name,
                                        'city_name'=>$lead->city_name,
                                        'address'=>$lead->address,
                                        'locality'=>$lead->locality,
                                        'pincode'=>$lead->pincode,
                                        'floor_name'=>$lead->floor_name,
                                        'unit_no'=>$lead->unit_no,
                                        'tower_no'=>$lead->tower_no,
                                        'salable_area'=>$lead->salable_area,
                                        'base_rate'=>$lead->base_rate,
                                        'unit_value'=>$lead->unit_value,
                                        'total_cost'=>$lead->total_cost,
                                        'outstanding_principle'=>$lead->outstanding_principle,
                                        'broker_name'=>$lead->broker_name,
                                        'assign_date'=>$lead->assign_date,
                                        'history'=>$history,
                                        
                                    );
            
              
                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Schedule Visit Or Token Details.';
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
    
    public function sellerDataUpdate(Request $request)
    {
        try {
            
             
            
            $user = auth()->user();
            
            $id=$request->id;
            
            $saveLead = SellerLead::findOrFail($id);

            $saveLead->status = $request->status;
            $saveLead->call_back_date = $request->call_back_date;
            $saveLead->remark = $request->remark;
            
            $saveLead->save();
            
            
            $leadJourney = new SellerLeadJourney();
            $leadJourney->lead = $id;
            $leadJourney->status = $request->status;
            $leadJourney->call_back_date = $request->call_back_date;
            $leadJourney->remark = $request->remark;
            $leadJourney->addby = $user->id;
            $leadJourney->save();
        

            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Updated successfully.';
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    

}
