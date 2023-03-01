<?php

namespace Database\Seeders;

use App\Models\master_table_structure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterTableStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        master_table_structure::create(['table_id' => '1', 'field_name' => 'customer_name'  ,'field_description'=>'CUstomer Name'  ,'is_show'=>'1', 'data_type'=>'VARCHAR(255)','relation'=>'0','relate_to'=>'','input_type'=>'Text','required'=>'','created_by'=>'seed','sequence_id'=>'1']);
        master_table_structure::create(['table_id' => '2', 'field_name' => 'outlet_id'      ,'field_description'=>'Outlet ID'      ,'is_show'=>'1', 'data_type'=>'VARCHAR(255)','relation'=>'0','relate_to'=>'','input_type'=>'Text','required'=>'','created_by'=>'seed','sequence_id'=>'1']);
        master_table_structure::create(['table_id' => '2', 'field_name' => 'customer_id'    ,'field_description'=>'Customer ID'    ,'is_show'=>'1', 'data_type'=>'VARCHAR(255)','relation'=>'0','relate_to'=>'','input_type'=>'Text','required'=>'','created_by'=>'seed','sequence_id'=>'2']);
        master_table_structure::create(['table_id' => '2', 'field_name' => 'customer_branch','field_description'=>'Customer Branch','is_show'=>'1', 'data_type'=>'VARCHAR(255)','relation'=>'0','relate_to'=>'','input_type'=>'Text','required'=>'','created_by'=>'seed','sequence_id'=>'3']);
    }
}
