<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OPTI-LEARNING')</title>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gradient-to-br from-navy-50 to-navy-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/95 backdrop-blur-sm shadow-sm border-b border-navy-100 sticky top-0 z-50">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                            <div
                                class="w-9 h-9 bg-gradient-to-r from-navy-600 to-navy-700 rounded-xl flex items-center justify-center shadow-md transform transition-transform group-hover:scale-105">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                            <span class="text-navy-800 font-bold text-xl">OPTI-LEARNING</span>
                        </a>
                    </div>

                    <!-- Navigation Links (Desktop) -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 font-medium">
                            Accueil
                        </a>
                        <a href="{{ url('/cours') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 font-medium">
                            Cours
                        </a>
                        <a href="{{ url('/formateurs') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 font-medium">
                            Formateurs
                        </a>
                        <a href="{{ url('/blog') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 font-medium">
                            Blog
                        </a>
                        <a href="{{ url('/contact') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 font-medium">
                            Contact
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button id="mobileMenuButton" class="text-navy-600 hover:text-navy-800 focus:outline-none">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div id="mobileMenu" class="hidden md:hidden pb-4">
                    <div class="flex flex-col space-y-3">
                        <a href="{{ url('/') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 px-2 py-1">
                            Accueil
                        </a>
                        <a href="{{ url('/cours') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 px-2 py-1">
                            Cours
                        </a>
                        <a href="{{ url('/formateurs') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 px-2 py-1">
                            Formateurs
                        </a>
                        <a href="{{ url('/blog') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 px-2 py-1">
                            Blog
                        </a>
                        <a href="{{ url('/contact') }}"
                            class="text-navy-600 hover:text-navy-800 transition-colors duration-300 px-2 py-1">
                            Contact
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-navy-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Logo et description -->
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="w-8 h-8 bg-navy-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-white text-sm"></i>
                            </div>
                            <span class="text-white font-bold text-lg">OPTI-LEARNING</span>
                        </div>
                        <p class="text-navy-300 text-sm leading-relaxed">
                            Plateforme d'apprentissage en ligne dédiée à l'excellence et à l'innovation en Afrique de
                            l'Ouest.
                        </p>
                        <div class="flex space-x-4 mt-6">
                            <a href="#" class="text-navy-400 hover:text-white transition-colors duration-300">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="text-navy-400 hover:text-white transition-colors duration-300">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="#" class="text-navy-400 hover:text-white transition-colors duration-300">
                                <i class="fab fa-linkedin-in text-lg"></i>
                            </a>
                            <a href="#" class="text-navy-400 hover:text-white transition-colors duration-300">
                                <i class="fab fa-youtube text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Liens rapides -->
                    <div>
                        <h3 class="text-white font-semibold mb-4">Liens rapides</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ url('/') }}"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Accueil</a>
                            </li>
                            <li><a href="{{ url('/cours') }}"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Tous
                                    les cours</a></li>
                            <li><a href="{{ url('/formateurs') }}"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Nos
                                    formateurs</a></li>
                            <li><a href="{{ url('/blog') }}"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Blog</a>
                            </li>
                            <li><a href="{{ url('/contact') }}"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h3 class="text-white font-semibold mb-4">Support</h3>
                        <ul class="space-y-2">
                            <li><a href="#"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">FAQ</a>
                            </li>
                            <li><a href="#"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Conditions
                                    générales</a></li>
                            <li><a href="#"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Politique
                                    de confidentialité</a></li>
                            <li><a href="#"
                                    class="text-navy-300 hover:text-white transition-colors duration-300 text-sm">Aide</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-white font-semibold mb-4">Contact</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center space-x-3 text-navy-300 text-sm">
                                <i class="fas fa-envelope w-4 text-navy-400"></i>
                                <span>contact@opti-learning.com</span>
                            </li>
                            <li class="flex items-center space-x-3 text-navy-300 text-sm">
                                <i class="fas fa-phone-alt w-4 text-navy-400"></i>
                                <span>+229 00 00 00 00</span>
                            </li>
                            <li class="flex items-center space-x-3 text-navy-300 text-sm">
                                <i class="fas fa-map-marker-alt w-4 text-navy-400"></i>
                                <span>Cotonou, Bénin</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-navy-700 mt-10 pt-8 text-center">
                    <p class="text-navy-400 text-sm">
                        &copy; {{ date('Y') }} OPTI-LEARNING. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobileMenuButton')?.addEventListener('click', function () {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>