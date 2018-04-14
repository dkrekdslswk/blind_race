<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_type_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	        $table->string('name', 32);
	        $table->primary('keyword');
        });

        DB::table('quiz_type_keyword')->insert([
	        ['keyword' => 'o', 'name' => 'objective'],
	        ['keyword' => 's', 'name' => 'subjective'],
	        ['keyword' => 't', 'name' => 'set word'],
	        ['keyword' => 'w', 'name' => 'word']
        ]);

        Schema::create('quiz_bank', function (Blueprint $table) {
            $table->increments('quiz_num');

	        $table->unsignedInteger('book_num')->nullable();
	        $table->foreign('book_num')->references('book_num')->on('books');

	        $table->unsignedSmallInteger('book_page')->nullable();

	        $table->string('quiz_question',1000);
	        $table->string('quiz_right_answer',100);
	        $table->string('quiz_example1',100)->nullable();
	        $table->string('quiz_example2',100)->nullable();
	        $table->string('quiz_example3',100)->nullable();

            $table->char('quiz_type', 1);
	        $table->foreign('quiz_type')->references('keyword')->on('quiz_type_keyword');

            $table->char('quiz_level', 1)->nullable();

	        $table->unsignedInteger('user_t_num')->nullable();
	        $table->foreign('user_t_num')->references('user_t_num')->on('user_teachers');
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
