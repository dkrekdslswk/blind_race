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
        // 내부 함수에서도 userData를 가져가 쓰기위해서 사용
        global $userData;

        // 받을 값 설정.
//        $postData     = array(
//            'groupId'   => 1,
//            'raceType'  => 'race',
//            'listId'    => 1
//        );

        $postData = array(
            'groupId'   => $request->input('groupId'),
            'raceType'  => $request->input('raceType'),
            'listId'    => $request->input('listId')
        );

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
                'g.teacherNumber'   => $userData['userId']
            ])
            ->groupBy('g.number')
            ->first();

        // 해당 리스트의 존재확인
        $listData = DB::table('lists as l')
            ->select(
                'l.name                         as listName',
                'l.number                       as listId',
                DB::raw('COUNT(lq.quizNumber)   as quizCount')
            )
            ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
            ->join('folders as f', 'f.number', '=', 'l.folderNumber')
            ->where([
                'l.number' => $postData['listId'],
            ])
            ->where(function ($query){
                global $userData;
                $query->where([
                    'f.teacherNumber' => $userData['userId']
                ])
                    ->orWhere([
                        'l.openState' => QuizTreeController::OPEN_STATE
                    ]);
            })
            ->groupBy('l.number')
            ->first();

        // 레이스와 그룹이 존재하면 시작
        if(!((!$listData) || (!$groupData))) {

            // 레이스 정보를 저장
            $raceId = DB::table('races')->insertGetId([
                'groupNumber'   => $groupData->groupId,
                'teacherNumber' => $userData['userId'],
                'listNumber'    => $listData->listId,
                'type'          => $postData['raceType']
            ], 'number');

            // 중복 없는 방 번호 입력
            do{
                // 랜덤 값 지정
                $roomPin = rand(100000, 999999);
//                $roomPin = 123456;

                // 교사 세션에 데이터 저장
                DB::table('sessionDatas')
                    ->where('number', '=', $request->session()->get('sessionId'))
                    ->update([
                        'raceNumber'        => $raceId,
                        'PIN'               => $roomPin,
                        'nick'              => '',
                        'characterNumber'   => null
                    ]);

                // 해당 유저 이외의 같은 방번호를 가진 사람이 있는가?
                $roomCheck = DB::table('sessionDatas')
                    ->select('PIN')
                    ->where(['PIN' => $roomPin])
                    ->where('number', '<>', $request->session()->get('sessionId'))
                    ->first();
            }while($roomCheck);

            // 반납할 값 정리
            $returnValue = array(
                'list'=>array(
                    'listName'  => $listData->listName,
                    'quizCount'  => $listData->quizCount
                ),
                'group'=>array(
                    'groupName'         => $groupData->groupName,
                    'groupStudentCount' => $groupData->studentCount
                ),
                'sessionId' => $request->session()->get('sessionId'),
                'check'     => true,
                'roomPin'   => $roomPin
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        // 값을 반납
//        return $returnValue;
        return view('Race/race_waiting')->with('response', $returnValue);
    }

    // 학생이 소켓에 들어올 때
    public function studentIn(Request $request){
        // 받아야하는 값
//        $postData = array(
//            'roomPin'       => 123456,
//            'sessionId'     => 2
//        );
        $postData = array(
            'roomPin'       => $request->input('roomPin'),
            'sessionId'     => $request->input('sessionId')
        );
        // 반납값 디폴트
        $sessionCheck   = false;

        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 해당 학생이 참가한 레이스의 정보 및 해당 그룹 학생인지 확인
        $data = DB::table('races as r')
            ->select([
                'r.number as raceId'
            ])
            ->where([
                'gs.userNumber'         => $userData['userId'],
                's2.PIN'                => $postData['roomPin'],
                's2.nick'               => ''
            ])
            ->join('groupStudents as gs', 'gs.groupNumber', '=', 'r.groupNumber')
            ->join('sessionDatas as s2', 's2.raceNumber', '=', 'r.number')
            ->first();

        if ($data) {
            // 유저 세션 갱신
            $sessionUpdate = DB::table('sessionDatas')
                ->where([
                    'number' => $postData['sessionId']
                ])
                ->update([
                    'PIN'               => $postData['roomPin'],
                    'raceNumber'        => $data->raceId,
                    'characterNumber'   => null,
                    'nick'              => null,
                ]);
            $sessionCheck = ($sessionUpdate == 1);

            // 갱신 성공시 유저정보 입력
            if ($sessionCheck){
                DB::table('raceUsers')
                    ->insert([
                        'raceNumber'    => $data->raceId,
                        'userNumber'    => $userData['userId'],
                        'retestState'   => 'not'
                    ]);
            }
        }

        // 반납값 정리
        $returnValue = array(
            'check'         => $sessionCheck,
        );

        return $returnValue;
    }

    // 학생이 소켓에 들어올 때
    public function studentSet(Request $request){
        // 받아야하는 값
//        $postData = array(
//            'sessionId'     => 2,
//            'nick'          => 'temp3',
//            'characterId'   => 1
//        );
        $postData = array(
            'sessionId'     => $request->input('sessionId'),
            'nick'          => $request->input('nick'),
            'characterId'   => $request->input('characterId')
        );

        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 해당 학생이 레이스에 참가중인지 확인
        $Data = DB::table('sessionDatas as s1')
            ->select(
                's2.raceNumber as raceId'
            )
            ->where([
                's1.number'   => $postData['sessionId'],
                's2.nick'   => '',
            ])
            ->join('sessionDatas as s2', function ($join){
                $join->on('s2.PIN', '=', 's1.PIN');
                $join->on('s2.raceNumber', '=', 's1.raceNumber');
            })
            ->first();

        if ($Data) {
            // 닉네임 중복확인
            $nickUpdate = DB::table('sessionDatas')
                ->where([
                    'number' => $postData['sessionId']
                ])
                ->update([
                    'nick'  => $postData['nick']
                ]);
            $nickCheck = ($nickUpdate == 1);

            // 캐릭터 중복확인
            $characterData = DB::table('sessionDatas')
                ->where([
                    'number' => $postData['sessionId']
                ])
                ->update([
                    'characterNumber'   => $postData['characterId']
                ]);
            $characterCheck = ($characterData == 1);

            // 반납값 정리
            $returnValue = array(
                'nickCheck'         => $nickCheck,
                'characterCheck'    => $characterCheck,
                'characterId'       => $postData['characterId'],
                'check'             => true
            );
        } else {
            $returnValue = array(
                'check'             => false
            );
        }

        return $returnValue;
    }

    // get quiz
    public function quizNext(Request $request){
        // 선생의 세션 번호 필요
//        $postData = array(
//            'sessionId' => 1,
//        );
        $postData = array(
            'sessionId' => $request->input('sessionId'),
        );

        // 선생의 정보를 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 레이스 번호가 존재하는지 확인
        if(!is_null($userData['raceId'])){

            // 현재 진행중의 번호 가져오기
            $quizCount = DB::table('races')
                ->select(
                    'questionNumber as count'
                )
                ->where([
                    'number' => $userData['raceId']
                ])
                ->first();

            // 문제 가져오기
            $quizData = DB::table('quizBanks as qb')
                ->select([
                    'qb.number          as number',
                    'qb.question        as question',
                    'qb.hint            as hint',
                    'qb.rightAnswer     as rightAnswer',
                    'qb.example1        as example1',
                    'qb.example2        as example2',
                    'qb.example3        as example3',
                    'qb.type            as type'
                ])
                ->where([
                    'lq.raceNumber' => $userData['raceId']
                ])
                ->join('listQuizs as lq', 'lq.quizNumber', '=', 'qb.number')
                ->orderBy('qb.number', 'desc')
                ->offset($quizCount->count)
                ->limit(1)
                ->first();

            // 다음 문제가 있을 때
            if($quizData) {
                // 현재 진행중의 번호 갱신
                DB::table('races')
                    ->where([
                        'number' => $userData['raceId']
                    ])
                    ->insert([
                        'questionNumber' => $quizCount->count + 1
                    ]);

                // 반납값 정리
                $type = explode(' ', $quizData->type);
                $returnValue = array(
                    'quiz' => array(
                        'quizCount' => $quizCount->count + 1,
                        'quizId'    => $quizData->number,
                        'question'  => $quizData->question,
                        'hint'      => $quizData->hint,
                        'right'     => $quizData->rightAnswer,
                        'example1'  => $quizData->example1,
                        'example2'  => $quizData->example2,
                        'example3'  => $quizData->example3,
                        'quizType'  => $type[0],
                        'makeType'  => $type[1]
                    ),
                    'check' => true
                );
            } else {
                $returnValue = array('check' => false);
            }
        } else {
            $returnValue = array('check' => false);
        }

        return response()->json($returnValue);
    }

    // 학생들의 정답들을 DB에 입력
    public function answerIn(Request $request){
        // 학생의 세션 아이디 필요
//        $postData     = array(
//            'sessionId' => 2,
//            'roomPin'   => 123456,
//            'quizId'    => 1,
//            'answer'    => 1
//        );
        $postData     = array(
            'sessionId' => $request->input('sessionId'),
            'roomPin'   => $request->input('roomPin'),
            'quizId'    => $request->input('quizId'),
            'answer'    => $request->input('answer')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 리스트 정보 가져오기
        $listData = DB::table('races as r')
            ->select(
                'r.number as raceId',
                'r.listNumber as listId'
            )
            ->where([
                's.PIN'     => $postData['roomPin'],
                's.nick'    => ''
            ])
            ->join('sessionDatas as s', 's.raceNumber', '=', 'r.number')
            ->first();

        // 레이스가 존재할 경우 값을 입력
        if($listData){
            // 정답을 입력
            $quizInsert = DB::table('records')
                ->insert([
                    'raceNo' => $listData->raceId,
                    'userNo' => $userData['userId'],
                    'listNo' => $listData->listId,
                    'quizNo' => $postData['quizId'],
                    'answer' => $postData['answer']
                ]);

            // true 값 입력 성공
            // false 재 시간 이내에 정답 입력실패, 중복입력, 레이스가 없음, 리스트가 없음.
            if ($quizInsert == 1){
                $returnValue = array(
                    'check' => true
                );
            } else{
                $returnValue = array(
                    'check' => false
                );
            }
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 중간 및 최종 결과용
    public function result(Request $request)
    {
        // 선생 세션아이디 필요
//        $postData = array(
//            'sessionId' => 1,
//            'quizId' => 1
//        );
        $postData = array(
            'sessionId' => $request->input('sessionId'),
            'quizId'    => $request->input('quizId')
        );

        // 세션정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 레이스 정보 가져오기
        $raceData = DB::table('races')
            ->select(
                'number as raceId',
                'listNumber as listId'
            )
            ->where([
                'number' => $userData['raceId']
            ])
            ->first();

        if ($raceData){
            // 현재 문제정보
            $quizData = DB::table('quizBanks')
                ->select(
                    'rightAnswer as right',
                    'type'
                )
                ->where([
                    'number' => $postData['quizId']
                ])
                ->first();

            // 참가 학생목록
            $students = DB::table('raceUsers as ru')
                ->select(
                    'ru.userNumber      as userId',
                    's.number           as sessionId',
                    's.nick             as nick',
                    's.characterNumber  as characterId',
                    DB::raw('MAX(r.quizNo) as lastQuizId'),
                    DB::raw('COUNT(CASE WHEN r.answer="@" THEN 1 END) as rightCount')
                )
                ->where([
                    'ru.raceNumber' => $raceData->raceId
                ])
                ->leftJoin('records as r', function ($join){
                    $join->on('r.raceNo', '=', 'ru.raceNumber');
                    $join->on('r.userNo', '=', 'ru.userNumber');
                })
                ->join('sessionDatas as s', 's.userNumber', '=', 'ru.userNumber')
                ->orderBy('rightCount', 'userId')
                ->groupBy('userId')
                ->get();

            // 값 정리 시작
            $studentResults = array();
            $rightAnswer = 0;
            $wrongAnswer = 0;
            foreach($students as $student){
                // 미입력자 처리
                if ($student->lastQuizId != $postData['quizId']){
                    DB::table('records')
                        ->insert([
                            'raceNo' => $raceData->raceId,
                            'userNo' => $student->userId,
                            'listNo' => $raceData->listId,
                            'quizNo' => $postData['quizId'],
                            'answer' => 'X'
                        ]);

                    array_push($studentResults, array(
                        'sessionId'     => $student->sessionId,
                        'nick'          => $student->nick,
                        'characterId'   => $student->characterId,
                        'rightCount'    => $student->rightCount,
                        'answer'        => 'X'
                    ));
                    $wrongAnswer++;
                } else {
                    // 입력한 사람 정답여부 처리하기
                    $answer = '';
                    switch ($student->type){
                        case 'vocabulary obj':
                        case 'word obj':
                        case 'grammar obj':
                            $answer = $student->answer == 1 ? 'O' : 'X';
                            break;
                        case 'vocabulary sub':
                        case 'word sub':
                        case 'grammar sub':
                            $rights = explode(',', $quizData->right);
                            $answer = 'X';
                            foreach ($rights as $right){
                                if($answer == $right){
                                    $answer = 'O';
                                    break;
                                }
                            }
                            break;
                        default:
                    }
                    if ($answer == 'O'){
                        $rightAnswer++;
                    }else{
                        $wrongAnswer++;
                    }
                    array_push($studentResults, array(
                        'sessionId'     => $student->sessionId,
                        'nick'          => $student->nick,
                        'characterId'   => $student->characterId,
                        'rightCount'    => $student->rightCount,
                        'answer'        => $answer
                    ));
                }
            }

            // 반납값 정리
            $returnValue = array(
                'studentResults'    => $studentResults,
                'rightAnswer'       => $rightAnswer,
                'wrongAnswer'       => $wrongAnswer,
                'check'             => true
            );
        }
        else{
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 레이스 종료 후 세션 정리
    // 미구현
}