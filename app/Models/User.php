<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getEmpCountry()
    {
        return $this->belongsTo(Country::class, 'country');
    }
    public function getEmpState()
    {
        return $this->belongsTo(State::class, 'state');
    }
    public function getEmpCity()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function getEmpDesignation()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }
    
    public function getShopImages()
    {
        return $this->hasMany(ShopImage::class, 'shop_id');
    }
    
}
