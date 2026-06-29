<?php

namespace App\Http\Controllers\Admin\SalesCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use App\Models\Builder;
use App\Models\Society;
use App\Models\Property;

class LeadDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.salescrm.leadDetail');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $lead_id = $id;
        $leadDetail = Lead::find($id);
        $leadJourney = $leadDetail
            ->getLeadJourney()
            ->orderByDesc('id')
            ->get();
            
        $properties = Property::get();
        //$fieldPersons = User::whereHas('getEmpDesignation', fn($query) => $query->where('name', 'Field Manager'))->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get(); */  
        
        $builders = Builder::where('status', 1)->get();
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $query = Property::query();
        
        /*if (auth()->user()->is_admin != '1') {
            $query->where('addby', '=', auth()->user()->id);
        }*/
        
        /*if ($request->project != '') {
            $query->where('society_id', '=', $request->project);
        }*/
        
        /*if ($request->size != '') {
            
            if($request->size=='100 Sqft - 300 Sqft'){
                $query->where('property_size', '>=', 100);
                $query->where('property_size', '<=', 300);
            }elseif($request->size=='300 Sqft - 500 Sqft'){
                $query->where('property_size', '>=', 300);
                $query->where('property_size', '<=', 500);
            }elseif($request->size=='500 Sqft - 800 Sqft'){
                $query->where('property_size', '>=', 500);
                $query->where('property_size', '<=', 800);
            }elseif($request->size=='800 Sqft - 1100 Sqft'){
                $query->where('property_size', '>=', 800);
                $query->where('property_size', '<=', 1100);
            }elseif($request->size=='1100 Sqft - 1500 Sqft'){
                $query->where('property_size', '>=', 1100);
                $query->where('property_size', '<=', 1500);
            }elseif($request->size=='1500 Sqft - 2000 Sqft'){
                $query->where('property_size', '>=', 1500);
                $query->where('property_size', '<=', 2000);
            }
        }*/
        
        
        $query->where('total_cost', '>=', $leadDetail->budget-1000000);
        $query->where('total_cost', '<=', $leadDetail->budget+1000000);
           
        
        
        /*if ($request->project_type != '') {
            $query->where('property_bhk', '=', $request->project_type);
        }*/
        
        /*if ($request->is_for_rent != '') {
            $query->where('is_for_rent', '=', $request->is_for_rent);
        }*/
        
        /*if ($request->possession_status != '') {
            $query->where('possession_status', '=', $request->possession_status);
        }*/
        
        /*if ($request->category != '') {
            $query->where('property_category', '=', $request->category);
        }*/
        
        /*if ($request->sub_category != '') {
            $query->where('property_sub_category', '=', $request->sub_category);
        }*/
        
        $sugestedproperties = $query->paginate(10);
        $sugestedpropertyCount = $query->count();
        
        
        return view('admin.salescrm.leadDetail', compact('sugestedproperties','leadDetail', 'leadJourney', 'properties', 'fieldPersons','builders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
