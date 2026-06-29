<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadError extends Model
{
    use HasFactory;
    
    protected $fillable = ['import_id','is_lead','source', 'name', 'mobile_no', 'email', 'city', 'message', 'campaigns', 'developer', 'project', 'reason', 'assign_emp', 'assign_date', 'assign_by', 'addby'];
    
    
}
