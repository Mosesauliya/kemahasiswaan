<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin TAK FIK Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
            color: #2C3E50;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #2C3E50;
        }

        /* ==================== LOADING INDICATOR ==================== */
        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #E67E22, #f39c12, #E67E22);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            z-index: 9999;
            display: none;
        }

        @keyframes loading {
            0% { background-position: 100% 0; }
            100% { background-position: -100% 0; }
        }

        /* ==================== TOP HEADER ==================== */
        .top-header {
            background: linear-gradient(135deg, #2C3E50 0%, #1a2632 100%);
            padding: 0.8rem 2rem;
            border-bottom: 3px solid #E67E22;
        }

        .top-header .brand {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .top-header .brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .top-header .brand .logo-fik {
            height: 50px;
            width: auto;
            object-fit: contain;
            border-left: 2px solid rgba(255,255,255,0.2);
            padding-left: 15px;
        }

        .top-header .brand-text h1 {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .top-header .brand-text p {
            color: #E67E22;
            font-size: 0.8rem;
            margin: 0;
            font-style: italic;
        }

        /* ==================== TOP NAVIGATION ==================== */
        .top-nav {
            background: white;
            padding: 0.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-bottom: 2px solid #E67E22;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
        }

        .nav-links > li > a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 0;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .nav-links > li > a:hover,
        .nav-links > li > a.active {
            color: #E67E22;
        }

        /* ==================== DROPDOWN ==================== */
        .dropdown-container {
            position: relative;
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 250px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 0.5rem 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1000;
            border: 1px solid #eef2f6;
        }

        .dropdown-menu-custom.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            text-decoration: none;
            color: #2C3E50;
            transition: all 0.2s ease;
            gap: 0.8rem;
            font-size: 0.85rem;
        }

        .dropdown-item-custom:hover {
            background: rgba(230, 126, 34, 0.05);
            color: #E67E22;
        }

        .dropdown-item-custom i {
            width: 18px;
            color: #E67E22;
        }

        .dropdown-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 999;
            display: none;
        }

        .dropdown-overlay.show {
            display: block;
        }

        /* ==================== BUTTONS ==================== */
        .btn-custom {
            background: #E67E22;
            color: white;
            padding: 0.4rem 1.2rem;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #E67E22;
            display: inline-block;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-custom:hover {
            background: transparent;
            color: #E67E22;
        }

        .btn-template {
            background: white;
            border: 1px solid #E67E22;
            color: #E67E22;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            text-decoration: none;
        }

        .btn-template:hover {
            background: #E67E22;
            color: white;
        }

        .btn-action {
            background: none;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #2C3E50;
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-action:hover {
            background: #E67E22;
            color: white;
        }

        /* ==================== ADMIN BADGE ==================== */
        .admin-badge {
            background: #E67E22;
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.65rem;
            margin-left: 0.5rem;
            font-weight: 600;
        }

        /* ==================== HERO SECTION ==================== */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg?auto=compress&cs=tinysrgb&w=1920');
            background-size: cover;
            background-position: center;
            padding: 3rem 2rem;
            color: white;
            text-align: center;
        }

        .hero-section h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-section p {
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            opacity: 0.9;
        }

        .welcome-message .badge {
            background: #E67E22 !important;
            color: white !important;
            font-size: 0.85rem;
            padding: 0.4rem 1.2rem;
            border-radius: 30px;
            margin-bottom: 1rem;
        }

        /* ==================== DASHBOARD CARDS ==================== */
        .dashboard-card {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #eef2f6;
            position: relative;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.1);
            border-color: #E67E22;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            background: rgba(230, 126, 34, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.8rem;
        }

        .card-icon i {
            font-size: 1.5rem;
            color: #E67E22;
        }

        .card-label {
            color: #7f8c8d;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.2rem;
        }

        .card-number {
            color: #2C3E50;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
            line-height: 1.2;
        }

        /* ==================== STATS SECTION ==================== */
        .stats-section {
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            border-radius: 10px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 1.2rem;
            text-align: center;
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
            height: 100%;
        }

        .stat-card h2 {
            color: #E67E22;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 0.2rem;
        }

        .stat-card p {
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .stat-card small {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        /* ==================== STATUS BADGES ==================== */
        .status-badge {
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border: none;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-diproses {
            background: #cce5ff;
            color: #004085;
        }

        .status-disetujui {
            background: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
        }

        /* ==================== DATA TABLE ==================== */
        .data-table {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eef2f6;
            margin-bottom: 1.5rem;
        }

        .data-table h5 {
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .data-table h5 i {
            color: #E67E22;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        .table th {
            background: #f8f9fa;
            color: #2C3E50;
            font-weight: 600;
            padding: 0.8rem;
            border-bottom: 2px solid #E67E22;
            text-align: left;
        }

        .table td {
            padding: 0.8rem;
            border-bottom: 1px solid #eef2f6;
        }

        .table tbody tr:hover td {
            background: rgba(230, 126, 34, 0.02);
        }

        /* ==================== ADMIN QUICK ACTIONS ==================== */
        .admin-quick-actions {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            border: 1px solid #eef2f6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .admin-quick-actions h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .admin-quick-actions h3 i {
            color: #E67E22;
        }

        .admin-action-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #eef2f6;
            height: 100%;
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .admin-action-card:hover {
            background: white;
            border-color: #E67E22;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.1);
        }

        .admin-action-card i {
            font-size: 1.5rem;
            color: #E67E22;
            margin-bottom: 0.3rem;
        }

        .admin-action-card h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
            color: #2C3E50;
        }

        .admin-action-card p {
            font-size: 0.7rem;
            color: #7f8c8d;
            margin-bottom: 0;
        }

        /* ==================== EMPTY STATE ==================== */
        .empty-state {
            text-align: center;
            padding: 1.5rem;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 2rem;
            color: #E67E22;
            opacity: 0.3;
            margin-bottom: 0.3rem;
        }

        .empty-state p {
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        /* ==================== ALERT ==================== */
        .alert-info {
            background: rgba(230, 126, 34, 0.05);
            border-left: 3px solid #E67E22;
            border-radius: 5px;
            padding: 0.8rem;
            margin-bottom: 1.2rem;
        }

        .alert-info h5 {
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .alert-info p {
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        /* ==================== FOOTER ==================== */
        .footer {
            background: #2C3E50;
            color: white;
            padding: 2rem;
            margin-top: 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .footer-section h4 {
            color: #E67E22;
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.4rem;
        }

        .footer-section ul li a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.75rem;
            transition: color 0.2s ease;
        }

        .footer-section ul li a:hover {
            color: #E67E22;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            padding: 1.5rem 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .hero-section p {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 768px) {
            .top-header .brand {
                justify-content: center;
                text-align: center;
            }
            
            .top-header .brand .logo-fik {
                border-left: none;
                padding-left: 0;
            }
            
            .nav-links {
                flex-direction: column;
                align-items: flex-start;
                width: 100%;
                gap: 0.5rem;
            }
            
            .nav-links > li {
                width: 100%;
            }
            
            .nav-links > li > a {
                width: 100%;
                justify-content: space-between;
            }
            
            .dropdown-menu-custom {
                position: static;
                box-shadow: none;
                border: 1px solid #eef2f6;
                width: 100%;
                opacity: 1;
                visibility: visible;
                transform: none;
                display: none;
                margin-top: 0.3rem;
            }
            
            .dropdown-menu-custom.show {
                display: block;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
            
            .hero-section {
                padding: 2rem 1rem;
            }
            
            .stats-section {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .top-header {
                padding: 0.5rem 1rem;
            }
            
            .top-nav {
                padding: 0.5rem 1rem;
            }
            
            .hero-section h1 {
                font-size: 1.6rem;
            }
            
            .card-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Indicator -->
    <div id="loading-indicator"></div>

    <!-- Dropdown Overlay -->
    <div class="dropdown-overlay" id="dropdownOverlay"></div>

    <!-- Top Header -->
    <div class="top-header">
        <div class="container-fluid">
            <div class="brand">
                <img src="<?= base_url('assets/Tel-U_logo.png') ?>" 
                     alt="Telkom University Logo" 
                     loading="lazy"
                     onerror="this.src='https://via.placeholder.com/50x50/2C3E50/FFFFFF?text=Tel-U'">
                
                <img src="" 
                     alt="" 
                     class="logo-fik"
                     loading="lazy">
                
                <div class="brand-text">
                    <h1>Fakultas Industri Kreatif</h1>
                    <p>School of Creative Industries | Inspire • Create • Innovate</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Navigation -->
    <div class="top-nav">
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <ul class="nav-links">
                    <!-- Profil dengan Dropdown -->
                    <li class="dropdown-container">
                        <a href="#" id="profilToggle">
                            Profil <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </a>
                        
                        <div class="dropdown-menu-custom" id="profilDropdown">
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-history"></i>
                                <span>Sejarah</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-bullseye"></i>
                                <span>Visi dan Misi</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-chart-line"></i>
                                <span>Perencanaan</span>
                            </a>
                        </div>
                    </li>
                    
                    <!-- Program Studi dengan Dropdown -->
                    <li class="dropdown-container">
                        <a href="#" id="programStudiToggle">
                            Program Studi <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </a>
                        
                        <div class="dropdown-menu-custom" id="programStudiDropdown">
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-paint-brush"></i>
                                <span>Desain Komunikasi Visual</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-cube"></i>
                                <span>Desain Produk</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-couch"></i>
                                <span>Desain Interior</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-film"></i>
                                <span>Film & Animasi</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-tshirt"></i>
                                <span>Kriya (Tekstil & Mode)</span>
                            </a>
                            <a href="#" class="dropdown-item-custom">
                                <i class="fas fa-palette"></i>
                                <span>Seni Rupa</span>
                            </a>
                        </div>
                    </li>
                    
                    <!-- Admin Panel dengan Dropdown -->
                    <?php if(isset($user_data) && $user_data && $user_data['role'] == 'admin'): ?>
                    <li class="dropdown-container">
                        <a href="#" id="adminToggle" style="color: #E67E22;">
                            <i class="fas fa-crown me-1"></i> Admin Panel 
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </a>
                        
                        <div class="dropdown-menu-custom" id="adminDropdown">
                            <a href="<?= base_url('admin') ?>" class="dropdown-item-custom">
                                <i class="fas fa-dashboard"></i>
                                <span>Dashboard Admin</span>
                            </a>
                            <a href="<?= base_url('berita/admin_list') ?>" class="dropdown-item-custom">
                                <i class="fas fa-newspaper"></i>
                                <span>Manajemen Berita</span>
                            </a>
                            <a href="<?= base_url('berita/create') ?>" class="dropdown-item-custom">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tulis Berita</span>
                            </a>
                            <a href="<?= base_url('tak_admin') ?>" class="dropdown-item-custom" style="background: rgba(230, 126, 34, 0.1);">
                                <i class="fas fa-file-signature"></i>
                                <span>Admin TAK <span class="admin-badge">Active</span></span>
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>
                    
                    <!-- Menu Lainnya -->
                    <li><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li><a href="<?= base_url('proposal') ?>">Proposal</a></li>
                    <li><a href="<?= base_url('sertifikat') ?>">Sertifikat</a></li>
                    <li><a href="<?= base_url('beasiswa') ?>">Beasiswa</a></li>
                    <li><a href="<?= base_url('tak') ?>">Pengajuan TAK</a></li>
                </ul>
                
                <!-- Profile dengan Nama dan Logout -->
                <?php if(isset($user_data) && $user_data): ?>
                    <div class="d-flex align-items-center gap-2">
                        <span class="px-3 py-2 rounded-pill" style="background: #2C3E50; color: white; border: 1px solid #E67E22; font-size: 0.8rem;">
                            <i class="fas fa-user-circle me-2" style="color: #E67E22;"></i>
                            <?= $user_data['nama'] ?> (<?= $user_data['role_display'] ?>)
                        </span>
                        <a href="<?= base_url('login/logout') ?>" class="btn-custom">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn-custom">
                        <i class="fas fa-user-astronaut me-2"></i>Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <?php if(isset($user_data) && $user_data): ?>
                <?php 
                    $hour = date('H');
                    if($hour < 11) $greeting = 'Selamat Pagi';
                    elseif($hour < 15) $greeting = 'Selamat Siang';
                    elseif($hour < 18) $greeting = 'Selamat Sore';
                    else $greeting = 'Selamat Malam';
                    
                    $first_name = explode(' ', $user_data['nama'])[0];
                ?>
                <div class="welcome-message">
                    <span class="badge">Welcome Back, <?= $user_data['role_display'] ?>!</span>
                    <h1>Halo, <?= $first_name ?>! 👋</h1>
                    <p><?= $greeting ?>! Kelola pengajuan TAK dengan mudah dan efisien.</p>
                </div>
            <?php else: ?>
                <h1>Admin TAK - Fakultas Industri Kreatif</h1>
                <p>Kelola Pengajuan Tugas Akhir Kemahasiswaan</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Prodi Message -->
            <?php if(isset($user_data) && $user_data && $user_data['prodi']): ?>
            <div class="alert-info">
                <div class="d-flex align-items-center">
                    <i class="fas fa-graduation-cap me-3" style="font-size: 1.5rem; color: #E67E22;"></i>
                    <div>
                        <h5>Program Studi: <strong><?= $user_data['prodi'] ?></strong></h5>
                        <p>Anda memiliki akses penuh sebagai admin TAK.</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Admin Quick Actions -->
            <?php if(isset($user_data) && $user_data && $user_data['role'] == 'admin'): ?>
            <div class="admin-quick-actions">
                <h3>
                    <i class="fas fa-bolt"></i>
                    Akses Cepat Admin TAK
                </h3>
                <div class="row g-2">
                    <div class="col-md-4 col-6">
                        <a href="<?= base_url('tak_admin') ?>" class="admin-action-card">
                            <i class="fas fa-file-signature"></i>
                            <h4>Dashboard TAK</h4>
                            <p>Kelola semua pengajuan TAK</p>
                            <span class="admin-badge">Active</span>
                        </a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="<?= base_url('tak_admin/daftar_pengajuan/pending') ?>" class="admin-action-card">
                            <i class="fas fa-clock"></i>
                            <h4>Pending</h4>
                            <p>Menunggu verifikasi</p>
                            <?php if(isset($pending_count) && $pending_count > 0): ?>
                            <span class="badge bg-warning text-dark" style="font-size: 0.65rem;"><?= $pending_count ?> perlu dicek</span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="<?= base_url('tak_admin/daftar_pengajuan/diproses') ?>" class="admin-action-card">
                            <i class="fas fa-spinner"></i>
                            <h4>Diproses</h4>
                            <p>Sedang diproses</p>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Statistik Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <div class="dashboard-card">
                        <div class="card-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="card-label">Total Pengajuan</div>
                        <h3 class="card-number"><?= $total_pengajuan ?></h3>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="dashboard-card">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-label">Menunggu Verifikasi</div>
                        <h3 class="card-number"><?= $pending_count ?></h3>
                        <a href="<?= base_url('tak_admin/daftar_pengajuan/pending') ?>" class="stretched-link"></a>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="dashboard-card">
                        <div class="card-icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="card-label">Sedang Diproses</div>
                        <h3 class="card-number"><?= $diproses_count ?></h3>
                        <a href="<?= base_url('tak_admin/daftar_pengajuan/diproses') ?>" class="stretched-link"></a>
                    </div>
                </div>
                
                <div class="col-md-3 col-6">
                    <div class="dashboard-card">
                        <div class="card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="card-label">Disetujui</div>
                        <h3 class="card-number"><?= $disetujui_count ?></h3>
                        <a href="<?= base_url('tak_admin/daftar_pengajuan/disetujui') ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <!-- Chart dan Tabel -->
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="data-table">
                        <h5>
                            <i class="fas fa-chart-line"></i>
                            Statistik Pengajuan (12 Bulan Terakhir)
                        </h5>
                        <canvas id="statistikChart" style="width:100%; max-height:250px; height:250px;"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="data-table">
                        <h5>
                            <i class="fas fa-pie-chart"></i>
                            Status Pengajuan
                        </h5>
                        <canvas id="statusChart" style="width:100%; max-height:250px; height:250px;"></canvas>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="data-table">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">
                                <i class="fas fa-history"></i>
                                Pengajuan Terbaru
                            </h5>
                            <a href="<?= base_url('tak_admin/daftar_pengajuan') ?>" class="btn-template">
                                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIM</th>
                                        <th>Mahasiswa</th>
                                        <th>Judul Kegiatan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(empty($pengajuan_terbaru)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-3">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <p>Belum ada data pengajuan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $no = 1; foreach($pengajuan_terbaru as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($p->created_at)) ?></td>
                                            <td><?= $p->nim ?></td>
                                            <td><?= $p->nama_mahasiswa ?><br><small style="font-size:0.65rem;"><?= $p->program_studi ?></small></td>
                                            <td><?= substr($p->judul_kegiatan, 0, 30) ?><?= strlen($p->judul_kegiatan) > 30 ? '...' : '' ?></td>
                                            <td>
                                                <?php
                                                $status_class = '';
                                                $status_icon = '';
                                                switch($p->status) {
                                                    case 'pending':
                                                        $status_class = 'status-pending';
                                                        $status_icon = 'fa-clock';
                                                        $status_text = 'Pending';
                                                        break;
                                                    case 'diproses':
                                                        $status_class = 'status-diproses';
                                                        $status_icon = 'fa-spinner';
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
                                                <a href="<?= base_url('tak_admin/detail_pengajuan/' . $p->id) ?>" class="btn-action" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url('tak_admin/proses_pengajuan/' . $p->id) ?>" class="btn-action" title="Proses">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section (Simplified) -->
            <div class="stats-section">
                <div class="row g-2">
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <h2><?= number_format($total_mahasiswa ?? 2500) ?>+</h2>
                            <p>Mahasiswa Aktif</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <h2><?= $disetujui_count ?></h2>
                            <p>TAK Disetujui</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <h2><?= $ditolak_count ?></h2>
                            <p>TAK Ditolak</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-card">
                            <h2><?= $pending_count + $diproses_count ?></h2>
                            <p>Menunggu Proses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Simplified Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Admin TAK</h4>
                <ul>
                    <li><a href="<?= base_url('tak_admin') ?>">Dashboard</a></li>
                    <li><a href="<?= base_url('tak_admin/daftar_pengajuan/pending') ?>">Pending</a></li>
                    <li><a href="<?= base_url('tak_admin/daftar_pengajuan/diproses') ?>">Diproses</a></li>
                    <li><a href="<?= base_url('tak_admin/daftar_pengajuan/disetujui') ?>">Disetujui</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Menu Utama</h4>
                <ul>
                    <li><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li><a href="<?= base_url('proposal') ?>">Proposal</a></li>
                    <li><a href="<?= base_url('sertifikat') ?>">Sertifikat</a></li>
                    <li><a href="<?= base_url('beasiswa') ?>">Beasiswa</a></li>
                    <li><a href="<?= base_url('tak') ?>">Pengajuan TAK</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Kontak</h4>
                <ul>
                    <li><i class="fas fa-phone me-2"></i> (022) 756 5923 ext. 123</li>
                    <li><i class="fas fa-envelope me-2"></i> tak.fik@telkomuniversity.ac.id</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Admin TAK - Fakultas Industri Kreatif Telkom University</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Dropdown Handling
        const profilToggle = document.getElementById('profilToggle');
        const profilDropdown = document.getElementById('profilDropdown');
        const studiToggle = document.getElementById('programStudiToggle');
        const studiDropdown = document.getElementById('programStudiDropdown');
        const adminToggle = document.getElementById('adminToggle');
        const adminDropdown = document.getElementById('adminDropdown');
        const dropdownOverlay = document.getElementById('dropdownOverlay');

        function closeAllDropdowns() {
            if (profilDropdown) profilDropdown.classList.remove('show');
            if (studiDropdown) studiDropdown.classList.remove('show');
            if (adminDropdown) adminDropdown.classList.remove('show');
            if (dropdownOverlay) dropdownOverlay.classList.remove('show');
        }

        function toggleDropdown(menu) {
            if (menu.classList.contains('show')) {
                closeAllDropdowns();
            } else {
                closeAllDropdowns();
                menu.classList.add('show');
                if (dropdownOverlay) dropdownOverlay.classList.add('show');
            }
        }

        if (profilToggle) {
            profilToggle.addEventListener('click', (e) => {
                e.preventDefault();
                toggleDropdown(profilDropdown);
            });
        }

        if (studiToggle) {
            studiToggle.addEventListener('click', (e) => {
                e.preventDefault();
                toggleDropdown(studiDropdown);
            });
        }

        if (adminToggle && adminDropdown) {
            adminToggle.addEventListener('click', (e) => {
                e.preventDefault();
                toggleDropdown(adminDropdown);
            });
        }

        if (dropdownOverlay) {
            dropdownOverlay.addEventListener('click', closeAllDropdowns);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeAllDropdowns();
            }
        });

        // Chart Initialization
        document.addEventListener('DOMContentLoaded', function() {
            // Loading indicator
            const loadingIndicator = document.getElementById('loading-indicator');
            if (loadingIndicator) {
                loadingIndicator.style.display = 'block';
                setTimeout(() => {
                    loadingIndicator.style.display = 'none';
                }, 500);
            }
            
            // Statistik Chart
            setTimeout(function() {
                const ctx = document.getElementById('statistikChart');
                if (ctx) {
                    <?php
                    // Prepare chart data
                    $labels = [];
                    $pending_data = [];
                    $diproses_data = [];
                    $disetujui_data = [];
                    $ditolak_data = [];
                    
                    if (!empty($statistik_bulanan)) {
                        foreach(array_reverse($statistik_bulanan) as $stat) {
                            $labels[] = date('M Y', strtotime($stat->bulan . '-01'));
                            $pending_data[] = (int)$stat->pending;
                            $diproses_data[] = (int)$stat->diproses;
                            $disetujui_data[] = (int)$stat->disetujui;
                            $ditolak_data[] = (int)$stat->ditolak;
                        }
                    }
                    ?>
                    
                    new Chart(ctx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: <?= json_encode($labels) ?>,
                            datasets: [
                                { 
                                    label: 'Pending', 
                                    data: <?= json_encode($pending_data) ?>, 
                                    borderColor: '#856404', 
                                    backgroundColor: 'transparent', 
                                    tension: 0.4,
                                    borderWidth: 2
                                },
                                { 
                                    label: 'Diproses', 
                                    data: <?= json_encode($diproses_data) ?>, 
                                    borderColor: '#004085', 
                                    backgroundColor: 'transparent', 
                                    tension: 0.4,
                                    borderWidth: 2
                                },
                                { 
                                    label: 'Disetujui', 
                                    data: <?= json_encode($disetujui_data) ?>, 
                                    borderColor: '#155724', 
                                    backgroundColor: 'transparent', 
                                    tension: 0.4,
                                    borderWidth: 2
                                },
                                { 
                                    label: 'Ditolak', 
                                    data: <?= json_encode($ditolak_data) ?>, 
                                    borderColor: '#721c24', 
                                    backgroundColor: 'transparent', 
                                    tension: 0.4,
                                    borderWidth: 2
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: { 
                                legend: { 
                                    position: 'bottom',
                                    labels: { boxWidth: 12, font: { size: 11 } }
                                } 
                            },
                            scales: {
                                y: { beginAtZero: true, grid: { color: '#eef2f6' } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }
                
                // Status Chart
                const ctx2 = document.getElementById('statusChart');
                if (ctx2) {
                    new Chart(ctx2.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Pending', 'Diproses', 'Disetujui', 'Ditolak'],
                            datasets: [{
                                data: [
                                    <?= (int)$pending_count ?>, 
                                    <?= (int)$diproses_count ?>, 
                                    <?= (int)$disetujui_count ?>, 
                                    <?= (int)$ditolak_count ?>
                                ],
                                backgroundColor: ['#856404', '#004085', '#155724', '#721c24'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: { 
                                legend: { 
                                    position: 'bottom',
                                    labels: { boxWidth: 12, font: { size: 11 } }
                                } 
                            },
                            cutout: '65%'
                        }
                    });
                }
            }, 100);
        });
    </script>
</body>
</html>