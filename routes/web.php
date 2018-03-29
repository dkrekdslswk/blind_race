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

Route::get('/', function () {
    return view('main');
});

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

// controllers
// choi byeongchan

Route::get('/raceController', 'RaceController@create');
//Route::get('/cbcSocketTest', function(){
//    return view('cbcSocketTest');
//});
