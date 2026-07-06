<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title>Dashboard FIK - Fakultas Industri Kreatif | Telkom University</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1f2937;
    }

    :root {
      --orange: #f97316;
      --orange-dark: #ea580c;
      --orange-light: #ffedd5;
      --blue: #1e3a8a;
      --gray-bg: #f8fafc;
      --border: #e2e8f0;
    }

    .bg-orange-grad {
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      position: relative;
    }

    .bg-orange-grad::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
      background-size: 32px 32px;
      pointer-events: none;
    }

    .container-custom {
      width: min(100% - 3rem, 1280px);
      margin-inline: auto;
    }

    /* HEADER */
    .header-glass {
      position: absolute;
      top: 24px;
      left: 0;
      right: 0;
      z-index: 50;
    }

    .navbar-glass {
      background: rgba(0, 0, 0, 0.55);
      backdrop-filter: blur(20px);
      border-radius: 60px;
      padding: 12px 32px;
      border: 1px solid rgba(255,255,255,0.15);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .logo-icon {
      width: 48px;
      height: 48px;
      background: #2d3e50;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 1.3rem;
    }

    .logo-text h5 {
      font-size: 0.9rem;
      font-weight: 800;
      color: white;
      margin: 0;
      line-height: 1.2;
    }

    .logo-text span {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.85);
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
      position: relative;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      border-bottom: 2px solid transparent;
      padding-bottom: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .nav-links a.active, .nav-links a:hover {
      border-bottom-color: #f97316;
    }




    .btn-mytelu-custom {
      background: #f97316;
      padding: 8px 28px;
      border-radius: 40px;
      font-weight: 700;
      color: white;
      transition: 0.2s;
      text-decoration: none;
    }

    .btn-mytelu-custom:hover {
      background: #ea580c;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
    }

    .mobile-toggle {
      display: none;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 12px;
      padding: 8px 14px;
      font-size: 1.4rem;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .mobile-toggle:hover {
      background: rgba(255,255,255,0.25);
    }

    /* HERO SECTION */
    .hero-wrap {
      min-height: 100vh;
      padding-top: 160px;
      padding-bottom: 0;
    }

    .hero-flex {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      gap: 40px;
    }

    .hero-title h1 {
      font-size: clamp(3rem, 7vw, 5.8rem);
      font-weight: 500;
      color: white;
      line-height: 1.1;
      max-width: 550px;
      letter-spacing: -0.02em;
    }

    .hero-image-area {
  width: 53%;
  background: transparent;
  backdrop-filter: none;
  border-radius: 0px;
  min-height: 550px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  overflow: hidden;
  position: relative;
}

.hero-image-area img {
  width: 100%;
  height: auto;
  max-height: 550px;
  object-fit: contain;
  transition: transform 0.3s ease;
  border-radius: 0px;
}

    .hero-image-area img:hover {
      transform: scale(1.02);
    }

    .hero-image-placeholder {
      text-align: center;
      color: rgba(255,255,255,0.7);
      padding: 20px;
    }

    .hero-image-placeholder i {
      font-size: 3rem;
      margin-bottom: 10px;
      display: block;
    }

    /* FLOATING BADGES */
    .floating-card {
      position: absolute;
      background: white;
      border-radius: 24px;
      padding: 14px 24px;
      display: flex;
      gap: 16px;
      align-items: center;
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.2);
      z-index: 15;
      transition: transform 0.3s ease;
    }

    .floating-card:hover {
      transform: scale(1.03);
    }

    .badge-abs-1 { top: 15%; left: 52%; }
    .badge-abs-2 { top: 32%; right: 2%; }
    .badge-abs-3 { top: 44%; left: 46%; }

    .badge-icon-orange {
      width: 52px;
      height: 52px;
      background: #fff0e2;
      border-radius: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.9rem;
      color: #f97316;
    }

    /* ACHIEVEMENT CARD */
    .achievement-master {
      background: #f97316;
      border-radius: 48px 48px 0 0;
      margin-top: 0;
      padding: 48px 56px;
      color: white;
      box-shadow: 0 -10px 30px rgba(0,0,0,0.1);
      position: relative;
      z-index: 10;
    }

    .achievement-title {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 48px;
      display: flex;
      gap: 12px;
      align-items: center;
    }

    .stats-three-col {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 48px;
    }

    .big-number {
      font-size: 2.8rem;
      font-weight: 800;
      line-height: 1.2;
      font-family: monospace;
      letter-spacing: 2px;
    }

    .winner-avatar {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: rgba(255,255,255,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
    }

    .winner-avatar i {
      font-size: 2rem;
      color: rgba(255,255,255,0.8);
    }

    .winner-row {
      display: flex;
      flex-direction: column;
      gap: 32px;
    }

    .winner-item-flex {
      display: flex;
      gap: 20px;
      align-items: center;
    }

    /* DIREKTORAT - Updated with image */
.direktorat-card {
  background: white;
  border-radius: 32px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.06);
  margin: 70px auto;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.direktorat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 48px rgba(0,0,0,0.1);
}

.direktorat-img-area {
  background: #eef2ff;
  min-height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.direktorat-img-area img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  min-height: 300px;
}

    /* BERITA CAROUSEL */
    .berita-carousel-container {
      position: relative;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 60px;
      overflow: hidden;
    }

    .berita-carousel {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 500px;
    }

    .berita-card {
      position: absolute;
      width: 380px;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
      transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
    }

    .berita-card.active {
      z-index: 30;
      opacity: 1;
      transform: translateX(0) scale(1);
      filter: blur(0);
      width: 420px;
    }

    .berita-card.right {
      transform: translateX(320px) scale(0.85);
      opacity: 0.9;
      filter: blur(2px);
      z-index: 20;
    }

    .berita-card.left {
      transform: translateX(-320px) scale(0.85);
      opacity: 0.9;
      filter: blur(2px);
      z-index: 20;
    }

    .berita-card.right-far {
      transform: translateX(580px) scale(0.7);
      opacity: 0;
      filter: blur(4px);
      z-index: 10;
      pointer-events: none;
    }

    .berita-card.left-far {
      transform: translateX(-580px) scale(0.7);
      opacity: 0;
      filter: blur(4px);
      z-index: 10;
      pointer-events: none;
    }

    .berita-card-inner {
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .berita-image {
      height: 220px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%);
    }

    .berita-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .berita-card:hover .berita-image img {
      transform: scale(1.05);
    }

    .berita-content {
      padding: 24px;
      flex: 1;
    }

    .berita-category {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.7rem;
      font-weight: 600;
      margin-bottom: 12px;
    }

    .berita-category.berita {
      background: #dbeafe;
      color: #1e40af;
    }

    .berita-category.pengumuman {
      background: #fed7aa;
      color: #9a3412;
    }

    .berita-category.artikel {
      background: #dcfce7;
      color: #166534;
    }

    .berita-title {
      font-size: 1.2rem;
      font-weight: 800;
      margin-bottom: 12px;
      line-height: 1.4;
      color: #1f2937;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .berita-meta {
      display: flex;
      gap: 16px;
      font-size: 0.75rem;
      color: #6b7280;
      margin-bottom: 16px;
    }

    .berita-meta i {
      margin-right: 4px;
    }

    .berita-excerpt {
      font-size: 0.85rem;
      color: #6b7280;
      line-height: 1.5;
      margin-bottom: 20px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .berita-readmore {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #f97316;
      font-weight: 600;
      font-size: 0.85rem;
      text-decoration: none;
      transition: gap 0.3s ease;
    }

    .berita-readmore:hover {
      gap: 12px;
      color: #ea580c;
    }

    .carousel-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: white;
      border: none;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 40;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .carousel-nav:hover {
      background: #f97316;
      color: white;
      box-shadow: 0 6px 16px rgba(249,115,22,0.3);
      transform: scale(1.05);
    }

    .carousel-nav.prev {
      left: 0;
    }

    .carousel-nav.next {
      right: 0;
    }

    .carousel-nav i {
      font-size: 1.2rem;
    }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin-top: 40px;
    }

    .dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #cbd5e1;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .dot.active {
      width: 30px;
      border-radius: 10px;
      background: #f97316;
    }

    /* ORGANISASI SECTION */
    .org-bg-orange {
      position: relative;
      padding: 80px 0;
      color: white;
      overflow: hidden;
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      background-blend-mode: overlay;
    }
    
    .org-bg-orange::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
      background-repeat: repeat;
      background-size: 60px;
      opacity: 0.12;
      pointer-events: none;
      z-index: 0;
    }
    
    .org-bg-orange::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(circle at 20% 40%, rgba(255,255,200,0.15) 2px, transparent 2.5px);
      background-size: 35px 35px;
      pointer-events: none;
      z-index: 0;
    }
    
    .org-bg-orange .container-custom {
      position: relative;
      z-index: 2;
    }

    .org-layout {
      display: flex;
      align-items: flex-start;
      gap: 50px;
    }

    .org-left {
      flex: 0 0 320px;
      position: sticky;
      top: 100px;
    }

    .org-section-title {
      font-size: 2.6rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 16px;
      color: white;
    }

    .org-section-subtitle {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.85);
      line-height: 1.5;
    }

    .org-right {
      flex: 1;
      display: flex;
      gap: 25px;
    }

    .org-col-left {
      flex: 1;
      position: relative;
      height: 550px;
      overflow: hidden;
    }

    .org-col-right {
      flex: 1;
      position: relative;
      height: 550px;
      overflow: hidden;
    }

    .org-scroll-up-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .org-scroll-up-content {
      position: absolute;
      width: 100%;
      animation: scrollUp 25s linear infinite;
    }

    .org-scroll-up-content:hover {
      animation-play-state: paused;
    }

    @keyframes scrollUp {
      0% { transform: translateY(0); }
      100% { transform: translateY(-50%); }
    }

    .org-scroll-down-wrapper {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .org-scroll-down-content {
      position: absolute;
      width: 100%;
      animation: scrollDown 25s linear infinite;
    }

    .org-scroll-down-content:hover {
      animation-play-state: paused;
    }

    @keyframes scrollDown {
      0% { transform: translateY(-50%); }
      100% { transform: translateY(0); }
    }

    .org-grid-one {
      display: grid;
      grid-template-columns: 1fr;
      gap: 18px;
      margin-bottom: 18px;
    }

    .org-card {
      background: white;
      border-radius: 14px;
      padding: 14px 16px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .org-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 22px rgba(0,0,0,0.12);
    }

    .org-logo {
      width: 48px;
      height: 48px;
      min-width: 48px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
      overflow: hidden;
    }

    .org-card:hover .org-logo {
      transform: scale(1.05);
    }

    .org-logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .org-logo.no-image {
      background: linear-gradient(135deg, #ffedd5 0%, #fff7ed 100%);
    }

    .org-logo.no-image i {
      font-size: 1.4rem;
      color: #f97316;
    }

    .org-info {
      flex: 1;
    }

    .org-info h3 {
      font-size: 0.9rem;
      font-weight: 800;
      margin: 0 0 4px 0;
      color: #1f2937;
    }

    .org-info p {
      font-size: 0.72rem;
      color: #6b7280;
      line-height: 1.35;
      margin: 0;
    }

    /* INTERNATIONAL RECOGNITIONS */
    .recognition-section {
      background: white;
      padding: 80px 0;
      text-align: center;
    }

    .recognition-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e3a8a;
      margin-bottom: 16px;
    }

    .recognition-subtitle {
      font-size: 1.1rem;
      color: #4b5563;
      margin-bottom: 48px;
      line-height: 1.5;
    }

    .recognition-logos {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      max-width: 1100px;
      margin: 0 auto;
    }

    .recognition-item {
      background: #f8fafc;
      padding: 20px 25px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
      min-width: 150px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
    }

    .recognition-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
      border-color: #f97316;
    }

    .recognition-item img {
      max-width: 120px;
      max-height: 60px;
      object-fit: contain;
    }

    .recognition-item span {
      font-size: 0.8rem;
      font-weight: 600;
      color: #1f2937;
      text-align: center;
    }

    /* ALUMNI QUOTE */
    .alumni-quote-section {
      position: relative;
      padding: 100px 0;
      color: white;
      overflow: hidden;
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      background-blend-mode: overlay;
      width: 100%;
      margin: 0;
    }
    
    .alumni-quote-section::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: url('https://www.transparenttextures.com/patterns/cartographer.png');
      background-repeat: repeat;
      background-size: 80px;
      opacity: 0.15;
      pointer-events: none;
      z-index: 0;
    }
    
    .alumni-quote-section::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image: radial-gradient(circle at 30% 50%, rgba(255,255,200,0.12) 2px, transparent 2.5px);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: 0;
    }
    
    .alumni-quote-section .container-custom {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 3rem;
    }
    
    .alumni-quote-content {
      max-width: 100%;
      margin: 0;
      text-align: left;
    }
    
    .alumni-quote-section h2 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 16px;
      letter-spacing: -0.02em;
      text-align: left;
    }
    
    .alumni-quote-section p {
      font-size: 1.3rem;
      font-weight: 500;
      opacity: 0.95;
      margin: 0;
      text-align: left;
    }
    
    .quote-icon {
      font-size: 3rem;
      opacity: 0.25;
      margin-bottom: 16px;
      text-align: left;
    }

    /* MITRA KERJASAMA */
    .partner-section {
      padding: 80px 0;
      background: white;
    }

    .partner-layout {
      display: flex;
      align-items: center;
      gap: 60px;
      flex-wrap: wrap;
    }

    .partner-logos {
      flex: 1;
      min-width: 280px;
    }

    .partner-logos-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 25px;
      align-items: center;
    }

    .partner-logo-item {
      background: #f8fafc;
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      transition: all 0.3s ease;
      border: 1px solid #e2e8f0;
      cursor: pointer;
      min-height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .partner-logo-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0,0,0,0.1);
      border-color: #f97316;
    }

    .partner-logo-item img {
      max-width: 100%;
      max-height: 70px;
      object-fit: contain;
    }

    .partner-content {
      flex: 1;
      min-width: 280px;
    }

    .partner-content h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e3a8a;
      margin-bottom: 20px;
    }

    .partner-content p {
      font-size: 1rem;
      color: #4b5563;
      line-height: 1.6;
      margin-bottom: 30px;
    }

    .partner-content .btn-partner {
      background: #f97316;
      color: white;
      padding: 12px 32px;
      border-radius: 40px;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
      border: none;
    }

    .partner-content .btn-partner:hover {
      background: #ea580c;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(249, 115, 22, 0.25);
    }

    footer {
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      height: 80px;
    }

    @media (max-width: 1024px) {
      .stats-three-col { grid-template-columns: 1fr; gap: 28px; }
      .direktorat-card { grid-template-columns: 1fr; }
      .badge-abs-1, .badge-abs-2, .badge-abs-3 { display: none; }
      .org-layout { flex-direction: column; gap: 30px; }
      .org-left { flex: auto; position: static; text-align: center; }
      .org-section-title { font-size: 2rem; text-align: center; }
      .org-right { flex-direction: column; gap: 30px; }
      .org-col-left, .org-col-right { height: 400px; }
      .recognition-title { font-size: 2rem; }
      .alumni-quote-section h2 { font-size: 2.5rem; }
      .alumni-quote-section p { font-size: 1.2rem; }
      .alumni-quote-section { padding: 80px 0; }
      .partner-layout { flex-direction: column; text-align: center; }
      .partner-content { text-align: center; }
      .partner-content h2 { text-align: center; }
      .hero-flex { flex-direction: column; text-align: center; }
      .hero-title h1 { text-align: center; margin: 0 auto; }
      .hero-image-area { width: 80%; margin: 0 auto; min-height: 350px; }
      .achievement-master { border-radius: 32px; margin-top: 30px; }
      .recognition-logos { gap: 20px; }
      .recognition-item { padding: 15px 20px; min-width: 130px; }
    }

    @media (max-width: 768px) {
      .navbar-glass { flex-direction: column; align-items: stretch; }
      .nav-links { display: none; flex-direction: column; align-items: center; margin-top: 12px; gap: 16px; }
      .nav-links.open { display: flex !important; }
      .mobile-toggle { display: block; }
      .hero-image-area { width: 100%; margin-top: 20px; min-height: 280px; }
      .achievement-master { margin-top: 30px; padding: 32px 24px; }
      .hero-title h1 { font-weight: 500; }
      .org-grid-one { gap: 14px; }
      .org-section-title { font-size: 1.6rem; }
      .org-col-left, .org-col-right { height: 400px; }
      .org-card { padding: 12px 14px; }
      .org-logo { width: 42px; height: 42px; min-width: 42px; }
      .org-info h3 { font-size: 0.85rem; }
      .org-info p { font-size: 0.68rem; }
      .recognition-title { font-size: 1.6rem; }
      .recognition-subtitle { font-size: 0.9rem; }
      .recognition-item { padding: 12px 15px; min-width: 110px; }
      .recognition-item img { max-height: 35px; }
      .recognition-item span { font-size: 0.7rem; }
      .alumni-quote-section { padding: 60px 0; }
      .alumni-quote-section h2 { font-size: 2rem; }
      .alumni-quote-section p { font-size: 1rem; }
      .quote-icon { font-size: 2rem; }
      .partner-section { padding: 50px 0; }
      .partner-logos-grid { gap: 15px; }
      .partner-logo-item { padding: 15px; min-height: 80px; }
      .partner-logo-item img { max-height: 50px; }
      .partner-content h2 { font-size: 1.8rem; }
      .partner-content p { font-size: 0.9rem; }
    }


    /* ==================== BERITA CAROUSEL ==================== */
