@extends('layouts.admin')

@section('title', 'Clients - PEBCO')

@section('content')
<div class="min-h-screen bg-green-50 flex">
    <!-- Sidebar Fixed Position -->
    <aside id="adminSidebar" class="w-64 bg-green-900 text-white flex-shrink-0 fixed lg:relative lg:translate-x-0 -translate-x-full transition-transform duration-300 z-40 h-screen overflow-y-auto hidden lg:block">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-university text-green-400 text-2xl"></i>
                    <div>
                        <h2 class="text-xl font-bold">PEBCO</h2>
                        <p class="text-green-200 text-sm">Admin Panel</p>
                    </div>
                </div>
                <button id="sidebarClose" class="lg:hidden text-green-400 hover:text-white transition-colors p-2">
                    <i class="fas fa-times text-xl"></i>
                </button>
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
                <a href="{{ route('admin.agents') }}" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
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
        <div class="absolute bottom-0 left-0 right-0 p-6 bg-green-900">
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
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-green-100 bg-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg hover:bg-green-700 transition-colors">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200 lg:mt-0 mt-16">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="lg:pl-0 pl-16">
                        <h1 class="text-2xl font-bold text-green-900">Clients</h1>
                        <p class="text-green-700 text-sm">Liste des clients enregistrés</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Search Section -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="px-6 py-4 border-b border-green-200">
                    <h3 class="text-lg font-semibold text-green-900">Recherche</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <input type="text" id="searchClients" placeholder="Rechercher par nom ou prénom" 
                                   class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        </div>
                        <button id="searchButton" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Clients Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Liste des Clients ({{ $clients->total() }})</h2>
                </div>
                <div class="overflow-x-auto">
                    @if($clients->count() > 0)
                        <table class="min-w-full divide-y divide-green-200" id="clientsTable">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Contact</th>
                                    
                                   
                                   
                            </thead>
                            <tbody class="bg-white divide-y divide-green-200">
                                @foreach($clients as $client)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-green-600">{{ strtoupper(substr($client->nom ?? 'C', 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $client->nom }} {{ $client->prenom }}</div>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $client->telephone ?? 'Non renseigné' }}</div>
                                       
                                    </td>
                                    
                                    <td>
                                         
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('admin.clients.show', $client->id) }}" class="text-green-600 hover:text-green-900">Voir</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
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
                            @endif
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                            <p class="text-lg font-medium text-gray-900">Aucun client trouvé</p>
                            <p class="text-sm text-gray-500 mt-2">Aucun client n'a été enregistré pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction de recherche
    function searchClients() {
        const searchValue = document.getElementById('searchClients').value.toLowerCase();
        const rows = document.querySelectorAll('#clientsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    }

    // Vérifier si les éléments existent avant d'ajouter les écouteurs
    const searchInput = document.getElementById('searchClients');
    const searchButton = document.getElementById('searchButton');
    
    if (searchInput) {
        // Recherche en temps réel
        searchInput.addEventListener('input', searchClients);
        
        // Recherche avec touche Entrée
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchClients();
            }
        });
    }
    
    if (searchButton) {
        // Bouton de recherche
        searchButton.addEventListener('click', searchClients);
    }
    
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('adminSidebar');
    
    if (sidebarToggle && sidebar) {
        // Initialize sidebar state
        let isSidebarOpen = false;
        
        // Function to toggle sidebar
        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            console.log('Toggle sidebar:', isSidebarOpen);
            
            if (isSidebarOpen) {
                // Show sidebar
                sidebar.classList.remove('hidden');
                sidebar.classList.add('block');
                sidebar.style.transform = 'translateX(0)';
                document.body.style.overflow = 'hidden';
                console.log('Showing sidebar');
            } else {
                // Hide sidebar
                sidebar.classList.add('hidden');
                sidebar.classList.remove('block');
                sidebar.style.transform = 'translateX(-100%)';
                document.body.style.overflow = 'auto';
                console.log('Hiding sidebar');
            }
        }
        
        // Toggle sidebar on button click
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Hamburger clicked');
            toggleSidebar();
        });
        
        // Close sidebar with close button
        const sidebarClose = document.getElementById('sidebarClose');
        if (sidebarClose) {
            sidebarClose.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Close button clicked');
                if (isSidebarOpen) {
                    toggleSidebar();
                }
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 1024 && isSidebarOpen && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target) &&
                !sidebarClose?.contains(event.target)) {
                console.log('Clicking outside - closing sidebar');
                toggleSidebar();
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('block');
                sidebar.style.transform = 'translateX(0)';
                document.body.style.overflow = 'auto';
                isSidebarOpen = false;
                console.log('Desktop mode - sidebar visible');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('block');
                sidebar.style.transform = 'translateX(-100%)';
                document.body.style.overflow = 'auto';
                isSidebarOpen = false;
                console.log('Mobile mode - sidebar hidden');
            }
        });
        
        // Initialize sidebar state
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('block');
            sidebar.style.transform = 'translateX(0)';
            console.log('Init: Desktop mode');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('block');
            sidebar.style.transform = 'translateX(-100%)';
            console.log('Init: Mobile mode');
        }
    }
});
</script>
@endsection
