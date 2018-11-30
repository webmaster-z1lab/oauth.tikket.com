<?php

Route::group(['prefix' => 'actions'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::post('register', 'RegisterController@register');

    Route::get('verify-email/{id}','VerificationController@verify')->name('api.actions.verify-email');

    Route::group(['prefix' => 'recovery'], function () {
        Route::post('', 'RecoveryController@recovery');
        Route::post('reset', 'RecoveryController@reset');
    });
});
