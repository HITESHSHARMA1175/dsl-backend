<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiBooking extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    public function getKiBookingUser()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
    
    public function getKiBookingClinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
    
    public function getKiBookingProfessional()
    {
        return $this->belongsTo(Professional::class, 'profession_id');
    }
    
    /*public function getKiBookinService()
    {
        return $this->belongsTo(Property::class, 'service_id');
    }*/
    
    public function getKiBookinService()
    {
        // Assuming 'service_id' is stored as a JSON field
        //return Property::whereIn('id', json_decode($this->service_id))->get();
        return Property::whereIn('id', json_decode($this->service_id))->get();
    }
    
    public function getKiBookinAddon()
    {
        // Assuming 'service_id' is stored as a JSON field
        //return Property::whereIn('id', json_decode($this->addon_id))->get();
        return Addon::whereIn('id', json_decode($this->addon_id))->get();
    }


    

    
}
