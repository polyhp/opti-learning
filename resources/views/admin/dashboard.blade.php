@extends('layouts.admin')

@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Apprenants</p>
                <p class="text-3xl font-bold text-[#0A2647] mt-2">{{ number_format($stats['apprenants'], 0, ',', ' ') }}</p>
                <p class="text-xs text-green-500 mt-2">Nouveaux inscrits</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-[#FF6B35]/10 to-[#FF8E5E]/10 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#FF6B35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Formateurs</p>
                <p class="text-3xl font-bold text-[#0A2647] mt-2">{{ number_format($stats['formateurs'], 0, ',', ' ') }}</p>
                <p class="text-xs text-green-500 mt-2">Partenaires actifs</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-[#FF6B35]/10 to-[#FF8E5E]/10 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#FF6B35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">Revenus Globaux</p>
                <p class="text-3xl font-bold text-[#0A2647] mt-2">{{ number_format($stats['revenue'], 0, ',', ' ') }} <span class="text-xl">F</span></p>
                <p class="text-xs text-green-500 mt-2">Chiffre d'affaires</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-br from-[#FF6B35]/10 to-[#FF8E5E]/10 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-[#FF6B35]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-[#FF6B35] to-[#FF8E5E] rounded-2xl p-6 shadow-lg card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-white/80 font-medium">Alerte Modération</p>
                <p class="text-3xl font-bold text-white mt-2">{{ $stats['pending_courses'] }}</p>
                <p class="text-xs text-white/70 mt-2">Formations en attente</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 max-w-4xl">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-[#0A2647]">Derniers Paiements</h3>
        <a href="{{ route('admin.payments.index') }}" class="text-sm text-[#FF6B35] hover:text-[#FF8E5E] font-medium transition-colors">Voir tout →</a>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($recentOrders as $order)
        <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden shrink-0">
                <img src="{{ $order->user->avatar_url }}" alt="avatar" class="w-full h-full object-cover">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $order->user->full_name }} <span class="text-xs text-gray-500 ml-1">a acheté</span></p>
                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $order->course->title ?? 'Formation' }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-[#0A2647]">{{ number_format($order->amount, 0, ',', ' ') }} F</p>
                <span class="text-[10px] text-gray-400">Il y a {{ $order->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-500">
            <p class="text-sm font-medium">Aucun paiement récent enregistré.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection