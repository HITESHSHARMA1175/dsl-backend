<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveDetail extends Model
{
    use HasFactory;

    public function getProperty()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
    
    public function getPropertyOwner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function getTenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function getRoomType()
    {
        return $this->belongsTo(MasterValue::class, 'room_type');
    }

    public function getMoveDetailRent()
    {
        return $this->hasMany(MoveDetailRent::class, 'move_in_id');
    }

    
}
