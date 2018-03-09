<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_division_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	    $table->char('name', 32);
	    $table->primary('keyword');
        });

        DB::table('user_division_keyword')->insert([
	    ['keyword' => 't', 'name' => 'teacher'],
	    ['keyword' => 's', 'name' => 'student']
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_num');
            $table->string('user_id', 16);
            $table->unique('user_id');
            $table->char('user_password', 160);
	    $table->char('user_name', 20);
            $table->char('user_division', 1);
            $table->foreign('user_division')->references('keyword')->on('user_division_keyword');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_division_keyword');
    }
}
