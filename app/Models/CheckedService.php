<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckedService extends Model
{
    use HasFactory;

    protected $fillable = ['item'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'sid', 'id'); // 'sid' in `checked_services` relates to `id` in `services`
    }
    
    public function getCheckedService()
    {
        return $this->belongsTo(Property::class, 'sid');
    }

    public function getCheckedAddon()
    {
        return $this->belongsTo(Addon::class, 'sid');
    }

    public function getAddonCategory()
    {
        return $this->belongsTo(MasterValue::class, 'parent_id');
    }

    

    
}
