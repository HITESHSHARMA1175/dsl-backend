<?php

namespace App\Http\Controllers\Admin\SellerCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerLead;
use App\Models\Property;
use App\Models\User;

class SellerLeadDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sellercrm.leadDetail');
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
        $leadDetail = SellerLead::find($id);
        $leadJourney = $leadDetail
            ->getSellerLeadJourney()
            ->orderByDesc('id')
            ->get();
            
        @$next_lead_info = SellerLead::where('id','>',$id)->first();    
        $nextleadid=@$next_lead_info->id; 
        @$prev_lead_info = SellerLead::where('id','<',$id)->orderByDesc('id')->first();    
        $prevleadid=@$prev_lead_info->id; 
        
        
        $properties = Property::get();
        //$fieldPersons = User::whereHas('getEmpDesignation', fn($query) => $query->where('name', 'Field Manager'))->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get(); */ 
        $fieldPersons = User::where('id','!=', '17')->get();
        return view('admin.sellercrm.leadDetail', compact('leadDetail', 'leadJourney', 'properties', 'fieldPersons', 'nextleadid', 'prevleadid'));
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
