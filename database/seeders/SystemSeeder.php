<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class SystemSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les agents par défaut
        $agents = [
            [
                'prenom' => 'Koffi',
                'nom' => 'Mensah',
                'email' => 'koffi@sfd.com',
                'password' => Hash::make('Agent123!'),
                'statut' => 'actif',
            ],
            [
                'prenom' => 'Awa',
                'nom' => 'Diallo',
                'email' => 'awa@sfd.com',
                'password' => Hash::make('Agent123!'),
                'statut' => 'actif',
            ],
        ];

        foreach ($agents as $agent) {
            Agent::create($agent);
        }

        // Créer les demandes fictives
        $demandes = [
            [
                'code' => 'CRD-2025-001',
                'nom' => 'Konan Yves',
                'telephone' => '+225 07 89 45 12 33',
                'type_credit' => 'Crédit Consommation',
                'montant' => 2500000,
                'duree' => 12,
                'objet' => 'Achat d\'équipement ménager',
                'revenus' => 350000,
                'statut' => 'soumis',
                'agent_id' => 1,
            ],
            [
                'code' => 'CRD-2025-002',
                'nom' => 'Adjara Touré',
                'telephone' => '+225 05 67 89 01 23',
                'type_credit' => 'Crédit Auto',
                'montant' => 5000000,
                'duree' => 24,
                'objet' => 'Achat véhicule',
                'revenus' => 600000,
                'statut' => 'en_cours',
                'agent_id' => 1,
            ],
            [
                'code' => 'CRD-2025-003',
                'nom' => 'Bakary Konaté',
                'telephone' => '+225 08 90 12 34 56',
                'type_credit' => 'Crédit Immobilier',
                'montant' => 15000000,
                'duree' => 60,
                'objet' => 'Construction maison',
                'revenus' => 800000,
                'statut' => 'soumis',
                'agent_id' => 2,
            ],
            [
                'code' => 'CRD-2025-004',
                'nom' => 'Fatoumata Bamba',
                'telephone' => '+225 04 56 78 90 12',
                'type_credit' => 'Crédit Consommation',
                'montant' => 1500000,
                'duree' => 6,
                'objet' => 'Frais scolaires',
                'revenus' => 450000,
                'statut' => 'accepte',
                'agent_id' => 2,
            ],
            [
                'code' => 'CRD-2025-005',
                'nom' => 'Mamadou Diarra',
                'telephone' => '+225 07 23 45 67 89',
                'type_credit' => 'Crédit Pro',
                'montant' => 8000000,
                'duree' => 36,
                'objet' => 'Expansion entreprise',
                'revenus' => 1200000,
                'statut' => 'en_cours',
                'agent_id' => 1,
            ],
            [
                'code' => 'CRD-2025-006',
                'nom' => 'Aminata Sow',
                'telephone' => '+225 06 78 90 12 34',
                'type_credit' => 'Crédit Consommation',
                'montant' => 3000000,
                'duree' => 12,
                'objet' => 'Urgence médicale',
                'revenus' => 400000,
                'statut' => 'refuse',
                'agent_id' => 2,
            ],
        ];

        foreach ($demandes as $demande) {
            Client::create($demande);
        }

        // Ajouter quelques entrées d'historique
        $historiques = [
            [
                'client_id' => 2,
                'ancien_statut' => 'soumis',
                'nouveau_statut' => 'en_cours',
                'commentaire' => 'Dossier en cours d\'analyse',
                'date' => now(),
            ],
            [
                'client_id' => 4,
                'ancien_statut' => 'soumis',
                'nouveau_statut' => 'en_cours',
                'commentaire' => 'Analyse rapide',
                'date' => now(),
            ],
            [
                'client_id' => 4,
                'ancien_statut' => 'en_cours',
                'nouveau_statut' => 'accepte',
                'commentaire' => 'Crédit approuvé',
                'date' => now(),
            ],
        ];

        foreach ($historiques as $historique) {
            Historique::create($historique);
        }

        // Ajouter au journal
        $journal = [
            [
                'agent_nom' => 'Koffi Mensah',
                'code' => 'CRD-2025-002',
                'ancien_statut' => 'soumis',
                'nouveau_statut' => 'en_cours',
                'date' => now(),
            ],
            [
                'agent_nom' => 'Awa Diallo',
                'code' => 'CRD-2025-004',
                'ancien_statut' => 'en_cours',
                'nouveau_statut' => 'accepte',
                'date' => now(),
            ],
        ];

        foreach ($journal as $entry) {
            Journal::create($entry);
        }
    }
}
