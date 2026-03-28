<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Order;

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

        return view('formateur.dashboard', compact(
            'formateur', 'totalCourses', 'recentCourses', 'orders', 'totalRevenue', 'totalSales'
        ));
    }
}
