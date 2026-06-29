<?php

namespace App\Http\Controllers\Api\Appointment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//new apis model 
use App\Models\Appointment;
use App\Models\AppointmentJourney;
use App\Models\AppointmentLog;
use App\Models\KiBooking;
use App\Models\MasterValue;
use App\Models\Treatment;


use Carbon\Carbon;

class AppointmentControllerInApi extends Controller
{
    
    public function get_appointment_details(Request $request)
    {
        try {
            $user = auth()->user();
            $appointmentId = $request->appointment_id;
            $datas = Appointment::where('id', $appointmentId);
            $data = $datas->first();
            
                $appointmentJourneys = $data
                ->getAppointmentJourney()
                ->orderByDesc('id')
                ->get();
                
                $notes=[];
                
                foreach ($appointmentJourneys as $journey)
                {
                    $notes[] = array(
                            'id'=>$journey->id,
                            'notes'=>$journey->notes,
                            'addby'=>$journey->getAppointmentJourneyAddby->id.'Devolyt',
                            'created_at'=>$journey->created_at->format('H:i d.m.y'),
                            
                        );
                        
                }
                
                if(@$data->getAppointmentPatient->id!=''){
                    $app_patient_code = "{$data->getAppointmentPatient->id}";
                    $app_patient_name = $data->getAppointmentPatient->first_name.' '.$data->getAppointmentPatient->last_name;
                }else{
                    $app_patient_code = "";
                    $app_patient_name = "";
                }
            
                $data_data = array(
                    'id' => $data->id ?? '',
                    'clinician_id' => $data->clinician_id,
                    'app_purpose' => $data->app_purpose,
                    'app_date' => $data->app_date,
                    'app_duration' => $data->app_duration,
                    'app_time_start' => $data->app_time_start,
                    'app_time_end' => $data->app_time_end,
                    'title' => $data->title,
                    'app_patient' => $data->app_patient,
                    'patient_id' => $data->app_patient,
                    'app_type' => $data->app_type,
                    'virtual_call' => $data->virtual_call,
                    'treatement_type_id' => $data->treatement_type,
                    'treatement_id' => $data->treatement,
                    'room_id' => $data->room,
                    'equipment_id' => $data->equipment,
                    'created_at' => $data->created_at,
                    'add_by' => @$data->getAppointmentAddedBy->id.'Devolyt',
                    'app_patient_name' => $app_patient_code,
                    'app_patient_code' => $app_patient_code,
                    'app_status' => $data->app_status,
                    'treatement_type' => @$data->getAppTreatementType->MasterValue,
                    'treatement' => @$data->getAppTreatement->name,
                    'room' => @$data->getAppRoom->MasterValue,
                    'gender' => 'Male',
                    'dob' => $data->app_date,
                    'address' => 'Delhi India',
                    'home_phone' => @$data->getAppointmentPatient->home_phone ?? 'N/A',
                    'mobile' => @$data->getAppointmentPatient->mobile ?? 'N/A',
                    'work_phone' => @$data->getAppointmentPatient->work_phone ?? 'N/A',
                    'notes' => $notes,
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment details successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_appointment(Request $request)
    {
        try {
            $user = auth()->user();
            $clinicianId = $request->clinician_id;
            $datas = Appointment::where('id', '!=', '');
            // Check if clinician_id is present in the request
            if ($clinicianId != '') {
                $datas = $datas->where('clinician_id', $clinicianId);
            }
            
            // Execute the query and get the results
            $datas = $datas->get();
            $data_data = $datas->map(function ($data) {
                
                if(@$data->getAppointmentPatient->id!=''){
                    $app_patient_code = "{$data->getAppointmentPatient->id}";
                    $app_patient_name = $data->getAppointmentPatient->first_name.' '.$data->getAppointmentPatient->last_name;
                }else{
                    $app_patient_code = "";
                    $app_patient_name = "";
                }
               
                return [
                    'id' => $data->id ?? '',
                    'clinician_id' => $data->clinician_id,
                    'app_purpose' => $data->app_purpose,
                    'app_date' => $data->app_date,
                    'app_duration' => $data->app_duration,
                    'app_time_start' => $data->app_time_start,
                    'app_time_end' => $data->app_time_end,
                    'title' => $data->title,
                    'app_patient_name' => $app_patient_name,
                    'app_patient_code' => $app_patient_code,
                    'app_status' => $data->app_status,
                    'treatement_type' => @$data->getAppTreatementType->MasterValue,
                    'treatement' => @$data->getAppTreatement->name,
                    'room' => @$data->getAppRoom->MasterValue,
                    'dob' => $data->app_date,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function create_appointment(Request $request)
    {
        try {
            $user = auth()->user();
            
            $rules = [
                'clinician_id' => 'required',
                
            ];
            
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['error' => true, 'status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            if(@$request->id!=''){
                $saveAppointment = Appointment::find($request->id);
            }else{
                $saveAppointment = new Appointment();
            }
            
            $saveAppointment->clinician_id = $request->clinician_id;
            $saveAppointment->title = $request->title;
            $saveAppointment->app_date = $request->app_date;
            $saveAppointment->app_duration = $request->app_duration;
            $saveAppointment->total_service_duration = $request->total_service_duration;
            $saveAppointment->app_time_id = $request->app_time_id;
            $saveAppointment->app_time_start = $request->app_time_start;
            $saveAppointment->app_time_end = $request->app_time_end;
            $saveAppointment->app_purpose = $request->app_purpose;
            $saveAppointment->app_patient = $request->app_patient;
            $saveAppointment->app_type = $request->app_type; 
            $saveAppointment->virtual_call = $request->virtual_call;
            $saveAppointment->treatement_type = $request->treatement_type;
            $saveAppointment->treatement = $request->treatement;
            $saveAppointment->room = $request->room;
            $saveAppointment->equipment = $request->equipment;
            $saveAppointment->app_notes = $request->app_notes;
            $saveAppointment->add_by = $user->id;
            
            $saveAppointment->save();
            
            $appointmentJourney = new AppointmentJourney();
            $appointmentJourney->appointment = $saveAppointment->id;
            $appointmentJourney->notes = $request->app_notes;
            $appointmentJourney->add_by = $user->id;
            $appointmentJourney->save();
            
            $data=[
                    'appointment_id'=>$saveAppointment->id,
                ];
            
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment added successfully.';
            $result['data'] = $data;
            
            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
 
    public function add_appointment_notes(Request $request)
    {
        try {
            $user = auth()->user();
            
            $rules = [
                'appointment_id' => 'required',
                
            ];
            
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['error' => true, 'status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            
            $appointmentJourney = new AppointmentJourney();
            $appointmentJourney->appointment = $request->appointment_id;
            $appointmentJourney->notes = $request->app_notes;
            $appointmentJourney->add_by = $user->id;
            $appointmentJourney->save();
            
            $data=[
                    'notes_id'=>$appointmentJourney->id,
                ];
            
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment notes added successfully.';
            $result['data'] = $data;
            
            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
 
    public function add_appointment_logs(Request $request)
    {
        try {
            $user = auth()->user();
            
            $rules = [
                'appointment_id' => 'required',
                
            ];
            
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['error' => true, 'status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            
            $appointmentJourney = new AppointmentLog();
            $appointmentJourney->appointment = $request->appointment_id;
            $appointmentJourney->appointment_action = $request->appointment_action;
            $appointmentJourney->add_by = $user->id;
            $appointmentJourney->save();
            
            $data=[
                    'appointment_action_id'=>$appointmentJourney->id,
                    'appointment_action'=>$appointmentJourney->appointment_action,
                    'created_at'=>$appointmentJourney->created_at->format('H:i d.m.y'),
                ];
            
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment action added successfully.';
            $result['data'] = $data;
            
            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
 

}
