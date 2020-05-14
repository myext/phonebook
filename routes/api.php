<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/user', 'UserController@index')->name('get_all_users');
Route::get('/user/{id}', 'UserController@byId')->where('id', '[0-9]+')->name('get_user');
Route::get('/user/name', 'UserController@byName');
Route::get('/user/phone/{phone}', 'UserController@byPhone')->where('phone', '[0-9]{10, 12}')->name('by_phone');
Route::post('/user', 'UserController@post');
Route::delete('/user/{id}', 'UserController@delete')->where('id', '[0-9]+')->name('del_user');
Route::put('/user', 'UserController@update')->name('update_user');


