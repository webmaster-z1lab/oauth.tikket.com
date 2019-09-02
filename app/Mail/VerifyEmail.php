<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $image = [
        'source' => 'https://d35c048n9fix3e.cloudfront.net/images/undraw/png/undraw_hello_aeia.png',
        'text'   => 'Welcome and confirm your email',
    ];
    /**
     * @var array
     */
    public $button;
    /**
     * @var
     */
    public $user;
    /**
     * @var string
     */
    public $subject = 'Bem-vindo ao Tikket.com.br';

    public $description = 'Seja bem vindo ao Tikket. Por favor confirme o seu e-mail';

    /**
     * VerifyEmail constructor.
     *
     * @param        $user
     * @param string $verifyLink
     */
    public function __construct($user, $verifyLink)
    {
        $this->user = $user;
        $this->button = [
            'link' => $verifyLink,
            'text' => 'Confirmar meu e-mail',
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome');
    }
}
