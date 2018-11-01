<?php

namespace Modules\User\Http\Resources\v1;

use Illuminate\Http\Resources\Json\Resource;

class Address extends Resource
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
            'type'       => 'addresses',
            'id'         => $this->id,
            'attributes' => [
                'street'      => $this->street,
                'number'      => $this->number,
                'complement'  => $this->complement,
                'district'    => $this->district,
                'city'        => $this->city,
                'state'       => $this->state,
                'postal_code' => $this->postal_code,
                'formatted'   => $this->formatted,
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
                'self' => route('addresses.show', $this->id),
            ],
        ];
    }
}
