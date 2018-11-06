<?php

namespace Modules\User\Http\Requests;


use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class CpfRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document' => 'bail|required|document|unique:users',
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
