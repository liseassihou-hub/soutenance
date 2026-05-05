<?php
// Définir les variables de statut en fonction du statut de la demande
switch($demande->statut) {
    case 'en_attente':
        $couleurStatut = '#f59e0b';
        $iconeStatut = 'fas fa-clock';
        $texteStatut = 'En attente de traitement';
        $messageStatut = 'Votre demande est en cours d\'examen par nos services. Nous vous informerons dès qu\'une décision sera prise.';
        break;
    case 'approuve':
        $couleurStatut = '#10b981';
        $iconeStatut = 'fas fa-check-circle';
        $texteStatut = 'Demande approuvée';
        $messageStatut = 'Votre demande a été approuvée.';
        break;
    case 'refuse':
        $couleurStatut = '#ef4444';
        $iconeStatut = 'fas fa-times-circle';
        $texteStatut = 'Demande refusée';
        $messageStatut = 'Nous sommes désolés, votre demande n\'a pas pu être approuvée à ce moment.';
        break;
    default:
        $couleurStatut = '#6b7280';
        $iconeStatut = 'fas fa-question-circle';
        $texteStatut = 'Statut inconnu';
        $messageStatut = 'Le statut de votre demande n\'est pas défini.';
        break;
}

// Définir le nom du crédit
$nomCredit = $demande->type_credit ?? 'Non spécifié';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat du Suivi - PEBCo BETHESDA</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-700 via-green-800 to-green-900 p-4">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6">
            <div class="flex justify-between items-center flex-wrap gap-3">
                <div>
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <i class="fas fa-search"></i> Résultat du Suivi
                    </h3>
                    <p class="text-green-100 text-sm">
                        Code: {{ $demande->code_dossier }}
                    </p>
                </div>

                <div class="text-sm text-green-100">
                    Demandé le : {{ is_string($demande->created_at) ? date('d/m/Y', strtotime($demande->created_at)) : $demande->created_at->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="p-8">

            <!-- STATUT -->
            <div class="text-center mb-10">
                <div class="w-28 h-28 mx-auto rounded-full flex items-center justify-center mb-4"
                     style="background: {{ $couleurStatut }}20;">
                    <i class="{{ $iconeStatut }} text-4xl" style="color: {{ $couleurStatut }}"></i>
                </div>

                <h2 class="text-2xl font-bold mb-2" style="color: {{ $couleurStatut }}">
                    {{ $texteStatut }}
                </h2>

                <p class="text-gray-600 text-sm max-w-md mx-auto">
                    {{ $messageStatut }}
                </p>
            </div>

            <!-- INFOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

                <!-- INFORMATIONS DU DEMANDEUR -->
                <div>
                    <h5 class="text-lg font-semibold mb-4 text-green-700 flex items-center gap-2">
                        <i class="fas fa-user"></i> Informations du demandeur
                    </h5>

                    <div class="space-y-2 text-base">
                        <p><span class="font-semibold text-gray-700">Nom :</span> {{ $demande->client->nom }} {{ $demande->client->prenom }}</p>
                        <p><span class="font-semibold text-gray-700">Téléphone :</span> {{ $demande->client->telephone }}</p>
                        <p><span class="font-semibold text-gray-700">Pièce d'identité :</span> {{ $demande->client->piece_identite_numero }}</p>
                    </div>
                </div>

                <!-- INFORMATIONS PROFESSIONNELLES -->
                <div>
                    <h5 class="text-lg font-semibold mb-4 text-green-700 flex items-center gap-2">
                        <i class="fas fa-briefcase"></i> Informations sur la demande
                    </h5>

                    <div class="space-y-2 text-base">
                        <p><span class="font-semibold text-gray-700">Type de crédit :</span> {{ $demande->type_credit }}</p>
                        <p>
                            <span class="font-semibold text-gray-700">Montant demandé :</span>
                            <span class="font-bold text-green-600">
                                {{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA
                            </span>
                        </p>
                       
                        <p><span class="font-semibold text-gray-700">Durée :</span> {{ $demande->duree_mois }} mois</p>
                        
                        <p><span class="font-semibold text-gray-700">Périodicité :</span> {{ ucfirst($demande->periodicite) }}</p>
                        
                        <p><span class="font-semibold text-gray-700">Date de demande :</span> {{ \Carbon\Carbon::parse($demande->date_demande)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- ALERTES -->
            <div class="text-center">

                @if($demande->statut == 'accepte' || $demande->statut == 'approuve')
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 text-green-800 px-6 py-4 rounded-lg mb-4 shadow-md">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-2xl text-green-600 mr-3"></i>
                            <div>
                                <strong class="text-green-900">Félicitations !</strong> Votre demande a été acceptée. Veillez passé à la caisse pour le décaissement.
                            </div>
                        </div>
                    </div>

                @elseif($demande->statut == 'refuse')
                

                    @if($demande->raison_refus)
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
                        <h4 class="font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Raison du refus :
                        </h4>
                        <p class="text-sm">{{ $demande->raison_refus }}</p>
                    </div>
                    @endif

                  

                @elseif($demande->statut == 'en_cours' || $demande->statut == 'en_analyse')
                    <div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-3 rounded-lg mb-4">
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        <strong>Patience...</strong> Votre demande est en cours de traitement.
                    </div>
                @endif

                <!-- BOUTONS -->
                <div class="mt-6 flex flex-wrap justify-center gap-3">

                    <a href="{{ route('suivi-demande') }}"
                       class="inline-flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold transition shadow hover:shadow-lg">
                        <i class="fas fa-search"></i> Nouvelle recherche
                    </a>

                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold transition shadow hover:shadow-lg">
                        <i class="fas fa-home"></i> Accueil
                    </a>

                </div>
            </div>

        </div>
    </div>

</body>
</html>