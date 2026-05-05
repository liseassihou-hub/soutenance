<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Application de Microfinance
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});

// AUTHENTIFICATION AGENT
Route::middleware('guest:agent')->prefix('agent')->name('agent.')->group(function () {
    Route::get('/login', [AgentController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AgentController::class, 'login'])->name('login.submit');
});

// ESPACE AGENT PROTÉGÉ
Route::middleware(['auth:agent'])->prefix('agent')->name('agent.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
    
    // GESTION DES DOSSIERS
    Route::get('/dossiers', [AgentController::class, 'index'])->name('dossiers.index');           // Lister les dossiers
    Route::get('/dossiers/{dossier}', [AgentController::class, 'show'])->name('dossiers.show');   // Voir un dossier
    
    // ROUTE CRITIQUE : MISE À JOUR DU STATUT
    Route::put('/dossiers/{dossier}/update', [AgentController::class, 'update'])->name('dossiers.update');
    
    // Autres routes agent
    Route::get('/profile', [AgentController::class, 'profile'])->name('profile');
    Route::post('/logout', [AgentController::class, 'logout'])->name('logout');
});

// ESPACE ADMIN PROTÉGÉ
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dossiers', [AdminController::class, 'dossiers'])->name('dossiers.index');
    Route::get('/dossiers/{dossier}', [AdminController::class, 'show'])->name('dossiers.show');
});

// AUTHENTIFICATION ADMIN
Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');
});
