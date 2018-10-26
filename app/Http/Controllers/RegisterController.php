<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Response;
use Modules\User\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('guest');
        $this->repository = $repository;
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->repository->create($request->only(['name', 'email', 'password']));

        event(new Registered($user));

        return $this->respondWithToken(auth()->login($user));
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => (int)auth()->factory()->getTTL(),
        ], Response::HTTP_OK);
    }


}
