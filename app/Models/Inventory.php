<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function getInventoryType()
    {
        return $this->belongsTo(MasterValue::class, 'inventory_type');
    }

    public function getInventoryCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category');
    }

    public function getInventorySubCategory()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_sub_category');
    }

    public function getInventoryImages()
    {
        return $this->hasMany(InventoryImage::class, 'inventory_id');
    }

    public function getInventoryAttributes()
    {
        return $this->hasMany(InventoryCategoryAttribute::class, 'inventory_id');
    }

    public function getPropertyName()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function getRoomName()
    {
        return $this->belongsTo(PropertyRoom::class, 'room_id');
    }

    

}
