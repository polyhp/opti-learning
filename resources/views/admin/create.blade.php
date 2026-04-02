@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary-dark">Nouvel Administrateur</h1>
        <p class="text-gray-500 mt-1">Créez un nouveau compte avec les privilèges d'administration.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#0A2647] to-[#1E3A5F]"></div>
        <div class="p-8 md:p-10">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Prénom -->
                    <div class="group">
                        <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-[#FF6B35] transition-colors">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 bg-gray-50 focus:bg-white transition-all shadow-sm @error('first_name') border-red-500 @enderror">
                        @error('first_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Nom -->
                    <div class="group">
                        <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-[#FF6B35] transition-colors">Nom <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 bg-gray-50 focus:bg-white transition-all shadow-sm @error('last_name') border-red-500 @enderror">
                        @error('last_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-10 group">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-[#FF6B35] transition-colors">Adresse E-mail <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 group-focus-within:text-[#FF6B35] transition-colors"></i>
                        </div>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" 
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#FF6B35] focus:ring focus:ring-[#FF6B35]/20 bg-gray-50 focus:bg-white transition-all shadow-sm @error('email') border-red-500 @enderror" placeholder="exemple@opti-learning.com">
                    </div>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle mr-1"></i> Un e-mail d'invitation sera envoyé à cette adresse pour finaliser la configuration.</p>
                    @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end border-t border-gray-100 pt-8 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 border border-gray-200 rounded-xl bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-900 font-semibold transition-all shadow-sm">Annuler</a>
                    <button type="submit" class="btn-primary text-white font-bold px-8 py-3 rounded-xl shadow-lg flex items-center gap-2">
                        Envoyer l'invitation
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
