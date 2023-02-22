<?php

namespace Database\Seeders;

use App\Models\master_table;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        master_table::create(['group' => '-', 'name' => 'master_customers',         'description'=>'Master CUstomer',           'is_show'=>'1', 'extend'=>'0','status'=>'1','created_by'=>'seed','updated_by'=>'seed']);
        master_table::create(['group' => '-', 'name' => 'master_customer_branches', 'description'=>'Master CUstomer Branch',    'is_show'=>'1', 'extend'=>'0','status'=>'1','created_by'=>'seed','updated_by'=>'seed']);
    }
}
