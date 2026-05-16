@extends('layouts.app')

@php
    // Force regeneration of CSRF token
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
@endphp

@php
    $creditTypes = [
        'petit-credit-individuel' => 'Petit crédit individuel',
        'credit-scolaire' => 'Crédit scolaire',
        'credit-moyen' => 'Crédit moyen',
        'credit-warrantage' => 'Crédit agricole / warrantage',
        'credit-artisans' => 'Crédit aux artisan',
        'credit-substantiel' => 'Crédit substantiel',
        'individuel' => 'Petit crédit individuel'
    ];
    
    $creditTypeName = $creditTypes[$typeCredit] ?? 'Petit crédit individuel';
    
    // Durées par défaut pour chaque type de crédit
    $defaultDurations = [
        'petit-credit-individuel' => 12,
        'credit-scolaire' => 10,
        'credit-moyen' => 14,
        'credit-warrantage' => 10,
        'credit-artisans' => 24,
        'credit-substantiel' => 36,
        'individuel' => 12
    ];
    
    $defaultDuration = $defaultDurations[$typeCredit] ?? 12;
@endphp

@section('title', 'Fiche de Demande de ' . $creditTypeName . ' - PEBCO BETHESDA')

@push('styles')
<style>
body {
    background: #e5e5e5;
    font-family: Arial, sans-serif;
}

/* CONTENEUR */
.form-paper {
    width: 900px;
    margin: 30px auto;
    background: #fff;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding-top: 20px;
}

/* HEADER VERT */
.form-header {
    background: #1e5e1e;
    color: white;
    padding: 20px;
    text-align: left;
    position: relative;
}

.org-name {
    font-weight: bold;
    font-size: 24px;
}

.org-sub {
    font-size: 16px;
    opacity: 0.9;
}

.form-title {
    font-size: 18px;
    margin-top: 5px;
}

/* META */
.meta-line {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    padding: 15px;
}

.meta-item label {
    display: block;
    font-size: 15px;
    color: #555;
    margin-bottom: 3px;
    font-weight: bold;
}

.meta-item input {
    width: 100%;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* SECTION */
.section-title {
    background: #f3f3f3;
    padding: 6px 15px;
    font-weight: bold;
    font-size: 38px !important;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
}

/* CHAMPS */
.field-row {
    padding: 8px 15px;
    
}

.field-row label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #333;
    font-weight: bold;
}

.field-row input,
.field-row textarea,
.field-row select {
    width: 100%;
    padding: 7px;
    border: 1px solid #ccc;
    outline: none;
    font-family: 'Times New Roman', serif;
}

.fields-2 input,
.fields-2 select,
.fields-2 textarea {
    width: 100%;
    padding: 7px;
    border: 1px solid #ccc;
    outline: none;
    font-family: 'Times New Roman', serif;
    box-sizing: border-box;
}

/* GRID 2 COLONNES */
.fields-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    padding: 10px 15px;
}

.fields-2 .cell label {
    display: block;
    margin-bottom: 5px;
    font-size: 17px;
    font-weight: bold;
}

/* MULTI COLONNES */
.fields-multi input {
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    padding: 6px 8px;
    font-family: 'Times New Roman', serif;
    width: 100%;
    box-sizing: border-box;
}

.fields-multi select {
    border: 1px solid #ccc;
    outline: none;
    font-size: 14px;
    padding: 6px 8px;
    font-family: 'Times New Roman', serif;
    width: 100%;
    box-sizing: border-box;
    background: white;
}

.fields-multi .cell label {
    font-size: 16px;
    margin-bottom: 5px;
    font-weight: bold;
}

