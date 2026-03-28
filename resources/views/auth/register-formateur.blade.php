@extends('layouts.app')

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
                    <div class="bg-white/20 px-4 py-2 rounded-lg">
                        <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('register.formateur') }}" enctype="multipart/form-data" class="p-6 md:p-10 space-y-6">
                @csrf
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prénom <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sexe <span class="text-red-500">*</span></label>
                        <select name="gender" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <option value="">Sélectionnez</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de naissance <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('birth_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lieu de naissance <span class="text-red-500">*</span></label>
                    <input type="text" name="birth_place" value="{{ old('birth_place') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    @error('birth_place')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Domaine de formation <span class="text-red-500">*</span></label>
                    <input type="text" name="expertise_domain" value="{{ old('expertise_domain') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="ex: Développement Web, Marketing Digital, Design...">
                    @error('expertise_domain')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Documents justificatifs</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Diplôme <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer" onclick="document.getElementById('diploma').click()">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                        </div>
                        <input type="file" name="diploma_file" id="diploma" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        @error('diploma_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Carte d'identité <span class="text-red-500">*</span></label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer" onclick="document.getElementById('id_card').click()">
                            <i class="fas fa-id-card text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                        </div>
                        <input type="file" name="id_card_file" id="id_card" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        @error('id_card_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Certificat (Optionnel)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-orange-500 transition cursor-pointer" onclick="document.getElementById('certificate').click()">
                            <i class="fas fa-certificate text-3xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600">Cliquez pour télécharger (PDF, JPG, PNG max 5Mo)</p>
                        </div>
                        <input type="file" name="certificate_file" id="certificate" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                        @error('certificate_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe <span class="text-red-500">*</span></label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer mot de passe <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-orange-500 rounded">
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        J'accepte les <a href="#" class="text-orange-500 hover:text-orange-600">conditions générales</a> et je certifie l'authenticité des documents fournis
                    </label>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-4 rounded-lg hover:from-orange-600 hover:to-orange-700 transition transform hover:scale-[1.02] shadow-lg">
                    <i class="fas fa-chalkboard-teacher mr-2"></i>Devenir Formateur
                </button>
            </form>
        </div>
    </div>
</div>
@endsection