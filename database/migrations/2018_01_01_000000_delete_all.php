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
        Schema::dropIfExists('races');
        Schema::dropIfExists('group_students');
	DB::unprepared('DROP TRIGGER IF EXISTS tr_groups_user_division_check');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('user_division_keyword');
        Schema::dropIfExists('users');
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
