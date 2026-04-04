<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Course;
use App\Models\QuizAttempt;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Fetch valid purchased courses
        $orders = Order::with(['course.formateur.user', 'course.lessons', 'course.quizzes'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderByDesc('created_at')
            ->get();

        $enrolledCourses = $orders->unique('course_id')->map(function($order) use ($user) {
            $course = $order->course;
            
            // Calcul du progrès des leçons
            $lessonIds = $course->lessons->pluck('id');
            $totalLessons = $lessonIds->count();
            
            // Check completed lessons using the pivot table relation
            $completedLessonsCount = $user->completedLessons()
                ->whereIn('lesson_user.lesson_id', $lessonIds)
                ->count();
            
            $progress = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;
            
            // Note au quiz si disponible
            $quizIds = $course->quizzes->pluck('id');
            $bestAttempt = QuizAttempt::where('user_id', $user->id)
                ->whereIn('course_quiz_id', $quizIds)
                ->orderByDesc('score')
                ->first();
                
            $passed = $bestAttempt ? (bool) $bestAttempt->passed : false;
            $score = $bestAttempt ? $bestAttempt->score : null;
            
            // Condition pour obtenir le certificat
            $canDownloadCertificate = ($progress == 100 && $passed);

            // Attacher les attributs calculés
            $course->custom_progress = $progress;
            $course->custom_score = $score;
            $course->custom_passed = $passed;
            $course->order_date = $order->created_at;
            $course->can_download_certificate = $canDownloadCertificate;

            return $course;
        });

        // Nouvelles suggestions de formations non achetées
        $purchasedIds = $orders->pluck('course_id')->toArray();
        $suggestedCourses = Course::with(['formateur.user'])
            ->where('status', 'approved')
            ->whereNotIn('id', $purchasedIds)
            ->latest()
            ->take(8)
            ->get();

        return view('apprenant.dashboard', compact('enrolledCourses', 'suggestedCourses'));
    }
    public function catalog(Request $request)
    {
        $search = $request->input('search');

        $coursesQuery = Course::where('status', 'approved')
            ->with(['category', 'formateur.user'])
            ->withCount('lessons');

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

        $courses = $coursesQuery->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('apprenant.catalog', compact('courses', 'search'));
    }
}
