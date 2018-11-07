<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Http\Requests\AvatarRequest;
use Modules\User\Http\Requests\CpfRequest;
use Modules\User\Http\Requests\PasswordRequest;
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
        $this->middleware('auth');
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

    /**
     * @param CpfRequest $request
     * @param string     $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function changeCpf(CpfRequest $request, string $id)
    {
        return parent::makeResource($this->repository->update($request->all(), $id));
    }

    /**
     * @param PasswordRequest $request
     * @param string          $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function changePassword(PasswordRequest $request, string $id)
    {
        return parent::makeResource($this->repository->update($request->only('password'), $id));
    }

    /**
     * @param AvatarRequest $request
     * @param string        $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function changeAvatar(AvatarRequest $request, string $id)
    {
        return parent::makeResource($this->repository->updateAvatar($request, $id));
    }
}
