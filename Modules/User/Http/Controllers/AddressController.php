<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Http\Requests\AddressRequest;
use Modules\User\Repositories\AddressRepository;

class AddressController extends Controller
{
    /**
     * @var AddressRepository
     */
    protected $repository;

    /**
     * AddressController constructor.
     *
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AddressRequest $request
     * @param string  $user
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function store(AddressRequest $request, string $user)
    {
        return api_resource('User')->make($this->repository->insert($request->all(), $user));
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
        return api_resource('Address')->make($this->repository->show($id));
    }
}
