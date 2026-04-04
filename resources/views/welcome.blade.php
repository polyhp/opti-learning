<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OptiLearning – Plateforme de Formation en Ligne</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap"
    rel="stylesheet">
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

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--white);
      color: var(--navy);
      line-height: 1.5;
      overflow-x: hidden;
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
    }

    .section-title .accent {
      color: var(--orange);
    }

    .section-sub {
      font-size: 16px;
      color: var(--gray-text);
      margin-top: 12px;
    }

    .section-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 16px;
      margin-bottom: 48px;
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
   HEADER AVEC RECHERCHE INTÉGRÉE
   ============================ */
    header {
      background: var(--navy);
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 20px rgba(11, 26, 62, 0.3);
    }

    .header-main {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 72px;
      gap: 16px;
    }

    /* Logo */
    .logo {

      display: flex;
      align-items: center;
      gap: 30px;
      flex-shrink: 0;
    }

    .logo-image {
      height: 200px;
      width: 100%;
      max-width: 200px;
      object-fit: contain;
      /*border-radius: 30%;*/
    }

    /* Barre de recherche dans le header */
    .header-search {
      flex: 1;
      max-width: 500px;
      margin: 0 16px;
    }

    @media (max-width: 1024px) {
      .header-search {
        display: none;
      }
    }

    .header-search-form {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-md);
      border: 1px solid rgba(255, 255, 255, 0.15);
      transition: var(--transition-fast);
      backdrop-filter: blur(4px);
    }

    .header-search-form:focus-within {
      border-color: var(--orange);
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
    }

    .header-search-icon {
      display: flex;
      align-items: center;
      padding-left: 14px;
      color: rgba(255, 255, 255, 0.6);
    }

    .header-search-input {
      flex: 1;
      border: none;
      padding: 10px 12px;
      font-size: 14px;
      background: transparent;
      outline: none;
      color: var(--white);
    }

    .header-search-input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    .header-search-select {
      border: none;
      border-left: 1px solid rgba(255, 255, 255, 0.2);
      padding: 10px 14px;
      font-size: 13px;
      background: transparent;
      color: rgba(255, 255, 255, 0.8);
      cursor: pointer;
      outline: none;
    }

    .header-search-select option {
      background: var(--navy);
      color: var(--white);
    }

    .header-search-btn {
      background: var(--orange);
      border: none;
      color: var(--white);
      padding: 10px 24px;
      border-radius: 0 var(--radius-md) var(--radius-md) 0;
      font-size: 14px;
      font-weight: 600;
      transition: var(--transition-fast);
      cursor: pointer;
    }

    .header-search-btn:hover {
      background: var(--orange-lt);
    }

    /* Header actions - TOUJOURS VISIBLES sur tous les écrans */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
    }

    .btn-login {
      padding: 8px 20px;
      border: 1.5px solid rgba(255, 255, 255, 0.25);
      background: transparent;
      color: var(--white);
      border-radius: var(--radius-sm);
      font-size: 14px;
      font-weight: 500;
      transition: var(--transition-fast);
      white-space: nowrap;
    }

    .btn-login:hover {
      border-color: var(--orange);
      color: var(--orange);
    }

    .btn-signup {
      padding: 8px 22px;
      background: var(--orange);
      border: none;
      color: var(--white);
      border-radius: var(--radius-sm);
      font-size: 14px;
      font-weight: 600;
      transition: var(--transition-fast);
      white-space: nowrap;
    }

    .btn-signup:hover {
      background: var(--orange-lt);
      transform: translateY(-1px);
    }

    /* Navigation desktop - visible uniquement sur desktop */
    .nav-wrapper {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    nav {
      display: flex;
      align-items: center;
      gap: 0;
      overflow-x: auto;
      scrollbar-width: none;
    }

    nav::-webkit-scrollbar {
      display: none;
    }

    nav a {
      color: rgba(255, 255, 255, 0.65);
      padding: 14px 20px;
      font-size: 14px;
      font-weight: 500;
      border-bottom: 2px solid transparent;
      white-space: nowrap;
      transition: var(--transition-fast);
    }

    nav a:hover,
    nav a.active {
      color: var(--white);
      border-bottom-color: var(--orange);
    }

    /* Hamburger mobile - visible uniquement sur mobile/tablette */
    .hamburger {
      display: none;
      flex-direction: column;
      gap: 5px;
      background: transparent;
      border: none;
      padding: 8px;
      cursor: pointer;
    }

    .hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background: var(--white);
      border-radius: 2px;
      transition: var(--transition-fast);
    }

    .hamburger.open span:nth-child(1) {
      transform: translateY(7px) rotate(45deg);
    }

    .hamburger.open span:nth-child(2) {
      opacity: 0;
    }

    .hamburger.open span:nth-child(3) {
      transform: translateY(-7px) rotate(-45deg);
    }

    /* Mobile menu - visible uniquement quand ouvert sur mobile/tablette */
    .mobile-menu {
      display: none;
      flex-direction: column;
      background: var(--navy-mid);
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding: 12px 0;
    }

    .mobile-menu.open {
      display: flex;
    }

    .mobile-menu a {
      color: rgba(255, 255, 255, 0.7);
      padding: 14px 24px;
      font-size: 15px;
      font-weight: 500;
      border-left: 3px solid transparent;
      transition: var(--transition-fast);
    }

    .mobile-menu a:hover,
    .mobile-menu a.active {
      color: var(--white);
      border-left-color: var(--orange);
      background: rgba(255, 255, 255, 0.05);
    }

    /* ============================
   RESPONSIVE - GESTION DES ÉCRANS
   ============================ */

    /* Tablette (769px - 1024px) */
    @media (min-width: 769px) and (max-width: 1024px) {

      /* Navigation desktop masquée */
      .nav-wrapper {
        display: none !important;
      }

      /* Hamburger visible */
      .hamburger {
        display: flex !important;
      }

      /* Boutons connexion/inscription RESTENT VISIBLES */
      .header-actions {
        display: flex !important;
      }

      /* Recherche masquée sur tablette */
      .header-search {
        display: none !important;
      }

      /* Ajustement des boutons pour tablette */
      .btn-login,
      .btn-signup {
        padding: 6px 16px;
        font-size: 13px;
      }
    }

    /* Mobile (<= 768px) */
    @media (max-width: 768px) {

      /* Navigation desktop masquée */
      .nav-wrapper {
        display: none !important;
      }

      /* Hamburger visible */
      .hamburger {
        display: flex !important;
      }

      /* Boutons connexion/inscription RESTENT VISIBLES sur mobile */
      .header-actions {
        display: flex !important;
      }

      /* Recherche masquée sur mobile */
      .header-search {
        display: none !important;
      }

      /* Ajustement des boutons pour mobile */
      .btn-login,
      .btn-signup {
        padding: 6px 14px;
        font-size: 12px;
      }

      .hero-section {
        padding: 40px 0 60px;
      }

      /* Réduction de l'espacement dans le header */
      .header-main {
        gap: 12px;
        height: 64px;
      }
    }

    /* Très petits mobiles (<= 480px) */
    @media (max-width: 480px) {

      .btn-login,
      .btn-signup {
        padding: 5px 10px;
        font-size: 11px;
      }

      .logo-image {
        height: 48px;
      }

      .header-main {
        gap: 8px;
      }
    }

    /* Desktop (>= 1025px) */
    @media (min-width: 1025px) {
      .nav-wrapper {
        display: block !important;
      }

      .hamburger {
        display: none !important;
      }

      .mobile-menu {
        display: none !important;
      }

      .header-search {
        display: block !important;
      }
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
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
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
      border: 1px solid var(--gray-border);
      overflow: hidden;
      transition: var(--transition);
      position: relative;
    }

    .course-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-hover);
      border-color: var(--orange-pale);
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
  <header>
    <div class="container">
      <div class="header-main">
        <!-- Logo avec emplacement pour votre image -->
        <a href="#" class="logo">
          <img src="{{ asset('images/logo optilearning.jpg') }}" alt="OptiLearning" class="logo-image">
        </a>

        <!-- Barre de recherche intégrée dans le header (desktop uniquement) -->
        <div class="header-search">
          <form action="{{ route('home') }}" method="GET" class="header-search-form">
            <div class="header-search-icon">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
              </svg>
            </div>
            <input type="text" name="search" class="header-search-input"
              placeholder="Rechercher par formateur, mots ou lettres..." value="{{ request('search') }}">
            <select name="category" class="header-search-select">
              <option value="">Toutes catégories</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}
                </option>
              @endforeach
            </select>
            <button type="submit" class="header-search-btn">Rechercher</button>
          </form>
        </div>

        <!-- Actions desktop - TOUJOURS VISIBLES sur tous les écrans -->
        <div class="header-actions">
          <a href="{{route('login')}}" class="btn-login">Connexion</a>
          <a href="{{route('register')}}" class="btn-signup">Inscription</a>
        </div>

        <!-- Hamburger mobile/tablette - visible sur tous les écrans sauf desktop -->
        <button class="hamburger" id="hamburger" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <!-- Navigation desktop - visible uniquement sur desktop (>=1025px) -->


    <!-- Menu mobile/tablette - visible uniquement quand ouvert -->
    <div class="mobile-menu" id="mobileMenu">
      <a href="#" class="active">Accueil</a>
      <a href="#formations">Formations</a>
      <a href="#categories">Catégories</a>
      <a href="#">Contact</a>
    </div>
  </header>

  <!-- Barre de recherche mobile (fixée en bas) -->
  <div class="mobile-search-bar">
    <form action="{{ route('home') }}" method="GET" class="mobile-search-form">
      <input type="text" name="search" class="mobile-search-input" placeholder="Rechercher une formation..."
        value="{{ request('search') }}">
      <select name="category" class="header-search-select" style="display: none;">
        <option value="">Toutes</option>
      </select>
      <button type="submit" class="mobile-search-btn">🔍</button>
    </form>
  </div>

  <!-- ===================== HERO SECTION ===================== -->
  <section class="hero-section">
    <div class="container">
      <div class="hero-content">
        <h1>Trouvez la formation qui va <span class="highlight">transformer</span> votre carrière</h1>
        <p>Plus de 100 formations disponibles · Paiement Mobile Money accepté · Certificats reconnus</p>
      </div>
    </div>
  </section>

  @if(isset($searchResults))
    <!-- Résultats de recherche -->
    <section class="courses-section" style="min-height: 60vh;">
      <div class="container">
        <div class="section-header">
          <div>
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
          </div>
          <a href="{{ route('home') }}" class="see-all">← Retour à l'accueil</a>
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
                    <a href="{{ route('courses.show', $course->id) }}" class="btn-voir">Voir</a>
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
                  <a href="{{ route('courses.show', $course->id) }}" class="btn-voir">Voir</a>
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
  <footer>
    <div class="container">
      <div class="footer-grid">
        <div>
          <div class="footer-logo-wrap">
            <div
              style="width:36px;height:36px;background:var(--orange);border-radius:8px;display:flex;align-items:center;justify-content:center;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="white">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
              </svg>
            </div>
            <span class="footer-logo-text">OPTI-<span>LEARNING</span></span>
          </div>
          <p class="footer-desc">La plateforme de formation en ligne pensée pour l'Afrique. Des cours certifiants
            accessibles depuis votre téléphone.</p>
          <div class="payment-badges">
            <span class="pay-badge">MTN Money</span>
            <span class="pay-badge">Moov Money</span>
            <span class="pay-badge">Visa / MasterCard</span>
          </div>
          <div class="social-links">
            <button class="social-btn">f</button>
            <button class="social-btn">in</button>
            <button class="social-btn">▶</button>
          </div>
        </div>
        <div class="footer-col">
          <h4>Plateforme</h4><a href="#">Comment ça marche</a><a href="#">Devenir formateur</a><a href="#">Tarifs &
            Paiement</a><a href="#">FAQ</a>
        </div>
        <div class="footer-col">
          <h4>Entreprise</h4><a href="#">À propos</a><a href="#">Contact</a><a href="#">Partenaires</a>
        </div>
        <div class="footer-col">
          <h4>Légal</h4><a href="#">Confidentialité</a><a href="#">Mentions légales</a><a href="#">CGU</a>
        </div>
      </div>
      <div class="footer-bottom">
        <span class="footer-copy">© 2026 OptiLearning. Tous droits réservés. Conçu avec ❤️ pour l'Afrique.</span>
        <div class="footer-links"><a href="#">Confidentialité</a><a href="#">Mentions légales</a></div>
      </div>
    </div>
  </footer>

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