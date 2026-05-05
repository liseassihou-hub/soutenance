@extends('layouts.app')

@section('title', 'Suivi de Demande - PEBCO BETHESDA')

@section('content')
<div class="result-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="result-container">
                    <!-- Header -->
                    <div class="text-center mb-3">
                        <div class="logo-result mb-2">
                            <i class="fas fa-file-alt fa-3x text-primary"></i>
                        </div>
                        <h2 class="fw-bold text-dark mb-2">
                            @if($demande->statut === 'en_attente')
                                Demande Soumise
                            @elseif($demande->statut === 'en_cours')
                                Demande en Cours
                            @elseif($demande->statut === 'refuse')
                                Demande Refusée
                            @elseif($demande->statut === 'accepte')
                                Demande Acceptée
                            @elseif($demande->statut === 'approuve')
                                Demande Approuvée
                            @elseif($demande->statut === 'en_analyse')
                                Demande en Analyse
                            @else
                                Suivi de votre Demande
                            @endif
                        </h2>
                    </div>

                    <!-- Carte de Résultat -->
                    <div class="result-card">
                        <div class="card border-0 shadow-lg">
                            <div class="card-header bg-gradient">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informations de la Demande
                                </h6>
                                </div>
                            <div class="card-body">
                                <!-- Informations Client -->
                                <div class="client-info mb-4">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fas fa-user me-2"></i>
                                        Informations Client
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Nom complet :</strong>
                                            <br>
                                            {{ $demande->nom_complet }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Email :</strong>
                                            <br>
                                            {{ $demande->email }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Téléphone :</strong>
                                            <br>
                                            {{ $demande->telephone }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Adresse :</strong>
                                            <br>
                                            {{ $demande->adresse }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations Demande -->
                                <div class="demande-info mb-4">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Détails de la Demande
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Montant demandé :</strong>
                                            <br>
                                            <span class="text-primary fw-bold">{{ $demande->montant_formatted }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Type de crédit :</strong>
                                            <br>
                                            {{ $demande->type_credit_formatted }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Durée :</strong>
                                            <br>
                                            {{ $demande->duree }} mois
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <strong>Description du projet :</strong>
                                            <br>
                                            <p class="text-muted">{{ $demande->description_projet }}</p>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="actions text-center mt-4">
                        <a href="{{ route('suivi.form') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Nouvelle Recherche
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>
                            Accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.result-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    padding: 1rem 0;
}

.result-container {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.logo-result i {
    opacity: 1;
    transition: all 0.3s ease;
    display: block !important;
    visibility: visible !important;
}

.logo-result:hover i {
    opacity: 1;
    transform: scale(1.1);
}

.result-card .card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.client-info, .demande-info, .statut-info {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -2rem;
    top: 0;
    width: 2px;
    height: 100%;
    background: #dee2e6;
}

.timeline-marker {
    position: absolute;
    left: -2.5rem;
    top: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    z-index: 2;
}

.timeline-marker.completed {
    background: #28a745;
}

.timeline-marker.pending {
    background: #ffc107;
    animation: pulse 2s infinite;
}

.timeline-marker.rejected {
    background: #dc3545;
}

.timeline-content {
    margin-left: 3rem;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

@media (max-width: 768px) {
    .result-section {
        padding: 1rem 0;
    }
    
    .result-container {
        padding: 1.5rem;
        margin: 1rem;
    }
    
    .timeline {
        padding-left: 1.5rem;
    }
    
    .timeline-marker {
        left: -1.5rem;
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .timeline-content {
        margin-left: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'apparition des éléments de la timeline
    const timelineItems = document.querySelectorAll('.timeline-item');
    timelineItems.forEach((item, index) => {
        setTimeout(() => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100);
        }, index * 200);
    });
});
</script>
@endsection
