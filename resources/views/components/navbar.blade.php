@props(['showSidebarToggle' => false, 'searchAction' => route('home'), 'hideCart' => false, 'showProfile' => false])

<style>
/* ============================
   HEADER UNIFIÉ (COMPOSANT GLOBAL)
============================ */
.main-navbar {
    background: #0B1A3E; /* Bleu Nuit / var(--navy) */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(11, 26, 62, 0.3);
}

.navbar-spacer {
    height: 88px;
}

.main-navbar .header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 72px;
    gap: 16px;
}

.main-navbar .header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
}

.main-navbar .btn-login {
    padding: 8px 20px;
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    background: transparent;
    color: #FFFFFF;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.main-navbar .btn-login:hover {
    border-color: #F97316;
    color: #F97316;
}

.main-navbar .btn-signup {
    padding: 8px 22px;
    background: #F97316;
    border: none;
    color: #FFFFFF;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.main-navbar .btn-signup:hover {
    background: #ea580c;
    transform: translateY(-1px);
}

.main-navbar .btn-dashboard {
    padding: 8px 22px;
    background: #122255;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #FFFFFF;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.main-navbar .btn-dashboard:hover {
    background: #1A3070;
}

.main-navbar .hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: transparent;
    border: none;
    padding: 8px;
    cursor: pointer;
}

.main-navbar .hamburger span {
    display: block;
    width: 24px;
    height: 2px;
    background: #FFFFFF;
    border-radius: 2px;
    transition: all 0.2s ease;
}

.main-navbar .hamburger.open span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.main-navbar .hamburger.open span:nth-child(2) {
    opacity: 0;
}

.main-navbar .hamburger.open span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

.main-navbar .mobile-menu {
    display: none;
    flex-direction: column;
    background: #122255;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding: 12px 0;
}

.main-navbar .mobile-menu.open {
    display: flex;
}

.main-navbar .mobile-menu a {
    color: rgba(255, 255, 255, 0.7);
    padding: 14px 24px;
    font-size: 15px;
    font-weight: 500;
    border-left: 3px solid transparent;
    transition: all 0.2s ease;
}

.main-navbar .mobile-menu a:hover,
.main-navbar .mobile-menu a.active {
    color: #FFFFFF;
    border-left-color: #F97316;
    background: rgba(255, 255, 255, 0.05);
}

/* RESPONSIVE */
@media (min-width: 769px) and (max-width: 1024px) {
    .main-navbar .hamburger { display: flex !important; }
    .main-navbar .header-actions { display: flex !important; }
    .main-navbar .btn-login, .main-navbar .btn-signup, .main-navbar .btn-dashboard { padding: 6px 16px; font-size: 13px; }
}

@media (max-width: 768px) {
    .main-navbar .hamburger { display: flex !important; }
    .main-navbar .header-actions { display: flex !important; }
    .main-navbar .btn-login, .main-navbar .btn-signup, .main-navbar .btn-dashboard { padding: 6px 14px; font-size: 12px; }
    .main-navbar .header-main { gap: 12px; height: 64px; }
}

@media (max-width: 480px) {
    .main-navbar .btn-login, .main-navbar .btn-signup, .main-navbar .btn-dashboard { padding: 5px 10px; font-size: 11px; }
    .main-navbar .header-main { gap: 8px; }
}

@media (min-width: 1025px) {
    .main-navbar .hamburger { display: none !important; }
    .main-navbar .mobile-menu { display: none !important; }
}

@media (max-width: 1024px) {
    .navbar-spacer { height: 135px; }
}
@media (max-width: 768px) {
    .navbar-spacer { height: 125px; }
}
@media (max-width: 480px) {
    .navbar-spacer { height: 120px; }
}
</style>

