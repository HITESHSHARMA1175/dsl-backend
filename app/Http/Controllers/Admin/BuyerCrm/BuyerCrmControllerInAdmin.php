<?php

namespace App\Http\Controllers\Admin\BuyerCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Master;
use App\Models\PropertyRoom;
use App\Models\Property;
use App\Models\User;
use App\Models\LeadJourney;
use Str;


class BuyerCrmControllerInAdmin extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 'New';
        $leads = Lead::where('status', $status)
            ->orderByDesc('id')
            ->paginate(10);
        $properties = Property::get();
        $fieldPersons = User::where('id','!=', '17')->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get();*/

        return view('admin.buyercrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $leadSources = Master::where('MasterHead', 'Lead Sources')->first()->getMasterValues ?? [];
        return view('admin.buyercrm.create', compact('roomTypes', 'leadSources', 'properties','ropertySaleType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return view('admin.buyercrm.create');
        $saveLead = new Lead();

        $saveLead->source = $request->source;
        $saveLead->name = $request->name;
        $saveLead->email = $request->email;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->city = $request->city;
        $saveLead->message = $request->message;
        
        $saveLead->flat = $request->flat;
        $saveLead->size = $request->size;
        $saveLead->location = $request->location;
        $saveLead->budget = $request->budget;
        $saveLead->within = $request->within;
        $saveLead->type = $request->type;
        $saveLead->pro_status = $request->pro_status;

        $saveLead->save();
        return redirect()
            ->back()
            ->with('success', 'Lead has been saved Successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $status)
    {
      
        $status = $status;
        $query = Lead::query();
        if ($status == 'Visits') {
            $query->where('status', $status)->orwhere('status', 'Re Visits');
        } else {
            $query->where('status', $status);
        }
        $leads = $query->orderByDesc('id')->paginate(10);
        $properties = Property::get();
        $fieldPersons = User::where('id','!=', '17')->get();
        /*$fieldPersons = User::whereHas('getEmpDesignation', function($query) {
        $query->where('name', 'Field Manager');
        })->get();*/
        return view('admin.buyercrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $properties = Property::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $leadSources = Master::where('MasterHead', 'Lead Sources')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $lead = Lead::findOrFail($id);
        return view('admin.buyercrm.update', compact('lead', 'roomTypes', 'leadSources', 'properties','ropertySaleType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $saveLead = Lead::findOrFail($id);
        
        $saveLead->source = $request->source;
        $saveLead->name = $request->name;
        $saveLead->email = $request->email;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->city = $request->city;
        $saveLead->message = $request->message;
        
        $saveLead->flat = $request->flat;
        $saveLead->size = $request->size;
        $saveLead->location = $request->location;
        $saveLead->budget = $request->budget;
        $saveLead->within = $request->within;
        $saveLead->type = $request->type;
        $saveLead->pro_status = $request->pro_status;
        
        $saveLead->save();
        return redirect()
            ->back()
            ->with('success', 'Lead has been saved Successfully!!');
    }

    public function changeLeadStatus(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->status = $request->status;
        $lead->save();
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = $request->status;

        if ($request->status == 'Visits') {
            $leadJourney->visit_time = $request->visit_time;
            $leadJourney->visit_date = $request->visit_date;
            $leadJourney->property = $request->property;
            $leadJourney->field_person = $request->field_person;
        }

        $FileName = '';
        if ($request->status == 'Agreement') {
            if ($request->hasFile('agreement')) {
                $file = $request->file('agreement');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->agreement = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('police_verification')) {
                $file = $request->file('police_verification');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->police_verification = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('signatured_agreement')) {
                $file = $request->file('signatured_agreement');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->signatured_agreement = $FileName;
                $FileName = '';
            }
        }
        if ($request->status == 'Move In') {
            $leadJourney->visit_time = $request->visit_time;
            $leadJourney->visit_date = $request->visit_date;
            $leadJourney->property = $request->property;
            $leadJourney->field_person = $request->field_person;
        }
        $leadJourney->remark = $request->remark;
        $leadJourney->addby = auth()->user()->id;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Lead Status has been saved Successfully!!');
    }
    
    public function assignLead(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->assign_emp = $request->assign_emp;
        $lead->assign_date = now();
        $lead->assign_by = auth()->user()->id;
        $lead->save();
        
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = '';
        
        $leadJourney->assign_emp = $request->assign_emp;
        $leadJourney->assign_date = now();
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->remark;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Lead has been Assigned Successfully!!');
    }
    
    public function updateCall(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->call_status = $request->call_status;
        $lead->call_date = $request->call_date;
        $lead->call_time = $request->call_time;
        $lead->call_agenda = $request->call_agenda;
        $lead->save();
        
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = '';
        
        $leadJourney->call_status = $request->call_status;
        $leadJourney->call_date = $request->call_date;
        $leadJourney->call_time = $request->call_time;
        $leadJourney->call_agenda = $request->call_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->remark;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Call has been Updated Successfully!!');
    }
    
    public function updateMeeting(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->meeting_status = $request->meeting_status;
        $lead->meeting_with = $request->meeting_with;
        $lead->meeting_date = $request->meeting_date;
        $lead->meeting_time = $request->meeting_time;
        $lead->meeting_agenda = $request->meeting_agenda;
        $lead->save();
        
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = '';
        
        $leadJourney->meeting_status = $request->meeting_status;
        $leadJourney->meeting_with = $request->meeting_with;
        $leadJourney->meeting_date = $request->meeting_date;
        $leadJourney->meeting_time = $request->meeting_time;
        $leadJourney->meeting_agenda = $request->meeting_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->remark;
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Meeting has been Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return redirect()
            ->back()
            ->with('success', 'Lead has been Deleted Successfully!!');
    }
}
