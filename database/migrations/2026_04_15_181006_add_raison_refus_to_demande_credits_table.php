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
        if (!Schema::hasColumn('demande_credits', 'raison_refus')) {
            Schema::table('demande_credits', function (Blueprint $table) {
                $table->text('raison_refus')->nullable()->after('date_traitement');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_credits', function (Blueprint $table) {
            $table->dropColumn('raison_refus');
        });
    }
};
