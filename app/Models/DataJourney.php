<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJourney extends Model
{
    use HasFactory;

    public function getDataBuilderDetails()
    {
        return $this->belongsTo(Builder::class, 'builder');
    }

    public function getDataSocietyDetails()
    {
        return $this->belongsTo(Society::class, 'society');
    }

    public function getDataPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'property');
    }

    public function getDataFieldPerson()
    {
        return $this->belongsTo(User::class, 'field_person');
    }
}
