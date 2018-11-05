<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repositories\UserRepository;
use Z1lab\JsonApi\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * UserController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository, 'User');
    }

    /**
     * @param UserRequest $request
     * @param string      $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function update(UserRequest $request, string $id)
    {
        return parent::makeResource($this->repository->update($request->all(), $id));
    }
}
