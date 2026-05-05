@extends('layouts.admin')

@section('title', 'Résultats de Recherche Demandes - PEBCO')

@section('content')
<div class="flex h-screen bg-green-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-900 text-white flex-shrink-0">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-8">
                <i class="fas fa-university text-green-400 text-2xl"></i>
                <div>
                    <h2 class="text-xl font-bold">PEBCO</h2>
                    <p class="text-green-200 text-sm">Admin Panel</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Tableau de Bord</span>
                </a>
                <a href="/admin/clients" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-users w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Clients</span>
                </a>
                <a href="{{ route('admin.demandes') }}" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
                    <i class="fas fa-file-invoice w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Demandes</span>
                </a>
                <a href="/admin/agents" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-user-tie w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Agents</span>
                </a>
            </nav>
        </div>
        
        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-green-200">Administrateur</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">Demandes par Statut</h1>
                        <p class="text-green-700 text-sm">
                            @if($statut)
                                Statut : "{{ $statut }}" ({{ $demandes->count() }} résultat(s))
                            @else
                                Tous les statuts ({{ $demandes->count() }} résultat(s))
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-arrow-left mr-2"></i>Retour au dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Filter Form -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <form action="{{ route('admin.demandes.search') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <select name="statut" 
                                class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ $statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours" {{ $statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="approuve" {{ $statut == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                            <option value="refuse" {{ $statut == 'refuse' ? 'selected' : '' }}>Refusé</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                </form>
            </div>

            <!-- Results Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Demandes Trouvées</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Code Dossier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-200">
                            @forelse($demandes as $demande)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
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
                                    <div class="text-sm font-medium text-gray-900">{{ $demande->code_dossier }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($demande->statut == 'en_attente') bg-green-100 text-green-800
                                        @elseif($demande->statut == 'en_cours') bg-yellow-100 text-yellow-800
                                        @elseif($demande->statut == 'approuve') bg-green-100 text-green-800
                                        @elseif($demande->statut == 'refuse') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($demande->statut == 'en_attente') En attente
                                        @elseif($demande->statut == 'en_cours') En cours
                                        @elseif($demande->statut == 'approuve') Approuvé
                                        @elseif($demande->statut == 'refuse') Refusé
                                        @else {{ $demande->statut }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.demande.show', $demande->id) }}" class="text-green-600 hover:text-green-900">Voir</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-filter text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucune demande trouvée</p>
                                        <p class="text-sm mt-2">Essayez avec un autre statut</p>
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
        </main>
    </div>
</div>
@endsection
