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
        Schema::create('master_customer_branches', function (Blueprint $table) {
            $table->id();
            $table->string('outlet_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_branch');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('master_customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_customer_branches');
    }
};
