<?php

namespace App\Http\Controllers\Admin\Property;

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
use App\Imports\PropertyImport;

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
use App\Models\PropertyJourney;
use App\Models\Addon;

class PropertyControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
        //return $request->project_type;
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
        
        $states = State::where('country_id', '229')->get();
        $cities = City::where('state_id', $request->state)->get();
       
        $query = Property::query();
        
        if ($request->searchtext != '') {
            $query->where('property_name', 'like', '%'.$request->searchtext.'%');
        }

        if ($request->parent_id != '') {
            $query->where('parent_id', '=', $request->parent_id);
        }
        
        if ($request->category != '') {
            $query->where('property_category', '=', $request->category);
        }
        
        if ($request->sub_category != '') {
            $query->where('property_sub_category', '=', $request->sub_category);
        }
        
        $propertyCount = $query->count();
        $properties = $query->paginate(10);

        $services = Property::where('parent_id', 0)->get();
   
        
        return view('admin.property.index', compact('properties','propertyCount','categories','subcategories','services','request',
    'roomTypes','roomSizes','roomBathrooms','roomKitchens','roomBalconies'));
    }

    public function property_list_filter(Request $request)
    {
        //return $request->project_type;
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
        
        $states = State::where('country_id', '229')->get();
        $cities = City::where('state_id', $request->state)->get();
       
        $query = Property::query();
        
        if (auth()->user()->is_admin != '1') {
            $query->where('addby', '=', auth()->user()->id);
        }
        
        if ($request->project != '') {
            $query->where('society_id', '=', $request->project);
        }
        
        if ($request->state != '') {
            $query->where('state_id', '=', $request->state);
        }
        
        if ($request->city != '') {
            $query->where('city_id', '=', $request->city);
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
        
        $properties = $query->paginate(10);
        $propertyCount = $query->count();
   
        
        return view('admin.property.index', compact('properties','propertyCount', 'roomTypes',
        'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist','ropertyBhks','ropertySaleType',
       'inventoryTypes','inventoryCategories','propertyChecklist','societies','categories','subcategories','states','cities','request'));
    }

    public function property_list(string $id)
    {
        $properties = Property::where('owner_id', $id)->paginate(10);
        $propertyCount = Property::where('owner_id', $id)->count();
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PropertyCategory::where('parent_id', 0)->where('is_condition', '0')->get();
        $conditions = PropertyCategory::where('is_condition', '1')->get();
        $services = Property::where('parent_id', 0)->get();
        $addons = Addon::where('id','!=', 0)->get();

        return view('admin.property.create', compact('categories', 'conditions', 'services','addons'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $saveProperty = new Property();
        $saveProperty->parent_id = $request->parent_id;
        //$saveProperty->skin_condition = $request->skin_condition;
        //$saveProperty->skin_sub_condition = $request->skin_sub_condition;
        //$saveProperty->property_category = $request->category;
        //$saveProperty->property_sub_category = $request->sub_category;
        
        $saveProperty->skin_condition = json_encode($request->skin_condition); // Convert array to JSON
        $saveProperty->skin_sub_condition = json_encode($request->skin_sub_condition); // Convert array to JSON
        $saveProperty->property_category = json_encode($request->category); // Convert array to JSON
        $saveProperty->property_sub_category = json_encode($request->sub_category); // Convert array to JSON
        
        $saveProperty->property_name = $request->property_name;
        $saveProperty->description = $request->description;
        $saveProperty->duration = $request->duration;
        $saveProperty->number_of_members_required = $request->number_of_members_required;
        $saveProperty->max_quantity_allowed = $request->max_quantity_allowed;
        $saveProperty->session1 = $request->session1;
        $saveProperty->price = $request->price ?? 0.00;
        $saveProperty->discounted_price = $request->discounted_price ?? 0.00;
        $saveProperty->session2 = $request->session2;
        $saveProperty->price2 = $request->price2 ?? 0.00;
        $saveProperty->discounted_price2 = $request->discounted_price2 ?? 0.00;
        $saveProperty->session3 = $request->session3;
        $saveProperty->price3 = $request->price3 ?? 0.00;
        $saveProperty->discounted_price3 = $request->discounted_price3 ?? 0.00;
        $saveProperty->session4 = $request->session4;
        $saveProperty->price4 = $request->price4 ?? 0.00;
        $saveProperty->discounted_price4 = $request->discounted_price4 ?? 0.00;
        $saveProperty->long_description = $request->long_description;
        $saveProperty->addon_ids = is_array($request->addon_id) ? implode(',', $request->addon_id) : $request->addon_id;
        
        $saveProperty->addby = auth()->user()->id;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/property'), $FileName);
            $saveProperty->profile = $FileName;
        }
        
        if ($request->hasFile('offer_image')) {
            $file = $request->file('offer_image');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/property'), $FileName);
            $saveProperty->offer_image = $FileName;
        }
        
        $saveProperty->save();

        $images = $request->photos;
        // dd($images);
        if (!empty($images)) {
        $FileName = '';
        foreach ($images as $image_key => $image) {
            $file = $image;
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/property'), $FileName);

            $savePropertyImage = new PropertyImage();
            $savePropertyImage->property_id = $saveProperty->id;
            $savePropertyImage->image = $FileName;
            $savePropertyImage->save();
        }
        }

        return redirect()
            ->back()
            ->with('success', 'Property has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $property_info = Property::where('id', $id)->first();

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
        
        if(auth()->user()->is_admin=='1'){
            $propertyjourneys = PropertyJourney::where('property_id', $property_info->id)->get();
        }else{
            $propertyjourneys = PropertyJourney::where('property_id', $property_info->id)->where('addby', auth()->user()->id)->get();
        }

        return view('admin.property.details', compact('property_info', 'propertyMappedAttribute', 'propertyAttribute',
         'propertySavedChecklist', 'propertyRooms', 'owners', 'builders', 'societies', 'categories', 'propertyimages',
          'countries', 'roomTypes', 'roomSizes', 'roomBathrooms', 'roomKitchens', 'roomBalconies', 'propertyChecklist',
          'ropertyBhks','inventoryTypes','inventoryCategories','ropertySaleType','propertyjourneys'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $property_info = Property::where('id', $id)->first();
        $propertyimages = $property_info->getPropertyImages;

        $categories = PropertyCategory::where('parent_id', 0)->where('is_condition', '0')->get();
        $conditions = PropertyCategory::where('is_condition', '1')->get();
        $services = Property::where('parent_id', 0)->where('id','!=', $id)->get();
        $addons = Addon::where('id','!=', 0)->get();
        
        return view('admin.property.update', compact('property_info', 'services','categories', 'conditions', 'addons', 'propertyimages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $property_id = $id;
        $saveProperty = Property::find($id);
        $saveProperty->parent_id = $request->parent_id;
        
        $saveProperty->skin_condition = json_encode($request->skin_condition); // Convert array to JSON
        $saveProperty->skin_sub_condition = json_encode($request->skin_sub_condition); // Convert array to JSON
        $saveProperty->property_category = json_encode($request->category); // Convert array to JSON
        $saveProperty->property_sub_category = json_encode($request->sub_category); // Convert array to JSON
        
        $saveProperty->property_name = $request->property_name;
        $saveProperty->description = $request->description;
        $saveProperty->duration = $request->duration;
        $saveProperty->number_of_members_required = $request->number_of_members_required;
        $saveProperty->max_quantity_allowed = $request->max_quantity_allowed;
        $saveProperty->session1 = $request->session1;
        $saveProperty->price = $request->price ?? 0.00;
        $saveProperty->discounted_price = $request->discounted_price ?? 0.00;
        $saveProperty->session2 = $request->session2;
        $saveProperty->price2 = $request->price2 ?? 0.00;
        $saveProperty->discounted_price2 = $request->discounted_price2 ?? 0.00;
        $saveProperty->session3 = $request->session3;
        $saveProperty->price3 = $request->price3 ?? 0.00;
        $saveProperty->discounted_price3 = $request->discounted_price3 ?? 0.00;
        $saveProperty->session4 = $request->session4;
        $saveProperty->price4 = $request->price4 ?? 0.00;
        $saveProperty->discounted_price4 = $request->discounted_price4 ?? 0.00;
        $saveProperty->long_description = $request->long_description;
        $saveProperty->addon_ids = is_array($request->addon_id) ? implode(',', $request->addon_id) : $request->addon_id;
        
        $saveProperty->addby = auth()->user()->id;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/property'), $FileName);
            $saveProperty->profile = $FileName;
        }
        
        if ($request->hasFile('offer_image')) {
            $file = $request->file('offer_image');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/property'), $FileName);
            $saveProperty->offer_image = $FileName;
        }
        
        $saveProperty->save();

       

        $images = $request->photos;
        // dd($images);

        $oldImages = $request->old;
        if (!empty($oldImages)) {
            $saveProperty
                ->getPropertyImages()
                ->whereNotIn('id', $oldImages)
                ->delete();
        }

        $FileName = '';
        if (!empty($images)) {
            foreach ($images as $image_key => $image) {
                $file = $image;
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/property'), $FileName);

                $savePropertyImage = new PropertyImage();
                $savePropertyImage->property_id = $property_id;
                $savePropertyImage->image = $FileName;
                $savePropertyImage->save();
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Property has been saved.');
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
        $data = Property::find($id);
        
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
     
    public function property_offer_status($id)
    {
        $data = Property::find($id);
        
        if ($data->offer_status == 1) {
            $data->offer_status = 0;
            $msg = 'Offer Desabled';
        } else {
            $data->offer_status = 1;
            $msg = 'offer Enabled';
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
       
    public function update_property_price(Request $request)
    {
        $id=$request->price_pro_id;
        $data = Property::find($id);
        
            $savePropertyJourney = new PropertyJourney();
            $savePropertyJourney->property_id = $id;
            $savePropertyJourney->old_base_rate =$data->base_rate;
            $savePropertyJourney->old_unit_value = $data->unit_value;
            $savePropertyJourney->old_total_cost = $data->total_cost;
            $savePropertyJourney->base_rate =$request->base_rate;
            $savePropertyJourney->unit_value = $request->unit_value;
            $savePropertyJourney->total_cost = $request->total_cost;
            $savePropertyJourney->addby = auth()->user()->id;
            $savePropertyJourney->save();
            
        $data->base_rate = $request->base_rate;
        $data->unit_value = $request->unit_value;
        $data->total_cost = $request->total_cost;
        
        if ($data->save()) {
            
            return redirect()
            ->back()
            ->with('success', 'Price updated Successfully!');
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
        $property = Property::findOrFail($id);
        $property->delete();
        return redirect()
            ->back()
            ->with('success', 'Property has been Deleted Successfully!!');
    }
}
