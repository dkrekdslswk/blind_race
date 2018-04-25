<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
    // 유저 로그인 확인
    private function userLogin($userId, $password){
        // 유저 조회
        $userData = DB::table('users')
            ->select([
                'number',
                'name',
                'classification'
            ])
            ->where([
                'number'    => $userId,
                'pw'        => $password
            ])
            ->first();

        // 반납값 정리
        if(is_null($userData)) {
            $returnValue = array([
                'check'             => false
            ]);
        }else{
            $returnValue = array([
                'userId'            => $userData->number,
                'classification'    => $userData->classification,
                'name'              => $userData->name,
                'check'             => true
            ]);
        }

        return $returnValue;
    }

    // 모바일 로그인
    public function mobileLogin(Request $request){
        $userData = $this->userLogin($request->input('p_ID'), $request->input('p_PW'));

        // 로그인 성공
        if ($userData['check']){
            // 세션 아이디 저장
            $request->session()->put('sessionId', $this->sessionIdGet($userData['userId']));
            
            // 반납값 설정
            $returnVelue = [
                'check'             => true,
                'sessionId'         => $request->session()->get('sessionId'),
                'userName'          => $userData->name,
                'classification'    => $userData->classification
            ];
        } else {
            $returnVelue = [
                'check'     => false
            ];
        }

        return $returnVelue;
    }

    // 세션 정보 및 유저정보 읽어오기
    public static function sessionDataGet($sessionId){
        // 세션 시간 갱신
        DB::table('sessionDatas')
            ->where('number', '=', $sessionId)
            ->update(['updated_at' => DB::raw('CURRENT_TIMESTAMP')]);

        // 유저 정보 읽어오기
        $userData = DB::table('users as u')
            ->select(
                'u.number           as userId',
                'u.name             as userName',
                'u.classification   as classification',
                's.raceNumber       as raceId',
                's.nick             as nick',
                's.PIN              as roomPin'
            )
            ->where('s.number', '=', $sessionId)
            ->join('sessionDatas as s', 's.userNumber', '=', 'u.number')
            ->first();

        // 반납값 정리하기
        $returnVelue = array(
            'userId'            => $userData->userId,
            'userName'          => $userData->userName,
            'classification'    => $userData->classification,
            'raceId'            => $userData->raceId,
            'nick'              => $userData->nick,
            'roomPin'           => $userData->roomPin
        );

        return $returnVelue;
    }

    // 세션 값 입력
    public function sessionIdGet($userId){
        // 오래된 세션 확인
        $this->oldLoginCheck();

        // 이미 있는 세션 확인하기
        $data = DB::table('sessionDatas')
            ->select(['number'])
            ->where(['userNumber' => $userId])
            ->first();

        // 새로 세션을 만들기
        if(is_null($data)){
            $sessionId = DB::table('sessionDatas')
                ->insertGetId(['userNumber' => $userId], 'number');
        }
        // 이미 있는 세션 사용
        else{
            DB::table('sessionDatas')
                ->where('number', '=',$data->number)
                ->update('updated_at', '=', 'now()');
            $sessionId = $data->session_num;
        }

        return $sessionId;
    }

    // 오래된 세션을 삭제
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