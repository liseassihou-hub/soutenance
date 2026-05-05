@extends('layouts.app')

@section('content')


    

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="swiper hero-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url('{{ asset('images/slider/slider1.png') }}');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide" style="background-image: url('{{ asset('images/slider/slider2.avif') }}');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide" style="background-image: url('{{ asset('images/slider/slider3.avif') }}');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide" style="background-image: url('{{ asset('images/slider/slider4.webp') }}');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="swiper-slide" style="background-image: url('{{ asset('images/slider/slider5.webp') }}');">
                    <div class="hero-overlay"></div>
                </div>
            </div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title" data-aos="fade-up">PEBCO</h1>
            <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                Votre partenaire de confiance pour des solutions financières adaptées à vos besoins
            </p>
            
            <!-- Boutons d'accès -->
            
    <a href="{{ route('nos-credits') }}" class="credit-btn" style="position: relative; z-index: 9999; pointer-events: auto; background: linear-gradient(135deg, var(--primary-green) 0%, var(--light-green) 100%); color: white; padding: 1rem 2.5rem; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 1.1rem; border-radius: 50px; text-decoration: none; display: inline-block; box-shadow: 0 4px 16px rgba(30, 94, 30, 0.3);">
        <i class="fas fa-paper-plane me-2"></i> Nos offres de crédits
    </a>
