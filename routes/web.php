<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/','FrontController@index');
Route::get('admin','FrontController@admin');
Route::get('password/email','Auth\PasswordController@getEmail');
Route::post('password/email','Auth\PasswordController@postEmail');
Route::get('password/reset/{token}','Auth\PasswordController@getReset');

Route::resource('user','UserController');
/*Route::get('/admin/contacts', 'ContactsController@index');*/
Route::get('/admin/contacts', function () {
    return view('/admin/contacts/index');
});

Route::resource('log','LogController');
Route::get('logout','LogController@logout');