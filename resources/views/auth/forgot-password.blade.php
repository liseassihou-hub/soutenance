<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Mot de passe oublié - PEBCo BETHESDA</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<style>
			body {
				background: linear-gradient(135deg, #1d6d1d 0%, #147749 100%);
			}
			.reset-container {
				max-width: 460px;
			}
		</style>
	</head>
	<body class="min-h-screen flex items-center justify-center px-4">
		<div class="reset-container bg-white rounded-lg shadow-xl p-8 w-full">
			<div class="text-center mb-8">
				<h1 class="text-3xl font-bold text-green-800">PEBCo BETHESDA</h1>
				<p class="text-green-600">Réinitialisation de mot de passe</p>
			</div>

			<p class="text-sm text-gray-600 mb-6 text-center">
				Saisissez votre adresse email. Un lien de réinitialisation sera envoyé via Maildev.
			</p>

			@if(session('status'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-6 text-sm">{{ session('status') }}
                </div>
            @endif

			<form method="POST" action="{{ route('password.email') }}">
				@csrf
				<div class="mb-6">
					<label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
					<input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="votre@email.com" required>
					@error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
				</div>

				<div class="mb-6">
					<button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
						Envoyer le lien de réinitialisation
					</button>
				</div>
			</form>

			<div class="text-center mt-6">
				<a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors">
					<i class="fas fa-arrow-left mr-1"></i>Retour à la connexion
				</a>
			</div>
		</div>
	</body>
</html>
