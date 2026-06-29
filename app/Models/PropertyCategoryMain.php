<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategoryMain extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'category_name', 'parent_id'];
    
    public function categoryServices()
    {
        return $this->hasMany(Property::class, 'property_category');
    }
    
    
    public function getMappedPropertyAttribute()
    {
        return $this->hasMany(MapAttribute::class, 'property_sub_category_id');
    }
    
    
    public function getMappedSellerLeadAttribute()
    {
        return $this->hasMany(MapAttribute::class, 'property_sub_category_id');
    }
    
    public function mappedProperties()
    {
        return $this->hasMany(Property::class, 'property_category');
    }
    
    
}
