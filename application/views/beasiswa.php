<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Beasiswa FIK - Fakultas Industri Kreatif | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #ffffff; color: #1f2937; overflow-x: hidden; }
        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 16px 48px rgba(249, 115, 22, 0.12);
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }
        .container-custom { width: min(100% - 3rem, 1280px); margin-inline: auto; }

        /* Animations */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Header Glass */
        .header-glass { position: absolute; top: 24px; left: 0; right: 0; z-index: 50; transition: all 0.3s ease; }
        .navbar-glass { background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(20px); border-radius: 60px; padding: 12px 32px; border: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; transition: all 0.3s ease; }
        .navbar-glass.scrolled { background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(25px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .logo-area { display: flex; align-items: center; gap: 16px; }
        .logo-icon { width: 48px; height: 48px; background: linear-gradient(145deg, var(--orange), var(--orange-dark)); border-radius: 18px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.4rem; }
        .logo-text h5 { font-size: 0.9rem; font-weight: 800; color: white; margin: 0; }
        .logo-text span { font-size: 0.7rem; color: rgba(255,255,255,0.85); }
        .nav-links { display: flex; gap: 2rem; align-items: center; position: relative; }
        .nav-links a { color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; position: relative; padding-bottom: 4px; transition: all 0.3s ease; }
        .nav-links a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0%; height: 2px; background: var(--orange); transition: 0.3s ease; }
        .nav-links a.active::after, .nav-links a:hover::after { width: 100%; }
        .btn-mytelu-custom { background: linear-gradient(105deg, var(--orange), var(--orange-dark)); padding: 8px 28px; border-radius: 40px; font-weight: 700; color: white; transition: 0.3s; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .btn-mytelu-custom:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(249, 115, 22, 0.4); color: white; }
        .user-avatar-small { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }
        .mobile-toggle { display: none; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 8px 14px; font-size: 1.4rem; color: white; cursor: pointer; }

        /* Hero Section */
        .hero-beasiswa { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); padding: 160px 0 100px; position: relative; overflow: hidden; clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%); }
        .hero-beasiswa::before { content: ""; position: absolute; inset: 0; background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px); background-size: 32px 32px; pointer-events: none; }
        .hero-beasiswa h1 { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 800; color: white; text-align: center; position: relative; z-index: 1; font-family: 'Playfair Display', serif; animation: fadeInUp 0.8s ease; }
        .hero-beasiswa p { color: rgba(255,255,255,0.95); font-size: 1.2rem; text-align: center; max-width: 700px; margin: 16px auto 0; position: relative; z-index: 1; animation: fadeInUp 0.8s ease 0.1s both; }
        .floating-elements { position: absolute; inset: 0; pointer-events: none; overflow: hidden; }
        .floating-elements .element { position: absolute; opacity: 0.15; color: white; animation: float 6s ease-in-out infinite; }
        .floating-elements .element:nth-child(1) { top: 15%; left: 5%; font-size: 3rem; }
        .floating-elements .element:nth-child(2) { top: 60%; right: 8%; font-size: 2.5rem; animation-delay: 1s; }
        .floating-elements .element:nth-child(3) { bottom: 20%; left: 10%; font-size: 2rem; animation-delay: 0.5s; }
        .floating-elements .element:nth-child(4) { top: 30%; right: 15%; font-size: 2.8rem; animation-delay: 1.5s; }

        .beasiswa-section { padding: 60px 0 80px; }
        .section-title { text-align: center; margin-bottom: 50px; }
        .section-title h2 { font-size: 2.5rem; font-weight: 800; color: #1f2937; position: relative; display: inline-block; padding-bottom: 16px; font-family: 'Playfair Display', serif; }
        .section-title h2::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background: linear-gradient(90deg, var(--orange), var(--orange-dark)); border-radius: 2px; }

        /* Info Cards */
        .info-card { background: white; border-radius: 24px; padding: 32px 24px; box-shadow: var(--shadow); border: 1px solid #e2e8f0; transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1); height: 100%; }
        .info-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-hover); }
        .info-card-icon { width: 70px; height: 70px; background: linear-gradient(145deg, var(--orange-light), #fff); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
        .info-card-icon i { font-size: 2.2rem; color: var(--orange); }
        .info-card h3 { font-size: 1.3rem; font-weight: 800; margin-bottom: 12px; }
        .info-card p { color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px; }
        .info-card ul { list-style: none; padding: 0; margin: 0; }
        .info-card ul li { color: #4b5563; font-size: 0.85rem; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .info-card ul li i { color: var(--orange); width: 20px; }

        /* Timeline */
        .timeline-section { background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 30px; padding: 48px 40px; margin: 40px 0; color: white; }
        .timeline-section h3 { font-size: 2rem; font-weight: 700; margin-bottom: 40px; text-align: center; font-family: 'Playfair Display', serif; }
        .timeline-steps { display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap; }
        .timeline-step { text-align: center; flex: 1; }
        .step-number { width: 80px; height: 80px; background: linear-gradient(145deg, #1e293b, #0f172a); border: 3px solid var(--orange); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-weight: 800; font-size: 2rem; color: var(--orange); transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1); }
        .timeline-step:hover .step-number { background: var(--orange); color: white; transform: scale(1.1) rotate(360deg); }
        .step-label { font-weight: 700; font-size: 1rem; margin-bottom: 4px; }
        .step-date { font-size: 0.85rem; color: #fdba74; font-weight: 600; }

        /* Form Section */
        .form-section { background: white; border-radius: 32px; padding: 48px; box-shadow: var(--shadow); margin: 40px 0; border: 1px solid #e2e8f0; }
        .form-section h2 { font-size: 2rem; font-weight: 700; margin-bottom: 32px; position: relative; display: inline-block; padding-bottom: 12px; font-family: 'Playfair Display', serif; }
        .form-section h2::after { content: ''; position: absolute; bottom: 0; left: 0; width: 60px; height: 3px; background: linear-gradient(90deg, var(--orange), var(--orange-dark)); border-radius: 2px; }
        .form-label { font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
        .form-label i { color: var(--orange); width: 20px; }
        .form-label .required { color: #ef4444; font-weight: 700; }
        .form-control, .form-select { border: 2px solid #e2e8f0; border-radius: 14px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; background: #faf9f7; }
        .form-control:focus, .form-select:focus { border-color: var(--orange); box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1); background: white; outline: none; }

        /* File Upload */
        .file-upload { position: relative; margin-bottom: 16px; }
        .file-upload-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
        .file-upload-area { border: 2px dashed var(--orange); border-radius: 20px; padding: 32px; text-align: center; background: linear-gradient(145deg, rgba(249,115,22,0.02), rgba(249,115,22,0.05)); transition: all 0.3s ease; cursor: pointer; }
        .file-upload-area:hover { background: rgba(249,115,22,0.08); border-color: var(--orange-dark); transform: translateY(-2px); }
        .file-upload-area i { font-size: 3rem; color: var(--orange); margin-bottom: 16px; transition: transform 0.3s ease; }
        .file-upload-area:hover i { transform: scale(1.1); }
        .file-upload-area h5 { color: #1f2937; font-weight: 600; margin-bottom: 8px; }
        .file-info { display: none; background: linear-gradient(145deg, #f0fdf4, #e8fce8); border: 1px solid #22c55e; border-radius: 16px; padding: 16px; margin-top: 16px; align-items: center; gap: 16px; animation: fadeInUp 0.3s ease; }
        .file-info.show { display: flex; }
        .file-info i { font-size: 2rem; color: #22c55e; }
        .file-info .file-details { flex: 1; }
        .file-info .file-name { font-weight: 600; color: #1f2937; margin-bottom: 4px; word-break: break-all; }
        .file-info .file-size { font-size: 0.75rem; color: #6b7280; }
        .file-info .file-remove { background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.2rem; padding: 0; }
        .file-info .file-remove:hover { transform: scale(1.1); }

        .btn-submit { background: linear-gradient(135deg, var(--orange), var(--orange-dark)); color: white; border: none; padding: 14px 40px; border-radius: 50px; font-weight: 700; font-size: 1.1rem; display: inline-flex; align-items: center; gap: 12px; transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1); width: 100%; justify-content: center; margin-top: 16px; cursor: pointer; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(249, 115, 22, 0.4); }

        /* Tabel Pendaftar Beasiswa */
        .pendaftar-table-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: var(--shadow); margin-top: 40px; border: 1px solid #e2e8f0; }
        .pendaftar-table-card .card-header { background: linear-gradient(135deg, var(--orange), var(--orange-dark)); color: white; padding: 20px 24px; }
        .pendaftar-table-card .card-header h3 { margin: 0; font-weight: 700; font-size: 1.3rem; display: flex; align-items: center; gap: 10px; }
        .pendaftar-table { width: 100%; margin-bottom: 0; }
        .pendaftar-table th { background: #f8fafc; padding: 16px 20px; font-weight: 700; color: #1f2937; border-bottom: 2px solid #e2e8f0; }
        .pendaftar-table td { padding: 16px 20px; vertical-align: middle; border-bottom: 1px solid #e2e8f0; }
        .pendaftar-table tr:hover { background: #fef9f4; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .status-badge.pending { background: #fef3c7; color: #d97706; }
        .status-badge.diproses { background: #dbeafe; color: #2563eb; }
        .status-badge.diterima { background: #dcfce7; color: #16a34a; }
        .status-badge.ditolak { background: #fee2e2; color: #dc2626; }

        .back-button { display: inline-flex; align-items: center; gap: 10px; background: transparent; color: var(--orange); padding: 10px 24px; border-radius: 40px; text-decoration: none; font-weight: 600; border: 2px solid var(--orange); margin-bottom: 30px; transition: all 0.3s ease; }
        .back-button:hover { background: var(--orange); color: white; transform: translateX(-4px); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3); }
        
        .footer { background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%); color: white; padding: 40px 0 20px; margin-top: 60px; }
        .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s; }
        .footer a:hover { color: var(--orange); }
        .footer-bottom { text-align: center; padding-top: 20px; margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); }

        @media (max-width: 768px) {
            .navbar-glass { flex-direction: column; align-items: stretch; }
            .nav-links { display: none; flex-direction: column; margin-top: 16px; width: 100%; }
            .nav-links.open { display: flex !important; }
            .mobile-toggle { display: block; }
            .hero-beasiswa { padding: 120px 0 60px; }
            .hero-beasiswa h1 { font-size: 2rem; }
            .form-section { padding: 24px; }
            .pendaftar-table th, .pendaftar-table td { padding: 12px; font-size: 0.8rem; }
            .timeline-steps { flex-direction: column; }
            .timeline-step { margin-bottom: 20px; }
        }
    </style>
</head>
<body>



<?php $this->load->view('partials/navbar', ['active_menu' => 'layanan']); ?>

<!-- Hero Section -->
<section class="hero-beasiswa">
    <div class="floating-elements">
        <div class="element"><i class="fas fa-graduation-cap"></i></div>
        <div class="element"><i class="fas fa-trophy"></i></div>
        <div class="element"><i class="fas fa-book"></i></div>
        <div class="element"><i class="fas fa-star"></i></div>
    </div>
    <div class="container-custom">
        <h1 data-aos="fade-up">Beasiswa Fakultas Industri Kreatif</h1>
        <p data-aos="fade-up" data-aos-delay="100">Wujudkan Mimpi Mu Bersama Beasiswa FIK • Raih Pendidikan Tinggi Tanpa Khawatir Biaya</p>
    </div>
</section>

<!-- Main Content -->
<section class="beasiswa-section">
    <div class="container-custom">
        
        <a href="<?= base_url('dashboard') ?>" class="back-button" data-aos="fade-right">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="section-title" data-aos="fade-up">
            <h2>Program Beasiswa FIK 2025</h2>
            <p class="text-muted mt-3">Temukan beasiswa yang sesuai dengan program studi dan prestasimu.</p>
        </div>

        <!-- Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-graduation-cap"></i></div>
                    <h3>Beasiswa Prestasi</h3>
                    <p>Beasiswa bagi calon mahasiswa dengan prestasi akademik dan non-akademik unggul.</p>
                    <ul><li><i class="fas fa-check-circle"></i> Minimal nilai rapor 85</li><li><i class="fas fa-check-circle"></i> Memiliki prestasi minimal tingkat kota</li><li><i class="fas fa-check-circle"></i> Potongan UKT hingga 100%</li></ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3>Beasiswa KIP Kuliah</h3>
                    <p>Bantuan pendidikan bagi mahasiswa dari keluarga kurang mampu secara ekonomi.</p>
                    <ul><li><i class="fas fa-check-circle"></i> Terdaftar di DTKS Kemensos</li><li><i class="fas fa-check-circle"></i> Memiliki KIP atau PKH</li><li><i class="fas fa-check-circle"></i> Bebas UKT + biaya hidup</li></ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card">
                    <div class="info-card-icon"><i class="fas fa-paint-brush"></i></div>
                    <h3>Beasiswa Kreatif</h3>
                    <p>Khusus bagi calon mahasiswa dengan portofolio karya kreatif yang luar biasa.</p>
                    <ul><li><i class="fas fa-check-circle"></i> Memiliki portofolio karya</li><li><i class="fas fa-check-circle"></i> Pernah mengikuti pameran/lomba</li><li><i class="fas fa-check-circle"></i> Potongan UKT 50-100%</li></ul>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="timeline-section" data-aos="fade-up">
            <h3>📅 Jadwal Pendaftaran Beasiswa 2025</h3>
            <div class="timeline-steps">
                <div class="timeline-step"><div class="step-number">1</div><div class="step-label">Pendaftaran</div><div class="step-date">1 - 30 Juni 2025</div></div>
                <div class="timeline-step"><div class="step-number">2</div><div class="step-label">Seleksi Berkas</div><div class="step-date">1 - 10 Juli 2025</div></div>
                <div class="timeline-step"><div class="step-number">3</div><div class="step-label">Tes & Wawancara</div><div class="step-date">15 - 25 Juli 2025</div></div>
                <div class="timeline-step"><div class="step-number">4</div><div class="step-label">Pengumuman</div><div class="step-date">1 Agustus 2025</div></div>
            </div>
        </div>

        <!-- Form Pendaftaran -->
        <div class="form-section" id="form-daftar" data-aos="fade-up">
            <h2><i class="fas fa-pen-alt me-3"></i>Formulir Pendaftaran Beasiswa</h2>
            
            <form id="beasiswaForm" action="<?= base_url('beasiswa/test') ?>" method="POST" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span class="required">*</span></label><input type="text" class="form-control" name="nama" id="nama" required placeholder="Masukkan nama lengkap sesuai KTP"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-envelope"></i> Email <span class="required">*</span></label><input type="email" class="form-control" name="email" id="email" required placeholder="Contoh: email@domain.com"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-calendar-alt"></i> Tempat & Tanggal Lahir <span class="required">*</span></label><div class="row g-2"><div class="col-md-6"><input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" required placeholder="Tempat lahir"></div><div class="col-md-6"><input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required></div></div></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-trophy"></i> Jenis Beasiswa <span class="required">*</span></label><select class="form-select" name="jenis_beasiswa" id="jenis_beasiswa" required><option value="">Pilih jenis beasiswa</option><option value="prestasi">Beasiswa Prestasi Akademik</option><option value="kip">KIP Kuliah</option><option value="kreatif">Beasiswa Kreatif</option><option value="afirmasi">Beasiswa Afirmasi</option><option value="telu_unggul">Beasiswa Tel-U Unggul</option><option value="internasional">Beasiswa International</option></select></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-school"></i> Asal Sekolah <span class="required">*</span></label><input type="text" class="form-control" name="asal_sekolah" id="asal_sekolah" required placeholder="Nama sekolah asal"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-graduation-cap"></i> Jurusan <span class="required">*</span></label><input type="text" class="form-control" name="jurusan" id="jurusan" required placeholder="Jurusan di sekolah"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-calendar-check"></i> Tahun Lulus <span class="required">*</span></label><input type="number" class="form-control" name="tahun_lulus" id="tahun_lulus" required min="2020" max="2026" placeholder="Contoh: 2025"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-phone-alt"></i> Nomor WhatsApp <span class="required">*</span></label><input type="tel" class="form-control" name="no_hp" id="no_hp" required placeholder="Contoh: 081234567890"><div class="form-text">Aktif dan bisa dihubungi</div></div></div>
                    <div class="col-12"><div class="mb-3"><label class="form-label"><i class="fas fa-home"></i> Alamat <span class="required">*</span></label><textarea class="form-control" name="alamat" id="alamat" rows="2" required placeholder="Alamat lengkap sesuai KTP"></textarea></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-star"></i> Nilai Rapor <span class="required">*</span></label><input type="number" class="form-control" name="nilai_rapor" id="nilai_rapor" required min="0" max="100" step="0.01" placeholder="Contoh: 89.50"></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-chart-line"></i> Peringkat Kelas</label><input type="text" class="form-control" name="peringkat" id="peringkat" placeholder="Contoh: 4 dari 40 Siswa"></div></div>
                    <div class="col-12"><div class="mb-3"><label class="form-label"><i class="fas fa-medal"></i> Prestasi yang Pernah Diraih</label><textarea class="form-control" name="prestasi" id="prestasi" rows="2" placeholder="Contoh: Juara 1 Lomba Desain Poster Tingkat Provinsi 2024"></textarea></div></div>
                    
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-upload"></i> Upload File Nilai <span class="required">*</span></label><div class="file-upload"><input type="file" class="file-upload-input" id="file_nilai" name="file_nilai" accept=".pdf,.jpg,.jpeg,.png" required><div class="file-upload-area"><i class="fas fa-cloud-upload-alt"></i><h5>Upload File Nilai</h5><p>Klik atau drag & drop file disini</p><small>Format: PDF, JPG, JPEG, PNG (Max. 5MB)</small></div></div><div class="file-info" id="fileInfo"><i class="fas fa-file-pdf"></i><div class="file-details"><div class="file-name" id="fileName"></div><div class="file-size" id="fileSize"></div></div><button type="button" class="file-remove" onclick="removeFile('nilai')"><i class="fas fa-times-circle"></i></button></div></div></div>
                    <div class="col-md-6"><div class="mb-3"><label class="form-label"><i class="fas fa-camera"></i> Upload Foto</label><div class="file-upload"><input type="file" class="file-upload-input" id="file_foto" name="file_foto" accept=".jpg,.jpeg,.png"><div class="file-upload-area"><i class="fas fa-cloud-upload-alt"></i><h5>Upload Foto</h5><p>Klik atau drag & drop file disini</p><small>Format: JPG, JPEG, PNG (Max. 2MB)</small></div></div><div class="file-info" id="fotoInfo"><i class="fas fa-file-image"></i><div class="file-details"><div class="file-name" id="fotoName"></div><div class="file-size" id="fotoSize"></div></div><button type="button" class="file-remove" onclick="removeFile('foto')"><i class="fas fa-times-circle"></i></button></div></div></div>
                    <div class="col-12"><div class="mb-3"><label class="form-label"><i class="fas fa-file-signature"></i> Surat Rekomendasi</label><div class="file-upload"><input type="file" class="file-upload-input" id="file_rekomendasi" name="file_rekomendasi" accept=".pdf,.jpg,.jpeg,.png"><div class="file-upload-area"><i class="fas fa-cloud-upload-alt"></i><h5>Upload Surat Rekomendasi</h5><p>Klik atau drag & drop file disini</p><small>Format: PDF, JPG, JPEG, PNG (Max. 5MB)</small></div></div><div class="file-info" id="rekomendasiInfo"><i class="fas fa-file-pdf"></i><div class="file-details"><div class="file-name" id="rekomendasiName"></div><div class="file-size" id="rekomendasiSize"></div></div><button type="button" class="file-remove" onclick="removeFile('rekomendasi')"><i class="fas fa-times-circle"></i></button></div></div></div>
                    
                    <div class="col-12"><div class="mb-3"><div class="form-check"><input class="form-check-input" type="checkbox" id="persetujuan" required><label class="form-check-label" for="persetujuan">Saya menyatakan bahwa data yang saya isi adalah benar dan dapat dipertanggungjawabkan. <span class="required">*</span></label></div></div></div>
                    <div class="col-12"><button type="submit" class="btn-submit" id="submitBtn"><i class="fas fa-paper-plane"></i> Daftar Beasiswa Sekarang</button></div>
                </div>
            </form>
        </div>

        <!-- ===== DAFTAR PENDAFTAR BEASISWA ===== -->
        <div class="pendaftar-table-card" data-aos="fade-up">
            <div class="card-header">
                <h3><i class="fas fa-users"></i> Daftar Pendaftar Beasiswa</h3>
            </div>
            <div class="table-responsive">
                <table class="pendaftar-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Asal Sekolah</th>
                            <th>Jenis Beasiswa</th>
                            <th>Nilai Rapor</th>
                            <th>Status</th>
                            <th>Tgl Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendaftar_list)): ?>
                            <?php $no = 1; foreach ($pendaftar_list as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($p->nama) ?></strong></td>
                                    <td><?= htmlspecialchars($p->email) ?></td>
                                    <td><?= htmlspecialchars($p->no_hp) ?></td>
                                    <td><?= htmlspecialchars($p->asal_sekolah) ?></td>
                                    <td><?= ucfirst(str_replace('_', ' ', $p->jenis_beasiswa)) ?></td>
                                    <td><?= $p->nilai_rapor ?></td>
                                    <td><span class="status-badge <?= $p->status ?>"><?= $p->status == 'pending' ? 'Menunggu' : ($p->status == 'diproses' ? 'Diproses' : ($p->status == 'diterima' ? 'Diterima' : 'Ditolak')) ?></span></td>
                                    <td><?= date('d/m/Y', strtotime($p->tanggal_daftar)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center py-4">Belum ada pendaftar beasiswa</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container-custom">
        <div class="row">
            <div class="col-md-4 mb-4"><h4 class="mb-3" style="color: var(--orange);">Fakultas Industri Kreatif</h4><p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p></div>
            <div class="col-md-4 mb-4"><h4 class="mb-3" style="color: var(--orange);">Tautan Cepat</h4><ul class="list-unstyled"><li class="mb-2"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li><li class="mb-2"><a href="<?= base_url('berita') ?>">Berita</a></li><li class="mb-2"><a href="#">Layanan Mahasiswa</a></li><li class="mb-2"><a href="#">Forum Alumni</a></li></ul></div>
            <div class="col-md-4 mb-4"><h4 class="mb-3" style="color: var(--orange);">Kontak</h4><ul class="list-unstyled"><li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bandung, Jawa Barat</li><li class="mb-2"><i class="fas fa-envelope me-2"></i> fik@telkomuniversity.ac.id</li><li class="mb-2"><i class="fas fa-phone me-2"></i> (022) 756 5923</li></ul></div>
        </div>
        <div class="footer-bottom"><p class="mb-0">&copy; <?= date('Y') ?> Fakultas Industri Kreatif - Telkom University. All rights reserved.</p></div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    AOS.init({ duration: 800, once: true, offset: 50 });

    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });

    let isSubmitting = false;
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function handleFileSelect(input, infoElement, nameElement, sizeElement, maxSize) {
        const file = input.files[0];
        if (!file) return;
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) { 
            Swal.fire('Error', 'Format file tidak didukung. Gunakan PDF, JPG, atau PNG', 'error');
            input.value = ''; 
            return; 
        }
        if (file.size > maxSize) { 
            Swal.fire('Error', `Ukuran file terlalu besar. Maksimal ${formatFileSize(maxSize)}`, 'error');
            input.value = ''; 
            return; 
        }
        nameElement.textContent = file.name;
        sizeElement.textContent = formatFileSize(file.size);
        infoElement.classList.add('show');
        const icon = infoElement.querySelector('i');
        icon.className = file.type.includes('pdf') ? 'fas fa-file-pdf' : 'fas fa-file-image';
    }
    
    const fileNilai = document.getElementById('file_nilai');
    const fileInfo = document.getElementById('fileInfo');
    if (fileNilai) fileNilai.addEventListener('change', function() { handleFileSelect(this, fileInfo, document.getElementById('fileName'), document.getElementById('fileSize'), 5 * 1024 * 1024); });
    
    const fileFoto = document.getElementById('file_foto');
    const fotoInfo = document.getElementById('fotoInfo');
    if (fileFoto) fileFoto.addEventListener('change', function() { handleFileSelect(this, fotoInfo, document.getElementById('fotoName'), document.getElementById('fotoSize'), 2 * 1024 * 1024); });
    
    const fileRekomendasi = document.getElementById('file_rekomendasi');
    const rekomendasiInfo = document.getElementById('rekomendasiInfo');
    if (fileRekomendasi) fileRekomendasi.addEventListener('change', function() { handleFileSelect(this, rekomendasiInfo, document.getElementById('rekomendasiName'), document.getElementById('rekomendasiSize'), 5 * 1024 * 1024); });
    
    window.removeFile = function(type) {
        if (type === 'nilai') { if (fileNilai) fileNilai.value = ''; if (fileInfo) fileInfo.classList.remove('show'); }
        else if (type === 'foto') { if (fileFoto) fileFoto.value = ''; if (fotoInfo) fotoInfo.classList.remove('show'); }
        else if (type === 'rekomendasi') { if (fileRekomendasi) fileRekomendasi.value = ''; if (rekomendasiInfo) rekomendasiInfo.classList.remove('show'); }
    };
    
    // Submit form
const form = document.getElementById('beasiswaForm');
const submitBtn = document.getElementById('submitBtn');
const persetujuan = document.getElementById('persetujuan');

if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isSubmitting) return;
        
        // Validasi file nilai
        if (fileNilai && !fileNilai.files[0] && !fileInfo.classList.contains('show')) { 
            Swal.fire('Error', 'File nilai wajib diupload', 'error');
            return; 
        }
        
        // Validasi persetujuan
        if (persetujuan && !persetujuan.checked) { 
            Swal.fire('Error', 'Anda harus menyetujui pernyataan data yang diisi', 'error');
            return; 
        }
        
        isSubmitting = true;
        if (submitBtn) { 
            submitBtn.disabled = true; 
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mendaftarkan...'; 
        }
        
        var formData = new FormData(form);
        
        $.ajax({
            url: '<?= base_url("beasiswa/submit") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                console.log('Response:', response); // DEBUG: lihat response di console
                
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#f97316',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
                
                if (submitBtn) { 
                    submitBtn.disabled = false; 
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Daftar Beasiswa Sekarang'; 
                }
                isSubmitting = false;
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', xhr.responseText); // DEBUG: lihat error response
                
                // Coba parse response jika ada
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        Swal.fire('Error!', response.message, 'error');
                    } else {
                        Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                } catch(e) {
                    Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
                
                if (submitBtn) { 
                    submitBtn.disabled = false; 
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Daftar Beasiswa Sekarang'; 
                }
                isSubmitting = false;
            }
        });
    });
}
</script>
</body>
</html>