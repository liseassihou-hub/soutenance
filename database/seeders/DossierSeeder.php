<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dossier;

class DossierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dossiers = [
            [
                'code_dossier' => 'DOSS-2024-0001',
                'nom' => 'Diop',
                'prenom' => 'Mamadou',
                'telephone' => '778123456',
                'type_credit' => 'Crédit à la consommation',
                'montant' => 500000,
                'duree' => 12,
                'statut' => 'en_attente',
                'decision_comite' => false,
                'revenus' => 200000,
                'garanties' => 'Voiture de marque Toyota',
                'documents' => 'Pièce d\'identité, Justificatif de domicile, Fiche de paie'
            ],
            [
                'code_dossier' => 'DOSS-2024-0002',
                'nom' => 'Sall',
                'prenom' => 'Aminata',
                'telephone' => '779876543',
                'type_credit' => 'Crédit immobilier',
                'montant' => 5000000,
                'duree' => 36,
                'statut' => 'en_cours',
                'decision_comite' => true,
                'revenus' => 800000,
                'garanties' => 'Appartement en centre-ville',
                'documents' => 'Titre foncier, Relevés bancaires, Certificat de résidence'
            ],
            [
                'code_dossier' => 'DOSS-2024-0003',
                'nom' => 'Ndiaye',
                'prenom' => 'Cheikh',
                'telephone' => '776543210',
                'type_credit' => 'Crédit professionnel',
                'montant' => 2000000,
                'duree' => 24,
                'statut' => 'approuve',
                'decision_comite' => true,
                'revenus' => 500000,
                'garanties' => 'Matériel informatique, Stock de marchandises',
                'documents' => 'Registre de commerce, Plan d\'affaires, Bilan financier'
            ],
            [
                'code_dossier' => 'DOSS-2024-0004',
                'nom' => 'Ba',
                'prenom' => 'Fatou',
                'telephone' => '774567890',
                'type_credit' => 'Crédit étudiant',
                'montant' => 300000,
                'duree' => 18,
                'statut' => 'rejete',
                'decision_comite' => false,
                'revenus' => 50000,
                'garanties' => 'Aucune garantie',
                'documents' => 'Certificat de scolarité, Carte d\'étudiant',
                'observation' => 'Revenus insuffisants pour le montant demandé'
            ],
            [
                'code_dossier' => 'DOSS-2024-0005',
                'nom' => 'Faye',
                'prenom' => 'Omar',
                'telephone' => '772345678',
                'type_credit' => 'Crédit automobile',
                'montant' => 3000000,
                'duree' => 48,
                'statut' => 'en_attente',
                'decision_comite' => false,
                'revenus' => 600000,
                'garanties' => 'Permis de conduire, Assurance automobile',
                'documents' => 'Permis de conduire, Devis du véhicule, Justificatif de revenus'
            ]
        ];

        foreach ($dossiers as $dossier) {
            Dossier::create($dossier);
        }
    }
}
