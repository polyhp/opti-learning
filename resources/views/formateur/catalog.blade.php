@extends('layouts.formateur')

@section('title', 'Catalogue des Formations - Formateur')

@section('content')
<div class="w-full flex flex-col space-y-8">
    
    <!-- Top Header & Search -->
    <div class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 rounded-3xl p-8 relative overflow-hidden shadow-xl border border-orange-500/20">
        <!-- Abstract Decorations -->
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-orange-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-orange-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-gradient-to-r from-transparent via-orange-500/5 to-transparent blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-white">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-1 h-8 bg-orange-500 rounded-full"></div>
                    <h1 class="font-head text-3xl font-extrabold bg-gradient-to-r from-white to-orange-200 bg-clip-text text-transparent">Catalogue OptiLearning</h1>
                </div>
                <p class="text-navy-200 ml-4">Découvrez l'ensemble des formations publiées sur la plateforme.</p>
            </div>
            
            <form action="{{ route('formateur.catalog') }}" method="GET" class="w-full md:w-1/2 lg:w-1/3 relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-orange-400"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}" 
                       class="block w-full pl-11 pr-4 py-4 bg-navy-800/50 backdrop-blur-sm border-2 border-navy-700 rounded-2xl text-white placeholder-navy-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-navy-800 transition-all outline-none" 
                       placeholder="Rechercher une formation...">
                @if(isset($search) && $search != '')
                    <a href="{{ route('formateur.catalog') }}" class="absolute inset-y-0 right-4 flex items-center text-navy-400 hover:text-orange-400 transition-colors">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Stats rapides -->
        <div class="relative z-10 mt-8 pt-6 border-t border-navy-700 flex flex-wrap justify-between gap-4 text-sm">
            <div class="flex items-center gap-2 text-navy-300">
                <i class="fas fa-chalkboard text-orange-500"></i>
                <span>Total formations: <strong class="text-white">{{ $courses->count() }}</strong></span>
            </div>
            <div class="flex items-center gap-2 text-navy-300">
                <i class="fas fa-graduation-cap text-orange-500"></i>
                <span>Votre espace formateur</span>
            </div>
        </div>
    </div>

    <!-- Filtres rapides -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b-2 border-navy-200">
        <h2 class="font-head text-xl font-bold text-navy-900">
            @if(isset($search) && $search != '')
                <i class="fas fa-search text-orange-500 mr-2"></i>Résultats pour "{{ $search }}" ({{ $courses->count() }})
            @else
                <i class="fas fa-th-large text-orange-500 mr-2"></i>Toutes les formations ({{ $courses->count() }})
            @endif
        </h2>
    </div>

    <!-- Grid Courses - Cartes entièrement cliquables -->
    @if($courses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($courses as $course)
                <a href="{{ route('courses.show', $course->id) }}" class="group block cursor-pointer transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-white rounded-2xl border-2 border-navy-100 overflow-hidden shadow-sm hover:shadow-xl hover:border-orange-300 transition-all duration-300 flex flex-col h-full relative">
                        <!-- Badge Prix -->
                        <div class="absolute top-3 right-3 z-10 bg-gradient-to-r from-navy-900 to-navy-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg border border-orange-500/30">
                            {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                        </div>
                        
                        <!-- Badge Statut -->
                        @if($course->status == 'approved')
                            <div class="absolute top-3 left-3 z-10 bg-emerald-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center gap-1">
                                <i class="fas fa-check-circle text-[8px]"></i> Publié
                            </div>
                        @elseif($course->status == 'pending')
                            <div class="absolute top-3 left-3 z-10 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center gap-1">
                                <i class="fas fa-hourglass-half text-[8px]"></i> En attente
                            </div>
                        @else
                            <div class="absolute top-3 left-3 z-10 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-md flex items-center gap-1">
                                <i class="fas fa-times-circle text-[8px]"></i> Rejeté
                            </div>
                        @endif
                        
                        <!-- Cover Image -->
                        <div class="h-48 relative overflow-hidden bg-gradient-to-br from-navy-100 to-navy-200">
                            @if($course->thumbnail)
                                <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-navy-300">
                                    <i class="fas fa-image text-5xl mb-2 opacity-50"></i>
                                    <span class="text-xs font-medium uppercase tracking-wider opacity-50">Sans image</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-900/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <!-- Overlay au survol -->
                            <div class="absolute inset-0 bg-orange-500/0 group-hover:bg-orange-500/10 transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-all duration-300 shadow-lg">
                                    <i class="fas fa-eye text-orange-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] uppercase tracking-wider font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-md border border-orange-200">
                                        {{ $course->category->name ?? 'Général' }}
                                    </span>
                                    <span class="text-[10px] text-navy-400 font-medium">
                                        <i class="far fa-clock mr-1"></i>{{ $course->duration_minutes }} min
                                    </span>
                                </div>
                                <h3 class="font-head text-base font-bold text-navy-900 mb-2 line-clamp-2 leading-snug group-hover:text-orange-600 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-xs text-navy-500 line-clamp-2 mb-3">
                                    {{ Str::limit($course->description, 80) }}
                                </p>
                            </div>
                            
                            <div class="mt-3 pt-3 border-t border-navy-100">
                                <!-- Auteur -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-navy-700 to-navy-800 text-white flex items-center justify-center text-[10px] font-bold font-head">
                                            {{ substr($course->formateur->user->first_name, 0, 1) }}{{ substr($course->formateur->user->last_name, 0, 1) }}
                                        </div>
                                        <div class="text-[11px] text-navy-600 font-medium">
                                            {{ $course->formateur->user->first_name }} {{ substr($course->formateur->user->last_name, 0, 1) }}.
                                        </div>
                                    </div>
                                    <div class="text-[10px] text-navy-400 font-medium flex items-center gap-1">
                                        <i class="fas fa-book-open text-[9px]"></i> 
                                        {{ $course->lessons_count }} leçon(s)
                                    </div>
                                </div>
                                
                                <!-- Statistiques Ventes -->
                                <div class="flex items-center justify-between text-[10px] text-navy-400 mb-2">
                                    <span><i class="fas fa-shopping-cart mr-1"></i> {{ $course->orders_count ?? 0 }} ventes</span>
                                    <span><i class="fas fa-eye mr-1"></i> {{ $course->views_count ?? 0 }} vues</span>
                                </div>
                                
                                <!-- Indicateur visuel de clic -->
                                <div class="mt-2 text-center">
                                    <span class="text-[10px] text-orange-400 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1">
                                        <i class="fas fa-mouse-pointer"></i> Cliquer pour voir les détails
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($courses, 'links'))
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-3xl border-2 border-navy-100 p-12 text-center shadow-sm">
            <div class="w-24 h-24 bg-gradient-to-br from-navy-50 to-navy-100 rounded-full flex items-center justify-center text-navy-300 text-5xl mx-auto mb-6 border-2 border-navy-200">
                <i class="fas fa-search"></i>
            </div>
            <h2 class="text-2xl font-head font-bold text-navy-900 mb-3">Aucun résultat trouvé</h2>
            <p class="text-navy-500 max-w-md mx-auto">Nous n'avons trouvé aucune formation publiée correspondant à votre recherche.</p>
            @if(isset($search))
                <a href="{{ route('formateur.catalog') }}" class="inline-block mt-6 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-orange-500/30">
                    <i class="fas fa-redo-alt mr-2"></i>Réinitialiser la recherche
                </a>
            @endif
        </div>
    @endif

</div>

<style>
    /* Amélioration des bordures et ombres */
    .border-navy-100 {
        border-color: #e2e8f0;
    }
    .border-navy-200 {
        border-color: #cbd5e1;
    }
    .border-navy-700 {
        border-color: #1e293b;
    }
    
    /* Effet de survol sur les cartes */
    .group {
        cursor: pointer;
    }
    
    .group:hover {
        transform: translateY(-4px);
    }
    
    /* Animation de l'overlay */
    .group .absolute.inset-0.bg-orange-500\/0 {
        transition: background-color 0.3s ease;
    }
    
    /* Ligne de texte pour les descriptions */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Style de la pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    .pagination .page-item .page-link {
        padding: 8px 16px;
        border-radius: 12px;
        background: white;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-weight: 500;
        transition: all 0.2s;
    }
    .pagination .page-item.active .page-link {
        background: #F97316;
        border-color: #F97316;
        color: white;
    }
    .pagination .page-item .page-link:hover {
        background: #f1f5f9;
        border-color: #F97316;
    }
    
    /* Curseur pointer pour toute la carte */
    a.group {
        cursor: pointer;
    }
</style>
@endsection