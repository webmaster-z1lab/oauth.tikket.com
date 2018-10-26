<?php

Route::post('login', 'AuthController@login');
Route::post('register', 'RegisterController@register');
Route::post('logout', 'AuthController@logout');
Route::get('email-verify', 'Auth\VerificationController@show')->name('verification.verify');
