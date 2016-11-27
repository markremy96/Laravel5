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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>['web']],function(){
    Route::get('company',[
        'uses' => 'ControllerCompany@ViewInfo',
        'as' => 'info.company',
    ]);
    Route::post('company',[
        'uses' => 'ControllerCompany@Handing',
    ]);
});
