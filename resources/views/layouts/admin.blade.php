<!DOCTYPE html>
<html lang="fr" class="antialiased bg-[#F8FAFE]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: linear-gradient(135deg, #F8FAFE 0%, #F1F5F9 100%);
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
            background: #F1F5F9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #0A2647, #1E3A5F);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FF6B35;
        }

        /* Sidebar scroll */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #1E3A5F;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #FF6B35;
            border-radius: 10px;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #FF6B35 #1E3A5F;
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

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.1);
            }
        }

        .animate-slide-in {
            animation: slideInRight 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8E5E 100%);
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
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8E5E 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(255, 107, 53, 0.4);
        }

        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Active nav indicator */
        .nav-active {
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.12) 0%, rgba(255, 107, 53, 0.05) 100%);
            border-left: 3px solid #FF6B35;
        }
    </style>
</head>

<body class="flex min-h-screen overflow-hidden selection:bg-[#FF6B35] selection:text-white"
    x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <!-- OVERLAY MOBILE -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-[#0A2647]/80 backdrop-blur-sm lg:hidden"
        @click="sidebarOpen = false" x-cloak></div>

    <!-- SIDEBAR - Bleu nuit profond -->
    <aside
        class="fixed inset-y-0 left-0 z-50 w-80 bg-gradient-to-b from-[#0A2647] to-[#0B2B4F] flex flex-col transition-transform duration-300 transform lg:relative lg:translate-x-0 shadow-2xl"
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" x-cloak>

        <!-- Header Logo Sidebar -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/10 shrink-0 bg-[#082032]">
            <a href="#" class="flex items-center group relative">
                <div
                    class="absolute -inset-4 bg-[#FF6B35] opacity-0 group-hover:opacity-10 blur-xl transition-all duration-500 rounded-full">
                </div>
                <div class="w-10 h-10 flex items-center justify-center mr-3 animate-pulse"
                    style="animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;">
                    <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo" class="w-full h-full object-contain drop-shadow-md">
                </div>
                <div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">OPTI-<span
                            class="gradient-text">LEARNING</span></span>
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
                <p class="px-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-[#FF6B35] mr-2"></span>
                    MENU PRINCIPAL
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Tableau de bord
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.users.*') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Utilisateurs
                    </a>

                    <a href="{{ route('admin.courses.index') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.courses.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.courses.*') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Formations
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.payments.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.payments.*') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Paiements
                    </a>
                </div>
            </div>

            <!-- Administration -->
            <div>
                <p class="px-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-[#FF6B35] mr-2"></span>
                    ADMINISTRATION
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.create') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.create') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.create') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                        Nouvel Admin
                    </a>

                    <a href="{{ route('admin.logs.index') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.logs.*') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.logs.*') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Journal d'activités
                    </a>

                    <a href="{{ route('admin.profile.edit') }}"
                        class="nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300 {{ request()->routeIs('admin.profile.edit') ? 'nav-active text-white' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.profile.edit') ? 'text-[#FF6B35]' : 'text-gray-500 group-hover:text-[#FF6B35]' }} transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Paramètres
                    </a>
                </div>
            </div>

        </div>

        <!-- User Profile Section -->
        <div class="p-3 border-t border-white/10 bg-[#082032] shrink-0">
            <div class="flex items-center p-2.5 rounded-2xl bg-white/5 backdrop-blur-sm">
                <img src="{{ auth()->user()->avatar_url }}" alt="Profile"
                    class="w-12 h-12 rounded-full border border-gray-600 object-cover shrink-0">
                <div class="ml-3 flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-[11px] text-gray-400 font-medium mt-0.5 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="w-full mt-3">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500/10 hover:bg-red-500 border border-red-500/20 text-red-400 hover:text-white text-sm font-semibold rounded-xl transition-all duration-300 group">
                    <svg class="w-4 h-4 transform rotate-180 group-hover:-translate-x-1 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

        <!-- Header Glass -->
        <header class="glass h-20 flex items-center justify-between px-6 lg:px-8 z-30 shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-600 hover:text-[#FF6B35] focus:outline-none p-2 rounded-xl hover:bg-white transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>
                <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                <h1
                    class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-[#0A2647] to-[#1E3A5F] bg-clip-text text-transparent">
                    @yield('header_title', 'Espace Administration')</h1>
            </div>

            <div class="flex items-center gap-3">
                <!-- Search -->
                <div class="hidden md:flex items-center bg-white rounded-xl px-3 py-2 shadow-sm border border-gray-100">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Rechercher..."
                        class="ml-2 text-sm bg-transparent border-none focus:outline-none text-gray-700 w-48">
                </div>

                <!-- Notifications -->
                <button
                    class="relative p-2.5 text-gray-500 hover:text-[#FF6B35] transition-all rounded-xl hover:bg-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#FF6B35] rounded-full ring-2 ring-white"></span>
                </button>

                <!-- Logout Desktop -->
                <form method="POST" action="{{ route('logout') }}"
                    class="hidden lg:block ml-2 border-l border-gray-200 pl-4">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 text-sm font-semibold rounded-xl transition-all group">
                        <svg class="w-4 h-4 transform rotate-180 group-hover:-translate-x-1 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </header>

        <!-- Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8">
            <div class="max-w-7xl mx-auto animate-fade-up relative">
                <!-- Flash Messages -->
                <div
                    class="absolute top-0 right-0 z-50 flex mb-4 flex-col space-y-3 pointer-events-none w-full max-w-sm">
                    @if (session('success'))
                        <div class="pointer-events-auto p-4 bg-white shadow-xl shadow-green-500/10 border border-green-100 rounded-2xl flex items-start relative overflow-hidden"
                            x-data="{ show: true }" x-show="show" x-transition.opacity
                            x-init="setTimeout(() => show = false, 5000)">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-green-500"></div>
                            <div class="p-2 bg-green-50 rounded-xl mr-3 shrink-0"><svg class="w-5 h-5 text-green-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7"></path>
                                </svg></div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Succès</h4>
                                <p class="text-xs text-gray-500 mt-1 font-medium">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="pointer-events-auto p-4 bg-white shadow-xl shadow-red-500/10 border border-red-100 rounded-2xl flex items-start relative overflow-hidden"
                            x-data="{ show: true }" x-show="show" x-transition.opacity
                            x-init="setTimeout(() => show = false, 7000)">
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500"></div>
                            <div class="p-2 bg-red-50 rounded-xl mr-3 shrink-0"><svg class="w-5 h-5 text-red-500"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900">Erreur</h4>
                                <p class="text-xs text-gray-500 mt-1 font-medium">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="ml-auto text-gray-400 hover:text-gray-600"><svg
                                    class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg></button>
                        </div>
                    @endif
                </div>

                @yield('content')
            </div>

            <footer class="mt-12 pt-6 text-center text-xs text-gray-400 border-t border-gray-200">
                <p>&copy; {{ date('Y') }} OPTI-LEARNING. Tous droits réservés. Espace Administration.</p>
            </footer>
        </main>

        <!-- Scripts additionnels -->
        @stack('scripts')
    </div>
</body>

</html>