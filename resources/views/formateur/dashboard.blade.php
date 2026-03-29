@extends('layouts.formateur')

@section('title', 'Mon Espace - Formateur')

@section('content')
<div class="w-full flex flex-col space-y-8">
    
    <!-- Top Actions & Search -->
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-slate-100 gap-4">
        <!-- Search bar -->
        <form action="{{ route('formateur.catalog') }}" method="GET" class="relative w-full md:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-slate-400"></i>
            </div>
            <input type="text" name="search" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-0 rounded-xl text-sm placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:bg-white transition-all outline-none" placeholder="Rechercher dans le catalogue...">
        </form>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-3 w-full md:w-auto">
            <button onclick="document.getElementById('profileModal').classList.remove('hidden')" class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-navy-50 text-navy-700 hover:bg-navy-100 px-5 py-3 rounded-xl font-medium transition-colors">
                <i class="fas fa-user-cog"></i>
                <span>Gestion Profil</span>
            </button>
            <a href="{{ route('formateur.courses.create') }}" class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                <i class="fas fa-plus"></i>
                <span>Ajouter Formation</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Stat 1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-500 font-medium text-sm uppercase tracking-wider">Revenus Totaux</h3>
                    <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center"><i class="fas fa-wallet"></i></div>
                </div>
                <div class="text-3xl font-head font-bold text-slate-800">{{ number_format($totalRevenue, 0, ',', ' ') }} <span class="text-lg text-slate-400 font-medium">FCFA</span></div>
            </div>
        </div>
        
        <!-- Stat 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-navy-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-500 font-medium text-sm uppercase tracking-wider">Ventes (Achats)</h3>
                    <div class="w-10 h-10 bg-navy-100 text-navy-700 rounded-lg flex items-center justify-center"><i class="fas fa-shopping-cart"></i></div>
                </div>
                <div class="text-3xl font-head font-bold text-slate-800">{{ $totalSales }} <span class="text-lg text-slate-400 font-medium">ventes</span></div>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-slate-500 font-medium text-sm uppercase tracking-wider">Formations Publiées</h3>
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center"><i class="fas fa-book-open"></i></div>
                </div>
                <div class="text-3xl font-head font-bold text-slate-800">{{ $totalCourses }}</div>
            </div>
        </div>
        
        <!-- Stat 4 -->
        <div class="bg-gradient-to-br from-navy-900 to-navy-800 p-6 rounded-2xl shadow-lg relative overflow-hidden flex flex-col justify-center">
            <div class="absolute right-0 bottom-0 opacity-10 text-white text-8xl transform translate-x-4 translate-y-4">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="relative z-10 text-center">
                <h3 class="text-navy-300 font-medium text-sm mb-2">Fréquence des ventes</h3>
                <div class="text-3xl font-head font-bold text-white mb-1">+{{ rand(5, 25) }}%</div>
                <p class="text-xs text-orange-400">Cette semaine</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Panel: Apprenants & Rapports -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Apprenants inscrits -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h2 class="font-head text-lg font-bold text-navy-900"><i class="fas fa-users mr-2 text-navy-500"></i>Apprenants Inscrits (Ventes Récentes)</h2>
                    <button class="text-sm text-orange-500 font-medium hover:text-orange-600">Voir tout</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white text-slate-400 text-xs uppercase tracking-wider border-b border-slate-100">
                                <th class="px-6 py-4 font-medium">Apprenant</th>
                                <th class="px-6 py-4 font-medium">Formation (Achetée)</th>
                                <th class="px-6 py-4 font-medium">Montant</th>
                                <th class="px-6 py-4 font-medium">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-500 text-xs">
                                            {{ substr($order->user->first_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-800">{{ $order->user->first_name }} {{ $order->user->last_name }}</div>
                                            <div class="text-xs text-slate-400">{{ $order->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-slate-800 font-medium truncate max-w-[150px]">{{ $order->course->title }}</div>
                                </td>
                                <td class="px-6 py-4 text-emerald-600 font-semibold">{{ number_format($order->amount, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400">
                                    <i class="fas fa-box-open text-4xl mb-3 text-slate-200"></i>
                                    <p>Aucune vente pour le moment.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Rapport de vente -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="font-head text-lg font-bold text-navy-900"><i class="fas fa-chart-area mr-2 text-navy-500"></i>Rapport de Vente</h2>
                </div>
                <div class="p-6 h-64 flex items-center justify-center flex-col text-slate-400">
                    <i class="fas fa-chart-bar text-6xl mb-4 text-slate-200"></i>
                    <p>Interface de graphique analytique à connecter.</p>
                </div>
            </div>
        </div>

        <!-- Right Panel: Mes Formations -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h2 class="font-head text-lg font-bold text-navy-900"><i class="fas fa-film mr-2 text-navy-500"></i>Formations Récentes</h2>
                </div>
                <div class="p-4 space-y-4">
                    @forelse($recentCourses as $course)
                    <div class="flex space-x-4 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition-all group">
                        <div class="w-20 h-20 rounded-lg overflow-hidden flex-shrink-0 bg-slate-200 relative">
                            @if($course->thumbnail)
                                <img src="{{ asset($course->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-navy-100 text-navy-400"><i class="fas fa-video"></i></div>
                            @endif
                            @if($course->status == 'approved')
                                <div class="absolute top-1 right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white" title="Approuvée"></div>
                            @elseif($course->status == 'pending')
                                <div class="absolute top-1 right-1 w-3 h-3 bg-amber-500 rounded-full border-2 border-white" title="En attente"></div>
                            @endif
                        </div>
                        <div class="flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-navy-900 line-clamp-2 leading-tight group-hover:text-orange-500 transition-colors">{{ $course->title }}</h3>
                                <p class="text-xs text-slate-400 mt-1">{{ number_format($course->price, 0, ',', ' ') }} FCFA • {{ $course->lessons_count }} leçon(s)</p>
                            </div>
                            <a href="{{ route('formateur.courses.show', $course->id) }}" class="text-xs font-semibold text-navy-500 hover:text-navy-700 mt-2 inline-flex items-center">
                                Visionner <i class="fas fa-chevron-right ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400">
                        <p class="text-sm mb-4">Vous n'avez pas encore créé de formation.</p>
                        <a href="{{ route('formateur.courses.create') }}" class="text-sm bg-orange-100 text-orange-600 px-4 py-2 rounded-lg font-medium hover:bg-orange-200">Créer ma première formation</a>
                    </div>
                    @endforelse
                    
                    @if(count($recentCourses) > 0)
                    <a href="{{ route('formateur.courses.index') }}" class="block text-center w-full mt-2 py-3 bg-slate-50 text-slate-600 hover:bg-slate-100 rounded-xl text-sm font-semibold transition-colors">
                        Voir toutes mes formations
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Profile (Tailwind) -->
<div id="profileModal" class="fixed inset-0 z-[100] hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-navy-900/60 backdrop-blur-sm" onclick="document.getElementById('profileModal').classList.add('hidden')"></div>
    
    <!-- Modal Panel -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-white rounded-3xl shadow-2xl p-8 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-head font-bold text-navy-900">Gestion du Profil</h2>
            <button onclick="document.getElementById('profileModal').classList.add('hidden')" class="w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center hover:bg-slate-200"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('formateur.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Prénom</label>
                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nom</label>
                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
            </div>
            
            <hr class="border-slate-100">
            
            <div>
                <h3 class="text-lg font-bold text-navy-900 mb-4">Sécurité</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mot de passe actuel (si modification)</label>
                        <input type="password" name="current_password" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Confirmer mot de passe</label>
                            <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="border-slate-100">
            
            <div>
                <h3 class="text-lg font-bold text-navy-900 mb-4">Documents (Optionnel)</h3>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Rajouter un dossier/diplôme</label>
                    <input type="file" name="diploma_file" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100 text-sm text-slate-500">
                </div>
            </div>
            
            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-navy-900 hover:bg-navy-800 text-white px-8 py-3 rounded-xl font-medium shadow-lg shadow-navy-900/20 transition-all">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
@endsection