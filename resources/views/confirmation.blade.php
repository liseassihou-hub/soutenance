@extends('layouts.app')

@section('title', 'Confirmation de Demande')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="text-center">
                        <i class="fas fa-check-circle me-2"></i>Demande Soumise avec Succès!
                    </h3>
                </div>
                <div class="card-body text-center p-5">
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Debug information -->
                    @if(session()->has('success') || session()->has('error'))
                        <div class="alert alert-light mb-4">
                            <small class="text-muted">
                                <strong>Debug:</strong> Session ID: {{ session()->getId() }}<br>
                                @if(session('code_suivi'))
                                    Code suivi en session: {{ session('code_suivi') }}
                                @elseif(session('code_dossier'))
                                    Code dossier en session: {{ session('code_dossier') }}
                                @else
                                    Aucun code en session
                                @endif
                            </small>
                        </div>
                    @endif
                    
                    @if(session('code_suivi'))
                        <div class="alert alert-info mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-folder-open me-2"></i>Votre Code de Suivi
                            </h4>
                            <div class="d-inline-block">
                                <div class="input-group">
                                    <input type="text" 
                                           value="{{ session('code_suivi') }}" 
                                           readonly 
                                           class="form-control form-control-lg text-center fw-bold"
                                           style="font-family: 'Courier New', monospace; font-size: 1.5rem; letter-spacing: 2px; background-color: #f8f9fa;">
                                    <button class="btn btn-outline-secondary" onclick="copyCode()" title="Copier le code">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Conservez ce code précieusement pour suivre votre demande
                            </small>
                        </div>
                        
                        <div class="alert alert-warning mb-4">
                            <h5 class="mb-3">
                                <i class="fas fa-lightbulb me-2"></i>Prochaines Étapes
                            </h5>
                            <div class="row text-start">
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    <strong>Vérification Email:</strong> Vous recevrez un email de confirmation
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-user-check me-2 text-info"></i>
                                    <strong>Examen:</strong> Votre demande sera étudiée par nos équipes
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-phone me-2 text-success"></i>
                                    <strong>Contact:</strong> Nous vous contacterons pour la suite
                                </div>
                            </div>
                        </div>
                    @elseif(session('code_dossier'))
                        <div class="alert alert-info mb-4">
                            <h4 class="mb-3">
                                <i class="fas fa-folder-open me-2"></i>Votre Code de Dossier
                            </h4>
                            <div class="d-inline-block">
                                <div class="input-group">
                                    <input type="text" 
                                           value="{{ session('code_dossier') }}" 
                                           readonly 
                                           class="form-control form-control-lg text-center fw-bold"
                                           style="font-family: 'Courier New', monospace; font-size: 1.5rem; letter-spacing: 2px; background-color: #f8f9fa;">
                                    <button class="btn btn-outline-secondary" onclick="copyCode()" title="Copier le code">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Conservez ce code précieusement pour suivre votre demande
                            </small>
                        </div>
                    @endif
                    
                    <div class="mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('home') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-home me-2"></i>Retour à l'Accueil
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('demande.create') }}" class="btn btn-outline-success btn-lg w-100">
                                    <i class="fas fa-plus me-2"></i>Nouvelle Demande
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('suivi.form') }}" class="btn btn-outline-info btn-lg w-100">
                                    <i class="fas fa-search me-2"></i>Suivre ma Demande
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyCode() {
    const codeInput = document.querySelector('input[readonly]');
    codeInput.select();
    codeInput.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        
        // Afficher une notification temporaire
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i> Copié!';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    } catch (err) {
        console.error('Erreur lors de la copie:', err);
    }
}
</script>
@endsection
