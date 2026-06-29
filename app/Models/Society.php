<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;
    
    protected $fillable = ['builder_id', 'society_name', 'address', 'country_id', 'state_id', 'city_id', 'pincode', 'society_id', 'profile',
                           'category', 'sub_category', 'project_area','total_tower', 'total_floor', 'total_no_of_unit','upload_master_plan', 'upload_payment_plan',
                           'upload_price_list', 'possession_status', 'addby'];

    
    public function getProjectCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'category');
    }
    public function getProjectSubCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'sub_category');
    }
    public function getProjectOption()
    {
        return $this->hasMany(SocietyOption::class, 'project_id');
    }
    public function getSocietyBuilder()
    {
        return $this->belongsTo(Builder::class, 'builder_id');
    }
    public function getSocietyCountry()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function getSocietyState()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function getSocietyCity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
