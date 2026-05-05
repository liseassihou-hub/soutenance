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
        Schema::table('clients', function (Blueprint $table) {
            // Ajouter les champs manquants
            $table->date('date_ouverture')->after('date_inscription');
            $table->string('agence')->after('date_ouverture');
            
            // Supprimer uniquement les champs vraiment inutiles (pas dans le formulaire)
            $table->dropColumn([
                'deja_beneficie_credit',
                'nb_retards',
                'date_obtention_credit',
                'montant_obtenu_credit',
                'echeance_credit',
                'institution_credit'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Remettre les champs supprimés
            $table->boolean('deja_beneficie_credit');
            $table->integer('nb_retards');
            $table->date('date_obtention_credit')->nullable();
            $table->decimal('montant_obtenu_credit', 15, 2);
            $table->string('echeance_credit')->nullable();
            $table->string('institution_credit')->nullable();
            
            // Supprimer les champs ajoutés
            $table->dropColumn(['date_ouverture', 'agence']);
        });
    }
};
