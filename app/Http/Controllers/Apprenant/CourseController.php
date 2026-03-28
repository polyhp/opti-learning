<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Simulation de paiement
     */
    public function checkout(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);
        
        $course = Course::findOrFail($request->course_id);
        $user = Auth::user();
        
        // Vérifier s'il a déjà une commande en cours ou complète
        $existingOrder = Order::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($existingOrder && $existingOrder->status === 'completed') {
            return redirect()->route('apprenant.courses.watch', $course->id);
        }

        if ($existingOrder && $existingOrder->status === 'pending') {
            return redirect()->route('courses.show', $course->id)
                ->with('info', 'Votre commande est toujours en attente de paiement.');
        }

        // Le statut dépend du prix (gratuit = complété, sinon = en attente)
        $status = $course->price > 0 ? 'pending' : 'completed';

        $order = Order::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => $status,
        ]);
        
        if ($course->price == 0) {
            return redirect()->route('apprenant.courses.watch', $course->id)
                ->with('success', 'Inscription réussie à cette formation gratuite !');
        }
        
        return redirect()->route('courses.show', $course->id)
            ->with('info', 'Commande enregistrée. L\'intégration du système de paiement est en cours de développement.');
    }

    /**
     * Interface de visionnage
     */
    public function watch(Course $course)
    {
        $user = Auth::user();
        
        // Vérification de sécurité drastique
        $hasAccess = false;
        
        if ($user->hasRole('admin')) {
            $hasAccess = true;
        } elseif ($user->hasRole('formateur')) {
            // Si c'est SON cours
            if ($user->formateur && $course->formateur_id == $user->formateur->id) {
                $hasAccess = true;
            }
        }
        
        if (!$hasAccess) {
            // Pour l'apprenant, on vérifie la commande
            $hasPaid = Order::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'completed')
                ->exists();
                
            if (!$hasPaid) {
                return redirect()->route('courses.show', $course->id)
                    ->with('error', 'Vous devez acheter cette formation pour avoir accès aux vidéos.');
            }
        }
        
        $course->load(['lessons', 'quizzes.questions.options']);
        
        return view('apprenant.courses_watch', compact('course'));
    }
}
