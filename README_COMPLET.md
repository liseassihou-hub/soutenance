# 📚 Documentation Complète du Site PEBCO

## 🏗️ Structure Générale du Projet

### 📁 Arborescence des Fichiers Principaux
```
d:\ELISE\monprojet\
├── resources\
│   ├── views\
│   │   ├── layouts\
│   │   │   └── app.blade.php          # Layout principal du site
│   │   ├── partials\
│   │   │   ├── header.blade.php        # Navigation/header
│   │   │   ├── footer.blade.php        # Footer
│   │   │   └── timeline.blade.php      # Section timeline PEBCO
│   │   ├── home.blade.php             # Page d'accueil
│   │   ├── nos-credits.blade.php      # Page unifiée des crédits
│   │   ├── dashboard.blade.php         # Tableau de bord utilisateur
│   │   └── auth\
│   │       ├── login.blade.php         # Page de connexion
│   │       └── register.blade.php      # Page d'inscription
│   └── public\
│       └── images\
│           └── slider\                # Images des crédits
├── routes\
│   └── web.php                       # Routes Laravel
└── app\
    └── Http\Controllers\
        ├── HomeController.php
        ├── AuthController.php
        └── CreditController.php
```

---

## 🌐 Pages du Site

### 1. 🏠 Page d'Accueil (`home.blade.php`)

#### 📋 Structure HTML
```blade
@extends('layouts.app')  // Hérite du layout principal

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <h1>PEBCO</h1>
            <p>Votre partenaire de confiance...</p>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2>À Propos de PEBCO</h2>
                <p style="text-align: justify;">...</p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="services-section">
    <div class="container">
        <div class="row">
            <!-- 6 cartes de services -->
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h4>Microcrédit</h4>
                    <p>...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Credits Section -->
<section id="credits" class="credits-section">
    <div class="container">
        <!-- Carrousel Swiper -->
        <div class="credits-carousel swiper">
            <div class="swiper-wrapper">
                <!-- 6 slides de crédits pointant vers /nos-credits -->
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <!-- 4 statistiques avec compteurs animés -->
        </div>
    </div>
</section>

<!-- Timeline Section -->
@include('partials.timeline')

@endsection
```

#### 🎨 Classes CSS Principales
```css
/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
    height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.3);
}

.hero-content {
    position: relative;
    z-index: 2;
}

/* About Section */
.about-section {
    background: var(--bg-light);
    position: relative;
}

.about-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--border-color), transparent);
}

/* Service Cards */
.service-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-10px);
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-size: 2rem;
}

/* Credits Carousel */
.credit-card {
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.credit-card:hover {
    transform: translateY(-8px);
}

.card-img-wrapper {
    position: relative;
    overflow: hidden;
}

.card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(30,94,30,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.credit-card:hover .card-overlay {
    opacity: 1;
}
```

---

### 2. 💳 Page des Crédits (`nos-credits.blade.php`)

#### 📋 Structure HTML
```blade
@extends('layouts.app')

@section('content')
<style>
/* Styles spécifiques pour cette page */
body {
    background-image: linear-gradient(rgba(255,255,255,0.95), rgba(255,255,255,0.95)), 
                      url('{{ asset('images/slider/slider1.png') }}');
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="container">
            <h1>Nos Solutions de Crédit</h1>
            <p>Découvrez nos offres de financement...</p>
            <!-- Fil d'Ariane -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="active">Nos Crédits</li>
                </ol>
            </nav>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Toutes Nos Offres de Crédit</h2>
        </div>

        <div class="row">
            <!-- 6 cartes de crédits détaillées -->
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('images/slider/credit individuel.png') }}" alt="Crédit Individuel">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-user"></i>Crédit Individuel
                        </h5>
                        <p>Financement personnel...</p>
                        
                        <!-- Conditions d'éligibilité -->
                        <div class="mb-3">
                            <h6>Conditions d'éligibilité :</h6>
                            <ul>
                                <li>Être majeur (18 ans et plus)</li>
                                <li>Activité stable ou revenus réguliers</li>
                                <li>Bonne capacité de remboursement</li>
                            </ul>
                        </div>
                        
                        <!-- Caractéristiques -->
                        <div class="mb-3">
                            <h6>Caractéristiques :</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Montant :</strong><br>50K - 5M FCFA
                                </div>
                                <div class="col-6">
                                    <strong>Durée :</strong><br>Jusqu'à 36 mois
                                </div>
                                <div class="col-6">
                                    <strong>Taux :</strong><br>À partir de 8%/an
                                </div>
                                <div class="col-6">
                                    <strong>Délai :</strong><br>48-72h
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bouton de demande -->
                        <a href="{{ route('login') }}" class="btn btn-primary-custom w-100">
                            <i class="fas fa-paper-plane"></i>Faire une demande
                        </a>
                    </div>
                </div>
            </div>
            <!-- ... 5 autres cartes similaires ... -->
        </div>
    </div>
</section>
@endsection
```

---

### 3. 📅 Section Timeline (`partials/timeline.blade.php`)

