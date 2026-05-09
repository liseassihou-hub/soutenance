@extends('layouts.admin')

@section('title', 'Agents - PEBCO')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
                sidebar.style.transform = 'translateX(0)';
                document.body.style.overflow = 'hidden';
                console.log('Showing sidebar');
            } else {
                // Hide sidebar
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
                sidebar.style.transform = 'translateX(0)';
                document.body.style.overflow = 'auto';
                isSidebarOpen = false;
                console.log('Desktop mode - sidebar visible');
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                document.body.style.overflow = 'auto';
                isSidebarOpen = false;
                console.log('Mobile mode - sidebar hidden');
            }
        });
        
        // Initialize sidebar state
        if (window.innerWidth >= 1024) {
            sidebar.style.transform = 'translateX(0)';
            console.log('Init: Desktop mode');
        } else {
            sidebar.style.transform = 'translateX(-100%)';
            console.log('Init: Mobile mode');
        }
    }
});
</script>
@endpush

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
                <a href="/admin/clients" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-users w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Clients</span>
                </a>
                <a href="/admin/agents" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
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
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-green-100 bg-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden relative z-30">
        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg hover:bg-green-700 transition-colors">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">Agents</h1>
                        <p class="text-green-700 text-sm">Liste des agents créés</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.agents.create') }}" class="px-3 sm:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm sm:text-base">
                            <i class="fas fa-plus mr-1 sm:mr-2"></i>Nouvel Agent
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 w-full">
            <!-- Agents Table -->
            <div class="max-w-7xl mx-auto bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Liste des Agents</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200 text-xs sm:text-sm">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Agent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Sexe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-200">
                            @php
                                $agents = \App\Models\Agent::orderBy('id', 'desc')->get();
                            @endphp
                            @foreach($agents as $agent)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-sm font-medium text-green-600">{{ strtoupper(substr($agent->nom ?? 'A', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $agent->nom }} {{ $agent->prenom }}</div>
                                           
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $agent->email }}</div>
                                    <div class="text-sm text-gray-500">{{ $agent->telephone ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $agent->sexe ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($agent->statut == 'activé') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                        {{ $agent->statut ?? 'activé' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" style="position: relative; z-index: 10;">
                                    <a href="{{ route('admin.agents.edit', $agent->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" style="position: relative; z-index: 11;">Modifier</a>
                                    <form action="{{ route('admin.agents.toggle', $agent->id) }}" method="POST" class="inline toggle-agent-form" data-agent-id="{{ $agent->id }}" style="position: relative; z-index: 11;">
                                        @csrf
                                        @if($agent->statut == 'activé')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment désactiver cet agent?')" style="position: relative; z-index: 12;">
                                                Désactiver
                                            </button>
                                        @else
                                            <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Voulez-vous vraiment activer cet agent?')" style="position: relative; z-index: 12;">
                                                Activer
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
