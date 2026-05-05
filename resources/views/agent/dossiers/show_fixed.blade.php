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
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dossier {{ $demande->code_dossier }}</h1>
                <p class="text-gray-600 mt-2">Détails de la demande de crédit</p>
            </div>
            <a href="{{ route('agent.dossiers.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
            </a>
        </div>
    </div>

    <!-- FORMULAIRE CORRIGÉ -->
    <form action="{{ route('agent.dossiers.updateStatut', $demande->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations client -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations du client</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                            <p class="text-gray-900 font-medium">{{ $demande->nom }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                            <p class="text-gray-900 font-medium">{{ $demande->prenom }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900 font-medium">{{ $demande->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <p class="text-gray-900 font-medium">{{ $demande->telephone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Détails du crédit -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Détails du crédit</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Objet du crédit</label>
                            <p class="text-gray-900 font-medium">{{ $demande->objet_credit ?? 'Non spécifié' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type de crédit</label>
                            <p class="text-gray-900 font-medium">{{ $demande->type_credit ?? 'Non spécifié' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Montant demandé</label>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($demande->montant, 0, ',', ' ') }} FCFA</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                            <p class="text-gray-900 font-medium">{{ $demande->duree ?? 'Non spécifiée' }} mois</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Garantie</label>
                            <p class="text-gray-900 font-medium">{{ $demande->garantie ?? 'Non spécifiée' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Décision du comité -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Décision du comité</h2>
                    <div class="mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-info-circle mr-1"></i>
                            Modifiable et sera sauvegardé
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observations du comité</label>
                        <textarea name="decision_comite" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Saisir les observations du comité...">{{ $demande->decision_comite ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Statut -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Statut du dossier</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut</label>
                            <select name="statut" id="statut" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="en_attente" {{ $demande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en_cours" {{ $demande->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="accepte" {{ $demande->statut == 'accepte' ? 'selected' : '' }}>Accepté</option>
                                <option value="refuse" {{ $demande->statut == 'refuse' ? 'selected' : '' }}>Refusé</option>
                            </select>
                        </div>

                        <!-- Champ observation si refusé -->
                        <div id="observation_refus_field" class="{{ $demande->statut != 'refuse' ? 'hidden' : '' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Observation du refus <span class="text-red-500">*</span>
                            </label>
                            <textarea name="observation_refus" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Veuillez spécifier la raison du refus...">{{ $demande->observation_refus ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-save mr-1"></i>
                            Enregistre toutes les modifications
                        </span>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('statut').addEventListener('change', function() {
    const observationField = document.getElementById('observation_refus_field');
    const observationTextarea = document.querySelector('textarea[name="observation_refus"]');
    
    if (this.value === 'refuse') {
        observationField.classList.remove('hidden');
        observationTextarea.setAttribute('required', 'required');
    } else {
        observationField.classList.add('hidden');
        observationTextarea.removeAttribute('required');
    }
});
</script>
@endsection
