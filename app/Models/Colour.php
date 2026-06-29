<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    use HasFactory;
    
    public function getColourBrand()
    {
        return $this->belongsTo(Brand::class, 'brand'); 
    }
    
    public function getColourModel()
    {
        return $this->belongsTo(Mmodel::class, 'model'); 
    }
    
    public function getColourVariant()
    {
        return $this->belongsTo(Variant::class, 'variant'); 
    }


}