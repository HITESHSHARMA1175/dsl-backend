<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;

class TenantMemberDetail extends Model
{
    use HasFactory;

    protected $table = 'tenant_members_details';
    public function getTenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
