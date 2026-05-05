<?php

use App\Http\Controllers\DemandeCreditController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    
    // Liste des demandes de crédit
    Route::get('/demande-credits', [DemandeCreditController::class, 'index'])
        ->name('demande-credits.index');
    
    // Formulaire de modification du statut
    Route::get('/demande-credits/{demandeCredit}/edit', [DemandeCreditController::class, 'edit'])
        ->name('demande-credits.edit');
    
    // Mise à jour du statut
    Route::patch('/demande-credits/{demandeCredit}/statut', [DemandeCreditController::class, 'updateStatut'])
        ->name('demande-credits.updateStatut');
    
    // Affichage des détails (lecture seule)
    Route::get('/demande-credits/{demandeCredit}', [DemandeCreditController::class, 'show'])
        ->name('demande-credits.show');
    
    // API pour les statistiques
    Route::get('/api/demande-credits/stats', [DemandeCreditController::class, 'stats'])
        ->name('demande-credits.stats');
});
