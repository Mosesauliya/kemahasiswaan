<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Riwayat Pengajuan TAK - Kemahasiswaan FIK | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <style>
        /* ========== RESET & GLOBAL ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1f2937;
            overflow-x: hidden;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --blue: #1e3a8a;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 16px 48px rgba(249, 115, 22, 0.12);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--orange);
            border-radius: 10px;
        }

        .container-custom {
            width: min(100% - 3rem, 1280px);
            margin-inline: auto;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ========== HEADER GLASS ========== */
        .header-glass {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            z-index: 50;
            transition: all 0.3s ease;
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
            transition: all 0.3s ease;
        }

        .navbar-glass.scrolled {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(25px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(145deg, var(--orange), var(--orange-dark));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.4rem;
            box-shadow: 0 6px 12px rgba(249,115,22,0.3);
        }

        .logo-text h5 {
            font-size: 0.9rem;
            font-weight: 800;
            color: white;
            margin: 0;
            letter-spacing: -0.3px;
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
            position: relative;
            padding-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--orange);
            transition: 0.3s ease;
        }

        .nav-links a.active::after,
        .nav-links a:hover::after {
            width: 100%;
        }

        /* Dropdown Menu */
        .nav-item-dropdown {
            position: relative;
        }
        
        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 0.8rem 0;
            min-width: 240px;
            border: 1px solid rgba(255,255,255,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }
        
        .nav-item-dropdown:hover .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .dropdown-menu-custom a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        
        .dropdown-menu-custom a::after {
            display: none;
        }
        
        .dropdown-menu-custom a:hover {
            background: rgba(249,115,22,0.3);
            color: var(--orange);
            padding-left: 28px;
        }
        
        .dropdown-menu-custom i {
            width: 24px;
            font-size: 1.1rem;
            color: var(--orange);
        }
        
        .dropdown-toggle-icon {
            margin-left: 6px;
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }
        
        .nav-item-dropdown:hover .dropdown-toggle-icon {
            transform: rotate(180deg);
        }

        .btn-mytelu-custom {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            padding: 8px 28px;
            border-radius: 40px;
            font-weight: 700;
            color: white;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-mytelu-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(249, 115, 22, 0.4);
            color: white;
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
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

        /* ========== BACK BUTTON ========== */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: var(--orange);
            padding: 10px 24px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 2px solid var(--orange);
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: var(--orange);
            color: white;
            transform: translateX(-4px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        /* ========== HERO SECTION ========== */
        .hero-riwayat {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        .hero-riwayat::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-riwayat .wave-bottom {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-riwayat h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: white;
            text-align: center;
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .hero-riwayat p {
            color: rgba(255,255,255,0.95);
            font-size: 1.2rem;
            text-align: center;
            max-width: 700px;
            margin: 16px auto 0;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        /* ========== FLOATING ELEMENTS ========== */
        .floating-elements {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .floating-elements .element {
            position: absolute;
            opacity: 0.15;
            color: white;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-elements .element:nth-child(1) {
            top: 15%;
            left: 5%;
            font-size: 3rem;
            animation-delay: 0s;
        }
        
        .floating-elements .element:nth-child(2) {
            top: 60%;
            right: 8%;
            font-size: 2.5rem;
            animation-delay: 1s;
        }
        
        .floating-elements .element:nth-child(3) {
            bottom: 20%;
            left: 10%;
            font-size: 2rem;
            animation-delay: 0.5s;
        }
        
        .floating-elements .element:nth-child(4) {
            top: 30%;
            right: 15%;
            font-size: 2.8rem;
            animation-delay: 1.5s;
        }

        /* ========== RIWAYAT SECTION ========== */
        .riwayat-section {
            padding: 60px 0 80px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            position: relative;
            display: inline-block;
            padding-bottom: 16px;
            font-family: 'Playfair Display', serif;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            border-radius: 2px;
        }

        /* ========== ACTION BUTTONS ========== */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .btn-pengajuan {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .btn-pengajuan:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
            color: white;
        }

        /* ========== STATUS BADGE ========== */
        .status-badge {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-diproses {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-disetujui {
            background: #d1fae5;
            color: #065f46;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ========== TABLE ========== */
        .table-container {
            background: white;
            border-radius: 28px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .table-container:hover {
            box-shadow: 0 25px 50px -12px rgba(249,115,22,0.15);
        }

        .table-container .table {
            margin-bottom: 0;
        }

        .table-container .table thead th {
            background: #f8fafc;
            color: #1f2937;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 18px 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-container .table tbody td {
            padding: 16px 20px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .table-container .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-container .table tbody tr {
            transition: all 0.3s ease;
        }

        .table-container .table tbody tr:hover td {
            background: #faf9f7;
            transform: scale(1.01);
        }

        /* ========== BUTTON DETAIL ========== */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            background: var(--orange);
            color: white;
            border: 2px solid var(--orange);
        }

        .btn-detail:hover {
            background: transparent;
            color: var(--orange);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            background: white;
            border-radius: 28px;
            padding: 64px 32px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            box-shadow: 0 25px 50px -12px rgba(249,115,22,0.15);
        }

        .empty-state .icon-wrapper {
            width: 100px;
            height: 100px;
            background: linear-gradient(145deg, var(--orange-light), #fff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state .icon-wrapper i {
            font-size: 3rem;
            color: var(--orange);
        }

        .empty-state h3 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.5rem;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        /* ========== STATS CARD ========== */
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .stats-card i {
            font-size: 2rem;
            color: var(--orange);
            margin-bottom: 12px;
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
        }

        .stats-card .stats-label {
            color: #6b7280;
            font-size: 0.85rem;
        }

        /* ========== PAGINATION ========== */
        .pagination-container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .pagination {
            gap: 8px;
        }

        .pagination .page-link {
            border-radius: 12px;
            padding: 10px 16px;
            color: #1f2937;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .pagination .page-link:hover {
            background: var(--orange);
            color: white;
            border-color: var(--orange);
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: var(--orange);
            border-color: var(--orange);
            color: white;
            box-shadow: 0 4px 12px rgba(249,115,22,0.3);
        }

        /* ========== FOOTER ========== */
        .footer {
            background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer a:hover {
            color: var(--orange);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .stats-card .stats-number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .header-glass {
                top: 12px;
            }
            .navbar-glass {
                padding: 12px 20px;
                border-radius: 40px;
            }
            .nav-links {
                display: none;
                flex-direction: column;
                align-items: center;
                margin-top: 16px;
                gap: 16px;
                width: 100%;
            }
            .nav-links.open {
                display: flex !important;
            }
            .mobile-toggle {
                display: block;
            }
            .dropdown-menu-custom {
                position: static;
                opacity: 1;
                visibility: visible;
                transform: none;
                display: none;
                background: transparent;
                backdrop-filter: none;
                padding-left: 20px;
                border: none;
            }
            .dropdown-menu-custom.show-mobile {
                display: block;
            }
            .hero-riwayat {
                padding: 120px 0 60px;
            }
            .hero-riwayat h1 {
                font-size: 2rem;
            }
            .hero-riwayat p {
                font-size: 1rem;
            }
            .action-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            .back-button, .btn-pengajuan {
                justify-content: center;
            }
            .table-container {
                overflow-x: auto;
            }
            .table-container .table thead th,
            .table-container .table tbody td {
                padding: 12px 14px;
                font-size: 0.85rem;
            }
            .status-badge {
                padding: 4px 12px;
                font-size: 0.7rem;
            }
            .btn-detail {
                padding: 6px 14px;
                font-size: 0.8rem;
            }
            .stats-row {
                margin-bottom: 24px;
            }
        }

        @media (max-width: 576px) {
            .container-custom {
                width: min(100% - 1.5rem, 1280px);
            }
            .table-container .table thead th,
            .table-container .table tbody td {
                padding: 10px 12px;
                font-size: 0.75rem;
            }
            .empty-state {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

<!-- ========== HEADER GLASS ========== -->
<header class="header-glass" id="mainHeader">
    <div class="container-custom">
        <div class="navbar-glass" id="navbar">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-palette"></i></div>
                <div class="logo-text">
                    <h5>Unit Kemahasiswaan</h5>
                    <span>Fakultas Industri Kreatif</span>
                </div>
            </div>
            
            <div class="nav-links" id="navLinks">
                <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                <a href="<?= base_url('berita') ?>">Informasi</a>
                
                <!-- Dropdown Layanan -->
                <div class="nav-item-dropdown">
                    <a href="#">Layanan <i class="fas fa-chevron-down dropdown-toggle-icon"></i></a>
                    <div class="dropdown-menu-custom">
                        <a href="<?= base_url('sertifikat') ?>"><i class="fas fa-certificate"></i> Pengajuan Sertifikat</a>
                        <a href="<?= base_url('proposal') ?>"><i class="fas fa-file-alt"></i> Pengajuan Proposal</a>
                        <a href="<?= base_url('beasiswa') ?>"><i class="fas fa-graduation-cap"></i> Pengajuan Beasiswa</a>
                        <a href="<?= base_url('tak') ?>"><i class="fas fa-clipboard-list"></i> Pengajuan TAK</a>
                        <a href="<?= base_url('forum_alumni') ?>"><i class="fas fa-users"></i> Layanan Alumni</a>
                    </div>
                </div>
                
                <a href="#">Forum Alumni</a>
                <a href="#" class="active">Riwayat TAK</a>
            </div>
            
            <?php 
            // Safe user data check
            $is_logged_in = isset($user_data) && is_array($user_data) && isset($user_data['logged_in']) && $user_data['logged_in'] === true;
            if($is_logged_in): 
            ?>
                <a href="<?= base_url('dashboard/profile') ?>" class="btn-mytelu-custom">
                    <?php if(!empty($user_data['foto'])): ?>
                        <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" class="user-avatar-small">
                    <?php else: ?>
                        <i class="fas fa-user-circle"></i>
                    <?php endif; ?>
                    <?= isset($user_data['nama']) ? htmlspecialchars($user_data['nama']) : 'User' ?>
                </a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-mytelu-custom">
                    <i class="fas fa-sign-in-alt"></i> MyTeLU
                </a>
            <?php endif; ?>
            
            <button class="mobile-toggle" id="mobileNavBtn"><i class="fas fa-bars"></i></button>
        </div>
    </div>
</header>

<!-- ========== HERO SECTION ========== -->
<section class="hero-riwayat">
    <div class="floating-elements">
        <div class="element"><i class="fas fa-clipboard-list"></i></div>
        <div class="element"><i class="fas fa-file-alt"></i></div>
        <div class="element"><i class="fas fa-history"></i></div>
        <div class="element"><i class="fas fa-check-circle"></i></div>
    </div>
    <div class="container-custom">
        <h1 data-aos="fade-up">Riwayat Pengajuan TAK</h1>
        <p data-aos="fade-up" data-aos-delay="100">Pantau status pengajuan TAK Kolektif yang telah Anda kirimkan</p>
    </div>
    <div class="wave-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- ========== MAIN CONTENT ========== -->
<section class="riwayat-section">
    <div class="container-custom">
        
        <!-- ===== TOMBOL KEMBALI ===== -->
        <a href="<?= base_url('dashboard') ?>" class="back-button" data-aos="fade-right">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <!-- ===== SECTION TITLE ===== -->
        <div class="section-title" data-aos="fade-up">
            <h2>Daftar Riwayat Pengajuan</h2>
            <p class="text-muted mt-3">Semua pengajuan TAK Kolektif yang pernah Anda buat</p>
        </div>

        <!-- ===== STATISTICS CARDS ===== -->
        <div class="row g-4 mb-5 stats-row" data-aos="fade-up">
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <i class="fas fa-file-alt"></i>
                    <div class="stats-number"><?= isset($total_pengajuan) ? $total_pengajuan : 0 ?></div>
                    <div class="stats-label">Total Pengajuan</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <i class="fas fa-clock"></i>
                    <div class="stats-number"><?= isset($total_pending) ? $total_pending : 0 ?></div>
                    <div class="stats-label">Menunggu</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <i class="fas fa-spinner"></i>
                    <div class="stats-number"><?= isset($total_diproses) ? $total_diproses : 0 ?></div>
                    <div class="stats-label">Diproses</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="stats-number"><?= isset($total_disetujui) ? $total_disetujui : 0 ?></div>
                    <div class="stats-label">Disetujui</div>
                </div>
            </div>
        </div>

        <!-- ===== ACTION BUTTONS ===== -->
        <div class="action-buttons" data-aos="fade-up">
            <div></div> <!-- Spacer -->
            <a href="<?= base_url('tak') ?>" class="btn-pengajuan">
                <i class="fas fa-plus"></i>
                Ajukan TAK Baru
            </a>
        </div>

        <!-- ===== TABLE ===== -->
        <?php if(empty($pengajuan)): ?>
            <div class="empty-state" data-aos="fade-up">
                <div class="icon-wrapper">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Belum Ada Pengajuan</h3>
                <p>Anda belum pernah mengajukan TAK Kolektif</p>
                <a href="<?= base_url('tak') ?>" class="btn-pengajuan">
                    <i class="fas fa-plus"></i>
                    Ajukan TAK Sekarang
                </a>
            </div>
        <?php else: ?>
            <div class="table-container" data-aos="fade-up">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Judul Kegiatan</th>
                            <th>Nama PIC</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $start = isset($current_page) ? ($current_page - 1) * $per_page : 0;
                        foreach($pengajuan as $p): 
                        ?>
                        <tr>
                            <td><?= $start + $no++ ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p->created_at ?? $p['created_at'])) ?></td>
                            <td><?= htmlspecialchars($p->judul_kegiatan ?? $p['judul_kegiatan']) ?></td>
                            <td><?= htmlspecialchars($p->nama_pic ?? $p['nama_pic']) ?></td>
                            <td><?= date('d/m/Y', strtotime($p->tanggal_kegiatan ?? $p['tanggal_kegiatan'])) ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                $status_icon = '';
                                $status_text = '';
                                $status = $p->status ?? $p['status'];
                                switch($status) {
                                    case 'pending':
                                        $status_class = 'status-pending';
                                        $status_icon = 'fa-clock';
                                        $status_text = 'Pending';
                                        break;
                                    case 'diproses':
                                        $status_class = 'status-diproses';
                                        $status_icon = 'fa-spinner fa-spin';
                                        $status_text = 'Diproses';
                                        break;
                                    case 'disetujui':
                                        $status_class = 'status-disetujui';
                                        $status_icon = 'fa-check-circle';
                                        $status_text = 'Disetujui';
                                        break;
                                    case 'ditolak':
                                        $status_class = 'status-ditolak';
                                        $status_icon = 'fa-times-circle';
                                        $status_text = 'Ditolak';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $status_class ?>">
                                    <i class="fas <?= $status_icon ?>"></i>
                                    <?= $status_text ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('tak/detail/' . ($p->id ?? $p['id'])) ?>" class="btn-detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ===== PAGINATION ===== -->
            <?php if(isset($total_pages) && $total_pages > 1): ?>
            <div class="pagination-container" data-aos="fade-up">
                <nav>
                    <ul class="pagination">
                        <?php if($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php 
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);
                        
                        if($start_page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
                            <?php if($start_page > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if($end_page < $total_pages): ?>
                            <?php if($end_page < $total_pages - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?>"><?= $total_pages ?></a></li>
                        <?php endif; ?>
                        
                        <?php if($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container-custom">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Fakultas Industri Kreatif</h4>
                <p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Tautan Cepat</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="mb-2"><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li class="mb-2"><a href="#">Layanan Mahasiswa</a></li>
                    <li class="mb-2"><a href="#">Forum Alumni</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Kontak</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bandung, Jawa Barat</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> fik@telkomuniversity.ac.id</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> (022) 756 5923</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="mb-0">&copy; <?= date('Y') ?> Fakultas Industri Kreatif - Telkom University. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- ========== SCRIPTS ========== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({ duration: 800, once: true, offset: 50 });

    // Mobile toggle
    const mobileBtn = document.getElementById('mobileNavBtn');
    const navLinksDiv = document.getElementById('navLinks');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            navLinksDiv.classList.toggle('open');
            
            // Handle mobile dropdown
            if(navLinksDiv.classList.contains('open')) {
                const dropdown = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
                if(dropdown) dropdown.classList.add('show-mobile');
            } else {
                const dropdown = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
                if(dropdown) dropdown.classList.remove('show-mobile');
            }
        });
    }

    // Mobile dropdown toggle
    if(window.innerWidth <= 768) {
        const dropdownToggle = document.querySelector('.nav-item-dropdown > a');
        if(dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                const dropdownMenu = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
                if(dropdownMenu) dropdownMenu.classList.toggle('show-mobile');
            });
        }
    }

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

</body>
</html>