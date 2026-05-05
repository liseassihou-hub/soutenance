<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuiviControllerFixed extends Controller
{
    /**
     * Afficher le formulaire de suivi
     */
    public function form()
    {
        return view('suivi-demande');
    }

    /**
     * Rechercher une demande de crédit
     */
    public function rechercher(Request $request)
    {
        try {
            // Log de début
            Log::info('=== DÉBUT RECHERCHE SUIVI ===');
            Log::info('Méthode: ' . $request->method());
            Log::info('URL: ' . $request->fullUrl());
            
            // Validation des données
            $validated = $request->validate([
                'code_dossier' => 'required|string|max:191'
            ], [
                'code_dossier.required' => 'Le code dossier est obligatoire',
                'code_dossier.string' => 'Le code dossier doit être une chaîne de caractères',
                'code_dossier.max' => 'Le code dossier ne doit pas dépasser 191 caractères'
            ]);

            Log::info('Code reçu: ' . $validated['code_dossier']);

            // Nettoyage et normalisation du code
            $codeDossier = strtoupper(trim($validated['code_dossier']));
            Log::info('Code normalisé: ' . $codeDossier);

            // Recherche directe avec le champ code_dossier
            $demande = DB::table('demande_credits')
                ->join('clients', 'demande_credits.client_id', '=', 'clients.id')
                ->select('demande_credits.*', 'clients.nom', 'clients.prenom', 'clients.telephone', 'clients.activite_principale')
                ->where('demande_credits.code_dossier', $codeDossier)
                ->first();

            Log::info('Résultat recherche: ' . ($demande ? 'TROUVÉ ID: ' . $demande->id : 'NON TROUVÉ'));

            if (!$demande) {
                Log::warning('Aucune demande trouvée pour: ' . $codeDossier);
                return back()
                    ->withInput()
                    ->with('error', "Aucune demande trouvée avec le code dossier : $codeDossier");
            }

            // Préparation des données pour la vue
            $donnees = $this->preparerDonnees($demande);
            
            Log::info('Redirection vers la vue de résultat');
            return view('suivi-resultat', array_merge($donnees, ['demande' => (object)$demande]));

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur validation: ' . json_encode($e->errors()));
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Erreur technique: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()
                ->withInput()
                ->with('error', 'Une erreur technique est survenue. Veuillez réessayer plus tard.');
        }
    }

    /**
     * Préparer les données pour l'affichage
     */
    private function preparerDonnees($demande)
    {
        // Mapping des types de crédit
        $typesCredit = [
            'Crédit moyen' => 'Crédit Moyen',
            'Crédit personnel' => 'Crédit Personnel',
            'Crédit scolaire' => 'Crédit Scolaire',
            'Crédit commerce' => 'Crédit Commerce',
            'Crédit immobilier' => 'Crédit Immobilier',
            'Crédit automobile' => 'Crédit Automobile',
            'Crédit auto' => 'Crédit Auto',
            'Crédit de groupe' => 'Crédit de Groupe',
            'autre' => 'Autre Crédit',
            'conso' => 'Crédit Consommation'
        ];

        // Détermination du statut avec messages
        $statuts = [
            'en_attente' => [
                'texte' => 'Demande soumise',
                'icone' => 'fas fa-clock',
                'couleur' => '#ffc107',
                'message' => 'Votre demande a été bien reçue et est en cours d\'examen par nos services.'
            ],
            'en_cours' => [
                'texte' => 'Demande en cours',
                'icone' => 'fas fa-spinner fa-spin',
                'couleur' => '#17a2b8',
                'message' => 'Votre demande est en cours de traitement.'
            ],
            'accepte' => [
                'texte' => 'Demande acceptée',
                'icone' => 'fas fa-check-circle',
                'couleur' => '#28a745',
                'message' => 'Félicitations ! Votre demande de crédit a été acceptée.'
            ],
            'refuse' => [
                'texte' => 'Demande refusée',
                'icone' => 'fas fa-times-circle',
                'couleur' => '#dc3545',
                'message' => 'Nous sommes désolés, votre demande de crédit n\'a pas pu être acceptée.'
            ]
        ];

        $statutInfo = $statuts[$demande->statut] ?? $statuts['en_attente'];

        return [
            'demande' => $demande,
            'nomCredit' => $typesCredit[$demande->type_credit] ?? 'Type de crédit inconnu',
            'texteStatut' => $statutInfo['texte'],
            'iconeStatut' => $statutInfo['icone'],
            'couleurStatut' => $statutInfo['couleur'],
            'messageStatut' => $statutInfo['message'],
            'codeSuivi' => $demande->code_dossier,
            'numeroDossier' => 'D' . date('Ym', strtotime($demande->created_at)) . str_pad($demande->id, 4, '0', STR_PAD_LEFT)
        ];
    }
}
