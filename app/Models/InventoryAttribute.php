<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAttribute extends Model
{
    use HasFactory;

    public function getInventoryAttributeValue()
    {
        return $this->hasMany(InventoryAttributeValue::class, 'attribute_id');
    }
    
}
