<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OptiLearning – Plateforme de Formation en Ligne</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link <link
    href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
    rel="stylesheet">

  <!-- Intégration Tailwind et FontAwesome pour les composants partagés -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            navy: {
              800: '#1d3566',
              900: '#0B1A3E',
            }
          }
        }
      }
    }
  </script>
  <style>
    /* ============================
   VARIABLES & RESET - COULEURS BLEU NUIT / ORANGE
   ============================ */
    :root {
      --navy: #0B1A3E;
      --navy-mid: #122255;
      --navy-light: #1A3070;
      --navy-dark: #060E24;
      --navy-soft: #1a2a5a;
      --orange: #F97316;
      --orange-lt: #FB923C;
      --orange-dark: #EA580C;
      --orange-pale: #FFF0E6;
      --white: #FFFFFF;
      --gray-bg: #F8FAFE;
      --gray-border: #E9EDF4;
      --gray-text: #6B7A99;
      --shadow-sm: 0 2px 8px rgba(11, 26, 62, 0.06);
      --shadow-md: 0 8px 24px rgba(11, 26, 62, 0.10);
      --shadow-lg: 0 16px 40px rgba(11, 26, 62, 0.15);
      --shadow-xl: 0 24px 56px rgba(11, 26, 62, 0.20);
      --shadow-hover: 0 20px 40px rgba(11, 26, 62, 0.18);
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
      --radius-xl: 24px;
      --transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
      --transition-fast: all 0.2s ease;
    }

    *,
    *::before,
    *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      max-width: 100%;
      overflow-x: hidden;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--white);
      color: var(--navy);
      line-height: 1.5;
    }

    img {
      max-width: 100%;
      display: block;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    button {
      cursor: pointer;
      font-family: inherit;
    }

    /* ============================
   UTILITIES
   ============================ */
    .container {
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
    }

    @media (max-width: 768px) {
      .container {
        padding: 0 16px;
      }
    }

    .section-tag {
      display: inline-block;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--orange);
      background: var(--orange-pale);
      padding: 5px 14px;
      border-radius: 30px;
      margin-bottom: 16px;
    }

    .section-title {
      font-weight: 800;
      font-size: clamp(28px, 4vw, 38px);
      color: var(--navy);
      line-height: 1.2;
      letter-spacing: -0.02em;
      text-align: center;
    }

    .section-title .accent {
      color: var(--orange);
    }

    .section-sub {
      font-size: 16px;
      color: var(--gray-text);
      text-align: center;
      margin-top: 8px;
    }

    .section-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      margin-bottom: 40px;
      gap: 16px;
      text-align: center;
    }

    .see-all {
      font-size: 14px;
      font-weight: 600;
      color: var(--orange);
      transition: var(--transition-fast);
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .see-all:hover {
      gap: 10px;
      color: var(--orange-dark);
    }

    /* ============================
   HERO SECTION
   ============================ */
    .hero-section {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
      padding: 60px 0 80px;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(circle at 20% 80%, rgba(249, 115, 22, 0.12) 0%, transparent 60%);
      pointer-events: none;
    }

    .hero-section::after {
      content: '';
      position: absolute;
      top: -50%;
      right: -20%;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(249, 115, 22, 0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .hero-content {
      text-align: center;
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 1;
    }

    .hero-content h1 {
      font-size: clamp(32px, 5vw, 52px);
      font-weight: 800;
      color: var(--white);
      line-height: 1.2;
      margin-bottom: 16px;
      letter-spacing: -0.02em;
    }

    .hero-content .highlight {
      color: var(--orange);
    }

    .hero-content p {
      font-size: 18px;
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 40px;
    }

    /* Barre de recherche mobile (en bas de l'écran) */
    .mobile-search-bar {
      display: none;
      position: relative;
      background: var(--navy);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding: 12px 16px;
      z-index: 100;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.2);
    }

    .mobile-search-form {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .mobile-search-input {
      flex: 1;
      padding: 12px 16px;
      border-radius: var(--radius-md);
      border: 1px solid rgba(255, 255, 255, 0.2);
      background: rgba(255, 255, 255, 0.1);
      color: var(--white);
      font-size: 14px;
      outline: none;
    }

    .mobile-search-input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    .mobile-search-input:focus {
      border-color: var(--orange);
    }

    .mobile-search-btn {
      background: var(--orange);
      border: none;
      padding: 12px 20px;
      border-radius: var(--radius-md);
      color: white;
      font-weight: 600;
      cursor: pointer;
      white-space: nowrap;
    }

    @media (max-width: 1024px) {
      .mobile-search-bar {
        display: block;
      }

      body {
        padding-bottom: 70px;
      }
    }

    /* ============================
   COURSE CARDS - ANIMATION FLUIDE
   ============================ */
    .courses-section {
      padding: 60px 0;
      background: var(--white);
    }

    .courses-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 28px;
    }

    @media (max-width: 1100px) {
      .courses-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 768px) {
      .courses-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
      }
    }

    @media (max-width: 480px) {
      .courses-grid {
        grid-template-columns: 1fr;
      }
    }

    .course-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      border: 2px solid #0B1A3E;
      overflow: hidden;
      transition: var(--transition);
      position: relative;
    }

    .course-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-hover);
      border-color: var(--orange-pale);
      border: 4px solid #0B1A3E;

    }

    .card-thumb {
      height: 180px;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
    }

    .card-thumb img,
    .card-thumb video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .course-card:hover .card-thumb img {
      transform: scale(1.08);
    }

    .card-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(249, 115, 22, 0.9), rgba(249, 115, 22, 0.2));
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: all 0.4s ease;
      z-index: 5;
    }

    .card-overlay-btn {
      background: var(--white);
      color: var(--orange);
      padding: 10px 24px;
      border-radius: 30px;
      font-weight: 700;
      font-size: 14px;
      transform: translateY(20px);
      transition: all 0.4s ease;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .course-card:hover .card-overlay,
    .mini-card:hover .card-overlay {
      opacity: 1;
    }

    .course-card:hover .card-overlay-btn,
    .mini-card:hover .card-overlay-btn {
      transform: translateY(0);
    }

    .card-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      z-index: 2;
      font-size: 11px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      background: var(--orange);
      color: white;
      letter-spacing: 0.5px;
    }

    .card-body {
      padding: 20px;
    }

    .card-cat {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--orange);
      margin-bottom: 8px;
      letter-spacing: 0.8px;
    }

    .card-title {
      font-weight: 700;
      font-size: 16px;
      color: var(--navy);
      line-height: 1.4;
      margin-bottom: 10px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .card-instructor {
      font-size: 12px;
      color: var(--gray-text);
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .instructor-dot {
      width: 5px;
      height: 5px;
      background: var(--orange);
      border-radius: 50%;
    }

    .card-meta {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 12px;
      color: var(--gray-text);
      margin-bottom: 16px;
    }

    .card-divider {
      height: 1px;
      background: var(--gray-border);
      margin-bottom: 16px;
    }

    .card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .price-new {
      font-weight: 800;
      font-size: 20px;
      color: var(--orange);
    }

    .btn-voir {
      background: var(--navy);
      color: var(--white);
      border: none;
      padding: 8px 18px;
      border-radius: var(--radius-sm);
      font-size: 13px;
      font-weight: 600;
      transition: var(--transition-fast);
      cursor: pointer;
    }

    .btn-voir:hover {
      background: var(--orange);
      transform: scale(1.02);
    }

    /* Mini cards pour populaires */
    .mini-card {
      background: var(--white);
      border-radius: var(--radius-md);
      border: 1px solid var(--gray-border);
      overflow: hidden;
      transition: var(--transition);
      position: relative;
    }

    .mini-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
      border-color: var(--orange-pale);
    }

    .mini-thumb {
      height: 130px;
      overflow: hidden;
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
    }

    .mini-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .mini-card:hover .mini-thumb img {
      transform: scale(1.06);
    }

    .mini-body {
      padding: 16px;
    }

    .mini-cat {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--orange);
      margin-bottom: 6px;
      letter-spacing: 0.6px;
    }

    .mini-title {
      font-weight: 600;
      font-size: 14px;
      color: var(--navy);
      line-height: 1.4;
      margin-bottom: 12px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .mini-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .mini-price {
      font-weight: 800;
      font-size: 16px;
      color: var(--orange);
    }

    .mini-stats {
      font-size: 11px;
      color: var(--gray-text);
    }

    /* ============================
   CATEGORIES
   ============================ */
    .categories-section {
      padding: 60px 0;
      background: var(--gray-bg);
    }

    .categories-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 20px;
    }

    @media (max-width: 1000px) {
      .categories-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 640px) {
      .categories-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .cat-card {
      background: var(--white);
      border-radius: var(--radius-lg);
      padding: 24px 16px;
      text-align: center;
      border: 1px solid var(--gray-border);
      transition: var(--transition);
      cursor: pointer;
    }

    .cat-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
      border-color: var(--orange);
    }

    .cat-icon {
      width: 56px;
      height: 56px;
      margin: 0 auto 16px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--orange-pale);
    }

    .cat-icon svg {
      width: 28px;
      height: 28px;
    }

    .cat-name {
      font-weight: 700;
      font-size: 14px;
      color: var(--navy);
      margin-bottom: 4px;
      overflow-wrap: break-word;
      word-wrap: break-word;
      hyphens: auto;
    }

    .cat-count {
      font-size: 12px;
      color: var(--gray-text);
    }

    /* ============================
   STATS SECTION
   ============================ */
    .stats-section {
      background: var(--navy);
      padding: 70px 0;
      position: relative;
      overflow: hidden;
    }

    .stats-section::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(249, 115, 22, 0.08) 0%, transparent 70%);
    }

    .stats-inner {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      position: relative;
      z-index: 1;
    }

    @media (max-width: 768px) {
      .stats-inner {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
      }
    }

    .stats-text h2 {
      font-size: clamp(28px, 4vw, 36px);
      font-weight: 800;
      color: var(--white);
      margin-bottom: 16px;
    }

    .stats-text h2 .accent {
      color: var(--orange);
    }

    .stats-text p {
      color: rgba(255, 255, 255, 0.6);
      margin-bottom: 28px;
      line-height: 1.6;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
      color: rgba(255, 255, 255, 0.75);
      font-size: 14px;
    }

    @media (max-width: 768px) {
      .feature-item {
        justify-content: center;
      }
    }

    .feature-check {
      width: 20px;
      height: 20px;
      background: rgba(249, 115, 22, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .feature-check svg {
      width: 12px;
      height: 12px;
      stroke: var(--orange);
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-lg);
      padding: 28px 20px;
      text-align: center;
      transition: var(--transition-fast);
    }

    .stat-card:hover {
      background: rgba(249, 115, 22, 0.1);
      border-color: rgba(249, 115, 22, 0.3);
    }

    .stat-num {
      font-size: 36px;
      font-weight: 800;
      color: var(--orange);
      display: block;
      margin-bottom: 8px;
    }

    .stat-label {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.55);
    }

    /* ============================
   FOOTER
   ============================ */
    footer {
      background: var(--navy-dark);
      padding: 50px 0 24px;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.5fr;
      gap: 48px;
      padding-bottom: 40px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 768px) {
      .footer-grid {
        grid-template-columns: 1fr;
        gap: 32px;
      }
    }

    .footer-logo-wrap {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .footer-logo-text {
      font-weight: 800;
      font-size: 20px;
      color: var(--white);
    }

    .footer-logo-text span {
      color: var(--orange);
    }

    .footer-desc {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.45);
      line-height: 1.6;
      margin-bottom: 20px;
      max-width: 280px;
    }

    .payment-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 24px;
    }

    .pay-badge {
      background: rgba(255, 255, 255, 0.06);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 6px;
      padding: 5px 12px;
      font-size: 11px;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.6);
    }

    .social-links {
      display: flex;
      gap: 10px;
    }

    .social-btn {
      width: 36px;
      height: 36px;
      border-radius: var(--radius-sm);
      border: 1px solid rgba(255, 255, 255, 0.12);
      background: transparent;
      color: rgba(255, 255, 255, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition-fast);
    }

    .social-btn:hover {
      background: var(--orange);
      border-color: var(--orange);
      color: white;
    }

    .footer-col h4 {
      font-size: 14px;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 20px;
    }

    .footer-col a {
      display: block;
      color: rgba(255, 255, 255, 0.4);
      font-size: 13px;
      margin-bottom: 10px;
      transition: var(--transition-fast);
    }

    .footer-col a:hover {
      color: var(--orange);
    }

    .footer-bottom {
      padding-top: 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 16px;
    }

    .footer-copy {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.3);
    }

    .footer-links {
      display: flex;
      gap: 24px;
    }

    .footer-links a {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.3);
      transition: var(--transition-fast);
    }

    .footer-links a:hover {
      color: var(--orange);
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .course-card,
    .cat-card,
    .mini-card,
    .stat-card {
      animation: fadeUp 0.5s ease forwards;
      opacity: 0;
    }
  </style>
</head>

<body>

  <!-- ===================== HEADER AVEC RECHERCHE INTÉGRÉE ===================== -->
  <!-- ===================== HEADER AVEC RECHERCHE INTÉGRÉE ===================== -->
  <x-navbar />



  <!-- ===================== CAROUSEL HERO SECTION ===================== -->
  @if(!isset($searchResults) && isset($recentCourses) && $recentCourses->count() > 0)
    <section class="relative overflow-hidden w-full h-[60vh] sm:h-[70vh] lg:h-[80vh] bg-[#060E24] group cursor-default"
      x-data="{
                  activeSlide: 0,
                  slides: {{ count($recentCourses->take(5)) }},
                  next() { this.activeSlide = this.activeSlide === this.slides - 1 ? 0 : this.activeSlide + 1 },
                  prev() { this.activeSlide = this.activeSlide === 0 ? this.slides - 1 : this.activeSlide - 1 },
                  startAutoPlay() { this.interval = setInterval(() => this.next(), 3000) },
                  stopAutoPlay() { clearInterval(this.interval) }
              }" x-init="startAutoPlay()" @mouseenter="stopAutoPlay()" @mouseleave="startAutoPlay()">

      <div class="relative w-full h-full overflow-hidden">
        @foreach($recentCourses->take(5) as $index => $course)
          <!-- Slide -->
          <div x-show="activeSlide === {{ $index }}" x-transition:enter="transition-opacity duration-1000 ease-in-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-1000 ease-in-out" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="absolute inset-0 w-full h-full" style="display: none;">

            <!-- Image de couverture (Fond flouté) -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat blur-2xl opacity-40 scale-110"
              style="background-image: url('{{ asset($course->thumbnail ?? 'images/default-course.jpg') }}');"></div>

            <!-- Image de couverture au format original sans recadrage abusif -->
            <div class="absolute inset-0 bg-contain bg-center bg-no-repeat w-[90%] md:w-[80%] mx-auto my-6 lg:my-10"
              style="background-image: url('{{ asset($course->thumbnail ?? 'images/default-course.jpg') }}');"></div>

            <!-- Overlay Sombre (dégradé pour rendre le texte lisible par dessus) -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0B1A3E] via-[#0B1A3E]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-black/30"></div>

            <!-- Contenu au premier plan -->
            <div
              class="container h-full relative z-10 flex flex-col justify-end pb-16 sm:pb-24 lg:pb-32 px-6 sm:px-12 text-center items-center">
              <span
                class="inline-block px-3 py-1 mb-4 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[#F97316] bg-[#F97316]/20 backdrop-blur-md rounded-full border border-[#F97316]/30 animate-fade-in-up"
                style="animation-delay: 0.1s;">
                Nouveauté
              </span>
              <h1
                class="text-3xl sm:text-4xl lg:text-6xl font-black text-white mb-4 sm:mb-6 max-w-4xl text-shadow-xl animate-fade-in-up"
                style="animation-delay: 0.2s;">
                {{ $course->title }}
              </h1>
              <p class="text-sm sm:text-lg lg:text-xl text-gray-200 mb-8 max-w-2xl line-clamp-2 animate-fade-in-up"
                style="animation-delay: 0.3s;">
                Par <span class="text-[#F97316] font-semibold">{{ $course->formateur->user->first_name ?? 'Expert' }}
                  {{ $course->formateur->user->last_name ?? '' }}</span> · {{ $course->category->name ?? 'Général' }}
              </p>

              <div class="flex flex-col sm:flex-row gap-4 justify-center w-full sm:w-auto animate-fade-in-up"
                style="animation-delay: 0.4s;">
                <a href="{{ route('courses.show', $course->id) }}"
                  class="px-6 py-3 sm:px-8 bg-gradient-to-r from-[#F97316] to-[#EA580C] hover:from-[#EA580C] hover:to-[#C2410C] text-white font-bold rounded-lg shadow-lg shadow-[#F97316]/30 transform transition hover:scale-105 flex items-center justify-center">
                  <span>Découvrir</span>
                  <i class="fas fa-arrow-right ml-2 text-sm"></i>
                </a>

                <form action="{{ route('cart.add', $course->id) }}" method="POST" class="inline w-full sm:w-auto">
                  @csrf
                  <button type="submit"
                    class="w-full sm:w-auto px-6 py-3 sm:px-8 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-bold rounded-lg transition transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Flèche Précédent -->
      <button @click="prev()"
        class="absolute left-2 sm:left-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/40 hover:bg-[#F97316] text-white backdrop-blur-sm border border-white/20 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-all duration-300 z-20 shadow-lg">
        <i class="fas fa-chevron-left sm:text-xl"></i>
      </button>

      <!-- Flèche Suivant -->
      <button @click="next()"
        class="absolute right-2 sm:right-6 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/40 hover:bg-[#F97316] text-white backdrop-blur-sm border border-white/20 opacity-100 lg:opacity-0 lg:group-hover:opacity-100 transition-all duration-300 z-20 shadow-lg">
        <i class="fas fa-chevron-right sm:text-xl"></i>
      </button>

      <!-- Indicateurs -->
      <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 sm:space-x-3 z-20">
        @foreach($recentCourses->take(5) as $index => $course)
          <button @click="activeSlide = {{ $index }}" class="transition-all duration-300 rounded-full"
            :class="activeSlide === {{ $index }} ? 'w-6 h-2 sm:w-8 sm:h-2.5 bg-[#F97316]' : 'w-2 h-2 sm:w-2.5 sm:h-2.5 bg-white/50 hover:bg-white/80'"></button>
        @endforeach
      </div>
    </section>
    <style>
      .animate-fade-in-up {
        animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
      }

      @keyframes fadeUp {
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  @endif

  @if(isset($searchResults))
    <!-- Résultats de recherche -->
    <section class="courses-section" style="min-height: 60vh;">
      <div class="container">
        <div class="section-header">
          <span class="section-tag">Résultats</span>
          <h2 class="section-title">
            @if(request('all'))
              Toutes les <span class="accent">formations</span>
            @elseif(request('search'))
              Recherche : <span class="accent">{{ request('search') }}</span>
            @else
              Catalogue des <span class="accent">formations</span>
            @endif
          </h2>
          <p class="section-sub">{{ $searchResults->total() }} formation(s) trouvée(s)</p>
          <a href="{{ route('home') }}" class="inline-block mt-4 text-[#F97316] font-bold hover:underline">← Retour à
            l'accueil</a>
        </div>

        @if($searchResults->count() > 0)
          <div class="courses-grid">
            @foreach($searchResults as $course)
              <div class="course-card">
                <div class="card-thumb">
                  <div class="card-overlay">
                    <a href="{{ route('courses.show', $course->id) }}" class="card-overlay-btn">▶ Découvrir</a>
                  </div>
                  @if($course->cover_video)
                    <video autoplay loop muted playsinline>
                      <source src="{{ asset($course->cover_video) }}" type="video/mp4">
                    </video>
                  @elseif($course->thumbnail)
                    <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}">
                  @else
                    <div
                      style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-size:32px;">
                      📚</div>
                  @endif
                </div>
                <div class="card-body">
                  <div class="card-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
                  <div class="card-title">{{ $course->title }}</div>
                  <div class="card-instructor"><span class="instructor-dot"></span>
                    {{ $course->formateur->user->first_name ?? 'Formateur' }}</div>
                  <div class="card-meta">⏱️ {{ $course->duration_minutes }} min</div>
                  <div class="card-divider"></div>
                  <div class="card-footer">
                    <span
                      class="price-new">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>

                    <div class="flex gap-2">
                      <form action="{{ route('cart.add', $course->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                          class="bg-[#122255] hover:bg-[#1A3070] text-white p-2 rounded transition-colors whitespace-nowrap"
                          title="Ajouter au panier">
                          <i class="fas fa-cart-plus"></i>
                        </button>
                      </form>
                      <a href="{{ route('courses.show', $course->id) }}" class="btn-voir">Voir</a>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          @if ($searchResults->hasPages())
            <div style="margin-top: 48px; display: flex; justify-content: center; gap: 12px;">
              @if ($searchResults->onFirstPage())
                <span
                  style="padding: 10px 20px; background: var(--gray-bg); border-radius: 8px; color: var(--gray-text);">Précédent</span>
              @else
                <a href="{{ $searchResults->previousPageUrl() }}"
                  style="padding: 10px 20px; background: var(--orange); color: white; border-radius: 8px; font-weight: 600;">Précédent</a>
              @endif
              @if ($searchResults->hasMorePages())
                <a href="{{ $searchResults->nextPageUrl() }}"
                  style="padding: 10px 20px; background: var(--orange); color: white; border-radius: 8px; font-weight: 600;">Suivant</a>
              @else
                <span
                  style="padding: 10px 20px; background: var(--gray-bg); border-radius: 8px; color: var(--gray-text);">Suivant</span>
              @endif
            </div>
          @endif
        @else
          <div style="text-align: center; padding: 60px; background: var(--gray-bg); border-radius: 20px;">
            <h3 style="font-size: 20px; margin-bottom: 8px; color: var(--navy);">Aucune formation trouvée</h3>
            <p style="color: var(--gray-text);">Essayez de modifier vos critères de recherche</p>
            <a href="{{ route('home') }}" class="btn-signup" style="display: inline-block; margin-top: 24px;">Effacer les
              filtres</a>
          </div>
        @endif
      </div>
    </section>
  @else
    <!-- ===================== FORMATIONS RÉCENTES ===================== -->
    <section class="courses-section" id="formations">
      <div class="container">
        <div class="section-header">
          <div>
            <span class="section-tag">🆕 Nouveautés</span>
            <h2 class="section-title">Nouvelles <span class="accent">formations</span></h2>
            <p class="section-sub">Découvrez les derniers cours ajoutés par nos experts</p>
          </div>
          <a href="{{ route('home', ['all' => 1]) }}" class="see-all">Tout voir →</a>
        </div>
        <div class="courses-grid">
          @forelse($recentCourses as $course)
            <div class="course-card">
              <div class="card-thumb">
                <div class="card-overlay">
                  <a href="{{ route('courses.show', $course->id) }}" class="card-overlay-btn">▶ Découvrir</a>
                </div>
                @if($course->cover_video)
                  <video autoplay loop muted playsinline>
                    <source src="{{ asset($course->cover_video) }}" type="video/mp4">
                  </video>
                @elseif($course->thumbnail)
                  <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}">
                @else
                  <div
                    style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-size:32px;">
                    📚</div>
                @endif
              </div>
              <div class="card-body">
                <div class="card-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
                <div class="card-title">{{ $course->title }}</div>
                <div class="card-instructor"><span class="instructor-dot"></span>
                  {{ $course->formateur->user->first_name ?? 'Formateur' }}</div>
                <div class="card-meta">⏱️ {{ $course->duration_minutes }} min</div>
                <div class="card-divider"></div>
                <div class="card-footer">
                  <span
                    class="price-new">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
                  <div class="flex gap-2">
                    <form action="{{ route('cart.add', $course->id) }}" method="POST" class="inline">
                      @csrf
                      <button type="submit"
                        class="bg-[#122255] hover:bg-[#1A3070] text-white p-2 rounded transition-colors whitespace-nowrap"
                        title="Ajouter au panier">
                        <i class="fas fa-cart-plus"></i>
                      </button>
                    </form>
                    <a href="{{ route('courses.show', $course->id) }}" class="btn-voir">Voir</a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="course-card">
              <div class="card-body">
                <div class="card-title">Aucune formation disponible</div>
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- ===================== CATÉGORIES ===================== -->
    <section class="categories-section" id="categories">
      <div class="container">
        <div class="section-header">
          <div>
            <span class="section-tag">Explorer</span>
            <h2 class="section-title">Nos <span class="accent">catégories</span> de formations</h2>
            <p class="section-sub">Choisissez votre domaine et commencez dès aujourd'hui</p>
          </div>
        </div>
        <div class="categories-grid">
          @forelse($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->id]) }}" class="cat-card">
              <div class="cat-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="var(--orange)">
                  <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
              </div>
              <div class="cat-name">{{ $cat->name }}</div>
              <div class="cat-count">{{ $cat->courses_count }} formation(s)</div>
            </a>
          @empty
            <div>Aucune catégorie disponible</div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- ===================== FORMATIONS POPULAIRES ===================== -->
    <section class="courses-section">
      <div class="container">
        <div class="section-header">
          <div>
            <span class="section-tag">⭐ Tendance</span>
            <h2 class="section-title">Formations les plus <span class="accent">populaires</span></h2>
            <p class="section-sub">Basées sur le nombre d'apprenants inscrits</p>
          </div>
          <a href="{{ route('home', ['all' => 1]) }}" class="see-all">Voir tout →</a>
        </div>
        <div class="courses-grid">
          @forelse($popularCourses as $course)
            <div class="mini-card">
              <a href="{{ route('courses.show', $course->id) }}" style="position: absolute; inset: 0; z-index: 1;"></a>
              <div class="mini-thumb">
                @if($course->thumbnail)
                  <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}">
                @else
                  <div
                    style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:white;font-size:28px;">
                    📖</div>
                @endif
              </div>
              <div class="mini-body">
                <div class="mini-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
                <div class="mini-title">{{ $course->title }}</div>
                <div class="mini-footer">
                  <span
                    class="mini-price">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
                  <span class="mini-stats">👥 {{ $course->orders_count ?? 0 }} inscrits</span>
                </div>
              </div>
            </div>
          @empty
            <div>Aucune formation populaire</div>
          @endforelse
        </div>
      </div>
    </section>
  @endif

  <!-- ===================== STATS SECTION ===================== -->
  <section class="stats-section">
    <div class="container">
      <div class="stats-inner">
        <div class="stats-text">
          <span class="section-tag" style="background:rgba(249,115,22,0.15); color:var(--orange);">Pourquoi nous
            choisir</span>
          <h2>Rejoignez des milliers d'<span class="accent">apprenants</span> qui transforment leur carrière</h2>
          <p>Des formations conçues pour l'Afrique, accessibles depuis votre smartphone. Payez avec MTN Money, Moov
            Money, ou Carte Bancaire.</p>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg></div>
            Certifications reconnues et téléchargeables en PDF
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg></div>
            Paiement Mobile Money (MTN, Moov) et par Carte Bancaire
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg></div>
            Accès illimité à vie après achat, 100% mobile
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12" />
              </svg></div>
            Formateurs experts locaux et internationaux
          </div>
        </div>
        <div class="stats-grid">
          <div class="stat-card"><span class="stat-num" data-target="12500">0</span>
            <div class="stat-label">Apprenants actifs</div>
          </div>
          <div class="stat-card"><span class="stat-num" data-target="109">0</span>
            <div class="stat-label">Formations disponibles</div>
          </div>
          <div class="stat-card"><span class="stat-num" data-target="48">0</span>
            <div class="stat-label">Formateurs experts</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== FOOTER ===================== -->
  <x-footer />

  <script>
    // Hamburger menu - gère l'ouverture/fermeture du menu mobile/tablette
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (hamburger && mobileMenu) {
      hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
      });
    }

    // Stats counter avec animation fluide
    const counters = document.querySelectorAll('.stat-num[data-target]');
    let triggered = false;

    function animateStats() {
      counters.forEach(el => {
        const target = parseInt(el.dataset.target);
        let current = 0;
        const increment = Math.ceil(target / 50);
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            el.textContent = target.toLocaleString('fr-FR');
            clearInterval(timer);
          } else {
            el.textContent = current.toLocaleString('fr-FR');
          }
        }, 30);
      });
    }

    const observer = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && !triggered) {
        triggered = true;
        animateStats();
      }
    }, { threshold: 0.3 });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) observer.observe(statsSection);

    // Fermer le menu mobile lors du clic sur un lien
    const mobileLinks = document.querySelectorAll('.mobile-menu a');
    mobileLinks.forEach(link => {
      link.addEventListener('click', () => {
        if (hamburger) hamburger.classList.remove('open');
        if (mobileMenu) mobileMenu.classList.remove('open');
      });
    });
  </script>
</body>

</html>