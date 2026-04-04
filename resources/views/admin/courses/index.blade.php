@extends('layouts.admin')

@section('content')
<div>
    <!-- Header attractif -->
    <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] p-6 shadow-xl">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(249,115,22,0.08)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-[#F97316]/20 flex items-center justify-center border border-[#F97316]/30">
                        <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Gestion des Formations</h1>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Gérez le catalogue et validez les propositions des formateurs</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-[#F97316]/20 border-2 border-[#0B1A3E] flex items-center justify-center text-[10px] font-bold text-white">+12</div>
                </div>
                <span class="text-white/60 text-sm">formations au total</span>
            </div>
        </div>
    </div>

    <!-- Filtres élégants -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-[#F97316]/20 p-5 mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-gray-700">Filtrer par statut :</span>
            </div>
            
            <form method="GET" action="{{ route('admin.courses.index') }}" class="flex flex-wrap gap-3 items-center">
                <select name="status" id="status" class="rounded-xl border-2 border-gray-200 focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 shadow-sm px-4 py-2 text-sm bg-white" onchange="this.form.submit()">
                    <option value="">📋 Tous les statuts</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>✅ Approuvée</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>❌ Rejetée</option>
                </select>
                
                @if($status)
                    <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-1 px-4 py-2 text-sm text-gray-600 hover:text-[#F97316] bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Réinitialiser
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Grille des formations - Cartes cliquables -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <a href="{{ route('admin.courses.show', $course) }}" class="group block transform transition-all duration-300 hover:-translate-y-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:border-[#F97316]/30 transition-all duration-300 flex flex-col h-full relative">
                    <!-- Image d'arrière-plan avec overlay -->
                    <div class="h-48 relative overflow-hidden">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0B1A3E] to-[#1d3566]">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Overlay au survol -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <div class="bg-white/90 backdrop-blur-sm rounded-full p-3 transform scale-0 group-hover:scale-100 transition-all duration-300">
                                <svg class="w-6 h-6 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Badge de statut -->
                        <div class="absolute top-3 right-3 shrink-0 z-10">
                            @if($course->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500 text-white shadow-lg">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    En attente
                                </span>
                            @elseif($course->status === 'approved')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-lg">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Approuvée
                                </span>
                            @elseif($course->status === 'rejected')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500 text-white shadow-lg">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Rejetée
                                </span>
                            @endif
                        </div>
                        
                        <!-- Badge prix -->
                        <div class="absolute bottom-3 left-3 z-10">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#0B1A3E]/90 backdrop-blur-sm text-white border border-[#F97316]/30 shadow-lg">
                                <svg class="w-3 h-3 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ number_format($course->price, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-3">
                            <span class="text-[10px] font-bold text-[#F97316] uppercase tracking-wider bg-[#F97316]/10 px-2 py-1 rounded-lg">
                                {{ $course->category->name ?? 'Général' }}
                            </span>
                            <div class="flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $course->duration_minutes }} min
                            </div>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2 line-clamp-2 group-hover:text-[#F97316] transition-colors duration-300">
                            {{ $course->title }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">
                            {{ Str::limit($course->description, 80) }}
                        </p>

                        <div class="flex items-center gap-2 text-sm text-gray-500 mt-auto pt-3 border-t border-gray-100">
                            <div class="w-6 h-6 rounded-full bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] flex items-center justify-center text-white text-[10px] font-bold">
                                {{ substr($course->formateur->user->first_name, 0, 1) }}{{ substr($course->formateur->user->last_name, 0, 1) }}
                            </div>
                            <span class="text-xs truncate">{{ $course->formateur->user->first_name }} {{ substr($course->formateur->user->last_name, 0, 1) }}.</span>
                            <span class="text-xs text-gray-400 ml-auto">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $course->lessons_count }} leçons
                            </span>
                        </div>
                    </div>
                    
                    <!-- Indicateur de clic -->
                    <div class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-[#F97316] text-white text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1 shadow-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Examiner
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Aucune formation trouvée</h3>
                    <p class="text-gray-500">Essayez de modifier vos filtres pour voir plus de résultats.</p>
                    @if($status)
                        <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-[#F97316] text-white rounded-xl font-semibold hover:bg-[#ea580c] transition-all shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Réinitialiser les filtres
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Animation pour les cartes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .grid > a {
        animation: fadeInUp 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .grid > a:nth-child(1) { animation-delay: 0.05s; }
    .grid > a:nth-child(2) { animation-delay: 0.1s; }
    .grid > a:nth-child(3) { animation-delay: 0.15s; }
    .grid > a:nth-child(4) { animation-delay: 0.2s; }
    .grid > a:nth-child(5) { animation-delay: 0.25s; }
    .grid > a:nth-child(6) { animation-delay: 0.3s; }
</style>
@endsection