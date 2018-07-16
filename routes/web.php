<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ↓↓↓↓↓ ROUTE VIEW ↓↓↓↓↓ */

/* Homepage : Main */
Route::get('/', function () {
    return view('homepage');
});

/* Login */
Route::get('/login', function () {
    return view('Login/login');
});

/* 1. My Group */
Route::get('/mygroup2', function(){
    return view('Mygroup/mygroup');
});

Route::get('/myside', function(){
    return view('Mygroup/mygroup_sidebar');
});

Route::get('/mygroup', function(){
    return view('Mygroup/mygroup_main');
});

Route::get('/Unregistered_group', function(){
    return view('Mygroup/Unregistered_group');
});

Route::get('/mygroup_Unregistered_group', function(){
    return view('Mygroup/mygroup_Unregistered_group');
});


/* 2. Race Mode : Blind Race */
Route::get('/race_list', function(){
    return view('Race/race_list');
});

/* 2-1. Blind Race : Waiting Room */
Route::get('/race_waiting', function(){
    return view('Race/race_waiting');
});

/* 2-1. Blind Race : Waiting Room */
Route::get('/mid_result', function(){
    return view('Race/mid_result');
});


/* 2-3. Blind Race : Race Result */
Route::get('/race_result', function(){
    return view('Race/race_result');
});

/* 2-4 Blind Race : Race_student  -> 학생 웹 레이스 부분 */
Route::get('/race_student', function(){
    return view('Race/race_student');
});
/* 2-5 Blind Race : Race_retest  -> 학생 웹 재시험 부분 */
Route::get('/race_retest', function(){
    return view('Race/race_retest');
});
/* 2-6 Blind Race : Race_popquiz  -> 교사 쪽지시험 부분 */
Route::get('/race_popquiz', function(){
    return view('Race/race_popquiz');
});

/* 2-7 Blind Race : Race_popquiz  -> 학생 웹 쪽지시험 */
Route::get('/race_student_popquiz', function(){
    return view('Race/race_student_popquiz');
});

/* 3. Quiz Tree : Quiz List */
Route::get('/quiz_list', function(){
    return view('QuizTree/quiz_list');
});

/* 3-1. Quiz Tree : Quiz Making */
Route::get('/quiz_making', function(){
    return view('QuizTree/quiz_making');
});

/* 4. Record Box : Record List */
Route::get('/recordbox', function(){
    return view('Recordbox/recordbox_main');
});

/* 4-1. Record Box : test */
Route::get('/recordbox_main', function(){
    return view('Recordbox/recordbox_main');
});

/* 4-1. Record Box : test */
Route::get('/recordbox/sidebar', function(){
    return view('Recordbox/sidebar');
});

/* 4-1. Record Box : test */
Route::get('/recordbox_main/sidebar', function(){
    return view('Recordbox/sidebar');
});

/* 4-2. Record Box : Record List */
Route::get('/recordbox_student', function(){
    return view('Recordbox/recordbox_student_main');
});

/* 4-3. student: student_homepage */
Route::get('/student', function(){
    return view('homepage_studnet');
});

