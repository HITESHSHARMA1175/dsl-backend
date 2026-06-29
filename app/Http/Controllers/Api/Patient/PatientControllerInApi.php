    <?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//new apis model 
use App\Models\Clinic;
use App\Models\MasterValue;
use App\Models\Customer;
use App\Models\Patient;
use App\Models\MedicalHistory;
use App\Models\PatientMedicalHistory;

use Carbon\Carbon;

class PatientControllerInApi extends Controller
{
    
    public function add_patient(Request $request)
    {
        try {
            
            $user = auth()->user();
            
         
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                
            ];
            
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            $savePatient = new Patient();
            
            $savePatient->first_name = $request->first_name;
            $savePatient->last_name = $request->last_name;
            $savePatient->sex = $request->sex;
            $savePatient->gender = $request->gender;
            $savePatient->dob = $request->dob;
            $savePatient->mobile = $request->mobile;
            $savePatient->email = $request->email;
            $savePatient->contact_permission = $request->contact_permission;
            $savePatient->address1 = $request->address1;
            $savePatient->address2 = $request->address2;
            $savePatient->city = $request->city;
            $savePatient->country = $request->country;
            $savePatient->pincode = $request->pincode;
            $savePatient->country2 = $request->country2;
            $savePatient->add_by = $user->id;
            
            $savePatient->save();
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Added successfully.';
            $result['data'] = [];
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function update_patient(Request $request)
    {
        try {
            
            $user = auth()->user();
            
            if($request->type=='Demographics'){
                
                $rules = [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    
                ];
                
                $check_validate = Validator::make($request->all(), $rules);
                if ($check_validate->fails()) {
                    return response()->json(['status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
                }
                
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->title = $request->title;
                $savePatient->first_name = $request->first_name;
                $savePatient->last_name = $request->last_name;
                $savePatient->middle_name = $request->middle_name;
                $savePatient->sex = $request->sex;
                $savePatient->gender = $request->gender;
                $savePatient->dob = $request->dob;
                $savePatient->marital_status = $request->marital_status;
                $savePatient->maiden_name = $request->maiden_name;
                $savePatient->about_hear = $request->about_hear;
                $savePatient->add_by = $user->id;
                
                $savePatient->save();
            
            }else if($request->type=='Contact Details'){
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->mobile = $request->mobile;
                $savePatient->home_mobile = $request->home_mobile;
                $savePatient->work_mobile = $request->work_mobile;
                $savePatient->email = $request->email;
                $savePatient->address1 = $request->address1;
                $savePatient->address2 = $request->address2;
                $savePatient->city = $request->city;
                $savePatient->country = $request->country;
                $savePatient->pincode = $request->pincode;
                $savePatient->country2 = $request->country2;
                $savePatient->add_by = $user->id;
                
                $savePatient->save();
                
            }else if($request->type=='Registered Clinic'){
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->clinic_id = $request->clinic_id;
                $savePatient->clinician_id = $request->clinician_id;
                $savePatient->add_by = $user->id;
                
                $savePatient->save();
                
            }else if($request->type=='GP Information'){
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->gp_privately_insured = $request->gp_privately_insured;
                $savePatient->gp_practice = $request->gp_practice;
                $savePatient->gp_name = $request->gp_name;
                $savePatient->gp_phone = $request->gp_phone;
                $savePatient->gp_address1 = $request->gp_address1;
                $savePatient->gp_address2 = $request->gp_address2;
                $savePatient->gp_city = $request->gp_city;
                $savePatient->gp_country = $request->gp_country;
                $savePatient->gp_pincode = $request->gp_pincode;
                $savePatient->gp_country2 = $request->gp_country2;
                $savePatient->add_by = $user->id;
                
                $savePatient->save();
                
            }else if($request->type=='Patient GDPR'){
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->permission_to_contact = $request->permission_to_contact;
                $savePatient->contact_permission_for = $request->contact_permission_for;
                $savePatient->permission_to_marketing = $request->permission_to_marketing;
                $savePatient->marketing_permission_for = $request->marketing_permission_for;
                $savePatient->add_by = $user->id;
                
                $savePatient->save();
                
            }else if($request->type=='Emergency Contact'){
                
                $savePatient = Patient::find($request->id);
            
                $savePatient->e_first_name = $request->e_first_name;
                $savePatient->e_last_name = $request->e_last_name;
                $savePatient->e_mobile = $request->e_mobile;
                $savePatient->e_home_mobile = $request->e_home_mobile;
                $savePatient->e_patient_relation = $request->e_patient_relation;
                $savePatient->add_by = $user->id;
               
                $savePatient->save();
                
            }
            
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Updated successfully.';
            $result['data'] = [];
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function medicle_history_patient(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = MasterValue::where('MasterHead', '9')->get();
    
            $data_data = $datas->map(function ($data) {
                
                $history_values = MedicalHistory::where('medical_history', '34')->get();
                $history_values11 = $history_values->map(function ($history_value) {
                    return [
                        'id' => $history_value->id ?? '',
                        'name' => $history_value->name,
                        
                    ];
                });
                
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->MasterValue,
                    'history_values' => $history_values11,
                    
                ];
            });
    
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Medical history.';
            $result['data'] = $data_data;
            
            return $result;
    
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_patient_timeline(Request $request)
    {
        try {
            $user = auth()->user();
            $patient_id = $request->patient_id;
            $datas = Patient::where('id', $patient_id);
            $data = $datas->first();
            
            
                $data_data[] = array(
                    'id' => 1,
                    'name' => 'Advises no known allergies',
                    'status' => 'red',
                    
                );
                
                $data_data[] = array(
                    'id' => 1,
                    'name' => 'Allergy to dermal fillers',
                    'status' => 'red',
                    
                );
                
                $data_data[] = array(
                    'id' => 1,
                    'name' => 'Be sting allergy',
                    'status' => 'red',
                    
                );
                
                $data_data[] = array(
                    'id' => 1,
                    'name' => 'Blepharoplasty Lower',
                    'status' => 'yellow',
                    
                );
                
                $data_data[] = array(
                    'id' => 1,
                    'name' => 'Blepharoplasty Upper',
                    'status' => 'yellow',
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Patient Timeline.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_patient_info(Request $request)
    {
        try {
            $user = auth()->user();
            $patient_id = $request->patient_id;
            $datas = Patient::where('id', $patient_id);
            $data = $datas->first();
            
            
                $data_data = array(
                    'id' => $data->id ?? 0,
                    'd_title' => $data->title ?? '',
                    'd_fname' => $data->first_name ?? '',
                    'd_mname' => $data->middle_name ?? '',
                    'd_lname' => $data->last_name ?? '',
                    'd_sex' => $data->sex ?? '',
                    'd_gender' => $data->gender ?? '',
                    'd_dob' => '10.06.1996 (28)',
                    'd_marital' => $data->marital_status ?? '',
                    'd_maiden_name' => $data->maiden_name ?? '',
                    'd_about_hear' => $data->about_hear ?? '',
                    
                    'c_mobile_phone' => $data->mobile ?? '',
                    'c_home_phone' => $data->home_mobile ?? '',
                    'c_work_phone' => $data->work_mobile ?? '',
                    'c_email' => $data->email ?? '',
                    'c_address' => 'Delhi India',
                    
                    'clinic_id' => $data->clinic_id ?? 0,
                    'clinician_id' => $data->clinician_id ?? 0,
                    'cl_name' => 'Diamond Skin Ltd',
                    'cl_phone' => '9090909090',
                    'cl_clinician' => '9090909090',
                    'cl_address' => 'Delhi India',
                    
                    'gp_privately_insured' => $data->gp_privately_insured ?? '',
                    'gp_practice' => $data->gp_practice ?? '',
                    'gp_name' => $data->gp_name ?? '',
                    'gp_phone' => $data->gp_phone ?? '',
                    'gp_address' => $data->gp_address1 ?? '',
                    
                    'g_permission_given' => 'Yes',
                    'g_preferred_cotact' => 'Phone, SMS, Email',
                    'g_cotact_marketing' => 'No',
                    'g_preferred_cotact2' => 'No Permission',
                    
                    'e_fname' => $data->e_first_name ?? '',
                    'e_lname' => $data->e_last_name ?? '',
                    'e_mobile' => $data->e_mobile ?? '',
                    'e_home_phone' => $data->e_home_mobile ?? '',
                    'e_patient_relation' => $data->e_patient_relation ?? '',
                    
                    'last_update_at' => '20 Dec 2024 at 12:54',
                    'last_updated_by' => 'Devolyt Tech',
                    
                   
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Patient Info.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_patient_finance(Request $request)
    {
        try {
            $user = auth()->user();
            $patient_id = $request->patient_id;
            $datas = Patient::where('id', $patient_id);
            $data = $datas->first();
            
            
                $data_data = array(
                    'id' => $data->id ?? '',
                    'total_invoice' => 300,
                    'total_paid' => 100,
                    'total_remaining' => 200,
                    
                    
                );
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Patient Finance.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function save_medical_history(Request $request)
    {
        try {
            $user = auth()->user();
    
            // Check if concern already exists for this patient and appointment
            $existingConcern = PatientMedicalHistory::where('patient_id', $request->patient_id)
                ->where('appointment_id', $request->appointment_id)
                ->first();
    
            if ($existingConcern) {
                // Update existing record
                $existingConcern->medical_history = json_encode($request->medical_history);
                $existingConcern->add_by = $user->id;
                $existingConcern->save();
    
                $message = 'Medical history updated successfully.';
            } else {
                // Create new concern record
                $savePatientConcern = new PatientMedicalHistory();
                $savePatientConcern->patient_id = $request->patient_id;
                $savePatientConcern->appointment_id = $request->appointment_id;
                $savePatientConcern->medical_history = json_encode($request->medical_history);
                $savePatientConcern->add_by = $user->id;
                $savePatientConcern->save();
    
                $message = 'Medical history saved successfully.';
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
    
    
    
 

}
