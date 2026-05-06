<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetLinkNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $token,
        private readonly string $guard,
        private readonly string $email
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = route('password.reset.form', [
            'token' => $this->token,
            'email' => $this->email,
            'guard' => $this->guard,
        ]);

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe')
            ->greeting('Bonjour,')
            ->line('Une demande de réinitialisation de mot de passe a été reçue pour votre compte.')
            ->line('Si vous êtes à l’origine de cette demande, cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe.')
            ->action('Réinitialiser mon mot de passe', $resetUrl)
            ->line('Ce lien expirera dans 60 minutes.')
            ->line('Si vous n’avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.');
    }
}