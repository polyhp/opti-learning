<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $formateur = $user->formateur;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'diploma_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Update User info
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ];

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Le mot de passe actuel est incorrect.');
            }
            $userData['password'] = Hash::make($request->new_password);
        }

        $user->update($userData);

        // Update Formateur docs
        if ($request->hasFile('diploma_file')) {
            $filename = Str::uuid() . '.' . $request->file('diploma_file')->getClientOriginalExtension();
            $path = $request->file('diploma_file')->storeAs("formateur_documents/diplomas", $filename, 'public');
            $formateur->update(['diploma_file' => $path]);
        }

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}
