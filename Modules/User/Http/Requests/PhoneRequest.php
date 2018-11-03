<?php

namespace Modules\User\Http\Requests;


use Z1lab\JsonApi\Http\Requests\ApiFormRequest;

class PhoneRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'area_code'   => 'bail|required|number|digits:2',
            'phone'       => 'bail|required|number|min:8|max:9',
            'is_whatsapp' => 'bail|required|boolean',
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
