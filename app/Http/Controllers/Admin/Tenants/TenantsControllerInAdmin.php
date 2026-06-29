<?php

namespace App\Http\Controllers\Admin\Tenants;

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
use App\Imports\TenantsImport;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Tenant;
use App\Models\TenantMemberDetail;

class TenantsControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenantsCount = Tenant::count();
        $tenants = Tenant::paginate(10);
        return view('admin.tenants.index', compact('tenants','tenantsCount'));
    }

    public function tenantsImportdata(Request $request)
    {
        try {
            Excel::import(new TenantsImport(), $request->file('file')->store('temp'));
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
        $countries = Country::get();
        return view('admin.tenants.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            //'last_name' => 'required',
            'email' => 'required|email|unique:users,email|unique:tenants,email',
            'mobile_no' => 'required|unique:users,mobile_no|unique:tenants,mobile_no',
            'gender' => 'required',
            'dob' => 'required',
            'date_of_joining' => 'required',
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
            'upload_aadhaar' => 'required|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'upload_pan' => 'required|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'police_verification' => 'required|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'cancel_cheque' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',

            // 'account_name' => 'required',
            // 'account_no' => 'required',
            // 'bank_name' => 'required',
            // 'ifsc' => 'required',
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

        $addTenant = new Tenant();
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

        // $addTenant->password = $request->password;

        $addTenant->date_of_joining = !empty($request->date_of_joining) ? date('Y-m-d', strtotime($request->date_of_joining)) : '';
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

        $members = $request->member;
        // dd($members);
        if(!empty($members)){
        foreach ($members as $key => $value) {
            if($value['relation']!=''){
            $addMember = new TenantMemberDetail();
            $addMember->tenant_id = $addTenant->id;
            $addMember->relation = $value['relation'];
            $addMember->name = $value['name'];
            $addMember->mobile_no = $value['mobile'];
            $addMember->gender = $value['gender'];
            $addMember->save(); 
            }
        }
        }

        $addTenant->save();
        return redirect(route('tenants.create'))->with('success', 'Tenant Has been Created Successfuly.');
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
        $tenant = Tenant::find($id);
        $tenantMembers = $tenant->getMembersDetail;
        //$tenantMembers=[];
        $countries = Country::get();
        $states = State::where('country_id', $tenant->country)->get();
        $cites = City::where('state_id', $tenant->state)->get();
        return view('admin.tenants.update', compact('tenant', 'countries', 'states', 'cites', 'tenantMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'nullable|email|unique:users,email|unique:tenants,email,' . $id,
            'mobile_no' => 'nullable|unique:users,mobile_no|unique:tenants,mobile_no,' . $id,
            'upload_aadhaar' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'upload_pan' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'police_verification' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
            'cancel_cheque' => 'nullable|file|max:2048|mimes:jpg,png,jpeg,pdf',
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

        $addTenant = Tenant::find($id);
        if (!empty($request->first_name)) {
            $addTenant->first_name = $request->first_name;
        }
        if (!empty($request->last_name)) {
            $addTenant->last_name = $request->last_name;
        }
        if (!empty($request->email)) {
            $addTenant->email = $request->email;
        }
        if (!empty($request->mobile_no)) {
            $addTenant->mobile_no = $request->mobile_no;
        }
        if (!empty($request->gender)) {
            $addTenant->gender = $request->gender;
        }
        if (!empty($request->dob)) {
            $addTenant->dob = !empty($request->dob) ? date('Y-m-d', strtotime($request->dob)) : '';
        }

        if (!empty($request->address)) {
            $addTenant->address = $request->address;
        }
        if (!empty($request->country)) {
            $addTenant->country = $request->country;
        }
        if (!empty($request->state)) {
            $addTenant->state = $request->state;
        }
        if (!empty($request->city)) {
            $addTenant->city = $request->city;
        }
        if (!empty($request->pincode)) {
            $addTenant->pincode = $request->pincode;
        }

        // $addTenant->password = $request->password;

        $addTenant->date_of_joining = !empty($request->date_of_joining) ? date('Y-m-d', strtotime($request->date_of_joining)) : '';
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

        $members = $request->member;
        // dd($members);
        if(!empty($members)){
        foreach ($members as $key => $value) {
            if($value['relation']!=''){
            $addMember = new TenantMemberDetail();
            $addMember->tenant_id = $addTenant->id;
            $addMember->relation = $value['relation'];
            $addMember->name = $value['name'];
            $addMember->mobile_no = $value['mobile'];
            $addMember->gender = $value['gender'];
            $addMember->save(); 
            }
        }
        }
        return redirect()
            ->back()
            ->with('success', 'Tenant Has been Updated Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->delete();
        return redirect()
            ->back()
            ->with('success', 'Tenant has been Deleted Successfully!!');
    }
}
