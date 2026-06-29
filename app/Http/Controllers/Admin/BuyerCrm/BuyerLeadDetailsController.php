<?php

namespace App\Http\Controllers\Admin\SalesCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Property;
use App\Models\User;

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
        $fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get();    
        return view('admin.salescrm.leadDetail', compact('leadDetail', 'leadJourney', 'properties', 'fieldPersons'));
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
