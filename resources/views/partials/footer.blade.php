<footer class="bg-gradient-to-br from-green-800 to-green-900 text-white py-6 mt-auto" style="background: linear-gradient(to bottom right, #1e5e1e, #144614);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Section PEBCO -->
            <div class="space-y-3">
                <div class="flex items-center space-x-2">
                    <div class="p-2 rounded-lg" style="background-color: #2d7a2d;">
                        <i class="fas fa-university text-white text-xl"></i>
                    </div>
                    <div>
                        <h5 class="text-white text-lg font-bold">PEBCO</h5>
                        <p class="text-green-200 text-xs">Institution de Microfinance</p>
                    </div>
                </div>
                <p class="text-green-100 text-sm leading-relaxed">
                    Votre partenaire de confiance pour des solutions financières adaptées à vos besoins.
                </p>
            </div>

            
            
            <!-- Services -->
            <div>
                <h6 class="text-white font-bold mb-4 uppercase tracking-wider text-xs border-b pb-1" style="border-color: #2d7a2d;">Services</h6>
                <ul class="space-y-2">
                    <li><a href="{{ route('nos-credits') }}" class="text-green-100 hover:text-white transition-colors flex items-center text-sm">
                        <i class="fas fa-chevron-right mr-2 text-xs" style="color: #4caf50;"></i>Crédits
                    </a></li>
                    <li><a href="#" class="text-green-100 hover:text-white transition-colors flex items-center text-sm">
                        <i class="fas fa-chevron-right mr-2 text-xs" style="color: #4caf50;"></i>Épargne
                    </a></li>
                    <li><a href="#" class="text-green-100 hover:text-white transition-colors flex items-center text-sm">
                        <i class="fas fa-chevron-right mr-2 text-xs" style="color: #4caf50;"></i>Transfert
                    </a></li>
                    <li><a href="#" class="text-green-100 hover:text-white transition-colors flex items-center text-sm">
                        <i class="fas fa-chevron-right mr-2 text-xs" style="color: #4caf50;"></i>Assurance
                    </a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h6 class="text-white font-bold mb-4 uppercase tracking-wider text-xs border-b pb-1" style="border-color: #2d7a2d;">Contact</h6>
                <ul class="space-y-2">
                    <li class="flex items-center space-x-2">
                        <div class="p-1.5 rounded-full" style="background-color: #2d7a2d;">
                            <i class="fas fa-phone text-white text-xs"></i>
                        </div>
                        <span class="text-green-100 text-sm">+(229) 21 60 26 81</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <div class="p-1.5 rounded-full" style="background-color: #2d7a2d;">
                            <i class="fas fa-envelope text-white text-xs"></i>
                        </div>
                        <span class="text-green-100 text-sm">Cotonou, Sainte Rita.</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <div class="p-1.5 rounded-full" style="background-color: #2d7a2d;">
                            <i class="fas fa-map-marker-alt text-white text-xs"></i>
                        </div>
                        <span class="text-green-100 text-sm">Cotonou, Sainte Rita.
Promotion de l'Epargne Crédit à Base Communautaire.</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Barre inférieure -->
        <div class="border-t mt-6 pt-4" style="border-color: #144614;">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-green-200 text-xs">
                    © {{ date('Y') }} PEBCO BETHESDA. Tous droits réservés.
                </p>
                <div class="flex space-x-3 mt-3 md:mt-0">
                    <a href="https://www.facebook.com/p/PEBCo-Bethesda-100063667567326/" class="text-white p-1.5 rounded-full transition-colors" style="background-color: #2d7a2d;" onmouseover="this.style.backgroundColor='#4caf50'" onmouseout="this.style.backgroundColor='#2d7a2d'">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    <a href="#" class="bg-green-600 hover:bg-green-500 text-white p-1.5 rounded-full transition-colors">
                        <i class="fab fa-twitter text-xs"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/pebcobethesda/?originalSubdomain=bj" class="bg-green-600 hover:bg-green-500 text-white p-1.5 rounded-full transition-colors">
                        <i class="fab fa-linkedin-in text-xs"></i>
                    </a>
                    <a href="#" class="bg-green-600 hover:bg-green-500 text-white p-1.5 rounded-full transition-colors">
                        <i class="fab fa-instagram text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
