<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - OptiLearning</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        head: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        navy: { 50: '#f0f3f9', 100: '#dde5f1', 500: '#6488c0', 700: '#2D4B8E', 800: '#1d3566', 900: '#0B1A3E' },
                        orange: { 50: '#fff6ec', 100: '#ffead3', 500: '#F97316', 600: '#ea580c' }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- Header Rapide -->
    <header class="bg-navy-900 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center shadow-lg"><i class="fas fa-graduation-cap text-white text-xl"></i></div>
                    <span class="text-2xl font-head font-bold text-white">OPTI<span class="text-orange-500">LEARNING</span></span>
                </a>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-orange-400 font-medium">Mon Espace</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-300 hover:text-white" title="Déconnexion"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-orange-400 font-medium font-head">Connexion</a>
                        <a href="{{ route('register') }}" class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-full text-white font-medium font-head transition-colors shadow-md shadow-orange-500/20">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Héros de la formation -->
    <section class="bg-navy-900 text-white py-16 lg:py-24 border-t border-white/10 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800 to-transparent z-10"></div>
        <!-- Image de fond floutée -->
        @if($course->thumbnail)
            <img src="{{ asset($course->thumbnail) }}" class="absolute inset-0 w-full h-full object-cover opacity-20 blur-sm mix-blend-overlay">
        @endif
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="max-w-3xl">
                <div class="flex items-center space-x-3 text-orange-400 text-sm font-bold uppercase tracking-wider mb-6">
                    <span>{{ $course->category->name ?? 'Général' }}</span>
                    <span>•</span>
                    <span class="flex items-center text-yellow-500"><i class="fas fa-star mr-1"></i> 4.8 (Nouveau)</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-head font-bold leading-tight mb-6">{{ $course->title }}</h1>
                <p class="text-lg text-slate-300 mb-8 max-w-2xl leading-relaxed opacity-90 truncate">{{ Str::limit($course->description, 150) }}</p>
                
                <div class="flex items-center space-x-4 text-sm text-slate-300">
                    <span class="flex items-center"><i class="fas fa-user-tie mr-2 text-white"></i> Créé par <span class="text-white font-medium ml-1">{{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}</span></span>
                    <span>•</span>
                    <span class="flex items-center"><i class="fas fa-video mr-2 text-white"></i> {{ $course->lessons->count() }} leçons</span>
                    <span>•</span>
                    <span class="flex items-center"><i class="fas fa-clock mr-2 text-white"></i> {{ $course->duration_minutes }} min</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu Principal & Carte de Paiement -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
        <div class="flex flex-col lg:flex-row gap-12 relative">
            
            <!-- Left Column: Infos -->
            <div class="flex-grow max-w-4xl space-y-12">
                <!-- Description -->
                <div>
                    <h2 class="text-2xl font-head font-bold text-navy-900 mb-6 w-full border-b border-slate-200 pb-2">Description de la formation</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relax whitespace-pre-line">
                        {{ $course->description }}
                    </div>
                </div>
                
                <!-- Programme (Lessons) -->
                <div>
                    <h2 class="text-2xl font-head font-bold text-navy-900 mb-6 w-full border-b border-slate-200 pb-2">Contenu du cours</h2>
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center text-sm font-semibold text-slate-700">
                            <span>Matière couverte</span>
                            <span>{{ $course->lessons->count() }} leçons</span>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($course->lessons as $index => $lesson)
                                <div class="px-6 py-4 hover:bg-slate-50/50 transition-colors flex items-center justify-between group">
                                    <div class="flex items-center">
                                        @if($lesson->type == 'video')
                                            <i class="fas fa-play-circle text-slate-300 group-hover:text-orange-500 mr-4 text-xl"></i>
                                        @else
                                            <i class="fas fa-file-alt text-slate-300 group-hover:text-orange-500 mr-4 text-xl"></i>
                                        @endif
                                        <span class="text-slate-700 font-medium">{{ $index + 1 }}. {{ $lesson->title }}</span>
                                    </div>
                                    @if($hasPaid)
                                        <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-1 rounded">Accessible</span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400"><i class="fas fa-lock"></i> Verrouillé</span>
                                    @endif
                                </div>
                            @endforeach
                            @if($course->quizzes->count() > 0)
                                <div class="px-6 py-5 bg-navy-50/50 border-t border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-question-circle text-navy-400 mr-4 text-xl"></i>
                                        <span class="text-navy-900 font-bold">Évaluation Finale (Quiz)</span>
                                    </div>
                                    @if($hasPaid)
                                        <span class="text-xs font-medium text-emerald-500 bg-emerald-50 px-2 py-1 rounded">Accessible</span>
                                    @else
                                        <span class="text-xs font-medium text-slate-400"><i class="fas fa-lock"></i> Verrouillé</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Card Achat -->
            <div class="lg:w-[400px] flex-shrink-0">
                <!-- Sticky Box -->
                <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden sticky top-28 transform lg:-translate-y-48 z-30 transition-all">
                    <!-- Miniature -->
                    <div class="h-56 bg-slate-100 relative">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy-800 text-navy-400"><i class="fas fa-video text-4xl"></i></div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center rounded-t-3xl opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-orange-500 text-2xl pl-1"><i class="fas fa-play"></i></div>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        @if($course->price == 0)
                            <div class="text-4xl font-head font-bold text-navy-900 mb-6">Gratuit</div>
                        @else
                            <div class="text-4xl font-head font-bold text-navy-900 mb-6">{{ number_format($course->price, 0, ',', ' ') }} <span class="text-xl text-slate-400">FCFA</span></div>
                        @endif
                        
                        @if($hasPaid)
                            <!-- Déjà payé / Admin / Formateur -->
                            <a href="{{ route('apprenant.courses.watch', $course->id) }}" class="block w-full text-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 text-lg mb-4">
                                Accéder à la formation
                            </a>
                            <p class="text-center text-sm text-emerald-600 font-medium"><i class="fas fa-check-circle"></i> Vous possédez cette formation</p>
                        @else
                            <!-- Non payé -> Formulaire d'Achat Simulé -->
                            @auth
                                <form action="{{ route('apprenant.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 rounded-xl shadow-xl shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 text-lg mb-4">
                                        {{ $course->price > 0 ? 'Payer ' . number_format($course->price, 0, ',', ' ') . ' FCFA' : "S'inscrire à la formation" }}
                                    </button>
                                </form>
                                <p class="text-center text-xs text-slate-400 mb-6">Paiement sécurisé par Mobile Money / Carte</p>
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center bg-navy-800 hover:bg-navy-900 text-white font-bold py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 text-lg mb-4">
                                    Se connecter pour acheter
                                </a>
                                <p class="text-center text-xs text-slate-400 mb-6">Vous devez avoir un compte pour acheter cette formation.</p>
                            @endauth
                        @endif

                        <div class="space-y-3 pt-6 border-t border-slate-100 text-sm text-slate-600">
                            <h4 class="font-bold text-navy-900 mb-4">Cette formation inclut :</h4>
                            <div class="flex items-center"><i class="fas fa-video w-6 text-center text-slate-400"></i> Accès illimité aux vidéos</div>
                            <div class="flex items-center"><i class="fas fa-mobile-alt w-6 text-center text-slate-400"></i> Accessible sur mobile et PC</div>
                            <div class="flex items-center"><i class="fas fa-certificate w-6 text-center text-slate-400"></i> Certificat de fin de formation (si Quiz réussi)</div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-navy-900 border-t border-navy-800 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-navy-300 text-sm">
            &copy; {{ date('Y') }} OptiLearning. Apprentissage Sécurisé. Tous droits réservés.
        </div>
    </footer>

</body>
</html>
