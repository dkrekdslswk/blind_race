<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

class RecordBoxController extends Controller{
    const RETEST_NOT_STATE  = 0;
    const RETEST_STATE      = 1;

    // 차트정보 가져오기
    public function getChart(Request $request){
        // 현재 시간가져오기 기본값 가져오기
        $time = time();
        $endDate = date('Y-m-d', $time);
        $startDate = date('Y-m-d', $time - 7 * 24 * 60 * 60);

        // 요구하는 값
//        $postData = array(
//            'groupId'   => 1,
//            'startDate' => '2018-05-01',
//            'endDate'   => '2018-05-10'
//        );
        $postData = array(
            'groupId'   => $request->input('groupId'),
            'startDate' => $request->has('startDate') ? $request->input('startDate') : $startDate,
            'endDate'   => $request->has('endDate') ? $request->input('endDate') : $endDate
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));
        if ($userData['check']){

            // 그룹권한 확인
            $where = array();
            switch ($userData['classification']){
                case 'teacher':
                    $where = array('teacherNumber' => $userData['userId']);
                case 'root':
                    $groupData = DB::table('groups')
                        ->select(
                            'number as groupId',
                            'name   as groupName'
                        )
                        ->where([
                            'number' => $postData['groupId']
                        ])
                        ->where($where)
                        ->first();

                    if($groupData){
                        $races = $this->selectGroupRecords($groupData->groupId, $postData['startDate'], $postData['endDate']);

                        // 반납하는값
                        $returnValue = array(
                            'group' => array(
                                'id'    => $groupData->groupId,
                                'name'  => $groupData->groupName
                            ),
                            'races'     => $races,
                            'startDate' => $postData['startDate'],
                            'endDate'   => $postData['endDate'],
                            'check'     => true
                        );
                    } else {
                        $returnValue = array(
                            'check' => false
                        );
                    }
                    break;
//                case 'student':
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

        return $returnValue;
    }

    // 최근출제된 레이스 목록 받아오기
    public function getRaces(Request $request){
        // 요구하는 값
//        $postData = array(
//            'groupId'   => 1
//        );
        $postData = array(
            'groupId'   => $request->input('groupId')
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));
        if ($userData['check']) {

            // 그룹권한 확인
            $where = array();
            switch ($userData['classification']) {
                case 'teacher':
                    $where = array('teacherNumber' => $userData['userId']);
                case 'root':
                    $groupData = DB::table('groups')
                        ->select(
                            'number as groupId'
                        )
                        ->where([
                            'number' => $postData['groupId']
                        ])
                        ->where($where)
                        ->first();

                    if($groupData){
                        // 레이스 정보 읽어오기
                        $raceData = DB::table('races as r')
                            ->select(
                                'r.number as raceId',
                                'l.name as listName',
                                'u.name as teacherName',
                                'r.created_at as date',
                                DB::raw('year(r.created_at) as year'),
                                DB::raw('month(r.created_at) as month'),
                                DB::raw('dayofmonth(r.created_at) as day'),
                                DB::raw('count(distinct ru.userNumber) as studentCount'),
                                DB::raw('count(CASE WHEN ru.retestState = "order" THEN 1 END) as retestOrderCount'),
                                DB::raw('count(CASE WHEN ru.retestState = "clear" THEN 1 END) as retestClearCount'),
                                DB::raw('count(CASE WHEN ru.wrongState = "order" THEN 1 END) as wrongOrderCount'),
                                DB::raw('count(CASE WHEN ru.wrongState = "clear" THEN 1 END) as wrongClearCount')
                            )
                            ->where('r.groupNumber', '=', $groupData->groupId)
                            ->join('raceUsers as ru', 'ru.raceNumber', '=', 'r.number')
                            ->join('lists as l', 'l.number', '=', 'r.listNumber')
                            ->join('folders as f', 'f.number', '=', 'l.folderNumber')
                            ->join('users as u', 'u.number', '=', 'f.teacherNumber')
                            ->groupBy('r.number')
                            ->orderBy('r.created_at', 'desc')
                            ->get();

                        // 레이스 정보 정리
                        $races = array();
                        foreach ($raceData as $race){
                            array_push($races, array(
                                'raceId' => $race->raceId,
                                'listName' => $race->listName,
                                'teacherName' => $race->teacherName,
                                'date' => $race->date,
                                'year' => $race->year,
                                'month' => $race->month,
                                'day' => $race->day,
                                'studentCount' => $race->studentCount,
                                'retestClearCount' => $race->retestClearCount,
                                'retestCount' => $race->retestOrderCount + $race->retestClearCount,
                                'wrongClearCount' => $race->wrongClearCount,
                                'wrongCount' => $race->wrongOrderCount + $race->wrongClearCount
                            ));
                        }
                        
                        // 반납하는값
                        $returnValue = array(
                            'races'  => $races,
                            'check' => true
                        );
                    } else {
                        $returnValue = array(
                            'check' => false
                        );
                    }

                    break;
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

        return $returnValue;
    }

    // 과제 미출제 학생 조회
    public function homeworkCheck(Request $request){
        // 요구하는 값
//        $postData = array(
//            'raceId'    => 1
//        );
        // 요구하는 값
        $postData = array(
            'raceId'    => $request->input('raceId')
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));
        if ($userData['check'] && $postData['raceId']) {

            // 그룹권한 확인
            $where = array();
            switch ($userData['classification']) {
                case 'teacher':
                case 'root':

                    // 레이스 정보 읽어오기
                    $studentData = DB::table('raceUsers as ru')
                        ->select(
                            'ru.userNumber as userId',
                            'u.name as userName',
                            'ru.retestState as retestState',
                            'ru.wrongState as wrongState'
                        )
                        ->where('ru.raceNumber', '=', $postData['raceId'])
                        ->join('users as u', 'u.number', '=', 'ru.userNumber')
                        ->groupBy(['ru.userNumber', 'ru.raceNumber'])
                        ->orderBy('ru.userNumber', 'desc')
                        ->get();

                    // 레이스 정보 정리
                    $students = array();
                    foreach ($studentData as $student) {
                        array_push($students, array(
                            'userId' => $student->userId,
                            'userName' => $student->userName,
                            'retestState' => $student->retestState,
                            'wrongState' => $student->wrongState
                        ));
                    }

                    // 반납하는값
                    $returnValue = array(
                        'students'  => $students,
                        'check' => true
                    );
                    break;
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

        return $returnValue;
    }

    // 학생의 최근기록 조회 'userId'
    // + 학생 본인일 경우 자기 성적 조회 + 'groupId
    // 레이스를 친 학생들 정보 조회 'raceId'
    // 재시험 한 결과를 조회하기 위해서 사용 'userId', 'raceId', 'retestState' => 1
    // + 학생 본인일 경우 자기 성적 조회
    public function getStudents(Request $request){
        // 요구하는 값
//        $postData = array(
//            'userId'        => 1300000
//            'raceId'        => 1
//            'retestState'   => 1
//        );
        // 요구하는 값
        $postData = array(
            'userId'        => $request->has('userId') ? $request->input('userId') : false,
            'raceId'        => $request->has('raceId') ? $request->input('raceId') : false,
            'groupId'       => $request->has('groupId') ? $request->input('groupId') : false,
            'retestState'   => $request->has('retestState') ? $request->input('retestState') : self::RETEST_NOT_STATE,
            'sessionId'     => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 모바일용, 세션 아이디 값을 보낼 경우 세션의 유저아이디 값을 사용
        if ($userData['classification'] == 'student'){
            $postData['userId'] = $userData['userId'];
        }

        if ($userData['check']) {
            // 조회 구분
            if($postData['userId'] && $postData['raceId']){
                $typeWhere = array(
                    'ru.userNumber' => $postData['userId'],
                    'ru.raceNumber' => $postData['raceId'],
                    're.retest' => $postData['retestState']
                );
            } else if($postData['userId'] && $postData['groupId']){
                $typeWhere = array(
                    'ru.userNumber' => $postData['userId'],
                    'r.groupNumber' => $postData['groupId'],
                    're.retest' => self::RETEST_NOT_STATE
                );
            } else if($postData['userId']){
                $typeWhere = array(
                    'ru.userNumber' => $postData['userId'],
                    're.retest' => self::RETEST_NOT_STATE
                );
            } else if ($postData['raceId']){
                $typeWhere = array(
                    'ru.raceNumber' => $postData['raceId'],
                    're.retest' => self::RETEST_NOT_STATE
                );
            } else {
                $typeWhere = false;
            }

            // 그룹권한 확인
            $where = array();
            if ($typeWhere) {
                switch ($userData['classification']) {
                    // 학생은 자기것만 볼 수 있음.
                    case 'student':
                    case 'sleepStudent':
                        $where = array('ru.userNumber' => $userData['userId']);
                    // 선생은 모든 학생을 볼 수 있음.
                    case 'teacher':
                    case 'root':
                        // 학생 정보 조회
                        $raceData = DB::table('raceUsers as ru')
                            ->select(
                                'r.number as raceId',
                                'l.name as listName',
                                'ru.userNumber as userId',
                                'u.name as userName',
                                'r.created_at as date',
                                'ut.name as teacherName',
                                DB::raw('year(r.created_at) as year'),
                                DB::raw('month(r.created_at) as month'),
                                DB::raw('dayofmonth(r.created_at) as day'),
                                DB::raw('count(re.quizNo) as allCount'),
                                DB::raw('count(CASE WHEN re.answerCheck = "O" THEN 1 END) as allRightAnswerCount'),
                                DB::raw('count(CASE WHEN qb.type like "vocabulary%" THEN 1 END) as vocabularyCount'),
                                DB::raw('count(CASE WHEN qb.type like "vocabulary%" AND re.answerCheck = "O"  THEN 1 END) as vocabularyRightAnswerCount'),
                                DB::raw('count(CASE WHEN qb.type like "word%" THEN 1 END) as wordCount'),
                                DB::raw('count(CASE WHEN qb.type like "word%" AND re.answerCheck = "O"  THEN 1 END) as wordRightAnswerCount'),
                                DB::raw('count(CASE WHEN qb.type like "grammar%" THEN 1 END) as grammarCount'),
                                DB::raw('count(CASE WHEN qb.type like "grammar%" AND re.answerCheck = "O"  THEN 1 END) as grammarRightAnswerCount'),
                                'ru.retestState as retestState',
                                'ru.wrongState as wrongState',
                                'ru.wrong_at as wrongDate'
                            )
                            ->where($typeWhere)
                            ->where($where)
                            ->join('races as r', 'r.number', '=', 'ru.raceNumber')
                            ->join('lists as l', 'l.number', '=', 'r.listNumber')
                            ->join('users as ut', 'ut.number', '=', 'r.teacherNumber')
                            ->join('users as u', 'u.number', '=', 'ru.userNumber')
                            ->join('records as re', function ($join) {
                                $join->on('re.raceNo', '=', 'ru.raceNumber');
                                $join->on('re.userNo', '=', 'ru.userNumber');
                            })
                            ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
                            ->groupBy(['ru.userNumber', 'ru.raceNumber'])
                            ->orderBy('ru.raceNumber', 'desc')
                            ->get();

                        // 반납할 정보 정리
                        $races = array();
                        foreach ($raceData as $race) {
                            array_push($races, array(
                                'raceId' => $race->raceId,
                                'listName' => $race->listName,
                                'teacherName' => $race->teacherName,
                                'userId' => $race->userId,
                                'userName' => $race->userName,
                                'date' => $race->date,
                                'year' => $race->year,
                                'month' => $race->month,
                                'day' => $race->day,
                                'allCount' => $race->allCount,
                                'allRightCount' => $race->allRightAnswerCount,
                                'vocabularyCount' => $race->vocabularyCount,
                                'vocabularyRightCount' => $race->vocabularyRightAnswerCount,
                                'wordCount' => $race->wordCount,
                                'wordRightCount' => $race->wordRightAnswerCount,
                                'grammarCount' => $race->grammarCount,
                                'grammarRightCount' => $race->grammarRightAnswerCount,
                                'retestState' => $race->retestState,
                                'wrongState' => $race->wrongState,
                                'wrongDate' => $race->wrongDate
                            ));
                        }

                        $returnValue = array(
                            'races' => $races,
                            'check' => true
                        );
                        break;
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
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 학생의 최근기록 조회 'userId', 'sessionId'
    // + 학생 본인일 경우 자기 그룹내 성적 조회 + 'groupId
    // 레이스를 친 학생들 정보 조회 'raceId', 'sessionId'
    // 재시험 한 결과를 조회하기 위해서 사용 'userId', 'raceId', 'retestState' => 1
    public function mobileGetStudents(Request $request){
        return $this->getStudents($request);
    }

    // 오답문제 조회하기 학생별 'userId', 'raceId'
    // 오답문제 조회하기 레이스 전체 'raceId'
    // => 유저가 학생일 경우 오답문제 조회하기 'raceId'
    // + 재시험 한 결과를 조회하기 위해서 사용 'retestState' => 1
    public function getWrongs(Request $request){
        // 요구하는 값
//        $postData = array(
//            'userId'    => false,
//            'raceId'    => 1
//            'retestState'   => 1
//        );
        $postData = array(
            'userId'    => $request->has('userId') ? $request->input('userId') : false,
            'raceId'    => $request->has('raceId') ? $request->input('raceId') : false,
            'retestState'   => $request->has('retestState') ? $request->input('retestState') : self::RETEST_NOT_STATE,
            'sessionId'   => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 유저권한 확인
        if ($userData['check'] && $postData['raceId']){
            // 메서드 호출 타입 설정
            if ($userData['classification'] == 'student'){
                $typeWhere = array(
                    're.userNo' => $userData['userId'],
                    're.raceNo' => $postData['raceId'],
                    're.retest' => $postData['retestState']
                );
                $typeGroupBy = array('re.raceNo', 're.userNo', 're.quizNo', 're.retest');
            }
            else if ($postData['userId']){
                $typeWhere = array(
                    're.userNo' => $postData['userId'],
                    're.raceNo' => $postData['raceId'],
                    're.retest' => $postData['retestState']
                );
                $typeGroupBy = array('re.raceNo', 're.userNo', 're.quizNo', 're.retest');
            } else {
                $typeWhere = array(
                    're.raceNo' => $postData['raceId'],
                    're.retest' => $postData['retestState']
                );
                $typeGroupBy = array('re.raceNo', 're.quizNo', 're.retest');
            }

            switch ($userData['classification']){
                case 'student':
                case 'sleepStudent':
                    // 반납값 정리1
                    if ($postData['userId'] == $userData['userId']){
                        $returnValue = array(
                            'check' => false
                        );
                        break;
                    }
                case 'teacher':
                case 'root':
                    // 문제 리스트 뽑아오기
                    $raceQuizs = DB::table('records as re')
                        ->select(
                            'qb.number as quizId',
                            'qb.question as question',
                            'qb.hint as hint',
                            'qb.rightAnswer as rightAnswer',
                            'qb.example1 as example1',
                            'qb.example2 as example2',
                            'qb.example3 as example3',
                            'qb.type as type',
                            DB::raw('count(distinct re.userNo) as userCount'),
                            DB::raw('count(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightAnswerCount')
                        )
                        ->where($typeWhere)
                        ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
                        ->groupBy($typeGroupBy)
                        ->orderBy('re.quizNo')
                        ->get();

                    // 문제 확인
                    $wrongs = array();
                    for ($i = 0 ; $i < count($raceQuizs) ; $i++) {
                        // 오답노트 불러오기용 변수
                        $wrongText = false;

                        // 오답 확인
                        if ($raceQuizs[$i]->userCount > $raceQuizs[$i]->rightAnswerCount) {
                            if (preg_match('/^(.)+ obj$/', $raceQuizs[0]->type)) {
                                // 객관식 처리
                                $quizData = DB::table('records as re')
                                    ->select(
                                        DB::raw('count(CASE WHEN re.answer = qb.rightAnswer THEN 1 END) as rightAnswerCount'),
                                        DB::raw('count(CASE WHEN re.answer = qb.example1 THEN 1 END) as example1Count'),
                                        DB::raw('count(CASE WHEN re.answer = qb.example2 THEN 1 END) as example2Count'),
                                        DB::raw('count(CASE WHEN re.answer = qb.example3 THEN 1 END) as example3Count')
                                    )
                                    ->where($typeWhere)
                                    ->where(['qb.number' => $raceQuizs[$i]->quizId])
                                    ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
                                    ->groupBy($typeGroupBy)
                                    ->first();

                                // 학생 조회일 경우 오답노트도 출력
                                if ($postData['userId']){
                                    $wrongText = DB::table('records as re')
                                        ->select(
                                            're.wrongAnswerNote as wrongAnswerNote'
                                        )
                                        ->where([
                                            're.quizNo' => $raceQuizs[$i]->quizId
                                        ])
                                        ->where($typeWhere)
                                        ->first();
                                }

                                array_push($wrongs, array(
                                    'number' => $i + 1,
                                    'id' => $raceQuizs[$i]->quizId,
                                    'question' => $raceQuizs[$i]->question,
                                    'hint' => $raceQuizs[$i]->hint,
                                    'rightAnswer' => $raceQuizs[$i]->rightAnswer,
                                    'rightAnswerCount' => $quizData->rightAnswerCount,
                                    'example1' => $raceQuizs[$i]->example1,
                                    'example1Count' => $quizData->example1Count,
                                    'example2' => $raceQuizs[$i]->example2,
                                    'example2Count' => $quizData->example2Count,
                                    'example3' => $raceQuizs[$i]->example3,
                                    'example3Count' => $quizData->example3Count,
                                    'wrongCount' => $raceQuizs[$i]->userCount - $quizData->rightAnswerCount,
                                    'userCount' => $raceQuizs[$i]->userCount,
                                    'wrong' => $wrongText ? $wrongText->wrongAnswerNote : false
                                ));
                            } else if (preg_match('/^(.)+ sub$/', $raceQuizs[0]->type)) {
                                // 주관식 처리
                                $quizData = DB::table('records as re')
                                    ->select(
                                        're.answer as answer',
                                        'u.number as userId',
                                        'u.name as userName'
                                    )
                                    ->where($typeWhere)
                                    ->where(['qb.number' => $raceQuizs[$i]->quizId])
                                    ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
                                    ->join('users as u', 'u.number', '=', 're.userNo')
                                    ->get();

                                $wrongData = array();
                                $rights = explode(',', $raceQuizs[$i]->rightAnswer);
                                foreach ($quizData as $quiz) {
                                    foreach ($rights as $right){
                                        if ($quiz->answer == $right){
                                            array_push($wrongData, array(
                                                'userId' => $quiz->userId,
                                                'userName' => $quiz->userName,
                                                'answer' => $quiz->answer
                                            ));
                                            break;
                                        }
                                    }
                                }

                                // 학생 조회일 경우 오답노트도 출력
                                if ($postData['userId']){
                                    $wrongText = DB::table()
                                        ->select(
                                            'wrongAnswerNote'
                                        )
                                        ->where([
                                            'quizNumber' => $raceQuizs[$i]->quizId
                                        ])
                                        ->where($typeWhere)
                                        ->first();
                                }


                                if (count($wrongData) > 0) {
                                    array_push($wrongs, array(
                                        'number' => $i + 1,
                                        'id' => $raceQuizs[$i]->quizId,
                                        'question' => $raceQuizs[$i]->question,
                                        'hint' => $raceQuizs[$i]->hint,
                                        'rightAnswer' => $raceQuizs[$i]->rightAnswer,
                                        'rightAnswerCount' => $raceQuizs[$i]->userCount - count($wrongData),
                                        'wrongs' => $wrongData,
                                        'wrongCount' => count($wrongData),
                                        'userCount' => $raceQuizs[$i]->userCount,
                                        'wrong' => $wrongText ? $wrongText->quizNumber : false
                                    ));
                                }
                            }
                        }
                    }

                    // 반납값 정리2
                    $returnValue = array(
                        'raceId' => $postData['raceId'],
                        'wrongs' => $wrongs,
                        'check' => true
                    );
                    break;
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

        return $returnValue;
    }

    // 오답문제 조회하기 학생별 'userId', 'raceId', 'sessionId'
    // 오답문제 조회하기 레이스 전체 'raceId', 'sessionId'
    // => 유저가 학생일 경우 오답문제 조회하기 'raceId'
    // + 재시험 한 결과를 조회하기 위해서 사용 'retestState' => 1
    // 모바일 버전 오답문제 조회하기
    public function mobileGetWrongs(Request $request){
        return $this->getWrongs($request);
    }

    // 오답풀이 입력하기
    public function insertWrongs(Request $request){
//        $postData = array(
//            'raceId' => 1,
//            'wrongs' => array(
//                0 => array(
//                    'quizId' => 1,
//                    'text' => '이렇게 쉬운걸 왜 틀린걸까요?'
//                )
//            )
//        );
        $postData = array(
            'raceId' => $request->input('raceId'),
            'wrongs' => $request->input('wrongs'),
            'sessionId'   => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 로그인 확인
        if ($userData['check']){
            // 오답풀이 대상자인지 확인
            $recordData1 = DB::table('raceUsers as ru')
                ->select(
                    DB::raw('count(CASE WHEN re.answerCheck = "X" THEN 1 END) as wrongAnswerCount')
                )
                ->where([
                    'ru.userNumber' => $userData['userId'],
                    'ru.raceNumber' => $postData['raceId'],
                    'ru.wrongState' => 'order',
                    're.retest' => self::RETEST_NOT_STATE
                ])
                ->join('records as re', function ($join){
                    $join->on('re.userNo', '=', 'ru.userNumber');
                    $join->on('re.raceNo', '=', 'ru.raceNumber');
                })
                ->groupBy('ru.userNumber')
                ->first();

            if ($recordData1) {
                // 오답풀이 입력
                foreach ($postData['wrongs'] as $wrong) {
                    if ($wrong['text'] != '') {
                        $update = array(
                            'wrongAnswerNote' => $wrong['text']
                        );
                    } else {
                        $update = array(
                            'wrongAnswerNote' => null
                        );
                    }

                    DB::table('records')
                        ->where([
                            'raceNo' => $postData['raceId'],
                            'quizNo' => $wrong['quizId'],
                            'userNo' => $userData['userId'],
                            'retest' => self::RETEST_NOT_STATE,
                            'answerCheck' => 'X'
                        ])
                        ->update($update);
                }

                // 오답풀이가 전부 입력되었는지 확인
                $recordData2 = DB::table('raceUsers as ru')
                    ->select(
                        DB::raw('count(CASE WHEN re.wrongAnswerNote IS NOT NULL THEN 1 END) as wrongAnswerCount')
                    )
                    ->where([
                        'ru.userNumber' => $userData['userId'],
                        'ru.raceNumber' => $postData['raceId'],
                        'ru.wrongState' => 'order',
                        're.retest' => self::RETEST_NOT_STATE
                    ])
                    ->join('records as re', function ($join){
                        $join->on('re.userNo', '=', 'ru.userNumber');
                        $join->on('re.raceNo', '=', 'ru.raceNumber');
                    })
                    ->groupBy('ru.userNumber')
                    ->first();

                if ($recordData1->wrongAnswerCount == $recordData2->wrongAnswerCount){
                    DB::table('raceUsers')
                        ->where([
                            'ru.userNumber' => $userData['userId'],
                            'ru.raceNumber' => $postData['raceId'],
                            'ru.wrongState' => 'order',
                        ])
                        ->update([
                            'ru.wrongState'  => 'clear',
                            'ru.wrong_at'  => DB::raw('now()')
                        ]);

                    $returnValue = array(
                        'wrongCheck' => true,
                        'check' => true
                    );
                } else {
                    $returnValue = array(
                        'wrongCheck' => false,
                        'check' => true
                    );
                }
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

    // 모바일 버전 오답풀이 입력하기
    public function mobileInsertWrongs(Request $request){
        return $this->insertWrongs($request);
    }

    // 피드백과 질문
    // 질문하기
    public function insertQuestion(Request $request){
        $postData = array(
            'title' => $request->has('title') ? $request->input('title') : false,
            'question' => $request->has('question') ? $request->input('question') : false,
            'teacherId' => $request->has('teacherId') ? $request->input('teacherId') : false,
            'sessionId' => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 로그인 확인
        if ($userData['check'] && $postData['title'] && $postData['question'] && $postData['teacherId']){
            switch ($userData['classification']){
                case 'student':
                    DB::table('QnAs')
                        ->insert([
                            'userNumber' => $userData['userId'],
                            'teacherNumber' => $postData['teacherId'],
                            'title' => $postData['title'],
                            'question' => $postData['question']
                        ]);

                    // 반납값 정리
                    $returnValue = array(
                        'check' => true
                    );
                    break;
                default:

                    // 반납값 정리
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

        return $returnValue;
    }
    // QnAs 가져오기
    public function selectQnAs(Request $request){
        $postData = array(
            'sessionId' => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        if ($userData['check']){
            // 유저 권한별 정리
            switch ($userData['classification']){
                case 'student':
                    $where = array(
                        'QnAs.userNumber' => $userData['userId']
                    );
                    break;
                case 'teacher':
                    $where = array(
                        'QnAs.teacherNumber' => $userData['userId']
                    );
                    break;
                case 'root':
                    $where = array(
                        'QnAs.teacherNumber' => $userData['userId']
                    );
                    break;
                default:
                    $where = array(
                        1 => 2
                    );
                    break;
            }

            // QnA정보 가져오기
            $QnAData = DB::table('QnAs')
                ->select(
                    'QnAs.number as QnAId',
                    'u.name as userName',
                    'tu.name as teacherName',
                    'QnAs.title as title',
                    'QnAs.question_at as question_at',
                    'QnAs.answer_at as answer_at'
                )
                ->where($where)
                ->join('users as u', 'u.number', '=', 'QnAs.userNumber')
                ->join('users as tu', 'tu.number', '=', 'QnAs.teacherNumber')
                ->first();

            // 반납값 정리
            $QnAs = array();
            foreach ($QnAData as $QnA){
                array_push($QnAs, array(
                    'QnAId' => $QnA->QnAId,
                    'userName' => $QnA->userName,
                    'teacherName' => $QnA->teacherName,
                    'title' => $QnA->title,
                    'question_at' => $QnA->question_at,
                    'answer_at' => $QnA->answer_at
                ));
            }

            $returnValue = array(
                'QnAs' => $QnAs,
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }
    // 조회하기
    public function selectQnA(Request $request){
        $postData = array(
            'QnAId' => $request->input('QnAId'),
            'sessionId' => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        if ($userData['check']){
            // 유저 권한별 정리
            switch ($userData['classification']){
                case 'student':
                    $where = array(
                        'QnAs.userNumber' => $userData['userId']
                    );
                    break;
                case 'teacher':
                    $where = array(
                        'QnAs.teacherNumber' => $userData['userId']
                    );
                    break;
                case 'root':
                    $where = array(
                        'QnAs.teacherNumber' => $userData['userId']
                    );
                    break;
                default:
                    $where = array(
                        1 => 2
                    );
                    break;
            }

            // QnA정보 가져오기
            $QnAData = DB::table('QnAs')
                ->select(
                    'QnAs.number as QnAId',
                    'u.name as userName',
                    'tu.name as teacherName',
                    'QnAs.title as title',
                    'QnAs.question as question',
                    'QnAs.answer as answer',
                    'QnAs.question_at as question_at',
                    'QnAs.answer_at as answer_at'
                )
                ->where($where)
                ->join('users as u', 'u.number', '=', 'QnAs.userNumber')
                ->join('users as tu', 'tu.number', '=', 'QnAs.teacherNumber')
                ->where([
                    'QnAs.number' => $postData['QnAId']
                ])
                ->orderBy('number', 'DESC')
                ->get();

            // 반납값 정리
            $returnValue = array(
                'QnA' => array(
                    'QnAId' => $QnAData->QnAId,
                    'userName' => $QnAData->userName,
                    'teacherName' => $QnAData->teacherName,
                    'title' => $QnAData->title,
                    'question' => $QnAData->question,
                    'answer' => $QnAData->answer,
                    'question_at' => $QnAData->question_at,
                    'answer_at' => $QnAData->answer_at
                ),
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }
    // 답변하기
    public function updateAnswer(Request $request){
        $postData = array(
            'QnAId' => $request->has('QnAId') ? $request->input('QnAId') : false,
            'answer' => $request->has('answer') ? $request->input('answer') : false,
            'sessionId' => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        // 유저 정보 가져오기
        $userData = UserController::sessionDataGet($postData['sessionId']);

        // 확인
        if ($userData['check'] && $postData['QnAId'] && $postData['answer']){
            switch ($userData['classification']){
                case 'teacher':
                    $where = array(
                        'teacherNumber' => $userData['userId']
                    );
                    break;
                default:
                    $where = array(
                        1 => 2
                    );
                    break;
            }

            // 업데이트
            DB::table('QnAs')
                ->where($where)
                ->where([
                    'number' => $postData['QnAId']
                ])
                ->update([
                    'answer' => $postData['answer'],
                    'answer_at' => DB::raw('now()')
                ]);

            $returnValue = array(
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => true
            );
        }

        return $returnValue;
    }

    // 모바일용 피드백과 질문
    // 질문하기
    public function mobileInsertQuestion(Request $request){
        return $this->insertQuestion($request);
    }
    // QnAs 가져오기
    public function mobileSelectQnAs(Request $request){
        return $this->selectQnAs($request);
    }
    // 조회하기
    public function mobileSelectQnA(Request $request){
        return $this->selectQnA($request);
    }
    // 답변하기
    public function mobileUpdateAnswer(Request $request){
        return $this->updateAnswer($request);
    }

    // 기간내의 차트 읽어오기
    private function selectGroupRecords($groupId, $startDate, $endDate){
        $recordDatas = DB::table('races as r')
            ->select(
                'l.name as listName',
                'r.number as raceId',
                'r.created_at as date',
                DB::raw('year(r.created_at) as year'),
                DB::raw('month(r.created_at) as month'),
                DB::raw('dayofmonth(r.created_at) as day'),
                DB::raw('count(distinct ru.userNumber) as userCount'),
                DB::raw('count(distinct re.quizNo) as quizCount'),
                DB::raw('count(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightAnswerCount'),
                DB::raw('count(CASE WHEN qb.type like "vocabulary%" THEN 1 END) as vocabularyCount'),
                DB::raw('count(CASE WHEN qb.type like "vocabulary%" AND re.answerCheck = "O"  THEN 1 END) as vocabularyRightAnswerCount'),
                DB::raw('count(CASE WHEN qb.type like "word%" THEN 1 END) as wordCount'),
                DB::raw('count(CASE WHEN qb.type like "word%" AND re.answerCheck = "O"  THEN 1 END) as wordRightAnswerCount'),
                DB::raw('count(CASE WHEN qb.type like "grammar%" THEN 1 END) as grammarCount'),
                DB::raw('count(CASE WHEN qb.type like "grammar%" AND re.answerCheck = "O"  THEN 1 END) as grammarRightAnswerCount')
            )
            ->where([
                're.retest' => self::RETEST_NOT_STATE,
                'r.groupNumber' => $groupId
            ])
            ->where(DB::raw('date(r.created_at)'), '>=', $startDate)
            ->where(DB::raw('date(r.created_at)'), '<=', $endDate)
            ->join('lists as l', 'l.number', '=', 'r.listNumber')
            ->join('raceUsers as ru', 'ru.raceNumber', '=', 'r.number')
            ->join('records as re', function ($join){
                $join->on('re.raceNo', '=', 'ru.raceNumber');
                $join->on('re.userNo', '=', 'ru.userNumber');
            })
            ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
            ->groupBy('r.number')
            ->orderBy('r.number')
            ->get();

        // 반납할 값 정리
        $records = array();
        foreach ($recordDatas as $record){
            array_push($records, array(
                'listName'                      => $record->listName,
                'raceId'                        => $record->raceId,
                'date'                          => $record->date,
                'year'                          => $record->year,
                'month'                         => $record->month,
                'day'                           => $record->day,
                'userCount'                     => $record->userCount,
                'quizCount'                     => $record->quizCount,
                'rightAnswerCount'              => $record->rightAnswerCount            / $record->userCount,
                'vocabularyCount'               => $record->vocabularyCount             / $record->userCount,
                'vocabularyRightAnswerCount'    => $record->vocabularyRightAnswerCount  / $record->userCount,
                'wordCount'                     => $record->wordCount                   / $record->userCount,
                'wordRightAnswerCount'          => $record->wordRightAnswerCount        / $record->userCount,
                'grammarCount'                  => $record->grammarCount                / $record->userCount,
                'grammarRightAnswerCount'       => $record->grammarRightAnswerCount     / $record->userCount
            ));
        }

        return $records;
    }
}

?>