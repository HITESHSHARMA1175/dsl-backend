<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerLeadJourney extends Model
{
    use HasFactory;
    
    public function getSellerLeadMeetingEmp()
    {
        return $this->belongsTo(User::class, 'meeting_with');
    }

    
}
