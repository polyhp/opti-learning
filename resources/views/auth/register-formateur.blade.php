@extends('layouts.auth')

@section('title', 'Devenir Formateur - OPTI-LEARNING')

@section('content')
    <div class="relative min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>

        <div class="relative max-w-5xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-8 md:px-10">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Devenir Formateur</h1>
                            <p class="text-orange-100">Partagez votre expertise et gagnez de l'argent</p>
                        </div>
                        <a href="{{ url('/') }}" class="bg-white p-2 rounded w-16 h-12 flex items-center justify-center hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('images/logo.jpg') }}" alt="OptiLearning" class="w-full h-full object-contain">
                        </a>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.formateur') }}" enctype="multipart/form-data"
                    class="p-6 md:p-10 space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prénom <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span
                                    class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sexe <span
                                    class="text-red-500">*</span></label>
                            <select name="gender" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="">Sélectionnez</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('birth_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lieu de naissance <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('birth_place')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Domaine de formation <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="expertise_domain" value="{{ old('expertise_domain') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            placeholder="ex: Développement Web, Marketing Digital, Design...">
                        @error('expertise_domain')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                        <h3 class="font-semibold text-gray-900 mb-4">Documents justificatifs</h3>

                        <!-- Diplôme -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diplôme <span
                                    class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer"
                                onclick="document.getElementById('diploma').click()">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                            </div>
                            <input type="file" name="diploma_file" id="diploma" class="hidden" accept=".pdf,.jpg,.jpeg,.png"
                                onchange="previewFile(this, 'diploma_preview')">
                            <div id="diploma_preview"
                                class="mt-3 hidden items-center bg-gray-50 p-2 rounded-lg border border-gray-200 shadow-sm transition-all">
                                <div class="w-12 h-12 shrink-0 bg-white rounded flex items-center justify-center border border-gray-300 overflow-hidden"
                                    id="diploma_preview_media"></div>
                                <div class="ml-3 flex-1 overflow-hidden">
                                    <p class="text-sm font-medium text-gray-800 truncate" id="diploma_preview_name"></p>
                                    <p class="text-xs text-gray-500" id="diploma_preview_size"></p>
                                </div>
                                <button type="button" class="ml-2 text-red-500 hover:text-red-700 focus:outline-none"
                                    onclick="clearFile('diploma', 'diploma_preview')" title="Retirer le fichier">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </button>
                            </div>
                            @error('diploma_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Carte d'identité -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Carte d'identité <span
                                    class="text-red-500">*</span></label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer"
                                onclick="document.getElementById('id_card').click()">
                                <i class="fas fa-id-card text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                            </div>
                            <input type="file" name="id_card_file" id="id_card" class="hidden" accept=".pdf,.jpg,.jpeg,.png"
                                onchange="previewFile(this, 'id_card_preview')">
                            <div id="id_card_preview"
                                class="mt-3 hidden items-center bg-gray-50 p-2 rounded-lg border border-gray-200 shadow-sm transition-all">
                                <div class="w-12 h-12 shrink-0 bg-white rounded flex items-center justify-center border border-gray-300 overflow-hidden"
                                    id="id_card_preview_media"></div>
                                <div class="ml-3 flex-1 overflow-hidden">
                                    <p class="text-sm font-medium text-gray-800 truncate" id="id_card_preview_name"></p>
                                    <p class="text-xs text-gray-500" id="id_card_preview_size"></p>
                                </div>
                                <button type="button" class="ml-2 text-red-500 hover:text-red-700 focus:outline-none"
                                    onclick="clearFile('id_card', 'id_card_preview')" title="Retirer le fichier">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </button>
                            </div>
                            @error('id_card_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Certificat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Certificat (Optionnel)</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer"
                                onclick="document.getElementById('certificate').click()">
                                <i class="fas fa-certificate text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                            </div>
                            <input type="file" name="certificate_file" id="certificate" class="hidden"
                                accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'certificate_preview')">
                            <div id="certificate_preview"
                                class="mt-3 hidden items-center bg-gray-50 p-2 rounded-lg border border-gray-200 shadow-sm transition-all">
                                <div class="w-12 h-12 shrink-0 bg-white rounded flex items-center justify-center border border-gray-300 overflow-hidden"
                                    id="certificate_preview_media"></div>
                                <div class="ml-3 flex-1 overflow-hidden">
                                    <p class="text-sm font-medium text-gray-800 truncate" id="certificate_preview_name"></p>
                                    <p class="text-xs text-gray-500" id="certificate_preview_size"></p>
                                </div>
                                <button type="button" class="ml-2 text-red-500 hover:text-red-700 focus:outline-none"
                                    onclick="clearFile('certificate', 'certificate_preview')" title="Retirer le fichier">
                                    <i class="fas fa-times-circle text-xl"></i>
                                </button>
                            </div>
                            @error('certificate_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-medium text-navy-800 mb-2">Mot de passe <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-navy-900">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-orange-500 transition focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-navy-800 mb-2">Confirmer mot de passe <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-navy-900">
                                <button type="button" onclick="togglePassword('password_confirmation', this)"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-orange-500 transition focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-orange-500 rounded">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            J'accepte les <a href="#" class="text-orange-500 hover:text-orange-600">conditions générales</a>
                            et je certifie l'authenticité des documents fournis
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition transform hover:scale-[1.02] shadow-lg">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>Devenir Formateur
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        function previewFile(input, previewId) {
            const previewContainer = document.getElementById(previewId);
            const nameElement = document.getElementById(previewId + '_name');
            const sizeElement = document.getElementById(previewId + '_size');
            const mediaElement = document.getElementById(previewId + '_media');

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate size (max 5Mo)
                if (file.size > 5 * 1024 * 1024) {
                    alert("Le fichier ne doit pas dépasser 5 Mo.");
                    input.value = "";
                    previewContainer.classList.add('hidden');
                    previewContainer.classList.remove('flex');
                    return;
                }

                nameElement.textContent = file.name;
                sizeElement.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' Mo';

                // Preview logic
                mediaElement.innerHTML = '';
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        mediaElement.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else if (file.type === 'application/pdf') {
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-file-pdf text-red-500 text-2xl';
                    mediaElement.appendChild(icon);
                } else {
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-file text-gray-500 text-2xl';
                    mediaElement.appendChild(icon);
                }

                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('flex');
            } else {
                previewContainer.classList.add('hidden');
                previewContainer.classList.remove('flex');
            }
        }

        function clearFile(inputId, previewId) {
            document.getElementById(inputId).value = "";
            const previewContainer = document.getElementById(previewId);
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (e) {
                    let valid = true;
                    let errorMessage = "";

                    const pwd = document.getElementById('password').value;
                    const pwdRegex = /^(?=.*[A-Za-z])(?=.*\d).{8,}$/;
                    if (pwd && !pwdRegex.test(pwd)) {
                        errorMessage += "- Le mot de passe doit comporter au moins 8 caractères, incluant au moins une lettre et un chiffre.\n";
                        valid = false;
                    }

                    const birthDateInput = document.querySelector('input[name="birth_date"]').value;
                    if (birthDateInput) {
                        const birthDate = new Date(birthDateInput);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        if (birthDate > today) {
                            errorMessage += "- La date de naissance ne peut pas être dans le futur.\n";
                            valid = false;
                        }
                    }

                    if (!valid) {
                        e.preventDefault();
                        alert("Veuillez corriger les erreurs suivantes :\n\n" + errorMessage);
                    }
                });
            }
        });
    </script>
@endsection