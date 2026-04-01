@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary-dark">Nouvel Administrateur</h1>
        <p class="text-gray-500 mt-1">Créez un nouveau compte avec les privilèges d'administration.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Prénom -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}" 
                            class="w-full rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm @error('first_name') border-red-500 @enderror">
                        @error('first_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    
                    <!-- Nom -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nom <span class="text-red-500">*</span></label>
                        <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}" 
                            class="w-full rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm @error('last_name') border-red-500 @enderror">
                        @error('last_name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse E-mail <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" 
                        class="w-full rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm @error('email') border-red-500 @enderror" placeholder="exemple@opti-learning.com">
                    @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe <span class="text-red-500">*</span></label>
                        <input type="password" id="password" name="password" required 
                            class="w-full rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm @error('password') border-red-500 @enderror">
                        @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères.</p>
                    </div>
                    
                    <!-- Confirm password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmez le mot de passe <span class="text-red-500">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                            class="w-full rounded-lg border-gray-300 focus:border-primary-orange focus:ring focus:ring-primary-orange/20 shadow-sm">
                    </div>
                </div>

                <div class="flex items-center justify-end border-t border-gray-100 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-50 font-medium transition-colors mr-3">Annuler</a>
                    <button type="submit" class="px-6 py-2 bg-primary-dark text-white rounded-lg hover:bg-opacity-90 transition-colors font-medium shadow-sm">Créer l'administrateur</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
