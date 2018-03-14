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
        Schema::create('rece_set_exam_state_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	    $table->string('name', 32);
	    $table->primary('keyword');
        });

        DB::table('rece_set_exam_state_keyword')->insert([
	    ['keyword' => 'n', 'name' => 'nomal'],
	    ['keyword' => 'g', 'name' => 'golden bell'],
	    ['keyword' => 'r', 'name' => 'raid']
        ]);

        Schema::create('rece_set_exam', function (Blueprint $table) {
            $table->increments('set_exam_num');
	    $table->unsignedInteger('group_num');
	    $table->json('set_exam_quiz_list');
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
