@extends('layouts.admin')

@section('header_title', 'Modifier l\'utilisateur')

@section('content')
    <div class="max-w-4xl mx-auto">

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
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">Modifier l'utilisateur</h1>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Modifiez les informations personnelles de <span
                        class="text-white font-semibold">{{ $user->full_name }}</span></p>
            </div>
        </div>

        <!-- Bouton retour flottant -->
        <div class="mb-4">
            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#F97316] transition-all duration-200 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Retour à la liste des utilisateurs
            </a>
        </div>

        <!-- Formulaire d'édition -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/20 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#0B1A3E] to-[#F97316]"></div>

            <div class="p-6 md:p-8">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Section Informations Personnelles -->
                    <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Informations Personnelles</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Prénom -->
                        <div>
                            <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[#F97316] mr-2"></i>Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="first_name" name="first_name" required
                                value="{{ old('first_name', $user->first_name) }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('first_name') border-red-500 @enderror">
                            @error('first_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[#F97316] mr-2"></i>Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" required
                                value="{{ old('last_name', $user->last_name) }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('last_name') border-red-500 @enderror">
                            @error('last_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-[#F97316] mr-2"></i>Adresse E-mail <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('email') border-red-500 @enderror">
                            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone text-[#F97316] mr-2"></i>Téléphone
                            </label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('phone') border-red-500 @enderror">
                            @error('phone') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Genre -->
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-venus-mars text-[#F97316] mr-2"></i>Sexe
                            </label>
                            <select id="gender" name="gender"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 bg-white @error('gender') border-red-500 @enderror">
                                <option value="">Sélectionner</option>
                                <option value="male" {{ (old('gender', $user->gender) == 'male') ? 'selected' : '' }}>👨 Homme
                                </option>
                                <option value="female" {{ (old('gender', $user->gender) == 'female') ? 'selected' : '' }}>👩
                                    Femme</option>
                                <option value="other" {{ (old('gender', $user->gender) == 'other') ? 'selected' : '' }}>🌐
                                    Autre</option>
                            </select>
                            @error('gender') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date de Naissance -->
                        <div>
                            <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar-alt text-[#F97316] mr-2"></i>Date de Naissance
                            </label>
                            <input type="date" id="birth_date" name="birth_date"
                                value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 @error('birth_date') border-red-500 @enderror">
                            @error('birth_date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Lieu de Naissance -->
                        <div>
                            <label for="birth_place" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-[#F97316] mr-2"></i>Lieu de Naissance
                            </label>
                            <input type="text" id="birth_place" name="birth_place"
                                value="{{ old('birth_place', $user->birth_place) }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('birth_place') border-red-500 @enderror">
                            @error('birth_place') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Section Mot de Passe -->
                    <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Changer le Mot de Passe</h3>
                    </div>
                    <p class="text-xs text-gray-500 mb-5 ml-10">Laissez ces champs vides si vous ne souhaitez pas modifier
                        le mot de passe.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-key text-[#F97316] mr-2"></i>Nouveau Mot de Passe
                            </label>
                            <input type="password" id="password" name="password" autocomplete="new-password"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 @error('password') border-red-500 @enderror">
                            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-check-circle text-[#F97316] mr-2"></i>Confirmer le Mot de Passe
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                autocomplete="new-password"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800">
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t-2 border-gray-200">
                        <a href="{{ route('admin.users.index') }}"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 border-2 border-gray-300 rounded-xl bg-white text-gray-700 hover:bg-gray-50 font-semibold transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-2.5 bg-gradient-to-r from-[#F97316] to-[#ea580c] text-white font-bold rounded-xl shadow-lg hover:shadow-[#F97316]/30 transition-all duration-300 transform hover:-translate-y-0.5">
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
    </div>

    <style>
        /* Style des inputs avec bordures bleu nuit */
        input,
        select {
            background-color: #ffffff;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        /* Placeholder style */
        input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Style pour les icônes dans les labels */
        label i {
            width: 18px;
            text-align: center;
        }
    </style>
@endsection