/* 4-3. student: student_homepage */
Route::get('/recordbox/{where}/{groupId?}/{country?}', function($where,$groupId = null,$country = null){

    if ($country != "kr" && $country != null && $country != "jp") {
        $where = "error";
    }else{
        $language = array();

        switch ($country){
        /*
        $language['modal']['Title']['']
        $language['modal']['Date']['']
        $language['modal']['Grade']['']
        $language['modal']['Feedback']['']
        */
            case null :
            case "kr" :
                $language['modal'] = ["Title" => array('allStudentGrade' => '학생 점수',
                                                    'allStudent' => '전체 학생',
                                                    'detail' => '상세 보기',
                                                    'feedback' => '피드백',
                                                    'wrongTest' => '오답 문제'),
                                    "Subtitle" => array("number" => "번호",
                                                    "quizName" => "퀴즈 제목",
                                                    "date" => "날짜",
                                                    "grade" => "성적표",
                                                    "homework" => "과제 확인하기",
                                                    "date" => "작성일자",
                                                    "title" => "제목",
                                                    "state" => "상태"),
                                    "Date" => array('year' => "년" ,
                                                    'month' => '월' ,
                                                    'date' =>'일' ),
                                    "Grade" => array('allStudent' => "전체학생",
                                                    'allGrade' => "총점수",
                                                    'totalVoca' => "어휘",
                                                    'totalGrammer' => "독해",
                                                    'totalWord' => "문법",
                                                    'allCount' => "갯수",
                                                    'allAverage' => "전체 평균",
                                                    'noWrongData' => "오답 내용이 없습니다."),
                                    "Feedback" => array('file'=>'파일 첨부',
                                                        'alert'=>'정상 등록되었습니다.',
                                                        'questionDate' => '질문 날짜',
                                                        'feedbackDate' => '대답 날짜',
                                                        'ok'=>'확인',
                                                        'cancel'=>'취소')
                ];

                $language['chart'] = ["statistics" => "統計",
                                        "history" => "最近 記録",
                                        "student" => "生徒の情報",
                                        "feedback" => "フィードバック"
                ];

                $language['recordnav'] = ["statistics" => "통계",
                                          "history" => "최근 기록",
                                          "student" => "학생 관리",
                                          "feedback" => "피드백"
                ];

                break;

            case "jp" :
                $language['modal'] = ["Title" => array('allStudentGrade' => '成績表',
                                                    'allStudent' => '学生 全員',
                                                    'detail' => '詳録',
                                                    'feedback' => 'Feedback',
                                                    'wrongTest' => '間違った問題')
                                                    ,
                                        "Subtitle" => array("number" => "번호",
                                                        "quizName" => "퀴즈 제목",
                                                        "date" => "날짜",
                                                        "grade" => "성적표",
                                                        "homework" => "과제 확인하기",
                                                        "date" => "작성일자",
                                                        "title" => "제목",
                                                        "state" => "상태")
                                                        ,
                                        "Date" => array('year' => "年" ,
                                                        'month' => '月' ,
                                                        'date' =>'日' )
                                                        ,
                                        "Grade" => array('allStudent' => "学生全員",
                                                        'allGrade' => "総点",
                                                        'totalVoca' => "語彙",
                                                        'totalGrammer' => "文法",
                                                        'totalWord' => "読解",
                                                        'allCount' => "本数",
                                                        'allAverage' => "全員の平均",
                                                        'noWrongData' => "内容がありません")
                                                        ,
                                        "Feedback" => array('file'=>'添付ファイル',
                                                        'alert'=>'登録しました',
                                                        'questionDate' => '質問 日付',
                                                        'feedbackDate' => '反問 日付',
                                                        'ok'=>'OK',
                                                        'cancel'=>'Cancel')
                ];

                $language['recordnav'] = ["statistics" => "統計",
                                          "history" => "最近 記録",
                                          "student" => "生徒の情報",
                                          "feedback" => "フィードバック"
                ];

                $language['recordnav'] = ["statistics" => "統計",
                                          "history" => "最近 記録",
                                          "student" => "生徒の情報",
                                          "feedback" => "フィードバック"
                ];
            break;
        }
    }

    switch ($where){
        case "chart":
        case "history":
        case "students":
        case "feedback":
            return view('Recordbox/recordbox_history' , ['where' => $where ,'groupId'=>$groupId , 'country' => $country,'language' => $language]);
            break;

        default:
            return view('sorry');
            break;
    }
});




/* ↓↓↓↓↓ FOR TEST ↓↓↓↓↓ */

/* CBC : test */
Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});

Route::get('/race_content', function(){
    return view('Race/race_content');
});


/* ↓↓↓↓↓ CONTROLLER ↓↓↓↓↓ */

/*
 * 로그인 컨트롤러
 */
// 웹용
Route::post('/userController/loginCheck',"UserController@loginCheck");
Route::post('/userController/webLogin',"UserController@webLogin");
Route::post('/userController/webLogout',"UserController@webLogout");
Route::post('/userController/userUpdate',"UserController@userUpdate");
// 모바일용
Route::post('/mobileLogin',"UserController@mobileLogin");
Route::post('/mobileLogout',"UserController@mobileLogout");

/*
 * 레이스 컨트롤러
 */
