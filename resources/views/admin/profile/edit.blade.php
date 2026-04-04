@extends('layouts.admin')

@section('header_title', 'Paramètres et Profil')

@section('content')
    <div class="max-w-4xl">

        <!-- Header attractif -->
        <div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-[#0B1A3E] to-[#1d3566] p-6 shadow-xl">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(249,115,22,0.08)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-20"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="w-10 h-10 rounded-xl bg-[#F97316]/20 flex items-center justify-center border border-[#F97316]/30">
                        <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-extrabold text-white tracking-tight">Mon Profil Administrateur</h2>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Mettez à jour vos informations personnelles et sécurisez votre
                    compte.</p>
            </div>
        </div>

        <!-- Edit Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/20 overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/80 flex items-center">
                <div class="w-8 h-8 rounded-lg bg-[#F97316]/15 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Informations Personnelles</h3>
            </div>

            <div class="p-6 md:p-8">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[#F97316] mr-2"></i>Prénom
                            </label>
                            <input type="text" name="first_name" id="first_name"
                                value="{{ old('first_name', $user->first_name) }}" required
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[#F97316] mr-2"></i>Nom de famille
                            </label>
                            <input type="text" name="last_name" id="last_name"
                                value="{{ old('last_name', $user->last_name) }}" required
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-[#F97316] mr-2"></i>Adresse Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full md:w-2/3 px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="border-t-2 border-gray-200 pt-8 mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-[#F97316]/15 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-800">Changer de mot de passe</h4>
                        </div>
                        <p class="text-xs text-gray-500 mb-5 ml-10">Laissez ces champs vides si vous ne souhaitez pas
                            modifier votre mot de passe actuel.</p>

                        <div class="space-y-5 max-w-md">
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock text-[#F97316] mr-2"></i>Mot de passe actuel
                                </label>
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                                @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-key text-[#F97316] mr-2"></i>Nouveau mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-[#F97316] mr-2"></i>Confirmer le nouveau mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t-2 border-gray-200">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#F97316] to-[#ea580c] text-white font-bold rounded-xl shadow-lg hover:shadow-[#F97316]/30 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#F97316]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations supplémentaires - Carte de statut -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/20 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50/80 flex items-center">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Statut du compte</h3>
            </div>

            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-16 h-16 rounded-xl bg-gradient-to-br from-[#0B1A3E] to-[#1d3566] flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Rôle</p>
                            <p class="font-bold text-gray-800 text-lg">Administrateur</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Statut</p>
                            <p class="font-semibold text-emerald-600">Compte actif</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-[#F97316]/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Membre depuis</p>
                            <p class="font-semibold text-gray-800">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animation fade up */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.5s ease-out forwards;
        }

        /* Style des inputs avec bordures bleu nuit */
        input,
        select,
        textarea {
            background-color: #ffffff;
            border-color: rgba(11, 26, 62, 0.3);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        /* Placeholder style */
        input::placeholder,
        textarea::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Style pour les icônes dans les labels */
        label i {
            width: 18px;
            text-align: center;
        }

        /* Amélioration du contraste */
        .text-gray-700 {
            color: #374151;
        }

        .text-gray-800 {
            color: #1f2937;
        }
    </style>
@endsection