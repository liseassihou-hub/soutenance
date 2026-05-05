<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeCredit;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StatutDossierUpdated;

class AgentControllerFixed extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Afficher le dashboard agent
     */
    public function dashboard()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.dashboard', compact('agent'));
    }

    /**
     * Lister les dossiers
     */
    public function index(Request $request)
    {
        $query = DemandeCredit::query();
        
        // Filtrage par recherche
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('code_dossier', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filtrage par statut
        if ($request->statut) {
            $query->where('statut', $request->statut);
        }
        
        $demandes = $query->latest()->paginate(10);
        
        return view('agent.dossiers.index', compact('demandes'));
    }

    /**
     * Afficher les détails d'un dossier
     */
    public function show($id)
    {
        $demande = DemandeCredit::findOrFail($id);
        return view('agent.dossiers.show', compact('demande'));
    }

    /**
     * METTRE À JOUR LE STATUT - VERSION CORRIGÉE
     */
    public function updateStatut(Request $request, $id)
    {
        try {
            // 1. Validation des données
            $validated = $request->validate([
                'statut' => 'required|in:en_attente,en_cours,accepte,refuse',
                'observation_refus' => 'required_if:statut,refuse|string',
                'decision_comite' => 'nullable|string',
            ]);

            // 2. Récupération du dossier
            $demande = DemandeCredit::findOrFail($id);
            $ancienStatut = $demande->statut;
            
            // 3. Préparation des données à mettre à jour
            $updateData = [
                'statut' => $validated['statut'],
                'observation_refus' => $validated['statut'] === 'refuse' ? $validated['observation_refus'] : null,
                'decision_comite' => $validated['decision_comite'],
            ];
            
            // 4. MISE À JOUR - VERSION SIMPLIFIÉE
            $result = $demande->update($updateData);
            
            // 5. Vérification
            if (!$result) {
                throw new \Exception('La mise à jour a échoué');
            }
            
            // 6. Retour avec message de succès
            return redirect()->route('agent.dossiers.show', $id)
                ->with('success', "Statut mis à jour avec succès : {$ancienStatut} → {$validated['statut']}")
                ->with('debug', [
                    'ancien_statut' => $ancienStatut,
                    'nouveau_statut' => $validated['statut'],
                    'donnees_mise_a_jour' => $updateData,
                    'resultat' => $result ? 'succès' : 'échec'
                ]);
                
        } catch (\Exception $e) {
            // En cas d'erreur
            return redirect()->route('agent.dossiers.show', $id)
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage())
                ->with('debug', [
                    'erreur' => $e->getMessage(),
                    'donnees_recues' => $request->all()
                ]);
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
     * Mettre à jour les paramètres
     */
    public function updateParametres(Request $request)
    {
        $agent = Auth::guard('agent')->user();
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:agents,email,' . $agent->id,
            'telephone' => 'required|string|max:20',
        ]);
        
        $agent->update($validated);
        
        return redirect()->route('agent.parametres')
            ->with('success', 'Paramètres mis à jour avec succès');
    }
}
