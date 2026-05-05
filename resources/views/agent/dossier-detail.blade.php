@extends('agent.layout')

@section('title', 'Détails du dossier')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-900">Détails du dossier</h1>
            <p class="text-green-700 mt-2">Informations complètes de la demande de crédit</p>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-xl shadow-lg border border-green-200 p-8">
            <!-- Messages de succès/erreur -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informations client -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-user text-green-600 mr-3"></i>
                    Informations du client
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Nom complet</p>
                        <p class="font-medium text-gray-900">{{ $demande->client->nom }} {{ $demande->client->prenom }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Téléphone</p>
                        <p class="font-medium text-gray-900">{{ $demande->client->telephone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Adresse</p>
                        <p class="font-medium text-gray-900">{{ $demande->client->adresse_personnelle }}</p>
                    </div>

                    
                    <div>
                        <p class="text-sm text-gray-600">Type de crédit</p>
                        <p class="font-medium text-gray-900">{{ $demande->type_credit }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Durée</p>
                        <p class="font-medium text-gray-900">{{ $demande->duree_mois }} mois</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Montant demandé</p>
                        <p class="font-medium text-gray-900">{{ number_format($demande->montant_demande, 0, ',', ' ') }} FCFA</p>
                    </div>
                   
                    
                    <div>
                        <p class="text-sm text-gray-600">Objet du prêt</p>
                        <p class="font-medium text-gray-900">{{ $demande->objet_pret }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Description de l'activité</p>
                        <p class="font-medium text-gray-900">{{ $demande->client->description_activite }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Statut</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($demande->statut == 'en_cours') bg-amber-100 text-amber-800
                            @elseif($demande->statut == 'approuve') bg-green-100 text-green-800
                            @elseif($demande->statut == 'refuse') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            @if($demande->statut == 'en_cours') En cours
                            @elseif($demande->statut == 'approuve') Approuvé
                            @elseif($demande->statut == 'refuse') Refusé
                            @else En attente
                            @endif
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-600">Date de la demande</p>
                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($demande->date_demande)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date de traitement</p>
                        <p class="font-medium text-gray-900">{{ $demande->date_traitement ? \Carbon\Carbon::parse($demande->date_traitement)->format('d/m/Y') : 'Non traitée' }}</p>
                    </div>
                  
                </div>
            </div>

           

            <!-- Dates importantes -->
            <div class="mb-8">
               
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
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

            <!-- Actions -->
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('agent.dashboard') }}" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au tableau de bord
                    </a>
                </div>
                
                @if($demande->statut == 'en_cours')
                <div class="flex space-x-4">
                    <form action="{{ route('agent.dossiers.approuver', $demande->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-check mr-2"></i>Approuver
                        </button>
                    </form>
                    <button onclick="ouvrirModalRefus({{ $demande->id }})" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-times mr-2"></i>Refuser
                    </button>
                </div>

                <!-- Modal de Refus -->
                <div id="modalRefus" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
                        <div class="mt-3">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Refuser la Demande</h3>
                            <form action="{{ route('agent.dossiers.refuser', $demande->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Raison du Refus *</label>
                                    <textarea name="raison_refus" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Veuillez expliquer pourquoi cette demande est refusée..." required></textarea>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <button type="button" onclick="fermerModalRefus()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                        Annuler
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                        Confirmer le Refus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                function ouvrirModalRefus(demandeId) {
                    document.getElementById('modalRefus').classList.remove('hidden');
                }

                function fermerModalRefus() {
                    document.getElementById('modalRefus').classList.add('hidden');
                }
                </script>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
