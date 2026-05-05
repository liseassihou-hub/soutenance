@extends('layouts.app')

@section('content')

<style>
    /* Styles pour la fenêtre popup */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .popup-content {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        max-width: 450px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.4s ease;
    }

    .code-display {
        background: #f0f9ff;
        border: 2px solid #0ea5e9;
        border-radius: 10px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        font-family: 'Courier New', monospace;
        font-size: 1.8rem;
        font-weight: bold;
        color: #0369a1;
        letter-spacing: 2px;
    }

    .copy-btn {
        background: linear-gradient(135deg, #0ea5e9, #0284c7);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .copy-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(14, 165, 233, 0.4);
    }

    .close-btn {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        margin-left: 0.5rem;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        background: #dc2626;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { 
            opacity: 0;
            transform: translateY(50px);
        }
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }

    .warning-text {
        color: #dc2626;
        font-weight: 600;
        margin: 1rem 0;
        font-size: 0.9rem;
    }

    .success-icon {
        color: #10b981;
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    .suivi-page {
        min-height: 100vh;
        padding: 1rem;
        padding-top: 100px;
        background: #ffffff;
        position: relative;
    }

    /* Arrière-plan animé dégradé */
    .bg-animated {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: -1;
        background: linear-gradient(135deg, #1e5e1e, #065f46, #0a3d2e, #1a6b3a, #0d4f20);
        background-size: 400% 400%;
        animation: gradientShift 8s ease infinite;
    }

    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Bulles flottantes */
    .bubbles {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 1;
        overflow: hidden;
    }

    .bubble {
        position: absolute;
        bottom: -150px;
        background: rgba(255, 255, 255, 0.06);
        border-radius: 50%;
        animation: floatUp linear infinite;
    }

    .bubble:nth-child(1)  { width: 40px;  height: 40px;  left: 10%; animation-duration: 8s;  animation-delay: 0s; }
    .bubble:nth-child(2)  { width: 20px;  height: 20px;  left: 20%; animation-duration: 12s; animation-delay: 2s; }
    .bubble:nth-child(3)  { width: 60px;  height: 60px;  left: 35%; animation-duration: 10s; animation-delay: 4s; }
    .bubble:nth-child(4)  { width: 80px;  height: 80px;  left: 50%; animation-duration: 7s;  animation-delay: 0s; }
    .bubble:nth-child(5)  { width: 25px;  height: 25px;  left: 65%; animation-duration: 11s; animation-delay: 3s; }
    .bubble:nth-child(6)  { width: 50px;  height: 50px;  left: 75%; animation-duration: 9s;  animation-delay: 1s; }
    .bubble:nth-child(7)  { width: 35px;  height: 35px;  left: 88%; animation-duration: 13s; animation-delay: 5s; }
    .bubble:nth-child(8)  { width: 15px;  height: 15px;  left: 5%;  animation-duration: 6s;  animation-delay: 2s; }
    .bubble:nth-child(9)  { width: 70px;  height: 70px;  left: 45%; animation-duration: 14s; animation-delay: 7s; }
    .bubble:nth-child(10) { width: 30px;  height: 30px;  left: 90%; animation-duration: 10s; animation-delay: 4s; }

    @keyframes floatUp {
        0%   { transform: translateY(0) rotate(0deg);        opacity: 0.6; }
        100% { transform: translateY(-110vh) rotate(720deg); opacity: 0;   }
    }

    /* Carte */
    .suivi-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 450px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 2.5rem 2rem;
        animation: cardAppear 0.6s ease-out;
    }

    @keyframes cardAppear {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Icône cercle pulsante */
    .icon-circle {
        width: 64px;
        height: 64px;
        background: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1);    box-shadow: 0 0 0 0   rgba(34, 197, 94, 0.3); }
        50%       { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);   }
    }

    /* Input */
    .code-input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        outline: none;
        transition: all 0.2s;
    }

    .code-input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }

    /* Bouton */
    .btn-submit {
        width: 100%;
        background: #16a34a;
        color: white;
        font-weight: 700;
        padding: 0.65rem 1rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .btn-submit:hover {
        background: #15803d;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.35);
    }

    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
</style>

<div class="suivi-page">
    <div class="bg-animated"></div>
    <div class="bubbles">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- Wrapper pour centrer le contenu principal -->
    <div style="min-height: calc(100vh - 200px); display: flex; align-items: center; justify-content: center;">
        <div class="suivi-container">

       
        <div class="text-center mb-8">
            <div class="icon-circle">
                <i class="fas fa-search text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-green-800">PEBCo BETHESDA</h1>
            <p class="text-green-600 text-sm mt-1">Suivi de votre demande de crédit</p>
        </div>

 
        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 text-blue-600 rounded-md px-4 py-3 mb-4 text-sm flex items-center gap-2">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>
        @endif

       
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 rounded-md px-4 py-3 mb-4 text-sm flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('error') }}
            </div>
        @endif
      


       
        <form method="POST" action="{{ route('suivi.rechercher') }}" id="suivi-form">
            @csrf

            <div class="mb-4">
                <label for="code_dossier" class="block text-gray-700 text-base font-bold mb-2">
                    Code Dossier
                </label>
                <input
                    type="text"
                    id="code_dossier"
                    name="code_dossier"
                    value="{{ old('code_dossier') }}"
                    placeholder="Ex: PEB-2025000001"
                    required
                    autocomplete="off"
                    class="code-input"
                >
                @error('code_dossier')
                    <p class="text-red-500 text-xs mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <button type="submit" id="submit-btn" class="btn-submit">
                    <i class="fas fa-search"></i>
                    Rechercher ma demande
                </button>
            </div>
        </form>

        <p class="text-center text-gray-400 text-xs mt-2">
            <i class="fas fa-info-circle mr-1"></i>
            Entrez le code reçu lors de la soumission de votre dossier
        </p>
        <p class="text-center text-gray-400 text-xs mt-2">
            <i class="fas fa-info-circle mr-1"></i>
            Si code oublié cliquer sur  
            <a href="{{ route('recuperation') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition duration-200">
                <i class="fas fa-arrow-right mr-1"></i>
                Code oublié ?
            </a>
        </p>

       
        <div class="text-center mt-5">
            <a href="{{ route('home') }}" class="text-green-600 hover:text-green-800 text-sm font-medium transition duration-200">
                <i class="fas fa-arrow-left mr-1"></i>
                Retour à l'accueil
            </a>
        </div>

        <div class="text-center mt-5">
           
        </div>

    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const codeInput = document.getElementById('code_dossier');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('suivi-form');

            if (codeInput) {
                codeInput.focus();
                codeInput.addEventListener('input', function () {
                    this.value = this.value.toUpperCase().replace(/\s/g, '');
                });
            }

            if (form) {
                form.addEventListener('submit', function () {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Recherche en cours...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>

<!-- Fenêtre popup pour le code de dossier -->
@if(session('code_dossier'))
<div id="codePopup" class="popup-overlay">
    <div class="popup-content">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h2 style="color: #1f2937; margin-bottom: 1rem; font-size: 1.5rem;">
            Félicitations ! Votre demande a été enregistrée
        </h2>
        
        <p style="color: #6b7280; margin-bottom: 1.5rem;">
            Voici votre code de dossier unique. Conservez-le précieusement pour suivre votre demande.
        </p>
        
        <div class="code-display" id="codeText">
            {{ session('code_dossier') }}
        </div>
        
        <div class="warning-text">
            <i class="fas fa-exclamation-triangle"></i>
            IMPORTANT : Sauvegardez ce code immédiatement !
        </div>
        
        <p style="color: #6b7280; font-size: 0.85rem; margin: 1rem 0;">
            Vous pouvez copier ce code en cliquant sur le bouton ci-dessous.
        </p>
        
        <div style="margin-top: 1.5rem;">
            <button class="copy-btn" onclick="copyCode()">
                <i class="fas fa-copy"></i>
                Copier le code
            </button>
            <button class="close-btn" onclick="closePopup()">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
function copyCode() {
    const codeText = document.getElementById('codeText').innerText;
    
    // Copier dans le presse-papiers
    navigator.clipboard.writeText(codeText).then(function() {
        // Changer le bouton temporairement
        const btn = event.target;
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i> Code copié !';
        btn.style.background = 'linear-gradient(135deg, #10b981, #059669)';
        
        // Revenir au bouton original après 2 secondes
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.style.background = 'linear-gradient(135deg, #0ea5e9, #0284c7)';
        }, 2000);
        
        // Afficher une notification
        showNotification('Code copié avec succès !');
        
    }).catch(function(err) {
        // Fallback pour les navigateurs plus anciens
        const textArea = document.createElement("textarea");
        textArea.value = codeText;
        textArea.style.position = "fixed";
        textArea.style.opacity = "0";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showNotification('Code copié avec succès !');
        } catch (err) {
            showNotification('Erreur lors de la copie', 'error');
        }
        
        document.body.removeChild(textArea);
    });
}

function closePopup() {
    const popup = document.getElementById('codePopup');
    popup.style.animation = 'fadeOut 0.3s ease';
    
    setTimeout(function() {
        popup.style.display = 'none';
    }, 300);
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        font-weight: 500;
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(function() {
        notification.style.animation = 'fadeOut 0.3s ease';
        setTimeout(function() {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Ajouter les animations CSS manquantes
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @keyframes slideInRight {
        from { 
            opacity: 0;
            transform: translateX(100px);
        }
        to { 
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);

// Fermer automatiquement après 30 secondes
setTimeout(function() {
    const popup = document.getElementById('codePopup');
    if (popup && popup.style.display !== 'none') {
        closePopup();
    }
}, 30000);
</script>
@endif
    </div>
</div>

@endsection
