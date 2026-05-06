@extends('layouts.admin')

@section('title', 'Créer un Agent - PEBCO')

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
                <a href="{{ route('admin.agents.create') }}" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
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
                <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-green-100 bg-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-colors">
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
                    <div class="flex items-center space-x-4">
                        <a href="/admin/agents" class="text-green-600 hover:text-green-800">
                            <i class="fas fa-arrow-left mr-2"></i>Retour aux Agents
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-green-900">Créer un Agent</h1>
                            <p class="text-green-700 text-sm">Ajouter un nouvel agent au système</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-green-200">
                        <h2 class="text-lg font-semibold text-green-900">Informations de l'Agent</h2>
                    </div>
                    <div class="p-6">
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

                        <form action="{{ route('admin.agents.store') }}" method="POST" id="createAgentForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                    <input type="text" name="nom" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Entrez le nom">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                                    <input type="text" name="prenom" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Entrez le prénom">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="email" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="email@gmail.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="text" name="telephone" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="+229 00 00 00 00 00">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Sexe *</label>
                                    <select name="sexe" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="M">Masculin</option>
                                        <option value="F">Féminin</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" required minlength="6" class="w-full px-3 py-2 pr-10 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Minimum 6 caractères">
                                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none">
                                            <i id="password-icon" class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors" style="position: relative; z-index: 9999; pointer-events: auto !important;" onclick="console.log('Bouton cliqué'); this.style.border='3px solid red';">
                                    <i class="fas fa-save mr-2"></i>Créer l'Agent
                                </button>
                            </div>
                        </form>
                        
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
                        
                        <!-- Test CSS -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.getElementById('createAgentForm');
                                const submitBtn = form.querySelector('button[type="submit"]');
                                
                                console.log('Formulaire trouvé:', form);
                                console.log('Bouton trouvé:', submitBtn);
                                console.log('Action formulaire:', form.action);
                                console.log('Styles du bouton:', window.getComputedStyle(submitBtn));
                                console.log('Position du bouton:', submitBtn.getBoundingClientRect());
                                console.log('Z-index:', window.getComputedStyle(submitBtn).zIndex);
                                console.log('Pointer-events:', window.getComputedStyle(submitBtn).pointerEvents);
                                
                                // Vérifier si quelque chose couvre le bouton
                                const rect = submitBtn.getBoundingClientRect();
                                const elementAtPoint = document.elementFromPoint(rect.left + rect.width/2, rect.top + rect.height/2);
                                console.log('Élément au-dessus du bouton:', elementAtPoint);
                                
                                submitBtn.addEventListener('click', function(e) {
                                    console.log('Click détecté sur le bouton');
                                    e.stopPropagation();
                                });
                                
                                form.addEventListener('submit', function(e) {
                                    console.log('Submit détecté sur le formulaire');
                                    console.log('Données:', new FormData(form));
                                    e.preventDefault();
                                    
                                    // Forcer la soumission après 1 seconde
                                    setTimeout(() => {
                                        console.log('Forçage de la soumission...');
                                        form.submit();
                                    }, 1000);
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
