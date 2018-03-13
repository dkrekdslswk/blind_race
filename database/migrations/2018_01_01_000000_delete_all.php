<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	DB::unprepared('DROP TRIGGER IF EXISTS tr_races_user_division_check');
        Schema::dropIfExists('races');
        Schema::dropIfExists('group_students');
        Schema::dropIfExists('group_student_state_keyword');
	DB::unprepared('DROP TRIGGER IF EXISTS tr_groups_user_division_check');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_division_keyword');
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
