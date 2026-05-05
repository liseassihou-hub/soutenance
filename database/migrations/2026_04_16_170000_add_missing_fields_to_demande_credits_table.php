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
        Schema::table('demande_credits', function (Blueprint $table) {
            // Ajouter les champs manquants s'ils n'existent pas
            if (!Schema::hasColumn('demande_credits', 'differe_mois')) {
                $table->integer('differe_mois')->default(0);
            }
            
            if (!Schema::hasColumn('demande_credits', 'periode_grace')) {
                $table->integer('periode_grace')->default(0);
            }
            
            if (!Schema::hasColumn('demande_credits', 'taux_interet')) {
                $table->decimal('taux_interet', 5, 2)->default(1.80);
            }
            
            if (!Schema::hasColumn('demande_credits', 'raison_refus')) {
                $table->text('raison_refus')->nullable();
            }
            
            // S'assurer que les colonnes existent avec les bons types
            $table->string('type_credit', 191)->change();
            $table->string('periodicite', 191)->change();
            $table->text('objet_pret')->change();
            $table->decimal('montant_dernier_credit', 12, 2)->nullable()->change();
            $table->string('photo_personnelle', 191)->nullable()->change();
            $table->string('photo_piece_identite', 191)->nullable()->change();
            $table->string('garantie_type', 191)->nullable()->change();
            $table->text('garantie_description')->nullable()->change();
            $table->decimal('garantie_valeur', 12, 2)->nullable()->change();
            $table->enum('statut', ['en_attente', 'en_cours', 'approuve', 'refuse'])->default('en_attente')->change();
            $table->date('date_demande')->change();
            $table->date('date_traitement')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_credits', function (Blueprint $table) {
            // Ces colonnes sont essentielles, on ne les supprime pas
            // On pourrait seulement modifier les types si nécessaire
        });
    }
};
