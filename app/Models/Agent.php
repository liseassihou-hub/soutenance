<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agent extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'email',
        'statut',
        'telephone',
        'password',
      
    ];

    protected $hidden = [
        'password',
       
    ];

    public $timestamps = false;

     
    public function getAuthPassword()
    {
        return $this->password;
    }

    
    public function demandesTraitees()
    {
        return $this->hasMany(\App\Models\DemandeCredit::class, 'agent_id');
    }
}
