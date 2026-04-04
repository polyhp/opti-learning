<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('search');
        $query = \App\Models\User::query();

        if ($role && in_array($role, ['apprenant', 'formateur', 'admin'])) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:apprenant,formateur,admin,super_admin',
        ]);

        $isSuperAdmin = false;
        $role = $validated['role'];
        if ($role === 'super_admin') {
            abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé.');
            $isSuperAdmin = true;
            $role = 'admin';
        }

        \App\Models\User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $role,
            'is_super_admin' => $isSuperAdmin,
            'is_active' => true,
        ]);

        \App\Models\AdminActivityLog::log('Création Utilisateur', "A créé l'utilisateur: {$validated['email']} ({$validated['role']})");

        return back()->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(\App\Models\User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        \App\Models\AdminActivityLog::log('Mise à jour Utilisateur', "A mis à jour le profil de l'utilisateur: {$user->email}");

        return redirect()->route('admin.users.index')->with('success', 'Profil utilisateur mis à jour avec succès.');
    }

    public function updateRole(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:apprenant,formateur,admin,super_admin',
        ]);

        // Prevent self-demotion
        if ($user->id === auth()->id() && !in_array($validated['role'], ['admin', 'super_admin'])) {
            return back()->with('error', 'Vous ne pouvez pas modifier votre propre rôle administrateur.');
        }

        if ($validated['role'] === 'super_admin') {
            abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé.');
            $user->update(['role' => 'admin', 'is_super_admin' => true]);
        } else {
            $updateData = ['role' => $validated['role']];
            if (auth()->user()->is_super_admin) {
                $updateData['is_super_admin'] = false;
            }
            $user->update($updateData);
        }

        \App\Models\AdminActivityLog::log('Modification Rôle', "A modifié le rôle de {$user->email} en {$validated['role']}");

        return back()->with('success', 'Rôle mis à jour.');
    }

    public function updatePermissions(Request $request, \App\Models\User $user)
    {
        abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé. Seul le super admin peut faire ceci.');

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:manage-users,manage-courses,manage-payments',
        ]);

        if ($user->role !== 'admin' && !$user->is_super_admin) {
            return back()->with('error', 'Vous ne pouvez définir des accès que pour les administrateurs.');
        }

        $user->syncPermissions($validated['permissions'] ?? []);

        \App\Models\AdminActivityLog::log('Modification Accès', "A modifié les privilèges de l'administrateur: {$user->email}");

        return back()->with('success', 'Accès administrateur mis à jour avec succès.');
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
