<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppFacultyStudent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app-faculty_student', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->string('gender')->nullable();
            $table->string('year_in')->nullable();
            $table->string('faculty')->nullable();
            $table->string('major')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('group_uid')->nullable();
            $table->string('dosen_id')->nullable();
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
