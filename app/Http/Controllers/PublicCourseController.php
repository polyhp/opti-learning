<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicCourseController extends Controller
{
    /**
     * Affiche les détails d'une formation sur l'espace public
     */
    public function show(Course $course)
    {
        // On s'assure que la formation est approuvée
        if ($course->status !== 'approved') {
            abort(404, "Cette formation n'est pas encore disponible.");
        }

        // Charger les relations nécessaires
        $course->load(['category', 'formateur.user', 'lessons']);

        $hasPaid = false;
        
        // Vérification de l'accès
        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->hasRole('admin')) {
                // Les admins ont accès à tout
                $hasPaid = true;
            } elseif ($user->hasRole('formateur')) {
                // Le créateur a accès à sa propre formation
                if ($course->formateur_id == $user->formateur->id) {
                    $hasPaid = true;
                }
            } elseif ($user->hasRole('apprenant')) {
                // Vérifier s'il a une commande validée
                $hasPaid = Order::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->where('status', 'completed') // 'completed' comme statut final simulé
                    ->exists();
            }
        }

        return view('courses.show', compact('course', 'hasPaid'));
    }
}
