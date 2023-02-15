<?php

namespace Database\Seeders;

use App\Models\MasterStatusReport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterStatusReport::create(['name' => 'In Progress']);
        MasterStatusReport::create(['name' => 'Done']);
        MasterStatusReport::create(['name' => 'Escalated']);
        MasterStatusReport::create(['name' => 'Pending']);
        MasterStatusReport::create(['name' => 'No Case']);
    }
}
