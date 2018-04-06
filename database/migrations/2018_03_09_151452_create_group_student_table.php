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

        Schema::create('group_student_state_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	        $table->string('name', 32);
	        $table->primary('keyword');
        });

        DB::table('group_student_state_keyword')->insert([
	        ['keyword' => 'a', 'name' => 'active'],
	        ['keyword' => 'p', 'name' => 'application'],
	        ['keyword' => 'r', 'name' => 'refusal']
        ]);

        Schema::create('group_students', function (Blueprint $table) {
	        $table->unsignedInteger('group_num');
	        $table->foreign('group_num')->references('group_num')->on('groups');

	        $table->unsignedInteger('user_num');
	        $table->foreign('user_num')->references('user_num')->on('users');
	        $table->primary(['group_num', 'user_num']);

            $table->char('group_student_state', 1);
	        $table->foreign('group_student_state')->references('keyword')->on('group_student_state_keyword');

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
