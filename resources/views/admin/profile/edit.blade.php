@extends('layouts.admin')

@section('header_title', 'Paramètres et Profil')

@section('content')
<div class="max-w-4xl">
    
    <div class="mb-8 animate-fade-up">
        <h2 class="text-2xl font-extrabold text-[#0A2647] tracking-tight">Mon Profil Administrateur</h2>
        <p class="text-sm font-medium text-gray-500 mt-1">Mettez à jour vos informations personnelles et sécurisez votre compte.</p>
    </div>

    <!-- Edit Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 animate-fade-up" style="animation-delay: 0.1s;">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-[#0A2647]">Informations Personnelles</h3>
        </div>
        
        <div class="p-6 md:p-8">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required
                               class="w-full rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de famille</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required
                               class="w-full rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full md:w-1/2 rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="border-t border-gray-100 pt-8 mb-6">
                    <h4 class="text-base font-bold text-[#0A2647] mb-4">Changer de mot de passe</h4>
                    <p class="text-xs text-gray-500 mb-4">Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe actuel.</p>
                    
                    <div class="space-y-4 max-w-md">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                            <input type="password" name="current_password" id="current_password"
                                   class="w-full rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                            @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password"
                                   class="w-full rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full rounded-xl border-gray-300 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 shadow-sm text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#FF6B35] to-[#FF8E5E] text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF6B35]">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
