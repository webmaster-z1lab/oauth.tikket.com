<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\ApiController;
use Z1lab\Form\Builder;
use Modules\User\Http\Requests\UserRequest;
use Modules\User\Repositories\UserRepository;

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

    /**
     * @param string $id
     * @return \Z1lab\Form\Http\Resource\Form
     */
    public function form(string $id)
    {
        return (new Builder($this->repository->form($id)))->toJson();
    }
}
