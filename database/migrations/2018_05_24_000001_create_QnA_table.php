<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQnATable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QnAs', function (Blueprint $table) {
            $table->increments('number');

            $table->unsignedInteger('userNumber');
            $table->foreign('userNumber')->references('number')->on('users');

            $table->unsignedInteger('teacherNumber');
            $table->foreign('teacherNumber')->references('number')->on('users');

            $table->string('title', 50);
            $table->text('question');
            $table->text('answer')->nullable();

            $table->timestamp('question_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('answer_at')->nullable();
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