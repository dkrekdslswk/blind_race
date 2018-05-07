<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        Schema::create('accessionStates', function (Blueprint $table) {
//            $table->char('name', 20);
//	        $table->primary('name');
//        });
//
//        DB::table('accessionStates')->insert([
//	        ['name' => 'user apply'],
//	        ['name' => 'teacher apply'],
//            ['name' => 'user refuse'],
//            ['name' => 'teacher refuse'],
//            ['name' => 'unregistered'],
//            ['name' => 'enrollment']
//        ]);

        Schema::create('groupStudents', function (Blueprint $table) {
	        $table->unsignedInteger('groupNumber');
	        $table->foreign('groupNumber')->references('number')->on('groups');

	        $table->unsignedInteger('userNumber');
	        $table->foreign('userNumber')->references('number')->on('users');
	        $table->primary(['groupNumber', 'userNumber']);

            $table->char('userName', 20);

//            $table->char('accessionState', 20);
//	        $table->foreign('accessionState')->references('name')->on('accessionStates');

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
