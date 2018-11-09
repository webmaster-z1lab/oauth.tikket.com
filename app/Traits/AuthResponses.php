<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 29/10/2018
 * Time: 20:56
 */

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Z1lab\JsonApi\Exceptions\ErrorObject;

trait AuthResponses
{
    /**
     * @param int $http_response
     * @param string $token
     * @param int $expires_in
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken(int $http_response, string $token, int $expires_in)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $expires_in,
        ], $http_response);
    }

    /**
     * @param int   $http_response
     * @param array $errors
     */
    public function sendFailedResponse(int $http_response, array $errors = [])
    {
        if (empty($errors)) $errors['email'] = __('auth.failed');

        $error = (new ErrorObject(array_first($errors), $http_response, $errors))->toArray();

        throw new HttpResponseException(response()->json($error, $http_response));
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
