<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapWorkCategory extends Model
{
    use HasFactory;

    public function getWorkCategory()
    {
        return $this->belongsTo(MasterValue::class, 'work_category_id');
    }
    public function getSubWorkCategory()
    {
        return $this->belongsTo(MasterValue::class, 'sub_work_category_id');
    }
}
