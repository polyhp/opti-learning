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

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .logo-glow {
            transition: all 0.3s ease;
        }

        .logo-glow:hover {
            filter: drop-shadow(0 0 15px rgba(255, 107, 53, 0.5));
        }

        /* Effet de brillance sur le logo */
        .shimmer-effect {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gradient-to-br from-[#F8FAFE] to-[#F1F5F9]">
    <div class="min-h-screen flex flex-col">
        <!-- Header avec effet glassmorphisme amélioré -->
        <header class="bg-white/80 backdrop-blur-md shadow-lg border-b border-white/20 sticky top-0 z-50">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center items-center h-20">
                    <!-- Logo avec animation et effet de brillance -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3 group relative">
                            <!-- Cercle de glow au survol -->
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-[#FF6B35] to-[#FF8E5E] opacity-0 group-hover:opacity-20 blur-xl transition-all duration-500 rounded-full">
                            </div>

                            <div class="h-16 flex items-center justify-center transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 animate-float">
                                <img src="{{ asset('images/logo.jpg') }}" alt="OptiLearning" class="h-full w-auto object-contain drop-shadow-md rounded">
                            </div>
                        </a>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content avec effet de fondu -->
        <main class="flex-1 relative">
            <!-- Décoration de fond -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-[#FF6B35] to-[#FF8E5E] rounded-full opacity-5 blur-3xl animate-pulse">
                </div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-[#FF6B35] to-[#FF8E5E] rounded-full opacity-5 blur-3xl animate-pulse"
                    style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10">
                @yield('content')
            </div>
        </main>

        <!-- Footer avec effet moderne -->
        <footer class="relative mt-auto overflow-hidden">
            <!-- Dégradé de fond animé -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0A2647] via-[#0B2B4F] to-[#0A2647]"></div>

            <!-- Motif de points décoratif -->
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="white" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#dots)" />
                </svg>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <!-- Ligne décorative -->
                    <div class="w-24 h-px bg-gradient-to-r from-transparent via-[#FF6B35] to-transparent mx-auto mb-6">
                    </div>

                    <!-- Copyright avec effet hover -->
                    <p class="text-gray-400 text-sm font-medium tracking-wide group">
                        <i class="far fa-copyright mr-1 text-[#FF6B35] group-hover:text-white transition-colors"></i>
                        {{ date('Y') }} <span
                            class="text-white font-semibold group-hover:text-[#FF6B35] transition-colors">OPTI-LEARNING</span>
                        <span class="hidden sm:inline">• Tous droits réservés</span>
                        <span class="inline sm:hidden">• Tous droits réservés</span>
                    </p>

                    <!-- Petit texte de crédit (optionnel) -->
                    <p class="text-gray-500 text-xs mt-2 opacity-60 hover:opacity-100 transition-opacity">
                        <i class="fas fa-heart text-[#FF6B35] text-xs"></i> Plateforme d'excellence éducative
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Ajout d'un effet de parallaxe subtil au survol du logo (optionnel)
        document.querySelector('.group')?.addEventListener('mousemove', function (e) {
            const icon = this.querySelector('.w-11');
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            if (icon) {
                icon.style.transform = `perspective(500px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
            }
        });

        document.querySelector('.group')?.addEventListener('mouseleave', function () {
            const icon = this.querySelector('.w-11');
            if (icon) {
                icon.style.transform = 'perspective(500px) rotateX(0deg) rotateY(0deg) scale(1)';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>