<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Routes avec Guard Admin
|--------------------------------------------------------------------------
*/

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées par le guard admin
Route::middleware(['admin.guard'])->group(function () {
    
    // Dashboard Admin
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Création d'agents
    Route::post('/admin/create-agent', [AuthController::class, 'createAgent'])->name('admin.create.agent');
    
    // Autres routes admin (à ajouter selon besoin)
    Route::get('/admin/users', function () {
        $users = \App\Models\User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    })->name('admin.users');
    
    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});
