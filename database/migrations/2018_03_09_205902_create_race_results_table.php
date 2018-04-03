<?php

use Illuminate\Support\Facades\DB;
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
	    $table->foreign('set_exam_num')->references('set_exam_num')->on('race_set_exam');

	    $table->unsignedInteger('user_num');
	    $table->foreign('user_num')->references('user_num')->on('users');
	    $table->primary(['set_exam_num', 'user_num']);

	    $table->unsignedInteger('team_num');
	    $table->foreign('team_num')->references('team_num')->on('race_teams');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
