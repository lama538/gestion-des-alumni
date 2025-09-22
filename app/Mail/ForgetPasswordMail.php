<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

public $actionUrl;
public $level = 'primary';

public function __construct($actionUrl)
{
    $this->actionUrl = $actionUrl;
}

public function build()
{
    return $this->subject('Réinitialisation de votre mot de passe')
                ->markdown('vendor.notifications.email') // utiliser la vue existante
                ->with([
                    'actionText' => 'Réinitialiser le mot de passe',
                    'actionUrl' => $this->actionUrl,
                ]);
}


}
