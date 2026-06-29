<?php

namespace App\Http\Controllers\Admin\MedicalHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\MasterValue;
use App\Models\MedicalHistory;


class MedicalHistoryControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = MedicalHistory::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->medical_history != '') {
            $query->where('medical_history', $request->medical_history);
        }
        
        $medicalhistorys = $query->paginate(10);
        $medicalhistorysCount = $query->count();
        
        $medical_historys = MasterValue::where('MasterHead', '9')->get();
        
        return view('admin.medicalhistory.index', compact('medicalhistorys','medicalhistorysCount','medical_historys','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicalhistory_info='';
        $medical_historys = MasterValue::where('MasterHead', '9')->get();
        return view('admin.medicalhistory.create', compact('medicalhistory_info','medical_historys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveMedicalHistory = new MedicalHistory();
        $saveMedicalHistory->medical_history = $request->medical_history;
        $saveMedicalHistory->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveMedicalHistory->profile = $FileName;
        }

        $saveMedicalHistory->save();

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
        $medicalhistory_info = MedicalHistory::where('id', $id)->first();
        $medical_historys = MasterValue::where('MasterHead', '9')->get();
        
        return view('admin.medicalhistory.update', compact('medicalhistory_info','medical_historys'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveMedicalHistory = MedicalHistory::find($id);
        $saveMedicalHistory->medical_history = $request->medical_history;
        $saveMedicalHistory->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveMedicalHistory->profile = $FileName;
        }
        
        $saveMedicalHistory->save();



        return redirect()
            ->back()
            ->with('success', 'Medical history has been saved.');
    }

    public function banner_status($id)
    {
        $data = MedicalHistory::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'MedicalHistory ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicalhistory = MedicalHistory::findOrFail($id);
        $medicalhistory->delete();
        return redirect()
            ->back()
            ->with('success', 'Medical history has been Deleted Successfully!!');
    }
}
