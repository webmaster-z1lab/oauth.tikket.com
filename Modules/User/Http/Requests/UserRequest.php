<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'bail|required|string',
            'email'       => 'bail|string',
            'social_name' => 'bail|nullable|string|min:3',
            'nickname'    => 'bail|nullable|string|min:3',
            'gender'      => 'bail|nullable|string',
            'birth_date'   => 'bail|nullable|date',
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
}
