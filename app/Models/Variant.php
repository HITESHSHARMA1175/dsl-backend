<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    
    public function getVariantBrand()
    {
        return $this->belongsTo(Brand::class, 'brand'); 
    }
    
    public function getVariantModel()
    {
        return $this->belongsTo(Mmodel::class, 'model'); 
    }


}