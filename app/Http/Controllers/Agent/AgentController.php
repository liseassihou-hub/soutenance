<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\DemandeCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Tableau de bord agent
     */
    public function dashboard()
    {
        $agent = Auth::guard('agent')->user();
        
        // Récupérer seulement les dossiers de l'agence de l'agent + les dossiers déjà en charge par lui
        $demandes = DemandeCredit::with('client')
            ->where(function($query) use ($agent) {
                $query->where(function($q) use ($agent) {
                    $q->whereNull('agent_id')
                      ->where(function($subQuery) use ($agent) {
                          $subQuery->where('id_agence', $agent->id_agence)
                                   ->orWhereNull('id_agence');
                      });
                })
                ->orWhere(function($q) use ($agent) {
                    $q->where('agent_id', $agent->id)
                      ->where(function($subQuery) use ($agent) {
                          $subQuery->where('id_agence', $agent->id_agence)
                                   ->orWhereNull('id_agence');
                      });
                });
            })
            ->orderBy('date_demande', 'desc')
            ->get();
        
        // Calcul des métriques pour l'agent
        $totalDossiers = $demandes->count();
        $enCours = $demandes->where('statut', 'en_cours')->count();
        $approuves = $demandes->where('statut', 'approuve')->count();
        $refuses = $demandes->where('statut', 'refuse')->count();
        $mesDossiers = $demandes->where('agent_id', $agent->id)->count();
        $disponibles = $demandes->whereNull('agent_id')->count();
        
        // Debug pour vérifier les nombres exacts
        \Log::info('Dashboard Agent - Agent ID: ' . $agent->id);
        \Log::info('Total demandes: ' . $totalDossiers);
        \Log::info('En cours: ' . $enCours);
        \Log::info('Approuvés: ' . $approuves);
        \Log::info('Refusés: ' . $refuses);
        
        $metrics = [
            'total_dossiers' => $totalDossiers,
            'dossiers_en_cours' => $enCours,
            'dossiers_approuves' => $approuves,
            'dossiers_refuses' => $refuses,
            'mes_dossiers' => $mesDossiers,
            'dossiers_disponibles' => $disponibles,
            'montant_total' => $demandes->sum('montant_demande'),
        ];
        
        // Calcul des statuts pour le graphique
        $statuts = [
            'en_cours' => $enCours,
            'approuve' => $approuves,
            'refuse' => $refuses,
        ];
        
        // Debug pour vérifier les statuts
        \Log::info('Statuts dashboard agent:', $statuts);
        
        // Dernières demandes pour l'aperçu
        $dernieresDemandes = $demandes->take(5);
        
        return view('agent.dashboard', compact('agent', 'demandes', 'metrics', 'statuts', 'dernieresDemandes'));
    }

    /**
     * Afficher les détails d'un dossier
     */
    public function showDossier($id)
    {
        $agent = Auth::guard('agent')->user();
        $demande = DemandeCredit::with('client')->findOrFail($id);
        
        if ($demande->id_agence !== null && $demande->id_agence != $agent->id_agence) {
            return back()->with('error', 'Ce dossier n\'appartient pas à votre agence.');
        }
        
        // Vérifier si le dossier est déjà pris par un autre agent
        if ($demande->agent_id && $demande->agent_id != $agent->id) {
            return back()->with('error', 'Ce dossier est déjà traité par un autre agent.');
        }
        
        // Assigner automatiquement le dossier si non assigné
        if (!$demande->agent_id) {
            $demande->update(['agent_id' => $agent->id]);
        }
        
        // Changer automatiquement le statut à "en cours" si c'est "en attente"
        if ($demande->statut == 'en_attente') {
            $demande->update([
                'statut' => 'en_cours',
                'date_traitement' => now()
            ]);
        }
        
        return view('agent.dossier-detail', compact('demande'));
    }

    /**
     * Approuver un dossier
     */
    public function approuverDossier($id)
    {
        $agent = Auth::guard('agent')->user();
        $demande = DemandeCredit::findOrFail($id);

        if ($demande->id_agence !== null && $demande->id_agence != $agent->id_agence) {
            return back()->with('error', 'Ce dossier n\'appartient pas à votre agence.');
        }

        if ($demande->agent_id && $demande->agent_id != $agent->id) {
            return back()->with('error', 'Ce dossier est déjà traité par un autre agent.');
        }

        $demande->update([
            'statut' => 'approuve',
            'date_traitement' => now(),
            'agent_id' => $agent->id
        ]);
        
        return redirect()
            ->route('agent.dossiers')
            ->with('success', 'Dossier approuvé avec succès!');
    }

    /**
     * Refuser un dossier
     */
    public function refuserDossier(Request $request, $id)
    {
        $agent = Auth::guard('agent')->user();

        $request->validate([
            'raison_refus' => 'required|string|max:1000'
        ], [
            'raison_refus.required' => 'La raison du refus est obligatoire'
        ]);
        
        $demande = DemandeCredit::findOrFail($id);

        if ($demande->id_agence !== null && $demande->id_agence != $agent->id_agence) {
            return back()->with('error', 'Ce dossier n\'appartient pas à votre agence.');
        }

        if ($demande->agent_id && $demande->agent_id != $agent->id) {
            return back()->with('error', 'Ce dossier est déjà traité par un autre agent.');
        }

        $demande->update([
            'statut' => 'refuse',
            'date_traitement' => now(),
            'raison_refus' => $request->raison_refus,
            'agent_id' => $agent->id
        ]);
        
        return redirect(url('/agent/dossiers'))
            ->with('success', 'Dossier refusé avec succès!');
    }

    /**
     * Afficher le formulaire d'édition d'un dossier
     */
    public function editDossier($id)
    {
        $agent = Auth::guard('agent')->user();
        $demande = DemandeCredit::with('client')->findOrFail($id);

        if ($demande->id_agence !== null && $demande->id_agence != $agent->id_agence) {
            return back()->with('error', 'Ce dossier n\'appartient pas à votre agence.');
        }

        if ($demande->agent_id && $demande->agent_id != $agent->id) {
            return back()->with('error', 'Ce dossier est déjà traité par un autre agent.');
        }

        return view('agent.dossier-edit', compact('demande'));
    }

    /**
     * Mettre à jour le statut d'un dossier
     */
    public function updateDossier(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,approuve,refuse',
            'raison_refus' => 'nullable|required_if:statut,refuse|string|max:1000'
        ], [
            'statut.required' => 'Le statut est obligatoire',
            'raison_refus.required' => 'La raison du refus est obligatoire lorsque le statut est "Refusé"'
        ]);

        $agent = Auth::guard('agent')->user();
        $demande = DemandeCredit::findOrFail($id);

        if ($demande->id_agence !== null && $demande->id_agence != $agent->id_agence) {
            return back()->with('error', 'Ce dossier n\'appartient pas à votre agence.');
        }

        if ($demande->agent_id && $demande->agent_id != $agent->id) {
            return back()->with('error', 'Ce dossier est déjà traité par un autre agent.');
        }
        
        $demande->statut = $request->statut;
        $demande->date_traitement = now();
        $demande->agent_id = Auth::guard('agent')->user()->id; // Enregistrer l'agent qui traite
        
        // Ajouter la raison de refus si le statut est "refuse"
        if ($request->statut === 'refuse') {
            $demande->raison_refus = $request->raison_refus;
        } else {
            $demande->raison_refus = null; // Effacer la raison si le statut change
        }
        
        $demande->save();

        return redirect(url('/agent/dossiers'))
            ->with('success', 'Statut du dossier mis à jour avec succès!');
    }

    /**
     * Lister tous les dossiers
     */
    public function dossiers(Request $request)
    {
        $agent = Auth::guard('agent')->user();
        
        $query = DemandeCredit::with('client')
            ->where(function($query) use ($agent) {
                $query->where(function($q) use ($agent) {
                    $q->whereNull('agent_id')
                      ->where(function($subQuery) use ($agent) {
                          $subQuery->where('id_agence', $agent->id_agence)
                                   ->orWhereNull('id_agence');
                      });
                })
                ->orWhere(function($q) use ($agent) {
                    $q->where('agent_id', $agent->id)
                      ->where(function($subQuery) use ($agent) {
                          $subQuery->where('id_agence', $agent->id_agence)
                                   ->orWhereNull('id_agence');
                      });
                });
            });
        
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
        
        // Filtre par assignation
        if ($assignation = $request->get('assignation')) {
            if ($assignation === 'mes_dossiers') {
                $query->where('agent_id', $agent->id);
            } elseif ($assignation === 'disponibles') {
                $query->whereNull('agent_id');
            }
        }
        
        $demandes = $query->orderBy('date_demande', 'desc')->paginate(10);
        
        return view('agent.dossiers', compact('demandes'));
    }

    /**
     * Mettre à jour les paramètres de l'agent
     */
    public function updateParametres(Request $request)
    {
        $agent = Auth::guard('agent')->user();
        
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,'.$agent->id,
            'telephone' => 'nullable|string|max:20',
            'id_agence' => 'required|exists:agences,id_agence',
        ]);

        $agent->update($validated);

        return redirect()
            ->route('agent.parametres')
            ->with('success', 'Informations personnelles modifiées avec succès!');
    }

    /**
     * Afficher les paramètres de l'agent
     */
    public function parametres()
    {
        $agent = Auth::guard('agent')->user();
        $agences = \App\Models\Agence::orderBy('nom_agence')->get();
        return view('agent.parametres', compact('agent', 'agences'));
    }
}
