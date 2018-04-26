<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class RaceController extends Controller{
    // 리스트 선택 후 레이스 혹은 테스트를 생성
    public function createRace(Request $request)
    {
        $postData     = array(
            'groupId'   => 1,
            'raceType'  => 'race',
            'listId'    => 1
        );

//        $postData = array(
//            'groupId'   => $request->input('groupId'),
//            'raceType'  => $request->input('raceType'),
//            'listId'    => $request->input('listId')
//        );

        // 유저가 선생인지 확인하고 선생이 아니면 강퇴
        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select([
                'u.number   as userId',
                's.number   as sessionId'
            ])
            ->where('u.number', '=', 123456789)
            ->leftJoin('sessionDatas as s', 's.userNumber', '=', 'u.number')
            ->first();

        if(!isset($userData->sessionId)){
            $request->session()->put('sessionId', DB::table('sessionDatas')
                ->insertGetId([
                    'userNumber' => $userData->userId
                ], 'number'));
        }else{
            $request->session()->put('sessionId', $userData->sessionId);
        }
        // test

        // 로그인된 유저의 세션 정보 가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 레이스를 시작하려는 그룹이 해당 유저의 그룹이 맞는지 확인
        // 그룹의 정보 가져오기
        $groupData = DB::table('groups as g')
		    ->select(
		        'g.number                       as groupId',
			    'g.name                         as groupName',
                DB::raw('COUNT(gs.userNumber)   as studentCount')
            )
		    ->join('groupStudents as gs', 'gs.groupNumber', '=', 'g.number')
		    ->where([
		        'g.number'          => $postData['groupId'],
                'g.teacherNumber'   => $userData['userId'],
                'gs.accessionState' => 'enrollment'
            ])
            ->groupBy('g.number')
		    ->first();

        // 해당 리스트의 존재확인
        $listData = DB::table('lists as l')
		    ->select(
		        'l.name                     as listName',
                'l.number                   as listId',
                DB::raw('COUNT(lq.quiz_num) as quizCount')
            )
            ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
            ->join('folders as f', 'f.number', '=', 'l.folderNumber')
		    ->where([
		        'l.number' => $postData['listId'],
            ])
            ->where(function ($query){
                global $userData;
                $query->where('f.teacherNumber'. '=', $userData['userId'])
                    ->orWhere('l.openState', '=', QuizTreeController::OPEN_STATE);
            })
            ->groupBy('l.number')
		    ->first();

        // 레이스와 그룹이 존재하면 시작
        if((!is_null($listData)) && (!is_null($groupData))) {

            // 레이스 정보를 저장
            $raceId = DB::table('races')->insertGetId([
                'groupNumber' => $groupData->groupId,
                'teacherNumber' => $userData['userId'],
                'listNumber' => $listData->listId,
                'type' => $postData['raceType']
            ], 'number');

            // 교사 세션에 데이터 저장
            DB::table('sessions')
                ->where('number', '=', $request->session()->get('sessionId'))
                ->update(['raceNumber' => $raceId]);

            // 반납할 값 정리
            $returnValue = array(
                'list'=>array(
                    'listName'  => $listData->listName,
                    'quiCount'  => $listData->quizCount
                ),
                'group'=>array(
                    'groupName'         => $groupData->groupName,
                    'groupStudentCount' => $groupData->studentCount
                ),
                'sessionId' => $request->session()->get('sessionId'),
                'check'     => true,
                'quizData'  => isset($quizList) ? $quizList : null
            );
        }
        else {
            $returnValue = array('check' => false);
        }

        // 값을 반납
        return $returnValue;
    }

    // 소켓방에 교사가 입장했을 때 실행
    public function teacherIn(Request $request){
        // 반는 값
        $postData = array(
            'roomPin'   => '123465',
            'sessionId' => 1
        );
//        $postData = array(
//            'roomPin'   => $request->input('roomPin'),
//            'sessionId' => $request->input('sessionId')
//        );

        // 레이스 존재여부 확인
        $raceData = DB::table('sessions as s')
            ->select(
                'r.questionNumber   as quizCount',
                'r.number           as raceId',
                'r.groupNumber      as groupId'
            )
            ->leftJoin('races as r', 'r.number', '=', 's.raceNumber')
            ->where('s.number', '=', $postData['sessionId'])
            ->groupBy('s.number')
            ->first();

        if(!is_null($raceData)){
            // 올바르게 방번호가 입력되었는지 확인
            $updateCheck = DB::table('sessions')
                ->where('number', '=', $postData['sessionId'])
                ->update([
                    'PIN' => $postData['roomPin']
                ]);

            // 반납할 값 정리
            $returnValue = array(
                'race' => array(
                    'raceId'    => $raceData->raceId,
                    'quizCount' => $raceData->quizCount),
                'group' => array(
                    'groupId'     => $raceData->groupId),
                'check' => true
            );
        }
        // 레이스 정보를 찾을 수 없을 때
        else {
            $returnValue = array('check' => false);
        }

        return $returnValue;
    }

    // 학생이 소켓에 들어올 때
    public function studentIn(Request $request){
        $postData = array(
            'roomPin' => '123456',
            'sessionId' => 2,
            'nick' => 'temp1',
            'characterId' => 2
        );

        // 현재 유저가 그룹에 소속된 유저인지 확인
        $userCheck = DB::table('groupStudents as gs')
            ->select(
                's2.raceNumber as raceId'
            )
            ->where([
                's.number' => $postData['sessionId'],
                's2.PIN' => $postData['roomPin'],
                's2.nick' => null
            ])
            ->join('sessions as s1', 's1.userNumber', '=', 'gs.userNumber')
            ->join('races as r', 'r.groupNumber', '=', 'gs.groupNumber.')
            ->join('sessions as s2', 's2.raceNumber', '=', 'r.number')
            ->first();

        if(!is_null($userCheck))
        {
            do{
                // 이미 선택된 캐릭터 목록 획득
                $characters = DB::table('characters as c')
                    ->select(
                        'c.character_num as characterId'
                    )
                    ->where('rr.set_exam_num', '=', $postData['setExamId'])
                    ->leftJoin('sessions as s', 's.character_num', '=', 'c.character_num')
                    ->leftJoin('race_results as rr', 'rr.user_num', '=', 's.user_num')
                    ->get();

                $charList = array();
                foreach($characters as $charNumber){
                    array_push($charList, $charNumber->characterId);
                }

                // 캐릭터 url 획득
                $character = DB::table('characters')
                    ->select(
                        'character_num as characterId',
                        'character_url as characterUrl'
                    )
                    ->whereNotIn('character_num', $charList)
                    ->inRandomOrder()
                    ->first();

                // 유저 세션에 정보 저장
                $updateCheck = DB::table('sessions')
                    ->where('session_num', '=', $postData['sessionId'])
                    ->update([
                        'set_exam_num' => $postData['setExamId'],
                        'character_num'  => $character->characterId,
                        'room_pin_number' => $postData['roomId']
                    ]);

            } while ($updateCheck != 1);

            // 캐릭터 획득 성공 여부 확인
            if($updateCheck == 1){
                // 참가 유저 정보 입력
                DB::table('race_results')
                    ->insert([
                        'set_exam_num' => $postData['setExamId'],
                        'user_num' => $userCheck->user_num
                    ]);

                // 성공 값 반납
                $returnValue = array('check' => true,
                    'characterUrl' => $character->characterUrl);
            } else {
                $returnValue = array('check' => false);
            }
        } else {
            $returnValue = array('check' => false);
        }

        return response()->json($returnValue);
    }

    public function nickIn(Request $request){
        $json     = $request->input('post');
        //학생의 세션 아이디 필요
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => 2, 'setExamId' => 2, 'groupId' => 1));
        // 데모버전용 학생 아이디로 학생을 검색
        $json     = json_encode(array('userId' => 'tamp2id', 'userNick' => 'baka'));
        $postData = json_decode($json, true);

        // test
        $userId = DB::table('users as u')
            ->select([
                'u.user_num as user_num',
                's.session_num as session_num'
            ])
            ->where('u.user_id', '=', $postData['userId'])
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userId->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId([
                    'user_num' => $userId->user_num
                ], 'session_num');
        }else{
            $_SESSION['sessionId'] = $userId->session_num;
        }
        // test

        $updateCount = DB::table('sessions')
            ->where([
                ['session_num', '=', $_SESSION['sessionId']],
                ['set_exam_num', '<>', null]
            ])
            ->update([
                'user_nick' => $postData['userNick'
                ]]);

        if($updateCount == 1)
            $returnValue = array(
                'check' => true,
                'nick' => $postData['userNick']
            );
        else{
            $returnValue = array(
                'check' => false
            );
        }

        return response()->json($returnValue);
    }

    // get quiz
    public function quizNext(Request $request){
        $json     = $request->input('post');
        //선생의 세션 아이디 필요
        //$json     = json_encode(array('roomPin' => '123456', 'setExamId' => 2, 'sessionId' => 1));
        $postData = json_decode($json, true);

        $chaeck = DB::table('sessions')
            ->select(
                'session_num'
            )
            ->where([
                'session_num'     => $postData['sessionId'],
                'set_exam_num'    => $postData['setExamId'],
                'room_pin_number' => $postData['roomPin']
            ])
            ->first();

        if(isset($chaeck->session_num)){
            $raceData = DB::table('race_set_exam as rse')
                ->select(
                    'rse.race_num                 as raceId',
                    'rse.book_num                 as bookId',
                    'rse.book_page_start          as pageStart',
                    'rse.book_page_end            as pageEnd',
                    'rse.exam_count               as setExamCount',
                    DB::raw('COUNT(quiz.sequence) as examCount')
                )
                ->where('rse.set_exam_num', '=', $postData['setExamId'])
                ->leftJoin('race_set_exam_quizs as quiz', 'quiz.set_exam_num', '=', 'rse.set_exam_num')
                ->groupBy('rse.set_exam_num')
                ->first();

            $setExams = DB::table('race_quizs as rq')
                ->select(
                    'rq.quiz_num as quiz_num'
                )
                ->where([
                    'rq.race_num'       => $raceData->raceId,
                    'rseq.set_exam_num' => $postData['setExamId']
                ])
                ->leftJoin('race_set_exam_quizs as rseq', 'rseq.quiz_num', '=', 'rq.quiz_num')
                ->get();

            $setExamList = array(0);
            foreach($setExams as $exam){
                array_push($setExamList, $exam->quiz_num);
            }

            $quizData = DB::table('race_quizs as rq')
                ->select(
                    'qb.quiz_num          as quizId',
                    'qb.quiz_question     as question',
                    'qb.quiz_right_answer as right',
                    'qb.quiz_example1     as exam1',
                    'qb.quiz_example2     as exam2',
                    'qb.quiz_example3     as exam3',
                    'qb.quiz_type         as type'
                )
                ->whereNotIn('rq.quiz_num', $setExamList)
                ->join('quiz_bank as qb', 'qb.quiz_num', 'rq.quiz_num')
                ->inRandomOrder()
                ->first();

            $updateCheck = DB::table('race_set_exam_quizs')
                ->insertGetId([
                    'set_exam_num' => $postData['setExamId'],
                    'quiz_num' => $quizData->quizId
                ], 'sequence');

            $returnValue = array(
                'quiz' => array(
                    'examCount' => $raceData->examCount + 1,
                    'sequence'  => $updateCheck,
                    'question'  => $quizData->question,
                    'right'     => $quizData->right,
                    'example1'  => $quizData->exam1,
                    'example2'  => $quizData->exam2,
                    'example3'  => $quizData->exam3,
                    'type'      => $quizData->type
                ),
                'check' => true);
        } else {
            $returnValue = array('check' => false);
        }

        return response()->json($returnValue);
    }

    /*
    public function resultIn(Request $request){
        //$json     = $request->input('post');
        // 학생의 세션 아이디 필요
        $json     = json_encode(array(
            'roomPin' => '123456',
            'sessionId' => 1,
            'exam_data' => array(
                'setExamId' => 2,
                'sequence' => 1,
                'exam_result'=>'1')
        ));
        $postData = json_decode($json, true);

        UserController::sessionDataGet($postData['sessionId']);

        $data = DB::table('race_result')
            ->select('user_num as userId', 'set_exam_num as setExamId')
            ->where([
                'set_exam_num' => $postData['setExamId']])
            ->first();

        if(isset($data->userId)){
            DB::table('playing_quizs')
                ->insert(['set_exam_num' => $data->setExamId,
                    'user_num' => $data->userId,
                    'sequence' => $postData['sequence'],
                    'result' => $postData['exam_result']
                ]);
        }

        $returnValue = array();
        return response()->json($returnValue);
    }
    */

    public function destroy(Request $request)
    {
        /*
          $item = Item::find($id);
          $item->delete();

          return response()->json('Successfully Deleted');
        */
    }
}