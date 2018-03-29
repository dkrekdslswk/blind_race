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
        Schema::dropIfExists('mistaken_quizs');
        Schema::dropIfExists('race_mistaken_quizs');
        Schema::dropIfExists('race_set_exam_quizs');
        Schema::dropIfExists('race_quizs');

        Schema::dropIfExists('race_team_users');
        //Schema::dropIfExists('race_teams');

        Schema::dropIfExists('race_results');

        Schema::dropIfExists('race_teams');

        Schema::dropIfExists('rece_set_exam');
        Schema::dropIfExists('rece_set_exam_state_keyword');
        Schema::dropIfExists('race_set_exam');
        Schema::dropIfExists('race_set_exam_state_keyword');

        Schema::dropIfExists('quiz_bank');
        Schema::dropIfExists('quiz_type_keyword');
        Schema::dropIfExists('quiz_set_state_keyword');

        Schema::dropIfExists('books');

	DB::unprepared('DROP TRIGGER IF EXISTS tr_races_user_division_check');
        Schema::dropIfExists('races');

        Schema::dropIfExists('group_students');
        Schema::dropIfExists('group_student_state_keyword');

	DB::unprepared('DROP TRIGGER IF EXISTS tr_groups_user_division_check');
        Schema::dropIfExists('groups');

	/******************************* 
        * 18.03.28 
	* user_division_keyword삭제 
	* user_teachers로 선생구분으로 변경
	********************************/
        Schema::dropIfExists('user_teachers');
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
