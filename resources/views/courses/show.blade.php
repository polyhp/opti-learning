<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>{{ $course->title }} - OptiLearning</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        head: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        navy: { 50: '#e8edf5', 100: '#d1dceb', 200: '#a3b9d7', 300: '#7596c3', 400: '#4773af', 500: '#2D4B8E', 600: '#243c72', 700: '#1b2d55', 800: '#121e39', 900: '#0B1A3E' },
                        orange: { 50: '#fff6ec', 100: '#ffecd9', 200: '#ffd9b3', 300: '#ffc68d', 400: '#ffb366', 500: '#F97316', 600: '#ea580c', 700: '#c2410c', 800: '#9a3412', 900: '#7c2d12' }
                    }
                }
            }
        }
    </script>
    <style>
        /* Styles personnalisés pour le responsive */
        @media (max-width: 640px) {
            .container-padding {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .mobile-stack {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-mobile-full {
                width: 100%;
                text-align: center;
            }
        }

        /* Animation douce pour les cartes */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.25);
        }

        /* Scroll fluide */
        html {
            scroll-behavior: smooth;
        }

        /* Amélioration du contenu texte */
        .prose-custom {
            line-height: 1.7;
        }

        .prose-custom p {
            margin-bottom: 1rem;
        }

        /* Styles de bordure personnalisés */
        .border-navy {
            border-color: #1b2d55;
        }

        .border-navy-light {
            border-color: #2D4B8E;
        }

        .bg-gradient-custom {
            background: linear-gradient(135deg, #0B1A3E 0%, #121e39 100%);
        }

        .card-bg {
            background: linear-gradient(135deg, #121e39 0%, #1b2d55 100%);
        }

        .section-bg {
            background: linear-gradient(135deg, #1b2d55 0%, #243c72 100%);
        }

        /* Modal de confirmation personnalisé */
        .modal-confirm {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .modal-confirm.active {
            display: flex;
        }

        .modal-content {
            background: linear-gradient(135deg, #121e39 0%, #1b2d55 100%);
            border: 2px solid #2D4B8E;
            border-radius: 1.5rem;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-btn {
            flex: 1;
            padding: 0.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, #F97316, #ea580c);
            color: white;
            border: none;
        }

        .modal-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
        }

        .modal-btn-cancel {
            background: #1b2d55;
            color: #cbd5e1;
            border: 1px solid #2D4B8E;
        }

        .modal-btn-cancel:hover {
            background: #243c72;
            color: white;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 font-sans text-slate-200 antialiased flex flex-col min-h-screen">

    <!-- Header Responsive -->
    <header class="bg-navy-900/95 backdrop-blur-sm sticky top-0 z-50 shadow-2xl border-b-2 border-navy-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-3 py-3 sm:py-0 sm:h-20">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 flex-shrink-0">
                    <div
                        class="w-16 h-16 rounded-xl flex items-center justify-center overflow-hidden bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg shadow-orange-500/30">
                        @php
                            $logoPath = asset('images/logo.jpg');
                            $hasCustomLogo = file_exists(public_path('images/logo.jpg'));
                        @endphp
                        @if($hasCustomLogo)
                            <img src="{{ $logoPath }}" alt="OptiLearning" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        @endif
                    </div>
                    <span class="text-xl sm:text-2xl font-head font-bold text-white">
                        OPTI<span class="text-orange-500">LEARNING</span>
                    </span>
                </a>

                <!-- Boutons d'authentification - Version Desktop -->
                <div class="hidden sm:flex items-center space-x-3 md:space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="text-slate-300 hover:text-orange-400 font-medium transition-colors text-sm md:text-base px-3 py-2 rounded-lg hover:bg-navy-800 border border-transparent hover:border-navy-600">
                            Mon Espace
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="logout-form-desktop">
                            @csrf
                            <button type="button" onclick="confirmLogout(this)"
                                class="text-slate-400 hover:text-white transition-colors px-3 py-2 rounded-lg hover:bg-navy-800 border border-transparent hover:border-navy-600"
                                title="Déconnexion">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-slate-300 hover:text-orange-400 font-medium transition-colors text-sm md:text-base px-3 py-2 rounded-lg hover:bg-navy-800 border border-transparent hover:border-navy-600">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 px-4 py-2 md:px-5 md:py-2 rounded-full text-white font-medium transition-all shadow-lg shadow-orange-500/30 text-sm md:text-base">
                            Inscription
                        </a>
                    @endauth
                </div>

                <!-- Menu Mobile - Bouton hamburger -->
                <button id="mobileMenuBtn"
                    class="sm:hidden text-white hover:text-orange-500 transition-colors p-2 focus:outline-none rounded-lg hover:bg-navy-800 border border-navy-700">
                    <i id="menuIcon" class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Menu Mobile Déroulant -->
            <div id="mobileMenu" class="sm:hidden hidden flex-col pb-4 space-y-2 border-t-2 border-navy-700 mt-2 pt-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-slate-300 hover:bg-navy-800 px-4 py-2 rounded-lg transition-colors border border-navy-700 hover:border-orange-500">
                        <i class="fas fa-tachometer-alt mr-3 w-5"></i> Mon Espace
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <button type="button" onclick="confirmLogout(this)"
                            class="w-full text-left text-slate-300 hover:bg-navy-800 px-4 py-2 rounded-lg transition-colors border border-navy-700 hover:border-orange-500">
                            <i class="fas fa-sign-out-alt mr-3 w-5"></i> Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-slate-300 hover:bg-navy-800 px-4 py-2 rounded-lg transition-colors border border-navy-700 hover:border-orange-500">
                        <i class="fas fa-sign-in-alt mr-3 w-5"></i> Connexion
                    </a>
                    <a href="{{ route('register') }}"
                        class="text-slate-300 hover:bg-navy-800 px-4 py-2 rounded-lg transition-colors border border-navy-700 hover:border-orange-500">
                        <i class="fas fa-user-plus mr-3 w-5"></i> Inscription
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Modal de confirmation de déconnexion -->
    <div id="logoutModal" class="modal-confirm">
        <div class="modal-content">
            <div class="text-center">
                <div
                    class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-orange-500/50">
                    <i class="fas fa-sign-out-alt text-2xl text-orange-500"></i>
                </div>
                <h3 class="text-xl font-head font-bold text-white mb-2">Déconnexion</h3>
                <p class="text-slate-300 text-sm">Êtes-vous sûr de vouloir vous déconnecter ?</p>
                <p class="text-slate-400 text-xs mt-2">Vous devrez vous reconnecter pour accéder à votre compte.</p>
            </div>
            <div class="modal-buttons">
                <button onclick="cancelLogout()" class="modal-btn modal-btn-cancel">
                    <i class="fas fa-times mr-2"></i> Annuler
                </button>
                <button onclick="proceedLogout()" class="modal-btn modal-btn-confirm">
                    <i class="fas fa-check mr-2"></i> Déconnexion
                </button>
            </div>
        </div>
    </div>

    <!-- Héros de la formation -->
    <section
        class="bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 text-white py-12 sm:py-16 lg:py-24 border-b-2 border-navy-700 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800 to-transparent z-10"></div>
        @if($course->thumbnail)
            <img src="{{ asset($course->thumbnail) }}"
                class="absolute inset-0 w-full h-full object-cover opacity-10 blur-sm mix-blend-overlay">
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
            <div class="max-w-3xl">
                <div
                    class="flex flex-wrap items-center gap-2 text-orange-400 text-xs sm:text-sm font-bold uppercase tracking-wider mb-4 sm:mb-6">
                    <span
                        class="bg-navy-800/80 px-3 py-1 rounded-full border border-orange-500/30">{{ $course->category->name ?? 'Général' }}</span>
                    <span>•</span>
                    <span class="flex items-center text-yellow-500"><i class="fas fa-star mr-1 text-xs"></i> 4.8
                        (Nouveau)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-5xl font-head font-bold leading-tight mb-4 sm:mb-6">
                    {{ $course->title }}
                </h1>
                <p class="text-sm sm:text-base lg:text-lg text-slate-300 mb-6 sm:mb-8 max-w-2xl leading-relaxed">
                    {{ Str::limit($course->description, 120) }}
                </p>

                <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs sm:text-sm text-slate-300">
                    <span class="flex items-center bg-navy-800/60 px-3 py-1.5 rounded-lg border border-navy-600">
                        <i class="fas fa-user-tie mr-2 text-orange-400 text-xs"></i>
                        <span class="hidden xs:inline">Créé par</span>
                        <span class="text-white font-medium ml-1">{{ $course->formateur->user->first_name }}
                            {{ $course->formateur->user->last_name }}</span>
                    </span>
                    <span class="flex items-center bg-navy-800/60 px-3 py-1.5 rounded-lg border border-navy-600">
                        <i class="fas fa-video mr-2 text-orange-400 text-xs"></i>
                        {{ $course->lessons->count() }} leçons
                    </span>
                    <span class="flex items-center bg-navy-800/60 px-3 py-1.5 rounded-lg border border-navy-600">
                        <i class="fas fa-clock mr-2 text-orange-400 text-xs"></i>
                        {{ $course->duration_minutes }} min
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu Principal & Carte de Paiement -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 flex-grow">
        <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 relative">

            <!-- Left Column: Infos -->
            <div class="flex-grow lg:max-w-4xl space-y-8 sm:space-y-12 order-2 lg:order-1">
                <!-- Description -->
                <div class="card-bg rounded-2xl border-2 border-navy-600 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 bg-navy-800/50 border-b-2 border-navy-600">
                        <h2 class="text-xl sm:text-2xl font-head font-bold text-orange-400">
                            Description de la formation
                        </h2>
                    </div>
                    <div class="p-6">
                        <div
                            class="prose-custom text-sm sm:text-base text-slate-300 leading-relaxed whitespace-pre-line">
                            {{ $course->description }}
                        </div>
                    </div>
                </div>

                <!-- Programme (Lessons) -->
                <div class="card-bg rounded-2xl border-2 border-navy-600 shadow-xl overflow-hidden">
                    <div class="px-6 py-4 bg-navy-800/50 border-b-2 border-navy-600">
                        <h2 class="text-xl sm:text-2xl font-head font-bold text-orange-400">
                            Contenu du cours
                        </h2>
                    </div>

                    <div class="divide-y divide-navy-700">
                        <div
                            class="bg-navy-800/30 px-6 py-3 border-b border-navy-600 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                            <span class="text-sm font-semibold text-slate-300">Matière couverte</span>
                            <span
                                class="text-xs bg-navy-800 border border-navy-600 px-2 py-1 rounded-full text-slate-400">
                                {{ $course->lessons->count() }} leçons
                            </span>
                        </div>

                        @foreach($course->lessons as $index => $lesson)
                            <div
                                class="px-6 py-4 hover:bg-navy-800/50 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-3 group border-b border-navy-700 last:border-b-0">
                                <div class="flex items-center flex-1 min-w-0">
                                    @if($lesson->type == 'video')
                                        <i
                                            class="fas fa-play-circle text-navy-500 group-hover:text-orange-500 mr-4 text-xl flex-shrink-0 transition-colors"></i>
                                    @else
                                        <i
                                            class="fas fa-file-alt text-navy-500 group-hover:text-orange-500 mr-4 text-xl flex-shrink-0 transition-colors"></i>
                                    @endif
                                    <span
                                        class="text-slate-300 font-medium text-sm sm:text-base break-words group-hover:text-white transition-colors">
                                        {{ $index + 1 }}. {{ $lesson->title }}
                                    </span>
                                </div>
                                @if($hasPaid)
                                    <span
                                        class="text-xs font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 rounded-full self-start sm:self-center">
                                        <i class="fas fa-unlock-alt mr-1"></i> Accessible
                                    </span>
                                @else
                                    <span
                                        class="text-xs font-medium text-slate-500 bg-navy-800 border border-navy-600 px-3 py-1 rounded-full self-start sm:self-center">
                                        <i class="fas fa-lock mr-1"></i> Verrouillé
                                    </span>
                                @endif
                            </div>
                        @endforeach

                        @if($course->quizzes->count() > 0)
                            <div
                                class="px-6 py-4 bg-navy-800/30 border-t-2 border-navy-600 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                                <div class="flex items-center">
                                    <i class="fas fa-question-circle text-orange-500 mr-4 text-xl"></i>
                                    <span class="text-white font-bold text-sm sm:text-base">Évaluation Finale (Quiz)</span>
                                </div>
                                @if($hasPaid)
                                    <span
                                        class="text-xs font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 rounded-full">
                                        <i class="fas fa-unlock-alt mr-1"></i> Accessible
                                    </span>
                                @else
                                    <span
                                        class="text-xs font-medium text-slate-500 bg-navy-800 border border-navy-600 px-3 py-1 rounded-full">
                                        <i class="fas fa-lock mr-1"></i> Verrouillé
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Card Achat -->
            <div class="lg:w-[380px] flex-shrink-0 order-1 lg:order-2">
                <div
                    class="card-bg rounded-2xl border-2 border-navy-600 shadow-2xl overflow-hidden sticky top-24 lg:top-28 transition-all hover:border-orange-500/50">
                    <!-- Miniature -->
                    <div class="h-48 sm:h-56 bg-navy-800 relative border-b-2 border-navy-600">
                        @if($course->thumbnail)
                            <img src="{{ asset($course->thumbnail) }}" class="w-full h-full object-cover opacity-80">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-navy-800 to-navy-900">
                                <i class="fas fa-video text-4xl text-navy-600"></i>
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-t-2xl opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                            <div
                                class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full flex items-center justify-center text-white text-xl sm:text-2xl shadow-xl">
                                <i class="fas fa-play ml-0.5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 lg:p-8">
                        @if($course->price == 0)
                            <div class="text-3xl sm:text-4xl font-head font-bold text-orange-400 mb-4 sm:mb-6">Gratuit</div>
                        @else
                            <div class="text-3xl sm:text-4xl font-head font-bold text-orange-400 mb-4 sm:mb-6">
                                {{ number_format($course->price, 0, ',', ' ') }} <span
                                    class="text-base sm:text-xl text-slate-400">FCFA</span>
                            </div>
                        @endif

                        @if($hasPaid)
                            <a href="{{ route('apprenant.courses.watch', $course->id) }}"
                                class="block w-full text-center bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold py-3 sm:py-4 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 text-base sm:text-lg mb-3 sm:mb-4">
                                <i class="fas fa-play-circle mr-2"></i> Accéder à la formation
                            </a>
                            <p class="text-center text-xs sm:text-sm text-emerald-400 font-medium">
                                <i class="fas fa-check-circle"></i> Vous possédez cette formation
                            </p>
                        @else
                            @auth
                                <form action="{{ route('apprenant.checkout') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 sm:py-4 rounded-xl shadow-xl shadow-orange-500/30 transition-all transform hover:-translate-y-0.5 text-base sm:text-lg mb-3 sm:mb-4">
                                        @if($course->price > 0)
                                            <i class="fas fa-shopping-cart mr-2"></i> Payer
                                            {{ number_format($course->price, 0, ',', ' ') }} FCFA
                                        @else
                                            <i class="fas fa-graduation-cap mr-2"></i> S'inscrire gratuitement
                                        @endif
                                    </button>
                                </form>
                                <p class="text-center text-xs text-slate-400 mb-4 sm:mb-6">Paiement sécurisé par Mobile Money /
                                    Carte</p>
                            @else
                                <a href="{{ route('login') }}"
                                    class="block w-full text-center bg-navy-800 hover:bg-navy-700 text-white font-bold py-3 sm:py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 text-base sm:text-lg mb-3 sm:mb-4 border border-navy-600">
                                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter pour acheter
                                </a>
                                <p class="text-center text-xs text-slate-400 mb-4 sm:mb-6">Vous devez avoir un compte pour
                                    acheter cette formation.</p>
                            @endauth
                        @endif

                        <div class="space-y-2 sm:space-y-3 pt-4 sm:pt-6 border-t-2 border-navy-600">
                            <h4 class="font-bold text-orange-400 mb-3 sm:mb-4 text-sm sm:text-base">Cette formation
                                inclut :</h4>
                            <div class="flex items-center p-2 rounded-lg hover:bg-navy-800 transition-colors">
                                <i class="fas fa-video w-5 sm:w-6 text-center text-orange-500 text-xs sm:text-sm"></i>
                                <span class="ml-3 text-slate-300">Accès illimité aux vidéos</span>
                            </div>
                            <div class="flex items-center p-2 rounded-lg hover:bg-navy-800 transition-colors">
                                <i
                                    class="fas fa-mobile-alt w-5 sm:w-6 text-center text-orange-500 text-xs sm:text-sm"></i>
                                <span class="ml-3 text-slate-300">Accessible sur mobile et PC</span>
                            </div>
                            <div class="flex items-center p-2 rounded-lg hover:bg-navy-800 transition-colors">
                                <i
                                    class="fas fa-certificate w-5 sm:w-6 text-center text-orange-500 text-xs sm:text-sm"></i>
                                <span class="ml-3 text-slate-300">Certificat de fin de formation (si Quiz réussi)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-navy-900 border-t-2 border-navy-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-400 text-xs sm:text-sm">
            &copy; {{ date('Y') }} OptiLearning. Apprentissage Sécurisé. Tous droits réservés.
        </div>
    </footer>

    <script>
        // Variables pour la gestion de la déconnexion
        let activeLogoutButton = null;

        // Fonction pour afficher la modale de confirmation
        function confirmLogout(button) {
            activeLogoutButton = button;
            const modal = document.getElementById('logoutModal');
            modal.classList.add('active');
            // Empêcher le scroll du body
            document.body.style.overflow = 'hidden';
        }

        // Fonction pour annuler la déconnexion
        function cancelLogout() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('active');
            activeLogoutButton = null;
            // Réactiver le scroll du body
            document.body.style.overflow = '';
        }

        // Fonction pour procéder à la déconnexion
        function proceedLogout() {
            if (activeLogoutButton) {
                // Trouver le formulaire parent
                const form = activeLogoutButton.closest('form');
                if (form) {
                    // Ajouter un indicateur de chargement
                    const originalText = activeLogoutButton.innerHTML;
                    activeLogoutButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Déconnexion...';
                    activeLogoutButton.disabled = true;

                    // Soumettre le formulaire
                    form.submit();
                } else {
                    // Fallback: recharger la page avec le token CSRF
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (token) {
                        fetch('{{ route('logout') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            },
                            credentials: 'same-origin'
                        }).then(() => {
                            window.location.href = '{{ route('login') }}';
                        }).catch(() => {
                            window.location.reload();
                        });
                    } else {
                        window.location.reload();
                    }
                }
            }
        }

        // Fermer la modale avec la touche Echap
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('logoutModal');
                if (modal.classList.contains('active')) {
                    cancelLogout();
                }
            }
        });

        // Fermer la modale en cliquant sur l'overlay
        document.getElementById('logoutModal').addEventListener('click', function (event) {
            if (event.target === this) {
                cancelLogout();
            }
        });

        // Menu mobile toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                } else {
                    mobileMenu.classList.add('hidden');
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            });
        }

        // Fermer le menu lors du redimensionnement en mode desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640 && mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                if (menuIcon) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            }
        });
    </script>
</body>

</html>