<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $title ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --blue: #1e3a8a;
            --blue-dark: #0f2b66;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--orange);
            border-radius: 10px;
        }

        /* Header Glass */
        .header-glass {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 16px 0;
            transition: padding 0.3s ease;
        }

        .header-glass.scrolled {
            padding: 8px 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
        }

        .navbar-glass {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(20px);
            border-radius: 60px;
            padding: 10px 32px;
            border: 1px solid rgba(255,255,255,0.2);
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
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            position: relative;
            padding-bottom: 4px;
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

        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }


        .btn-mytelu-custom {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            padding: 8px 28px;
            border-radius: 40px;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-mytelu-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(249,115,22,0.4);
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
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            padding: 8px 16px;
            font-size: 1.3rem;
            color: white;
            cursor: pointer;
        }

        /* Hero Section Premium */
        .berita-header {
            position: relative;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            overflow: hidden;
        }

        .berita-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
            z-index: 1;
        }

        .berita-header .bg-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.3s ease;
        }

        .berita-header .container {
            position: relative;
            z-index: 2;
            padding: 140px 0 80px;
        }

        .berita-header h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease;
        }

        .berita-meta {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            font-size: 0.95rem;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .berita-meta span {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 8px 18px;
            border-radius: 40px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .berita-meta i {
            color: var(--orange);
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-custom a {
            color: var(--orange);
            text-decoration: none;
            font-weight: 600;
        }

        .breadcrumb-custom a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: rgba(255,255,255,0.8);
        }

        /* Content Card */
        .berita-content {
            background: white;
            border-radius: 32px;
            padding: 3rem;
            margin-top: -3rem;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.1);
            position: relative;
            z-index: 10;
        }

        .berita-content img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            margin: 2rem 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .berita-content p {
            line-height: 1.8;
            color: #374151;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .berita-content h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 2.5rem 0 1rem;
            font-family: 'Playfair Display', serif;
        }

        .berita-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin: 2rem 0 1rem;
        }

        .berita-content blockquote {
            border-left: 4px solid var(--orange);
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            background: var(--orange-light);
            border-radius: 16px;
            font-style: italic;
            color: #4b5563;
        }

        /* Share Buttons Sticky */
        .berita-share {
            position: sticky;
            top: 90px;
        }

        .share-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1f2937;
        }

        .share-btn {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem 1.2rem;
            background: #f8fafc;
            color: #1f2937;
            text-decoration: none;
            border-radius: 14px;
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .share-btn:hover {
            background: var(--orange);
            color: white;
            transform: translateX(5px);
            border-color: var(--orange);
        }

        .share-btn i {
            width: 24px;
            font-size: 1.2rem;
        }

        /* Komentar Section */
        .komentar-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            animation: fadeInUp 0.5s ease;
        }

        .komentar-card:hover {
            transform: translateX(5px);
            border-color: var(--orange);
        }

        .komentar-nama {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .komentar-nama i {
            color: var(--orange);
        }

        .komentar-tanggal {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 0.8rem;
        }

        .komentar-text {
            color: #4b5563;
            line-height: 1.6;
        }

        /* Form Komentar Premium */
        .form-komentar {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            padding: 2rem;
            border-radius: 24px;
            margin-top: 2rem;
            border: 1px solid #e2e8f0;
        }

        .form-control-custom {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
            outline: none;
        }

        .btn-custom {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            border: none;
            padding: 12px 32px;
            border-radius: 40px;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249,115,22,0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid #e2e8f0;
            padding: 10px 28px;
            border-radius: 40px;
            font-weight: 600;
            color: #1f2937;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-outline-custom:hover {
            border-color: var(--orange);
            color: var(--orange);
            transform: translateY(-2px);
        }

        /* Sidebar Cards */
        .sidebar-card {
            background: white;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            border: 1px solid #f0f2f5;
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .sidebar-card h4 {
            font-weight: 800;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--orange);
            display: inline-block;
            color: #1f2937;
            font-size: 1.2rem;
        }

        /* Related News Card */
        .related-card {
            display: flex;
            gap: 1rem;
            padding: 0.8rem;
            background: #f8fafc;
            border-radius: 16px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            border: 1px solid transparent;
        }

        .related-card:hover {
            transform: translateX(5px);
            border-color: var(--orange);
            background: white;
            box-shadow: 0 5px 15px rgba(249,115,22,0.1);
        }

        .related-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
        }

        .related-card h5 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: #1f2937;
            line-height: 1.4;
        }

        .related-card .date {
            font-size: 0.7rem;
            color: #6b7280;
        }

        /* Popular List */
        .popular-list {
            list-style: none;
            padding: 0;
        }

        .popular-list li {
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .popular-list li:last-child {
            border-bottom: none;
        }

        .popular-list li a {
            color: #1f2937;
            text-decoration: none;
            font-weight: 600;
            display: block;
            transition: color 0.2s;
        }

        .popular-list li a:hover {
            color: var(--orange);
        }

        .popular-list .views {
            font-size: 0.7rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Reading Progress Bar */
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            z-index: 1000;
        }

        .progress-bar-custom {
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            width: 0%;
            transition: width 0.1s ease;
        }

        /* Footer */
        .footer {
            background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%);
            color: white;
            padding: 60px 0 30px;
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
            padding-top: 30px;
            margin-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Animations */
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

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-glass {
                flex-direction: column;
                align-items: stretch;
                padding: 12px 20px;
            }
            
            .nav-links {
                display: none;
                flex-direction: column;
                align-items: center;
                margin-top: 12px;
                gap: 16px;
            }
            
            .nav-links.open {
                display: flex !important;
            }
            
            .mobile-toggle {
                display: block;
                align-self: flex-end;
            }

            .berita-header h1 {
                font-size: 2rem;
            }
            
            .berita-content {
                padding: 1.5rem;
            }
            
            .berita-meta span {
                padding: 5px 12px;
                font-size: 0.8rem;
            }

            /* Sticky share: disable on mobile, show inline */
            .berita-share {
                position: static;
            }
        }
    </style>
