@extends('layouts.admin')

@section('title', 'Modifier Agent - PEBCO')

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
                <a href="/admin/agents" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
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
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-green-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">Modifier Agent</h1>
                        <p class="text-green-700 text-sm">Mettre à jour les informations de l'agent</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            Agent #{{ $agent->id }}
                        </div>
                        <button class="text-green-600 hover:text-green-800 relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.agents.update', $agent->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                        <input type="text" name="nom" required value="{{ $agent->nom }}" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Entrez le nom">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                        <input type="text" name="prenom" required value="{{ $agent->prenom }}" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Entrez le prénom">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" required value="{{ $agent->email }}" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="email@exemple.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="telephone" value="{{ $agent->telephone }}" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="+228 00 00 00 00">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sexe *</label>
                        <select name="sexe" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="">Sélectionner</option>
                            <option value="M" {{ $agent->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ $agent->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                        <div class="relative">
                            <input type="password" name="mot_de_passe" id="edit-password" class="w-full px-3 py-2 pr-10 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Laisser vide pour ne pas modifier">
                            <button type="button" onclick="togglePassword('edit-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none">
                                <i id="edit-password-icon" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver le mot de passe actuel</p>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Mettre à jour l'Agent
                    </button>
                    <a href="{{ route('admin.agents') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors ml-2">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                </div>
            </form>
        </main>
    </div>
</div>

<!-- JavaScript pour afficher/masquer le mot de passe -->
<script>
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
