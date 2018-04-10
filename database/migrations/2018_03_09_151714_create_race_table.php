<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_folders', function (Blueprint $table) {
            $table->increments('race_folder_num');

            $table->unsignedInteger('user_t_num');
            $table->foreign('user_t_num')->references('user_t_num')->on('user_teachers');

            $table->string('race_folder_name', 100)->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        Schema::create('races', function (Blueprint $table) {
            $table->increments('race_num');

	        $table->unsignedInteger('user_t_num');
	        $table->foreign('user_t_num')->references('user_t_num')->on('user_teachers');

            $table->string('race_name', 100);

            $table->unsignedInteger('race_folder_num')->nullable();
            $table->foreign('race_folder_num')->references('race_folder_num')->on('race_folders');

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
