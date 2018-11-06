<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Validator\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $me = $this;

        $this->app['validator']->resolver(function ($translator, $data, $rules, $messages, $customAttributes) use($me)
        {
            $messages += $me->getMessages();

            return new Validator($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @return array
     */
    protected function getMessages()
    {
        return [
            'cell_phone'        => 'O campo :attribute não é um possui o formato válido de celular com DDD',
            'cnpj'              => 'O campo :attribute não é um CNPJ válido',
            'cpf'               => 'O campo :attribute não é um CPF válido',
            'bool_custom'       => 'O campo :attribute deve ser verdadeiro ou falso'
        ];
    }
}
