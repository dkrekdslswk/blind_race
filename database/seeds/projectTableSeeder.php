<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class projectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['tamp1id','temp1password','temp1name'],
            ['tamp2id','temp2password','temp2name'],
            ['tamp3id','temp3password','temp3name'],
            ['tamp4id','temp4password','temp4name'],
            ['tamp5id','temp5password','temp5name'],
            ['tamp6id','temp6password','temp6name']
        ];
 
        foreach($users as $user){
            $userId = DB::table('users')->insertGetId([
                'user_id'       => array_get($user, 0),
                'user_password' => array_get($user, 1),
                'user_name'     => array_get($user, 2)
            ], 'user_num');

            if(!isset($user_first)){
                $userFirstId = $userId;
            }
        }

        DB::table('user_teachers')->insert([
            'user_t_num'    => $userFirstId
        ]);

        $groupId = DB::table('groups')->insertGetId([
            'group_name'    => 'group1',
            'user_t_num'    => $userFirstId
        ], 'group_num');

        for($user_num = 2 ; $user_num <= 6 ; $user_num++){
            DB::table('group_students')->insert([
                'group_num'           => $groupId,
                'user_num'            => $user_num,
                'group_student_state' => 'a'
            ]);
        }

        $raceId = DB::table('races')->insertGetId([
            'user_t_num'=>$userFirstId,
            'race_name'=>"테스트용 레이스1",
            'race_folder_name'=>'-';
        ], 'race_num');

        for($quiz_count = 1 ; $quiz_count <= 30 ; $quiz_count++){
	    $quizId = DB::table('quiz_bank')->insertGetId([
                'quiz_question'=>''.($quiz_count%4+1).'',
                'quiz_right_answer'=>''.($quiz_count%4+1).'',
                'quiz_example1'=>''.(($quiz_count+1)%4+1).'',
                'quiz_example2'=>''.(($quiz_count+2)%4+1).'',
                'quiz_example3'=>''.(($quiz_count+3)%4+1).'',
                'quiz_type'=>'o',
                'quiz_level'=>'5';
            ], 'quiz_num');

            DB::table('race_quizs')->insert([
                'race_num'=>$raceId,
                'quiz_num'=>$quizId
            ]);
	}
    }
}
