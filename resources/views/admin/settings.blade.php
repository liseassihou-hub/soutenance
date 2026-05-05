@extends('layouts.admin')

@section('title', 'Paramètres - PEBCO')

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
                <div class="border-t border-green-800 my-2"></div>
                <a href="/admin/settings" class="flex items-center space-x-3 px-4 py-3 bg-green-800 text-green-300 rounded-lg">
                    <i class="fas fa-cog w-7 text-lg"></i>
                    <span class="text-lg font-semibold">Paramètres</span>
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
                        <h1 class="text-2xl font-bold text-green-900">Paramètres</h1>
                        <p class="text-green-700 text-sm">Configuration du système PEBCO</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Settings Navigation -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="border-b border-green-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('general')" class="tab-btn py-4 px-1 border-b-2 border-green-500 font-medium text-sm text-green-600" data-tab="general">
                            <i class="fas fa-building mr-2"></i>Général
                        </button>
                        <button onclick="showTab('credit')" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="credit">
                            <i class="fas fa-coins mr-2"></i>Crédits
                        </button>
                        <button onclick="showTab('users')" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="users">
                            <i class="fas fa-users-cog mr-2"></i>Utilisateurs
                        </button>
                        <button onclick="showTab('notifications')" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="notifications">
                            <i class="fas fa-bell mr-2"></i>Notifications
                        </button>
                        <button onclick="showTab('security')" class="tab-btn py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="security">
                            <i class="fas fa-shield-alt mr-2"></i>Sécurité
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="space-y-6">
                <!-- General Settings -->
                <div id="general-tab" class="tab-content">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-green-200">
                            <h2 class="text-lg font-semibold text-green-900">Informations de l'Entreprise</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise</label>
                                    <input type="text" value="PEBCO" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email de contact</label>
                                    <input type="email" value="contact@pebco.com" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                    <input type="text" value="+228 00 00 00 00" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                    <input type="text" value="Lomé, Togo" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Devise par défaut</label>
                                    <select class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <option selected>FCFA - Franc CFA</option>
                                        <option>EUR - Euro</option>
                                        <option>USD - Dollar US</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Fuseau horaire</label>
                                    <select class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <option selected>UTC+00:00 (GMT)</option>
                                        <option>UTC+01:00 (Paris)</option>
                                        <option>UTC+00:00 (Lomé)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Credit Settings -->
                <div id="credit-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-green-200">
                            <h2 class="text-lg font-semibold text-green-900">Configuration des Crédits</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Taux d'intérêt -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Taux d'Intérêt</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Taux standard (%)</label>
                                            <input type="number" value="12" step="0.1" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Taux réduit (%)</label>
                                            <input type="number" value="8" step="0.1" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Taux majoré (%)</label>
                                            <input type="number" value="15" step="0.1" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Plafonds -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Plafonds de Crédit</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Montant minimum (FCFA)</label>
                                            <input type="number" value="50000" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Montant maximum (FCFA)</label>
                                            <input type="number" value="5000000" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Durée minimum (mois)</label>
                                            <input type="number" value="3" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Durée maximum (mois)</label>
                                            <input type="number" value="60" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Frais -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Frais de Dossier</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Frais fixes (FCFA)</label>
                                            <input type="number" value="5000" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Frais variables (%)</label>
                                            <input type="number" value="2" step="0.1" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Settings -->
                <div id="users-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-green-200">
                            <h2 class="text-lg font-semibold text-green-900">Gestion des Utilisateurs</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Permissions des agents -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Permissions des Agents</h3>
                                    <div class="space-y-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Peut consulter les demandes</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Peut approuver les crédits</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Peut modifier les informations client</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Peut supprimer des demandes</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Limites d'approbation -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Limites d'Approbation</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Limite par agent (FCFA)</label>
                                            <input type="number" value="1000000" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Limite journalière (FCFA)</label>
                                            <input type="number" value="5000000" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Session -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Session Utilisateur</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Durée de session (heures)</label>
                                            <input type="number" value="8" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tentatives max avant blocage</label>
                                            <input type="number" value="5" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Settings -->
                <div id="notifications-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-green-200">
                            <h2 class="text-lg font-semibold text-green-900">Configuration des Notifications</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Email notifications -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Notifications Email</h3>
                                    <div class="space-y-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Nouvelle demande de crédit</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Approbation/rejet de demande</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Rappel de paiement</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Rapports quotidiens</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- SMS notifications -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Notifications SMS</h3>
                                    <div class="space-y-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Confirmation de demande</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Approbation de crédit</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Rappel d'échéance</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Fréquence -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Fréquence des Rapports</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rapport quotidien</label>
                                            <select class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                                <option selected>17:00</option>
                                                <option>18:00</option>
                                                <option>19:00</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rapport hebdomadaire</label>
                                            <select class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                                <option selected>Lundi</option>
                                                <option>Mardi</option>
                                                <option>Mercredi</option>
                                                <option>Jeudi</option>
                                                <option>Vendredi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div id="security-tab" class="tab-content hidden">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-green-200">
                            <h2 class="text-lg font-semibold text-green-900">Sécurité du Système</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Password policy -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Politique de Mot de Passe</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Longueur minimum</label>
                                            <input type="number" value="8" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Expiration (jours)</label>
                                            <input type="number" value="90" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                    <div class="mt-4 space-y-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Exiger des majuscules</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Exiger des chiffres</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Exiger des caractères spéciaux</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Backup -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Sauvegarde des Données</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Fréquence de sauvegarde</label>
                                            <select class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                                <option>Quotidienne</option>
                                                <option selected>Hebdomadaire</option>
                                                <option>Mensuelle</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rétention (jours)</label>
                                            <input type="number" value="30" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Audit -->
                                <div>
                                    <h3 class="text-md font-medium text-gray-900 mb-4">Journal d'Audit</h3>
                                    <div class="space-y-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Logger les connexions</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Logger les modifications</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" checked class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Logger les suppressions</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="mr-3 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            <span class="text-sm text-gray-700">Logger les consultations</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Sauvegarder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('border-green-500', 'text-green-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active state to selected button
    const activeBtn = document.querySelector(`[data-tab="${tabName}"]`);
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    activeBtn.classList.add('border-green-500', 'text-green-600');
}
</script>
@endsection
