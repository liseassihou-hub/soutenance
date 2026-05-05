@extends('layouts.admin')

@section('title', 'Résultats de Recherche Clients - PEBCO')

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
                <a href="/admin/clients" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
                    <i class="fas fa-users w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Clients</span>
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
                        <h1 class="text-2xl font-bold text-green-900">Résultats de Recherche</h1>
                        <p class="text-green-700 text-sm">
                            @if($search)
                                Recherche pour : "{{ $search }}" ({{ $clients->count() }} résultat(s))
                            @else
                                Aucun terme de recherche spécifié
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
            <!-- Search Form -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <form action="{{ route('admin.clients.search') }}" method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Rechercher par nom, prénom ou téléphone..." 
                                   value="{{ $search }}"
                                   class="w-full pl-10 pr-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-green-400"></i>
                        </div>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Rechercher
                    </button>
                </form>
            </div>

            <!-- Results Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Clients Trouvés</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Adresse</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-200">
                            @forelse($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">{{ strtoupper(substr($client->nom ?? 'C', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $client->nom }} {{ $client->prenom }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $client->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $client->telephone ?? 'Non renseigné' }}</div>
                                    <div class="text-sm text-gray-500">{{ $client->situation_famille ?? 'Non spécifiée' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $client->adresse ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $client->ville ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $client->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.clients.show', $client->id) }}" class="text-blue-600 hover:text-blue-900">Voir</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-search text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Aucun client trouvé</p>
                                        <p class="text-sm mt-2">Essayez avec d'autres termes de recherche</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($clients->hasPages())
                <div class="px-6 py-4 border-t border-green-200">
                    {{ $clients->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</div>
@endsection
