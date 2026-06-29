<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    
    public function getTreatmentTreatmentType()
    {
        return $this->belongsTo(MasterValue::class, 'treatment_type'); 
    }


}