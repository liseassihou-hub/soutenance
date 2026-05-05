<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeCredit;

class SuiviDemandeController extends Controller
{
    /**
     * Afficher le formulaire de suivi
     */
    public function form()
    {
        return view('pebco.suivi.form');
    }

    /**
     * Rechercher une demande
     */
    public function rechercher(Request $request)
    {
        try {
            // Debug: voir les données reçues
            \Log::info('=== DÉBUT RECHERCHE DEMANDE ===');
            \Log::info('Données brutes reçues:', $request->all());
            \Log::info('Méthode HTTP:', $request->method());
            \Log::info('URL complète:', $request->fullUrl());
            
            // Validation des données
            $validated = $request->validate([
                'code_dossier' => 'required|string'
            ]);

            // Debug: voir les données validées
            \Log::info('Données validées:', $validated);
            \Log::info('Code dossier recherché:', $validated['code_dossier']);

            // Recherche de la demande par code dossier uniquement
            $demande = DemandeCredit::where('code_dossier', $validated['code_dossier'])->first();
            
            // Debug: voir si la demande est trouvée
            if ($demande) {
                \Log::info('✅ Demande trouvée:', [
                    'id' => $demande->id, 
                    'code_dossier' => $demande->code_dossier,
                    'nom' => $demande->nom . ' ' . $demande->prenom,
                    'email' => $demande->email,
                    'statut' => $demande->statut
                ]);
            } else {
                \Log::warning('❌ Aucune demande trouvée pour le code:', $validated['code_dossier']);
            }

            if (!$demande) {
                return back()
                    ->withInput()
                    ->with('error', 'Aucune demande trouvée avec ce code dossier.');
            }

            // Préparation des données pour la vue
            $donnees = $this->preparerDonneesDemande($demande);
            $donnees['demande'] = $demande; // Ajout de l'objet demande original

            \Log::info('📤 Redirection vers la vue de résultat');
            return view('pebco.suivi.result', $donnees);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Erreur de validation:', $e->errors());
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            \Log::error('❌ Erreur technique:', [
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
     * API endpoint pour récupérer les détails d'une demande par code de suivi
     */
    public function apiShow($codeSuivi)
    {
        try {
            $demande = DemandeCredit::where('code_dossier', $codeSuivi)->first();
            
            if (!$demande) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune demande trouvée avec ce code de suivi',
                    'code' => 'NOT_FOUND'
                ], 404);
            }
            
            // Préparer les données de la demande
            $donnees = $this->preparerDonneesDemande($demande);
            
            return response()->json([
                'success' => true,
                'message' => 'Demande trouvée avec succès',
                'data' => [
                    'demande' => [
                        'id' => $demande->id,
                        'code_suivi' => $demande->code_dossier,
                        'nom_complet' => $demande->nom_complet,
                        'email' => $demande->email,
                        'telephone' => $demande->telephone,
                        'montant' => $demande->montant,
                        'montant_formatted' => $demande->montant_formatted,
                        'type_credit' => $demande->type_credit,
                        'type_credit_formatted' => $demande->type_credit_formatted,
                        'objet_credit' => $demande->objet_credit,
                        'duree' => $demande->duree,
                        'statut' => $demande->statut,
                        'statut_info' => [
                            'texte' => $donnees['texteStatut'],
                            'icone' => $donnees['iconeStatut'],
                            'couleur' => $donnees['couleurStatut'],
                            'message' => $donnees['messageStatut']
                        ],
                        'created_at' => $demande->created_at->toISOString(),
                        'updated_at' => $demande->updated_at->toISOString(),
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Erreur API lors de la récupération de la demande: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur technique est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Préparer les données de la demande pour l'affichage
     */
    private function preparerDonneesDemande($demande)
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

        $nomCredit = $typesCredit[$demande->type_credit] ?? 'Type de crédit inconnu';

        // Détermination du statut avec messages personnalisés
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
                'message' => 'Demande en cours, veuillez patienter.'
            ],
            'accepte' => [
                'texte' => 'Demande acceptée',
                'icone' => 'fas fa-check-circle',
                'couleur' => '#28a745',
                'message' => 'Demande acceptée, veuillez passer à la caisse.'
            ],
            'refuse' => [
                'texte' => 'Demande refusée',
                'icone' => 'fas fa-times-circle',
                'couleur' => '#dc3545',
                'message' => 'Demande refusée, veuillez contacter le chargé de crédit.'
            ],
            'en_analyse' => [
                'texte' => 'En cours d\'analyse',
                'icone' => 'fas fa-search',
                'couleur' => '#17a2b8',
                'message' => 'Votre demande est en cours d\'analyse par nos agents.'
            ],
            'approuve' => [
                'texte' => 'Demande approuvée',
                'icone' => 'fas fa-check-circle',
                'couleur' => '#28a745',
                'message' => 'Félicitations ! Votre crédit a été approuvé.'
            ],
            'informations_complementaires' => [
                'texte' => 'Informations complémentaires requises',
                'icone' => 'fas fa-exclamation-triangle',
                'couleur' => '#fd7e14',
                'message' => 'Veuillez fournir les informations complémentaires demandées.'
            ]
        ];

        $statutInfo = $statuts[$demande->statut] ?? $statuts['en_attente'];

        return [
            'demande' => $demande,
            'nomCredit' => $nomCredit,
            'texteStatut' => $statutInfo['texte'],
            'iconeStatut' => $statutInfo['icone'],
            'couleurStatut' => $statutInfo['couleur'],
            'messageStatut' => $statutInfo['message']
        ];
    }
}
