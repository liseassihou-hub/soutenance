<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnifiedAuthController;
use App\Http\Controllers\AgentCreditController;

/*
|--------------------------------------------------------------------------
| Routes Unifiées - Système d'Authentification Unique
|--------------------------------------------------------------------------
*/

// Routes d'authentification unifiées
Route::get('/login', [UnifiedAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UnifiedAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [UnifiedAuthController::class, 'logout'])->name('logout');

// Routes Agent (avec session)
Route::prefix('agent')->name('unified.agent.')->group(function () {
    // Route::get('/dashboard', [\App\Http\Controllers\AgentDashboardController::class, 'dashboard'])->name('dashboard'); // Supprimé
    Route::get('/dossiers', [AgentCreditController::class, 'index'])->name('dossiers');
    Route::get('/dossier/{id}', [AgentCreditController::class, 'show'])->name('dossier.show');
    Route::put('/dossier/{id}/statut', [AgentCreditController::class, 'updateStatut'])->name('dossier.update.statut');
    Route::put('/dossier/{id}/decision', [AgentCreditController::class, 'updateDecisionComite'])->name('dossier.update.decision');
});

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    
    // Routes Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [UnifiedAuthController::class, 'adminDashboard'])->name('dashboard');
        Route::post('/create-user', [UnifiedAuthController::class, 'createUser'])->name('create.user');
        
        // Routes pour la gestion des dossiers (admin)
        Route::get('/dossiers', function () {
            $dossiers = \App\Models\Dossier::orderBy('created_at', 'desc')->paginate(15);
            return view('admin.dossiers', compact('dossiers'));
        })->name('dossiers');
        
        Route::get('/dossier/{id}', function ($id) {
            $dossier = \App\Models\Dossier::findOrFail($id);
            return view('admin.show-dossier', compact('dossier'));
        })->name('dossier.show');
    });
});

// Middleware pour vérifier le rôle
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes accessibles uniquement aux admins
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    // Routes accessibles uniquement aux agents
});
