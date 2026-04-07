<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Lesson;
use App\Models\CourseQuiz;
use App\Models\QuizAttempt;
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
        
        $forceRetake = $request->has('force_retake');
        
        if ($forceRetake) {
            // Supprimer les anciens essais de quiz pour que l'étudiant reparte de zéro
            $quizIds = $course->quizzes()->pluck('id');
            QuizAttempt::where('user_id', $user->id)
                ->whereIn('course_quiz_id', $quizIds)
                ->delete();
        }
        
        // Vérifier s'il a déjà une commande en cours ou complète
        $existingOrder = Order::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($existingOrder && $existingOrder->status === 'completed' && !$forceRetake) {
            return redirect()->route('apprenant.courses.watch', $course->id);
        }

        if ($existingOrder && $existingOrder->status === 'pending') {
            return redirect()->route('apprenant.payment.show', $existingOrder->id)
                ->with('info', 'Reprise de votre commande en attente.');
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
        
        return redirect()->route('apprenant.payment.show', $order->id);
    }

    /**
     * Simulation de paiement pour le panier
     */
    public function checkoutCart(Request $request)
    {
        $cartIds = session('cart', []);
        
        if (empty($cartIds)) {
            return redirect()->route('cart.index', [], 303)->with('error', 'Votre panier est vide.');
        }
        
        $user = Auth::user();
        $courses = Course::whereIn('id', $cartIds)->get();
        $createdOrders = [];
        
        foreach ($courses as $course) {
            // Vérifier s'il a déjà une commande complète
            $existingOrder = Order::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'completed')
                ->first();
                
            if ($existingOrder) {
                continue; // Déjà acheté
            }

            // Vérifier s'il a déjà une commande en attente
            $pendingOrder = Order::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('status', 'pending')
                ->first();

            $status = $course->price > 0 ? 'pending' : 'completed';

            if (!$pendingOrder) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'amount' => $course->price,
                    'status' => $status,
                ]);
                
                if ($order->status == 'pending') {
                    $createdOrders[] = $order->id;
                }
            } else {
                $createdOrders[] = $pendingOrder->id;
            }
        }
        
        // Vider le panier après la création des commandes
        session()->forget('cart');
        
        if (empty($createdOrders)) {
            $userRole = 'apprenant';
            if ($user->is_super_admin || $user->hasRole('admin')) {
                $userRole = 'admin';
            } elseif ($user->hasRole('formateur')) {
                $userRole = 'formateur';
            }
            return redirect()->route($userRole . '.dashboard')->with('info', 'Toutes les formations de votre panier sont gratuites ou déjà achetées.');
        }
        
        // S'il y a un seul ordre, on utilise la route normale
        if (count($createdOrders) == 1) {
            return redirect()->route('apprenant.payment.show', $createdOrders[0]);
        }
        
        // S'il y a plusieurs ordres, on passe la liste (ex: 15,16) en paramètre HTTP
        $orderIdsStr = implode(',', $createdOrders);
        return redirect()->route('apprenant.payment.show', ['order' => $orderIdsStr]);
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
        
        $completedLessonIds = $user->completedLessons()->whereIn('lesson_id', $course->lessons->pluck('id'))->pluck('lesson_id')->toArray();
        
        $standardQuiz = $course->quizzes->where('type', 'standard')->first();
        $makeupQuiz = $course->quizzes->where('type', 'makeup')->first();

        $standardAttempt = null;
        if ($standardQuiz) {
            $standardAttempt = QuizAttempt::where('user_id', $user->id)
                ->where('course_quiz_id', $standardQuiz->id)
                ->orderByDesc('score')
                ->first();
        }

        $makeupAttempt = null;
        if ($makeupQuiz) {
            $makeupAttempt = QuizAttempt::where('user_id', $user->id)
                ->where('course_quiz_id', $makeupQuiz->id)
                ->orderByDesc('score')
                ->first();
        }
        
        return view('apprenant.courses_watch', compact('course', 'completedLessonIds', 'standardQuiz', 'makeupQuiz', 'standardAttempt', 'makeupAttempt'));
    }

    /**
     * Marquer une leçon comme terminée ou non
     */
    public function completeLesson(Lesson $lesson, Request $request)
    {
        $user = Auth::user();
        $isCompleted = $request->input('completed', true);

        if ($isCompleted) {
            // Utiliser syncWithoutDetaching pour éviter les doublons avec le timestamp
            $user->completedLessons()->syncWithoutDetaching([$lesson->id => ['completed_at' => now()]]);
        } else {
            $user->completedLessons()->detach($lesson->id);
        }

        return response()->json([
            'success' => true,
            'completed' => $isCompleted
        ]);
    }

    /**
     * Soumettre le quiz final
     */
    public function submitQuiz(CourseQuiz $quiz, Request $request)
    {
        $user = Auth::user();
        $answers = $request->except('_token');
        
        $correctAnswersCount = 0;
        $totalQuestions = $quiz->questions()->count();

        if ($totalQuestions === 0) {
            return response()->json(['success' => false, 'message' => 'Aucune question dans ce quiz.']);
        }

        foreach ($quiz->questions as $question) {
            $submittedAnswer = $request->input('q_' . $question->id);
            // submittedAnswer "1" = l'option choisie était "correct"
            if ($submittedAnswer === '1') {
                $correctAnswersCount++;
            }
        }

        $score = round(($correctAnswersCount / $totalQuestions) * 20);
        $passed = $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'course_quiz_id' => $quiz->id,
            'score' => $score,
            'passed' => $passed,
        ]);

        return response()->json([
            'success' => true,
            'score' => $score,
            'passed' => $passed,
            'correct' => $correctAnswersCount,
            'total' => $totalQuestions,
            'message' => $passed ? 'Félicitations, vous avez validé la formation !' : 'Vous n\'avez pas atteint le score requis.'
        ]);
    }
}
