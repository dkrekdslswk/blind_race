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
            'groupId'   => $request->input('groupId')
        );

        // 유저정보가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 권한확인
        if ($userData['check']){
            $where = array();
            switch ($userData['classification']){
                case 'teacher':
                    $where = array('teacherId' => $userData['userId']);
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
                        $raceData = DB::table()
                            ->select()
                            ->where()
                            ->get();
                    }

//                case 'student':
                default:
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
        return $returnValue;
    }

    // 모든 레이스 정보 가져오기
    // 재시험 상태(실시, 미실시 전채 인원 포함) 및 오답노트 상태

    // 오답노트 재출 명령하기기

    // 기간내의 정보 읽어오기
    private function selectGroupRecords($groupId, $startDate, $endDate){
        $recordDatas = DB::table('races as r')
            ->select(
                'r.number                               as raceId',
                DB::raw('year(r.created_at)             as year'),
                DB::raw('month(r.created_at)            as month'),
                DB::raw('dayofmonth(r.created_at)       as day'),
                DB::raw('count(distinct ru.userNumber)  as userCount')
            )
            ->where([
                ['re.retest' => 0]
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
    }

    // 한 개의 레이스 정보 읽어오기
    private function selectOneRaceRecords(){}

    // 각 학생별 성적을 읽어오기
    private function selectStudensRecords(){}

    // 한 명의 레이스 성적 읽어오기
    private function selectOneStudentRecords(){}
}

?>