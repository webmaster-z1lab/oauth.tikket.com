<?php

namespace App\Notifications;

use App\Mail\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var
     */
    public $user;
    /**
     * @var string
     */
    private $confirmationRoute = 'email-confirmation';

    /**
     * VerifyEmail constructor.
     *
     * @param $user
     */
    public function __construct($user)
    {
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
     * @return VerifyEmail
     */
    public function toMail($notifiable)
    {
        return (new VerifyEmail($this->user, $this->verificationUrl()))->to($this->user['email']);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @return string
     */
    protected function verificationUrl()
    {
        $token = base64_encode(URL::temporarySignedRoute(
            'api.actions.verify-email', now()->addMonths(6), ['id' => $this->user['user_id']]
        ));

        return "{$this->user['referer']}{$this->confirmationRoute}?token={$token}";
    }
}
