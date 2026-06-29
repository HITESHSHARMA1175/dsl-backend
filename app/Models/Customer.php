<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = ['first_name', 'last_name', 'mobile', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    
    public function getCustomerBrand()
    {
        return $this->belongsTo(Brand::class, 'brand_id'); 
    }
    
    public function getCustomerModel()
    {
        return $this->belongsTo(Mmodel::class, 'model_id'); 
    }
    
    public function getCustomerVariant()
    {
        return $this->belongsTo(Variant::class, 'variant_id'); 
    }
    
    public function getCustomerColour()
    {
        return $this->belongsTo(Colour::class, 'colour_id'); 
    }


}