#### 📋 Structure HTML
```blade
<!-- Timeline Section -->
<section id="timeline" class="timeline-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Évolution et Activités de PEBCO</h2>
        </div>

        <div class="timeline">
            <!-- Éléments chronologiques -->
            <div class="timeline-item">
                <div class="timeline-dot">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="timeline-content">
                    <div class="timeline-year">1994</div>
                    <h4>Fondation de PEBCO</h4>
                    <p>Création de PEBCO avec pour mission...</p>
                    <div class="timeline-stats">
                        <div class="stat-badge">
                            <i class="fas fa-users"></i>
                            <span>50 premiers clients</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ... autres éléments timeline ... -->
        </div>

        <!-- Section Résumé -->
        <div class="text-center mt-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="summary-card">
                        <div class="summary-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="summary-number">30+</div>
                        <div class="summary-label">Ans d'expérience</div>
                    </div>
                </div>
                <!-- ... 3 autres cartes résumé ... -->
            </div>
        </div>
    </div>
</section>
```

#### 🎨 CSS Timeline
```css
.timeline-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    position: relative;
}

.timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

/* Ligne centrale */
.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--primary-green), var(--accent-green));
    transform: translateX(-50%);
}

.timeline-item {
    position: relative;
    margin-bottom: 60px;
    display: flex;
    align-items: center;
}

/* Alternance gauche/droite */
.timeline-item:nth-child(odd) {
    flex-direction: row;
}

.timeline-item:nth-child(even) {
    flex-direction: row-reverse;
}

.timeline-dot {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 20px rgba(30, 94, 30, 0.3);
}

.timeline-content {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    width: calc(50% - 40px);
    transition: transform 0.3s ease;
}

.timeline-content:hover {
    transform: translateY(-5px);
}

.timeline-year {
    background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
    color: white;
    padding: 8px 16px;
    border-radius: 25px;
    display: inline-block;
    font-weight: 600;
}

.stat-badge {
    background: rgba(30, 94, 30, 0.1);
    color: var(--primary-green);
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 6px;
}
```

---

### 4. 🧭 Header (`partials/header.blade.php`)

#### 📋 Structure HTML
```blade
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-university"></i>
            <span>PEBCO</span>
        </a>
        
        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu de navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link smooth-scroll" href="{{ route('home') }}#about">
                        <i class="fas fa-info-circle"></i>About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link smooth-scroll" href="{{ route('home') }}#services">
                        <i class="fas fa-concierge-bell"></i>Services
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('nos-credits') }}">
                        <i class="fas fa-hand-holding-usd"></i>Credits
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn-get-started nav-link">
                        <i class="fas fa-sign-in-alt"></i>Get Started
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
```

#### 🎨 CSS Header
```css
.navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary-green) !important;
}

.navbar-brand i {
    margin-right: 10px;
    font-size: 1.8rem;
}

.nav-link {
    color: var(--text-dark) !important;
    font-weight: 500;
    padding: 10px 15px !important;
    border-radius: 25px;
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: rgba(30, 94, 30, 0.1);
    color: var(--primary-green) !important;
}

.btn-get-started {
    background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
    color: white !important;
    border-radius: 25px;
    padding: 10px 25px !important;
}

.btn-get-started:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(30, 94, 30, 0.3);
}
```

---

### 5. 🎨 Layout Principal (`layouts/app.blade.php`)

#### 📋 Structure HTML
```blade
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PEBCO - Microfinance')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Variables CSS */
        :root {
            --primary-green: #1e5e1e;
            --accent-green: #4caf50;
            --light-green: #66bb6a;
            --bg-light: #f8f9fa;
            --bg-secondary: #ffffff;
            --text-primary: #2c3e50;
            --text-secondary: #6c757d;
            --text-muted: #adb5bd;
            --border-color: #e9ecef;
        }
        
        /* Styles globaux */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
        }
        
        /* Boutons personnalisés */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 94, 30, 0.3);
        }
        
        /* Sections */
        .section-padding {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 20px;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    @include('partials.header')
    
    <!-- Contenu principal -->
    @yield('content')
    
    <!-- Footer -->
    @include('partials.footer')
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
        // Initialisation AOS
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Smooth scroll pour la navigation
        document.querySelectorAll('.smooth-scroll').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    const targetPosition = target.offsetTop - navbarHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
```

---

## 🛣️ Routes (`routes/web.php`)

```php
<?php

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Page unifiée des crédits
Route::get('/nos-credits', function () {
    return view('nos-credits');
})->name('nos-credits');

// Authentification
Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/dashboard', function() {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function() {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
```

---

## 🎯 Fonctionnalités Clés

### 1. 🔄 Navigation Smooth Scroll
```javascript
// Script dans layouts/app.blade.php
document.querySelectorAll('.smooth-scroll').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const targetPosition = target.offsetTop - navbarHeight - 20;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});
```

### 2. 📊 Animations AOS
```javascript
// Initialisation avec délais personnalisés
AOS.init({
    duration: 1000,
    once: true
});
```

