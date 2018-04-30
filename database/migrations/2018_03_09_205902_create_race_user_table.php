<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retestStates', function (Blueprint $table) {
            $table->char('name', 20);
            $table->primary('name');
        });

        DB::table('retestStates')->insert([
            ['name' => 'not'],
            ['name' => 'order'],
            ['name' => 'clear']
        ]);

        Schema::create('raceUsers', function (Blueprint $table) {
	        $table->unsignedInteger('raceNumber');
	        $table->foreign('raceNumber')->references('number')->on('races');

	        $table->unsignedInteger('userNumber');
	        $table->foreign('userNumber')->references('number')->on('users');
	        $table->primary(['raceNumber', 'userNumber']);

            $table->char('retestState', 20);
            $table->foreign('retestState')->references('name')->on('retestStates');

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
