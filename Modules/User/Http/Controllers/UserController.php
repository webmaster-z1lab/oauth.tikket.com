<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\User\Repositories\UserRepository;

class UserController extends ApiController
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository, 'Place');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(Request $request)
    {
        return parent::makeResource($this->repository->create($request->all()));
    }
}
