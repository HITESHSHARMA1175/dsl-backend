<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    public function getProfessionalCategory()
    {
        return $this->belongsTo(PropertyCategory::class, 'category_ids');
    }

    

    
}
