<nav class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 md:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 text-green-700 hover:text-green-900 transition-colors">
                <img src="{{ asset('images/logo.jpg') }}" alt="PEBCO Logo" class="h-10 w-10 sm:h-12 sm:w-12 md:h-14 md:w-14 object-contain">
                <span class="font-bold text-lg sm:text-xl md:text-2xl">PEBCO</span>
            </a>
            
            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700 hover:text-green-700 transition-colors p-2 rounded-lg hover:bg-green-50" id="mobileMenuToggle">
                <i class="fas fa-bars text-lg sm:text-xl"></i>
            </button>
            
            <!-- Desktop menu -->
            <div class="hidden md:flex items-center space-x-4 lg:space-x-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium px-3 py-2 rounded-lg hover:bg-green-50">
                    <i class="fas fa-home text-sm"></i>
                    <span class="hidden sm:inline">Home</span>
                </a>
                <a href="{{ route('nos-credits') }}" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium px-3 py-2 rounded-lg hover:bg-green-50">
                    <i class="fas fa-coins text-sm"></i>
                    <span class="hidden sm:inline">Nos Crédits</span>
                </a>
                <a href="/suivi-demande" class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium px-3 py-2 rounded-lg hover:bg-green-50">
                    <i class="fas fa-paper-plane text-sm"></i>
                    <span class="hidden sm:inline">Suivre ma demande</span>
                </a>
                
                <!-- Auth buttons -->
                @guest
                    <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-3 sm:px-4 py-2 rounded-lg transition-colors text-sm sm:text-base">
                        <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i>
                        <span class="hidden sm:inline">Se connecter</span>
                    </a>
                @else
                    <!-- Dropdown pour admin connecté -->
                    @auth('admin')
                        <div class="relative">
                            <button class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium px-3 py-2 rounded-lg hover:bg-green-50" id="adminDropdown">
                                <i class="fas fa-user-shield text-sm"></i>
                                <span class="hidden sm:inline">{{ Auth::guard('admin')->user()->email }}</span>
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
                                <button class="flex items-center space-x-1 text-gray-700 hover:text-green-700 transition-colors font-medium px-3 py-2 rounded-lg hover:bg-green-50" id="agentDropdown">
                                    <i class="fas fa-user-tie text-sm"></i>
                                    <span class="hidden sm:inline">{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}</span>
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
        <div class="md:hidden hidden fixed inset-0 bg-white z-50" id="mobileMenu">
            <div class="flex flex-col h-full">
                <!-- Mobile header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200">
                    <span class="text-lg font-bold text-green-700">Menu</span>
                    <button class="text-gray-700 hover:text-green-700 transition-colors p-2" id="mobileMenuClose">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Mobile navigation -->
                <div class="flex-1 overflow-y-auto p-4 space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                        <i class="fas fa-home mr-3 text-lg"></i>
                        <span class="text-base font-medium">Home</span>
                    </a>
                    
                    <a href="{{ route('nos-credits') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                        <i class="fas fa-coins mr-3 text-lg"></i>
                        <span class="text-base font-medium">Nos Crédits</span>
                    </a>
                    
                    <a href="/suivi-demande" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                        <i class="fas fa-paper-plane mr-3 text-lg"></i>
                        <span class="text-base font-medium">Suivre ma demande</span>
                    </a>
                
                @guest
                    <a href="{{ route('login') }}" class="block w-full text-left px-3 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white transition-colors mt-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Connexion
                    </a>
                @else
                    @auth('admin')
                        <div class="border-t border-gray-200 mt-4 pt-4">
                            <div class="px-4 py-3 bg-green-50 rounded-lg mb-3">
                                <div class="flex items-center text-gray-900">
                                    <i class="fas fa-user-shield mr-3 text-green-600"></i>
                                    <div>
                                        <div class="text-sm font-medium">Admin</div>
                                        <div class="text-xs text-gray-600">{{ Auth::guard('admin')->user()->email }}</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                                <span class="text-base font-medium">Tableau de bord</span>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                                    <span class="text-base font-medium">Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    @else
                        @auth('agent')
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <div class="px-4 py-3 bg-green-50 rounded-lg mb-3">
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-user-tie mr-3 text-green-600"></i>
                                        <div>
                                            <div class="text-sm font-medium">Agent</div>
                                            <div class="text-xs text-gray-600">{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('agent.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                    <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
                                    <span class="text-base font-medium">Tableau de bord</span>
                                </a>
                                <form method="POST" action="{{ route('agent.agent.logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                                        <span class="text-base font-medium">Déconnexion</span>
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
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden');
            document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';
        }
    });
    
    document.getElementById('mobileMenuClose')?.addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
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
