@extends('layouts.app')

@section('title', 'Confirmation de Demande - PEBCO')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="height: 60vh; min-height: 400px;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container text-center">
            <div class="success-icon mb-4" data-aos="zoom-in">
                <i class="fas fa-check-circle text-white" style="font-size: 4rem;"></i>
            </div>
            <h1 class="display-4 fw-bold text-white mb-3" data-aos="fade-up">Demande Soumise avec Succès!</h1>
            <p class="lead text-white" data-aos="fade-up" data-aos-delay="100">Votre demande de crédit a été enregistrée</p>
        </div>
    </div>
</section>

<!-- Code de Suivi Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-green-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Votre Code de Suivi</h2>
            <p class="text-lg text-gray-600">Conservez précieusement ce code pour suivre votre demande</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12" data-aos="fade-up" data-aos-delay="200">
            <!-- Code Display -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gradient-to-r from-green-600 to-green-700 text-white px-8 py-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300">
                    <p class="text-sm font-medium mb-2 opacity-90">CODE DE SUIVI</p>
                    <p class="text-3xl md:text-4xl font-bold tracking-wider" id="codeSuivi">
                        @if($codeDossier)
                            {{ $codeDossier }}
                        @else
                            <span style="color: #ff6b6b;">CODE NON TROUVÉ</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Copy Button -->
            <div class="text-center mb-8">
                <button onclick="copierCode()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                    <i class="fas fa-copy mr-2"></i>
                    Copier le code
                </button>
                <div id="copyMessage" class="mt-3 text-green-600 font-medium hidden">
                    <i class="fas fa-check-circle mr-2"></i>
                    Code copié avec succès!
                </div>
            </div>

            <!-- Instructions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-save text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Sauvegardez ce code</h3>
                    <p class="text-gray-600">Prenez une capture d'écran ou écrivez-le quelque part</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Utilisez-le pour le suivi</h3>
                    <p class="text-gray-600">Entrez ce code sur la page de suivi pour connaître l'état</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('suivi-demande') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 text-center">
                    <i class="fas fa-search mr-2"></i>
                    Suivre ma demande
                </a>
                <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 text-center">
                    <i class="fas fa-home mr-2"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg" data-aos="fade-up" data-aos-delay="400">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Important :</strong> Un email contenant votre code de suivi vous a été envoyé. 
                        Vous pouvez également retrouver votre demande en utilisant le code ci-dessus sur la page de suivi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.success-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

#codeSuivi {
    font-family: 'Courier New', monospace;
    letter-spacing: 0.1em;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.hero-section {
    background: linear-gradient(135deg, #1e5e1e 0%, #2d7d2d 60%, #0a3d0a 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}
</style>

<script>
function copierCode() {
    const codeElement = document.getElementById('codeSuivi');
    const codeText = codeElement.textContent.trim();
    
    navigator.clipboard.writeText(codeText).then(function() {
        const message = document.getElementById('copyMessage');
        message.classList.remove('hidden');
        
        setTimeout(() => {
            message.classList.add('hidden');
        }, 3000);
    }).catch(function(err) {
        // Fallback pour les navigateurs anciens
        const textArea = document.createElement('textarea');
        textArea.value = codeText;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        
        try {
            document.execCommand('copy');
            const message = document.getElementById('copyMessage');
            message.classList.remove('hidden');
            setTimeout(() => {
                message.classList.add('hidden');
            }, 3000);
        } catch (err) {
            console.error('Erreur lors de la copie:', err);
        }
        
        document.body.removeChild(textArea);
    });
}

// Auto-sélection du code au clic
document.getElementById('codeSuivi').addEventListener('click', function() {
    const selection = window.getSelection();
    const range = document.createRange();
    range.selectNodeContents(this);
    selection.removeAllRanges();
    selection.addRange(range);
});
</script>
@endsection
