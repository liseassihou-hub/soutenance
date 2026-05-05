<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;

class AgentAuthController extends Controller
{
    /**
     * Afficher le formulaire de connexion agent
     */
    public function showLoginForm()
    {
        return view('agent.login');
    }

    /**
     * Traiter la tentative de connexion agent
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
            if (Auth::guard('agent')->attempt($validated)) {
                
                // Régénération de la session
                $request->session()->regenerate();
                
                $agent = Auth::guard('agent')->user();
                
                // Vérifier si l'agent est actif
                if ($agent->statut !== 'activé') {
                    Auth::guard('agent')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return back()
                        ->withInput($request->only('email'))
                        ->with('error', 'Votre compte est désactivé. Veuillez contacter l\'administrateur.');
                }
                
                return redirect()->route('agent.dashboard')
                    ->with('success', 'Bienvenue dans votre espace agent !');
            }

            // Échec de connexion
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Identifiants incorrects, veuillez réessayer.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Erreur de connexion: ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function showChangePasswordForm()
    {
        return view('agent.change-password');
    }

    /**
     * Traiter le changement de mot de passe
     */
    public function changePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string'
            ]);

            $agent = Auth::guard('agent')->user();

            // Vérifier l'ancien mot de passe
            if (!Hash::check($validated['current_password'], $agent->password)) {
                return back()
                    ->with('error', 'L\'ancien mot de passe est incorrect.');
            }

            // Mettre à jour le mot de passe
            $agent->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->route('agent.parametres')
                ->with('success', 'Mot de passe changé avec succès!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors du changement de mot de passe.');
        }
    }

    /**
     * Déconnexion agent
     */
    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
