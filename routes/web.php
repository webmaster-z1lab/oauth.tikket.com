<?php

use Z1lab\Form\Models\Inputs\Text;

Route::get('test', function () {
    $inputs['name'] = new Text();
    $inputs['name']->col('col-md-6');
    $inputs['name']->validate('required');

    return $inputs;
});
