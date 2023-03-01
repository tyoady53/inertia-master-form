<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    public function thread()
    {
        return $this->hasMany(Helpdesk_thread::class);
    }

    public function topic()
    {
        return $this->belongsTo(Helpdesk_topic::class);
    }

    public function module()
    {
        return $this->belongsTo(Lis_cis_module::class);
    }

    public function sla()
    {
        return $this->belongsTo(Sla_plan::class);
    }

    public function lis()
    {
        return $this->belongsTo(Lis_menu_app::class);
    }

    public function cis()
    {
        return $this->belongsTo(Cis_menu_app::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assign()
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function division()
    {
        return $this->belongsTo(MasterDivision::class, 'department_id');
    }

    public function customer()
    {
        return $this->belongsTo(MasterCustomer::class, 'customer_id');
    }

    public function branch()
    {
        return $this->belongsTo(MasterCustomerBranch::class, 'branch_id');
    }

}
