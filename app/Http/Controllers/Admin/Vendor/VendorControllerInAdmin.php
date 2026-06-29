<?php

namespace App\Http\Controllers\Admin\Vendor;

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
use App\Models\User;
use App\Models\Vendor;
use App\Models\Master;
use App\Models\MasterValue;

class VendorControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::get();
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $work_category_id = Master::where('MasterHead', 'Work Category')
            ->pluck('id')
            ->first();
        $work_category = MasterValue::where('MasterHead', $work_category_id)->get();
        $sub_work_category_id = Master::where('MasterHead', 'Sub Work Category')
            ->pluck('id')
            ->first();
        $sub_work_category = MasterValue::where('MasterHead', $sub_work_category_id)->get();
        $countries = Country::get();
        return view('admin.vendor.create', compact('countries', 'work_category', 'sub_work_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email|unique:tenants,email',
            'mobile_no' => 'required|unique:users,mobile_no|unique:tenants,mobile_no',
            'gender' => 'required',
            'dob' => 'required',

            // 'date_of_joining' => 'required',
            // 'password' => 'required',
            // 'user_status' => 'required',

            'address' => 'required|string:500',
            'country' => 'required',
            'state' => 'required',
            // 'city' => 'required',
            'pincode' => 'required',

            // 'profile' => 'required|file|max:2048|mimes:jpg,png,jpeg',
            'aadhaar_no' => 'required',
            'pan_no' => 'required',

            'upload_aadhaar' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'upload_pan' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'police_verification' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',

            'work_category' => 'required',
            'work_sub_category' => 'required',
            'work_area' => 'required',
            'agreement' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // dd($validator);
            // session()->flash('upload_aadhaar', $request->file('upload_aadhaar')->getClientOriginalName());
            // session()->flash('upload_pan', $request->file('upload_pan')->getClientOriginalName());
            // session()->flash('police_verification', $request->file('police_verification')->getClientOriginalName());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Validation Error.')
                ->withErrors($validator);
        }

        $addTenant = new Vendor();
        $addTenant->first_name = $request->first_name;
        $addTenant->last_name = $request->last_name;
        $addTenant->email = $request->email;
        $addTenant->mobile_no = $request->mobile_no;
        $addTenant->gender = $request->gender;
        $addTenant->dob = !empty($request->dob) ? date('Y-m-d', strtotime($request->dob)) : '';

        $addTenant->address = $request->address;
        $addTenant->country = $request->country;
        $addTenant->state = $request->state;
        $addTenant->city = $request->city;
        $addTenant->pincode = $request->pincode;

        $addTenant->work_category = $request->work_category;
        $addTenant->work_sub_category = $request->work_sub_category;
        $addTenant->work_area = $request->work_area;
        $addTenant->agreement = $request->agreement;

        // $addTenant->password = $request->password;

        // $addTenant->date_of_joining = !empty($request->date_of_joining) ? date('Y-m-d', strtotime($request->date_of_joining)) : '';
        $addTenant->aadhar_number = $request->aadhaar_no;
        $addTenant->pan_number = $request->pan_no;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addTenant->profile = $FileName;
        }

        if ($request->hasFile('upload_aadhaar')) {
            $Afile = $request->file('upload_aadhaar');
            $AFileName = 'AADHAAR' . rand(11, 99) . Str::random(15) . '.' . $Afile->getClientOriginalExtension();
            $Afile->move(public_path('uploads/users_document'), $AFileName);
            $addTenant->upload_aadhaar = $AFileName;
        }
        if ($request->hasFile('upload_pan')) {
            $Pfile = $request->file('upload_pan');
            $PFileName = 'PANCARD' . rand(11, 99) . Str::random(15) . '.' . $Pfile->getClientOriginalExtension();
            $Pfile->move(public_path('uploads/users_document'), $PFileName);
            $addTenant->upload_pan = $PFileName;
        }
        if ($request->hasFile('police_verification')) {
            $PVfile = $request->file('police_verification');
            $PVFileName = 'POLICEVERIFICATION' . rand(11, 99) . Str::random(15) . '.' . $PVfile->getClientOriginalExtension();
            $PVfile->move(public_path('uploads/users_document'), $PVFileName);
            $addTenant->police_verification = $PVFileName;
        }

        $addTenant->save();
        return redirect(route('vendors.create'))->with('success', 'Vendor Has been Created Successfuly.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
