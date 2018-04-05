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
        //$json     = json_encode(array('group' => array('groupId'  => 1), 
        //                              'race' => array('raceMode'  => 'n', 
        //                                              'examCount' => 30, 
        //                                              'raceId'    => 1)));
        //$postData = json_decode($json);

        $postData     = array('group' => array('groupId'   => 1), 
                          'race'  => array('raceMode'  => 'n', 
                                           'examCount' => 30, 
                                           'raceId'    => 1));

        //$postData = array('group' => array('groupId'   => $request->input('groupId')), 
        //                  'race'  => array('raceMode'  => $request->input('raceMode'), 
        //                                   'examCount' => $request->input('examCount'), 
        //                                   'raceId'    => $request->input('raceId')));

	// test
        $userId = DB::table('users as u')
                  ->select(['u.user_num as user_num',
                            's.session_num as session_num'])
                  ->where('u.user_id', '=', 'tamp1id')
                  ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
                  ->first();

        if(!isset($userId->session_num)){
             $session['sessionId'] = DB::table('sessions')
                                       ->insertGetId(['user_num' => $userId->user_num],
                                                     'session_num');
        }else{
             $session['sessionId'] = $userId->session_num;
        }
        // test

        $sData = DB::table('sessions')
                 ->select(['user_num'])
                 ->where('session_num', '=', $session['sessionId'])
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
		->select(['races.race_name as race_name', 
                          'races.race_num  as race_num', 
                          DB::raw('COUNT(race_quizs.quiz_num) as examCount')])
		->join('race_quizs', 'race_quizs.race_num', '=', 'races.race_num')
		->where(['races.race_num' => $postData['race']['raceId'],
                         'races.user_t_num' => $sData->user_num])
                ->groupBy('races.race_num')
		->first();

        if(isset($raceCheck->race_num) && ($raceCheck->examCount >= $postData['race']['examCount'])){

            $raceSetExamId = DB::table('race_set_exam')->insertGetId([
                'group_num'=>$groupData->groupId,
                'set_exam_state'=>$postData['race']['raceMode'], 
                'exam_count'=>$postData['race']['examCount'],
                'race_num'=>$raceCheck->race_num
                ], 'set_exam_num');

            DB::table('sessions')
            ->where('session_num', '=', $session['sessionId'])
            ->update(['set_exam_num' => $raceSetExamId]);

       	    $returnValue = array(
       	                 'race'=>array('raceName'          =>$raceCheck->race_name,
                                       'examCount'         =>$postData['race']['examCount']),
       	                 'group'=>array('groupName'         => $groupData->groupName,
       	                                'groupStudentCount' => $groupData->studentCount),
       	                 'sessionId' => $session['sessionId'],
                         'check' =>  true);

        }
        else {
             $returnValue = array('check' => false);
        }

	//return response()->json($groupData);
	return response()->json($returnValue);
	//return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    // race teacher is in to room 
    public function teacherIn(Request $request){
        //$json     = $request->input('post');
        $json     = json_encode(array('roomPin' => '123456', 'sessionId' => 1));
        $postData = json_decode($json, true);

        // race set exam check
        $setExamTest = DB::table('sessions')
		->select(['set.exam_count as setExamCount',
			  DB::raw('COUNT(quiz.sequence) as examCount'),
                          'sessions.set_exam_num as setExamId',
                          'set.group_num as groupId'])
                       ->leftJoin('race_set_exam as set', 'set.set_exam_num', '=', 'sessions.set_exam_num')
                       ->leftJoin('race_set_exam_quizs as quiz', 'quiz.set_exam_num', '=', 'sessions.set_exam_num')
                       ->where('sessions.session_num', '=', $postData['sessionId'])
                       ->groupBy('sessions.session_num')
                       ->first();
        
        // first exam start
        if(isset($setExamTest->setExamCount)
           && (($setExamTest->setExamCount != 0)
                && ($setExamTest->examCount <= $setExamTest->setExamCount))){

             $updateCheck = DB::table('sessions')
                            ->where('session_num', '=', $postData['sessionId'])
                            ->update(['room_pin_number' => $postData['roomPin']]);

             $returnValue = array('race' => array('setExamId'    => $setExamTest->setExamId,
                                                  'setExamCount' => $setExamTest->setExamCount),
                                  'group' => array('groupId'     => $setExamTest->groupId),
                                  'check' => true);
        } 
        // error incorrect race
        else {
             $returnValue = array('check' => false);
        }

        return response()->json($returnValue);
    }

    // race student is in to room
    public function studentIn(Request $request){
        //$json     = $request->input('post');
        $json     = json_encode(array('roomPin' => '123456', 'sessionId' => 2, 'setExamId' => 1, 'groupId' => 1));
        $postData = json_decode($json, true);

	// test
        $userId = DB::table('users as u')
                  ->select(['u.user_num as user_num',
                            's.session_num as session_num'])
                  ->where('s.session_num', '=', $postData['sessionId'])
                  ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
                  ->first();

        if(!isset($userId->session_num)){
             $session['sessionId'] = DB::table('sessions')
                                       ->insertGetId(['user_num' => $postData['sessionId']],
                                                     'session_num');
        }else{
             $session['sessionId'] = $userId->session_num;
        }
        // test
        
        $userCheck = DB::table('group_students as gs')
                     ->select('gs.user_num as user_num')
                     ->where(['gs.group_num'  => $postData['groupId'],
                              's.session_num' => $postData['sessionId']])
                     ->join('sessions as s', 's.user_num', '=', 'gs.user_num')
                     ->first();

        if(isset($userCheck->user_num))
        {
            $countDown = 10;

            do{
            $characters = DB::table('characters as c')
                         ->select('c.character_num as characterId')
                         ->where('rr.set_exam_num', $postData['setExamId'])
                         ->leftJoin('sessions as s', 's.character_num', '=', 'c.character_num')
                         ->leftJoin('race_results as rr', 'rr.user_num', '=', 's.user_num')
                         ->get();

            $charList = array();
            foreach($characters as $charNumber){
                array_push($charList, $charNumber->characterId);
            }

            $character = DB::table('characters')
                         ->select('character_num as characterId',
                                  'character_url as characterUrl')
                         ->whereNotIn('character_num', $charList)
                         ->inRandomOrder()
                         ->first();

            $updateCheck = DB::table('sessions')
                           ->where('session_num', '=', $postData['sessionId'])
                           ->update(['set_exam_num'  => $postData['setExamId'],
                                     'character_num' => $character->characterId]);

                 $countDown--;
            } while ($updateCheck != 1 && $countDown > 0);
        
            if($updateCheck == 1){
                $returnValue = array('userStudentCheck' => $updateCheck,
                                     'characterUrl'     => $character->characterUrl);
            } else {
                $returnValue = array('userStudentCheck' => $updateCheck);
            }
        } else {
            $returnValue = array('userStudentCheck' => $updateCheck);
        }

        return response()->json($returnValue);
    }

    // get quiz
    public function quizNext(Request $request){
        //$json     = $request->input('post');
        $json     = json_encode(array('roomPin' => '123456', 'setExamId' => 1, 'sessionId' => 1));
        $postData = json_decode($json, true);

        $chaeck = DB::table('sessions')
                  ->select(DB::raw('COUNT(*) as check'))
                  ->where(['session_num'     => $postData['sessionId'],
                           'set_exam_num'    => $postData['setExamId'],
                           'room_pin_number' => $postData['roomPin']])
                  ->first();

        if($chaeck->check == 1){
            $raceId = DB::table('race_set_exam as rse')
                      ->select('rse.race_num                 as base', 
                               'rse.book_num                 as bookId', 
                               'rse.book_page_start          as pageStart', 
                               'rse.book_page_end            as pageEnd',
                               'rse.exam_count               as setExamCount',
			       DB::raw('COUNT(quiz.sequence) as examCount'))
                      ->where('rse.set_exam_num', '=', $postData['setExamId'])
                      ->join('race_set_exam_quizs as quiz', 'quiz.set_exam_num', '=', 'rse.set_exam_num')
                      ->groupBy('res.set_exam_num')
                      ->first();

            $returnValue = DB::table('race_quizs as rq')
                        ->select('qb.quiz_question     as question',
                                 'qb.quiz_right_answer as right',
                                 'qb.quiz_example1     as exam1',
                                 'qb.quiz_example1     as exam2',
                                 'qb.quiz_example1     as exam3',
                                 'qb.quiz_type         as type')
                        ->where(['rq.race_num'       => $raceId->base,
                                 'rseq.set_exam_num' => $postData['setExamId'],
                                 DB::raw('rseq.sequence IS NULL')])
                        ->leftJoin('race_set_exam_quizs as rseq', 'rseq.quiz_num', 'rq.quiz_num')
                        ->join('quiz_bank as qb', 'qb.quiz_num', 'rq.quiz_num')
                        ->inRandomOrder()
                        ->first();
        } else {
            $returnValue = "fail";
        }

        return response()->json($returnValue);
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