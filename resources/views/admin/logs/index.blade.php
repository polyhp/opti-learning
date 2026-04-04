@extends('layouts.admin')

@section('content')
    <div x-data="{ 
            selectedDate: '{{ request('date') }}', 
            loading: false,
            refreshLogs() {
                this.loading = true;
                const url = this.selectedDate ? `{{ route('admin.logs.index') }}?date=${this.selectedDate}` : '{{ route('admin.logs.index') }}';
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('tbody');
                    const newPagination = doc.querySelector('.pagination-container');
                    if (newContent) {
                        document.querySelector('tbody').innerHTML = newContent.innerHTML;
                    }
                    if (newPagination) {
                        const paginationDiv = document.querySelector('.pagination-container');
                        if (paginationDiv) paginationDiv.innerHTML = newPagination.innerHTML;
                    }
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.loading = false;
                });
            }
        }" x-init="() => {
            $watch('selectedDate', (value) => {
                if (value) {
                    loading = true;
                    fetch(`{{ route('admin.logs.index') }}?date=${value}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('tbody');
                        const newPagination = doc.querySelector('.pagination-container');
                        if (newContent) {
                            document.querySelector('tbody').innerHTML = newContent.innerHTML;
                        }
                        if (newPagination) {
                            const paginationDiv = document.querySelector('.pagination-container');
                            if (paginationDiv) paginationDiv.innerHTML = newPagination.innerHTML;
                        }
                        loading = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loading = false;
                    });
                } else {
                    window.location.href = '{{ route('admin.logs.index') }}';
                }
            });
        }">
        <!-- Header attractif -->
        <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] p-6 shadow-xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(249,115,22,0.08)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 mb-2">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#F97316]/20 flex items-center justify-center border border-[#F97316]/30">
                            <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Journal d'activités</h1>
                    </div>
                    <!-- Bouton Rafraîchir pour mobile -->
                    <button @click="refreshLogs()"
                        class="lg:hidden flex items-center gap-2 px-3 py-2 bg-[#F97316]/20 hover:bg-[#F97316]/30 text-white rounded-xl transition-all duration-200 border border-[#F97316]/30">
                        <svg class="w-4 h-4" :class="{'animate-spin': loading}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span class="text-sm">Actualiser</span>
                    </button>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Consultez l'historique des actions effectuées par les
                    administrateurs.</p>
            </div>
        </div>

        <!-- Filtres élégants -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-[#F97316]/20 p-5 mb-6">
            <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Filtrer par date :</span>
                </div>

                <div class="flex flex-wrap gap-3 items-center">
                    <input type="date" name="date" id="date" x-model="selectedDate"
                        class="rounded-xl border-2 border-gray-200 focus:border-[#F97316] focus:ring focus:ring-[#F97316]/20 shadow-sm px-4 py-2 text-sm bg-white transition-all">

                    <div x-show="loading" class="flex items-center gap-2 text-[#F97316]">
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-sm">Chargement...</span>
                    </div>

                    <template x-if="selectedDate">
                        <a href="#" @click.prevent="selectedDate = ''; refreshLogs()"
                            class="flex items-center gap-1 px-4 py-2 text-sm text-gray-600 hover:text-[#F97316] bg-gray-100 rounded-xl hover:bg-gray-200 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Réinitialiser
                        </a>
                    </template>

                    <!-- Bouton Rafraîchir pour desktop -->
                    <button @click="refreshLogs()"
                        class="hidden lg:flex items-center gap-2 px-4 py-2 bg-[#F97316]/10 hover:bg-[#F97316]/20 text-[#F97316] rounded-xl transition-all duration-200 border border-[#F97316]/20">
                        <svg class="w-4 h-4" :class="{'animate-spin': loading}" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        <span>Actualiser</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tableau des logs stylisé -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] text-white">
                            <th class="px-6 py-4 font-semibold text-sm">Date</th>
                            <th class="px-6 py-4 font-semibold text-sm">Administrateur</th>
                            <th class="px-6 py-4 font-semibold text-sm">Action</th>
                            <th class="px-6 py-4 font-semibold text-sm">Description</th>
                            <th class="px-6 py-4 font-semibold text-sm">Adresse IP</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-[#FFF6EC] transition-all duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                            {{ substr($log->user->first_name ?? 'A', 0, 1) }}{{ substr($log->user->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-gray-800 text-sm">{{ $log->user ? $log->user->full_name : 'Administrateur inconnu' }}</span>
                                            <span class="text-xs text-gray-500">{{ $log->user->email ?? 'Email non disponible' }}</span>
                                            @if($log->user && $log->user->phone)
                                                <span class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    {{ $log->user->phone }}
                                                </span>
                                            @endif
                                            @if($log->user && $log->user->role)
                                                <span class="text-[10px] font-medium uppercase tracking-wider text-[#F97316] mt-0.5">
                                                    {{ $log->user->is_super_admin ? 'Super Admin' : 'Admin' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 text-gray-600 text-sm max-w-md">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="break-words">{{ $log->description }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <code
                                        class="text-xs font-mono bg-gray-100 px-2 py-1 rounded-lg text-gray-600 border border-gray-200">
                                                {{ $log->ip_address }}
                                            </code>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">Aucune activité enregistrée</p>
                                        <p class="text-gray-400 text-sm">Les actions des administrateurs apparaîtront ici</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
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

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
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

        tbody tr:nth-child(8) {
            animation-delay: 0.4s;
        }

        tbody tr:nth-child(9) {
            animation-delay: 0.45s;
        }

        tbody tr:nth-child(10) {
            animation-delay: 0.5s;
        }

        /* Animation de pulsation pour le bouton d'actualisation */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        button:active {
            transform: scale(0.98);
        }
    </style>
@endsection