@extends('agent.layout')

@section('title', 'Dossiers')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dossiers</h1>
        <p class="text-gray-600 mt-2">Liste de toutes les demandes de crédit</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input type="text" name="search" value="{{ request()->get('search') }}" 
                       placeholder="Nom, email, code dossier..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="min-w-40">
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request()->get('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_cours" {{ request()->get('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="accepte" {{ request()->get('statut') == 'accepte' ? 'selected' : '' }}>Accepté</option>
                    <option value="refuse" {{ request()->get('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search mr-2"></i>Filtrer
            </button>
        </form>
    </div>

    <!-- Tableau des dossiers -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code dossier</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($demandes as $demande)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $demande->code_dossier }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $demande->nom }} {{ $demande->prenom }}</div>
                                <div class="text-sm text-gray-500">{{ $demande->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($demande->montant, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ getStatutBadgeClass($demande->statut) }}">
                                    {{ getStatutLabel($demande->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $demande->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('agent.dossiers.show', $demande->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p class="text-lg font-medium">Aucun dossier trouvé</p>
                                    <p class="text-sm">Essayez de modifier vos filtres de recherche.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($demandes->hasPages())
            <div class="bg-white px-6 py-3 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Affichage de {{ $demandes->firstItem() }} à {{ $demandes->lastItem() }} 
                    sur {{ $demandes->total() }} résultats
                </div>
                {{ $demandes->links() }}
            </div>
        @endif
    </div>
</div>

@php
function getStatutBadgeClass($statut) {
    $classes = [
        'en_attente' => 'bg-orange-100 text-orange-800',
        'en_cours' => 'bg-blue-100 text-blue-800',
        'accepte' => 'bg-green-100 text-green-800',
        'refuse' => 'bg-red-100 text-red-800',
    ];
    return $classes[$statut] ?? 'bg-gray-100 text-gray-800';
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
@endphp
@endsection
