<?php

namespace Database\Seeders;

use App\Models\Lis_menu_app;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterMenuTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lis_menu_app::create(['app_name' => 'Registration ~ Lab Registration', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Registration ~ Registration Blood & Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Registration ~ Finance Receipt', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Collection Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Handling Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Sample Handling Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Collection Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Handling Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Sample Handling Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Collection Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Sampling ~ Specimen Handling Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ QC Result', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Process Sample Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Result Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Verification Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Authorization Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Proses Sample Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Result Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Verification Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Authorization Non Lab', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Process Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Result Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Verification Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Authorization Blood Bank', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Checkup', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Print Result', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Analysis ~ Print Result Other sys', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Result Handling ~ Result Handling', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Finance ~ Finance Receipt', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Finance ~ Void', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Finance ~ Payment', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Inventory ~ Inv Order Outlet', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Inventory ~ Inv Stock Opname', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Inventory ~ Inv Order Loc', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Marketing ~ Messenger', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Marketing ~ QA', 'created_by' => '1']);
        Lis_menu_app::create(['app_name' => 'Master ~ Master', 'created_by' => '1']);
    }
}
