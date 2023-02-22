<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDivision extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function helpdesk()
    {
        return $this->hasMany(Helpdesk::class);
    }
}
