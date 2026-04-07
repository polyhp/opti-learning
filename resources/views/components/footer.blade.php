{{-- resources/views/components/footer.blade.php --}}
<footer
    class="bg-gradient-to-b from-[#0A2647] to-[#061830] text-gray-300 relative mt-auto border-t border-white/10 overflow-hidden">
    {{-- Motif de fond optionnel --}}
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="2" cy="2" r="1" fill="white" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#dots)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        <!-- Première ligne : 5 colonnes principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">

            <!-- 1. Logo, présentation et contact -->
            <div class="space-y-4 lg:col-span-1">
                <x-logo class="mb-4" />
                <p class="text-sm text-gray-400 leading-relaxed">
                    La plateforme d'excellence pour l'apprentissage en ligne.
                    Rejoignez des milliers de formateurs et apprenants.
                </p>
                <div class="flex items-center text-[#FF6B35] mt-4">
                    <div
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center mr-3 hover:bg-[#FF6B35] hover:text-white transition cursor-pointer">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <span class="font-bold tracking-wide">+228 90 00 00 00</span>
                </div>
                <div class="flex items-center text-gray-400 text-sm mt-2">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>contact@opti-learning.com</span>
                </div>
            </div>

            <!-- 2. Plan du site - Principal -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 border-b-2 border-[#FF6B35] inline-block pb-1">Navigation
                </h4>
                <ul class="space-y-3 mt-4 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-[#FF6B35] transition flex items-center group"><span
                                class="w-1.5 h-1.5 rounded-full bg-[#FF6B35] mr-2 group-hover:scale-125 transition"></span>Accueil</a>
                    </li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition flex items-center group"><span
                                class="w-1.5 h-1.5 rounded-full bg-[#FF6B35] mr-2 group-hover:scale-125 transition"></span>Toutes
                            les formations</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition flex items-center group"><span
                                class="w-1.5 h-1.5 rounded-full bg-[#FF6B35] mr-2 group-hover:scale-125 transition"></span>Devenir
                            Formateur</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition flex items-center group"><span
                                class="w-1.5 h-1.5 rounded-full bg-[#FF6B35] mr-2 group-hover:scale-125 transition"></span>Entreprises
                            & partenariats</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition flex items-center group"><span
                                class="w-1.5 h-1.5 rounded-full bg-[#FF6B35] mr-2 group-hover:scale-125 transition"></span>Témoignages</a>
                    </li>
                </ul>
            </div>

            <!-- 3. Catégories de formations -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 border-b-2 border-[#FF6B35] inline-block pb-1">Formations
                </h4>
                <ul class="space-y-3 mt-4 text-sm">
                    <li><a href="#" class="hover:text-[#FF6B35] transition">💻 Développement Web</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">📊 Marketing Digital</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">🎨 Design & UX/UI</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">📈 Business & Management</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">🤖 Intelligence Artificielle</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">📱 Mobile Development</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition text-[#FF6B35] font-semibold">Plus →</a></li>
                </ul>
            </div>

            <!-- 4. Derniers articles du blog -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 border-b-2 border-[#FF6B35] inline-block pb-1">Blog &
                    Actualités</h4>
                <ul class="space-y-4 mt-4 text-sm">
                    <li>
                        <a href="#" class="hover:text-[#FF6B35] transition group">
                            <p class="font-medium group-hover:text-[#FF6B35]">📝 Les tendances e-learning 2025</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-[#FF6B35] transition group">
                            <p class="font-medium group-hover:text-[#FF6B35]">🎯 Comment réussir sa formation en ligne ?
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-[#FF6B35] transition group">
                            <p class="font-medium group-hover:text-[#FF6B35]">🚀 5 astuces pour booster sa carrière</p>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 5. Informations légales & support -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 border-b-2 border-[#FF6B35] inline-block pb-1">Support</h4>
                <ul class="space-y-3 mt-4 text-sm">
                    <li><a href="#" class="hover:text-[#FF6B35] transition">❓ Centre d'aide</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">📞 Contactez-nous</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">📄 Conditions générales</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">🔒 Politique de confidentialité</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">🍪 Gestion des cookies</a></li>
                    <li><a href="#" class="hover:text-[#FF6B35] transition">⚖️ Mentions légales</a></li>
                </ul>
            </div>
        </div>

        <!-- Deuxième ligne : Newsletter, Apps, Réseaux sociaux, Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pt-8 border-t border-white/10">

            <!-- Newsletter -->
            <div class="lg:col-span-1">
                <h4 class="text-white text-lg font-bold mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-[#FF6B35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Newsletter
                </h4>
                <p class="text-sm text-gray-400 mb-4">Recevez nos actualités et offres exclusives</p>
                <form action="#" method="POST" class="flex flex-col gap-3">
                    <div class="flex">
                        <input type="email" placeholder="Votre adresse email"
                            class="flex-1 px-4 py-2.5 rounded-l-lg bg-navy-800/50 border border-white/20 text-white focus:outline-none focus:border-[#FF6B35] focus:ring-1 focus:ring-[#FF6B35] transition">
                        <button type="submit"
                            class="bg-[#FF6B35] hover:bg-[#EA580C] text-white px-4 py-2.5 rounded-r-lg transition font-bold">
                            OK
                        </button>
                    </div>
                    <label class="flex items-center text-xs text-gray-500">
                        <input type="checkbox" class="mr-2 rounded border-white/20 bg-navy-800/50"> J'accepte la
                        politique de confidentialité
                    </label>
                </form>
            </div>

            <!-- Télécharger l'application -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-[#FF6B35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Notre application
                </h4>
                <p class="text-sm text-gray-400 mb-4">Apprenez où que vous soyez</p>
                <!-- Add visual placeholders or leave empty if the app buttons were removed -->
            </div>

            <!-- Réseaux sociaux & Statistiques -->
            <div>
                <h4 class="text-white text-lg font-bold mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2 text-[#FF6B35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Communauté
                </h4>
                <div class="flex space-x-3 mb-6">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF6B35] hover:border-[#FF6B35] text-white transition-all transform hover:-translate-y-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF6B35] hover:border-[#FF6B35] text-white transition-all transform hover:-translate-y-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF6B35] hover:border-[#FF6B35] text-white transition-all transform hover:-translate-y-1">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF6B35] hover:border-[#FF6B35] text-white transition-all transform hover:-translate-y-1">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-[#FF6B35] hover:border-[#FF6B35] text-white transition-all transform hover:-translate-y-1">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center text-sm">
                    <div>
                        <p class="text-2xl font-bold text-white">50K+</p>
                        <p class="text-xs text-gray-500">Apprenants</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">500+</p>
                        <p class="text-xs text-gray-500">Formations</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">200+</p>
                        <p class="text-xs text-gray-500">Formateurs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Troisième ligne : Badges de certification et partenaires -->
    <div class="mt-8 pt-6 border-t border-white/10">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-gray-500">
                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-green-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg> Certification Qualiopi</span>
                <span class="flex items-center gap-1"><svg class="h-4 w-4 text-green-500" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg> Paiement 100% sécurisé</span>
            </div>
        </div>
    </div>
    </div>

    <!-- Copyright et Remontée -->
    <div class="border-t border-white/10 bg-[#040f1e]">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row justify-between items-center text-sm">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} <span class="text-white font-bold tracking-wide">OPTI-LEARNING</span>. Tous
                droits réservés.
            </p>
            <div class="flex gap-4 text-xs text-gray-500 mt-2 md:mt-0">
                <a href="#" class="hover:text-[#FF6B35]">Plan du site</a>
                <a href="#" class="hover:text-[#FF6B35]">Accessibilité</a>
                <a href="#" class="hover:text-[#FF6B35]">Crédits</a>
            </div>
            <!-- Bouton de remontée (Scroll to top) -->
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="mt-4 md:mt-0 w-10 h-10 rounded-full bg-white/10 hover:bg-[#FF6B35] text-white flex items-center justify-center transition-colors border border-white/10 hover:border-[#FF6B35]"
                title="Remonter en haut">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</footer>