<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['property_name', 'owner_id', 'builder_id', 'society_id', 'property_category', 'property_sub_category', 'country_id', 'state_id',
                           'city_id', 'area', 'street', 'pincode', 'property_tags', 'rental_plan_duration', 'rent_per_month', 'early_closure_charges_info',
                           'free_relocation_info', 'free_upgrade_info', 'seven_days_free_trial'];

    public function getParentService()
    {
        return $this->belongsTo(Property::class, 'parent_id');
    }

    public function getPropertyCatSlug()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category')
                    ->select('id', 'category_slug'); // Fetch only `id` and `category_slug`
    }

    public function getPropertySaleType()
    {
        return $this->belongsTo(MasterValue::class, 'property_bhk');
    }
    
    public function getPropertyOwner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function getPropertyBuilder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }

    public function getPropertySociety()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function getPropertyCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category');
    }

    public function getPropertySubCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_sub_category');
    }

    public function getPropertyCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function getPropertyState()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function getPropertyCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getPropertyTenant()
    {
        return $this->hasMany(MoveDetail::class, 'property_id');
    }

    public function getPropertyAttributes()
    {
        return $this->hasMany(PropertyCategoryAttribute::class, 'property_id');
    }

    public function getPropertyChecklist()
    { 
        return $this->hasMany(PropertyChecklist::class, 'property_id');
    }

    public function getPropertyImages()
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    public function getPropertyRooms()
    {
        return $this->hasMany(PropertyRoom::class, 'property_id');
    }

    public function getPropertyRoomInventory($room_id)
    {
        return $this->hasMany(Inventory::class, 'property_id')->where('room_id', '=', $room_id);
        //return $this->hasMany(PropertyRoomInventory::class, 'property_id');
    }
    
    public function getPropertyInventory()
    {
        //return $this->hasMany(PropertyRoomInventory::class, 'property_id')->where('room_id', '=', $room_id);
        return $this->hasMany(Inventory::class, 'property_id');
    }

    // public function roomInventory()
    // {
    //     return $this->belongsToMany(Inventory::class, 'property_room_inventories', 'room_id', 'inventory_id');
    // }

    
}
