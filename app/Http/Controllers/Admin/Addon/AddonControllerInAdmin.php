<?php

namespace App\Http\Controllers\Admin\Addon;

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
use App\Models\Addon;
use App\Models\Master;
use App\Models\MasterValue;


class AddonControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Addon::query();
        
        if ($request->searchtext != '') {
            $query->where('addon_name', 'like', '%'.$request->searchtext.'%');
        }

        if ($request->parent_id != '') {
            $query->where('parent_id', '=', $request->parent_id);
        }
        
        
        $addonCount = $query->count();
        $addons = $query->paginate(10);
   
        $services = Property::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        return view('admin.addon.index', compact('addons','addonCount', 'services','addoncats','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $services = Property::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];

        return view('admin.addon.create', compact('services','addoncats'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $saveAddon = new Addon();
        $saveAddon->parent_id = $request->parent_id;
        $saveAddon->addon_name = $request->addon_name;
        $saveAddon->description = $request->description;
        $saveAddon->duration = $request->duration;
        $saveAddon->number_of_members_required = $request->number_of_members_required;
        $saveAddon->max_quantity_allowed = $request->max_quantity_allowed;
        $saveAddon->price = $request->price;
        $saveAddon->addon_slug = $request->addon_slug;
        $saveAddon->discounted_price = $request->discounted_price;
        $saveAddon->profile = $request->profile;
        
        $saveAddon->addby = auth()->user()->id;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/addon'), $FileName);
            $saveAddon->profile = $FileName;
        }
        
        $saveAddon->save();

      

        return redirect()
            ->back()
            ->with('success', 'Addon has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $addon_info = Addon::where('id', $id)->first();

        return view('admin.addon.details', compact('addon_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $addon_info = Addon::where('id', $id)->first();

        $services = Property::where('parent_id', 0)->get();
        $addoncats = Master::where('MasterHead', 'Addon Category')->first()->getMasterValues ?? [];
        
        return view('admin.addon.update', compact('addon_info', 'services', 'addoncats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $addon_id = $id;
        $saveAddon = Addon::find($id);
        $saveAddon->parent_id = $request->parent_id;
        $saveAddon->addon_name = $request->addon_name;
        $saveAddon->description = $request->description;
        $saveAddon->duration = $request->duration;
        $saveAddon->number_of_members_required = $request->number_of_members_required;
        $saveAddon->max_quantity_allowed = $request->max_quantity_allowed;
        $saveAddon->price = $request->price;
        $saveAddon->addon_slug = $request->addon_slug;
        $saveAddon->discounted_price = $request->discounted_price;
        $saveAddon->addby = auth()->user()->id;
        
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/addon'), $FileName);
            $saveAddon->profile = $FileName;
        }
        
        $saveAddon->save();



        return redirect()
            ->back()
            ->with('success', 'Addon has been saved.');
    }

    
    public function addon_status($id)
    {
        $data = Addon::find($id);
        
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
            ->with('success', 'Addon ' . $msg . ' Successfully!');
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
        $addon = Addon::findOrFail($id);
        $addon->delete();
        return redirect()
            ->back()
            ->with('success', 'Addon has been Deleted Successfully!!');
    }
}
