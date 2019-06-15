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
    // return view('welcome');
    return "Hello World!";
});

Route::get('/task', 'TaskController@home');

// 诗人
Route::get('/Author', 'AuthorController@index');
Route::get('/Author/detail_{id}', 'AuthorController@detail')->where(['id'=>'\d+']);

// 古诗
Route::get('/Opus', 'OpusController@index');
Route::get('/Opus/detail_{id}', 'OpusController@detail')->where(['id'=>'\d+']);

// 古文
Route::get('/Guwen', 'GuwenController@index');
Route::get('/Guwen/artList_{id}', 'GuwenController@artList')->where(['id'=>'\d+']);
Route::get('/Guwen/artDetail_{id}', 'GuwenController@artDetail')->where(['id'=>'\d+']);


// 书籍
Route::get('/Shuji', 'ShujiController@index');
Route::get('/Shuji/artList_{id}', 'ShujiController@artList')->where(['id'=>'\d+']);
Route::get('/Shuji/artDetail_{id}', 'ShujiController@artDetail')->where(['id'=>'\d+']);

