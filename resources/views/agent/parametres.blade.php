@extends('agent.layout')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- En-tête -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Paramètres</h1>
        <p class="text-gray-600 mt-2">Gérez votre profil et vos informations personnelles</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Informations personnelles</h2>
            <form action="{{ route('agent.updateParametres') }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                    <input type="text" name="nom" value="{{ $agent->nom }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                    <input type="text" name="prenom" value="{{ $agent->prenom }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $agent->email }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" name="telephone" value="{{ $agent->telephone ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Mettre à jour les informations
                </button>
            </form>
        </div>

        <!-- Changement de mot de passe -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Changer le mot de passe</h2>
            <form action="{{ route('agent.change-password') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current-password" required
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('current-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 focus:outline-none">
                            <i id="current-password-icon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password" id="new-password" required minlength="8"
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('new-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 focus:outline-none">
                            <i id="new-password-icon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="confirm-password" required
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="togglePassword('confirm-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 focus:outline-none">
                            <i id="confirm-password-icon" class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors font-medium">
                    <i class="fas fa-key mr-2"></i>Changer le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript pour afficher/masquer les mots de passe -->
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
