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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@main');
    Route::get('/home', 'DashboardController@main');
    Route::get('info/{domain}', 'DashboardController@domain_info');
    Route::get('seo/{domain}', 'DashboardController@domain_seo');
    Route::get('settings', 'DashboardController@settings');
    Route::post('domain/add', 'DashboardController@add_domain');
    Route::get('confirm/{id}', 'DashboardController@confirm');
    Route::get('piwik/add/{domain}', 'DashboardController@add_piwik');
    Route::get('confirm/info/{domain}/{id}', 'DashboardController@confirm_info');
    Route::get('faq', 'DashboardController@faq');
    Route::get('delete/{id}', 'DashboardController@delete');

    Route::post('/domains/index', 'DashboardController@get_index');
    Route::post('/domains/get_domains', 'DashboardController@get_domains');
    Route::post('/domains/messages', 'DashboardController@get_messages');

});

Route::group(['middleware' => ['adminAuth']], function () {

    Route::get('/admin', ['as' => 'admin', 'uses' => 'Admin\AdminController@index']);
    Route::get('/admin/generate/{user_id}', 'Admin\AdminController@generate_token');
    Route::post('/admin/search', 'Admin\AdminController@search_user');

});

Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('/admin/login', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@login']);
Route::post('/admin/logout', ['as' => 'admin.logout', 'uses' => 'Admin\Auth\LoginController@logout']);


Route::post('generate/token', 'Auth\PublicLoginController@generate_token');
Route::any('auth', 'Auth\PublicLoginController@token_login');


Route::get('/test', 'DashboardController@test_token');

Route::post('/language-chooser', 'languageController@changeLanguage');
Route::post('/language/', [
    'before' => 'csrf',
    'as' => 'language-chooser',
    'uses' => 'languageController@changeLanguage',
]);

Route::get('graphics/list',[
    'as' => 'graphics.page',
    'uses' => 'GraphicsController@index'
]);
Route::post('graphics/list/screens',[
    'as' => 'graphics.screens',
    'uses' => 'GraphicsController@getScreens'
]);
Route::post('graphics/list/graphics',[
    'as' => 'graphics.graphics',
    'uses' => 'GraphicsController@getGraphics'
]);
Route::get('graphics/list/graphic_img',[
    'as' => 'graphics.graphic_img',
    'uses' => 'GraphicsController@getGraphImg'
]);
