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

Auth::routes();

Route::get('status', function()
{
    if(!Auth::user()->status) return view('status');

    return redirect('/');
});

Route::group(['middleware' => ['web', 'auth', 'status.user']], function () {

    Route::get('/', 'PanelController@index');

    Route::post('add/resolution', 'PanelController@storeResolution');
    Route::post('add/bitrate', 'PanelController@storeBitrate');

    Route::get('download/{id}', ['uses' => 'ConvertController@download', 'as' => 'convert-files.download']);
    Route::resource('profile', 'ProfileController');
    Route::resource('ftp-settings', 'FtpSettingsController', ['except' => [
        'show'
    ]]);
    Route::resource('files', 'FilesController');
    Route::post('files/delete', 'FilesController@massDestroy')->name('files.delete');
    Route::resource('convert-files', 'ConvertController');
    Route::post('convert-files/delete', 'ConvertController@massDestroy')->name('convert-files.delete');
    
    Route::resource('settings', 'SettingsController');

    Route::resource('templates', 'TemplateController');
    Route::get('templates/active/{id}', 'TemplateController@active');
    // Route::get('settings.destroy', 'SettingsController@destroy');

    Route::group(['middleware' => ['check.admin']], function () {
        Route::get('admin/status/{id}', 'AdminController@statusUser');
        Route::get('admin', 'AdminController@index');
        Route::post('admin/quantity/{id}', ['uses' => 'AdminController@statusUpload', 'as' => 'status.upload']);
    });

//    Route::post('settings/add/code', 'PatternController@store');
    Route::post('settings/generate', 'TemplateController@generate');
    Route::any('test/test/{id}', 'TemplateController@generate');
});



