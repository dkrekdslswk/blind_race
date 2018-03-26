<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceMistakenQuizsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_mistaken_quizs', function (Blueprint $table) {
            $table->unsignedInteger('set_exam_num');
	    $table->unsignedInteger('user_num');
	    $table->unsignedInteger('quiz_sequence');
	    $table->foreign(['set_exam_num', 'user_num'])->references(['set_exam_num', 'user_num'])->on('race_results');
	    $table->foreign('quiz_sequence')->references('quiz_sequence')->on('race_set_exam_quizs');
            $table->unsignedTinyInteger('retake')->default(0);
            $table->string('result', 100);
            $table->text('wrong_answer_note')->nullable();
	    $table->primary(['set_exam_num', 'user_num', 'quiz_sequence', 'retake']);
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
