<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCustomerBranch extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function customer_name()
    {
        return $this->belongsTo(MasterCustomer::class,'customer_id');
    }
}
