<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $query = \App\Models\User::query();

        if ($role && in_array($role, ['apprenant', 'formateur', 'admin'])) {
            $query->where('role', $role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'role'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:apprenant,formateur,admin',
        ]);

        \App\Models\User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        \App\Models\AdminActivityLog::log('Création Utilisateur', "A créé l'utilisateur: {$validated['email']} ({$validated['role']})");

        return back()->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateRole(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:apprenant,formateur,admin',
        ]);

        // Prevent self-demotion
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle administrateur.');
        }

        $user->update(['role' => $validated['role']]);

        \App\Models\AdminActivityLog::log('Modification Rôle', "A modifié le rôle de {$user->email} en {$validated['role']}");

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function toggleStatus(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activé' : 'désactivé';

        \App\Models\AdminActivityLog::log('Modification Statut Utilisateur', "Le compte de {$user->email} a été $status.");

        return back()->with('success', "Le compte utilisateur a été $status.");
    }

    public function destroy(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        \App\Models\AdminActivityLog::log('Suppression Utilisateur', "A supprimé le compte de {$user->email}.");

        return back()->with('success', 'Utilisateur supprimé.');
    }
}
