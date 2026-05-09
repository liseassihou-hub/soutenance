<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Agent;
use App\Models\PasswordResetToken;
use App\Notifications\PasswordResetLinkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    private const RESET_TOKEN_TTL_MINUTES = 60;

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
        ]);

        $account = $this->findAccountByEmail($validated['email']);

        if ($account === null) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Aucun compte ne correspond à cette adresse email.',
                ]);
        }

        $token = Str::random(64);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $validated['email'],
                'guard' => $account['guard'],
            ],
            [
                'token' => hash('sha256', $token),
                'expires_at' => now()->addMinutes(self::RESET_TOKEN_TTL_MINUTES),
                'created_at' => now(),
            ]
        );

        $account['model']->notify(new PasswordResetLinkNotification(
            $token,
            $account['guard'],
            $validated['email']
        ));

        return back()->with('status', 'Un lien de réinitialisation a été envoyé si le compte existe. Vérifiez Maildev.');
    }

    public function showResetForm(Request $request, string $token)
    {
        $guard = $request->query('guard');
        $email = $request->query('email');

        if (! $guard || ! $email) {
            abort(404);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
            'guard' => $guard,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'guard' => ['required', 'in:admin,agent'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'guard.required' => 'Le type de compte est obligatoire',
            'guard.in' => 'Le type de compte est invalide',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ]);

        $resetToken = PasswordResetToken::query()
            ->where('email', $validated['email'])
            ->where('guard', $validated['guard'])
            ->first();

        if ($resetToken === null || ! hash_equals($resetToken->token, hash('sha256', $validated['token'])) || $resetToken->expires_at->isPast()) {
            return back()->withErrors([
                'token' => 'Ce lien de réinitialisation est invalide ou expiré.',
            ]);
        }

        if ($validated['guard'] === 'admin') {
            $account = Admin::where('email', $validated['email'])->first();

            if ($account === null) {
                return back()->withErrors([
                    'email' => 'Compte introuvable.',
                ]);
            }

            $account->mot_de_passe = Hash::make($validated['password']);
            $account->save();
        } else {
            $account = Agent::where('email', $validated['email'])->first();

            if ($account === null) {
                return back()->withErrors([
                    'email' => 'Compte introuvable.',
                ]);
            }

            $account->password = Hash::make($validated['password']);
            $account->save();
        }

        $resetToken->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Votre mot de passe a été réinitialisé. Vous pouvez maintenant vous connecter.');
    }

    private function findAccountByEmail(string $email): ?array
    {
        $admin = Admin::where('email', $email)->first();

        if ($admin !== null) {
            return [
                'guard' => 'admin',
                'model' => $admin,
            ];
        }

        $agent = Agent::where('email', $email)->first();

        if ($agent !== null) {
            return [
                'guard' => 'agent',
                'model' => $agent,
            ];
        }

        return null;
    }
}