<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{
    // 모바일 로그인
    public function mobileLogin(Request $request){
        $userData = $this->userLogin(
            $request->input('p_ID'),
            $request->input('p_PW')
        );

        // 로그인 성공
        if ($userData['check']){
            // 세션 받아오기
            $sessionId = $this->sessionIdGet($userData['userId']);

            if ($sessionId) {
                // 반납값 설정
                $returnValue = array(
                    'check' => true,
                    'loginCheck' => true,
                    'sessionId' => $this->sessionIdGet($userData['userId']),
                    'userName' => $userData['name'],
                    'classification' => $userData['classification']
                );
            } else {
                $returnValue = array(
                    'check' => true,
                    'loginCheck' => false
                );
            }
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
            // 세션아이디 받아오기
            $sessionId = $this->sessionIdGet($userData['userId']);

            if ($sessionId) {
                // 세션 아이디 저장
                $request->session()->put('sessionId', $sessionId);

                // 반납값 설정
                $returnValue = array(
                    'check' => true,
                    'loginCheck' => true,
                    'userName' => $userData['name'],
                    'classification' => $userData['classification']
                );
            } else {
                $returnValue = array(
                    'check'     => false,
                    'loginCheck' => false
                );
            }
        } else {
            $returnValue = array(
                'check'     => false
            );
        }

        return view('homepage')->with('response', $returnValue);
    }

    // 회원 정보 수정
    public function userUpdate(Request $request){
        $postData = array(
            'name'              => $request->input('name'),
            'password'          => $request->input('password'),
            'passwordCheck'     => $request->input('passwordCheck'),
            'passwordUpdate'    => $request->input('passwordUpdate')
        );

        // 유저정보
        $userData = self::sessionDataGet('sessionId');

        if ($userData['check']) {
            // 페스워드 변경 하기
            if ($postData['passwordCheck']) {
                $update = array(
                    'pw' => $postData['passwordUpdate'],
                    'name' => $postData['name']
                );
            } else {
                $update = array(
                    'name' => $postData['name']
                );
            }

            // 변경하기
            DB::table('users')
                ->where([
                    'number' => $userData['userId'],
                    'pw' => $postData['password']
                ])
                ->update($update);

            // 반납할 값 정리
            $userData = self::sessionDataGet('sessionId');

            $returnValue = array(
                'name' => $userData['userName'],
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 모바일 로그아웃
    public function mobileLogout(Request $request){
        $postData = array(
            'sessionId' => $request->input('sessionId')
        );

        // 세션을 삭제
        DB::table('sessionDatas')
            ->where([
                'number' => $postData['sessionId']
            ])
            ->delete();
    }

    // 웹 로그아웃
    public function webLogout(Request $request){
        // 세션안 데이터 비우기
        DB::table('sessionDatas')
            ->where([
                'number' => $request->session()->get('sessionId')
            ])
            ->update([
                'nick' => null,
                'PIN' => null,
                'characterNumber' => null,
                'raceNumber' => null
            ]);

        // 세션 비우기
        $request->session()->flush();
    }

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

    // 세션 정보 및 유저정보 읽어오기
    public static function sessionDataGet($sessionId){
        // 세션 시간 갱신
        DB::table('sessionDatas')
            ->where('number', '=', $sessionId)
            ->update(['updated_at' => DB::raw('CURRENT_TIMESTAMP')]);

        // 오래된 세션 정리하기
        DB::table('sessionDatas')
            ->where(DB::raw('date(updated_at)'), '<=', DB::raw('subdate(now(), INTERVAL 7 DAY)'))
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

    // 세션 만들거나 받아오기
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

        // 이미 있는 세션 그대로 쓰기
        if($data){
            $sessionId = false;
//            $sessionId = $data->sessionId;
//            DB::table('sessionDatas')
//                ->where([
//                    'number' => $sessionId
//                ])
//                ->update([
//                    'nick' => null,
//                    'PIN' => null,
//                    'characterNumber' => null,
//                    'raceNumber' => null
//                ]);
        }
        // 새션 할당하기
        else {
            // 새션 할당하기
            $sessionId = DB::table('sessionDatas')
                ->insertGetId([
                    'userNumber' => $userId
                ], 'number');
        }

        // 아이디 반납
        return $sessionId;
    }
}

?>