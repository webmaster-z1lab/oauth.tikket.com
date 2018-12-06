<?php

namespace App\Notifications;

use App\Mail\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $referer;
    /**
     * @var array
     */
    private $user;
    /**
     * @var string
     */
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
     * @param $notifiable
     * @return ResetPassword
     */
    public function toMail($notifiable)
    {
        return (new ResetPassword($this->user, $this->resetUrl()))->to($this->user['email']);
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $this->user,
        ];
    }

    /**
     * @return string
     */
    private function resetUrl()
    {
        return "{$this->user['referer']}{$this->resetRoute}?token={$this->token}&email={$this->user['email']}";
    }
}
