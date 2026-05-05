@extends('layouts.app')

@section('title', 'Suivi de Demande - PEBCO BETHESDA')

@section('content')
<div class="animated-background">
    <div class="container">
        <div class="row justify-content-center min-vh-100">
            <div class="col-lg-6">
                <div class="glass-effect shadow-xl border-0 rounded-4 overflow-hidden">
                    <!-- Header -->
                    <div class="text-center p-4 bg-gradient-primary text-white">
                        <div class="logo-suivi mb-3">
                            <div class="avatar-circle bg-white text-primary d-flex align-items-center justify-content-center rounded-circle pulse-animation mx-auto" style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-2">
                            Suivre ma Demande
                        </h3>
                        <p class="mb-0 opacity-75">
                            Consultez l'état de votre demande de crédit en temps réel
                        </p>
                    </div>

                    <div class="p-5">
                        <!-- Messages Flash -->
                        @if(session('error'))
                            <div class="alert alert-danger glass-alert border-0 mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulaire de Suivi SIMPLE -->
                        <form method="POST" action="{{ route('suivi.rechercher') }}" id="suiviForm">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="code_dossier" class="form-label fw-bold">
                                    <i class="fas fa-hashtag me-2"></i>Code Dossier
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="code_dossier" 
                                       name="code_dossier" 
                                       value="{{ old('code_dossier') }}" 
                                       placeholder="Ex: DM202633B472"
                                       required 
                                       autofocus>
                                @error('code_dossier')
                                    <div class="text-danger small mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" 
                                        style="width: 100%; padding: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; display: block;"
                                        onclick="console.log('CLICK DIRECT'); this.form.submit();">
                                    <i class="fas fa-search me-2"></i>
                                    Rechercher ma demande
                                </button>
                            </div>
                        </form>

                        <!-- Lien de retour -->
                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="text-decoration-none glass-text">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Background animé */
.animated-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
    z-index: -1;
}

.animated-background::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: moveGrid 20s linear infinite;
}

.animated-background::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    animation: floatAnimation 15s ease-in-out infinite;
}

@keyframes moveGrid {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

@keyframes floatAnimation {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-20px) rotate(120deg); }
    66% { transform: translateY(20px) rotate(240deg); }
}

/* Effet verre */
.glass-effect {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 
        0 8px 32px rgba(31, 38, 135, 0.37),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
}

/* Animation pulse pour l'avatar */
.pulse-animation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Alerts avec effet verre */
.glass-alert {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.glass-text {
    background: rgba(255, 255, 255, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 10px;
    backdrop-filter: blur(5px);
    color: white;
}

/* Messages d'erreur */
.error-message {
    background: rgba(220, 53, 69, 0.1);
    border-left: 3px solid #dc3545;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Container principal */
.container {
    position: relative;
    z-index: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .glass-effect {
        margin: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== DÉBUT DU FORMULAIRE DE SUIVI ===');
    
    // Auto-focus sur le champ code dossier
    const codeInput = document.getElementById('code_dossier');
    const form = document.getElementById('suiviForm');
    
    console.log('Éléments trouvés:', {
        codeInput: !!codeInput,
        form: !!form
    });
    
    if (codeInput) {
        codeInput.focus();
        console.log('✅ Focus appliqué sur le champ code dossier');
    }
    
    // Formatage automatique du code dossier
    if (codeInput) {
        codeInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            value = value.replace(/\s/g, '');
            e.target.value = value;
            console.log('📝 Code modifié:', value);
        });
    }
    
    console.log('=== FIN D\'INITIALISATION ===');
});
</script>
@endsection
