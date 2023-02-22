<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCustomer extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function branch()
    {
        return $this->hasMany(MasterCustomerBranch::class,'customer_id');
    }
}