### 3. 🎠 Carrousel Swiper
```javascript
// Configuration du carrousel de crédits
const creditsSwiper = new Swiper('.credits-carousel', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 3,
        },
        1024: {
            slidesPerView: 4,
        },
    }
});
```

---

## 📱 Responsive Design

### 🖥️ Desktop (>1024px)
- Timeline : alternance gauche/droite
- Crédits : 4 colonnes
- Services : 3 colonnes

### 📱 Tablette (768px-1024px)
- Timeline : alignement à gauche
- Crédits : 2-3 colonnes
- Services : 2-3 colonnes

### 📱 Mobile (<768px)
- Timeline : alignement à gauche avec décalage
- Crédits : 1 colonne
- Services : 1-2 colonnes
- Navigation : menu hamburger

---

## 🎨 Thème et Couleurs

### 🎨 Variables CSS Principales
```css
:root {
    --primary-green: #1e5e1e;    /* Vert principal */
    --accent-green: #4caf50;      /* Vert accent */
    --light-green: #66bb6a;       /* Vert clair */
    --bg-light: #f8f9fa;          /* Fond clair */
    --bg-secondary: #ffffff;      /* Fond blanc */
    --text-primary: #2c3e50;     /* Texte principal */
    --text-secondary: #6c757d;   /* Texte secondaire */
    --text-muted: #adb5bd;        /* Texte muted */
    --border-color: #e9ecef;      /* Bordures */
}
```

### 🎨 Gradients Utilisés
```css
/* Boutons et éléments principaux */
background: linear-gradient(135deg, var(--primary-green), var(--accent-green));

/* Hero sections */
background: linear-gradient(135deg, var(--primary-green), var(--accent-green));

/* Overlays */
background: rgba(30, 94, 30, 0.8);
```

---

## 🔧 Composants Réutilisables

### 1. 📋 Service Card
```html
<div class="service-card">
    <div class="service-icon">
        <i class="fas fa-icon-name"></i>
    </div>
    <h4>Titre du service</h4>
    <p>Description du service...</p>
</div>
```

### 2. 💳 Credit Card
```html
<div class="credit-card">
    <div class="card-img-wrapper">
        <img src="image.jpg" alt="Nom du crédit">
        <div class="card-overlay">
            <i class="bi bi-icon"></i>
        </div>
    </div>
    <div class="card-body">
        <h5>Titre du crédit</h5>
        <p>Description...</p>
    </div>
</div>
```

### 3. 📅 Timeline Item
```html
<div class="timeline-item">
    <div class="timeline-dot">
        <i class="fas fa-icon"></i>
    </div>
    <div class="timeline-content">
        <div class="timeline-year">Année</div>
        <h4>Titre</h4>
        <p>Description...</p>
        <div class="timeline-stats">
            <div class="stat-badge">
                <i class="fas fa-icon"></i>
                <span>Statistique</span>
            </div>
        </div>
    </div>
</div>
```

---

## 🚀 Fonctionnalités Implémentées

### ✅ Page d'accueil complète
- Hero section avec overlay
- Section About avec texte justifié
- Section Services (6 cartes)
- Section Credits (carrousel Swiper)
- Section Statistiques (compteurs animés)
- Section Timeline (chronologie PEBCO)

### ✅ Page unifiée des crédits
- Hero section spécifique
- 6 cartes détaillées avec :
  - Image et overlay
  - Conditions d'éligibilité
  - Caractéristiques (montant, durée, taux, délai)
  - Bouton "Faire une demande" vers login

### ✅ Navigation optimisée
- Header fixe avec blur effect
- Smooth scroll vers les sections
- Liens fonctionnels vers toutes les pages
- Menu responsive mobile

### ✅ Design moderne
- Animations AOS
- Gradients modernes
- Cards avec hover effects
- Timeline chronologique interactive
- Responsive complet

---

## 📝 Notes Techniques

### 🔄 Flux de Navigation
1. **Accueil** → Sections (About, Services, Credits, Stats, Timeline)
2. **Credits** → Page `/nos-credits` avec toutes les offres
3. **Demande** → Redirection vers `/login` (obligation de connexion)

### 🎯 Objectifs Atteints
- ✅ Centralisation des informations de crédit
- ✅ Simplification de la navigation
- ✅ Obligation de connexion avant demande
- ✅ Design moderne et responsive
- ✅ Code structuré et maintenable

### 🛡️ Sécurité
- Toutes les demandes nécessitent une connexion
- Routes protégées par middleware `auth`
- Validation des formulaires côté serveur

---

## 🎉 Conclusion

Cette documentation couvre l'ensemble de la structure du site PEBCO avec :
- **Pages** : Accueil, Crédits, Dashboard, Auth
- **Composants** : Header, Footer, Timeline
- **Styles** : CSS complet avec variables et responsive
- **Fonctionnalités** : Animations, carrousel, navigation
- **Routes** : Laravel avec authentification

Le code est organisé, maintenable et suit les meilleures pratiques Laravel et Bootstrap 5.
