<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class RaceController extends Controller
{
    // race create first order
    public function create(Request $request)
    {
        //$json     = $request->input('post');
        //$json     = json_encode(array('group' => array('groupId' => 1), 
        //                              'race' => array('raceMode' => 'n', 'examCount' => 30, 'raceId' => 1)));
        //$postData = json_decode($json);
        $postData = array('group' => array('groupId'   => $request->input('groupId')), 
                          'race'  => array('raceMode'  => $request->input('raceMode'), 
                                           'examCount' => $request->input('examCount'), 
                                           'raceId'    => $request->input('raceId')));

	// test
        $userId = DB::table('users')
                  ->select(['user_num'])
                  ->where('user_id', '=', 'tamp1id')
                  ->first();

        if(is_null($userId->session_num)){
             Session::put('sessionId', DB::table('sessions')
                                       ->insertGetId(['user_num'    => $userId->user_num, 
                                                      'session_num' => $userId->session_num]));
        }else{
             Session::put('sessionId', $userId->session_num);
        }
        // test

        $session['sessionId']   = DB::table('sessions')
                             ->insertGetId(['user_num' => $userId->user_num], 'session_num')
                             ->first();

        $sData = DB::table('sessions')
                 ->select(['user_num'])
                 ->where('session_num', '=', Session::get('sessionId'))
                 ->first();
        // test
        
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
		->select(['races.race_name', 'races.race_num', DB::raw('COUNT(race_quizs.quiz_num) as examCount')])
		->join('race_quizs', 'race_quizs.race_num', '=', 'races.race_num')
		->where(['races.race_num' => $postData['race']['raceId'],
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
            ->where('session_num', '=', Session::get('sessionId'))
            ->update(['set_exam_num' => $raceSetExamId]);

       	    $returnValue = array(
       	                 'race'=>array('raceName'          =>$raceCheck->race_name,
                                       'examCount'         =>$postData['race']['examCount']),
       	                 'group'=>array('groupName'         => $groupData->groupName,
       	                                'groupStudentCount' => $groupData->studentCount),
       	                 'sessionId'=>Session::get('sessionId'));

        }

	//return response()->json($groupData);
	return response()->json($returnValue);
	//return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    // race teacher is in to room 
    public function teacherIn(Request $request){
        $json     = $request->input('post');
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => ));
        $postData = json_decode($json, true);

        // race set exam check
        $setExamTest = DB::table('sessions')
		->select(['set.exam_count as setExamCount',
			  DB::raw('COUNT(quiz.sequence) as examCount'),
                          'sessions.set_exam_num as setExamId',
                          'race_set_exam.group_num as groupId'])
                       ->join('race_set_exam as set', 'set.set_exam_num', '=', 'sessions.set_exam_num')
                       ->join('race_set_exam_quizs as quiz', 'quiz.set_exam_num', '=', 'sessions.set_exam_num')
                       ->where('sessions.session_num', '=', postData['sessionId'])
                       ->groupBy('sessions.session_num')
                       ->first();
       
        // first exam start
        if(isset($setExamTest->setExamCount)
           && (($setExamTest->setExamCount != 0)
                && ($setExamTest->examCount <= $setExamTest->setExamCount))){

             $returnValue = array('race' => array('setExamId'    => $setExamTast->setExamId,
                                                  'setExamCount' => $setExamTast->setExamCount),
                                  'group' => array('groupId'     => $setExamTast->groupId),
                                  'userTeacherCheck' => true);
        } 
        // error incorrect race
        else {
             $returnValue = array('userTeacherCheck' => false;);
        }

        retrun response()->json($returnValue);
    }

    // race student is in to room
    public function studentIn(Request $request){
        $json     = $request->input('post');
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => ));
        $postData = json_decode($json, true);
        
        $userCheck = DB::table('groupStudent as gs')
                     ->select([DB::raw('COUNT(*) as check')])
                     ->where(['gs.group_num'  => $postData['groupId'],
                              's.session_num' => $postData['sessionId']])
                     ->join('sessions as s', 's.user_num', '=', 'gs.user_num')
                     ->first();

        if($userCheck->check == 1)
        {
            $countDown = 10;

            do{
            $character = DB::('characters as c')
                         ->select(['c.character_num as characterId', 'c.character_url as characterUrl']);
                         ->where(['rr.set_exam_num' => $postData['setExamId'],
                                  DB::raw('s.session_num IS NULL')])
                         ->leftJoin('sessions as s', 's.character_num', '=', 'c.character_num')
                         ->leftJoin('race_results as rr', 'rr.user_num', '=', 's.user_num')
                         ->inRandomOrder()
                         ->first();

            $updateCheck = DB::table('sessions')
                           ->where('session_num', '=', postData['sessionId'])
                           ->update(['set_exam_num'  => postData['setExamId'],
                                     'character_num' => $character->characterId]);

                 $countDown--;
            } while($updateCheck != 1 && $countDown > 0);
        
            if($updateCheck == 1){
            $returnValue = array('userStudentCheck' => true,
                                 'characterUrl'     => $character->characterUrl);
            } else {
                $returnValue = array('userStudentCheck' => false);
            }
        } else {
            $returnValue = array('userStudentCheck' => false);
        }

        retrun response()->json($returnValue);
    }

    // get quiz
    public function quizNext(Request $request){
        $json     = $request->input('post');
        //$json     = json_encode(array('roomPin' => '123456', 'sessionId' => ));
        $postData = json_decode($json, true);

        $raceId = DB::table('race_set_exam')
                  ->select('set_exam_data.base as base', 'set_exam_data.bookPage as bookPage')
                  ->where('set_exam_num', '=', $postData['race']['setExamId'])
                  ->first();

        

        retrun response()->json($returnValue);
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