<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayingQuizsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playing_quizs', function (Blueprint $table) {
            $table->unsignedInteger('set_exam_num');
	        $table->unsignedInteger('user_num');
	        $table->unsignedInteger('sequence');
            $table->unsignedTinyInteger('retake')->default(0);
	        $table->primary(['set_exam_num', 'user_num', 'sequence', 'retake']);

            $table->string('result', 100);

            $table->text('wrong_answer_note')->nullable();
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
