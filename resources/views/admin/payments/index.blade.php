@extends('layouts.admin')

@section('content')
    <div>
        <!-- Header attractif -->
        <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] p-6 shadow-xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(249,115,22,0.08)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#F97316]/20 flex items-center justify-center border border-[#F97316]/30">
                            <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Suivi des Paiements</h1>
                    </div>
                    <p class="text-[#F97316]/80 text-sm ml-13">Consultez l'historique des transactions et gérez les revenus
                    </p>
                </div>

                <a href="{{ route('admin.payments.export') }}"
                    class="group flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exporter en CSV
                </a>
            </div>
        </div>

        <!-- KPIs Paiements - Style moderne -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Carte Revenus Totaux -->
            <div
                class="group bg-white rounded-2xl shadow-lg border border-[#F97316]/10 p-6 hover:shadow-2xl hover:border-[#F97316]/30 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider">Revenus Totaux</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-3/4 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full"></div>
                </div>
            </div>

            <!-- Carte Revenus du mois -->
            <div
                class="group bg-white rounded-2xl shadow-lg border border-[#F97316]/10 p-6 hover:shadow-2xl hover:border-[#F97316]/30 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#F97316] to-[#ea580c] flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 font-medium uppercase tracking-wider">Revenus ce mois</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($monthlyRevenue, 0, ',', ' ') }}
                                FCFA</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-xs font-semibold text-[#F97316] bg-[#F97316]/10 px-2 py-1 rounded-lg">{{ \Carbon\Carbon::now()->locale('fr')->translatedFormat('F Y') }}</span>
                    </div>
                </div>
                <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full w-1/2 bg-gradient-to-r from-[#F97316] to-[#ea580c] rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Filtres élégants -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-[#F97316]/20 p-5 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Filtrer par statut :</span>
                </div>

                <form method="GET" action="{{ route('admin.payments.index') }}" class="flex flex-wrap gap-3 items-center">
                    <select name="status" id="status"
                        class="rounded-xl border-2 border-gray-200 focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 shadow-sm px-4 py-2 text-sm bg-white"
                        onchange="this.form.submit()">
                        <option value="">📋 Toutes les transactions</option>
                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>✅ Complétées</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>❌ Échouées</option>
                    </select>

                    @if($status)
                        <a href="{{ route('admin.payments.index') }}"
                            class="flex items-center gap-1 px-4 py-2 text-sm text-gray-600 hover:text-[#F97316] bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table des paiements stylisée -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/10 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] text-white">
                            <th class="px-6 py-4 font-semibold text-sm">ID Trans.</th>
                            <th class="px-6 py-4 font-semibold text-sm">Client</th>
                            <th class="px-6 py-4 font-semibold text-sm">Formation</th>
                            <th class="px-6 py-4 font-semibold text-sm">Montant</th>
                            <th class="px-6 py-4 font-semibold text-sm">Date</th>
                            <th class="px-6 py-4 font-semibold text-sm">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-[#FFF6EC] transition-all duration-200 group">
                                <td class="px-6 py-4">
                                    <span
                                        class="font-mono text-xs font-semibold text-[#F97316] bg-[#F97316]/10 px-2 py-1 rounded-lg">
                                        #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->user)
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] flex items-center justify-center text-white font-bold text-sm shadow-md">
                                                    {{ substr($payment->user->first_name, 0, 1) }}{{ substr($payment->user->last_name, 0, 1) }}
                                                </div>
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $payment->user->full_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $payment->user->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Client introuvable</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        <p class="text-gray-800 max-w-[200px] truncate font-medium"
                                            title="{{ $payment->course ? $payment->course->title : 'Inconnue' }}">
                                            {{ $payment->course ? $payment->course->title : 'Inconnue' }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="font-bold text-gray-900 text-lg">{{ number_format($payment->amount, 0, ',', ' ') }}
                                        <span class="text-xs text-gray-400">FCFA</span></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1 text-gray-500 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $payment->created_at->format('d/m/Y') }}
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">{{ $payment->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->status === 'completed' || $payment->status === 'paid')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            Succès
                                        </span>
                                    @elseif($payment->status === 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                            En attente
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Échoué
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Aucune transaction trouvée</p>
                                        <p class="text-gray-400 text-sm">Essayez de modifier vos filtres</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Animation pour l'apparition des lignes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tbody tr {
            animation: fadeInUp 0.3s ease-out forwards;
            opacity: 0;
        }

        tbody tr:nth-child(1) {
            animation-delay: 0.05s;
        }

        tbody tr:nth-child(2) {
            animation-delay: 0.1s;
        }

        tbody tr:nth-child(3) {
            animation-delay: 0.15s;
        }

        tbody tr:nth-child(4) {
            animation-delay: 0.2s;
        }

        tbody tr:nth-child(5) {
            animation-delay: 0.25s;
        }

        tbody tr:nth-child(6) {
            animation-delay: 0.3s;
        }

        tbody tr:nth-child(7) {
            animation-delay: 0.35s;
        }

        tbody tr:nth-child(8) { animation-delay: 0.4s; }
        tbody tr:nth-child(9) { animation-delay: 0.45s; }
        tbody tr:nth-child(10) { animation-delay: 0.5s; }
    </style>
@endsection