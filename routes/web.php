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
    return view('welcome');
});
//微信回复功能
Route::any('/wechat', 'WeChatController@serve');
//图片功能
Route::any('/img','ImagesController@index');
//菜单功能
Route::get('/menu/create','MenuController@create');
Route::get('/menu/delete/{$id?}','MenuController@delete');
Route::get('/menu/list','MenuController@index');