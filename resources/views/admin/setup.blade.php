@extends('layouts.app')

@section('content')
    <style>
        :root {
            --navy: #0A2647;
            --navy-dark: #061e3a;
            --navy-light: #1a3a5f;
            --orange: #FF6B35;
            --orange-dark: #e55a2b;
            --orange-light: #ff8a5e;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --red-500: #ef4444;
        }

        .setup-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .setup-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .setup-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .setup-subtitle {
            color: var(--gray-600);
            font-size: 0.95rem;
        }

        .setup-card {
            background: var(--white);
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.01);
            border: 1px solid var(--gray-200);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .setup-card:hover {
            box-shadow: 0 25px 30px -12px rgba(0, 0, 0, 0.15);
        }

        .setup-card-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            padding: 1.25rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .setup-card-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, transparent 0%, rgba(255, 107, 53, 0.1) 100%);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        .setup-card-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .setup-icon-box {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .setup-icon-box i {
            font-size: 1.5rem;
            color: var(--white);
        }

        .setup-card-header-text h2 {
            color: var(--white);
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
        }

        .setup-card-header-text p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
        }

        .setup-card-body {
            padding: 2rem;
        }

        .setup-form-group {
            margin-bottom: 1.5rem;
        }

        .setup-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .setup-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .setup-label i {
            color: var(--orange);
            font-size: 0.75rem;
            margin-right: 0.25rem;
        }

        .setup-label .required {
            color: var(--orange);
            margin-left: 0.125rem;
        }

        .setup-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: var(--white);
            color: var(--gray-700);
        }

        .setup-input:focus {
            outline: none;
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .setup-input.error {
            border-color: var(--red-500);
        }

        .setup-error {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: var(--red-500);
            font-weight: 500;
        }

        .setup-security-note {
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .setup-security-note i {
            color: var(--orange);
            font-size: 0.75rem;
        }

        .setup-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1.5rem;
            margin-top: 0.5rem;
            border-top: 1px solid var(--gray-200);
        }

        .setup-info-text {
            font-size: 0.75rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .setup-info-text i {
            color: var(--orange);
            font-size: 0.75rem;
        }

        .setup-btn-submit {
            background: var(--navy);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .setup-btn-submit:hover {
            background: var(--orange);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .setup-btn-submit:active {
            transform: translateY(0);
        }

        .setup-btn-submit i {
            font-size: 0.75rem;
            transition: transform 0.2s ease;
        }

        .setup-btn-submit:hover i {
            transform: translateX(4px);
        }

        @media (max-width: 640px) {
            .setup-form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .setup-card-body {
                padding: 1.5rem;
            }

            .setup-card-header {
                padding: 1rem 1.5rem;
            }

            .setup-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
                text-align: center;
            }

            .setup-info-text {
                justify-content: center;
            }

            .setup-btn-submit {
                justify-content: center;
            }
        }

        /* Animation pour les champs */
        .setup-input:not(.error):valid {
            border-color: var(--gray-300);
        }
    </style>

    <div class="setup-container">
        <div class="setup-header">
            <h1 class="setup-title">Configuration du compte</h1>
            <p class="setup-subtitle">
                Bienvenue {{ $user->first_name }}, finalisez la configuration de votre compte avec les privilèges d'administration.
            </p>
        </div>

        <div class="setup-card">
            <div class="setup-card-header">
                <div class="setup-card-header-content">
                    <div class="setup-icon-box">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="setup-card-header-text">
                        <h2>Informations personnelles</h2>
                        <p>Veuillez compléter votre profil administrateur</p>
                    </div>
                </div>
            </div>

            <div class="setup-card-body">
                <form action="{{ request()->fullUrl() }}" method="POST">
                    @csrf

                    <div class="setup-form-row">
                        <!-- Prénom -->
                        <div class="setup-form-group">
                            <label for="first_name" class="setup-label">
                                <i class="fas fa-user"></i> Prénom <span class="required">*</span>
                            </label>
                            <input id="first_name" name="first_name" type="text" required 
                                   value="{{ old('first_name', $user->first_name) }}" 
                                   class="setup-input @error('first_name') error @enderror">
                            @error('first_name')
                                <div class="setup-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div class="setup-form-group">
                            <label for="last_name" class="setup-label">
                                <i class="fas fa-user-edit"></i> Nom <span class="required">*</span>
                            </label>
                            <input id="last_name" name="last_name" type="text" required 
                                   value="{{ old('last_name', $user->last_name) }}" 
                                   class="setup-input @error('last_name') error @enderror">
                            @error('last_name')
                                <div class="setup-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="setup-form-row">
                        <!-- Mot de passe -->
                        <div class="setup-form-group">
                            <label for="password" class="setup-label">
                                <i class="fas fa-lock"></i> Mot de passe <span class="required">*</span>
                            </label>
                            <input id="password" name="password" type="password" required 
                                   class="setup-input @error('password') error @enderror">
                            @error('password')
                                <div class="setup-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmation Mot de passe -->
                        <div class="setup-form-group">
                            <label for="password_confirmation" class="setup-label">
                                <i class="fas fa-lock"></i> Confirmez <span class="required">*</span>
                            </label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                   class="setup-input">
                        </div>
                    </div>

                    <div class="setup-form-row">
                        <!-- Date de naissance -->
                        <div class="setup-form-group">
                            <label for="birth_date" class="setup-label">
                                <i class="fas fa-calendar-alt"></i> Date de naissance <span class="required">*</span>
                            </label>
                            <input id="birth_date" name="birth_date" type="date" required 
                                   value="{{ old('birth_date') }}" max="{{ date('Y-m-d') }}"
                                   class="setup-input @error('birth_date') error @enderror">
                            @error('birth_date')
                                <div class="setup-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Numéro de téléphone -->
                        <div class="setup-form-group">
                            <label for="phone" class="setup-label">
                                <i class="fas fa-phone"></i> Téléphone <span class="required">*</span>
                            </label>
                            <input id="phone" name="phone" type="tel" required 
                                   value="{{ old('phone') }}" placeholder="+229 00000000"
                                   class="setup-input @error('phone') error @enderror">
                            @error('phone')
                                <div class="setup-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Lieu de résidence -->
                    <div class="setup-form-group">
                        <label for="residence" class="setup-label">
                            <i class="fas fa-map-marker-alt"></i> Lieu de résidence <span class="required">*</span>
                        </label>
                        <input id="residence" name="residence" type="text" required 
                               value="{{ old('residence') }}" placeholder="Cotonou, Bénin..."
                               class="setup-input @error('residence') error @enderror">

                        <div class="setup-security-note">
                            <i class="fas fa-shield-alt"></i>
                            <span>Vos informations sont chiffrées et sécurisées.</span>
                        </div>

                        @error('residence')
                            <div class="setup-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="setup-footer">
                        <div class="setup-info-text">
                            <i class="fas fa-info-circle"></i>
                            <span>Tous les champs sont obligatoires</span>
                        </div>
                        <button type="submit" class="setup-btn-submit">
                            Activer mon compte
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection