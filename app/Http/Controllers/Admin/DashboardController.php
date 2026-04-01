<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'apprenants' => \App\Models\User::where('role', 'apprenant')->count(),
            'formateurs' => \App\Models\User::where('role', 'formateur')->count(),
            'certificats' => \App\Models\Certificate::count(),
            'revenue' => \App\Models\Order::where('status', 'completed')->sum('amount'),
            'pending_courses' => \App\Models\Course::where('status', 'en_attente')->count(),
        ];

        // Liste des formations en attente
        $pendingCourses = \App\Models\Course::with(['formateur.user', 'category'])
            ->where('status', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        // Récentes commandes
        $recentOrders = \App\Models\Order::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingCourses', 'recentOrders'));
    }
}
