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
            $table->unsignedInteger('team_num');
	    $table->unsignedInteger('set_exam_num');
	    $table->foreign('set_exam_num')->references('set_exam_num')->on('race_set_exam');
	    $table->primary(['set_exam_num', 'team_num']);
	    $table->string('team_name', 40);
            $table->unsignedSmallInteger('team_rank');
        });

        Schema::create('race_team_users', function (Blueprint $table) {
            $table->unsignedInteger('team_num');
	    $table->unsignedInteger('set_exam_num');
	    $table->unsignedInteger('user_num');
	    $table->foreign(['set_exam_num', 'team_num'])->references(['set_exam_num', 'team_num'])->on('race_teams');
	    $table->foreign(['set_exam_num', 'user_num'])->references(['set_exam_num', 'user_num'])->on('race_results');
	    $table->primary(['set_exam_num', 'team_num', 'user_num']);
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
