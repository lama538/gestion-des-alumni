<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    /**
     * Crée une nouvelle instance de notification.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Détermine les canaux de notification.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Représentation de l'email de réinitialisation.
     */
    public function toMail($notifiable)
    {
        $url = url("/reset-password?token={$this->token}&email={$notifiable->email}");

        return (new MailMessage)
            ->subject('Réinitialisation de mot de passe')
            ->line('Vous recevez cet email pour réinitialiser votre mot de passe.')
            ->action('Réinitialiser le mot de passe', $url)
            ->line("Si vous n'avez pas demandé ce changement, ignorez cet email.");
    }

    /**
     * Représentation en tableau de la notification (optionnel).
     */
    public function toArray($notifiable): array
    {
        return [];
    }
}
