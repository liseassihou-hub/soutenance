<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'date_naissance' => $this->faker->date('Y-m-d', '-18 years'),
            'lieu_naissance' => $this->faker->city,
            'piece_identite_type' => $this->faker->randomElement(['CNI', 'Passeport', 'Permis de conduire']),
            'piece_identite_numero' => $this->faker->unique()->numerify('#########'),
            'piece_identite_expiration' => $this->faker->date('Y-m-d', '+5 years'),
            'adresse_personnelle' => $this->faker->address,
            'anciennete_adresse' => $this->faker->numberBetween(1, 20),
            'telephone' => $this->faker->phoneNumber,
            'situation_famille' => $this->faker->randomElement(['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)']),
            'nb_enfants_charge' => $this->faker->numberBetween(0, 8),
            'autres_personnes_charge' => $this->faker->numberBetween(0, 5),
            'nom_pere' => $this->faker->lastName,
            'nom_mere' => $this->faker->lastName,
            'nom_conjoint' => $this->faker->optional(0.6)->lastName,
            'contact_urgence_nom' => $this->faker->name,
            'contact_urgence_adresse' => $this->faker->address,
            'activite_principale' => $this->faker->randomElement(['Agriculture', 'Commerce', 'Artisanat', 'Services', 'Élevage']),
            'autres_activites' => $this->faker->optional(0.4)->text,
            'description_activite' => $this->faker->text,
            'anciennete_activite' => $this->faker->numberBetween(1, 25),
            'deja_beneficie_credit' => $this->faker->boolean(50),
            'respect_engagements' => $this->faker->boolean(80),
            'nb_retards' => $this->faker->numberBetween(0, 10),
            'credit_en_cours' => $this->faker->boolean(30),
            'date_obtention_credit' => $this->faker->optional(0.3)->date('Y-m-d', '-2 years'),
            'montant_obtenu_credit' => $this->faker->randomFloat(2, 0, 5000000),
            'echeance_credit' => $this->faker->optional(0.3)->randomElement(['Mensuelle', 'Bimensuelle', 'Trimestrielle']),
            'institution_credit' => $this->faker->optional(0.3)->company,
            'date_inscription' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
