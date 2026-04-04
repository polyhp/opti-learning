<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $query = \App\Models\Course::with(['formateur.user', 'category']);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('formateur.user', function($q2) use ($search) {
                      $q2->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $courses = $query->latest()->paginate(15)->withQueryString();

        return view('admin.courses.index', compact('courses', 'status', 'search'));
    }

    public function show(\App\Models\Course $course)
    {
        $course->load(['formateur.user', 'category', 'lessons', 'quizzes.questions.options']);
        return view('admin.courses.show', compact('course'));
    }

    public function updateStatus(Request $request, \App\Models\Course $course)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string',
        ]);

        $course->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null,
        ]);

        if ($validated['status'] === 'rejected') {
            \Illuminate\Support\Facades\Mail::to($course->formateur->user->email)->send(
                new \App\Mail\CourseRejectedMail($course, $validated['rejection_reason'])
            );
        }

        $message = $validated['status'] === 'approved' ? 'Formation approuvée avec succès.' : 'Formation rejetée, le formateur a été notifié.';

        $statusStr = $validated['status'] === 'approved' ? 'approuvé' : 'rejeté';
        \App\Models\AdminActivityLog::log('Modération Formation', "A $statusStr la formation: {$course->title}");

        return back()->with('success', $message);
    }
}
