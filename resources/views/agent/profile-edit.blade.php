@extends('layouts.app')

@section('title', 'Modifier Profil')

@section('content')
<div class="animated-background">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card glass-effect shadow-xl border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4 border-0">
                        <div class="d-flex align-items-center">
                            <div class="avatar-container me-3">
                                <div class="avatar-circle bg-white text-primary d-flex align-items-center justify-content-center rounded-circle pulse-animation" style="width: 60px; height: 60px; font-size: 24px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::guard('agent')->user()->nom, 0, 1) . substr(Auth::guard('agent')->user()->prenom, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <h3 class="mb-1 fw-bold">Modifier mon Profil</h3>
                                <p class="mb-0 opacity-75">Mettez à jour vos informations personnelles</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <form action="{{ route('agent.profile.update') }}" method="POST" class="enhanced-form">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 enhanced-input-group">
                                        <div class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <input type="text" class="form-control enhanced-input border-0" id="nom" name="nom" 
                                               value="{{ Auth::guard('agent')->user()->nom }}" required placeholder="Votre nom">
                                        <label for="nom" class="enhanced-label">Nom</label>
                                        <div class="input-border"></div>
                                        @error('nom')
                                            <div class="text-danger small mt-1 error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3 enhanced-input-group">
                                        <div class="input-icon">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <input type="text" class="form-control enhanced-input border-0" id="prenom" name="prenom" 
                                               value="{{ Auth::guard('agent')->user()->prenom }}" required placeholder="Votre prénom">
                                        <label for="prenom" class="enhanced-label">Prénom</label>
                                        <div class="input-border"></div>
                                        @error('prenom')
                                            <div class="text-danger small mt-1 error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 enhanced-input-group">
                                        <div class="input-icon">
                                            <i class="fas fa-venus-mars"></i>
                                        </div>
                                        <select class="form-select enhanced-input border-0" id="sexe" name="sexe" required>
                                            <option value="">Sélectionner</option>
                                            <option value="M" {{ Auth::guard('agent')->user()->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                            <option value="F" {{ Auth::guard('agent')->user()->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                                        </select>
                                        <label for="sexe" class="enhanced-label">Sexe</label>
                                        <div class="input-border"></div>
                                        @error('sexe')
                                            <div class="text-danger small mt-1 error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3 enhanced-input-group">
                                        <div class="input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <input type="email" class="form-control enhanced-input border-0" id="email" name="email" 
                                               value="{{ Auth::guard('agent')->user()->email }}" required placeholder="votre.email@exemple.com">
                                        <label for="email" class="enhanced-label">Email</label>
                                        <div class="input-border"></div>
                                        @error('email')
                                            <div class="text-danger small mt-1 error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5 pt-4 border-top border-light">
                                <a href="{{ route('agent.profile') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4 enhanced-btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg rounded-3 px-4 enhanced-btn-primary">
                                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </form>
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

/* Champs de formulaire améliorés */
.enhanced-input-group {
    position: relative;
    margin-bottom: 2rem;
}

.input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #667eea;
    z-index: 10;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.enhanced-input {
    background: rgba(255, 255, 255, 0.8);
    border: 2px solid transparent;
    border-radius: 15px;
    padding: 1rem 1rem 1rem 3.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
    height: auto;
}

.enhanced-input:focus {
    background: rgba(255, 255, 255, 0.95);
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    outline: none;
}

.enhanced-input:focus + .enhanced-label {
    color: #667eea;
    transform: translateY(-2.5rem) scale(0.85);
}

.enhanced-label {
    position: absolute;
    left: 3.5rem;
    top: 1rem;
    color: #6c757d;
    transition: all 0.3s ease;
    pointer-events: none;
    background: transparent;
    padding: 0 0.5rem;
}

.enhanced-input:not(:placeholder-shown) + .enhanced-label {
    transform: translateY(-2.5rem) scale(0.85);
    color: #667eea;
}

.input-border {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.enhanced-input:focus ~ .input-border {
    transform: scaleX(1);
}

/* Boutons améliorés */
.enhanced-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.enhanced-btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.enhanced-btn-primary:hover::before {
    left: 100%;
}

.enhanced-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.enhanced-btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 600;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.enhanced-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
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
    .enhanced-input {
        padding: 1rem 1rem 1rem 3rem;
    }
    
    .enhanced-label {
        left: 3rem;
    }
    
    .input-icon {
        left: 12px;
    }
}
</style>
@endsection
