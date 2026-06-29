<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientMedicalHistory extends Model
{
    use HasFactory;
    
    public function getParentConcern()
    {
        return $this->belongsTo(Concern::class, 'parent_id'); 
    }

    public function getConcern()
    {
        return $this->belongsTo(MasterValue::class, 'concern_types'); 
    }


}