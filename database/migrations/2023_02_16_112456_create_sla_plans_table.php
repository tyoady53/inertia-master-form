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
        Schema::create('sla_plans', function (Blueprint $table) {
            $table->id();
            $table->text('sla_name');
            $table->integer('sla_hour');
            $table->unsignedBigInteger('created_at');
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
        Schema::dropIfExists('sla_plans');
    }
};
