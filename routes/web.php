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

Route::post('/store',"UserController@store");
Route::post('/user_login',"UserController@user_login");

Route::get('/', function () {
    return view('homepage');
});
//
//Route::get('/homepage', function() {
//    return view('homepage');
//});

Route::get('/nav', function(){
    return view('nav/mainnav');
});

Route::get('/login', function () {
    return view('Login/login');
});

Route::get('/mygroup', function(){
    return view('Mygroup/mygroup');
});

Route::get('/race', function(){
    return view('Race/race');
});

Route::get('/race_waiting', function(){
    return view('Race/race_waiting');
});

Route::get('/recordbox', function(){
    return view('Recordbox/recordbox');
});

Route::get('/feedback', function(){
    return view('Recordbox/Feedback');
});

Route::get('/Quiz_list', function(){
    return view('Quiz_tree/Quiz_list');
});

 Route::get('/Quiz_making', function(){
     return view('Quiz_tree/Quiz_making');
 });

Route::get('/feedback', function(){
    return view('Recordbox/Feedback');
});

Route::get('/chat', function(){
    return view('chat');
});

Route::get('/playing', function(){
    return view('playing');
});

Route::get('/ctest', function(){
    return view('ctest');
});

Route::get('/raid', function(){
    return view('Raid/raid');
});

// 임시용 민수가
Route::get('/sidebar', function(){
    return view('sidebar');
});

// ↓↓↓↓↓↓↓ transfer test _yoolme
Route::get('/test', function(){
     return view('test');
});

Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});

Route::post('/raceController/create','RaceController@create');
Route::post('/raceController/teacherIn','RaceController@teacherIn');
Route::post('/raceController/studentIn','RaceController@studentIn');
Route::post('/raceController/nickIn','RaceController@nickIn');
Route::post('/raceController/quizNext','RaceController@quizNext');
//Route::post('/raceController/resultIn','RaceController@resultIn');
//Route::post('/raceController/destroy','RaceController@destroy');


 Route::get('/quizTreeController/folderRaceDataGet','QuizTreeController@folderRaceDataGet');
 Route::post('/quizTreeController/createRace','QuizTreeController@createRace');
 Route::post('/quizTreeController/getQuiz','QuizTreeController@getQuiz');
 Route::post('/quizTreeController/insertRace','QuizTreeController@insertRace');
 Route::post('/quizTreeController/postRaceGet','QuizTreeController@postRaceGet');

 Route::post('/recordBoxController/totalScoreGet','RecordBoxController@totalScoreGet');
