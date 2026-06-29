<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

//new apis model
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\Addon;
use App\Models\Professional;
use App\Models\Customer;
use App\Models\KiBooking;
use App\Models\Treatment;


use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\MasterValue;
use App\Models\Banner;
use App\Models\Faq;
use App\Models\Patient;


use Carbon\Carbon;

class CommonControllerInApi extends Controller
{
    
    public function get_staff(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = PropertyCategory::where('id', '!=', '')
                        ->where('category_name', 'like', '%'.$request->search_text.'%')
                        ->paginate(10); // 10 items per page, you can adjust the number as needed
    
            $data_data = $datas->map(function ($data) {
                return [
                    'id' => $data->id ?? '',
                    'name' => 'Staff '.$data->id,
                    'role' => 'Clinical',
                    'job_title' => 'Practitioner',
                    'access' => 'Staff',
                ];
            });
    
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Staff fetched successfully.';
            $result['data'] = $data_data;
            $result['pagination'] = [
                'total' => $datas->total(),
                'per_page' => $datas->perPage(),
                'current_page' => $datas->currentPage(),
                'last_page' => $datas->lastPage(),
                'next_page_url' => $datas->nextPageUrl(),
                'prev_page_url' => $datas->previousPageUrl(),
            ];
    
            return $result;
    
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }

    public function get_patient(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = Patient::where('id', '!=', '')
                        ->where('first_name', 'like', '%'.$request->search_text.'%')
                        ->paginate(10); // 10 items per page, you can adjust the number as needed
    
            $data_data = $datas->map(function ($data) {
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->first_name.' '.$data->last_name,
                    'dob' => '2024-05-17',
                    'address' => 'noida',
                ];
            });
    
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Patient fetched successfully.';
            $result['data'] = $data_data;
            $result['pagination'] = [
                'total' => $datas->total(),
                'per_page' => $datas->perPage(),
                'current_page' => $datas->currentPage(),
                'last_page' => $datas->lastPage(),
                'next_page_url' => $datas->nextPageUrl(),
                'prev_page_url' => $datas->previousPageUrl(),
            ];
    
