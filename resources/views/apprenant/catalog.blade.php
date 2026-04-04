@extends('layouts.apprenant')

@section('title', 'Catalogue des Formations - Apprenant')

@section('content')
    <div class="w-full flex flex-col space-y-8">

        <!-- Top Header & Search -->
        <div
            class="bg-gradient-to-r from-navy-800 to-navy-900 rounded-3xl p-8 relative overflow-hidden shadow-xl border border-navy-700">
            <!-- Abstract Decoration -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-orange-500/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-white">
                    <h1 class="font-head text-3xl font-extrabold mb-2">Catalogue OptiLearning</h1>
                    <p class="text-slate-300">Explorez toutes nos formations parcourez les nouveautés de nos experts.</p>
                </div>

                <!-- Search Bar within Header -->
                <form action="{{ route('apprenant.catalog') }}" method="GET" class="w-full md:w-96">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-11 pr-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:bg-slate-700 transition-all outline-none"
                            placeholder="Rechercher une formation...">
                    </div>
                </form>
            </div>
        </div>

        <!-- Filtres rapides (Visuel) -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-700">
            <h2 class="font-head text-xl font-bold text-blue">
                @if(isset($search) && $search != '')
                    Résultats pour "{{ $search }}" ({{ $courses->total() }})
                @else
                    Toutes les formations disponibles ({{ $courses->total() }})
                @endif
            </h2>
            <div class="flex space-x-2">
                <span
                    class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-sm font-medium cursor-not-allowed opacity-70 border border-slate-700">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </span>
            </div>
        </div>

        <!-- Grid Courses -->
        @if($courses->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($courses as $course)
                    <div
                        class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden shadow-lg hover:shadow-2xl hover:border-orange-500 transition-all duration-300 flex flex-col group relative">
                        <!-- Badge -->
                        <div
                            class="absolute top-3 right-3 z-10 bg-slate-900/90 backdrop-blur text-orange-400 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm border border-slate-700">
                            {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                        </div>

                        <!-- Cover Image -->
                        <div class="h-48 relative overflow-hidden bg-slate-700">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-orange-600/90 to-orange-500/70 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 z-20">
                                <a href="{{ route('courses.show', $course->id) }}"
                                    class="bg-white text-orange-600 px-5 py-2.5 rounded-full font-bold shadow-xl shadow-black/30 transform translate-y-6 group-hover:translate-y-0 transition-all duration-500 hover:bg-orange-50 cursor-pointer">
                                    ▶ Découvrir
                                </a>
                            </div>
                            @if($course->thumbnail)
                                <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-navy-800 text-navy-600">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <span class="text-xs font-medium uppercase tracking-wider">Sans image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <span
                                        class="text-[10px] uppercase tracking-wider font-bold text-orange-400 bg-orange-500/20 px-2 py-1 rounded-md">{{ $course->category->name ?? 'Général' }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium"><i
                                            class="fas fa-clock mr-1"></i>{{ $course->duration_minutes }} min</span>
                                </div>
                                <h3
                                    class="font-head text-lg font-bold text-white mb-2 line-clamp-2 leading-tight group-hover:text-orange-400 transition-colors">
                                    {{ $course->title }}</h3>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-700">
                                <!-- Auteur -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-navy-700 text-slate-300 flex items-center justify-center text-xs font-bold font-head">
                                            {{ substr($course->formateur->user->first_name, 0, 1) }}{{ substr($course->formateur->user->last_name, 0, 1) }}
                                        </div>
                                        <div class="text-xs text-slate-300 font-medium">
                                            Par {{ $course->formateur->user->first_name }}
                                        </div>
                                    </div>
                                    <div class="text-xs text-slate-400 font-medium flex items-center">
                                        <i class="fas fa-book-open mr-1"></i> {{ $course->lessons_count }} Leçons
                                    </div>
                                </div>

                                <!-- Action View -->
                                <a href="{{ route('courses.show', $course->id) }}"
                                    class="mt-4 block w-full text-center py-2.5 bg-slate-700 text-slate-200 font-semibold text-sm rounded-xl hover:bg-orange-600 hover:text-white transition-colors">
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
            <div class="bg-slate-800 rounded-3xl border border-slate-700 p-12 text-center shadow-xl">
                <div
                    class="w-24 h-24 bg-slate-700 rounded-full flex items-center justify-center text-slate-500 text-4xl mx-auto mb-6">
                    <i class="fas fa-search"></i>
                </div>
                <h2 class="text-2xl font-head font-bold text-white mb-2">Aucun résultat trouvé</h2>
                <p class="text-slate-400 max-w-md mx-auto">Nous n'avons trouvé aucune formation publiée correspondant à votre
                    recherche. Modifiez vos mots-clés ou explorez le catalogue complet.</p>
                @if(isset($search))
                    <a href="{{ route('apprenant.catalog') }}"
                        class="inline-block mt-6 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-xl transition-colors shadow-lg shadow-orange-500/20">Réinitialiser
                        la recherche</a>
                @endif
            </div>
        @endif

    </div>
@endsection