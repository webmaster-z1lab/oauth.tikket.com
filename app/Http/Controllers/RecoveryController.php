<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecoveryRequest;
use App\Http\Requests\ResetRequest;
use App\Traits\AuthResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class RecoveryController extends Controller
{
    use AuthResponses;

    /**
     * @var string
     */
    private $token;

    /**
     * RecoveryController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param RecoveryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recovery(RecoveryRequest $request)
    {
        $response = Password::broker()->sendResetLink($request->only('email'));

        if ($response !== Password::RESET_LINK_SENT) $this->sendFailedResponse(Response::HTTP_UNAUTHORIZED, ['email' => __($response)]);

        return $this->sendSuccessResponse(Response::HTTP_CREATED, __($response));
    }

    /**
     * @param ResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetRequest $request)
    {
        $data = $request->only('email', 'password', 'password_confirmation', 'token');

        $response = Password::broker()->reset($data, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response !== Password::PASSWORD_RESET) $this->sendFailedResponse(Response::HTTP_UNAUTHORIZED, ['email' => __($response)]);

        return $this->respondWithToken(Response::HTTP_OK, $this->token);
    }

    /**
     * Reset the given user's password.
     *
     * @param         $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = $password;
        $user->save();

        event(new PasswordReset($user));

        $this->token = auth()->login($user);
    }
}
