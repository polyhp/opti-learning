import os

pdf_cert_content = """<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat - {{ $course->title }}</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { margin: 0; padding: 0; font-family: 'Helvetica', 'Arial', sans-serif; background: #ffffff; color: #1e293b; }
        .certificate-container {
            width: 297mm; height: 210mm;
            position: relative;
            box-sizing: border-box;
            padding: 20mm;
            background: #fff;
        }
        .outer-border { border: 4px solid #F97316; position: absolute; top: 10mm; left: 10mm; right: 10mm; bottom: 10mm; }
        .inner-border { border: 2px solid #0B1A3E; position: absolute; top: 13mm; left: 13mm; right: 13mm; bottom: 13mm; }
        
        .content {
            position: relative; z-index: 10;
            text-align: center;
            height: 100%;
        }
        .header { display: table; width: 100%; margin-bottom: 20px; }
        .header-logo { height: 60px; object-fit: contain; }
        .title { font-family: 'Georgia', serif; font-size: 52px; font-weight: bold; color: #0B1A3E; letter-spacing: 4px; text-transform: uppercase; margin-top: 10px; margin-bottom: 5px; }
        .subtitle { font-size: 16px; color: #F97316; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 30px; font-weight: bold; }
        .presented-to { font-size: 18px; color: #64748B; margin-bottom: 10px; font-style: italic; }
        .name { font-family: 'Georgia', serif; font-size: 48px; font-weight: bold; color: #0F172A; text-decoration: underline; text-decoration-color: #F97316; margin-bottom: 20px; }
        .reason { font-size: 16px; color: #475569; max-width: 700px; margin: 0 auto 20px auto; line-height: 1.5; }
        .course-title-box { display: inline-block; padding: 10px 30px; border-left: 4px solid #F97316; border-right: 4px solid #F97316; background: #f8fafc; font-size: 24px; font-weight: bold; color: #0B1A3E; margin-bottom: 30px; }
        
        .footer { position: absolute; bottom: 20px; left: 0; right: 0; width: 100%; padding: 0 40px; box-sizing: border-box; }
        .signature-table { width: 100%; table-layout: fixed; }
        .signature-table td { text-align: center; vertical-align: bottom; }
        .sig-line { border-bottom: 1px solid #0B1A3E; width: 220px; margin: 0 auto 10px auto; }
        .sig-name { font-weight: bold; font-size: 14px; color: #0B1A3E; }
        .sig-title { font-size: 12px; color: #F97316; font-weight: bold; }
        
        .badge { display: inline-block; padding: 8px 25px; background: #0B1A3E; color: #fff; border-radius: 50px; font-weight: bold; font-size: 16px; margin-bottom: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .badge span { color: #F97316; }
        
        .verify-info { position: absolute; bottom: 0; right: 40px; text-align: right; font-size: 10px; color: #64748b; line-height: 1.4; }
        .verify-info strong { color: #334155; }
        .qr-code { position: absolute; bottom: 0; left: 40px; border: 1px solid #e2e8f0; padding: 5px; background: #fff; border-radius: 5px; }
        .qr-code img { width: 65px; height: 65px; display: block; }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="outer-border"></div>
        <div class="inner-border"></div>
        
        <div class="content">
            <div style="margin-top: 10px;">
                @php
                    $logoPath = public_path('images/logo.jpg');
                    if(file_exists($logoPath)) {
                        $logoData = base64_encode(file_get_contents($logoPath));
                        echo '<img src="data:image/jpeg;base64,'.$logoData.'" class="header-logo" alt="OptiLearning">';
                    } else {
                        echo '<div style="font-size: 28px; font-weight: 800; color: #0B1A3E; font-family: \'Georgia\', serif; letter-spacing: 2px;">OPTI<span style="color:#F97316;">LEARNING</span></div>';
                    }
                @endphp
            </div>
            
            <div class="title">CERTIFICAT</div>
            <div class="subtitle">DE RÉUSSITE</div>
            
            <div class="presented-to">Ce certificat est fièrement décerné à</div>
            
            <div class="name">{{ $user->first_name }} {{ $user->last_name }}</div>
            
            <div class="reason">
                Pour avoir suivi avec succès l'intégralité du programme d'apprentissage et satisfait à toutes les exigences de la formation certifiante :
            </div>
            
            <div>
                <div class="course-title-box">{{ $course->title }}</div>
            </div>
            
            @if(isset($score))
            <div>
                <div class="badge">
                    Note Finale : <span>{{ $score }}</span> / 20
                </div>
            </div>
            @endif
            
            <div class="footer">
                <div class="qr-code">
                    <img src="data:image/svg+xml;base64,{{ $qrcode }}" alt="QR Code">
                </div>
                <div class="verify-info">
                    <strong>Réf.</strong> {{ $certificate->certificate_code }}<br>
                    <strong>Délivré le</strong> {{ \Carbon\Carbon::parse($certificate->issued_at)->format('d/m/Y') }}<br>
                    <strong>Vérification:</strong> Scannez le QR code
                </div>
                <table class="signature-table">
                    <tr>
                        <td>
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ mb_strtoupper($course->formateur->user->first_name . ' ' . $course->formateur->user->last_name) }}</div>
                            <div class="sig-title">Formateur Expert</div>
                        </td>
                        <td>
                            <div style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #F97316; margin: 0 auto 15px auto; line-height: 80px; color: #F97316; font-size: 40px; background: white; text-align: center;">
                                &#9733;
                            </div>
                        </td>
                        <td>
                            <div class="sig-line"></div>
                            <div class="sig-name">DIRECTION OPTILEARNING</div>
                            <div class="sig-title">Certification Officielle</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>"""

