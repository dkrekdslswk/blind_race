<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('session_num');

            $table->unsignedInteger('user_num');
	        $table->foreign('user_num')->references('user_num')->on('users');
	        $table->unique('user_num');

	        $table->string('user_nick', 20)->nullable();

            $table->unsignedInteger('set_exam_num')->nullable();
	        $table->foreign('set_exam_num')->references('set_exam_num')->on('race_set_exam');

            $table->unsignedInteger('character_num')->nullable();
	        $table->foreign('character_num')->references('character_num')->on('characters');
            $table->unique(['set_exam_num', 'character_num']);

            $table->string('room_pin_number',10)->nullable();
	        $table->unique('room_pin_number');

            $table->unsignedInteger('team_num')->nullable();
	        $table->foreign('team_num')->references('team_num')->on('race_teams');

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
