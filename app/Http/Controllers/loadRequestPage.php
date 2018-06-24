<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-06-24
 * Time: 오후 3:50
 */

namespace app\Http\Controllers;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;

class loadRequestPage extends GroupController {

    public function requestPage(Request $request){

        $groupList = $this->groupsGet($request);
        $url = "recordbox/chart/".$groupList;

        echo "<script>window.location.href(".$url.")";

    }

}


?>