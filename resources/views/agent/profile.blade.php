@extends('layouts.app')

@section('title', 'Profil Agent')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>
                        <i class="fas fa-user me-2"></i>Mon Profil
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="avatar-circle bg-info text-white d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 50%; font-size: 3rem;">
                                {{ strtoupper(substr(Auth::guard('agent')->user()->nom, 0, 1)) }}{{ strtoupper(substr(Auth::guard('agent')->user()->prenom, 0, 1)) }}
                            </div>
                            <h5 class="mt-3">{{ Auth::guard('agent')->user()->nom }} {{ Auth::guard('agent')->user()->prenom }}</h5>
                            <p class="text-muted">{{ Auth::guard('agent')->user()->email }}</p>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nom:</strong></td>
                                    <td>{{ Auth::guard('agent')->user()->nom }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Prénom:</strong></td>
                                    <td>{{ Auth::guard('agent')->user()->prenom }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Sexe:</strong></td>
                                    <td>{{ Auth::guard('agent')->user()->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ Auth::guard('agent')->user()->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date de création:</strong></td>
                                    <td>{{ Auth::guard('agent')->user()->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('agent.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Modifier mon profil
                        </a>
                        <a href="{{ route('agent.change-password') }}" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>Changer mot de passe
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
