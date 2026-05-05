@extends('layouts.app')

@section('title', 'Accueil - PEBCO BETHESDA')

@section('content')
<!-- Message Flash -->
@if(session('success'))
<div class="fixed top-20 left-0 right-0 z-50 flex justify-center">
    <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg max-w-md mx-4 flex items-center space-x-3">
        <i class="fas fa-check-circle text-xl"></i>
        <div>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-50 to-green-100 flex items-center" style="min-height: 100vh;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Association pour la Promotion de l'Épargne-crédit
                    <span class="text-green-600">à Base Communautaire</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    PEBCO BETHESDA vous offre des solutions financières adaptées à vos besoins. 
                    Découvrez nos services de crédit et d'épargne pour développer vos projets.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('nos-credits') }}" class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-hand-holding-usd mr-3"></i>
                        Découvrir nos crédits
                    </a>
                    <a href="/suivi-demande" class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-50 text-green-600 font-semibold rounded-lg border-2 border-green-600 transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-search mr-3"></i>
                        Suivre ma demande
                    </a>
                </div>
            </div>
            
            <!-- Image/Illustration -->
            <div class="flex justify-center lg:justify-end">
                <div class="relative">
                    <div class="w-[28rem] h-[28rem] bg-gradient-to-br from-green-400 to-green-600 rounded-full opacity-20 absolute top-0 left-0 animate-pulse"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-12">
                        <div class="text-center">
                            <i class="fas fa-university text-8xl text-green-600 mb-6"></i>
                            <h3 class="text-3xl font-bold text-gray-900 mb-3">PEBCO BETHESDA</h3>
                            <p class="text-lg text-gray-600">Votre partenaire de confiance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Pourquoi nous <span class="text-green-600">choisir</span> ?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Nous mettons à votre disposition des services financiers adaptés à vos besoins
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-xl bg-green-50 border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Approche Communautaire</h3>
                <p class="text-gray-600">
                    Nous développons des solutions financières adaptées aux besoins de notre communauté locale
                </p>
            </div>
            
            <div class="text-center p-8 rounded-xl bg-green-50 border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-percentage text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Taux Compétitifs</h3>
                <p class="text-gray-600">
                    Des taux d'intérêt avantageux pour vous accompagner dans vos projets
                </p>
            </div>
            
            <div class="text-center p-8 rounded-xl bg-green-50 border-2 border-green-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Sécurité</h3>
                <p class="text-gray-600">
                    Vos transactions et vos données sont protégées avec les plus hauts standards
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-green-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Nos <span class="text-green-600">Services</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez la gamme complète de nos services financiers
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-coins text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Microcrédits</h3>
                </div>
                <p class="text-gray-600 mb-6">
                    Accédez à des financements rapides pour développer vos activités professionnelles ou personnelles
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Montants de 50 000 à 5 000 000 FCFA
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Délai de traitement rapide
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Taux d'intérêt compétitifs
                    </li>
                </ul>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-piggy-bank text-white text-xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Épargne</h3>
                </div>
                <p class="text-gray-600 mb-6">
                    Faites fructifier votre argent avec nos solutions d'épargne sécurisées
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Épargne à vue ou à terme
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Taux d'intérêt attractifs
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Accès flexible à vos fonds
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-green-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Prêt à démarrer votre projet ?
        </h2>
        <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto">
            Rejoignez des milliers de clients qui nous font confiance pour leurs besoins financiers
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('demande.create') }}" class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-100 text-green-600 font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-3"></i>
                Faire une demande
            </a>
            <a href="{{ route('nos-credits') }}" class="inline-flex items-center px-8 py-4 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-info-circle mr-3"></i>
                En savoir plus
            </a>
        </div>
    </div>
</section>
@endsection
