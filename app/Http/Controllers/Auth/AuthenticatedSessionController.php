<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirection basée sur le rôle
            $user = Auth::user();
            
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('formateur')) {
                return redirect()->route('formateur.dashboard');
            } else {
                return redirect()->route('apprenant.dashboard');
            }
        }

        throw ValidationException::withMessages([
            'email' => __('Les identifiants fournis ne correspondent pas à nos enregistrements.'),
        ]);
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}