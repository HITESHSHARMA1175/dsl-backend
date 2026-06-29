<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAttributeValue extends Model
{
    use HasFactory;

    public function getInventoryAttribute()
    {
        return $this->belongsTo(InventoryAttribute::class, 'attribute_id'); 
    }
}
