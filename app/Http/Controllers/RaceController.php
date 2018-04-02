<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class RaceController extends Controller
{
    public function index()
    {
    }

    // race create first order
    public function create(Request $request)
    {
        $postData = array('group' => array('groupId'   => $request->input('groupId')),
                          'race'  => array('raceMode'  => $request->input('raceMode'), 
                                           'examCount' => $request->input('examCount'), 
                                           'raceId'    => $request->input('raceId')));
        /*$json     = json_encode(array('group' => array('groupId' => 1),
                                      'race' => array('raceMode' => 'n', 'examCount' => 30, 'raceId' => 1)));
        $postData = json_decode($json, true);*/


	// test
        $userId = DB::table('users as u')
                  ->select(['u.user_num as user_num', 's.session_num as session_num'])
		  ->leftJoin('session as s', 's.user_num', '=', 'u.user_num')
                  ->where('user_id', '=', 'tamp1id')
                  ->first();

        if(is_null($userId->session_num)){
             $session['sessionId']   = DB::table('sessions')
                                       ->insertGetId(['user_num'    => $userId->user_num, 
                                                      'session_num' => $userId->session_num]);
        }else{
             $session['sessionId'] = $userId->session_num;
        }
        // test

        $sData = DB::table('sessions')
                 ->select(['user_num'])
                 ->where('session_num', '=', $session['sessionId'])
                 ->first();

        $groupData = DB::table('groups')
		->select(['groups.group_num as groupId',
			'groups.group_name as groupName',
			DB::raw('COUNT(group_students.user_num) as studentCount')])
		->join('group_students', 'group_students.group_num', '=', 'groups.group_num')
		->where(['groups.group_num'  => $postData['group']['groupId'],
		         'groups.user_t_num' => $sData->user_num])
                ->groupBy('groups.group_num')
		->first();

        $raceCheck = DB::table('races')
		->select(['races.race_name as race_name', 
                          'races.race_num  as race_num', 
                          DB::raw('COUNT(race_quizs.quiz_num) as examCount')])
		->join('race_quizs', 'race_quizs.race_num', '=', 'races.race_num')
		->where(['races.race_num'   => $postData['race']['raceId'],
                         'races.user_t_num' => $sData->user_num])
                ->groupBy('races.race_num')
		->first();

        if(isset($raceCheck->race_num) && ($raceCheck->examCount > $postData['race']['examCount'])){

            $raceSetExamId = DB::table('race_set_exam')->insertGetId([
                'group_num'=>$groupData->groupId,
                'set_exam_state'=>$postData['race']['raceMode'],
                'exam_count'=>$postData['race']['examCount'],
                'set_exam_data'=>'{"base":"' . $raceCheck->race_num . '","bookPage":null}'
                ], 'set_exam_num');

            DB::table('sessions')
            ->where('session_num', '=', $session['sessionId'])
            ->update(['set_exam_num' => $raceSetExamId]);

       	    $returnValue = array(
       	                 "race"=>array("raceName"          =>$raceCheck->race_name,
                                       "examCount"         =>$postData['race']['examCount']),
       	                 "group"=>array("groupName"         => $groupData->groupName,
       	                                "groupStudentCount" => $groupData->studentCount),
       	                 "sessionId"=>$session['sessionId']);

        }
        else{
            $returnValue = "fail";
        }

	return response()->json($returnValue);
	//return view('race/race_waitingroom')->with('json', response()->json($returnVelue));
    }

    // race teacher is in to room 
    public function roomIn(Request $request){
        $json     = $request->input('post');
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => ));
        $postData = json_decode($json, true);

        // race set exam check
        $setExamTest = DB::table('sessions')
		->select(['set.exam_count as setExamCount',
			DB::raw('COUNT(quiz.sequence) as examCount')])
                       ->join('race_set_exam as set', 'set.set_exam_num', '=', 'sessions.set_exam_num')
                       ->join('race_set_exam_quizs as quiz', 'quiz.set_exam_num', '=', 'sessions.set_exam_num')
                       ->where('sessions.session_num', '=', postData['sessionId'])
                       ->groupBy('sessions.session_num')
                       ->first();

        if(isset($setExamTest->setExamCount) 
           && (($setExamTest->setExamCount != 0)
                && ($setExamTest->examCount <= $setExamTest->setExamCount))){

            DB::table('sessions')
            ->where('session_num', '=', postData['sessionId'])
            ->update(['room_pin_number' => postData['roomPin']]);

            $returnValue = array('race' => array(''));
        }

        retrun response()->json($returnValue);
    }

    // race student is in to room
    public function studentIn(Request $request){
        //$json     = $request->input('post');
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => ));
        //$postData = json_decode($json, true);
        
        DB::table('sessions')
        ->where('session_num', '=', postData['sessionId'])
        ->update(['room_pin_number' => postData['roomPin']]);
    }

    public function destroy($id)
    {
	/*
      $item = Item::find($id);
      $item->delete();

      return response()->json('Successfully Deleted');
	*/
    }
}