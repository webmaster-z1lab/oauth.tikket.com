@extends('emails.layout')

@section('description', $description)

@section('content')
    @component('emails.components.message', [
        'button' => $url,
        'image' => $image
    ])
        <h2>Oi {{ explode(' ', $user['name'])[0] }}!</h2>
        <h2>Vamos recuperar o seu acesso</h2>

        <p>
            Você está recebendo esse email porque solicitou uma recuperação de senha em nosso site. Para continuar com o processo e cadastrar uma nova senha de acesso basta clicar
            no botão abaixo.
        </p>
    @endcomponent
@endsection
