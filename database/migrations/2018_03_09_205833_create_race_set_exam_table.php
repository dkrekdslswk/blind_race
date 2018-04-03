<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('race_set_exam_state_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	    $table->string('name', 32);
	    $table->primary('keyword');
        });

        DB::table('race_set_exam_state_keyword')->insert([
	    ['keyword' => 'n', 'name' => 'nomal'],
	    ['keyword' => 'g', 'name' => 'golden bell'],
	    ['keyword' => 'r', 'name' => 'raid']
        ]);

        Schema::create('race_set_exam', function (Blueprint $table) {
            $table->increments('set_exam_num');

	    $table->unsignedInteger('group_num');

            $table->char('set_exam_state', 1);
	    $table->foreign('set_exam_state')->references('keyword')->on('race_set_exam_state_keyword');

	    $table->unsignedSmallInteger('exam_count');

	    $table->json('set_exam_data')->nullable();

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
