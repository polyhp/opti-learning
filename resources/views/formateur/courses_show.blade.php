@extends('layouts.formateur')

@section('title', $course->title . ' - Profil Formateur')

@section('content')
<div class="w-full flex justify-between items-center mb-8">
    <div>
        <a href="{{ route('formateur.dashboard') }}" class="text-navy-500 hover:text-orange-500 flex items-center mb-2 font-medium transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Retour au tableau de bord
        </a>
        <h1 class="text-3xl font-head font-bold text-navy-900 flex items-center">
            {{ $course->title }}
            @if($course->status == 'approved')
                <span class="ml-4 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center">
                    <i class="fas fa-check-circle mr-1"></i> Publié
                </span>
            @elseif($course->status == 'pending')
                <span class="ml-4 bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center">
                    <i class="fas fa-hourglass-half mr-1"></i> En révision
                </span>
            @else
                <span class="ml-4 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm flex items-center">
                    <i class="fas fa-times-circle mr-1"></i> Rejeté
                </span>
            @endif
        </h1>
        <div class="flex items-center space-x-4 mt-2 text-slate-500 text-sm font-medium">
            <span class="flex items-center"><i class="fas fa-folder-open mr-1.5 text-navy-400"></i> {{ $course->category->name ?? 'Général' }}</span>
            <span class="text-slate-300">•</span>
            <span class="flex items-center"><i class="fas fa-clock mr-1.5 text-navy-400"></i> {{ $course->duration_minutes }} min</span>
            <span class="text-slate-300">•</span>
            <span class="flex items-center text-orange-600 font-bold"><i class="fas fa-tag mr-1.5"></i> {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
        </div>
    </div>
    
    <div>
        <a href="{{ route('formateur.dashboard') }}" class="bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 px-5 py-2.5 rounded-xl font-medium shadow-sm transition-colors flex items-center">
            <i class="fas fa-edit mr-2"></i> Modifier
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <!-- Main Detail Col -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Lecteur Vidéo Formateur -->
        <div class="bg-black rounded-3xl shadow-xl overflow-hidden relative group border border-slate-800">
            <div class="aspect-video w-full bg-black relative flex items-center justify-center" id="player-container">
                @if($course->lessons->count() > 0)
                    @php $firstVideo = $course->lessons->where('type', 'video')->first(); @endphp
                    @if($firstVideo)
                        <video id="main-player" controls class="w-full h-full outline-none" poster="{{ $course->thumbnail ? asset($course->thumbnail) : '' }}">
                            <source src="{{ asset($firstVideo->file_path) }}" type="video/mp4" id="video-source">
                            Votre navigateur ne supporte pas la lecture vidéo.
                        </video>
                    @else
                        <!-- S'il n'y a que des PDF -->
                        <div id="document-preview" class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-navy-900">
                            <i class="fas fa-file-pdf text-6xl mb-4 text-orange-500"></i>
                            <h3 class="text-xl text-white font-medium mb-2">Contenu Documentaire</h3>
                            <a href="{{ asset($course->lessons->first()->file_path) }}" target="_blank" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 outline-none text-white rounded-lg font-medium transition-colors">
                                Ouvrir le document
                            </a>
                        </div>
                    @endif
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 bg-navy-900" id="empty-preview">
                        <i class="fas fa-video-slash text-5xl mb-3 opacity-50"></i>
                        <span>Aucune vidéo publiée</span>
                    </div>
                @endif
            </div>
            <div class="bg-navy-900 border-t border-navy-800 px-6 py-4 flex justify-between items-center">
                <div>
                    <span class="text-xs text-orange-500 font-bold uppercase tracking-wider mb-1 block" id="current-type-label">Aperçu Formateur</span>
                    <h3 class="text-white font-head font-bold text-lg" id="current-video-title">
                        {{ $firstVideo ? '1. ' . $firstVideo->title : ($course->lessons->count() > 0 ? 'Document' : 'Pas de média') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center">
                <div class="w-10 h-10 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 mr-4">
                    <i class="fas fa-align-left"></i>
                </div>
                <h2 class="text-xl font-head font-bold text-navy-900">Description de la formation</h2>
            </div>
            <div class="p-8 text-slate-600 leading-relaxed whitespace-pre-line text-lg">
                {{ $course->description }}
            </div>
        </div>

        <!-- Quiz Details -->
        @if($course->quizzes->count() > 0)
        @php $quiz = $course->quizzes->first(); @endphp
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl shadow-sm border border-emerald-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-emerald-100/50 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mr-4">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h2 class="text-xl font-head font-bold text-navy-900">Évaluation configurée</h2>
                </div>
                <span class="bg-white text-emerald-700 px-4 py-1.5 rounded-full text-sm font-bold shadow-sm">Validation : {{ $quiz->passing_score }}%</span>
            </div>
            <div class="p-8">
                <h3 class="font-bold text-navy-900 text-lg mb-6">{{ $quiz->title }}</h3>
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $q)
                        <div class="bg-white p-6 rounded-2xl border border-emerald-100/50 shadow-sm relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-400"></div>
                            <h4 class="font-bold text-slate-800 mb-4 text-base ml-2"><span class="text-emerald-500 mr-2">Q{{ $index + 1 }}.</span> {{ $q->question_text }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-2">
                                @foreach($q->options as $opt)
                                    <div class="flex items-center space-x-3 p-3 rounded-xl border {{ $opt->is_correct ? 'border-emerald-300 bg-emerald-50 text-emerald-900' : 'border-slate-100 bg-slate-50' }}">
                                        @if($opt->is_correct)
                                            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                                            <span class="font-bold text-sm">{{ $opt->option_text }}</span>
                                        @else
                                            <i class="far fa-circle text-slate-300 text-xl"></i>
                                            <span class="text-sm text-slate-500">{{ $opt->option_text }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="bg-slate-50 rounded-3xl shadow-inner border border-slate-200 border-dashed overflow-hidden text-center py-12">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                <i class="fas fa-clipboard-check text-2xl"></i>
            </div>
            <h3 class="font-bold text-slate-600 text-lg">Aucun Quiz d'évaluation</h3>
            <p class="text-slate-400 mt-2 max-w-sm mx-auto">Vous n'avez configuré aucune question pour valider les acquis des apprenants à la fin de cette formation.</p>
        </div>
        @endif
    </div>

    <!-- Right Sidebar (Lessons) -->
    <div class="space-y-6">
        <div class="bg-white rounded-3xl shadow-xl shadow-navy-900/5 border border-slate-100 overflow-hidden sticky top-28">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h2 class="font-head text-lg font-bold text-navy-900">Programme ({{ $course->lessons->count() }})</h2>
                <span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md">Vérification</span>
            </div>
            
            <div class="divide-y divide-slate-100 max-h-[700px] overflow-y-auto" id="lesson-list">
                @forelse($course->lessons as $index => $lesson)
                    <button class="w-full text-left p-4 hover:bg-slate-50 transition-colors flex items-start group lesson-btn {{ $index === 0 ? 'bg-orange-50/30 border-l-4 border-orange-500' : 'border-l-4 border-transparent' }}"
                            data-type="{{ $lesson->type }}" 
                            data-url="{{ asset($lesson->file_path) }}" 
                            data-title="{{ $index + 1 }}. {{ $lesson->title }}"
                            onclick="previewLesson(this)">
                        
                        <div class="flex-shrink-0 w-10 text-center relative mt-1">
                            @if($lesson->type == 'video')
                                <div class="w-8 h-8 mx-auto rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs shadow-sm transition-transform group-hover:scale-110">
                                    <i class="fas fa-play ml-0.5"></i>
                                </div>
                            @elseif($lesson->type == 'document')
                                <div class="w-8 h-8 mx-auto rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs shadow-sm transition-transform group-hover:scale-110">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                            @else
                                <div class="w-8 h-8 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs shadow-sm transition-transform group-hover:scale-110">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3 flex-grow pr-2">
                            <h4 class="text-sm font-bold text-navy-900 leading-tight mb-1 group-hover:text-orange-600 transition-colors">{{ $index + 1 }}. {{ $lesson->title }}</h4>
                            <div class="flex items-center justify-between mt-1.5">
                                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wide">
                                    {{ $lesson->type == 'video' ? 'Vidéo' : 'Fichier' }}
                                </span>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="p-10 text-center text-slate-500">
                        <i class="fas fa-folder-open text-4xl mb-4 text-slate-300"></i>
                        <h4 class="font-medium text-navy-900">Leçon vide</h4>
                        <p class="text-sm mt-1">Aucun média n'a été rattaché à ce cours.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function previewLesson(btn) {
    // UI Update
    document.querySelectorAll('.lesson-btn').forEach(b => {
        b.classList.remove('bg-orange-50/30', 'border-orange-500');
        b.classList.add('border-transparent');
    });
    btn.classList.add('bg-orange-50/30', 'border-orange-500');
    btn.classList.remove('border-transparent');
    
    const title = btn.getAttribute('data-title');
    const url = btn.getAttribute('data-url');
    const type = btn.getAttribute('data-type');
    
    document.getElementById('current-video-title').textContent = title;
    
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
            // Create if missing
            docPreview = document.createElement('div');
            docPreview.id = 'document-preview';
            docPreview.className = 'w-full h-full flex flex-col items-center justify-center text-slate-400 bg-navy-900 absolute inset-0';
            docPreview.innerHTML = `
                <i class="fas fa-file-pdf text-6xl mb-4 text-orange-500"></i>
                <h3 class="text-xl text-white font-medium mb-2">Contenu Documentaire</h3>
                <a href="${url}" target="_blank" id="doc-link" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 outline-none text-white rounded-lg font-medium transition-colors">
                    Ouvrir le document
                </a>
            `;
            document.getElementById('player-container').appendChild(docPreview);
        } else if (docPreview) {
            docPreview.style.display = 'flex';
            document.getElementById('doc-link').setAttribute('href', url);
        }
    }
}
</script>
@endsection
