<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller{
    // 그룹 목록 가져오기 root(all teachers), teacher(mine)
    public function groupsGet(Request $request){
        // 유저가 선생인지 확인하고 선생이 아니면 강퇴
        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select([
                'u.number   as userId',
                's.number  as sessionId'
            ])
            ->where('u.number', '=', 123456789)
            ->leftJoin('sessionDatas as s', 's.userNumber', '=', 'u.number')
            ->first();

        if(!isset($userData->sessionId)){
            $request->session()->put('sessionId', DB::table('sessionDatas')
                ->insertGetId([
                    'userNumber' => $userData->userId
                ], 'number'));
        }else{
            $request->session()->put('sessionId', $userData->sessionId);
        }
        // test

        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 유저 로그인 확인
        if ($userData['check']){
            // 권한확인, 권한별로 목록 보여주기
            switch ($userData['classification']) {
            case 'root':
                $classificationWhere = array();
                $check = true;
                break;
            case 'teacher':
                $classificationWhere = array(
                    'g.number' => $userData['userId']
                );
                $check = true;
                break;
            case 'student':
            default:
                $classificationWhere = array(
                    'g.number' => 0
                );
                $check = false;
                break;
            }

            // 올바른 권한을 가진 사람만 접근가능
            if ($check){
                // 그룹 정보 가져오기
                $groupDatas = DB::table('groups')
                    ->select(
                        'number as groupId',
                        'name   as groupName'
                    )
                    ->where($classificationWhere)
                    ->orderBy('number', 'desc')
                    ->get();

                // 반납할 값 정리
                $groups = array();
                foreach ($groupDatas as $groupData){
                    array_push($groups, array(
                        'groupId' => $groupData->groupId,
                        'groupName' => $groupData->groupName
                    ));
                }
                $returnValue = array(
                    'groups'    => $groups,
                    'get'       => $request->input('test'),
                    'check'     => true
                );
            } else {
                $returnValue = array(
                    'get'       => $request->input('test'),
                    'check'     => false
                );
            }
        } else {
            $returnValue = array(
                'get'       => $request->input('test'),
                'check'     => false
            );
        }

        return $returnValue;
    }

    // 그룹 정보 가져오기 root, teacher

    // 그룹 만들기 root

    // 학생 초대하기 root, teacher

    // 학생 초대받기 root, teacher

    // 교사 임명 root

    // 유저 검색 root(교사, 학생), teacher(학생)

    // 학생 정보수정 root, teacher

    // 학생 그룹이동 root
}

?>