@extends('layouts.app')

@section('title', 'Inscription Apprenant - OPTI-LEARNING')

@section('content')
<div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Background avec effet de nuit -->
    <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" xmlns="http://www.w3.org/2000/svg"%3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,107,53,0.1)" stroke-width="1"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"/%3E%3C/svg%3E')] opacity-20"></div>
    </div>
    
    <div class="relative w-full max-w-4xl">
        <div class="bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden">
            <div class="grid md:grid-cols-2">
                <!-- Left Panel - Branding -->
                <div class="hidden md:block bg-gradient-to-br from-orange-500 to-orange-600 p-8 text-white">
                    <div class="h-full flex flex-col justify-between">
                        <div>
                            <div class="flex items-center space-x-3 mb-8">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                </div>
                                <span class="text-2xl font-bold">OPTI-LEARNING</span>
                            </div>
                            <h2 class="text-3xl font-bold mb-4">Devenez Apprenant</h2>
                            <p class="text-orange-100 mb-6">Accédez à des formations de qualité et développez vos compétences avec nos experts.</p>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-orange-200"></i>
                                    <span>Accès illimité à tous les cours</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-orange-200"></i>
                                    <span>Certificats reconnus</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-orange-200"></i>
                                    <span>Support 24/7</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8">
                            <div class="border-t border-orange-400 pt-6">
                                <p class="text-sm text-orange-100">Déjà un compte ?</p>
                                <a href="{{ route('login') }}" class="text-white font-semibold hover:text-orange-200 transition">
                                    Connectez-vous ici <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Panel - Form -->
                <div class="p-8 md:p-10 bg-white">
                    <div class="mb-8 text-center md:text-left">
                        <h2 class="text-2xl md:text-3xl font-bold text-navy-900 mb-2">Inscription Apprenant</h2>
                        <p class="text-gray-600">Créez votre compte et commencez votre apprentissage</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register.apprenant') }}" class="space-y-5">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user text-orange-500 mr-2"></i>Nom
                                </label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('last_name') border-red-500 @enderror"
                                    placeholder="Votre nom">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user text-orange-500 mr-2"></i>Prénom
                                </label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('first_name') border-red-500 @enderror"
                                    placeholder="Votre prénom">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-orange-500 mr-2"></i>Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                placeholder="exemple@email.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone text-orange-500 mr-2"></i>Téléphone
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                placeholder="+229 XX XX XX XX">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-venus-mars text-orange-500 mr-2"></i>Sexe
                                </label>
                                <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                                    <option value="">Sélectionnez</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-orange-500 mr-2"></i>Date de naissance
                                </label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('birth_date') border-red-500 @enderror">
                                @error('birth_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>Lieu de naissance
                            </label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('birth_place') border-red-500 @enderror"
                                placeholder="Ville, Pays">
                            @error('birth_place')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock text-orange-500 mr-2"></i>Mot de passe
                                </label>
                                <input type="password" name="password" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-check-circle text-orange-500 mr-2"></i>Confirmer mot de passe
                                </label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                    placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-orange-500 rounded border-gray-300 focus:ring-orange-500">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                J'accepte les <a href="#" class="text-orange-500 hover:text-orange-600">conditions générales d'utilisation</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition duration-300 transform hover:scale-[1.02] shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>S'inscrire
                        </button>
                        
                        <div class="text-center md:hidden mt-4">
                            <p class="text-sm text-gray-600">Déjà un compte ?</p>
                            <a href="{{ route('login') }}" class="text-orange-500 font-semibold hover:text-orange-600">
                                Connectez-vous ici <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection