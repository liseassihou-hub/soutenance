<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PEBCo BETHESDA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #1d6d1d 0%, #147749 100%); }
        .login-container { max-width: 400px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="login-container bg-white rounded-lg shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-800">PEBCo BETHESDA</h1>
            <p class="text-green-600">Association pour la Promotion de l'Épargne-crédit à Base Communautaire</p>
        </div>

        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                       placeholder="votre@email.com" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="mot_de_passe" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <div class="relative">
                    <input type="password" id="mot_de_passe" name="mot_de_passe" 
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" 
                           placeholder="••••••" required>
                    <button type="button" onclick="togglePassword('mot_de_passe')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-600 hover:text-green-800 focus:outline-none">
                        <i id="mot_de_passe-icon" class="fas fa-eye-slash"></i>
                    </button>
                </div>
                @error('mot_de_passe')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <button type="submit" 
                        class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
                    Se connecter
                </button>
            </div>

            <div class="text-center -mt-2 mb-6">
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-green-700 hover:text-green-900 transition-colors">
                    Mot de passe oublié ?
                </a>
            </div>

            @error('email')
                <div class="text-red-500 text-sm text-center mb-4">
                    {{ $message }}
                </div>
            @endif

            @if(session('error'))
                <div class="text-red-500 text-sm text-center mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="text-green-500 text-sm text-center mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </form>
        
        <!-- Lien retour à l'accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors">
                <i class="fas fa-arrow-left mr-1"></i>Retour à l'accueil
            </a>
        </div>
    </div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    }
}
</script>
</body>
</html>
