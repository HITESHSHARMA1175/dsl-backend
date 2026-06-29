<?php

namespace App\Http\Controllers\Admin\Owner;
 
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
use App\Imports\OwnersImport;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\Owner;
use App\Models\Property;
use App\Models\Tenant;


class OwnerControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $owners = Owner::paginate(10);
        $ownersCount = Owner::count();
        return view('admin.owner.index', compact('owners','ownersCount'));
    }

    public function ownersImportdata(Request $request)
    {
        try {
            Excel::import(new OwnersImport(), $request->file('file')->store('temp'));
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
        return view('admin.owner.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'first_name' => 'required',
            //'email' => 'required|email|unique:users,email|unique:tenants,email',
            'mobile_no' => 'required|unique:users,mobile_no|unique:tenants,mobile_no',
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

        $addOwner = new Owner();
        $addOwner->first_name = $request->first_name;
        $addOwner->last_name = $request->last_name;
        $addOwner->gender = $request->gender;
        $addOwner->email = $request->email;
        $addOwner->mobile_no = $request->mobile_no;
        $addOwner->relative_name = $request->relative_name;
        $addOwner->per_address = $request->per_address;
        $addOwner->pan_card_no = $request->pan_card_no;
        $addOwner->aadhar_card_no = $request->aadhar_card_no;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->profile = $FileName;
        }

        if ($request->hasFile('pan_card_upload')) {
            $file = $request->file('pan_card_upload');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->pan_card_upload = $FileName;
        }

        if ($request->hasFile('aadhar_card_upload')) {
            $file = $request->file('aadhar_card_upload');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->aadhar_card_upload = $FileName;
        }
        
        $addOwner->addby = auth()->user()->id;

        $addOwner->save();
        return redirect(route('owner.create'))->with('success', 'Owner Has been Created Successfuly.');
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
        $owner = Owner::find($id);
        $countries = Country::get();
        $states = State::where('country_id', $owner->country)->get();
        $cites = City::where('state_id', $owner->state)->get();
        return view('admin.owner.update', compact('owner', 'countries', 'states', 'cites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'email' => 'nullable|email|unique:users,email|unique:tenants,email|unique:owners,email,' . $id,
            'mobile_no' => 'nullable|unique:users,mobile_no|unique:tenants,email|unique:owners,email,' . $id,
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

        $addOwner = Owner::find($id);
        if (!empty($request->first_name)) {
            $addOwner->first_name = $request->first_name;
        }
        if (!empty($request->last_name)) {
            $addOwner->last_name = $request->last_name;
        }
        if (!empty($request->email)) {
            $addOwner->email = $request->email;
        }
        if (!empty($request->mobile_no)) {
            $addOwner->mobile_no = $request->mobile_no;
        }
        if (!empty($request->gender)) {
            $addOwner->gender = $request->gender;
        }

        $addOwner->relative_name = $request->relative_name;
        $addOwner->per_address = $request->per_address;
        $addOwner->pan_card_no = $request->pan_card_no;
        $addOwner->aadhar_card_no = $request->aadhar_card_no;

        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->profile = $FileName;
        }

        if ($request->hasFile('pan_card_upload')) {
            $file = $request->file('pan_card_upload');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->pan_card_upload = $FileName;
        }

        if ($request->hasFile('aadhar_card_upload')) {
            $file = $request->file('aadhar_card_upload');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/userimage'), $FileName);
            $addOwner->aadhar_card_upload = $FileName;
        }


        $addOwner->save();

        return redirect()
            ->back()
            ->with('success', 'Owner Has been Updated Successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    public function owner_status($id)
    {
        $data = Owner::find($id);

        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('owner.index'))->with('success', 'Owner ' . $msg . ' Successfully!');
        }
        return redirect(route('owner.index'))->with('error', 'Something Worng try again.!');
    }

    public function pan_card_status($id)
    {
        $data = Owner::find($id);

        if ($data->pan_card_status == 1) {
            $data->pan_card_status = 0;
            $msg = 'Rejected';
        } else {
            $data->pan_card_status = 1;
            $msg = 'Approved';
        }
        if ($data->save()) {
            return redirect(route('owner.index'))->with('success', 'Owner Pan card ' . $msg . ' Successfully!');
        }
        return redirect(route('owner.index'))->with('error', 'Something Worng try again.!');
    }

    public function aadhar_card_status($id)
    {
        $data = Owner::find($id);

        if ($data->aadhar_card_status == 1) {
            $data->aadhar_card_status = 0;
            $msg = 'Rejected';
        } else {
            $data->aadhar_card_status = 1;
            $msg = 'Approved';
        }
        if ($data->save()) {
            return redirect(route('owner.index'))->with('success', 'Owner Aadhar Card ' . $msg . ' Successfully!');
        }
        return redirect(route('owner.index'))->with('error', 'Something Worng try again.!');
    }

    


}
