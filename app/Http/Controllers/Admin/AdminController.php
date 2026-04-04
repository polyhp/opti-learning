<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function create()
    {
        abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé.');
        return view('admin.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé.');

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'permissions' => 'nullable|array',
            'is_super_admin' => 'nullable|boolean',
        ]);

        $user = \App\Models\User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
            'role' => 'admin',
            'is_active' => false,
            'is_super_admin' => $request->boolean('is_super_admin'),
        ]);

        $user->assignRole('admin');
        
        if (!empty($validated['permissions'])) {
            $user->syncPermissions($validated['permissions']);
        }

        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'admin.setup', now()->addHours(48), ['user' => $user->id]
        );

        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AdminInvitationMail($user, $url));

        \App\Models\AdminActivityLog::log('Invitation Administrateur', "A invité {$user->email} en tant qu'administrateur.");

        return redirect()->route('admin.users.index')->with('success', 'Invitation envoyée à l\'administrateur.');
    }

    public function editProfile()
    {
        return view('admin.profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        \App\Models\AdminActivityLog::log('Mise à jour Profil', "A mis à jour son profil administrateur.");

        return redirect()->route('admin.profile.edit')->with('success', 'Profil mis à jour avec succès.');
    }
    public function logs(Request $request)
    {
        abort_if(!auth()->user()->is_super_admin, 403, 'Accès non autorisé.');

        $query = \App\Models\AdminActivityLog::with('user')->latest();
        
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->paginate(20)->withQueryString();
        $date = $request->date;

        return view('admin.logs.index', compact('logs', 'date'));
    }
}
