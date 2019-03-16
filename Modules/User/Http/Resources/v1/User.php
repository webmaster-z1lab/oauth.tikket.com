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
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'          => 'users',
            'id'            => $this->user_id,
            'attributes'    => [
                'name'        => $this->name,
                'short_name'  => $this->short_name,
                'document'    => $this->getDocument($this->document),
                'social_name' => $this->social_name,
                'nickname'    => $this->nickname,
                'username'    => $this->username,
                'avatar'      => $this->avatar,
                'email'       => $this->email,
                'gender'      => $this->gender,
                'birth_date'  => $this->birth_date === NULL ? NULL : $this->birth_date->format('Y-m-d'),
                'phone'       => $this->getPhone($this->phone),
                'updated_at'  => $this->updated_at->format('d/m/Y à\s H:i:s'),
            ],
            'relationships' => [
                'address' => $this->getAddress($this->address),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('users.show', $this->user_id),
            ],
            'meta'  => [
                'forms' => [
                    'profile' => route('users.form.profile', $this->user_id),
                ],
            ],
        ];
    }

    /**
     * @param $address
     *
     * @return array|null
     */
    private function getAddress($address)
    {
        if (NULL === $address) return NULL;

        return [
            'links' => [
                'self' => route('addresses.show', ['user' => $this->id, 'address' => $address->id]),
            ],
            'data'  => api_resource('Address')->make($address),
        ];
    }

    /**
     * @param $phone
     *
     * @return array|null
     */
    private function getPhone($phone)
    {
        if (NULL === $phone) return NULL;

        return [
            'area_code'         => $phone->area_code,
            'phone'             => $phone->phone,
            'phone_verified_at' => $phone->phone_verified_at,
            'is_whatsapp'       => $phone->is_whatsapp,
            'formatted'         => $phone->formatted_phone,
        ];
    }

    /**
     * @param string|NULL $document
     *
     * @return string
     */
    private function getDocument(string $document = NULL)
    {
        if (NULL === $document) return NULL;

        return substr($document, 0, 3) . '.***.***-**';
    }
}
