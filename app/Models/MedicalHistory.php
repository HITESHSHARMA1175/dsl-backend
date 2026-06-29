<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;
    
    public function getMedicalHistory()
    {
        return $this->belongsTo(MasterValue::class, 'medical_history'); 
    }


}