@extends('agent.layout')

@section('title', 'Dossier ' . $demande->code_dossier)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Messages de debug -->
    @if(session('debug'))
        <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <h3 class="text-yellow-800 font-bold mb-2">Debug Information:</h3>
            <pre class="text-xs text-yellow-700">{{ json_encode(session('debug'), JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
    
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif
    
    <!-- En-tête -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Dossier {{ $demande->code_dossier }}</h1>
                <p class="text-gray-600 mt-1 sm:mt-2">Détails de la demande de crédit</p>
            </div>
            <a href="{{ route('agent.dossiers.index') }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center px-4 py-2 bg-white rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Retour à la liste</span>
                <span class="sm:hidden">Retour</span>
            </a>
        </div>
    </div>

    <form action="{{ route('agent.dossiers.updateStatut', $demande->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations client -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Photo/Avatar et infos de base -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations du client</h2>
                    <div class="flex flex-col sm:flex-row sm:items-start space-y-4 sm:space-y-0 sm:space-x-4">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xl sm:text-2xl font-bold flex-shrink-0">
                            {{ strtoupper(substr($demande->nom, 0, 1)) }}{{ strtoupper(substr($demande->prenom, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">{{ $demande->nom }} {{ $demande->prenom }}</h3>
                            <div class="mt-2 space-y-1">
                                <p class="text-sm text-gray-600 flex items-center justify-center sm:justify-start">
                                    <i class="fas fa-envelope w-4 mr-2"></i> 
                                    <span class="break-all">{{ $demande->email }}</span>
                                </p>
                                <p class="text-sm text-gray-600 flex items-center justify-center sm:justify-start">
                                    <i class="fas fa-phone w-4 mr-2"></i> 
                                    {{ $demande->telephone ?? 'Non spécifié' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Détails du crédit -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails du crédit</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Objet du crédit</label>
                            <p class="text-gray-900 font-medium break-words">{{ $demande->objet_credit ?? 'Non spécifié' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type de crédit</label>
                            <p class="text-gray-900 font-medium break-words">{{ $demande->type_credit ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                            <p class="text-xl sm:text-2xl font-bold text-blue-600">{{ number_format($demande->montant, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Garantie</label>
                            <p class="text-gray-900 font-medium break-words">{{ $demande->garantie ?? 'Non spécifiée' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Photos (si disponibles) -->
                @if($demande->photo_personnelle || $demande->photo_carte_identite)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Documents</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if($demande->photo_personnelle)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $demande->photo_personnelle) }}" alt="Photo personnelle" 
                                         class="w-full h-24 sm:h-32 object-cover rounded-lg border border-gray-200" onerror="this.style.display='none'">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $demande->photo_personnelle) }}" target="_blank" 
                                           class="text-white hover:text-gray-200 bg-black bg-opacity-50 rounded-full p-2 transition-colors">
                                            <i class="fas fa-search-plus text-lg sm:text-xl"></i>
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2 text-center">Photo personnelle</p>
                                </div>
                            @endif
                            @if($demande->photo_carte_identite)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $demande->photo_carte_identite) }}" alt="Carte d'identité" 
                                         class="w-full h-24 sm:h-32 object-cover rounded-lg border border-gray-200" onerror="this.style.display='none'">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $demande->photo_carte_identite) }}" target="_blank" 
                                           class="text-white hover:text-gray-200 bg-black bg-opacity-50 rounded-full p-2 transition-colors">
                                            <i class="fas fa-search-plus text-lg sm:text-xl"></i>
                                        </a>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2 text-center">Carte d'identité</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Statut et actions -->
            <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                <!-- Statut actuel -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Statut du dossier</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut</label>
                            <select name="statut" id="statut" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <option value="en_attente" {{ $demande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="en_cours" {{ $demande->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="accepte" {{ $demande->statut == 'accepte' ? 'selected' : '' }}>Accepté</option>
                            <option value="refuse" {{ $demande->statut == 'refuse' ? 'selected' : '' }}>Refusé</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
                    <div class="mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-save mr-1"></i>
                            Enregistre toutes les modifications
                        </span>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm sm:text-base">
                        <i class="fas fa-save mr-2"></i>
                        <span class="hidden sm:inline">Enregistrer les modifications</span>
                        <span class="sm:hidden">Enregistrer</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
