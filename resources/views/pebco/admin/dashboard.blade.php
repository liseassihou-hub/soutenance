@extends('layouts.app')

@section('title', 'Dashboard Admin - PEBCO BETHESDA')

@section('content')
<div class="admin-dashboard">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="header-title">
                        <h4 class="mb-0 fw-bold text-white">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard Admin
                        </h4>
                        <small class="text-white-50">PEBCO BETHESDA</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-actions">
                        <div class="dropdown">
                            <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>
                                <span>{{ auth()->user()->name }}</span>
                                <span class="badge bg-danger ms-2">{{ auth()->user()->role_label }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('pebco.admin.agents') }}">
                                    <i class="fas fa-users me-2"></i>Gérer les Agents
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('pebco.admin.demandes') }}">
                                    <i class="fas fa-folder-open me-2"></i>Demandes de Crédit
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('pebco.logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Messages Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Contenu Principal -->
    <div class="dashboard-content">
        <div class="container-fluid">
            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $stats['total_users'] }}</h3>
                            <p class="stat-label">Total Utilisateurs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $stats['total_agents'] }}</h3>
                            <p class="stat-label">Agents Actifs</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-info">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $stats['total_demandes'] }}</h3>
                            <p class="stat-label">Total Demandes</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-icon bg-warning">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">{{ $stats['taux_approbation'] }}%</h3>
                            <p class="stat-label">Taux d'Approbation</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques et Tableaux -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Évolution des Demandes
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="demandesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>
                                Répartition par Statut
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="statutsChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableaux des Données -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-user-plus me-2"></i>
                                Agents Récents
                            </h6>
                            <a href="{{ route('pebco.admin.agents') }}" class="btn btn-sm btn-outline-primary">
                                Voir tout
                            </a>
                        </div>
                        <div class="card-body">
                            @if($agentsRecents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($agentsRecents as $agent)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-success">{{ $agent->role_label }}</span>
                                                    {{ $agent->name }}
                                                </td>
                                                <td>{{ $agent->email }}</td>
                                                <td>{{ $agent->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('pebco.admin.agents.edit', $agent->id) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('pebco.admin.agents.delete', $agent->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet agent?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-users fa-2x mb-3"></i>
                                    <h6>Aucun agent récent</h6>
                                    <p>Commencez par créer des agents.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-folder-open me-2"></i>
                                Demandes Récentes
                            </h6>
                            <a href="{{ route('pebco.admin.demandes') }}" class="btn btn-sm btn-outline-primary">
                                Voir tout
                            </a>
                        </div>
                        <div class="card-body">
                            @if($demandesRecentes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Client</th>
                                                <th>Montant</th>
                                                <th>Statut</th>
                                                <th>Agent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($demandesRecentes as $demande)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $demande->code_dossier }}</span>
                                                </td>
                                                <td>{{ $demande->nom_complet }}</td>
                                                <td>{{ $demande->montant_formatted }}</td>
                                                <td>{!! $demande->statut_badge !!}</td>
                                                <td>
                                                    @if($demande->agent)
                                                        <span class="badge bg-success">{{ $demande->agent->name }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">Non assigné</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-2x mb-3"></i>
                                    <h6>Aucune demande récente</h6>
                                    <p>Les demandes apparaîtront ici.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    background: #f8f9fa;
    min-height: 100vh;
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1rem 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.header-title h4 {
    margin: 0;
}

.dashboard-content {
    padding: 2rem 0;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.stat-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.stat-content p {
    margin: 0.25rem 0 0 0;
    color: #666;
    font-size: 0.9rem;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
    border: none;
}

.card-header h6 {
    margin: 0;
}

@media (max-width: 768px) {
    .dashboard-content {
        padding: 1rem 0;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .stat-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des demandes mensuelles
    const demandesCtx = document.getElementById('demandesChart').getContext('2d');
    new Chart(demandesCtx, {
        type: 'line',
        data: {
            labels: @json($statsMensuelles['labels']),
            datasets: [{
                label: 'Demandes',
                data: @json($statsMensuelles['demandes']),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4
            }, {
                label: 'Approuvées',
                data: @json($statsMensuelles['approuvees']),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Graphique des statuts
    const statutsCtx = document.getElementById('statutsChart').getContext('2d');
    new Chart(statutsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Soumis', 'En Analyse', 'Validés', 'Refusés'],
            datasets: [{
                data: [
                    {{ $stats['demandes_en_attente'] }},
                    {{ $stats['demandes_en_analyse'] }},
                    {{ $stats['demandes_validees'] }},
                    {{ $stats['demandes_refusees'] }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#28a745',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endsection
