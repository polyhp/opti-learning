<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'Tableau de bord Formateur - OptiLearning')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
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
                        navy: {
                            50: '#f0f3f9',
                            100: '#dde5f1',
                            300: '#aabfdd',
                            500: '#6488c0',
                            700: '#2D4B8E',
                            800: '#1d3566',
                            900: '#0B1A3E',
                        },
                        orange: {
                            50: '#fff6ec',
                            100: '#ffead3',
                            500: '#F97316',
                            600: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animation pour le modal */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate(-50%, -40%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }

        /* Transition menu mobile - sans blocage du scroll */
        .mobile-menu-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Le menu mobile n'affecte pas le scroll */
        .mobile-menu-container {
            position: relative;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    @stack('styles')
</head>

<body class="text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-navy-900 border-b border-navy-800 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3 shrink-0">
                    <a href="{{ route('formateur.dashboard') }}">
                        <img src="{{ asset('images/logo.jpg') }}" alt="OptiLearning" class="h-16 w-auto rounded">
                    </a>
                </div>

                <!-- Mobile Search Bar (Header) -->
                <div class="md:hidden flex-1 mx-3">
                    <form action="{{ route('formateur.catalog') }}" method="GET" class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-navy-400 text-sm"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
                            class="block w-full pl-9 pr-3 py-2 bg-navy-800/80 border border-navy-700 rounded-full text-white placeholder-navy-300 focus:outline-none focus:bg-navy-700 focus:border-orange-500 text-xs sm:text-sm transition-all">
                    </form>
                </div>

                <!-- Center Menu - Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('formateur.dashboard') }}"
                        class="text-white hover:text-orange-500 transition-colors border-b-2 border-transparent hover:border-orange-500 px-1 py-2 font-medium">Tableau
                        de bord</a>
                    <a href="{{ route('formateur.catalog') }}"
                        class="text-navy-300 hover:text-white transition-colors border-b-2 border-transparent hover:border-navy-300 px-1 py-2 font-medium">Catalogue</a>
                </nav>

                <!-- Search Bar in Header - Desktop -->
                <div class="hidden lg:block flex-1 max-w-sm mx-6">
                    <form action="{{ route('formateur.catalog') }}" method="GET" class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-navy-300"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Rechercher par formations, mots..."
                            class="block w-full pl-11 pr-4 py-2 bg-navy-800/80 border border-navy-700 rounded-full shadow-inner text-white placeholder-navy-300 focus:outline-none focus:bg-white focus:text-navy-900 focus:placeholder-gray-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/50 sm:text-sm transition-all duration-300">
                    </form>
                </div>

                <!-- Right Nav - Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <!-- User Menu -->
                    <div class="flex items-center space-x-3 cursor-pointer" onclick="openProfileModal()">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-white">{{ Auth::user()->first_name }}
                                {{ Auth::user()->last_name }}
                            </div>
                            <div class="text-xs text-orange-500 font-medium tracking-wider uppercase">Formateur</div>
                        </div>
                        <div
                            class="w-10 h-10 rounded-full bg-navy-700 border-2 border-orange-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <button onclick="confirmLogout()"
                        class="bg-white/10 hover:bg-white/20 text-white p-2.5 rounded-xl transition-all duration-200"
                        title="Me déconnecter">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>

                <!-- Mobile Menu Button (Hamburger) -->
                <button id="mobileMenuBtn"
                    class="md:hidden text-white hover:text-orange-500 transition-colors p-2 focus:outline-none">
                    <i id="menuIcon" class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu Panel - Scrollable sans bloquer le body -->
            <div id="mobileMenu"
                class="hidden md:hidden bg-navy-800/95 backdrop-blur-sm rounded-2xl mt-2 mb-3 overflow-hidden border border-navy-700 shadow-xl mobile-menu-container">
                <div class="overflow-y-auto" style="max-height: calc(100vh - 100px);">
                    <!-- Mobile Navigation Links -->
                    <nav class="flex flex-col p-4 space-y-2">
                        <a href="{{ route('formateur.dashboard') }}"
                            class="text-white hover:bg-navy-700 px-4 py-3 rounded-xl transition-colors flex items-center space-x-3"
                            onclick="closeMobileMenu()">
                            <i class="fas fa-chalkboard-teacher w-5 text-orange-500"></i>
                            <span class="font-medium">Tableau de bord</span>
                        </a>
                        <a href="{{ route('formateur.catalog') }}"
                            class="text-navy-200 hover:text-white hover:bg-navy-700 px-4 py-3 rounded-xl transition-colors flex items-center space-x-3"
                            onclick="closeMobileMenu()">
                            <i class="fas fa-book-open w-5 text-orange-400"></i>
                            <span class="font-medium">Catalogue</span>
                        </a>
                    </nav>

                    <!-- User Info Mobile -->
                    <div class="border-t border-navy-700 p-4">
                        <div class="flex items-center space-x-3 mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-navy-600 border-2 border-orange-500 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-white">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}
                                </div>
                                <div class="text-xs text-orange-500 font-medium">Formateur</div>
                            </div>
                        </div>

                        <!-- Mobile Logout Button -->
                        <button onclick="confirmLogout(); closeMobileMenu();"
                            class="w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-xl px-4 py-3 transition-all duration-200 flex items-center justify-center space-x-2 border border-red-500/20">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="font-medium">Se déconnecter</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col md:flex-row max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 gap-8">

        <!-- Alerts -->
        @if(session('success'))
            <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center animate-bounce"
                id="toast">
                <i class="fas fa-check-circle text-2xl mr-3"></i>
                <div>
                    <h4 class="font-bold">Succès</h4>
                    <p class="text-sm opacity-90">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center"
                id="toast-error">
                <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                <div>
                    <h4 class="font-bold">Erreur</h4>
                    <p class="text-sm opacity-90">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="bg-navy-900 border-t border-navy-800 py-6 mt-auto">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-navy-300 text-sm flex flex-col md:flex-row justify-between items-center gap-4">
            <div>&copy; {{ date('Y') }} OptiLearning. Espace Formateur. Tous droits réservés.</div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white transition-colors">Support</a>
                <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
            </div>
        </div>
    </footer>

    <!-- Modal de confirmation de déconnexion professionnel -->
    <div id="logoutConfirmModal" class="fixed inset-0 z-[200] hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-navy-900/80 backdrop-blur-md" onclick="closeLogoutModal()"></div>

        <!-- Modal Panel -->
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in-up">
            <!-- Header avec icône -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-sign-out-alt text-white text-4xl"></i>
                </div>
                <h3 class="text-white text-xl font-head font-bold">Déconnexion</h3>
                <p class="text-white/80 text-sm mt-1">Êtes-vous sûr de vouloir quitter ?</p>
            </div>

            <!-- Body -->
            <div class="p-6 text-center">
                <p class="text-slate-600 text-sm mb-6">
                    Vous allez être déconnecté de votre session. Pour accéder à nouveau à votre espace, vous devrez vous
                    reconnecter.
                </p>

                <div class="flex gap-3">
                    <button onclick="closeLogoutModal()"
                        class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors border border-slate-200">
                        Annuler
                    </button>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-red-500/30">
                            Oui, me déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Profil -->
    <div id="profileModal" class="fixed inset-0 z-[150] hidden">
        <div class="absolute inset-0 bg-navy-900/60 backdrop-blur-sm" onclick="closeProfileModal()"></div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-head font-bold text-navy-900">Mon Profil</h3>
                <button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nom complet</label>
                    <p class="text-navy-900 font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <p class="text-navy-900 font-semibold">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Rôle</label>
                    <p class="text-orange-500 font-semibold">Formateur</p>
                </div>
            </div>
            <button onclick="closeProfileModal()"
                class="w-full mt-6 bg-navy-900 hover:bg-navy-800 text-white py-2 rounded-xl transition-colors">
                Fermer
            </button>
        </div>
    </div>

    <script>
        // Gestion des toasts
        setTimeout(() => {
            let toast = document.getElementById('toast');
            if (toast) { toast.style.display = 'none'; }
            let toastErr = document.getElementById('toast-error');
            if (toastErr) { toastErr.style.display = 'none'; }
        }, 5000);

        // Menu mobile toggle - SANS bloquer le scroll
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');

        function closeMobileMenu() {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                if (menuIcon) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            }
        }

        function openMobileMenu() {
            if (mobileMenu && mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                if (menuIcon) {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            }
        }

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    openMobileMenu();
                } else {
                    closeMobileMenu();
                }
            });
        }

        // Fermer le menu mobile en cliquant à l'extérieur
        document.addEventListener('click', function (event) {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                const isClickInside = mobileMenu.contains(event.target) || mobileMenuBtn.contains(event.target);
                if (!isClickInside) {
                    closeMobileMenu();
                }
            }
        });

        // Fermer le menu lors du redimensionnement en mode desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && mobileMenu && !mobileMenu.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });

        // Fonction de confirmation de déconnexion professionnelle
        function confirmLogout() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Fonctions pour le modal profil
        function openProfileModal() {
            const modal = document.getElementById('profileModal');
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeProfileModal() {
            const modal = document.getElementById('profileModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Fermer les modals avec la touche Echap
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const logoutModal = document.getElementById('logoutConfirmModal');
                if (logoutModal && !logoutModal.classList.contains('hidden')) {
                    closeLogoutModal();
                }
                const profileModal = document.getElementById('profileModal');
                if (profileModal && !profileModal.classList.contains('hidden')) {
                    closeProfileModal();
                }
                // Fermer aussi le menu mobile si ouvert
                if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                    closeMobileMenu();
                }
            }
        });

        // Fermer le modal de déconnexion en cliquant sur l'overlay
        const logoutModalElem = document.getElementById('logoutConfirmModal');
        if (logoutModalElem) {
            logoutModalElem.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeLogoutModal();
                }
            });
        }

        // Fermer le modal profil en cliquant sur l'overlay
        const profileModalElem = document.getElementById('profileModal');
        if (profileModalElem) {
            profileModalElem.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeProfileModal();
                }
            });
        }

        // Empêcher la propagation des clics à l'intérieur du menu mobile pour ne pas le fermer
        if (mobileMenu) {
            mobileMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        }
    </script>
    @stack('scripts')
</body>

</html>