// 웹용
Route::post('/raceController/createRace','RaceController@createRace');
Route::post('/raceController/studentIn','RaceController@studentIn');
Route::post('/raceController/studentOut','RaceController@studentOut');
Route::post('/raceController/studentSet','RaceController@studentSet');
Route::post('/raceController/quizNext','RaceController@quizNext');
Route::post('/raceController/answerIn','RaceController@answerIn');
Route::post('/raceController/result','RaceController@result');
Route::post('/raceController/raceEnd','RaceController@raceEnd');

Route::post('/raceController/getRetestListWeb','RaceController@getRetestListWeb');

Route::post('/raceController/retestSet','RaceController@retestSet');
// 모바일, 웹 겸용
Route::post('/raceController/retestStart','RaceController@retestStart');
Route::post('/raceController/retestAnswerIn','RaceController@retestAnswerIn');
Route::post('/raceController/retestEnd','RaceController@retestEnd');
// 모바일용
Route::post('/getRetestListMobile','RaceController@getRetestListMobile');

/*
 * 문제나무 컨트롤러
 */
// 웹용
Route::post('/quizTreeController/getfolderLists','QuizTreeController@getfolderLists');
Route::post('/quizTreeController/createFolder'  ,'QuizTreeController@createFolder');
Route::post('/quizTreeController/createList'    ,'QuizTreeController@createList');
Route::post('/quizTreeController/getQuiz'       ,'QuizTreeController@getQuiz');
Route::post('/quizTreeController/insertList'    ,'QuizTreeController@insertList');
Route::post('/quizTreeController/deleteList'    ,'QuizTreeController@deleteList');
Route::post('/quizTreeController/updateList'    ,'QuizTreeController@updateList');
Route::post('/quizTreeController/showList'    ,'QuizTreeController@showList');
Route::post('/quizTreeController/updateOpenState'    ,'QuizTreeController@updateOpenState');

/*
 * 레코드박스 컨트롤러
 */
// 웹용
Route::post('/recordBoxController/getChart','RecordBoxController@getChart');
Route::post('/recordBoxController/getRaces','RecordBoxController@getRaces');
Route::post('/recordBoxController/homeworkCheck','RecordBoxController@homeworkCheck');
Route::post('/recordBoxController/getStudents','RecordBoxController@getStudents');
Route::post('/recordBoxController/getWrongs','RecordBoxController@getWrongs');
Route::post('/recordBoxController/insertWrongs','RecordBoxController@insertWrongs');
Route::post('/recordBoxController/insertQuestion','RecordBoxController@insertQuestion');
Route::post('/recordBoxController/selectQnAs','RecordBoxController@selectQnAs');
Route::post('/recordBoxController/selectQnA','RecordBoxController@selectQnA');
Route::post('/recordBoxController/updateAnswer','RecordBoxController@updateAnswer');
// 모바일용
Route::post('/mobileGetStudents','RecordBoxController@mobileGetStudents');
Route::post('/mobileGetWrongs','RecordBoxController@mobileGetWrongs');
Route::post('/mobileInsertWrongs','RecordBoxController@mobileInsertWrongs');
Route::post('/mobileInsertQuestion','RecordBoxController@mobileInsertQuestion');
Route::post('/mobileSelectQnAs','RecordBoxController@mobileSelectQnAs');
Route::post('/mobileSelectQnA','RecordBoxController@mobileSelectQnA');
Route::post('/mobileUpdateAnswer','RecordBoxController@mobileUpdateAnswer');


/*
 * 그룹 컨트롤러
 */
// 웹용
Route::post('/groupController/groupsGet','GroupController@groupsGet');
Route::post('/groupController/groupDataGet','GroupController@groupDataGet');
Route::post('/groupController/createGroup','GroupController@createGroup');
Route::post('/groupController/pushInvitation','GroupController@pushInvitation');
Route::post('/groupController/selectUser','GroupController@selectUser');
Route::post('/groupController/studentModify','GroupController@studentModify');
Route::post('/groupController/studentGroupExchange','GroupController@studentGroupExchange');
Route::post('/groupController/studentGroupsGet','GroupController@studentGroupsGet');
// 모바일용
Route::post('/mobileStudentGroupsGet','GroupController@mobileStudentGroupsGet');
?>


