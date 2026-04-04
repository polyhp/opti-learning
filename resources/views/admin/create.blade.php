@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto">

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
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-extrabold text-white tracking-tight">Nouvel Administrateur</h1>
                </div>
                <p class="text-[#F97316]/80 text-sm ml-13">Créez un nouveau compte avec les privilèges d'administration.</p>
            </div>
        </div>

        <!-- Formulaire de création -->
        <div class="bg-white rounded-2xl shadow-xl border border-[#F97316]/20 overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#0B1A3E] to-[#F97316]"></div>

            <div class="p-6 md:p-8">
                <form action="{{ route('admin.store') }}" method="POST">
                    @csrf

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
                            <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('first_name') border-red-500 @enderror">
                            @error('first_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user text-[#F97316] mr-2"></i>Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}"
                                class="w-full px-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('last_name') border-red-500 @enderror">
                            @error('last_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-8">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope text-[#F97316] mr-2"></i>Adresse E-mail <span
                                class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="w-full pl-11 pr-4 py-2.5 border-2 border-[#0B1A3E]/30 rounded-xl focus:border-[#F97316] focus:ring-2 focus:ring-[#F97316]/20 transition-all text-gray-800 placeholder-gray-400 @error('email') border-red-500 @enderror"
                                placeholder="exemple@opti-learning.com">
                        </div>
                        @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Section Permissions -->
                    <div class="flex items-center gap-2 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-8 h-8 rounded-lg bg-[#F97316]/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#F97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Privilèges et Accès</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <!-- Permission Utilisateurs -->
                        <label
                            class="flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316]/50 transition-all duration-200 group">
                            <input type="checkbox" name="permissions[]" value="manage-users"
                                class="mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316] focus:ring-2">
                            <div class="ml-3">
                                <span
                                    class="block text-sm font-bold text-gray-800 group-hover:text-[#F97316] transition-colors">
                                    <i class="fas fa-users text-[#F97316] mr-1"></i> Utilisateurs
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">Gérer les comptes formateurs et
                                    apprenants</span>
                            </div>
                        </label>

                        <!-- Permission Formations -->
                        <label
                            class="flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316]/50 transition-all duration-200 group">
                            <input type="checkbox" name="permissions[]" value="manage-courses"
                                class="mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316] focus:ring-2">
                            <div class="ml-3">
                                <span
                                    class="block text-sm font-bold text-gray-800 group-hover:text-[#F97316] transition-colors">
                                    <i class="fas fa-book-open text-[#F97316] mr-1"></i> Formations
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">Valider ou rejeter les formations</span>
                            </div>
                        </label>

                        <!-- Permission Paiements -->
                        <label
                            class="flex items-start p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-[#FFF6EC] hover:border-[#F97316]/50 transition-all duration-200 group">
                            <input type="checkbox" name="permissions[]" value="manage-payments"
                                class="mt-1 w-4 h-4 text-[#F97316] border-gray-300 rounded focus:ring-[#F97316] focus:ring-2">
                            <div class="ml-3">
                                <span
                                    class="block text-sm font-bold text-gray-800 group-hover:text-[#F97316] transition-colors">
                                    <i class="fas fa-credit-card text-[#F97316] mr-1"></i> Paiements
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">Suivre les transactions financières</span>
                            </div>
                        </label>

                        @if(auth()->check() && auth()->user()->is_super_admin)
                        <!-- Super Admin -->
                        <label
                            class="flex items-start p-4 border-2 border-[#1d3566]/20 rounded-xl cursor-pointer hover:bg-[#1d3566]/5 hover:border-[#1d3566]/50 transition-all duration-200 group">
                            <input type="checkbox" name="is_super_admin" value="1"
                                class="mt-1 w-4 h-4 text-[#1d3566] border-gray-300 rounded focus:ring-[#1d3566] focus:ring-2">
                            <div class="ml-3">
                                <span
                                    class="block text-sm font-bold text-[#1d3566] group-hover:text-[#F97316] transition-colors">
                                    <i class="fas fa-crown text-[#F97316] mr-1"></i> Super Admin
                                </span>
                                <span class="block text-xs text-gray-500 mt-1">Accès total non restreint</span>
                            </div>
                        </label>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 p-4 bg-[#F97316]/5 rounded-xl border border-[#F97316]/20 mb-8">
                        <i class="fas fa-info-circle text-[#F97316] text-sm"></i>
                        <p class="text-xs text-gray-600"><span class="font-semibold">Information :</span> Un e-mail
                            d'invitation sera envoyé à cette adresse pour finaliser la configuration du compte
                            administrateur.</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 2v4m0 0l-2-2m2 2l2-2M4 16a2 2 0 012-2h12a2 2 0 012 2M4 20h16a2 2 0 002-2v-2H2v2a2 2 0 002 2z">
                                </path>
                            </svg>
                            Envoyer l'invitation
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

        /* Checkbox personnalisée au focus */
        input[type="checkbox"]:focus {
            box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.2);
        }
    </style>
@endsection