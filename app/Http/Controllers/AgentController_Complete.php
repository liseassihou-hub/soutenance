<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;  // Modèle Dossier
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    /**
     * Constructeur - Middleware d'authentification agent
     */
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Dashboard Agent
     */
    public function dashboard()
    {
        $agent = Auth::guard('agent')->user();
        $stats = [
            'total' => Dossier::count(),
            'en_attente' => Dossier::where('statut', 'en_attente')->count(),
            'en_cours' => Dossier::where('statut', 'en_cours')->count(),
            'acceptes' => Dossier::where('statut', 'accepte')->count(),
            'refuses' => Dossier::where('statut', 'refuse')->count(),
        ];
        
        return view('agent.dashboard', compact('agent', 'stats'));
    }

    /**
     * Lister tous les dossiers
     */
    public function index(Request $request)
    {
        $query = Dossier::query();
        
        // Filtres
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('code_dossier', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        
        $dossiers = $query->latest()->paginate(10);
        
        return view('agent.dossiers.index', compact('dossiers'));
    }

    /**
     * Afficher les détails d'un dossier
     */
    public function show(Dossier $dossier)
    {
        return view('agent.dossiers.show', compact('dossier'));
    }

    /**
     * MÉTHODE CRITIQUE : Mettre à jour le statut d'un dossier
     */
    public function update(Request $request, Dossier $dossier)
    {
        try {
            // 🔍 DEBUG : Voir ce qu'on reçoit
            Log::info('Tentative de mise à jour statut', [
                'dossier_id' => $dossier->id,
                'statut_actuel' => $dossier->statut,
                'donnees_recues' => $request->all()
            ]);

            // 1️⃣ VALIDATION DES DONNÉES
            $validated = $request->validate([
                'statut' => 'required|in:en_attente,en_cours,accepte,refuse',
                'observation_refus' => 'required_if:statut,refuse|string|max:1000',
            ]);

            // 2️⃣ VÉRIFICATION (optionnelle)
            $ancienStatut = $dossier->statut;
            
            // 3️⃣ PRÉPARATION DES DONNÉES
            $updateData = [
                'statut' => $validated['statut'],
                'observation_refus' => $validated['statut'] === 'refuse' 
                    ? $validated['observation_refus'] 
                    : null,
                'agent_id' => Auth::guard('agent')->id(), // Qui a modifié
            ];

            // 4️⃣ EXÉCUTION DE LA MISE À JOUR
            $result = $dossier->update($updateData);

            // 5️⃣ VÉRIFICATION DU RÉSULTAT
            if (!$result) {
                throw new \Exception('La mise à jour a échoué');
            }

            // 6️⃣ LOG DE SUCCÈS
            Log::info('Statut mis à jour avec succès', [
                'dossier_id' => $dossier->id,
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $validated['statut'],
                'agent_id' => Auth::guard('agent')->id()
            ]);

            // 7️⃣ REDIRECTION AVEC MESSAGE
            return redirect()
                ->route('agent.dossiers.show', $dossier)
                ->with('success', "Statut mis à jour : {$ancienStatut} → {$validated['statut']}")
                ->with('debug', [
                    'ancien_statut' => $ancienStatut,
                    'nouveau_statut' => $validated['statut'],
                    'donnees_mise_a_jour' => $updateData,
                    'agent' => Auth::guard('agent')->user()->nom
                ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Erreur de validation
            Log::error('Erreur de validation mise à jour statut', [
                'dossier_id' => $dossier->id,
                'erreurs' => $e->errors()
            ]);
            
            return redirect()
                ->route('agent.dossiers.show', $dossier)
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            // Autre erreur
            Log::error('Erreur mise à jour statut', [
                'dossier_id' => $dossier->id,
                'erreur' => $e->getMessage()
            ]);
            
            return redirect()
                ->route('agent.dossiers.show', $dossier)
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage())
                ->with('debug', [
                    'erreur' => $e->getMessage(),
                    'donnees_recues' => $request->all()
                ]);
        }
    }

    /**
     * Page de profil
     */
    public function profile()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.profile', compact('agent'));
    }

    /**
     * Afficher le formulaire de login
     */
    public function showLoginForm()
    {
        return view('agent.auth.login');
    }

    /**
     * Connexion agent
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('agent')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('agent.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::guard('agent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('agent.login');
    }
}
