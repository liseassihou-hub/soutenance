<nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 text-green-700 hover:text-green-900 transition-colors">
                <img src="{{ asset('images/logo.jpg') }}" alt="PEBCO Logo" class="h-14 w-14 object-contain">
                <span class="font-bold text-xl">PEBCO</span>
            </a>
            
            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700 hover:text-green-700 transition-colors" id="mobileMenuToggle">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <!-- Desktop menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                      <a href="{{ route('nos-credits') }}" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors">
                            <i class="fas fa-coins mr-2"></i>
                            <span>Nos Crédits</span>
                        </a>
                   
                  
                
                
                <a href="/suivi-demande" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium">
                    <i class="fas fa-paper-plane"></i>
                    <span>Suivre ma demande</span>
                </a>
                
                <!-- Auth buttons -->
                @guest
                    <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                         Se connecter
                    </a>
                @else
                    <!-- Dropdown pour admin connecté -->
                    @auth('admin')
                        <div class="relative">
                            <button class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium" id="adminDropdown">
                                <i class="fas fa-user-shield"></i>
                                <span>{{ Auth::guard('admin')->user()->email }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden" id="adminDropdownMenu">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                </a>
                                <hr class="border-gray-200">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Dropdown pour agent connecté -->
                        @auth('agent')
                            <div class="relative">
                                <button class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium" id="agentDropdown">
                                    <i class="fas fa-user-tie"></i>
                                    <span>{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden" id="agentDropdownMenu">
                                    <a href="{{ route('agent.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                    </a>
                                    <hr class="border-gray-200">
                                    <form method="POST" action="{{ route('agent.agent.logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endauth
                    @endauth
                @endguest
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden hidden" id="mobileMenu">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                    <i class="fas fa-home mr-2"></i>Home
                </a>
                
                <a href="{{ route('nos-credits') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                    <i class="fas fa-hand-holding-usd mr-2"></i>Nos Credits
                </a>
                
                <a href="/suivi-demande" class="block px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Suivre ma demande
                </a>
                
                @guest
                    <a href="{{ route('login') }}" class="block w-full text-left px-3 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white transition-colors mt-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Connexion
                    </a>
                @else
                    @auth('admin')
                        <div class="px-3 py-2 border-t border-gray-200 mt-2">
                            <div class="text-sm font-medium text-gray-900 mb-2">
                                <i class="fas fa-user-shield mr-2"></i>{{ Auth::guard('admin')->user()->email }}
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    @else
                        @auth('agent')
                            <div class="px-3 py-2 border-t border-gray-200 mt-2">
                                <div class="text-sm font-medium text-gray-900 mb-2">
                                    <i class="fas fa-user-tie mr-2"></i>{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}
                                </div>
                                <a href="{{ route('agent.dashboard') }}" class="block px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Tableau de bord
                                </a>
                                <form method="POST" action="{{ route('agent.agent.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        @endauth
                    @endauth
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });

    // Dropdown admin
    document.getElementById('adminDropdown')?.addEventListener('click', function() {
        document.getElementById('adminDropdownMenu').classList.toggle('hidden');
    });

    // Dropdown agent
    document.getElementById('agentDropdown')?.addEventListener('click', function() {
        document.getElementById('agentDropdownMenu').classList.toggle('hidden');
    });

    // Dropdown services
    document.getElementById('servicesDropdown')?.addEventListener('click', function() {
        document.getElementById('servicesDropdownMenu').classList.toggle('hidden');
    });

    // Fermer les dropdowns quand on clique ailleurs
    document.addEventListener('click', function(event) {
        // Ne pas fermer les dropdowns si on clique sur un lien ou un bouton
        if (event.target.closest('a') || event.target.closest('button')) {
            return;
        }
        
        if (!event.target.closest('#adminDropdown') && !event.target.closest('#adminDropdownMenu')) {
            document.getElementById('adminDropdownMenu')?.classList.add('hidden');
        }
        if (!event.target.closest('#agentDropdown') && !event.target.closest('#agentDropdownMenu')) {
            document.getElementById('agentDropdownMenu')?.classList.add('hidden');
        }
        if (!event.target.closest('#servicesDropdown') && !event.target.closest('#servicesDropdownMenu')) {
            document.getElementById('servicesDropdownMenu')?.classList.add('hidden');
        }
    });
</script>
