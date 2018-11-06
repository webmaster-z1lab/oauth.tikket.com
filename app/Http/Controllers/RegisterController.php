<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Traits\AuthResponses;
use Illuminate\Http\Response;
use Modules\User\Repositories\UserRepository;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use AuthResponses;

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
        $data = $request->only(['name', 'email', 'password']);
        $data['referer'] = str_finish($request->server('HTTP_REFERER'), '/');

        $user = $this->repository->create($data);

        event(new Registered($user));

        $result = $user->createToken('login_token');

        return $this->respondWithToken(Response::HTTP_OK, $result->accessToken,
            $result->token->expires_at->getTimestamp());
    }


}
