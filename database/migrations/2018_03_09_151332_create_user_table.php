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
        Schema::create('classifications',function (Blueprint $table) {
            $table->char('name', 20);
            $table->primary('name');
        });
        DB::table('classifications')->insert([
            ['name' => 'student'],
            ['name' => 'teacher'],
            ['name' => 'root']
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->string('number', 10);
            $table->primary('number');

            $table->char('pw', 20);
            $table->char('name', 20);

            $table->char('classification', 20);
            $table->foreign('classification')->references('name')->on('classifications');
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
