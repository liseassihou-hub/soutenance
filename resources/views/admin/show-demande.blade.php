@extends('layouts.app')

@section('title', 'Détails Demande - PEBCO')

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
                            <i class="fas fa-file-invoice-dollar me-2"></i>Détails de la Demande
                        </h4>
                        <small class="text-muted">Dossier: {{ $demande->code_dossier }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Boutons retour -->
                    <a href="{{ route('admin.demandes') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-1"></i>Liste des demandes
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                    
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
            <!-- Actions Rapides -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="mb-0">Actions Rapides</h6>
                                </div>
                                <div class="col-auto">
                                    <div class="btn-group">
                                        <button class="btn btn-outline-warning" onclick="modifierDemande({{ $demande->id }})">
                                            <i class="fas fa-edit me-1"></i>Modifier
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-cog me-1"></i>Changer Statut
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="changerStatut({{ $demande->id }}, 'valide')">
                                                    <i class="fas fa-check text-success me-2"></i>Approuver
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changerStatut({{ $demande->id }}, 'refuse')">
                                                    <i class="fas fa-times text-danger me-2"></i>Refuser
                                                </a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changerStatut({{ $demande->id }}, 'en_analyse')">
                                                    <i class="fas fa-search text-info me-2"></i>En analyse
                                                </a></li>
                                            </ul>
                                        </div>
                                        <button class="btn btn-outline-primary" onclick="imprimerDemande({{ $demande->id }})">
                                            <i class="fas fa-print me-1"></i>Imprimer
                                        </button>
                                        <button class="btn btn-outline-success" onclick="exporterDemande({{ $demande->id }})">
                                            <i class="fas fa-download me-1"></i>Exporter PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations de la Demande -->
            <div class="row mb-4">
                <!-- Informations Principales -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations de la Demande</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Code Dossier:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-primary">{{ $demande->code_dossier }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Type Crédit:</strong></div>
                                <div class="col-sm-8">{{ $typesCredit[(int)$demande->credit_type_id] ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Objet du Crédit:</strong></div>
                                <div class="col-sm-8">
                                    {{-- DEBUG: {{ var_dump($demande->objet_pret) } --}}
                                    {{ $demande->objet_pret ?? 'Non spécifié' }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Montant Demandé:</strong></div>
                                <div class="col-sm-8">
                                    <strong class="text-success">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Durée (mois):</strong></div>
                                <div class="col-sm-8">{{ $demande->duree ?? 'Non spécifié' }} mois</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Taux d'intérêt:</strong></div>
                                <div class="col-sm-8">{{ $demande->taux_interet ?? 'Non spécifié' }}%</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Statut:</strong></div>
                                <div class="col-sm-8">
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
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Date de soumission:</strong></div>
                                <div class="col-sm-8">{{ $demande->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Dernière mise à jour:</strong></div>
                                <div class="col-sm-8">{{ $demande->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations Client -->
                <div class="col-md-6 mb-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>Informations du Client</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Nom complet:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->nom ?? 'Non spécifié' }} {{ $demande->client->prenom ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->email ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Téléphone:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->telephone ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Date de naissance:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->date_naissance ? \Carbon\Carbon::parse($demande->client->date_naissance)->format('d/m/Y') : 'Non spécifiée' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Lieu de naissance:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->lieu_naissance ?? 'Non spécifié' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Adresse:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->adresse_personnelle ?? 'Non spécifiée' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Profession:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->activite_principale ?? 'Non spécifiée' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Revenu mensuel:</strong></div>
                                <div class="col-sm-8">{{ $demande->client->revenu_mensuel ? number_format($demande->client->revenu_mensuel, 0, ',', ' ') . ' FCFA' : 'Non spécifié' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents et Pièces Jointes -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="fas fa-paperclip me-2"></i>Documents et Pièces Jointes</h6>
                        </div>
                        <div class="card-body">
                            @if(isset($demande->documents) && $demande->documents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Type de document</th>
                                                <th>Nom du fichier</th>
                                                <th>Date d'upload</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($demande->documents as $document)
                                            <tr>
                                                <td>{{ $document->type_document ?? 'Non spécifié' }}</td>
                                                <td>{{ $document->nom_fichier }}</td>
                                                <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" onclick="voirDocument({{ $document->id }})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-success" onclick="telechargerDocument({{ $document->id }})">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-folder-open fa-3x mb-3"></i>
                                    <h5>Aucun document</h5>
                                    <p>Aucun document n'a été joint à cette demande.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique et Commentaires -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="fas fa-history me-2"></i>Historique et Commentaires</h6>
                        </div>
                        <div class="card-body">
                            <!-- Ajouter un commentaire -->
                            <div class="mb-4">
                                <h6>Ajouter un commentaire</h6>
                                <form id="commentForm" onsubmit="ajouterCommentaire(event)">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="commentaire" name="commentaire" rows="3" 
                                                      placeholder="Ajoutez votre commentaire ici..." required></textarea>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary h-100">
                                                <i class="fas fa-paper-plane me-1"></i>Ajouter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Historique des commentaires -->
                            <div id="historiqueCommentaires">
                                @if(isset($demande->commentaires) && $demande->commentaires->count() > 0)
                                    @foreach($demande->commentaires as $commentaire)
                                    <div class="border-start border-3 border-info ps-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $commentaire->auteur ?? 'Admin' }}</strong>
                                                <small class="text-muted ms-2">{{ $commentaire->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                            <span class="badge bg-info">{{ $commentaire->type ?? 'Commentaire' }}</span>
                                        </div>
                                        <p class="mb-0 mt-2">{{ $commentaire->contenu }}</p>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-3">
                                        <p>Aucun commentaire pour le moment.</p>
                                    </div>
                                @endif
                            </div>
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
function modifierDemande(id) {
    window.location.href = `/admin/demandes/${id}/edit`;
}

function changerStatut(id, statut) {
    if(confirm(`Voulez-vous changer le statut de cette demande vers "${statut}"?`)) {
        fetch(`/admin/demandes/${id}/statut`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ statut: statut })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erreur: ' + error.message);
        });
    }
}

function imprimerDemande(id) {
    window.open(`/admin/demandes/${id}/print`, '_blank');
}

function exporterDemande(id) {
    window.location.href = `/admin/demandes/${id}/export`;
}

function voirDocument(id) {
    window.open(`/admin/document/${id}/view`, '_blank');
}

function telechargerDocument(id) {
    window.location.href = `/admin/document/${id}/download`;
}

function ajouterCommentaire(event) {
    event.preventDefault();
    
    const form = document.getElementById('commentForm');
    const formData = new FormData(form);
    
    fetch(`/admin/demandes/{{ $demande->id }}/commentaire`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erreur: ' + error.message);
    });
}
</script>
@endsection
