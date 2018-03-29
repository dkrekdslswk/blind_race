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

    public function create()
    {
        //$json     = $request->input('post');
        $json     = '{"group":["groupId":1],"race":["raceMode":"n","raceCount":30,"raceId":1]}';
        $postData = json_decode($json, true);

	// ???? ??????
        $session['user_num']   = 1;
        $session['user_id']    = 'tamp1id';
        // ???? ??????
        
        $groupData = DB::table('groups')
		->select(['groups.group_num as groupId',
			'groups.group_name as groupName',
			DB::raw('COUNT(group_students.user_num) as studentCount')])
		->join('group_students', 'group_students.group_num', '=', 'groups.group_num')
		->where(['groups.group_num', '=', $postData['group']['groupId'],
		['groups.user_t_num', '=', $_session['user_num']]])
		->group_by('groups.group_num')
		->get();

        $raceSetExamId = DB::table('race_set_exam')->insertGetId([
		'group_num'=>$groupData.groupId, 
		'set_exam_state'=>$postData['race']['raceMode'], 
		'exam_count'=>$postData['race']['examCount'], 
		'set_exam_data'=>'{"base":"'.$postData['race']['raceId'].'","bookPage":null}'
		], 'set_exam_num');
        $session['set_exam_num'] = $raceSetExamId;

	$raceName = DB::table('races')
		->select('race_name')
		->where('race_num', '=', $postData['race']['raceId'])
		->value('race_name');

	$returnValue = array(
	"race"=>array("raceName"=>$raceName,"examCount"=>$postData.race['exanCount']),
	"group"=>array("groupName"=>$groupData["groupName"],
			"groupStudentCount"=>$groupData['studentCount']),
	"sessionId"=>session_id());

	return response()->json($returnValue);
	//return view('race/race_waitingroom')->with('json', response()->json($returnVelue));
    }

    public function comein($pin){
        
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