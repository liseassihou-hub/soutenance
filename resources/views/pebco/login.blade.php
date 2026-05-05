@extends('layouts.app')

@section('title', 'Connexion - PEBCO BETHESDA')

@section('content')
<div class="animated-background">
    <div class="container">
        <div class="row justify-content-center min-vh-100">
            <div class="col-lg-5 col-md-7">
                <div class="glass-effect shadow-xl border-0 rounded-4 overflow-hidden">
                    <!-- Logo et Titre -->
                    <div class="text-center p-4 bg-gradient-primary text-white">
                        <div class="logo-login mb-3">
                            <div class="avatar-circle bg-white text-primary d-flex align-items-center justify-content-center rounded-circle pulse-animation mx-auto" style="width: 80px; height: 80px; font-size: 32px; font-weight: bold;">
                                <i class="fas fa-university"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-2">
                            Espace de Connexion
                        </h3>
                        <p class="mb-0 opacity-75">
                            PEBCO BETHESDA - Système de Finance Décentralisée
                        </p>
                    </div>

                    <div class="p-5">
                        <!-- Messages Flash -->
                        @if(session('success'))
                            <div class="alert alert-success glass-alert border-0 mb-4">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger glass-alert border-0 mb-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulaire de Connexion -->
                        <form method="POST" action="{{ route('pebco.login.submit') }}" id="loginForm" class="enhanced-form">
                            @csrf
                            
                            <div class="mb-4 enhanced-input-group">
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" 
                                       class="form-control enhanced-input border-0" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="admin@pebco.com ou agent@pebco.com"
                                       required 
                                       autocomplete="email">
                                <label for="email" class="enhanced-label">Adresse Email</label>
                                <div class="input-border"></div>
                                @if($errors->has('email'))
                                    <div class="text-danger small mt-1 error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-floating mb-4 position-relative">
                                <div class="input-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" 
                                       class="form-control enhanced-input border-0 pe-4" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Entrez votre mot de passe"
                                       required 
                                       autocomplete="current-password">
                                <label for="password" class="enhanced-label">Mot de passe</label>
                                <button type="button" onclick="togglePassword('password')" class="position-absolute end-0 top-50 translate-middle-y border-0 bg-transparent pe-3" style="z-index: 10;">
                                    <i id="password-icon" class="fas fa-eye-slash text-muted"></i>
                                </button>
                                <div class="input-border"></div>
                                @if($errors->has('password'))
                                    <div class="text-danger small mt-1 error-message">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg enhanced-btn-primary" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Se connecter
                                </button>
                            </div>

                            <!-- Informations de connexion -->
                            <div class="login-info glass-alert mt-4">
                                <h6 class="alert-heading">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informations de Connexion
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Admin :</strong>
                                        <br>
                                        <small>Email: admin@pebco.com</small>
                                        <br>
                                        <small>Mot de passe: admin123</small>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Agent :</strong>
                                        <br>
                                        <small>Email: agent@pebco.com</small>
                                        <br>
                                        <small>Mot de passe: agent123</small>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Lien de retour -->
                        <div class="text-center mt-4">
                            <a href="{{ route('pebco.home') }}" class="text-decoration-none glass-text">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Illustration -->
            <div class="col-lg-7 d-none d-lg-block">
                <div class="login-illustration">
                    <div class="illustration-content">
                        <div class="floating-icons">
                            <div class="float-icon">
                                <i class="fas fa-shield-alt fa-3x text-white"></i>
                            </div>
                            <div class="float-icon">
                                <i class="fas fa-user-tie fa-2x text-white"></i>
                            </div>
                            <div class="float-icon">
                                <i class="fas fa-lock fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="illustration-text">
                            <h3 class="fw-bold mb-3 text-white">
                                Connexion Sécurisée
                            </h3>
                            <p class="text-white-50 mb-4">
                                Accès différencié selon le rôle :<br>
                                <span class="badge bg-danger">Admin</span> → Gestion et supervision<br>
                                <span class="badge bg-success">Agent</span> → Traitement des demandes
                            </p>
                            <div class="security-features">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-white me-2"></i>
                                    Authentification à deux facteurs
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-white me-2"></i>
                                    Chiffrement des données
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-white me-2"></i>
                                    Journalisation des activités
                                </div>
                            </div>
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

/* Illustration */
.login-illustration {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.illustration-content {
    text-align: center;
    color: white;
}

.floating-icons {
    position: relative;
    width: 200px;
    height: 200px;
    margin: 0 auto 2rem;
}

.float-icon {
    position: absolute;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: float 6s ease-in-out infinite;
}

.float-icon:nth-child(1) {
    top: 0;
    left: 70px;
    animation-delay: 0s;
}

.float-icon:nth-child(2) {
    top: 70px;
    right: 70px;
    animation-delay: 2s;
}

.float-icon:nth-child(3) {
    bottom: 0;
    left: 70px;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

.security-features .feature-item {
    text-align: left;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
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
    
    .login-illustration {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le champ email
    document.getElementById('email').focus();
    
    // Animation du bouton de connexion
    document.getElementById('loginBtn').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connexion en cours...';
        this.disabled = true;
    });
});

// Fonction pour afficher/masquer le mot de passe
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
</script>
@endsection
