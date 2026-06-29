<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TenantMemberDetail;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Tenant extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'mobile_no', 'gender', 'dob', 'address',
     'country', 'state', 'city', 'pincode', 'date_of_joining', 'password', 'type', 'email_verified_at', 'account_name',
     'account_no', 'bank_name', 'ifcs', 'profile', 'upload_aadhaar', 'aadhar_number', 'upload_pan', 'pan_number', 'upload_resume',
     'upload_cancel_cheque', 'is_admin', 'status', 'remember_token'];

    public function getMembersDetail()
    {
        return $this->hasMany(TenantMemberDetail::class);
    }

    public function getTenantProperty()
    {
        return $this->hasMany(MoveDetail::class, 'tenant_id');
    }
    
    public function getTenantCountry()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function getTenantState()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function getTenantCity()
    {
        return $this->belongsTo(City::class, 'city');
    }
    
}
