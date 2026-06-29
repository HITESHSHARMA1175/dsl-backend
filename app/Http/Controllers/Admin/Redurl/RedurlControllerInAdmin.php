<?php

namespace App\Http\Controllers\Admin\Redurl;

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
use App\Models\Redurl;
use App\Models\Master;
use App\Models\MasterValue;


class RedurlControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = Redurl::query();
        
        if ($request->searchtext != '') {
            $query->where('old_url', 'like', '%'.$request->searchtext.'%');
            $query->orWhere('redirect_url', 'like', '%'.$request->searchtext.'%');
        }

        $redurls = $query->paginate(10);
        $redurlCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        $redurlcats = Master::where('MasterHead', 'Redurl Category')->first()->getMasterValues ?? [];
        
        return view('admin.redurl.index', compact('redurls','redurlCount', 'services','redurlcats','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.redurl.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        $saveRedurl = new Redurl();
        $saveRedurl->old_url = $request->old_url;
        $saveRedurl->redirect_url = $request->redirect_url;
        $saveRedurl->short_description = $request->short_description;
        
        $saveRedurl->addby = auth()->user()->id;
        
        $saveRedurl->save();

      

        return redirect()
            ->back()
            ->with('success', 'Redirect url has been saved.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $redurl_info = Redurl::where('id', $id)->first();

        return view('admin.redurl.details', compact('redurl_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $redurl_info = Redurl::where('id', $id)->first();

        $services = Property::where('parent_id', 0)->get();
        $redurlcats = Master::where('MasterHead', 'Redurl Category')->first()->getMasterValues ?? [];
        
        return view('admin.redurl.update', compact('redurl_info', 'services', 'redurlcats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $redurl_id = $id;
        $saveRedurl = Redurl::find($id);
        $saveRedurl->old_url = $request->old_url;
        $saveRedurl->redirect_url = $request->redirect_url;
        $saveRedurl->short_description = $request->short_description;
        
        $saveRedurl->addby = auth()->user()->id;
        
        $saveRedurl->save();



        return redirect()
            ->back()
            ->with('success', 'Redirect url has been saved.');
    }

    
    public function redurl_status($id)
    {
        $data = Redurl::find($id);
        
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
            ->with('success', 'Redirect url ' . $msg . ' Successfully!');
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
        $redurl = Redurl::findOrFail($id);
        $redurl->delete();
        return redirect()
            ->back()
            ->with('success', 'Redurl has been Deleted Successfully!!');
    }
}
