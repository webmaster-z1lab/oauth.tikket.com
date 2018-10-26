<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 26/09/2018
 * Time: 19:27
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

abstract class ApiController extends Controller
{
    /**
     * Set the base repository
     *
     * @var \App\Repositories\ApiRepository
     */
    protected $repository;
    /**
     * Set the resource base ClassName
     *
     * @var
     */
    protected $resource;
    /**
     * Set the actions will be cached in http
     *
     * @var array
     */
    protected $cacheable = ['index', 'show'];

    /**
     * ApiController constructor.
     *
     * @param        $repository
     * @param string $resource
     */
    public function __construct($repository, string $resource)
    {
        if (env('APP_ENV') === 'production') $this->middleware('ttl')->only($this->cacheable);
        $this->repository = $repository;
        $this->resource = $resource;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function index()
    {
        return $this->collectResource($this->repository->list());
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(string $id)
    {
        return $this->makeResource($this->repository->find($id));
    }

    /**
     * @param Request $request
     * @param string  $id
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function update(Request $request, string $id)
    {
        return $this->makeResource($this->repository->update($id, $request->all()));
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        $this->repository->destroy($id);

        return response()->json(NULL, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $obj
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    protected function makeResource($obj)
    {
        return api_resource($this->resource)->make($obj);
    }

    /**
     * @param $collection
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    protected function collectResource($collection)
    {
        return api_resource($this->resource)->collection($collection);
    }
}