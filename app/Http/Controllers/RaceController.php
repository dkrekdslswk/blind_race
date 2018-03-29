<?php

// RaceController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $json     = $request->input('post');
        $postData = json_decode($json);

	// 더미 데이터
        $session['user_num']   = 1;
        $session['user_id']    = 'tamp1id';
        // 더미 데이터
        
        $groupData = DB::table('groups')
		->select(['groups.group_num as groupId',
			'groups.group_name as groupName',
			DB::raw('COUNT(group_students.user_num) as studentCount')])
		->join('group_students', 'group_students.group_num', '=', 'groups.group_num')
		->where(['groups.group_num', '=', $postData.group['groupId'],
		['groups.user_t_num', '=', $_session['user_num']]])
		->group_by('groups.group_num')
		->get();

        $raceSetExamId = DB::table('race_set_exam')->insertGetId([
		'group_num'=>$groupData.groupId, 
		'set_exam_state'=>$postData.race['raceMode'], 
		'exam_count'=>$postData.race['examCount'], 
		'set_exam_data'=>'{"base":"'.$postData.race['raceId'].'","bookPage":null}'
		], 'set_exam_num');

	$raceName = DB::table('races')
		->select('race_name')
		->where('race_num', '=', $postData.race['raceId'])
		->value('race_name');

	$returnVelue = array(
	"race"=>array("raceName"=>$raceName,"examCount"=>$postData.race['exanCount']),
	"group"=>array("groupName"=>$groupData["groupName"],
			"groupStudentCount"=>$groupData['studentCount']),
	"sessionId"=>session_id());

	return response()->json($returnVelue);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	/*
        $item = Item::find($id);
        return response()->json($item);
	*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*
	$item = Item::find($id);
        $item->name = $request->get('name');
        $item->price = $request->get('price');
        $item->save();

        return response()->json('Successfully Updated');
	*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	/*
      $item = Item::find($id);
      $item->delete();

      return response()->json('Successfully Deleted');
	*/
    }
}