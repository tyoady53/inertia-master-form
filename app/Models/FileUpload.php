<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    // public function helpdesk_thread()
    // {
    //     return $this->belongsTo(Helpdesk_thread::class);
    // }
}
