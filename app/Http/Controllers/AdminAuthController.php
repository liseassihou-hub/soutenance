<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Afficher le formulaire d'inscription admin
     */
    public function showRegistrationForm()
    {
        return view('admin.register');
    }

    /**
     * Traiter l'inscription d'un nouvel admin
     */
    public function register(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string'
            ]);

            // Création du compte admin
            $admin = Admin::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            // Connexion automatique du nouvel admin
            Auth::guard('admin')->login($admin);
            
            // Régénération de la session
            $request->session()->regenerate();
            
            return redirect()->route('admin.dashboard')
                ->with('success', 'Compte administrateur créé avec succès ! Bienvenue ' . $admin->email);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Une erreur technique est survenue lors de la création du compte.');
        }
    }

    /**
     * Afficher le formulaire de connexion admin (route /login)
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Traiter la tentative de connexion admin (route /login et /admin/login)
     */
    public function login(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6'
            ]);

            // Tentative de connexion
            if (Auth::guard('admin')->attempt($validated)) {
                
                // Régénération de la session
                $request->session()->regenerate();
                
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue dans votre espace administrateur !');
            }

            // Échec de connexion
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Identifiants incorrects, veuillez réessayer.');

        } catch (\Exception $e) {
            // Afficher l'erreur pour le débogage
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Erreur de connexion: ' . $e->getMessage());
        }
    }

    /**
     * Déconnexion admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
