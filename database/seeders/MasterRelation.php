<?php

namespace Database\Seeders;

use App\Models\MasterRelation as ModelsMasterRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterRelation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsMasterRelation::create([
            'table_name_from' => '2',
            'field_from' => 'customer_id',
            'table_from_desc'=>'Customer ID',
            'field_from_desc'=>'1',
            'table_name_to'=>'VARCHAR(255)',
            'refer_to'=>'1',
            'table_to_desc'=>'',
            'refer_to_desc'=>'Text',
            'created_by'=>'seed',
            'updated_by'=>'seed',
        ]);
    }
}
