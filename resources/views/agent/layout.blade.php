<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace Agent') - PEBCO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            z-index: 1000;
        }
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: linear-gradient(to bottom right, #f0fdf4, #dcfce7);
        }
        
        /* Fix Tailwind green colors */
        .bg-green-50 {
            background-color: #f0fdf4 !important;
        }
        .bg-green-600 {
            background-color: #16a34a !important;
        }
        .bg-green-700 {
            background-color: #15803d !important;
        }
        .bg-green-800 {
            background-color: #166534 !important;
        }
        .text-green-600 {
            color: #16a34a !important;
        }
        .text-green-700 {
            color: #15803d !important;
        }
        .text-green-800 {
            color: #166534 !important;
        }
        .text-green-900 {
            color: #14532d !important;
        }
        .text-green-100 {
            color: #dcfce7 !important;
        }
        .border-green-100 {
            border-color: #dcfce7 !important;
        }
        .border-green-200 {
            border-color: #bbf7d0 !important;
        }
        
        /* Fix gradient backgrounds */
        .bg-gradient-to-b {
            background-image: linear-gradient(to bottom, #16a34a, #166534) !important;
        }
        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, #f0fdf4, #dcfce7) !important;
        }
        
        /* Fix transitions */
        .transition-all {
            transition: all 0.2s ease !important;
        }
        .duration-200 {
            transition-duration: 200ms !important;
        }
        
        /* Fix shadows */
        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        }
        
        /* Fix hover states */
        .hover\:bg-white:hover {
            background-color: #ffffff !important;
        }
        .hover\:bg-opacity-10:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        .hover\:text-green-800:hover {
            color: #166534 !important;
        }
        .hover\:bg-red-600:hover {
            background-color: #dc2626 !important;
        }
        
        /* Fix opacity utilities */
        .bg-opacity-10 {
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        .bg-opacity-20 {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        
        /* Fix rounded utilities */
        .rounded-lg {
            border-radius: 0.5rem !important;
        }
        .rounded-full {
            border-radius: 9999px !important;
        }
        .rounded-xl {
            border-radius: 0.75rem !important;
        }
        .rounded-2xl {
            border-radius: 1rem !important;
        }
        
        /* Fix spacing utilities */
        .space-x-3 > * + * {
            margin-left: 0.75rem !important;
        }
        .space-y-4 > * + * {
            margin-top: 1rem !important;
        }
        
        @media (max-width: 768px) {
            .sidebar-fixed {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar-fixed.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-green-50">
    <!-- Sidebar -->
    <div class="sidebar-fixed bg-gradient-to-b from-green-600 to-green-800 text-white shadow-xl">
        <div class="p-6">
            <h4 class="text-xl font-bold mb-6">
                <i class="fas fa-university mr-2"></i>
                PEBCO Agent
            </h4>
        </div>
        
        <!-- Navigation -->
        <nav class="px-3">
            <a href="{{ route('agent.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('agent.dashboard') ? 'bg-white bg-opacity-10' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="{{ route('agent.dossiers') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('agent.dossiers.*') ? 'bg-white bg-opacity-10' : '' }}">
                <i class="fas fa-folder-open w-5"></i>
                <span>Dossiers</span>
            </a>
            <a href="{{ route('agent.parametres') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 hover:bg-white hover:bg-opacity-10 {{ request()->routeIs('agent.parametres') ? 'bg-white bg-opacity-10' : '' }}">
                <i class="fas fa-cog w-5"></i>
                <span>Paramètres</span>
            </a>
        </nav>
        
        <!-- User Info -->
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-white border-opacity-20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold">
                        {{ substr(Auth::guard('agent')->user()->prenom, 0, 1) }}{{ substr(Auth::guard('agent')->user()->nom, 0, 1) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}</p>
                    <p class="text-xs text-green-100">Agent</p>
                </div>
            </div>
            <form action="{{ route('agent.logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Menu Toggle -->
        <div class="md:hidden bg-white shadow-sm p-4 flex items-center justify-between">
            <button class="text-gray-600 hover:text-gray-900" id="sidebarToggle">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Page Content -->
        <main class="p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar-fixed').classList.toggle('show');
        });
    </script>
</body>
</html>
