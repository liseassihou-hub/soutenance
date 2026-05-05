<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creditTypes = [
            [
                'nom_credit' => 'Crédit Commerce',
                'description' => 'Financement pour les commerçants et petits entrepreneurs pour développer leurs activités commerciales.',
                'montant_min' => 50000,
                'montant_max' => 2000000,
                'duree_max' => 24,
            ],
            [
                'nom_credit' => 'Crédit Agriculture',
                'description' => 'Soutien financier pour les agriculteurs pour l\'achat d\'intrants et matériel agricole.',
                'montant_min' => 100000,
                'montant_max' => 5000000,
                'duree_max' => 36,
            ],
            [
                'nom_credit' => 'Crédit Consommation',
                'description' => 'Prêt personnel pour faire face aux besoins immédiats et dépenses personnelles.',
                'montant_min' => 25000,
                'montant_max' => 1000000,
                'duree_max' => 18,
            ],
            [
                'nom_credit' => 'Crédit Éducation',
                'description' => 'Financement pour les frais de scolarité et dépenses éducatives des enfants.',
                'montant_min' => 50000,
                'montant_max' => 1500000,
                'duree_max' => 12,
            ],
            [
                'nom_credit' => 'Crédit Habitat',
                'description' => 'Aide financière pour la construction, rénovation ou amélioration de logement.',
                'montant_min' => 500000,
                'montant_max' => 10000000,
                'duree_max' => 60,
            ],
        ];

        foreach ($creditTypes as $creditType) {
            \App\Models\CreditType::create($creditType);
        }
    }
}
