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
            // Supprimer les champs inutilisés seulement s'ils existent
            $columnsToDrop = [
                'deja_beneficie_credit',
                'respect_engagements', 
                'nb_retards',
                'date_obtention_credit',
                'montant_obtenu_credit',
                'echeance_credit',
                'institution_credit'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('clients', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Remettre les champs en cas de rollback
            $table->boolean('deja_beneficie_credit');
            $table->boolean('respect_engagements');
            $table->integer('nb_retards');
            $table->date('date_obtention_credit')->nullable();
            $table->decimal('montant_obtenu_credit', 15, 2);
            $table->string('echeance_credit')->nullable();
            $table->string('institution_credit')->nullable();
        });
    }
};
