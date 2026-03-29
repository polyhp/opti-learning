@extends('layouts.formateur')

@section('title', 'Aperçu : ' . $course->title)

@section('content')
<!-- Header Bandeau -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
    <div>
        <a href="{{ route('formateur.dashboard') }}" class="text-slate-400 hover:text-orange-500 flex items-center mb-3 text-sm font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Retour au catalogue
        </a>
        <h1 class="text-3xl font-head font-extrabold text-navy-900 flex items-center flex-wrap gap-4">
            {{ $course->title }}
            
            @if($course->status == 'approved')
                <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0">
                    <i class="fas fa-check-circle mr-1.5"></i> Publié
                </span>
            @elseif($course->status == 'pending')
                <span class="bg-amber-100 text-amber-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0">
                    <i class="fas fa-hourglass-half mr-1.5"></i> En attente de validation
                </span>
            @else
                <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center flex-shrink-0">
                    <i class="fas fa-times-circle mr-1.5"></i> Rejeté
                </span>
            @endif
        </h1>
        
        <div class="flex items-center space-x-6 mt-4 text-slate-500 font-medium text-sm">
            <span class="flex items-center"><i class="fas fa-shapes text-orange-400 mr-2"></i> {{ $course->category->name ?? 'Catégorie Générale' }}</span>
            <span class="flex items-center"><i class="fas fa-stopwatch text-orange-400 mr-2"></i> {{ $course->duration_minutes }} min estimées</span>
            <span class="flex items-center text-navy-800 font-bold"><i class="fas fa-coins text-amber-500 mr-2"></i> {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Formation Gratuite' }}</span>
        </div>
    </div>
    
    @if($course->status !== 'approved')
    <div class="mt-6 md:mt-0 flex-shrink-0">
        <a href="{{ route('formateur.dashboard') }}" class="bg-navy-900 hover:bg-navy-800 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg flex items-center border border-navy-700">
            <i class="fas fa-pen-nib mr-2"></i> Modifier la formation
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
        
        <!-- Conteneur du Lecteur (Masterclass) -->
        <div class="bg-navy-950 rounded-3xl shadow-xl overflow-hidden relative group border border-navy-900">
            <div class="aspect-video w-full relative flex items-center justify-center bg-black" id="player-container">
                @if($course->lessons->count() > 0)
                    @if($firstVideo)
                        <video id="main-player" controls class="w-full h-full outline-none" poster="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}">
                            <source src="{{ asset($firstVideo->file_path) }}" type="video/mp4" id="video-source">
                            Votre navigateur ne supporte pas la vidéo.
                        </video>
                    @endif
                    
                    @if((!$firstVideo && $firstLesson && $firstLesson->type !== 'video'))
                        <div id="document-preview" class="w-full h-full flex flex-col items-center justify-center text-slate-400 absolute inset-0 bg-navy-950 z-20">
                            <i class="fas fa-file-pdf text-7xl mb-4 text-orange-500 drop-shadow-lg"></i>
                            <h3 class="text-2xl text-white font-head font-bold mb-2">Support Documentaire</h3>
                            <a href="{{ asset($firstLesson->file_path) }}" target="_blank" id="doc-link" class="mt-4 px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold shadow-lg transition-all transform hover:-translate-y-1">
                                Ouvrir le document
                            </a>
                        </div>
                    @else
                        <!-- Le conteneur doc est injecté dynamiquement en JS si la toute première vue est une vidéo -->
                    @endif
                @else
                    <div class="text-center text-slate-500">
                        <i class="fas fa-film text-6xl mb-4 opacity-30"></i>
                        <p class="font-medium">Aucun contenu multimédia</p>
                    </div>
                @endif
                
                <!-- Zone réservée aux Aperçus de Quiz (Injectés en JS via id="quiz-placeholder") -->
            </div>
            
            <!-- Barre de Titre (Overlay stylé au hover) -->
            <div class="absolute top-0 w-full bg-gradient-to-b from-black/80 to-transparent pt-6 pb-12 px-6 flex justify-between items-start opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <h3 class="text-white font-head font-bold text-lg drop-shadow-md truncate max-w-[80%]" id="current-video-title">
                    {{ $firstVideo ? '1. ' . $firstVideo->title : ($firstLesson ? 'Document Initial' : 'Formation Vide') }}
                </h3>
                <span class="bg-orange-500 text-white text-[10px] font-bold uppercase tracking-widest px-2 py-1 flex-shrink-0 rounded shadow-sm">
                    Aperçu Formateur
                </span>
            </div>
        </div>
        
        <!-- Onglets Contenu (À propos / Évaluations) -->
        <div class="mt-8 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex-grow relative z-10">
            <!-- Navigation des Onglets -->
            <div class="flex border-b border-slate-100 px-6 sm:px-8 bg-slate-50/50">
                <button class="tab-btn active py-5 px-4 font-head font-bold text-navy-900 border-b-2 border-orange-500 hover:text-orange-600 transition-colors" onclick="switchTab('about', this)">
                    <i class="fas fa-align-left text-orange-500 mr-2"></i>À propos du cours
                </button>
                <button class="tab-btn py-5 px-4 font-head font-bold text-slate-400 border-b-2 border-transparent hover:text-orange-600 transition-colors" onclick="switchTab('evaluations', this)">
                    <i class="fas fa-gavel mr-2"></i>Détail des Examens
                </button>
            </div>
            
            <!-- Contenus -->
            <div class="p-6 sm:p-8">
                <!-- Onglet 1: À Propos -->
                <div id="tab-about" class="tab-content block animate-fade-in">
                    <h2 class="text-2xl font-head font-bold text-navy-900 mb-6">Description détaillée</h2>
                    <div class="prose prose-slate prose-lg max-w-none text-slate-600 whitespace-pre-line leading-relaxed">
                        {{ $course->description }}
                    </div>
                </div>
                
                <!-- Onglet 2: Détail des Examens -->
                <div id="tab-evaluations" class="tab-content hidden animate-fade-in">
                    
                    <div class="space-y-8">
                        <!-- Examen Standard -->
                        <div class="bg-emerald-50 rounded-3xl border border-emerald-100 p-6 sm:p-8 relative overflow-hidden transition-all duration-300" id="card-standard">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-bl-[100px] z-0"></div>
                            
                            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-emerald-200/50">
                                <h3 class="font-head font-bold text-emerald-900 text-xl flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-500 flex items-center justify-center mr-3 shadow-inner">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    Examen Standard
                                </h3>
                                @if($standardQuiz)
                                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">Seuil de réussite : {{ $standardQuiz->passing_score }}/20</span>
                                @endif
                            </div>
                            
                            <div class="relative z-10">
                                @if($standardQuiz && $standardQuiz->questions->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($standardQuiz->questions as $index => $q)
                                            <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-emerald-100/50 shadow-sm">
                                                <p class="font-bold text-navy-900 mb-3 text-sm">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-700 px-2 py-1 rounded mr-2">Question {{ $index + 1 }}</span> 
                                                    {{ $q->question_text }}
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                                                    @foreach($q->options as $opt)
                                                        <div class="flex items-center text-xs p-2 rounded-lg {{ $opt->is_correct ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-200' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                                            @if($opt->is_correct)
                                                                <i class="fas fa-check-circle text-emerald-500 mr-2 shrink-0"></i>
                                                            @else
                                                                <i class="fas fa-circle text-slate-200 mr-2 shrink-0"></i>
                                                            @endif
                                                            {{ $opt->option_text }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex items-center py-6 text-emerald-700/60 font-medium">
                                        <i class="fas fa-inbox text-2xl mr-3 opacity-50"></i> Aucun examen standard généré.
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Examen de Rattrapage -->
                        <div class="bg-red-50 rounded-3xl border border-red-100 p-6 sm:p-8 relative overflow-hidden transition-all duration-300" id="card-makeup">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-bl-[100px] z-0"></div>
                            
                            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-red-200/50">
                                <h3 class="font-head font-bold text-red-900 text-xl flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center mr-3 shadow-inner">
                                        <i class="fas fa-life-ring"></i>
                                    </div>
                                    Session Rattrapage
                                </h3>
                                @if($makeupQuiz)
                                    <span class="bg-red-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">Seuil de réussite : {{ $makeupQuiz->passing_score }}/20</span>
                                @endif
                            </div>
                            
                            <div class="relative z-10">
                                @if($makeupQuiz && $makeupQuiz->questions->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($makeupQuiz->questions as $index => $q)
                                            <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-red-100/50 shadow-sm">
                                                <p class="font-bold text-navy-900 mb-3 text-sm">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700 px-2 py-1 rounded mr-2">Question {{ $index + 1 }}</span> 
                                                    {{ $q->question_text }}
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-3">
                                                    @foreach($q->options as $opt)
                                                        <div class="flex items-center text-xs p-2 rounded-lg {{ $opt->is_correct ? 'bg-red-50 text-red-700 font-bold border border-red-200' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                                            @if($opt->is_correct)
                                                                <i class="fas fa-check-circle text-red-500 mr-2 shrink-0"></i>
                                                            @else
                                                                <i class="fas fa-circle text-slate-200 mr-2 shrink-0"></i>
                                                            @endif
                                                            {{ $opt->option_text }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center py-6 text-red-700/60 font-medium">
                                        <i class="fas fa-shield-alt text-3xl mr-4 opacity-50 mb-2 sm:mb-0"></i> 
                                        <div>
                                            <p>Aucun rattrapage configuré.</p>
                                            <p class="text-xs font-normal opacity-80 mt-1">L'apprenant n'aura qu'une seule chance de valider la formation.</p>
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

    <!-- Colonne Droite: Sommaire du cours (Playlist Sidebar) -->
    <div class="w-full lg:w-1/3 flex flex-col">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden flex flex-col sticky top-8" style="max-height: calc(100vh - 8rem);">
            <!-- Header du menu -->
            <div class="p-6 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-navy-900 font-head font-bold text-lg">Sommaire</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">{{ $course->lessons->count() }} Leçons validées</p>
            </div>
            
            <!-- Liste Scrollable -->
            <div class="overflow-y-auto custom-scrollbar flex-grow p-4 space-y-2">
                @forelse($course->lessons as $index => $lesson)
                    <button class="w-full text-left p-3 rounded-2xl transition-all duration-300 flex items-start group lesson-btn {{ $index === 0 ? 'bg-orange-50 border-orange-200 border shadow-sm' : 'hover:bg-slate-50 border border-transparent' }}"
                            data-type="{{ $lesson->type }}" 
                            data-url="{{ asset($lesson->file_path) }}" 
                            data-title="{{ $index + 1 }}. {{ $lesson->title }}"
                            onclick="previewLesson(this)">
                        
                        <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center shadow-inner transition-colors {{ $index === 0 ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-orange-100 group-hover:text-orange-500' }}">
                            @if($lesson->type == 'video')
                                <i class="fas fa-play text-xs ml-0.5"></i>
                            @else
                                <i class="fas fa-file-pdf text-xs"></i>
                            @endif
                        </div>
                        
                        <div class="ml-4 pt-1">
                            <h4 class="text-sm font-bold leading-snug {{ $index === 0 ? 'text-orange-800' : 'text-navy-900 group-hover:text-orange-600' }} transition-colors line-clamp-2">
                                {{ $index + 1 }}. {{ $lesson->title }}
                            </h4>
                            <span class="text-[10px] font-bold tracking-widest uppercase mt-1 block {{ $index === 0 ? 'text-orange-500/80' : 'text-slate-400' }}">
                                {{ $lesson->type == 'video' ? 'Vidéo' : 'Lecture' }}
                            </span>
                        </div>
                    </button>
                @empty
                    <div class="text-center py-10 px-4 text-slate-400">
                        <i class="fas fa-inbox text-4xl mb-3 opacity-30"></i>
                        <p class="text-sm font-medium">Programme vide</p>
                    </div>
                @endforelse
                
                @if($standardQuiz || $makeupQuiz)
                <!-- Séparateur Section Évaluations -->
                <div class="pt-6 pb-2 px-2 flex items-center">
                    <div class="h-px bg-slate-200 flex-grow"></div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Évaluations</span>
                    <div class="h-px bg-slate-200 flex-grow"></div>
                </div>
                @endif
                
                @if($standardQuiz)
                    <button class="w-full text-left p-3 rounded-2xl hover:bg-emerald-50 transition-all duration-300 flex items-start group lesson-btn border border-transparent" onclick="previewQuiz('standard', this)">
                        <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center bg-emerald-100 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors shadow-inner">
                            <i class="fas fa-award text-xs"></i>
                        </div>
                        <div class="ml-4 pt-1">
                            <h4 class="text-sm font-bold text-navy-900 group-hover:text-emerald-800 transition-colors leading-snug">Examen Standard</h4>
                            <span class="text-[10px] font-bold tracking-widest uppercase mt-1 block text-emerald-500/70">Test Final</span>
                        </div>
                    </button>
                @endif
                
                @if($makeupQuiz)
                    <button class="w-full text-left p-3 rounded-2xl hover:bg-red-50 transition-all duration-300 flex items-start group lesson-btn border border-transparent" onclick="previewQuiz('makeup', this)">
                        <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center bg-red-100 text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors shadow-inner">
                            <i class="fas fa-life-ring text-xs"></i>
                        </div>
                        <div class="ml-4 pt-1">
                            <h4 class="text-sm font-bold text-navy-900 group-hover:text-red-800 transition-colors leading-snug">Session Rattrapage</h4>
                            <span class="text-[10px] font-bold tracking-widest uppercase mt-1 block text-red-500/70">2ème Chance</span>
                        </div>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
</style>

<script>
// Gestion des onglets (À propos / Évaluations)
function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active', 'border-orange-500', 'text-navy-900');
        b.classList.add('border-transparent', 'text-slate-400');
    });
    document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
    
    if (btn) {
        btn.classList.add('active', 'border-orange-500', 'text-navy-900');
        btn.classList.remove('border-transparent', 'text-slate-400');
    }
    document.getElementById('tab-' + tabId).style.display = 'block';
}

function resetButtonsDesign() {
    document.querySelectorAll('.lesson-btn').forEach(b => {
        b.classList.remove('bg-orange-50', 'border-orange-200', 'bg-emerald-50', 'border-emerald-200', 'bg-red-50', 'border-red-200');
        b.classList.add('border-transparent');
        
        // Reset icônes (vidéo/pdf)
        const iconContainer = b.querySelector('.rounded-full');
        if (iconContainer) {
            iconContainer.classList.remove('bg-orange-500', 'text-white', 'bg-emerald-500', 'bg-red-500');
            // Restore default passive colors
            if (b.innerText.includes('Examen Standard')) {
                iconContainer.classList.add('bg-emerald-100', 'text-emerald-500');
            } else if (b.innerText.includes('Rattrapage')) {
                iconContainer.classList.add('bg-red-100', 'text-red-500');
            } else {
                iconContainer.classList.add('bg-slate-100', 'text-slate-400');
            }
        }
        
        // Reset Text Title Colors
        const titleH4 = b.querySelector('h4');
        if(titleH4) {
            titleH4.classList.remove('text-orange-800', 'text-emerald-800', 'text-red-800');
            titleH4.classList.add('text-navy-900');
        }
    });
}

function previewLesson(btn) {
    resetButtonsDesign();
    
    // Set active style for video/lesson
    btn.classList.add('bg-orange-50', 'border-orange-200');
    btn.classList.remove('border-transparent');
    
    const iconContainer = btn.querySelector('.rounded-full');
    if(iconContainer) {
        iconContainer.classList.remove('bg-slate-100', 'text-slate-400');
        iconContainer.classList.add('bg-orange-500', 'text-white');
    }
    const titleH4 = btn.querySelector('h4');
    if(titleH4) titleH4.classList.replace('text-navy-900', 'text-orange-800');
    
    const title = btn.getAttribute('data-title');
    const url = btn.getAttribute('data-url');
    const type = btn.getAttribute('data-type');
    
    document.getElementById('current-video-title').textContent = title;
    
    const quizPreview = document.getElementById('quiz-placeholder');
    if (quizPreview) {
        quizPreview.style.display = 'none';
    }
    
    const player = document.getElementById('main-player');
    
    if (type === 'video') {
        if(player) {
            player.style.display = 'block';
            document.getElementById('video-source').setAttribute('src', url);
            player.load();
            player.play();
        }
        
        const docPreview = document.getElementById('document-preview');
        if(docPreview) docPreview.style.display = 'none';
        
    } else {
        if(player) {
            player.pause();
            player.style.display = 'none';
        }
        
        let docPreview = document.getElementById('document-preview');
        if(!docPreview && document.getElementById('player-container')) {
            docPreview = document.createElement('div');
            docPreview.id = 'document-preview';
            docPreview.className = 'w-full h-full flex flex-col items-center justify-center text-slate-400 absolute inset-0 bg-navy-950 z-20';
            docPreview.innerHTML = `
                <i class="fas fa-file-pdf text-7xl mb-4 text-orange-500 drop-shadow-lg"></i>
                <h3 class="text-2xl text-white font-head font-bold mb-2">Support Documentaire</h3>
                <a href="${url}" target="_blank" id="doc-link" class="mt-4 px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold shadow-lg transition-all transform hover:-translate-y-1">
                    Ouvrir le document
                </a>
            `;
            document.getElementById('player-container').appendChild(docPreview);
        } else if (docPreview) {
            docPreview.style.display = 'flex';
            const link = document.getElementById('doc-link');
            if(link) link.setAttribute('href', url);
        }
    }
    
    // Auto-switch to About tab when viewing a lesson
    switchTab('about', document.querySelectorAll('.tab-btn')[0]);
}

function previewQuiz(type, btn) {
    resetButtonsDesign();
    
    // Set active style for Quiz
    if(type === 'standard') {
        btn.classList.add('bg-emerald-50', 'border-emerald-200');
        const iconContainer = btn.querySelector('.rounded-full');
        if(iconContainer) iconContainer.classList.add('bg-emerald-500', 'text-white');
        const titleH4 = btn.querySelector('h4');
        if(titleH4) titleH4.classList.replace('text-navy-900', 'text-emerald-800');
    } else {
        btn.classList.add('bg-red-50', 'border-red-200');
        const iconContainer = btn.querySelector('.rounded-full');
        if(iconContainer) iconContainer.classList.add('bg-red-500', 'text-white');
        const titleH4 = btn.querySelector('h4');
        if(titleH4) titleH4.classList.replace('text-navy-900', 'text-red-800');
    }
    
    document.getElementById('current-video-title').textContent = type === 'standard' ? 'Examen Standard' : 'Session Rattrapage';
    
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
        quizPreview.className = 'w-full h-full flex flex-col items-center justify-center text-slate-400 absolute inset-0 bg-navy-950 z-30 animate-fade-in';
        const container = document.getElementById('player-container');
        if (container) container.appendChild(quizPreview);
    }
    
    if (quizPreview) {
        quizPreview.style.display = 'flex';
        if (type === 'standard') {
            quizPreview.innerHTML = `
                <i class="fas fa-award text-7xl mb-6 text-emerald-500 drop-shadow-lg"></i>
                <h3 class="text-3xl text-white font-head font-bold mb-3">Examen de Qualification</h3>
                <p class="text-slate-400 mb-8 max-w-sm text-center">Cette évaluation couvre l'ensemble du curriculum enseigné.</p>
                <button onclick="document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });" class="px-8 py-3 bg-emerald-500/10 text-emerald-400 border border-emerald-500/50 hover:bg-emerald-500 hover:text-white rounded-xl font-bold transition-colors">
                    <i class="fas fa-eye mr-2"></i> Voir les questions
                </button>
            `;
        } else {
            quizPreview.innerHTML = `
                <i class="fas fa-life-ring text-7xl mb-6 text-red-500 drop-shadow-lg"></i>
                <h3 class="text-3xl text-white font-head font-bold mb-3">Examen de Rattrapage</h3>
                <p class="text-slate-400 mb-8 max-w-sm text-center">Cette session de seconde chance est proposée aux apprenants échoués.</p>
                <button onclick="document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });" class="px-8 py-3 bg-red-500/10 text-red-400 border border-red-500/50 hover:bg-red-500 hover:text-white rounded-xl font-bold transition-colors">
                    <i class="fas fa-eye mr-2"></i> Voir les questions
                </button>
            `;
        }
    }
    
    // Auto-switch tab to evaluations
    switchTab('evaluations', document.querySelectorAll('.tab-btn')[1]);
    
    // Clignotement léger de la carte dédiée
    const targetCard = type === 'standard' ? document.getElementById('card-standard') : document.getElementById('card-makeup');
    if (targetCard) {
        document.getElementById('tab-evaluations').scrollIntoView({ behavior: 'smooth', block: 'center' });
        targetCard.classList.add('ring-4', type === 'standard' ? 'ring-emerald-500' : 'ring-red-500', 'ring-opacity-50', 'shadow-2xl');
        setTimeout(() => {
            targetCard.classList.remove('ring-4', type === 'standard' ? 'ring-emerald-500' : 'ring-red-500', 'ring-opacity-50', 'shadow-2xl');
        }, 1200);
    }
}
</script>
@endsection
