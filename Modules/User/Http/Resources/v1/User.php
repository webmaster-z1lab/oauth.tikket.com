<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 25/10/2018
 * Time: 16:44
 */

namespace Modules\User\Http\Resources\v1;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'type'          => 'users',
            'id'            => $this->id,
            'attributes'    => [
                'name'        => $this->name,
                'social_name' => $this->social_name,
                'nickname'    => $this->nickname,
                'username'    => $this->username,
                'avatar'      => $this->avatar,
                'email'       => $this->email,
                'gender'      => $this->gender,
                'birth_date'  => $this->birth_date,
            ],
            'relationships' => [
                'address' => $this->getAddress($this->address),
                'phone'   => $this->getPhone($this->phone),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('users.show', $this->id),
                'related' => route('users.form', $this->id)
            ],
        ];
    }

    private function getAddress($address)
    {
        if (NULL === $address) return NULL;

        return [
            'links' => [
                'self' => route('addresses.show', $this->id),
            ],
            'data'  => api_resource('Address')->make($address),
        ];
    }

    private function getPhone($phone)
    {
        if (NULL === $phone) return NULL;

        return [
            'links' => [
                'self' => route('phones.show', $this->id),
            ],
            'data'  => api_resource('Phone')->make($phone),
        ];
    }
}
