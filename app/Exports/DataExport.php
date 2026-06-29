<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Data;

class DataExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Added By',
            'Add Date',
            'Source',
            'Name',
            'Email',
            'Mobile',
            'Alt Mobile',
            'City',
            'message',
            'Status',
            'Assign Emp Name',
            'Assign Emp Designation',
            'Assign Emp Mobile',
            'Assign Date',
        ];
    }

    public function query()
    {
        return $this->query;
    }

    // Implement WithMapping to add custom column data
    public function map($row): array
    {
        
        if(@$row->getAssignEmp->id!=''){
            $assign_emp_name = @$row->getAssignEmp->first_name.' '.@$row->getAssignEmp->last_name;
            $assign_emp_designation = @$row->getAssignEmp->getEmpDesignation->name;
            $assign_emp_mobile = @$row->getAssignEmp->mobile_no;
            $assign_date =date('d M Y',strtotime($row->assign_date));
        }else{
            $assign_emp_name='';
            $assign_emp_designation='';
            $assign_emp_mobile='';
            $assign_date='';
        }
        
        return [
            $row->id,
            @$row->getDataAddedBy->first_name.' '.@$row->getDataAddedBy->last_name,
            optional($row->created_at)->tz('Asia/Kolkata')->format("d M Y H:i A"),
            @$row->source,
            $row->name,
            $row->email,
            $row->mobile_no,
            $row->alt_mobile_no,
            $row->city,
            $row->message,
            $row->data_status,
            $assign_emp_name,
            $assign_emp_designation,
            $assign_emp_mobile,
            $assign_date,
        ];
    }
}
