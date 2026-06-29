<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [];

    
    public function getPatientUser()
    {
        return $this->belongsTo(Customer::class, 'add_by');
    }
    

    
}
