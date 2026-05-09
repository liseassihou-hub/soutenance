<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;
use App\Models\Agence;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Utiliser l'authentification par guard admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects']);
    }

    public function dashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Utiliser la table demande_credits pour les métriques
        $totalDemandes = \App\Models\DemandeCredit::count();
        $demandesEnAttente = \App\Models\DemandeCredit::where('statut', 'en_attente')->count();
        $demandesEnCours = \App\Models\DemandeCredit::whereIn('statut', ['en_cours', 'en_analyse'])->count();
        $demandesApprouvees = \App\Models\DemandeCredit::whereIn('statut', ['approuve', 'accepte'])->count();
        $demandesRefusees = \App\Models\DemandeCredit::where('statut', 'refuse')->count();
        
        // Calculer le taux d'approbation
        $tauxApprobation = $totalDemandes > 0 ? round(($demandesApprouvees / $totalDemandes) * 100, 1) : 0;
        
        // Compter les agents actifs (tous les agents sont considérés comme actifs)
        $agentsActifs = Agent::count();
        
        $metrics = [
            'total' => $totalDemandes,
            'en_attente' => $demandesEnAttente,
            'en_analyse' => $demandesEnCours,
            'approuve' => $demandesApprouvees,
            'refuse' => $demandesRefusees,
        ];

        // Récupérer les agents pour le dashboard
        $agents = Agent::latest()->get();
        
        // Récupérer les demandes récentes avec les informations des agents
        $demandesRecentes = \App\Models\DemandeCredit::with('agent')->latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'agents', 'demandesRecentes', 'tauxApprobation', 'agentsActifs', 'totalDemandes', 'demandesApprouvees'));
    }

    /**
     * Afficher le formulaire de création d'agent
     */
    public function createAgentForm()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $agences = Agence::orderBy('nom_agence')->get();
        
        // Debug: Vérifier si les agences sont chargées
        \Log::info('Nombre d\'agences chargées: ' . $agences->count());
        if ($agences->count() > 0) {
            \Log::info('Première agence: ' . $agences->first()->nom_agence);
        } else {
            \Log::error('Aucune agence trouvée dans la base de données!');
        }
        
        return view('admin.create-agent', compact('agences'));
    }

    /**
     * Créer un nouvel agent
     */
    public function createAgent(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
            }
            return redirect()->route('admin.login');
        }

        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'sexe' => 'required|in:M,F',
                'email' => 'required|email|unique:agents,email',
                'password' => 'required|string|min:8',
                'id_agence' => 'required|integer|exists:agences,id_agence',
            ]);

            // Créer l'agent
            $agent = Agent::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'sexe' => $validated['sexe'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'id_agence' => $validated['id_agence'],
            ]);

            // Si la requête attend du JSON (AJAX), retourner du JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Agent créé avec succès !',
                    'agent' => $agent
                ]);
            }

            // Sinon, redirection normale
            return redirect()->route('admin.dashboard')
                ->with('success', 'Agent créé avec succès ! L\'agent recevra un email pour se connecter.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Une erreur est survenue lors de la création de l\'agent.'
                ], 500);
            }
            
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de l\'agent.');
        }
    }

    /**
     * Supprimer un agent
     */
    public function deleteAgent($id)
    {
        if (!Auth::guard('admin')->check()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
            }
            return redirect()->route('admin.login');
        }

        try {
            $agent = Agent::findOrFail($id);
            $agent->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Agent supprimé avec succès.'
                ]);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Agent supprimé avec succès.');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Une erreur est survenue lors de la suppression de l\'agent.'
                ], 500);
            }
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression de l\'agent.');
        }
    }

    public function demandes(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $query = \App\Models\DemandeCredit::with('client');

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code_dossier', 'like', "%{$search}%")
                  ->orWhereHas('client', function($subQuery) use ($search) {
                      $subQuery->where('nom', 'like', "%{$search}%")
                             ->orWhere('prenom', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('telephone', 'like', "%{$search}%");
                  });
            });
        }

        $demandes = $query->latest('date_demande')->paginate(15);
        $demandes = $query->latest()->paginate(15);

        // Types de crédit pour le filtre
        $typesCredit = [
            1 => 'Crédit moyen',
            2 => 'Crédit personnel', 
            3 => 'Crédit scolaire',
            4 => 'Crédit commerce',
            5 => 'Crédit immobilier',
            6 => 'Crédit automobile',
            7 => 'Crédit de groupe',
            8 => 'Autre Crédit',
            9 => 'Crédit Consommation'
        ];

        return view('admin.demandes', compact('demandes', 'typesCredit'));
    }

    /**
     * Mettre à jour le statut d'une demande
     */
    public function updateStatut(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
        }

        try {
            $validated = $request->validate([
                'statut' => 'required|in:en_attente,en_cours,en_analyse,approuve,accepte,refuse',
            ]);

            $demande = \App\Models\DemandeCredit::findOrFail($id);
            $demande->statut = $validated['statut'];
            
            // Enregistrer l'ID de l'admin qui modifie le statut
            $demande->id_agent = Auth::guard('admin')->user()->id;
            
            $demande->save();

            return response()->json([
                'success' => true, 
                'message' => 'Statut mis à jour avec succès',
                'nouveau_statut' => $validated['statut'],
                'agent' => Auth::guard('admin')->user()->name
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function journal()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Utiliser les demandes de crédit comme journal d'activités
        $query = \App\Models\DemandeCredit::latest();
        
        // Filtres
        if (request()->filled('search')) {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('code_dossier', 'like', "%{$search}%");
            });
        }
        
        if (request()->filled('statut')) {
            $statut = request()->statut;
            if ($statut === 'en_cours') {
                $query->whereIn('statut', ['en_cours', 'en_analyse']);
            } else {
                $query->where('statut', $statut);
            }
        }
        
        if (request()->filled('date')) {
            $query->whereDate('date_demande', request()->date);
        }
        
        $demandes = $query->paginate(50);
        
        return view('admin.journal', compact('demandes'));
    }

    public function showDemande($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $demande = \App\Models\DemandeCredit::with('client')->findOrFail($id);
        
        // Types de crédit pour l'affichage
        $typesCredit = [
            1 => 'Crédit moyen',
            2 => 'Crédit personnel', 
            3 => 'Crédit scolaire',
            4 => 'Crédit commerce',
            5 => 'Crédit immobilier',
            6 => 'Crédit automobile',
            7 => 'Crédit de groupe',
            8 => 'Autre Crédit',
            9 => 'Crédit Consommation'
        ];
        
        return view('admin.show-demande', compact('demande', 'typesCredit'));
    }

    public function toggleAgentStatus($id)
    {
        if (!Auth::guard('admin')->check()) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
            }
            return redirect()->route('admin.login');
        }

        try {
            $agent = Agent::findOrFail($id);
            $agent->statut = $agent->statut === 'activé' ? 'désactivé' : 'activé';
            $agent->save();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Statut de l\'agent mis à jour avec succès.',
                    'new_status' => $agent->statut
                ]);
            }

            return redirect()->route('admin.agents')
                ->with('success', 'Statut de l\'agent mis à jour avec succès.');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Erreur lors de la mise à jour du statut: ' . $e->getMessage()
                ], 500);
            }
            
            return back()
                ->with('error', 'Erreur lors de la mise à jour du statut de l\'agent.');
        }
    }

    public function showClient($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $client = Client::with(['demandesCredit' => function($query) {
            $query->with('agent')->orderBy('date_demande', 'desc');
        }])->findOrFail($id);
        
        return view('admin.client-show', compact('client'));
    }
}
