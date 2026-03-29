@extends('layouts.apprenant')

@section('title', 'Catalogue des Formations - Apprenant')

@section('content')
<div class="w-full flex flex-col space-y-8">
    
    <!-- Top Header & Search -->
    <div class="bg-navy-900 rounded-3xl p-8 relative overflow-hidden shadow-xl border border-navy-800">
        <!-- Abstract Decoration -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-orange-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-white">
                <h1 class="font-head text-3xl font-extrabold mb-2">Catalogue OptiLearning</h1>
                <p class="text-navy-300">Explorez toutes nos formations parcourez les nouveautés de nos experts.</p>
            </div>
            
            <form action="{{ route('apprenant.catalog') }}" method="GET" class="w-full md:w-1/2 lg:w-1/3 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       class="block w-full pl-11 pr-4 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl text-white placeholder-navy-300 focus:ring-2 focus:ring-orange-500 focus:bg-white/20 transition-all outline-none" 
                       placeholder="Rechercher une formation...">
                @if(isset($search) && $search != '')
                    <a href="{{ route('apprenant.catalog') }}" class="absolute inset-y-0 right-4 flex items-center text-slate-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Filtres rapides (Visuel) -->
    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
        <h2 class="font-head text-xl font-bold text-navy-900 dark:text-white">
            @if(isset($search) && $search != '')
                Résultats pour "{{ $search }}" ({{ $courses->total() }})
            @else
                Toutes les formations disponibles ({{ $courses->total() }})
            @endif
        </h2>
        <div class="flex space-x-2">
            <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium cursor-not-allowed opacity-50"><i class="fas fa-filter mr-2"></i>Filtrer</span>
        </div>
    </div>

    <!-- Grid Courses -->
    @if($courses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($courses as $course)
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 flex flex-col group relative">
                    <!-- Badge -->
                    <div class="absolute top-3 right-3 z-10 bg-white/90 backdrop-blur text-navy-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm">
                        {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                    </div>
                    
                    <!-- Cover Image -->
                    <div class="h-48 relative overflow-hidden bg-slate-100">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-navy-50 text-navy-200">
                                <i class="fas fa-image text-4xl mb-2"></i>
                                <span class="text-xs font-medium uppercase tracking-wider">Sans image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="text-[10px] uppercase tracking-wider font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md">{{ $course->category->name ?? 'Général' }}</span>
                                <span class="text-[10px] text-slate-400 font-medium"><i class="fas fa-clock mr-1"></i>{{ $course->duration_minutes }} min</span>
                            </div>
                            <h3 class="font-head text-lg font-bold text-navy-900 mb-2 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">{{ $course->title }}</h3>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-slate-50">
                            <!-- Auteur -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-navy-100 text-navy-700 flex items-center justify-center text-xs font-bold font-head">
                                        {{ substr($course->formateur->user->first_name, 0, 1) }}{{ substr($course->formateur->user->last_name, 0, 1) }}
                                    </div>
                                    <div class="text-xs text-slate-600 font-medium">
                                        Par {{ $course->formateur->user->first_name }}
                                    </div>
                                </div>
                                <div class="text-xs text-slate-400 font-medium flex items-center">
                                    <i class="fas fa-book-open mr-1"></i> {{ $course->lessons_count }} Leçons
                                </div>
                            </div>
                            
                            <!-- Action View -->
                            <a href="{{ route('courses.show', $course->id) }}" class="mt-4 block w-full text-center py-2.5 bg-slate-50 text-navy-700 font-semibold text-sm rounded-xl hover:bg-orange-500 hover:text-white transition-colors">
                                Consulter les détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8 flex justify-center">
            {{ $courses->links() }}
        </div>
    @else
        <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-4xl mx-auto mb-6">
                <i class="fas fa-search"></i>
            </div>
            <h2 class="text-2xl font-head font-bold text-navy-900 mb-2">Aucun résultat trouvé</h2>
            <p class="text-slate-500 max-w-md mx-auto">Nous n'avons trouvé aucune formation publiée correspondant à votre recherche. Modifiez vos mots-clés ou explorez le catalogue complet.</p>
            @if(isset($search))
                <a href="{{ route('apprenant.catalog') }}" class="inline-block mt-6 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-xl transition-colors">Réinitialiser la recherche</a>
            @endif
        </div>
    @endif

</div>
@endsection
