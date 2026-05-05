<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemandeCreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des clients et agents existants
        $clients = DB::table('clients')->pluck('id')->toArray();
        $agents = DB::table('agents')->pluck('id')->toArray();

        if (empty($clients) || empty($agents)) {
            $this->command->warn('Veuillez d\'abord exécuter les seeders ClientSeeder et AgentSeeder');
            return;
        }

        $demandes = [
            [
                'client_id' => $clients[0] ?? 1,
                'agent_id' => $agents[0] ?? 1,
                'montant_demande' => 500000.00,
                'duree_mois' => 12,
                'differe_mois' => 1,
                'periode_grace' => 0,
                'taux_interet' => 1.8,
                'type_credit' => 'personnel',
                'periodicite' => 'mensuel',
                'objet_pret' => 'Financement projet personnel pour achat d\'équipement',
                'montant_dernier_credit' => 200000.00,
                'photo_personnelle' => 'photos/client1_personnelle.jpg',
                'photo_piece_identite' => 'photos/client1_cni.jpg',
                'garantie_type' => 'hypothèque',
                'garantie_description' => 'Immeuble situé à Cocody Abidjan',
                'garantie_valeur' => 800000.00,
                'statut' => 'en_attente',
                'date_demande' => Carbon::now()->subDays(5),
                'date_traitement' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[1] ?? 2,
                'agent_id' => $agents[1] ?? 2,
                'montant_demande' => 1500000.00,
                'duree_mois' => 24,
                'differe_mois' => 2,
                'periode_grace' => 3,
                'taux_interet' => 2.1,
                'type_credit' => 'immobilier',
                'periodicite' => 'mensuel',
                'objet_pret' => 'Achat appartement à Yopougon',
                'montant_dernier_credit' => 0,
                'photo_personnelle' => 'photos/client2_personnelle.jpg',
                'photo_piece_identite' => 'photos/client2_passeport.jpg',
                'garantie_type' => 'caution',
                'garantie_description' => 'Cautionnaire avec salaire mensuel de 500000 FCFA',
                'garantie_valeur' => 0,
                'statut' => 'en_cours',
                'date_demande' => Carbon::now()->subDays(3),
                'date_traitement' => Carbon::now()->subDays(1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[2] ?? 3,
                'agent_id' => $agents[0] ?? 1,
                'montant_demande' => 750000.00,
                'duree_mois' => 18,
                'differe_mois' => 0,
                'periode_grace' => 1,
                'taux_interet' => 1.9,
                'type_credit' => 'auto',
                'periodicite' => 'mensuel',
                'objet_pret' => 'Achat véhicule Toyota Corolla',
                'montant_dernier_credit' => 300000.00,
                'photo_personnelle' => 'photos/client3_personnelle.jpg',
                'photo_piece_identite' => 'photos/client3_cni.jpg',
                'garantie_type' => 'vehicule',
                'garantie_description' => 'Véhicule de marque Toyota RAV4 année 2020',
                'garantie_valeur' => 400000.00,
                'statut' => 'approuve',
                'date_demande' => Carbon::now()->subDays(10),
                'date_traitement' => Carbon::now()->subDays(7),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[3] ?? 4,
                'agent_id' => $agents[2] ?? 3,
                'montant_demande' => 300000.00,
                'duree_mois' => 6,
                'differe_mois' => 0,
                'periode_grace' => 0,
                'taux_interet' => 2.5,
                'type_credit' => 'conso',
                'periodicite' => 'mensuel',
                'objet_pret' => 'Besoin de trésorerie pour frais scolaires',
                'montant_dernier_credit' => 100000.00,
                'photo_personnelle' => 'photos/client4_personnelle.jpg',
                'photo_piece_identite' => 'photos/client4_cni.jpg',
                'garantie_type' => null,
                'garantie_description' => null,
                'garantie_valeur' => null,
                'statut' => 'refuse',
                'date_demande' => Carbon::now()->subDays(15),
                'date_traitement' => Carbon::now()->subDays(12),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'client_id' => $clients[4] ?? 5,
                'agent_id' => $agents[1] ?? 2,
                'montant_demande' => 2000000.00,
                'duree_mois' => 36,
                'differe_mois' => 3,
                'periode_grace' => 6,
                'taux_interet' => 1.7,
                'type_credit' => 'professionnel',
                'periodicite' => 'trimestriel',
                'objet_pret' => 'Expansion capital pour entreprise de commerce',
                'montant_dernier_credit' => 800000.00,
                'photo_personnelle' => 'photos/client5_personnelle.jpg',
                'photo_piece_identite' => 'photos/client5_passeport.jpg',
                'garantie_type' => 'fond_commerce',
                'garantie_description' => 'Fonds de commerce évalué à 3000000 FCFA',
                'garantie_valeur' => 3000000.00,
                'statut' => 'en_attente',
                'date_demande' => Carbon::now()->subDays(1),
                'date_traitement' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('demande_credits')->insert($demandes);

        $this->command->info('Demandes de crédit créées avec succès!');
    }
}
