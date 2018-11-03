<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Repositories\PhoneRepository;
use Z1lab\JsonApi\Http\Controllers\ApiController;


class PhoneController extends ApiController
{
    public function __construct(PhoneRepository $repository)
    {
        parent::__construct($repository, 'Phone');
    }
}
