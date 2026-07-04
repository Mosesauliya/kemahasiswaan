<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Admin TAK FIK Telkom University</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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

        /* ==================== STATUS BADGES ==================== */
        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
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

        .status-radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .status-radio {
            flex: 1;
            min-width: 120px;
        }

        .status-radio .form-check-input {
            display: none;
        }

        .status-radio .form-check-label {
            display: block;
            padding: 0.8rem;
            text-align: center;
            border: 2px solid #eef2f6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-radio .form-check-input:checked + .form-check-label {
            border-color: #E67E22;
            background: rgba(230, 126, 34, 0.05);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(230, 126, 34, 0.1);
        }

        .status-radio .status-badge {
            pointer-events: none;
        }

        /* ==================== FORM STYLES ==================== */
        .form-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eef2f6;
            margin-bottom: 1.5rem;
        }

        .form-card h5 {
            font-size: 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid #E67E22;
            padding-bottom: 0.5rem;
        }

        .form-card h5 i {
            color: #E67E22;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-bottom: 0.3rem;
        }

        .form-control, .form-select {
            border: 1px solid #eef2f6;
            border-radius: 6px;
            padding: 0.6rem;
            font-size: 0.9rem;
            width: 100%;
            margin-bottom: 1rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #E67E22;
            outline: none;
            box-shadow: 0 0 0 2px rgba(230, 126, 34, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-text {
            font-size: 0.75rem;
            color: #95a5a6;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        /* ==================== SUMMARY CARD ==================== */
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 1.2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border: 1px solid #eef2f6;
            margin-bottom: 1.5rem;
            position: sticky;
            top: 1rem;
        }

        .summary-card h6 {
            font-size: 0.95rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 2px solid #E67E22;
            padding-bottom: 0.5rem;
        }

        .summary-card h6 i {
            color: #E67E22;
        }

        .summary-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eef2f6;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-label {
            font-size: 0.75rem;
            color: #7f8c8d;
            margin-bottom: 0.2rem;
        }

        .summary-value {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .summary-value small {
            font-weight: normal;
            font-size: 0.8rem;
            color: #7f8c8d;
        }

        .doc-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            text-decoration: none;
            color: #2C3E50;
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
        }

        .doc-link:hover {
            background: rgba(230, 126, 34, 0.1);
            color: #E67E22;
        }

        .doc-link i {
            width: 20px;
        }

        .doc-link i.fa-file-pdf { color: #dc3545; }
        .doc-link i.fa-file-excel { color: #28a745; }
        .doc-link i.fa-link { color: #17a2b8; }

        /* ==================== ALERT ==================== */
        .alert-info {
            background: rgba(230, 126, 34, 0.05);
            border-left: 3px solid #E67E22;
            border-radius: 5px;
            padding: 0.8rem;
            margin-bottom: 1.2rem;
        }

        .alert {
            border-radius: 5px;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
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

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 992px) {
            .footer-content {
                grid-template-columns: repeat(2, 1fr);
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
            
            .status-radio-group {
                flex-direction: column;
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
                                <span>Admin</span>
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
                    <span class="badge">Proses Pengajuan TAK</span>
                    <h1>Halo, <?= $first_name ?>! 👋</h1>
                    <p><?= $greeting ?>! Verifikasi dan tentukan status pengajuan</p>
                </div>
            <?php else: ?>
                <h1>Fakultas Industri Kreatif</h1>
                <p>Where Creativity Meets Innovation</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Proses Pengajuan TAK</h4>
            <a href="<?= base_url('tak_admin/detail_pengajuan/' . $pengajuan->id) ?>" class="btn-template">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Proses -->
                <div class="form-card">
                    <h5>
                        <i class="fas fa-check-circle"></i>
                        Update Status Pengajuan
                    </h5>
                    
                    <form action="<?= base_url('tak_admin/update_status') ?>" method="POST" id="prosesForm">
                        <input type="hidden" name="id" value="<?= $pengajuan->id ?>">
                        
                        <div class="mb-4">
                            <label class="form-label">Pilih Status</label>
                            <div class="status-radio-group">
                                <div class="status-radio">
                                    <input class="form-check-input" type="radio" name="status" id="statusPending" value="pending" <?= $pengajuan->status == 'pending' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusPending">
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    </label>
                                </div>
                                
                                <div class="status-radio">
                                    <input class="form-check-input" type="radio" name="status" id="statusDiproses" value="diproses" <?= $pengajuan->status == 'diproses' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusDiproses">
                                        <span class="status-badge status-diproses">
                                            <i class="fas fa-spinner"></i> Diproses
                                        </span>
                                    </label>
                                </div>
                                
                                <div class="status-radio">
                                    <input class="form-check-input" type="radio" name="status" id="statusDisetujui" value="disetujui">
                                    <label class="form-check-label" for="statusDisetujui">
                                        <span class="status-badge status-disetujui">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                    </label>
                                </div>
                                
                                <div class="status-radio">
                                    <input class="form-check-input" type="radio" name="status" id="statusDitolak" value="ditolak">
                                    <label class="form-check-label" for="statusDitolak">
                                        <span class="status-badge status-ditolak">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan Verifikasi</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="5" placeholder="Masukkan catatan atau alasan jika menolak pengajuan..."><?= $pengajuan->catatan ?></textarea>
                            <div class="form-text">Catatan ini akan dikirimkan ke mahasiswa</div>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Perhatian:</strong> Pastikan semua berkas telah diverifikasi sebelum mengubah status menjadi "Disetujui".
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-template" style="padding: 0.5rem 2rem;">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="<?= base_url('tak_admin/detail_pengajuan/' . $pengajuan->id) ?>" class="btn-template" style="border-color: #95a5a6; color: #7f8c8d;">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Ringkasan Pengajuan -->
                <div class="summary-card">
                    <h6>
                        <i class="fas fa-file-alt"></i>
                        Ringkasan Pengajuan
                    </h6>
                    
                    <div class="summary-item">
                        <div class="summary-label">NIM</div>
                        <div class="summary-value"><?= $pengajuan->nim ?></div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Nama Mahasiswa</div>
                        <div class="summary-value"><?= $pengajuan->nama_mahasiswa ?></div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Program Studi</div>
                        <div class="summary-value"><?= $pengajuan->program_studi ?></div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Judul Kegiatan</div>
                        <div class="summary-value">
                            <?= substr($pengajuan->judul_kegiatan, 0, 50) ?>
                            <?= strlen($pengajuan->judul_kegiatan) > 50 ? '...' : '' ?>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Tanggal Pengajuan</div>
                        <div class="summary-value"><?= date('d/m/Y H:i', strtotime($pengajuan->created_at)) ?></div>
                    </div>
                    
                    <div class="summary-item">
                        <div class="summary-label">Status Saat Ini</div>
                        <div class="summary-value">
                            <?php
                            $status_class = '';
                            switch($pengajuan->status) {
                                case 'pending':
                                    $status_class = 'status-pending';
                                    break;
                                case 'diproses':
                                    $status_class = 'status-diproses';
                                    break;
                                case 'disetujui':
                                    $status_class = 'status-disetujui';
                                    break;
                                case 'ditolak':
                                    $status_class = 'status-ditolak';
                                    break;
                            }
                            ?>
                            <span class="status-badge <?= $status_class ?>" style="font-size:0.75rem;">
                                <i class="fas <?= $status_icon ?>"></i>
                                <?= ucfirst($pengajuan->status) ?>
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Dokumen -->
                <div class="summary-card">
                    <h6>
                        <i class="fas fa-paperclip"></i>
                        Dokumen Terkait
                    </h6>
                    
                    <a href="<?= base_url('uploads/surat_pengajuan/' . $pengajuan->file_surat_pengajuan) ?>" class="doc-link" download>
                        <i class="fas fa-file-pdf"></i>
                        <span>Surat Pengajuan</span>
                        <i class="fas fa-download ms-auto"></i>
                    </a>
                    
                    <a href="<?= base_url('uploads/excel_peserta/' . $pengajuan->file_excel_peserta) ?>" class="doc-link" download>
                        <i class="fas fa-file-excel"></i>
                        <span>Excel Peserta</span>
                        <i class="fas fa-download ms-auto"></i>
                    </a>
                    
                    <a href="<?= $pengajuan->link_sertifikat ?>" class="doc-link" target="_blank">
                        <i class="fas fa-link"></i>
                        <span>Link Sertifikat</span>
                        <i class="fas fa-external-link-alt ms-auto"></i>
                    </a>
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

        // Form validation
        const prosesForm = document.getElementById('prosesForm');
        const catatanField = document.getElementById('catatan');
        const statusRadios = document.querySelectorAll('input[name="status"]');

        function updateCatatanRequirement() {
            const selectedStatus = document.querySelector('input[name="status"]:checked')?.value;
            
            if (selectedStatus === 'ditolak') {
                catatanField.required = true;
                catatanField.closest('.mb-3').querySelector('.form-text').textContent = 'Wajib diisi jika menolak pengajuan';
            } else {
                catatanField.required = false;
                catatanField.closest('.mb-3').querySelector('.form-text').textContent = 'Catatan ini akan dikirimkan ke mahasiswa';
            }
        }

        statusRadios.forEach(radio => {
            radio.addEventListener('change', updateCatatanRequirement);
        });

        prosesForm.addEventListener('submit', function(e) {
            const selectedStatus = document.querySelector('input[name="status"]:checked')?.value;
            const catatan = catatanField.value.trim();
            
            if (selectedStatus === 'ditolak' && !catatan) {
                e.preventDefault();
                alert('Catatan wajib diisi jika menolak pengajuan');
                catatanField.focus();
            }
            
            if (selectedStatus === 'disetujui') {
                if (!confirm('Apakah Anda yakin ingin menyetujui pengajuan ini? TAK akan diterbitkan.')) {
                    e.preventDefault();
                }
            }
        });

        // Initialize
        updateCatatanRequirement();
    </script>
</body>
</html>