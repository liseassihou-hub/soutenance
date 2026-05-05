<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Routes pour les clients avec vérification du statut
|
*/

Route::prefix('client')->name('client.')->middleware(['client.status.check'])->group(function () {
    
    // Dashboard client (protégé par le middleware de statut)
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard')->middleware('auth:client');
    
    // Profil client (protégé par le middleware de statut)
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile')->middleware('auth:client');
    
    // Routes publiques
    Route::get('/login', [ClientController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ClientController::class, 'logout'])->name('logout');
    
});
