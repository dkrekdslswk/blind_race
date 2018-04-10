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

       $data = DB::select('select user_num from users where user_id=? and user_password=?', [$user_id,$password]);
        $user_num = $data[0]->user_num;

       if(count($data)){
           session(['connect_num' => $user_num]);
           return view('homepage');
       }else{
           echo "login failed";

       }
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