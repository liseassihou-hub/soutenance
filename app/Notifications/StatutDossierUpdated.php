<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class StatutDossierUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $dossier;

    /**
     * Create a new notification instance.
     *
     * @param mixed $dossier
     */
    public function __construct($dossier)
    {
        $this->dossier = $dossier;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Mise à jour du statut de votre dossier')
            ->greeting('Bonjour ' . ($notifiable->nom ?? '') . ',')
            ->line('Votre dossier N°' . $this->dossier->code_dossier . ' est passé au statut : **' . $this->getStatutLabel($this->dossier->statut) . '**')
            ->line('Montant demandé : ' . number_format($this->dossier->montant_demande, 0, ',', ' ') . ' FCFA')
            ->line('Date de mise à jour : ' . $this->dossier->updated_at->format('d/m/Y H:i'))
            ->action('Voir votre dossier', route('suivi.form'))
            ->line('Merci de votre confiance dans PEBCO.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'dossier_id' => $this->dossier->id,
            'code_dossier' => $this->dossier->code_dossier,
            'statut' => $this->dossier->statut,
            'montant' => $this->dossier->montant_demande,
            'message' => 'Votre dossier ' . $this->dossier->code_dossier . ' est passé au statut ' . $this->getStatutLabel($this->dossier->statut),
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'dossier_id' => $this->dossier->id,
            'code_dossier' => $this->dossier->code_dossier,
            'statut' => $this->dossier->statut,
            'montant' => $this->dossier->montant_demande,
            'message' => 'Votre dossier ' . $this->dossier->code_dossier . ' est passé au statut ' . $this->getStatutLabel($this->dossier->statut),
        ]);
    }

    /**
     * Obtenir le libellé du statut
     */
    private function getStatutLabel($statut)
    {
        $labels = [
            'soumis' => 'Soumis',
            'en_cours' => 'En cours',
            'accepte' => 'Accepté',
            'refuse' => 'Refusé',
        ];

        return $labels[$statut] ?? $statut;
    }
}