            return $result;
    
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }

    
    public function get_all_patient(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = KiBooking::where('id', '!=', '')->where('first_name', 'like', '%'.$request->search_text.'%')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->first_name.' '.$data->last_name,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Patient fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_appointment_type(Request $request)
    {
        try {
            $user = auth()->user();
            
            
            
            $datas = MasterValue::where('MasterHead', '4')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->MasterValue,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Appointment type fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_treatment_type(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = MasterValue::where('MasterHead', '5')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->MasterValue,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Treatment type fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_treatment(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = Treatment::where('treatment_type', $request->treatment_type_id)->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => $data->name,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Treatment fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_room(Request $request)
    {
        try {
            $user = auth()->user();
            
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
            $result['message'] = 'Room fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_equipment(Request $request)
    {
        try {
            $user = auth()->user();
            
            $datas = Faq::where('id', '!=', '')->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'name' => 'equipment '.$data->id,
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Equipment fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_app_slots(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = Professional::query();
            $query->where("id","=",$request->professional_id);
            $datas = $query->orderByDesc('id')->first();
            
            
            $startTime = '10:00';
            $endTime = '17:00';
            $interval = 10; // minutes
    
            
            $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
            $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);
    
            $slots = [];
            $i = 1;
            while ($start->lt($end)) {
                //$slots[] = $start->format('H:i');
                $start->addMinutes($interval);
                
                $slots[] = array(
                    'id' => $i ?? '',
                    'slot_start' => $start->format('H:i:a') ?? '',
                    'slot_end' => $start->format('H:i:a') ?? '',
                    'date' => date('d M',strtotime($request->date)) ?? ''
                    );
                    
                $i++;        
            }

            
            /*$data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'slot' => '10:00 am' ?? '',
                    'date' => '10 July' ?? '',
                    
                ];
            });*/
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Slot fetched successfully.';
            $result['data'] = $slots;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function ki_get_categories(Request $request)
    {
        try {
            $user = auth()->user();
            
            if($request->parent_id==''){
                $request->parent_id=0;
            }
            
            $datas = PropertyCategory::where('parent_id', $request->parent_id)->get();
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'parent_id' => $data->parent_id ?? '',
                    'name' => $data->category_name ?? '',
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Categories fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function ki_get_services(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = Property::query();
            
            if ($request->category_id != '') {
                $query->where(function ($query) use ($request) {
                    $query->where("property_category","=",$request->category_id);
                });
            }
            
            if ($request->sub_category_id != '') {
                $query->where(function ($query) use ($request) {
                    $query->where("property_sub_category","=",$request->sub_category_id);
                });
            }
            
            $datas = $query->orderByDesc('id')->get();
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'title' => $data->property_name ?? '',
                    'description' => $data->description ?? '',
                    'long_description' => $data->long_description ?? '',
                    'price' => $data->price ?? '',
                    'discounted_price' => $data->discounted_price ?? '',
                    'number_of_members_required' => $data->number_of_members_required ?? '',
                    'duration' => $data->duration ?? '',
                    'rating' => '0',
                    'number_of_ratings' => '0',
                    
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Services fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function ki_get_addon_services(Request $request)
    {
        try {
            $user = auth()->user();
            
            $category_id = $request->category_id;
             //$service_id = json_decode($request->service_id, true);
            
            $query = Addon::query();
            
            if ($category_id != '') {
                // $query->where(function ($query) use ($service_id) {
                //     $query->whereIn("parent_id", $service_id);
                // });
                $query->where("parent_id", $category_id);
            }
            
            
            //$datas = $query->orderByDesc('id')->get();
            $datas = $query->orderByDesc('id')->paginate(10);
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'category_id' => $data->parent_id ?? '',
                    'title' => $data->addon_name ?? '',
                    'description' => $data->description ?? '',
                    'long_description' => $data->long_description ?? '',
                    'price' => $data->price ?? '',
                    'discounted_price' => $data->discounted_price ?? '',
                    'number_of_members_required' => $data->number_of_members_required ?? '',
                    'duration' => $data->duration ?? '',
                    'rating' => '0',
                    'number_of_ratings' => '0',
                    'profile' => !empty($data->profile) ? asset('uploads/addon') . '/' . $data->profile : '',
                    
                    
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Addon fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_professionals(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = Professional::query();
            
            if ($request->service_id != '') {
                $query->where(function ($query) use ($request) {
                    $query->where("parent_id","=",$request->service_id);
                });
            }
            
            
            $datas = $query->orderByDesc('id')->get();
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'pro_name' => $data->professional_name ?? '',
                    'pro_designation' => $data->designation ?? '',
                    'pro_profession' => $data->profession ?? '',
                    'image' => $data->profile ?? '',
                    'rating' => $data->rating ?? 0,
                    
                    
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Professionals fetched successfully.';
            $result['data'] = $data_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_latter_slots(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = Professional::query();
            $query->where("id","=",$request->professional_id);
            $datas = $query->orderByDesc('id')->first();
            
            
            $professional_id = $request->professional_id;
            $sdate = $request->date;
            $totalDuration = $request->total_service_duration;
            
            $startTime = '10:00';
            $endTime = '17:00';
            $interval = 10; // minutes
    
            
            $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
            $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);
    
            $slots = [];
            $i = 1;
            while ($start->lt($end)) {
                
                $start2 = $start->copy();
                $startTime = $start2->subMinutes($totalDuration)->format('h:i:a'); // 12-hour format with AM/PM
                $endTime = $start2->addMinutes($totalDuration*2)->format('h:i:a'); // Adds 80 mins to get 40 mins after
                
                $query = KiBooking::where('profession_id', $professional_id)
                ->where('slot_date',$sdate) // Convert slot_date to DATE format
                ->whereBetween(DB::raw("STR_TO_DATE(slot_time, '%h:%i:%p')"), [
                    DB::raw("STR_TO_DATE('$startTime', '%h:%i:%p')"),
                    DB::raw("STR_TO_DATE('$endTime', '%h:%i:%p')")
                ]);
                
                $exists = $query->exists();
            
                if (!$exists) {
                    $slotStart = $start->format('H:i:a');
                    $slotEnd = (clone $start)->addMinutes($totalDuration)->format('H:i:a');
                
                    $slots[] = array(
                        'id' => $i ?? '',
                        'slot' => $slotStart,
                        'slot_end' => $slotEnd,
                        'date' => date('d M', strtotime($request->date)) ?? ''
                    );
                }
               
                $start->addMinutes($interval);
                $i++;  
                   
            }

            
            /*$data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'slot' => '10:00 am' ?? '',
                    'date' => '10 July' ?? '',
                    
                ];
            });*/
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Slot fetched successfully.';
            $result['data'] = $slots;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function get_next_slots(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = Professional::query();
            $query->where("id","=",$request->professional_id);
            $datas = $query->orderByDesc('id')->first();
            
            
            $startTime = '10:00';
            $endTime = '17:00';
            $interval = 10; // minutes
    
            
            $start = \Carbon\Carbon::createFromFormat('H:i', $startTime);
            $end = \Carbon\Carbon::createFromFormat('H:i', $endTime);
    
            $slots = [];
            $i = 1;
            while ($start->lt($end)) {
                //$slots[] = $start->format('H:i');
                $start->addMinutes($interval);
                
                $slots[] = array(
                    'id' => $i ?? '',
                    'slot' => $start->format('H:i:a') ?? '',
                    'date' => date('d M',strtotime($request->date)) ?? ''
                    );
                    
                $i++;        
            }

            
            /*$data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                    'slot' => '10:00 am' ?? '',
                    'date' => '10 July' ?? '',
                    
                ];
            });*/
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Slot fetched successfully.';
            $result['data'] = $slots;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function add_ki_booking(Request $request)
    {
        try {
            $user = auth()->user();
            
            $rules = [
                'service_id' => 'required',
                'profession_id' => 'required',
                'slot_id' => 'required',
                'slot_date' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                
            ];
            
            $check_validate = Validator::make($request->all(), $rules);
            if ($check_validate->fails()) {
                return response()->json(['error' => true, 'status' => 200, 'success' => false, 'message' => $check_validate->errors()->first()]);
            }
            
            
            
            $query = Customer::query();
            $query->where("mobile","=",$request->mobile)->whereOr("email","=",$request->email);
            $customer = $query->orderByDesc('id')->first();
            
            $user_id = @$customer->id;
            
            if(@$user_id==''){
               
                
                $saveCustomer = new Customer();
                $saveCustomer->first_name = $request->first_name;
                $saveCustomer->last_name = $request->last_name;
                $saveCustomer->mobile = $request->mobile;
                $saveCustomer->email = $request->email;
                
                $saveCustomer->save();
                
                $user_id = $saveCustomer->id;
                
            }
            
            $saveBooking = new KiBooking();
            $saveBooking->user_id = $user_id;
            $saveBooking->service_id = $request->service_id;
            $saveBooking->addon_id = $request->addon_id;
            $saveBooking->profession_id = $request->profession_id;
            $saveBooking->total_service_duration = $request->total_service_duration;
            $saveBooking->total_addon_duration = $request->total_addon_duration;
            $saveBooking->ddate = $request->date;
            $saveBooking->slot_id = $request->slot_id;
            $saveBooking->slot_date = $request->slot_date;
            $saveBooking->slot_time = $request->slot_time; 
            $saveBooking->first_name = $request->first_name;
            $saveBooking->last_name = $request->last_name;
            $saveBooking->email = $request->email;
            $saveBooking->mobile = $request->mobile;
            
            $saveBooking->save();
            
            $data=[
                    'booking_id'=>$saveBooking->id,
                ];
            
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Booking added successfully.';
            $result['data'] = $data;
            
            return $result;

        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function search_ki_booking(Request $request)
    {
        try {
            $user = auth()->user();
            
            $query = KiBooking::query();
            $query->where("first_name","=",$request->search_text);
            $datas = $query->orderByDesc('id')->get();
            
            $data_data = $datas->map(function ($data) {
                
               
                return [
                    'id' => $data->id ?? '',
                   
                ];
            });
            
           
            $result['error'] = false;
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Booking fetched successfully.';
            $result['data'] = $datas;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    
    
    
    
    public function getState(Request $request)
    {
        try {
            $user = auth()->user();

            $states = State::where('country_id', $request->country_id)->get();
            $state_data = $states->map(function ($state) {
                
               
                return [
                    'id' => $state->id ?? '',
                    'name' => $state->name ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'State List.';
            $result['data'] = $state_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getCity(Request $request)
    {
        try {
            $user = auth()->user();

            $cities = City::where('state_id', $request->state_id)->get();
            $city_data = $cities->map(function ($city) {
                
               
                return [
                    'id' => $city->id ?? '',
                    'name' => $city->name ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'City List.';
            $result['data'] = $city_data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function businessTypeList(Request $request)
    {
        try {
            $user = auth()->user();

            $masterValues = MasterValue::where('MasterHead', '1')->get();
            $data = $masterValues->map(function ($masterValue) {
                
               
                return [
                    'id' => $masterValue->id ?? '',
                    'name' => $masterValue->MasterValue ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Master Value List.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function businessCategoryList(Request $request)
    {
        try {
            $user = auth()->user();

            $masterValues = MasterValue::where('MasterHead', '2')->get();
            $data = $masterValues->map(function ($masterValue) {
                
               
                return [
                    'id' => $masterValue->id ?? '',
                    'name' => $masterValue->MasterValue ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Master Value List.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function ki_get_addon_categories(Request $request)
    {
        try {
            $user = auth()->user();

            $masterValues = MasterValue::where('MasterHead', '3')->get();
            $data = $masterValues->map(function ($masterValue) {
                
               
                return [
                    'id' => $masterValue->id ?? '',
                    'name' => $masterValue->MasterValue ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Addon Category List.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function getHelpSupport(Request $request)
    {
        try {
            $user = auth()->user();
            
            $top_banner=[];
            $propertyimages = Banner::where('banner_type', '=', 'Help & Support Video')->get(); 
            foreach ($propertyimages as $item)
            {
                $top_banner[] = array('id'=>$item->id,'name'=>$item->banner_name,'video_url'=>$item->banner_url);
            }
            
            $data['video_data']=$top_banner;


            $masterValues = Faq::where('id', '!=', '')->get();
            $data['help_data'] = $masterValues->map(function ($masterValue) {
                
               
                return [
                    'id' => $masterValue->id ?? '',
                    'question' => $masterValue->faq_name ?? '',
                    'answer' => $masterValue->description ?? '',
                ];
            });
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Help Support List.';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function staticPage(Request $request)
    {
        try {
            $user = auth()->user();

            $banner = Banner::where('banner_type', 'Static Pages')->where('banner_name', '=', $request->page_name)->first(); 
            
            $data['title']=$banner->banner_name;
            $data['description']=$banner->description;
            
           
            $result['status'] = 200;
            $result['success'] = true;
            $result['message'] = 'Page Details';
            $result['data'] = $data;
            
            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
  

    

}
