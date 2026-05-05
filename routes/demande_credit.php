<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeCreditController;

/*
|--------------------------------------------------------------------------
| Routes pour la gestion des demandes de crédit
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Routes pour les demandes de crédit (authentifiées)
    Route::prefix('demande')->name('demande.')->group(function () {
        Route::get('/', [DemandeCreditController::class, 'index'])->name('index');
        Route::get('/{id}', [DemandeCreditController::class, 'show'])->name('show');
        Route::put('/{id}/statut', [DemandeCreditController::class, 'updateStatut'])->name('update.statut');
        Route::get('/export', [DemandeCreditController::class, 'export'])->name('export');
        Route::get('/statistiques', [DemandeCreditController::class, 'statistiques'])->name('statistiques');
    });
    
    // Route de suivi (accessible sans authentification)
    Route::get('/suivi', [DemandeCreditController::class, 'suivi'])->name('suivi.rechercher');
});

// Routes publiques pour les demandes de crédit
Route::prefix('demande')->name('demande.')->group(function () {
    Route::get('/create', [\App\Http\Controllers\DemandeController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\DemandeController::class, 'store'])->name('store');
});

// Route publique pour la confirmation de demande
Route::get('/demande/confirmation', [DemandeCreditController::class, 'confirmation'])->name('demande.confirmation');

// Route publique pour le suivi
Route::post('/suivi', [DemandeCreditController::class, 'suivi'])->name('suivi.rechercher.post');
