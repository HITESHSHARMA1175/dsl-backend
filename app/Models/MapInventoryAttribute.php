<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapInventoryAttribute extends Model
{
    use HasFactory;
    //protected $table = 'map_inventory_attributes';

    public function getInventoryCategrory()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_category_id');
    }

    public function getInventorySubCategrory()
    {
        return $this->belongsTo(InventoryCategory::class, 'inventory_sub_category_id');
    }

    public function getInventoryAttribute()
    {
        return $this->belongsTo(InventoryAttribute::class, 'attribute_id');
    }
}
