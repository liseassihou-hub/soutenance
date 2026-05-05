@extends('layouts.app')

@section('title', 'Demandes de Crédit - PEBCO')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <header class="admin-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-dark me-3" id="sidebarToggle">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div>
                        <h4 class="mb-0 fw-bold text-success">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Demandes de Crédit
                        </h4>
                        <small class="text-muted">Gestion des demandes de crédit</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Bouton retour dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left me-1"></i>Dashboard
                    </a>
                    
                    <!-- Notifications -->
                    <div class="dropdown me-3">
                        <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notificationsCount ?? 0 }}
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">Notifications</li>
                            <li><a class="dropdown-item text-muted">Aucune nouvelle notification</a></li>
                        </ul>
                    </div>
                    
                    <!-- Info Admin -->
                    <div class="dropdown">
                        <button class="btn btn-light d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2"></i>
                            <span>{{ Auth::guard('admin')->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="row">
        <!-- Menu Latéral -->
        <div class="col-md-2">
            <nav class="admin-sidebar bg-light rounded p-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="{{ route('admin.demandes') }}">
                            <i class="fas fa-file-invoice-dollar me-2"></i>Demandes de Crédit
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.clients') }}">
                            <i class="fas fa-users me-2"></i>Clients
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.agents') }}">
                            <i class="fas fa-user-tie me-2"></i>Agents
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.statistiques') }}">
                            <i class="fas fa-chart-bar me-2"></i>Statistiques
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="{{ route('admin.parametres') }}">
                            <i class="fas fa-cogs me-2"></i>Paramètres
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Contenu Principal -->
        <div class="col-md-10">
            <!-- Filtres et Recherche -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.demandes') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Rechercher</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           placeholder="Nom, email, code dossier..." 
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select class="form-select" id="statut" name="statut">
                                        <option value="">Tous</option>
                                        <option value="soumis" {{ request('statut') == 'soumis' ? 'selected' : '' }}>En attente</option>
                                        <option value="en_analyse" {{ request('statut') == 'en_analyse' ? 'selected' : '' }}>En analyse</option>
                                        <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Approuvé</option>
                                        <option value="refuse" {{ request('statut') == 'refuse' ? 'selected' : '' }}>Refusé</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="credit_type_id" class="form-label">Type Crédit</label>
                                    <select class="form-select" id="credit_type_id" name="credit_type_id">
                                        <option value="">Tous</option>
                                        @foreach($typesCredit as $key => $type)
                                            <option value="{{ $key }}" {{ request('credit_type_id') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="date_debut" class="form-label">Date début</label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" 
                                           value="{{ request('date_debut') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="date_fin" class="form-label">Date fin</label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" 
                                           value="{{ request('date_fin') }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('admin.demandes') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des Demandes -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">Liste des Demandes ({{ $demandes->total() }} demandes)</h6>
                                </div>
                                <div class="col-auto">
                                    <div class="d-flex gap-2">
                                        <!-- Export -->
                                        <button class="btn btn-success btn-sm" onclick="exportDemandes()">
                                            <i class="fas fa-download me-1"></i>Exporter
                                        </button>
                                        <!-- Nouvelle demande -->
                                        <a href="{{ route('home') }}#demande" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>Nouvelle Demande
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'code_dossier', 'order' => (request('sort') == 'code_dossier' && request('order') == 'asc') ? 'desc' : 'asc']) }}">
                                                    ID Dossier <i class="fas fa-sort"></i>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'nom', 'order' => (request('sort') == 'nom' && request('order') == 'asc') ? 'desc' : 'asc']) }}">
                                                    Client <i class="fas fa-sort"></i>
                                                </a>
                                            </th>
                                            <th>Email</th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'montant_demande', 'order' => (request('sort') == 'montant_demande' && request('order') == 'asc') ? 'desc' : 'asc']) }}">
                                                    Montant <i class="fas fa-sort"></i>
                                                </a>
                                            </th>
                                            <th>Type Crédit</th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'statut', 'order' => (request('sort') == 'statut' && request('order') == 'asc') ? 'desc' : 'asc']) }}">
                                                    Statut <i class="fas fa-sort"></i>
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'order' => (request('sort') == 'created_at' && request('order') == 'asc') ? 'desc' : 'asc']) }}">
                                                    Date <i class="fas fa-sort"></i>
                                                </a>
                                            </th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($demandes->count() > 0)
                                            @foreach($demandes as $demande)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $demande->code_dossier }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $demande->client->nom ?? 'N/A' }} {{ $demande->client->prenom ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $demande->client->telephone ?? 'N/A' }}</small>
                                                </td>
                                                <td>{{ $demande->client->email ?? 'N/A' }}</td>
                                                <td>
                                                    <strong>{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</strong>
                                                </td>
                                                <td>{{ $typesCredit[(int)$demande->credit_type_id] ?? 'Non spécifié' }}</td>
                                                <td>
                                                    @switch($demande->statut)
                                                        @case('soumis')
                                                            <span class="badge bg-warning">En attente</span>
                                                            @break
                                                        @case('en_analyse')
                                                            <span class="badge bg-info">En analyse</span>
                                                            @break
                                                        @case('valide')
                                                            <span class="badge bg-success">Approuvé</span>
                                                            @break
                                                        @case('refuse')
                                                            <span class="badge bg-danger">Refusé</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">Inconnu</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    {{ $demande->created_at->format('d/m/Y H:i') }}
                                                    <br>
                                                    <small class="text-muted">{{ $demande->created_at->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.demande.show', $demande->id) }}" class="btn btn-outline-primary btn-sm" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <h5>Aucune demande trouvée</h5>
                                                    <p>Aucune demande de crédit ne correspond à vos critères de recherche.</p>
                                                    <a href="{{ route('home') }}#demande" class="btn btn-primary">
                                                        <i class="fas fa-plus me-1"></i>Créer une nouvelle demande
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($demandes->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $demandes->links() }}
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
.admin-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    padding: 1.5rem;
}

.admin-sidebar {
    min-height: 80vh;
    position: sticky;
    top: 20px;
}

.admin-sidebar .nav-link {
    color: #495057;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.admin-sidebar .nav-link:hover,
.admin-sidebar .nav-link.active {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table th a {
    color: inherit;
    text-decoration: none;
}

.table th a:hover {
    color: #28a745;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

@media (max-width: 768px) {
    .admin-sidebar {
        display: none;
    }
    
    .admin-sidebar.show {
        display: block;
    }
}
</style>

<script>
// Toggle sidebar
document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.querySelector('.admin-sidebar').classList.toggle('show');
});

// Fonctions JavaScript
function voirDemande(id) {
    window.location.href = `/admin/demandes/${id}`;
}

function exportDemandes() {
    const params = new URLSearchParams(window.location.search);
    window.location.href = `/admin/demandes/export?${params.toString()}`;
}
</script>
@endsection
