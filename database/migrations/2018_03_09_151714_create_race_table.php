<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->increments('race_num');
	    $table->unsignedInteger('user_t_num');
	    $table->foreign('user_t_num')->references('user_num')->on('users');
            $table->string('race_name', 100);
            $table->string('race_folder_name', 100);
	    $table->json('race_quiz_list');
            $table->timestamps();
        });

	DB::unprepared('
	CREATE TRIGGER tr_races_user_division_check BEFORE INSERT ON races
	FOR EACH ROW
	    BEGIN
                DECLARE v_division CHAR(1) DEFAULT NULL;

		SELECT user_division INTO v_division
		FROM users
		WHERE user_num = NEW.user_t_num;
		IF v_division <> "t" THEN
			SIGNAL SQLSTATE "12000"
				SET MESSAGE_TEXT = "check constraint on races.user_t_num division failed";
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
