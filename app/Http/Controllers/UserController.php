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
                'number as userId',
                'name',
                'classification'
            ])
            ->where([
                'number'    => $userId,
                'pw'        => $password
            ])
            ->first();

        // 반납값 정리
        if(!$userData) {
            $returnValue = array(
                'check'             => false
            );
        }else{
            $returnValue = array(
                'userId'            => $userData->userId,
                'classification'    => $userData->classification,
                'name'              => $userData->name,
                'check'             => true
            );
        }

        return $returnValue;
    }

    // 모바일 로그인
    public function mobileLogin(Request $request){
        $userData = $this->userLogin(
            $request->input('p_ID'),
            $request->input('p_PW')
        );

        // 로그인 성공
        if ($userData['check']){
            // 반납값 설정
            $returnValue = array(
                'check'             => true,
                'sessionId'         => $this->sessionIdGet($userData['userId']),
                'userName'          => $userData['name'],
                'classification'    => $userData['classification']
            );
        } else {
            $returnValue = array(
                'check'     => false
            );
        }

        return json_encode($returnValue);
    }

    // 웹 로그인
    public function webLogin(Request $request){
        $userData = $this->userLogin(
            $request->input('p_ID'),
            $request->input('p_PW')
        );

        // 로그인 성공
        if ($userData['check']){
            // 세션 아이디 저장
            $request->session()->put('sessionId', $this->sessionIdGet($userData['userId']));

            // 반납값 설정
            $returnValue = array(
                'check'             => true,
                'userName'          => $userData['name'],
                'classification'    => $userData['classification']
            );
        } else {
            $returnValue = array(
                'check'     => false
                
            );
        }

        return view('homepage')->with('response', $returnValue);
    }

    // 세션 정보 및 유저정보 읽어오기
    public static function sessionDataGet($sessionId){
        // 세션 시간 갱신
        DB::table('sessionDatas')
            ->where('number', '=', $sessionId)
            ->update(['updated_at' => DB::raw('CURRENT_TIMESTAMP')]);

        // 오래된 세션 정리하기
        DB::table('sessionDatas')
            ->where(DB::raw('date(updated_at)'), '<=', DB::raw('subdate(now(), INTERVAL 1 DAY)'))
            ->delete();

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
        if($userData) {
            $returnValue = array(
                'userId' => $userData->userId,
                'userName' => $userData->userName,
                'classification' => $userData->classification,
                'raceId' => $userData->raceId,
                'nick' => $userData->nick,
                'roomPin' => $userData->roomPin,
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 세션 값 입력
    private function sessionIdGet($userId){
        // 이미 있는 세션 확인하기
        $data = DB::table('sessionDatas')
            ->select([
                'number as sessionId'
            ])
            ->where([
                'userNumber' => $userId
            ])
            ->first();

        // 이미 있는 세션 제거하기
        if($data){
            DB::table('sessionDatas')
                ->where([
                    'number' => $data->sessionId
                ])
                ->delete();
        }

        // 새션 할당하기
        $sessionId = DB::table('sessionDatas')
            ->insertGetId([
                'userNumber' => $userId
            ], 'number');

        // 아이디 반납
        return $sessionId;
    }

    // 회원 정보 수정
    public function store(Request $request){
        $postData = array(
            'name'              => $request->input('name'),
            'password'          => $request->input('password'),
            'passwordCheck'     => $request->input('passwordCheck'),
            'passwordUpdate'    => $request->input('passwordUpdate')
        );

        // 반납할 값 정리
    }

    // 로그아웃
    public function logout(Request $request){
        $postData = array(
            'sessionId' => $request->has('sessionId') ? $request->input('sessionId') : $request->session()->get('sessionId')
        );

        //
    }
}

?>