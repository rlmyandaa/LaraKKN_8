<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppDailyReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app-daily_report', function (Blueprint $table) {
            $table->id();
            $table->string('group_uid')->nullable();
            $table->string('student_id')->nullable();
            $table->text('report_detail')->nullable();
            $table->date('report_date')->nullable();
            $table->date('report_date_submitted')->nullable();
            $table->string('report_folderpath')->nullable();
            $table->integer('report_filecount')->nullable();
            $table->string('report_uid')->nullable();
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
