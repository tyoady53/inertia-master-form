<?php

namespace Database\Seeders;

use App\Models\Sla_plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSlaPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sla_plan::create(['sla_name' => 'App Update Required', 'sla_hour' => '168', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Apps Troubleshoot CITO', 'sla_hour' => '4', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Apps Troubleshoot REGULAR', 'sla_hour' => '12', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Emergency', 'sla_hour' => '2', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Hardware Replacement CITO', 'sla_hour' => '12', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Hardware Replacement REGULAR', 'sla_hour' => '48', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Interfacing Cable', 'sla_hour' => '24', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Interfacing New Analyzer', 'sla_hour' => '168', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Interfacing New PRG', 'sla_hour' => '72', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Interfacing Troubleshoot CITO', 'sla_hour' => '12', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Interfacing Troubleshoot REGULAR', 'sla_hour' => '', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'License and Regkey CITO', 'sla_hour' => '24', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'License and Regkey REGULAR', 'sla_hour' => '48', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Network Configuration CITO', 'sla_hour' => '24', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Network Configuration REGULAR', 'sla_hour' => '48', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Report ADJUSMENT / Existing', 'sla_hour' => '24', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Report New, ADVANCED', 'sla_hour' => '336', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Report New, CITO', 'sla_hour' => '48', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Report New, REGULAR', 'sla_hour' => '72', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'Server Installation', 'sla_hour' => '168', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'SLA 12', 'sla_hour' => '12', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'SLA 1W', 'sla_hour' => '168', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'SLA 24', 'sla_hour' => '24', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'SLA 2d', 'sla_hour' => '48', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'sla 2w', 'sla_hour' => '336', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'sla 3d', 'sla_hour' => '72', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'sla 4h', 'sla_hour' => '4', 'created_by' => '1']);
        Sla_plan::create(['sla_name' => 'sla 8h', 'sla_hour' => '8', 'created_by' => '1']);
    }
}
