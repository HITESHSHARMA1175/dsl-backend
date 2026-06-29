<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    
    protected $fillable = ['is_lead','source','builder_id','society_id', 'name', 'mobile_no', 'email', 'message', 'campaigns', 'assign_emp', 'assign_date', 'assign_by', 'addby'];

    public function getLeadCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'property_type');
    }
    
    public function getLeadSubCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'property_sub_type');
    }

    public function getLeadAddedBy()
    {
        return $this->belongsTo(User::class, 'addby');
    }

    public function getAssignEmp()
    {
        return $this->belongsTo(User::class, 'assign_emp');
    }
    
    public function getAssignMultipleEmp($assign_emp)
    {
        
        $assign_emp_ids = explode(',', $assign_emp);

        return  $assingEmployees = User::select('id','first_name','last_name','mobile_no')->whereIn('id', $assign_emp_ids)->get();

        //$assingEmployeesIds = $assingEmployees->pluck('id');

        //return $assingEmployeesIds->implode(', ');
    }

    public function getLeadProperty()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getLeadSource()
    {
        return $this->belongsTo(MasterValue::class, 'source');
    }

    public function getLeadRoomType()
    {
        return $this->belongsTo(MasterValue::class, 'room_type');
    }
    
    public function getLeadRoomName()
    {
        return $this->belongsTo(PropertyRoom::class, 'room_id');
    }

    public function getDataJourney()
    {
        return $this->hasMany(LeadJourney::class, 'lead')->where('is_lead','0');
    }
    
    public function getLeadJourney()
    {
        return $this->hasMany(LeadJourney::class, 'lead')->where('is_lead','1');
    }
    
    public function getLeadJourneyLast()
    {
        return $this->hasOne(LeadJourney::class, 'lead')->latest();
        //return $this->belongsTo(LeadJourney::class, 'lead');
    }
}
