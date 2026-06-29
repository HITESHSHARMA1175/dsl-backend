<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    
    protected $fillable = ['is_lead','source','builder_id','society_id', 'name', 'mobile_no', 'email', 'message', 'campaigns', 'assign_emp', 'assign_date', 'assign_by', 'addby'];
    
    public function getDataCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'property_type');
    }
    
    public function getDataSubCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'property_sub_type');
    }
    
    public function getDataDeadBy()
    {
        return $this->belongsTo(User::class, 'dead_by');
    }

    public function getDataConvertBy()
    {
        return $this->belongsTo(User::class, 'converted_by');
    }

    public function getDataAddedBy()
    {
        return $this->belongsTo(User::class, 'addby');
    }

    public function getAssignEmp()
    {
        return $this->belongsTo(User::class, 'assign_emp');
    }

    public function getDataProperty()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getDataSource()
    {
        return $this->belongsTo(MasterValue::class, 'source');
    }

    public function getDataRoomType()
    {
        return $this->belongsTo(MasterValue::class, 'room_type');
    }
    
    public function getDataRoomName()
    {
        return $this->belongsTo(PropertyRoom::class, 'room_id');
    }

    public function getDataJourney()
    {
        return $this->hasMany(DataJourney::class, 'lead')->where('is_lead','0');
    }
    
    public function getDataJourneyLast()
    {
        return $this->hasOne(DataJourney::class, 'lead')->latest();
        //return $this->belongsTo(DataJourney::class, 'lead');
    }
}
