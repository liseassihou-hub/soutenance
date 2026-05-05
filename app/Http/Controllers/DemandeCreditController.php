<?php

namespace App\Http\Controllers;

use App\Models\DemandeCredit;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DemandeCreditController extends Controller
{
    /**
     * Afficher le formulaire de demande de crédit
     */
    public function create()
    {
        return view('demande.create');
    }

    /**
     * Enregistrer une nouvelle demande de crédit
     */
    public function store(Request $request)
    {
        // Validation des données du client et de la demande
        $validated = $request->validate([
            // Données du client
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F,PM',
          
            'piece_identite_type' => 'required|string|max:255',
            'piece_identite_numero' => 'required|string|max:255',
            'piece_identite_expiration' => 'nullable|date',
       
            'telephone' => 'required|string|max:20',
            'numero_compte' => 'required|string|regex:/^A01[0-9]+$/|unique:clients,numero_compte',
           
           
            'autres_activites' => 'nullable|string',
            'description_activite' => 'nullable|string',
         
            
            // Données de la demande de crédit
            'montant_demande' => 'required|numeric|min:10000|max:10000000',
            'duree_mois' => 'required|integer|min:3|max:60',
            'type_credit' => 'required|string|max:50',
            'periodicite' => 'required|string|in:mensuel,trimestriel,semestriel,annuel',
            'objet_pret' => 'required|string|max:1000',
           
            'photo_personnelle' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_piece_identite' => 'required|image|mimes:jpeg,png,jpg|max:2048',
         
        ], [
            'required' => 'Veuillez remplir les champs vides',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'sexe.required' => 'Le sexe est obligatoire',
            'piece_identite_type.required' => 'Le type de pièce d\'identité est obligatoire',
            'piece_identite_numero.required' => 'Le numéro de pièce d\'identité est obligatoire',
            'adresse_personnelle.required' => 'L\'adresse personnelle est obligatoire',
            'telephone.required' => 'Le téléphone est obligatoire',
            'situation_famille.required' => 'La situation de famille est obligatoire',
            'contact_urgence_nom.required' => 'Le nom du contact d\'urgence est obligatoire',
            'activite_principale.required' => 'L\'activité principale est obligatoire',
            'montant_demande.required' => 'Le montant demandé est obligatoire',
            'duree_mois.required' => 'La durée est obligatoire',
            'type_credit.required' => 'Le type de crédit est obligatoire',
            'periodicite.required' => 'La périodicité est obligatoire',
            'objet_pret.required' => 'L\'objet du prêt est obligatoire',
            'photo_personnelle.required' => 'La photo personnelle est obligatoire',
            'photo_piece_identite.required' => 'La photo de la pièce d\'identité est obligatoire',
            'numero_compte.required' => 'Le numéro de compte est obligatoire',
            'numero_compte.regex' => 'Le numéro de compte doit commencer par A01 suivi de chiffres',
            'numero_compte.unique' => 'Ce numéro de compte existe déjà',
        ]);

        // Création du client
        $clientData = [
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'sexe' => $validated['sexe'],
            'date_naissance' => $validated['date_naissance'],
            'lieu_naissance' => $validated['lieu_naissance'],
            'piece_identite_type' => $validated['piece_identite_type'],
            'piece_identite_numero' => $validated['piece_identite_numero'],
            'piece_identite_expiration' => $validated['piece_identite_expiration'],
            'adresse_personnelle' => $validated['adresse_personnelle'],
            
            'telephone' => $validated['telephone'],
           
            'description_activite' => $validated['description_activite'] ?? null,
          
     
            'date_inscription' => now(),
        ];

        $client = Client::create($clientData);

        // Génération du code de dossier unique
        $codeDossier = 'DM' . date('Y') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT) . chr(65 + rand(0, 25)) . rand(10, 99);

        // Traitement des photos
        if ($request->hasFile('photo_personnelle')) {
            $photoPersonnelle = $request->file('photo_personnelle');
            $nomPhotoPersonnelle = 'photo_personnelle_' . $codeDossier . '_' . time() . '.' . $photoPersonnelle->getClientOriginalExtension();
            $photoPersonnelle->storeAs('photos/demandes', $nomPhotoPersonnelle, 'public');
            $validated['photo_personnelle'] = $nomPhotoPersonnelle;
        }

        if ($request->hasFile('photo_piece_identite')) {
            $photoPiece = $request->file('photo_piece_identite');
            $nomPhotoPiece = 'photo_piece_' . $codeDossier . '_' . time() . '.' . $photoPiece->getClientOriginalExtension();
            $photoPiece->storeAs('photos/demandes', $nomPhotoPiece, 'public');
            $validated['photo_piece_identite'] = $nomPhotoPiece;
        }

        // Préparation des données de la demande
        $demandeData = [
            'client_id' => $client->id,
            'agent_id' => 1, // Valeur par défaut car agent_id n'est pas dans le formulaire
            'code_dossier' => $codeDossier,
            'montant_demande' => $validated['montant_demande'],
            'duree_mois' => $validated['duree_mois'],
            'type_credit' => $validated['type_credit'],
            'periodicite' => $validated['periodicite'],
            'objet_pret' => $validated['objet_pret'],
           
            
            'photo_personnelle' => $validated['photo_personnelle'] ?? null,
            'photo_piece_identite' => $validated['photo_piece_identite'] ?? null,
          
            'date_demande' => now()->toDateString(),
            'statut' => 'en_attente',
        ];

        // Création de la demande
        $demande = DemandeCredit::create($demandeData);

        // Envoyer le code de suivi par email
        try {
            \Mail::raw(
                "Bonjour " . $client->prenom . " " . $client->nom . ",\n\n" .
                "Votre demande de crédit a été soumise avec succès.\n\n" .
                "Code de suivi : " . $codeDossier . "\n" .
                "Montant demandé : " . number_format($validated['montant_demande'], 2, ',', ' ') . " FCFA\n" .
                "Type de crédit : " . $validated['type_credit'] . "\n\n" .
                "Vous pouvez suivre l'état de votre demande en utilisant ce code sur notre site.\n\n" .
                "Cordialement,\n" .
                "L'équipe PEBCO",
                function($message) use ($client) {
                    $message->to($client->telephone . '@sms.pebco.com') // Adapté pour SMS si nécessaire
                           ->subject('Votre demande de crédit PEBCO - Code: ' . $codeDossier);
                }
            );
        } catch (\Exception $e) {
            // En cas d'erreur d'envoi d'email, continuer quand même
            \Log::error('Erreur envoi email code suivi: ' . $e->getMessage());
        }

        // Stocker le code en session pour la page de confirmation
        session(['code_dossier' => $codeDossier]);
        
        return redirect()
            ->route('demande.confirmation')
            ->with('success', 'Votre demande de crédit a été soumise avec succès!')
            ->with('code_dossier', $codeDossier);
    }

    /**
     * Afficher la page de confirmation avec le code de suivi
     */
    public function confirmation()
    {
        // Récupérer le code de dossier depuis la session ou le dernier créé
        $codeDossier = session('code_dossier');
        
        // Si pas dans la session, récupérer le dernier code de dossier créé
        if (!$codeDossier) {
            $derniereDemande = DemandeCredit::orderBy('created_at', 'desc')->first();
            $codeDossier = $derniereDemande ? $derniereDemande->code_dossier : null;
        }
        
        return view('demande.confirmation', ['codeDossier' => $codeDossier]);
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show($id)
    {
        $demande = DemandeCredit::with(['client', 'agent'])->findOrFail($id);
        return view('demande.show', compact('demande'));
    }

    /**
     * Afficher la liste des demandes (pour les agents)
     */
    public function index(Request $request)
    {
        $query = DemandeCredit::with(['client', 'agent']);

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->byStatut($request->statut);
        }

        // Filtrage par agent
        if ($request->filled('agent_id')) {
            $query->deLagent($request->agent_id);
        }

        // Filtrage par date
        if ($request->filled('date_debut')) {
            $query->where('date_demande', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_demande', '<=', $request->date_fin);
        }

        $demandes = $query->orderBy('date_demande', 'desc')->paginate(20);

        return view('demande.index', compact('demandes'));
    }

    /**
     * Mettre à jour le statut d'une demande
     */
    public function updateStatut(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,en_cours,approuve,refuse',
            'motif' => 'required_if:statut,refuse|string|max:500'
        ]);

        $demande = DemandeCredit::findOrFail($id);
        $demande->statut = $validated['statut'];
        $demande->date_traitement = Carbon::now();
        
        if (isset($validated['motif'])) {
            $demande->motif_refus = $validated['motif'];
        }
        
        $demande->save();

        return redirect()
            ->back()
            ->with('success', 'Statut de la demande mis à jour avec succès!');
    }

    /**
     * Suivi d'une demande par code dossier
     */
    public function suivi(Request $request)
    {
        $validated = $request->validate([
            'code_dossier' => 'required|string|max:20'
        ]);

        // Recherche par code de dossier exact
        $demande = DemandeCredit::with(['client', 'agent'])
            ->where('code_dossier', $validated['code_dossier'])
            ->first();

        if (!$demande) {
            return redirect()
                ->back()
                ->with('error', 'Aucune demande trouvée pour ce code de dossier.');
        }

        return view('demande.suivi-result', compact('demande'));
    }

    /**
     * Exporter les demandes en Excel
     */
    public function export(Request $request)
    {
        $query = DemandeCredit::with(['client', 'agent']);

        // Appliquer les mêmes filtres que index()
        if ($request->filled('statut')) {
            $query->byStatut($request->statut);
        }
        if ($request->filled('agent_id')) {
            $query->deLagent($request->agent_id);
        }
        if ($request->filled('date_debut')) {
            $query->where('date_demande', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_demande', '<=', $request->date_fin);
        }

        $demandes = $query->orderBy('date_demande', 'desc')->get();

        // Logique d'exportation Excel ici
        // ...

        return response()->json([
            'message' => 'Exportation réussie',
            'count' => $demandes->count()
        ]);
    }

    /**
     * Statistiques des demandes
     */
    public function statistiques()
    {
        $stats = [
            'total' => DemandeCredit::count(),
            'en_attente' => DemandeCredit::byStatut('en_attente')->count(),
            'en_cours' => DemandeCredit::byStatut('en_cours')->count(),
            'approuve' => DemandeCredit::byStatut('approuve')->count(),
            'refuse' => DemandeCredit::byStatut('refuse')->count(),
            'recentes' => DemandeCredit::recentes(7)->count(),
        ];

        return view('demande.statistiques', compact('stats'));
    }
}
