<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

// Routes principales
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

// Routes Admin (protégé par middleware auth:admin)
Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/clients', [App\Http\Controllers\Admin\AdminController::class, 'clients'])->name('clients');
    Route::get('/clients/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showClient'])->name('clients.show');
    Route::get('/clients/search', [App\Http\Controllers\Admin\AdminController::class, 'searchClients'])->name('clients.search');
    Route::get('/clients/search-ajax', [App\Http\Controllers\Admin\AdminController::class, 'searchClientsAjax'])->name('clients.search.ajax');
    Route::get('/agents', [App\Http\Controllers\Admin\AdminController::class, 'agents'])->name('agents');
    Route::get('/settings', [App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
    Route::get('/agents/create', [App\Http\Controllers\Admin\AdminController::class, 'createAgentForm'])->name('agents.create');
    Route::post('/agents', [App\Http\Controllers\Admin\AdminController::class, 'createAgent'])->name('agents.store');
    Route::get('/agents/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'editAgentForm'])->name('agents.edit');
    Route::get('/agents/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showAgent'])->name('agents.show');
    Route::post('/agents/{id}/toggle', [App\Http\Controllers\Admin\AdminController::class, 'toggleAgentStatus'])->name('agents.toggle');
    Route::put('/agents/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updateAgent'])->name('agents.update');
    Route::delete('/agents/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroyAgent'])->name('agents.destroy');
    Route::get('/demandes/search', [App\Http\Controllers\Admin\AdminController::class, 'searchDemandes'])->name('admin.demandes.search');
    Route::get('/demandes/{id}', [App\Http\Controllers\Admin\AdminController::class, 'showDemande'])->name('demande.show');
    Route::get('/demandes', [App\Http\Controllers\Admin\AdminController::class, 'demandes'])->name('demandes');
    // Routes alternatives pour compatibilité (rediriger vers les bonnes URLs)
    Route::get('/demande', function() {
        return redirect()->route('admin.demandes');
    });
    Route::get('/demande/{id}', function($id) {
        return redirect()->route('admin.demande.show', $id);
    });
    Route::get('/demandes/search', [App\Http\Controllers\Admin\AdminController::class, 'searchDemandes'])->name('demandes.search');
    Route::get('/journal', [App\Http\Controllers\Admin\AdminController::class, 'journal'])->name('journal');
});

// Routes de connexion Agent
Route::get('/agent/login', [App\Http\Controllers\AgentAuthController::class, 'showLoginForm'])->name('agent.login');
Route::post('/agent/login', [App\Http\Controllers\AgentAuthController::class, 'login'])->name('agent.login.submit');
Route::post('/agent/logout', [App\Http\Controllers\AgentAuthController::class, 'logout'])->name('agent.logout');

// Routes Agent (protégé par middleware auth:agent)
Route::prefix('agent')->name('agent.')->middleware(['auth:agent', 'session.cookie:agent'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Agent\AgentController::class, 'dashboard'])->name('dashboard');
    Route::get('/dossiers', [App\Http\Controllers\Agent\AgentController::class, 'dossiers'])->name('dossiers');
    Route::get('/dossiers/{id}', [App\Http\Controllers\Agent\AgentController::class, 'showDossier'])->name('dossiers.show');
    Route::get('/dossiers/{id}/edit', [App\Http\Controllers\Agent\AgentController::class, 'editDossier'])->name('dossiers.edit');
    Route::put('/dossiers/{id}', [App\Http\Controllers\Agent\AgentController::class, 'updateDossier'])->name('dossiers.update');
    Route::post('/dossiers/{id}/approuver', [App\Http\Controllers\Agent\AgentController::class, 'approuverDossier'])->name('dossiers.approuver');
    Route::post('/dossiers/{id}/refuser', [App\Http\Controllers\Agent\AgentController::class, 'refuserDossier'])->name('dossiers.refuser');
    Route::get('/parametres', [App\Http\Controllers\Agent\AgentController::class, 'parametres'])->name('parametres');
    Route::patch('/parametres', [App\Http\Controllers\Agent\AgentController::class, 'updateParametres'])->name('updateParametres');
    Route::post('/change-password', [App\Http\Controllers\AgentAuthController::class, 'changePassword'])->name('change-password');
    });

// Routes existantes (compatibilité)
Route::get('/credits', [\App\Http\Controllers\CreditController::class, 'index'])->name('credits.index');
Route::get('/nos-credits', [\App\Http\Controllers\NosCreditsController::class, 'index'])->name('nos-credits');
Route::get('/nos-services', function () {
    return view('nos-services');
})->name('nos-services');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/epargne', function () {
    return view('epargne');
})->name('epargne');
Route::get('/demande/create', [\App\Http\Controllers\DemandeController::class, 'create'])->name('demande.create');
Route::post('/demande/store', [\App\Http\Controllers\DemandeController::class, 'store'])->name('demande.store');
Route::get('/confirmation', function() {
    return view('confirmation');
})->name('confirmation');

// Routes API pour les demandes de crédit
Route::prefix('api')->group(function () {
    Route::post('/demande-credit', [\App\Http\Controllers\DemandeController::class, 'apiStore'])->name('api.demande.store');
    Route::get('/demande/{codeSuivi}', [\App\Http\Controllers\SuiviDemandeController::class, 'apiShow'])->name('api.demande.show');
});

// La page que tu m'as montrée (affichage du formulaire de recherche)
Route::get('/suivi-demande', [\App\Http\Controllers\DemandeController::class, 'showSuivi'])->name('suivi-demande');

// La logique de recherche (quand on clique sur le bouton "Rechercher")
Route::post('/suivi-demande', [\App\Http\Controllers\DemandeController::class, 'rechercher'])->name('suivi.rechercher');

// La page de récupération de code oublié
Route::get('/recuperation', [\App\Http\Controllers\DemandeController::class, 'showRecuperation'])->name('recuperation');

// La logique de récupération (quand on clique sur le bouton "Rechercher mon code")
Route::post('/recuperation', [\App\Http\Controllers\DemandeController::class, 'recupererCode'])->name('recuperation.rechercher');