@extends('agent.layout')

@section('title', 'Dossier ' . $dossier->code_dossier)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Messages Flash -->
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <strong>Succès !</strong> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Erreur !</strong> {{ session('error') }}
        </div>
    @endif

    <!-- Debug Information -->
    @if(session('debug'))
        <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            <h3 class="font-bold mb-2">🔍 Debug Information:</h3>
            <pre class="text-xs">{{ json_encode(session('debug'), JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif

    <!-- En-tête -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dossier {{ $dossier->code_dossier }}</h1>
                <p class="text-gray-600">Client : {{ $dossier->nom }} {{ $dossier->prenom }}</p>
            </div>
            <a href="{{ route('agent.dossiers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Retour
            </a>
        </div>
    </div>

    <!-- FORMULAIRE DE MODIFICATION DU STATUT -->
    <form action="{{ route('agent.dossiers.update', $dossier->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')  <!-- Important pour la mise à jour -->
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Informations du dossier -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Informations du Dossier</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <p class="text-gray-900">{{ $dossier->nom }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <p class="text-gray-900">{{ $dossier->prenom }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="text-gray-900">{{ $dossier->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Montant</label>
                        <p class="text-lg font-bold text-blue-600">{{ number_format($dossier->montant, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de crédit</label>
                        <p class="text-gray-900">{{ $dossier->type_credit }}</p>
                    </div>
                </div>
            </div>

            <!-- Modification du statut -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Modifier le Statut</h2>
                
                <!-- Statut actuel -->
                <div class="mb-4 p-3 bg-gray-50 rounded">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut actuel</label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                        @if($dossier->statut == 'en_attente') bg-yellow-100 text-yellow-800
                        @elseif($dossier->statut == 'en_cours') bg-blue-100 text-blue-800
                        @elseif($dossier->statut == 'accepte') bg-green-100 text-green-800
                        @elseif($dossier->statut == 'refuse') bg-red-100 text-red-800
                        @endif">
                        @if($dossier->statut == 'en_attente') En attente
                        @elseif($dossier->statut == 'en_cours') En cours
                        @elseif($dossier->statut == 'accepte') Accepté
                        @elseif($dossier->statut == 'refuse') Refusé
                        @endif
                    </span>
                </div>

                <!-- Nouveau statut -->
                <div class="mb-4">
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                        Nouveau statut <span class="text-red-500">*</span>
                    </label>
                    <select name="statut" id="statut" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Sélectionner un statut --</option>
                        <option value="en_attente" {{ $dossier->statut == 'en_attente' ? 'selected' : '' }}>
                            🟡 En attente
                        </option>
                        <option value="en_cours" {{ $dossier->statut == 'en_cours' ? 'selected' : '' }}>
                            🔵 En cours
                        </option>
                        <option value="accepte" {{ $dossier->statut == 'accepte' ? 'selected' : '' }}>
                            🟢 Accepté
                        </option>
                        <option value="refuse" {{ $dossier->statut == 'refuse' ? 'selected' : '' }}>
                            🔴 Refusé
                        </option>
                    </select>
                </div>

                <!-- Observation si refusé -->
                <div id="refus-field" class="{{ $dossier->statut != 'refuse' ? 'hidden' : '' }}">
                    <label for="observation_refus" class="block text-sm font-medium text-gray-700 mb-2">
                        Observation du refus <span class="text-red-500">*</span>
                    </label>
                    <textarea name="observation_refus" id="observation_refus" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Veuillez expliquer la raison du refus...">{{ $dossier->observation_refus ?? '' }}</textarea>
                </div>

                <!-- Bouton de soumission -->
                <div class="mt-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium">
                        💾 Mettre à jour le statut
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Afficher/masquer le champ observation si refusé
document.getElementById('statut').addEventListener('change', function() {
    const refusField = document.getElementById('refus-field');
    const observationTextarea = document.getElementById('observation_refus');
    
    if (this.value === 'refuse') {
        refusField.classList.remove('hidden');
        observationTextarea.setAttribute('required', 'required');
    } else {
        refusField.classList.add('hidden');
        observationTextarea.removeAttribute('required');
    }
});
</script>
@endsection
