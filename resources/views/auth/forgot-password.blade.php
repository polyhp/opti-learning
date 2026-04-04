@extends('layouts.app')

@section('title', 'Mot de passe oublié - OPTI-LEARNING')

@section('content')
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background avec dégradé bleu-nuit -->
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60"
                xmlns="http://www.w3.org/2000/svg" %3E%3Cdefs%3E%3Cpattern id="grid" width="60" height="60"
                patternUnits="userSpaceOnUse" %3E%3Cpath d="M 60 0 L 0 0 0 60" fill="none" stroke="rgba(255,107,53,0.08)"
                stroke-width="1" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100%25" height="100%25" fill="url(%23grid)"
                /%3E%3C/svg%3E')] opacity-30"></div>
            <!-- Effet de particules -->
            <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-navy-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-md">
            <!-- Carte principale -->
            <div
                class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-500 hover:shadow-orange-500/10">
                <!-- En-tête avec dégradé orange -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-8 text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mt-16 -mr-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full -mb-12 -ml-12"></div>
                    <div
                        class="inline-flex items-center justify-center h-20 leading-none bg-white p-2 rounded mb-4 shadow-lg transform transition-transform hover:scale-110 duration-300">
                        <img src="{{ asset('images/logo.jpg') }}" alt="OptiLearning" class="h-full w-auto object-contain">
                    </div>
                    <h2 class="text-2xl font-bold text-white">Mot de passe oublié</h2>
                    <p class="text-orange-100 mt-2">Réinitialisation en 3 étapes simples</p>
                </div>

                <div class="p-8">
                    <!-- Barre de chargement globale -->
                    <div id="loadingOverlay"
                        class="fixed inset-0 bg-navy-900/80 backdrop-blur-sm z-50 hidden items-center justify-center">
                        <div class="bg-white rounded-2xl p-8 text-center transform transition-all duration-300 scale-100">
                            <div class="relative w-24 h-24 mx-auto mb-4">
                                <!-- Cercle de chargement orange -->
                                <div class="absolute inset-0 border-4 border-orange-200 rounded-full"></div>
                                <div class="absolute inset-0 border-4 border-orange-500 rounded-full animate-spin"
                                    style="border-top-color: transparent; border-right-color: transparent; border-bottom-color: transparent;">
                                </div>
                                <!-- Cercle intérieur bleu-nuit -->
                                <div class="absolute inset-2 border-4 border-navy-200 rounded-full"></div>
                                <div class="absolute inset-2 border-4 border-navy-700 rounded-full animate-spin-slow"
                                    style="border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent;">
                                </div>
                                <!-- Icône -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <i class="fas fa-key text-orange-500 text-2xl animate-pulse"></i>
                                </div>
                            </div>
                            <p id="loadingMessage" class="text-navy-800 font-semibold mb-2">Traitement en cours...</p>
                            <p class="text-gray-500 text-sm">Veuillez patienter</p>
                            <!-- Barre de progression -->
                            <div class="mt-4 w-48 h-1 bg-gray-200 rounded-full overflow-hidden">
                                <div
                                    class="h-full bg-gradient-to-r from-navy-600 to-orange-500 rounded-full animate-loading-bar">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Indicateur d'étapes modernisé -->
                    <div class="flex justify-between mb-10 relative">
                        <!-- Ligne de progression -->
                        <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200 -z-0"></div>
                        <div class="absolute top-5 left-0 h-0.5 bg-gradient-to-r from-navy-600 to-orange-500 transition-all duration-500 -z-0"
                            id="progressLine" style="width: 0%"></div>

                        <!-- Étape 1 -->
                        <div class="step-indicator text-center flex-1 relative z-10" id="step1Indicator">
                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white flex items-center justify-center font-bold text-lg shadow-lg ring-4 ring-white transition-all duration-300">
                                1</div>
                            <p class="text-xs mt-3 font-medium text-navy-700">Email</p>
                        </div>

                        <!-- Étape 2 -->
                        <div class="step-indicator text-center flex-1 relative z-10" id="step2Indicator">
                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg transition-all duration-300">
                                2</div>
                            <p class="text-xs mt-3 font-medium text-gray-500">Code</p>
                        </div>

                        <!-- Étape 3 -->
                        <div class="step-indicator text-center flex-1 relative z-10" id="step3Indicator">
                            <div
                                class="w-12 h-12 mx-auto rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg transition-all duration-300">
                                3</div>
                            <p class="text-xs mt-3 font-medium text-gray-500">Nouveau mot de passe</p>
                        </div>
                    </div>

                    <!-- Étape 1: Formulaire email -->
                    <div id="step1" class="step-content animate-fadeIn">
                        <form id="emailForm">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-navy-800 mb-2">
                                    <i class="fas fa-envelope text-orange-500 mr-2"></i>Adresse email
                                </label>
                                <div class="relative group">
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-3 pl-11 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-300 outline-none text-navy-900"
                                        placeholder="exemple@email.com">
                                    <i
                                        class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-300"></i>
                                </div>
                                <div id="emailError" class="text-red-500 text-xs mt-2 hidden"></div>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-orange-500/25 flex items-center justify-center gap-2 group">
                                <i
                                    class="fas fa-paper-plane group-hover:translate-x-1 transition-transform duration-300"></i>
                                <span>Envoyer le code</span>
                            </button>
                        </form>
                    </div>

                    <!-- Étape 2: Formulaire code -->
                    <div id="step2" class="step-content hidden animate-fadeIn">
                        <form id="codeForm">
                            @csrf
                            <input type="hidden" id="resetEmail" name="email">

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-navy-800 mb-2">
                                    <i class="fas fa-lock text-orange-500 mr-2"></i>Code de vérification
                                </label>
                                <div class="flex gap-3">
                                    <div class="flex-1 relative group">
                                        <input type="text" id="code" name="code" maxlength="4" required
                                            class="w-full px-4 py-3 text-center text-2xl font-mono tracking-widest border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-300 outline-none text-navy-900"
                                            placeholder="0000">
                                    </div>
                                    <button type="button" id="resendCode"
                                        class="px-5 py-3 bg-gray-100 text-navy-700 rounded-xl hover:bg-orange-500 hover:text-white transition-all duration-300 text-sm font-medium">
                                        <i class="fas fa-redo-alt mr-1"></i>Renvoyer
                                    </button>
                                </div>
                                <div id="codeError" class="text-red-500 text-xs mt-2 hidden"></div>
                                <div class="flex items-center gap-2 mt-3 text-xs text-gray-500">
                                    <i class="fas fa-clock text-orange-500"></i>
                                    <span>Le code expire dans 10 minutes</span>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button type="button" id="backToEmail"
                                    class="flex-1 px-4 py-3 bg-gray-100 text-navy-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Précédent</span>
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 flex items-center justify-center gap-2 group">
                                    <span>Vérifier</span>
                                    <i
                                        class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Étape 3: Formulaire nouveau mot de passe -->
                    <div id="step3" class="step-content hidden animate-fadeIn">
                        <form id="passwordForm">
                            @csrf
                            <input type="hidden" id="finalEmail" name="email">

                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-navy-800 mb-2">
                                    <i class="fas fa-lock text-orange-500 mr-2"></i>Nouveau mot de passe
                                </label>
                                <div class="relative group">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-4 py-3 pl-11 pr-12 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-300 outline-none text-navy-900"
                                        placeholder="••••••••">
                                    <i
                                        class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-300"></i>
                                    <button type="button" onclick="togglePassword('password', this)"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-orange-500 transition-colors duration-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordError" class="text-red-500 text-xs mt-2 hidden"></div>
                                <div class="mt-2 flex flex-wrap gap-2 text-xs text-gray-500">
                                    <span class="flex items-center gap-1"><i class="fas fa-check-circle text-gray-400"></i>
                                        Min 8 caractères</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-navy-800 mb-2">
                                    <i class="fas fa-check-circle text-orange-500 mr-2"></i>Confirmer le mot de passe
                                </label>
                                <div class="relative group">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="w-full px-4 py-3 pl-11 pr-12 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-300 outline-none text-navy-900"
                                        placeholder="••••••••">
                                    <i
                                        class="fas fa-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors duration-300"></i>
                                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-orange-500 transition-colors duration-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button type="button" id="backToCode"
                                    class="flex-1 px-4 py-3 bg-gray-100 text-navy-700 rounded-xl hover:bg-gray-200 transition-all duration-300 font-medium flex items-center justify-center gap-2">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Précédent</span>
                                </button>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 flex items-center justify-center gap-2 group">
                                    <span>Réinitialiser</span>
                                    <i
                                        class="fas fa-check-circle group-hover:scale-110 transition-transform duration-300"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Lien retour -->
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-orange-500 transition-all duration-300 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-300"></i>
                            <span>Retour à la connexion</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-gray-400">
                    &copy; 2024 OPTI-LEARNING. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour afficher la barre de chargement
        function showLoading(message = 'Traitement en cours...') {
            const overlay = document.getElementById('loadingOverlay');
            const loadingMessage = document.getElementById('loadingMessage');
            loadingMessage.textContent = message;
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }

        // Fonction pour cacher la barre de chargement
        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        let currentStep = 1;
        let userEmail = '';

        function updateSteps() {
            const progressWidth = ((currentStep - 1) / 2) * 100;
            document.getElementById('progressLine').style.width = `${progressWidth}%`;

            for (let i = 1; i <= 3; i++) {
                const indicator = document.getElementById(`step${i}Indicator`);
                const circle = indicator.querySelector('div');
                const text = indicator.querySelector('p');

                if (i < currentStep) {
                    circle.className = 'w-12 h-12 mx-auto rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white flex items-center justify-center font-bold text-lg shadow-lg ring-4 ring-white transition-all duration-300';
                    circle.innerHTML = '<i class="fas fa-check text-sm"></i>';
                    text.className = 'text-xs mt-3 font-medium text-green-600';
                } else if (i === currentStep) {
                    circle.className = 'w-12 h-12 mx-auto rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white flex items-center justify-center font-bold text-lg shadow-lg ring-4 ring-white scale-110 transition-all duration-300';
                    circle.innerHTML = i;
                    text.className = 'text-xs mt-3 font-medium text-orange-600';
                } else {
                    circle.className = 'w-12 h-12 mx-auto rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold text-lg transition-all duration-300';
                    circle.innerHTML = i;
                    text.className = 'text-xs mt-3 font-medium text-gray-500';
                }
            }

            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');
            document.getElementById(`step${currentStep}`).classList.remove('hidden');
        }

        function showMessage(message, type = 'success') {
            const messageDiv = document.createElement('div');
            messageDiv.className = `fixed top-4 right-4 z-50 px-5 py-3 rounded-xl shadow-2xl backdrop-blur-lg ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                } animate-slide-in flex items-center gap-3`;
            messageDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} text-xl"></i>
            <span class="font-medium">${message}</span>
        `;
            document.body.appendChild(messageDiv);
            setTimeout(() => {
                messageDiv.style.opacity = '0';
                messageDiv.style.transform = 'translateX(100%)';
                setTimeout(() => messageDiv.remove(), 300);
            }, 5000);
        }

        // Étape 1: Envoi du code
        document.getElementById('emailForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;

            showLoading('Envoi du code de vérification...');

            try {
                const response = await fetch('{{ route("password.send-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();
                hideLoading();

                if (data.success) {
                    userEmail = email;
                    document.getElementById('resetEmail').value = email;
                    document.getElementById('finalEmail').value = email;
                    currentStep = 2;
                    updateSteps();
                    showMessage(data.message, 'success');
                    document.getElementById('code').value = '';
                } else {
                    if (data.errors) {
                        const errorDiv = document.getElementById('emailError');
                        errorDiv.textContent = data.errors.email?.[0] || 'Une erreur est survenue';
                        errorDiv.classList.remove('hidden');
                        setTimeout(() => errorDiv.classList.add('hidden'), 3000);
                    } else {
                        showMessage(data.message || 'Une erreur est survenue', 'error');
                    }
                }
            } catch (error) {
                hideLoading();
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
            }
        });

        // Étape 2: Vérification du code
        document.getElementById('codeForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('resetEmail').value;
            const code = document.getElementById('code').value;

            showLoading('Vérification du code...');

            try {
                const response = await fetch('{{ route("password.verify-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email, code })
                });

                const data = await response.json();
                hideLoading();

                if (data.success) {
                    currentStep = 3;
                    updateSteps();
                    showMessage(data.message, 'success');
                } else {
                    const errorDiv = document.getElementById('codeError');
                    errorDiv.textContent = data.message;
                    errorDiv.classList.remove('hidden');
                    setTimeout(() => errorDiv.classList.add('hidden'), 3000);
                }
            } catch (error) {
                hideLoading();
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
            }
        });

        // Étape 3: Réinitialisation du mot de passe
        document.getElementById('passwordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('finalEmail').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            const errorDiv = document.getElementById('passwordError');

            if (password !== password_confirmation) {
                errorDiv.textContent = 'Les mots de passe ne correspondent pas';
                errorDiv.classList.remove('hidden');
                setTimeout(() => errorDiv.classList.add('hidden'), 3000);
                return;
            }

            if (password.length < 8) {
                errorDiv.textContent = 'Le mot de passe doit contenir au moins 8 caractères';
                errorDiv.classList.remove('hidden');
                setTimeout(() => errorDiv.classList.add('hidden'), 3000);
                return;
            }

            showLoading('Réinitialisation du mot de passe...');

            try {
                const response = await fetch('{{ route("password.reset") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email, password, password_confirmation })
                });

                const data = await response.json();
                hideLoading();

                if (data.success) {
                    showMessage(data.message, 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    if (data.errors) {
                        errorDiv.textContent = data.errors.password?.[0] || 'Une erreur est survenue';
                    } else {
                        errorDiv.textContent = data.message;
                    }
                    errorDiv.classList.remove('hidden');
                    setTimeout(() => errorDiv.classList.add('hidden'), 3000);
                }
            } catch (error) {
                hideLoading();
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
            }
        });

        // Navigation
        document.getElementById('backToEmail').addEventListener('click', () => {
            currentStep = 1;
            updateSteps();
        });

        document.getElementById('backToCode').addEventListener('click', () => {
            currentStep = 2;
            updateSteps();
        });

        // Renvoyer le code
        document.getElementById('resendCode').addEventListener('click', async () => {
            const email = document.getElementById('resetEmail').value;

            showLoading('Envoi d\'un nouveau code...');

            try {
                const response = await fetch('{{ route("password.resend-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();
                hideLoading();

                if (data.success) {
                    showMessage(data.message, 'success');
                } else {
                    showMessage(data.message || 'Une erreur est survenue', 'error');
                }
            } catch (error) {
                hideLoading();
                showMessage('Erreur de connexion. Veuillez réessayer.', 'error');
            }
        });

        document.getElementById('code').addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 4);
        });
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }

        @keyframes loading-bar {
            0% {
                width: 0%;
                transform: translateX(-100%);
            }

            50% {
                width: 70%;
                transform: translateX(0%);
            }

            100% {
                width: 100%;
                transform: translateX(100%);
            }
        }

        .animate-spin {
            animation: spin 0.8s linear infinite;
        }

        .animate-spin-slow {
            animation: spin-slow 1.2s linear infinite;
        }

        .animate-loading-bar {
            animation: loading-bar 1.5s ease-in-out infinite;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #FF6B35;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #e55c2a;
        }

        /* Focus ring styles */
        *:focus {
            outline: none;
        }

        input:focus {
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }
    </style>
@endsection