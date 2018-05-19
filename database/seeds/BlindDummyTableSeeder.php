<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlindDummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [123456789, 'sub', '이OO교수', 'teacher'],
            [999999999, 'main', 's', 'root'],
            [1300000, '1234', '김똘똘', 'student'],
            [1300001, '1234', '최천재', 'student'],
            [1300002, '1234', '안예민', 'student'],
            [1300003, '1234', '심샤쵸', 'student'],
            [1300004, '1234', '사라다', 'student']
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'number' => array_get($user, 0),
                'pw' => array_get($user, 1),
                'name' => array_get($user, 2),
                'classification' => array_get($user, 3)
            ]);
        }
        $userss = [
            [1300005,'1234','똘똘','student'],
            [1300006,'1234','멍청','student'],
            [1300007,'1234','예민','student'],
            [1300008,'1234','샤쵸','student'],
            [1300009,'1234','라다','student']
        ];

        foreach($userss as $user){
            DB::table('users')->insert([
                'number'            => array_get($user, 0),
                'pw'                => array_get($user, 1),
                'name'              => array_get($user, 2),
                'classification'    => array_get($user, 3)
            ]);
        }
        $groupId = DB::table('groups')->insertGetId([
            'name' => '3WDJ',
            'teacherNumber' => $users[0][0]
        ], 'number');

        for ($number = 2; $number < count($users); $number++) {
            DB::table('groupStudents')->insert([
                'groupNumber' => $groupId,
                'userNumber' => $users[$number][0],
            ]);
        }

        $folderId = DB::table('folders')->insertGetId([
            'teacherNumber' => $users[0][0],
            'name' => "테스트용 폴더1",
        ], 'number');

        $listId = DB::table('lists')->insertGetId([
            'folderNumber' => $folderId,
            'name' => "테스트용 리스트1",
            'openState' => 1
        ], 'number');

        $bookId = DB::table('books')->insertGetId([
            'name' => "테스트용 교재1",
            'maxPage' => 1,
            'minPage' => 6,
        ], 'number');

        $quizType = [
            ['name' => 'vocabulary obj'],
            ['name' => 'vocabulary sub'],
            ['name' => 'word obj'],
            ['name' => 'word sub'],
            ['name' => 'grammar obj'],
            ['name' => 'grammar sub']
        ];

        $quizList = array();
        for ($count = 1; $count <= 6; $count++) {
            $quizId = DB::table('quizBanks')->insertGetId([
                'bookNumber' => $bookId,
                'page' => $count,
                'question' => '' . ($count) . '',
                'hint' => '' . ($count) . '',
                'rightAnswer' => '' . ($count) . '',
                'example1' => '' . ($count + 1) . '',
                'example2' => '' . ($count + 2) . '',
                'example3' => '' . ($count + 3) . '',
                'type' => $quizType[$count - 1]['name'],
                'level' => '5'
            ], 'number');

            array_push($quizList, $quizId);

            DB::table('listQuizs')->insert([
                'listNumber' => $listId,
                'quizNumber' => $quizId
            ]);
        }

        for ($char = 1; $char <= 28; $char++) {
            DB::table('characters')->insert([
                'url' => 'img/character/char' . (string)$char
            ]);
        }

        $bookId = DB::table('books')->insertGetId([
            'name' => "급소공략 N1",
            'maxPage' => 12,
            'minPage' => 195
        ], 'number');

        $quizs = [
            [
                17,
                '苦労してためたお金なのだから、一円（　　）無駄には使いたくない。',
                'たりとも',
                ['ばかりも', 'だけさえ', 'とはいえ'],
                'grammar obj', '1'
            ],
            [
                17,
                'この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。',
                'とあって',
                ['からして', 'にあって', 'にしては'],
                'grammar obj', '1'
            ],
            [
                18,
                '姉は市役所に勤める（　　）、ボランティアで日本語を教えています。',
                'かたわら',
                ['かたがた', 'こととて', 'うちに'],
                'grammar obj', '1'
            ],
            [
                18,
                '周辺の住民がいくら反対した（　　）、動きだした開発計画は止まらないだろう。',
                'ところで',
                ['かぎりで', 'もので', 'ようで'],
                'grammar obj', '1'
            ]];

        foreach ($quizs as $quiz) {
            DB::table('quizBanks')
                ->insert([
                    'bookNumber' => $bookId,
                    'page' => $quiz[0],
                    'question' => $quiz[1],
                    'rightAnswer' => $quiz[2],
                    'example1' => $quiz[3][0],
                    'example2' => $quiz[3][1],
                    'example3' => $quiz[3][2],
                    'type' => $quiz[4],
                    'level' => $quiz[5]
                ]);
        }

        for ($day = 7 ; $day > 0 ; $day--) {
            for ($count = 0; $count < 5; $count++) {
                $raceId = DB::table('races')->insertGetId([
                    'groupNumber' => $groupId,
                    'teacherNumber' => $users[0][0],
                    'listNumber' => $listId,
                    'type' => 'race',
                    'created_at' => DB::raw('subdate(now(), INTERVAL ' . $day . ' DAY)')
                ], 'number');

                for ($number = 2; $number < count($users); $number++) {
                    DB::table('raceUsers')
                        ->insert([
                            'raceNumber' => $raceId,
                            'userNumber' => $users[$number][0],
                            'retestState' => 'not',
                            'wrongState' => 'not'
                        ]);
                }

                for ($count = 1; $count <= 6; $count++) {
                    for ($number = 2; $number < count($users); $number++) {
                        $answerCheck = (string)(mt_rand(0, 2) == 0 ? 'X' : 'O');
                        DB::table('records')->insert([
                            'raceNo' => $raceId,
                            'userNo' => $users[$number][0],
                            'listNo' => $listId,
                            'quizNo' => $quizList[$count - 1],
                            'answerCheck' => $answerCheck,
                            'answer' => $answerCheck == '0' ? $count : $count + mt_rand(1, 3)
                        ]);
                    }
                }
            }
        }
    }
}
