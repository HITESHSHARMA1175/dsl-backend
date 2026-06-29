<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationForm extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function getConsultationClinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic');
    }
    
    public function getConsultationService()
    {
        return $this->belongsTo(PropertyCategory::class, 'service');
    }

  
    
}
