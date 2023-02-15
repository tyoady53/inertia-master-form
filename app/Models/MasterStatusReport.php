<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStatusReport extends Model
{
    use HasFactory;
    protected $table = 'master_status_report';
    protected $guarded = [
        'id',
    ];
}
