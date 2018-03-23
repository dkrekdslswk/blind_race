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
	    $table->unsignedInteger('quiz_num');
	    $table->foreign(['set_exam_num', 'user_num'])->references(['set_exam_num', 'user_num'])->on('race_results');
	    $table->foreign(['set_exam_num', 'quiz_num'])->references(['set_exam_num', 'quiz_num'])->on('race_set_exam');
            $table->unsignedTinyInteger('retake_status')->default(0);
            $table->string('result', 100);
            $table->text('wrong_answer_note')->default("-");
	    $table->primary(['set_exam_num', 'group_num', 'quiz_num', 'retake_status']);
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
