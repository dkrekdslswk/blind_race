<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class RecordBoxController extends Controller{
    public function user_login(Request $request){
        //$postData     = array('group' => array('groupId'   => 1),
        //                  'race'  => array('raceMode'  => 'n',
        //                                   'examCount' => 30,
        //                                   'raceId'    => 1));

        $postData = array(
            'group' => array('groupId'   => $request->input('groupId')),
            'race'  => array('raceMode'  => $request->input('raceMode'),
                'examCount' => $request->input('examCount'),
                'raceId'    => $request->input('raceId')));

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
                DB::raw('AVG(rr.race_score) as total_score')
            ])
            ->where([
                'rse.group_num' => $postData['groupId']
            ])
            ->join('race_results as rr', 'rr.set_exam_num', '=', 'rse.set_exam_num')
            ->groupBy()
            ->orderBy()
            ->offset(0)
            ->limit(5)
            ->get();

    }
}

?>