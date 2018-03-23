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
	    $table->unsignedInteger('race_num');
	    $table->foreign('race_num')->references('race_num')->on('races');
	    $table->unsignedInteger('quiz_num');
	    $table->foreign('quiz_num')->references('quiz_num')->on('quiz_bank');
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
