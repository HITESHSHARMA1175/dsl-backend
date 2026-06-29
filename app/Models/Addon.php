<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    public function getAddonService()
    {
        return $this->belongsTo(Property::class, 'parent_id');
    }

    public function getAddonCategory()
    {
        return $this->belongsTo(MasterValue::class, 'parent_id');
    }

    

    
}
