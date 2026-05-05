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
            // Supprimer les champs inutilisés seulement s'ils existent
            $columnsToDrop = [
                'differe_mois',
                'periode_grace'
            ];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('demande_credits', $column)) {
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
        Schema::table('demande_credits', function (Blueprint $table) {
            // Remettre les champs en cas de rollback
            $table->integer('differe_mois')->default(0);
            $table->integer('periode_grace')->default(0);
        });
    }
};
