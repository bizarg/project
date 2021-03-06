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

//Route::get('/', function () {
//    return view('welcome');
//});


Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/add_domain', 'InstallController@add_domain');
    Route::post('/install', 'InstallController@install');

    Route::post('get/servers', 'InstallController@getServers');
    Route::get('get/servers', 'InstallController@getServers');
});
Auth::routes();

