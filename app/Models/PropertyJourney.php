<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyJourney extends Model
{
    use HasFactory;

    public function getLeadPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'property');
    }

    public function getLeadFieldPerson()
    {
        return $this->belongsTo(User::class, 'field_person');
    }
}
