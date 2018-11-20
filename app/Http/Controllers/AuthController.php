<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Traits\AuthResponses;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    use ThrottlesLogins, AuthResponses;

    /**
     * @var string
     */
    private $username = 'email';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->only('login');
        $this->middleware('auth')->only('logout');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        /** @var \App\Models\User $user */
        $user = \Auth::getProvider()->retrieveByCredentials($request->only(['email', 'password']));
        if (!$user || !\Auth::getProvider()->validateCredentials($user, $request->only(['email', 'password']))) {
            $this->incrementLoginAttempts($request);
            $this->sendFailedResponse(Response::HTTP_UNAUTHORIZED);
        }

        $result = $user->createToken('login_token');

        //event(new Login('api', $user, FALSE));

        //\Cookie::queue('auth_time', now()->getTimestamp(), 10);

        return $this->respondWithToken(Response::HTTP_OK, $result->accessToken,
            $result->token->expires_at->getTimestamp());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = (new Parser())->parse($request->bearerToken());

        $this->revokeTokens($token->getClaim('jti'));

        return $this->sendSuccessResponse(Response::HTTP_RESET_CONTENT, __('logged out'));
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @param Request $request
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn($this->throttleKey($request));

        $errors = [$this->username() => [\Lang::get('auth.throttle', ['seconds' => $seconds])]];

        $this->sendFailedResponse(Response::HTTP_UNAUTHORIZED, $errors);
    }

    /**
     * @param $token
     */
    private function revokeTokens($token)
    {
        Passport::token()->find($token)->revoke();

        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $token)
            ->update(['revoked' => TRUE]);
    }
}
