<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadJourney extends Model
{
    use HasFactory;

    public function getLeadBuilderDetails()
    {
        return $this->belongsTo(Builder::class, 'builder');
    }

    public function getLeadSocietyDetails()
    {
        return $this->belongsTo(Society::class, 'society');
    }

    public function getLeadPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'property');
    }
    
    public function getLeadMeetBuilderDetails()
    {
        return $this->belongsTo(Builder::class, 'meeting_builder');
    }

    public function getLeadMeetSocietyDetails()
    {
        return $this->belongsTo(Society::class, 'meeting_society');
    }

    public function getLeadMeetPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'meeting_property');
    }
    
    public function getLeadMeetFeedBuilderDetails()
    {
        return $this->belongsTo(Builder::class, 'meeting_feedback_builder');
    }

    public function getLeadMeetFeedSocietyDetails()
    {
        return $this->belongsTo(Society::class, 'meeting_feedback_society');
    }

    public function getLeadMeetFeedPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'meeting_feedback_property');
    }
    
    public function getLeadEOIBuilderDetails()
    {
        return $this->belongsTo(Builder::class, 'eoi_collected_builder');
    }

    public function getLeadEOISocietyDetails()
    {
        return $this->belongsTo(Society::class, 'eoi_collected_society');
    }

    public function getLeadEOIPropertyDetail()
    {
        return $this->belongsTo(Property::class, 'eoi_collected_property');
    }
    
    public function getLeadMeetingPerson()
    {
        return $this->belongsTo(User::class, 'meeting_with');
    }
    
    public function getLeadFieldPerson()
    {
        return $this->belongsTo(User::class, 'field_person');
    }
}
