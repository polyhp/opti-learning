<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // Afficher la page d'oubli de mot de passe
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Étape 1: Envoyer le code
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Aucun compte trouvé avec cette adresse email.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        
        // Générer un code aléatoire à 4 chiffres
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Stocker le code dans cache (expiration 10 minutes)
        Cache::put('reset_code_' . $email, $code, now()->addMinutes(10));
        
        // Envoyer la notification
        $user = User::where('email', $email)->first();
        $user->notify(new PasswordResetCodeNotification($code));
        
        return response()->json([
            'success' => true,
            'message' => 'Un code de vérification a été envoyé à votre adresse email.',
            'email' => $email
        ]);
    }

    // Étape 2: Vérifier le code
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $code = $request->code;
        
        // Récupérer le code stocké
        $storedCode = Cache::get('reset_code_' . $email);
        
        if (!$storedCode) {
            return response()->json([
                'success' => false,
                'message' => 'Code expiré ou inexistant. Veuillez renvoyer un nouveau code.'
            ], 422);
        }
        
        if ($storedCode != $code) {
            return response()->json([
                'success' => false,
                'message' => 'Code incorrect. Veuillez réessayer.'
            ], 422);
        }
        
        // Marquer comme vérifié
        Cache::put('reset_code_verified_' . $email, true, now()->addMinutes(10));
        
        return response()->json([
            'success' => true,
            'message' => 'Code vérifié avec succès.',
            'email' => $email
        ]);
    }

    // Étape 3: Réinitialiser le mot de passe
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        
        // Vérifier si le code a été validé
        $isVerified = Cache::get('reset_code_verified_' . $email);
        
        if (!$isVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez d\'abord vérifier votre code.'
            ], 422);
        }
        
        // Mettre à jour le mot de passe
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Nettoyer le cache
        Cache::forget('reset_code_' . $email);
        Cache::forget('reset_code_verified_' . $email);
        
        return response()->json([
            'success' => true,
            'message' => 'Votre mot de passe a été réinitialisé avec succès.',
            'redirect' => route('login')
        ]);
    }

    // Renvoyer le code
    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        
        // Générer un nouveau code
        $code = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        
        // Stocker le nouveau code
        Cache::put('reset_code_' . $email, $code, now()->addMinutes(10));
        
        // Envoyer la notification
        $user = User::where('email', $email)->first();
        $user->notify(new PasswordResetCodeNotification($code));
        
        return response()->json([
            'success' => true,
            'message' => 'Un nouveau code a été envoyé à votre adresse email.'
        ]);
    }
}