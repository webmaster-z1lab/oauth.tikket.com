<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\AuthResponses;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class VerificationController extends Controller
{
    use AuthResponses;

    /**
     * VerificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->only('resend');
        $this->middleware('signed');
        $this->middleware('throttle:6,1');
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(string $id)
    {
        try {
            $user = User::where('user_id', $id)->first();
            $user->markEmailAsVerified();

            event(new Verified($user));
        } catch (\Exception $e) {
            $this->sendFailedResponse(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->sendSuccessResponse(Response::HTTP_NO_CONTENT, 'OK');
    }

    /**
     * @todo Create logic for resend email confirmation
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }
}