</div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gradient-to-br from-green-50 to-green-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <div class="mb-8">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"> PEBCo BETHESDA</h2>
                        <div class="flex items-center mb-6">
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold mr-3">SFD</span>
                            <span class="text-xl text-gray-700">Institution de Microfinance de confiance</span>
                        </div>
                    </div>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed text-justify">
                        PEBCO est une institution de microfinance engagée dans le développement économique 
                        et social de nos communautés. Nous offrons des services financiers adaptés aux besoins 
                        des entrepreneurs, des agriculteurs et des ménages.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed text-justify">
                        En tant que SFD (Système Financier Décentralisé), nous nous efforçons de rendre 
                        les services financiers accessibles à tous, en particulier aux populations rurales 
                        et urbaines défavorisées.
                    </p>
                </div>
                <div data-aos="fade-left">
                    <div class="relative">
                        <img src="{{ asset('images/slider/about.jpg') }}" alt="À propos de PEBCO" 
                             class="w-full h-[400px] lg:h-[500px] object-cover rounded-2xl shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-800 opacity-10 rounded-2xl pointer-events-none"></div>
                    </div>
                </div>
            </div>
            
            <!-- Mission & Valeurs & Impact -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-16">
                <div data-aos="fade-right">
                    <div class="relative">
                        <img src="{{ asset('images/slider/slider2.avif') }}" alt="Mission & Valeurs" 
                             class="w-full h-[400px] lg:h-[500px] object-cover rounded-2xl shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-800 opacity-10 rounded-2xl pointer-events-none"></div>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <!-- Mission & Vision -->
                    <div class="mb-8">
                        <h5 class="text-2xl font-bold text-green-600 mb-4 flex items-center">
                            <i class="fas fa-bullseye mr-3"></i>
                            Notre Mission
                        </h5>
                        <p class="text-lg text-gray-600 leading-relaxed text-justify">
                            Promouvoir l'inclusion financière en offrant des solutions adaptées 
                            aux besoins réels des entrepreneurs, agriculteurs et ménages.
                        </p>
                    </div>
                    
                    <!-- Valeurs -->
                    <div class="mb-8">
                        <h5 class="text-2xl font-bold text-green-600 mb-4 flex items-center">
                            <i class="fas fa-heart mr-3"></i>
                            Nos Valeurs
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-check-circle text-green-600 mr-3 text-xl"></i>
                                <span class="text-lg font-semibold text-gray-800">Intégrité</span>
                            </div>
                            <div class="flex items-center mb-3">
                                <i class="fas fa-lightbulb text-green-600 mr-3 text-xl"></i>
                                <span class="text-lg font-semibold text-gray-800">Innovation</span>
                            </div>
                            <div class="flex items-center mb-3">
                                <i class="fas fa-handshake text-green-600 mr-3 text-xl"></i>
                                <span class="text-lg font-semibold text-gray-800">Engagement</span>
                            </div>
                            <div class="flex items-center mb-3">
                                <i class="fas fa-star text-green-600 mr-3 text-xl"></i>
                                <span class="text-lg font-semibold text-gray-800">Excellence</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Impact Social -->
                    <div class="mb-8">
                        <h5 class="text-2xl font-bold text-green-600 mb-4 flex items-center">
                            <i class="fas fa-users mr-3"></i>
                            Impact Social
                        </h5>
                        <div class="space-y-3">
                            <p class="text-lg text-gray-600 flex items-start">
                                <i class="fas fa-arrow-right text-green-600 mr-3 mt-1"></i>
                                <span class="text-justify">Soutien aux projets communautaires et développement local</span>
                            </p>
                            <p class="text-lg text-gray-600 flex items-start">
                                <i class="fas fa-arrow-right text-green-600 mr-3 mt-1"></i>
                                <span class="text-justify">Formation financière pour les entrepreneurs</span>
                            </p>
                            <p class="text-lg text-gray-600 flex items-start">
                                <i class="fas fa-arrow-right text-green-600 mr-3 mt-1"></i>
                                <span class="text-justify">Réduction de la pauvreté par l'accès au crédit</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    <!-- Credits Section -->
    <section id="credits" class="credits-section section-padding">
      <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
          <h2>Nos Offres de Crédits</h2>
          <p class="section-subtitle">Choisissez le financement adapté à votre projet</p>
        </div>

        <!-- Carrousel de crédits -->
        <div class="credits-carousel swiper" data-aos="fade-up">
          <div class="swiper-wrapper">

            <!-- Petit crédit individuel -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                    <img src="{{ asset('images/slider/credit individuel.png') }}" class="card-img-top" alt="Petit crédit individuel">
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-person fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Petit prêts individuel</h5>
                    <p class="card-text text-justify">Un crédit petits prêts individuels est un type de prêt conçu pour financer des.... 
                         <a href="{{ route('nos-credits') }}#petit-credit-individuel" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'">En savoir plus</a>.</p> 
                    
                      
                    
                  </div>
                </div>
            </div>

            <!-- Crédit scolaire -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                     <img src="{{ asset('images/slider/credit scolaire.jpg') }}" class="card-img-top" alt="Crédit scolaire ">
                    
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-mortarboard fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Crédit scolaire</h5>
                    <p class="card-text text-justify">Solution de financement pour frais de scolarité et matériel... <br> 
                        <a href="{{ route('nos-credits') }}#credit-scolaire" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'">En savoir plus</a></p>
                    
                   
                  </div>
                </div>
            </div>

            <!-- Crédit moyen -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                    <img src="{{ asset('images/slider/microcredit.jpeg') }}" class="card-img-top" alt="Crédit moyen">
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-piggy-bank fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Crédit moyen</h5>
                    <p class="card-text text-justify">Un crédit de prêts moyens est un type de financement spécifiquement conçu... <br> 
                        <a href="{{ route('nos-credits') }}#credit-moyen" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'">En savoir plus</a>
                    </p>
                    
                    
                  </div>
                </div>
            </div>

            <!-- Crédit agricole / warrantage -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                    <img src="{{ asset('images/slider/credit agricole.png') }}" class="card-img-top" alt="Crédit agricole / warrantage">
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-tree fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Crédit agricole / warrantage</h5>
                    <p class="card-text text-justify">Vous êtes producteur de soja, maïs, arachide, niébé ou d'autres cultures ? ... <br>
                        <a href="{{ route('nos-credits') }}#credit-warrantage" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'">En savoir plus</a>
                    </p>
                    
                  </div>
                </div>
            </div>

            <!-- Crédit agricole général -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                   <img src="{{ asset('images/slider/credit de groupe.jpg') }}" class="card-img-top" alt="Crédit groupe">
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-tractor fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Credits aux Artisans</h5>
                    <p class="card-text text-justify">Le Crédit aux Artisans est une solution de financement dédiée à soutenir les... 
                        <a href="{{ route('nos-credits') }}#credit-artisans" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'"> <br> En savoir plus... </a> </P>
                    
                    
                  </div>
                </div>
            </div>

            <!-- Crédit substantiel -->
            <div class="swiper-slide">
                <div class="card h-100 shadow credit-card">
                  <div class="card-img-wrapper">
                    <img src="{{ asset('images/slider/credit equipement.jpg') }}" class="card-img-top" alt="Crédit substantiel">
                    <div class="card-overlay">
                      <div class="overlay-content">
                        <i class="bi bi-tools fs-1"></i>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-center">
                    <h5 class="card-title">Crédit substantiel</h5>
                    <p class="card-text text-justify">Un prêt substantiel est un type de financement accordé à un emprunteur,... 
                        <a href="{{ route('nos-credits') }}#credit-substantiel" class="fw-bold text-decoration-none" style="color: #2d7a2d;" onmouseover="this.style.color='#1e5e1e'" onmouseout="this.style.color='#2d7a2d'">En savoir plus</a> </P>
                    </div>
                  </div>
                </div>
            </div>

          </div>
        </div>

       
      </div>
    </section>

    <!-- Pourquoi nous choisir Section -->
    <section class="py-20 relative min-h-screen overflow-hidden" style="background-image: url('{{ asset('images/slider/reassurance.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-gray-700 opacity-40"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" style="color: #ffffff; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">Pourquoi nous choisir ?</h2>
                <p class="text-2xl max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100" style="color: #f8f9fa; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">
                    Des chiffres qui témoignent de notre expertise et de notre engagement
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-5xl font-bold text-white mb-2" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                            <span class="stat-number" data-target="30">0</span>
                            <span class="text-green-400">+</span>
                        </div>
                        <div class="text-xl font-medium" style="color: #f1f2f3; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">ans d'expérience</div>
                    </div>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-5xl font-bold text-white mb-2" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                            <span class="stat-number" data-target="14655">0</span>
                            <span class="text-green-400">+</span>
                        </div>
                        <div class="text-lg font-medium" style="color: #f8f9fa; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">clients accompagnés</div>
                    </div>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-5xl font-bold text-white mb-2" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                            <span class="stat-number" data-target="1300">0</span>
                            <span class="text-green-400">%</span>
                        </div>
                        <div class="text-lg font-medium" style="color: #f8f9fa; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">crédits accordés</div>
                    </div>
                </div>
                
                <div class="text-center" data-aos="fade-up" data-aos-delay="500">
                    <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-8 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-5xl font-bold text-white mb-2" style="color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">
                            <span class="stat-number" data-target="69">0</span>
                            <span class="text-green-400">+</span>
                        </div>
                        <div class="text-lg font-medium" style="color: #f8f9fa; text-shadow: 0 1px 2px rgba(0,0,0,0.2);">agences</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline Section -->
    @include('partials.timeline')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper with enhanced settings
    const heroSwiper = new Swiper('.hero-slider', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        speed: 2000,
        lazy: {
            loadPrevNext: true,
        },
    });
    
    // Initialize Credits Carousel - Auto-scroll only
    const creditsCarousel = new Swiper('.credits-carousel', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: false,
        },
        allowTouchMove: false,
        simulateTouch: false,
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 25,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
        effect: 'slide',
        speed: 600,
    });
    
    // Enhanced smooth scrolling for navigation links
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
                
                // Close mobile menu if open
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                }
            }
        });
    });
    
    // Enhanced navbar scroll effect
    const navbar = document.querySelector('.navbar');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add/remove scrolled class
        if (scrollTop > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Hide/show navbar on scroll
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        
        lastScrollTop = scrollTop;
    });
    
    // Add parallax effect to hero section
    const heroSection = document.querySelector('.hero-section');
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallax = heroSection.querySelector('.hero-content');
        if (parallax) {
            parallax.style.transform = `translate(-50%, calc(-50% + ${scrolled * 0.3}px))`;
        }
    });
    
    // Add hover effect to credit cards
    document.querySelectorAll('.credit-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add loading animation for images
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '0';
            setTimeout(() => {
                this.style.transition = 'opacity 0.5s ease-in-out';
                this.style.opacity = '1';
            }, 100);
        });
    });
    
    // Enhanced AOS settings
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100,
        easing: 'ease-out-cubic'
    });
    
    // Add counter animation for stats
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    let current = start;
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Trigger counter animation when stats are visible
const observerOptions = {
    threshold: 0.3, // Déclenche quand 30% de la section est visible
    rootMargin: '0px 0px -100px 0px' // Légèrement avant que la section n'entre dans le viewport
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Trouver tous les compteurs dans la section observée
            const statNumbers = entry.target.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                // Récupérer la valeur cible depuis l'attribut data-target
                const target = parseInt(stat.getAttribute('data-target'));
                if (!isNaN(target) && stat.textContent === '0') {
                    animateCounter(stat, target);
                }
            });
            // Une fois l'animation déclenchée, arrêter d'observer cette section
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observer la section "Pourquoi nous choisir" - Méthode plus robuste
const pourquoiNousChoisirSection = document.querySelector('.py-20.relative.min-h-screen.overflow-hidden');
if (pourquoiNousChoisirSection) {
    observer.observe(pourquoiNousChoisirSection);
}
});
</script>
@endpush
