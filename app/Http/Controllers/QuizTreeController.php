<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class QuizTreeController extends Controller
{
    // race create first order
    public function create(Request $request)
    {
//        $json     = $request->input('post');
        $json     = json_encode(array('group' => array('groupId'  => 1),
                                      'race' => array('raceMode'  => 'n',
                                                      'examCount' => 30,
                                                      'raceId'    => 1)));
        $postData = json_decode($json);

        //$postData     = array('group' => array('groupId'   => 1),
        //                  'race'  => array('raceMode'  => 'n',
        //                                   'examCount' => 30,
        //                                   'raceId'    => 1));

//        $postData = array(
//            'group' => array('groupId'   => $request->input('groupId')),
//            'race'  => array('raceMode'  => $request->input('raceMode'),
//            'examCount' => $request->input('examCount'),
//            'raceId'    => $request->input('raceId')));



        //return response()->json($groupData);
        //return response()->json($returnValue);
//        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }
}