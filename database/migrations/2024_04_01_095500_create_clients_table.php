<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->string('piece_identite_type');
            $table->string('piece_identite_numero')->unique();
            $table->date('piece_identite_expiration')->nullable();
            $table->text('adresse_personnelle');
            $table->integer('anciennete_adresse');
            $table->string('telephone');
            $table->string('situation_famille');
            $table->integer('nb_enfants_charge');
            $table->integer('autres_personnes_charge');
            $table->string('nom_pere');
            $table->string('nom_mere');
            $table->string('nom_conjoint')->nullable();
            $table->string('contact_urgence_nom');
            $table->text('contact_urgence_adresse');
            $table->string('activite_principale');
            $table->text('autres_activites')->nullable();
            $table->text('description_activite');
            $table->integer('anciennete_activite');
            $table->boolean('deja_beneficie_credit');
            $table->boolean('respect_engagements');
            $table->integer('nb_retards');
            $table->boolean('credit_en_cours');
            $table->date('date_obtention_credit')->nullable();
            $table->decimal('montant_obtenu_credit', 15, 2);
            $table->string('echeance_credit')->nullable();
            $table->string('institution_credit')->nullable();
            $table->dateTime('date_inscription');
            
            
            
            // Indexes
            $table->index('piece_identite_numero');
            $table->index('telephone');
            $table->index('date_inscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
