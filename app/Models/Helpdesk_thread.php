<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpdesk_thread extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function helpdesk()
    {
        return $this->belongsTo(Helpdesk::class, 'helpdesk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
