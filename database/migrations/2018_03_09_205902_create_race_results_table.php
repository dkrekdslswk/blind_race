<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_results', function (Blueprint $table) {
	    $table->unsignedInteger('set_exam_num');
	    $table->foreign('set_exam_num')->references('set_exam_num')->on('rece_set_exam');
	    $table->unsignedInteger('user_num');
	    $table->foreign('user_num')->references('user_num')->on('users');
	    $table->primary(['set_exam_num', 'user_num']);
	    $table->json('race_result_mistaken_quiz_list');
	    $table->json('race_result_data');
            $table->timestamps();
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
