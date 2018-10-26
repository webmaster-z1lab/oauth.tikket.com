<?php

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('register', 'RegisterController@register');
Route::get('email-verify', 'Auth\VerificationController@show')->name('verification.verify');
