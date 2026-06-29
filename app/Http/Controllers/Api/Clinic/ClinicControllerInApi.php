<?php

namespace App\Http\Controllers\Api\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//new apis model 
use App\Models\Clinic;
use App\Models\MasterValue;

use Carbon\Carbon;

class ClinicControllerInApi extends Controller
{
    
    public function get_clinic(Request $request)
    {
        try {
            $user = auth()->user();
            $datas = Clinic::where('id', '1')->get();
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->clinic_name,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic list.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_all_clinic(Request $request)
    {
        try {
            $user = auth()->user();
            $datas = Clinic::where('id', '1')->get();
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->clinic_name,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic list.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_info(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = Clinic::where('id', $clinicId);
            $data = $datas->first();
            
            
                $data_data = array(
                    'id' => $data->id ?? '',
                    'clinic_name' => $data->clinic_name ?? 'N/A',
                    'clinic_website' => $data->clinic_website ?? 'N/A',
                    'clinic_email' => $data->clinic_email ?? 'N/A',
                    'clinic_phone' => $data->clinic_phone ?? 'N/A',
                    'clinic_alt_phone' => $data->clinic_alt_phone ?? 'N/A',
                    'clinic_timezone' => $data->clinic_timezone ?? 'N/A',
                    'address' => $data->address ?? 'N/A',
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic info.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_hxg(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = Clinic::where('id', $clinicId);
            $data = $datas->first();
            
            
                $data_data = array(
                    'id' => $data->id ?? '',
                    'account_status' => '1',
                    'username' => 'rajivanshk',
                    'account_reference' => 'DIA20',
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic HXG.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_rooms(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = MasterValue::where('MasterHead', '7')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->MasterValue,
                ];
            });
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic Rooms.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_equipments(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = MasterValue::where('MasterHead', '7')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => 'Equipment '.$data->id,
                    'room' => 'Room 1',
                    'is_portable' => '1',
                ];
            });
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic Equipments.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_time(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = Clinic::where('id', $clinicId);
            $data = $datas->first();
            
            
                $data_data[] = array(
                    'id' => 1,
                    'day' => 'Mon',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 2,
                    'day' => 'Tue',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 3,
                    'day' => 'Wed',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 4,
                    'day' => 'Thu',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 5,
                    'day' => 'Fri',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 6,
                    'day' => 'Sat',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
                
                $data_data[] = array(
                    'id' => 7,
                    'day' => 'Sun',
                    'open_time' => '09:00',
                    'close_time' => '19:00',
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic Opening times.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_clinic_finance(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicId = $request->clinic_id;
            $datas = Clinic::where('id', $clinicId);
            $data = $datas->first();
            
            
                $data_data = array(
                    'id' => $data->id ?? '',
                    'vat_type' => 'percentage',
                    'vat' => '20',
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Clinic HXG.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
 

}
