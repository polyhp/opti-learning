@extends('layouts.app')

@section('content')
<div class="relative min-h-screen py-12 bg-gradient-to-br from-[#0B1A3E] via-[#0D1F4A] to-[#0B1A3E]">
    <!-- Pattern flou en arrière-plan -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M60 0L0 0 0 60\' fill=\'none\' stroke=\'rgba(249,115,22,0.05)\' stroke-width=\'1\'/%3E%3C/svg%3E')] opacity-30"></div>
    
    <div class="container relative z-10 mx-auto max-w-5xl px-4 lg:px-8">
        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-8 text-center sm:text-left font-['Outfit']">
            <i class="fas fa-shopping-cart text-[#F97316] mr-2"></i> Mon Panier
        </h1>

        @if(session('success'))
            <div class="bg-green-100/90 backdrop-blur-sm border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg shadow-md mb-6">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(count($courses) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Liste des articles -->
                <div class="lg:col-span-2 space-y-5">
                    @foreach($courses as $course)
                        <div class="flex flex-col sm:flex-row bg-white rounded-2xl shadow-lg border-0 p-4 relative group transition-all duration-300 hover:shadow-orange-500/10 hover:shadow-xl hover:-translate-y-1">
                            <!-- Image de la formation -->
                            <div class="w-full sm:w-48 h-40 sm:h-32 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 mb-4 sm:mb-0 relative">
                                @if($course->thumbnail)
                                    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#122255] text-white">
                                        <i class="fas fa-book text-3xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2 py-1 rounded-md">
                                    <i class="fas fa-play-circle text-[#F97316] mr-1"></i> Formation
                                </div>
                            </div>

                            <!-- Détails de la formation -->
                            <div class="sm:ml-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-[#0B1A3E] leading-tight font-['Outfit'] group-hover:text-[#F97316] transition-colors">{{ $course->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Par <span class="font-medium text-gray-700">{{ $course->formateur->user->first_name ?? 'Inconnu' }} {{ $course->formateur->user->last_name ?? '' }}</span></p>
                                    <span class="inline-block mt-2 text-[11px] font-bold px-2.5 py-1 bg-orange-50 text-[#F97316] rounded-md border border-orange-100 uppercase tracking-widest">
                                        {{ $course->category->name ?? 'Général' }}
                                    </span>
                                </div>
                                
                                <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                                    <div class="text-xl sm:text-2xl font-black text-[#0B1A3E]">
                                        {{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $course->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-white transition px-3 py-1.5 text-sm bg-gray-50 hover:bg-red-500 rounded-lg flex items-center gap-2" title="Retirer du panier">
                                            <i class="fas fa-trash-alt"></i> <span class="hidden sm:inline">Retirer</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Résumé et Paiement -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-2xl border-0 p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-[#0B1A3E] mb-5 font-['Outfit'] border-b border-gray-100 pb-3">Récapitulatif</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Articles ({{ count($courses) }})</span>
                                <span class="font-medium">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <hr class="border-dashed border-gray-200">
                            <div class="flex justify-between items-end bg-orange-50 p-4 rounded-xl border border-orange-100/50">
                                <span class="text-md font-bold text-[#0B1A3E]">Total</span>
                                <span class="text-2xl sm:text-3xl font-black text-[#F97316]">{{ number_format($total, 0, ',', ' ') }} <span class="text-lg">FCFA</span></span>
                            </div>
                        </div>

                        @auth
                            <form action="{{ route('apprenant.checkout.cart') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-[#F97316] to-[#EA580C] hover:from-[#EA580C] hover:to-[#C2410C] text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-orange-500/30 transform transition hover:-translate-y-1 active:scale-95 flex justify-center items-center gap-3 text-lg">
                                    <i class="fas fa-lock text-sm bg-white/20 p-2 rounded-full"></i> Valider la commande
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="w-full bg-[#0B1A3E] hover:bg-[#122255] text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-blue-900/20 transform transition hover:-translate-y-1 active:scale-95 flex justify-center items-center gap-3 text-lg">
                                <i class="fas fa-user text-sm bg-white/10 p-2 rounded-full"></i> Se connecter pour payer
                            </a>
                        @endauth
                        
                        <div class="mt-6 flex flex-col items-center justify-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-2 text-[#0B1A3E] font-medium mb-1 text-sm">
                                <i class="fas fa-shield-alt text-green-500"></i> Paiement 100% sécurisé
                            </div>
                            <p class="text-center text-[11px] text-gray-500">
                                Par KkiaPay : Mobile Money & Cartes Bancaires.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Panier Vide -->
            <div class="bg-white rounded-3xl shadow-2xl p-10 lg:p-16 text-center max-w-2xl mx-auto relative overflow-hidden mt-8">
                <!-- Background decorations -->
                <div class="absolute -top-16 -right-16 w-32 h-32 bg-orange-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                <div class="absolute -bottom-16 -left-16 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-60 pointer-events-none"></div>
                
                <div class="relative z-10 w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-4 ring-white">
                    <i class="fas fa-shopping-basket text-4xl text-[#F97316]"></i>
                </div>
                
                <h2 class="text-3xl font-bold text-[#0B1A3E] mb-2 font-['Outfit']">Panier désert</h2>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Il semblerait que vous n'ayez ajouté aucune formation pour le moment. Explorez notre catalogue !</p>
                
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center bg-[#0B1A3E] hover:bg-[#122255] text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-900/20">
                    <i class="fas fa-search mr-2"></i> Parcourir les formations
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
