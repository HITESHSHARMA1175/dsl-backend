<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentJourney extends Model
{
    use HasFactory;


    public function getAppointmentJourneyAddby()
    {
        return $this->belongsTo(User::class, 'add_by');
    }
}
