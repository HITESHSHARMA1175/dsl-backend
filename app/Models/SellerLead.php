<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerLead extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mobile_no', 'alt_mobile_no', 'email', 'property_name', 'owner_id', 'builder_id', 'society_id', 'property_category',
                           'property_sub_category', 'property_size', 'property_bhk', 'country_id','state_id', 'city_id', 'area','street', 'pincode', 'property_tags',
                           'rental_plan_duration', 'rent_per_month', 'early_closure_charges_info', 'free_relocation_info', 'free_upgrade_info', 'seven_days_free_trial',
                           'floor_name', 'unit_no', 'tower_no', 'salable_area', 'base_rate', 'unit_value', 'total_cost', 'outstanding_principle', 'broker_name',
                           'possession_status', 'registration_no', 'loan_on_property', 'loan_bank_name', 'video_link', 'status', 'assign_emp', 'assign_date',
                           'assign_by', 'lead_status', 'call_status', 'call_date', 'call_time', 'call_agenda', 'meeting_status', 'meeting_with', 'meeting_date',
                           'meeting_time', 'meeting_agenda', 'addby'];

    public function getSellerLeadAssignEmp()
    {
        return $this->belongsTo(User::class, 'assign_emp');
    }
    
    public function getSellerLeadJourney()
    {
        return $this->hasMany(SellerLeadJourney::class, 'lead');
    }

    public function getSellerLeadSaleType()
    {
        return $this->belongsTo(MasterValue::class, 'property_bhk');
    }
    
    public function getSellerLeadOwner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function getSellerLeadBuilder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }

    public function getSellerLeadSociety()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function getSellerLeadCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category');
    }

    public function getSellerLeadSubCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_sub_category');
    }

    public function getSellerLeadCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getSellerLeadState()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getSellerLeadCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getSellerLeadTenant()
    {
        return $this->hasMany(MoveDetail::class, 'property_id');
    }

    public function getSellerLeadAttributes()
    {
        return $this->hasMany(SalesLeadCategoryAttribute::class, 'property_id');
    }

    public function getSellerLeadChecklist()
    { 
        return $this->hasMany(PropertyChecklist::class, 'property_id');
    }

    public function getSellerLeadImages()
    {
        return $this->hasMany(SalesLeadImage::class, 'property_id');
    }

    public function getSellerLeadRooms()
    {
        return $this->hasMany(PropertyRoom::class, 'property_id');
    }

    public function getSellerLeadRoomInventory($room_id)
    {
        return $this->hasMany(Inventory::class, 'property_id')->where('room_id', '=', $room_id);
        //return $this->hasMany(PropertyRoomInventory::class, 'property_id');
    }
    
    public function getSellerLeadInventory()
    {
        //return $this->hasMany(PropertyRoomInventory::class, 'property_id')->where('room_id', '=', $room_id);
        return $this->hasMany(Inventory::class, 'property_id');
    }

    // public function roomInventory()
    // {
    //     return $this->belongsToMany(Inventory::class, 'property_room_inventories', 'room_id', 'inventory_id');
    // }

    
}
