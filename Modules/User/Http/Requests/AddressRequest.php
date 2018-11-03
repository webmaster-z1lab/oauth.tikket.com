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
            'street'     => 'bail|required|string',
            'number'     => 'bail|nullable|number',
            'complement' => 'bail|nullable|string',
            'district'   => 'bail|required|string',
            'city'       => 'bail|required|string',
            'state'      => 'bail|required|string',
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
