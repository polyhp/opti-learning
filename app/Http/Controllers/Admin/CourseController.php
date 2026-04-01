<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = \App\Models\Course::with(['formateur.user', 'category']);

        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $status);
        }

        $courses = $query->latest()->paginate(15)->withQueryString();

        return view('admin.courses.index', compact('courses', 'status'));
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

        return back()->with('success', $message);
    }
}
