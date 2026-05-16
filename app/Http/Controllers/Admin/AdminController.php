<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Client;
use App\Models\DemandeCredit;
use App\Models\User;
use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Tableau de bord admin
     */
    public function dashboard()
    {
        // Statistiques des demandes
        $totalDemandes = DemandeCredit::count();
        $demandesEnCours = DemandeCredit::where('statut', 'en_cours')->count();
        $demandesApprouvees = DemandeCredit::where('statut', 'approuve')->count();
        $demandesRefusees = DemandeCredit::where('statut', 'refuse')->count();
        
        // Données pour le graphique - 7 derniers jours
        $dailyData = [];
        $labels7 = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels7[] = $date->format('D');
            $dailyData[] = DemandeCredit::whereDate('date_demande', $date->format('Y-m-d'))->count();
        }

        // Données pour les 30 derniers jours (par semaine)
        $weeklyData = [];
        $labels30 = [];
        for ($i = 3; $i >= 0; $i--) {
            $startDate = now()->subWeeks($i + 1)->startOfWeek();
            $endDate = now()->subWeeks($i + 1)->endOfWeek();
            $labels30[] = 'Sem ' . (4 - $i);
            $weeklyData[] = DemandeCredit::whereBetween('date_demande', [$startDate, $endDate])->count();
        }

        // Données pour les 90 derniers jours (par mois)
        $monthlyData = [];
        $labels90 = [];
        for ($i = 2; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels90[] = $date->format('M');
            $monthlyData[] = DemandeCredit::whereMonth('date_demande', $date->month)->whereYear('date_demande', $date->year)->count();
        }
        
        return view('admin.dashboard', compact(
            'totalDemandes',
            'demandesEnCours', 
            'demandesApprouvees', 
            'demandesRefusees',
            'labels7',
            'dailyData',
            'labels30',
            'weeklyData',
            'labels90',
            'monthlyData'
        ));
    }

    /**
     * Page des clients
     */
    public function clients()
    {
        $clients = \App\Models\Client::with('demandesCredit')->orderBy('id', 'desc')->paginate(20);
        return view('admin.clients', compact('clients'));
    }

    /**
     * Page des agents
     */
    public function agents()
    {
        return view('admin.agents-index');
    }

    /**
     * Afficher les détails d'une demande
     */
    public function showDemande($id)
    {
        $demande = DemandeCredit::with('client')->findOrFail($id);
        return view('admin.demande-detail', compact('demande'));
    }

    
    /**
     * Formulaire de création d'agent
     */
    public function createAgentForm()
    {
        $agences = Agence::orderBy('nom_agence')->get();
        return view('admin.create-agent', compact('agences'));
    }

    /**
     * Créer un agent
     */
    public function createAgent(Request $request)
    {
        try {
            // Validation des données
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'sexe' => 'required|in:M,F',
                'email' => 'required|email|unique:agents,email',
                'password' => 'required|string|min:6',
                'telephone' => 'nullable|string',
                'id_agence' => 'required|integer|exists:agences,id_agence',
            ]);

            \Log::info('Données reçues:', $request->all());
            
            $agent = new Agent();
            $agent->nom = $validated['nom'];
            $agent->prenom = $validated['prenom'];
            $agent->email = $validated['email'];
            $agent->telephone = $validated['telephone'];
            $agent->sexe = $validated['sexe'];
            $agent->id_agence = $validated['id_agence'];
            $agent->password = Hash::make($validated['password']);
            $agent->save();

            \Log::info('Agent créé avec ID: ' . $agent->id);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Agent créé avec succès!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Erreur création agent: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Erreur: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Formulaire de modification d'agent
     */
    public function editAgentForm($id)
    {
        $agent = Agent::findOrFail($id);
        return view('admin.edit-agent', compact('agent'));
    }

    /**
     * Mettre à jour un agent
     */
    public function updateAgent(Request $request, $id)
    {
        try {
            $agent = Agent::findOrFail($id);
            
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'sexe' => 'required|in:M,F',
                'email' => 'required|email|unique:agents,email,'.$id,
                'mot_de_passe' => 'nullable|min:6',
            ]);

            $agent->update([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'sexe' => $validated['sexe'],
                'email' => $validated['email'],
                'telephone' => $request->telephone,
            ]);

            // Mise à jour du mot de passe si fourni
            if (!empty($validated['mot_de_passe'])) {
                $agent->update([
                    'password' => Hash::make($validated['mot_de_passe']),
                ]);
            }

            return redirect()
                ->route('admin.agents')
                ->with('success', 'Agent modifié avec succès!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de la modification: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Supprimer un agent
     */
    public function destroyAgent($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();
        
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Agent supprimé avec succès!');
    }

    /**
     * Activer/Désactiver un agent
     */
    public function toggleAgentStatus($id)
    {
        $agent = Agent::findOrFail($id);
        
        if ($agent->statut === 'activé') {
            $agent->statut = 'désactivé';
            $message = 'Agent désactivé avec succès! Il ne pourra plus se connecter.';
        } else {
            $agent->statut = 'activé';
            $message = 'Agent activé avec succès! Il peut maintenant se connecter.';
        }
        
        $agent->save();
        
        return redirect()
            ->route('admin.agents')
            ->with('success', $message);
    }

    /**
     * Rechercher des clients (AJAX)
     */
    public function searchClientsAjax(Request $request)
    {
        $search = $request->get('search');
        
        if (empty($search) || strlen($search) < 2) {
            return response()->json(['clients' => []]);
        }
        
        $clients = Client::where(function($query) use ($search) {
                $query->where('nom', 'LIKE', "%{$search}%")
                      ->orWhere('prenom', 'LIKE', "%{$search}%")
                      ->orWhere('telephone', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['id', 'nom', 'prenom', 'telephone']);
        
        return response()->json(['clients' => $clients]);
    }

    /**
     * Rechercher des clients
     */
    public function searchClients(Request $request)
    {
        $search = $request->get('search');
        
        if (empty($search)) {
            return redirect()->route('admin.dashboard')->with('error', 'Veuillez entrer un terme de recherche.');
        }
        
        try {
            $clients = Client::where(function($query) use ($search) {
                    $query->where('nom', 'LIKE', "%{$search}%")
                          ->orWhere('prenom', 'LIKE', "%{$search}%")
                          ->orWhere('telephone', 'LIKE', "%{$search}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
            
            return view('admin.clients-search-results', compact('clients', 'search'));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Erreur lors de la recherche: ' . $e->getMessage());
        }
    }

    /**
     * Rechercher des demandes par statut
     */
    public function searchDemandes(Request $request)
    {
        $statut = $request->get('statut');
        
        $query = DemandeCredit::with('client');
        
        if ($statut && $statut !== '') {
            $query->where('statut', $statut);
        }
        
        $demandes = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.demandes-search-results', compact('demandes', 'statut'));
    }

    /**
     * Afficher les détails d'un client
     */
    public function showClient($id)
    {
        $client = Client::with(['demandesCredit' => function($query) {
            $query->with('agent')->orderBy('date_demande', 'desc');
        }])->findOrFail($id);
        
        return view('admin.client-show', compact('client'));
    }

    /**
     * Afficher le journal des activités
     */
    public function journal()
    {
        return view('admin.journal');
    }
}
