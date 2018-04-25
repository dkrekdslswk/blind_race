<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use App\Http\Controllers\UserController;

class QuizTreeController extends Controller
{
    // 공개된 레이스의 숫자 및 가상 폴더의 번호
    private $openFolderId = 0;

    // 폴더목록과 선택된 폴더의 리스트 목록을 반납
    public function getfolderLists(Request $request)
    {
        // 들어올 정보
//        $postData = array('folderId' => 'base');
        $postData = array('folderId' => $request->post('folderId'));

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

        // 유저의 폴더 정보 가져오기
        $folders = $this->getFolders($request->session()->get('sessionId'));

        // 요구하는 폴더가 없을경우 기본 폴더를 가져옴
        if ($postData['folderId'] == 'base'){
            $selectFolderId = $folders[0]['folderId'];
        }
        else{
            $selectFolderId = $postData['folderId'];
        }

        // 호출된 폴더의 리스트 정보 가져오기
        $lists = $this->getLists($selectFolderId, $request->session()->get('sessionId'));

        // 반납할 데이터 정리
        $returnValue = array(
            'folders'    => $folders,
            'lists'      => $lists,
            'selectFolder'  => $selectFolderId,
            'check'         => true
        );

        return $returnValue;
    }

    // 폴더목록 가져오기
    private function getFolders($sessionId){
        // 폴더목록 가져오기
        $folderData = DB::table('folders as f')
            ->select(
                'f.number as folderId',
                'f.name as folderName'
            )
            ->where('s.number', '=', $sessionId)
            ->join('sessionDatas as s', 's.userNumber', '=', 'f.teacherNumber')
            ->orderBy('f.number')
            ->get();

        // 최초 접속시 폴더 정보가 없는 사람의 경우 base 폴더 생성
        if (count($folderData) == 0){
            // 선생 아이디 가져오기
            $teacher = DB::table('users as u')
                ->select(
                    'u.number as userId'
                )
                ->where([
                    'u.classifications' => ['teacher', 'root'],
                    's.number'          => $sessionId
                ])
                ->join('sessionDatas as s', 's.userNumber', '=', 'u.number')
                ->first();

            // base 폴더 만들기
            DB::table('folders')
                ->insert([
                    'teacherNumber' => $teacher->userId,
                    'name'          => 'base'
                ]);

            // 다시 폴더목록 가져오기
            $folderData = DB::table('folders as f')
                ->select(
                    'f.number   as folderId',
                    'f.name     as folderName'
                )
                ->where('s.number', '=', $sessionId)
                ->join('sessionDatas as s', 's.userNumber', '=', 'f.teacherNumber')
                ->orderBy('f.number')
                ->get();
        }

        // 가져온 폴더 정보를 정리하기
        $folders = array();
        foreach ($folderData as $folder){
            array_push($folders, array(
                'folderId' => $folder->folderId,
                'folderName' => $folder->folderName)
            );
        }

        // 공개된 리스트 정보를 불러올 폴더 설정
        array_push($folders, array(
                'folderId' => $this->openFolderId,
                'folderName' => '공개 리스트')
        );

        return $folders;
    }

    // 리스트 목록 가져오기
    private function getLists($selectFolderId, $sessionId){
        // 공개된 리스트 목록 가져오기
        if ($selectFolderId == $this->openFolderId){
            $data = DB::table('lists as l')
                ->select(
                    'l.number                       as listId',
                    'l.name                         as listName',
                    DB::raw('COUNT(lq.quizNumber)   as quizCount')
                )
                ->where([
                    'l.openState' => $this->openFolderId
                ])
                ->join('listQuizs as lq', 'lq.listNumber', '=', 'l.number')
                ->groupBy('l.number')
                ->orderBy('l.number', 'desc')
                ->get();
        }
        // 선택된 리스트 목록 가져오기
        else {
            $data = DB::table('lists as l')
                ->select(
                    'l.number                       as listId',
                    'l.name                         as listName',
                    DB::raw('COUNT(lq.quizNumber)   as quizCount')
                )
                ->where([
                    's.number' => $sessionId,
                    'l.folderNumber' => $selectFolderId
                ])
                ->join('listQuizs as lq',   'lq.listNumber',    '=', 'l.number')
                ->join('folders as f',      'f.number',         '=', 'l.folderNumber')
                ->join('sessionDatas as s', 's.userNumber',     '=', 'f.teacherNumber')
                ->groupBy('l.number')
                ->orderBy('l.number', 'desc')
                ->get();
        }

        // 반납할 데이터 정리
        $lists = array();
        foreach ($data as $list){
            array_push($lists, array(
                'listId'    => $list->listId,
                'listName'  => $list->listName,
                'quizCount' => $list->quizCount));
        }

        return $lists;
    }

