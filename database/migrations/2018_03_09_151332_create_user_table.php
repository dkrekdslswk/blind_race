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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_num');

            $table->string('user_id', 16);
            $table->unique('user_id');

            $table->char('user_password', 16);

	    $table->char('user_name', 20);
        });

	Schema::create('user_teachers',function (Blueprint $table) {
	    $table->unsignedInteger('user_t_num');
	    $table->foreign('user_t_num')->references('user_num')->on('users');
	    $table->primary('user_t_num');
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
