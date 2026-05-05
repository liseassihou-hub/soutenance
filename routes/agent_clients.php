<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\ClientController;

/*
|--------------------------------------------------------------------------
| Agent Client Routes
|--------------------------------------------------------------------------
|
| Routes pour la gestion des clients par les agents
|
*/

Route::prefix('agent/clients')->name('agent.clients.')->middleware(['auth:agent'])->group(function () {
    
    // Liste des clients
    Route::get('/', [ClientController::class, 'index'])->name('index');
    
    // Détails d'un client
    Route::get('/{id}', [ClientController::class, 'show'])->name('show');
    
    // Mettre à jour le statut d'un client
    Route::put('/{id}/statut', [ClientController::class, 'updateStatut'])->name('update.statut');
    
    // API pour les statistiques
    Route::get('/api/stats', [ClientController::class, 'apiStats'])->name('api.stats');
    
});
