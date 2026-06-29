<?php

namespace App\Http\Controllers\Admin\Clinic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;


use App\Models\Property;
use App\Models\Clinic;
use App\Models\Master;
use App\Models\MasterValue;


class ClinicControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Clinic::query();
        
        if ($request->searchtext != '') {
            $query->where('clinic_name', 'like', '%'.$request->searchtext.'%');
        }

        $clinics = $query->paginate(10);
        $clinicCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        $cliniccats = Master::where('MasterHead', 'Clinic Category')->first()->getMasterValues ?? [];
        
        return view('admin.clinic.index', compact('clinics','clinicCount', 'services','cliniccats','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $services = Property::where('parent_id', 0)->get();
        $cliniccats = Master::where('MasterHead', 'Clinic Category')->first()->getMasterValues ?? [];

        return view('admin.clinic.create', compact('services','cliniccats'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $saveClinic = new Clinic();
        $saveClinic->clinic_name = $request->clinic_name;
        
        $saveClinic->clinic_email = $request->clinic_email;
        $saveClinic->clinic_phone = $request->clinic_phone;
        $saveClinic->clinic_whatsapp = $request->clinic_whatsapp;
        $saveClinic->clinic_alt_phone = $request->clinic_alt_phone;
        $saveClinic->clinic_website = $request->clinic_website;
        $saveClinic->clinic_timezone = $request->clinic_timezone;
        $saveClinic->address = $request->address;
        
        $saveClinic->google_map = $request->google_map;
        $saveClinic->metro_name = $request->metro_name;
        $saveClinic->metro_text = $request->metro_text;
        $saveClinic->railway_name = $request->railway_name;
        $saveClinic->railway_text = $request->railway_text;
        
        $saveClinic->mon_to_fry = $request->mon_to_fry;
        $saveClinic->clinic_start_time = $request->clinic_start_time;
        $saveClinic->clinic_close_time = $request->clinic_close_time;
        
        $saveClinic->sat = $request->sat;
        $saveClinic->sat_start_time = $request->sat_start_time;
        $saveClinic->sat_close_time = $request->sat_close_time;
        
        $saveClinic->sun = $request->sun;
        $saveClinic->sun_start_time = $request->sun_start_time;
        $saveClinic->sun_close_time = $request->sun_close_time;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/clinic'), $FileName);
            $saveClinic->profile = $FileName;
        }
       
        $saveClinic->addby = auth()->user()->id;
        
        $saveClinic->save();

      

        return redirect()
            ->back()
            ->with('success', 'Clinic has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clinic_info = Clinic::where('id', $id)->first();

        return view('admin.clinic.details', compact('clinic_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $clinic_info = Clinic::where('id', $id)->first();

        $services = Property::where('parent_id', 0)->get();
        $cliniccats = Master::where('MasterHead', 'Clinic Category')->first()->getMasterValues ?? [];
        
        return view('admin.clinic.update', compact('clinic_info', 'services', 'cliniccats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $clinic_id = $id;
        $saveClinic = Clinic::find($id);
        $saveClinic->clinic_name = $request->clinic_name;
        $saveClinic->clinic_email = $request->clinic_email;
        $saveClinic->clinic_phone = $request->clinic_phone;
        $saveClinic->clinic_whatsapp = $request->clinic_whatsapp;
        $saveClinic->clinic_alt_phone = $request->clinic_alt_phone;
        $saveClinic->clinic_website = $request->clinic_website;
        $saveClinic->clinic_timezone = $request->clinic_timezone;
        $saveClinic->address = $request->address;
        
        $saveClinic->google_map = $request->google_map;
        $saveClinic->metro_name = $request->metro_name;
        $saveClinic->metro_text = $request->metro_text;
        $saveClinic->railway_name = $request->railway_name;
        $saveClinic->railway_text = $request->railway_text;
        
        $saveClinic->mon_to_fry = $request->mon_to_fry;
        $saveClinic->clinic_start_time = $request->clinic_start_time;
        $saveClinic->clinic_close_time = $request->clinic_close_time;
        
        $saveClinic->sat = $request->sat;
        $saveClinic->sat_start_time = $request->sat_start_time;
        $saveClinic->sat_close_time = $request->sat_close_time;
        
        $saveClinic->sun = $request->sun;
        $saveClinic->sun_start_time = $request->sun_start_time;
        $saveClinic->sun_close_time = $request->sun_close_time;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/clinic'), $FileName);
            $saveClinic->profile = $FileName;
        }
        
        $saveClinic->addby = auth()->user()->id;
        
        $saveClinic->save();



        return redirect()
            ->back()
            ->with('success', 'Clinic has been saved.');
    }

    
    public function clinic_status($id)
    {
        $data = Clinic::find($id);
        
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
            ->with('success', 'Clinic ' . $msg . ' Successfully!');
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
        $clinic = Clinic::findOrFail($id);
        $clinic->delete();
        return redirect()
            ->back()
            ->with('success', 'Clinic has been Deleted Successfully!!');
    }
}
