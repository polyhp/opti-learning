@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-primary-dark">Gestion des Formations</h1>
            <p class="text-gray-500 mt-1">Gérez le catalogue des formations et validez les propositions.</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.courses.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par statut</label>
                <select name="status" id="status" class="rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm" onchange="this.form.submit()">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approuvée</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>
            
            @if($status)
                <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-primary-orange bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Grille des cours -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                <!-- Thumbnail -->
                <div class="h-48 bg-gray-200 relative">
                    @if($course->thumbnail)
                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-100">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <!-- Badge de statut -->
                    <div class="absolute top-3 right-3 shrink-0">
                        @if($course->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                En attente
                            </span>
                        @elseif($course->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                Approuvée
                            </span>
                        @elseif($course->status === 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                Rejetée
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Contenu -->
                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-medium text-primary-orange uppercase tracking-wider">{{ $course->category->name }}</span>
                        <span class="font-bold text-gray-900">{{ number_format($course->price, 0, ',', ' ') }} F</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-primary-dark leading-tight mb-2 line-clamp-2" title="{{ $course->title }}">
                        {{ $course->title }}
                    </h3>
                    
                    <div class="flex items-center text-sm text-gray-500 mb-4 items-center">
                        <img src="{{ $course->formateur->user->avatar_url }}" alt="" class="w-5 h-5 rounded-full mr-2">
                        <span class="truncate">{{ $course->formateur->user->full_name }}</span>
                    </div>

                    <!-- Espace flexible pour pousser les boutons en bas -->
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.courses.show', $course) }}" class="block w-full py-2 px-4 bg-gray-50 hover:bg-gray-100 text-center text-sm font-semibold text-gray-700 rounded-lg transition-colors border border-gray-200">
                            Examiner en détail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune formation trouvée</h3>
                <p class="text-gray-500">Essayez de modifier vos filtres.</p>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