/* RADIO */
.check-group {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.check-opt {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 10px;
}

/* TABLE */
.doc-table {
    width: 95%;
    margin: 10px auto;
    border-collapse: collapse;
}

.doc-table th {
    background: #f3f3f3;
}

.doc-table th,
.doc-table td {
    border: 1px solid #ccc;
    padding: 6px;
}

.doc-table input {
    width: 100%;
    border: none;
}

/* PHOTO */
.photo-box {
    border: 2px dashed #ccc;
    height: 180px;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.photo-box input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    z-index: 1;
}

.photo-box .preview {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    filter: brightness(1.05) contrast(1.1) saturate(1.1);
    -webkit-filter: brightness(1.05) contrast(1.1) saturate(1.1);
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
    image-rendering: pixelated;
}

/* TEXTE */
.consent-text {
    padding: 15px;
    font-size: 12px;
    color: #333;
}

/* BOUTONS */
.form-actions {
    display: flex;
    justify-content: space-between;
    padding: 15px;
}

.btn-paper {
    padding: 8px 15px;
    border: none;
    border-radius: 3px;
    background: #ccc;
    cursor: pointer;
}

.btn-submit {
    background: #1e5e1e;
    color: white;
}

/* RADIO ET CHECKBOX */
.radio-group {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.radio-option {
    display: flex;
    align-items: center;
    padding: 8px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.radio-option:hover {
    border-color: #4caf50;
    background: #f1f8e9;
}

.radio-option input[type="radio"] {
    margin-right: 8px;
}

.radio-option.selected {
    border-color: #4caf50;
    background: #e8f5e8;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    .form-container {
        padding: 0 15px;
    }
    
    .form-paper {
        border-radius: 10px;
    }
    
    .form-header {
        padding: 30px 20px;
    }
    
    .org-name {
        font-size: 24px;
    }
    
    .form-title {
        font-size: 18px;
    }
    
    .form-body {
        padding: 25px 20px;
    }
    
    .form-section {
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .row-cols-2,
    .row-cols-3,
    .row-cols-4 {
        grid-template-columns: 1fr;
    }
    
    .photo-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 15px;
        padding: 20px;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .form-header {
        padding: 25px 15px;
    }
    
    .org-name {
        font-size: 20px;
    }
    
    .form-body {
        padding: 20px 15px;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .section-header {
        flex-direction: column;
        text-align: center;
    }
    
    .section-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }
}

/* LOADING SPINNER */
.spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* TOOLTIP */
.tooltip {
    position: relative;
    cursor: help;
}

.tooltip::before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 12px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 1000;
}

.tooltip:hover::before {
    opacity: 1;
}

/* ANIMATIONS ADDITIONNELLES */
.fade-in {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.slide-up {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== IMPRESSION ===== */
@media print {
    body {
        background: white;
    }

    .form-paper {
        border: none;
        width: 100%;
        margin: 0;
        box-shadow: none;
    }

    .form-actions {
        display: none;
    }
    
    .form-section {
        break-inside: avoid;
        box-shadow: none;
        border: 1px solid #ccc;
    }
}

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
    .form-paper { 
        padding: 20px 16px; 
        margin: 12px;
    }

    .fields-2 { 
        grid-template-columns: 1fr; 
    }
    .fields-2 .cell {
        border-right: none;
        border-bottom: 1px solid #000;
    }
    .fields-2 .cell:last-child { 
        border-bottom: none; 
    }

    .fields-multi.cols-4,
    .fields-multi.cols-3 { 
        grid-template-columns: 1fr 1fr; 
    }
    .fields-multi .cell { 
        border-right: none; 
        border-bottom: 1px solid #000; 
    }
    .fields-multi .cell:nth-child(odd) { 
        border-right: 1px solid #000; 
    }
    .fields-multi .cell:last-child { 
        border-bottom: none; 
    }

    .signature-grid { 
        grid-template-columns: 1fr; 
        gap: 24px; 
    }
    .meta-line { 
        gap: 12px 20px; 
    }
    .doc-table { 
        font-size: 11px; 
    }
    .doc-table th, .doc-table td { 
        padding: 4px 6px; 
    }
    
    /* Cases à cocher responsive */
    .fields-2 .cell .check-group,
    .check-group { 
        gap: 6px 12px; 
    }
    .check-opt span { 
        font-size: 11px; 
    }
    
    .btn-paper {
        padding: 8px 20px;
        font-size: 11px;
    }
    
    /* Largeurs fixes pour mobile */
    .meta-line .meta-item label {
        min-width: 60px;
        font-size: 12px;
    }
    .fields-2 .cell > label {
        min-width: 100px;
        font-size: 12px;
    }
    .field-row > label {
        min-width: 150px;
        font-size: 12px;
    }
    .fields-multi .cell > label {
        min-width: 80px;
        font-size: 12px;
    }
}

</style>
@endpush

@section('content')
<div class="form-paper">
    <form action="{{ route('demande.store') }}" method="POST" enctype="multipart/form-data" id="creditForm">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        @if ($errors->any())
            <div style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
                <strong>Erreur de validation :</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER --}}
        <div class="form-header">
            <div class="org-name">P.E.B.Co - BETHESDA</div>
            <div class="org-sub">Association pour la Promotion de l'Épargne-crédit à Base Communautaire</div>
            <div class="form-title">Fiche de Demande de {{ $creditTypeName }}</div>
        </div>

        
        <div class="section-title">I -Information du demandeur </div>
        {{-- META --}}
        <div class="fields-2">
            <div class="cell">
                <label>Numéro de compte <span style="color:red;">*</span></label>
                <input type="text" name="numero_compte" placeholder="A01XXXX" value="{{ old('numero_compte') }}" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <small style="color: #666; font-size: 11px;">Entrez votre numéro de carte jaune ou DAV</small>
                @error('numero_compte')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Agence <span style="color:red;">*</span></label>
                <select name="agence" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">Sélectionnez une agence</option>
                    @if(isset($agences))
                        @foreach($agences as $agence)
                            <option value="{{ $agence->id_agence }}" {{ old('agence') == $agence->id_agence ? 'selected' : '' }}>
                                {{ $agence->nom_agence }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('agence')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        

        <div class="fields-2">
            <div class="cell">
                <label>Nom <span style="color:red;">*</span></label>
                <input type="text" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Prénoms <span style="color:red;">*</span></label>
                <input type="text" name="prenom" value="{{ old('prenom') }}" required>
                @error('prenom')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="fields-2">
            <div class="cell">
                <label>Type de pièce d'identité <span style="color:red;">*</span></label>
                <input type="text" name="piece_identite_type" placeholder="ex : CNI" value="{{ old('piece_identite_type') }}" required>
                @error('piece_identite_type')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Numéro de pièce d'identité <span style="color:red;">*</span></label>
                <input type="text" name="piece_identite_numero" placeholder="ex : 0123456789012" value="{{ old('piece_identite_numero') }}" required>
                @error('piece_identite_numero')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="fields-2">
            <div class="cell">
                <label>Date d'expiration de la pièce</label>
                <input type="date" name="piece_identite_expiration" value="{{ old('piece_identite_expiration') }}">
            </div>
            <div class="cell">
                <label>Adresse personnelle <span style="color:red;">*</span></label>
                <input type="text" name="adresse_personnelle" placeholder="Quartier, maison, lot" value="{{ old('adresse_personnelle') }}" required>
                @error('adresse_personnelle')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="fields-2">
            <div class="cell">
                <label>Téléphone <span style="color:red;">*</span></label>
                <div style="display: flex; align-items: center;">
                    <span style="background: #f5f5f5; padding: 6px 8px; border: 1px solid #ccc; border-right: none; font-family: 'Times New Roman', serif;">+229</span>
                    <input type="tel" name="telephone" placeholder="0146564110" value="{{ old('telephone') }}" required style="border: 1px solid #ccc; outline: none; font-size: 14px; padding: 6px 8px; font-family: 'Times New Roman', serif; width: 100%; box-sizing: border-box;">
                </div>
                @error('telephone')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        

        <div class="section-title">II - Modalités de la Demande</div>

        <!-- Montant et Type crédit -->
        <div class="fields-2">
            <div class="cell">
                <label>Montant (FCFA) <span style="color:red;">*</span></label>
                <input type="number" name="montant_demande" id="montant" min="100" value="{{ old('montant_demande') }}" required>
                @error('montant_demande')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Type crédit <span style="color:red;">*</span></label>
                <select name="type_credit" id="type_credit" required>
                    <option value="">Sélectionnez...</option>
                    @foreach([
                        'Petit crédit individuel',
                        'Crédit aux artisan',
                        'Crédit moyen',
                        'Crédit agricole / warrantage',
                        'Crédit scolaire',
                        'Crédit substantiel'
                    ] as $type)
                    <option value="{{ $type }}" {{ old('type_credit')==$type ? 'selected' : ($creditTypeName==$type ? 'selected' : '') }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('type_credit')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Durée et Périodicité -->

        <div class="fields-2">
            <div class="cell">
                <label>Durée (mois) <span style="color:red;">*</span></label>
                <input type="number" name="duree_mois" id="duree_mois" min="3" max="60" value="{{ old('duree_mois', $defaultDuration) }}" required>
                @error('duree_mois')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Périodicité <span style="color:red;">*</span></label>
                <div class="check-group" id="periodiciteGroup">
                    @foreach(['mensuel','trimestriel','semestriel','annuel'] as $p)
                    <label class="check-opt">
                        <input type="radio" name="periodicite" value="{{ $p }}" {{ old('periodicite',$p=='mensuel'?'mensuel':'') == $p ? 'checked' : '' }} required>
                        <span>{{ ucfirst($p) }}</span>
                    </label>
                    @endforeach
                </div>
                @error('periodicite')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Objet et Description de l'activité -->
        <div class="fields-2">
            <div class="cell">
                <label>Objet du prêt <span style="color:red;">*</span></label>
                <textarea name="objet_pret" rows="5" required>{{ old('objet_pret') }}</textarea>
                @error('objet_pret')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
            <div class="cell">
                <label>Description de l'activité <span style="color:red;">*</span></label>
                <textarea name="description_activite" rows="5" required>{{ old('description_activite') }}</textarea>
                @error('description_activite')
                    <span style="color:red; font-size:11px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

          
        <div class="section-title">Photos</div>

        <div class="fields-2 photo-section close-border">
            <div class="cell">
                <label>Votre photo <span style="color:red;">*</span></label>
                <div class="photo-box" id="areaPersonnelle">
                    <input type="file" name="photo_personnelle" id="photo_personnelle" accept="image/jpeg,image/jpg,image/png" onchange="previewPhoto(this,'previewPersonnelle')">
                    <div>PHOTO</div>
                    <img id="previewPersonnelle" class="preview" alt="Aperçu photo personnelle">
                </div>
                <small style="color:#666; font-size:11px;">Formats: JPEG, JPG, PNG | Max: 1MB</small>
                            </div>
            <div class="cell">
                <label>Photo de la pièce d'identité <span style="color:red;">*</span></label>
                <div class="photo-box" id="areaCarte">
                    <input type="file" name="photo_piece_identite" id="photo_piece_identite" accept="image/jpeg,image/jpg,image/png" onchange="previewPhoto(this,'previewCarte')">
                    <div>PHOTO PIÈCE D'IDENTITÉ</div>
                    <img id="previewCarte" class="preview" alt="Aperçu carte d'identité">
                </div>
                <small style="color:#666; font-size:11px;">Formats: JPEG, JPG, PNG | Max: 1MB</small>
                            </div>
        </div>


        <div class="form-actions">
            <a href="{{ route('home') }}" class="btn-paper">
                <-
            </a>
            <button type="submit" class="btn-paper btn-submit">
                Soumettre la demande
            </button>
        </div>

    </form>
    <script>
        // Simple CSRF token validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('creditForm');
            const tokenInput = form.querySelector('input[name="_token"]');
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                // Double-check token before submission
                if (!tokenInput.value || tokenInput.value.length < 10) {
                    e.preventDefault();
                    alert('Erreur de sécurité. Veuillez rafraîchir la page.');
                    return false;
                }
            });
        });
    </script>
