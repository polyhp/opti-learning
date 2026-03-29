<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tableau de bord Apprenant - OptiLearning')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                            900: '#0B1A3E', // Bleu-nuit
                        },
                        orange: {
                            50: '#fff6ec',
                            100: '#ffead3',
                            500: '#F97316', // Orange OptiLearning
                            600: '#ea580c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-navy-900 border-b border-navy-800 sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <a href="{{ route('apprenant.dashboard') }}" class="text-2xl font-head font-bold text-white tracking-tight">
                        OPTI<span class="text-orange-500">LEARNING</span>
                    </a>
                </div>

                <!-- Center Menu -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('apprenant.dashboard') }}" class="text-white hover:text-orange-500 transition-colors border-b-2 border-transparent hover:border-orange-500 px-1 py-2 font-medium">Mon Apprentissage</a>
                    <a href="{{ route('apprenant.catalog') }}" class="text-navy-300 hover:text-white transition-colors border-b-2 border-transparent hover:border-navy-300 px-1 py-2 font-medium">Catalogue</a>
                </nav>

                <!-- Right Nav -->
                <div class="flex items-center space-x-6">
                    <!-- User Menu -->
                    <div class="flex items-center space-x-3 cursor-pointer" onclick="document.getElementById('profileModal').classList.remove('hidden')">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-semibold text-white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            <div class="text-xs text-orange-500 font-medium tracking-wider uppercase">Apprenant</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-navy-700 border-2 border-orange-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->first_name, 0, 1) }}{{ substr(Auth::user()->last_name, 0, 1) }}
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white/10 hover:bg-white/20 text-white p-2.5 rounded-xl transition-all duration-200" title="Me déconnecter">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col md:flex-row max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 gap-8">
        
        <!-- Alerts -->
        @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-emerald-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center animate-bounce" id="toast">
            <i class="fas fa-check-circle text-2xl mr-3"></i>
            <div>
                <h4 class="font-bold">Succès</h4>
                <p class="text-sm opacity-90">{{ session('success') }}</p>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center" id="toast-error">
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-navy-300 text-sm flex flex-col md:flex-row justify-between items-center gap-4">
            <div>&copy; {{ date('Y') }} OptiLearning. Espace Apprenant. Tous droits réservés.</div>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-white transition-colors">Support</a>
                <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
            </div>
        </div>
    </footer>

    <script>
        setTimeout(() => {
            let toast = document.getElementById('toast');
            if(toast) { toast.style.display = 'none'; }
            let toastErr = document.getElementById('toast-error');
            if(toastErr) { toastErr.style.display = 'none'; }
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
