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
//        $postData = array(
//            'groupId'   => 1
//        );
        $postData = array(
            'groupId'   => $request->input('groupId')
        );

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
                        // 일주일 조회
                        $time = time();
                        $endDate = date('Y-m-d', $time);
                        $startDate = date('Y-m-d', $time - 7 * 24 * 60 * 60);
                        $races = $this->selectGroupRecords($groupData->groupId, $startDate, $endDate);

                        // 반납하는값
                        $returnValue = array(
                            'group' => array(
                                'id' => $groupData->groupId,
                                'name' => $groupData->groupName
                            ),
                            'races' => $races,
                            'check' => true
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

    // 모든 레이스 정보 가져오기
    // 재시험 상태(실시, 미실시 전채 인원 포함) 및 오답노트 상태

    // 오답노트 재출 명령하기기

    // 기간내의 정보 읽어오기
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

    // 한 개의 레이스 정보 읽어오기
    private function selectOneRaceRecords(){}

    // 각 학생별 성적을 읽어오기
    private function selectStudensRecords(){}

    // 한 명의 레이스 성적 읽어오기
    private function selectOneStudentRecords(){}
}

?>