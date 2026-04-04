@extends('layouts.formateur')

@section('title', 'Aperçu : ' . $course->title)

@section('content')
    <!-- Header Bandeau -->
    <div
        class="bg-gradient-to-r from-navy-900 to-navy-800 rounded-2xl shadow-xl p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center transition-all duration-300 border border-orange-500/20">
        <div>
            <a href="{{ route('formateur.dashboard') }}"
                class="text-navy-300 hover:text-orange-400 flex items-center mb-3 text-sm font-medium transition-colors group">
                <i class="fas fa-arrow-left mr-2 text-navy-400 group-hover:text-orange-400 transition-colors"></i>
                <span>Retour au catalogue</span>
            </a>
            <h1
                class="text-3xl lg:text-4xl font-head font-bold text-white flex items-center flex-wrap gap-4 tracking-tight">
                {{ $course->title }}

                @if($course->status == 'approved')
                    <span
                        class="bg-emerald-500/20 text-emerald-300 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0 border border-emerald-500/30">
                        <i class="fas fa-check-circle mr-1.5 text-emerald-400"></i> Publié
                    </span>
                @elseif($course->status == 'pending')
                    <span
                        class="bg-amber-500/20 text-amber-300 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0 border border-amber-500/30">
                        <i class="fas fa-hourglass-half mr-1.5 text-amber-400"></i> En attente de validation
                    </span>
                @else
                    <span
                        class="bg-red-500/20 text-red-300 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0 border border-red-500/30">
                        <i class="fas fa-times-circle mr-1.5 text-red-400"></i> Rejeté
                    </span>
                @endif
            </h1>

            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-4 text-white/70 font-medium text-sm">
                <span class="flex items-center"><i class="fas fa-shapes text-orange-400 mr-2 w-4"></i>
                    {{ $course->category->name ?? 'Catégorie Générale' }}</span>
                <span class="flex items-center"><i class="far fa-clock text-orange-400 mr-2 w-4"></i>
                    {{ $course->duration_minutes }} min estimées</span>
                <span class="flex items-center text-orange-400 font-bold"><i class="fas fa-coins text-amber-400 mr-2 w-4"></i>
                    {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Formation Gratuite' }}</span>
            </div>
        </div>

        @if($course->status !== 'approved')
            <div class="mt-6 md:mt-0 flex-shrink-0">
                <a href="{{ route('formateur.courses.edit', $course) }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg hover:shadow-orange-500/30 flex items-center gap-2">
                    <i class="fas fa-pen-nib text-sm"></i> Modifier la formation
                </a>
            </div>
        @endif
    </div>

    @php 
        $standardQuiz = $course->quizzes->where('type', 'standard')->first();
        $makeupQuiz = $course->quizzes->where('type', 'makeup')->first();
        $firstLesson = $course->lessons->first();
        $firstVideo = $course->lessons->where('type', 'video')->first();
    @endphp

    <!-- Main UI Layout: 2/3 Player & Tabs | 1/3 Sidebar Playlist -->
    <div class="flex flex-col lg:flex-row gap-8 mb-12">

        <!-- Colonne Gauche: Lecteur et Onglets -->
        <div class="w-full lg:w-2/3 flex flex-col">

            <!-- Conteneur du Lecteur -->
            <div class="bg-navy-950 rounded-2xl shadow-2xl overflow-hidden relative group border border-orange-500/30">
                <div class="aspect-video w-full relative flex items-center justify-center bg-black"
                    id="player-container">
                    @if($course->cover_video)
                        <div id="cover-video-layer"
                            class="w-full h-full absolute inset-0 z-20 bg-black cursor-pointer group/video"
                            onclick="document.getElementById('cover-video-layer').style.display='none'; const p = document.getElementById('main-player'); if(p) p.play();">
                            <video autoplay loop muted playsinline class="w-full h-full object-cover opacity-80">
                                <source src="{{ asset($course->cover_video) }}" type="video/mp4">
                            </video>
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover/video:opacity-100 transition-all duration-300">
                                <div
                                    class="bg-orange-500 text-white w-20 h-20 rounded-full flex items-center justify-center shadow-2xl transform transition-transform duration-300 scale-90 group-hover/video:scale-100">
                                    <i class="fas fa-play text-3xl ml-1"></i>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($course->lessons->count() > 0)
                        @if($firstVideo)
                            <video id="main-player" controls class="w-full h-full outline-none"
                                poster="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}">
                                <source src="{{ asset($firstVideo->file_path) }}" type="video/mp4" id="video-source">
                                Votre navigateur ne supporte pas la vidéo.
                            </video>
                        @endif

                        @if((!$firstVideo && $firstLesson && $firstLesson->type !== 'video'))
                            <div id="document-preview"
                                class="w-full h-full flex flex-col items-center justify-center absolute inset-0 bg-navy-950 z-20">
                                <div class="w-24 h-24 bg-orange-500/20 rounded-2xl flex items-center justify-center mb-6">
                                    <i class="fas fa-file-pdf text-5xl text-orange-500"></i>
                                </div>
                                <h3 class="text-2xl text-white font-head font-bold mb-2">Document pédagogique</h3>
                                <p class="text-white/60 mb-6 text-sm">Cliquez sur le bouton ci-dessous pour consulter le document
                                </p>
                                <a href="{{ asset($firstLesson->file_path) }}" target="_blank" id="doc-link"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-semibold shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <i class="fas fa-download"></i> Ouvrir le document
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-white/50">
                            <div class="w-24 h-24 bg-navy-800 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-film text-5xl opacity-40"></i>
                            </div>
                            <p class="font-medium">Aucun contenu multimédia</p>
                        </div>
                    @endif
                </div>

                <!-- Barre de Titre -->
                <div
                    class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/80 via-black/30 to-transparent pt-6 pb-12 px-6 flex justify-between items-start opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    <h3 class="text-white font-head font-semibold text-base drop-shadow-md truncate max-w-[70%]"
                        id="current-video-title">
                        {{ $firstVideo ? '1. ' . $firstVideo->title : ($firstLesson ? 'Document Initial' : 'Formation Vide') }}
                    </h3>
                    <span
                        class="bg-orange-500 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full shadow-lg">
                        Mode Aperçu
                    </span>
                </div>
            </div>

            <!-- Onglets Contenu -->
            <div class="mt-8 bg-navy-900 rounded-2xl shadow-xl border border-orange-500/20 overflow-hidden">
                <!-- Navigation des Onglets -->
                <div class="flex border-b border-navy-700 px-6 bg-navy-900">
                    <button
                        class="tab-btn active py-4 px-5 font-head font-semibold text-orange-500 border-b-2 border-orange-500 hover:text-orange-400 transition-all duration-200 text-sm"
                        onclick="switchTab('about', this)">
                        <i class="fas fa-align-left mr-2"></i>À propos du cours
                    </button>
                    <button
                        class="tab-btn py-4 px-5 font-head font-semibold text-white/60 border-b-2 border-transparent hover:text-orange-400 transition-all duration-200 text-sm"
                        onclick="switchTab('evaluations', this)">
                        <i class="fas fa-gavel mr-2"></i>Détail des Examens
                    </button>
                </div>

                <!-- Contenus -->
                <div class="p-6 lg:p-8">
                    <!-- Onglet 1: À Propos -->
                    <div id="tab-about" class="tab-content block animate-fade-in">
                        <h2 class="text-2xl font-head font-bold text-orange-500 mb-6 tracking-tight">Description détaillée
                        </h2>
                        <div class="prose prose-invert prose-slate max-w-none text-white/80 whitespace-pre-line leading-relaxed">
                            {{ $course->description }}
                        </div>
                    </div>

                    <!-- Onglet 2: Détail des Examens -->
                    <div id="tab-evaluations" class="tab-content hidden animate-fade-in">

                        <div class="space-y-6">
                            <!-- Examen Standard -->
                            <div class="bg-navy-800/50 rounded-xl border border-emerald-500/30 p-6 lg:p-7 transition-all duration-300 hover:border-emerald-500/60 hover:shadow-lg"
                                id="card-standard">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-navy-700">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center mr-3">
                                            <i class="fas fa-award text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-head font-bold text-emerald-400 text-lg">Examen Standard</h3>
                                            <p class="text-xs text-white/50 mt-0.5">Évaluation de fin de formation</p>
                                        </div>
                                    </div>
                                    @if($standardQuiz)
                                        <span
                                            class="bg-emerald-500/20 text-emerald-400 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm inline-flex items-center gap-1 border border-emerald-500/30">
                                            <i class="fas fa-chart-line text-xs"></i> Seuil :
                                            {{ $standardQuiz->passing_score }}/20
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($standardQuiz && $standardQuiz->questions->count() > 0)
                                        <div class="space-y-4">
                                            @foreach($standardQuiz->questions as $index => $q)
                                                <div
                                                    class="bg-navy-900/50 rounded-lg border border-navy-700 p-5 hover:border-emerald-500/30 transition-all duration-200">
                                                    <div class="flex items-start gap-3 mb-3">
                                                        <span
                                                            class="flex-shrink-0 w-7 h-7 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold flex items-center justify-center">{{ $index + 1 }}</span>
                                                        <p class="font-semibold text-white text-sm leading-relaxed flex-1">
                                                            {{ $q->question_text }}</p>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3 pl-10">
                                                        @foreach($q->options as $opt)
                                                            <div
                                                                class="flex items-center text-xs p-2 rounded-lg {{ $opt->is_correct ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-navy-800/50 text-white/60 border border-navy-700' }}">
                                                                @if($opt->is_correct)
                                                                    <i
                                                                        class="fas fa-check-circle text-emerald-500 mr-2 text-xs flex-shrink-0"></i>
                                                                @else
                                                                    <i class="far fa-circle text-white/40 mr-2 text-xs flex-shrink-0"></i>
                                                                @endif
                                                                <span class="truncate">{{ $opt->option_text }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3 py-8 text-white/50 justify-center">
                                            <i class="fas fa-inbox text-3xl opacity-40"></i>
                                            <span class="font-medium">Aucun examen standard généré</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Examen de Rattrapage -->
                            <div class="bg-navy-800/50 rounded-xl border border-red-500/30 p-6 lg:p-7 transition-all duration-300 hover:border-red-500/60 hover:shadow-lg"
                                id="card-makeup">
                                <div
                                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-navy-700">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center mr-3">
                                            <i class="fas fa-life-ring text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-head font-bold text-red-400 text-lg">Session Rattrapage</h3>
                                            <p class="text-xs text-white/50 mt-0.5">Seconde chance pour les apprenants</p>
                                        </div>
                                    </div>
                                    @if($makeupQuiz)
                                        <span
                                            class="bg-red-500/20 text-red-400 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm inline-flex items-center gap-1 border border-red-500/30">
                                            <i class="fas fa-chart-line text-xs"></i> Seuil :
                                            {{ $makeupQuiz->passing_score }}/20
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    @if($makeupQuiz && $makeupQuiz->questions->count() > 0)
                                        <div class="space-y-4">
                                            @foreach($makeupQuiz->questions as $index => $q)
                                                <div
                                                    class="bg-navy-900/50 rounded-lg border border-navy-700 p-5 hover:border-red-500/30 transition-all duration-200">
                                                    <div class="flex items-start gap-3 mb-3">
                                                        <span
                                                            class="flex-shrink-0 w-7 h-7 rounded-full bg-red-500/20 text-red-400 text-xs font-bold flex items-center justify-center">{{ $index + 1 }}</span>
                                                        <p class="font-semibold text-white text-sm leading-relaxed flex-1">
                                                            {{ $q->question_text }}</p>
                                                    </div>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3 pl-10">
                                                        @foreach($q->options as $opt)
                                                            <div
                                                                class="flex items-center text-xs p-2 rounded-lg {{ $opt->is_correct ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-navy-800/50 text-white/60 border border-navy-700' }}">
                                                                @if($opt->is_correct)
                                                                    <i
                                                                        class="fas fa-check-circle text-red-500 mr-2 text-xs flex-shrink-0"></i>
                                                                @else
                                                                    <i class="far fa-circle text-white/40 mr-2 text-xs flex-shrink-0"></i>
                                                                @endif
                                                                <span class="truncate">{{ $opt->option_text }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div
                                            class="flex flex-col sm:flex-row items-center gap-4 py-8 text-white/50 justify-center text-center">
                                            <i class="fas fa-shield-alt text-4xl opacity-40"></i>
                                            <div>
                                                <p class="font-medium">Aucun rattrapage configuré</p>
                                                <p class="text-xs opacity-70 mt-1">L'apprenant n'aura qu'une seule chance de
                                                    valider la formation</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Droite: Sommaire du cours -->
        <div class="w-full lg:w-1/3 flex flex-col">
            <div class="bg-navy-900 rounded-2xl shadow-xl border border-orange-500/20 overflow-hidden flex flex-col sticky top-8"
                style="max-height: calc(100vh - 8rem);">
                <!-- Header du menu -->
                <div class="p-5 bg-gradient-to-r from-navy-800 to-navy-900 border-b border-navy-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-white font-head font-bold text-lg">Sommaire</h3>
                        <span
                            class="text-xs text-white/50 font-medium bg-navy-800 px-2.5 py-1 rounded-full border border-navy-700">{{ $course->lessons->count() }}
                            leçon(s)</span>
                    </div>
                    <div class="w-full bg-navy-800 rounded-full h-1.5 mt-3">
                        <div class="bg-orange-500 rounded-full h-1.5 transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Liste Scrollable -->
                <div class="overflow-y-auto flex-grow p-3 space-y-1.5 bg-navy-900" style="scrollbar-width: thin;">
                    @forelse($course->lessons as $index => $lesson)
                        <button
                            class="lesson-item w-full text-left p-3 rounded-xl transition-all duration-200 flex items-start gap-3 lesson-btn {{ $index === 0 ? 'bg-navy-800 border-l-4 border-l-orange-500 shadow-lg' : 'hover:bg-navy-800 border-l-4 border-l-transparent' }}"
                            data-type="{{ $lesson->type }}" data-url="{{ asset($lesson->file_path) }}"
                            data-title="{{ $index + 1 }}. {{ $lesson->title }}" onclick="previewLesson(this)">

                            <div
                                class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center transition-all duration-200 {{ $index === 0 ? 'bg-orange-500 text-white shadow-md' : 'bg-navy-800 text-white/50 group-hover:bg-orange-500/20 group-hover:text-orange-400' }}">
                                @if($lesson->type == 'video')
                                    <i class="fas fa-play text-xs ml-0.5"></i>
                                @else
                                    <i class="fas fa-file-pdf text-xs"></i>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <h4
                                    class="text-sm font-semibold leading-snug {{ $index === 0 ? 'text-orange-400' : 'text-white/80' }} transition-colors line-clamp-2">
                                    {{ $index + 1 }}. {{ $lesson->title }}
                                </h4>
                                <span
                                    class="text-[10px] font-medium uppercase tracking-wide mt-1 block {{ $index === 0 ? 'text-orange-500' : 'text-white/40' }}">
                                    {{ $lesson->type == 'video' ? 'Vidéo' : 'Document' }}
                                </span>
                            </div>
                        </button>
                    @empty
                        <div class="text-center py-12 px-4 text-white/40">
                            <i class="fas fa-inbox text-5xl mb-4 opacity-30"></i>
                            <p class="text-sm font-medium">Programme vide</p>
                            <p class="text-xs mt-1">Ajoutez des leçons depuis l'édition</p>
                        </div>
                    @endforelse

                    @if($standardQuiz || $makeupQuiz)
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-navy-700"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span
                                    class="bg-navy-900 px-3 text-[10px] font-semibold text-white/40 uppercase tracking-wider">Évaluations</span>
                            </div>
                        </div>
                    @endif

                    @if($standardQuiz)
                        <button
                            class="lesson-item w-full text-left p-3 rounded-xl transition-all duration-200 flex items-start gap-3 hover:bg-navy-800 border-l-4 border-l-transparent hover:border-l-emerald-500"
                            onclick="previewQuiz('standard', this)">
                            <div
                                class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center bg-navy-800 text-emerald-400 group-hover:bg-emerald-500/20 transition-all duration-200">
                                <i class="fas fa-award text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-white/80 leading-snug">Examen Standard</h4>
                                <span class="text-[10px] font-medium uppercase tracking-wide mt-1 block text-emerald-400">Test
                                    final</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-white/30 self-center"></i>
                        </button>
                    @endif

                    @if($makeupQuiz)
                        <button
                            class="lesson-item w-full text-left p-3 rounded-xl transition-all duration-200 flex items-start gap-3 hover:bg-navy-800 border-l-4 border-l-transparent hover:border-l-red-500"
                            onclick="previewQuiz('makeup', this)">
                            <div
                                class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center bg-navy-800 text-red-400 group-hover:bg-red-500/20 transition-all duration-200">
                                <i class="fas fa-life-ring text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-white/80 leading-snug">Session Rattrapage</h4>
                                <span class="text-[10px] font-medium uppercase tracking-wide mt-1 block text-red-400">2ème
                                    chance</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-white/30 self-center"></i>
                        </button>
                    @endif
                </div>

                <!-- Footer du sommaire -->
                <div class="p-4 border-t border-navy-700 bg-navy-800/50">
                    <div class="flex items-center justify-between text-xs text-white/50">
                        <span><i class="far fa-check-circle mr-1"></i>
                            {{ $course->lessons->where('type', 'video')->count() }} vidéos</span>
                        <span><i class="far fa-file-alt mr-1"></i>
                            {{ $course->lessons->where('type', 'document')->count() }} documents</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Scrollbar personnalisée */
        .overflow-y-auto::-webkit-scrollbar {
            width: 5px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 10px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }

        /* Animation fade */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fadeIn 0.35s ease-out forwards;
        }

        /* Amélioration du lecteur vidéo */
        video::-webkit-media-controls-panel {
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4));
        }

        /* Transitions fluides */
        .lesson-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Prose styling pour texte blanc */
        .prose p {
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.8);
        }
        .prose strong {
            color: #F97316;
            font-weight: 600;
        }
    </style>

    <script>
        // Gestion des onglets
        function switchTab(tabId, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'border-orange-500', 'text-orange-500');
                b.classList.add('border-transparent', 'text-white/60');
            });
            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');

            if (btn) {
                btn.classList.add('active', 'border-orange-500', 'text-orange-500');
                btn.classList.remove('border-transparent', 'text-white/60');
            }
            document.getElementById('tab-' + tabId).style.display = 'block';
        }

        function resetButtonsDesign() {
            document.querySelectorAll('.lesson-btn').forEach(b => {
                b.classList.remove('bg-navy-800', 'border-l-orange-500', 'border-l-emerald-500', 'border-l-red-500');
                b.classList.add('border-l-transparent');

                const iconContainer = b.querySelector('.rounded-lg');
                if (iconContainer) {
                    if (b.innerText.includes('Examen Standard')) {
                        iconContainer.classList.remove('bg-emerald-500/20');
                        iconContainer.classList.add('bg-navy-800', 'text-emerald-400');
                    } else if (b.innerText.includes('Rattrapage')) {
                        iconContainer.classList.remove('bg-red-500/20');
                        iconContainer.classList.add('bg-navy-800', 'text-red-400');
                    } else {
                        iconContainer.classList.remove('bg-orange-500', 'text-white');
                        iconContainer.classList.add('bg-navy-800', 'text-white/50');
                    }
                }

                const titleH4 = b.querySelector('h4');
                if (titleH4) {
                    titleH4.classList.remove('text-orange-400', 'text-emerald-400', 'text-red-400');
                    titleH4.classList.add('text-white/80');
                }
            });
        }

        function previewLesson(btn) {
            resetButtonsDesign();

            btn.classList.add('bg-navy-800', 'border-l-orange-500');
            btn.classList.remove('border-l-transparent');

            const iconContainer = btn.querySelector('.rounded-lg');
            if (iconContainer) {
                iconContainer.classList.remove('bg-navy-800', 'text-white/50');
                iconContainer.classList.add('bg-orange-500', 'text-white');
            }
            const titleH4 = btn.querySelector('h4');
            if (titleH4) titleH4.classList.replace('text-white/80', 'text-orange-400');

            const title = btn.getAttribute('data-title');
            const url = btn.getAttribute('data-url');
            const type = btn.getAttribute('data-type');

            document.getElementById('current-video-title').textContent = title;

            const coverVideo = document.getElementById('cover-video-layer');
            if (coverVideo) coverVideo.style.display = 'none';

            const quizPreview = document.getElementById('quiz-placeholder');
            if (quizPreview) {
                quizPreview.style.display = 'none';
            }

            const player = document.getElementById('main-player');

            if (type === 'video') {
                if (player) {
                    player.style.display = 'block';
                    document.getElementById('video-source').setAttribute('src', url);
                    player.load();
                    player.play();
                }

                const docPreview = document.getElementById('document-preview');
                if (docPreview) docPreview.style.display = 'none';

            } else {
                if (player) {
                    player.pause();
                    player.style.display = 'none';
                }

                let docPreview = document.getElementById('document-preview');
                if (!docPreview && document.getElementById('player-container')) {
                    docPreview = document.createElement('div');
                    docPreview.id = 'document-preview';
                    docPreview.className = 'w-full h-full flex flex-col items-center justify-center absolute inset-0 bg-navy-950 z-20';
                    docPreview.innerHTML = `
                        <div class="w-24 h-24 bg-orange-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-file-pdf text-5xl text-orange-500"></i>
                        </div>
                        <h3 class="text-2xl text-white font-head font-bold mb-2">Document pédagogique</h3>
                        <p class="text-white/60 mb-6 text-sm">Cliquez sur le bouton ci-dessous pour consulter le document</p>
                        <a href="${url}" target="_blank" id="doc-link" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-semibold shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fas fa-download"></i> Ouvrir le document
                        </a>
                    `;
                    document.getElementById('player-container').appendChild(docPreview);
                } else if (docPreview) {
                    docPreview.style.display = 'flex';
                    const link = document.getElementById('doc-link');
                    if (link) link.setAttribute('href', url);
                }
            }

            switchTab('about', document.querySelectorAll('.tab-btn')[0]);
        }

        function previewQuiz(type, btn) {
            resetButtonsDesign();

            if (type === 'standard') {
                btn.classList.add('bg-navy-800', 'border-l-emerald-500');
                const iconContainer = btn.querySelector('.rounded-lg');
                if (iconContainer) {
                    iconContainer.classList.remove('bg-navy-800', 'text-emerald-400');
                    iconContainer.classList.add('bg-emerald-500/20', 'text-emerald-400');
                }
                const titleH4 = btn.querySelector('h4');
                if (titleH4) titleH4.classList.replace('text-white/80', 'text-emerald-400');
            } else {
                btn.classList.add('bg-navy-800', 'border-l-red-500');
                const iconContainer = btn.querySelector('.rounded-lg');
                if (iconContainer) {
                    iconContainer.classList.remove('bg-navy-800', 'text-red-400');
                    iconContainer.classList.add('bg-red-500/20', 'text-red-400');
                }
                const titleH4 = btn.querySelector('h4');
                if (titleH4) titleH4.classList.replace('text-white/80', 'text-red-400');
            }

            document.getElementById('current-video-title').textContent = type === 'standard' ? 'Examen Standard' : 'Session Rattrapage';

            const coverVideo = document.getElementById('cover-video-layer');
            if (coverVideo) coverVideo.style.display = 'none';

            const player = document.getElementById('main-player');
            if (player) {
                player.pause();
                player.style.display = 'none';
            }

            const docPreview = document.getElementById('document-preview');
            if (docPreview) {
                docPreview.style.display = 'none';
            }

            let quizPreview = document.getElementById('quiz-placeholder');
            if (!quizPreview) {
                quizPreview = document.createElement('div');
                quizPreview.id = 'quiz-placeholder';
                quizPreview.className = 'w-full h-full flex flex-col items-center justify-center absolute inset-0 bg-navy-950 z-30 animate-fade-in';
                const container = document.getElementById('player-container');
                if (container) container.appendChild(quizPreview);
            }

            if (quizPreview) {
                quizPreview.style.display = 'flex';
                if (type === 'standard') {
                    quizPreview.innerHTML = `
                        <div class="w-24 h-24 bg-emerald-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-award text-5xl text-emerald-500"></i>
                        </div>
                        <h3 class="text-2xl text-white font-head font-bold mb-2">Examen de Qualification</h3>
                        <p class="text-white/60 mb-6 text-center max-w-sm">Cette évaluation couvre l'ensemble du curriculum enseigné.</p>
                        <button onclick="document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500 hover:text-white rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-eye"></i> Voir les questions
                        </button>
                    `;
                } else {
                    quizPreview.innerHTML = `
                        <div class="w-24 h-24 bg-red-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-life-ring text-5xl text-red-500"></i>
                        </div>
                        <h3 class="text-2xl text-white font-head font-bold mb-2">Examen de Rattrapage</h3>
                        <p class="text-white/60 mb-6 text-center max-w-sm">Cette session de seconde chance est proposée aux apprenants ayant échoué.</p>
                        <button onclick="document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });" class="inline-flex items-center gap-2 px-6 py-3 bg-red-500/20 text-red-400 border border-red-500/30 hover:bg-red-500 hover:text-white rounded-xl font-semibold transition-all duration-200">
                            <i class="fas fa-eye"></i> Voir les questions
                        </button>
                    `;
                }
            }

            switchTab('evaluations', document.querySelectorAll('.tab-btn')[1]);

            const targetCard = type === 'standard' ? document.getElementById('card-standard') : document.getElementById('card-makeup');
            if (targetCard) {
                document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });
                targetCard.classList.add('ring-2', type === 'standard' ? 'ring-emerald-500' : 'ring-red-500', 'ring-opacity-60', 'shadow-lg');
                setTimeout(() => {
                    targetCard.classList.remove('ring-2', type === 'standard' ? 'ring-emerald-500' : 'ring-red-500', 'ring-opacity-60', 'shadow-lg');
                }, 1000);
            }
        }
    </script>
@endsection