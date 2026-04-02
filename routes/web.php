<?php
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route d'accueil
Route::get('/', function (\Illuminate\Http\Request $request) {
    $search = $request->query('search');
    $categoryId = $request->query('category');
    $showAll = $request->query('all');

    // Catégories avec comptage
    $categories = \App\Models\Category::withCount('courses')->get();

    $baseQuery = \App\Models\Course::with(['category', 'formateur.user'])
        ->where('status', 'approved');

    // Moteur de recherche et filtres
    if ($search || $categoryId || $showAll) {
        $query = clone $baseQuery;
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $searchResults = $query->latest()->paginate(12)->withQueryString();
        
        return view('welcome', compact('categories', 'searchResults', 'search', 'categoryId', 'showAll'));
    }

    // Listes par défaut
    $recentCourses = (clone $baseQuery)
        ->latest()
        ->take(10)
        ->get();

    $popularCourses = (clone $baseQuery)
        ->withCount(['orders' => function ($query) {
            $query->where('status', 'completed');
        }])
        ->orderByDesc('orders_count')
        ->take(8)
        ->get();

    return view('welcome', compact('categories', 'recentCourses', 'popularCourses'));
})->name('home');

// Route de détail d'une formation (Publique)
Route::get('/formations/{course}', [\App\Http\Controllers\PublicCourseController::class, 'show'])->name('courses.show');

// Route de vérification de certificat (Publique)
Route::get('/verify/{code}', [\App\Http\Controllers\Apprenant\CertificateController::class, 'verify'])->name('verify.certificate');

// Routes d'authentification
Route::group([], function () {
    // Routes de connexion
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    
    // Routes d'inscription
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');
    
    Route::get('/register/apprenant', [RegisterController::class, 'createApprenant'])
        ->name('register.apprenant');
    Route::post('/register/apprenant', [RegisterController::class, 'storeApprenant'])
        ->name('register.apprenant.store');
    
    Route::get('/register/formateur', [RegisterController::class, 'createFormateur'])
        ->name('register.formateur');
    Route::post('/register/formateur', [RegisterController::class, 'storeFormateur'])
        ->name('register.formateur.store');
        
    
});

// Route de déconnexion
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('formateur')) {
            return redirect()->route('formateur.dashboard');
        } else {
            return redirect()->route('apprenant.dashboard');
        }
    })->name('dashboard');
    
    // Routes pour les apprenants - Utilisation du middleware SimpleRoleCheck
    Route::prefix('apprenant')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Apprenant\DashboardController::class, 'index'])->name('apprenant.dashboard')->middleware('role:apprenant');
        Route::get('/catalog', [\App\Http\Controllers\Apprenant\DashboardController::class, 'catalog'])->name('apprenant.catalog')->middleware('role:apprenant');
        
        // Gestion de profil
        Route::post('/profile', [\App\Http\Controllers\Apprenant\ProfileController::class, 'update'])->name('apprenant.profile.update')->middleware('role:apprenant');
        
        // Téléchargement Certificat
        Route::get('/certificate/{course}', [\App\Http\Controllers\Apprenant\CertificateController::class, 'download'])->name('apprenant.certificate.download');

        // Paiement et Visionnage
        Route::post('/checkout', [\App\Http\Controllers\Apprenant\CourseController::class, 'checkout'])->name('apprenant.checkout');
        Route::get('/payment/{order}', [\App\Http\Controllers\Apprenant\PaymentController::class, 'show'])->name('apprenant.payment.show');
        Route::get('/payment/verify/kkiapay', [\App\Http\Controllers\Apprenant\PaymentController::class, 'verify'])->name('apprenant.payment.verify');
        Route::get('/courses/{course}/watch', [\App\Http\Controllers\Apprenant\CourseController::class, 'watch'])->name('apprenant.courses.watch');
        Route::post('/lessons/{lesson}/complete', [\App\Http\Controllers\Apprenant\CourseController::class, 'completeLesson'])->name('apprenant.lessons.complete');
        Route::post('/quizzes/{quiz}/submit', [\App\Http\Controllers\Apprenant\CourseController::class, 'submitQuiz'])->name('apprenant.quizzes.submit');
    });
    
    // Routes pour les formateurs
    Route::prefix('formateur')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Formateur\DashboardController::class, 'index'])->name('formateur.dashboard')->middleware('role:formateur');
        Route::get('/catalog', [\App\Http\Controllers\Formateur\DashboardController::class, 'catalog'])->name('formateur.catalog')->middleware('role:formateur');
        
        // Gestion de Profil
        Route::post('/profile', [\App\Http\Controllers\Formateur\ProfileController::class, 'update'])->name('formateur.profile.update')->middleware('role:formateur');
        
        // Gestion des Formations
        Route::get('/courses', [\App\Http\Controllers\Formateur\CourseController::class, 'index'])->name('formateur.courses.index')->middleware('role:formateur');
        Route::get('/courses/create', [\App\Http\Controllers\Formateur\CourseController::class, 'create'])->name('formateur.courses.create')->middleware('role:formateur');
        Route::post('/courses', [\App\Http\Controllers\Formateur\CourseController::class, 'store'])->name('formateur.courses.store')->middleware('role:formateur');
        Route::get('/courses/{course}', [\App\Http\Controllers\Formateur\CourseController::class, 'show'])->name('formateur.courses.show')->middleware('role:formateur');
        Route::get('/courses/{course}/edit', [\App\Http\Controllers\Formateur\CourseController::class, 'edit'])->name('formateur.courses.edit')->middleware('role:formateur');
        Route::put('/courses/{course}', [\App\Http\Controllers\Formateur\CourseController::class, 'update'])->name('formateur.courses.update')->middleware('role:formateur');
    });
    
    // Routes pour les admins
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Paramètres Profil Admin
        Route::get('/profile', [\App\Http\Controllers\Admin\AdminController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('profile.update');

        // Nouveaux Administrateurs
        Route::get('/create', [\App\Http\Controllers\Admin\AdminController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->name('store');
        
        // Journal des activités
        Route::get('/logs', [\App\Http\Controllers\Admin\AdminController::class, 'logs'])->name('logs.index');
        

        // Gestion des Utilisateurs (Apprenants & Formateurs)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users/store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.role');
        Route::patch('/users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Gestion des Formations
        Route::get('/courses', [\App\Http\Controllers\Admin\CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/{course}', [\App\Http\Controllers\Admin\CourseController::class, 'show'])->name('courses.show');
        Route::patch('/courses/{course}/status', [\App\Http\Controllers\Admin\CourseController::class, 'updateStatus'])->name('courses.status');

        // Suivi des Paiements
        Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/export', [\App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');
    });
});

// Configuration du compte Admin
Route::get('/admin/setup/{user}', [\App\Http\Controllers\Admin\AdminSetupController::class, 'show'])->name('admin.setup')->middleware('signed');
Route::post('/admin/setup/{user}', [\App\Http\Controllers\Admin\AdminSetupController::class, 'confirm'])->name('admin.setup.confirm')->middleware('signed');

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password/send-code', [PasswordResetController::class, 'sendCode'])->name('password.send-code');
    Route::post('/forgot-password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify-code');
    Route::post('/forgot-password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
    Route::post('/forgot-password/resend-code', [PasswordResetController::class, 'resendCode'])->name('password.resend-code');
});

// Webhook Kkiapay
Route::post('/kkiapay/webhook', [\App\Http\Controllers\Apprenant\PaymentController::class, 'webhook'])->name('kkiapay.webhook');