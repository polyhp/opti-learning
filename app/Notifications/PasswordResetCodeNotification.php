<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetCodeNotification extends Notification
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Code de réinitialisation de mot de passe - OPTI-LEARNING')
            ->greeting('Bonjour !')
            ->line('Vous avez demandé la réinitialisation de votre mot de passe.')
            ->line('Voici votre code de vérification :')
            ->line('**' . $this->code . '**')
            ->line('Ce code expirera dans 10 minutes.')
            ->line('Si vous n\'êtes pas à l\'origine de cette demande, ignorez cet email.')
            ->salutation('Cordialement, L\'équipe OPTI-LEARNING');
    }
}