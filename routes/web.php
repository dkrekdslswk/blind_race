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

/* 4-2. Record Box : Record List */
Route::get('/recordbox_student', function(){
    return view('Recordbox/recordbox_student_main');
});





/* ↓↓↓↓↓ FOR TEST ↓↓↓↓↓ */

/* CBC : test */
Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});


/* ↓↓↓↓↓ CONTROLLER ↓↓↓↓↓ */

//Route::post('/store',"UserController@store");
Route::post('/mobileLogin',"UserController@mobileLogin");
Route::post('/userController/webLogin',"UserController@webLogin");

Route::post('/raceController/createRace','RaceController@createRace');
Route::post('/raceController/studentIn','RaceController@studentIn');
Route::post('/raceController/studentSet','RaceController@studentSet');
Route::post('/raceController/quizNext','RaceController@quizNext');
Route::post('/raceController/answerIn','RaceController@answerIn');
Route::post('/raceController/result','RaceController@result');
Route::post('/raceController/raceEnd','RaceController@raceEnd');
Route::post('/raceController/showList','RaceController@getRetestListWeb');

Route::post('/quizTreeController/getfolderLists','QuizTreeController@getfolderLists');
Route::post('/quizTreeController/createFolder'  ,'QuizTreeController@createFolder');
Route::post('/quizTreeController/createList'    ,'QuizTreeController@createList');
Route::post('/quizTreeController/getQuiz'       ,'QuizTreeController@getQuiz');
Route::post('/quizTreeController/insertList'    ,'QuizTreeController@insertList');
Route::post('/quizTreeController/deleteList'    ,'QuizTreeController@deleteList');
Route::post('/quizTreeController/updateList'    ,'QuizTreeController@updateList');
Route::post('/quizTreeController/showList'    ,'QuizTreeController@showList');

Route::post('/recordBoxController/getChart','RecordBoxController@getChart');
Route::post('/recordBoxController/getRaces','RecordBoxController@getRaces');
Route::post('/recordBoxController/homeworkCheck','RecordBoxController@homeworkCheck');
Route::post('/recordBoxController/getStudents','RecordBoxController@getStudents');
Route::post('/recordBoxController/getWrongs','RecordBoxController@getWrongs');

Route::post('/groupController/groupsGet','GroupController@groupsGet');
Route::post('/groupController/groupDataGet','GroupController@groupDataGet');
Route::post('/groupController/createGroup','GroupController@createGroup');
Route::post('/groupController/pushInvitation','GroupController@pushInvitation');
Route::post('/groupController/selectUser','GroupController@selectUser');
Route::post('/groupController/studentModify','GroupController@studentModify');
Route::post('/groupController/studentGroupExchange','GroupController@studentGroupExchange');
?>


