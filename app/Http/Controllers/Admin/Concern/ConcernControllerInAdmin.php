<?php

namespace App\Http\Controllers\Admin\Concern;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Brand;
use App\Models\MasterValue;
use App\Models\Concern;


class ConcernControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $query = Concern::query();
        
        if ($request->search_text != '') {
            $query->where('name', 'LIKE', '%'.$request->search_text.'%');
        }
        if ($request->concern_types != '') {
            $query->where('concern_types', $request->concern_types);
        }
        
        $concerns = $query->paginate(10);
        $concernsCount = $query->count();
        
        $concern_types = MasterValue::where('MasterHead', '10')->get();
        
        return view('admin.concern.index', compact('concerns','concernsCount','concern_types','request'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $concern_info='';
        $concern_types = MasterValue::where('MasterHead', '10')->get();
        return view('admin.concern.create', compact('concern_info','concern_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saveConcern = new Concern();
        $saveConcern->concern_types = $request->concern_types;
        $saveConcern->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveConcern->profile = $FileName;
        }

        $saveConcern->save();
        
        if ($request->has('childs')) {
            foreach ($request->childs as $child) {
                // Check if the child value is not empty
                if (!empty($child)) {
                    // Create and save a new child record
                    $childOption = new Concern();
                    $childOption->concern_types = $request->concern_types;
                    $childOption->parent_id = $saveConcern->id; // Assume ClinicalOptionChild has a foreign key to ClinicalOption
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
        $concern_info = Concern::where('id', $id)->first();
        $concern_types = MasterValue::where('MasterHead', '10')->get();
        
        $query = Concern::query();
        $query->where('parent_id', $id);
        $concerns = $query->get();
        
        return view('admin.concern.update', compact('concern_info','concern_types','concerns'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner_id = $id;
        $saveConcern = Concern::find($id);
        $saveConcern->concern_types = $request->concern_types;
        $saveConcern->name = $request->name;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/mobile'), $FileName);
            $saveConcern->profile = $FileName;
        }
        
        $saveConcern->save();

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
        $data = Concern::find($id);
        
        if ($data->status == 1) {
            $data->status = 0;
            $msg = 'Desabled';
        } else {
            $data->status = 1;
            $msg = 'Enabled';
        }
        if ($data->save()) {
            return redirect(route('banner.index'))->with('success', 'Concern ' . $msg . ' Successfully!');
        }
        return redirect(route('banner.index'))->with('error', 'Something Worng try again.!');
    }

   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concern = Concern::findOrFail($id);
        $concern->delete();
        return redirect()
            ->back()
            ->with('success', 'Medical history has been Deleted Successfully!!');
    }
}
