<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapAttribute extends Model
{
    use HasFactory;
    protected $table = 'mapped_attributes';

    public function getPropertyCategrory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_category_id');
    }

    public function getPropertySubCategrory()
    {
        return $this->belongsTo(PropertyCategory::class, 'property_sub_category_id');
    }

    public function getPropertyAttribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
