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
            $table->date('ticket_date');
            $table->string('ticket_source');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('branch_id')->nullable(); //optional
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('sla_id')->nullable();
            $table->dateTime('duedate');
            $table->unsignedBigInteger('assign_id');
            $table->text('title');
            $table->text('description');
            $table->string('priority');
            $table->enum('status', ['open', 'closed']);
            $table->string('outlet_id')->nullable(); //optional
            $table->string('out_name')->nullable(); //optional
            $table->string('section_id')->nullable();
            $table->string('analyer_id')->nullable();
            $table->string('analyzer_name')->nullable(); //optional
            $table->string('hid')->nullable(); //optional
            $table->string('cable_length')->nullable(); //optional
            $table->string('additional_com')->nullable(); //optional
            $table->text('reason_reg')->nullable(); //optional
            $table->unsignedBigInteger('tag_module_id')->nullable();
            $table->unsignedBigInteger('cis_menu_id')->nullable();
            $table->unsignedBigInteger('lis_menu_app')->nullable();
            $table->string('reg_report_type')->nullable();
            $table->string('report_id')->nullable();
            $table->text('report_name')->nullable();
            $table->text('pkg')->nullable();
            $table->string('report_type')->nullable();
            $table->dateTime('report_date')->nullable();
            $table->text('purpose')->nullable();
            $table->text('data_display')->nullable();
            $table->string('file_upload')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('edited_by')->nullable();
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
