<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataImportLog extends Model
{
    use HasFactory;

    protected $fillable = ['total_record', 'start_id', 'end_id', 'duplicate', 'updated', 'total_new', 'upload_file', 'addby'];

    public function getSellerLeadImportEmp()
    {
        return $this->belongsTo(User::class, 'addby');
    }
    
}
