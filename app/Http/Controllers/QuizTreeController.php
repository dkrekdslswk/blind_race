<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Controllers\UserController;

class QuizTreeController extends Controller
{
    // race create first order
    public function folderRaceDataGet($folderId)
    {
//        $json     = $request->input('post');
//        $json     = json_encode(array('folderId' => null));
//        $postData = json_decode($json);
        $postData = array('folderId' => $folderId == 'null' ? '' : $folderId);

        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                's.session_num  as session_num'])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userData->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId(['user_num' => $userData->user_num],
                    'session_num');
        }else{
            $_SESSION['sessionId'] = $userData->session_num;
        }
        // test

        $folderList = $this->folderGet();

        $raceList = $this->raceGet($postData['folderId'], $userData->user_num);

        $returnValue = array('folderList' => $folderList,
            'raceList' => $raceList,
            'selectFolder' => $postData['folderId']);

//        return $returnValue;
        return view('QuizTree/quiz_list')->with('response', $returnValue);
    }

    public function RaceDataGet($folderId)
    {
//        $json     = $request->input('post');
//        $json     = json_encode(array('folderId' => null));
//        $postData = json_decode($json);
        $postData = array('folderId' => $folderId == 'null' ? '' : $folderId);

        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                's.session_num  as session_num'])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userData->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId(['user_num' => $userData->user_num],
                    'session_num');
        }else{
            $_SESSION['sessionId'] = $userData->session_num;
        }
        // test

        $folderList = $this->folderGet();

        $raceList = $this->raceGet($postData['folderId'], $userData->user_num);

        $returnValue = array('folderList' => $folderList,
            'raceList' => $raceList,
            'selectFolder' => $postData['folderId']);

//        return $returnValue;
        return view('Race/race_list')->with('response', $returnValue);
    }

    public function folderGet(){
        $folderData = DB::table('race_folders as rf')
            ->select('rf.race_folder_num as raceFolderId', 'rf.race_folder_name as raceFolderName')
            ->where('s.session_num', '=', $_SESSION['sessionId'])
            ->join('sessions as s', 's.user_num', '=', 'rf.user_t_num')
            ->get();

        $folderList = array();
        foreach ($folderData as $folder){
            array_push($folderList, array('folderId' => $folder->raceFolderId, 'folderName' => $folder->raceFolderName));
        }

        return $folderList;
    }

    public function postRaceGet(Request $request){
        $postData = array(
            'folderId' => $request->input('folderId')
        );

        $userData = UserController::sessionDataGet($_SESSION['sessionId']);

        return $this->raceGet($postData['folderId'], $userData['userId']);
    }

    public function raceGet($folderId, $userId){
        $data = DB::table('races as r')
            ->select('r.race_num as raceId',
                'r.race_name as raceName',
                DB::raw('COUNT(r.race_num) as quizCount'))
            ->where(['r.user_t_num' => $userId/*,
                'r.race_folder_num' => $folderId*/])
            ->join('race_quizs as rq', 'rq.race_num', '=', 'r.race_num')
            ->groupBy('r.race_num')
            ->orderBy('r.race_num', 'desc')
            ->get();

        $raceDatas = array();
        foreach ($data as $race){
            array_push($raceDatas, array(
                'raceId' => $race->raceId,
                'raceName' => $race->raceName,
                'quizCount' => $race->quizCount));
        }

        return $raceDatas;
    }

    public function createFolder(Request $request){
        $json     = $request->input('post');
//        $json     = json_encode(array('folderName' => '교통사고칠조'));
        $postData = json_decode($json);

        $userData = UserController::sessionDataGet($_SESSION['sessionId']);

        $folderId = DB::table('race_folders')
            ->insertGetId([
                    'race_folder_name' => $postData['folderName'],
                    'user_t_num' => $userData['userId']
                ], 'race_folder_num');

        $folderData = DB::table('race_folders as rf')
            ->select(
                'rf.race_folder_num as raceFolderId',
                'rf.race_folder_name as raceFolderName'
            )
            ->where('s.session_num', '=', $_SESSION['sessionId'])
            ->join('sessions as s', 's.user_num', '=', 'rf.user_t_num')
            ->get();

        $folderList = array();
        foreach ($folderData as $folder){
            array_push($folderList, array(
                'folderId' => $folder->raceFolderId,
                'folderName' => $folder->raceFolderName)
            );
        }

        if (isset($folderId)) {
            $returnValue = array(
                'folderList' => $folderList,
                'raceList' => array(),
                'selectFolder' => $folderId
            );
        }else{
            $returnValue = array('check' => false);
        }

        return $returnValue;
//        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    public function createRace(Request $request){
//        $json     = $request->input('post');
//        $json     = json_encode(array('raceName' => '스스쿠쿠스쿠스쿠',
//            'folderId' => null));
//        $postData = json_decode($json);
        $postData = array(
            'raceName' => $request->input('raceName'),
            'folderId' => $request->input('folderId')
        );

        // test 임시로 유저 세션 부여
        $userDataUp = DB::table('users as u')
            ->select([
                'u.user_num as user_num',
                's.session_num  as session_num'
            ])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userDataUp->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId([
                    'user_num' => $userDataUp->user_num
                ], 'session_num');
        }else{
            $_SESSION['sessionId'] = $userDataUp->session_num;
        }
        // test

        $userData = UserController::sessionDataGet($_SESSION['sessionId']);

        $raceId = DB::table('races')
            ->insertGetId([
                'race_name' => $postData['raceName'],
                'race_folder_num' => $postData['folderId'],
                'user_t_num' => $userData['userId']
            ], 'race_num');

        $bookList = $this->getBookGet();

        if (isset($raceId)) {
            $returnValue = array(
                'raceId' => $raceId,
                'raceName' => $postData['raceName'],
                'bookList' => $bookList,
                'check' => true
            );
        }else{
            $returnValue = array('check' => false);
        }

