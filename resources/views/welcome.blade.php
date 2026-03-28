<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OptiLearning – Plateforme de Formation en Ligne</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">
<style>
/* ============================
   VARIABLES & RESET
   ============================ */
:root {
  --navy:        #0B1A3E;
  --navy-mid:    #122255;
  --navy-light:  #1A3070;
  --navy-dark:   #060E24;
  --orange:      #F97316;
  --orange-lt:   #FB923C;
  --orange-pale: #FFF0E6;
  --white:       #FFFFFF;
  --gray-bg:     #F4F6FB;
  --gray-border: #E2E8F2;
  --gray-text:   #8896AE;
  --font-head:   'Syne', sans-serif;
  --font-body:   'DM Sans', sans-serif;
  --radius-sm:   8px;
  --radius-md:   12px;
  --radius-lg:   16px;
  --shadow-card: 0 4px 24px rgba(11,26,62,0.10);
  --shadow-hover:0 12px 36px rgba(11,26,62,0.16);
  --transition:  0.22s ease;
}

*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

html { scroll-behavior: smooth; }

body {
  font-family: var(--font-body);
  background: var(--white);
  color: var(--navy);
  line-height: 1.6;
  overflow-x: hidden;
}

img { max-width: 100%; display: block; }
a  { text-decoration: none; color: inherit; }
button { cursor: pointer; font-family: var(--font-body); }
ul, ol { list-style: none; }

/* ============================
   UTILITIES
   ============================ */
.container {
  width: 100%;
  max-width: 1240px;
  margin: 0 auto;
  padding: 0 5%;
}

.section-tag {
  display: inline-block;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.2px;
  text-transform: uppercase;
  color: var(--orange);
  background: var(--orange-pale);
  padding: 5px 14px;
  border-radius: 20px;
  margin-bottom: 12px;
}

.section-title {
  font-family: var(--font-head);
  font-weight: 800;
  font-size: clamp(22px, 3vw, 32px);
  color: var(--navy);
  line-height: 1.25;
}

.section-title .accent { color: var(--orange); }

.section-sub {
  font-size: 15px;
  color: var(--gray-text);
  margin-top: 8px;
}

.section-header {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 32px;
}

.see-all {
  font-size: 14px;
  font-weight: 500;
  color: var(--orange);
  white-space: nowrap;
  transition: gap var(--transition);
  display: flex;
  align-items: center;
  gap: 4px;
}
.see-all:hover { gap: 8px; }

/* ============================
   HEADER
   ============================ */
header {
  background: var(--navy);
  position: sticky;
  top: 0;
  z-index: 1000;
  box-shadow: 0 2px 20px rgba(11,26,62,0.4);
}

.header-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 68px;
  gap: 16px;
}

/* Logo */
.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  flex-shrink: 0;
}

.logo-icon {
  width: 38px;
  height: 38px;
  background: var(--orange);
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.logo-icon svg { width: 22px; height: 22px; }

.logo-text {
  font-family: var(--font-head);
  font-weight: 800;
  font-size: 20px;
  color: var(--white);
  letter-spacing: -0.3px;
}

.logo-text span { color: var(--orange); }

/* Header actions */
.header-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-login {
  padding: 9px 20px;
  border: 1.5px solid rgba(255,255,255,0.25);
  background: transparent;
  color: var(--white);
  border-radius: var(--radius-sm);
  font-size: 14px;
  font-weight: 400;
  transition: all var(--transition);
  white-space: nowrap;
}
.btn-login:hover { border-color: var(--orange); color: var(--orange); }

.btn-signup {
  padding: 9px 22px;
  background: var(--orange);
  border: none;
  color: var(--white);
  border-radius: var(--radius-sm);
  font-size: 14px;
  font-weight: 600;
  transition: all var(--transition);
  white-space: nowrap;
}
.btn-signup:hover { background: var(--orange-lt); transform: scale(1.03); }

/* Hamburger */
.hamburger {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: transparent;
  border: none;
  padding: 6px;
  border-radius: var(--radius-sm);
}
.hamburger span {
  display: block;
  width: 24px;
  height: 2px;
  background: var(--white);
  border-radius: 2px;
  transition: all var(--transition);
}
.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* Nav */
.nav-wrapper {
  border-top: 1px solid rgba(255,255,255,0.08);
}

nav {
  display: flex;
  align-items: center;
  gap: 0;
  overflow-x: auto;
  scrollbar-width: none;
}
nav::-webkit-scrollbar { display: none; }

nav a {
  color: rgba(255,255,255,0.65);
  padding: 14px 18px;
  font-size: 14px;
  border-bottom: 2px solid transparent;
  white-space: nowrap;
  transition: all var(--transition);
  flex-shrink: 0;
}
nav a:hover,
nav a.active { color: var(--white); border-bottom-color: var(--orange); }

/* Mobile nav */
.mobile-menu {
  display: none;
  flex-direction: column;
  background: var(--navy-mid);
  border-top: 1px solid rgba(255,255,255,0.08);
  padding: 8px 0;
}
.mobile-menu.open { display: flex; }
.mobile-menu a {
  color: rgba(255,255,255,0.7);
  padding: 14px 5%;
  font-size: 15px;
  border-left: 3px solid transparent;
  transition: all var(--transition);
}
.mobile-menu a:hover,
.mobile-menu a.active {
  color: var(--white);
  border-left-color: var(--orange);
  background: rgba(255,255,255,0.04);
}
.mobile-menu .mobile-auth {
  display: flex;
  gap: 10px;
  padding: 14px 5%;
  border-top: 1px solid rgba(255,255,255,0.08);
  margin-top: 8px;
}
.mobile-menu .mobile-auth .btn-login,
.mobile-menu .mobile-auth .btn-signup { flex: 1; text-align: center; }

/* ============================
   SEARCH SECTION
   ============================ */
.search-section {
  background: var(--navy-mid);
  padding: 28px 0;
}

.search-hero-text {
  text-align: center;
  margin-bottom: 20px;
}
.search-hero-text h2 {
  font-family: var(--font-head);
  font-size: clamp(18px, 3vw, 26px);
  font-weight: 700;
  color: var(--white);
}
.search-hero-text p {
  color: rgba(255,255,255,0.55);
  font-size: 14px;
  margin-top: 4px;
}

.search-bar {
  max-width: 720px;
  margin: 0 auto;
  display: flex;
  background: var(--white);
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: 0 6px 30px rgba(11,26,62,0.25);
}

.search-icon-wrap {
  display: flex;
  align-items: center;
  padding: 0 14px 0 18px;
  flex-shrink: 0;
}

.search-input {
  flex: 1;
  border: none;
  padding: 16px 10px;
  font-size: 15px;
  font-family: var(--font-body);
  outline: none;
  color: var(--navy);
  min-width: 0;
}
.search-input::placeholder { color: var(--gray-text); }

.search-select {
  border: none;
  border-left: 1px solid var(--gray-border);
  padding: 0 14px;
  font-size: 14px;
  font-family: var(--font-body);
  color: var(--navy);
  background: var(--white);
  outline: none;
  cursor: pointer;
  display: block;
}

.btn-search {
  background: var(--orange);
  border: none;
  color: var(--white);
  padding: 0 28px;
  font-size: 15px;
  font-weight: 600;
  letter-spacing: 0.2px;
  transition: background var(--transition);
  white-space: nowrap;
  flex-shrink: 0;
}
.btn-search:hover { background: var(--orange-lt); }

.search-tags {
  max-width: 720px;
  margin: 14px auto 0;
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: center;
}
.search-tag {
  font-size: 12px;
  color: rgba(255,255,255,0.55);
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.12);
  padding: 5px 14px;
  border-radius: 20px;
  cursor: pointer;
  transition: all var(--transition);
}
.search-tag:hover { background: var(--orange); color: var(--white); border-color: var(--orange); }

