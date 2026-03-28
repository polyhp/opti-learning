<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprenantRegisterRequest;
use App\Http\Requests\FormateurRegisterRequest;
use App\Models\User;
use App\Models\Formateur;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Afficher la page de choix du rôle
     */
    public function create()
    {
        return view('auth.choose-role');
    }

    /**
     * Afficher le formulaire d'inscription apprenant
     */
    public function createApprenant()
    {
        return view('auth.register-apprenant');
    }

    /**
     * Afficher le formulaire d'inscription formateur
     */
    public function createFormateur()
    {
        return view('auth.register-formateur');
    }

    /**
     * Traiter l'inscription apprenant
     */
    public function storeApprenant(ApprenantRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'is_active' => true,
        ]);

        // Assigner le rôle apprenant
        $user->assignRole('apprenant');

        event(new Registered($user));

        // Connexion automatique après l'inscription
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Inscription réussie ! Bienvenue sur votre tableau de bord.');
    }

    /**
     * Traiter l'inscription formateur
     */
    public function storeFormateur(FormateurRegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'is_active' => true,
            'role' => 'formateur',
        ]);

        // Gestion des fichiers
        $diplomaPath = $this->uploadFile($request->file('diploma_file'), 'diplomas');
        $idCardPath = $this->uploadFile($request->file('id_card_file'), 'id_cards');
        $certificatePath = $request->hasFile('certificate_file') 
            ? $this->uploadFile($request->file('certificate_file'), 'certificates') 
            : null;

        $formateur = Formateur::create([
            'user_id' => $user->id,
            'expertise_domain' => $request->expertise_domain,
            'diploma_file' => $diplomaPath,
            'id_card_file' => $idCardPath,
            'certificate_file' => $certificatePath,
            'validation_status' => 'approved',
            'validated_at' => now(),
        ]);

        // Assigner le rôle formateur
        $user->assignRole('formateur');

        event(new Registered($user));

        // Connexion automatique après l'inscription
        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Inscription réussie ! Bienvenue sur votre tableau de bord formateur.');
    }

    /**
     * Upload de fichier
     */
    private function uploadFile($file, $folder)
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("formateur_documents/{$folder}", $filename, 'public');
        return $path;
    }
}