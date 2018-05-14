<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

class RecordBoxController extends Controller{
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
                            ->groupBy('r.number')
                            ->orderBy('r.created_at', 'desc')
                            ->get();

                        // 레이스 정보 정리
                        $races = array();
                        foreach ($raceData as $race){
                            array_push($races, array(
                                'raceId' => $race->raceId,
                                'listName' => $race->listName,
                                'date' => $race->year . '년 ' . $race->month . '월 ' . $race->day . '일',
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
                    $studentData = DB::table('users as u')
                        ->select(
                            'ru.userNumber as userId',
                            'u.name as userName',
                            'ru.retestState as retestState',
                            'ru.wrongState as wrongState'
                        )
                        ->where('ru.raceNumber', '=', $postData['raceId'])
                        ->join('raceUsers as ru', 'ru.userNumber', '=', 'u.number')
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

    // 학생들의 최근기록 조회 'userId'
    // 레이스를 친 학생들 정보 조회 'raceId'
    public function getStudents(Request $request){
        // 요구하는 값
//        $postData = array(
//            'userId'    => 1300000
//            'raceId'    => 1
//        );
        // 요구하는 값
        $postData = array(
            'userId'    => $request->has('userId') ? $request->input('userId') : false,
            'raceId'    => $request->has('raceId') ? $request->input('raceId') : false
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));
        if ($userData['check']) {

            // 조회 구분
            if($postData['userId']){
                $typeWhere = array('ru.userNumber' => $postData['userId']);
            } else if ($postData['raceId']){
                $typeWhere = array('ru.raceNumber' => $postData['raceId']);
            } else {
                $typeWhere = array(1=>2);
            }

            // 그룹권한 확인
            $where = array();
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
                            'ru.wrongState as wrongState'
                        )
                        ->where(['re.retest' => 0])
                        ->where($typeWhere)
                        ->where($where)
                        ->join('races as r', 'r.number', '=', 'ru.raceNumber')
                        ->join('lists as l', 'l.number', '=', 'r.listNumber')
                        ->join('users as u', 'u.number', '=', 'ru.userNumber')
                        ->join('records as re', function ($join){
                            $join->on('re.raceNo', '=', 'ru.raceNumber');
                            $join->on('re.userNo', '=', 'ru.userNumber');
                        })
                        ->join('quizBanks as qb', 'qb.number', '=', 're.quizNo')
                        ->groupBy(['ru.userNumber', 'ru.raceNumber'])
                        ->orderBy('ru.raceNumber', 'desc')
                        ->get();

                        // 반납할 정보 정리
                        $races = array();
                        foreach ($raceData as $race){
                            array_push($races, array(
                                'raceId' => $race->raceId,
                                'listName' => $race->listName,
                                'userId' => $race->userId,
                                'userName' => $race->userName,
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
                                'wrongState' => $race->wrongState
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

        return $returnValue;
    }

    // 기간내의 차트 읽어오기
    private function selectGroupRecords($groupId, $startDate, $endDate){
        $recordDatas = DB::table('races as r')
            ->select(
                'l.name as listName',
                'r.number as raceId',
                DB::raw('year(r.created_at) as year'),
                DB::raw('month(r.created_at) as month'),
                DB::raw('dayofmonth(r.created_at) as day'),
                DB::raw('count(distinct ru.userNumber) as userCount'),
                DB::raw('count(distinct re.quizNo) as quizCount'),
                DB::raw('count(CASE WHEN re.answerCheck = "O" THEN 1 END) as rightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "vocabulary%" THEN 1 END) as vocabularyCount'),
                DB::raw('count(CASE WHEN q.type like "vocabulary%" AND re.answerCheck = "O"  THEN 1 END) as vocabularyRightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "word%" THEN 1 END) as wordCount'),
                DB::raw('count(CASE WHEN q.type like "word%" AND re.answerCheck = "O"  THEN 1 END) as wordRightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "grammar%" THEN 1 END) as grammarCount'),
                DB::raw('count(CASE WHEN q.type like "grammar%" AND re.answerCheck = "O"  THEN 1 END) as grammarRightAnswerCount')
            )
            ->where([
                're.retest' => 0,
                'r.groupNumber' => $groupId
            ])
            ->where(DB::raw('date(r.created_at) >= date('.$startDate.')'))
            ->where(DB::raw('date(r.created_at) <= date('.$endDate.')'))
            ->join('lists as l', 'l.number', '=', 'r.listNumber')
            ->join('raceUsers as ru', 'ru.raceNumber', '=', 'r.number')
            ->join('records as re', function ($join){
                $join->on('re.raceNo', '=', 'ru.raceNumber');
                $join->on('re.userNo', '=', 'ru.userNumber');
            })
            ->join('quizBanks as q', 'q.number', '=', 're.quizNo')
            ->groupBy('r.number')
            ->orderBy('r.number')
            ->get();

        // 반납할 값 정리
        $records = array();
        foreach ($recordDatas as $record){
            array_push($records, array(
                'listName'                      => $record->listName,
                'raceId'                        => $record->raceId,
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