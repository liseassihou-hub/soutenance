<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemandeCreditController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');

// Inclure les routes de gestion des demandes de crédit
require __DIR__.'/demande-credits.php';

// Autres routes existantes...
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth']);
