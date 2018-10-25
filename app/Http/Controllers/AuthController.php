<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ThrottlesLogins;

    /**
     * @var string
     */
    private $username = 'email';

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
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

        $token = auth()->attempt($request->only(['email', 'password']));

        if ($token) return $this->respondWithToken($token);

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if ($request->bearerToken() != NULL) {
            $token = (new Parser())->parse($request->bearerToken());

            $this->revokeTokens($token->getClaim('jti'));

            return response()->json(['success' => 'Logged out'], Response::HTTP_RESET_CONTENT);
        }

        return $this->sendFailedLoginResponse();
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
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

    /**
     * @param array $errors
     */
    protected function sendFailedLoginResponse($errors = [])
    {
        if (empty($errors)) $errors = [$this->username => __('auth.failed')];

        throw new HttpResponseException(response()->json(['errors' => $errors], Response::HTTP_UNAUTHORIZED));
    }

    /**
     * @param Request $request
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $errors = [$this->username() => [\Lang::get('auth.throttle', ['seconds' => $seconds])]];

        $this->sendFailedLoginResponse($errors);
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
