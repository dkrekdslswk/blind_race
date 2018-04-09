<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
    public function user_login(Request $request){
        $user_id = $request->input('ID');
        $password = $request->input('PW');

        $data = DB::select('select user_num from users where user_id=? and user_password=?', [$user_id,$password])->first();

        if(count($data)){
            $session['sessionId'] = $this->sessionIdGet($data->user_num);
            return view('homepage');
        }else{
            echo "login failed";
        }
    }

    public function sessionDataGet($sessionId){

    }

    public function sessionIdGet($userId){
        $this->oldLoginCheck();

        $data = DB::table('sessions')
            ->select(['session_num'])
            ->where(['user_num' => $userId])
            ->first();

        if(count($data)){
            $sessionId = $data->session_num;
        }else{
            $sessionId = DB::table('sessions')
                ->insertGetId(['user_num' => $userId], 'session_num');
        }

        return $sessionId;
    }

    public function oldLoginCheck(){
        DB::table('sessions')
            ->where(DB::raw('date(updated_at) <= date(subdate(now(), INTERVAL 7 DAY))'))
            ->where(DB::raw('date(created_at) <= date(subdate(now(), INTERVAL 120 DAY))'))
            ->delete();
    }

    public function store(Request $request){

        /* 회원가입 */
        $result = DB::insert("insert into users(user_id,user_password,user_name) values(?,?,?)"
            ,[$request->input('ID'),$request->input('PW'),$request->input('user_name')]);

        if($result == 1 )
            return view('login/login');
    }
}

?>