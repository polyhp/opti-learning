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
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->formateur) {
            abort(403, 'Profil formateur introuvable.');
        }

        $search = $request->query('search');

        $query = Course::where('formateur_id', $user->formateur->id)
            ->withCount('lessons');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('formateur.courses_index', compact('courses', 'search'));
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
            'cover_video' => 'nullable|file|mimes:mp4,mov,ogg,qt,webm,mkv|max:102400',
            
            // Lessons (dynamic array)
            'lessons' => 'required|array',
            'lessons.*.title' => 'required|string',
            'lessons.*.file' => 'required|file', // Suppression des restrictions de format et de taille
            
            // Quiz (now required)
            'quiz_title' => 'required|string',
            'quiz_passing_score' => 'required|numeric|min:1|max:20',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_option' => 'required|numeric',
            
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
        
        $coverVideoPath = null;
        if ($request->hasFile('cover_video')) {
            $videoName = time() . '_cover_' . $request->file('cover_video')->getClientOriginalName();
            $request->file('cover_video')->move(public_path('uploads/courses/covers'), $videoName);
            $coverVideoPath = 'uploads/courses/covers/' . $videoName;
        }

        $course = Course::create([
            'formateur_id' => $formateur->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'thumbnail' => $thumbnailPath,
            'cover_video' => $coverVideoPath,
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

    public function edit(Course $course)
    {
        if ($course->formateur_id != Auth::user()->formateur->id) {
            abort(403, 'Accès refusé à cette formation.');
        }
        $course->load(['lessons' => function($query) {
            $query->orderBy('order_index');
        }, 'quizzes.questions.options']);
        $categories = Category::all();
        
        return view('formateur.courses_edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->formateur_id != Auth::user()->formateur->id) {
            abort(403, 'Accès refusé à cette formation.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|numeric|min:1',
            'thumbnail' => 'nullable|image|max:2048',
            'cover_video' => 'nullable|file|mimes:mp4,mov,ogg,qt,webm,mkv|max:102400',
            
            // Lessons
            'lessons' => 'required|array',
            'lessons.*.id' => 'nullable|exists:lessons,id',
            'lessons.*.title' => 'required|string',
            'lessons.*.file' => 'nullable|file', 
            
            // Quiz (now required)
            'quiz_title' => 'required|string',
            'quiz_passing_score' => 'required|numeric|min:1|max:20',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_option' => 'required|numeric',
            
            // Makeup Quiz
            'makeup_quiz_title' => 'nullable|string',
            'makeup_quiz_passing_score' => 'nullable|numeric|min:1|max:20',
            'makeup_questions' => 'nullable|array',
            'makeup_questions.*.text' => 'required_with:makeup_quiz_title|string',
            'makeup_questions.*.options' => 'required_with:makeup_quiz_title|array',
            'makeup_questions.*.correct_option' => 'required_with:makeup_quiz_title|numeric',
        ]);

        $updateData = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'status' => 'pending', // Reverts to pending
        ];

        // 1. Update basic info and files
        if ($request->hasFile('thumbnail')) {
            $thumbnailName = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->move(public_path('uploads/courses/thumbnails'), $thumbnailName);
            $updateData['thumbnail'] = 'uploads/courses/thumbnails/' . $thumbnailName;
        }

        if ($request->hasFile('cover_video')) {
            $videoName = time() . '_cover_' . $request->file('cover_video')->getClientOriginalName();
            $request->file('cover_video')->move(public_path('uploads/courses/covers'), $videoName);
            $updateData['cover_video'] = 'uploads/courses/covers/' . $videoName;
        }

        $course->update($updateData);

        // 2. Update Lessons
        $requestedLessonIds = collect($request->lessons)->pluck('id')->filter()->toArray();
        // Remove deleted lessons
        $course->lessons()->whereNotIn('id', $requestedLessonIds)->delete();

        foreach ($request->lessons as $index => $lessonData) {
            $lesson = null;
            if (isset($lessonData['id'])) {
                $lesson = Lesson::find($lessonData['id']);
            }

            $filePath = $lesson ? $lesson->file_path : null;
            $type = $lesson ? $lesson->type : null;

            if (isset($lessonData['file']) && $lessonData['file']) {
                $file = $lessonData['file'];
                $mimeType = $file->getMimeType();
                $type = str_starts_with($mimeType, 'video/') ? 'video' : (str_starts_with($mimeType, 'image/') ? 'image' : 'document');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("uploads/courses/{$course->id}/lessons"), $fileName);
                $filePath = "uploads/courses/{$course->id}/lessons/" . $fileName;
            }

            if (!$filePath) {
                // Should not happen for new lessons due to frontend validation,
                // but just in case
                continue;
            }

            if ($lesson) {
                $lesson->update([
                    'title' => $lessonData['title'],
                    'order_index' => $index,
                    'type' => $type,
                    'file_path' => $filePath,
                ]);
            } else {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => $lessonData['title'],
                    'order_index' => $index,
                    'type' => $type,
                    'file_path' => $filePath,
                ]);
            }
        }

        // 3. Recreate Quizzes
        // To simplify, we delete existing quizzes and recreate them
        $course->quizzes()->delete();

        // Add Standard Quiz
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

        // Add Makeup Quiz
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

        return redirect()->route('formateur.courses.show', $course)->with('success', 'Formation modifiée avec succès. Elle est de nouveau en attente de validation.');
    }
}
