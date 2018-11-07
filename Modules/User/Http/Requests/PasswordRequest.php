<?php

namespace Modules\User\Http\Requests;

use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class PasswordRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'         => 'required|string|confirmed|min:8|required_with:password_confirmation',
            'current_password' => 'required|string',
        ];
    }

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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!\Hash::check($this->current_password, \Auth::user()->makeVisible('password')->password))
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
        });

        return;
    }
}