dashboard_content = """@extends('layouts.apprenant')

@section('title', 'Mon Parcours Apprenant - OptiLearning')

@section('content')
    <div class="w-full flex flex-col space-y-8">

        <!-- Top Actions & Search -->
        <div class="flex flex-col md:flex-row justify-between items-center bg-white p-4 rounded-2xl shadow-sm border-2 border-slate-200 gap-4">
            <!-- Search bar -->
            <form action="{{ route('apprenant.catalog') }}" method="GET" class="relative w-full md:w-1/2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input type="text" name="search"
                    class="block w-full pl-11 pr-4 py-3 bg-white border-2 border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all outline-none" placeholder="Rechercher dans le catalogue...">
            </form>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
                <button onclick="document.getElementById('profileModal').classList.remove('hidden')"
                    class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-navy-50 text-navy-700 hover:bg-navy-100 border-2 border-navy-200 px-5 py-3 rounded-xl font-medium transition-colors">
                    <i class="fas fa-user-cog"></i>
                    <span>Gestion Profil</span>
                </button>
                <a href="{{ route('apprenant.catalog') }}"
                    class="flex-1 md:flex-none flex items-center justify-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-compass"></i>
                    <span>Explorer le catalogue</span>
                </a>
            </div>
        </div>

        <!-- Mes Formations Actuelles -->
        <div class="bg-white rounded-2xl shadow-sm border-2 border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b-2 border-slate-200 flex justify-between items-center bg-slate-50/50">
                <h2 class="font-head text-lg font-bold text-navy-900"><i
                        class="fas fa-book-reader mr-2 text-orange-500"></i>Mes Formations en cours</h2>
            </div>

            <div class="p-6">
                @if($enrolledCourses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($enrolledCourses as $course)
                            <div class="bg-white border-2 border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl hover:border-orange-300 transition-all duration-300 group flex flex-col h-full relative">
                                <!-- Image Container -->
                                <div class="h-40 overflow-hidden relative bg-slate-100 border-b border-slate-200">
                                    @if($course->thumbnail)
                                        <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy-50 text-navy-200">
                                            <i class="fas fa-laptop-code text-4xl"></i>
                                        </div>
                                    @endif
                                    <!-- Overlay Date -->
                                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-navy-800 text-xs font-bold px-2 py-1 rounded-lg border border-slate-200">
                                        Inscrit le {{ $course->order_date->format('d/m/Y') }}
                                    </div>
                                </div>

                                <!-- Content Container -->
                                <div class="p-5 flex-grow flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-head font-bold text-lg text-navy-900 mb-1 line-clamp-2 leading-tight group-hover:text-orange-500 transition-colors">
                                            {{ $course->title }}
                                        </h3>
                                        <p class="text-sm text-slate-500 mb-4 flex items-center">
                                            <i class="fas fa-chalkboard-teacher mr-2 text-slate-400"></i>
                                            {{ $course->formateur->user->first_name }} {{ $course->formateur->user->last_name }}
                                        </p>
                                    </div>

                                    <!-- Progression & Stats -->
                                    <div class="space-y-4">
                                        <!-- Progress Bar -->
                                        <div>
                                            <div class="flex justify-between items-center text-xs mb-1">
                                                <span class="font-medium text-slate-600">Progrès des leçons</span>
                                                <span class="font-bold {{ $course->custom_progress == 100 ? 'text-emerald-500' : 'text-orange-500' }}">{{ $course->custom_progress }}%</span>
                                            </div>
                                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200">
                                                <div class="h-full {{ $course->custom_progress == 100 ? 'bg-emerald-500' : 'bg-gradient-to-r from-orange-400 to-orange-500' }} rounded-full"
                                                    style="width: {{ $course->custom_progress }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Quiz Note -->
                                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border-2 border-slate-200">
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-clipboard-check {{ $course->custom_passed ? 'text-emerald-500' : 'text-slate-400' }}"></i>
                                                <span class="text-xs font-semibold text-slate-600">Note Finale</span>
                                            </div>
                                            @if(!is_null($course->custom_score))
                                                <span class="font-head font-bold text-sm {{ $course->custom_passed ? 'text-emerald-600' : 'text-red-500' }}">{{ $course->custom_score }}/20</span>
                                            @else
                                                <span class="text-xs text-orange-500 font-medium">À passer</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Footer -->
                                <div class="p-4 border-t-2 border-slate-200 bg-slate-50/50 flex justify-between items-center gap-2">
                                    <a href="{{ route('apprenant.courses.watch', $course->id) }}"
                                        class="flex-grow text-center bg-navy-900 hover:bg-navy-800 text-white text-sm font-medium py-2.5 rounded-xl transition-colors">
                                        {{ $course->custom_progress == 100 ? 'Réviser' : 'Continuer' }}
                                    </a>

                                    @if($course->can_download_certificate)
                                        <a href="{{ route('apprenant.certificate.download', $course->id) }}"
                                            class="flex-none bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-700 p-2.5 rounded-xl transition-colors border border-emerald-200"
                                            title="Télécharger le certificat PDF">
                                            <i class="fas fa-award text-lg"></i>
                                        </a>
                                    @else
                                        <button disabled
                                            class="flex-none bg-slate-100 text-slate-300 p-2.5 rounded-xl cursor-not-allowed border border-slate-200"
                                            title="Le certificat n'est pas encore débloqué">
                                            <i class="fas fa-lock text-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-4xl mb-4 border-2 border-slate-200">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3 class="text-lg font-bold text-navy-900 mb-2">Aucune formation en cours</h3>
                        <p class="text-slate-500 max-w-md mx-auto mb-6">Vous ne participez à aucune formation pour le moment.
                            Explorez notre catalogue pour commencer votre apprentissage !</p>
                        <a href="{{ route('apprenant.catalog') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-medium transition-colors border border-orange-600">
                            Découvrir les formations
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Nouvelles Propositions de Formations -->
        @if($suggestedCourses->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border-2 border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b-2 border-slate-200 bg-slate-50/50 flex justify-between items-center">
                    <h2 class="font-head text-lg font-bold text-navy-900"><i class="fas fa-star text-orange-500 mr-2"></i>Nos
                        recommandations pour vous</h2>
                    <a href="{{ route('apprenant.catalog') }}"
                        class="text-sm font-medium text-orange-600 hover:text-orange-700 transition-colors">Voir tout &rarr;</a>
                </div>

                <div class="p-6">
                    <!-- Scrollable Container -->
                    <div class="flex overflow-x-auto space-x-6 pb-4 snap-x snap-mandatory hide-scrollbar">
                        @foreach($suggestedCourses as $suggestion)
                            <div class="snap-start flex-none w-72 bg-white border-2 border-slate-200 rounded-2xl overflow-hidden hover:shadow-xl hover:border-orange-300 transition-all group">
                                <div class="h-36 relative overflow-hidden bg-slate-100 border-b border-slate-200">
                                    @if($suggestion->thumbnail)
                                        <img src="{{ asset($suggestion->thumbnail) }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy-50 text-navy-200">
                                            <i class="fas fa-video text-3xl"></i>
                                        </div>
                                    @endif
                                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur text-orange-600 border border-slate-200 text-xs font-bold px-2 py-1 rounded">
                                        {{ number_format($suggestion->price, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                                <div class="p-4 bg-slate-50/30">
                                    <h3 class="font-head font-bold text-navy-900 text-sm mb-1 line-clamp-2 min-h-[40px] group-hover:text-orange-500 transition-colors">
                                        {{ $suggestion->title }}
                                    </h3>
                                    <p class="text-xs text-slate-500 mb-3"><i class="fas fa-user-circle mr-1"></i>
                                        {{ $suggestion->formateur->user->first_name }}</p>
                                    <a href="{{ route('courses.show', $suggestion->id) }}"
                                        class="block w-full text-center py-2 bg-navy-50 text-navy-700 border border-navy-200 text-xs font-bold rounded-lg hover:bg-orange-500 hover:border-orange-500 hover:text-white transition-all">En
                                        savoir plus</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <style>
                        .hide-scrollbar::-webkit-scrollbar {
                            display: none;
                        }

                        .hide-scrollbar {
                            -ms-overflow-style: none;
                            scrollbar-width: none;
                        }
                    </style>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Profile (Tailwind) -->
    <div id="profileModal" class="fixed inset-0 z-[100] hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-navy-900/60 backdrop-blur-sm"
            onclick="document.getElementById('profileModal').classList.add('hidden')"></div>

        <!-- Modal Panel -->
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-3xl shadow-2xl border-2 border-slate-200 p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-head font-bold text-navy-900">Mon Profil</h2>
                <button onclick="document.getElementById('profileModal').classList.add('hidden')"
                    class="w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center hover:bg-slate-200 border border-slate-300 transition-colors"><i
                        class="fas fa-times"></i></button>
            </div>

            <form action="{{ route('apprenant.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Prénom</label>
                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}" required
                        class="w-full px-4 py-2 bg-white border-2 border-slate-300 text-navy-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nom</label>
                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}" required
                        class="w-full px-4 py-2 bg-white border-2 border-slate-300 text-navy-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition-all">
                </div>

                <hr class="border-slate-200">

                <div>
                    <h3 class="text-md font-bold text-navy-900 mb-3">Sécurité</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Mot de passe actuel (si modification)</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-2 bg-white border-2 border-slate-300 text-navy-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password"
                                class="w-full px-4 py-2 bg-white border-2 border-slate-300 text-navy-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Confirmer mot de passe</label>
                            <input type="password" name="new_password_confirmation"
                                class="w-full px-4 py-2 bg-white border-2 border-slate-300 text-navy-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-navy-900 hover:bg-navy-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg shadow-navy-900/20 transition-all border border-navy-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection"""

with open("/home/polyhp7/opti-learning/resources/views/pdf/certificate.blade.php", "w") as f:
    f.write(pdf_cert_content)

with open("/home/polyhp7/opti-learning/resources/views/apprenant/dashboard.blade.php", "w") as f:
    f.write(dashboard_content)

print("Updates applied successfully.")
