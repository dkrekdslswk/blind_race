<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlindDymmyTableSeeder extends Seeder
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
            ['tamp2','tamp2','tamp2'],
            ['tamp3','tamp3','tamp3'],
            ['tamp4','tamp4','tamp4'],
            ['tamp5','tamp5','tamp5'],
            ['tamp6','tamp6','tamp6']
        ];
 
        foreach($users as $user){
            $userId = DB::table('users')->insertGetId([
                'user_id'       => array_get($user, 0),
                'user_password' => array_get($user, 1),
                'user_name'     => array_get($user, 2)
            ], 'user_num');

            if(!isset($userFirstId)){
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

        for($user_num = 2 ; $user_num <= count($users) ; $user_num++){
            DB::table('group_students')->insert([
                'group_num'           => $groupId,
                'user_num'            => $user_num,
                'group_student_state' => 'a'
            ]);
        }

        $raceId = DB::table('races')->insertGetId([
            'user_t_num'=>$userFirstId,
            'race_name'=>"테스트용 레이스1",
        ], 'race_num');

        for($quiz_count = 1 ; $quiz_count <= 30 ; $quiz_count++) {
            $quizId = DB::table('quiz_bank')->insertGetId([
                'quiz_question' => '' . ($quiz_count % 4 + 1) . '',
                'quiz_right_answer' => '' . ($quiz_count % 4 + 1) . '',
                'quiz_example1' => '' . (($quiz_count + 1) % 4 + 1) . '',
                'quiz_example2' => '' . (($quiz_count + 2) % 4 + 1) . '',
                'quiz_example3' => '' . (($quiz_count + 3) % 4 + 1) . '',
                'quiz_type' => 'o',
                'quiz_level' => '5'
            ], 'quiz_num');

            DB::table('race_quizs')->insert([
                'race_num' => $raceId,
                'quiz_num' => $quizId
            ]);
        }

        for ($char = 1; $char <= 9; $char++) {
            DB::table('characters')->insert([
                'character_url' => 'img/character/char' . (string)$char
            ]);
        }

        $raceSetExamId = DB::table('race_set_exam')->insertGetId([
            'group_num'=>$groupId,
            'set_exam_state'=>'n',
            'exam_count'=>30,
            'race_num'=>$raceId
        ], 'set_exam_num');

        for($user_num = 2 ; $user_num <= count($users) ; $user_num++){
            DB::table('race_results')
                ->insert(['set_exam_num' => $raceSetExamId,
                    'user_num' => $user_num]);
        }

        $bookId =DB::table('books')->insertGetId([
            'book_name'=>"급소공략 N1",
            'book_page_max'=>12,
            'book_page_min'=>195
        ], 'book_num');

        $quizs = [
            [
                17,
                '苦労してためたお金なのだから、一円（　　）無駄には使いたくない。',
                'たりとも',
                ['ばかりも', 'だけさえ', 'とはいえ'],
                'o', '1'
            ],
            [
                17,
                'この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。',
                'とあって',
                ['からして', 'にあって', 'にしては'],
                'o', '1'
            ],
            [
                18,
                '姉は市役所に勤める（　　）、ボランティアで日本語を教えています。',
                'かたわら',
                ['かたがた', 'こととて', 'うちに'],
                'o', '1'
            ],
            [
                18,
                '周辺の住民がいくら反対した（　　）、動きだした開発計画は止まらないだろう。',
                'ところで',
                ['かぎりで', 'もので', 'ようで'],
                'o', '1'
            ]];

        foreach ($quizs as $quiz){
            DB::table('quiz_bank')
                ->insert([
                    'book_num'          => $bookId,
                    'book_page'         => $quiz[0],
                    'quiz_question'     => $quiz[1],
                    'quiz_right_answer' => $quiz[2],
                    'quiz_example1'     => $quiz[3][0],
                    'quiz_example2'     => $quiz[3][1],
                    'quiz_example3'     => $quiz[3][2],
                    'quiz_type'         => $quiz[4],
                    'quiz_level'        => $quiz[5]
                ]);
        }

        for($count = 0 ; $count < 5 ; $count++) {
            $raceSetExamId = DB::table('race_set_exam')->insertGetId([
                'group_num' => $groupId,
                'set_exam_state' => 'n',
                'exam_count' => 30,
                'race_num' => $raceId,
                'created_at' => DB::raw('subdate(now(), INTERVAL '.$count.' DAY)')
            ], 'set_exam_num');

            for ($user_num = 2; $user_num <= count($users); $user_num++) {
                DB::table('race_results')
                    ->insert(['set_exam_num' => $raceSetExamId,
                        'user_num' => $user_num]);
            }

            for ($quiz_count = 1; $quiz_count <= 30; $quiz_count++) {
                $quizId = DB::table('quiz_bank')->insertGetId([
                    'quiz_question' => '' . ($quiz_count % 4 + 1) . '',
                    'quiz_right_answer' => '' . ($quiz_count % 4 + 1) . '',
                    'quiz_example1' => '' . (($quiz_count + 1) % 4 + 1) . '',
                    'quiz_example2' => '' . (($quiz_count + 2) % 4 + 1) . '',
                    'quiz_example3' => '' . (($quiz_count + 3) % 4 + 1) . '',
                    'quiz_type' => 'o',
                    'quiz_level' => '5'
                ], 'quiz_num');

                $setQuizId = DB::table('race_set_exam_quizs')->insertGetId([
                    'set_exam_num' => $raceSetExamId,
                    'quiz_num' => $quizId
                ], 'sequence');

                for ($user_num = 2; $user_num <= count($users); $user_num++) {
                    DB::table('playing_quizs')->insert([
                        'set_exam_num' => $raceSetExamId,
                        'user_num' => $user_num,
                        'sequence' => $setQuizId,
                        'result' => (string)mt_rand(1, 4)
                    ]);
                }
            }
        }
    }
}