.berita-carousel-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px 60px;
    overflow: hidden;
}

.berita-carousel {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}

.berita-card {
    position: absolute;
    width: 380px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

/* Card tengah (aktif) */
.berita-card.active {
    z-index: 30;
    opacity: 1;
    transform: translateX(0) scale(1);
    filter: blur(0);
    width: 420px;
}

/* Card kanan (posisi 1) */
.berita-card.right {
    transform: translateX(320px) scale(0.85);
    opacity: 0.9;
    filter: blur(2px);
    z-index: 20;
    cursor: pointer;
}

/* Card kiri (posisi -1) */
.berita-card.left {
    transform: translateX(-320px) scale(0.85);
    opacity: 0.9;
    filter: blur(2px);
    z-index: 20;
    cursor: pointer;
}

/* Card jauh kanan */
.berita-card.right-far {
    transform: translateX(580px) scale(0.7);
    opacity: 0;
    filter: blur(4px);
    z-index: 10;
    pointer-events: none;
}

/* Card jauh kiri */
.berita-card.left-far {
    transform: translateX(-580px) scale(0.7);
    opacity: 0;
    filter: blur(4px);
    z-index: 10;
    pointer-events: none;
}

.berita-card-inner {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.berita-image {
    height: 220px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%);
}

.berita-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.berita-card:hover .berita-image img {
    transform: scale(1.05);
}

.berita-content {
    padding: 24px;
    flex: 1;
}

.berita-category {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.berita-category.berita {
    background: #dbeafe;
    color: #1e40af;
}

.berita-category.pengumuman {
    background: #fed7aa;
    color: #9a3412;
}

.berita-category.artikel {
    background: #dcfce7;
    color: #166534;
}

.berita-title {
    font-size: 1.2rem;
    font-weight: 800;
    margin-bottom: 12px;
    line-height: 1.4;
    color: #1f2937;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.berita-meta {
    display: flex;
    gap: 16px;
    font-size: 0.75rem;
    color: #6b7280;
    margin-bottom: 16px;
}

.berita-meta i {
    margin-right: 4px;
}

.berita-excerpt {
    font-size: 0.85rem;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.berita-readmore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #f97316;
    font-weight: 600;
    font-size: 0.85rem;
    text-decoration: none;
    transition: gap 0.3s ease;
}

.berita-readmore:hover {
    gap: 12px;
    color: #ea580c;
}

/* Tombol Navigasi */
.carousel-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: white;
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 40;
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-nav:hover {
    background: #f97316;
    color: white;
    box-shadow: 0 6px 16px rgba(249,115,22,0.3);
}

.carousel-nav.prev {
    left: 0;
}

.carousel-nav.next {
    right: 0;
}

.carousel-nav i {
    font-size: 1.2rem;
}

/* Dots Indicator */
.carousel-dots {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 40px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #cbd5e1;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active {
    width: 30px;
    border-radius: 10px;
    background: #f97316;
}

/* Responsive */
@media (max-width: 1024px) {
    .berita-carousel-container {
        padding: 20px 40px;
    }
    
    .berita-card {
        width: 320px;
    }
    
    .berita-card.active {
        width: 360px;
    }
    
    .berita-card.right {
        transform: translateX(280px) scale(0.85);
    }
    
    .berita-card.left {
        transform: translateX(-280px) scale(0.85);
    }
}

@media (max-width: 768px) {
    .berita-carousel-container {
        padding: 20px 16px;
        overflow: hidden;
    }

    .berita-carousel {
        min-height: 420px;
        touch-action: pan-y;
    }

    /* On mobile: show ONLY the active card; hide all others */
    .berita-card {
        width: calc(100% - 0px);
        max-width: 100%;
    }

    .berita-card.active {
        width: 100%;
        transform: translateX(0) scale(1);
        opacity: 1;
        filter: none;
        z-index: 30;
    }

    .berita-card.right,
    .berita-card.left {
        transform: translateX(0) scale(1);
        opacity: 0;
        pointer-events: none;
        z-index: 10;
    }

    .berita-card.right-far,
    .berita-card.left-far {
        opacity: 0;
        pointer-events: none;
    }

    /* Show nav buttons on mobile as well */
    .carousel-nav {
        display: flex;
        width: 40px;
        height: 40px;
    }

    .carousel-nav.prev { left: 4px; }
    .carousel-nav.next { right: 4px; }

    /* Show dots on mobile */
    .carousel-dots {
        display: flex;
        margin-top: 20px;
    }
}
  </style>
</head>
<body>
<?php $this->load->view('partials/navbar', ['active_menu' => 'dashboard']); ?>

<main>
  <!-- Hero Section -->
  <section class="bg-orange-grad hero-wrap" id="homeSection">
    <div class="container-custom hero-flex">
      <div class="hero-title">
        <h1>Sesuaikan Ke<br>kebutuhanmu</h1>
      </div>
      
      <div class="hero-image-area">
  <img id="heroStudentImage" src="<?= base_url('assets/mahasiswa.png') ?>" alt="Foto Mahasiswa" style="width:100%; height:100%; object-fit:cover; border-radius:0px;" onerror="this.onerror=null; this.style.display='none'; document.getElementById('heroFallback').style.display='flex'">
  <div id="heroFallback" class="hero-image-placeholder" style="display:none; flex-direction:column;">
    <i class="fas fa-user-graduate"></i>
    <p>Foto Mahasiswa Kreatif</p>
    <p style="font-size:12px;">Letakkan mahasiswa.png di folder assets/</p>
  </div>
</div>

      <div class="floating-card badge-abs-1">
        <div class="badge-icon-orange"><i class="fas fa-certificate"></i></div>
        <div><strong>Complete chapters</strong><br>to earn certificates</div>
      </div>
      
      <div class="floating-card badge-abs-2">
        <div class="badge-icon-orange"><i class="fas fa-users"></i></div>
        <div><strong>Forum Alumni</strong><br>Jaringan profesional</div>
      </div>
      
      <div class="floating-card badge-abs-3">
        <div class="badge-icon-orange"><i class="fas fa-chalkboard"></i></div>
        <div><strong>MyTeLU</strong><br>Dashboard interaktif</div>
      </div>
    </div>

    <div class="container-custom" style="padding: 0;">
      <div class="achievement-master" id="achievementCard">
        <div class="achievement-title">
          Mahasiswa Berprestasi <i class="fas fa-arrow-right"></i>
        </div>
        <div class="stats-three-col">
          <div>
            <div class="big-number" id="activeStudents">0</div>
            <div>Mahasiswa Aktif<br>Berdasarkan MR 2025 ganjil<br>Keadaan Tanggal 30 Oktober 2025</div>
            <div class="big-number mt-4" id="countryCount">0</div>
            <div>Negara</div>
          </div>
          
          <div class="winner-row">
            <div class="winner-item-flex">
              <div class="winner-avatar"><i class="fas fa-trophy"></i></div>
              <div>Juara 1 Kategori Ilustrasi Digital dan Juara 3 Kategori Motion Graphic dalam Festival Kreatif Mahasiswa 2025 Cabang Desain Komunikasi Visual, Bandung.</div>
            </div>
            <div class="winner-item-flex">
              <div class="winner-avatar"><i class="fas fa-camera-retro"></i></div>
              <div>Juara 3 Kategori Fotografi Komersial dan Juara 2 Kategori Desain Konten Media Sosial dalam Creative Student Award 2025 Cabang Desain Komunikasi Visual, Malang.</div>
            </div>
          </div>
          
          <div>
            <div class="big-number" id="alumniCount">0</div>
            <div>Alumni<br>Berdasarkan MR 2024</div>
            <div class="d-flex gap-5 mt-4">
              <div><span class="big-number" id="teluDaerah">0</span><br>TelU Daerah</div>
              <div><span class="big-number" id="teluLuar">0</span><br>TelU Luar Negeri</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- DIREKTORAT -->
  <div class="container-custom">
    <div class="direktorat-card">
      <div class="direktorat-img-area">
  <img src="<?= base_url('assets/Direktorat.png') ?>" alt="Direktorat Kemahasiswaan" onerror="...">
</div>
      <div class="p-5">
        <h2 class="fw-bold">Direktorat Kemahasiswaan, Karier, dan Alumni</h2>
        <p class="mt-3">Direktorat Kemahasiswaan, Karier dan Alumni (KKA) merupakan Direktorat yang berfungsi mengelola prestasi, kegiatan mahasiswa, pengembangan karakter, kesejahteraan mahasiswa, pengembangan Karier dan kontribusi alumni. Dengan keberadaan Direktorat KKA diharapkan seluruh mahasiswa dapat mengembangkan minat dan bakat sehingga dapat meningkatkan kompetensi khususnya dalam mempersiapkan diri dalam memasuki dunia kerja.</p>
        <a href="#" class="btn btn-outline-dark rounded-pill px-4">Selengkapnya <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>

<!-- BERITA SECTION -->
<section class="berita-section">
    <div class="container-custom">
        <h2 class="display-5 fw-bold mb-2 text-center">BERITA</h2>
        <p class="text-muted mb-5 text-center">Informasi terbaru dari Fakultas Industri Kreatif</p>
        
        <?php if (isset($berita_list) && !empty($berita_list)): ?>
        <!-- Carousel Berita -->
        <div class="berita-carousel-container">
            <div class="berita-carousel">
                <?php foreach ($berita_list as $index => $item): ?>
                <div class="berita-card <?= $index == 0 ? 'active' : ($index == 1 ? 'right' : '') ?>" data-id="<?= $item['id'] ?>" data-slug="<?= $item['slug'] ?>">
                    <div class="berita-card-inner">
                        <?php if(!empty($item['gambar']) && file_exists('uploads/berita/' . $item['gambar'])): ?>
                            <div class="berita-image">
                                <img src="<?= base_url('uploads/berita/' . $item['gambar']) ?>" alt="<?= htmlspecialchars($item['judul']) ?>">
                            </div>
                        <?php else: ?>
                            <div class="berita-image bg-light">
                                <i class="fas fa-newspaper fa-4x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="berita-content">
                            <span class="berita-category <?= $item['kategori'] ?>">
                                <?= ucfirst($item['kategori']) ?>
                            </span>
                            <h3 class="berita-title"><?= htmlspecialchars($item['judul']) ?></h3>
                            <div class="berita-meta">
                                <span><i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($item['published_at'])) ?></span>
                                <span><i class="fas fa-eye"></i> <?= number_format($item['views']) ?> views</span>
                            </div>
                            <p class="berita-excerpt"><?= htmlspecialchars(strip_tags(substr($item['ringkasan'] ?: $item['konten'], 0, 120))) ?>...</p>
                            <a href="<?= base_url('berita/detail/' . $item['slug']) ?>" class="berita-readmore">
                                Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Tombol Navigasi -->
            <button class="carousel-nav prev" id="prevBerita">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-nav next" id="nextBerita">
                <i class="fas fa-chevron-right"></i>
            </button>
            <a href="<?= base_url('berita') ?>" class="btn btn-outline-dark rounded-pill px-4">Berita Selengkapnya <i class="fas fa-arrow-right"></i></a>
            <!-- Dots Indicator -->
            <div class="carousel-dots">
                <?php foreach ($berita_list as $index => $item): ?>
                <button class="dot <?= $index == 0 ? 'active' : '' ?>" data-index="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Belum Ada Berita</h4>
            <p class="text-muted">Silakan admin menambahkan berita melalui dashboard admin.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

  <!-- ORGANISASI KEMAHASISWAAN -->
  <section class="org-bg-orange">
    <div class="container-custom">
      <div class="org-layout">
        <div class="org-left">
          <h2 class="org-section-title">Daftar Organisasi<br>Kemahasiswaan<br>Universitas Telkom</h2>
          <p class="org-section-subtitle">Bergabung dan kembangkan potensimu bersama 25+ UKM favorit</p>
        </div>
        
        <div class="org-right">
          <div class="org-col-left">
            <div class="org-scroll-up-wrapper">
              <div class="org-scroll-up-content" id="orgLeftContent"></div>
            </div>
          </div>
          <div class="org-col-right">
            <div class="org-scroll-down-wrapper">
              <div class="org-scroll-down-content" id="orgRightContent"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- INTERNATIONAL RECOGNITIONS -->
  <section class="recognition-section">
    <div class="container-custom">
      <h2 class="recognition-title">International Recognitions</h2>
      <p class="recognition-subtitle">As a Research and Entrepreneurial University<br>Telkom University is well-known throughout the world</p>
      <div class="recognition-logos" id="recognitionLogosContainer">
        <!-- Logo akan di-generate oleh JavaScript -->
      </div>
    </div>
  </section>

  <!-- ALUMNI QUOTE -->
  <section class="alumni-quote-section">
    <div class="container-custom">
      <div class="alumni-quote-content">
        <div class="quote-icon"><i class="fas fa-quote-right"></i></div>
        <h2>Apa Kata Alumni</h2>
        <p>Jadilah salah satu orang hebat seperti mereka</p>
      </div>
    </div>
  </section>

  <!-- MITRA KERJASAMA -->
  <section class="partner-section">
    <div class="container-custom">
      <div class="partner-layout">
        <div class="partner-logos">
          <div class="partner-logos-grid" id="partnerLogosGrid"></div>
        </div>
        <div class="partner-content">
          <h2>MITRA KERJASAMA</h2>
          <p>Dalam penyelenggaraan pendidikan tinggi terbuka dan jarak jauh, TelU bekerjasama dengan berbagai pihak dalam berbagai hal, seperti penyediaan beasiswa, fasilitas penunjang dan tenaga ahli</p>
          <a href="#" class="btn-partner">Selengkapnya <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </section>

  <footer></footer>
</main>

<script>
  // ==================== DATA ORGANISASI (UKM) – diambil dari database ====================

  function splitArray(arr) {
    const mid = Math.ceil(arr.length / 2);
    return { left: arr.slice(0, mid), right: arr.slice(mid) };
  }

  function renderGrid(containerId, dataArray, isDuplicated = true) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    let itemsToRender = [...dataArray];
    if (isDuplicated && dataArray.length > 0) {
      itemsToRender = [...dataArray, ...dataArray];
    }

    const gridDiv = document.createElement('div');
    gridDiv.className = 'org-grid-one';

    itemsToRender.forEach((org) => {
      const card = document.createElement('div');
      card.className = 'org-card';

      const logoContent = org.logo
        ? `<img src="${org.logo}" alt="${org.name}" style="width:100%; height:100%; object-fit:cover;" onerror="this.parentElement.classList.add('no-image'); this.remove(); this.parentElement.innerHTML='<i class=\\'${org.icon}\\'></i>'">`
        : `<i class="${org.icon}"></i>`;

      card.innerHTML = `
        <div class="org-logo">
          ${logoContent}
        </div>
        <div class="org-info">
          <h3>${org.name}</h3>
          <p>${org.desc}</p>
        </div>
      `;

      gridDiv.appendChild(card);
    });

    container.appendChild(gridDiv);
  }

  async function renderOrganizations() {
    try {
      const res  = await fetch('<?= base_url('dashboard/get_organisasi_json') ?>');
      const json = await res.json();
      const organizations = (json.status === 'success' && json.data.length > 0) ? json.data : [];
      const { left, right } = splitArray(organizations);
      renderGrid('orgLeftContent', left, true);
      renderGrid('orgRightContent', right, true);
    } catch (e) {
      console.warn('Gagal memuat data organisasi dari server:', e);
    }
  }

  // ==================== DATA MITRA KERJASAMA ====================
  const partners = [
    { name: "Bank BRI", logo: "assets/Bank BRI.png", defaultIcon: "fas fa-university" },
    { name: "BPJS Kesehatan", logo: "assets/BPJS Kesehatan.png", defaultIcon: "fas fa-hospital-user" },
    { name: "Pertamina", logo: "assets/Pertamina.png", defaultIcon: "fas fa-gas-pump" },
    { name: "BRIN", logo: "assets/BRIN.png", defaultIcon: "fas fa-microscope" }
  ];

  function renderPartnerLogos() {
    const container = document.getElementById('partnerLogosGrid');
    if (!container) return;
    container.innerHTML = '';
    
    partners.forEach(partner => {
      const logoDiv = document.createElement('div');
      logoDiv.className = 'partner-logo-item';
      logoDiv.innerHTML = `<img src="${partner.logo}" alt="${partner.name}" style="max-width:100%; max-height:70px;" onerror="this.parentElement.innerHTML='<i class=\\'${partner.defaultIcon}\\' style=\\'font-size:2rem; color:#cbd5e1;\\'></i><div style=\\'font-size:0.7rem; margin-top:8px;\\'>${partner.name}</div>'">`;
      container.appendChild(logoDiv);
    });
  }

  // ==================== DATA INTERNATIONAL RECOGNITIONS (LOGO DARI ASSETS) ====================
  const recognitionItems = [
    { name: "Bank BRI", file: "assets/Bank BRI.png", fallback: "fas fa-chart-line" },
    { name: "Webometri", file: "assets/Webometrics.png", fallback: "fas fa-globe" },
    { name: "Times Higher Education", file: "assets/Times Higher Education.png", fallback: "fas fa-graduation-cap" },
    { name: "Green Metric", file: "assets/Green Metric.png", fallback: "fas fa-leaf" },
    { name: "AppliedHE", file: "assets/AppliedHE.png", fallback: "fas fa-chalkboard-user" },
    { name: "World University Rankings", file: "assets/World University Rankings.png", fallback:   "fas fa-trophy" }
  ];

  function renderRecognitionLogos() {
    const container = document.getElementById('recognitionLogosContainer');
    if (!container) return;
    container.innerHTML = '';
    
    recognitionItems.forEach(item => {
      const logoDiv = document.createElement('div');
      logoDiv.className = 'recognition-item';
      logoDiv.innerHTML = `
        <img src="${item.file}" alt="${item.name}" onerror="this.parentElement.innerHTML='<i class=\\'${item.fallback}\\' style=\\'font-size:2rem; color:#cbd5e1;\\'></i><span>${item.name}</span>'">
        <span>${item.name}</span>
      `;
      container.appendChild(logoDiv);
    });
  }

  // (dummy news data removed – carousel now uses PHP-rendered cards below)

  // ==================== ANIMASI ANGKA ====================
  function animateNumber(element, finalValue, duration = 800) {
    if (!element) return;
    const finalNum = parseInt(finalValue.toString().replace(/,/g, '')) || 0;
    const startNum = 0;
    const startTime = performance.now();
    
    function updateNumber(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeOutCubic = 1 - Math.pow(1 - progress, 3);
      const currentValue = Math.floor(startNum + (finalNum - startNum) * easeOutCubic);
      element.textContent = currentValue.toLocaleString('id-ID');
      if (progress < 1) {
        requestAnimationFrame(updateNumber);
      } else {
        element.textContent = finalNum.toLocaleString('id-ID');
      }
    }
    requestAnimationFrame(updateNumber);
  }
  
  let animationTriggered = false;
  
  function checkAndAnimateNumbers() {
    if (animationTriggered) return;
    const achievementCard = document.getElementById('achievementCard');
    if (!achievementCard) return;
    const rect = achievementCard.getBoundingClientRect();
    const isVisible = rect.top < window.innerHeight - 100 && rect.bottom > 100;
    if (isVisible) {
      animationTriggered = true;
      animateNumber(document.getElementById('activeStudents'), 762918, 800);
      animateNumber(document.getElementById('countryCount'), 50, 600);
      animateNumber(document.getElementById('alumniCount'), 2156104, 900);
      animateNumber(document.getElementById('teluDaerah'), 39, 500);
      animateNumber(document.getElementById('teluLuar'), 1, 500);
    }
  }

  // ==================== CAROUSEL NAVIGATION (placeholder – actual init is below) ====================
  function initCarouselNav() { /* handled by the DOMContentLoaded block below */ }

  // ==================== INITIALIZATION ====================
  document.addEventListener('DOMContentLoaded', function() {
    renderOrganizations();
    renderPartnerLogos();
    renderRecognitionLogos();
    
    window.addEventListener('scroll', checkAndAnimateNumbers);
    setTimeout(checkAndAnimateNumbers, 500);
  });
  // ==================== BERITA CAROUSEL ====================
