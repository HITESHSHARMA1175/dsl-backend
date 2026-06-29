<?php

namespace App\Http\Controllers\Admin\Treatment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\MasterValue;
use App\Models\Treatment;


class TreatmentControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Treatment::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->treatment_type != '') {
            $query->where('treatment_type', $request->treatment_type);
        }
        
        $treatments = $query->paginate(10);
        $treatmentsCount = $query->count();
        
        $treatment_types = MasterValue::where('MasterHead', '5')->get();
        
        return view('admin.treatment.index', compact('treatments','treatmentsCount','treatment_types','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $treatment_info='';
        $treatment_types = MasterValue::where('MasterHead', '5')->get();
        return view('admin.treatment.create', compact('treatment_info','treatment_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveTreatment = new Treatment();
        $saveTreatment->treatment_type = $request->treatment_type;
        $saveTreatment->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveTreatment->profile = $FileName;
        }

        $saveTreatment->save();



        return redirect()
            ->back()
            ->with('success', 'Treatment has been saved.');
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
        $treatment_info = Treatment::where('id', $id)->first();
        $treatment_types = MasterValue::where('MasterHead', '5')->get();
        
        return view('admin.treatment.update', compact('treatment_info','treatment_types'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveTreatment = Treatment::find($id);
        $saveTreatment->treatment_type = $request->treatment_type;
        $saveTreatment->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveTreatment->profile = $FileName;
        }
        
        $saveTreatment->save();



        return redirect()
            ->back()
            ->with('success', 'Treatment has been saved.');
    }

    public function banner_status($id)
    {
        $data = Treatment::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Treatment ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $treatment = Treatment::findOrFail($id);
        $treatment->delete();
        return redirect()
            ->back()
            ->with('success', 'Treatment has been Deleted Successfully!!');
    }
}
