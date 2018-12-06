@extends('emails.layout')

@section('description', $description)

@section('content')
    @component('emails.components.message', [
        'button' => $url,
        'image' => $image
    ])
        <h2>Oi {{ explode(' ', $user['name'])[0] }}!</h2>
        <h2>Obrigado por criar sua conta e seja bem-vindo(a)</h2>

        <p>
            A sua conta no <a href="https://quantofica.com" target="_blank">quantofica.com</a> acaba de ser criada e já está ativa para que você faça buscas personalizadas, envie
            mensagens e até mesmo anuncie em nosso portal.
        </p>

        <p>
            Agora você só precisa clicar no botão abaixo para confirmar o seu e-mail e ter acesso a todas as comodidades do site.
        </p>
    @endcomponent
@endsection