//        return $returnValue;
        return view('QuizTree/quiz_making')->with('response', $returnValue);
    }

    public function getBookGet(){

        $bookData = DB::table('books')
            ->select(
                'book_num',
                'book_name',
                'book_page_max',
                'book_page_min'
            )
            ->orderBy('book_name')
            ->get();

        $bookList = array();

        foreach ($bookData as $book){
            array_push($bookList, array(
                'bookId' => $book->book_num,
                'bookName' => $book->book_name,
                'pageMax' => $book->book_page_max,
                'pageMin' => $book->book_page_min
            ));
        }

        return $bookList;
//        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    public function getQuiz(Request $request){
//        $json     = $request->all();
//        $json     = json_encode(array(
//            'bookId' => $request->input('bookId'),
//            'pageStart' => $request->input('pageStart'),
//            'pageEnd' => $request->input('pageEnd'),
//            'type' => $request->input('type'),
//            'level' => $request->input('level')));
        $postData = array(
            'bookId' => $request->input('bookId'),
            'pageStart' => $request->input('pageStart'),
            'pageEnd' => $request->input('pageEnd'),
            'type' => $request->input('type'),
            'level' => $request->input('level')
        );

        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                's.session_num  as session_num'])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userData->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId(['user_num' => $userData->user_num],
                    'session_num');
        }else{
            $_SESSION['sessionId'] = $userData->session_num;
        }
        // test
        $userData = UserController::sessionDataGet($_SESSION['sessionId']);

        $quizList = array();

        if($userData['tCheck'] == 't') {
            $quizData = DB::table('quiz_bank')
                ->select(
                    'quiz_num as quizId',
                    'book_num as bookId',
                    'book_page as page',
                    'quiz_question as question',
                    'quiz_right_answer as right',
                    'quiz_example1 as example1',
                    'quiz_example2 as example2',
                    'quiz_example3 as example3',
                    'quiz_type as type',
                    'quiz_level as level'
                )
                ->where([
                    'book_num' => $postData['bookId'],
                    'quiz_type' => $postData['type'],
                    'quiz_level' => $postData['level']
                ])
                ->where('book_page', '>=', $postData['pageStart'])
                ->where('book_page', '<=', $postData['pageEnd'])
                ->get();

            foreach ($quizData as $quiz) {
                array_push($quizList, array(
                    'quizId' => $quiz->quizId,
                    'bookId' => $quiz->bookId,
                    'page' => $quiz->page,
                    'question' => $quiz->question,
                    'right' => $quiz->right,
                    'example1' => $quiz->example1,
                    'example2' => $quiz->example2,
                    'example3' => $quiz->example3,
                    'type' => $quiz->type,
                    'level' => $quiz->level
                ));
            }
        }

        if (count($quizList) > 0) {
            $returnValue = array(
                'raceId' => $quizList,
                'check' => true
            );
        }else{
            $returnValue = array(
                'check' => false
            );
        }

        return response()->json($returnValue);
