@extends('layouts.app')

@section('title', 'Changement de Mot de Passe')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white text-center">
                    <h4>
                        <i class="fas fa-exclamation-triangle me-2"></i>Changement de Mot de Passe Obligatoire
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('agent.change-password.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="current_password" 
                                       name="current_password" required>
                            </div>
                            @error('current_password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" class="form-control" id="password" 
                                       name="password" required minlength="8">
                            </div>
                            <small class="text-muted">Minimum 8 caractères</small>
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" class="form-control" id="password_confirmation" 
                                       name="password_confirmation" required>
                            </div>
                            @error('password_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
