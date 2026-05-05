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
        Schema::create('demande_credits', function (Blueprint $table) {
            $table->id();
            
            // Clés étrangères
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
            
            // Montants et durées
            $table->decimal('montant_demande', 12, 2);
            $table->integer('duree_mois');
            $table->integer('differe_mois')->default(0);
            $table->integer('periode_grace')->default(0);
            
            // Taux et type de crédit
            $table->decimal('taux_interet', 5, 2)->default(1.8);
            $table->string('type_credit');
            $table->string('periodicite');
            
            // Objet et garanties
            $table->text('objet_pret');
            $table->decimal('montant_dernier_credit', 12, 2)->nullable();
            $table->string('photo_personnelle')->nullable();
            $table->string('photo_piece_identite')->nullable();
            $table->string('garantie_type')->nullable();
            $table->text('garantie_description')->nullable();
            $table->decimal('garantie_valeur', 12, 2)->nullable();
            
            // Statut et dates
            $table->enum('statut', ['en_attente', 'en_cours', 'approuve', 'refuse'])->default('en_attente');
            $table->date('date_demande');
            $table->date('date_traitement')->nullable();
            
            // Index pour optimisation
            $table->index('client_id');
            $table->index('agent_id');
            $table->index('statut');
            $table->index('date_demande');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_credits');
    }
};
