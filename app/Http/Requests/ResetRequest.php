<?php

namespace App\Http\Requests;

use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class ResetRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'    => 'bail|required',
            'email'    => 'bail|required|email|exists:users,email',
            'password' => 'bail|required|confirmed|min:8',
        ];
    }
}
