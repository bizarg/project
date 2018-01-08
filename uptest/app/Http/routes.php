<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'TaskController@showInputForm');
//Route::post('url/static', 'TaskController@get_url_static');
//Route::post('url/info', 'TaskController@get_url_info');
//



Route::post('/merchant/result', 'WebMoneyController@result');

Route::post('/log/api', 'TaskController@log_writer');

Route::group(['middlewareGroups' => ['web']], function () {
    Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
    Route::auth();
    
    $this->get('admin/login', 'Auth\AdminAuthController@showLoginForm');
    $this->post('admin/login', 'Auth\AdminAuthController@login');
    $this->get('admin/logout', 'Auth\AdminAuthController@logout');


    Route::get('/', function () {
        return view('main');
    });

    Route::group(['middleware' => ['auth.admin']], function () {

        $this->get('admin/users', 'Admin\UserController@all_users');
        $this->get('admin/user/profile/{id}', 'Admin\UserController@edit_user');
        $this->get('admin/user/suspend/{id}', 'Admin\UserController@suspend_user');
        $this->post('admin/user/edit/{id}', 'Admin\UserController@user_edit');
        $this->get('admin/user/detail/{id}', 'Admin\UserController@detail_user');

        $this->get('admin/domain/task/{id}', 'Admin\TaskController@domain_tasks');

        $this->get('admin/task/reset/{id}', 'Admin\TaskController@reset_task');
        $this->get('admin/task/delete/{id}', 'Admin\TaskController@delete_task');
        $this->get('admin/task/{id}', 'Admin\TaskController@detail_task');
        $this->get('admin/tasks', 'Admin\TaskController@all_tasks');

        $this->get('admin/domains', 'Admin\DomainController@domain_all');


        $this->get('admin/nodes', 'Admin\NodeController@nodes');
        $this->post('admin/node', 'Admin\NodeController@store');
        $this->get('admin/node/create', 'Admin\NodeController@create');
        $this->get('admin/node/{id}', 'Admin\NodeController@edit');
        $this->get('admin/node/status/{id}', 'Admin\NodeController@status');



        $this->get('admin/sites', 'Admin\SiteController@sites');
        $this->post('admin/site', 'Admin\SiteController@store');
        $this->get('admin/site/create', 'Admin\SiteController@create');
        $this->get('admin/site/{id}', 'Admin\SiteController@edit');
        $this->get('admin/site/status/{id}', 'Admin\SiteController@status');
    });


    Route::group(['middleware' => ['auth']], function () {
        Route::get('/monitoring', 'MonitorController@index');
        Route::get('/monitoring/add', 'MonitorController@add');
        Route::post('/monitoring/add', 'MonitorController@store');
        Route::get('/monitoring/compare', 'MonitorController@compare');

        Route::get('/monitoring/{id}', 'MonitorController@view');
        Route::get('/monitoring/delete/{id}', 'MonitorController@delete');






        Route::get('/domains', 'DomainController@user_domains');
        Route::post('/domain/add', 'DomainController@domain_add');
        Route::get('/domain/delete/{id}', 'DomainController@domain_delete');
        Route::get('/domain/token/{id}', 'DomainController@domain_token_file');
        Route::get('/domain/token/update/{id}', 'DomainController@domain_update_token');

        Route::get('/domain/confirm/{id}', 'DomainController@domain_confirm');

        Route::get('/task/new/{id?}', 'TaskController@new_task_form');
        Route::post('/task/new', 'TaskController@new_task_add');
        Route::get('/tasks', 'TaskController@tasks_all');
        Route::get('/task/{id}', 'TaskController@task_detail');

        Route::get('/task/start/{id}', 'TaskController@task_start');
        Route::get('/task/load/{id}', 'TaskController@task_load');


        Route::get('/task/update/log/{id}', 'TaskController@set_task_report');

        Route::get('/task/get/log/{id}', 'TaskController@get_task_report');
        Route::get('/task/log/json/{id}', 'TaskController@get_task_reports_json');


        Route::get('/balance', 'WebMoneyController@index');
        Route::get('/test', 'WebMoneyController@test');

        Route::get('/merchant/success', 'WebMoneyController@success');
        Route::get('/merchant/fail', 'WebMoneyController@fail');
    });
});