/* ============================
   CAROUSEL
   ============================ */
.carousel-section { padding: 56px 0; background: var(--white); }

.carousel-outer { position: relative; }

.carousel-track {
  display: flex;
  gap: 20px;
  overflow: hidden;
}

/* Course Card */
.course-card {
  min-width: calc(33.333% - 14px);
  background: var(--white);
  border-radius: var(--radius-lg);
  border: 1px solid var(--gray-border);
  overflow: hidden;
  transition: transform var(--transition), box-shadow var(--transition);
  flex-shrink: 0;
}
.course-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-hover);
}

.card-thumb {
  height: 176px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.card-thumb-bg {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
}

/* Geometric pattern overlay */
.card-thumb-bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    radial-gradient(circle at 20% 80%, rgba(249,115,22,0.15) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.04) 0%, transparent 50%);
}

.card-thumb-icon {
  position: relative;
  z-index: 1;
  width: 56px;
  height: 56px;
  background: var(--orange);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.card-thumb-icon svg { width: 30px; height: 30px; fill: white; }

.badge {
  position: absolute;
  top: 12px;
  left: 12px;
  z-index: 2;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  padding: 4px 10px;
  border-radius: 20px;
}
.badge-hot  { background: var(--orange);  color: white; }
.badge-new  { background: #10B981;        color: white; }
.badge-sale { background: #8B5CF6;        color: white; }

.card-body { padding: 20px; }
.card-cat {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.8px;
  text-transform: uppercase;
  color: var(--orange);
  margin-bottom: 6px;
}
.card-title {
  font-family: var(--font-head);
  font-size: 15px;
  font-weight: 700;
  color: var(--navy);
  line-height: 1.4;
  margin-bottom: 10px;
}
.card-instructor {
  font-size: 12px;
  color: var(--gray-text);
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  gap: 6px;
}
.instructor-dot {
  width: 6px; height: 6px;
  background: var(--orange);
  border-radius: 50%;
  flex-shrink: 0;
}
.card-meta {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 12px;
  color: var(--gray-text);
  margin-bottom: 16px;
  flex-wrap: wrap;
}
.stars { color: #F59E0B; font-size: 13px; letter-spacing: -1px; }

.card-divider {
  height: 1px;
  background: var(--gray-border);
  margin-bottom: 16px;
}

.card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.price-block {}
.price-old {
  font-size: 11px;
  color: var(--gray-text);
  text-decoration: line-through;
  display: block;
  line-height: 1.2;
}
.price-new {
  font-family: var(--font-head);
  font-weight: 800;
  font-size: 20px;
  color: var(--navy);
}
.btn-voir {
  background: var(--navy);
  color: var(--white);
  border: none;
  padding: 10px 18px;
  border-radius: var(--radius-sm);
  font-size: 13px;
  font-weight: 600;
  transition: all var(--transition);
  white-space: nowrap;
}
.btn-voir:hover { background: var(--orange); transform: scale(1.03); }

/* Carousel Navigation */
.carousel-nav {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 32px;
}
.carousel-arrow {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1.5px solid var(--gray-border);
  background: var(--white);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all var(--transition);
  flex-shrink: 0;
}
.carousel-arrow:hover { background: var(--orange); border-color: var(--orange); }
.carousel-arrow:hover svg { stroke: white; }
.carousel-arrow svg { width: 18px; height: 18px; stroke: var(--navy); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

.carousel-dots { display: flex; gap: 6px; align-items: center; }
.dot {
  width: 8px; height: 8px;
  border-radius: 4px;
  background: var(--gray-border);
  cursor: pointer;
  transition: all var(--transition);
}
.dot.active { background: var(--orange); width: 24px; }

/* ============================
   CATEGORIES
   ============================ */
.categories-section {
  padding: 56px 0;
  background: var(--gray-bg);
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 16px;
}

.cat-card {
  background: var(--white);
  border-radius: var(--radius-lg);
  padding: 26px 14px 22px;
  text-align: center;
  border: 1.5px solid var(--gray-border);
  cursor: pointer;
  transition: all var(--transition);
  position: relative;
  overflow: hidden;
}
.cat-card::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 3px;
  background: var(--orange);
  transform: scaleX(0);
  transform-origin: center;
  transition: transform var(--transition);
}
.cat-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
  border-color: rgba(249,115,22,0.3);
}
.cat-card:hover::after { transform: scaleX(1); }

.cat-icon {
  width: 56px;
  height: 56px;
  margin: 0 auto 14px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.cat-icon svg { width: 28px; height: 28px; }

.cat-name {
  font-family: var(--font-head);
  font-size: 13px;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 5px;
  line-height: 1.3;
}
.cat-count {
  font-size: 11px;
  color: var(--gray-text);
}

/* ============================
   ALL COURSES
   ============================ */
.all-courses-section { padding: 56px 0; background: var(--white); }

.courses-wrapper {
  position: relative;
  width: 100%;
  display: flex;
  align-items: center;
}
.courses-grid {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  scroll-snap-type: x mandatory;
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
  gap: 20px;
  width: 100%;
  padding: 10px 0 20px 0;
}
.courses-grid::-webkit-scrollbar {
  display: none;
}
.courses-grid > div {
  flex: 0 0 auto;
  width: calc(25% - 15px);
  scroll-snap-align: start;
}

.scroll-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 44px;
  height: 44px;
  border-radius: 50%;
  border: 1.5px solid var(--gray-border);
  background: var(--white);
  color: var(--navy);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
  box-shadow: 0 4px 15px rgba(0,0,0,0.15); /* More visible shadow */
  transition: all var(--transition);
}
.scroll-btn:hover {
  background: var(--orange);
  border-color: var(--orange);
  color: white;
}
.scroll-btn svg {
  width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
}
.scroll-btn-left { left: -22px; }
.scroll-btn-right { right: -22px; }

@media (max-width: 900px) {
  .courses-grid > div { width: calc(50% - 10px); }
}
@media (max-width: 480px) {
  .courses-grid > div { width: 85vw; }
  .scroll-btn { width: 40px; height: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); display: flex !important; }
  .scroll-btn-left { left: 4px; }
  .scroll-btn-right { right: 4px; }
}

.mini-card {
  background: var(--white);
  border-radius: var(--radius-md);
  border: 1px solid var(--gray-border);
  overflow: hidden;
  transition: all var(--transition);
}
.mini-card:hover {
  box-shadow: var(--shadow-card);
  transform: translateY(-3px);
}

.mini-thumb {
  height: 128px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background: linear-gradient(135deg, var(--navy), var(--navy-light));
}
.mini-thumb-bg {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(circle at 70% 30%, rgba(249,115,22,0.12) 0%, transparent 60%);
}
.mini-thumb svg { position: relative; z-index: 1; width: 34px; height: 34px; fill: var(--orange); }

.mini-body { padding: 14px 16px; }
.mini-cat {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.7px;
  text-transform: uppercase;
  color: var(--orange);
  margin-bottom: 5px;
}
.mini-title {
  font-family: var(--font-head);
  font-size: 13px;
  font-weight: 700;
  color: var(--navy);
  line-height: 1.4;
  margin-bottom: 10px;
}
.mini-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.mini-price {
  font-family: var(--font-head);
  font-weight: 800;
  font-size: 15px;
  color: var(--orange);
}
.mini-stars { font-size: 11px; color: #F59E0B; }

/* ============================
   STATS
   ============================ */
.stats-section {
  background: var(--navy);
  padding: 72px 0;
  position: relative;
  overflow: hidden;
}

/* Background decoration */
.stats-section::before {
  content: '';
  position: absolute;
  top: -100px; right: -100px;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(249,115,22,0.08) 0%, transparent 70%);
  pointer-events: none;
}
.stats-section::after {
  content: '';
  position: absolute;
  bottom: -80px; left: -80px;
  width: 300px; height: 300px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(255,255,255,0.03) 0%, transparent 70%);
  pointer-events: none;
}

.stats-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 60px;
  align-items: center;
  position: relative;
  z-index: 1;
}