    // 리스트 폴더 만들기
    public function createFolder(Request $request){
        // 보내진 값 받기
//        $json     = $request->input('post');
        $json     = json_encode(array('folderName' => '교통사고칠조'));
        $postData = json_decode($json);

        // 로그인 되어있는 유저의 정보 가져오기
        $userData = UserController::sessionDataGet($request->session()->get('sessionId'));

        // 폴더를 생성
        $folderId = DB::table('folders')
            ->insertGetId([
                    'name'          => $postData['folderName'],
                    'teacherNumber' => $userData['userId']
                ], 'number');

        // 선체 폴더를 다시 받기
        $folders = $this->getFolders($request->session()->get('sessionId'));

        // 반납할 값을 정리
        if (isset($folderId)) {
            $returnValue = array(
                'folders'    => $folders,
                'lists'      => array(),
                'selectFolder'  => $folderId,
                'check'         => true
            );
        }else{
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 리스트 만들기
    public function createList(Request $request){
//        $postData = array(
//            'listName' => '테스트 리스트명2',
//            'folderId' => 1
//        );
        $postData = array(
            'listName' => $request->input('listName'),
            'folderId' => $request->input('folderId')
        );

        // 유저가 선생인지 확인하고 선생이 아니면 강퇴
        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select([
                'u.number   as userId',
                's.number   as sessionId'
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

        // 리스트 만들기
        $listId = DB::table('lists')
            ->insertGetId([
                'name'          => $postData['listName'],
                'folderNumber'  => $postData['folderId']
            ], 'number');

        // 저장된 교재 정보 가져오기
        $bookList = $this->getBookGet();

        // 반납할 값 반납
        if (isset($listId)) {
            $returnValue = array(
                'listId' => $listId,
                'listName' => $postData['listName'],
                'bookList' => $bookList,
                'check' => true
            );
        }else{
            $returnValue = array(
                'check' => false
            );
        }

//        return $returnValue;
        return view('QuizTree/quiz_making')->with('response', $returnValue);
    }

    // 교재목록 가져오기
    private function getBookGet(){

        // 교재목록 검색
        $bookData = DB::table('books')
            ->select(
                'number',
                'name',
                'maxPage',
                'minPage'
            )
            ->orderBy('name')
            ->get();

        // 반납할 값 정리
        $bookList = array();
        foreach ($bookData as $book){
            array_push($bookList, array(
                'bookId' => $book->number,
                'bookName' => $book->name,
                'pageMax' => $book->maxPage,
                'pageMin' => $book->minPage
            ));
        }

        return $bookList;
    }

    // 문제 검색하기
    public function getQuiz(Request $request){
//        $postData     = array(
//            'bookId'        => 2,
//            'pageStart'     => 17,
//            'pageEnd'       => 20,
//            'makeType'      => 'grammar',
//            'quizType'      => 'obj',
//            'level'         => 1
//        );
        $postData = array(
            'bookId'    => $request->input('bookId'),
            'pageStart' => $request->input('pageStart'),
            'pageEnd'   => $request->input('pageEnd'),
            'makeType'      => $request->input('makeType'),
            'quizType'      => $request->input('quizType'),
            'level'     => $request->input('level')
        );

        // 유저가 선생인지 확인하고 선생이 아니면 강퇴
        // test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select([
                'u.number   as userId',
                's.number   as sessionId'
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

        $quizList = array();
        if($userData['classification'] == 'teacher' || $userData['classification'] == 'root') {
            $quizData = DB::table('quizBanks')
                ->select(
                    'number         as quizId',
                    'bookNumber     as bookId',
                    'page           as page',
                    'question       as question',
                    'hint           as hint',
                    'rightAnswer    as right',
                    'example1       as example1',
                    'example2       as example2',
                    'example3       as example3',
                    'type           as type',
                    'level          as level'
                )
                ->where([
                    'bookNumber'    => $postData['bookId'],
                    'type'          => $postData['quizType'].' '.$postData['makeType'],
                    'level'         => $postData['level']
                ])
                ->where('page', '>=', $postData['pageStart'])
                ->where('page', '<=', $postData['pageEnd'])
                ->get();

            foreach ($quizData as $quiz) {
                $type = explode(' ', $quiz->type);

                array_push($quizList, array(
                    'quizId'    => $quiz->quizId,
                    'bookId'    => $quiz->bookId,
                    'page'      => $quiz->page,
                    'question'  => $quiz->question,
                    'hint'      => $quiz->hint,
                    'right'     => $quiz->right,
                    'example1'  => $quiz->example1,
                    'example2'  => $quiz->example2,
                    'example3'  => $quiz->example3,
                    'makeType'  => $type[0],
                    'quizType'  => $type[1],
                    'level'     => $quiz->level
                ));
            }
        }

        if (count($quizList) > 0) {
            $returnValue = array(
                'listId' => $quizList,
                'check' => true
            );
        }else{
            $returnValue = array(
                'check' => false
            );
        }

        return $returnValue;
    }

    // 만든 리스트 저장하기
    public function insertList(Request $request){
//        $postData     = array(
//            'listId' => 9,
//            'quizs' => array(
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'hint' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'vocabulary obj'
//                ],
//                [
//                    'question' => '1',
//                    'right' => '1',
//                    'hint' => '1',
//                    'example1' => '2',
//                    'example2' => '3',
//                    'example3' => '4',
//                    'type' => 'vocabulary obj'
//                ]
//            )
//        );
        $postData = array(
            'listId' => $request->input('listId'),
            'quizs' => $request->input('quizs')
        );
//
//         유저가 선생인지 확인하고 선생이 아니면 강퇴
//         test 임시로 유저 세션 부여
        $userData = DB::table('users as u')
            ->select([
                'u.number   as userId',
                's.number   as sessionId'
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

        // 입력 실패한 문제의 배열상 위치를 반납
        $errorQuiz = array();

        // 해당유저의 리스트인지 확인
        $listUserCheck = DB::table('lists as l')
            ->select('l.number as listId')
            ->where([
                'f.teacherNumber'   => $userData['userId'],
                'l.number'          => $postData['listId']
            ])
            ->join('folders as f', 'f.number', '=', 'l.folderNumber')
            ->first();

        if(isset($listUserCheck->listId)) {
            foreach ($postData['quizs'] as $quiz) {
                // 정규표현식으로 확인
                if (preg_match('[@#]', $quiz['right']) ||
                    preg_match('[@#]', $quiz['example1']) ||
                    preg_match('[@#]', $quiz['example2']) ||
                    preg_match('[@#]', $quiz['example3'])){

                    $insertCheck = null;
                } else {
                        // 문제를 저장
                        $quizId = DB::table('quizBanks')
                            ->insertGetId([
                                'question' => $quiz['question'],
                                'hint' => $quiz['hint'],
                                'rightAnswer' => $quiz['right'],
                                'example1' => $quiz['example1'],
                                'example2' => $quiz['example2'],
                                'example3' => $quiz['example3'],
                                'type' => $quiz['makeType'] . ' ' . $quiz['quizType'],
                                'teacherNumber' => $userData['userId']
                            ], 'number');

                        // 리스트에 문제를 연결
                        $insertCheck = DB::table('listQuizs')
                            ->insert([
                                'listNumber' => $postData['listId'],
                                'quizNumber' => $quizId
                            ]);
                    }

                // 입력 실패한 문제를 반납
                if (is_null($insertCheck)) {
                    array_push($errorQuiz, $quiz);
                }
            }
        }

        // 반납 값 정리
        // 1문제 이상이 입력 성공시
        if(count($errorQuiz) == 0){
            $returnValue = array(
                'check' => true
            );
        }
        // 1문제도 입력 안되었을 경우
        else{
            $returnValue = array(
                'check' => false,
                'errorQuiz' => $errorQuiz
            );
        }

        return $returnValue;
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

    /*public function getRaceQuiz(Request $request){
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

        return array('raceList' => $returnValue);
    }*/
}