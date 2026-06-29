<?php

namespace App\Http\Controllers\Admin\ClinicalOption;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\MasterValue;
use App\Models\ClinicalOption;


class ClinicalOptionControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = ClinicalOption::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->clinical_option != '') {
            $query->where('clinical_option', $request->clinical_option);
        }
        
        $clinicaloptions = $query->paginate(10);
        $clinicaloptionsCount = $query->count();
        
        $clinical_options = MasterValue::where('MasterHead', '11')->get();
        
        return view('admin.clinicaloption.index', compact('clinicaloptions','clinicaloptionsCount','clinical_options','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinicaloption_info='';
        $clinical_options = MasterValue::where('MasterHead', '11')->get();
        return view('admin.clinicaloption.create', compact('clinicaloption_info','clinical_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveClinicalOption = new ClinicalOption();
        $saveClinicalOption->clinical_option = $request->clinical_option;
        $saveClinicalOption->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveClinicalOption->profile = $FileName;
        }

        $saveClinicalOption->save();
        
        // Save the childs if provided
        if ($request->has('childs')) {
            foreach ($request->childs as $child) {
                // Check if the child value is not empty
                if (!empty($child)) {
                    // Create and save a new child record
                    $childOption = new ClinicalOption();
                    $childOption->clinical_option = $request->clinical_option;
                    $childOption->parent_id = $saveClinicalOption->id; // Assume ClinicalOptionChild has a foreign key to ClinicalOption
                    $childOption->name = $child;
                    $childOption->save();
                }
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Medical history has been saved.');
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
        $clinicaloption_info = ClinicalOption::where('id', $id)->first();
        $clinical_options = MasterValue::where('MasterHead', '11')->get();
        
        
        $query = ClinicalOption::query();
        $query->where('parent_id', $id);
        $clinicaloptions = $query->get();
        
        return view('admin.clinicaloption.update', compact('clinicaloption_info','clinical_options','clinicaloptions'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveClinicalOption = ClinicalOption::find($id);
        $saveClinicalOption->clinical_option = $request->clinical_option;
        $saveClinicalOption->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveClinicalOption->profile = $FileName;
        }
        
        $saveClinicalOption->save();
        
        // Save the childs if provided
        if ($request->has('childs')) {
            foreach ($request->childs as $child) {
                // Check if the child value is not empty
                if (!empty($child)) {
                    // Create and save a new child record
                    $childOption = new ClinicalOption();
                    $childOption->clinical_option = $request->clinical_option;
                    $childOption->parent_id = $saveClinicalOption->id; // Assume ClinicalOptionChild has a foreign key to ClinicalOption
                    $childOption->name = $child;
                    $childOption->save();
                }
            }
        }
        
        if ($request->has('oldchilds')) {
            foreach ($request->oldchilds as $ido => $valueo) {
                if (!empty($valueo)) {
                    $childOption = ClinicalOption::find($ido);
                    if ($childOption) {
                        $childOption->name = $valueo;
                        $childOption->save();
                    }
                }
            }
        }


        return redirect()
            ->back()
            ->with('success', 'Medical history has been saved.');
    }

    public function banner_status($id)
    {
        $data = ClinicalOption::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'ClinicalOption ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clinicaloption = ClinicalOption::findOrFail($id);
        $clinicaloption->delete();
        return redirect()
            ->back()
            ->with('success', 'Medical history has been Deleted Successfully!!');
    }
}
