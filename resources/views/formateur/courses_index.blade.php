@extends('layouts.formateur')

@section('title', 'Toutes mes formations - Formateur')

@section('content')
<div class="w-full flex flex-col space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100 gap-4">
        <div>
            <h1 class="text-2xl font-head font-bold text-navy-900">Mes Formations</h1>
            <p class="text-sm text-slate-500 mt-1">Gérez tout votre catalogue de cours depuis cet espace.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('formateur.dashboard') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl font-medium transition-colors">Retour</a>
            <a href="{{ route('formateur.courses.create') }}" class="flex items-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Créer une formation</span>
            </a>
        </div>
    </div>

    <!-- Grille des formations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-shadow">
            
            <!-- Miniature -->
            <div class="h-40 bg-slate-200 relative overflow-hidden">
                @if($course->thumbnail)
                    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-navy-100 text-navy-400">
                        <i class="fas fa-video text-3xl"></i>
                    </div>
                @endif
                
                <!-- Badge de Statut -->
                <div class="absolute top-3 right-3">
                    @if($course->status == 'approved')
                        <span class="bg-emerald-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            <i class="fas fa-check-circle mr-1"></i> Publié
                        </span>
                    @elseif($course->status == 'pending')
                        <span class="bg-amber-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            <i class="fas fa-clock mr-1"></i> En attente
                        </span>
                    @else
                        <span class="bg-slate-600/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            {{ ucfirst($course->status) }}
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Corps de la carte -->
            <div class="p-5 flex-grow flex flex-col">
                <div class="text-xs font-semibold text-orange-500 uppercase tracking-wider mb-2">
                    {{ $course->category->name ?? 'Catégorie' }}
                </div>
                <h3 class="text-lg font-bold text-navy-900 leading-tight mb-2 line-clamp-2" title="{{ $course->title }}">
                    {{ $course->title }}
                </h3>
                
                <div class="text-slate-500 text-sm mb-4 line-clamp-2">
                    {{ Str::limit($course->description, 80) }}
                </div>
                
                <div class="mt-auto flex flex-col space-y-3 pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-600"><i class="fas fa-book-open mr-1"></i> {{ $course->lessons_count }} leçon(s)</span>
                        <span class="font-bold text-navy-900">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
                    </div>
                    
                    <a href="{{ route('formateur.courses.show', $course->id) }}" class="w-full py-2 bg-navy-50 text-navy-700 hover:bg-navy-900 hover:text-white rounded-lg text-center font-semibold text-sm transition-colors border border-navy-100 hover:border-navy-900">
                        Gérer la formation
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 flex flex-col justify-center items-center text-center bg-white rounded-2xl border border-slate-100">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-folder-open text-3xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy-900 mb-2">Aucune formation</h3>
            <p class="text-slate-500 mb-6">Vous n'avez pas encore créé de contenu sur la plateforme.</p>
            <a href="{{ route('formateur.courses.create') }}" class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-xl shadow-lg shadow-orange-500/30 transition-colors">
                Commencer ma première formation
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
    <div class="flex justify-center mt-8">
        {{ $courses->links('pagination::tailwind') }}
    </div>
    @endif

</div>
@endsection
