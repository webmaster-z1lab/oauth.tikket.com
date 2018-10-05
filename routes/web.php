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

Route::group(['namespace' => 'Auth'], function ()
{
    Route::post('login', 'LoginController@login')->middleware('guest');

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::group(['middleware' => 'guest', 'prefix' => 'password', 'as' => 'password.'], function ()
    {
        Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');

        Route::post('reset', 'ResetPasswordController@reset')->name('update');
    });

    Route::post('register', 'RegisterController@register')->middleware('guest');
});

//Auth::routes(['verify' => true]);