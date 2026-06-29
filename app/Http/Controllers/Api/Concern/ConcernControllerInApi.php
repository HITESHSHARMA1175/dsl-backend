<?php

namespace App\Http\Controllers\Api\Concern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//new apis model 
use App\Models\MasterValue;
use App\Models\Customer;
use App\Models\Concern;
use App\Models\PatientConcern;


use Carbon\Carbon;

class ConcernControllerInApi extends Controller
{
    
    public function get_concern_type(Request $request)
    {
        try {
            $user = auth()->user();
            
            
            
            $datas = MasterValue::where('MasterHead', '10')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->MasterValue,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Concern type fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_concern(Request $request)
    {
        try {
            $user = auth()->user();
            
            $concern_type = $request->concern_type_id;
            
            $datas = Concern::where('concern_types', $concern_type)->where('parent_id', 0)->get();
            $data_data = $datas->map(function ($data) {
                
                $childs=[];
                $child_datas = Concern::where('parent_id', $data->id)->get();
                foreach ($child_datas as $child_data)
                {
                    $childs[] = array(
                            'id'=>$child_data->id,
                            'name'=>$child_data->name,
                            
                        );
                        
                }
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->name,
                    'childs' => $childs,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Concern type fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function save_concern(Request $request)
    {
        try {
            $user = auth()->user();
    
            // Check if concern already exists for this patient and appointment
            $existingConcern = PatientConcern::where('patient_id', $request->patient_id)
                ->where('appointment_id', $request->appointment_id)
                ->first();
    
            if ($existingConcern) {
                // Update existing record
                $existingConcern->concerns = json_encode($request->concerns);
                $existingConcern->add_by = $user->id;
                $existingConcern->save();
    
                $message = 'Concern updated successfully.';
            } else {
                // Create new concern record
                $savePatientConcern = new PatientConcern();
                $savePatientConcern->patient_id = $request->patient_id;
                $savePatientConcern->appointment_id = $request->appointment_id;
                $savePatientConcern->concerns = json_encode($request->concerns);
                $savePatientConcern->add_by = $user->id;
                $savePatientConcern->save();
    
                $message = 'Concern saved successfully.';
            }
    
            return response()->json([
                'error' => false,
                'status' => 200,
                'success' => true,
                'message' => $message,
                'data' => []
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage() . ', line no.: ' . $e->getLine()
            ]);
        }
    }

    
    public function get_saved_concern(Request $request)  
    {
        try {
            $user = auth()->user();
    
            $patient_id = $request->patient_id;
            $appointment_id = $request->appointment_id;
    
            $savedConcern = PatientConcern::where('patient_id', $patient_id)
                ->where('appointment_id', $appointment_id)
                ->first();
    
            if (!$savedConcern) {
                return response()->json([
                    'error' => true,
                    'status' => 404,
                    'success' => false,
                    'message' => 'No concern found for the given patient and appointment.',
                    'data' => []
                ]);
            }
    
            $decodedConcerns = json_decode($savedConcern->concerns, true);
    
            $concernsWithNames = collect($decodedConcerns)->map(function ($item) {
                $concernType = MasterValue::find($item['concern_type_id']);
                $concern = Concern::find($item['concern_id']);
    
                $childConcerns = Concern::whereIn('id', $item['concern_child_ids'])->get();
    
                return [
                    'concern_type_id' => $item['concern_type_id'],
                    'concern_type_name' => $concernType ? $concernType->MasterValue : null,
    
                    'concern_id' => $item['concern_id'],
                    'concern_name' => $concern ? $concern->name : null,
                    'concern_image' => $concern ? asset('uploads/cimage.png') : null, // update if you have actual image field
    
                    'child' => $childConcerns->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'name' => $child->name,
                            'image' => asset('uploads/cimage.png'), // update this if an actual image field exists
                        ];
                    }),
                ];
            });
    
            $data = [
                'patient_id' => $savedConcern->patient_id,
                'appointment_id' => $savedConcern->appointment_id,
                'concerns' => $concernsWithNames,
            ];
    
            return response()->json([
                'error' => false,
                'status' => 200,
                'success' => true,
                'message' => 'Concern retrieved successfully.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => 500,
                'success' => false,
                'message' => $e->getMessage() . ', line no.: ' . $e->getLine()
            ]);
        }
    }




    
    
 

}
