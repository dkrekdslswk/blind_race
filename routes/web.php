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
Route::get('/mygroup', function(){
    return view('Mygroup/mygroup');
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



/* ↓↓↓↓↓ FOR TEST ↓↓↓↓↓ */

/* CBC : test */
Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});


/* ↓↓↓↓↓ CONTROLLER ↓↓↓↓↓ */

//Route::post('/store',"UserController@store");
Route::post('/mobileLogin',"UserController@mobileLogin");

Route::post('/raceController/createRace','RaceController@createRace');
Route::post('/raceController/teacherIn','RaceController@teacherIn');
//Route::post('/raceController/studentIn','RaceController@studentIn');
//Route::post('/raceController/nickIn','RaceController@nickIn');
//Route::post('/raceController/quizNext','RaceController@quizNext');
//Route::post('/raceController/resultIn','RaceController@resultIn');
//Route::post('/raceController/destroy','RaceController@destroy');

Route::post('/quizTreeController/getfolderLists','QuizTreeController@getfolderLists');
Route::post('/quizTreeController/createFolder'  ,'QuizTreeController@createFolder');
Route::post('/quizTreeController/createList'    ,'QuizTreeController@createList');
Route::post('/quizTreeController/getQuiz'       ,'QuizTreeController@getQuiz');
Route::post('/quizTreeController/insertList'    ,'QuizTreeController@insertList');

//Route::post('/recordBoxController/totalScoreGet','RecordBoxController@totalScoreGet');

?>


