<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppProkerList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app-proker-list', function (Blueprint $table) {
            $table->id();
            $table->string('group_uid')->nullable();
            $table->string('proker_name')->nullable();
            $table->string('proker_category')->nullable();
            $table->text('proker_detail')->nullable();
            $table->string('proker_filename')->nullable();
            $table->string('proker_uid')->nullable();
            $table->dateTime('proker_submit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
