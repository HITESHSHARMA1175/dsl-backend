<?php

namespace App\Http\Controllers\Admin\SellerCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Master;
use App\Models\MasterValue;
use App\Models\PropertyRoom;
use App\Models\Property;
use App\Models\PropertyCategory;
use App\Models\User;
use App\Models\LeadJourney;
use App\Models\SellerLead;
use App\Models\SellerLeadJourney;
use App\Models\Owner;
use App\Models\Builder;
use App\Models\Society;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Str;

// use App\Exports\ExportReceiving;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SellerDataImport;


class SellerCrmControllerInAdmin extends Controller
{
    
    /**
     * Import data.
     */
    public function sellerDataImportdata(Request $request)
    {
        try {
            Excel::import(new SellerDataImport(), $request->file('file')->store('temp'));
            return redirect()
                ->back()
                ->with('message', 'Import successful!');
            // return response()->json(['message' => 'Import successful!']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', explode(' (', $e->getMessage())[0]);
            // return response()->json(['error' => $e->getMessage()], 500);
            return response()->json(['status' => Constants::FAILED_STATUS, 'error' => $e->getMessage(), 'message' => 'validation error'], 422);
        }
    }
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 'New';
        $leads = SellerLead::where('status', $status)
            ->orderByDesc('id')
            ->paginate(10);
        $properties = Property::get();
        $fieldPersons = User::where('id','!=', '17')->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get();*/

