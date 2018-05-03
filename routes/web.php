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
    return view('Recordbox/recordbox');
});

/* 4-1. Record Box : Feedback */
Route::get('/feedback', function(){
    return view('Recordbox/feedback');
});

/* 4-2. Record Box : test */
Route::get('/test', function(){
    return view('Recordbox/test');
});

/* 4-2. Record Box : test */
Route::get('/test_sidebar', function(){
    return view('Recordbox/test_sidebar');
});

/* 4-2. Record Box : test */
Route::get('/test_record', function(){
    return view('Recordbox/test_record');
});

/* 4-2. Record Box : test */
Route::get('/recordbox_main', function(){
    return view('Recordbox/recordbox_main');
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

Route::post('/quizTreeController/getfolderLists','QuizTreeController@getfolderLists');
Route::post('/quizTreeController/createFolder'  ,'QuizTreeController@createFolder');
Route::post('/quizTreeController/createList'    ,'QuizTreeController@createList');
Route::post('/quizTreeController/getQuiz'       ,'QuizTreeController@getQuiz');
Route::post('/quizTreeController/insertList'    ,'QuizTreeController@insertList');

//Route::post('/recordBoxController/totalScoreGet','RecordBoxController@totalScoreGet');

Route::post('/GroupController/groupsGet','GroupController@groupsGet');
Route::post('/GroupController/selectUser','GroupController@selectUser');

?>


