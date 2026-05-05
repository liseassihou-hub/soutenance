<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;

class AgentProfileController extends Controller
{
    /**
     * Afficher le profil de l'agent
     */
    public function show()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.profile', compact('agent'));
    }

    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $agent = Auth::guard('agent')->user();
        return view('agent.profile-edit', compact('agent'));
    }

    /**
     * Mettre à jour le profil de l'agent
     */
    public function update(Request $request)
    {
        try {
            $agent = Auth::guard('agent')->user();
            
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'sexe' => 'required|in:M,F',
                'email' => 'required|email|unique:agents,email,' . $agent->id,
            ]);

            $agent->update($validated);

            return redirect()->route('agent.profile')
                ->with('success', 'Profil mis à jour avec succès !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil.');
        }
    }

    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function showPasswordForm()
    {
        return view('agent.change-password');
    }

    /**
     * Changer le mot de passe de l'agent
     */
    public function changePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
                'password_confirmation' => 'required|string'
            ]);

            $agent = Auth::guard('agent')->user();

            // Vérifier l'ancien mot de passe
            if (!Hash::check($validated['current_password'], $agent->password)) {
                return back()
                    ->with('error', 'L\'ancien mot de passe est incorrect.');
            }

            // Mettre à jour le mot de passe
            $agent->update([
                'password' => Hash::make($validated['password']),
                'must_change_password' => false
            ]);

            return redirect()->route('agent.profile')
                ->with('success', 'Mot de passe changé avec succès !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors());
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Une erreur est survenue lors du changement de mot de passe.');
        }
    }
}
