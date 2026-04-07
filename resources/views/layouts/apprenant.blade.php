<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>@yield('title', 'Tableau de bord Apprenant - OptiLearning')</title>
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

<body class="text-slate-800 antialiased min-h-screen flex flex-col overflow-x-clip">

    <!-- Main Unified Navbar -->
    <x-navbar :showSidebarToggle="false" :showProfile="true" :searchAction="route('apprenant.catalog')" />

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
    <x-footer />

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
                    <p class="text-orange-500 font-semibold">Apprenant</p>
                </div>
            </div>
            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                <button onclick="confirmLogout()" class="flex-1 bg-red-100 text-red-600 hover:bg-red-200 py-2 rounded-xl font-medium transition-colors border border-red-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                </button>
                <button onclick="closeProfileModal()"
                    class="flex-1 bg-navy-900 hover:bg-navy-800 text-white py-2 rounded-xl transition-colors">
                    Fermer
                </button>
            </div>
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
            closeProfileModal();
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