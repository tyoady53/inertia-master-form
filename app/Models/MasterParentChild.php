<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterParentChild extends Model
{
    use HasFactory;
    protected $table = 'master_parent_child';
    protected $guarded = [
        'id',
    ];
}
