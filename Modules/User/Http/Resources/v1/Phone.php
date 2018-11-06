<?php

namespace Modules\User\Http\Resources\v1;

use Illuminate\Http\Resources\Json\Resource;

class Phone extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'       => 'phones',
            'id'         => $this->id,
            'attributes' => [
                'area_code'   => $this->area_code,
                'number'       => $this->phone,
                'is_whatsapp' => $this->is_whatsapp,
                'formatted'   => $this->formatted_phone,
            ],
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'links' => [
                'self' => route('phones.show', $this->id),
            ],
        ];
    }
}
