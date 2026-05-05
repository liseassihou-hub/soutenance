<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DemandeCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Twilio\Rest\Client as TwilioClient;

class DemandeController extends Controller
{
    public function create(Request $request)
    {
        $typeCredit = $request->get('type', 'individuel');
        return view('demande.create', compact('typeCredit'));
    }

    public function store(Request $request)
    {
        \Log::info('=== DEMANDE CONTROLLER STORE APPELÉ ===');
        \Log::info('Données brutes reçues: ' . json_encode($request->all()));

        // 1. VALIDATION
        $validated = $request->validate([
            'nom'                       => 'required|string|max:100',
            'prenom'                    => 'required|string|max:100',
            'piece_identite_type'       => 'required|string|max:50',
            'piece_identite_numero'     => 'required|string|max:50',
            'piece_identite_expiration' => 'nullable|date',
            'adresse_personnelle'       => 'required|string|max:255',
            'telephone'                 => 'required|string|max:20',
            'numero_compte'             => 'required|string|max:50',
            'agence'                    => 'required|string|max:100',
            'description_activite'      => 'required|string',
            'montant_demande'           => 'required|numeric|min:10000',
            'duree_mois'                => 'required|integer|min:1|max:36',
            'type_credit'               => 'required|string',
            'periodicite'               => 'required|string',
            'objet_pret'                => 'required|string',
            'photo_personnelle'         => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'photo_piece_identite'      => 'required|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        \Log::info('VALIDATION RÉUSSIE');

        // ----------------------------------------------------------------
        // FORMATAGE DU NUMÉRO ICI — en dehors de tout try/catch
        // pour que $telephoneDestinataire soit accessible partout
        // ----------------------------------------------------------------
        $telephoneDestinataire = preg_replace('/\s+/', '', $validated['telephone']); // supprime les espaces

// Le client ne saisit que les 10 chiffres après +229
// On ajoute directement +229 devant le numéro saisi
$telephoneDestinataire = '+229' . $telephoneDestinataire;

\Log::info('Numéro formaté : ' . $telephoneDestinataire);
// Résultat attendu : +2290146564110 (client saisit: 0146564110)

        // Variable initialisée ici pour être accessible dans le redirect final
        $codeSuivi = null;

        try {
            DB::beginTransaction();

            // 2. UPLOAD PHOTOS
            $photoPersonnellePath   = null;
            $photoPieceIdentitePath = null;

            if ($request->hasFile('photo_personnelle')) {
                $file = $request->file('photo_personnelle');
                $name = 'photo_personnelle_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('photos/clients', $name, 'public');
                $photoPersonnellePath = 'photos/clients/' . $name;
            }

            if ($request->hasFile('photo_piece_identite')) {
                $file = $request->file('photo_piece_identite');
                $name = 'photo_piece_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('photos/pieces', $name, 'public');
                $photoPieceIdentitePath = 'photos/pieces/' . $name;
            }

            // 3. CRÉATION OU MISE À JOUR DU CLIENT
            $client = Client::updateOrCreate(
                [
                    'piece_identite_numero' => $validated['piece_identite_numero'],
                    'nom'                   => $validated['nom'],
                    'prenom'                => $validated['prenom'],
                ],
                [
                    'nom'                       => $validated['nom'],
                    'prenom'                    => $validated['prenom'],
                    'piece_identite_type'       => $validated['piece_identite_type'],
                    'piece_identite_numero'     => $validated['piece_identite_numero'],
                    'piece_identite_expiration' => $validated['piece_identite_expiration'] ?? null,
                    'adresse_personnelle'       => $validated['adresse_personnelle'],
                    'telephone'                 => $validated['telephone'],
                    'numero_compte'             => $validated['numero_compte'],
                    'agence'                    => $validated['agence'],
                    'description_activite'      => $validated['description_activite'] ?? null,
                ]
            );

            // 4. GÉNÉRATION CODE SUIVI
            $lastId    = DemandeCredit::max('id') ?? 0;
            $nextId    = $lastId + 1;
            $codeSuivi = 'PEB-' . date('Y') . str_pad($nextId, 6, '0', STR_PAD_LEFT);

            // 5. CRÉATION DEMANDE
            $demande = DemandeCredit::create([
                'client_id'            => $client->id,
                'agent_id'             => null,
                'code_dossier'         => $codeSuivi,
                'montant_demande'      => $validated['montant_demande'],
                'duree_mois'           => $validated['duree_mois'],
                'type_credit'          => $validated['type_credit'],
                'periodicite'          => $validated['periodicite'],
                'objet_pret'           => $validated['objet_pret'],
                'photo_personnelle'    => $photoPersonnellePath,
                'photo_piece_identite' => $photoPieceIdentitePath,
                'statut'               => 'en_attente',
                'date_demande'         => Carbon::now(),
            ]);

            \Log::info('DEMANDE CRÉÉE - ID: ' . $demande->id . ' | Code: ' . $codeSuivi);
            DB::commit();

            
            // 7. REDIRECTION FINALE
            \Log::info('REDIRECTION VERS SUIVI-DEMANDE');

            return redirect()
                ->route('suivi-demande')
                ->with('info', "Félicitations {$validated['prenom']} ! Votre demande a été enregistrée.")
                ->with('code_dossier', $codeSuivi);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            \Log::error('ERREUR SQL: ' . $e->getMessage());
            \Log::error('SQL: ' . $e->getSql() . ' | Bindings: ' . json_encode($e->getBindings()));

            return redirect()->back()->withInput()
                ->with('error', 'Erreur de base de données. Veuillez contacter l\'administrateur.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('ERREUR GÉNÉRALE: ' . $e->getMessage());
            \Log::error('FILE: ' . $e->getFile() . ' LINE: ' . $e->getLine());

            return redirect()->back()->withInput()
                ->with('error', 'Erreur lors de la soumission : ' . $e->getMessage());
        }
    }

    public function showSuivi()
    {
        return view('suivi-demande');
    }

    public function rechercher(Request $request)
    {
        $request->validate([
            'code_dossier' => 'required|string',
        ]);

        $demande = DemandeCredit::where('code_dossier', $request->code_dossier)->first();

        if (!$demande) {
            return redirect()->back()->with('error', 'Désolé, ce code de dossier est inexistant.');
        }

        // On renvoie la vue suivi-resultat avec la variable $demande pour afficher les résultats
        return view('suivi-resultat', compact('demande'));
    }

    /**
     * Afficher la page de récupération de code oublié
     */
    public function showRecuperation()
    {
        return view('recuperation');
    }

    /**
     * Rechercher un code de dossier par numéro de pièce d'identité
     */
    public function recupererCode(Request $request)
    {
        $request->validate([
            'piece_identite_numero' => 'required|string',
        ]);

        // Rechercher un client par son numéro de pièce d'identité
        $client = Client::where('piece_identite_numero', $request->piece_identite_numero)->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de demande à PEBCo avec ce numéro de pièce.');
        }

        // Rechercher les demandes de crédit de ce client
        $demande = DemandeCredit::where('client_id', $client->id)->first();

        if (!$demande) {
            return redirect()->back()->with('error', 'Vous n\'avez pas de demande à PEBCo avec ce numéro de pièce.');
        }

        // Rediriger vers la page de récupération avec le code dossier en session pour afficher le popup
        return redirect()->route('recuperation')->with('code_dossier', $demande->code_dossier);
    }
}