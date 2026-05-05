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
        // Supprimer les champs qui existent encore dans la table clients
        if (Schema::hasColumn('clients', 'deja_beneficie_credit')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('deja_beneficie_credit');
            });
        }

        if (Schema::hasColumn('clients', 'montant_obtenu_credit')) {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('montant_obtenu_credit');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            // Remettre les champs en cas de rollback
            $table->boolean('deja_beneficie_credit');
            $table->decimal('montant_obtenu_credit', 15, 2);
        });
    }
};
