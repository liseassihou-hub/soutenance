<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\CreditType;
use App\Models\Document;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * Afficher le formulaire de connexion client
     */
    public function showLoginForm()
    {
        if (Auth::guard('client')->check()) {
            return redirect()->route('client.dashboard');
        }
        return view('client.login');
    }

    /**
     * Connexion du client avec vérification du statut
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();

            $client = Auth::guard('client')->user();
            
            // Vérifier le statut du client
            if ($client->statut === 'bloque') {
                Auth::guard('client')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                throw ValidationException::withMessages([
                    'email' => 'Votre compte a été bloqué. Veuillez contacter l\'agent.',
                ]);
            }

            return redirect()->route('client.dashboard')
                ->with('success', 'Bienvenue ' . $client->nom_complet . ' !');
        }

        throw ValidationException::withMessages([
            'email' => 'Les identifiants fournis sont incorrects.',
        ]);
    }

    /**
     * Déconnexion du client
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Dashboard client avec affichage du statut
     */
    public function dashboard()
    {
        $client = Auth::guard('client')->user();
        
        // Vérification supplémentaire du statut
        if ($client->statut === 'bloque') {
            Auth::guard('client')->logout();
            return redirect()->route('client.login')
                ->with('error', 'Votre compte a été bloqué. Veuillez contacter l\'agent.');
        }
        
        $stats = [
            'total_demandes' => $client->loanApplications()->count(),
            'demandes_en_cours' => $client->loanApplications()->enAttente()->count(),
            'demandes_acceptees' => $client->loanApplications()->acceptes()->count(),
            'demandes_rejetees' => $client->loanApplications()->rejetes()->count(),
        ];

        $recentApplications = $client->loanApplications()
            ->with('creditType')
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'recentApplications', 'client'));
    }

    /**
     * Profil client avec affichage du statut
     */
    public function profile()
    {
        $client = Auth::guard('client')->user();
        
        // Vérification supplémentaire du statut
        if ($client->statut === 'bloque') {
            Auth::guard('client')->logout();
            return redirect()->route('client.login')
                ->with('error', 'Votre compte a été bloqué. Veuillez contacter l\'agent.');
        }
        
        return view('client.profile', compact('client'));
    }

    public function applications()
    {
        $applications = auth()->user()
            ->loanApplications()
            ->with('creditType')
            ->latest()
            ->paginate(10);

        return view('client.applications.index', compact('applications'));
    }

    public function createApplication()
    {
        $creditTypes = CreditType::active()->get();

        return view('client.applications.create', compact('creditTypes'));
    }

    public function storeApplication(Request $request)
    {
        $request->validate([
            'credit_type_id' => 'required|exists:credit_types,id',
            'montant' => 'required|numeric|min:10000',
            'duree' => 'required|integer|min:1|max:60',
        ]);

        $creditType = CreditType::findOrFail($request->credit_type_id);

        // Validation supplémentaire
        if ($request->montant < $creditType->montant_min) {
            return back()->withErrors(['montant' => 'Le montant minimum pour ce type de crédit est ' . $creditType->formatted_montant_min]);
        }

        if ($request->montant > $creditType->montant_max) {
            return back()->withErrors(['montant' => 'Le montant maximum pour ce type de crédit est ' . $creditType->formatted_montant_max]);
        }

        if ($request->duree > $creditType->duree_max) {
            return back()->withErrors(['duree' => 'La durée maximum pour ce type de crédit est ' . $creditType->duree_max . ' mois']);
        }

        $application = auth()->user()->loanApplications()->create([
            'credit_type_id' => $request->credit_type_id,
            'montant' => $request->montant,
            'duree' => $request->duree,
            'statut' => 'soumis',
        ]);

        return redirect()->route('client.applications')
            ->with('success', 'Demande de crédit soumise avec succès.');
    }

    public function showApplication(LoanApplication $application)
    {
        if ($application->client_id !== auth()->id()) {
            abort(403);
        }

        $application->load(['creditType', 'documents', 'statusHistory.changedByUser']);

        return view('client.applications.show', compact('application'));
    }

    public function editApplication(LoanApplication $application)
    {
        if ($application->client_id !== auth()->id() || $application->statut !== 'soumis') {
            abort(403);
        }

        $creditTypes = CreditType::active()->get();

        return view('client.applications.edit', compact('application', 'creditTypes'));
    }

    public function updateApplication(Request $request, LoanApplication $application)
    {
        if ($application->client_id !== auth()->id() || $application->statut !== 'soumis') {
            abort(403);
        }

        $request->validate([
            'credit_type_id' => 'required|exists:credit_types,id',
            'montant' => 'required|numeric|min:10000',
            'duree' => 'required|integer|min:1|max:60',
        ]);

        $creditType = CreditType::findOrFail($request->credit_type_id);

        // Validation supplémentaire
        if ($request->montant < $creditType->montant_min) {
            return back()->withErrors(['montant' => 'Le montant minimum pour ce type de crédit est ' . $creditType->formatted_montant_min]);
        }

        if ($request->montant > $creditType->montant_max) {
            return back()->withErrors(['montant' => 'Le montant maximum pour ce type de crédit est ' . $creditType->formatted_montant_max]);
        }

        if ($request->duree > $creditType->duree_max) {
            return back()->withErrors(['duree' => 'La durée maximum pour ce type de crédit est ' . $creditType->duree_max . ' mois']);
        }

        $application->update($request->all());

        return redirect()->route('client.applications')
            ->with('success', 'Demande de crédit mise à jour avec succès.');
    }

    public function uploadDocuments(Request $request, LoanApplication $application)
    {
        if ($application->client_id !== auth()->id() || $application->statut !== 'soumis') {
            abort(403);
        }

        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'type_documents.*' => 'required|string|in:pièce_identité,justificatif_domicile,bulletin_salaire,autres',
        ]);

        foreach ($request->file('documents') as $index => $file) {
            if ($file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/documents', $filename);

                Document::create([
                    'loan_application_id' => $application->id,
                    'nom_document' => $file->getClientOriginalName(),
                    'fichier' => $filename,
                    'type_document' => $request->type_documents[$index],
                    'taille_fichier' => $file->getSize(),
                ]);
            }
        }

        return back()->with('success', 'Documents téléchargés avec succès.');
    }

    public function deleteDocument(Document $document)
    {
        $application = $document->loanApplication;
        
        if ($application->client_id !== auth()->id() || $application->statut !== 'soumis') {
            abort(403);
        }

        // Supprimer le fichier
        Storage::delete('public/documents/' . $document->fichier);
        
        // Supprimer l'enregistrement
        $document->delete();

        return back()->with('success', 'Document supprimé avec succès.');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:20',
        ]);

        auth()->user()->update($request->all());

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        return back()->with('success', 'Mot de passe changé avec succès.');
    }
}
