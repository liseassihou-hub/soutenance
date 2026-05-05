<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\DemandeCredit;
use App\Models\Agent;
use App\Notifications\StatutDossierUpdated;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Tableau de bord de l'agent
     */
    public function dashboard()
    {
        $agent = Auth::guard('agent')->user();
        
        // Métriques
        $metrics = [
            'total_dossiers' => DemandeCredit::count(),
            'montant_total' => DemandeCredit::sum('montant'),
            'dossiers_en_attente' => DemandeCredit::whereIn('statut', ['en_attente', 'en_cours'])->count(),
            'dossiers_acceptes' => DemandeCredit::where('statut', 'accepte')->count(),
        ];

        // Données pour le graphique
        $statuts = DemandeCredit::selectRaw('statut, COUNT(*) as count')
            ->groupBy('statut')
            ->pluck('count', 'statut')
            ->toArray();

        // 5 dernières demandes
        $dernieresDemandes = DemandeCredit::latest()->take(5)->get();

        return view('agent.dashboard', compact('metrics', 'statuts', 'dernieresDemandes', 'agent'));
    }

    /**
     * Liste de toutes les demandes
     */
    public function index(Request $request)
    {
        $query = DemandeCredit::query();
        
        // Filtre de recherche
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('code_dossier', 'like', "%{$search}%")
                  ->orWhereHas('client', function($subQuery) use ($search) {
                      $subQuery->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%")
                               ->orWhere('telephone', 'like', "%{$search}%")
                               ->orWhere('piece_identite_numero', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filtre par statut
        if ($statut = $request->get('statut')) {
            $query->where('statut', $statut);
        }
        
        $demandes = $query->latest()->paginate(15);
        
        return view('agent.dossiers.index', compact('demandes'));
    }

    /**
     * Détail d'une demande
     */
    public function show($id)
    {
        $demande = DemandeCredit::findOrFail($id);
        return view('agent.dossiers.show', compact('demande'));
    }

    /**
     * Mettre à jour le statut d'une demande
     */
    public function updateStatut(Request $request, $id)
    {
        try {
            // Validation simple
            $validated = $request->validate([
                'statut' => 'required|in:en_attente,en_cours,accepte,accepter,refuse',
            ]);
            
            // Normaliser la valeur
            if ($validated['statut'] === 'accepter') {
                $validated['statut'] = 'accepte';
            }

            // Récupérer et mettre à jour
            $demande = DemandeCredit::findOrFail($id);
            
            // Mise à jour directe
            $demande->statut = $validated['statut'];
            $demande->save();

            return redirect()->route('agent.dossiers.show', $id)
                ->with('success', "Statut mis à jour avec succès !");
                
        } catch (\Exception $e) {
            return redirect()->route('agent.dossiers.show', $id)
                ->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Page des paramètres
     */
    public function parametres()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.parametres', compact('agent'));
    }

    /**
     * Mettre à jour les paramètres de l'agent
     */
    public function updateParametres(Request $request)
    {
        $agent = Auth::guard('agent')->user();
        
        // Vérifier si c'est une mise à jour du profil
        if ($request->has('nom') || $request->has('prenom') || $request->has('email')) {
            // Mise à jour du profil
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:agents,email,' . $agent->id,
                'telephone' => 'nullable|string|max:20',
            ]);

            $agent->update($request->only(['nom', 'prenom', 'email', 'telephone']));

            return redirect()->route('agent.parametres')
                ->with('success', 'Profil mis à jour avec succès.');
        }
        
        // Changement de mot de passe
        if ($request->has('current_password') && $request->has('password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $agent->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }

            $agent->update([
                'password' => Hash::make($request->password),
                'must_change_password' => false,
            ]);

            return redirect()->route('agent.parametres')
                ->with('success', 'Mot de passe mis à jour avec succès.');
        }
    }
}
