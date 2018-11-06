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

    Route::group(['prefix' => 'users/{user}'], function () {
        Route::get('form/profile', 'FormController@profile')->name('users.form.profile');

        Route::patch('cpf', 'UserController@changeCpf')->name('users.change.cpf');
        Route::patch('password', 'UserController@changePassword')->name('users.change.password');
        Route::patch('avatar', 'UserController@changeAvatar')->name('users.change.avatar');

        Route::apiResource('addresses', 'AddressController')->only('show', 'store');
    });
});
