<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRoom extends Model
{
    use HasFactory;

    public function getRoomType()
    {
        return $this->belongsTo(MasterValue::class, 'room_type');
    }

    public function getRoomTypeName()
    {
        return $this->belongsTo(MasterValue::class, 'rooms');
    }

}
