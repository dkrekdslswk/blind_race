<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class RecordBoxController extends Controller{
    public function totalScoreGet(Request $request){
        //$postData     = array('group' => array('groupId'   => 1),
        //                  'race'  => array('raceMode'  => 'n',
        //                                   'examCount' => 30,
        //                                   'raceId'    => 1));

//        $postData = array('groupId'   => $request->input('groupId'));
        $postData = array('groupId'   => 1);

        // test 임시로 유저 세션 부여
        $userId = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                's.session_num  as session_num'])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userId->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId(['user_num' => $userId->user_num],
                    'session_num');
        }else{
            $_SESSION['sessionId'] = $userId->session_num;
        }
        // test

        $raceDataList = DB::table('race_set_exam as rse')
            ->select([
                'rse.set_exam_num as setExamId',
                'rse.created_at as createDate',
                DB::raw('SUM(CASE WHEN pq.result = "1" THEN 1 ELSE 0 END) as rightCount'),
                DB::raw('COUNT(pq.result) as quizCount')
            ])
            ->where([
                'rse.group_num' => $postData['groupId']
            ])
            ->join('race_results as rr', 'rr.set_exam_num', '=', 'rse.set_exam_num')
            ->join('playing_quizs as pq', function($join)
            {
                $join->on('pq.user_num', '=', 'rr.user_num');
                $join->on('pq.set_exam_num', '=', 'rr.set_exam_num');
            })
            ->groupBy('rse.set_exam_num')
            ->orderBy('rse.created_at')
            ->offset(0)
            ->limit(5)
            ->get();

        $rastRaceData = DB::table('race_results as rr')
            ->select('rr.user_num as userId',
                'u.user_name as userName',
                DB::raw('SUM(CASE WHEN pq.result = "1" THEN 1 ELSE 0 END) as rightCount'),
                DB::raw('COUNT(pq.result) as quizCount'))
            ->where('rr.set_exam_num', '=', $raceDataList[0] -> setExamId)
            ->join('playing_quizs as pq', function($join)
            {
                $join->on('pq.user_num', '=', 'rr.user_num');
                $join->on('pq.set_exam_num', '=', 'rr.set_exam_num');
            })
            ->join('users as u', 'u.user_num', '=', 'rr.user_num')
            ->groupBy('rr.user_num')
            ->orderBy('rightCount', 'DESC')
            ->get();

        $raceData = array();
        foreach ($raceDataList as $data){
            array_push($raceData, array([
                'setExamId' => $data->setExamId,
                'createDate' => $data->createDate,
                'avgScore' => (int)((int)$data->rightCount / (int)$data->quizCount * 100)
            ]));
        }

        $rastData = array();
        foreach ($rastRaceData as $data){
            array_push($rastData, array([
                'userId' => $data->userId,
                'userName' => $data->userName,
                'rightCount' => (int)$data->rightCount,
                'quizCount' => $data->quizCount
            ]));
        }

        $retrutnValue = array(
            'raceData' => $raceData,
            'rastData' => $rastData
        );

        return $retrutnValue;
    }
}

?>