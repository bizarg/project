<?php
use Illuminate\Http\Request;
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

Route::post('service', ['uses' => 'Admin\OrderController@resultInvoice']);
Route::post('result', ['uses' => 'Admin\OrderController@result']);

Route::get('test', ['uses' => 'WayForPayController@test']);


Route::get('merchant/form', 'WebMoneyController@index');
Route::post('merchant/result', 'WebMoneyController@result');

Route::get('merchant/fail', 'WebMoneyController@fail');
Route::get('merchant/access', 'WebMoneyController@access');
Route::post('merchant/test', 'WebMoneyController@test');


//ADMIN
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

	//USER
	Route::get('/user/index', ['uses' => 'Admin\UserController@index']);
	Route::get('/user/{id}/show', ['uses' => 'Admin\UserController@show']);

	//DOMAINS
	Route::get('/domains', ['uses' => 'Admin\DomainController@index']);
	Route::get('/domains/{id}', ['uses' => 'Admin\DomainController@show']);
	Route::post('/domains/{id}', ['uses' => 'Admin\DomainController@update']);
	Route::get('/domains/{id}/delete', ['uses' => 'Admin\DomainController@destroy']);

	//TARIFF
	Route::resource('/tariff', 'Admin\TariffController', ['except' => [
		'show', 'create'
	]]);
	Route::get('/tariff/{id}', ['uses' => 'Admin\TariffController@destroy']);
});


//CLIENT
Route::group(['prefix' => 'client', 'middleware' => ['auth']], function(){
	Route::get('/domains', 'Client\ClientController@index');

//	Route::get('/create_ticket', 'Client\ClientController@create');
//	Route::post('/store_ticket', 'Client\ClientController@store');
//	Route::get('/ticket/{id}', 'Client\ClientController@show');
});



Route::group(['middleware' => 'auth'], function () {

	Route::post('admin/add_domain', ['uses' => 'Admin\OrderController@store']);
	Route::post('payment/form_pay', ['uses' => 'Admin\OrderController@createOrder']);

	Route::get('/', 'DashboardController@main')->name('home');
	Route::get('/home', 'DashboardController@main')->name('home');
	Route::get('info/{domain}', 'DashboardController@domain_info');
//	Route::get('seo/{domain}', 'DashboardController@domain_seo');
//	Route::get('settings', 'DashboardController@settings');
//	Route::post('domain/add', 'DashboardController@add_domain');
//	Route::get('confirm/{domain}', 'DashboardController@confirm');
//	Route::get('piwik/add/{domain}', 'DashboardController@add_piwik');
//	Route::get('confirm/info/{domain}', 'DashboardController@confirm_info');
//	Route::get('faq', 'DashboardController@faq');
});


//
//Route::group(['middleware' => ['auth', 'role']], function () {
//	Route::get('search', 'SearchController@search');
//	// Project
//	Route::get('managment', ['as' => 'managment', 'uses' => 'ProjectController@index']);
//
//	Route::get('project/create', [ 'uses' => 'ProjectController@create']);
//
//
//	Route::get('project/edit/{id}', ['uses' => 'ProjectController@edit']);
//	Route::post('project/edit/{id}', ['uses' => 'ProjectController@update']);
//
//	Route::get('project/delete/{id}', ['uses' => 'ProjectController@destroy']);
//	Route::get('project/project/{id}', ['uses' => 'ProjectController@show']);
//
//	// Domen
//	Route::get('domen/create', ['uses' => 'DomenController@create']);
//	Route::post('domen/create', ['uses' => 'DomenController@store']);
//
//	Route::get('domen/edit/{id}', ['uses' => 'DomenController@edit']);
//	Route::post('domen/edit/{id}', ['uses' => 'DomenController@update']);
//
//	Route::get('domen/delete/{id}', ['uses' => 'DomenController@showDeleteForm']);
//	Route::post('domen/delete/{id}', ['uses' => 'DomenController@destroy']);
//	Route::get('domen/priority/{domen_id}/{project_id}', ['uses' => 'DomenController@editPriority']);
//	Route::post('domen/priority/{domen_id}/{project_id}', ['uses' => 'DomenController@updatePriority']);
//
//	Route::get('domen/domen/{id}', ['uses' => 'DomenController@show']);
//
//
//
//	// Profile
//	Route::get('profile', ['as' => 'profile', 'uses' => 'UserController@index']);
//
//	Route::get('profile/user', ['uses' => 'UserController@editUser']);
//	Route::post('profile/user', ['uses' => 'UserController@updateUser']);
//
//
//	Route::get('profile/account', ['uses' => 'UserController@editAccount']);
//	Route::post('profile/account', ['uses' => 'UserController@updateAccount']);
//
//	// Task
//	Route::get('task/task/{id}', ['uses' => 'Admin\TaskController@show', 'as' => 'task']);
//
//	// Comment
//	Route::post('comment/{id}', ['uses' => 'CommentController@addComment']);
//	Route::get('comments/{id}/{model}', ['uses' => 'CommentController@index']);
//
//	Route::get('logs/{id}/{model}', ['uses' => 'LogController@index']);
//
//});

Auth::routes();
