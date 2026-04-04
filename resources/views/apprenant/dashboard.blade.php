@extends('layouts.apprenant')

@section('title', 'Mon Parcours Apprenant - OptiLearning')

@section('content')
    <div class="w-full flex flex-col space-y-8">

        <!-- Top Actions & Search -->
        <div
            class="flex flex-col md:flex-row justify-between items-center bg-gradient-to-r from-navy-800 to-navy-900 p-4 rounded-2xl shadow-lg border border-navy-700 gap-4">
            <!-- Search bar -->
            <form action="{{ route('apprenant.catalog') }}" method="GET" class="relative w-full md:w-1/2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" name="search"
                    class="block w-full pl-11 pr-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-sm text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:bg-slate-700 transition-all outline-none">
            </form>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <button onclick="document.getElementById('profileModal').classList.remove('hidden')"
                    class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-navy-700 text-slate-200 hover:bg-navy-600 px-5 py-3 rounded-xl font-medium transition-all">
                    <i class="fas fa-user-cog"></i>
                    <span>Gestion Profil</span>
                </button>
                <a href="{{ route('apprenant.catalog') }}"
                    class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-compass"></i>
                    <span>Explorer le catalogue</span>
                </a>
            </div>
        </div>

        <!-- Mes Formations Actuelles -->
        <div
            class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl border border-slate-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-700 bg-slate-800/50 flex items-center justify-between">
                <h2 class="font-head text-lg font-bold text-white"><i
                        class="fas fa-book-reader mr-2 text-orange-500"></i>Mes Formations en cours</h2>
            </div>

            <div class="p-6">
                @if($enrolledCourses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrolledCourses as $course)
                            <div
                                class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-orange-500 transition-all duration-300 group flex flex-col h-full relative">
                                <!-- Image Container -->
                                <div class="h-40 overflow-hidden relative bg-slate-700">
                                    @if($course->thumbnail)
                                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy-800 text-navy-600">
                                            <i class="fas fa-laptop-code text-4xl"></i>
                                        </div>
                                    @endif
                                    <!-- Overlay Date -->
                                    <div
                                        class="absolute top-2 right-2 bg-slate-900/90 backdrop-blur text-slate-300 text-xs font-bold px-2 py-1 rounded-lg">
                                        Inscrit le {{ $course->order_date->format('d/m/Y') }}
                                    </div>
                                </div>

                                <!-- Content Container -->
                                <div class="p-5 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3
                                            class="font-head font-bold text-lg text-white mb-1 line-clamp-2 leading-tight group-hover:text-orange-400 transition-colors">
                                            {{ $course->title }}
                                        </h3>
                                        <p class="text-sm text-slate-400 mb-4 flex items-center">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-slate-500"></i>
                                            {{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}
                                        </p>
                                    </div>

                                    <!-- Progression & Stats -->
                                    <div class="space-y-4">
                                        <!-- Progress Bar -->
                                        <div>
                                            <div class="flex justify-between items-center text-xs mb-1">
                                                <span class="font-medium text-slate-400">Progrès des leçons</span>
                                                <span
                                                    class="font-bold {{ $course->custom_progress == 100 ? 'text-emerald-400' : 'text-orange-400' }}">{{ $course->custom_progress }}%</span>
                                            </div>
                                            <div class="w-full bg-slate-700 rounded-full h-2 overflow-hidden">
                                                <div class="h-full {{ $course->custom_progress == 100 ? 'bg-emerald-500' : 'bg-gradient-to-r from-orange-500 to-orange-600' }} rounded-full"
                                                    style="width: {{ $course->custom_progress }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Quiz Note -->
                                        <div
                                            class="flex items-center justify-between p-3 bg-slate-700/50 rounded-xl border border-slate-700">
                                            <div class="flex items-center space-x-2">
                                                <i
                                                    class="fas fa-clipboard-check {{ $course->custom_passed ? 'text-emerald-400' : 'text-slate-500' }}"></i>
                                                <span class="text-xs font-semibold text-slate-300">Note Finale</span>
                                            </div>
                                            @if(!is_null($course->custom_score))
                                                <span
                                                    class="font-head font-bold text-sm {{ $course->custom_passed ? 'text-emerald-400' : 'text-red-400' }}">{{ $course->custom_score }}/20</span>
                                            @else
                                                <span class="text-xs text-orange-400 font-medium">À passer</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="p-4 border-t border-slate-700 bg-slate-800/50 flex justify-between items-center gap-2">
                                    <a href="{{ route('apprenant.courses.watch', $course->id) }}"
                                        class="flex-grow text-center bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium py-2.5 rounded-xl transition-colors shadow-lg shadow-orange-500/20">
                                        {{ $course->custom_progress == 100 ? 'Réviser' : 'Continuer' }}
                                    </a>

                                    @if($course->can_download_certificate)
                                        <a href="{{ route('apprenant.certificate.download', $course->id) }}"
                                            class="flex-none bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white p-2.5 rounded-xl transition-all"
                                            title="Télécharger le certificat PDF">
                                            <i class="fas fa-award text-lg"></i>
                                        </a>
                                    @else
                                        <button disabled
                                            class="flex-none bg-slate-700 text-slate-500 p-2.5 rounded-xl cursor-not-allowed"
                                            title="Le certificat n'est pas encore débloqué">
                                            <i class="fas fa-lock text-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div
                            class="w-24 h-24 bg-slate-700 rounded-full flex items-center justify-center text-slate-500 text-4xl mb-4">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Aucune formation en cours</h3>
                        <p class="text-slate-400 max-w-md mx-auto mb-6">Vous ne participez à aucune formation pour le moment.
                            Explorez notre catalogue pour commencer votre apprentissage !</p>
                        <a href="{{ route('apprenant.catalog') }}"
                            class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-xl font-medium transition-colors shadow-lg shadow-orange-500/20">
                            Découvrir les formations
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Nouvelles Propositions de Formations -->
        @if($suggestedCourses->count() > 0)
            <div
                class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl border border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-700 bg-slate-800/50 flex justify-between items-center">
                    <h2 class="font-head text-lg font-bold text-white"><i class="fas fa-star text-orange-500 mr-2"></i>Nos
                        recommandations pour vous</h2>
                    <a href="{{ route('apprenant.catalog') }}"
                        class="text-sm font-medium text-orange-400 hover:text-orange-300 transition-colors">Voir tout &rarr;</a>
                </div>

                <div class="p-6">
                    <!-- Scrollable Container -->
                    <div class="flex overflow-x-auto space-x-6 pb-4 snap-x snap-mandatory hide-scrollbar">
                        @foreach($suggestedCourses as $suggestion)
                            <div
                                class="snap-start flex-none w-72 bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-orange-500 transition-all group">
                                <div class="h-36 relative overflow-hidden bg-slate-700">
                                    @if($suggestion->thumbnail)
                                        <img src="{{ asset($suggestion->thumbnail) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy-800 text-navy-600">
                                            <i class="fas fa-video text-3xl"></i>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute top-2 right-2 bg-slate-900/90 backdrop-blur text-orange-400 text-xs font-bold px-2 py-1 rounded">
                                        {{ number_format($suggestion->price, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-head font-bold text-white text-sm mb-1 line-clamp-2 min-h-[40px]">
                                        {{ $suggestion->title }}
                                    </h3>
                                    <p class="text-xs text-slate-400 mb-3"><i class="fas fa-user-circle mr-1"></i>
                                        {{ $suggestion->formateur->user->first_name }}</p>
                                    <a href="{{ route('courses.show', $suggestion->id) }}"
                                        class="block w-full text-center py-2 bg-slate-700 text-slate-300 text-xs font-bold rounded-lg hover:bg-orange-600 hover:text-white transition-all">En
                                        savoir plus</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <style>
                        .hide-scrollbar::-webkit-scrollbar {
                            display: none;
                        }

                        .hide-scrollbar {
                            -ms-overflow-style: none;
                            scrollbar-width: none;
                        }
                    </style>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Profile (Tailwind) -->
    <div id="profileModal" class="fixed inset-0 z-[100] hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"
            onclick="document.getElementById('profileModal').classList.add('hidden')"></div>

        <!-- Modal Panel -->
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-2xl border border-slate-700 p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-head font-bold text-white">Mon Profil</h2>
                <button onclick="document.getElementById('profileModal').classList.add('hidden')"
                    class="w-8 h-8 bg-slate-700 text-slate-400 rounded-full flex items-center justify-center hover:bg-slate-600 hover:text-white transition-colors"><i
                        class="fas fa-times"></i></button>
            </div>

            <form action="{{ route('apprenant.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Prénom</label>
                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" required
                        class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Nom</label>
                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" required
                        class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                <hr class="border-slate-700">

                <div>
                    <h3 class="text-md font-bold text-white mb-3">Sécurité</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Mot de passe actuel (si
                                modification)</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-400 mb-1">Confirmer mot de passe</label>
                            <input type="password" name="new_password_confirmation"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-orange-500/30 transition-all border border-orange-600">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection