<?php
namespace app\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuizTreeController;

class RaceController extends Controller{
    // 리스트 선택 후 레이스 혹은 테스트를 생성
    public function createRace(Request $request)
    {
        // 받을 값 설정.
//        $postData     = array(
//            'groupId'   => 1,
//            'raceType'  => 'race',
//            'listId'    => 1
//        );
        $postData = array(
            'groupId'       => $request->input('groupId'),
            'raceType'      => $request->input('raceType'),
            'listId'        => $request->input('listId'),
            'passingMark'   => $request->input('passingMark')
        );

        // 유저가 선생인지 확인하고 선생이 아니면 강퇴
        // test 임시로 유저 세션 부여
        // $userData = DB::table('users as u')
        //     ->select([
        //         'u.number   as userId',
        //         's.number   as sessionId'
        //     ])
        //     ->where('u.number', '=', 123456789)
        //     ->leftJoin('sessionDatas as s', 's.userNumber', '=', 'u.number')
        //     ->first();

        // if(!isset($userData->sessionId)){
        //     $request->session()->put('sessionId', DB::table('sessionDatas')
        //         ->insertGetId([
        //             'userNumber' => $userData->userId
        //         ], 'number'));
        // }else{
        //     $request->session()->put('sessionId', $userData->sessionId);
        // }
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
            ->where(function ($query) use ($userData){
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
            // 재시험 점수 값 확인
            if(($postData['passingMark']) < 0 || ($postData['passingMark'] > 100)){
                $postData['passingMark'] = 60;
            }

            // 레이스 정보를 저장
            $raceId = DB::table('races')->insertGetId([
                'groupNumber'   => $groupData->groupId,
                'teacherNumber' => $userData['userId'],
                'listNumber'    => $listData->listId,
                'passingMark'   => $postData['passingMark'],
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
                'sessionId'     => $request->session()->get('sessionId'),
                'check'         => true,
                'roomPin'       => $roomPin,
                'quizs'         => $this->quizGet($listData->listId)
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        // 값을 반납
        // return $returnValue;
        if ($returnValue['check'] == false){
            return view('homepage')->with('response', $returnValue);
        } else if ($postData['raceType'] == 'race') {
            return view('Race/race_waiting')->with('response', $returnValue);
        } else if ($postData['raceType'] == 'popQuiz') {
            return view('Race/race_popquiz')->with('response', $returnValue);
        }
    }

    // 레이스 혹은 테스트에서 학생이 방에 입장할 때
    public function studentIn(Request $request){
        // 받아야하는 값
//        $postData = array(
//            'roomPin'       => 123456,
//            'sessionId'     => 2
//        );
        $postData = array(
            'roomPin'       => $request->input('roomPin'),
            'sessionId'     => $request->input('sessionId') == 0 ? $request->session()->get('sessionId') : $request->input('sessionId')
        );

        // 앱 로그인인지 웹 로그인인지 확인
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 해당 학생이 참가한 레이스의 정보 및 해당 그룹 학생인지 확인
        $raceData = DB::table('races as r')
            ->select([
                'r.number as raceId',
                'r.type as raceType'
            ])
            ->where([
                'gs.userNumber'         => $userData['userId'],
                's2.PIN'                => $postData['roomPin'],
                's2.nick'               => ''
            ])
            ->join('groupStudents as gs', 'gs.groupNumber', '=', 'r.groupNumber')
            ->join('sessionDatas as s2', 's2.raceNumber', '=', 'r.number')
            ->first();

        if ($raceData) {
            // 유저 세션 갱신
            $sessionUpdate = DB::table('sessionDatas')
                ->where([
                    'number' => $postData['sessionId']
                ])
                ->update([
                    'PIN'               => $postData['roomPin'],
                    'raceNumber'        => $raceData->raceId,
                    'characterNumber'   => null,
                    'nick'              => $raceData->raceType == 'race' ? null : $userData['userName'],
                ]);
            $sessionCheck = ($sessionUpdate == 1);

            // 갱신 성공시 유저정보 입력
            if ($sessionCheck){
                DB::table('raceUsers')
                    ->insert([
                        'raceNumber'    => $raceData->raceId,
                        'userNumber'    => $userData['userId'],
                        'retestState'   => 'not',
                        'wrongState'   => 'not'
                    ]);
            }

            // 반납값 정리
            $returnValue = array(
                'sessionId'     => $postData['sessionId'],
                'check'         => $sessionCheck
            );
        } else {
            $returnValue = array(
                'sessionId'     => $postData['sessionId'],
                'check'         => false
            );
        }

        return $returnValue;
    }

    // 레이스 에서 학생이 닉네임과 캐릭터를 설정할 때
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

        // 해당 학생이 레이스에 참가중인지 확인
        $Data = DB::table('sessionDatas as s1')
            ->select(
                's2.raceNumber as raceId'
            )
            ->where([
                's1.number'         => $postData['sessionId'],
                's2.nick'           => '',
            ])
            ->where(function ($query){
                $query->where('s1.nick', '<>', '')
                    ->orWhereNull('s1.nick');
            })
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

    // 레이스 혹은 테스트에서 학생들의 정답들을 DB에 입력
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

        // 레이스 정보 가져오기
        $raceData = DB::table('races as r')
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
        if($raceData){
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

            switch ($quizData->type){
                case 'vocabulary obj':
                case 'word obj':
                case 'grammar obj':
                case 'vocabulary sub':
                case 'word sub':
                case 'grammar sub':
                    $rights = explode(',', $quizData->right);
                    $answerCheck = 'X';
                    foreach ($rights as $right){
                        if ($postData['answer'] == $right){
                            $answerCheck = 'O';
                            break;
                        }
                    }
                    break;
                default:
                    $answerCheck = 'X';
            }

            // 정답을 입력
            $quizInsert = DB::table('records')
                ->insert([
                    'raceNo'        => $raceData->raceId,
                    'userNo'        => $userData['userId'],
                    'listNo'        => $raceData->listId,
                    'quizNo'        => $postData['quizId'],
                    'answerCheck'   => $answerCheck,
                    'answer'        => $postData['answer']
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

    // 레이스에서 중간 및 최종 결과용
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
            // 참가 학생목록
            $students = DB::table('raceUsers as ru')
                ->select(
                    'ru.userNumber      as userId',
                    's.number           as sessionId',
                    's.nick             as nick',
                    's.characterNumber  as characterId',
                    DB::raw('MIN(r.quizNo) as lastQuizId'),
                    DB::raw('COUNT(CASE WHEN r.answerCheck="O" THEN 1 END) as rightCount')
                )
                ->where([
                    'ru.raceNumber' => $raceData->raceId
                ])
                ->whereNotNull('s.nick')
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
                if ((int)$student->lastQuizId != (int)$postData['quizId']){
                    DB::table('records')
                        ->insert([
                            'raceNo' => $raceData->raceId,
                            'userNo' => $student->userId,
                            'listNo' => $raceData->listId,
                            'quizNo' => $postData['quizId'],
                            'answer'        => '',
                            'answerCheck'   => 'X'
                        ]);

                    array_push($studentResults, array(
                        'sessionId'     => $student->sessionId,
                        'nick'          => $student->nick,
                        'characterId'   => $student->characterId,
                        'rightCount'    => $student->rightCount,
                        'answer'        => '',
                        'answerCheck'   => 'X'
                    ));
                    $wrongAnswer++;
                } else {
                    // 입력한 사람 정답여부 처리하기
                    $studentAnswer = DB::table('records')
                        ->select('answerCheck')
                        ->where([
                            'raceNo' => $raceData->raceId,
                            'userNo' => $student->userId,
                            'listNo' => $raceData->listId,
                            'quizNo' => $postData['quizId']
                        ])
                        ->first();

                    if ($studentAnswer->answerCheck == 'O'){
                        $rightAnswer++;
                    }else{
                        $wrongAnswer++;
                    }
                    array_push($studentResults, array(
                        'sessionId'     => $student->sessionId,
                        'nick'          => $student->nick,
                        'characterId'   => $student->characterId,
                        'rightCount'    => $student->rightCount,
                        'answer'        => $studentAnswer->answerCheck
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

    // 레이스 혹은 테스트에서 종료 후 세션 정리
    public function raceEnd(Request $request)
    {
        // 선생정보 가져오기기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        if ($userData['roomPin']) {
            // 시험정보 가져오기
            $raceData = DB::table('races as r')
                ->select(
                    'l.name as listName',
                    'r.passingMark as passingMark',
                    'l.number as listId',
                    'r.type as type',
                    DB::raw('count(lq.quizNumber) as quizCount')
                )
                ->where([
                    'r.number' => $userData['raceId']
                ])
                ->join('lists as l', 'l.number', '=', 'r.listNumber')
                ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
                ->groupBy('r.number')
                ->first();

            // 최종 성적 정보 가져오기
            $students = DB::table('records as re')
                ->select(
                    's.number           as sessionId',
                    's.nick             as nick',
                    's.characterNumber  as characterId',
                    's.userNumber       as userId',
                    DB::raw('COUNT(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightCount')
                )
                ->where([
                    're.raceNo' => $userData['raceId'],
                    're.retest' => 0
                ])
                ->join('sessionDatas as s', 's.userNumber', '=', 're.userNo')
                ->orderBy('rightCount', 's.userNumber')
                ->groupBy('s.userNumber')
                ->get();

//            // 미제출 문제 처리하기
//            foreach ($students as $student) {
//                $this->omission($student->userId, $userData['raceId'], 0);
//            }

            // 재시험 여부 확인하기
            $retestTargets = array();
            $wrongTargets = array();
            if ($raceData) {
                foreach ($students as $student) {
                    if ($raceData->passingMark > (($student->rightCount / $raceData->quizCount) * 100)) {
                        array_push($retestTargets, $student->userId);
                    }
                    if ($student->rightCount < $raceData->quizCount) {
                        array_push($wrongTargets, $student->userId);
                    }
                }
                // 재시험 상태 등록
                DB::table('raceUsers')
                    ->where('raceNumber', '=', $userData['raceId'])
                    ->whereIn('userNumber', $retestTargets)
                    ->update([
                        'retestState' => 'order'
                    ]);
                // 오답노트 상태 등록
                DB::table('raceUsers')
                    ->where('raceNumber', '=', $userData['raceId'])
                    ->whereIn('userNumber', $wrongTargets)
                    ->update([
                        'wrongState' => 'order'
                    ]);

                // 세션 초기화
                DB::table('sessionDatas')
                    ->where([
                        'PIN' => $userData['roomPin']
                    ])
                    ->update([
                        'nick' => null,
                        'PIN' => null,
                        'characterNumber' => null,
                        'raceNumber' => null
                    ]);

                // 반납값 정리
                $studentData = array();
                foreach ($students as $student) {
                    array_push($studentData, array(
                        'sessionId' => $student->sessionId,
                        'nick' => $student->nick,
                        'characterId' => $student->characterId,
                        'rightCount' => $student->rightCount,
                        'retestState' => in_array($student->userId, $retestTargets),
                        'wrongState' => in_array($student->userId, $wrongTargets)
                    ));
                }
                $returnValue = array(
                    'students' => $studentData,
                    'check' => true
                );
            } else {
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

    // 재시험 대상 레이스 목록 가져오기 웹 용
    public function getRetestListWeb(Request $request){
        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        if ($userData['check']) {
            $returnValue = array(
                'lists' => $this->selectRetestList($userData['userId']),
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 재시험 대상 레이스 목록 가져오기 어플 용
    public function getRetestListMobile(Request $request){
        $postData = array(
            'sessionId' => $request->input('sessionId')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        if ($userData['check']) {
            $returnValue = array(
                'lists' => $this->selectRetestList($userData['userId']),
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 재시험 준비 웹 전용
    public function retestSet(Request $request){
//        $postData = array(
//            'raceId' => 1
//        );
        $postData = array(
            'raceId' => $request->input('raceId')
        );

        // 유저정보 받아오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 학생일 경우에는 참가했던 레이스만 입장가능
        // 선생일 경우에는 출제된 레이스에 참가가능
        if ($userData['check']){
            switch ($userData['classification']){
                case 'student':
                    $raceCheck = DB::table('raceUsers as ru')
                        ->select(
                            'ru.retestState as retestState'
                        )
                        ->where([
                            'ru.userNumber' => $userData['userId'],
                            'ru.raceNumber' => $postData['raceId']
                        ])
                        ->first();

                    // 반납할 값 정리
                    if ($raceCheck && ($raceCheck->retestState == 'order')) {
                        $returnValue = array(
                            'sessionId' => $request->session()->get('sessionId'),
                            'raceId' => $postData['raceId'],
                            'check' => true
                        );
                    } else if ($raceCheck){ // 대상자가 아닐경우
                        $returnValue = array(
                            'retestState' => $raceCheck->retestState,
                            'check' => false
                        );
                    } else { // 레이스가 존재하지 않을 경우
                        $returnValue = array(
                            'check' => false
                        );
                    }
                    break;
//                case 'teacher':
//                case 'root':
                default:
                    $returnValue = array(
                        'check' => false
                    );
                    break;
            }
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return view('Race/race_retest')->with('response', $returnValue);
    }

    // 재시험 문제 받아오기 모바일은 바로 시작 가능
    public function retestStart(Request $request){
        $postData = array(
            'sessionId' => $request->input('sessionId'),
            'raceId'    => $request->input('raceId')
        );

        // 유저 정보 받아오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        $raceCheck = DB::table('raceUsers as ru')
            ->select(
                'ru.retestState as retestState',
                'l.number as listId',
                'l.name as listName',
                'u.name as userName',
                'g.name as groupName',
                DB::raw('count(lq.quizNumber) as quizCount'),
                'r.passingMark as passingMark'
            )
            ->where([
                'ru.userNumber' => $userData['userId'],
                'ru.raceNumber' => $postData['raceId']
            ])
            ->join('races as r', 'r.number', '=', 'ru.raceNumber')
            ->join('groups as g', 'g.number', '=', 'r.groupNumber')
            ->join('lists as l', 'l.number', '=', 'r.listNumber')
            ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
            ->join('users as u', 'u.number', '=', 'ru.userNumber')
            ->groupBy(['ru.userNumber', 'ru.raceNumber'])
            ->first();

        if($raceCheck){
            DB::table('sessionDatas')
                ->where([
                    'number' => $postData['sessionId']
                ])
                ->update([
                    'raceNumber' => $postData['raceId']
                ]);

            $retrunValue = array(
                'userName' => $raceCheck->userName,
                'listName' => $raceCheck->listName,
                'groupName' => $raceCheck->groupName,
                'quizCount' => $raceCheck->quizCount,
                'passingMark' => $raceCheck->passingMark,
                'quizs' => $this->quizGet($raceCheck->listId)
            );
        } else {
            $retrunValue = array(
                'check' => false
            );
        }

        return $retrunValue;
    }

    // 재시험 정답 입력
    public function retestAnswerIn(Request $request){
        // 학생의 세션 아이디 필요
//        $postData     = array(
//            'sessionId' => 2,
//            'quizId'    => 1,
//            'answer'    => 1
//        );
        $postData     = array(
            'sessionId' => $request->input('sessionId'),
            'quizId'    => $request->input('quizId'),
            'answer'    => $request->input('answer')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 레이스 정보 가져오기
        $raceData = DB::table('races as r')
            ->select(
                'r.number as raceId',
                'r.listNumber as listId'
            )
            ->where([
                'r.number' => $userData['raceId']
            ])
            ->join('sessionDatas as s', 's.raceNumber', '=', 'r.number')
            ->first();

        // 레이스가 존재할 경우 값을 입력
        if($raceData){
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

            switch ($quizData->type){
                case 'vocabulary obj':
                case 'word obj':
                case 'grammar obj':
                case 'vocabulary sub':
                case 'word sub':
                case 'grammar sub':
                    $rights = explode(',', $quizData->right);
                    $answerCheck = 'X';
                    foreach ($rights as $right){
                        if ($postData['answer'] == $right){
                            $answerCheck = 'O';
                            break;
                        }
                    }
                    break;
                default:
                    $answerCheck = 'X';
            }

            // 정답을 입력
            $quizInsert = DB::table('records')
                ->insert([
                    'raceNo'        => $raceData->raceId,
                    'userNo'        => $userData['userId'],
                    'listNo'        => $raceData->listId,
                    'quizNo'        => $postData['quizId'],
                    'answerCheck'   => $answerCheck,
                    'answer'        => $postData['answer'],
                    'retest'        => 1
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

    // 재시험에서 종료 후 세션 정리
    public function retestEnd(Request $request){
        $postData = array(
            'sessionId' => $request->input('sessionId')
        );

        // 유저정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        if ($userData['raceId']) {
            // 시험정보 가져오기
            $raceData = DB::table('races as r')
                ->select(
                    'l.name as listName',
                    'r.passingMark as passingMark',
                    'l.number as listId',
                    DB::raw('count(lq.quizNumber) as quizCount')
                )
                ->where([
                    'r.number' => $userData['raceId']
                ])
                ->join('lists as l', 'l.number', '=', 'r.listNumber')
                ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
                ->groupBy('r.number')
                ->first();

            if ($raceData) {
                // 최종 성적 정보 가져오기
                $records = DB::table('records as re')
                    ->select(
                        DB::raw('COUNT(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightCount')
                    )
                    ->where([
                        're.raceNo' => $userData['raceId'],
                        're.userNo' => $userData['userId'],
                        're.retest' => 1
                    ])
                    ->groupBy(['re.userNo', 're.raceNo'])
                    ->first();

                // 학생 점수
                $score = (int)(($records->rightCount / $raceData->quizCount) * 100);

                // 합격여부 확인하기
                // 합격
                if ($raceData->passingMark <= $score) {
                    // 미제출 문제 처리하기
                    $this->omission($userData['userId'], $userData['raceId'], 0);

                    // 통과 표시하기
                    DB::table('raceUsers')
                        ->where([
                            'raceNumber' => $userData['raceId'],
                            'userNumber' => $userData['userId']
                        ])
                        ->update([
                            'retestState' => 'clear'
                        ]);
                }
                // 불합격
                else {
                    // 시험친 기록 삭제
                    DB::table('records')
                        ->where([
                            'raceNo' => $userData['raceId'],
                            'userNo' => $userData['userId'],
                            'retest' => 1
                        ])
                        ->delete();
                }

                // 반납값 정리
                $returnValue = array(
                    'score' => $score,
                    'passingMark' => $raceData->passingMark,
                    'check' => true
                );
            } else {
                // 반납값 정리
                $returnValue = array(
                    'check' => false
                );
            }
        } else {
            // 반납값 정리
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 해당 리스트에서 모든 문제를 가져오는 구문
    private function quizGet($listId){

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
                'lq.listNumber' => $listId
            ])
            ->join('listQuizs as lq', 'lq.quizNumber', '=', 'qb.number')
            ->orderBy('qb.number', 'desc')
            ->get();

        // 다음 문제가 있을 때
        if($quizData) {

            // 반납값 정리
            $quizs = array();
            foreach ($quizData as $quiz) {
                $type = explode(' ', $quiz->type);
                array_push($quizs, array(
                    'quizId'    => $quiz->number,
                    'question'  => $quiz->question,
                    'hint'      => $quiz->hint,
                    'right'     => $quiz->rightAnswer,
                    'example1'  => $quiz->example1,
                    'example2'  => $quiz->example2,
                    'example3'  => $quiz->example3,
                    'quizType'  => $type[0],
                    'makeType'  => $type[1]
                ));
            }
            $returnValue = array(
                'quiz' => $quizs,
                'check' => true
            );
        } else {
            $returnValue = array('check' => false);
        }

        return $returnValue;
    }

    // 재시험 대상 레이스 목록을 검색
    private function selectRetestList($userId){
        $retestData = DB::table('raceUsers as ru')
            ->select(
                'ru.raceNumber as raceId',
                'l.name as listName',
                DB::raw('count(lq.quizNumber) as quizCount'),
                'r.passingMark as passingMark',
                DB::raw('COUNT(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightCount')
            )
            ->where([
                'ru.userNumber' => $userId,
                'ru.retestState' => 'order'
            ])
            ->join('races as r', 'r.number', '=', 'ru.raceNumber')
            ->join('lists as l', 'l.number', '=', 'r.listNumber')
            ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
            ->join('records as re', function ($join){
                $join->on('re.raceNo', '=', 'ru.raceNumber');
                $join->on('re.userNo', '=', 'ru.userNumber');
            })
            ->groupBy(['ru.raceNumber', 'ru.userNumber'])
            ->orderBy('ru.raceNumber')
            ->get();

        // 레이스번호, 리스트이름, 문항수, 통과점수, 이전점수
        $retests = array();
        foreach ($retestData as $retestRace){
            array_push($retests, array(
                'raceId' => $retestRace->raceId,
                'listName' => $retestRace->listName,
                'quizCount' => $retestRace->quizCount,
                'passingMark' => $retestRace->passingMark,
                'rightCount' => (int)($retestRace->rightCount / $retestRace->quizCount * 100)
            ));
        }

        return $retests;
    }

    // 재시험 혹은 테스트에서 미제출 문제 처리
    private function omission($userId, $raceId, $type)
    {
        $raceData = DB::table('races')
            ->select(
                'listNumber as listId'
            )
            ->where([
                'number' => $raceId
            ])
            ->first();

        $quizs = DB::table('listQuizs as lq')
            ->select(
                'lq.quizNumber as quizId',
                DB::raw('COUNT(CASE WHEN re.userNo = ' . $userId . ' THEN 1 END) as omissionCheck')
            )
            ->where([
                're.raceNo' => $raceId,
                're.retest' => $type
            ])
            ->leftJoin('records as re', function ($join) {
                $join->on('re.quizNo', '=', 'lq.quizNumber');
                $join->on('re.listNo', '=', 'lq.listNumber');
            })
            ->groupBy('lq.quizNumber')
            ->get();

        $insert = array();
        foreach ($quizs as $quiz) {
            if ($quiz->omissionCheck == 0) {
                array_push($insert, array(
                    'userNo' => $userId,
                    'raceNo' => $raceId,
                    'listNo' => $raceData->listId,
                    'quizNo' => $quiz->quizId,
                    'retest' => $type,
                    'answer' => '',
                    'answerCheck' => 'X'
                ));
            }
        }

        if (count($insert) > 0) {
            DB::table('records')
                ->insert($insert);
        }
    }
}