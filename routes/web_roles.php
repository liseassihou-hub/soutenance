<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Agent\DashboardController as AgentDashboardController;

/*
|--------------------------------------------------------------------------
| Routes avec Gestion des Rôles
|--------------------------------------------------------------------------
*/

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    
    // Routes Admin (uniquement pour les admins)
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/create-user', [AdminDashboardController::class, 'createUser'])->name('create.user');
        Route::get('/agents', [AdminDashboardController::class, 'agents'])->name('agents');
        Route::get('/dossiers', [AdminDashboardController::class, 'dossiers'])->name('dossiers');
        Route::get('/dossier/{id}', [AdminDashboardController::class, 'showDossier'])->name('dossier.show');
    });

    // Routes Agent (uniquement pour les agents)
    Route::prefix('agent')->name('agent.')->middleware('role:agent')->group(function () {
        // Route::get('/dashboard', [AgentDashboardController::class, 'index'])->name('dashboard'); // Supprimé
        Route::get('/dossiers', [AgentDashboardController::class, 'dossiers'])->name('dossiers');
        Route::get('/dossier/{id}', [AgentDashboardController::class, 'showDossier'])->name('dossier.show');
        Route::put('/dossier/{id}/statut', [AgentDashboardController::class, 'updateStatut'])->name('dossier.update.statut');
        Route::put('/dossier/{id}/decision', [AgentDashboardController::class, 'updateDecisionComite'])->name('dossier.update.decision');
        Route::get('/stats', [AgentDashboardController::class, 'getStats'])->name('stats');
    });

    // Routes partagées (admin et agent)
    Route::prefix('shared')->name('shared.')->group(function () {
        Route::get('/profile', function () {
            return view('shared.profile');
        })->name('profile');
        
        Route::put('/profile', function (Request $request) {
            // Logique de mise à jour du profil
            return back()->with('success', 'Profil mis à jour avec succès.');
        })->name('profile.update');
    });
});

// Routes de fallback pour les utilisateurs non authentifiés
Route::middleware('guest')->group(function () {
    Route::get('/access-denied', function () {
        return view('errors.access-denied');
    })->name('access.denied');
});
