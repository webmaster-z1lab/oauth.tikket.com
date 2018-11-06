<?php

namespace Modules\User\Http\Requests;


use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class AddressRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'street'     => 'bail|required|string|max:255',
            'number'     => 'bail|nullable|number',
            'complement' => 'bail|nullable|string|max:100',
            'district'   => 'bail|required|string|max:100',
            'city'       => 'bail|required|string|max:100',
            'state'      => 'bail|required|string|max:2',
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
