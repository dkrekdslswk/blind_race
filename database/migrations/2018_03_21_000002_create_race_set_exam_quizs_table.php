<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceSetExamQuizsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_set_exam_quizs', function (Blueprint $table) {
	    $table->increments('quiz_sequence');
	    $table->unsignedInteger('set_exam_num');
	    $table->foreign('set_exam_num')->references('set_exam_num')->on('race_set_exam');
	    $table->unsignedInteger('quiz_num');
	    $table->foreign('quiz_num')->references('quiz_num')->on('quiz_bank');
	    $table->unique(['set_exam_num', 'quiz_num']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
