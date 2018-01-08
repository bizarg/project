<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//Route::get( '/form', 'FileController@index' )
//    ->name( 'file.form' );
//
//
//Route::any( '/file/uploader', 'FileController@fileUploader' )
//    ->name( 'file.uploader' );
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

//Route::get('send', 'HomeController@send');



Route::group(['middleware' => ['auth', 'role']], function () {
	Route::get('search', 'SearchController@search');
	// Project
	Route::get('managment', ['as' => 'managment', 'uses' => 'ProjectController@index']);

	Route::get('project/create', [ 'uses' => 'ProjectController@create']);


	Route::get('project/edit/{id}', ['uses' => 'ProjectController@edit']);
	Route::post('project/edit/{id}', ['uses' => 'ProjectController@update']);

	Route::get('project/delete/{id}', ['uses' => 'ProjectController@destroy']);
	Route::get('project/project/{id}', ['uses' => 'ProjectController@show']);

	// Domen
	Route::get('domen/create', ['uses' => 'DomenController@create']);
	Route::post('domen/create', ['uses' => 'DomenController@store']);

	Route::get('domen/edit/{id}', ['uses' => 'DomenController@edit']);
	Route::post('domen/edit/{id}', ['uses' => 'DomenController@update']);

	Route::get('domen/delete/{id}', ['uses' => 'DomenController@showDeleteForm']);
	Route::post('domen/delete/{id}', ['uses' => 'DomenController@destroy']);
	Route::get('domen/priority/{domen_id}/{project_id}', ['uses' => 'DomenController@editPriority']);
	Route::post('domen/priority/{domen_id}/{project_id}', ['uses' => 'DomenController@updatePriority']);

	Route::get('domen/domen/{id}', ['uses' => 'DomenController@show']);



	// Profile
	Route::get('profile', ['as' => 'profile', 'uses' => 'UserController@index']);

	Route::get('profile/user', ['uses' => 'UserController@editUser']);
	Route::post('profile/user', ['uses' => 'UserController@updateUser']);


	Route::get('profile/account', ['uses' => 'UserController@editAccount']);
	Route::post('profile/account', ['uses' => 'UserController@updateAccount']);

	// Task
	Route::get('task/task/{id}', ['uses' => 'Admin\TaskController@show', 'as' => 'task']);

	// Comment
	Route::post('comment/{id}', ['uses' => 'CommentController@addComment']);
	Route::get('comments/{id}/{model}', ['uses' => 'CommentController@index']);

	Route::get('logs/{id}/{model}', ['uses' => 'LogController@index']);

});

// admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth','role']], function(){
	Route::get('/', ['uses' => 'Admin\AdminController@index']);
	Route::get('/users', ['uses' => 'Admin\AdminController@showUsers', 'as' => 'users']);
	Route::get('/users/status/{id}', ['uses' => 'Admin\AdminController@statusUser']);

	Route::get('/tasks/status/{id}', ['uses' => 'Admin\TaskController@statusTask']);
	Route::get('/tasks', ['uses' => 'Admin\TaskController@showTasks', 'as' => 'tasks']);
	Route::get('/create_task', ['uses' => 'Admin\TaskController@create']);
	Route::post('/create_task', ['uses' => 'Admin\TaskController@store']);
	Route::get('/edit_task/{id}', ['uses' => 'Admin\TaskController@edit']);
	Route::post('/update_task/{id}', ['uses' => 'Admin\TaskController@update']);
	Route::get('/delete_task/{id}', ['uses' => 'Admin\TaskController@destroy']);
	Route::get('/order', ['uses' => 'Admin\OrderController@index']);
	Route::post('/order', ['uses' => 'Admin\OrderController@store']);
});

Route::group(['prefix' => 'client', 'middleware' => ['auth']], function(){
	Route::get('/client', 'Client\ClientController@index');
	Route::get('/create_ticket', 'Client\ClientController@create');
	Route::post('/store_ticket', 'Client\ClientController@store');
	Route::get('/ticket/{id}', 'Client\ClientController@show');
});

Route::group(['middleware' => 'auth'], function () {

//	Route::get('/', 'DashboardController@main');
	Route::get('info/{domain}', 'DashboardController@domain_info');
//	Route::get('seo/{domain}', 'DashboardController@domain_seo');
//	Route::get('settings', 'DashboardController@settings');
//	Route::post('domain/add', 'DashboardController@add_domain');
//	Route::get('confirm/{domain}', 'DashboardController@confirm');
//	Route::get('piwik/add/{domain}', 'DashboardController@add_piwik');
//	Route::get('confirm/info/{domain}', 'DashboardController@confirm_info');
//	Route::get('faq', 'DashboardController@faq');

});

Auth::routes();
