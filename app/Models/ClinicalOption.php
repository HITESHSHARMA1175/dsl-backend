<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalOption extends Model
{
    use HasFactory;
    
    public function getParentClinicalOption()
    {
        return $this->belongsTo(ClinicalOption::class, 'parent_id'); 
    }

    public function getClinicalOption()
    {
        return $this->belongsTo(MasterValue::class, 'clinical_option'); 
    }


}