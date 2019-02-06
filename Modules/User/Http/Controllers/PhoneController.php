<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\User\Http\Requests\PhoneRequest;
use Modules\User\Repositories\PhoneRepository;

class PhoneController extends Controller
{
    /**
     * @var \Modules\User\Repositories\PhoneRepository
     */
    private $repository;

    /**
     * PhoneController constructor.
     *
     * @param \Modules\User\Repositories\PhoneRepository $repository
     */
    public function __construct(PhoneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Modules\User\Http\Requests\PhoneRequest $request
     * @param string                                   $user
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(PhoneRequest $request, string $user)
    {
        return api_resource('User')->make($this->repository->insert($request->validated(), $user));
    }

    /**
     * @param string $user
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function destroy(string $user)
    {
        return api_resource('User')->make($this->repository->destroy($user));
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(string $id)
    {
        return api_resource('Phone')->make($this->repository->show($id));
    }
}
