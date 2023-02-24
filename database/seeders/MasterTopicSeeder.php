<?php

namespace Database\Seeders;

use App\Models\Helpdesk_topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Helpdesk_topic::create(['topic_name' => 'New Request', 'id_category'  => '1','created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / LIS-CIS Features', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / PC and Peripherals', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / Server and Networking', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / Adjusment', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / Bridging', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'New Request / Interfacing', 'id_category' => '2', 'created_by' => '1']); //tag interfacing
        Helpdesk_topic::create(['topic_name' => 'New Request / LIS-CIS Modules', 'id_category' => '3', 'created_by' => '1']); //tag modul
        Helpdesk_topic::create(['topic_name' => 'New Request / Reg Key', 'id_category' => '4', 'created_by' => '1']); // tag regkey
        Helpdesk_topic::create(['topic_name' => 'New Request / Report and Data', 'id_category' => '5', 'created_by' => '1']); //report
        Helpdesk_topic::create(['topic_name' => 'New Request / CIS App', 'id_category' => '6', 'created_by' => '1']); //menu tag
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / Interfacing', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / Onsite MCU', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / PC and Peripherals', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / Phlebotomy System', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / Networking', 'id_category' => '1', 'created_by' => '1']);
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / LIS Modules', 'id_category' => '3', 'created_by' => '1']); //tag modul
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / LIS', 'id_category' => '3', 'created_by' => '1']); //tag modul
        Helpdesk_topic::create(['topic_name' => 'TroubleShoot & Adjusment / LIS App', 'id_category' => '5', 'created_by' => '1']); //menu tag

    }
}
