<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\AgentProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\SuiviDemandeController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\NosCreditsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/credits', [\App\Http\Controllers\CreditController::class, 'index'])->name('credits.index');
Route::get('/nos-credits', [\App\Http\Controllers\NosCreditsController::class, 'index'])->name('nos-credits');

// Routes de demande de crédit (publiques)
Route::get('/demande/create', [\App\Http\Controllers\DemandeController::class, 'create'])->name('demande.create');
Route::post('/demande/store', [\App\Http\Controllers\DemandeController::class, 'store'])->name('demande.store');
Route::get('/confirmation', function() {
    return view('confirmation');
})->name('confirmation');

// Routes de suivi (publiques)
Route::get('/suivi-demande', [\App\Http\Controllers\SuiviDemandeController::class, 'form'])->name('suivi.form');
Route::post('/suivi-rechercher', [\App\Http\Controllers\SuiviDemandeController::class, 'rechercher'])->name('suivi.rechercher');

// Routes Admin
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/create-agent', [App\Http\Controllers\AdminController::class, 'createAgentForm'])->name('create-agent');
    Route::delete('/agent/{id}', [App\Http\Controllers\AdminController::class, 'deleteAgent'])->name('agent.delete');
    Route::get('/demandes', [App\Http\Controllers\AdminController::class, 'demandes'])->name('demandes');
    Route::get('/journal', [App\Http\Controllers\AdminController::class, 'journal'])->name('journal');
    Route::get('/demandes/{client}', [App\Http\Controllers\AdminController::class, 'showDemande'])->name('show-demande');
    Route::post('/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('logout');
});

// ROUTES AGENT - VERSION CORRIGÉE
Route::middleware(['auth:agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
    Route::get('/dossiers', [AgentController::class, 'index'])->name('dossiers.index');
    Route::get('/dossiers/{id}', [AgentController::class, 'show'])->name('dossiers.show');
    
    // ROUTE CRITIQUE - MISE À JOUR STATUT
    Route::patch('/dossiers/{id}/statut', [AgentController::class, 'updateStatut'])->name('dossiers.updateStatut');
    
    Route::get('/parametres', [AgentController::class, 'parametres'])->name('parametres');
    Route::patch('/parametres', [AgentController::class, 'updateParametres'])->name('updateParametres');
    Route::get('/profile', [AgentProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [AgentProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [AgentProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [AgentProfileController::class, 'showPasswordForm'])->name('change-password');
    Route::post('/change-password', [AgentProfileController::class, 'changePassword'])->name('change-password.submit');
    Route::post('/logout', [AgentAuthController::class, 'logout'])->name('logout');
});

// Routes Agent (changement mot de passe obligatoire)
Route::get('/agent/change-password', [AgentAuthController::class, 'showChangePasswordForm'])->name('agent.change-password');
Route::post('/agent/change-password', [AgentAuthController::class, 'changePassword'])->name('agent.change-password.submit');

// Authentification Admin
Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});

// Authentification Agent
Route::middleware('guest:agent')->prefix('agent')->name('agent.')->group(function () {
    Route::get('/login', [AgentAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AgentAuthController::class, 'login'])->name('login.submit');
});
