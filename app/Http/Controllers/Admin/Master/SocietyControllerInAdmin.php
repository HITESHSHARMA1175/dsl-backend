<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Builder;
use App\Models\Society;
use App\Models\SocietyOption;
use App\Models\PropertyCategory;
use App\Models\Property;

class SocietyControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Society::query();
        if ($request->search_text != '') {
            $query->where(function ($query) use ($request) {
                $query->where("society_name","like",'%'.$request->search_text.'%');
            });
        }
        if ($request->builder != '') {
            $query->where(function ($query) use ($request) {
                $query->where("builder_id","like",'%'.$request->builder.'%');
            });
        }
        
        $societies = $query->orderByDesc('id')->paginate(10);
        $societiesCount = $query->count();
        
        $builders = Builder::where("status","=","1")->get();
        
        
        //$societies = Society::orderByDesc('id')->paginate(10);
        //$societies = Society::get();
        return view('admin.society.index', compact('societies','societiesCount','builders','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $builders = Builder::get();
        $countries = Country::get();
        return view('admin.society.create', compact('countries', 'builders', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'builder' => 'required',
            'society_name' => 'required',
            //'address' => 'required|string:500',
            //'country' => 'required',
            //'state' => 'required',
            //'pincode' => 'required',
            //'category' => 'required',
            //'sub_category' => 'required',
            //'project_area' => 'required',
            //'total_tower' => 'required',
            //'total_floor' => 'required',
            //'total_no_of_unit' => 'required',
            'profile' => 'sometimes|file|max:2048|mimes:jpg,png,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validate);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }
        $save = new Society();
        $save->builder_id = $request->builder;
        $save->society_name = $request->society_name;
        // $save->email = $request->email;
        // $save->mobile_no = $request->mobile_no;
        $save->address = $request->address;
        $save->country_id = $request->country;
        $save->state_id = $request->state;
        $save->city_id = $request->city;
        $save->pincode = $request->pincode;
        $FileName = '';
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->profile = $FileName;
        }
        
        $save->category = $request->category;
        $save->sub_category = $request->sub_category;
        $save->project_area = $request->project_area;
        $save->total_tower = $request->total_tower;
        $save->total_floor = $request->total_floor;
        $save->total_no_of_unit = $request->total_no_of_unit;
        if ($request->hasFile('upload_master_plan')) {
            $file = $request->file('upload_master_plan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_master_plan = $FileName;
        }
        if ($request->hasFile('upload_payment_plan')) {
            $file = $request->file('upload_payment_plan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_payment_plan = $FileName;
        }
        if ($request->hasFile('upload_price_list')) {
            $file = $request->file('upload_price_list');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_price_list = $FileName;
        }
        $save->possession_status = $request->possession_status;
        
        $save->addby = auth()->user()->id;
        $save->save();
        
        
        $id=$save->id;
        
        if ($request->has('project_multiple_bhk')) {
            foreach ($request->project_multiple_bhk as $key => $value) {
                if (!empty($value)) {
                    $saveref = new SocietyOption();
                    $saveref->project_id = $id;
                    $saveref->project_multiple_bhk = $value; // Use $value directly from the loop
                    $saveref->project_multiple_area = $request->project_multiple_area[$key] ?? null; // Use null coalescing operator to handle potential undefined index
        
                    if ($request->hasFile('upload_multiple_layout') && is_array($request->file('upload_multiple_layout')) && array_key_exists($key, $request->file('upload_multiple_layout'))) {
                        $file = $request->file('upload_multiple_layout')[$key];
                        $fileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/userimage'), $fileName);
                        $saveref->upload_multiple_layout = $fileName;
                    }
        
                    $saveref->addby = auth()->user()->id;
                    $saveref->save();
                }
            }
        }
        
        if ($id) {
            return redirect(route('society.create'))->with('success', 'Project Has been Created Successfuly!');
        }
        return redirect(route('society.create'))->with('error', 'Something Wrong try Again!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $properties = Property::where('society_id', $id)->paginate(10);
        //$properties = Property::paginate(10);
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $countries = Country::get();
        $builders = Builder::get();
        $society = Society::find($id);
        return view('admin.society.details', compact('society', 'countries', 'builders', 'categories','properties'));
    }

    /**
     * Display the specified resource.
     */
    public function share_project($id)
    {
        $id=base64_decode($id);
        //$properties = Property::where('society_id', $id)->where('addby', auth()->user()->id)->paginate(10);
        $properties = Property::where('society_id', $id)->paginate(10);
        //$properties = Property::paginate(10);
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $countries = Country::get();
        $builders = Builder::get();
        $society = Society::find($id);
        return view('admin.society.sharedetails', compact('society', 'countries', 'builders', 'categories','properties'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = PropertyCategory::where('parent_id', 0)->get();
        $countries = Country::get();
        $builders = Builder::get();
        $society = Society::find($id);
        return view('admin.society.update', compact('society', 'countries', 'builders', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $rules = [
            'builder' => 'required',
            'society_name' => 'required',
            //'address' => 'required|string:500',
            //'country' => 'required',
            //'state' => 'required',
            //'pincode' => 'required',
            //'category' => 'required',
            //'sub_category' => 'required',
            //'project_area' => 'required',
            //'total_tower' => 'required',
            //'total_floor' => 'required',
            //'total_no_of_unit' => 'required',
            'profile' => 'sometimes|file|max:2048|mimes:jpg,png,jpeg',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validate);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }
        $save = Society::find($id);
        if (!empty($request->builder)) {
            $save->builder_id = $request->builder;
        }
        if (!empty($request->society_name)) {
            $save->society_name = $request->society_name;
        }
        if (!empty($request->email)) {
            $save->email = $request->email;
        }
        if (!empty($request->mobile_no)) {
            $save->mobile_no = $request->mobile_no;
        }
        if (!empty($request->address)) {
            $save->address = $request->address;
        }
        if (!empty($request->country)) {
            $save->country_id = $request->country;
        }
        if (!empty($request->state)) {
            $save->state_id = $request->state;
        }
        if (!empty($request->city)) {
            $save->city_id = $request->city;
        }
        if (!empty($request->pincode)) {
            $save->pincode = $request->pincode;
        }
        $FileName = '';
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->profile = $FileName;
        }
        
        $save->category = $request->category;
        $save->sub_category = $request->sub_category;
        $save->project_area = $request->project_area;
        $save->total_tower = $request->total_tower;
        $save->total_floor = $request->total_floor;
        $save->total_no_of_unit = $request->total_no_of_unit;
        if ($request->hasFile('upload_master_plan')) {
            $file = $request->file('upload_master_plan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_master_plan = $FileName;
        }
        if ($request->hasFile('upload_payment_plan')) {
            $file = $request->file('upload_payment_plan');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_payment_plan = $FileName;
        }
        if ($request->hasFile('upload_price_list')) {
            $file = $request->file('upload_price_list');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $save->upload_price_list = $FileName;
        }
        $save->possession_status = $request->possession_status;
        
        $save->save();
        
        
        SocietyOption::where('project_id',$id)->delete();
        if ($request->has('project_multiple_bhk')) {
            foreach ($request->project_multiple_bhk as $key => $value) {
                if (!empty($value)) {
                    $saveref = new SocietyOption();
                    $saveref->project_id = $id;
                    $saveref->project_multiple_bhk = $value; // Use $value directly from the loop
                    $saveref->project_multiple_area = $request->project_multiple_area[$key] ?? null; // Use null coalescing operator to handle potential undefined index
                    $saveref->upload_multiple_layout = $request->upload_multiple_layout_name[$key] ?? null; // Use null coalescing operator to handle potential undefined index
        
                    if ($request->hasFile('upload_multiple_layout') && is_array($request->file('upload_multiple_layout')) && array_key_exists($key, $request->file('upload_multiple_layout'))) {
                        $file = $request->file('upload_multiple_layout')[$key];
                        $fileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                        $path = $file->move(public_path('uploads/userimage'), $fileName);
                        $saveref->upload_multiple_layout = $fileName;
                    }
        
                    $saveref->addby = auth()->user()->id;
                    $saveref->save();
                }
            }
        }


        if ($id) {
            return redirect()
                ->back()
                ->with('success', 'Project Has been Saved Successfuly!');
        }
        return redirect()
            ->back()
            ->with('error', 'Something Wrong try Again!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $society = Society::findOrFail($id);
        
        $society->delete();
        return redirect()
            ->back()
            ->with('success', 'Project has been Deleted Successfully!!');
    }
}
