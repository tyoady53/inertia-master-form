<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('thread_id');
            $table->dateTime('ticket_date');
            $table->string('ticket_source');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('topic_id');
            $table->unsignedBigInteger('departement_id');
            $table->unsignedBigInteger('sla_id');
            $table->dateTime('duedate');
            $table->unsignedBigInteger('assign_id');
            $table->text('title');
            $table->text('description');
            $table->string('priority');
            $table->enum('status', ['open', 'closed']);
            $table->string('outlet_id');
            $table->string('outelt_name');
            $table->string('analyzer_name');
            $table->string('hid');
            $table->string('cable_length');
            $table->string('additional_com');
            $table->text('reason_reg');
            $table->unsignedBigInteger('tag_module_id');
            $table->unsignedBigInteger('cis_menu_id');
            $table->unsignedBigInteger('lis_menu_app');
            $table->string('reg_report_type');
            $table->string('report_id');
            $table->text('report_name');
            $table->text('pkg');
            $table->string('report_type');
            $table->dateTime('report_date');
            $table->text('purpose');
            $table->text('data_display');
            $table->string('file_upload');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpdesks');
    }
};
