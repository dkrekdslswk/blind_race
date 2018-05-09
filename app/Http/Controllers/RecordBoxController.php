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
    private function selectGroupRecords($groupId, $type, $startDate, $endDate){
        // 그룹 선택

        // 타입별 설정
        // 날자 쿼리 생성

        // 일별
        // 월별


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