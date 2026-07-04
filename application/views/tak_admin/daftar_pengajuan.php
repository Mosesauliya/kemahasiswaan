<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin TAK FIK Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
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
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #2C3E50;
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-action:hover {
            background: #E67E22;
            color: white;
        }

        .btn-danger-action {
            color: #dc3545;
        }

        .btn-danger-action:hover {
            background: #dc3545;
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

        /* ==================== FILTER SECTION ==================== */
        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1.5rem;
            border: 1px solid #eef2f6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-item {
            flex: 1;
            min-width: 180px;
        }

        .filter-item label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #7f8c8d;
            margin-bottom: 0.2rem;
            display: block;
        }

        .filter-item .form-control,
        .filter-item .form-select {
            border: 1px solid #eef2f6;
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 0.85rem;
            width: 100%;
        }

        .filter-item .form-control:focus,
        .filter-item .form-select:focus {
            border-color: #E67E22;
            outline: none;
            box-shadow: 0 0 0 2px rgba(230, 126, 34, 0.1);
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
            vertical-align: middle;
        }

        .table tbody tr:hover td {
            background: rgba(230, 126, 34, 0.02);
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

        /* ==================== EMPTY STATE ==================== */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #95a5a6;
        }

        .empty-state i {
            font-size: 3rem;
            color: #E67E22;
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }

        .empty-state p {
            font-size: 0.85rem;
            margin-bottom: 1rem;
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

        .alert {
            border-radius: 5px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 3px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 3px solid #dc3545;
        }

        .alert i {
            margin-right: 0.5rem;
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
            
            .filter-section {
                flex-direction: column;
            }
            
            .filter-item {
                width: 100%;
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
                        </div>
                    </li>
                    
                    <!-- ADMIN DROPDOWN -->
                    <?php if(isset($user_data) && $user_data && $user_data['role'] == 'admin'): ?>
                    <li class="dropdown-container">
                        <a href="#" id="adminToggle" style="color: #E67E22;">
                            <i class="fas fa-crown me-1"></i> Admin Panel 
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </a>
                        
                        <div class="dropdown-menu-custom" id="adminDropdown">
                            <a href="<?= base_url('tak_admin') ?>" class="dropdown-item-custom active">
                                <i class="fas fa-file-signature"></i>
                                <span>Admin TAK</span>
                            </a>
                            <a href="<?= base_url('berita/admin_list') ?>" class="dropdown-item-custom">
                                <i class="fas fa-newspaper"></i>
                                <span>Manajemen Berita</span>
                            </a>
                            <a href="<?= base_url('berita/create') ?>" class="dropdown-item-custom">
                                <i class="fas fa-plus-circle"></i>
                                <span>Tulis Berita</span>
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>
                    
                    <li><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li><a href="<?= base_url('tak') ?>">Pengajuan TAK</a></li>
                    <li><a href="<?= base_url('tak/riwayat') ?>">Riwayat TAK</a></li>
                </ul>
                
                <!-- PROFILE -->
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
                    <span class="badge">Admin TAK</span>
                    <h1>Halo, <?= $first_name ?>! 👋</h1>
                    <p><?= $greeting ?>! <?= $subtitle ?></p>
                </div>
            <?php else: ?>
                <h1>Fakultas Industri Kreatif</h1>
                <p>Where Creativity Meets Innovation</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i>
                    <?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="float: right;"></button>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="float: right;"></button>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0"><?= $subtitle ?></h4>
                <div>
                    <a href="<?= base_url('tak_admin/daftar_pengajuan') ?>" class="btn-template">
                        <i class="fas fa-list"></i> Semua
                    </a>
                    <a href="<?= base_url('tak_admin/daftar_pengajuan/pending') ?>" class="btn-template">
                        <i class="fas fa-clock"></i> Pending (<?= $pending_count ?>)
                    </a>
                    <a href="<?= base_url('tak_admin/daftar_pengajuan/diproses') ?>" class="btn-template">
                        <i class="fas fa-spinner"></i> Diproses (<?= $diproses_count ?>)
                    </a>
                    <a href="<?= base_url('tak_admin/daftar_pengajuan/disetujui') ?>" class="btn-template">
                        <i class="fas fa-check-circle"></i> Disetujui (<?= $disetujui_count ?>)
                    </a>
                    <a href="<?= base_url('tak_admin/daftar_pengajuan/ditolak') ?>" class="btn-template">
                        <i class="fas fa-times-circle"></i> Ditolak (<?= $ditolak_count ?>)
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-item">
                    <label>Filter Tanggal</label>
                    <div class="d-flex gap-2">
                        <input type="date" class="form-control" id="startDate">
                        <span class="align-self-center">s/d</span>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                </div>
                
                <div class="filter-item">
                    <label>Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="all" <?= $current_status == 'all' ? 'selected' : '' ?>>Semua Status</option>
                        <option value="pending" <?= $current_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="diproses" <?= $current_status == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="disetujui" <?= $current_status == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="ditolak" <?= $current_status == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    </select>
                </div>
                
                <div class="filter-item">
                    <label>&nbsp;</label>
                    <button class="btn-template w-100" id="applyFilter">
                        <i class="fas fa-filter me-2"></i>Terapkan Filter
                    </button>
                </div>
                
                <div class="filter-item">
                    <label>&nbsp;</label>
                    <button class="btn-template w-100" id="resetFilter">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="data-table">
                <h5>
                    <i class="fas fa-list"></i>
                    Daftar Pengajuan TAK
                </h5>
                
                <div class="table-responsive">
                    <table class="table" id="pengajuanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIM</th>
                                <th>Mahasiswa</th>
                                <th>Prodi</th>
                                <th>PIC</th>
                                <th>Judul Kegiatan</th>
                                <th>Tgl Kegiatan</th>
                                <th>No. TAK</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($pengajuan)): ?>
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h5>Belum Ada Data</h5>
                                            <p>Tidak ada pengajuan TAK yang ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($pengajuan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($p->created_at)) ?></td>
                                    <td><?= $p->nim ?></td>
                                    <td>
                                        <?= $p->nama_mahasiswa ?><br>
                                        <small style="font-size:0.65rem;"><?= $p->nim ?></small>
                                    </td>
                                    <td><?= $p->program_studi ?></td>
                                    <td><?= $p->nama_pic ?></td>
                                    <td>
                                        <?= substr($p->judul_kegiatan, 0, 30) ?>
                                        <?= strlen($p->judul_kegiatan) > 30 ? '...' : '' ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($p->tanggal_kegiatan)) ?></td>
                                    <td>
                                        <?php if($p->no_tak): ?>
                                            <span class="badge bg-success" style="font-size:0.65rem;"><?= $p->no_tak ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
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
                                        <div class="d-flex gap-1">
                                            <a href="<?= base_url('tak_admin/detail_pengajuan/' . $p->id) ?>" class="btn-action" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('tak_admin/proses_pengajuan/' . $p->id) ?>" class="btn-action" title="Proses">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('uploads/surat_pengajuan/' . $p->file_surat_pengajuan) ?>" class="btn-action" title="Download Surat" download>
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="<?= base_url('uploads/excel_peserta/' . $p->file_excel_peserta) ?>" class="btn-action" title="Download Excel" download>
                                                <i class="fas fa-file-excel"></i>
                                            </a>
                                            <button type="button" class="btn-action btn-danger-action" onclick="confirmDelete(<?= $p->id ?>)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Tentang FIK</h4>
                <ul>
                    <li><a href="#">Sejarah</a></li>
                    <li><a href="#">Visi Misi</a></li>
                    <li><a href="#">Akreditasi</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Program Studi</h4>
                <ul>
                    <li><a href="#">S1 Desain Komunikasi Visual</a></li>
                    <li><a href="#">S1 Desain Interior</a></li>
                    <li><a href="#">S1 Film & Animasi</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Fasilitas</h4>
                <ul>
                    <li><a href="#">Creative Studio</a></li>
                    <li><a href="#">Film Lab</a></li>
                    <li><a href="#">Animation Studio</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Kontak</h4>
                <ul>
                    <li><i class="fas fa-phone me-2"></i> (022) 756 5923</li>
                    <li><i class="fas fa-envelope me-2"></i> fik@telkomuniversity.ac.id</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 Fakultas Industri Kreatif - Telkom University</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
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

        // DataTable Initialization
        $(document).ready(function() {
            $('#pengajuanTable').DataTable({
                pageLength: 25,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                },
                order: [[1, 'desc']]
            });
        });

        // Filter functionality
        $('#applyFilter').click(function() {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
            const status = $('#statusFilter').val();
            
            if (startDate && endDate) {
                window.location.href = '<?= base_url("tak_admin/filter_by_date") ?>/' + startDate + '/' + endDate + '/' + status;
            } else if (status !== 'all') {
                window.location.href = '<?= base_url("tak_admin/daftar_pengajuan") ?>/' + status;
            }
        });
        
        $('#resetFilter').click(function() {
            window.location.href = '<?= base_url("tak_admin/daftar_pengajuan") ?>';
        });

        // Delete confirmation
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data pengajuan ini? Data yang dihapus tidak dapat dikembalikan.')) {
                window.location.href = '<?= base_url("tak_admin/hapus_pengajuan") ?>/' + id;
            }
        }

        // Auto hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>