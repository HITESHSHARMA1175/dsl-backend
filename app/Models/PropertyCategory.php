<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'category_name', 'parent_id'];
    
    public function getParentCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'parent_id'); 
    }
    
    public function getParentCategories()
    {
        return PropertyCategory::whereIn('id', json_decode($this->parent_ids, true))->get();
    }
    
    public function getParentCategories2()
    {
        return PropertyCategory::whereIn('id', json_decode($this->parent_ids2, true))->get();
    }
    
    public function categoryServices()
    {
        return $this->hasMany(Property::class, 'property_category');
    }
    
    public function subcategoryServices()
    {
           $this->hasMany(Property::class, 'property_sub_category')
            ->whereJsonContains('property_sub_category', json_encode($this->id));
            
            dd($this->sql);
    }

    
    public function subconditionServices()
    {
        //return $this->hasMany(Property::class, 'skin_sub_condition');
        return $this->hasMany(Property::class, 'skin_sub_condition')
            ->whereJsonContains('skin_sub_condition', strval($this->property_sub_category));
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
