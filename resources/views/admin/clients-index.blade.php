@extends('layouts.admin')

@section('title', 'Clients - PEBCO')

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
                <a href="{{ route('admin.clients') }}" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
                    <i class="fas fa-users w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Clients</span>
                </a>
                <a href="/admin/agents" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-user-tie w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Agents</span>
                </a>
                <a href="{{ route('admin.agents.create') }}" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-user-plus w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Créer Agent</span>
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
                        <h1 class="text-2xl font-bold text-green-900">Clients</h1>
                        <p class="text-green-700 text-sm">Liste des clients ayant fait des demandes</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ \App\Models\Client::count() }} Clients
                        </div>
                    </div>
                </div>
            </div>
        </header>

       
            <!-- Clients Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Liste des Clients</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Demandes</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-200">
                                                        @foreach($clients as $client)
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
                                    <div class="text-sm text-gray-900">{{ $client->telephone }}</div>
                                    <div class="text-sm text-gray-500">{{ $client->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $client->demandesCredit->count() }}</div>
                                    <div class="text-xs text-gray-500">demande(s)</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($client->demandesCredit->where('statut', 'approuve')->count() > 0)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $client->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.demande.show', $client->id) }}" class="text-green-600 hover:text-green-900 mr-3">Voir</a>
                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($clients->hasPages())
                    <div class="px-6 py-4 border-t border-green-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Affichage de {{ $clients->firstItem() }} à {{ $clients->lastItem() }} 
                                sur {{ $clients->total() }} clients
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $clients->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
