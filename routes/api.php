<?php


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
Route::group(['prefix' => 'actions'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::post('register', 'RegisterController@register');

    Route::group(['prefix' => 'recovery'], function () {
        Route::post('', 'RecoveryController@recovery');
        Route::post('reset', 'RecoveryController@reset');
    });
});
