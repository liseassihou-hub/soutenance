@extends('layouts.admin')

@section('title', 'Détails du Client - PEBCO')

@section('content')
<div class="flex h-screen bg-green-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-900 text-white flex-shrink-0">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-8">
                <i class="fas fa-university text-green-400 text-2xl"></i>
                <div>
                    <h2 class="text-xl font-bold">PEBCO</h2>
                    <p class="text-green-200 text-sm">Admin Panel</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Tableau de Bord</span>
                </a>
                <a href="/admin/clients" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-users w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Clients</span>
                </a>
                <a href="/admin/agents" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-user-tie w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Agents</span>
                </a>
                <a href="{{ route('admin.agents.create') }}" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-user-plus w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Créer Agent</span>
                </a>
            </nav>
        </div>
        
        <!-- Bottom Section -->
        <div class="absolute bottom-0 left-0 right-0 p-6">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-green-200">Administrateur</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-green-100 hover:bg-green-800 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200 sticky top-0 z-10">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">Détails du Client</h1>
                        <p class="text-green-700 text-sm">Informations complètes du client</p>
                    </div>
                                    </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if($client)
                <!-- Client Information -->
               

                <!-- Demand Information -->
                @if($client->demandesCredit->count() > 0)
                    @foreach($client->demandesCredit->take(1) as $demande)
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                       
                         <h2 class="text-lg font-semibold text-green-900 mb-4">Informations du Client sur la Demande</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">Nom Complet</label>
                            <p class="text-gray-900 font-medium">{{ $client->nom }} {{ $client->prenom }}</p>
                        </div>
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">Téléphone</label>
                            <p class="text-gray-900">{{ $client->telephone }}</p>
                        </div>
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">Adresse</label>
                            <p class="text-gray-900">{{ $client->adresse_personnelle }}</p>
                        </div>
                        <div>
                            <label class="block text-base font-semibold text-gray-800 mb-2">Pièce d'Identité</label>
                            <p class="text-gray-900">{{ $client->piece_identite_type }} N°{{ $client->piece_identite_numero }}</p>
                        </div>
                       
                         <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Date de Demande</label>
                                <p class="text-gray-900">{{ $demande->date_demande->format('d/m/Y') }}</p>
                            </div>
                    
                       
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Description de l'activité</label>
                                <p class="text-gray-900 font-medium">{{ $demande->client->description_activite ?: 'Non spécifiée' }}</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Montant Demandé</label>
                                <p class="text-gray-900 font-medium text-xl">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Durée (mois)</label>
                                <p class="text-gray-900">{{ $demande->duree_mois }} mois</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Type de Crédit</label>
                                <p class="text-gray-900">{{ $demande->type_credit }}</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Objet du Crédit</label>
                                <p class="text-gray-900">{{ $demande->objet_pret }}</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Statut</label>
                                @if($demande->statut == 'en_attente')
                                    <span class="px-3 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        En Attente
                                    </span>
                                @elseif($demande->statut == 'approuve')
                                    <span class="px-3 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Approuvé
                                    </span>
                                @else
                                    <span class="px-3 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejeté
                                    </span>
                                @endif
                            </div>
                           
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Date de Traitement</label>
                                <p class="text-gray-900">{{ $demande->date_traitement ? $demande->date_traitement->format('d/m/Y') : 'Non traité' }}</p>
                            </div>
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Agent Traitant</label>
                                <p class="text-gray-900">
                                    @if($demande->agent_id && $demande->agent)
                                        {{ $demande->agent->nom }} {{ $demande->agent->prenom }}
                                    @else
                                        Non assigné
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                <div class="bg-white rounded-xl shadow-sm border border-green-200 p-8 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-image text-green-600 mr-3"></i>
                    Documents du Client
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-base font-semibold text-gray-800 mb-2">Photo Personnelle</label>
                        @if($demande->photo_personnelle)
                            <img src="{{ asset('storage/' . $demande->photo_personnelle) }}" alt="Photo du client" 
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-green-200 cursor-pointer hover:opacity-80 transition-opacity"
                                 onclick="openImageModal('{{ asset('storage/' . $demande->photo_personnelle) }}', 'Photo Personnelle')"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div style="display:none;" class="text-red-500 text-sm">Erreur de chargement</div>
                        @else
                            <p class="text-gray-500">Photo non fournie</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-base font-semibold text-gray-800 mb-2">Photo Pièce d'Identité</label>
                        @if($demande->photo_piece_identite)
                            <img src="{{ asset('storage/' . $demande->photo_piece_identite) }}" alt="Pièce d'identité" 
                                 class="w-32 h-32 object-cover rounded-lg border-2 border-green-200 cursor-pointer hover:opacity-80 transition-opacity"
                                 onclick="openImageModal('{{ asset('storage/' . $demande->photo_piece_identite) }}', 'Photo Pièce d\'Identité')"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <div style="display:none;" class="text-red-500 text-sm">Erreur de chargement</div>
                        @else
                            <p class="text-gray-500">Pièce non fournie</p>
                        @endif
                    </div>
                </div>
            </div>

                    <!-- Notes -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-green-900 mb-4">Informations Complémentaires</h2>
                        <div class="space-y-4">
                            @if($demande->statut == 'refuse' && $demande->raison_refus)
                            <div>
                                <label class="block text-base font-semibold text-gray-800 mb-2">Raison du Refus</label>
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-800 font-medium">{{ $demande->raison_refus }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-center">
                            <i class="fas fa-file-invoice-dollar text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-700">Aucune demande de crédit trouvée</p>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                        <p class="text-gray-700">Client non trouvé</p>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <p id="modalTitle" class="text-white text-center mt-4 text-lg font-medium"></p>
    </div>
</div>

<script>
function openImageModal(imageSrc, title) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('modalTitle');
    
    modalImage.src = imageSrc;
    modalImage.alt = title;
    modalTitle.textContent = title;
    modal.classList.remove('hidden');
    
    // Prevent body scroll when modal is open
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    
    // Restore body scroll
    document.body.style.overflow = 'auto';
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});

// Close modal on background click
document.getElementById('imageModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeImageModal();
    }
});
</script>

@endsection
