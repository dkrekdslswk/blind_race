<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

class RecordBoxController extends Controller{
    // 그룹에서 친 모든 레이스 정보 가져오기
    public function getRecordData(Request $request){
        // 요구하는 값
        $postData = array(
            'groupId'   => 1
        );
//        $postData = array(
//            'groupId'   => $request->input('groupId')
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

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 권한확인
        if ($userData['check']){
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
                        $test = $this->selectGroupRecords($groupData->groupId, 'subdate(now(), INTERVAL 7 DAY)', 'now()');
                    }
                    break;
//                case 'student':
                default:
                    $test = false;
                    break;
            }
        }

        // 해당그룹의 레이스 정보 가져오기

        // 반납하는값
        $returnValue = array(
            'group' => array(
                'id',
                'name'
            ),
            'races' => array(
                0 => array(
                    'id',
                    'name',
                    'all',
                    'vocabulary',
                    'word',
                    'grammar',
                    'year',
                    'month',
                    'day'
                )
            ),
            'check'
        );
        return $test;
    }

    // 모든 레이스 정보 가져오기
    // 재시험 상태(실시, 미실시 전채 인원 포함) 및 오답노트 상태

    // 오답노트 재출 명령하기기

    // 기간내의 정보 읽어오기
    private function selectGroupRecords($groupId, $startDate, $endDate){
        $recordDatas = DB::table('races as r')
            ->select(
                'r.number as raceId',
                DB::raw('year(r.created_at) as year'),
                DB::raw('month(r.created_at) as month'),
                DB::raw('dayofmonth(r.created_at) as day'),
                DB::raw('count(distinct ru.userNumber) as userCount'),
                DB::raw('count(distinct re.quizNumber) as quizCount'),
                DB::raw('count(CASE WHEN re.answerCheck = O THEN 1 END) as rightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "vocabulary%" THEN 1 END) as vocabularyCount'),
                DB::raw('count(CASE WHEN q.type like "vocabulary%" AND re.answerCheck = O  THEN 1 END) as vocabularyRightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "word%" THEN 1 END) as wordCount'),
                DB::raw('count(CASE WHEN q.type like "word%" AND re.answerCheck = O  THEN 1 END) as wordRightAnswerCount'),
                DB::raw('count(CASE WHEN q.type like "grammar%" THEN 1 END) as grammarCount'),
                DB::raw('count(CASE WHEN q.type like "grammar%" AND re.answerCheck = O  THEN 1 END) as grammarRightAnswerCount')
            )
            ->where([
                ['re.retest' => 0],
                'r.groupNumber' => $groupId,
                DB::raw('date(r.create_at) >= date('.$startDate.')'),
                DB::raw('date(r.create_at) <= date('.$endDate.')')
            ])
            ->join('raceUsers as ru', 'ru.raceNumber', '=', 'r.number')
            ->join('records as re', function ($join){
                $join->on('re.raceNumber', '=', 'ru.raceNumber');
                $join->on('re.userNumber', '=', 'ru.userNumber');
            })
            ->join('quizBanks as q', 'q.number', '=', 'ru.quizNumber')
            ->groupBy('r.number')
            ->orderBy('r.number')
            ->get();
        // 반납할 값 정리
        return $recordDatas->toArray();
    }

    // 한 개의 레이스 정보 읽어오기
    private function selectOneRaceRecords(){}

    // 각 학생별 성적을 읽어오기
    private function selectStudensRecords(){}

    // 한 명의 레이스 성적 읽어오기
    private function selectOneStudentRecords(){}
}

?>