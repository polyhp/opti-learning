<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lecteur : {{ $course->title }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], head: ['Outfit', 'sans-serif'] },
                    colors: { navy: { 50: '#F4F7FB', 100: '#E6EDF5', 800: '#1d3566', 900: '#0B1A3E' }, orange: { 500: '#F97316', 600: '#ea580c' } }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #64748b; }
        .tab-btn.active { border-bottom: 3px solid #F97316; color: #FFFFFF; font-weight: 600; }
        .lesson-item.active { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-left: 4px solid #F97316; }
        .lesson-item.active .lesson-title-text { color: #F97316; }
        
        /* Sidebar Mobile Styles - Sans overlay */
        .sidebar-mobile {
            position: fixed;
            top: 0;
            right: 0;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -5px 0 25px rgba(0, 0, 0, 0.3);
        }
        .sidebar-mobile.open {
            transform: translateX(0);
        }
        
        @media (min-width: 1024px) {
            .sidebar-mobile {
                position: relative;
                transform: translateX(0) !important;
                max-width: none;
                width: 25%;
                box-shadow: none;
            }
        }
        
        .quiz-option-label { transition: all 0.2s ease; }
        .quiz-option-label:hover { background: rgba(249, 115, 22, 0.1); border-color: rgba(249, 115, 22, 0.5); }
        
        /* Empêcher le scroll du body quand le menu est ouvert */
        body.menu-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 to-slate-800 text-slate-200 font-sans h-screen flex flex-col overflow-hidden">

    <!-- Navbar -->
    <header class="bg-slate-900/95 backdrop-blur-sm border-b border-slate-700 h-auto min-h-16 flex items-center justify-between px-3 sm:px-6 py-2 flex-shrink-0 shadow-lg z-50 relative">
        <div class="flex items-center space-x-2 sm:space-x-4 flex-1 min-w-0">
            <button id="mobile-menu-btn" class="lg:hidden w-9 h-9 rounded-lg bg-slate-800 text-slate-300 hover:bg-orange-500 hover:text-white transition-colors flex items-center justify-center flex-shrink-0 shadow-md">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <a href="{{ Auth::user()->hasRole('formateur') ? route('formateur.dashboard') : route('apprenant.dashboard') }}" class="flex items-center space-x-2 flex-shrink-0">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/30">
                    <i class="fas fa-graduation-cap text-white text-sm"></i>
                </div>
                <span class="text-lg sm:text-xl font-head font-bold text-white hidden sm:block">OPTI<span class="text-orange-500">LEARNING</span></span>
            </a>
            
            <div class="h-6 w-px bg-slate-700 hidden sm:block"></div>
            
            <!-- Bouton Mon espace - Toujours visible sur mobile/tablette -->
            <a href="{{ Auth::user()->hasRole('formateur') ? route('formateur.dashboard') : route('apprenant.dashboard') }}" class="text-slate-400 hover:text-orange-500 transition-colors text-sm font-medium flex items-center whitespace-nowrap">
                <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>
                <span class="hidden xs:inline">Mon espace</span>
                <span class="inline xs:hidden">Espace</span>
            </a>
            
            <div class="h-6 w-px bg-slate-700 hidden md:block"></div>
            
            <h1 class="text-slate-200 font-head font-semibold truncate text-sm sm:text-base md:text-lg" title="{{ $course->title }}">{{ $course->title }}</h1>
        </div>
        
        <div class="flex items-center space-x-2 sm:space-x-4">
            <div class="hidden md:flex items-center space-x-3">
                <span class="text-xs font-semibold text-slate-400" id="progress-text">0% complété</span>
                <div class="w-32 h-2 bg-slate-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 w-0 transition-all duration-500" id="progress-bar"></div>
                </div>
            </div>
            <span class="text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2 sm:px-3 py-1.5 rounded-full shadow-sm flex-shrink-0">
                <i class="fas fa-unlock mr-1"></i><span class="hidden xs:inline">Accès</span> Garanti
            </span>
        </div>
    </header>

    @if(session('success'))
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-center py-2 text-sm font-medium w-full flex-shrink-0 shadow-lg" id="flashInfo">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="flex-grow flex flex-col lg:flex-row overflow-hidden relative">
        
        <!-- Main Player Area -->
        <main class="flex-grow flex flex-col relative bg-gradient-to-b from-slate-900 to-slate-800 overflow-y-auto w-full lg:w-3/4">
            
            <div class="w-full bg-black relative flex items-center justify-center flex-shrink-0" id="player-container" style="height: 55vh; max-height: 550px; min-height: 280px;">
                @if($course->lessons->count() > 0)
                    @php $firstVideo = $course->lessons->where('type', 'video')->first(); @endphp
                    @if($firstVideo)
                        <video id="main-player" controls class="w-full h-full outline-none shadow-2xl" poster="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}" onended="onVideoEnded()">
                            <source src="{{ asset($firstVideo->file_path) }}" type="video/mp4" id="video-source">
                            Votre navigateur ne supporte pas la lecture vidéo.
                        </video>
                    @else
                        <div class="text-center p-8">
                            <i class="fas fa-file-pdf text-6xl text-slate-600 mb-4"></i>
                            <h3 class="text-xl text-white font-medium">Contenu documentaire</h3>
                            <p class="text-sm text-slate-400 mt-2">Ce cours ne contient pas de vidéos. Lisez les documents dans le menu de droite.</p>
                        </div>
                    @endif
                @else
                    <div class="text-center text-slate-500">
                        <i class="fas fa-box-open text-4xl mb-4"></i>
                        <p>Aucun contenu n'a été publié pour cette formation.</p>
                    </div>
                @endif
                
                <!-- Quiz Modal Overlay -->
                <div id="quiz-overlay" class="absolute inset-0 bg-gradient-to-br from-slate-900 to-slate-800 border-t-4 border-orange-500 z-50 overflow-y-auto hidden custom-scrollbar">
                    <div class="max-w-3xl mx-auto py-8 sm:py-12 px-4 sm:px-6">
                        @if($standardQuiz)
                            @if(!$standardAttempt || ($standardAttempt && $standardAttempt->passed))
                                <!-- STANDARD QUIZ (Not taken OR Passed) -->
                                <div class="text-center mb-8 sm:mb-10">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-orange-500/20 text-orange-500 rounded-full flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 border border-orange-500/50 shadow-[0_0_15px_rgba(249,115,22,0.3)]">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <h2 class="text-2xl sm:text-3xl font-head font-bold text-white mb-2">Quiz : {{ $standardQuiz->title }}</h2>
                                    <p class="text-slate-300 font-medium bg-white/10 inline-block px-4 py-1 rounded-full text-sm mt-2">Score requis : <strong class="text-orange-400">{{ $standardQuiz->passing_score }}/20</strong></p>
                                </div>
                                
                                @if($standardAttempt && $standardAttempt->passed)
                                    <div class="rounded-2xl border p-6 sm:p-8 text-center mt-8 bg-white/5 backdrop-blur-sm border-emerald-500/30">
                                        <div class="text-5xl sm:text-6xl font-head font-bold text-emerald-400 mb-4">{{ $standardAttempt->score }}/20</div>
                                        <div class="mt-6 p-4 bg-emerald-500/20 border-emerald-500/30 border rounded-xl">
                                            <span class="text-base sm:text-lg font-bold text-emerald-300">🎉 Félicitations ! Vous avez validé la formation !</span>
                                        </div>
                                        <a href="{{ Auth::user()->hasRole('formateur') ? route('formateur.dashboard') : route('apprenant.dashboard') }}" class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">
                                            Retour au Tableau de Bord
                                        </a>
                                    </div>
                                @else
                                    <!-- Formulaire Quiz Standard -->
                                    <form id="quiz-form" class="space-y-4 sm:space-y-6" data-quiz-id="{{ $standardQuiz->id }}" onsubmit="submitQuizContent(event, this)">
                                        @foreach($standardQuiz->questions as $qIndex => $q)
                                            <div class="bg-slate-800/50 border border-slate-700 p-4 sm:p-6 rounded-2xl shadow-lg">
                                                <h3 class="text-white text-base sm:text-lg font-semibold mb-4 sm:mb-5">
                                                    <span class="text-orange-500 mr-2 bg-orange-500/10 px-2 py-1 rounded">Q{{ $qIndex + 1 }}</span> 
                                                    {{ $q->question_text }}
                                                </h3>
                                                <div class="space-y-2 sm:space-y-3">
                                                    @foreach($q->options as $opt)
                                                        <label class="quiz-option-label flex items-center space-x-3 p-3 sm:p-4 rounded-xl border border-slate-700 hover:border-orange-500/50 hover:bg-slate-700/50 cursor-pointer transition-all">
                                                            <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->is_correct ? '1' : '0' }}" class="w-4 h-4 sm:w-5 sm:h-5 accent-orange-500" required>
                                                            <span class="text-slate-300 font-medium select-none text-sm sm:text-base">{{ $opt->option_text }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 sm:py-4 rounded-xl shadow-xl transition-all transform hover:-translate-y-1 text-base sm:text-lg flex justify-center items-center mt-6 sm:mt-8">
                                            <i class="fas fa-paper-plane mr-2"></i> Valider mes réponses
                                        </button>
                                        <div id="quiz-result" class="hidden rounded-2xl border p-6 sm:p-8 text-center mt-6 sm:mt-8 bg-white/5 backdrop-blur-sm border-slate-700"></div>
                                    </form>
                                @endif
                                
                            @else
                                <!-- Échec Quiz Standard -->
                                @if($makeupQuiz)
                                    @if(!$makeupAttempt || ($makeupAttempt && $makeupAttempt->passed))
                                        <!-- RATTRAPAGE -->
                                        <div class="text-center mb-8 sm:mb-10">
                                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 border border-red-500/50 shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                                                <i class="fas fa-life-ring"></i>
                                            </div>
                                            <h2 class="text-2xl sm:text-3xl font-head font-bold text-white mb-2">Session de Rattrapage</h2>
                                            <p class="text-slate-300 mb-2">Votre note précédente : <span class="text-red-400 font-bold">{{ $standardAttempt->score }}/20</span></p>
                                            <p class="text-white font-medium bg-red-500/80 inline-block px-4 py-1 rounded-full text-sm">Dernière chance - Score requis : <strong class="text-white">{{ $makeupQuiz->passing_score }}/20</strong></p>
                                        </div>
                                        
                                        @if($makeupAttempt && $makeupAttempt->passed)
                                            <!-- Rattrapage Réussi -->
                                            <div class="rounded-2xl border p-6 sm:p-8 text-center mt-8 bg-white/5 backdrop-blur-sm border-emerald-500/30">
                                                <div class="text-5xl sm:text-6xl font-head font-bold text-emerald-400 mb-4">{{ $makeupAttempt->score }}/20</div>
                                                <div class="mt-6 p-4 bg-emerald-500/20 border-emerald-500/30 border rounded-xl">
                                                    <span class="text-base sm:text-lg font-bold text-emerald-300">🎉 Félicitations ! Vous avez validé votre rattrapage !</span>
                                                </div>
                                                <a href="{{ Auth::user()->hasRole('formateur') ? route('formateur.dashboard') : route('apprenant.dashboard') }}" class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">
                                                    Retour au Tableau de Bord
                                                </a>
                                            </div>
                                        @else
                                            <!-- Formulaire Rattrapage -->
                                            <form id="quiz-form" class="space-y-4 sm:space-y-6" data-quiz-id="{{ $makeupQuiz->id }}" onsubmit="submitQuizContent(event, this)">
                                                @foreach($makeupQuiz->questions as $qIndex => $q)
                                                    <div class="bg-slate-800/50 border border-slate-700 p-4 sm:p-6 rounded-2xl shadow-lg">
                                                        <h3 class="text-white text-base sm:text-lg font-semibold mb-4 sm:mb-5">
                                                            <span class="text-red-500 mr-2 bg-red-500/10 px-2 py-1 rounded">Q{{ $qIndex + 1 }}</span> 
                                                            {{ $q->question_text }}
                                                        </h3>
                                                        <div class="space-y-2 sm:space-y-3">
                                                            @foreach($q->options as $opt)
                                                                <label class="quiz-option-label flex items-center space-x-3 p-3 sm:p-4 rounded-xl border border-slate-700 hover:border-red-500/50 hover:bg-slate-700/50 cursor-pointer transition-all">
                                                                    <input type="radio" name="q_{{ $q->id }}" value="{{ $opt->is_correct ? '1' : '0' }}" class="w-4 h-4 sm:w-5 sm:h-5 accent-red-500" required>
                                                                    <span class="text-slate-300 font-medium select-none text-sm sm:text-base">{{ $opt->option_text }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 sm:py-4 rounded-xl shadow-xl transition-all text-base sm:text-lg flex justify-center items-center mt-6 sm:mt-8">
                                                    <i class="fas fa-paper-plane mr-2"></i> Valider mon rattrapage
                                                </button>
                                                <div id="quiz-result" class="hidden rounded-2xl border p-6 sm:p-8 text-center mt-6 sm:mt-8 bg-white/5 backdrop-blur-sm border-slate-700"></div>
                                            </form>
                                        @endif
                                        
                                    @else
                                        <!-- Echec Définitif Rattrapage -->
                                        <div class="text-center py-8 sm:py-12">
                                            <i class="fas fa-times-circle text-6xl sm:text-8xl text-slate-600 mb-6"></i>
                                            <h2 class="text-2xl sm:text-3xl font-head font-bold text-white mb-4">Échec Définitif</h2>
                                            <p class="text-base sm:text-lg text-slate-300 mb-4">Vous avez échoué au rattrapage avec une note de <strong class="text-red-400">{{ $makeupAttempt->score }}/20</strong>.</p>
                                            <p class="text-slate-400 max-w-lg mx-auto mb-8 px-4">Vous conservez l'accès aux vidéos de cette formation pour continuer à apprendre, mais vous ne pouvez plus prétendre au certificat.</p>
                                            
                                            <div class="bg-slate-800/50 border border-slate-700 p-6 sm:p-8 rounded-2xl inline-block max-w-md w-full mx-4">
                                                <h3 class="text-white font-bold mb-3">Réinitialiser les examens</h3>
                                                <p class="text-sm text-slate-400 mb-6">Pour pouvoir retenter votre chance aux examens, vous devez racheter la session.</p>
                                                <form action="{{ route('apprenant.checkout') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <input type="hidden" name="force_retake" value="1">
                                                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 rounded-xl transition-all">
                                                        Racheter l'examen ({{ number_format($course->price, 0, ',', ' ') }} FCFA)
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <!-- Echec sans rattrapage disponible -->
                                    <div class="text-center py-8 sm:py-12">
                                        <i class="fas fa-times-circle text-6xl sm:text-8xl text-slate-600 mb-6"></i>
                                        <h2 class="text-2xl sm:text-3xl font-head font-bold text-white mb-4">Échec à l'Évaluation</h2>
                                        <p class="text-base sm:text-lg text-slate-300 mb-4">Vous avez échoué à l'examen avec une note de <strong class="text-red-400">{{ $standardAttempt->score }}/20</strong>.</p>
                                        <p class="text-slate-400 max-w-lg mx-auto mb-8 px-4">Cet examen ne dispose pas de session de rattrapage. Vous conservez l'accès aux vidéos pour toujours.</p>
                                        
                                        <div class="bg-slate-800/50 border border-slate-700 p-6 sm:p-8 rounded-2xl inline-block max-w-md w-full mx-4">
                                            <h3 class="text-white font-bold mb-3">Retenter sa chance</h3>
                                            <p class="text-sm text-slate-400 mb-6">Vous devez vous réinscrire pour avoir le droit de repasser l'examen pour le certificat.</p>
                                            <form action="{{ route('apprenant.checkout') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <input type="hidden" name="force_retake" value="1">
                                                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 rounded-xl transition-all">
                                                    Racheter la session ({{ number_format($course->price, 0, ',', ' ') }} FCFA)
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="w-full bg-slate-800/50 backdrop-blur-sm border-b border-slate-700">
                <div class="max-w-5xl mx-auto px-4 sm:px-6">
                    <div class="flex space-x-6 sm:space-x-8">
                        <button class="tab-btn active py-3 sm:py-4 text-slate-400 hover:text-orange-500 font-medium transition-colors outline-none text-sm sm:text-base" onclick="switchTab('overview', this)">Aperçu</button>
                        <button class="tab-btn py-3 sm:py-4 text-slate-400 hover:text-orange-500 font-medium transition-colors outline-none text-sm sm:text-base" onclick="switchTab('resources', this)">Ressources</button>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="flex-grow bg-gradient-to-b from-slate-900 to-slate-800 p-4 sm:p-6 pb-20">
                <div class="max-w-5xl mx-auto">
                    <div id="tab-overview" class="tab-content" style="display: block;">
                        <h2 class="text-xl sm:text-2xl font-head font-bold text-white mb-2" id="current-title">Chargement...</h2>
                        <div class="flex flex-wrap items-center gap-2 text-sm text-slate-400 mb-6 sm:mb-8 border-b border-slate-700 pb-4">
                            <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-xs font-semibold" id="current-type">Vidéo</span>
                            <span class="text-slate-500">•</span>
                            <span><i class="fas fa-user-circle mr-1"></i>Auteur : {{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}</span>
                        </div>
                        <div class="prose prose-invert max-w-none">
                            <h3 class="text-base sm:text-lg font-bold text-white mb-3">À propos de ce cours</h3>
                            <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $course->description }}</p>
                        </div>
                    </div>
                    <div id="tab-resources" class="tab-content hidden">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-4">Ressources téléchargeables</h3>
                        <div class="bg-slate-800/50 rounded-xl border border-slate-700 p-6 sm:p-8 flex flex-col items-center justify-center text-center">
                            <i class="fas fa-folder-open text-4xl text-slate-600 mb-3"></i>
                            <p class="text-slate-400">Toutes les ressources mentionnées dans la leçon vidéo apparaîtront ici.</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
        
        <!-- Sidebar - Version mobile sans overlay -->
        <aside id="sidebar" class="sidebar-mobile bg-gradient-to-b from-slate-800 to-slate-900 border-l border-slate-700 flex flex-col flex-shrink-0 shadow-2xl">
            <div class="p-4 sm:p-5 border-b border-slate-700 bg-slate-800/90 sticky top-0 z-20 flex justify-between items-center">
                <div>
                    <h3 class="text-white font-head font-bold text-base sm:text-lg">Contenu du cours</h3>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-slate-400 font-medium">{{ $course->lessons->count() }} leçons</span>
                    </div>
                </div>
                <button id="close-sidebar-btn" class="lg:hidden w-8 h-8 rounded-lg bg-slate-700 text-slate-400 hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="overflow-y-auto custom-scrollbar flex-grow" id="playlist">
                @foreach($course->lessons as $index => $lesson)
                    @php $isCompleted = in_array($lesson->id, $completedLessonIds); @endphp
                    <div class="lesson-item border-b border-slate-700 hover:bg-slate-700/50 transition-all flex items-stretch group cursor-pointer" 
                         data-id="{{ $lesson->id }}"
                         data-type="{{ $lesson->type }}" 
                         data-url="{{ asset($lesson->file_path) }}" 
                         data-title="{{ $index + 1 }}. {{ $lesson->title }}"
                         onclick="playLesson(this)">
                        
                        <div class="w-12 flex items-center justify-center flex-shrink-0 border-r border-slate-700" onclick="toggleCompletion(event, this, {{ $lesson->id }})">
                            <div class="w-5 h-5 rounded border-2 {{ $isCompleted ? 'bg-emerald-500 border-emerald-500' : 'border-slate-500' }} flex items-center justify-center text-white transition-colors check-icon">
                                <i class="fas fa-check text-[10px] {{ $isCompleted ? 'opacity-100' : 'opacity-0' }} transition-opacity"></i>
                            </div>
                        </div>

                        <div class="p-3 sm:p-4 flex-grow flex items-start">
                            <div class="mt-0.5 text-slate-500 group-hover:text-orange-400 transition-colors w-6 flex-shrink-0 text-center">
                                @if($lesson->type == 'video')
                                    <i class="fas fa-play-circle" id="icon-{{ $lesson->id }}"></i>
                                @else
                                    <i class="fas fa-file-alt"></i>
                                @endif
                            </div>
                            <div class="ml-2 pr-2">
                                <h4 class="text-xs sm:text-sm font-medium text-slate-300 leading-snug lesson-title-text group-hover:text-white">{{ $index + 1 }}. {{ $lesson->title }}</h4>
                                <div class="text-xs text-slate-500 mt-1 flex items-center">
                                    <i class="fas fa-clock mr-1 opacity-50"></i> {{ $lesson->type == 'video' ? 'Vidéo' : 'Lecture' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                @if($standardQuiz)
                    <div class="lesson-item border-b border-slate-700 hover:bg-slate-700/50 transition-all flex items-center cursor-pointer" onclick="showQuiz(this)">
                        <div class="w-12 h-full py-4 sm:py-5 flex items-center justify-center flex-shrink-0 border-r border-slate-700">
                            @php
                                $finalPassed = false;
                                $finalFailed = false;
                                if($standardAttempt) {
                                    if($standardAttempt->passed) $finalPassed = true;
                                    else {
                                        if($makeupQuiz) {
                                            if($makeupAttempt && $makeupAttempt->passed) $finalPassed = true;
                                            if($makeupAttempt && !$makeupAttempt->passed) $finalFailed = true;
                                        } else {
                                            $finalFailed = true;
                                        }
                                    }
                                }
                            @endphp
                            
                            @if($finalPassed)
                                <div class="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center text-white">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                            @elseif($finalFailed)
                                <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center text-white">
                                    <i class="fas fa-times text-[10px]"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-3 sm:p-4 flex-grow flex items-center">
                            @if($finalFailed)
                                <div class="text-red-400 w-6 flex-shrink-0 text-center"><i class="fas fa-exclamation-triangle text-base sm:text-lg"></i></div>
                                <div class="ml-2 font-head font-bold text-red-400 text-sm sm:text-base">Résultat Échec</div>
                            @else
                                <div class="text-orange-500 w-6 flex-shrink-0 text-center"><i class="fas fa-award text-base sm:text-lg"></i></div>
                                <div class="ml-2 font-head font-bold text-orange-500 text-sm sm:text-base">Pôle d'Évaluation</div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </aside>
    </div>

    <script>
        // Mobile sidebar management - Version simplifiée sans overlay
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const closeSidebarBtn = document.getElementById('close-sidebar-btn');
        const sidebar = document.getElementById('sidebar');
        
        function openMobileSidebar() {
            if(window.innerWidth < 1024) {
                sidebar.classList.add('open');
                document.body.classList.add('menu-open');
            }
        }
        
        function closeMobileSidebar() {
            sidebar.classList.remove('open');
            document.body.classList.remove('menu-open');
        }
        
        if(mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', openMobileSidebar);
        }
        
        if(closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', closeMobileSidebar);
        }
        
        // Fermer avec la touche Echap
        document.addEventListener('keydown', function(event) {
            if(event.key === 'Escape' && sidebar.classList.contains('open')) {
                closeMobileSidebar();
            }
        });
        
        // Close sidebar on lesson click on mobile
        function closeSidebarIfMobile() {
            if(window.innerWidth < 1024) {
                closeMobileSidebar();
            }
        }
        
        setTimeout(() => { if(document.getElementById('flashInfo')) document.getElementById('flashInfo').style.display = 'none'; }, 4000);

        let completedLessons = {{ count($completedLessonIds) }};
        const totalLessons = {{ $course->lessons->count() }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let activeLessonId = null;

        function updateProgress() {
            if(totalLessons === 0) return;
            const percentage = Math.round((completedLessons / totalLessons) * 100);
            document.getElementById('progress-text').textContent = percentage + '% complété';
            document.getElementById('progress-bar').style.width = percentage + '%';
        }
        updateProgress();

        function toggleCompletion(event, el, lessonId) {
            event.stopPropagation();
            const checkIcon = el.querySelector('.check-icon');
            const iconMarker = checkIcon.querySelector('i');
            const isCurrentlyCompleted = checkIcon.classList.contains('bg-emerald-500');
            const newStatus = !isCurrentlyCompleted;
            
            if (newStatus) {
                checkIcon.classList.add('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.remove('border-slate-500');
                iconMarker.classList.remove('opacity-0');
                iconMarker.classList.add('opacity-100');
                completedLessons = Math.min(totalLessons, completedLessons + 1);
            } else {
                checkIcon.classList.remove('bg-emerald-500', 'border-emerald-500');
                checkIcon.classList.add('border-slate-500');
                iconMarker.classList.remove('opacity-100');
                iconMarker.classList.add('opacity-0');
                completedLessons = Math.max(0, completedLessons - 1);
            }
            updateProgress();

            fetch(`/apprenant/lessons/${lessonId}/complete`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ completed: newStatus })
            });
        }

        function onVideoEnded() {
            if(!activeLessonId) return;
            const container = document.querySelector(`.lesson-item[data-id="${activeLessonId}"]`);
            if(container) {
                const checkBlock = container.querySelector('.w-12');
                const checkIcon = checkBlock.querySelector('.check-icon');
                if(!checkIcon.classList.contains('bg-emerald-500')) {
                    toggleCompletion({stopPropagation:()=>{}}, checkBlock, activeLessonId);
                }
            }
        }

        function playLesson(container) {
            document.querySelectorAll('.lesson-item').forEach(b => {
                b.classList.remove('active', 'border-l-4', 'border-orange-500');
                b.style.borderLeft = '';
            });
            container.classList.add('active');
            container.style.borderLeft = '4px solid #F97316';
            
            const id = container.getAttribute('data-id');
            const title = container.getAttribute('data-title');
            const url = container.getAttribute('data-url');
            const type = container.getAttribute('data-type');
            activeLessonId = id;
            
            document.getElementById('current-title').textContent = title;
            document.getElementById('current-type').textContent = type === 'video' ? 'Leçon Vidéo' : 'Support Documentaire';
            document.getElementById('quiz-overlay').classList.add('hidden');
            
            const player = document.getElementById('main-player');
            if(player && type === 'video') {
                player.style.display = 'block';
                document.getElementById('video-source').setAttribute('src', url);
                player.load();
                player.play();
                switchTab('overview');
            } else if (type !== 'video') {
                if(player) player.pause();
                window.open(url, '_blank');
            }
            
            closeSidebarIfMobile();
        }
        
        window.addEventListener('DOMContentLoaded', () => {
            if (localStorage.getItem('forceShowQuiz') === 'true') {
                localStorage.removeItem('forceShowQuiz');
                const quizBtn = document.querySelector('.lesson-item[onclick*="showQuiz"]');
                if (quizBtn) {
                    showQuiz(quizBtn);
                    return;
                }
            }

            const firstLesson = document.querySelector('.lesson-item[data-url]');
            if (firstLesson) {
                playLesson(firstLesson);
                const player = document.getElementById('main-player');
                if(player) player.pause();
            }
        });

        function showQuiz(container) {
            const player = document.getElementById('main-player');
            if(player) {
                player.pause();
                player.style.display = 'none';
            }
            document.getElementById('quiz-overlay').classList.remove('hidden');
            document.getElementById('current-title').textContent = "Pôle d'Évaluation";
            document.getElementById('current-type').textContent = "Système de certification";
            document.querySelectorAll('.lesson-item').forEach(b => b.classList.remove('active'));
            if(container) {
                container.classList.add('active');
                container.style.borderLeft = '4px solid #F97316';
            }
            closeSidebarIfMobile();
        }

        function submitQuizContent(e, form) {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const resultBox = form.querySelector('#quiz-result') || Array.from(form.parentNode.children).find(el => el.id === 'quiz-result');
            const quizId = form.getAttribute('data-quiz-id');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Calcul en cours...';
            
            const formData = new FormData(form);
            const plainFormData = Object.fromEntries(formData.entries());
            
            fetch(`/apprenant/quizzes/${quizId}/submit`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify(plainFormData)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    form.querySelectorAll('input[type="radio"]').forEach(radio => {
                        const label = radio.closest('.quiz-option-label');
                        if(radio.checked) {
                            label.classList.add(radio.value === '1' ? 'bg-emerald-500/20' : 'bg-red-500/20', radio.value === '1' ? 'border-emerald-500' : 'border-red-500');
                            label.classList.remove('border-slate-700');
                        }
                        if(radio.value === '1') {
                             label.innerHTML += ' <i class="fas fa-check-circle text-emerald-400 ml-auto text-lg sm:text-xl"></i>';
                        }
                        radio.disabled = true;
                    });
                    
                    submitBtn.style.display = 'none';
                    
                    if (!resultBox) {
                        location.reload();
                    } else {
                        resultBox.classList.remove('hidden');
                        const passed = data.passed;
                        resultBox.innerHTML = `
                            <div class="text-5xl sm:text-6xl font-head font-bold ${passed ? 'text-emerald-400' : 'text-red-400'} mb-4">${data.score}/20</div>
                            <div class="text-white text-base sm:text-lg font-medium">${data.correct} bonne(s) réponse(s) sur ${data.total}</div>
                            <div class="mt-6 p-4 ${passed ? 'bg-emerald-500/20 border-emerald-500/30' : 'bg-red-500/20 border-red-500/30'} border rounded-xl">
                                <span class="text-base sm:text-lg font-bold ${passed ? 'text-emerald-300' : 'text-red-300'}">${data.message}</span>
                            </div>
                            <button onclick="${passed ? 'location.reload()' : 'localStorage.setItem(&quot;forceShowQuiz&quot;, &quot;true&quot;); location.reload()'}" class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">${passed ? 'Continuer' : 'Passer au Rattrapage'}</button>
                        `;
                    }
                } else {
                    alert(data.message || 'Une erreur est survenue.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Réessayer';
                }
            })
            .catch(err => console.error(err));
        }

        function switchTab(tabId, el) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
            if (el) el.classList.add('active');
            document.getElementById('tab-' + tabId).style.display = 'block';
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if(window.innerWidth >= 1024) {
                closeMobileSidebar();
            }
        });
    </script>
</body>
</html>