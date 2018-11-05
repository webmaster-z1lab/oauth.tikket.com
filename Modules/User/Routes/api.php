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
Route::group([
    'middleware' => ['api.v:1'],
    'prefix'     => 'v1',
], function () {
    Route::apiResource('users', 'UserController')->except('index', 'store');
    Route::apiResource('addresses', 'AddressController')->except('index', 'update');
    Route::apiResource('phones', 'PhoneController')->except('index', 'update');

    Route::group(['prefix' => 'users'], function () {
        Route::get('{user}/form/profile', 'FormController@profile')->name('users.form.profile');
    });
});
