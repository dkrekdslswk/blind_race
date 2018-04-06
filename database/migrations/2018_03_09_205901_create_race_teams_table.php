<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_teams', function (Blueprint $table) {
            $table->increments('team_num');

	    $table->unsignedInteger('set_exam_num');
	    $table->foreign('set_exam_num')->references('set_exam_num')->on('race_set_exam');

	    $table->string('team_name', 40);

            $table->unsignedSmallInteger('team_rank');
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
