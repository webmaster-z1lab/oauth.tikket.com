<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;
    /**
     * @var string
     */
    private $referer;
    /**
     * @var array
     */
    public $user;

    private $resetRoute = 'password-reset';

    /**
     * ResetPasswordNotification constructor.
     *
     * @param array $user
     * @param       $token
     */
    public function __construct(array $user, $token)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::getFromJson('Reset Password Notification'))
            ->line(Lang::getFromJson('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::getFromJson('Reset Password'), $this->resetUrl())
            ->line(Lang::getFromJson('If you did not request a password reset, no further action is required.'));
    }

    /**
     * @return string
     */
    public function resetUrl()
    {
        return "{$this->user['referer']}{$this->resetRoute}?token={$this->token}&email={$this->user['email']}";
    }

    public function toArray($notifiable)
    {
        return [
            'user' => $this->user
        ];
    }
}
