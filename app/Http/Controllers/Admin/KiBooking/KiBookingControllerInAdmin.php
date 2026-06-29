<?php

namespace App\Http\Controllers\Admin\KiBooking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Constants;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Str;
use Hash;
use Session;

use Illuminate\Support\Facades\DB;

use App\Models\Property;
use App\Models\KiBooking;
use App\Models\Clinic;


class KiBookingControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
        
       
        $query = KiBooking::query();
        $query->where('is_web', '0');
        if ($request->searchtext != '') {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('last_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('email', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('mobile', 'like', '%'.$request->searchtext.'%')
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $request->searchtext . '%');
            });
        }

        if ($request->parent_id != '') {
            $query->whereJsonContains('service_id', (int) $request->parent_id);
        }
        
        $query->orderBy('id', 'desc');
        
        $kibookings = $query->paginate(10);
        $kibookingCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.kibooking.index', compact('kibookings','kibookingCount', 'services','request'));
    }

    public function kibooking_web(Request $request)
    {
        
       
        $query = KiBooking::query();
        $query->where('is_web', '1');
        if ($request->searchtext != '') {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('last_name', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('email', 'like', '%'.$request->searchtext.'%')
                  ->orWhere('mobile', 'like', '%'.$request->searchtext.'%')
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $request->searchtext . '%');
            });
        }

        if ($request->parent_id != '') {
            $query->whereJsonContains('service_id', (int) $request->parent_id);
        }
        
        $query->orderBy('id', 'desc');
        
        $kibookings = $query->paginate(10);
        $kibookingCount = $query->count();
   
        $services = Property::where('parent_id', 0)->get();
        
        return view('admin.kibooking.webindex', compact('kibookings','kibookingCount', 'services','request'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $services = Property::where('parent_id', 0)->get();

        return view('admin.kibooking.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kibooking_info = KiBooking::where('id', $id)->first();

        return view('admin.kibooking.details', compact('kibooking_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $kibooking_info = KiBooking::where('id', $id)->first();

        $services = Property::where('parent_id', 0)->get();

        return view('admin.kibooking.update', compact('kibooking_info', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function kibooking_status($id)
    {
        $data = KiBooking::find($id);
        
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
            ->with('success', 'KiBooking ' . $msg . ' Successfully!');
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
        $kibooking = KiBooking::findOrFail($id);
        $kibooking->delete();
        return redirect()
            ->back()
            ->with('success', 'KiBooking has been Deleted Successfully!!');
    }
}
