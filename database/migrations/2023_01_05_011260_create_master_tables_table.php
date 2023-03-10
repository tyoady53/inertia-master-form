<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_tables', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('name');
            $table->string('description');
            $table->string('is_show',2);
            $table->string('extend',2);
            $table->string('status',2);
            $table->string('use_customer',2);
            $table->string('use_clipboard',2);
            $table->string('limit_access',2);
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // $table->foreign('group')->references('name')->on('master_tablegroup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_tables');
    }
}
