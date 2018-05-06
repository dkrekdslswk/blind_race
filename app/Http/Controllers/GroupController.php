<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
class GroupController extends Controller{
    // 그룹 목록 가져오기 root(all teachers), teacher(mine)
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
                    'teacherNumber' => $userData['userId']
                );
                $check = true;
                break;
            case 'student':
            default:
                $classificationWhere = array(
                    'teacherNumber' => 0
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
    public function groupDataGet(Request $request){
        // 요구하는 값
        $postData = array(
            'groupId'
        );

        // 유저정보 가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 권한 확인
        switch ($userData['classification']) {
            // 검색방식 설정
            // 1. 자기 그룹 조회
            case 'teacher':
                // 그룹과 선생정보 가져오기
                $group = DB::table('groups as g')
                    ->select(
                        'g.number   as groupId',
                        'g.name     as groupName',
                        'u.number   as teacherId',
                        'u.name     as teacherName'
                    )
                    ->where([
                        'g.number'          => $postData['groupId'] ,
                        'g.teacherNumber'   => $userData['userId']
                    ])
                    ->join('users as u', 'u.number', '=', 'g.teacherNumber')
                    ->first();

                // 학생들 가져오기
                $students = DB::table('groupStudents as gs')
                    ->select(
                        'gs.userNumber  as userId',
                        'u.name         as userName'
                    )
                    ->where([
                        'gs.groupNumber' => $postData['groupId']
                    ])
                    ->join('u.users as u', 'u.number', '=', 'gs.userNumber')
                    ->get();
                break;

            // 2. 루트의 그룹조회
            // 존재하는 모든 그룹 조회가능
            // 미구현
//            case 'root':
//                break;

            // 3. 권한 외
            default:
                $group = false;
                break;
        }

        // 반납하는 값
        if($group){
            $groupArr = array(
                'id' => $group->groupId,
                'name' => $group->groupName
            );
        }
        $returnValue = array(
            'group' => array(
                'id',
                'name',
                'studentCount'
            ),
            'teacher' => array(
                'id',
                'name'
            ),
            'students' => array(
                0 => array(
                    'id',
                    'name'
                )
            ),
            'check'
        );

        return $returnValue;
    }

    // 그룹 만들기 root, teacher
    // 구현 중
    public function createGroup(Request $request){
        // 요구하는 값
        $postData = array(
            'groupName'
        );

        // 유저확인
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 권한 확인

        // 갓 만든 그룹 정보 반납

        // 반납는 값
        $returnValue = array(
            'group' => array(
                'id',
                'name',
                'studentCount' => 0 // 갓 만들었기 때문에 없음.
            ),
            'teacher' => array(
                'id',
                'name'
            ),
            'students' => array(), // 호환용 비어있는 변수
            'check'
        );

        return $returnValue;
    }

    // 학생 초대하기 root, teacher
    // 미구현
    public function PushInvitation(Request $request){
        // 요구하는 값
        $postData = array(
            'groupId',
            'students' => array(
                0 => array(
                    'id'
                )
            )
        );

        // 반납하는 값
        $returnValue = array(
            'students' => array(
                0 => array(
                    'id'
                )
            ),
            'check'
        );

        return $returnValue;
    }

    // 학생 초대받기 root, teacher
    // 미구현
    public function GetInvitation(Request $request){
        // 요구하는 값
        $postData = array(
            'groupId'
        );

        // 반납하는 값
        $returnValue = array(
            'groupId',
            'check'
        );

        return $returnValue;
    }

    // 유저 검색 root, teacher
    public function selectUser(Request $request){
        // 요구하는 값
//        $postData = array(
//            'search' => '김', // 123
//            'groupId' => 1
//        );
        $postData = array(
            'search'    => $request->input('search'),
            'groupId'   => $request->input('groupId')
        );

        // 세션정보 가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 권한 확인
        switch ($userData['classification']) {
            // 검색방식 설정
            // 1. 미등록 학생
            // 해당 그룹에 미등록된 학생만 검색
            // 이름, 학번에 해당 문자가 포감되는지 확인
            // 학생만 검색
            case 'teacher':
                $users = DB::table('users as u')
                    ->select(
                        'u.number           as id',
                        'u.name             as name',
                        'u.classification   as classification'
                    )
                    ->where([
                        ['gs.groupNumber', '<>', $postData['groupId']],
                        ['u.classification', 'LIKE', '%' . 'student']
                    ])
                    ->where(function ($query) use ($postData){
                        $query->where('u.number', 'LIKE', '%' . $postData['search'] . '%')
                            ->orWhere('u.name', 'LIKE', '%' . $postData['search'] . '%');
                    })
                    ->leftJoin('groupStudents as gs', 'gs.userNumber', '=', 'u.number')
                    ->orderBy('u.number', 'desc')
                    ->get();
                break;

            // 2. 루트의 검색
            // 이름, 학번에 해당 문자가 포감되는지 확인
            // 교사등 모든학생 검색
            // 미구현
//            case 'root':
//                break;

            // 3. 권한 외
            default:
                $users = false;
                break;
        }

        // 반납하는 값
        if ($users) {
            $userArr = array();
            foreach ($users as $user){
                array_push($userArr, array(
                    'id'                => $user->id,
                    'name'              => $user->name,
                    'classification'    => $user->classification
                ));
            }

            $returnValue = array(
                'users' => $userArr,
                'check' => true
            );
        } else {
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 학생 정보수정 root, teacher
    // 미구현
    public function studentModify(Request $request){
        // 요구하는 값
        $postData = array(
            'userId',
            'userName',
            'password',
            'passwordState'
        );

        // 반납하는 값
        $returnValue = array(
            'userName',
            'check'
        );

        return $returnValue;
    }

    // 학생 그룹에서 제외 root, teacher
    // 미구현
    public function studentGroupExchange(Request $request){
        // 요구하는 값
        $postData = array(
            'userId',
            'groupIdBefore',
            'groupIdAfter'
        );

        // 반납하는 값
        $returnValue = array(
            'userId',
            'groupIdBefore',
            'groupIdAfter',
            'check'
        );

        return $returnValue;
    }

    // 교사 임명 root
    // 미구현
    public function teacherEmpowerment(Request $request){
        // 요구하는 값
        $postData = array(
            'userId',
            'classification'
        );

        // 반납하는 값
        $returnValue = array(
            'userId',
            'classification',
            'check'
        );

        return $returnValue;
    }

    // 그룹 담당 교사 변경 root
    // 미구현
    public function teacherGroupExchange(Request $request){
        // 요구하는 값
        $postData = array(
            'groupId',
            'userId'
        );

        // 반납하는 값
        $returnValue = array(
            'groupId',
            'userIdBefore',
            'userIdAfter',
            'check'
        );

        return $returnValue;
    }
}

?>