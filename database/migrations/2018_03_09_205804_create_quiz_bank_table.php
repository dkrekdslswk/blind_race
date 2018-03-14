<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_type_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	    $table->string('name', 32);
	    $table->primary('keyword');
        });

        DB::table('quiz_type_keyword')->insert([
	    ['keyword' => 'o', 'name' => 'objective'],
	    ['keyword' => 's', 'name' => 'subjective'],
	    ['keyword' => 't', 'name' => 'set word'],
	    ['keyword' => 'w', 'name' => 'word']
        ]);

        Schema::create('quiz_set_state_keyword', function (Blueprint $table) {
            $table->char('keyword', 1);
	    $table->string('name', 32);
	    $table->primary('keyword');
        });

        DB::table('quiz_set_state_keyword')->insert([
	    ['keyword' => 'b', 'name' => 'base quiz'],
	    ['keyword' => 'n', 'name' => 'no set exam'],
	    ['keyword' => 'y', 'name' => 'yes set exam']
        ]);

        Schema::create('quiz_bank', function (Blueprint $table) {
            $table->increments('quiz_num');
	    $table->unsignedInteger('book_num')->nullable();
	    $table->foreign('book_num')->references('book_num')->on('books');
	    $table->unsignedSmallInteger('book_page')->nullable();
	    $table->json('quiz_question');
            $table->char('quiz_type', 1);
	    $table->foreign('quiz_type')->references('keyword')->on('quiz_type_keyword');
	    $table->unsignedInteger('quiz_count_set_exam')->default(0);
	    $table->unsignedInteger('quiz_count_mistaken')->default(0);
            $table->char('quiz_level', 1);
	    $table->unsignedInteger('user_t_num')->nullable();
            $table->char('quiz_set_state', 1);
	    $table->foreign('quiz_set_state')->references('keyword')->on('quiz_set_state_keyword');
            $table->timestamps();
        });


	DB::unprepared('
	CREATE TRIGGER tr_quiz_bank_check BEFORE INSERT ON groups
	FOR EACH ROW
	    BEGIN
                DECLARE v_division CHAR(1) DEFAULT NULL;
                DECLARE v_page_max TINYINT UNSIGNED DEFAULT NULL;
                DECLARE v_page_min TINYINT UNSIGNED DEFAULT NULL;

		SELECT user_division INTO v_division
		FROM users
		WHERE user_num = NEW.user_t_num;
		IF v_division <> "t" THEN
			SIGNAL SQLSTATE "16000"
				SET MESSAGE_TEXT = "check constraint on quiz_bank.user_t_num division failed";
		END IF;
		IF NEW.book_num IS NOT NULL THEN

		    SELECT book_page_max, book_page_min
                    INTO v_page_max, v_page_min
		    FROM books
		    WHERE book_num = NEW.book_num;
                    
                    IF NEW.book_page < v_page_min
                       OR NEW.book_page > v_page_max THEN
			SIGNAL SQLSTATE "16001"
				SET MESSAGE_TEXT = "check constraint on quz_bank.book_page failed";
                    END IF;
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
