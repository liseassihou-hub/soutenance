<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeCredit extends Model
{
    use HasFactory;

    protected $table = 'demande_credits';
    
    public $timestamps = false;

    protected $fillable = [ 
        'client_id',
        'agent_id',
        'code_dossier',
        'montant_demande',
        'duree_mois',
        'type_credit',
        'periodicite',
        'objet_pret',
        'photo_personnelle',
        'photo_piece_identite',
        'statut',
        'date_demande',
        'date_traitement',
        'raison_refus',
    ];

    protected $casts = [
        'montant_demande' => 'decimal:2',
        'date_demande' => 'datetime',
        'date_traitement' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function getMontantDemandeFormattedAttribute(): string
    {
        return number_format($this->montant_demande, 2, ',', ' ') . ' FCFA';
    }

    public function getStatutFormattedAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'approuve' => 'Approuvé',
            'refuse' => 'Refusé',
            default => $this->statut,
        };
    }

    public function scopeByStatut($query, string $statut)
    {
        return $query->where('statut', $statut);
    }

    public function scopeRecentes($query, int $days = 30)
    {
        return $query->where('date_demande', '>=', now()->subDays($days));
    }
}
