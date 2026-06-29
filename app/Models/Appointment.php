<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    /*public function getProfessionalCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_ids');
    }*/

    public function getAppointmentJourney()
    {
        return $this->hasMany(AppointmentJourney::class, 'appointment');
    }
    
    public function getAppointmentPatient()
    {
        return $this->belongsTo(KiBooking::class, 'app_patient');
    }

    public function getAppRoom()
    {
        return $this->belongsTo(MasterValue::class, 'room');
    }

    public function getAppTreatementType()
    {
        return $this->belongsTo(MasterValue::class, 'treatement_type');
    }

    public function getAppTreatement()
    {
        return $this->belongsTo(Treatment::class, 'treatement');
    }

    public function getAppointmentAddedBy()
    {
        return $this->belongsTo(User::class, 'add_by');
    }

    
}
