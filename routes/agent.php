<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentDashboardController;

/*
|--------------------------------------------------------------------------
| Agent Routes
|--------------------------------------------------------------------------
|
| Routes protégées pour les agents avec préfixe /agent
|
*/

Route::prefix('agent')->middleware(['auth:agent'])->group(function () {
    
    // Demandes de crédit
    Route::get('/demandes', [AgentDashboardController::class, 'demandes'])->name('agent.demandes');
    Route::get('/demandes/create', [AgentDashboardController::class, 'createDemande'])->name('agent.demandes.create');
    Route::post('/demandes', [AgentDashboardController::class, 'storeDemande'])->name('agent.demandes.store');
    Route::get('/demandes/{id}', [AgentDashboardController::class, 'showDemande'])->name('agent.demandes.show');
    Route::put('/demandes/{id}', [AgentDashboardController::class, 'updateDemande'])->name('agent.demandes.update');
    
    // Profil
    Route::get('/profile', [AgentDashboardController::class, 'profile'])->name('agent.profile');
    Route::put('/profile', [AgentDashboardController::class, 'updateProfile'])->name('agent.profile.update');
    
    // Statistiques
    Route::get('/statistiques', [AgentDashboardController::class, 'statistiques'])->name('agent.statistiques');
    
});
