<?php

use Illuminate\Database\Seeder;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Vider la table clients
        DB::table('clients')->delete();

        // Créer 20 clients de test
        Client::factory()->count(20)->create();

        // Créer quelques clients spécifiques pour les tests
        Client::create([
            'nom' => 'Diop',
            'prenom' => 'Mamadou',
            'sexe' => 'M',
            'date_naissance' => '1985-06-15',
            'lieu_naissance' => 'Dakar',
            'piece_identite_type' => 'CNI',
            'piece_identite_numero' => '1234567890123',
            'piece_identite_expiration' => '2030-06-15',
            'adresse_personnelle' => '123 Rue de la République, Dakar',
            'anciennete_adresse' => 5,
            'telephone' => '+221771234567',
            'situation_famille' => 'Marié(e)',
            'nb_enfants_charge' => 3,
            'autres_personnes_charge' => 1,
            'nom_pere' => 'Diop',
            'nom_mere' => 'Diop',
            'nom_conjoint' => 'Diop',
            'contact_urgence_nom' => 'Aliou Diop',
            'contact_urgence_adresse' => '456 Avenue Faidherbe, Dakar',
            'activite_principale' => 'Commerce',
            'autres_activites' => 'Vente de produits électroniques',
            'description_activite' => 'Commerçant dans le quartier de Medina',
            'anciennete_activite' => 8,
            'deja_beneficie_credit' => true,
            'respect_engagements' => true,
            'nb_retards' => 0,
            'credit_en_cours' => false,
            'date_obtention_credit' => '2023-01-15',
            'montant_obtenu_credit' => 500000.00,
            'echeance_credit' => 'Mensuelle',
            'institution_credit' => 'Banque Nationale',
            'date_inscription' => '2024-01-15 10:30:00',
        ]);

        Client::create([
            'nom' => 'Fall',
            'prenom' => 'Aminata',
            'sexe' => 'F',
            'date_naissance' => '1990-03-22',
            'lieu_naissance' => 'Thiès',
            'piece_identite_type' => 'Passeport',
            'piece_identite_numero' => 'P987654321',
            'piece_identite_expiration' => '2028-03-22',
            'adresse_personnelle' => '789 Boulevard de la Liberté, Thiès',
            'anciennete_adresse' => 3,
            'telephone' => '+221762345678',
            'situation_famille' => 'Célibataire',
            'nb_enfants_charge' => 0,
            'autres_personnes_charge' => 0,
            'nom_pere' => 'Fall',
            'nom_mere' => 'Fall',
            'contact_urgence_nom' => 'Ousmane Fall',
            'contact_urgence_adresse' => '321 Rue du Commerce, Thiès',
            'activite_principale' => 'Artisanat',
            'autres_activites' => 'Confection de vêtements traditionnels',
            'description_activite' => 'Artisane spécialisée dans les tissus wax',
            'anciennete_activite' => 5,
            'deja_beneficie_credit' => false,
            'respect_engagements' => true,
            'nb_retards' => 0,
            'credit_en_cours' => false,
            'date_inscription' => '2024-02-20 14:15:00',
        ]);
    }
}