//        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    public function insertRace(Request $request){
//        $json     = json_encode(array(
//            'raceId' => 9,
//            'quizList' => array(
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'o'
//                ],
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'o'
//                ])
//            )
//        );
        $postData = array(
            'raceId' => $request->input('raceId'),
            'quizList' => $request->input('quizList')
        );

        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select(['u.user_num   as user_num',
                's.session_num  as session_num'])
            ->where('u.user_id', '=', 'tamp1id')
            ->leftJoin('sessions as s', 's.user_num', '=', 'u.user_num')
            ->first();

        if(!isset($userData->session_num)){
            $_SESSION['sessionId'] = DB::table('sessions')
                ->insertGetId(['user_num' => $userData->user_num],
                    'session_num');
        }else{
            $_SESSION['sessionId'] = $userData->session_num;
        }
        // test
        $userData = UserController::sessionDataGet($_SESSION['sessionId']);

        $insertCount = 0;
        foreach($postData['quizList'] as $quiz){
            $quizId = DB::table('quiz_bank')
                ->insertGetId([
                    'quiz_question'     => $quiz['question'],
                    'quiz_right_answer' => $quiz['right'],
                    'quiz_example1'     => $quiz['example1'],
                    'quiz_example2'     => $quiz['example2'],
                    'quiz_example3'     => $quiz['example3'],
                    'quiz_type'         => $quiz['type'],
                    'user_t_num'        => $userData['userId']
                ], 'quiz_num');

            $insertCheck = DB::table('race_quizs')
                ->insert([
                    'race_num' => $postData['raceId'],
                    'quiz_num' => $quizId
                ]);
            if(!is_null($insertCheck)) {
                $insertCount++;
            }
        }
        if($insertCount > 0){
            $returnValue = array(
                'check' => true,
                'insertCount' => $insertCount
            );
        }
        else{
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
//        return view('race/race_waitingroom')->with('json', response()->json($returnValue));
    }

    /*public function deleteRace(Request $request){
        $postData = array(
            'raceId' => $request->input('raceId')
        );

        $rowCount = DB::table('races')
            ->where()
            ->delete();

        return $returnValue;
    }*/

    public function showQuiz(Request $request){
        $postData = array(
            'raceId' => $request->input('raceId')
        );

        $quiz_data = DB::table('race_quizs as rq')
            ->select(
                'qb.quiz_question as question',
                'qb.quiz_right_answer as right',
                'qb.quiz_example1 as example1',
                'qb.quiz_example2 as example2',
                'qb.quiz_example3 as example3',
                'qb.quiz_type as type'
            )
            ->where('rq.race_num', '=', $postData{'raceId'})
            ->join('quiz_bank as qb', 'qb.quiz_num', '=', 'rq.quiz_num')
            ->orderBy('qb.quiz_num')
            ->get();

        $returnValue = array();
        foreach ($quiz_data as $data){
            array_push($returnValue, array(
                'name' => $data->question,
                'answer1' => $data->right,
                'answer2' => $data->example1,
                'answer3' => $data->example2,
                'answer4' => $data->example3,
                'type' => $data->type
            ));
        }

        return array('quizList' => $returnValue);
    }
}