</div>
@endsection

@push('scripts')
<script>

// Durées maximales et par défaut par type de crédit
const dureesMaximales = {
    'Petit crédit individuel': 12,
    'Crédit scolaire': 10,
    'Crédit substantiel': 36,
    'Crédit aux artisan': 24,
    'Crédit agricole / warrantage': 10,
    'Crédit moyen': 14
};

const dureesDefaut = {
    'Petit crédit individuel': 12,
    'Crédit scolaire': 10,
    'Crédit substantiel': 36,
    'Crédit aux artisan': 24,
    'Crédit agricole / warrantage': 10,
    'Crédit moyen': 14
};

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const typeCredit = document.getElementById('type_credit');
    const dureeMois = document.getElementById('duree_mois');
    
    // Si un type de crédit est pré-sélectionné, ajuster la durée
    if (typeCredit.value) {
        updateDuration(typeCredit.value);
    }
});

// Mettre à jour la durée quand le type de crédit change
function updateDuration(typeCredit) {
    const dureeInput = document.getElementById('duree_mois');
    
    if (dureesMaximales[typeCredit]) {
        dureeInput.max = dureesMaximales[typeCredit];
        console.log('Durée maximale mise à jour:', dureesMaximales[typeCredit]);
    }
    
    if (dureesDefaut[typeCredit] && !dureeInput.value || dureeInput.value == 12) {
        dureeInput.value = dureesDefaut[typeCredit];
        console.log('Durée par défaut mise à jour:', dureesDefaut[typeCredit]);
    }
}

// Écouteur d'événement pour le changement de type de crédit
document.addEventListener('DOMContentLoaded', function() {
    const typeCreditSelect = document.getElementById('type_credit');
    
    if (typeCreditSelect) {
        typeCreditSelect.addEventListener('change', function() {
            updateDuration(this.value);
        });
    }
});

// Photo preview
function previewPhoto(input, previewId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById(previewId);
        img.src = e.target.result;
        img.style.display = 'block';
        const area = input.closest('.photo-box');
        area.querySelector('div').style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush