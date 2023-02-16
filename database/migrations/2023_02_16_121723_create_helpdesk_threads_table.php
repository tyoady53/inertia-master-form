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
        Schema::create('helpdesk_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('helpdesk_id');
            $table->text('title');
            $table->text('description');
            $table->string('file_upload');
            $table->unsignedBigInteger('assign_id');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('helpdesk_threads');
    }
};
