<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterValue extends Model
{
    use HasFactory;

    public function master()
    {
        return $this->belongsTo(Master::class, 'MasterHead');
    }

    public function subPropertyCategories()
    {
        return $this->belongsToMany(MapPropertyCategory::class, 'map_property_categories', 'property_category_id', 'sub_property_category_id');
    }
    
    public function categoryAddons()
    {
        return $this->hasMany(Addon::class, 'id');
    }
    
    public function categoryBlogCount()
    {
        return $this->hasMany(Blog::class, 'blog_category')->count();
    }
    
}
