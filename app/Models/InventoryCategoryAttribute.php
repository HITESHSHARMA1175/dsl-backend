<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryAttribute;

class InventoryCategoryAttribute extends Model
{
    use HasFactory;

    public function getInventoryAttribute()
    {
        return $this->belongsTo(InventoryAttribute::class, 'attribute_id');
    }

    public function getInventoryAttributeValue()
    {
        return $this->belongsTo(InventoryAttributeValue::class, 'attribute_value_id');
    }
}
