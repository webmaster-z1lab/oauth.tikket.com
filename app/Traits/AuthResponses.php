<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 29/10/2018
 * Time: 20:56
 */

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait AuthResponses
{
    /**
     * @param int    $http_response
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken(int $http_response, string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => (int)auth()->factory()->getTTL(),
        ], $http_response);
    }

    /**
     * @param int   $http_response
     * @param array $errors
     */
    public function sendFailedResponse(int $http_response, array $errors = [])
    {
        if (empty($errors)) $errors = [$this->username => __('auth.failed')];

        throw new HttpResponseException(response()->json(['errors' => $errors], $http_response));
    }

    /**
     * @param int    $http_response
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse(int $http_response, string $message)
    {
        return response()->json(['message' => $message], $http_response);
    }
}