<?php

namespace App\Http\Controllers\Admin\SellerCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;

// use App\Exports\ExportReceiving;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SellerDataImport;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Owner;
use App\Models\Builder;
use App\Models\Society;
use App\Models\Master;
use App\Models\MasterValue;
use App\Models\PropertyCategory;
use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\PropertyChecklist;
use App\Models\PropertyCategoryAttribute;
use App\Models\PropertyImage;
use App\Models\MoveDetail;
use App\Models\InventoryCategory;
use App\Models\PropertyRoomInventory;
use App\Models\SellerLead;
use App\Models\SalesLeadCategoryAttribute;
use App\Models\SalesLeadImage;
use App\Models\SellerLeadJourney;

class SellerCrmControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        
        $societies = Society::where('id', '!=', '')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();

        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $ropertyBhks = Master::where('MasterHead', 'Property BKH')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $roomSizes = Master::where('MasterHead', 'Room Size')->first()->getMasterValues ?? [];
        $roomBathrooms = Master::where('MasterHead', 'Room Bathroom')->first()->getMasterValues ?? [];
        $roomKitchens = Master::where('MasterHead', 'Room Kitchen')->first()->getMasterValues ?? [];
        $roomBalconies = Master::where('MasterHead', 'Room Balcony')->first()->getMasterValues ?? [];
        $propertyChecklist = Master::where('MasterHead', 'Property Checklist')->first()->getMasterValues ?? [];
        
        if(auth()->user()->is_admin=='1'){
            $properties = SellerLead::paginate(10);
            $propertyCount = SellerLead::count();
        }else{
            $properties = SellerLead::where('addby', auth()->user()->id)->paginate(10);
            $propertyCount = SellerLead::where('addby', auth()->user()->id)->count();
        }
        
        return view('admin.sellercrm.index', compact('properties','propertyCount', 'roomTypes',
        'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist','ropertyBhks','ropertySaleType',
       'inventoryTypes','inventoryCategories','propertyChecklist','societies','categories'));
    }
    
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
    public function show(Request $request,string $status)
    {
        
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        
        $societies = Society::where('id', '!=', '')->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $subcategories = PropertyCategory::where('parent_id', $request->category)->get();

        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $ropertyBhks = Master::where('MasterHead', 'Property BKH')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $roomSizes = Master::where('MasterHead', 'Room Size')->first()->getMasterValues ?? [];
        $roomBathrooms = Master::where('MasterHead', 'Room Bathroom')->first()->getMasterValues ?? [];
        $roomKitchens = Master::where('MasterHead', 'Room Kitchen')->first()->getMasterValues ?? [];
        $roomBalconies = Master::where('MasterHead', 'Room Balcony')->first()->getMasterValues ?? [];
        $propertyChecklist = Master::where('MasterHead', 'Property Checklist')->first()->getMasterValues ?? [];
        
        $states = State::where('country_id', '101')->get();
        $cities = City::where('state_id', $request->state)->get();
        
        $status = $status;
        $query = SellerLead::query();
        
        if ($status == 'All') {
            // No additional conditions for 'All' status
        } elseif ($status == 'Visits') {
            $query->where(function ($query) use ($status) {
                $query->where('lead_status', $status)->orWhere('status', 'Re Visits');
            });
        } else {
            $query->where('lead_status', $status);
        }
        
        if (auth()->user()->is_admin != '1') {
            $query->where(function ($query) {
                $userId = auth()->user()->id;
                $query->where('addby', $userId)->orWhere('assign_emp', $userId);
            });
        }
        
        if ($request->project != '') {
            $query->where('society_id', '=', $request->project);
        }
        
        if ($request->size != '') {
            
            if($request->size=='100 Sqft - 300 Sqft'){
                $query->where('property_size', '>=', 100);
                $query->where('property_size', '<=', 300);
            }elseif($request->size=='300 Sqft - 500 Sqft'){
                $query->where('property_size', '>=', 300);
                $query->where('property_size', '<=', 500);
            }elseif($request->size=='500 Sqft - 800 Sqft'){
                $query->where('property_size', '>=', 500);
                $query->where('property_size', '<=', 800);
            }elseif($request->size=='800 Sqft - 1100 Sqft'){
                $query->where('property_size', '>=', 800);
                $query->where('property_size', '<=', 1100);
            }elseif($request->size=='1100 Sqft - 1500 Sqft'){
                $query->where('property_size', '>=', 1100);
                $query->where('property_size', '<=', 1500);
            }elseif($request->size=='1500 Sqft - 2000 Sqft'){
                $query->where('property_size', '>=', 1500);
                $query->where('property_size', '<=', 2000);
            }
        }
        
        if ($request->budget != '') {
            
            if($request->budget=='Under 10 Lac'){
                $query->where('total_cost', '<=', 10000000);
            }elseif($request->budget=='10 Lac to 20 lac'){
                $query->where('total_cost', '>=', 1000000);
                $query->where('total_cost', '<=', 2000000);
            }elseif($request->budget=='20 Lac to 30 lac'){
                $query->where('total_cost', '>=', 2000000);
                $query->where('total_cost', '<=', 3000000);
            }elseif($request->budget=='30 Lac to 40 lac'){
                $query->where('total_cost', '>=', 3000000);
                $query->where('total_cost', '<=', 4000000);
            }elseif($request->budget=='40 Lac to 50 lac'){
                $query->where('total_cost', '>=', 4000000);
                $query->where('total_cost', '<=', 5000000);
            }elseif($request->budget=='50 Lac to 60 lac'){
                $query->where('total_cost', '>=', 5000000);
                $query->where('total_cost', '<=', 6000000);
            }elseif($request->budget=='60 Lac to 70 lac'){
                $query->where('total_cost', '>=', 6000000);
                $query->where('total_cost', '<=', 7000000);
            }elseif($request->budget=='70 Lac to 80 lac'){
                $query->where('total_cost', '>=', 7000000);
                $query->where('total_cost', '<=', 8000000);
            }elseif($request->budget=='80 lac to 90 lac'){
                $query->where('total_cost', '>=', 8000000);
                $query->where('total_cost', '<=', 9000000);
            }elseif($request->budget=='90 Lac to 1 cr'){
                $query->where('total_cost', '>=', 9000000);
                $query->where('total_cost', '<=', 10000000);
            }elseif($request->budget=='1 Cr to above'){
                $query->where('total_cost', '>=', 10000000);
            }
        }
        
        if ($request->project_type != '') {
            $query->where('property_bhk', '=', $request->project_type);
        }
        
        if ($request->is_for_rent != '') {
            $query->where('is_for_rent', '=', $request->is_for_rent);
        }
        
        if ($request->possession_status != '') {
            $query->where('possession_status', '=', $request->possession_status);
        }
        
        if ($request->category != '') {
            $query->where('property_category', '=', $request->category);
        }
        
        if ($request->sub_category != '') {
            $query->where('property_sub_category', '=', $request->sub_category);
        }
        
        $properties = $query->orderByDesc('id')->paginate(100);
        $propertyCount = $query->count();
       
       
        $countAll = SellerLead::query()->where('id','!=','')->count();
        $countNew = SellerLead::query()->where('status', 'New')->count();
        $countFollowUp = SellerLead::query()->where('status', 'Follow Up')->count();
        $countCallScheduled = SellerLead::query()->where('status', 'Call Scheduled')->count();
        $countMeetingScheduled = SellerLead::query()->where('status', 'Meeting Scheduled')->count();
        $countVisits = SellerLead::query()->where('status', 'Visits')->orwhere('status', 'Re Visits')->count();
        $countCancelled = SellerLead::query()->where('status', 'Cancelled')->count();
        $countConvertToProperty = SellerLead::query()->where('status', 'Convert To Property')->count();
        $countDead = SellerLead::query()->where('status', 'Dead')->count();
        
        return view('admin.sellercrm.index', compact('countAll','countNew','countFollowUp','countCallScheduled','countMeetingScheduled','countVisits',
        'countCancelled','countConvertToProperty','countDead','fieldPersons','status','properties','propertyCount', 'roomTypes',
        'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist','ropertyBhks','ropertySaleType',
       'inventoryTypes','inventoryCategories','propertyChecklist','societies','categories','subcategories','states','cities','request'));
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
    
    public function changeSellerLeadStatus(Request $request)
    {
        $id = $request->id;
        $lead = SellerLead::findOrFail($id);
        $lead->lead_status = $request->status;
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
            
            
            $propertySubCategory = @$lead->getSellerLeadSubCategory;
            //dd($propertySubCategory);
            $propertyMappedAttribute = $propertySubCategory->getMappedSellerLeadAttribute;
            //dd($propertyMappedAttribute);
            
            
            // Create a new Property instance
            $newProperty = new Property();
            
            $newProperty->property_name = @$lead->property_name;
            $newProperty->owner_id = @$lead->owner_id;
            $newProperty->builder_id = @$lead->builder_id;
            $newProperty->society_id = @$lead->society_id;
            $newProperty->property_category = @$lead->property_category;
            $newProperty->property_sub_category = @$lead->property_sub_category;
            $newProperty->property_size = @$lead->property_size;
            $newProperty->property_bhk = @$lead->property_bhk;
            $newProperty->country_id = @$lead->country_id;
            $newProperty->state_id = @$lead->state_id;
            $newProperty->city_id = @$lead->city_id;
            $newProperty->area = @$lead->area;
            $newProperty->street = @$lead->street;
            $newProperty->pincode = @$lead->pincode;
            $newProperty->property_tags = @$lead->property_tags;
            $newProperty->rental_plan_duration = @$lead->rental_plan_duration;
            $newProperty->rent_per_month = @$lead->rent_per_month;
            $newProperty->early_closure_charges_info = @$lead->early_closure_charges_info;
            $newProperty->free_relocation_info = @$lead->free_relocation_info;
            $newProperty->free_upgrade_info = @$lead->free_upgrade_info;
            $newProperty->seven_days_free_trial = @$lead->seven_days_free_trial;
            $newProperty->floor_name = @$lead->floor_name;
            $newProperty->unit_no = @$lead->unit_no;
            $newProperty->tower_no = @$lead->tower_no;
            $newProperty->salable_area = @$lead->salable_area;
            $newProperty->base_rate = @$lead->base_rate;
            $newProperty->unit_value = @$lead->unit_value;
            $newProperty->total_cost = @$lead->total_cost;
            $newProperty->outstanding_principle = @$lead->outstanding_principle;
            $newProperty->broker_name = @$lead->broker_name;
            $newProperty->possession_status = @$lead->possession_status;
            $newProperty->registration_no = @$lead->registration_no;
            $newProperty->loan_on_property = @$lead->loan_on_property;
            $newProperty->loan_bank_name = @$lead->loan_bank_name;
            $newProperty->video_link = @$lead->video_link;
            $newProperty->status = @$lead->status;
            
            $newProperty->addby = auth()->user()->id;
            
            $newProperty->save();
            
            $property_id=$newProperty->id;
            
            
            $propertyimages = @$lead->getSellerLeadImages;
            if($propertyimages){
                foreach ($propertyimages as $item)
                {
                    $savePropertyImage = new PropertyImage();
                    $savePropertyImage->property_id = $property_id;
                    //$savePropertyImage->property_id = '11';
                    $savePropertyImage->image = $item->image;
                    $savePropertyImage->save();
                }
            }
            
            $propertyAttribute = @$lead->getSellerLeadAttributes;
            if($propertyAttribute){
                foreach ($propertyAttribute as $item)
                {
                    $savePropertyCateAttribute = new PropertyCategoryAttribute();
                    $savePropertyCateAttribute->property_id = $property_id;
                    //$savePropertyCateAttribute->property_id = '11';
                    $savePropertyCateAttribute->attribute_id = $item->attribute_id;
                    $savePropertyCateAttribute->attribute_value_id = $item->attribute_value_id;
                    $savePropertyCateAttribute->save();
                }
            }
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
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $ropertyBhks = Master::where('MasterHead', 'Property BKH')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $roomSizes = Master::where('MasterHead', 'Room Size')->first()->getMasterValues ?? [];
        $roomBathrooms = Master::where('MasterHead', 'Room Bathroom')->first()->getMasterValues ?? [];
        $roomKitchens = Master::where('MasterHead', 'Room Kitchen')->first()->getMasterValues ?? [];
        $roomBalconies = Master::where('MasterHead', 'Room Balcony')->first()->getMasterValues ?? [];

        $propertyChecklist = Master::where('MasterHead', 'Property Checklist')->first()->getMasterValues ?? [];

        $countries = Country::get();
        $owners = Owner::where('status', 1)->get();
        $builders = Builder::where('status', 1)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();

        return view('admin.sellercrm.create', compact('owners', 'builders', 'categories', 'countries', 'roomTypes',
         'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist','ropertyBhks','ropertySaleType',
        'inventoryTypes','inventoryCategories'));
    }
    
    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $saveProperty = new SellerLead();
        $saveProperty->property_name = $request->property_name;
        $saveProperty->is_for_rent = $request->is_for_rent;
        $saveProperty->owner_id = $request->owner;
        $saveProperty->builder_id = $request->builder;
        $saveProperty->society_id = $request->society;
        $saveProperty->property_category = $request->category;
        $saveProperty->property_sub_category = $request->sub_category;
        $saveProperty->property_size = $request->property_size;
        $saveProperty->property_bhk = $request->property_bhk;
        $saveProperty->country_id = $request->country;
        $saveProperty->state_id = $request->state;
        $saveProperty->city_id = $request->city;
        $saveProperty->area = $request->address;
        $saveProperty->street = $request->street;
        $saveProperty->pincode = $request->pincode;

        $saveProperty->property_tags = $request->property_tags;

        $saveProperty->rental_plan_duration = $request->rent_duration;
        $saveProperty->rent_per_month = $request->rent_amount;
        $saveProperty->early_closure_charges_info = $request->early_closure_charges_info;
        $saveProperty->free_relocation_info = $request->free_relocation_info;
        $saveProperty->free_upgrade_info = $request->free_upgrade_info;

        $saveProperty->seven_days_free_trial = $request->seven_days_free_trial;
        
        $saveProperty->floor_name = $request->floor_name;
        $saveProperty->unit_no = $request->unit_no;
        $saveProperty->tower_no = $request->tower_no;
        $saveProperty->salable_area = $request->salable_area;
        $saveProperty->base_rate = $request->base_rate;
        $saveProperty->unit_value = $request->unit_value;
        $saveProperty->total_cost = $request->total_cost;
        $saveProperty->outstanding_principle = $request->outstanding_principle;
        $saveProperty->broker_name = $request->broker_name;
        
        $saveProperty->possession_status = $request->possession_status;
        $saveProperty->registration_no = $request->registration_no;
        $saveProperty->loan_on_property = $request->loan_on_property;
        $saveProperty->loan_bank_name = $request->loan_bank_name;
        $saveProperty->video_link = $request->video_link;
        
        $saveProperty->addby = auth()->user()->id;
        
        
        $saveProperty->save();



        $property_category_attributes = $request->attributes_value;
        if($property_category_attributes!=''){
        foreach ($property_category_attributes as $attribute_key => $category_attributes) {
            $category_attributes = (object) $category_attributes;
            foreach ($category_attributes as $key => $value) {
                $savePropertyCateAttribute = new SalesLeadCategoryAttribute();
                $savePropertyCateAttribute->property_id = $saveProperty->id;
                $savePropertyCateAttribute->attribute_id = $attribute_key;
                $savePropertyCateAttribute->attribute_value_id = $value;

                $savePropertyCateAttribute->save();
            }
        }
        }

        $images = $request->photos;
        // dd($images);
        $FileName = '';
        foreach ($images as $image_key => $image) {
            $file = $image;
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/property'), $FileName);

            $savePropertyImage = new SalesLeadImage();
            $savePropertyImage->property_id = $saveProperty->id;
            $savePropertyImage->image = $FileName;
            $savePropertyImage->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Seller data has been saved.');
    }

    public function property_list(string $id)
    {
        $properties = SellerLead::where('owner_id', $id)->paginate(10);
        $propertyCount = SellerLead::where('owner_id', $id)->count();
        return view('admin.property.index', compact('properties','propertyCount'));
    }
    
    public function propertyImportdata(Request $request)
    {
        try {
            Excel::import(new PropertyImport(), $request->file('file')->store('temp'));
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $property_info = SellerLead::where('id', $id)->first();

        $propertySubCategory = $property_info->getSellerLeadSubCategory;
        // dd($propertyCategory);
        @$propertyMappedAttribute = $propertySubCategory->getMappedSellerLeadAttribute;
        // dd($propertyMappedAttribute);
        $propertyAttribute = $property_info->getSellerLeadAttributes;
        // dd($propertyAttribute);
        $propertySavedChecklist = $property_info->getSellerLeadChecklist;
        // dd($propertyChecklist);
        $propertyimages = $property_info->getSellerLeadImages;
        // dd($propertyimages);
        $propertyRooms = $property_info->getSellerLeadRooms;
        // dd($propertyRooms);

        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $ropertyBhks = Master::where('MasterHead', 'Property BKH')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $roomSizes = Master::where('MasterHead', 'Room Size')->first()->getMasterValues ?? [];
        $roomBathrooms = Master::where('MasterHead', 'Room Bathroom')->first()->getMasterValues ?? [];
        $roomKitchens = Master::where('MasterHead', 'Room Kitchen')->first()->getMasterValues ?? [];
        $roomBalconies = Master::where('MasterHead', 'Room Balcony')->first()->getMasterValues ?? [];
        $propertyChecklist = Master::where('MasterHead', 'Property Checklist')->first()->getMasterValues ?? [];

        $countries = Country::get();
        $owners = Owner::where('status', 1)->get();
        $builders = Builder::where('status', 1)->get();
        $societies = Society::where('builder_id', $property_info->builder_id)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();

        return view('admin.sellercrm.update', compact('property_info', 'propertyMappedAttribute', 'propertyAttribute',
         'propertySavedChecklist', 'propertyRooms', 'owners', 'builders', 'societies', 'categories', 'propertyimages',
          'countries', 'roomTypes', 'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist',
          'ropertyBhks','inventoryTypes','inventoryCategories','ropertySaleType'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property_id = $id;
        $saveProperty = SellerLead::find($id);
        $saveProperty->property_name = $request->property_name;
        $saveProperty->is_for_rent = $request->is_for_rent;
        $saveProperty->owner_id = $request->owner;
        $saveProperty->builder_id = $request->builder;
        $saveProperty->society_id = $request->society;
        $saveProperty->property_category = $request->category;
        $saveProperty->property_sub_category = $request->sub_category;
        $saveProperty->property_size = $request->property_size;
        $saveProperty->property_bhk = $request->property_bhk;
        $saveProperty->country_id = $request->country;
        $saveProperty->state_id = $request->state;
        $saveProperty->city_id = $request->city;
        $saveProperty->area = $request->address;
        $saveProperty->street = $request->street;
        $saveProperty->pincode = $request->pincode;

        $saveProperty->property_tags = $request->property_tags;

        $saveProperty->rental_plan_duration = $request->rent_duration;
        $saveProperty->rent_per_month = $request->rent_amount;
        $saveProperty->early_closure_charges_info = $request->early_closure_charges_info;
        $saveProperty->free_relocation_info = $request->free_relocation_info;
        $saveProperty->free_upgrade_info = $request->free_upgrade_info;

        $saveProperty->seven_days_free_trial = $request->seven_days_free_trial;
        
        $saveProperty->floor_name = $request->floor_name;
        $saveProperty->unit_no = $request->unit_no;
        $saveProperty->tower_no = $request->tower_no;
        $saveProperty->salable_area = $request->salable_area;
        $saveProperty->base_rate = $request->base_rate;
        $saveProperty->unit_value = $request->unit_value;
        $saveProperty->total_cost = $request->total_cost;
        $saveProperty->outstanding_principle = $request->outstanding_principle;
        $saveProperty->broker_name = $request->broker_name;
        
        $saveProperty->possession_status = $request->possession_status;
        $saveProperty->registration_no = $request->registration_no;
        $saveProperty->loan_on_property = $request->loan_on_property;
        $saveProperty->loan_bank_name = $request->loan_bank_name;
        $saveProperty->video_link = $request->video_link;
        
        $saveProperty->save();

      

        $property_category_attributes = $request->attributes_value;
        if($property_category_attributes!=''){
        $saveProperty->getSellerLeadAttributes()->delete();

        foreach ($property_category_attributes as $attribute_key => $category_attributes) {
            $category_attributes = (object) $category_attributes;
            foreach ($category_attributes as $key => $value) {
                $savePropertyCateAttribute = new SalesLeadCategoryAttribute();
                $savePropertyCateAttribute->property_id = $property_id;
                $savePropertyCateAttribute->attribute_id = $attribute_key;
                $savePropertyCateAttribute->attribute_value_id = $value;

                $savePropertyCateAttribute->save();
            }
        }
        }

        $images = $request->photos;
        // dd($images);

        $oldImages = $request->old;
        if (!empty($oldImages)) {
            $saveProperty
                ->getSellerLeadImages()
                ->whereNotIn('id', $oldImages)
                ->delete();
        }

        $FileName = '';
        if (!empty($images)) {
            foreach ($images as $image_key => $image) {
                $file = $image;
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/property'), $FileName);

                $savePropertyImage = new SalesLeadImage();
                $savePropertyImage->property_id = $property_id;
                $savePropertyImage->image = $FileName;
                $savePropertyImage->save();
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Seller data has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show2(string $id)
    {
        $property_info = SellerLead::where('id', $id)->first();

        $propertySubCategory = $property_info->getPropertySubCategory;
        // dd($propertyCategory);
        $propertyMappedAttribute = $propertySubCategory->getMappedPropertyAttribute;
        // dd($propertyMappedAttribute);
        $propertyAttribute = $property_info->getPropertyAttributes;
        // dd($propertyAttribute);
        $propertySavedChecklist = $property_info->getPropertyChecklist;
        // dd($propertyChecklist);
        $propertyimages = $property_info->getPropertyImages;
        // dd($propertyChecklist);
        $propertyRooms = $property_info->getPropertyRooms;
        // dd($propertyRooms);

        $inventoryCategories = InventoryCategory::where('parent_id', 0)->get();
        $inventoryTypes = Master::where('MasterHead', 'Inventory Type')->first()->getMasterValues ?? [];
        $ropertyBhks = Master::where('MasterHead', 'Property BKH')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $roomSizes = Master::where('MasterHead', 'Room Size')->first()->getMasterValues ?? [];
        $roomBathrooms = Master::where('MasterHead', 'Room Bathroom')->first()->getMasterValues ?? [];
        $roomKitchens = Master::where('MasterHead', 'Room Kitchen')->first()->getMasterValues ?? [];
        $roomBalconies = Master::where('MasterHead', 'Room Balcony')->first()->getMasterValues ?? [];
        $propertyChecklist = Master::where('MasterHead', 'Property Checklist')->first()->getMasterValues ?? [];

        $countries = Country::get();
        $owners = Owner::where('status', 1)->get();
        $builders = Builder::where('status', 1)->get();
        $societies = Society::where('builder_id', $property_info->builder_id)->get();
        $categories = PropertyCategory::where('parent_id', 0)->get();

        return view('admin.property.details', compact('property_info', 'propertyMappedAttribute', 'propertyAttribute',
         'propertySavedChecklist', 'propertyRooms', 'owners', 'builders', 'societies', 'categories', 'propertyimages',
          'countries', 'roomTypes', 'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist',
          'ropertyBhks','inventoryTypes','inventoryCategories','ropertySaleType'));
    }

    

    public function deleteRoomById(Request $request)
    {
        $room_id = $request->room_id;
        $propertyRoom = PropertyRoom::find($room_id);
        if ($propertyRoom->delete()) {
            $message = 'Room Successfully Delete.';
        } else {
            $message = 'Something try again.';
        }
        return response()->json(['status' => 'success', 'data' => $message]);
    }
    
    public function property_status($id)
    {
        $data = SellerLead::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect()
            ->back()
            ->with('success', 'Property ' . $msg . ' Successfully!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Worng try again.!');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = SellerLead::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Property has been Deleted Successfully!!');
    }
}