<header class="main-navbar">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="header-main flex justify-between items-center relative z-50 py-2">
            <!-- Logo -->
            <div class="flex items-center shrink-0 order-1 w-24 sm:w-auto">
                @if($showSidebarToggle)
                    <!-- Pour les vues admin/apprenant/formateur avec sidebar qui nécessite un burger menu -->
                   <button @click="sidebarOpen = !sidebarOpen"
                       class="lg:hidden -ml-2 mr-2 sm:mr-4 text-white hover:text-[#F97316] p-2 rounded-xl hover:bg-white/10 transition-all duration-300">
                       <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                               d="M4 6h16M4 12h16M4 18h7"></path>
                       </svg>
                   </button>
                @else
                   <!-- Hamburger de Navigation Mobile régulier (Page d'accueil) poussé à gauche -->
                   <button class="hamburger -ml-2 mr-2 sm:mr-4" id="global-hamburger" aria-label="Menu" onclick="document.getElementById('global-mobile-menu').classList.toggle('open'); this.classList.toggle('open');">
                       <span></span><span></span><span></span>
                   </button>
                @endif
                <x-logo href="{{ route('home') }}" />
            </div>

            <!-- Actions (Cart/Auth) & Hamburger -->
            <div class="flex items-center gap-2 md:gap-4 order-3">
                <div class="header-actions flex gap-2 items-center">
                    
                    <!-- Bouton Panier -->
                    @if(!$hideCart)
                    <a href="{{ route('cart.index') }}" class="relative text-[#F97316] hover:text-[#ea580c] transition mr-2 mt-1" title="Mon Panier">
                        <i class="fas fa-shopping-cart text-xl sm:text-2xl"></i>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[9px] sm:text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm border border-white">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                    @endif

                    <!-- Boutons Utilisateur DYNAMIQUE -->
                    @guest
                        <a href="{{ route('login') }}" class="btn-login flex items-center justify-center">Connexion</a>
                        <a href="{{ route('register') }}" class="btn-signup flex items-center justify-center">Inscription</a>
                    @else
                        @if($showSidebarToggle || $showProfile)
                            <!-- Profil de l'utilisateur sur le tableau de bord -->
                            <div class="hidden sm:flex items-center gap-2 cursor-pointer hover:bg-white/5 p-1 pr-3 rounded-full transition" onclick="if(typeof openProfileModal === 'function') openProfileModal();">
                                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->first_name ?? 'U').'&background=F97316&color=fff' }}" alt="Profile" class="w-8 h-8 rounded-full border border-gray-600 object-cover">
                                <span class="text-white text-sm font-medium">{{ auth()->user()->first_name }}</span>
                            </div>
                            
                            <!-- Bouton déconnexion direct (Mobile & Desktop) -->
                            <form method="POST" action="{{ route('logout') }}" class="block ml-1">
                                @csrf
                                <button type="button" onclick="typeof confirmLogout === 'function' ? confirmLogout() : this.closest('form').submit()" class="flex items-center justify-center text-white bg-red-500/20 hover:bg-red-500/40 border border-red-500/50 px-2.5 py-1.5 lg:px-3 lg:py-2 rounded-lg text-sm font-medium transition-all shadow-sm" title="Se déconnecter">
                                    <i class="fas fa-sign-out-alt"></i><span class="hidden lg:inline ml-2">Déconnexion</span>
                                </button>
                            </form>
                        @else
                            <!-- Bouton d'accès au dashboard depuis les pages publiques -->
                            @if(auth()->user()->is_super_admin || auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-dashboard flex items-center justify-center">
                                    <i class="fas fa-shield-alt mr-2 hidden sm:inline"></i>Admin
                                </a>
                            @elseif(auth()->user()->hasRole('formateur'))
                                <a href="{{ route('formateur.dashboard') }}" class="btn-dashboard flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher mr-2 hidden sm:inline"></i>Formateur
                                </a>
                            @else
                                <a href="{{ route('apprenant.dashboard') }}" class="btn-dashboard flex items-center justify-center">
                                    <i class="fas fa-user-graduate mr-2 hidden sm:inline"></i>Tableau de bord
                                </a>
                            @endif
                        @endif
                    @endguest
                </div>

            </div>

            <!-- Barre de Recherche Complète (Desktop) -->
            <div class="hidden lg:block lg:flex-1 lg:max-w-2xl lg:mx-4 xl:max-w-4xl xl:mx-8 order-2">
                <x-search-bar :action="$searchAction" />
            </div>
        </div>
        <!-- Barre de recherche mobile (Fixée sous le header) -->
        <div class="lg:hidden w-full pb-3 mt-1">
            <x-search-bar :action="$searchAction" />
        </div>
    </div>

    <!-- Menu mobile/tablette (Régulier) -->
    @if(!$showSidebarToggle)
    <div class="mobile-menu px-4 gap-2" id="global-mobile-menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }} mt-2">Accueil</a>
        <a href="{{ route('home') }}#formations">Formations</a>
        <a href="{{ route('home') }}#categories">Catégories</a>
        <a href="#">Contact</a>
        
        @auth
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="button" onclick="typeof confirmLogout === 'function' ? confirmLogout() : this.closest('form').submit()" class="w-full text-left text-red-400 hover:text-white padding-14px px-8 py-3 text-[15px] font-medium transition-colors">
                    <i class="fas fa-power-off mr-2"></i> Se déconnecter
                </button>
            </form>
        @endauth
    </div>
    @endif
</header>
<!-- Espaceur invisible pour repousser le contenu sous le header fixé -->
<div class="navbar-spacer"></div>
