<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
    use HasFactory;
    
    protected $fillable = ['builder_name', 'email', 'mobile_no', 'address', 'country_id', 'state_id', 'city_id', 'pincode', 'profile',
                           'status', 'addby'];

    public function getBuilderCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function getBuilderState()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function getBuilderCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
