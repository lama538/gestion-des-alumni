<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:4200');

        return (new MailMessage)
            ->subject('Réinitialisation du mot de passe')
            ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
            ->action(
                'Réinitialiser le mot de passe',
                $frontendUrl . '/reset-password/' . $this->token . '?email=' . urlencode($notifiable->getEmailForPasswordReset())
            )
            ->line('Si vous n\'avez pas demandé de réinitialisation, aucune action supplémentaire n\'est requise.');
    }
}
