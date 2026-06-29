<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

use Exception;

use App\Models\LeadError;
use App\Models\LeadImportLog;
use App\Models\MasterValue;
use App\Models\Lead;
use App\Models\LeadJourney;
use App\Models\User;
use App\Models\Builder;
use App\Models\Society;
use Maatwebsite\Excel\Concerns\ToModel;

use Mail;
use App\Mail\LeadImportMail;

class SalesDataImport implements ToCollection, WithHeadingRow
{
    
    private $staff_id;

    public function __construct($staff_id)
    {
        $this->staff_id = $staff_id;
    }
    
    public function collection(Collection $row)
    {
        
       
        
        
        // Validate
        $validator = Validator::make(
            $row->toArray(),
            [
                //'*.company_name' => 'required|exists:clients,company_name',
                //'*.file_number' => 'required|unique:receivings,file_number',
                //'*.container' => 'required|unique:receivings,container',
                //'*.cargo_id' => 'required|unique:cargos,cargo_id',
                // '*.ctn_count' => 'required',
                // '*.total_wt' => 'required',
                // '*.total_cbm' => 'required',
                // '*.whse_id' => 'required',
                // '*.po' => 'required',
                // '*.fba_id' => 'required',
            ],
            [
                //'*.company_name.required' => 'The company name field is required.',
                //'*.company_name.exists' => 'The company name does not exist.',
                // '*.cargo_id.required' => 'Cargo ID Required for all rows.',
            ]
        );

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        // }

        //$validator->validate();

        $rows = $row->toArray();
        $receiving_id = '';
        $duplicate=0;
        $assignNum=0;
        foreach ($rows as $key => $data) {
            
            $duplicate_flag='0';
            $reason='0';

            //$randomFieldPerson = User::where('emp_type', '=', 'Staff')->inRandomOrder()->first();
            
            @$randomFieldPerson = User::where('emp_type','=', 'Staff')->whereHas('getEmpDesignation', function($query) {
                $query->where('name', '=', 'Telesales');
            })->inRandomOrder()->first();
            
            /*if($data['source']!=''){
                @$source = MasterValue::where('MasterValue', $data['source'])->first();
                $source_id=@$source->id!='' ?$source->id:0;
            }else{
                $source_id=0;
            }*/
            
            if($data['developer']!=''){
                @$builder = Builder::where('builder_name', $data['developer'])->first();
                
                if(@$builder->id!=''){
                    $builder_id=@$builder->id!='' ?$builder->id:0;
                }else{
                    $duplicate_flag='1';
                    $reason="Incorrect developer.";
                }
            }else{
                $builder_id=0;
            }
            
            if($data['project']!=''){
                @$society = Society::where('society_name', $data['project'])->first();
                
                if(@$society->id!=''){
                    $society_id=@$society->id!='' ?$society->id:0;
                }else{
                    $duplicate_flag='1';
                    $reason="Incorrect project.";
                }
            }else{
                $society_id=0;
            }
            
            @$import_id_last1 = Lead::where('mobile_no',$data['mobile'])->orderBy('id', 'DESC')->pluck('id')->first();
            if(@$import_id_last1!=''){
                $duplicate_flag='1';
                $reason="Duplicate mobile.";
            }
                
            if(@$duplicate_flag=='1'){
                
                $duplicate=$duplicate+1;
                  
            }else{
            
            $addSalesdata = Lead::create([
                'is_lead' => '1',
                'source' => $data['source'],
                'builder_id' => $builder_id,
                'society_id' => $society_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile_no' => $data['mobile'],
                'city' => $data['city'],
                'message' => $data['message'],
                'campaigns' => $data['campaigns'],
                'assign_emp' => @$this->staff_id!='' ?$this->staff_id:null,
                'assign_date' => @$this->staff_id!='' ?now():null,
                'assign_by' => @$this->staff_id!='' ?auth()->user()->id:null,
                //'assign_emp' => @$randomFieldPerson->id,
                //'assign_date' => now(),
                //'assign_by' => auth()->user()->id,
                'addby' => auth()->user()->id,
            ]);
            
            $leadJourney = new LeadJourney();
            $leadJourney->lead = @$addSalesdata->id;
            $leadJourney->is_lead = '1';
            $leadJourney->status = 'New';
            //$leadJourney->status = 'Assigned';
            
            //$leadJourney->assign_emp =  @$randomFieldPerson->id;
            //$leadJourney->assign_date = now();
            //$leadJourney->remark = 'Data assigned';
            
            $leadJourney->addby = auth()->user()->id;
            $leadJourney->remark = 'Data added';
            $leadJourney->save();
            
            if($addSalesdata){
                $assignNum=$assignNum+1;
            }
        
            }
            
            
            if($data['mobile']!=''){
                if($key==0){
                    
                    $saveImportLog = new LeadImportLog();
                    $saveImportLog->total_record = count($rows);
                    $saveImportLog->duplicate = $duplicate;
                    $saveImportLog->updated = 0;
                    $saveImportLog->total_new = $assignNum;
                    $saveImportLog->addby = auth()->user()->id;
                    $saveImportLog->save();
                    
                    $import_id_last = $saveImportLog->id;
                    
                }else{
                    
                    $saveImportLog = LeadImportLog::findOrFail($import_id_last);
                    $saveImportLog->duplicate = $duplicate;
                    $saveImportLog->updated = 0;
                    $saveImportLog->total_new = $assignNum;
                    $saveImportLog->save();
                    
                }
            }   
            
            if(@$duplicate_flag=='1'){
                $addSalesdataError = LeadError::create([
                    'import_id' => $import_id_last,
                    'is_lead' => '1',
                    'source' => $data['source'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'mobile_no' => $data['mobile'],
                    'city' => $data['city'],
                    'message' => $data['message'],
                    'campaigns' => $data['campaigns'],
                    'developer' => $data['developer'],
                    'project' => $data['project'],
                    'reason' => $reason,
                    'assign_emp' => @$this->staff_id!='' ?$this->staff_id:null,
                    'assign_date' => @$this->staff_id!='' ?now():null,
                    'assign_by' => @$this->staff_id!='' ?auth()->user()->id:null,
                    'addby' => auth()->user()->id,
                ]);
            }
            
            
           
        }
        
        if($assignNum>0 && $this->staff_id!=''){
            
            $selectedStaff = User::where('id', '=', $this->staff_id)->first();
            
            $importData = [
                'assignNum'    => $assignNum,
                'userName'    => $selectedStaff->first_name.' '.$selectedStaff->last_name,
                
            ];
            
            $email=$selectedStaff->email;
            //$email='akundan55@gmail.com';
            Mail::to($email)->send(new LeadImportMail($importData));
        }
       
    }
    
   
}
