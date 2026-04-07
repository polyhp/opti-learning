<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OPTI-LEARNING')</title>

    <!-- Tailwind CSS (via CDN temporarily for dev without npm run dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
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
        <!-- Maintient le header unifié -->
        <x-navbar />

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

        <!-- Footer avec le nouveau composant centralisé -->
        <x-footer />
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