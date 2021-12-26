<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppFinalReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app-final_report', function (Blueprint $table) {
            $table->id();
            $table->string('group_uid')->nullable();
            $table->integer('fr_rev_stat')->nullable();
            $table->string('fr_filename')->nullable();
            $table->integer('fr_rev_count')->nullable();
            $table->dateTime('fr_submitted_date')->nullable();
            $table->string('fr_uid')->nullable();
            $table->integer('fr_rev_submitted')->nullable();
            $table->text('fr_dosen_rev_comment')->nullable();
            $table->integer('fr_acc_stat')->nullable();
            $table->text('fr_student_rev_comment')->nullable();
            $table->integer('fr_revised')->nullable();
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
