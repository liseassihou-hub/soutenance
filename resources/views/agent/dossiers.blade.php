@extends('agent.layout')

@section('title', 'Dossiers')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 p-6">
    <!-- En-tête -->
    <div class="max-w-7xl mx-auto mb-8">
        <h1 class="text-3xl font-bold text-green-900">Dossiers</h1>
        <p class="text-green-700 mt-2">Liste de toutes les demandes de crédit</p>
    </div>

    <!-- Carte principale -->
    <div class="max-w-7xl mx-auto">
        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request()->get('search') }}" 
                           placeholder="Entrez le nom à rechercher " 
                           class="w-full px-3 py-2 border-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="min-w-40">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request()->get('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours" {{ request()->get('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="approuve" {{ request()->get('statut') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                        <option value="accepte" {{ request()->get('statut') == 'accepte' ? 'selected' : '' }}>Accepté</option>
                        <option value="refuse" {{ request()->get('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                    </select>
                </div>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Filtrer
                </button>
            </form>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-green-200">
            <!-- En-tête du tableau -->
            <div class="px-6 py-4 border-b border-green-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-green-900">Liste des Dossiers</h2>
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $demandes->count() }} Dossiers
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des dossiers -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-green-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Durée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-green-200">
                        @forelse($demandes as $demande)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">{{ strtoupper(substr($demande->client->nom ?? 'C', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $demande->client->nom }} {{ $demande->client->prenom }}</div>
                                            <div class="text-sm text-gray-500">{{ $demande->client->telephone }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $demande->duree_mois }} mois</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($demande->statut == 'en_cours') bg-amber-100 text-amber-800
                                        @elseif($demande->statut == 'approuve') bg-green-100 text-green-800
                                        @elseif($demande->statut == 'refuse') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($demande->statut == 'en_cours') En cours
                                        @elseif($demande->statut == 'approuve') Approuvé
                                        @elseif($demande->statut == 'refuse') Refusé
                                        @else En attente
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($demande->date_demande)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('agent.dossiers.show', $demande->id) }}" class="text-green-600 hover:text-green-900 mr-3">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                   
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-folder-open text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucun dossier trouvé</p>
                                        <p class="text-sm mt-2">Il n'y a aucune demande de crédit pour le moment.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($demandes->hasPages())
                <div class="px-6 py-4 border-t border-green-200">
                    {{ $demandes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
