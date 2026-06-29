<?php
 
namespace App\Http\Controllers\Admin\SalesCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Master;
use App\Models\PropertyRoom;
use App\Models\Property;
use App\Models\User;
use App\Models\LeadJourney;
use App\Models\LeadPayment;
use App\Models\InventoryCategory;
use App\Models\LeadError;
use App\Models\LeadImportLog;
use App\Models\Builder;
use App\Models\Society;
use Str;

use App\Exports\LeadExport;
//use Excel;

// use App\Exports\ExportReceiving;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SalesDataImport;

use Mail;
use App\Mail\LeadImportMail;
use App\Mail\LeadStatusChangeMail;


class SalesCrmControllerInAdmin extends Controller
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
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        /*$fieldPersons = User::where('emp_type','=', 'Staff')->whereHas('getEmpDesignation', function($query) {
            $query->where('name', '=', 'Consultant');
        })->get();*/

        return view('admin.salescrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }
    
    public function exportLead() 
    {
        
       
        return Excel::download(new LeadExport, 'lead-list.xlsx');
        
        
        
    }
    
    public function lead_import_log()
    {
        
        if(auth()->user()->is_admin=='1'){
            $properties = LeadImportLog::orderByDesc('id')->paginate(10);
            $propertyCount = LeadImportLog::count();
        }else{
            $properties = LeadImportLog::where('addby', auth()->user()->id)->orderByDesc('id')->paginate(10);
            $propertyCount = LeadImportLog::where('addby', auth()->user()->id)->count();
        }
        
        return view('admin.salescrm.import-log', compact('properties','propertyCount'));
    }
    
    
    public function lead_import_failed_log(Request $request)
    {
        
        $id = $request->id;
        
        if(auth()->user()->is_admin=='1'){
            $properties = LeadError::where('import_id', $id)->orderByDesc('id')->paginate(10);
            $propertyCount = LeadError::where('import_id', $id)->count();
        }else{
            $properties = LeadError::where('import_id', $id)->where('addby', auth()->user()->id)->orderByDesc('id')->paginate(10);
            $propertyCount = LeadError::where('import_id', $id)->where('addby', auth()->user()->id)->count();
        }
        
        return view('admin.salescrm.import-failed-log', compact('properties','propertyCount'));
    }
    
    /**
     * import sales lead data.
     */
    public function salesDataImportdataOld(Request $request)
    {
        try {
            Excel::import(new SalesDataImport(), $request->file('file')->store('temp'));
            return redirect()
                ->back()
                ->with('message', 'Import successful!');
            // return response()->json(['message' => 'Import successful!']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', explode(' (', $e->getMessage())[0]);
            // return response()->json(['error' => $e->getMessage()], 500);
            return response()->json(['status' => Constants::FAILED_STATUS, 'error' => $e->getMessage(), 'message' => 'validation error'], 422);
        }
    }
    
     public function salesDataImportdata(Request $request)
    {
        $staff_id=$request->staff_id;
        try {
            Excel::import(new SalesDataImport($staff_id), $request->file('file')->store('temp'));
            
            $import_last_data = LeadImportLog::latest()->first();
            $FileName = '';
            if ($request->file('file')) {
                $file = $request->file('file');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/leadimport'), $FileName);
                $import_last_data->upload_file = $FileName;
            }
            $import_last_data->addby = auth()->user()->id;
            $import_last_data->save();
            
            return redirect()
            ->back()
            ->with('success', 'Import successful!')
            ->with('import_last_data_id', $import_last_data->id)
            ->with('import_last_data_duplicate', $import_last_data->duplicate)
            ->with('import_last_data_new', $import_last_data->total_new)
            ->with('import_last_data_url', '');
            // ->with(compact('import_last_data'));
            // return response()->json(['message' => 'Import successful!']);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', explode(' (', $e->getMessage())[0]);
            // return response()->json(['error' => $e->getMessage()], 500);
            return response()->json(['status' => Constants::FAILED_STATUS, 'error' => $e->getMessage(), 'message' => 'validation error'], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $builders = Builder::where('status', 1)->get();
        $properties = Property::get();
        $roomTypes = Master::where('MasterHead', 'Room Type')->first()->getMasterValues ?? [];
        $ropertySaleType = Master::where('MasterHead', 'Property Sale Type')->first()->getMasterValues ?? [];
        $leadSources = Master::where('MasterHead', 'Lead Sources')->first()->getMasterValues ?? [];
        $categories = InventoryCategory::where('parent_id', 0)->get();
        return view('admin.salescrm.create', compact('roomTypes', 'leadSources', 'properties','ropertySaleType','categories','builders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return view('admin.salescrm.create');
        $saveLead = new Lead();

        $saveLead->source = $request->source;
        $saveLead->builder_id = $request->builder;
        $saveLead->society_id = $request->society;
        
        $saveLead->name = $request->name;
        $saveLead->email = $request->email;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->alt_mobile_no = $request->alt_mobile_no;
        $saveLead->city = $request->city;
        $saveLead->message = $request->message;
        
        $saveLead->property_type = $request->property_type;
        $saveLead->property_sub_type = $request->property_sub_type;
        $saveLead->budget_start = $request->budget_start;
        $saveLead->budget_end = $request->budget_end;
        $saveLead->buy_type = $request->buy_type;
        
        $saveLead->location = $request->location;
        $saveLead->campaigns = $request->campaigns;
        $saveLead->pro_status = $request->pro_status;
        
        $saveLead->flat = $request->flat;
        $saveLead->size = $request->size;
        $saveLead->budget = $request->budget;
        $saveLead->within = $request->within;
        $saveLead->type = $request->type;
        
        if(auth()->user()->emp_type=='Staff'){
            $saveLead->assign_emp = auth()->user()->id;
            $saveLead->assign_date = now();
            $saveLead->assign_by = auth()->user()->id;
        }
        
        $saveLead->addby = auth()->user()->id;

        $saveLead->save();
        return redirect()
            ->back()
            ->with('success', 'Lead has been saved Successfully!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $status)
    {
        
        
        function getAllSubordinates($bossId, &$subordinateIds) {
            $subordinates = User::where('reporting_boss', $bossId)->pluck('id')->toArray();
        
            foreach ($subordinates as $subordinate) {
                $subordinateIds[] = $subordinate;
                getAllSubordinates($subordinate, $subordinateIds);
            }
        }
        
        $subordinateIds = [];
        if($request->staff_id!=''){
            $bossId = $request->staff_id; 
        }else{
            $bossId = auth()->user()->id; 
        }
        
        getAllSubordinates($bossId, $subordinateIds);
        if($request->staff_id!=''){
            $subordinateIds[] = $request->staff_id; 
        }else{
            $subordinateIds[] = auth()->user()->id; 
        }
        
        $empIds='';
        
        
        
        if($request->order_by=='asc'){
            $order_by='asc';
        }else{
            $order_by='desc';
        }
        
        $status = $status;
        $query = Lead::query();
        $query->where('is_lead','1');
        
        
        if (auth()->user()->is_admin == '1' && $request->staff_id=='') {
            
            // No additional conditions for Admin
            
        }elseif (auth()->user()->emp_type == 'Staff'  || $request->staff_id!='') {
            
            //$query->whereIn('assign_emp', $subordinateIds);
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            
        }elseif (auth()->user()->emp_type == 'Agent') {
            
            $query->whereIn('addby', $subordinateIds);
            
        }
        
        if ($request->emp_id != '') {
            //$query->where('assign_emp', '=', $request->emp_id);
            $query->whereRaw("FIND_IN_SET(?, assign_emp)", [$request->emp_id]);
        }
        
        if ($request->search_text != '') {
            $search_text = $request->search_text;
            $query->where(function ($query) use ($search_text) {
                $query->where('name', 'LIKE', '%' . $search_text . '%')
                      ->orWhere('email', 'LIKE', '%' . $search_text . '%')
                      ->orWhere('mobile_no', 'LIKE', '%' . $search_text . '%')
                      ->orWhere('alt_mobile_no', 'LIKE', '%' . $search_text . '%')
                      ->orWhere('location', 'LIKE', '%' . $search_text . '%')
                      ->orWhere('campaigns', 'LIKE', '%' . $search_text . '%');
            });
        }
        
        if ($request->start_date != '') {
            $query->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date != '') {
            $query->where('created_at', '<=', $request->end_date);
        }
        if ($request->property_type != '') {
            $query->where('property_type', '=', $request->property_type);
        }
        if ($request->property_sub_type != '') {
            $query->where('property_sub_type', '=', $request->property_sub_type);
        }
        
        // Lead ids without status
        $leadIds = $query->pluck('id')->toArray();
        
        if ($status == 'All') {
            // No additional conditions for 'All' status
        } elseif ($status == 'Visits') {
            $query->where('status', $status)->orwhere('status', 'Re Visits');
        } else {
            $query->where('status', $status);
        }
        
        if($request->export_value == '1'){
            //return 11;
            return Excel::download(new LeadExport($query), 'leads.xlsx');
        }
        
        $leadCount= $query->count();
        $leads = $query->orderBy('id',$order_by)->paginate(10);
        
        
        
        if (auth()->user()->is_admin == '1' && $request->staff_id=='') {
            
            $allCount = Lead::query()->where('is_lead','1')->where('id','!=', '')->whereIn('id', $leadIds)->count();
            $newCount = Lead::query()->where('is_lead','1')->where('status', 'New')->whereIn('id', $leadIds)->count();
            $FollowUpCount = Lead::query()->where('is_lead','1')->where('status', 'Follow Up')->whereIn('id', $leadIds)->count();
            $ColdCount = Lead::query()->where('is_lead','1')->where('status', 'Cold')->whereIn('id', $leadIds)->count();
            $InterestedCount = Lead::query()->where('is_lead','1')->where('status', 'Interested')->whereIn('id', $leadIds)->count();
            $NoAnswerCount = Lead::query()->where('is_lead','1')->where('status', 'No Answer')->whereIn('id', $leadIds)->count();
            $InvalidWrongNumberCount = Lead::query()->where('is_lead','1')->where('status', 'Invalid Wrong Number')->whereIn('id', $leadIds)->count();
            $AgentCount = Lead::query()->where('is_lead','1')->where('status', 'Agent')->whereIn('id', $leadIds)->count();
            $MeetingScheduleCount = Lead::query()->where('is_lead','1')->where('status', 'Meeting Schedule')->whereIn('id', $leadIds)->count();
            $MeetingsFeedbackCount = Lead::query()->where('is_lead','1')->where('status', 'Meetings Feedback')->whereIn('id', $leadIds)->count();
            $NotPotentialCount = Lead::query()->where('is_lead','1')->where('status', 'Not Potential')->whereIn('id', $leadIds)->count();
            $ContactedanddetailssharedCount = Lead::query()->where('is_lead','1')->where('status', 'Contacted and details shared')->whereIn('id', $leadIds)->count();
            $EOICollectedCount = Lead::query()->where('is_lead','1')->where('status', 'EOI Collected')->whereIn('id', $leadIds)->count();
            $BookingsCount = Lead::query()->where('is_lead','1')->where('status', 'Bookings')->whereIn('id', $leadIds)->count();
            $SPACount = Lead::query()->where('is_lead','1')->where('status', 'SPA')->whereIn('id', $leadIds)->count();
            $MOUCount = Lead::query()->where('is_lead','1')->where('status', 'MOU')->whereIn('id', $leadIds)->count();
            $DLDRegistrationCount = Lead::query()->where('is_lead','1')->where('status', 'DLD Registration')->whereIn('id', $leadIds)->count();
            $MortgageCount = Lead::query()->where('is_lead','1')->where('status', 'Mortgage')->whereIn('id', $leadIds)->count();
            $ConvertedtoDealCount = Lead::query()->where('is_lead','1')->where('status', 'Converted to Deal')->whereIn('id', $leadIds)->count();
            $DeadCount = Lead::query()->where('is_lead','1')->where('status', 'Dead')->whereIn('id', $leadIds)->count();
            
        }else if(auth()->user()->emp_type=='Staff' || $request->staff_id!=''){
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where('id','!=','');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $allCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'New');
            $newCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Follow Up');
            $FollowUpCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Cold');
            $ColdCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Interested');
            $InterestedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'No Answer');
            $NoAnswerCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Invalid Wrong Number');
            $InvalidWrongNumberCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Agent');
            $AgentCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Meeting Schedule');
            $MeetingScheduleCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Meetings Feedback');
            $MeetingsFeedbackCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Not Potential');
            $NotPotentialCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Contacted and details shared');
            $ContactedanddetailssharedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'EOI Collected');
            $EOICollectedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Bookings');
            $BookingsCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'SPA');
            $SPACount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'MOU');
            $MOUCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'DLD Registration');
            $DLDRegistrationCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Mortgage');
            $MortgageCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Converted to Deal');
            $ConvertedtoDealCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where(function ($q) use ($subordinateIds) {
                foreach ($subordinateIds as $id) {
                    $q->orWhereRaw("FIND_IN_SET($id, assign_emp)");
                }
            });
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Dead');
            $DeadCount = $query->orderByDesc('id')->count();
            
        }else if(auth()->user()->emp_type=='Agent'){
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->where('id','!=','');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $allCount = $query->orderByDesc('id')->count();
           
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'New');
            $newCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Follow Up');
            $FollowUpCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Cold');
            $ColdCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Interested');
            $InterestedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'No Answer');
            $NoAnswerCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Invalid Wrong Number');
            $InvalidWrongNumberCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Agent');
            $AgentCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Meeting Schedule');
            $MeetingScheduleCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Meetings Feedback');
            $MeetingsFeedbackCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Not Potential');
            $NotPotentialCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Contacted and details shared');
            $ContactedanddetailssharedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'EOI Collected');
            $EOICollectedCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Bookings');
            $BookingsCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'SPA');
            $SPACount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'MOU');
            $MOUCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'DLD Registration');
            $DLDRegistrationCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Mortgage');
            $MortgageCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Dead');
            $ConvertedtoDealCount = $query->orderByDesc('id')->count();
            
            $query = Lead::query();
            $query->where('is_lead','1');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('status', 'Converted to Deal');
            $DeadCount = $query->orderByDesc('id')->count();
            
        }
        
        
        
        $properties = Property::get();
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $categories = InventoryCategory::where('parent_id', 0)->get();
        $builders = Builder::where('status', 1)->get();
        /*$fieldPersons = User::where('emp_type','=', 'Staff')->whereHas('getEmpDesignation', function($query) {
            $query->where('name', '=', 'Consultant');
        })->get();*/
        return view('admin.salescrm.index', compact('empIds', 'leads', 'status', 'properties', 'allCount', 'fieldPersons','newCount','FollowUpCount','ColdCount','InterestedCount',
        'NoAnswerCount','InvalidWrongNumberCount','AgentCount','MeetingScheduleCount','MeetingsFeedbackCount','NotPotentialCount','ContactedanddetailssharedCount','EOICollectedCount',
        'BookingsCount','SPACount','MOUCount','DLDRegistrationCount','MortgageCount','ConvertedtoDealCount','DeadCount','categories','request','leadCount','builders'));
    }

    /**
     * lead meeting list.
     */
    public function lead_target_meeting(Request $request)
    {
        
        $status = $request->dash_type;
        
        if($request->order_by=='asc'){
            $order_by='asc';
        }else{
            $order_by='desc';
        }
        
        
        $query = Lead::query();
        $query->where('is_lead','1');
        if($request->dash_user_id!=''){
            //$query->where('assign_emp',$request->dash_user_id);
            $query->whereRaw("FIND_IN_SET(?, assign_emp)", [$request->dash_user_id]);
        }
        if($request->dash_type=='Todays Meeting'){
            $query->where('meeting_date',$request->todayDate);
            $query->where('status','Meeting Schedule');
        }elseif($request->dash_type=='Weekly Meeting'){
            $query->where('meeting_date','>=',$request->weekStartDate);
            $query->where('meeting_date','<=',$request->weekEndDate);
            $query->where('status','Meeting Schedule');
        }elseif($request->dash_type=='Monthly Meeting'){
            $query->where('meeting_date','>=',$request->monthStartDate);
            $query->where('meeting_date','<=',$request->monthEndDate);
            $query->where('status','Meeting Schedule');
        }elseif($request->dash_type=='Quarterly Meeting'){
            $query->where('meeting_date','>=',$request->quarterStartDate);
            $query->where('meeting_date','<=',$request->quarterEndDate);
            $query->where('status','Meeting Schedule');
        }elseif($request->dash_type=='Yearly Meeting'){
            $query->where('meeting_date','>=',$request->yearStartDate);
            $query->where('meeting_date','<=',$request->nextYearStartDate);
            $query->where('status','Meeting Schedule');
        }
        $leadCount= $query->count();
        $leads = $query->orderBy('id',$order_by)->paginate(10);
        
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $properties = Property::get();
        
        return view('admin.salescrm.lead-target-meeting', compact('leads','leadCount','status','fieldPersons','properties','request'));
    }


    /**
     * lead sale list.
     */
    public function lead_target_sale(Request $request)
    {
        
        $status = $request->dash_type;
        
        if($request->order_by=='asc'){
            $order_by='asc';
        }else{
            $order_by='desc';
        }
        
        
        $query = Lead::query();
        $query->where('is_lead','1');
        if($request->dash_user_id!=''){
            //$query->where('assign_emp',$request->dash_user_id);
            $query->whereRaw("FIND_IN_SET(?, assign_emp)", [$request->dash_user_id]);
        }
        if($request->dash_type=='Todays Sale'){
            $query->where('token_collect_date',$request->todayDate);
            $query->where('token_collect_flag', '1');
        }elseif($request->dash_type=='Weekly Sale'){
            $query->where('token_collect_date','>=',$request->weekStartDate);
            $query->where('token_collect_date','<=',$request->weekEndDate);
            $query->where('token_collect_flag', '1');
        }elseif($request->dash_type=='Monthly Sale'){
            $query->where('token_collect_date','>=',$request->monthStartDate);
            $query->where('token_collect_date','<=',$request->monthEndDate);
            $query->where('token_collect_flag', '1');
        }elseif($request->dash_type=='Quarterly Sale'){
            $query->where('token_collect_date','>=',$request->quarterStartDate);
            $query->where('token_collect_date','<=',$request->quarterEndDate);
            $query->where('token_collect_flag', '1');
        }elseif($request->dash_type=='Yearly Sale'){
            $query->where('token_collect_date','>=',$request->yearStartDate);
            $query->where('token_collect_date','<=',$request->nextYearStartDate);
            $query->where('token_collect_flag', '1');
        }
        $total_sale_value= $query->sum('sale_value');
        $leadCount= $query->count();
        $leads = $query->orderBy('id',$order_by)->paginate(10);
        
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $properties = Property::get();
        
        return view('admin.salescrm.lead-target-sale', compact('leads','leadCount','total_sale_value','status','fieldPersons','properties','request'));
    }
    
    /**
     * lead followup list.
     */
    public function lead_target_followup(Request $request)
    {
        
        $status = $request->dash_type;
        
        if($request->order_by=='asc'){
            $order_by='asc';
        }else{
            $order_by='desc';
        }
        
        //$todays_followup = Lead::join('lead_journeys', 'leads.id', '=', 'lead_journeys.lead')
        //->where('lead_journeys.assign_emp', $request->staff_id)->whereDate('lead_journeys.created_at', '=', $todayDate)->count();
        
        $query = Lead::join('lead_journeys', 'leads.id', '=', 'lead_journeys.lead');
        if($request->dash_user_id!=''){
            $query->where('lead_journeys.addby',$request->dash_user_id);
        }
        
        if($request->dash_type=='Todays Followup'){
            $query->whereDate('lead_journeys.created_at',$request->todayDate);
        }elseif($request->dash_type=='Weekly Followup'){
            $query->where('lead_journeys.created_at','>=',$request->weekStartDate);
            $query->where('lead_journeys.created_at','<=',$request->weekEndDate);
        }elseif($request->dash_type=='Monthly Followup'){
            $query->where('lead_journeys.created_at','>=',$request->monthStartDate);
            $query->where('lead_journeys.created_at','<=',$request->monthEndDate);
        }elseif($request->dash_type=='Quarterly Followup'){
            $query->where('lead_journeys.created_at','>=',$request->quarterStartDate);
            $query->where('lead_journeys.created_at','<=',$request->quarterEndDate);
        }elseif($request->dash_type=='Yearly Followup'){
            $query->where('lead_journeys.created_at','>=',$request->yearStartDate);
            $query->where('lead_journeys.created_at','<=',$request->nextYearStartDate);
        }
        
        $leadCount= $query->count();
        
        $query->select('leads.*', 'lead_journeys.*', 'leads.status as lead_status', 'leads.addby as lead_addby', 'lead_journeys.addby as lead_lead_journeys_addby');
        
        $leads = $query->orderBy('lead_journeys.id',$order_by)->paginate(10);
        
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $properties = Property::get();
        
        return view('admin.salescrm.lead-target-followup', compact('leads','leadCount','status','fieldPersons','properties','request'));
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
        $categories = InventoryCategory::where('parent_id', 0)->get();
        $builders = Builder::where('status', 1)->get();
        $societies = Society::where('builder_id', $lead->builder_id)->get();
        return view('admin.salescrm.update', compact('lead', 'roomTypes', 'leadSources', 'properties','ropertySaleType','categories','builders','societies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $saveLead = Lead::findOrFail($id);
        
        
        $saveLead->source = $request->source;
        $saveLead->builder_id = $request->builder;
        $saveLead->society_id = $request->society;
        
        $saveLead->name = $request->name;
        $saveLead->email = $request->email;
        $saveLead->mobile_no = $request->mobile_no;
        $saveLead->alt_mobile_no = $request->alt_mobile_no;
        $saveLead->city = $request->city;
        $saveLead->message = $request->message;
        
        $saveLead->is_profile_checked = $request->is_profile_checked;
        
        $saveLead->property_type = $request->property_type;
        $saveLead->property_sub_type = $request->property_sub_type;
        $saveLead->budget_start = $request->budget_start;
        $saveLead->budget_end = $request->budget_end;
        $saveLead->buy_type = $request->buy_type;
        
        $saveLead->location = $request->location;
        $saveLead->campaigns = $request->campaigns;
        $saveLead->pro_status = $request->pro_status;
        
        $saveLead->flat = $request->flat;
        $saveLead->size = $request->size;
        $saveLead->budget = $request->budget;
        $saveLead->within = $request->within;
        $saveLead->type = $request->type;
        
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
        if ($request->status == 'Bookings') {
            $lead->builder_id = $request->builder;
            $lead->society_id = $request->society;
            $lead->property_id = $request->property;
            $lead->sale_value = $request->sale_value;
            $lead->token_amount = $request->token_amount;
            $lead->our_commission = $request->our_commission;
            $lead->token_collect_flag = '1';
            $lead->token_collect_date = date("Y-m-d");
        }
        
        if ($request->status == 'Meeting Schedule') {
            $lead->meeting_builder = $request->builder;
            $lead->meeting_society = $request->society;
            $lead->meeting_property = $request->property;
            $lead->meeting_with = $request->field_person;
            $lead->meeting_date = $request->meeting_date;
            $lead->meeting_time = $request->meeting_time;
            $lead->meeting_agenda = $request->remark;
        }
        
        if ($request->status == 'Meetings Feedback') {
            $lead->meeting_feedback_builder = $request->builder;
            $lead->meeting_feedback_society = $request->society;
            $lead->meeting_feedback_property = $request->property;
            $lead->meeting_feedback_date = $request->meeting_date;
            $lead->meeting_feedback_time = $request->meeting_time;
        }
        
        if ($request->status == 'EOI Collected') {
            $lead->eoi_collected_builder = $request->builder;
            $lead->eoi_collected_society = $request->society;
            $lead->eoi_collected_property = $request->property;
            $lead->eoi_collected_type = $request->eoi_collected_type;
            $lead->eoi_collected_amount = $request->eoi_collected_amount;
            $lead->eoi_collected_date = $request->eoi_collected_date;
        }
        
        if ($request->status == 'Dead') {
            $lead->dead_date = now();
            $lead->dead_by = auth()->user()->id;
        }
        $lead->save();
        
        
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = $request->status;
        
        if ($request->status == 'Agent') {
            $leadJourney->agent_name = $request->agent_name;
            $leadJourney->agent_country = $request->agent_country;
            $leadJourney->agent_company = $request->agent_company;
            $leadJourney->agent_contact = $request->agent_contact;
            $leadJourney->agent_email = $request->agent_email;
        }
        
        if ($request->status == 'Meeting Schedule') {
            $leadJourney->meeting_builder = $request->builder;
            $leadJourney->meeting_society = $request->society;
            $leadJourney->meeting_property = $request->property;
            $leadJourney->meeting_with = $request->field_person;
            $leadJourney->meeting_date = $request->meeting_date;
            $leadJourney->meeting_time = $request->meeting_time;
        }
        
        if ($request->status == 'Meetings Feedback') {
            $leadJourney->meeting_feedback_builder = $request->builder;
            $leadJourney->meeting_feedback_society = $request->society;
            $leadJourney->meeting_feedback_property = $request->property;
            $leadJourney->meeting_feedback_date = $request->meeting_date;
            $leadJourney->meeting_feedback_time = $request->meeting_time;
        }
        
        if ($request->status == 'EOI Collected') {
            $leadJourney->eoi_collected_builder = $request->builder;
            $leadJourney->eoi_collected_society = $request->society;
            $leadJourney->eoi_collected_property = $request->property;
            $leadJourney->eoi_collected_type = $request->eoi_collected_type;
            $leadJourney->eoi_collected_amount = $request->eoi_collected_amount;
            $leadJourney->eoi_collected_date = $request->eoi_collected_date;
        }
        
        if ($request->status == 'Bookings') {
            $leadJourney->builder = $request->builder;
            $leadJourney->society = $request->society;
            $leadJourney->property = $request->property;
            $leadJourney->sale_value = $request->sale_value;
            $leadJourney->token_amount = $request->token_amount;
            $leadJourney->our_commission = $request->our_commission;
            
        }
        
        if ($request->status == 'SPA') {
            $leadJourney->spa_sign_date = $request->spa_sign_date;
            $leadJourney->spa_sign_client = $request->spa_sign_client;
            $leadJourney->spa_submitted_dev = $request->spa_submitted_dev;
            $FileName = '';
            if ($request->hasFile('spa_attachment')) {
                $file = $request->file('spa_attachment');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->spa_attachment = $FileName;
                $FileName = '';
            }
        }
        
        if ($request->status == 'MOU') {
            $leadJourney->mou_commission_per = $request->mou_commission_per;
            $leadJourney->mou_advance_buyer = $request->mou_advance_buyer;
            $leadJourney->mou_advance_seller = $request->mou_advance_seller;
            $leadJourney->mou_expiry_date = $request->mou_expiry_date;
            $leadJourney->mou_seller_name = $request->mou_seller_name;
            $leadJourney->mou_seller_contact = $request->mou_seller_contact;
            $leadJourney->mou_seller_email = $request->mou_seller_email;
            $leadJourney->mou_buyer_name = $request->mou_buyer_name;
            $leadJourney->mou_buyer_contact = $request->mou_buyer_contact;
            $leadJourney->mou_buyer_email = $request->mou_buyer_email;
            $FileName = '';
            if ($request->hasFile('mou_buyer_attachment')) {
                $file = $request->file('mou_buyer_attachment');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->mou_buyer_attachment = $FileName;
                $FileName = '';
            }
        }
        
        if ($request->status == 'DLD Registration') {
            $leadJourney->dld_sign_date = $request->dld_sign_date;
            $leadJourney->dld_appointment_date = $request->dld_appointment_date;
            $leadJourney->dld_commission_received = $request->dld_commission_received;
            $leadJourney->dld_commission_amount = $request->dld_commission_amount;
        }
        
        if ($request->status == 'Mortgage') {
            $leadJourney->mortgage_downpayment = $request->mortgage_downpayment;
            $leadJourney->mortgage_amount = $request->mortgage_amount;
            $leadJourney->mortgage_commission_bank = $request->mortgage_commission_bank;
        }
        
        
        if ($request->status == 'Bank Loan') {
            $leadJourney->loan_bank_name = $request->loan_bank_name;
            $leadJourney->loan_banker = $request->loan_banker;
            $leadJourney->loan_disbursed_amount = $request->loan_disbursed_amount;
            $leadJourney->loan_sanctioned_date = $request->loan_sanctioned_date;
            $leadJourney->loan_document_status = $request->loan_document_status;
        }
        
        $FileName = '';
        if ($request->status == 'NOC') {
            $leadJourney->noc_apply_date = $request->noc_apply_date;
            $leadJourney->noc_collect_date = $request->noc_collect_date;
            if ($request->hasFile('noc_attachment')) {
                $file = $request->file('noc_attachment');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->noc_attachment = $FileName;
                $FileName = '';
            }
        }

        if ($request->status == 'Agreement To Sale') {
            $leadJourney->agtosale_status = $request->agtosale_status;
            $leadJourney->agtosale_date = $request->agtosale_date;
            $leadJourney->agtosale_time = $request->agtosale_time;
            if ($request->hasFile('agtosale_attachment')) {
                $file = $request->file('agtosale_attachment');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->agtosale_attachment = $FileName;
                $FileName = '';
            }
        }

        if ($request->status == 'Visits') {
            $leadJourney->visit_time = $request->visit_time;
            $leadJourney->visit_date = $request->visit_date;
            $leadJourney->builder = $request->builder;
            $leadJourney->society = $request->society;
            $leadJourney->property = $request->property;
            $leadJourney->field_person = $request->field_person;
        }
        
        

        

        
        if ($request->status == 'Document Collect') {
            if ($request->hasFile('upload_tm')) {
                $file = $request->file('upload_tm');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_tm = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('upload_bba')) {
                $file = $request->file('upload_bba');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_bba = $FileName;
                $FileName = '';
            }

            if ($request->hasFile('upload_tpa')) {
                $file = $request->file('upload_tpa');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_tpa = $FileName;
                $FileName = '';
            }
            
            if ($request->hasFile('upload_ids')) {
                $file = $request->file('upload_ids');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_ids = $FileName;
                $FileName = '';
            }
            
            if ($request->hasFile('upload_notery')) {
                $file = $request->file('upload_notery');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_notery = $FileName;
                $FileName = '';
            }
            
            if ($request->hasFile('upload_sale_dscp')) {
                $file = $request->file('upload_sale_dscp');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_sale_dscp = $FileName;
                $FileName = '';
            }
            
            if ($request->hasFile('upload_other')) {
                $file = $request->file('upload_other');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/users_document'), $FileName);
                $leadJourney->upload_other = $FileName;
                $FileName = '';
            }
        }
        
        if ($request->status == 'Registry') {
            $leadJourney->registry_date = $request->registry_date;
            $leadJourney->registry_status = $request->registry_status;
            $leadJourney->registry_paper_work = $request->registry_paper_work;
            $leadJourney->registry_address = $request->registry_address;
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
        
        $lead_journey_id=$leadJourney->id;
        
        if($request->status == 'Token Collect'){
            $leadPayment = new LeadPayment();
            $leadPayment->lead = $lead->id;
            $leadPayment->lead_journey = $lead_journey_id;
            $leadPayment->user_id = $id;
            $leadPayment->builder_id = $request->builder;
            $leadPayment->society_id = $request->society;
            $leadPayment->property_id = $request->property;
            $leadPayment->amount = $request->sale_value;
            $leadPayment->payment = $request->token_amount;
            $leadPayment->remark = 'Token collected';
            $leadPayment->addby = auth()->user()->id;
            $leadPayment->save();
        }

        $email='marketing@dsl.in';
        $clientData = [
                'name'    => $lead->name,
                'email'    => $lead->email,
                'mobile'    => $lead->mobile_no,
                'status'    => $lead->status,
                'update_date'    => date("d M Y, H:i:s"),
                'action_by'    => auth()->user()->first_name.' '.auth()->user()->last_name,
                
            ];
        Mail::to($email)->send(new LeadStatusChangeMail($clientData));

        return redirect()
            ->back()
            ->with('success', 'Lead Status has been saved Successfully!!');
    }
    
    public function deadLeadCrm(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->status = 'Dead';
        $lead->dead_date = now();
        $lead->dead_by = auth()->user()->id;
        $lead->save();
        
        $leadJourney = new LeadJourney();
        $leadJourney->is_lead = '1';
        $leadJourney->lead = $id;
        $leadJourney->status = 'Dead';
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = 'Lead has been Dead';
        $leadJourney->save();

        return redirect()
            ->back()
            ->with('success', 'Lead has been Dead Successfully!!');
    }
    
    
    public function assignLead(Request $request)
    {
        $assignNum=0;
        if($request->ids=="All"){
            
            
            Lead::where('id','!=',null)->update([
                'assign_emp' => $request->assign_emp,
                'assign_date' => now(),
                'assign_by' => auth()->user()->id,
            ]);
                
            
        }elseif($request->type=="Multiple"){
            
            $ids = $request->ids;
            $ids_array = explode(',', $ids);
            foreach ($ids_array as $id) {
                
                if($id!=''){
                    $lead = Lead::findOrFail($id);
                    
                    $existingAssignEmp = $lead->assign_emp;
                    $newAssignEmpValue = $existingAssignEmp ? $existingAssignEmp . ',' . $request->assign_emp : $request->assign_emp;
                    
                    $lead->assign_emp = $newAssignEmpValue;
                    $lead->assign_date = now();
                    $lead->assign_by = auth()->user()->id;
                    if($lead->status=='Dead'){
                        $lead->status = 'New';
                    }
                    $lead->save();
                    
                    
                    $leadJourney = new LeadJourney();
                    $leadJourney->lead = $id;
                    $leadJourney->status = 'Assigned';
                    
                    $leadJourney->assign_emp = $request->assign_emp;
                    $leadJourney->assign_date = now();
                    $leadJourney->addby = auth()->user()->id;
            
                    $leadJourney->remark = 'Lead assigned';
                    $leadJourney->save();
                    
                    if($lead){
                        $assignNum=$assignNum+1;
                    }
                    
                }
                
            }
            
        }else{
            
            $id = $request->id;
            $lead = Lead::findOrFail($id);
            
            $existingAssignEmp = $lead->assign_emp;
            $newAssignEmpValue = $existingAssignEmp ? $existingAssignEmp . ',' . $request->assign_emp : $request->assign_emp;
            
            $lead->assign_emp = $newAssignEmpValue;
            $lead->assign_date = now();
            $lead->assign_by = auth()->user()->id;
            if($lead->status=='Dead'){
                $lead->status = 'New';
            }
            $lead->save();
            
            $leadJourney = new LeadJourney();
            $leadJourney->lead = $id;
            $leadJourney->status = 'Assigned';
            
            $leadJourney->assign_emp = $request->assign_emp;
            $leadJourney->assign_date = now();
            $leadJourney->addby = auth()->user()->id;
    
            $leadJourney->remark = 'Lead assigned';
            $leadJourney->save();
            
            if($lead){
                $assignNum=$assignNum+1;
            }
            
        }
        
        if($assignNum>0 && $request->assign_emp!=''){
            
            $selectedStaff = User::where('id', '=', $request->assign_emp)->first();
            
            $importData = [
                'assignNum'    => $assignNum,
                'userName'    => $selectedStaff->first_name.' '.$selectedStaff->last_name,
                
            ];
            
            $email=$selectedStaff->email;
            Mail::to($email)->send(new LeadImportMail($importData));
        }
        
        return redirect()
            ->back()
            ->with('success', 'Successfully Assigned!!');
    }
    
    public function assignLead2(Request $request)
    {
        $id = $request->id;
        $lead = Lead::findOrFail($id);
        $lead->assign_emp = $request->assign_emp;
        $lead->assign_date = now();
        $lead->assign_by = auth()->user()->id;
        $lead->save();
        
        $leadJourney = new LeadJourney();
        $leadJourney->lead = $id;
        $leadJourney->status = 'Lead assigned';
        
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
        $leadJourney->status = 'Call '.$request->call_status;
        
        $leadJourney->call_status = $request->call_status;
        $leadJourney->call_date = $request->call_date;
        $leadJourney->call_time = $request->call_time;
        $leadJourney->call_agenda = $request->call_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->call_agenda;
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
        $leadJourney->status = 'Meeting '.$request->meeting_status;
        
        $leadJourney->meeting_status = $request->meeting_status;
        $leadJourney->meeting_with = $request->meeting_with;
        $leadJourney->meeting_date = $request->meeting_date;
        $leadJourney->meeting_time = $request->meeting_time;
        $leadJourney->meeting_agenda = $request->meeting_agenda;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = $request->meeting_agenda;
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
        
        $lead->getLeadJourney()->delete(); // Delete associated lead journeys
        
        $lead->delete(); // Delete the lead itself
        
        return redirect()
            ->back()
            ->with('success', 'Lead has been deleted successfully!');
    }
}
