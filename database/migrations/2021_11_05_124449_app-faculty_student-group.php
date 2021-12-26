<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppFacultyStudentGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app-faculty_student-group', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->nullable();
            $table->text('group_location')->nullable();
            $table->integer('member_count')->nullable();
            $table->integer('member_registered')->nullable();
            $table->integer('token_registered')->nullable();
            $table->text('token')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('village_name')->nullable();
            $table->text('village_center_address')->nullable();
            $table->string('village_head_name')->nullable();
            $table->string('village_head_phone')->nullable();
            $table->string('group_mentor_id')->nullable();
            $table->string('babinsa_name')->nullable();
            $table->string('babinsa_phone')->nullable();
            $table->integer('proker_acc_count')->nullable();
            $table->integer('proker_pending_count')->nullable();
            $table->integer('fr_acc_stat')->nullable();
            $table->integer('kkn_finished_stat')->nullable();
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
