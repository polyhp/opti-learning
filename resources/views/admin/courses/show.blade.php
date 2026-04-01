@extends('layouts.admin')

@section('content')
<div x-data="{ showRejectModal: false }">
    <!-- En-tête de retour -->
    <div class="mb-6">
        <a href="{{ route('admin.courses.index', ['status' => $course->status]) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-orange transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Retour aux formations
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Colonne gauche : Contenu du cours -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Informations de base -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="h-64 bg-gray-200 relative">
                    @if($course->thumbnail)
                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                            <span class="text-lg">Aucune miniature</span>
                        </div>
                    @endif
                </div>
                
                <div class="p-6 md:p-8">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold uppercase tracking-wide">{{ $course->category->name }}</span>
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-semibold">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ intdiv($course->duration_minutes, 60) }}h {{ $course->duration_minutes % 60 }}min
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $course->title }}</h1>
                    
                    <div class="prose max-w-none text-gray-600 mt-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Description complète</h3>
                        <!-- Utiliser {!! nl2br(e($course->description)) !!} si c'est du plain text simple -->
                        {!! nl2br(e($course->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Contenu des leçons (Aperçu) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-gray-900">Programme de la formation</h2>
                    <span class="text-sm text-gray-500">{{ $course->lessons->count() }} Leçon(s), {{ $course->quizzes->count() }} Quiz</span>
                </div>
                <div class="p-0">
                    <ul class="divide-y divide-gray-100">
                        @forelse($course->lessons as $lesson)
                            <li class="px-6 py-4 flex items-start space-x-4">
                                <div class="shrink-0 mt-1">
                                    <span class="w-6 h-6 rounded-full bg-orange-50 text-[#FF6B35] border border-orange-100 shadow-sm flex items-center justify-center text-xs font-bold">{{ $loop->iteration }}</span>
                                </div>
                                <div class="flex-1 min-w-0" x-data="{ openVideo: false }">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-sm font-bold text-[#0A2647] leading-snug">{{ $lesson->title }}</p>
                                            @if($lesson->description)
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-2 max-w-xl">{{ $lesson->description }}</p>
                                            @endif
                                        </div>
                                        
                                        @if($lesson->type === 'video')
                                            <button @click="openVideo = !openVideo" class="shrink-0 ml-4 text-xs font-bold text-[#FF6B35] hover:text-white bg-white hover:bg-[#FF6B35] transition-colors flex items-center px-3 py-1.5 rounded-lg border border-[#FF6B35]/30 shadow-sm">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span x-text="openVideo ? 'Fermer la vidéo' : 'Regarder' "></span>
                                            </button>
                                        @endif
                                    </div>
                                    
                                    @if($lesson->type === 'video')
                                        <div x-show="openVideo" x-transition.duration.300ms class="mt-4 rounded-xl overflow-hidden border border-gray-200 bg-black aspect-video relative shadow-inner">
                                            <video controls preload="none" class="w-full h-full object-contain">
                                                <source src="{{ asset($lesson->file_path) }}" type="video/mp4">
                                                Votre navigateur ne supporte pas la prévisualisation vidéo de l'administration.
                                            </video>
                                        </div>
                                    @endif
                                    
                                    @if($lesson->type !== 'video' && $lesson->file_path)
                                        <div class="mt-3">
                                            <a href="{{ asset($lesson->file_path) }}" target="_blank" class="inline-flex items-center text-xs font-semibold text-gray-500 hover:text-blue-600 transition-colors p-2 bg-gray-50 rounded-lg border border-gray-200 hover:bg-white hover:shadow-sm">
                                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Voir le document joint
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="px-6 py-8 text-center text-gray-500">Aucune leçon définie pour le moment.</li>
                        @endforelse

                        <!-- Quizzes -->
                        @foreach($course->quizzes as $quiz)
                            <li class="px-6 py-4 flex items-start space-x-4 bg-purple-50/30">
                                <div class="shrink-0 mt-1">
                                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 border border-purple-200 shadow-sm flex items-center justify-center text-xs font-bold">Q</span>
                                </div>
                                <div class="flex-1 min-w-0" x-data="{ openQuiz: false }">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-sm font-bold text-[#0A2647] leading-snug">{{ $quiz->title ?? 'Quiz sans titre' }} <span class="ml-2 text-[10px] uppercase font-semibold text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full">{{ $quiz->type === 'makeup' ? 'Rattrapage' : 'Standard' }}</span></p>
                                            <p class="text-xs text-gray-500 mt-1">Score min : {{ $quiz->passing_score }}/20 • {{ $quiz->questions->count() }} question(s)</p>
                                        </div>
                                        <button @click="openQuiz = !openQuiz" class="shrink-0 ml-4 text-xs font-bold text-purple-600 hover:text-white bg-white hover:bg-purple-600 transition-colors flex items-center px-3 py-1.5 rounded-lg border border-purple-300 shadow-sm">
                                            <span x-text="openQuiz ? 'Masquer' : 'Voir les questions'"></span>
                                        </button>
                                    </div>
                                    <div x-show="openQuiz" x-transition.opacity class="mt-4 space-y-3" style="display: none;">
                                        @forelse($quiz->questions as $index => $question)
                                            <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                                                <p class="text-sm font-semibold text-gray-800 mb-2">{{ $index + 1 }}. {{ $question->question_text }}</p>
                                                <ul class="space-y-1">
                                                    @foreach($question->options as $option)
                                                        <li class="text-xs flex items-center {{ $option->is_correct ? 'text-green-600 font-semibold' : 'text-gray-500' }}">
                                                            @if($option->is_correct)
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            @else
                                                                <svg class="w-3 h-3 mr-1 opacity-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            @endif
                                                            {{ $option->option_text }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-500 italic">Aucune question configurée pour ce quiz.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Actions et infos formateur -->
        <div class="space-y-6">
            
            <!-- Actions de modération -->
            <div class="bg-white rounded-xl shadow-sm border {{ $course->status === 'en_attente' ? 'border-yellow-300 ring-4 ring-yellow-50' : 'border-gray-200' }} p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">Statut de publication</h3>
                
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">Statut actuel :</p>
                    @if($course->status === 'en_attente')
                        <div class="flex items-center text-yellow-600 font-bold bg-yellow-50 px-3 py-2 rounded-lg">
                            <span class="w-3 h-3 rounded-full bg-yellow-500 mr-2 animate-pulse"></span>
                            En attente de révision
                        </div>
                    @elseif($course->status === 'approved')
                        <div class="flex items-center text-green-600 font-bold bg-green-50 px-3 py-2 rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Formation approuvée !
                        </div>
                    @elseif($course->status === 'rejected')
                        <div class="flex items-center text-red-600 font-bold bg-red-50 px-3 py-2 rounded-lg mb-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Formation refusée
                        </div>
                        @if($course->rejection_reason)
                            <div class="p-3 bg-red-50 border border-red-100 rounded-lg text-sm text-red-800 italic">
                                <strong>Motif :</strong><br>
                                {{ $course->rejection_reason }}
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Boutons d'action -->
                @if($course->status !== 'approved')
                    <form method="POST" action="{{ route('admin.courses.status', $course) }}" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approuver la formation
                        </button>
                    </form>
                @endif
                
                @if($course->status !== 'rejected')
                    <button type="button" @click="showRejectModal = true" class="w-full flex justify-center items-center py-2.5 px-4 border border-red-200 rounded-lg shadow-sm text-sm font-medium text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Refuser la formation
                    </button>
                @endif
            </div>

            <!-- Profil du Formateur -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">À propos du formateur</h3>
                
                <div class="flex items-center space-x-4 mb-4">
                    <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-100" src="{{ $course->formateur->user->avatar_url }}" alt="">
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $course->formateur->user->full_name }}</h4>
                        <p class="text-sm text-gray-500">{{ $course->formateur->user->email }}</p>
                    </div>
                </div>
                
                @if($course->formateur->bio)
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $course->formateur->bio }}</p>
                @endif

                @if($course->formateur->certifications)
                    <div class="mt-4">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-2">Domaine d'expertise déclaré</span>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg border border-gray-300 bg-gray-50 text-xs font-bold text-gray-700">
                                {{ $course->formateur->expertise_domain ?? $course->formateur->certifications }}
                            </span>
                        </div>
                    </div>
                @endif
                
                <!-- Documents de Vérification du Formateur -->
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <span class="flex items-center text-sm font-bold text-[#0A2647] mb-4">
                        <svg class="w-5 h-5 mr-2 text-[#FF6B35]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Documents de vérification
                    </span>
                    
                    <div class="space-y-3">
                        @if($course->formateur->id_card_url)
                        <a href="{{ $course->formateur->id_card_url }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white hover:border-blue-300 hover:shadow-md transition-all group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#0A2647] group-hover:text-blue-600 transition-colors">Pièce d'identité</p>
                                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Vérification de nom</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        @endif

                        @if($course->formateur->diploma_url)
                        <a href="{{ $course->formateur->diploma_url }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white hover:border-purple-300 hover:shadow-md transition-all group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#0A2647] group-hover:text-purple-600 transition-colors">Diplôme d'expertise</p>
                                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Justificatif officiel</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        @endif
                        
                        @if($course->formateur->certificate_url)
                        <a href="{{ $course->formateur->certificate_url }}" target="_blank" class="flex items-center justify-between p-3 rounded-xl border border-gray-200 bg-gray-50 hover:bg-white hover:border-green-300 hover:shadow-md transition-all group">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#0A2647] group-hover:text-green-600 transition-colors">Documents annexes</p>
                                    <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold">Certifications</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Paramètres financiers -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">Tarification</h3>
                
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Prix public</p>
                        <p class="text-3xl font-bold text-primary-dark">{{ number_format($course->price, 0, ',', ' ') }} <span class="text-xl">FCFA</span></p>
                    </div>
                    <div class="text-right">
                        <!-- Exemple de structure de commission si applicable plus tard -->
                        <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded inline-block font-semibold">Standard</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modale de refus -->
    <div x-show="showRejectModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showRejectModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showRejectModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showRejectModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                
                <form action="{{ route('admin.courses.status', $course) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Refuser la formation</h3>
                                <div class="mt-2 text-sm text-gray-500 mb-4">
                                    Veuillez indiquer le motif du refus. Cet exte sera envoyé par e-mail au formateur pour l'aider à corriger sa proposition.
                                </div>
                                <div class="w-full">
                                    <label for="rejection_reason" class="sr-only">Motif du refus</label>
                                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ex: La qualité audio de la première vidéo est insuffisante..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirmer le refus
                        </button>
                        <button type="button" @click="showRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
