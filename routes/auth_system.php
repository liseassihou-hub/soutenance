<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes du système d'authentification séparé
|--------------------------------------------------------------------------
|
| Routes pour l'authentification Admin uniquement
|
*/

// Routes Admin
Route::get('/login-admin', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/login-admin', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login');
Route::get('/login-agent', [App\Http\Controllers\AdminAuthController::class, 'showLoginForm'])->name('agent.login.form');
Route::post('/login-agent', [App\Http\Controllers\AdminAuthController::class, 'login'])->name('agent.login');
Route::post('/admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

// Routes Agent pour le changement de mot de passe
Route::get('/agent/change-password', [App\Http\Controllers\AgentAuthController::class, 'showChangePasswordForm'])->name('agent.change-password');
Route::post('/agent/change-password', [App\Http\Controllers\AgentAuthController::class, 'changePassword'])->name('agent.change-password.submit');

// Routes protégées Admin
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/agents', [App\Http\Controllers\AdminController::class, 'agents'])->name('agents');
    Route::get('/agents/create', [App\Http\Controllers\AdminController::class, 'createAgent'])->name('agents.create');
    Route::post('/agents', [App\Http\Controllers\AdminController::class, 'storeAgent'])->name('agents.store');
    Route::post('/agents/{agent}/toggle', [App\Http\Controllers\AdminController::class, 'toggleAgent'])->name('agents.toggle');
});

?>
