<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceSetExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_set_exam', function (Blueprint $table) {
            $table->increments('set_exam_num');
	    $table->unsignedInteger('group_num');
            $table->char('set_exam_state', 1);
	    $table->foreign('set_exam_state')->references('keyword')->on('rece_set_exam_state_keyword');
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
