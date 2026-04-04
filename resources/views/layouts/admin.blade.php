<!DOCTYPE html>
<html lang="fr" class="antialiased">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Administration - OPTI-LEARNING</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:300,400,500,600,700,800&display=swap"
        rel="stylesheet" />

    <!-- AlpineJS & Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #0F172A;
            background: linear-gradient(135deg, #0B1A3E 0%, #0d1f4a 50%, #0B1A3E 100%);
            background-attachment: fixed;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }

        /* Sidebar scroll */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #1d3566;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #F97316;
            border-radius: 10px;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #F97316 #1d3566;
        }

        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUpModal {
            from {
                opacity: 0;
                transform: translate(-50%, -40%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .animate-slide-in {
            animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fade-in-up {
            animation: fadeInUpModal 0.3s ease-out forwards;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #F97316 0%, #ea580c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.3);
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #ea580c 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.4);
        }

        /* Glass morphism */
        .glass {
            background: rgba(11, 26, 62, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(249, 115, 22, 0.2);
        }

        /* Active nav indicator */
        .nav-active {
            background: linear-gradient(135deg, rgba(249, 115, 22, 0.15) 0%, rgba(249, 115, 22, 0.05) 100%);
            border-left: 3px solid #F97316;
        }

        /* Dropdown animation */
        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-open {
            animation: dropdownFade 0.2s ease-out forwards;
        }
    </style>
</head>

<body class="text-gray-800 flex min-h-screen overflow-hidden selection:bg-[#F97316] selection:text-white"
    x-data="{ sidebarOpen: window.innerWidth >= 1024, adminMenuOpen: false }">

    <!-- OVERLAY MOBILE -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-[#0B1A3E]/80 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false" x-cloak></div>

    <!-- SIDEBAR - Bleu nuit profond -->
    <aside
        class="fixed inset-y-0 left-0 z-50 w-80 bg-gradient-to-b from-[#0B1A3E] to-[#1d3566] flex flex-col transition-transform duration-300 transform lg:relative lg:translate-x-0 shadow-2xl"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" x-cloak>

        <!-- Header Logo Sidebar -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 shrink-0 bg-[#0B1A3E]">
            <a href="#" class="flex items-center group relative">
                <div
                    class="absolute -inset-4 bg-[#F97316] opacity-0 group-hover:opacity-10 blur-xl transition-all duration-500 rounded-full">
                </div>
                <div class="mr-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                        class="h-16 w-auto object-contain drop-shadow-md rounded">
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">OPTI-<span
                            class="text-[#F97316]">LEARNING</span></span>
                    <p class="text-[10px] text-gray-400 tracking-wider mt-0.5">ADMINISTRATION</p>
                </div>
            </a>

            <button @click="sidebarOpen = false"
                class="lg:hidden text-gray-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation Section -->
        <div class="flex-1 overflow-y-auto sidebar-scroll py-8 px-4 space-y-8">

            <!-- Menu Principal -->
            <div>
                <p class="px-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-[#F97316] mr-2"></span>
                    MENU PRINCIPAL
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-[#F97316]' : 'text-gray-500 group-hover:text-[#F97316]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Tableau de bord
                    </a>

                    @can('manage-users')
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-[#F97316]' : 'text-gray-500 group-hover:text-[#F97316]' }} transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Utilisateurs
                        </a>
                    @endcan

                    @can('manage-courses')
                        <a href="{{ route('admin.courses.index') }}"
                            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.courses.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.courses.*') ? 'text-[#F97316]' : 'text-gray-500 group-hover:text-[#F97316]' }} transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            Formations
                        </a>
                    @endcan

                    @can('manage-payments')
                        <a href="{{ route('admin.payments.index') }}"
                            class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.payments.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payments.*') ? 'text-[#F97316]' : 'text-gray-500 group-hover:text-[#F97316]' }} transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                            Paiements
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- User Profile Section -->
        <div class="p-3 border-t border-white/10 bg-[#0B1A3E] shrink-0">
            <div class="flex items-center p-2.5 rounded-2xl bg-white/5 backdrop-blur-sm">
                <img src="{{ auth()->user()->avatar_url }}" alt="Profile"
                    class="w-12 h-12 rounded-full border border-gray-600 object-cover shrink-0">
                <div class="ml-3 flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-[11px] text-gray-400 font-medium mt-0.5 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <!-- Bouton Déconnexion Sidebar avec confirmation -->
            <button onclick="confirmLogout()"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500/10 hover:bg-red-500 border border-red-500/20 text-red-400 hover:text-white text-sm font-semibold rounded-xl transition-all duration-300 group mt-3">
                <svg class="w-4 h-4 transform rotate-180 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                Se déconnecter
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Header Glass - Barre de recherche toujours visible -->
        <header
            class="glass h-auto lg:h-20 flex flex-col lg:flex-row items-center justify-between px-3 sm:px-4 lg:px-8 py-2 lg:py-0 z-30 shrink-0 shadow-lg">

            <!-- Ligne supérieure mobile : menu + titre + icône admin -->
            <div class="flex items-center justify-between w-full lg:hidden mb-2">
                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-white hover:text-[#F97316] focus:outline-none p-2 rounded-xl hover:bg-white/10 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <div class="h-6 w-px bg-gray-600"></div>
                    <h1 class="text-sm font-bold text-white">
                        @yield('header_title', 'Espace Admin')</h1>
                </div>

                <!-- Menu Admin Dropdown Mobile -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="relative p-2 text-white hover:text-[#F97316] transition-all rounded-xl hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu Mobile -->
                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-56 bg-[#1d3566] rounded-xl shadow-2xl border border-[#F97316]/30 overflow-hidden dropdown-open z-50"
                        style="display: none;">
                        <div class="py-2">
                            @if(auth()->user()->is_super_admin)
                                <a href="{{ route('admin.create') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                    <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    <span>Nouvel Admin</span>
                                </a>
                                <a href="{{ route('admin.logs.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                    <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span>Journal d'activités</span>
                                </a>
                            @endif
                            <a href="{{ route('admin.profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                </svg>
                                <span>Paramètres</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barre de recherche - Réduite sur mobile -->
            <div class="w-full lg:w-auto">
                @php
                    $searchAction = route('home');
                    $searchPlaceholder = 'Rechercher des formations...';

                    if (request()->routeIs('admin.users.*')) {
                        $searchAction = route('admin.users.index');
                        $searchPlaceholder = 'Rechercher un utilisateur...';
                    } elseif (request()->routeIs('admin.payments.*')) {
                        $searchAction = route('admin.payments.index');
                        $searchPlaceholder = 'Rechercher un paiement...';
                    } elseif (request()->routeIs('admin.courses.*')) {
                        $searchAction = route('admin.courses.index');
                        $searchPlaceholder = 'Rechercher une formation...';
                    }
                @endphp
                <form action="{{ $searchAction }}" method="GET"
                    class="flex items-center bg-[#1d3566] rounded-full px-3 py-1.5 lg:px-4 lg:py-2.5 shadow-lg border border-[#F97316]/30 focus-within:border-[#F97316] focus-within:ring-2 focus-within:ring-[#F97316]/30 transition-all duration-300">
                    <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 text-[#F97316]" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ $searchPlaceholder }}"
                        class="ml-2 text-xs lg:text-sm bg-transparent border-none focus:ring-0 focus:outline-none text-white placeholder-gray-400 w-full lg:w-80 transition-all duration-300">
                </form>
            </div>

            <!-- Actions desktop (inchangées) -->
            <div class="hidden lg:flex items-center gap-3">
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                        class="relative p-2.5 text-white hover:text-[#F97316] transition-all rounded-xl hover:bg-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak
                        class="absolute right-0 mt-2 w-56 bg-[#1d3566] rounded-xl shadow-2xl border border-[#F97316]/30 overflow-hidden dropdown-open"
                        style="display: none;">
                        <div class="py-2">
                            @if(auth()->user()->is_super_admin)
                                <a href="{{ route('admin.create') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                    <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    <span>Nouvel Administrateur</span>
                                </a>
                                <a href="{{ route('admin.logs.index') }}"
                                    class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                    <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <span>Journal d'activités</span>
                                </a>
                            @endif
                            <a href="{{ route('admin.profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-300 hover:text-white hover:bg-white/10 transition-colors">
                                <svg class="w-5 h-5 text-[#F97316]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                </svg>
                                <span>Paramètres du compte</span>
                            </a>
                        </div>
                    </div>
                </div>

                <button onclick="confirmLogout()"
                    class="flex items-center gap-2 px-4 py-2 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white text-sm font-semibold rounded-xl transition-all group border border-red-500/20">
                    <svg class="w-4 h-4 transform rotate-180 group-hover:-translate-x-1 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Déconnexion
                </button>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto animate-fade-up relative">
                <!-- Flash Messages -->
                <div
                    class="absolute top-0 right-0 z-50 flex mb-4 flex-col space-y-3 pointer-events-none w-full max-w-sm">
                    @if (session('success'))
                        <div class="pointer-events-auto p-4 bg-[#1d3566] shadow-xl shadow-emerald-500/10 border border-emerald-500/30 rounded-2xl flex items-start relative overflow-hidden"
                            x-data="{ show: true }" x-show="show" x-transition.opacity
                            x-init="setTimeout(() => show = false, 5000)">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
                            <div class="p-2 bg-emerald-500/20 rounded-xl mr-3 shrink-0"><svg
                                    class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7"></path>
                                </svg></div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Succès</h4>
                                <p class="text-xs text-gray-300 mt-1 font-medium">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-white"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="pointer-events-auto p-4 bg-[#1d3566] shadow-xl shadow-red-500/10 border border-red-500/30 rounded-2xl flex items-start relative overflow-hidden"
                            x-data="{ show: true }" x-show="show" x-transition.opacity
                            x-init="setTimeout(() => show = false, 7000)">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>
                            <div class="p-2 bg-red-500/20 rounded-xl mr-3 shrink-0"><svg class="w-5 h-5 text-red-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Erreur</h4>
                                <p class="text-xs text-gray-300 mt-1 font-medium">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-white"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                    @endif
                </div>

                @yield('content')
            </div>

            <footer class="mt-12 pt-6 text-center text-xs text-gray-500 border-t border-gray-700">
                <p>&copy; {{ date('Y') }} OPTI-LEARNING. Tous droits réservés. Espace Administration.</p>
            </footer>
        </main>

        @stack('scripts')
    </div>

    <!-- Modal de confirmation de déconnexion professionnel -->
    <div id="logoutConfirmModal" class="fixed inset-0 z-[200] hidden">
        <div class="absolute inset-0 bg-navy-900/80 backdrop-blur-sm" onclick="closeLogoutModal()"></div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in-up">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-sign-out-alt text-white text-4xl"></i>
                </div>
                <h3 class="text-white text-xl font-head font-bold">Déconnexion</h3>
                <p class="text-white/80 text-sm mt-1">Êtes-vous sûr de vouloir quitter ?</p>
            </div>
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

    <script>
        // Fonction de confirmation de déconnexion professionnelle
        function confirmLogout() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Fermer le modal de déconnexion avec la touche Echap
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('logoutConfirmModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeLogoutModal();
                }
            }
        });

        // Fermer le modal en cliquant sur l'overlay
        const logoutModal = document.getElementById('logoutConfirmModal');
        if (logoutModal) {
            logoutModal.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeLogoutModal();
                }
            });
        }
    </script>
</body>

</html>