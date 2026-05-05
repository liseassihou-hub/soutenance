<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuiviController extends Controller
{
    /**
     * Afficher le formulaire de suivi
     */
    public function form()
    {
        return view('suivi.form-simple');
    }

    /**
     * Rechercher une demande de crédit
     */
    public function rechercher(Request $request)
    {
        try {
            // Log de début
            Log::info('=== DÉBUT RECHERCHE SUIVI ===');
            Log::info('Méthode:', $request->method());
            Log::info('URL:', $request->fullUrl());
            
            // Validation des données
            $validated = $request->validate([
                'code_dossier' => 'required|string|max:191'
            ], [
                'code_dossier.required' => 'Le code dossier est obligatoire',
                'code_dossier.string' => 'Le code dossier doit être une chaîne de caractères',
                'code_dossier.max' => 'Le code dossier ne doit pas dépasser 191 caractères'
            ]);

            Log::info('Code reçu:', $validated['code_dossier']);

            // Nettoyage et normalisation du code
            $codeDossier = strtoupper(trim($validated['code_dossier']));
            Log::info('Code normalisé:', $codeDossier);

            // Recherche avec différentes casses et espaces
            $demande = DB::table('demande_credits')
                ->where(function($query) use ($codeDossier) {
                    $query->where('code_dossier', $codeDossier)
                          ->orWhere('code_dossier', strtolower($codeDossier))
                          ->orWhere('code_dossier', strtoupper($codeDossier))
                          ->orWhere('code_dossier', 'LIKE', '%' . $codeDossier . '%');
                })
                ->first();

            Log::info('Résultat recherche:', $demande ? 'TROUVÉ ID: ' . $demande->id : 'NON TROUVÉ');

            if (!$demande) {
                Log::warning('Aucune demande trouvée pour:', $codeDossier);
                return back()
                    ->withInput()
                    ->with('error', "Aucune demande trouvée avec le code dossier : $codeDossier");
            }

            // Préparation des données pour la vue
            $donnees = $this->preparerDonnees($demande);
            
            Log::info('Redirection vers la vue de résultat');
            return view('suivi.result', $donnees);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Erreur validation:', $e->errors());
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Erreur technique:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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
            'personnel' => 'Crédit Personnel',
            'scolaire' => 'Crédit Scolaire',
            'commerce' => 'Crédit Commerce',
            'immobilier' => 'Crédit Immobilier',
            'automobile' => 'Crédit Automobile',
            'auto' => 'Crédit Auto',
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
            'messageStatut' => $statutInfo['message']
        ];
    }
}
