@extends('layouts.admin')

@section('title', 'Tableau de Bord Administrateur - PEBCO')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('scripts')
<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
        const sidebar = document.querySelector('aside');
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
@endpush

@section('content')
<div class="h-screen bg-green-50 flex">
    <!-- Sidebar Fixed Position -->
    <aside class="w-64 bg-green-900 text-white flex-shrink-0 fixed lg:relative lg:translate-x-0 -translate-x-full transition-transform duration-300 lg:block z-20 h-screen overflow-y-auto">
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
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
                    <i class="fas fa-tachometer-alt w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Tableau de Bord</span>
                </a>
                <a href="/admin/clients" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
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
                <button type="submit" class="flex items-center space-x-3 px-6 py-3 text-green-100 bg-red-500 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Mobile Menu Toggle -->
        <button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-30 bg-green-600 text-white p-3 rounded-lg">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">Tableau de Bord</h1>
                        <p class="text-green-700 text-sm">Bienvenue dans le panneau d'administration</p>
                    </div>
                                    </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 w-full">
            <!-- Stats Cards -->
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Total des Demandes -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-folder text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total des Demandes</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalDemandes }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-blue-600 font-medium">Toutes les demandes</span>
                            <span class="text-gray-500 ml-2">système</span>
                        </div>
                    </div>
                </div>

                <!-- Demandes en Cours -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-spinner text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">En Cours</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $demandesEnCours }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-yellow-600 font-medium">En traitement</span>
                            <span class="text-gray-500 ml-2">actuellement</span>
                        </div>
                    </div>
                </div>

                <!-- Approuvées -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Approuvées</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $demandesApprouvees }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-green-600 font-medium">Acceptées</span>
                            <span class="text-gray-500 ml-2">validées</span>
                        </div>
                    </div>
                </div>

                <!-- Refusées -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times-circle text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Refusées</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $demandesRefusees }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-red-600 font-medium">Rejetées</span>
                            <span class="text-gray-500 ml-2">non validées</span>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Charts and Tables -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <!-- Chart -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-green-900">Évolution des Demandes</h2>
                        <select id="chartPeriod" class="text-sm border-green-300 rounded-md">
                            <option value="7">7 derniers jours</option>
                            <option value="30">30 derniers jours</option>
                            <option value="90">3 mois</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="demandesChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-green-900 mb-4">Activités Récentes</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Nouvelle demande approuvée</p>
                                <p class="text-xs text-gray-500">Il y a 2 heures</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Nouveau client inscrit</p>
                                <p class="text-xs text-gray-500">Il y a 3 heures</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-green-600 text-xs"></i>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Demande en attente</p>
                                <p class="text-xs text-gray-500">Il y a 5 heures</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Messages d'erreur -->
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search Section -->
            <div class="max-w-7xl mx-auto mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Recherche par Statut</h3>
                    <form action="{{ route('admin.demandes.search') }}" method="GET" class="space-y-4">
                        <select name="statut" 
                                class="w-full px-4 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="approuve" {{ request('statut') == 'approuve' ? 'selected' : '' }}>Approuvé</option>
                            <option value="refuse" {{ request('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                        </select>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i>Filtrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="max-w-7xl mx-auto mt-6 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-green-200">
                    <h2 class="text-lg font-semibold text-green-900">Demandes Récentes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-green-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Montant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Assignation</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-green-200">
                            @php
                                $recentDemandes = \App\Models\DemandeCredit::with(['client', 'agent'])->orderBy('date_demande', 'desc')->take(5)->get();
                                // Debug: Check if agent data is loaded
                                foreach($recentDemandes as $d) {
                                    \Log::info('Demande ID: ' . $d->id . ', Agent ID: ' . ($d->agent_id ?? 'null') . ', Agent: ' . ($d->agent ? $d->agent->nom : 'no agent'));
                                }
                            @endphp
                            @foreach($recentDemandes as $demande)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <span class="text-xs font-medium text-green-600">{{ strtoupper(substr($demande->client->nom ?? 'C', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $demande->client->nom ?? 'N/A' }} {{ $demande->client->prenom ?? '' }}</div>
                                            <div class="text-sm text-gray-500">{{ $demande->client->telephone ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($demande->statut == 'en_attente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            En Attente
                                        </span>
                                    @elseif($demande->statut == 'approuve')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approuvé
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejeté
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($demande->agent_id)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-user-check mr-1"></i>
                                            {{ $demande->agent->nom ?? 'Agent' }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Non assigné
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $demande->date_demande->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/admin/demandes/{{ $demande->id }}" class="text-green-600 hover:text-green-900">Voir</a>
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

@push('scripts')
<script>
// Données réelles pour le graphique
@php
// Données pour les 7 derniers jours
$dailyData = [];
$labels7 = [];
for ($i = 6; $i >= 0; $i--) {
    $date = now()->subDays($i);
    $labels7[] = $date->format('D');
    $dailyData[] = \App\Models\DemandeCredit::whereDate('date_demande', $date->format('Y-m-d'))->count();
}

// Données pour les 30 derniers jours (par semaine)
$weeklyData = [];
$labels30 = [];
for ($i = 3; $i >= 0; $i--) {
    $startDate = now()->subWeeks($i + 1)->startOfWeek();
    $endDate = now()->subWeeks($i + 1)->endOfWeek();
    $labels30[] = 'Sem ' . (4 - $i);
    $weeklyData[] = \App\Models\DemandeCredit::whereBetween('date_demande', [$startDate, $endDate])->count();
}

// Données pour les 90 derniers jours (par mois)
$monthlyData = [];
$labels90 = [];
for ($i = 2; $i >= 0; $i--) {
    $date = now()->subMonths($i);
    $labels90[] = $date->format('M');
    $monthlyData[] = \App\Models\DemandeCredit::whereMonth('date_demande', $date->month)->whereYear('date_demande', $date->year)->count();
}
@endphp

const chartData = {
    7: {
        labels: @json($labels7),
        data: @json($dailyData)
    },
    30: {
        labels: @json($labels30),
        data: @json($weeklyData)
    },
    90: {
        labels: @json($labels90),
        data: @json($monthlyData)
    }
};

// Configuration du graphique
const ctx = document.getElementById('demandesChart').getContext('2d');
const demandesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData[7].labels,
        datasets: [{
            label: 'Nombre de demandes',
            data: chartData[7].data,
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgb(34, 197, 94)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return 'Demandes: ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 12
                    }
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                },
                ticks: {
                    color: '#6b7280',
                    font: {
                        size: 12
                    },
                    stepSize: 1
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});

// Gestion du changement de période
document.getElementById('chartPeriod').addEventListener('change', function(e) {
    const period = parseInt(e.target.value);
    demandesChart.data.labels = chartData[period].labels;
    demandesChart.data.datasets[0].data = chartData[period].data;
    demandesChart.update();
});

// Recherche de clients en temps réel (désactivé - éléments non présents dans le dashboard)
// Les éléments clientSearchInput, clientSearchResults, clientSearchForm n'existent pas dans cette vue
</script>
@endpush
        </main>
    </div>
</div>
@endsection
