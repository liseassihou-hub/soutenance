<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'piece_identite_type',
        'piece_identite_numero',
        'piece_identite_expiration',
        'adresse_personnelle',
        'telephone',
        'numero_compte',
        'description_activite',
       
    ];

    protected $casts = [
        'piece_identite_expiration' => 'date',
    ];

    public function demandesCredit(): HasMany
    {
        return $this->hasMany(DemandeCredit::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getAgeAttribute(): int
    {
        
        return 0; 
    }
}
