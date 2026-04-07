<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Order;
use App\Models\QuizAttempt;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $formateur = $user->formateur;
        
        if (!$formateur) {
            abort(403, 'Profil formateur introuvable.');
        }

        // Statistiques
        $totalCourses = Course::where('formateur_id', $formateur->id)->count();
        
        // Formations récentes
        $recentCourses = Course::where('formateur_id', $formateur->id)
            ->withCount('lessons')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Apprenants ayant payé (Orders liés aux courses du formateur, statut completed ou success)
        // Note: Selon le modèle Order, un Order pointe vers un Course.
        $orders = Order::whereHas('course', function($q) use ($formateur) {
                $q->where('formateur_id', $formateur->id);
            })
            ->where('status', 'completed')
            ->with(['user', 'course', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalRevenue = $orders->sum('amount');
        $totalSales = $orders->count();
        
        // Apprentissages du formateur (s'il a testé son cours ou acheté des cours)
        $learningOrders = Order::with(['course.formateur.user', 'course.lessons', 'course.quizzes'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $myEnrolledCourses = $learningOrders->unique('course_id')->map(function($order) use ($user) {
            $course = $order->course;
            
            // Calcul du progrès des leçons
            $lessonIds = $course->lessons->pluck('id');
            $totalLessons = $lessonIds->count();
            
            $completedLessonsCount = $user->completedLessons()
                ->whereIn('lesson_user.lesson_id', $lessonIds)
                ->count();
            
            $progress = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;
            
            $quizIds = $course->quizzes->pluck('id');
            $bestAttempt = QuizAttempt::where('user_id', $user->id)
                ->whereIn('course_quiz_id', $quizIds)
                ->orderByDesc('score')
                ->first();
                
            $passed = $bestAttempt ? (bool) $bestAttempt->passed : false;
            $score = $bestAttempt ? $bestAttempt->score : null;
            
            $canDownloadCertificate = ($progress == 100 && $passed);

            $course->custom_progress = $progress;
            $course->custom_score = $score;
            $course->custom_passed = $passed;
            $course->order_date = $order->created_at;
            $course->can_download_certificate = $canDownloadCertificate;

            return $course;
        });

        // Retirer myCertificates qui ne sont plus nécessaires vu que tout est dans myEnrolledCourses
        return view('formateur.dashboard', compact(
            'formateur', 'totalCourses', 'recentCourses', 'orders', 'totalRevenue', 'totalSales', 'myEnrolledCourses'
        ));
    }

    public function catalog(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $trainerId = $request->input('trainer');
        $title = $request->input('title');
        $priceMax = $request->input('price_max');

        $coursesQuery = Course::where('status', 'approved')
            ->with(['category', 'formateur.user'])
            ->withCount('lessons');

        if ($search || $categoryId || $trainerId || $title || $priceMax) {
            
            // Recherche générique textuelle
            if ($search) {
                $coursesQuery->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhereHas('formateur.user', function($q2) use ($search) {
                          $q2->where('first_name', 'like', "%{$search}%")
                             ->orWhere('last_name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('category', function($q3) use ($search) {
                          $q3->where('name', 'like', "%{$search}%");
                      });
                });
            }

            // Filtres spécifiques
            if ($categoryId) {
                $coursesQuery->where('category_id', $categoryId);
            }
            if ($trainerId) {
                $coursesQuery->where('formateur_id', $trainerId);
            }
            if ($title) {
                $coursesQuery->where('title', 'like', "%{$title}%");
            }
            if ($priceMax) {
                $coursesQuery->where('price', '<=', $priceMax);
            }
        }

        $courses = $coursesQuery->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('formateur.catalog', compact('courses', 'search'));
    }
}
