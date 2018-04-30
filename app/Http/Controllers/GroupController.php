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

        // 권한확인, 권한별로 목록 보여주기
        switch ($userData['classification']){
            case 'root':
                break;
            case 'teacher':
                break;
            case 'student':
                break;
        }

        // 반납값 정리
        $returnValue = array(
            'check'             => true,
            'sessionId'         => $request->session()->get('sessionId'),
            'userName'          => $userData['name'],
            'classification'    => $userData['classification']
        );

        return json_encode($returnValue);
    }
}

?>