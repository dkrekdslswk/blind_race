<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
    public function user_login(Request $request){
        $user_id = $request->input('P_ID');
        $password = $request->input('P_PW');

        $data = DB::select('select user_num from users where user_id=? and user_password=?', [$user_id,$password])->first();

        if(count($data)){
            $_SESSION['sessionId'] = $this->sessionIdGet($data->user_num);
            return view('homepage');
        }else{
            echo "login failed";
        }
    }

    public static function sessionDataGet($sessionId){
        DB::table('sessions')
            ->where('number', '=', $sessionId)
            ->update(['updated_at' => DB::raw('CURRENT_TIMESTAMP')]);

        $userData = DB::table('users as u')
            ->select(
                'u.number           as userId',
                'u.name             as userName',
                'u.classification   as classification',
                's.raceNumber       as raceId',
                's.PIN              as roomPin'
            )
            ->where('s.number', '=', $sessionId)
            ->join('sessionDatas as s', 's.userNumber', '=', 'u.number')
            ->first();

        return array(
            'userId'            => $userData->userId,
            'userName'          => $userData->userName,
            'classification'    => $userData->classification,
            'raceId'            => $userData->raceId,
            'roomPin'           => $userData->roomPin
        );
    }

    public function sessionIdGet($userId){
        $this->oldLoginCheck();

        $data = DB::table('sessions')
            ->select(['session_num'])
            ->where(['user_num' => $userId])
            ->first();

        if(count($data)){
            DB::table('sessionDatas')
                ->where('session_num', '=',$data->session_num)
                ->update('updated_at', '=', 'now()');
            $sessionId = $data->session_num;
        }else{
            $sessionId = DB::table('sessions')
                ->insertGetId(['user_num' => $userId], 'session_num');
        }

        return $sessionId;
    }

    public function oldLoginCheck(){
        DB::table('sessionDatas')
            ->where(DB::raw('date(updated_at) <= date(subdate(now(), INTERVAL 7 DAY))'))
            ->where(DB::raw('date(created_at) <= date(subdate(now(), INTERVAL 120 DAY))'))
            ->delete();
    }

    public function store(Request $request){

        /* 회원가입 */
        $result = DB::insert("insert into users(user_id,user_password,user_name) values(?,?,?)"
            ,[$request->input('ID'),$request->input('PW'),$request->input('user_name')]);

        if($result == 1 )
            return view('Login/login');
    }
}

?>