        return view('admin.sellercrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $leadSources = Master::where('MasterHead', 'Lead Sources')->first()->getMasterValues ?? [];
        return view('admin.sellercrm.create', compact('roomTypes', 'leadSources', 'properties','ropertySaleType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return view('admin.sellercrm.create');
        $saveLead = new SellerLead();

        $saveLead->name = $request->name;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->alt_mobile_no = $request->alt_mobile_no;
        $saveLead->email = $request->email;
        
        $saveLead->sale_type = $request->sale_type;
        $saveLead->property_category = $request->property_category;
        $saveLead->property_sub_category = $request->property_sub_category;
        $saveLead->property_size = $request->property_size;
        $saveLead->builder_name = $request->builder_name;
        $saveLead->project_name = $request->project_name;
        $saveLead->country_name = $request->country_name;
        $saveLead->state_name = $request->state_name;
        $saveLead->city_name = $request->city_name;
        $saveLead->address = $request->address;
        $saveLead->locality = $request->locality;
        $saveLead->pincode = $request->pincode;
        
        $saveLead->floor_name = $request->floor_name;
        $saveLead->unit_no = $request->unit_no;
        $saveLead->tower_no = $request->tower_no;
        $saveLead->salable_area = $request->salable_area;
        $saveLead->base_rate = $request->base_rate;
        $saveLead->unit_value = $request->unit_value;
        $saveLead->total_cost = $request->total_cost;
        $saveLead->outstanding_principle = $request->outstanding_principle;
        $saveLead->broker_name = $request->broker_name;
        $saveLead->message = $request->message;
        $saveLead->addby = auth()->user()->id;
        
        $saveLead->save();
        return redirect()
            ->back()
            ->with('success', 'Data has been saved Successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $status)
    {
      
        $status = $status;
        $query = SellerLead::query();
        
        if ($status == 'All') {
            // No additional conditions for 'All' status
        } elseif ($status == 'Visits') {
            $query->where(function ($query) use ($status) {
                $query->where('status', $status)->orWhere('status', 'Re Visits');
            });
        } else {
            $query->where('status', $status);
        }
        
        if (auth()->user()->id != 17) {
            $query->where(function ($query) {
                $userId = auth()->user()->id;
                $query->where('addby', $userId)->orWhere('assign_emp', $userId);
            });
        }
        
        $leads = $query->orderByDesc('id')->paginate(100);
        $properties = Property::get();
        $fieldPersons = User::where('id','!=', '17')->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get();*/
        return view('admin.sellercrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $properties = Property::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $leadSources = Master::where('MasterHead', 'Lead Sources')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $lead = SellerLead::findOrFail($id);
        
        $propertySubCategory = $lead->getSellerLeadSubCategory;
         //dd($propertySubCategory);
        $propertyMappedAttribute = $propertySubCategory->getMappedSellerLeadAttribute;
        $propertyAttribute = $lead->getSellerLeadAttributes;
        // dd($propertyAttribute);
        
        $countries = Country::get();
        $owners = Owner::where('status', 1)->get();
        $builders = Builder::where('status', 1)->get();
        $societies = Society::where('builder_id', $lead->builder_id)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        
        return view('admin.sellercrm.update', compact('lead', 'roomTypes', 'leadSources', 'properties','ropertySaleType','owners','builders','societies','categories',
        'countries','propertyMappedAttribute','propertyAttribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $saveLead = SellerLead::findOrFail($id);
        
        $saveLead->name = $request->name;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->alt_mobile_no = $request->alt_mobile_no;
        $saveLead->email = $request->email;
        
        $saveLead->sale_type = $request->sale_type;
        $saveLead->property_category = $request->property_category;
        $saveLead->property_sub_category = $request->property_sub_category;
        $saveLead->property_size = $request->property_size;
        $saveLead->builder_name = $request->builder_name;
        $saveLead->project_name = $request->project_name;
        $saveLead->country_name = $request->country_name;
        $saveLead->state_name = $request->state_name;
        $saveLead->city_name = $request->city_name;
        $saveLead->address = $request->address;
        $saveLead->locality = $request->locality;
        $saveLead->pincode = $request->pincode;
        
        $saveLead->floor_name = $request->floor_name;
        $saveLead->unit_no = $request->unit_no;
        $saveLead->tower_no = $request->tower_no;
        $saveLead->salable_area = $request->salable_area;
        $saveLead->base_rate = $request->base_rate;
        $saveLead->unit_value = $request->unit_value;
        $saveLead->total_cost = $request->total_cost;
        $saveLead->outstanding_principle = $request->outstanding_principle;
        $saveLead->broker_name = $request->broker_name;
        $saveLead->message = $request->message;
        
        $saveLead->save();
        return redirect()
            ->back()
            ->with('success', 'Data has been saved Successfully!!');
    }

    public function changeSellerLeadStatus(Request $request)
    {
        $id = $request->id;
        $lead = SellerLead::findOrFail($id);
        $lead->status = $request->status;
        if ($request->status == 'Call Scheduled') {
            
            $lead->call_status = $request->status;
            $lead->call_date = $request->call_date;
            $lead->call_time = $request->call_time;
            $lead->call_agenda = $request->remark;
            
        }
        if ($request->status == 'Meeting Scheduled') {
            
            $lead->meeting_status = $request->status;
            $lead->meeting_with = $request->meeting_with;
            $lead->meeting_date = $request->meeting_date;
            $lead->meeting_time = $request->meeting_time;
            $lead->meeting_agenda = $request->remark;
            
        }
        $lead->save();
        $leadJourney = new SellerLeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = $request->status;

        if ($request->status == 'Visits') {
            $leadJourney->visit_time = $request->visit_time;
            $leadJourney->visit_date = $request->visit_date;
            $leadJourney->property = $request->property;
            $leadJourney->field_person = $request->field_person;
        }
        
        if ($request->status == 'Convert To Property') {
            
            @$property_country = Country::where('name', $lead->country_name)->first();
            @$property_state = State::where('name', $lead->state_name)->first();
            @$property_city = City::where('name', $lead->city_name)->first();
            
            $addOwner = new Owner();
            $addOwner->first_name = $lead->name;
            $addOwner->mobile_no = $lead->mobile_no;
            $addOwner->alt_mobile_no = $lead->alt_mobile_no;
            $addOwner->email = $lead->email;
            $addOwner->addby = auth()->user()->id;
            $addOwner->save();
            
            $addBuilder = new Builder();
            $addBuilder->builder_name = $lead->builder_name;
            $addBuilder->addby = auth()->user()->id;
            $addBuilder->save();
            
            /*$saveSociety = new Society();
            $saveSociety->builder_id = $addBuilder->id;
            $saveSociety->society_name = $lead->project_name;
            $saveSociety->country_id = $property_country->id;
            $saveSociety->state_id = $property_state->id;
            $saveSociety->city_id = $property_city->id;
            $saveSociety->address = $lead->address;
            $saveSociety->pincode = $lead->pincode;
            $saveSociety->save();*/
            
            @$property_category = PropertyCategory::where('category_name', $lead->property_category)->first();
            @$property_sub_category = PropertyCategory::where('category_name', $lead->property_sub_category)->first();
            
            @$property_bhk = MasterValue::where('MasterValue', $lead->sale_type)->first();
            
            @$property_society = Society::where('society_name', $lead->project_name)->first();
            
            
            
            $saveProperty = new Property();
            $saveProperty->property_name = $lead->property_size.'-'.$lead->sale_type;
            $saveProperty->owner_id = @$addOwner->id;
            $saveProperty->builder_id = @$addBuilder->id;
            $saveProperty->society_id = @$property_society->id;
            $saveProperty->property_category = @$property_category->id;
            $saveProperty->property_sub_category = @$property_sub_category->id;
            $saveProperty->property_size = @$lead->property_size;
            $saveProperty->property_bhk = @$property_bhk->id;
            $saveProperty->country_id = @$property_country->country_id;
            $saveProperty->state_id = @$property_society->state_id;
            $saveProperty->city_id = @$property_society->city_id;
            $saveProperty->area = @$lead->address;
            $saveProperty->street = @$lead->locality;
            $saveProperty->pincode = @$lead->pincode;
    
            
            
            $saveProperty->floor_name = $lead->floor_name;
            $saveProperty->unit_no = $lead->unit_no;
            $saveProperty->tower_no = $lead->tower_no;
            $saveProperty->salable_area = $lead->salable_area;
            $saveProperty->base_rate = $lead->base_rate;
            $saveProperty->unit_value = $lead->unit_value;
            $saveProperty->total_cost = $lead->total_cost;
            $saveProperty->outstanding_principle = $lead->outstanding_principle;
            $saveProperty->broker_name = $lead->broker_name;
            $saveProperty->addby = auth()->user()->id;
            
            $saveProperty->save();
        }

        $FileName = '';
        if ($request->status == 'Agreement') {
            if ($request->hasFile('agreement')) {
                $file = $request->file('agreement');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->agreement = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('police_verification')) {
                $file = $request->file('police_verification');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->police_verification = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('signatured_agreement')) {
                $file = $request->file('signatured_agreement');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->signatured_agreement = $FileName;
                $FileName = '';
            }
        }
        if ($request->status == 'Call Scheduled') {
            
            $leadJourney->call_status = $request->status;
            $leadJourney->call_date = $request->call_date;
            $leadJourney->call_time = $request->call_time;
            $leadJourney->call_agenda = $request->remark;
            
        }
        if ($request->status == 'Meeting Scheduled') {
            
            $leadJourney->meeting_status = $request->status;
            $leadJourney->meeting_with = $request->meeting_with;
            $leadJourney->meeting_date = $request->meeting_date;
            $leadJourney->meeting_time = $request->meeting_time;
            $leadJourney->meeting_agenda = $request->remark;
            
        }
        if ($request->status == 'Move In') {
            $leadJourney->visit_time = $request->visit_time;
            $leadJourney->visit_date = $request->visit_date;
            $leadJourney->property = $request->property;
            $leadJourney->field_person = $request->field_person;
        }
        
        $leadJourney->remark = $request->remark;
        $leadJourney->addby = auth()->user()->id;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Lead Status has been saved Successfully!!');
    }
    
    public function assignSellerLead(Request $request)
    {
        
        if($request->ids=="All"){
            
            
            SellerLead::where('id','!=',null)->update([
                'assign_emp' => $request->assign_emp,
                'assign_date' => now(),
                'assign_by' => auth()->user()->id,
            ]);
                
            
        }elseif($request->type=="Multiple"){
            
            $ids = $request->ids;
            $ids_array = explode(',', $ids);
            foreach ($ids_array as $id) {
                
                if($id!=''){
                    $lead = SellerLead::findOrFail($id);
                    $lead->assign_emp = $request->assign_emp;
                    $lead->assign_date = now();
                    $lead->assign_by = auth()->user()->id;
                    $lead->save();
                }
                
            }
            
        }else{
            
            $id = $request->id;
            $lead = SellerLead::findOrFail($id);
            $lead->assign_emp = $request->assign_emp;
            $lead->assign_date = now();
            $lead->assign_by = auth()->user()->id;
            $lead->save();
            
        }
        
        return redirect()
            ->back()
            ->with('success', 'Lead has been Assigned Successfully!!');
    }
    
    public function updateSellerDataCall(Request $request)
    {
        $id = $request->id;
        $lead = SellerLead::findOrFail($id);
        $lead->call_status = $request->call_status;
        $lead->call_date = $request->call_date;
        $lead->call_time = $request->call_time;
        $lead->call_agenda = $request->call_agenda;
        $lead->save();
        
        $leadJourney = new SellerLeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = $lead->status;
        
        $leadJourney->call_status = $request->call_status;
        $leadJourney->call_date = $request->call_date;
        $leadJourney->call_time = $request->call_time;
        $leadJourney->call_agenda = $request->call_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->remark;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Call has been Updated Successfully!!');
    }
    
    public function updateSellerDataMeeting(Request $request)
    {
        $id = $request->id;
        $lead = SellerLead::findOrFail($id);
        $lead->meeting_status = $request->meeting_status;
        $lead->meeting_with = $request->meeting_with;
        $lead->meeting_date = $request->meeting_date;
        $lead->meeting_time = $request->meeting_time;
        $lead->meeting_agenda = $request->meeting_agenda;
        $lead->save();
        
        $leadJourney = new SellerLeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = $lead->status;
        
        $leadJourney->meeting_status = $request->meeting_status;
        $leadJourney->meeting_with = $request->meeting_with;
        $leadJourney->meeting_date = $request->meeting_date;
        $leadJourney->meeting_time = $request->meeting_time;
        $leadJourney->meeting_agenda = $request->meeting_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->remark;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Meeting has been Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = SellerLead::findOrFail($id);
        $lead->delete();
        return redirect()
            ->back()
            ->with('success', 'Lead has been Deleted Successfully!!');
    }
}
