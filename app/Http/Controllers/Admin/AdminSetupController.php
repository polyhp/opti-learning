<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSetupController extends Controller
{
    public function show(\App\Models\User $user)
    {
        if ($user->is_active) {
            return redirect()->route('login')->with('info', 'Ce compte a déjà été configuré.');
        }

        return view('admin.setup', compact('user'));
    }

    public function confirm(Request $request, \App\Models\User $user)
    {
        if ($user->is_active) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date|before_or_equal:today',
            'phone' => 'required|string|max:20',
            'residence' => 'required|string|max:255',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'],
            'residence' => $validated['residence'],
            'is_active' => true,
            'email_verified_at' => now(), // Assume email is verified since they clicked the link
        ]);

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard')->with('success', 'Votre compte a été configuré avec succès.');
    }
}
