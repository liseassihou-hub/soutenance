@extends('agent.layout')

@section('title', 'Tableau de bord')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 p-6">
    <!-- En-tête -->
    <div class="max-w-7xl mx-auto mb-8">
        <h1 class="text-3xl font-bold text-green-900">Tableau de bord</h1>
        <p class="text-green-700 mt-2">Bienvenue, {{ Auth::guard('agent')->user()->prenom }} ! Voici un aperçu de vos activités.</p>
    </div>

    <!-- Cartes métriques -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total des dossiers</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($metrics['total_dossiers'], 0, ',', ' ') }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-folder text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-600"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En cours</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($metrics['dossiers_en_cours'], 0, ',', ' ') }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Approuvés</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($metrics['dossiers_approuves'], 0, ',', ' ') }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Refusés</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($metrics['dossiers_refuses'], 0, ',', ' ') }}</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-times-circle text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Section inférieure -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Graphique des statuts -->
        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Répartition des dossiers par statut</h2>
            <div class="space-y-4">
                @php
                    $maxCount = !empty($statuts) ? max($statuts) : 1;
                    $maxCount = $maxCount > 0 ? $maxCount : 1;
                @endphp
                @foreach($statuts as $statut => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="inline-block w-3 h-3 rounded-full" 
                                @if($statut == 'en_cours') style="background-color: #f59e0b;"
                                @elseif($statut == 'approuve') style="background-color: #10b981;"
                                @elseif($statut == 'refuse') style="background-color: #ef4444;"
                                @else style="background-color: #6b7280;"
                                @endif></span>
                            <span class="text-sm font-medium text-gray-700">
                                @if($statut == 'en_cours') En cours
                                @elseif($statut == 'approuve') Approuvés
                                @elseif($statut == 'refuse') Refusés
                                @else Autres
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-300" 
                                    style="width: {{ ($count / $maxCount) * 100 }}%; 
                                    @if($statut == 'en_cours') background-color: #f59e0b;
                                    @elseif($statut == 'approuve') background-color: #10b981;
                                    @elseif($statut == 'refuse') background-color: #ef4444;
                                    @else background-color: #6b7280;
                                    @endif;"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900 w-8 text-right">{{ $count }}</span>
                        </div>
                    </div>
                @endforeach
                
                @if(empty($statuts))
                    <div class="text-center py-8">
                        <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucun dossier trouvé</p>
                        <p class="text-sm text-gray-400 mt-2">Les statistiques s'afficheront ici dès que des dossiers seront disponibles</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dernières demandes -->
        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">5 dernières demandes</h2>
                <a href="{{ route('agent.dossiers') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors">
                    Voir tout
                </a>
            </div>
            <div class="space-y-3">
                @forelse($dernieresDemandes as $demande)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-100 transition-all duration-200 hover:bg-green-100">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $demande->client->nom }} {{ $demande->client->prenom }}</div>
                            <div class="text-sm text-gray-500">{{ $demande->client->telephone }}</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ getStatutLabel($demande->statut) }}
                            </span>
                            <a href="{{ route('agent.dossiers.show', $demande->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Aucune demande trouvée</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<?php
function getStatutColor($statut) {
    $colors = [
        'en_attente' => 'bg-orange-500',
        'en_cours' => 'bg-blue-500',
        'accepte' => 'bg-green-500',
        'refuse' => 'bg-red-500',
    ];
    return $colors[$statut] ?? 'bg-green-500';
}

function getStatutLabel($statut) {
    $labels = [
        'en_attente' => 'En attente',
        'en_cours' => 'En cours',
        'accepte' => 'Accepté',
        'refuse' => 'Refusé',
    ];
    return $labels[$statut] ?? $statut;
}

function getStatutBadgeClass($statut) {
    $classes = [
        'en_attente' => 'bg-orange-100 text-orange-800',
        'en_cours' => 'bg-blue-100 text-blue-800',
        'accepte' => 'bg-green-100 text-green-800',
        'refuse' => 'bg-red-100 text-red-800',
    ];
    return $classes[$statut] ?? 'bg-gray-100 text-gray-800';
}
?>
        </div>
    </div>
</div>
@endsection
