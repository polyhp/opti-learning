<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\CourseQuiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use App\Models\Category;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->formateur) {
            abort(403, 'Profil formateur introuvable.');
        }

        $courses = Course::where('formateur_id', $user->formateur->id)
            ->withCount('lessons')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('formateur.courses_index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('formateur.courses_create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|numeric|min:1',
            'thumbnail' => 'required|image|max:2048',
            
            // Lessons (dynamic array)
            'lessons' => 'required|array',
            'lessons.*.title' => 'required|string',
            'lessons.*.file' => 'required|file', // Suppression des restrictions de format et de taille
            
            // Quiz (optional but we expect global quiz structure)
            'quiz_title' => 'nullable|string',
            'quiz_passing_score' => 'nullable|numeric|min:1|max:20',
            'questions' => 'nullable|array',
            'questions.*.text' => 'required_with:quiz_title|string',
            'questions.*.options' => 'required_with:quiz_title|array',
            'questions.*.correct_option' => 'required_with:quiz_title|numeric',
            
            // Makeup Quiz (optional)
            'makeup_quiz_title' => 'nullable|string',
            'makeup_quiz_passing_score' => 'nullable|numeric|min:1|max:20',
            'makeup_questions' => 'nullable|array',
            'makeup_questions.*.text' => 'required_with:makeup_quiz_title|string',
            'makeup_questions.*.options' => 'required_with:makeup_quiz_title|array',
            'makeup_questions.*.correct_option' => 'required_with:makeup_quiz_title|numeric',
        ]);

        $formateur = Auth::user()->formateur;

        // 1. Create Course
        // Stockage direct dans le dossier public/uploads/courses/thumbnails
        $thumbnailName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
        $request->file('thumbnail')->move(public_path('uploads/courses/thumbnails'), $thumbnailName);
        $thumbnailPath = 'uploads/courses/thumbnails/' . $thumbnailName;
        
        $course = Course::create([
            'formateur_id' => $formateur->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'thumbnail' => $thumbnailPath,
            'status' => 'pending', // Requires admin approval
        ]);

        // 2. Add Lessons
        foreach ($request->lessons as $index => $lessonData) {
            $file = $lessonData['file'];
            $mimeType = $file->getMimeType();
            
            $type = str_starts_with($mimeType, 'video/') ? 'video' : (str_starts_with($mimeType, 'image/') ? 'image' : 'document');
            
            // Stockage direct dans le dossier public/uploads/courses/...
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path("uploads/courses/{$course->id}/lessons"), $fileName);
            $filePath = "uploads/courses/{$course->id}/lessons/" . $fileName;
            
            Lesson::create([
                'course_id' => $course->id,
                'title' => $lessonData['title'],
                'order_index' => $index,
                'type' => $type,
                'file_path' => $filePath,
            ]);
        }

        // 3. Add Quiz if provided
        if ($request->filled('quiz_title') && $request->has('questions')) {
            $quiz = CourseQuiz::create([
                'course_id' => $course->id,
                'title' => $request->quiz_title,
                'passing_score' => $request->quiz_passing_score ?? 10,
                'type' => 'standard'
            ]);

            foreach ($request->questions as $qIndex => $qData) {
                $question = QuizQuestion::create([
                    'course_quiz_id' => $quiz->id,
                    'question_text' => $qData['text'],
                    'points' => 1,
                ]);

                foreach ($qData['options'] as $optIndex => $optText) {
                    if (!empty($optText)) {
                        QuizOption::create([
                            'quiz_question_id' => $question->id,
                            'option_text' => $optText,
                            'is_correct' => ($optIndex == $qData['correct_option']),
                        ]);
                    }
                }
            }
        }

        // 4. Add Makeup Quiz if provided
        if ($request->filled('makeup_quiz_title') && $request->has('makeup_questions')) {
            $makeupQuiz = CourseQuiz::create([
                'course_id' => $course->id,
                'title' => $request->makeup_quiz_title,
                'passing_score' => $request->makeup_quiz_passing_score ?? 10,
                'type' => 'makeup'
            ]);

            foreach ($request->makeup_questions as $qIndex => $qData) {
                $question = QuizQuestion::create([
                    'course_quiz_id' => $makeupQuiz->id,
                    'question_text' => $qData['text'],
                    'points' => 1,
                ]);

                foreach ($qData['options'] as $optIndex => $optText) {
                    if (!empty($optText)) {
                        QuizOption::create([
                            'quiz_question_id' => $question->id,
                            'option_text' => $optText,
                            'is_correct' => ($optIndex == $qData['correct_option']),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('formateur.dashboard')->with('success', 'Formation créée avec succès ! Elle est en attente d\'approbation par un administrateur.');
    }

    public function show(Course $course)
    {
        if ($course->formateur_id != Auth::user()->formateur->id) {
            abort(403, 'Accès refusé à cette formation.');
        }
        $course->load(['lessons', 'quizzes' => function($query) {
            $query->orderBy('type', 'desc'); // standard before makeup if needed
        }, 'quizzes.questions.options']);
        return view('formateur.courses_show', compact('course'));
    }
}
