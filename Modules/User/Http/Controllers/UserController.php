<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\ApiController;
use Modules\Form\Http\Resource\Form;
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
     * @param string $id
     * @param array  $with
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(string $id, array $with = [])
    {
        $with = ['address', 'phone'];

        return parent::show($id, $with);
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
     * @return Form
     */
    public function form(string $id)
    {
        return new Form($this->repository->form($id));
    }
}
