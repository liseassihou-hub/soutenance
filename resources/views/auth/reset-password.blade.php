<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Nouveau mot de passe - PEBCo BETHESDA</title>
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
				<p class="text-green-600">Définir un nouveau mot de passe</p>
			</div>

			<form method="POST" action="{{ route('password.reset') }}">
				@csrf
				<input type="hidden" name="token" value="{{ $token }}">
				<input type="hidden" name="email" value="{{ $email }}">
				<input type="hidden" name="guard" value="{{ $guard }}">

				<div class="mb-4">
					<label for="password" class="block text-gray-700 text-sm font-bold mb-2">Nouveau mot de passe</label>
					<input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="••••••••" required minlength="8">
					@error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
				</div>

				<div class="mb-6">
					<label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmer le mot de passe</label>
					<input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="••••••••" required minlength="8">
				</div>

				@error('token')
                    <div
                        class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md mb-4 text-sm">{{ $message }}
                    </div>
                @enderror

				<div class="mb-6">
					<button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
						Mettre à jour le mot de passe
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
