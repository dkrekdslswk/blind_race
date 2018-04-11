<?php
namespace app\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class RecordBoxController extends Controller{
    public function user_login(Request $request){
        $user_id = $request->input('ID');
        $password = $request->input('PW');

        $data = DB::select('select user_num from users where user_id=? and user_password=?', [$user_id,$password])->first();

        $_SESSION['sessionId'] = $this->sessionIdGet($data->user_num);
        return view('homepage');
    }
}

?>