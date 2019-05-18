<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $user;
    /**
     * @var array
     */
    public $url;
    /**
     * @var array
     */
    public $image = [
        'source' => 'https://d35c048n9fix3e.cloudfront.net/images/undraw/png/undraw_authentication_fsn5.png',
        'text'   => 'Reset Password Notification',
    ];
    /**
     * @var string
     */
    public $subject = 'Recuperação de senha';

    public $description = 'Recuperação de senha. Para criar uma nova senha acesse o link do email.';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $resetLink)
    {
        $this->user = $user;
        $this->url = [
            'link' => $resetLink,
            'text' => 'Trocar senha',
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notifications.reset-password');
    }
}
