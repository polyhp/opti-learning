{{-- resources/views/auth/choose-role.blade.php --}}
@extends('layouts.auth')

@section('title', 'Choisissez votre profil - OPTI-LEARNING')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background animé -->
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 overflow-hidden">
            <!-- Particules animées -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 20; $i++)
                    <div class="absolute rounded-full bg-orange-500/10 animate-float"
                        style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; width: {{ rand(50, 200) }}px; height: {{ rand(50, 200) }}px; animation-delay: {{ rand(0, 10) }}s; animation-duration: {{ rand(10, 20) }}s;">
                    </div>
                @endfor
            </div>

            <!-- Effet de grille -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,107,53,0.05)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-30"></div>
        </div>

        <div class="relative w-full max-w-6xl">
            <!-- Header avec animation -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div class="inline-flex justify-center mb-6 transform rotate-3 hover:rotate-6 transition duration-300">
                    <x-logo />
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 text-shadow">
                    Bienvenue sur <span class="text-orange-500">OPTI-LEARNING</span>
                </h1>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                    Choisissez votre parcours et commencez votre aventure d'apprentissage
                </p>
            </div>

            <!-- Cartes de choix -->
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Carte Apprenant -->
                <div class="group cursor-pointer transform transition-all duration-500 hover:scale-105"
                    onclick="selectRole('apprenant')">
                    <div
                        class="relative bg-white/10 backdrop-blur-xl rounded-2xl overflow-hidden shadow-2xl hover:shadow-orange-500/20 transition-all duration-300 border border-white/20 hover:border-orange-500/50">
                        <!-- Badge populaire -->
                        <div
                            class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold z-10">
                            <i class="fas fa-fire mr-1"></i> Populaire
                        </div>

                        <!-- En-tête avec icône -->
                        <div
                            class="relative h-48 bg-gradient-to-br from-blue-600/20 to-purple-600/20 flex items-center justify-center">
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-6">
                                <i class="fas fa-user-graduate text-6xl text-white"></i>
                            </div>
                            <!-- Effet de vague -->
                            <div class="absolute bottom-0 left-0 right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                                    <path fill="rgba(255,107,53,0.1)" fill-opacity="1"
                                        d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,170.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-8 text-center">
                            <h2 class="text-3xl font-bold text-white mb-3">Je suis Apprenant</h2>
                            <p class="text-gray-300 mb-6">Je souhaite apprendre et développer mes compétences</p>

                            <!-- Avantages -->
                            <div class="space-y-3 text-left mb-8">
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Accès à +500 formations</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Certificats reconnus</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Suivi personnalisé</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Communauté d'apprenants</span>
                                </div>
                            </div>

                            <!-- Bouton -->
                            <button
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform group-hover:scale-105 shadow-lg">
                                <i class="fas fa-arrow-right mr-2"></i>
                                S'inscrire comme Apprenant
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Carte Formateur -->
                <div class="group cursor-pointer transform transition-all duration-500 hover:scale-105"
                    onclick="selectRole('formateur')">
                    <div
                        class="relative bg-white/10 backdrop-blur-xl rounded-2xl overflow-hidden shadow-2xl hover:shadow-orange-500/20 transition-all duration-300 border border-white/20 hover:border-orange-500/50">
                        <!-- Badge expert -->
                        <div
                            class="absolute top-4 right-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-1 rounded-full text-xs font-semibold z-10">
                            <i class="fas fa-star mr-1"></i> Expert
                        </div>

                        <!-- En-tête avec icône -->
                        <div
                            class="relative h-48 bg-gradient-to-br from-orange-600/20 to-red-600/20 flex items-center justify-center">
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center transform transition-all duration-500 group-hover:scale-110 group-hover:-rotate-6">
                                <i class="fas fa-chalkboard-teacher text-6xl text-white"></i>
                            </div>
                            <!-- Effet de vague -->
                            <div class="absolute bottom-0 left-0 right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
                                    <path fill="rgba(255,107,53,0.1)" fill-opacity="1"
                                        d="M0,224L48,208C96,192,192,160,288,165.3C384,171,480,213,576,213.3C672,213,768,171,864,154.7C960,139,1056,149,1152,170.7C1248,192,1344,224,1392,240L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <!-- Contenu -->
                        <div class="p-8 text-center">
                            <h2 class="text-3xl font-bold text-white mb-3">Je suis Formateur</h2>
                            <p class="text-gray-300 mb-6">Je souhaite partager mon expertise et former des apprenants</p>

                            <!-- Avantages -->
                            <div class="space-y-3 text-left mb-8">
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Créez vos formations</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Gagnez de l'argent</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Outils de création avancés</span>
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <i class="fas fa-check-circle text-orange-500 mr-3 text-lg"></i>
                                    <span>Accompagnement dédié</span>
                                </div>
                            </div>

                            <!-- Bouton -->
                            <button
                                class="w-full bg-white/20 backdrop-blur border border-orange-500 text-white font-semibold py-3 rounded-xl hover:bg-orange-500/20 transition-all duration-300 transform group-hover:scale-105">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>
                                Devenir Formateur
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer avec lien retour - CORRIGÉ -->
            <div class="text-center mt-12">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-gray-400 hover:text-white transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la connexion
                </a>
            </div>
        </div>
    </div>

    <!-- Script de redirection - CORRIGÉ -->
    <script>
        function selectRole(role) {
            // Animation de transition
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.style.opacity = '0.5';
                card.style.transform = 'scale(0.95)';
            });

            // Afficher un loader
            const loader = document.createElement('div');
            loader.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50';
            loader.innerHTML = `
                <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500 mb-4"></div>
                    <p class="text-white text-lg">Redirection en cours...</p>
                </div>
            `;
            document.body.appendChild(loader);

            // Redirection après un court délai pour l'animation
            setTimeout(() => {
                if (role === 'apprenant') {
                    window.location.href = "{{ route('register.apprenant') }}";
                } else {
                    window.location.href = "{{ route('register.formateur') }}";
                }
            }, 500);
        }

        // Animation d'entrée des cartes
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.group');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Ajouter des effets de survol au clavier
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const role = card.querySelector('h2').textContent.includes('Apprenant') ? 'apprenant' : 'formateur';
                    selectRole(role);
                }
            });
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            card.setAttribute('aria-label', card.querySelector('h2').textContent);
        });
    </script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        .animate-float {
            animation: float infinite ease-in-out;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection