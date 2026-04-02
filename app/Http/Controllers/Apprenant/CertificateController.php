<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Certificate;
use App\Models\QuizAttempt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function download(Course $course)
    {
        $user = auth()->user();

        // 1. Check if user bought the course
        $isOrdered = $course->orders()->where('user_id', $user->id)->where('status', 'completed')->exists();
        $isCreator = $user->hasRole('formateur') && $user->formateur && $course->formateur_id == $user->formateur->id;
        
        if (!$isOrdered && !$isCreator) {
            return back()->with('error', 'Vous devez avoir terminé cette formation pour obtenir un certificat.');
        }

        // 2. Check lessons progression
        $lessonIds = $course->lessons->pluck('id');
        $totalLessons = $lessonIds->count();
        $completedLessonsCount = $user->completedLessons()->whereIn('lesson_user.lesson_id', $lessonIds)->count();
        $progress = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;

        if ($progress < 100) {
            return back()->with('error', 'Vous devez terminer toutes les leçons vidéo.');
        }

        // 3. Check quiz passed
        $quizIds = $course->quizzes->pluck('id');
        $bestAttempt = QuizAttempt::where('user_id', $user->id)
                ->whereIn('course_quiz_id', $quizIds)
                ->orderByDesc('score')
                ->first();

        if (!$bestAttempt || !$bestAttempt->passed) {
            return back()->with('error', 'Vous devez réussir le quiz de cette formation.');
        }

        // 4. Record Certificate if not exists
        $certificate = Certificate::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ], [
            'certificate_code' => strtoupper(Str::random(10)) . '-' . date('Y'),
            'issued_at' => now()
        ]);

        // Generate QR Code base64
        $verifyUrl = route('verify.certificate', $certificate->certificate_code);
        $qrcode = base64_encode(QrCode::format('svg')->size(120)->generate($verifyUrl));

        // Generate PDF
        $data = [
            'certificate' => $certificate,
            'user' => $user,
            'course' => $course,
            'qrcode' => $qrcode,
            'score' => $bestAttempt->score
        ];

        $pdf = Pdf::loadView('pdf.certificate', $data)->setPaper('a4', 'landscape');
        return $pdf->download("Certificat_{$course->slug}.pdf");
    }

    public function verify($code)
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_code', $code)
            ->first();

        return view('public.certificate_verify', compact('certificate', 'code'));
    }
}
