<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dossier extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nom de la table (si différent du nom du modèle)
     */
    protected $table = 'dossiers';

    /**
     * Champs remplissables (mass assignment)
     * ⚠️ TRÈS IMPORTANT : Tous les champs qu'on peut mettre à jour via update()
     */
    protected $fillable = [
        'nom',
        'prenom', 
        'email',
        'telephone',
        'montant',
        'type_credit',
       'objet_pret',
        'duree',
        'garantie',
        'photo_personnelle',
        'photo_carte_identite',
        'code_dossier',
        'statut',                   
        'observation_refus',         // ⭐ Observation si refusé
                   
        'agent_id',                  // ⭐ Agent qui traite le dossier
        
        
    ];

    
    protected $casts = [
        'montant' => 'decimal:2',
        'date_decision' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
       
    ];

   

    
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

   
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

   
    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    
    public function scopeAcceptes($query)
    {
        return $query->where('statut', 'accepte');
    }

   
    public function scopeRefuses($query)
    {
        return $query->where('statut', 'refuse');
    }

    
    public function getStatutFormattedAttribute()
    {
        return match($this->statut) {
            'en_attente' => '<span class="badge bg-yellow-100 text-yellow-800">🟡 En attente</span>',
            'en_cours' => '<span class="badge bg-blue-100 text-blue-800">🔵 En cours</span>',
            'accepte' => '<span class="badge bg-green-100 text-green-800">🟢 Accepté</span>',
            'refuse' => '<span class="badge bg-red-100 text-red-800">🔴 Refusé</span>',
            default => '<span class="badge bg-gray-100 text-gray-800">❓ Inconnu</span>',
        };
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value;
        
        // Si le statut change vers une décision finale, mettre à jour la date
        if (in_array($value, ['accepte', 'refuse'])) {
            $this->attributes['date_decision'] = now();
        }
    }

    /**
     * Générer un code de dossier unique
     */
    public static function generateCodeDossier()
    {
        do {
            $code = 'DOSS-' . date('Y') . '-' . strtoupper(uniqid());
        } while (self::where('code_dossier', $code)->exists());
        
        return $code;
    }
}
