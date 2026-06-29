<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapSellerLeadCategory extends Model
{
    use HasFactory;

    public function getSellerLeadCategory()
    {
        return $this->belongsTo(MasterValue::class, 'property_category_id');
    }
    public function getSellerLeadSubCategory()
    {
        return $this->belongsTo(MasterValue::class, 'sub_property_category_id');
    }

    public function masterValue()
    {
        return $this->belongsTo(MasterValue::class, 'property_category_id', 'id');
    }
}
