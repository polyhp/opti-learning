@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-navy-900 text-orange-500 rounded-2xl flex items-center justify-center text-3xl shadow-lg mb-6">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h2 class="mt-6 text-3xl font-head font-extrabold text-navy-900">
                Vérification de Certificat
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                Système d'authentification OptiLearning
            </p>
        </div>

        @if($certificate)
        <div class="bg-white rounded-2xl shadow-xl border border-emerald-100 overflow-hidden transform transition-all hover:-translate-y-1 duration-300">
            <div class="bg-emerald-500 px-6 py-4 flex items-center justify-center space-x-3">
                <i class="fas fa-check-circle text-white text-2xl"></i>
                <h3 class="text-white font-bold text-lg">Certificat Valide</h3>
            </div>
            
            <div class="p-8">
                <div class="text-center mb-6">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Décerné à</p>
                    <p class="text-2xl font-head font-bold text-navy-900 mt-1">{{ $certificate->user->first_name }} {{ $certificate->user->last_name }}</p>
                </div>
                
                <div class="border-t border-b border-slate-100 py-4 my-4">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide text-center">Pour la formation</p>
                    <p class="text-lg font-medium text-orange-600 text-center mt-1">{{ $certificate->course->title }}</p>
                </div>
                
                <dl class="grid grid-cols-2 gap-x-4 gap-y-6 text-sm">
                    <div>
                        <dt class="font-medium text-slate-500">Formateur</dt>
                        <dd class="mt-1 text-slate-900">{{ $certificate->course->formateur->user->first_name }} {{ $certificate->course->formateur->user->last_name }}</dd>
                    </div>
                    <div>
                        <dt class="font-medium text-slate-500">Date de délivrance</dt>
                        <dd class="mt-1 text-slate-900">{{ \Carbon\Carbon::parse($certificate->issued_at)->format('d/m/Y') }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="font-medium text-slate-500">Numéro d'authentification</dt>
                        <dd class="mt-1 font-mono text-slate-900 bg-slate-50 p-2 rounded border border-slate-200 text-center">{{ $certificate->certificate_code }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-center">
                <a href="{{ route('home') }}" class="text-navy-600 hover:text-orange-500 font-medium text-sm transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
                </a>
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-xl border border-red-100 overflow-hidden transform transition-all hover:-translate-y-1 duration-300">
            <div class="bg-red-500 px-6 py-4 flex items-center justify-center space-x-3">
                <i class="fas fa-times-circle text-white text-2xl"></i>
                <h3 class="text-white font-bold text-lg">Certificat Invalide</h3>
            </div>
            
            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-3xl text-red-400"></i>
                </div>
                <h4 class="text-xl font-bold text-navy-900 mb-2">Code introuvable</h4>
                <p class="text-slate-500">Le code <strong class="text-slate-700">{{ $code }}</strong> n'existe pas dans notre base de données. Ce certificat a pu être falsifié.</p>
            </div>
            
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex justify-center">
                <a href="{{ route('home') }}" class="text-navy-600 hover:text-orange-500 font-medium text-sm transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
