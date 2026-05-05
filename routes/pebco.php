<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PEBCO\AuthController;
use App\Http\Controllers\PEBCO\AdminController;
use App\Http\Controllers\PEBCO\AgentController;
use App\Http\Controllers\SuiviDemandeController;

/*
|--------------------------------------------------------------------------
| Routes PEBCO BETHESDA - SFD
|--------------------------------------------------------------------------
|
| Routes pour la digitalisation des suivis de demande de crédit
| Architecture : Admin (création/gestion agents) + Agent (traitement demandes)
|
*/

// Routes d'authentification (publiques)
Route::prefix('auth')->name('pebco.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    
    // Routes Admin (protégées par rôle admin)
    Route::prefix('admin')->name('pebco.admin.')->middleware('pebco.admin')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Gestion des agents
        Route::get('/agents', [AdminController::class, 'agents'])->name('agents');
        Route::get('/agents/create', [AdminController::class, 'createAgent'])->name('agents.create');
        Route::post('/agents', [AdminController::class, 'storeAgent'])->name('agents.store');
        Route::get('/agents/{id}/edit', [AdminController::class, 'editAgent'])->name('agents.edit');
        Route::put('/agents/{id}', [AdminController::class, 'updateAgent'])->name('agents.update');
        Route::delete('/agents/{id}', [AdminController::class, 'deleteAgent'])->name('agents.delete');
        
        // Gestion des demandes
        Route::get('/demandes', [AdminController::class, 'demandes'])->name('demandes');
        Route::get('/demandes/{id}', [AdminController::class, 'showDemande'])->name('demandes.show');
        
        // API Admin
        Route::get('/api/stats', [AdminController::class, 'apiStats'])->name('api.stats');
    });

    // Routes Agent (protégées par rôle agent)
    Route::prefix('agent')->name('pebco.agent.')->group(function () {
        
        // Routes protégées
        Route::middleware('pebco.agent')->group(function () {
            // Profil de l'agent
            Route::get('/profil', [AgentController::class, 'profil'])->name('profil');
            Route::put('/profil', [AgentController::class, 'updateProfil'])->name('profil.update');
            Route::get('/profil/password', [AgentController::class, 'editPassword'])->name('profil.password');
            Route::put('/profil/password', [AgentController::class, 'updatePassword'])->name('profil.password.update');
            
            // Gestion des demandes de crédit
            Route::get('/demandes', [AgentController::class, 'demandes'])->name('demandes');
            Route::get('/demandes/create', [AgentController::class, 'createDemande'])->name('demandes.create');
            Route::post('/demandes', [AgentController::class, 'storeDemande'])->name('demandes.store');
            Route::get('/demandes/{id}', [AgentController::class, 'showDemande'])->name('demandes.show');
            Route::put('/demandes/{id}/statut', [AgentController::class, 'updateStatut'])->name('demandes.update.statut');
            
            // API Agent
            Route::get('/api/stats', [AgentController::class, 'apiStats'])->name('api.stats');
        });
    });
});

// Routes de suivi public (pour les clients)
Route::prefix('suivi')->name('pebco.suivi.')->group(function () {
    Route::get('/', [SuiviDemandeController::class, 'form'])->name('form');
    Route::post('/rechercher', [SuiviDemandeController::class, 'rechercher'])->name('rechercher');
});

// Routes API publiques
Route::prefix('api')->group(function () {
    Route::get('/stats', [AuthController::class, 'getLoginStats'])->name('api.stats');
});
