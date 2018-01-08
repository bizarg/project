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

Route::get('domain/info', 'ScanController@get_domain_info');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api/v1', 'middleware' => 'api.auth'], function () {

    Route::post('user/domains', 'ApiController@get_user_domains');
    Route::post('domain/info', 'ApiController@get_domain_info');
    Route::post('domain/info/period', 'ApiController@get_domain_info_period');
    Route::post('domain/confirm', 'ApiController@domain_confirm');
    Route::post('domain/messages', 'ApiController@domain_messages');
    Route::post('domain/add', 'ApiController@add_domain_to_user');
    Route::post('domain/delete', 'ApiController@delete_user_domain');
});
/*
|--------------------------------------------------------------------------
| API Admin Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/admin', 'middleware' => 'api.auth.admin'], function () {
    Route::post('user/find', 'Admin\ApiController@userAddOrCreate');
    Route::post('users', 'Admin\ApiController@getChildUsers');
});

/*
 * Test api 
 */

Route::group(['middleware' => 'auth'], function () {

//    Route::get('/', 'DashboardController@main');
//    Route::get('info/{domain}', 'DashboardController@domain_info');
//    Route::get('seo/{domain}', 'DashboardController@domain_seo');
//    Route::get('settings', 'DashboardController@settings');
//    Route::post('domain/add', 'DashboardController@add_domain');
//    Route::get('confirm/{domain}', 'DashboardController@confirm');
//    Route::get('piwik/add/{domain}', 'DashboardController@add_piwik');
//    Route::get('confirm/info/{domain}', 'DashboardController@confirm_info');
//    Route::get('faq', 'DashboardController@faq');

    Route::get('/home', 'User\UserController@index');
    Route::get('/', 'User\UserController@index');
    Route::get('/site/{id}', 'User\UserController@show_site');
    Route::get('/users/', 'User\UserController@show_users');
    Route::get('/user/{id}/sites', 'User\UserController@show_user_sites');
    Route::get('/user/{user}/site/{site}', 'User\UserController@show_user_site_info');

    Route::get('/user/notify/{contact}', 'User\UserController@notify');
    Route::post('/user/sites/change/notify', 'User\UserController@change_notify');

    Route::get('user/edit/{id}', 'User\SiteController@edit');
    Route::post('user/edit/{id}', 'User\SiteController@update');
    Route::get('user/delete/{id}', 'User\SiteController@delete');

    Route::any('user/main_url/{id}', 'User\SiteController@edit_main_url');

    Route::resource('contact', 'User\ContactController', ['except' => ['show']]);

    Route::get('user/history/yandex/{site_id}', 'User\HistoryController@yandex_history');
    Route::get('user/history/screenshot/{site_id}', 'User\HistoryController@screenshots_history');

    Route::post('user/history/yandex/{site_id}', 'User\HistoryController@yandex_search');
    Route::post('user/history/screenshot/{site_id}', 'User\HistoryController@screenshots_search');

    Route::post('user/search_sites', 'User\SearchController@search_sites');
});


Route::get('test/user/domains', 'TestApiController@test_user_domains');
Route::get('test/domain/confirm', 'TestApiController@test_confirm');
Route::get('test/domain/add', 'TestApiController@test_domain_add');
Route::get('test/domain/info', 'TestApiController@test_domain_info');
Route::get('test/domain/info/period', 'TestApiController@test_domain_info_period');
Route::get('test/domain/messages', 'TestApiController@domain_messages');
Route::get('test/relations', 'TestApiController@relations');
Route::get('test/admin', 'TestApiController@test_admin_user');
Route::get('test/email', 'TestApiController@testEmail');


Route::get('test/admin/{method}', 'TestAdminApiController@testCall');



/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('/admin/login', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@login']);
Route::get('/admin/logout', 'Admin\Auth\LoginController@logout');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['adminAuth']], function () {
    Route::get('admin', 'Admin\AdminController@index');
    Route::get('/admin/notify/{contact}', 'Admin\AdminController@notify');
    Route::post('/admin/site/edit/{id}', 'Admin\AdminController@edit_main_url');
    Route::post('/admin/sites/change/notify', 'Admin\AdminController@change_notify');

    Route::get('/admin/create/contact/{id}', 'Admin\ContactController@create');
    Route::post('/admin/create/contact/{id}', 'Admin\ContactController@store');
    Route::get('/admin/delete/contact/{contact_id}/{user_id}', 'Admin\ContactController@delete');
    Route::get('/admin/edit/{contact_id}/contact/{user_id}', 'Admin\ContactController@edit');
    Route::post('/admin/edit/contact/{contact_id}/{user_id}', 'Admin\ContactController@update');

    Route::resource('admin/users', 'Admin\UserResourceController');
    Route::resource('admin/sites', 'Admin\SiteResourceController');
    Route::resource('admin/admins', 'Admin\AdminResourceController', ['except' => ['show']]);


    Route::get('admin/jobs', 'Admin\AdminController@show_jobs');
    Route::get('admin/failed_jobs', 'Admin\AdminController@show_failed_jobs');
    Route::get('admin/failed_jobs/retry/{job_id}', 'Admin\AdminController@retry');
    Route::get('admin/failed_jobs/retryAll', 'Admin\AdminController@retryAll');

    Route::get('admin/history/yandex/{site_id}', 'Admin\HistoryController@yandex_history');
    Route::get('admin/history/screenshot/{site_id}', 'Admin\HistoryController@screenshots_history');

    Route::post('admin/history/yandex/{site_id}', 'Admin\HistoryController@yandex_search');
    Route::post('admin/history/screenshot/{site_id}', 'Admin\HistoryController@screenshots_search');

    Route::post('admin/search_sites', 'Admin\SearchController@search_sites');
    Route::post('admin/search_users', 'Admin\SearchController@search_users');

    
    Route::get('admin/proxies', 'Admin\ProxyController@index');
    Route::get('admin/proxy/create', 'Admin\ProxyController@create');

    Route::get('admin/proxy/{id}', 'Admin\ProxyController@edit');
    Route::post('admin/proxies/save', 'Admin\ProxyController@store');


});

Auth::routes();
