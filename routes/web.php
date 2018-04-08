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
    return view('Race/Result');
});



Route::get('/feedback', function(){
    return view('Recordbox/Feedback');
});

Route::get('/Quiz_tree', function(){
    return view('Quiz_tree/Quiz_list');
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

// ↓↓↓↓↓↓↓ transfer test _yoolme
/*Route::get('/', function(){
     return view('test');
});*/

Route::get('/cbcSocketTest', function(){
    return view('cbcSocketTest');
});
Route::post('/raceController/create','RaceController@create');
Route::post('/raceController/teacherIn','RaceController@teacherIn');
Route::post('/raceController/studentIn','RaceController@studentIn');
Route::post('/raceController/nickIn','RaceController@nickIn');
Route::post('/raceController/quizNext','RaceController@quizNext');

