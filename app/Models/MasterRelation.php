<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRelation extends Model
{
    use HasFactory;
    protected $table = 'master_relation';
    protected $guarded = [
        'id',
    ];
}
