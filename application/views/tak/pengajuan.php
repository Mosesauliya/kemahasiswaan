<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Pengajuan TAK Kolektif - Kemahasiswaan FIK | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ========== HEADER GLASS ========== */
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
        .hero-tak {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        .hero-tak::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-tak .wave-bottom {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-tak h1 {
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

        .hero-tak p {
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

        /* ========== TAK SECTION ========== */
        .tak-section {
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

        /* ========== TAK CARD ========== */
        .tak-card {
            background: white;
            border-radius: 32px;
            padding: 48px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .tak-card:hover {
            box-shadow: 0 25px 70px rgba(249,115,22,0.1);
        }

        .tak-card-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 24px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .tak-card-header i {
            font-size: 2.5rem;
            color: var(--orange);
            background: var(--orange-light);
            padding: 18px;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .tak-card:hover .tak-card-header i {
            transform: scale(1.05) rotate(5deg);
        }

        .tak-card-header h2 {
            color: #1f2937;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            font-family: 'Playfair Display', serif;
        }

        .tak-card-header p {
            color: #6b7280;
            margin: 8px 0 0;
            font-size: 0.95rem;
        }

        /* ========== FORM ========== */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--orange);
            width: 20px;
        }

        .form-label .required {
            color: #ef4444;
            font-weight: 700;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #faf9f7;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            background: white;
            outline: none;
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .form-hint {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 6px;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* ========== TEMPLATE SECTION ========== */
        .template-section {
            background: linear-gradient(145deg, #faf9f7, #ffffff);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 32px;
            border: 2px dashed #e2e8f0;
            transition: all 0.3s ease;
        }

        .template-section:hover {
            border-color: var(--orange);
            background: linear-gradient(145deg, #fff, #fff7ed);
        }

        .template-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .template-title i {
            font-size: 2rem;
            color: var(--orange);
        }

        .template-title h4 {
            color: #1f2937;
            font-weight: 700;
            margin: 0;
        }

        .template-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-template {
            background: white;
            border: 2px solid var(--orange);
            color: var(--orange);
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-template:hover {
            background: var(--orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.25);
        }

        /* ========== FILE UPLOAD ========== */
        .file-upload {
            position: relative;
            margin-bottom: 16px;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-area {
            border: 2px dashed var(--orange);
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            background: linear-gradient(145deg, rgba(249,115,22,0.02), rgba(249,115,22,0.05));
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            background: rgba(249,115,22,0.08);
            border-color: var(--orange-dark);
            transform: translateY(-2px);
        }

        .file-upload-area i {
            font-size: 3rem;
            color: var(--orange);
            margin-bottom: 16px;
            transition: transform 0.3s ease;
        }

        .file-upload-area:hover i {
            transform: scale(1.1);
        }

        .file-upload-area h5 {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .file-upload-area p {
            color: #6b7280;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .file-info {
            display: none;
            background: linear-gradient(145deg, #f0fdf4, #e8fce8);
            border: 1px solid #22c55e;
            border-radius: 16px;
            padding: 16px;
            margin-top: 16px;
            align-items: center;
            gap: 16px;
            animation: fadeInUp 0.3s ease;
        }

        .file-info.show {
            display: flex;
        }

        .file-info i {
            font-size: 2rem;
            color: #22c55e;
        }

        .file-info .file-details {
            flex: 1;
        }

        .file-info .file-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            word-break: break-all;
        }

        .file-info .file-size {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .file-info .file-remove {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
            padding: 0;
        }

        .file-info .file-remove:hover {
            transform: scale(1.1);
        }

        /* ========== SUBMIT BUTTON ========== */
        .btn-submit {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            width: 100%;
            justify-content: center;
            margin-top: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(249, 115, 22, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ========== INFO CARDS ========== */
        .info-card {
            background: white;
            border-radius: 24px;
            padding: 28px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(249,115,22,0.2);
        }

        .info-card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(145deg, var(--orange-light), #fff);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .info-card:hover .info-card-icon {
            transform: scale(1.05) rotate(5deg);
        }

        .info-card-icon i {
            font-size: 1.8rem;
            color: var(--orange);
        }

        .info-card h5 {
            color: #1f2937;
            font-weight: 800;
            margin-bottom: 12px;
            font-size: 1.2rem;
        }

        .info-card p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .info-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-card ul li {
            color: #4b5563;
            font-size: 0.85rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card ul li i {
            color: #22c55e;
            font-size: 0.8rem;
            width: 18px;
        }

        /* ========== LOADING SCREEN ========== */
        .loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(8px);
            z-index: 99999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loading-screen.show {
            display: flex;
            animation: fadeInUp 0.3s ease;
        }

        .loading-card {
            background: white;
            border-radius: 32px;
            padding: 48px 64px;
            text-align: center;
            animation: fadeInUp 0.4s ease;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.3);
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 24px;
        }

        .loading-card i {
            font-size: 3.5rem;
            color: var(--orange);
            margin-bottom: 24px;
            animation: float 2s ease-in-out infinite;
        }

        .loading-card h4 {
            color: #1f2937;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .loading-card p {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0;
        }

        .loading-progress {
            width: 280px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-top: 24px;
            overflow: hidden;
        }

        .loading-progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--orange), #fdba74);
            border-radius: 3px;
            transition: width 0.3s ease;
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
        @media (max-width: 768px) {
            .hero-tak {
                padding: 120px 0 60px;
            }
            .hero-tak h1 {
                font-size: 2rem;
            }
            .hero-tak p {
                font-size: 1rem;
            }
            .tak-card {
                padding: 24px;
            }
            .tak-card-header {
                flex-direction: column;
                text-align: center;
            }
            .tak-card-header i {
                width: 64px;
                height: 64px;
                font-size: 1.8rem;
            }
            .tak-card-header h2 {
                font-size: 1.5rem;
            }
            .template-buttons {
                flex-direction: column;
            }
            .btn-template {
                width: 100%;
                justify-content: center;
            }
            .file-upload-area {
                padding: 20px;
            }
            .loading-card {
                padding: 30px 40px;
                margin: 0 20px;
            }
        }
    </style>
</head>
<body>

<!-- ========== LOADING SCREEN ========== -->
<div id="loadingScreen" class="loading-screen">
    <div class="loading-card">
        <i class="fas fa-clipboard-list"></i>
        <h4>Mengirim Pengajuan TAK...</h4>
        <p>Mohon tunggu, sedang memproses data Anda</p>
        <div class="loading-progress">
            <div class="loading-progress-bar" id="progressBar"></div>
        </div>
        <p class="mt-3" style="font-size: 0.75rem; color: #9ca3af;">
            <i class="fas fa-info-circle me-1"></i> Jangan tutup halaman ini
        </p>
    </div>
</div>

<?php $this->load->view('partials/navbar', ['active_menu' => 'layanan']); ?>

<!-- ========== HERO SECTION ========== -->
<section class="hero-tak">
    <div class="floating-elements">
        <div class="element"><i class="fas fa-clipboard-list"></i></div>
        <div class="element"><i class="fas fa-file-alt"></i></div>
        <div class="element"><i class="fas fa-users"></i></div>
        <div class="element"><i class="fas fa-certificate"></i></div>
    </div>
    <div class="container-custom">
        <h1 data-aos="fade-up">Pengajuan TAK Kolektif</h1>
        <p data-aos="fade-up" data-aos-delay="100">Ajukan pengakuan kegiatan dan kompetensi mahasiswa secara kolektif • Mudah • Cepat • Terverifikasi</p>
    </div>
    <div class="wave-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- ========== MAIN CONTENT ========== -->
<section class="tak-section">
    <div class="container-custom">
        
        <!-- ===== TOMBOL KEMBALI ===== -->
        <a href="<?= base_url('dashboard') ?>" class="back-button" data-aos="fade-right">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <!-- ===== SECTION TITLE ===== -->
        <div class="section-title" data-aos="fade-up">
            <h2>Formulir Pengajuan TAK</h2>
            <p class="text-muted mt-3">Lengkapi semua data yang diperlukan dengan benar</p>
        </div>

        <!-- ===== ALERT MESSAGES ===== -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="fas fa-check-circle me-2"></i>
                <?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-up">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- ===== MAIN FORM ===== -->
        <div class="tak-card" data-aos="fade-up">
            <div class="tak-card-header">
                <i class="fas fa-file-alt"></i>
                <div>
                    <h2>Form Pengajuan TAK Kolektif</h2>
                    <p>Lengkapi semua data yang diperlukan dengan benar</p>
                </div>
            </div>

            <form action="<?= base_url('tak/submit_pengajuan') ?>" method="POST" enctype="multipart/form-data" id="takForm">
                <div class="row g-4">
                    <!-- Nama PIC -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-tie"></i>
                                Nama PIC <span class="required">*</span>
                            </label>
                            <input type="text" name="nama_pic" class="form-control" placeholder="Masukkan nama penanggung jawab" required>
                            <small class="form-hint">Nama dosen atau staf yang bertanggung jawab</small>
                        </div>
                    </div>
                    
                    <!-- Tanggal Kegiatan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tanggal Kegiatan <span class="required">*</span>
                            </label>
                            <input type="date" name="tanggal_kegiatan" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- Judul Kegiatan -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heading"></i>
                                Judul Kegiatan <span class="required">*</span>
                            </label>
                            <input type="text" name="judul_kegiatan" class="form-control" placeholder="Contoh: Seminar Desain Grafis 2025" required>
                        </div>
                    </div>
                    
                    <!-- Deskripsi Kegiatan -->
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-align-left"></i>
                                Deskripsi Kegiatan <span class="required">*</span>
                            </label>
                            <textarea name="deskripsi" class="form-control" placeholder="Jelaskan secara singkat tentang kegiatan yang dilaksanakan" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <!-- Lokasi Kegiatan -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Lokasi Kegiatan <span class="required">*</span>
                            </label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Gedung FIK Lantai 3, Ruang 301" required>
                        </div>
                    </div>
                    
                    <!-- Link Sertifikat -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-link"></i>
                                Link Seluruh Sertifikat <span class="required">*</span>
                            </label>
                            <input type="url" name="link_sertifikat" class="form-control" placeholder="https://drive.google.com/..." required>
                            <small class="form-hint">Google Drive link berisi semua sertifikat peserta (PDF)</small>
                        </div>
                    </div>
                </div>

                <!-- ===== TEMPLATE SECTION ===== -->
                <div class="template-section">
                    <div class="template-title">
                        <i class="fas fa-download"></i>
                        <h4>Download Template</h4>
                    </div>
                    <p class="text-muted mb-3">Download dan lengkapi template berikut sebelum mengupload:</p>
                    <div class="template-buttons">
                        <a href="https://docs.google.com/document/d/1Zjo6NTAHuE6Rc1EHMXrzKB3_HJ9-xShR/export?format=docx" target="_blank" class="btn-template">
                            <i class="fas fa-file-word"></i>
                            Template Surat Pengajuan TAK Kolektif
                        </a>
                        <a href="https://docs.google.com/spreadsheets/d/1ZizSQdg-QqNhmE94qy_W3Uy2PH7MTV76/export?format=xlsx" target="_blank" class="btn-template">
                            <i class="fas fa-file-excel"></i>
                            Template Data Excel Peserta
                        </a>
                    </div>
                </div>

                <!-- ===== UPLOAD SURAT PENGAJUAN ===== -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-file-pdf"></i>
                        Surat Pengajuan TAK Kolektif <span class="required">*</span>
                    </label>
                    <div class="file-upload">
                        <input type="file" name="surat_pengajuan" class="file-upload-input" id="suratPengajuan" accept=".pdf,.doc,.docx" required>
                        <div class="file-upload-area" id="suratUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h5>Upload Surat Pengajuan</h5>
                            <p>Klik atau drag & drop file disini</p>
                            <small class="text-muted">Format: PDF, DOC, DOCX (Max: 5MB)</small>
                        </div>
                    </div>
                    <div class="file-info" id="suratInfo">
                        <i class="fas fa-file-pdf"></i>
                        <div class="file-details">
                            <div class="file-name" id="suratName"></div>
                            <div class="file-size" id="suratSize"></div>
                        </div>
                        <button type="button" class="file-remove" onclick="removeFile('surat')">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- ===== UPLOAD EXCEL PESERTA ===== -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-file-excel"></i>
                        Excel Penerima Sertifikat <span class="required">*</span>
                    </label>
                    <div class="file-upload">
                        <input type="file" name="excel_peserta" class="file-upload-input" id="excelPeserta" accept=".xlsx,.xls,.csv" required>
                        <div class="file-upload-area" id="excelUploadArea">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <h5>Upload Excel Peserta</h5>
                            <p>Klik atau drag & drop file disini</p>
                            <small class="text-muted">Format: XLSX, XLS, CSV (Max: 2MB)</small>
                        </div>
                    </div>
                    <div class="file-info" id="excelInfo">
                        <i class="fas fa-file-excel"></i>
                        <div class="file-details">
                            <div class="file-name" id="excelName"></div>
                            <div class="file-size" id="excelSize"></div>
                        </div>
                        <button type="button" class="file-remove" onclick="removeFile('excel')">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- ===== SUBMIT BUTTON ===== -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    Submit Pengajuan TAK
                </button>
            </form>
        </div>

        <!-- ===== INFO CARDS ===== -->
        <div class="row g-4" data-aos="fade-up">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5>Waktu Proses</h5>
                    <p>Pengajuan diproses maksimal 3x24 jam kerja</p>
                    <ul>
                        <li><i class="fas fa-check"></i> Pending: Menunggu verifikasi</li>
                        <li><i class="fas fa-check"></i> Diproses: Sedang dicek</li>
                        <li><i class="fas fa-check"></i> Selesai: TAK diterbitkan</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>
                    <h5>Persyaratan</h5>
                    <ul>
                        <li><i class="fas fa-check"></i> Surat pengajuan bermaterai</li>
                        <li><i class="fas fa-check"></i> Daftar peserta di Excel</li>
                        <li><i class="fas fa-check"></i> Link sertifikat (PDF)</li>
                        <li><i class="fas fa-check"></i> Foto dokumentasi</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h5>Riwayat Pengajuan</h5>
                    <p>Cek status pengajuan TAK kamu</p>
                    <a href="<?= base_url('tak/riwayat') ?>" class="btn-template" style="width: 100%; justify-content: center; margin-top: 12px;">
                        <i class="fas fa-list"></i>
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

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

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // ==================== LOADING SCREEN ====================
    let progressInterval;
    
    function showLoadingScreen() {
        const loadingScreen = document.getElementById('loadingScreen');
        const progressBar = document.getElementById('progressBar');
        
        if (loadingScreen) {
            loadingScreen.classList.add('show');
            
            let progress = 0;
            if (progressBar) {
                progressBar.style.width = '0%';
                progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress >= 90) {
                        progress = 90;
                        clearInterval(progressInterval);
                    }
                    progressBar.style.width = progress + '%';
                }, 300);
            }
        }
    }
    
    function hideLoadingScreen() {
        const loadingScreen = document.getElementById('loadingScreen');
        const progressBar = document.getElementById('progressBar');
        
        if (progressInterval) {
            clearInterval(progressInterval);
        }
        
        if (progressBar) {
            progressBar.style.width = '100%';
        }
        
        setTimeout(() => {
            if (loadingScreen) {
                loadingScreen.classList.remove('show');
            }
            if (progressBar) {
                progressBar.style.width = '0%';
            }
        }, 500);
    }
    
    function showAlert(message, type) {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: type === 'success' ? 'Berhasil!' : 'Perhatian!',
            text: message,
            confirmButtonColor: '#f97316',
            timer: 3000,
            showConfirmButton: true
        });
    }

    // ==================== FILE UPLOAD HANDLING ====================
    function handleFileSelect(event, type) {
        const file = event.target.files[0];
        if (!file) return;
        
        const infoDiv = document.getElementById(type + 'Info');
        const nameSpan = document.getElementById(type + 'Name');
        const sizeSpan = document.getElementById(type + 'Size');
        
        // Validasi ukuran file
        const maxSize = type === 'surat' ? 5 * 1024 * 1024 : 2 * 1024 * 1024;
        if (file.size > maxSize) {
            showAlert('Ukuran file terlalu besar! Maksimal ' + (type === 'surat' ? '5MB' : '2MB'), 'error');
            event.target.value = '';
            return;
        }
        
        // Validasi format file
        const allowedTypes = type === 'surat' 
            ? ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
            : ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'];
        
        if (!allowedTypes.includes(file.type)) {
            showAlert('Format file tidak didukung. Gunakan format yang sesuai.', 'error');
            event.target.value = '';
            return;
        }
        
        const fileSize = (file.size / 1024).toFixed(2) + ' KB';
        nameSpan.textContent = file.name;
        sizeSpan.textContent = fileSize;
        infoDiv.classList.add('show');
        
        // Update icon based on file type
        const icon = infoDiv.querySelector('i');
        if (file.type.includes('pdf')) {
            icon.className = 'fas fa-file-pdf';
        } else if (file.type.includes('excel') || file.name.match(/\.(xls|xlsx|csv)$/i)) {
            icon.className = 'fas fa-file-excel';
        } else if (file.type.includes('word') || file.name.match(/\.(doc|docx)$/i)) {
            icon.className = 'fas fa-file-word';
        }
    }

    window.removeFile = function(type) {
        const fileInput = document.getElementById(type === 'surat' ? 'suratPengajuan' : 'excelPeserta');
        const infoDiv = document.getElementById(type + 'Info');
        
        fileInput.value = '';
        infoDiv.classList.remove('show');
    };

    // Attach event listeners
    document.getElementById('suratPengajuan').addEventListener('change', function(e) {
        handleFileSelect(e, 'surat');
    });

    document.getElementById('excelPeserta').addEventListener('change', function(e) {
        handleFileSelect(e, 'excel');
    });

    // ==================== DRAG & DROP ====================
    document.querySelectorAll('.file-upload-area').forEach(area => {
        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.style.background = 'rgba(249, 115, 22, 0.08)';
            area.style.borderColor = '#ea580c';
        });
        
        area.addEventListener('dragleave', (e) => {
            e.preventDefault();
            area.style.background = 'rgba(249, 115, 22, 0.02)';
            area.style.borderColor = '#f97316';
        });
        
        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.style.background = 'rgba(249, 115, 22, 0.02)';
            area.style.borderColor = '#f97316';
            
            const files = e.dataTransfer.files;
            const input = area.previousElementSibling;
            input.files = files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        });
    });

    // ==================== SET MAX DATE ====================
    const dateInput = document.querySelector('input[type="date"]');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('max', today);
    }

    // ==================== FORM SUBMIT LOADING ====================
    const form = document.getElementById('takForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Validasi sebelum submit
            const namaPic = document.querySelector('input[name="nama_pic"]')?.value.trim();
            const judulKegiatan = document.querySelector('input[name="judul_kegiatan"]')?.value.trim();
            const tanggalKegiatan = document.querySelector('input[name="tanggal_kegiatan"]')?.value;
            const lokasi = document.querySelector('input[name="lokasi"]')?.value.trim();
            const linkSertifikat = document.querySelector('input[name="link_sertifikat"]')?.value.trim();
            const suratFile = document.getElementById('suratPengajuan')?.files[0];
            const excelFile = document.getElementById('excelPeserta')?.files[0];
            
            if (!namaPic) {
                e.preventDefault();
                showAlert('Nama PIC wajib diisi', 'error');
                return false;
            }
            
            if (!judulKegiatan) {
                e.preventDefault();
                showAlert('Judul kegiatan wajib diisi', 'error');
                return false;
            }
            
            if (!tanggalKegiatan) {
                e.preventDefault();
                showAlert('Tanggal kegiatan wajib diisi', 'error');
                return false;
            }
            
            if (!lokasi) {
                e.preventDefault();
                showAlert('Lokasi kegiatan wajib diisi', 'error');
                return false;
            }
            
            if (!linkSertifikat) {
                e.preventDefault();
                showAlert('Link sertifikat wajib diisi', 'error');
                return false;
            }
            
            if (!suratFile) {
                e.preventDefault();
                showAlert('File surat pengajuan wajib diupload', 'error');
                return false;
            }
            
            if (!excelFile) {
                e.preventDefault();
                showAlert('File excel peserta wajib diupload', 'error');
                return false;
            }
            
            showLoadingScreen();
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            
            return true;
        });
    }

    // Hide loading screen on page load
    window.addEventListener('load', function() {
        hideLoadingScreen();
    });

    // Auto dismiss alert
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            setTimeout(() => bsAlert.close(), 3000);
        });
    }, 5000);
</script>

</body>
</html>