<?php

namespace App\Mail;

use App\Models\User;
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
    public $button;
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
     * ResetPassword constructor.
     *
     * @param  \App\Models\User  $user
     * @param  string            $resetLink
     */
    public function __construct(User $user, string $resetLink)
    {
        $this->user = $user;
        $this->button = [
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
        return $this->view('emails.reset-password');
    }
}
