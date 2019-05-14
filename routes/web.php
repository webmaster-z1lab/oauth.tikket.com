<?php

Route::view('/', 'cover');

Route::get('test', function () {



    Bugsnag\BugsnagLaravel\Facades\Bugsnag::notifyException(new RuntimeException("Test error"));
});
