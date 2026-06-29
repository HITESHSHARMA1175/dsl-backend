<?php

namespace App\Http\Controllers\Admin\DataCrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master;
use App\Models\PropertyRoom;
use App\Models\Property;
use App\Models\User;
use App\Models\Lead;
use App\Models\Data;
use App\Models\DataJourney;
use App\Models\DataPayment;
use App\Models\InventoryCategory;
use App\Models\DataImportLog;
use App\Models\DataError;
use App\Models\Builder;
use App\Models\Society;
use Str;

use App\Exports\DataExport;

// use App\Exports\ExportReceiving;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataDataImport;

use Mail;
use App\Mail\DataImportMail;
use App\Mail\DataStatusChangeMail;


class DataCrmControllerInAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = 'New';
        $leads = Data::where('is_lead', '0')->where('data_status', $status)
            ->orderByDesc('id')
            ->paginate(10);
        $properties = Property::get();
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        /*$fieldPersons = User::where('emp_type','=', 'Staff')->whereHas('getEmpDesignation', function($query) {
            $query->where('name', '=', 'Telesales');
        })->get();*/

        return view('admin.datacrm.index', compact('leads', 'status', 'properties', 'fieldPersons'));
    }
    
    public function data_import_log()
    {
        
        if(auth()->user()->is_admin=='1'){
            $properties = DataImportLog::orderByDesc('id')->paginate(10);
            $propertyCount = DataImportLog::count();
        }else{
            $properties = DataImportLog::where('addby', auth()->user()->id)->orderByDesc('id')->paginate(10);
            $propertyCount = DataImportLog::where('addby', auth()->user()->id)->count();
        }
        
        return view('admin.datacrm.import-log', compact('properties','propertyCount'));
    }
    
    
    public function data_import_failed_log(Request $request)
    {
        
        $id = $request->id;
        
        if(auth()->user()->is_admin=='1'){
            $properties = DataError::where('import_id', $id)->orderByDesc('id')->paginate(10);
            $propertyCount = DataError::where('import_id', $id)->count();
        }else{
            $properties = DataError::where('import_id', $id)->where('addby', auth()->user()->id)->orderByDesc('id')->paginate(10);
            $propertyCount = DataError::where('import_id', $id)->where('addby', auth()->user()->id)->count();
        }
        
        return view('admin.datacrm.import-failed-log', compact('properties','propertyCount'));
    }
    
    /**
     * import sales lead data.
     */
    public function dataDataImportdata(Request $request)
    {
        $staff_id=$request->staff_id;
        try {
            Excel::import(new DataDataImport($staff_id), $request->file('file')->store('temp'));
            
            $import_last_data = DataImportLog::latest()->first();
            $FileName = '';
            if ($request->file('file')) {
                $file = $request->file('file');
                $FileName = rand(11, 99) . Str::random(15) . '.' . $file->getClientOriginalExtension();
                $path = $file->move(public_path('uploads/dataimport'), $FileName);
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
        return view('admin.datacrm.create', compact('roomTypes', 'leadSources', 'properties','ropertySaleType','categories','builders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return view('admin.datacrm.create');
        $saveData = new Data();

        $saveData->is_lead = '0';
        $saveData->source = $request->source;
        $saveData->builder_id = $request->builder;
        $saveData->society_id = $request->society;
        
        $saveData->name = $request->name;
        $saveData->email = $request->email;
        $saveData->mobile_no = $request->mobile_no;
        $saveData->alt_mobile_no = $request->alt_mobile_no;
        $saveData->city = $request->city;
        $saveData->message = $request->message;
        
        $saveData->property_type = $request->property_type;
        $saveData->property_sub_type = $request->property_sub_type;
        $saveData->budget_start = $request->budget_start;
        $saveData->budget_end = $request->budget_end;
        $saveData->buy_type = $request->buy_type;
        
        $saveData->location = $request->location;
        $saveData->campaigns = $request->campaigns;
        $saveData->pro_status = $request->pro_status;
        
        $saveData->flat = $request->flat;
        $saveData->size = $request->size;
        $saveData->budget = $request->budget;
        $saveData->within = $request->within;
        $saveData->type = $request->type;
        
        if(auth()->user()->emp_type=='Staff'){
            $saveData->assign_emp = auth()->user()->id;
            $saveData->assign_date = now();
            $saveData->assign_by = auth()->user()->id;
        }
        
        $saveData->addby = auth()->user()->id;

        $saveData->save();
        return redirect()
            ->back()
            ->with('success', 'Data has been saved Successfully!!');
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
        $query = Data::query();
        $query->where('is_lead','0');
        
        
        if (auth()->user()->is_admin == '1' && $request->staff_id=='') {
            
        }elseif (auth()->user()->emp_type == 'Staff' || $request->staff_id!='') {
            
            $query->whereIn('assign_emp', $subordinateIds);
            
        }elseif (auth()->user()->emp_type == 'Agent') {
            
            $query->whereIn('addby', $subordinateIds);
            
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
            $query->where('data_status', $status)->orwhere('data_status', 'Re Visits');
        } else {
            $query->where('data_status', $status);
        }
        
        if($request->export_value == '1'){
            //return 11;
            return Excel::download(new DataExport($query), 'data.xlsx');
        }
        
        $leadCount= $query->count();
        
        $leads = $query->orderBy('id',$order_by)->paginate(10);
        
        
        if (auth()->user()->is_admin == '1' && $request->staff_id=='') {
            
            $allCount = Data::query()->where('is_lead', '0')->where('id','!=', '')->whereIn('id', $leadIds)->count();
            $newCount = Data::query()->where('is_lead', '0')->where('data_status', 'New')->whereIn('id', $leadIds)->count();
            $CToDCount = Data::query()->where('is_lead', '0')->where('data_status', 'Convert To Lead')->whereIn('id', $leadIds)->count();
            $followUpCount = Data::query()->where('is_lead', '0')->where('data_status', 'Follow Up')->whereIn('id', $leadIds)->count();
            $notInterestedCount = Data::query()->where('is_lead', '0')->where('data_status', 'Not Interested')->whereIn('id', $leadIds)->count();
            $notAnsweredCount = Data::query()->where('is_lead', '0')->where('data_status', 'Not Answered')->whereIn('id', $leadIds)->count();
            $visitCount = Data::query()->where('is_lead', '0')->where('data_status', 'Visits')->orwhere('data_status', 'Re Visits')->whereIn('id', $leadIds)->count();
            $tokenCollectCount = Data::query()->where('is_lead', '0')->where('data_status', 'Token Collect')->whereIn('id', $leadIds)->count();
            $agToSaleCount = Data::query()->where('is_lead', '0')->where('data_status', 'Agreement To Sale')->whereIn('id', $leadIds)->count();
            $nocCount = Data::query()->where('is_lead', '0')->where('data_status', 'NOC')->whereIn('id', $leadIds)->count();
            $documentCollectCount = Data::query()->where('is_lead', '0')->where('data_status', 'Document Collect')->whereIn('id', $leadIds)->count();
            $registryCount = Data::query()->where('is_lead', '0')->where('data_status', 'Registry')->whereIn('id', $leadIds)->count();
            $bankLoanCount = Data::query()->where('is_lead', '0')->where('data_status', 'Bank Loan')->whereIn('id', $leadIds)->count();
            $deadCount = Data::query()->where('is_lead', '0')->where('data_status', 'Dead')->whereIn('id', $leadIds)->count();
            
        }else if(auth()->user()->emp_type=='Staff' || $request->staff_id!=''){
            
            $query = Data::query();
            $query->where('id','!=','');
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $allCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'New');
            $newCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Convert To Lead');
            $CToDCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Follow Up');
            $followUpCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Not Interested');
            $notInterestedCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Not Answered');
            $notAnsweredCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where(function ($query) {
                $query->where('data_status', 'Visits')->orwhere('data_status', 'Re Visits');
            });
            $visitCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Token Collect');
            $tokenCollectCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Agreement To Sale');
            $agToSaleCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'NOC');
            $nocCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Document Collect');
            $documentCollectCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Registry');
            $registryCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Bank Loan');
            $bankLoanCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('assign_emp', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Dead');
            $deadCount = $query->orderByDesc('id')->count();
            
        }else if(auth()->user()->emp_type=='Agent'){
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->where('id','!=','');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $allCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'New');
            $newCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Convert To Lead');
            $CToDCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Follow Up');
            $followUpCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Not Interested');
            $notInterestedCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Not Answered');
            $notAnsweredCount = $query->orderByDesc('id')->count();
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where(function ($query) {
                $query->where('data_status', 'Visits')->orwhere('data_status', 'Re Visits');
            });
            $visitCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Token Collect');
            $tokenCollectCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Agreement To Sale');
            $agToSaleCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'NOC');
            $nocCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Document Collect');
            $documentCollectCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Registry');
            $registryCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Bank Loan');
            $bankLoanCount = $query->orderByDesc('id')->count();
            
            
            $query = Data::query();
            $query->where('is_lead','0');
            $query->whereIn('addby', $subordinateIds);
            $query->whereIn('id', $leadIds);
            $query->where('data_status', 'Dead');
            $deadCount = $query->orderByDesc('id')->count();
        }
        
        
        
        
        $properties = Property::get();
        $fieldPersons = User::where('emp_type','=', 'Staff')->get();
        $categories = InventoryCategory::where('parent_id', 0)->get();
        /*$fieldPersons = User::where('emp_type','=', 'Staff')->whereHas('getEmpDesignation', function($query) {
            $query->where('name', '=', 'Telesales');
        })->get();*/
        return view('admin.datacrm.index', compact('empIds', 'leads', 'status', 'properties', 'allCount', 'fieldPersons','newCount','followUpCount','visitCount'
        ,'tokenCollectCount','agToSaleCount','nocCount','documentCollectCount','registryCount','bankLoanCount','deadCount','CToDCount','notInterestedCount','notAnsweredCount',
        'categories','request','leadCount'));
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
        $lead = Data::findOrFail($id); 
        $categories = InventoryCategory::where('parent_id', 0)->get();
        $builders = Builder::where('status', 1)->get();
        $societies = Society::where('builder_id', $lead->builder_id)->get();
        return view('admin.datacrm.update', compact('lead', 'roomTypes', 'leadSources', 'properties','ropertySaleType','categories','builders','societies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $saveData = Data::findOrFail($id);
        
        
        $saveData->source = $request->source;
        $saveData->builder_id = $request->builder;
        $saveData->society_id = $request->society;
        
        $saveData->name = $request->name;
        $saveData->email = $request->email;
        $saveData->mobile_no = $request->mobile_no;
        $saveData->alt_mobile_no = $request->alt_mobile_no;
        $saveData->city = $request->city;
        $saveData->message = $request->message;
        
        $saveData->is_called = $request->is_called;
        $saveData->is_connected_call = $request->is_connected_call;
        
        $saveData->property_type = $request->property_type;
        $saveData->property_sub_type = $request->property_sub_type;
        $saveData->budget_start = $request->budget_start;
        $saveData->budget_end = $request->budget_end;
        $saveData->buy_type = $request->buy_type;
        
        $saveData->location = $request->location;
        $saveData->campaigns = $request->campaigns;
        $saveData->pro_status = $request->pro_status;
        
        $saveData->flat = $request->flat;
        $saveData->size = $request->size;
        $saveData->budget = $request->budget;
        $saveData->within = $request->within;
        $saveData->type = $request->type;
        
        $saveData->save();
        return redirect()
            ->back()
            ->with('success', 'Data has been saved Successfully!!');
    }
    
    public function changeDataStatus(Request $request)
    {
        $id = $request->id;
        $lead = Data::findOrFail($id);
        $lead->data_status = $request->status;
        if ($request->status == 'Token Collect') {
            $lead->builder_id = $request->builder;
            $lead->society_id = $request->society;
            $lead->property_id = $request->property;
            $lead->sale_value = $request->sale_value;
            $lead->token_amount = $request->token_amount;
            $lead->token_collect_flag = '1';
            $lead->token_collect_date = date("Y-m-d");
        }
        $lead->save();
        
        $leadJourney = new DataJourney();
        $leadJourney->is_lead = '0';
        $leadJourney->lead = $id;
        $leadJourney->status = $request->status;

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
        
        if ($request->status == 'Token Collect') {
            $leadJourney->builder = $request->builder;
            $leadJourney->society = $request->society;
            $leadJourney->property = $request->property;
            $leadJourney->sale_value = $request->sale_value;
            $leadJourney->token_amount = $request->token_amount;
            
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
            $leadPayment = new DataPayment();
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

        return redirect()
            ->back()
            ->with('success', 'Data Status has been saved Successfully!!');
    }
    
    public function convertDataToLead(Request $request)
    {
        $id = $request->id;
        $lead = Data::findOrFail($id);
        $lead->data_status = 'Convert To Lead';
        $lead->converted_date = now();
        $lead->converted_by = auth()->user()->id;
        $lead->save();
        //return $lead->id;
        // Create a new Lead instance
        $saveLead = new Lead();
        $saveLead->data_id = $lead->id;
        $saveLead->source = $lead->source;
        $saveLead->builder_id = $lead->builder_id;
        $saveLead->society_id = $lead->society_id;
        $saveLead->name = $lead->name;
        $saveLead->email = $lead->email;
        $saveLead->mobile_no = $lead->mobile_no;
        $saveLead->alt_mobile_no = $lead->alt_mobile_no;
        $saveLead->city = $lead->city;
        $saveLead->message = $lead->message;
        
        $saveLead->property_type = $lead->property_type;
        $saveLead->property_sub_type = $lead->property_sub_type;
        $saveLead->budget_start = $lead->budget_start;
        $saveLead->budget_end = $lead->budget_end;
        $saveLead->buy_type = $lead->buy_type;
        
        $saveLead->location = $lead->location;
        $saveLead->campaigns = $lead->campaigns;
        $saveLead->pro_status = $lead->pro_status;
        
        $saveLead->flat = $lead->flat;
        $saveLead->size = $lead->size;
        $saveLead->budget = $lead->budget;
        $saveLead->within = $lead->within;
        $saveLead->type = $lead->type;
        $saveLead->assign_emp = $lead->assign_emp;
        $saveLead->assign_date = now();
        $saveLead->assign_by = $lead->assign_by;
        $saveLead->addby = auth()->user()->id;
        $saveLead->save();
        
        $leadJourney = new DataJourney();
        $leadJourney->is_lead = '0';
        $leadJourney->lead = $id;
        $leadJourney->status = 'Convert To Lead';
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = 'Data has been Converted To Lead';
        $leadJourney->save();

        $email='marketing@dsl.in';
        $clientData = [
                'name'    => $lead->name,
                'email'    => $lead->email,
                'mobile'    => $lead->mobile_no,
                'status'    => $lead->data_status,
                'update_date'    => date("d M Y, H:i:s"),
                'action_by'    => auth()->user()->first_name.' '.auth()->user()->last_name,
                
            ];
        Mail::to($email)->send(new DataStatusChangeMail($clientData));

        return redirect()
            ->back()
            ->with('success', 'Data has been Converted Successfully!!');
    }
    
    public function deadDataCrm(Request $request)
    { 
        
        $id = $request->id;
        $lead = Data::findOrFail($id);
        if($request->status=='Dead'){
            $lead->data_status = 'Dead';
            $lead->dead_date = now();
            $lead->dead_by = auth()->user()->id;
        }else{
            $lead->data_status = $request->status;
        }
        $lead->save();
        
        $leadJourney = new DataJourney();
        $leadJourney->is_lead = '0';
        $leadJourney->lead = $id;
        $leadJourney->status = $request->status;
        
        $leadJourney->addby = auth()->user()->id;

        $leadJourney->remark = 'Status has been changed';
        $leadJourney->save();
        
        $email='marketing@dsl.in';
        $clientData = [
                'name'    => $lead->name,
                'email'    => $lead->email,
                'mobile'    => $lead->mobile_no,
                'status'    => $lead->data_status,
                'update_date'    => date("d M Y, H:i:s"),
                'action_by'    => auth()->user()->first_name.' '.auth()->user()->last_name,
                
            ];
        Mail::to($email)->send(new DataStatusChangeMail($clientData));
        
        return redirect()
            ->back()
            ->with('success', 'Status has been changes Successfully!!');
    }
        
    public function assignData(Request $request)
    {
        $assignNum=0;
        if($request->ids=="All"){
            
            
            Data::where('id','!=',null)->update([
                'assign_emp' => $request->assign_emp,
                'assign_date' => now(),
                'assign_by' => auth()->user()->id,
            ]);
                
            
        }elseif($request->type=="Multiple"){
            
            $ids = $request->ids;
            $ids_array = explode(',', $ids);
            foreach ($ids_array as $id) {
                
                if($id!=''){
                    $lead = Data::findOrFail($id);
                    $lead->assign_emp = $request->assign_emp;
                    $lead->assign_date = now();
                    $lead->assign_by = auth()->user()->id;
                    if($lead->data_status=='Dead'){
                        $lead->data_status = 'New';
                    }
                    $lead->save();
                    
                    
                    $leadJourney = new DataJourney();
                    $leadJourney->lead = $id;
                    $leadJourney->status = 'Assigned';
                    
                    $leadJourney->assign_emp = $request->assign_emp;
                    $leadJourney->assign_date = now();
                    $leadJourney->addby = auth()->user()->id;
            
                    $leadJourney->remark = 'Data assigned';
                    $leadJourney->save();
                    
                    if($lead){
                        $assignNum=$assignNum+1;
                    }
                }
                
            }
            
        }else{
            
            $id = $request->id;
            $lead = Data::findOrFail($id);
            $lead->assign_emp = $request->assign_emp;
            $lead->assign_date = now();
            $lead->assign_by = auth()->user()->id;
            if($lead->data_status=='Dead'){
                $lead->data_status = 'New';
            }
            $lead->save();
            
            $leadJourney = new DataJourney();
            $leadJourney->lead = $id;
            $leadJourney->status = 'Assigned';
            
            $leadJourney->assign_emp = $request->assign_emp;
            $leadJourney->assign_date = now();
            $leadJourney->addby = auth()->user()->id;
    
            $leadJourney->remark = 'Data assigned';
            $leadJourney->save();
            
            if($lead){
                $assignNum=$assignNum+1;
            }
            
        }
        
        if($assignNum>=0 && $request->assign_emp!=''){
        
            $selectedStaff = User::where('id', '=', $request->assign_emp)->first();
            
            $importData = [
                'assignNum'    => $assignNum,
                'userName'    => $selectedStaff->first_name.' '.$selectedStaff->last_name,
                
            ];
            
            $email=$selectedStaff->email;
            Mail::to($email)->send(new DataImportMail($importData));
        }
        
        
        return redirect()
            ->back()
            ->with('success', 'Successfully Assigned!!');
    }
    
    public function updateCall(Request $request)
    {
        $id = $request->id;
        $lead = Data::findOrFail($id);
        $lead->call_status = $request->call_status;
        $lead->call_date = $request->call_date;
        $lead->call_time = $request->call_time;
        $lead->call_agenda = $request->call_agenda;
        $lead->save();
        
        $leadJourney = new DataJourney();
        $leadJourney->is_lead = '0';
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
        $lead = Data::findOrFail($id);
        $lead->meeting_status = $request->meeting_status;
        $lead->meeting_with = $request->meeting_with;
        $lead->meeting_date = $request->meeting_date;
        $lead->meeting_time = $request->meeting_time;
        $lead->meeting_agenda = $request->meeting_agenda;
        $lead->save();
        
        $leadJourney = new DataJourney();
        $leadJourney->is_lead = '0';
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
        $lead = Data::findOrFail($id);
        
        $lead->getDataJourney()->delete(); // Delete associated lead journeys
        
        $lead->delete();
        return redirect()
            ->back()
            ->with('success', 'Data has been Deleted Successfully!!');
    }
}
