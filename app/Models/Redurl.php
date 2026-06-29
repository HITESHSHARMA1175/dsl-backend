<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redurl extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    /*public function getProfessionalCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_ids');
    }*/

    /*public function getAppointmentJourney()
    {
        return $this->hasMany(AppointmentJourney::class, 'appointment');
    }
    
    public function getAppointmentAddedBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }*/

    
}