.stats-text h2 {
  font-family: var(--font-head);
  font-size: clamp(22px, 3.5vw, 34px);
  font-weight: 800;
  color: var(--white);
  line-height: 1.3;
  margin-bottom: 16px;
}
.stats-text h2 .accent { color: var(--orange); }

.stats-text p {
  color: rgba(255,255,255,0.58);
  font-size: 15px;
  line-height: 1.75;
  margin-bottom: 32px;
}

.stats-features { margin-bottom: 32px; }
.feature-item {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
  font-size: 14px;
  color: rgba(255,255,255,0.75);
}
.feature-check {
  width: 20px; height: 20px;
  background: rgba(249,115,22,0.2);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.feature-check svg { width: 12px; height: 12px; stroke: var(--orange); fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }

.btn-cta {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--orange);
  color: var(--white);
  border: none;
  padding: 16px 34px;
  border-radius: var(--radius-md);
  font-size: 15px;
  font-weight: 600;
  transition: all var(--transition);
}
.btn-cta:hover { background: var(--orange-lt); transform: scale(1.03); gap: 12px; }
.btn-cta svg { width: 18px; height: 18px; stroke: white; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

.stats-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.stat-card {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: var(--radius-lg);
  padding: 28px 20px;
  text-align: center;
  transition: all var(--transition);
  cursor: default;
}
.stat-card:hover {
  background: rgba(249,115,22,0.12);
  border-color: rgba(249,115,22,0.35);
}

.stat-num {
  font-family: var(--font-head);
  font-size: clamp(28px, 3.5vw, 40px);
  font-weight: 800;
  color: var(--orange);
  display: block;
  margin-bottom: 6px;
  line-height: 1;
}

.stat-label {
  font-size: 13px;
  color: rgba(255,255,255,0.55);
  line-height: 1.4;
}

/* ============================
   TESTIMONIALS (bonus)
   ============================ */
.testimonials-section { padding: 56px 0; background: var(--gray-bg); }

.testi-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.testi-card {
  background: var(--white);
  border-radius: var(--radius-lg);
  padding: 24px;
  border: 1px solid var(--gray-border);
  transition: all var(--transition);
}
.testi-card:hover { box-shadow: var(--shadow-card); }

.testi-stars { font-size: 14px; color: #F59E0B; margin-bottom: 12px; }
.testi-text {
  font-size: 14px;
  color: #4A5568;
  line-height: 1.7;
  margin-bottom: 18px;
  font-style: italic;
}
.testi-author { display: flex; align-items: center; gap: 12px; }
.testi-avatar {
  width: 40px; height: 40px;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: var(--font-head);
  font-weight: 700;
  font-size: 14px;
  flex-shrink: 0;
}
.testi-name {
  font-family: var(--font-head);
  font-size: 14px;
  font-weight: 700;
  color: var(--navy);
}
.testi-role { font-size: 12px; color: var(--gray-text); }

/* ============================
   FOOTER
   ============================ */
footer {
  background: var(--navy-dark);
  padding: 60px 0 0;
}

.footer-grid {
  display: grid;
  grid-template-columns: 2fr 1fr 1fr 1fr;
  gap: 48px;
  padding-bottom: 48px;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}

.footer-brand {}
.footer-logo-wrap { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; }
.footer-logo-text {
  font-family: var(--font-head);
  font-weight: 800;
  font-size: 20px;
  color: var(--white);
}
.footer-logo-text span { color: var(--orange); }

.footer-desc {
  font-size: 14px;
  color: rgba(255,255,255,0.45);
  line-height: 1.75;
  margin-bottom: 22px;
  max-width: 280px;
}

.payment-badges {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 24px;
}
.pay-badge {
  background: rgba(255,255,255,0.07);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 6px;
  padding: 5px 12px;
  font-size: 11px;
  font-weight: 600;
  color: rgba(255,255,255,0.6);
  letter-spacing: 0.4px;
}

.social-links { display: flex; gap: 10px; }
.social-btn {
  width: 38px; height: 38px;
  border-radius: var(--radius-sm);
  border: 1px solid rgba(255,255,255,0.12);
  background: transparent;
  color: rgba(255,255,255,0.5);
  display: flex; align-items: center; justify-content: center;
  transition: all var(--transition);
}
.social-btn:hover { background: var(--orange); border-color: var(--orange); color: white; }
.social-btn svg { width: 16px; height: 16px; fill: currentColor; }

.footer-col h4 {
  font-family: var(--font-head);
  font-size: 14px;
  font-weight: 700;
  color: var(--white);
  margin-bottom: 18px;
}
.footer-col a {
  display: block;
  color: rgba(255,255,255,0.42);
  font-size: 13px;
  margin-bottom: 10px;
  transition: color var(--transition);
}
.footer-col a:hover { color: var(--orange); }

.footer-bottom {
  padding: 20px 0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
}
.footer-copy {
  font-size: 12px;
  color: rgba(255,255,255,0.28);
}
.footer-links { display: flex; gap: 20px; }
.footer-links a {
  font-size: 12px;
  color: rgba(255,255,255,0.28);
  transition: color var(--transition);
}
.footer-links a:hover { color: var(--orange); }

/* ============================
   RESPONSIVE — TABLET (≤1024px)
   ============================ */
@media (max-width: 1024px) {
  .categories-grid { grid-template-columns: repeat(3, 1fr); }
  .courses-grid     { grid-template-columns: repeat(3, 1fr); }
  .course-card      { min-width: calc(50% - 10px); }
  .stats-inner      { gap: 36px; }
  .footer-grid      { grid-template-columns: 1fr 1fr; gap: 32px; }
  .testi-grid       { grid-template-columns: repeat(2, 1fr); }
}

/* ============================
   RESPONSIVE — MOBILE (≤768px)
   ============================ */
@media (max-width: 768px) {

  /* Header */
  .btn-login,
  .btn-signup { display: none; }
  .hamburger  { display: flex; }
  .nav-wrapper { display: none; }

  /* Search */
  .search-section { padding: 22px 0; }
  .search-bar { border-radius: var(--radius-sm); }
  .search-select { display: none; }
  .search-input { padding: 14px 10px; font-size: 14px; }
  .btn-search { padding: 0 18px; font-size: 14px; }

  /* Carousel */
  .carousel-section { padding: 40px 0; }
  .course-card { min-width: calc(85vw); }

  /* Categories */
  .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .cat-card { padding: 20px 10px 16px; }
  .cat-icon { width: 44px; height: 44px; }
  .cat-icon svg { width: 22px; height: 22px; }
  .cat-name { font-size: 12px; }

  /* All Courses */
  /* All Courses */

  /* Stats */
  .stats-section { padding: 48px 0; }
  .stats-inner { grid-template-columns: 1fr; gap: 40px; }
  .stats-text { text-align: center; }
  .stats-features { text-align: left; display: inline-block; }
  .btn-cta { width: 100%; justify-content: center; }
  .stats-grid { grid-template-columns: 1fr 1fr; }

  /* Testimonials */
  .testimonials-section { padding: 40px 0; }
  .testi-grid { grid-template-columns: 1fr; }

  /* Footer */
  .footer-grid { grid-template-columns: 1fr; gap: 28px; }
  .footer-desc { max-width: 100%; }
  .footer-bottom { flex-direction: column; text-align: center; }
  .footer-links { justify-content: center; flex-wrap: wrap; }
}

/* ============================
   RESPONSIVE — SMALL MOBILE (≤480px)
   ============================ */
@media (max-width: 480px) {
  .logo-text { font-size: 17px; }
  .logo-icon { width: 32px; height: 32px; }
  .logo-icon svg { width: 18px; height: 18px; }

  .search-hero-text h2 { font-size: 16px; }
  .search-input { font-size: 13px; padding: 13px 8px; }
  .btn-search { padding: 0 14px; font-size: 13px; }

  .course-card { min-width: 90vw; }
  .categories-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }

  .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
  .stat-card { padding: 20px 14px; }
}

/* ============================
   ANIMATIONS
   ============================ */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

.animate-up {
  animation: fadeUp 0.5s ease forwards;
  opacity: 0;
}
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
.delay-4 { animation-delay: 0.4s; }
</style>
</head>
<body>

<!-- =====================
     HEADER
     ===================== -->
<header>
  <a href="#" class="logo">
  <div class="container">
    <div class="header-top">
      <!-- Logo -->
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" fill="white">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
        </div>
        <span class="logo-text">OPTI<span>LEARNING</span></span>
      </a>

      <!-- Desktop Actions -->
      <div class="header-actions">
        <a href="{{route('login')}}" class="btn-login">Connexion</a>
        <a href="{{route('register')}}" class="btn-signup">Inscription gratuite</a>
      </div>

      <!-- Hamburger -->
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <!-- Desktop Nav -->
  <div class="nav-wrapper">
    <div class="container">
      <nav>
        <a href="#" class="active">Accueil</a>
        <a href="#formations">Formations</a>
        <a href="#categories">Catégories</a>
        <a href="#">Formateurs</a>
        <a href="#">Tarifs</a>
        <a href="#">Blog</a>
        <a href="#">Contact</a>
      </nav>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <a href="#" class="active">Accueil</a>
    <a href="#formations">Formations</a>
    <a href="#categories">Catégories</a>
    <a href="#">Formateurs</a>
    <a href="#">Tarifs</a>
    <a href="#">Blog</a>
    <a href="#">Contact</a>
    <div class="mobile-auth">
      <a href="{{route('login')}}" class="btn-login" style="display:block; text-decoration: none;">Connexion</a>
      <a href="{{route('register')}}" class="btn-signup" style="display:block; text-decoration: none;">Inscription</a>
    </div>
  </div>
</header>


<!-- =====================
     SEARCH
     ===================== -->
<section class="search-section">
  <div class="container">
    <div class="search-hero-text">
      <h2>Trouvez la formation qui va transformer votre carrière</h2>
      <p>Plus de 109 formations disponibles · Paiement Mobile Money accepté</p>
    </div>
    <form action="{{ route('home') }}" method="GET" class="search-bar">
      <div class="search-icon-wrap">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#8896AE" stroke-width="2" stroke-linecap="round">
          <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
      </div>
      <input class="search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Ex : Excel, Python, Marketing Digital…" id="searchInput">
      <select class="search-select" name="category" id="catFilter">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-search">Rechercher</button>
    </form>
    <div class="search-tags">
      <a href="{{ route('home', ['search' => 'Python']) }}" class="search-tag text-decoration-none">Python</a>
      <a href="{{ route('home', ['search' => 'Excel']) }}" class="search-tag text-decoration-none">Excel Avancé</a>
      <a href="{{ route('home', ['search' => 'Marketing']) }}" class="search-tag text-decoration-none">Marketing Digital</a>
      <a href="{{ route('home', ['search' => 'Comptabilité']) }}" class="search-tag text-decoration-none">Comptabilité</a>
      <a href="{{ route('home', ['search' => 'React']) }}" class="search-tag text-decoration-none">React JS</a>
    </div>
  </div>
</section>

@if(isset($searchResults))
<!-- =====================
     RÉSULTATS RECHERCHE / CATALOGUE
     ===================== -->
<section class="all-courses-section" style="padding-top: 40px; min-height: 60vh;">
  <div class="container">
    <div class="section-header">
      <div>
        <span class="section-tag">Résultats</span>
        <h2 class="section-title">
          @if(request('all'))
             Toutes les <span class="accent">formations</span>
          @elseif(request('search') && request('category'))
             Recherche : <span class="accent">{{ request('search') }}</span>
          @elseif(request('search'))
             Recherche pour : <span class="accent">{{ request('search') }}</span>
          @elseif(request('category'))
             Catégorie : <span class="accent">{{ $categories->firstWhere('id', request('category'))->name ?? 'Sélectionnée' }}</span>
          @else
             Catalogue de <span class="accent">formations</span>
          @endif
        </h2>
        <p class="section-sub">{{ $searchResults->total() }} formation(s) trouvée(s)</p>
      </div>
      <a href="{{ route('home') }}" class="see-all" style="background:#F4F6FB; padding:8px 16px; border-radius:20px; color:#122255;">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="transform: rotate(180deg); margin-right:4px;"><path d="M5 12h14M12 5l7 7-7 7"/></svg> Retour à l'accueil
      </a>
    </div>

    @if($searchResults->count() > 0)
    <div class="courses-wrapper">
      <button class="scroll-btn scroll-btn-left" aria-label="Précédent" onclick="this.nextElementSibling.scrollBy({left: -300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <div class="courses-grid">
      @foreach($searchResults as $course)
      <div class="course-card">
          <div class="card-thumb" style="overflow: hidden; position: relative;">
            @if($course->thumbnail)
              <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <div class="card-thumb-bg"></div>
            @endif
          </div>
          <div class="card-body">
            <div class="card-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
            <div class="card-title" style="min-height:42px;">{{ $course->title }}</div>
            <div class="card-instructor"><span class="instructor-dot"></span>Par {{ $course->formateur->user->first_name ?? 'Inconnu' }}</div>
            <div class="card-meta">
              <span>{{ $course->duration_minutes }} min</span>
            </div>
            <div class="card-divider"></div>
            <div class="card-footer">
              <div class="price-block">
                <span class="price-new">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
              </div>
              <a href="{{ route('courses.show', $course->id) }}" class="btn-voir" style="display: inline-block; text-align: center;">Voir</a>
            </div>
          </div>
        </div>
      @endforeach
      </div>
      <button class="scroll-btn scroll-btn-right" aria-label="Suivant" onclick="this.previousElementSibling.scrollBy({left: 300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
    
    <!-- Pagination -->
    @if ($searchResults->hasPages())
    <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
        @if ($searchResults->onFirstPage())
            <span style="padding: 8px 16px; background: #eee; border-radius: 8px; color: #888; cursor: not-allowed; opacity: 0.6;">Précédent</span>
        @else
            <a href="{{ $searchResults->previousPageUrl() }}" style="padding: 8px 16px; background: var(--orange); color: white; border-radius: 8px; font-weight: bold; transition: background 0.2s;">Précédent</a>
        @endif

        @if ($searchResults->hasMorePages())
            <a href="{{ $searchResults->nextPageUrl() }}" style="padding: 8px 16px; background: var(--orange); color: white; border-radius: 8px; font-weight: bold; transition: background 0.2s;">Suivant</a>
        @else
            <span style="padding: 8px 16px; background: #eee; border-radius: 8px; color: #888; cursor: not-allowed; opacity: 0.6;">Suivant</span>
        @endif
    </div>
    @endif

    @else
      <div style="text-align: center; padding: 60px 20px; background: #F4F6FB; border-radius: 20px; border: 1px dashed #ccc;">
          <svg style="width: 64px; height: 64px; margin: 0 auto 16px; color: #8896AE;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h3 style="font-size: 20px; font-weight: bold; color: var(--navy); margin-bottom: 8px;">Aucune formation trouvée</h3>
          <p style="color: var(--gray-text);">Essayez de modifier vos critères de recherche ou de changer de catégorie.</p>
          <a href="{{ route('home') }}" class="btn-cta" style="margin-top: 24px;">Effacer les filtres</a>
      </div>
    @endif
  </div>
</section>

@else


<!-- =====================
     CAROUSEL – FORMATIONS RÉCENTES
     ===================== -->
<section class="carousel-section" id="formations">
  <div class="container">
    <div class="section-header">
      <div>
        <span class="section-tag" style="background:#EAF3DE; color:#3B6D11;">🆕 Nouveautés</span>
        <h2 class="section-title">Nouvelles <span class="accent">formations</span></h2>
        <p class="section-sub">Découvrez les derniers cours ajoutés par nos formateurs experts</p>
      </div>
      <a href="{{ route('home', ['all' => 1]) }}" class="see-all">Tout voir <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>

    <div class="courses-wrapper">
      <button class="scroll-btn scroll-btn-left" aria-label="Précédent" onclick="this.nextElementSibling.scrollBy({left: -300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <div class="courses-grid" id="carouselTrack">

        @forelse($recentCourses as $course)
        <div class="course-card">
          <div class="card-thumb" style="overflow: hidden; position: relative;">
            @if($course->thumbnail)
              <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <div class="card-thumb-bg"></div>
            @endif
          </div>
          <div class="card-body">
            <div class="card-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
            <div class="card-title">{{ $course->title }}</div>
            <div class="card-instructor"><span class="instructor-dot"></span>Par {{ $course->formateur->user->first_name ?? 'Inconnu' }}</div>
            <div class="card-meta">
              <span>{{ $course->duration_minutes }} min</span>
            </div>
            <div class="card-divider"></div>
            <div class="card-footer">
              <div class="price-block">
                <span class="price-new">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
              </div>
              <a href="{{ route('courses.show', $course->id) }}" class="btn-voir" style="display: inline-block; text-align: center;">Voir la formation</a>
            </div>
          </div>
        </div>
        @empty
        <!-- Card Par Défaut (si aucune formation approuvée) -->
        <div class="course-card">
          <div class="card-thumb"><div class="card-thumb-bg"></div></div>
          <div class="card-body">
            <div class="card-title">Aucune formation disponible pour le moment</div>
            <p class="text-sm text-gray-500">Revenez plus tard pour découvrir nos nouvelles formations !</p>
          </div>
        </div>
        @endforelse
      </div><!-- end courses-grid -->
      <button class="scroll-btn scroll-btn-right" aria-label="Suivant" onclick="this.previousElementSibling.scrollBy({left: 300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div><!-- end courses-wrapper -->
  </div>
</section>


<!-- =====================
     CATEGORIES
     ===================== -->
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

      @php
        $catStyles = [
          ['bg' => '#E6F1FB', 'color' => '#185FA5', 'icon' => '<path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 2h5v2h-5V6zm0 3h5v2h-5V9zm0 3h5v2h-5v-2zM4 6h10v8H4V6zm0 10h16v2H4v-2z"/>'],
          ['bg' => '#FFF0E6', 'color' => '#F97316', 'icon' => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>'],
          ['bg' => '#EAF3DE', 'color' => '#3B6D11', 'icon' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>'],
          ['bg' => '#EEEDFE', 'color' => '#534AB7', 'icon' => '<path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>'],
          ['bg' => '#E6F1FB', 'color' => '#185FA5', 'icon' => '<path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/>'],
          ['bg' => '#FAECE7', 'color' => '#D85A30', 'icon' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>']
        ];
      @endphp
      
      @forelse($categories as $index => $cat)
        @php $style = $catStyles[$index % count($catStyles)]; @endphp
        <a href="{{ route('home', ['category' => $cat->id]) }}" class="cat-card block text-decoration-none">
          <div class="cat-icon" style="background:{{ $style['bg'] }}">
            <svg viewBox="0 0 24 24" fill="{{ $style['color'] }}">{!! $style['icon'] !!}</svg>
          </div>
          <div class="cat-name">{{ $cat->name }}</div>
          <div class="cat-count">{{ $cat->courses_count }} formation(s)</div>
        </a>
      @empty
        <div class="col-span-full text-center text-gray-500 py-8">Aucune catégorie disponible.</div>
      @endforelse

    </div>
  </div>
</section>


<!-- =====================
     FORMATIONS POPULAIRES
     ===================== -->
<section class="all-courses-section">
  <div class="container">
    <div class="section-header">
      <div>
        <span class="section-tag" style="background:#FFF0E6; color:#F97316;">⭐ Tendance</span>
        <h2 class="section-title">Formations les plus <span class="accent">populaires</span></h2>
        <p class="section-sub">Basées sur le nombre d'apprenants inscrits</p>
      </div>
      <a href="{{ route('home', ['all' => 1]) }}" class="see-all">Voir tout le catalogue <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="courses-wrapper">
      <button class="scroll-btn scroll-btn-left" aria-label="Précédent" onclick="this.nextElementSibling.scrollBy({left: -300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <div class="courses-grid" id="coursesGrid">

      @forelse($popularCourses as $course)
        <div class="mini-card relative" style="position: relative;">
          <a href="{{ route('courses.show', $course->id) }}" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 10;"></a>
          <div class="mini-thumb" style="overflow:hidden">
            @if($course->thumbnail)
              <img src="{{ asset($course->thumbnail) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
              <div class="mini-thumb-bg"></div>
              <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
            @endif
          </div>
          <div class="mini-body">
            <div class="mini-cat">{{ $course->category ? $course->category->name : 'Général' }}</div>
            <div class="mini-title" style="min-height: 42px;">{{ $course->title }}</div>
            <div class="mini-footer" style="display:flex; flex-direction: column; align-items:flex-start; gap: 4px;">
              <span class="mini-price">{{ $course->price > 0 ? number_format($course->price, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}</span>
              <span class="mini-stars text-orange-500 font-bold" style="font-size:12px;"><i class="fas fa-users" style="margin-right:2px;"></i> {{ $course->orders_count }} inscrit(s)</span>
            </div>
          </div>
        </div>
      @empty
        <div class="col-span-full text-center text-gray-500 py-8" style="grid-column: 1 / -1;">Aucune formation pour l'instant.</div>
      @endforelse

      </div>
      <button class="scroll-btn scroll-btn-right" aria-label="Suivant" onclick="this.previousElementSibling.scrollBy({left: 300, behavior: 'smooth'})">
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>
  </div>
</section>

@endif

<!-- =====================
     STATS
     ===================== -->
<section class="stats-section" id="stats">
  <div class="container">
    <div class="stats-inner">
      <div class="stats-text">
        <span class="section-tag" style="background:rgba(249,115,22,0.15); color:var(--orange)">Pourquoi nous choisir</span>
        <h2>Rejoignez des milliers d'<span class="accent">apprenants</span> qui transforment leur carrière</h2>
        <p>Des formations conçues pour l'Afrique, accessibles depuis votre smartphone. Payez avec MTN Money, Moov Money ou carte bancaire. Apprenez à votre rythme.</p>
        <div class="stats-features">
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
            Certifications reconnues et téléchargeables en PDF
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
            Paiement Mobile Money (MTN, Moov) et Carte Bancaire
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
            Accès illimité à vie après achat, 100% mobile
          </div>
          <div class="feature-item">
            <div class="feature-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
            Formateurs experts locaux et internationaux
          </div>
        </div>
        <button class="btn-cta">
          Commencer gratuitement
          <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>

      <div class="stats-grid">
        <div class="stat-card">
          <span class="stat-num" data-target="12500" data-suffix="+">0</span>
          <div class="stat-label">Apprenants actifs</div>
        </div>
        <div class="stat-card">
          <span class="stat-num" data-target="109" data-suffix="">0</span>
          <div class="stat-label">Formations disponibles</div>
        </div>
        <div class="stat-card">
          <span class="stat-num" data-target="48" data-suffix="">0</span>
          <div class="stat-label">Formateurs experts</div>
        </div>
        <div class="stat-card">
          <span class="stat-num" data-target="97" data-suffix="%">0</span>
          <div class="stat-label">Taux de satisfaction</div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- =====================
     TESTIMONIALS
     ===================== -->
<section class="testimonials-section">
  <div class="container">
    <div class="section-header">
      <div>
        <span class="section-tag">Témoignages</span>
        <h2 class="section-title">Ce que disent nos <span class="accent">apprenants</span></h2>
      </div>
    </div>
    <div class="testi-grid">

      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-text">"Grâce à OptiLearning, j'ai pu me former en Python pendant mes pauses déjeuner. La qualité est au rendez-vous et le certificat m'a ouvert des portes professionnelles !"</p>
        <div class="testi-author">
          <div class="testi-avatar" style="background:#E6F1FB;color:#185FA5">KA</div>
          <div><div class="testi-name">Kofi Ametowoba</div><div class="testi-role">Développeur – Lomé, Togo</div></div>
        </div>
      </div>

      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-text">"Le paiement MTN Mobile Money m'a facilité la vie. J'ai payé ma formation en 2 secondes et j'ai eu accès immédiatement. Plateforme top !"</p>
        <div class="testi-author">
          <div class="testi-avatar" style="background:#FFF0E6;color:#F97316">FN</div>
          <div><div class="testi-name">Fatoumata Ndiaye</div><div class="testi-role">Entrepreneuse – Dakar, Sénégal</div></div>
        </div>
      </div>

      <div class="testi-card">
        <div class="testi-stars">★★★★★</div>
        <p class="testi-text">"La formation Comptabilité est exactement ce dont j'avais besoin. Les exercices pratiques et les quiz m'ont beaucoup aidé à progresser rapidement."</p>
        <div class="testi-author">
          <div class="testi-avatar" style="background:#EEEDFE;color:#534AB7">RH</div>
          <div><div class="testi-name">Romuald Hounkpè</div><div class="testi-role">Comptable – Cotonou, Bénin</div></div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- =====================
     FOOTER
     ===================== -->
<footer>
  <div class="container">
    <div class="footer-grid">

      <div class="footer-brand">
        <div class="footer-logo-wrap">
          <div class="logo-icon" style="width:34px;height:34px">
            <svg viewBox="0 0 24 24" fill="white" style="width:18px;height:18px"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
          </div>
          <span class="footer-logo-text">OPTI<span>LEARNING</span></span>
        </div>
        <p class="footer-desc">La plateforme de formation en ligne pensée pour l'Afrique. Des cours certifiants accessibles depuis votre téléphone, payables par Mobile Money.</p>
        <div class="payment-badges">
          <span class="pay-badge">MTN Money</span>
          <span class="pay-badge">Moov Money</span>
          <span class="pay-badge">Visa / MasterCard</span>
        </div>
        <div class="social-links">
          <!-- Facebook -->
          <button class="social-btn" title="Facebook">
            <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
          </button>
          <!-- Twitter/X -->
          <button class="social-btn" title="Twitter">
            <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
          </button>
          <!-- LinkedIn -->
          <button class="social-btn" title="LinkedIn">
            <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
          </button>
          <!-- YouTube -->
          <button class="social-btn" title="YouTube">
            <svg viewBox="0 0 24 24"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.95C18.88 4 12 4 12 4s-6.88 0-8.59.47A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" style="fill:#060E24"/></svg>
          </button>
          <!-- WhatsApp -->
          <button class="social-btn" title="WhatsApp">
            <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </button>
          <!-- Instagram -->
          <button class="social-btn" title="Instagram">
            <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" style="fill:#060E24"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5" style="stroke:#060E24;stroke-width:2;stroke-linecap:round"/></svg>
          </button>
        </div>
      </div>

      <div class="footer-col">
        <h4>Formations</h4>
        <a href="#">Informatique</a>
        <a href="#">Marketing Digital</a>
        <a href="#">Développement</a>
        <a href="#">Comptabilité</a>
        <a href="#">Entrepreneuriat</a>
        <a href="#">Dév. Personnel</a>
      </div>

      <div class="footer-col">
        <h4>Plateforme</h4>
        <a href="#">Comment ça marche</a>
        <a href="#">Devenir formateur</a>
        <a href="#">Tarifs & Paiement</a>
        <a href="#">Mobile Money</a>
        <a href="#">Certificats</a>
        <a href="#">FAQ</a>
      </div>

      <div class="footer-col">
        <h4>Entreprise</h4>
        <a href="#">À propos de nous</a>
        <a href="#">Blog & Actualités</a>
        <a href="#">Nos formateurs</a>
        <a href="#">Partenaires</a>
        <a href="#">Contact</a>
        <a href="#">Politique de confidentialité</a>
      </div>

    </div>

    <div class="footer-bottom">
      <span class="footer-copy">© 2026 OptiLearning. Tous droits réservés. Conçu avec ❤️ pour l'Afrique.</span>
      <div class="footer-links">
        <a href="#">CGU</a>
        <a href="#">Confidentialité</a>
        <a href="#">Cookies</a>
        <a href="#">Mentions légales</a>
      </div>
    </div>
  </div>
</footer>


<!-- =====================
     JAVASCRIPT
     ===================== -->
<script>
/* ---- HAMBURGER ---- */
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('open');
  mobileMenu.classList.toggle('open');
});

/* ---- SEARCH ---- */
function fillSearch(val) {
  document.getElementById('searchInput').value = val;
  document.getElementById('searchInput').focus();
}
function doSearch() {
  const q = document.getElementById('searchInput').value.trim();
  if (q) alert('Recherche lancée pour : "' + q + '"');
}
document.getElementById('searchInput').addEventListener('keydown', e => {
  if (e.key === 'Enter') doSearch();
});

/* ---- CAROUSEL LOGIC ---- */
/* Not needed anymore as we use native smooth scrolling grids */

/* ---- STATS COUNTER ---- */
(function() {
  const counters = document.querySelectorAll('.stat-num[data-target]');
  let triggered  = false;

  function animate() {
    counters.forEach(el => {
      const target = parseInt(el.dataset.target);
      const suffix = el.dataset.suffix || '';
      const duration = 1400;
      const step = target / (duration / 16);
      let val = 0;
      const timer = setInterval(() => {
        val += step;
        if (val >= target) { val = target; clearInterval(timer); }
        el.textContent = Math.round(val).toLocaleString('fr-FR') + suffix;
      }, 16);
    });
  }

  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting && !triggered) {
      triggered = true;
      animate();
    }
  }, { threshold: 0.3 });

  const statsSection = document.getElementById('stats');
  if (statsSection) observer.observe(statsSection);
})();
</script>

</body>
</html>
