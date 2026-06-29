<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Property;

class Owner extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile_no', 'alt_mobile_no', 'gender', 'relative_name', 'per_address', 'pan_card_no', 'aadhar_card_no',
                           'pan_card_upload', 'aadhar_card_upload', 'pan_card_status', 'aadhar_card_status', 'profile', 'status', 'addby'];

    public function getOwnerProperty()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }


    
}
