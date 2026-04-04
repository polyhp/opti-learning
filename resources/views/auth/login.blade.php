@extends('layouts.auth')

@section('title', 'Connexion - OPTI-LEARNING')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,107,53,0.1)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-20"></div>
        </div>

        <div class="relative w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-8 text-center">
                    <div class="inline-flex items-center justify-center h-20 mb-4 p-2 bg-white rounded hover:scale-105 transition-transform duration-300">
                        <a href="{{ url('/') }}" class="h-full block">
                            <img src="{{ asset('images/logo.jpg') }}" alt="OptiLearning" class="h-full w-auto object-contain drop-shadow-md">
                        </a>
                    </div>
                    <p class="text-orange-100 mt-2">Connectez-vous à votre compte</p>
                </div>

                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded">
                            <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-orange-500 mr-2"></i>Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                placeholder="votre@email.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5 relative" x-data="{ show: false }">
                            <label class="block text-sm font-medium text-navy-800 mb-2">
                                <i class="fas fa-lock text-orange-500 mr-2"></i>Mot de passe
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-navy-900 @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-orange-500 transition focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 text-orange-500 rounded border-gray-300 focus:ring-orange-500">
                                <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-orange-500 hover:text-orange-600">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 rounded-lg hover:from-orange-600 hover:to-orange-700 transition transform hover:scale-[1.02] shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                        </button>
                    </form>


                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('register.apprenant') }}"
                                class="text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-user-graduate mr-2"></i>Apprenant
                            </a>
                            <a href="{{ route('register.formateur') }}"
                                class="text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>Formateur
                            </a>
                        </div>
                        <p class="text-center text-sm text-gray-600 mt-4">
                            Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-orange-500 font-semibold hover:text-orange-600">
                                Créez votre compte
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection