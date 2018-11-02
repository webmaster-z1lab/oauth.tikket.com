<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Modules\User\Repositories\AddressRepository;


class AddressController extends ApiController
{
    /**
     * AddressController constructor.
     *
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        parent::__construct($repository, 'Address');
    }

    /**
     * @param Request $request
     * @param string  $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function update(Request $request, string $id)
    {
        return parent::makeResource($this->repository->update($request->all(), $id));
    }
}