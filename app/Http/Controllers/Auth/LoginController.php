<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Afficher la page de connexion
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required|min:6',
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        ]);

        // Débogage
        \Log::info('Tentative de connexion pour: ' . $credentials['email']);

        // Tentative de connexion admin
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin) {
            \Log::info('Admin trouvé: ' . $admin->email);
            if (Hash::check($credentials['mot_de_passe'], $admin->mot_de_passe)) {
                \Log::info('Connexion admin réussie');
                Auth::guard('admin')->login($admin);
                Session::put('user_type', 'admin');
                return redirect()->route('admin.dashboard');
            } else {
                \Log::info('Mot de passe admin incorrect');
            }
        }

        // Tentative de connexion agent
        $agent = Agent::where('email', $credentials['email'])->first();
        if ($agent) {
            \Log::info('Agent trouvé: ' . $agent->email . ', statut: ' . $agent->statut);
            if (Hash::check($credentials['mot_de_passe'], $agent->password)) {
                \Log::info('Mot de passe agent correct');
                // Vérifier si l'agent est actif
                if ($agent->statut !== 'activé') {
                    \Log::info('Agent non activé');
                    return back()
                        ->withInput($request->only('email'))
                        ->with('error', 'Votre compte est désactivé. Veuillez contacter l\'administrateur.');
                }
                
                \Log::info('Connexion agent réussie');
                // Créer les credentials correctes pour Laravel
                $agentCredentials = [
                    'email' => $credentials['email'],
                    'password' => $credentials['mot_de_passe']  // Laravel attend 'password'
                ];
                Auth::guard('agent')->attempt($agentCredentials);
                Session::put('user_type', 'agent');
                return redirect()->route('agent.dashboard');
            } else {
                \Log::info('Mot de passe agent incorrect');
            }
        }

        \Log::info('Aucun utilisateur trouvé avec cet email');
        // Échec de connexion
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Identifiants incorrects.']);
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('agent')->logout();
        Session::forget('user_type');
        Session::invalidate();
        
        return redirect()->route('login');
    }
}
