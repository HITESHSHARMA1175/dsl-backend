<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'category_name', 'parent_id'];

    public function getMappedInventoryAttribute()
    {
        return $this->hasMany(MapInventoryAttribute::class, 'inventory_sub_category_id');
    }
}
