<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;

class LoginController extends Controller
{
    // race create first order
    public function create(Request $request)
    {
        $postData = array(
            'userId'       => 'tamp2id',
            'userPassword' => 'tamp2password');

//        $postData = array(
//            'userId'       => $request->input('userId'),
//            'userPassword' => $request->input('userPassword'));

        $userData = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                    's.session_num  as session_num',
                    't.user_t_num   as user_t_num'])
            ->where(['u.user_id'      => $postData['userId'],
                    'u.user_password' => $postData['userPassword']])
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->leftJoin('user_teachers as t', 't.user_t_num', '=', 'u.user_num')
            ->first();

        $returnValue = array();

        //return response()->json($groupData);
        //return response()->json($returnValue);
        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    public function oldLoginCheck(){
        DB::table()
            ->where(DB::raw('date(created_at) <= date(subdate(now(), INTERVAL 2 DAY))'))
            ->orWhere(DB::raw('updated_at     <= DATE_ADD(NOW(), INTERVAL 6 HOUR)'));
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