</head>
<body>

<!-- Reading Progress Bar -->
<div class="progress-container">
    <div class="progress-bar-custom" id="readingProgressBar"></div>
</div>

<?php $this->load->view('partials/navbar', ['active_menu' => 'informasi']); ?>

<!-- Hero Section -->
<div class="berita-header">
    <div class="bg-image" style="background-image: url('<?= base_url('uploads/berita/' . ($berita['gambar'] ?: 'default.jpg')) ?>');"></div>
    <div class="container">
        <div class="breadcrumb-custom">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars(substr($berita['judul'], 0, 50)) ?>...</li>
                </ol>
            </nav>
        </div>
        
        <h1 data-aos="fade-up"><?= htmlspecialchars($berita['judul']) ?></h1>
        
        <div class="berita-meta" data-aos="fade-up" data-aos-delay="100">
            <span><i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($berita['published_at'])) ?></span>
            <span><i class="fas fa-user-circle"></i> <?= $berita['penulis'] ?: 'Humas FIK' ?></span>
            <span><i class="fas fa-tag"></i> <?= ucfirst($berita['kategori']) ?></span>
            <span><i class="fas fa-eye"></i> <?= number_format($berita['views']) ?> views</span>
            <span><i class="fas fa-clock"></i> <?= ceil(str_word_count(strip_tags($berita['konten'])) / 200) ?> min read</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container" style="max-width: 1280px;">
    <div class="row g-4">
        <!-- Left Column: Berita Content -->
        <div class="col-lg-8">
            <div class="berita-content" data-aos="fade-up">
                <?= $berita['konten'] ?>
                
                <hr class="my-5">
                
                <!-- Tags & Kategori -->
                <div class="mb-4">
                    <strong><i class="fas fa-tags me-2" style="color: var(--orange);"></i>Kategori:</strong>
                    <a href="<?= base_url('berita/kategori/' . $berita['kategori']) ?>" class="btn btn-sm ms-2" style="background: var(--orange-light); color: var(--orange); border-radius: 30px; font-weight: 600;">
                        <?= ucfirst($berita['kategori']) ?>
                    </a>
                </div>
                
                <!-- Navigasi -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="<?= base_url('berita') ?>" class="btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                    </a>
                    
                    <div>
                        <small class="text-muted me-2">Bagikan:</small>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="text-decoration-none me-2" style="color: #1877f2;"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($berita['judul']) ?>" target="_blank" class="text-decoration-none me-2" style="color: #1da1f2;"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="https://wa.me/?text=<?= urlencode($berita['judul'] . ' - ' . current_url()) ?>" target="_blank" class="text-decoration-none me-2" style="color: #25d366;"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="#" class="text-decoration-none" id="copyLinkBtn" style="color: var(--orange);"><i class="fas fa-link fa-lg"></i></a>
                    </div>
                </div>
            </div>

            <!-- Komentar Section Premium -->
            <div class="berita-content mt-4" data-aos="fade-up" data-aos-delay="100">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <h4 class="mb-0"><i class="far fa-comments me-2" style="color: var(--orange);"></i>Komentar (<span id="totalKomentar"><?= $total_komentar ?></span>)</h4>
                    <button class="btn btn-sm" id="scrollToFormBtn" style="background: var(--orange-light); color: var(--orange); border-radius: 30px;">
                        <i class="fas fa-pen"></i> Tulis Komentar
                    </button>
                </div>
                
                <div id="komentarList">
                    <?php if(!empty($komentar)): ?>
                        <?php foreach($komentar as $k): ?>
                        <div class="komentar-card" data-aos="fade-up" data-komentar-id="<?= $k['id'] ?>">
                            <div class="komentar-nama">
                                <i class="fas fa-user-circle fa-lg"></i> <?= htmlspecialchars($k['nama']) ?>
                                <?php if($k['email']): ?>
                                    <small class="text-muted">(<?= htmlspecialchars($k['email']) ?>)</small>
                                <?php endif; ?>
                            </div>
                            <div class="komentar-tanggal">
                                <i class="far fa-clock"></i> <?= date('d F Y H:i', strtotime($k['created_at'])) ?>
                            </div>
                            <div class="komentar-text">
                                <?= nl2br(htmlspecialchars($k['komentar'])) ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div id="noKomentarMessage" class="text-center py-5">
                            <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Form Komentar Premium -->
                <div class="form-komentar" id="formKomentarSection">
                    <h5 class="mb-3"><i class="fas fa-pencil-alt me-2" style="color: var(--orange);"></i>Tulis Komentar</h5>
                    <?php if(isset($user_data) && $user_data && $user_data['logged_in']): ?>
                    <form id="formKomentar">
                        <input type="hidden" name="berita_id" value="<?= $berita['id'] ?>">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-custom" name="nama" value="<?= htmlspecialchars($user_data['nama'] ?? '') ?>" placeholder="Nama Lengkap *" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-custom" name="email" value="<?= htmlspecialchars($user_data['email'] ?? '') ?>" placeholder="Email (opsional)">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <textarea class="form-control form-control-custom" name="komentar" rows="4" placeholder="Tulis komentar Anda... *" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn-custom" id="submitKomentarBtn">
                            <i class="far fa-paper-plane me-2"></i>Kirim Komentar
                        </button>
                        <span id="loadingIndicator" style="display: none; margin-left: 15px;">
                            <span class="loading-spinner"></span> Mengirim...
                        </span>
                    </form>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <p class="text-muted mb-3">Anda harus login terlebih dahulu untuk dapat memberikan komentar.</p>
                        <a href="<?= base_url('login') ?>" class="btn-custom">
                            <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar -->
        <div class="col-lg-4">
            <!-- Share Buttons Sticky -->
            <div class="berita-share" data-aos="fade-left">
                <div class="sidebar-card">
                    <div class="share-title"><i class="fas fa-share-alt me-2" style="color: var(--orange);"></i> Bagikan Artikel</div>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="share-btn">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($berita['judul']) ?>" target="_blank" class="share-btn">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="https://wa.me/?text=<?= urlencode($berita['judul'] . ' - ' . current_url()) ?>" target="_blank" class="share-btn">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="#" class="share-btn" id="copyLinkBtnSidebar">
                        <i class="fas fa-link"></i> Salin Link
                    </a>
                </div>
            </div>

            <!-- Related News -->
            <div class="sidebar-card" data-aos="fade-left" data-aos-delay="100">
                <h4><i class="fas fa-newspaper me-2" style="color: var(--orange);"></i> Berita Terkait</h4>
                <?php if(!empty($related)): ?>
                    <?php foreach($related as $r): ?>
                    <a href="<?= base_url('berita/detail/' . $r['slug']) ?>" class="related-card">
                        <img src="<?= base_url('uploads/berita/' . ($r['gambar'] ?: 'default.jpg')) ?>" 
                             alt="<?= htmlspecialchars($r['judul']) ?>"
                             onerror="this.src='https://placehold.co/80x80/f97316/white?text=FIK'">
                        <div>
                            <h5><?= htmlspecialchars($r['judul']) ?></h5>
                            <div class="date">
                                <i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($r['published_at'])) ?>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-3">Tidak ada berita terkait</p>
                <?php endif; ?>
            </div>

            <!-- Popular News -->
            <div class="sidebar-card" data-aos="fade-left" data-aos-delay="200">
                <h4><i class="fas fa-fire me-2" style="color: var(--orange);"></i> Berita Populer</h4>
                <ul class="popular-list">
                    <?php if(!empty($populer)): ?>
                        <?php foreach($populer as $p): ?>
                        <li>
                            <a href="<?= base_url('berita/detail/' . $p['slug']) ?>">
                                <?= htmlspecialchars($p['judul']) ?>
                            </a>
                            <div class="views">
                                <i class="fas fa-eye"></i> <?= number_format($p['views']) ?> views
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="text-muted text-center py-2">Belum ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 50
    });

    // Reading Progress Bar
    window.addEventListener('scroll', function() {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('readingProgressBar');
        if(progressBar) {
            progressBar.style.width = scrolled + '%';
        }
    });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const header = document.getElementById('mainHeader');
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 30) {
            if(header) header.classList.add('scrolled');
            if(navbar) navbar.classList.add('scrolled');
        } else {
            if(header) header.classList.remove('scrolled');
            if(navbar) navbar.classList.remove('scrolled');
        }
    });

    // Copy Link Function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Link berhasil disalin',
                timer: 1500,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menyalin link',
                timer: 1500,
                showConfirmButton: false
            });
        });
    }

    document.getElementById('copyLinkBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        copyToClipboard(window.location.href);
    });

    document.getElementById('copyLinkBtnSidebar')?.addEventListener('click', function(e) {
        e.preventDefault();
        copyToClipboard(window.location.href);
    });

    // Scroll to form button
    document.getElementById('scrollToFormBtn')?.addEventListener('click', function() {
        document.getElementById('formKomentarSection').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });

    // Function to add new comment to the list dynamically
    function addCommentToDOM(comment) {
        const komentarList = document.getElementById('komentarList');
        const noKomentarMessage = document.getElementById('noKomentarMessage');
        
        // Remove "no comments" message if exists
        if(noKomentarMessage) {
            noKomentarMessage.remove();
        }
        
        // Create new comment element
        const newComment = document.createElement('div');
        newComment.className = 'komentar-card';
        newComment.setAttribute('data-aos', 'fade-up');
        newComment.setAttribute('data-komentar-id', comment.id);
        newComment.style.animation = 'fadeInUp 0.5s ease';
        newComment.innerHTML = `
            <div class="komentar-nama">
                <i class="fas fa-user-circle fa-lg"></i> ${escapeHtml(comment.nama)}
                ${comment.email ? `<small class="text-muted">(${escapeHtml(comment.email)})</small>` : ''}
            </div>
            <div class="komentar-tanggal">
                <i class="far fa-clock"></i> ${comment.created_at}
            </div>
            <div class="komentar-text">
                ${escapeHtml(comment.komentar).replace(/\n/g, '<br>')}
            </div>
        `;
        
        // Add to top of the list
        if(komentarList.firstChild) {
            komentarList.insertBefore(newComment, komentarList.firstChild);
        } else {
            komentarList.appendChild(newComment);
        }
        
        // Update total komentar count
        const totalSpan = document.getElementById('totalKomentar');
        if(totalSpan) {
            let currentTotal = parseInt(totalSpan.innerText) || 0;
            totalSpan.innerText = currentTotal + 1;
        }
        
        // Re-trigger AOS for new element
        AOS.refresh();
    }
    
    // Helper function to escape HTML
    function escapeHtml(text) {
        if(!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Form komentar AJAX
    const formKomentar = document.getElementById('formKomentar');
    if(formKomentar) {
        formKomentar.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitKomentarBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const formData = new FormData(this);
            
            // Show loading
            if(submitBtn) submitBtn.disabled = true;
            if(loadingIndicator) loadingIndicator.style.display = 'inline-block';
            
            fetch('<?= base_url("berita/add_komentar") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Komentar Berhasil!',
                        text: data.message || 'Komentar Anda telah terkirim',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    if(data.komentar) {
                        addCommentToDOM(data.komentar);
                    } else {
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                    
                    formKomentar.reset();
                    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan. Silakan coba lagi.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan koneksi. Silakan coba lagi.'
                });
            })
            .finally(() => {
                if(submitBtn) submitBtn.disabled = false;
                if(loadingIndicator) loadingIndicator.style.display = 'none';
            });
        });
    }

    // Fix gambar error
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            if(!this.src.includes('placehold.co') && !this.src.includes('no-image')) {
                this.src = 'https://placehold.co/800x400/f97316/white?text=FIK';
            }
        });
    });
</script>
</body>
</html>