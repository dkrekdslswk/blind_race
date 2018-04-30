<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller{
    // 클레스 목록 획득
    public function groupsGet(Request $request){
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
                    'groups' => $groups,
                    'check' => true
                );
            } else {
                $returnValue = array(
                    'check' => false
                );
            }
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 유저목록 가져오기

    // 유저이동

    //ㅇ
}

?>