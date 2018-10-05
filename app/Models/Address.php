<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'street', 'number', 'complement', 'district', 'city', 'state', 'postal_code'
    ];

    protected $attributes = ['complement' => null];
}