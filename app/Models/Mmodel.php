<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mmodel extends Model
{
    use HasFactory;
    
    public function getModelBrand()
    {
        return $this->belongsTo(Brand::class, 'brand'); 
    }


}