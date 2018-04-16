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

/* 2. Race Mode : Golden Bell */
/* 2. Race Mode : Raid */
Route::get('/raid', function(){
    return view('Raid/raid');
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

Route::get('/feedback', function(){
    return view('Recordbox/feedback');
});


/* ↓↓↓↓↓ FOR TEST ↓↓↓↓↓ */

/* CBC : test */
Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});


/* ↓↓↓↓↓ CONTROLLER ↓↓↓↓↓ */

Route::post('/store',"UserController@store");
Route::post('/user_login',"UserController@user_login");

Route::get('/raceController/RaceDataGet/{folderId}','QuizTreeController@RaceDataGet');

Route::post('/raceController/create','RaceController@create');
Route::post('/raceController/teacherIn','RaceController@teacherIn');
Route::post('/raceController/studentIn','RaceController@studentIn');
Route::post('/raceController/nickIn','RaceController@nickIn');
Route::post('/raceController/quizNext','RaceController@quizNext');
//Route::post('/raceController/resultIn','RaceController@resultIn');
//Route::post('/raceController/destroy','RaceController@destroy');


Route::get('/quizTreeController/folderRaceDataGet/{folderId}','QuizTreeController@folderRaceDataGet');
Route::post('/quizTreeController/createRace','QuizTreeController@createRace');
Route::post('/quizTreeController/getQuiz','QuizTreeController@getQuiz');
Route::post('/quizTreeController/insertRace','QuizTreeController@insertRace');
Route::post('/quizTreeController/postRaceGet','QuizTreeController@postRaceGet');

Route::post('/recordBoxController/totalScoreGet','RecordBoxController@totalScoreGet');

?>


