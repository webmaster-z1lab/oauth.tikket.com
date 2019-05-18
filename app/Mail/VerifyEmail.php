<?php

namespace App\Mail;

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
    public $url;
    /**
     * @var
     */
    public $user;
    /**
     * @var string
     */
    public $subject = 'Bem-vindo ao quantofica.com';

    public $description = 'Seja bem vindo ao quantofica.com. Por favor confirme o seu e-mail';

    /**
     * VerifyEmail constructor.
     *
     * @param        $user
     * @param string $verifyLink
     */
    public function __construct($user, $verifyLink)
    {
        $this->user = $user;
        $this->url = [
            'link' => $verifyLink,
            'text' => 'Confirmar email',
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.verify-email');
    }
}
