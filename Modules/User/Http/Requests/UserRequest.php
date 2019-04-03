<?php

namespace Modules\User\Http\Requests;


use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class UserRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'       => 'bail|required|string|min:4|max:255',
            'phone'      => 'bail|required|string|cell_phone',
            'nickname'   => 'bail|nullable|string|min:3|max:50',
            'gender'     => 'bail|nullable|string|max:20',
            'birth_date' => 'bail|required|date|before_or_equal:today -18 years',
        ];

        if(\Auth::user()->document === NULL) $rules['document'] = 'bail|filled|document|unique:users';

        return $rules;
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