document.addEventListener('DOMContentLoaded', function() {
    const cards = Array.from(document.querySelectorAll('.berita-card'));
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.getElementById('prevBerita');
    const nextBtn = document.getElementById('nextBerita');
    
    if (!cards.length) return;
    
    let currentIndex = 0;
    const totalCards = cards.length;

    // Give each card a data-index so click-to-activate works
    cards.forEach((card, i) => card.setAttribute('data-index', i));
    
    // Fungsi update posisi card
    function updateCarousel() {
        cards.forEach((card, index) => {
            card.classList.remove('active', 'left', 'right', 'left-far', 'right-far');
            
            const diff = index - currentIndex;
            // Wrap-around distances
            const wrapDiff = ((diff + totalCards) % totalCards <= totalCards / 2)
                ? (diff + totalCards) % totalCards
                : diff - totalCards;

            if (index === currentIndex) {
                card.classList.add('active');
            } else if (wrapDiff === -1) {
                card.classList.add('left');
            } else if (wrapDiff === 1) {
                card.classList.add('right');
            } else if (wrapDiff < -1) {
                card.classList.add('left-far');
            } else {
                card.classList.add('right-far');
            }
        });
        
        // Update active dot
        dots.forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentIndex);
        });
    }
    
    // Navigasi ke berita sebelumnya
    function prevBerita() {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateCarousel();
    }
    
    // Navigasi ke berita selanjutnya
    function nextBerita() {
        currentIndex = (currentIndex + 1) % totalCards;
        updateCarousel();
    }
    
    // Event listeners untuk tombol
    if (prevBtn) prevBtn.addEventListener('click', prevBerita);
    if (nextBtn) nextBtn.addEventListener('click', nextBerita);
    
    // Event listeners untuk dots (PHP-rendered)
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });
    
    // Ketika card diklik
    cards.forEach((card) => {
        const slug = card.dataset.slug;
        card.addEventListener('click', (e) => {
            if (e.target.closest('.berita-readmore')) return;
            if (!card.classList.contains('active')) {
                const idx = parseInt(card.getAttribute('data-index'));
                if (!isNaN(idx)) { currentIndex = idx; updateCarousel(); }
            } else {
                if (slug) window.location.href = "<?= base_url('berita/detail/') ?>" + slug;
            }
        });
    });
    
    // Touch / swipe support
    const carouselEl = document.querySelector('.berita-carousel');
    if (carouselEl) {
        let touchStartX = 0;
        let touchStartY = 0;
        carouselEl.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        carouselEl.addEventListener('touchend', (e) => {
            const dx = e.changedTouches[0].clientX - touchStartX;
            const dy = e.changedTouches[0].clientY - touchStartY;
            // Only fire if horizontal swipe is dominant
            if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                if (dx < 0) nextBerita();
                else prevBerita();
                stopAutoSlide();
                startAutoSlide();
            }
        }, { passive: true });
    }
    
    // Auto slide setiap 5 detik
    let autoSlideInterval;
    
    function startAutoSlide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => {
            if (document.hasFocus()) nextBerita();
        }, 5000);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) { clearInterval(autoSlideInterval); autoSlideInterval = null; }
    }
    
    const container = document.querySelector('.berita-carousel-container');
    if (container) {
        container.addEventListener('mouseenter', stopAutoSlide);
        container.addEventListener('mouseleave', startAutoSlide);
    }
    
    startAutoSlide();
    updateCarousel();
});
</script>

</body>
</html>