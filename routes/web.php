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

Route::get('/race', function(){
    return view('Race/race');
});

Route::get('/recordbox', function(){
    return view('Recordbox/recordbox');
});

Route::get('/feedback', function(){
    return view('Recordbox/Feedback');
});


Route::get('/mygroup', function(){
    return view('Mygroup/mygroup');
});

Route::get('/nav', function(){
    return view('nav/mainnav');
});

Route::get('/feedback', function(){
    return view('Recordbox/Feedback');
});

Route::get('/mygroup', function(){
    return view('Mygroup/mygroup');
});
