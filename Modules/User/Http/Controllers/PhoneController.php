<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\ApiController;
use Modules\User\Repositories\PhoneRepository;


class PhoneController extends ApiController
{
    public function __construct(PhoneRepository $repository)
    {
        parent::__construct($repository, 'Phone');
    }
}
