<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('group_num');
            $table->char('group_name', 80);
	    $table->unsignedInteger('user_t_num');
	    $table->foreign('user_t_num')->references('user_num')->on('users');
        });

	DB::unprepared('
	CREATE TRIGGER tr_groups_user_division_check BEFORE INSERT ON groups
	FOR EACH ROW
	    BEGIN
                DECLARE v_division CHAR(1) DEFAULT NULL;

		SELECT user_division INTO v_division
		FROM users
		WHERE user_num = NEW.user_t_num;
		IF v_division <> "t" THEN
			SIGNAL SQLSTATE "12000"
				SET MESSAGE_TEXT = "check constraint on groups.user_t_num division failed";
		END IF;
	    END;
	');
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
