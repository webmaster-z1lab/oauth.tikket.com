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
            ],
            'meta' => [
                //'form' => $this->form($this->attributes)
            ]
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

    private function form($data)
    {
        return [
            'config' => [
                'header'     => [
                    'title'       => __('condominium.save.title'),
                    'information' => __('condominium.save.information'),
                ],
                'url_submit' => '',
                'url_return' => '',
                'field_set'  => TRUE,
                'method'     => is_null($data) ? 'POST' : 'PUT',
                'callback'   => '',
            ],
            'form'   => [
                [
                    'legend' => 'Dados do Usuário',
                    'inputs' => [
                        [
                            'label'    => __('form.name'),
                            'name'     => 'name',
                            'col'      => 'col-md-4',
                            'value'    => $data['name'] ?? '',
                            'validate' => 'required|min:3',
                        ], [
                            'label'       => __('form.email'),
                            'name'        => 'email',
                            'col'         => 'col-md-3',
                            'value'       => $data['email'] ?? '',
                            'validate'    => 'required|email',
                            'placeholder' => 'exemplo@email.com',
                        ], [
                            'type_input'  => 'input-mask',
                            'label'       => __('form.phone'),
                            'name'        => 'phone',
                            'col'         => 'col-md-2',
                            'value'       => $data['phone'] ?? '',
                            'validate'    => 'required|phone',
                            'mask'        => ['(##) ####-####', '(##) #####-####'],
                            'placeholder' => '(00) 0000-0000',
                        ], [
                            'type_input'  => 'input-mask',
                            'label'       => __('form.document'),
                            'name'        => 'document',
                            'col'         => 'col-md-3',
                            'value'       => $data['document'] ?? '',
                            'validate'    => 'required|document',
                            'placeholder' => "00.000.000/0001-00 ou 000.000.000-00",
                            'mask'        => ['###.###.###-##', '##.###.###/####-##'],
                        ],
                    ],
                ], [
                    'legend' => 'Endereço',
                    'inputs' => [
                        [
                            'type_input' => 'input-mask',
                            'label'      => __('form.cep'),
                            'name'       => 'cep',
                            'col'        => 'col-md-2',
                            'value'      => $data['cep'] ?? '',
                            'validate'   => 'required|cep',
                            'mask'       => '#####-###',
                        ], [
                            'label'       => __('form.address'),
                            'name'        => 'address',
                            'col'         => 'col-md-5',
                            'value'       => $data['address'] ?? '',
                            'validate'    => 'required|min:3',
                            'placeholder' => 'Avenida/Rua, Número',
                        ], [
                            'label'    => __('form.neighborhood'),
                            'name'     => 'neighborhood',
                            'col'      => 'col-md-3',
                            'value'    => $data['neighborhood'] ?? '',
                            'validate' => 'required',
                        ], [
                            'type_input' => 'input-selected',
                            'label'      => __('form.city'),
                            'name'       => 'city_id',
                            'col'        => 'col-md-2',
                            'value'      => $data['city_id'] ?? '',
                            'validate'   => 'required',
                            'options'    => [
                                'name_value' => 'id',
                                'values'     => '',
                                'label'      => 'name',
                            ],
                        ],
                    ],
                ], [
                    'legend' => 'Outros Dados',
                    'inputs' => [
                        [
                            'type_input' => 'input-selected',
                            'label'      => __('form.bank'),
                            'name'       => 'bank_id',
                            'col'        => 'col-md-6',
                            'value'      => $data['bank_id'] ?? '',
                            'validate'   => 'required',
                            'options'    => [
                                'name_value' => 'id',
                                'values'     => '',
                                'label'      => ['bank', ' - ', 'account'],
                            ],
                        ], [
                            'type_input' => 'input-selected',
                            'label'      => __('form.type'),
                            'name'       => 'type',
                            'col'        => 'col-md-6',
                            'value'      => $data['type'] ?? '',
                            'validate'   => 'required',
                            'options'    => [
                                'values' => '',
                            ],
                        ], [
                            'type_input' => 'input-money',
                            'label'      => __('form.reserve'),
                            'name'       => 'reserve_fund',
                            'col'        => 'col-md-4',
                            'value'      => $data['reserve_fund'] ?? '',
                            'validate'   => 'required|decimal:2',
                        ], [
                            'type_input' => 'input-money',
                            'label'      => __('form.reserve_fund_percentage'),
                            'porcentage' => TRUE,
                            'name'       => 'reserve_fund_percentage',
                            'col'        => 'col-md-4',
                            'value'      => $data['reserve_fund_percentage'] ?? '',
                            'validate'   => 'required|numeric|max_value:100',

                        ], [
                            'type_input' => 'input-money',
                            'label'      => __('form.trustee_percentage'),
                            'porcentage' => TRUE,
                            'name'       => 'trustee_percentage',
                            'col'        => 'col-md-4',
                            'value'      => $data['trustee_percentage'] ?? '',
                            'validate'   => 'required|numeric|max_value:100',
                        ], [
                            'type_input' => 'input-upload',
                            'label'      => __('form.attachments'),
                            'name'       => 'attachments',
                            'col'        => 'col-md-12',
                            'value'      => $data['attachments'] ?? '',
                        ], [
                            'type_input' => 'input-switch',
                            'label'      => __('form.has_blocks'),
                            'name'       => 'has_blocks',
                            'col'        => 'col-md-12',
                            'value'      => $data['has_blocks'] ?? '',
                        ], [
                            'type_input' => 'input-switch',
                            'label'      => __('form.is_active'),
                            'name'       => 'is_active',
                            'col'        => 'col-md-12',
                            'value'      => $data['is_active'] ?? '',
                        ],
                    ],
                ],
            ],
        ];
    }
}
