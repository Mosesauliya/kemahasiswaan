<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Detail Pengajuan TAK - Kemahasiswaan FIK | Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
            background: #f8fafc;
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
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .container-custom {
            width: min(100% - 3rem, 1280px);
            margin-inline: auto;
        }

        /* ========== HERO SECTION ========== */
        .hero-detail {
            background: linear-gradient(135deg, var(--orange) 0%, #fdba74 100%);
            padding: 140px 0 80px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        .hero-detail::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-detail .wave-bottom {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-detail h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: white;
            text-align: center;
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .hero-detail p {
            color: rgba(255,255,255,0.95);
            font-size: 1.1rem;
            text-align: center;
            max-width: 600px;
            margin: 16px auto 0;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        /* Floating Elements */
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

        /* ========== BREADCRUMB ========== */
        .breadcrumb-custom {
            background: transparent;
            padding: 1rem 0;
            margin-bottom: 0;
        }

        .breadcrumb-custom .breadcrumb {
            background: transparent;
            justify-content: center;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-custom .breadcrumb-item a:hover {
            color: white;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.5);
        }

        /* ========== DETAIL CARD ========== */
        .detail-container {
            padding: 60px 0 80px;
        }

        .detail-card {
            background: white;
            border-radius: 32px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
            margin-top: -60px;
        }

        .detail-card:hover {
            box-shadow: 0 25px 70px rgba(249,115,22,0.1);
        }

        /* Status Badge */
        .status-badge {
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fffbeb);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-diproses {
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .status-disetujui {
            background: linear-gradient(135deg, #d1fae5, #ecfdf5);
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .status-ditolak {
            background: linear-gradient(135deg, #fee2e2, #fef2f2);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Section Title */
        .section-title {
            color: #1f2937;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid var(--orange);
            display: inline-block;
            font-family: 'Playfair Display', serif;
        }

        /* Detail Item */
        .detail-item {
            display: flex;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: #faf9f7;
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: var(--orange-light);
            transform: translateX(5px);
        }

        .detail-label {
            width: 180px;
            font-weight: 600;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-label i {
            color: var(--orange);
            width: 24px;
        }

        .detail-value {
            flex: 1;
            color: #1f2937;
            font-weight: 500;
        }

        .detail-value a {
            color: var(--orange);
            text-decoration: none;
        }

        .detail-value a:hover {
            text-decoration: underline;
        }

        /* File Badge */
        .file-badge {
            background: white;
            border: 1px solid var(--border);
            border-radius: 40px;
            padding: 8px 20px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #1f2937;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .file-badge:hover {
            background: var(--orange);
            color: white;
            border-color: var(--orange);
            transform: translateY(-2px);
        }

        .file-badge:hover i {
            color: white;
        }

        .file-badge i {
            font-size: 1.2rem;
            color: var(--orange);
            transition: color 0.3s ease;
        }

        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 12px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--orange), #fdba74);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0;
            width: 16px;
            height: 16px;
            background: var(--orange);
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px var(--orange);
            z-index: 2;
        }

        .timeline-date {
            font-size: 0.8rem;
            color: var(--orange);
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .timeline-title {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.3rem;
            font-size: 1rem;
        }

        .timeline-desc {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Catatan Box */
        .catatan-box {
            background: linear-gradient(145deg, var(--orange-light), #fff);
            border-left: 4px solid var(--orange);
            padding: 1.5rem;
            border-radius: 16px;
            margin-top: 1rem;
        }

        .catatan-box p {
            margin: 0;
            color: #1f2937;
            line-height: 1.6;
        }

        /* Back Button */
        .btn-back {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            color: white;
            padding: 12px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .btn-back:hover {
            transform: translateX(-5px);
            box-shadow: 0 12px 20px rgba(249,115,22,0.4);
            color: white;
        }

        /* ========== FOOTER ========== */
        .footer {
            background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 40px;
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
            .hero-detail {
                padding: 120px 0 60px;
            }
            .detail-card {
                padding: 1.5rem;
            }
            .detail-item {
                flex-direction: column;
                gap: 0.5rem;
            }
            .detail-label {
                width: 100%;
            }
            .status-badge {
                padding: 8px 20px;
                font-size: 0.85rem;
            }
            .section-title {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            .container-custom {
                width: min(100% - 1.5rem, 1280px);
            }
            .detail-card {
                padding: 1rem;
            }
            .file-badge {
                padding: 6px 16px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'layanan']); ?>

<!-- ========== HERO SECTION ========== -->
<section class="hero-detail">
    <div class="floating-elements">
        <div class="element"><i class="fas fa-clipboard-list"></i></div>
        <div class="element"><i class="fas fa-file-alt"></i></div>
        <div class="element"><i class="fas fa-check-circle"></i></div>
        <div class="element"><i class="fas fa-calendar-check"></i></div>
    </div>
    <div class="container-custom">
        <div class="breadcrumb-custom">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('tak/riwayat') ?>">Riwayat TAK</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail Pengajuan</li>
                </ol>
            </nav>
        </div>
        <h1 data-aos="fade-up">Detail Pengajuan TAK</h1>
        <p data-aos="fade-up" data-aos-delay="100">Informasi lengkap pengajuan TAK Kolektif Anda</p>
    </div>
    <div class="wave-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- ========== MAIN CONTENT ========== -->
<div class="detail-container">
    <div class="container-custom">
        <div class="detail-card" data-aos="fade-up">
            <!-- Status -->
            <div class="text-center">
                <?php
                $status_class = '';
                $status_icon = '';
                $status_text = '';
                $status = isset($pengajuan->status) ? $pengajuan->status : 'pending';
                
                switch($status) {
                    case 'pending':
                        $status_class = 'status-pending';
                        $status_icon = 'fa-clock';
                        $status_text = 'Menunggu Verifikasi';
                        break;
                    case 'diproses':
                        $status_class = 'status-diproses';
                        $status_icon = 'fa-spinner fa-spin';
                        $status_text = 'Sedang Diproses';
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
            </div>

            <!-- Kode Pengajuan -->
            <div class="text-center mb-4">
                <small class="text-muted">Kode Pengajuan</small>
                <div class="fw-bold fs-5" style="color: var(--orange);">
                    <?= isset($pengajuan->kode_pengajuan) ? $pengajuan->kode_pengajuan : 'TAK/' . date('Ymd') . '/0001' ?>
                </div>
            </div>

            <!-- Timeline -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-history me-2"></i> Timeline Pengajuan
                </h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date"><?= date('d F Y H:i', strtotime($pengajuan->created_at ?? date('Y-m-d H:i:s'))) ?></div>
                        <div class="timeline-title">Pengajuan Dibuat</div>
                        <div class="timeline-desc">Pengajuan TAK berhasil dikirim dan sedang menunggu verifikasi</div>
                    </div>
                    
                    <?php if($status != 'pending'): ?>
                    <div class="timeline-item">
                        <div class="timeline-date"><?= date('d F Y H:i', strtotime($pengajuan->updated_at ?? date('Y-m-d H:i:s'))) ?></div>
                        <div class="timeline-title">
                            <?php
                            if($status == 'diproses') echo 'Pengajuan Diproses';
                            elseif($status == 'disetujui') echo 'Pengajuan Disetujui';
                            elseif($status == 'ditolak') echo 'Pengajuan Ditolak';
                            ?>
                        </div>
                        <div class="timeline-desc">Status pengajuan telah diperbarui oleh verifikator</div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Data Penanggung Jawab -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-user-tie me-2"></i> Data Penanggung Jawab
                </h3>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-user"></i> Nama PIC
                    </div>
                    <div class="detail-value"><?= $pengajuan->nama_pic ?? '-' ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-id-card"></i> NIM
                    </div>
                    <div class="detail-value"><?= $pengajuan->nim ?? $this->session->userdata('nim') ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-user-graduate"></i> Nama Mahasiswa
                    </div>
                    <div class="detail-value"><?= $pengajuan->nama_mahasiswa ?? $this->session->userdata('nama') ?></div>
                </div>
            </div>

            <!-- Data Kegiatan -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt me-2"></i> Data Kegiatan
                </h3>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-heading"></i> Judul Kegiatan
                    </div>
                    <div class="detail-value"><?= $pengajuan->judul_kegiatan ?? '-' ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </div>
                    <div class="detail-value"><?= nl2br($pengajuan->deskripsi ?? '-') ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-calendar-day"></i> Tanggal Kegiatan
                    </div>
                    <div class="detail-value"><?= isset($pengajuan->tanggal_kegiatan) ? date('d F Y', strtotime($pengajuan->tanggal_kegiatan)) : '-' ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-map-marker-alt"></i> Lokasi
                    </div>
                    <div class="detail-value"><?= $pengajuan->lokasi ?? '-' ?></div>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-file-alt me-2"></i> Dokumen Pendukung
                </h3>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-link"></i> Link Sertifikat
                    </div>
                    <div class="detail-value">
                        <a href="<?= $pengajuan->link_sertifikat ?? '#' ?>" target="_blank" class="file-badge">
                            <i class="fas fa-external-link-alt"></i>
                            Buka Link Sertifikat
                        </a>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-file-pdf"></i> Surat Pengajuan
                    </div>
                    <div class="detail-value">
                        <?php 
                            $surat_ext = strtolower(pathinfo($pengajuan->file_surat_pengajuan ?? '', PATHINFO_EXTENSION)); 
                            $surat_url = base_url('uploads/surat_pengajuan/' . ($pengajuan->file_surat_pengajuan ?? ''));
                            if ($surat_ext === 'pdf') {
                                $surat_preview = $surat_url;
                            } else {
                                $surat_preview = 'https://view.officeapps.live.com/op/view.aspx?src=' . urlencode($surat_url);
                            }
                        ?>
                        <a href="<?= base_url('tak/download_berkas/' . $pengajuan->id . '/surat') ?>" class="file-badge">
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                        <a href="<?= $surat_preview ?>" target="_blank" class="file-badge ms-2" style="background: var(--orange-light); color: var(--orange);">
                            <i class="fas fa-eye"></i>
                            Lihat (Preview)
                        </a>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">
                        <i class="fas fa-file-excel"></i> Excel Peserta
                    </div>
                    <div class="detail-value">
                        <?php 
                            $excel_ext = strtolower(pathinfo($pengajuan->file_excel_peserta ?? '', PATHINFO_EXTENSION)); 
                            $excel_url = base_url('uploads/excel_peserta/' . ($pengajuan->file_excel_peserta ?? ''));
                            if ($excel_ext === 'csv') {
                                $excel_preview = 'https://docs.google.com/viewer?url=' . urlencode($excel_url) . '&embedded=true';
                            } else {
                                $excel_preview = 'https://view.officeapps.live.com/op/view.aspx?src=' . urlencode($excel_url);
                            }
                        ?>
                        <a href="<?= base_url('tak/download_berkas/' . $pengajuan->id . '/excel') ?>" class="file-badge">
                            <i class="fas fa-download"></i>
                            Download
                        </a>
                        <a href="<?= $excel_preview ?>" target="_blank" class="file-badge ms-2" style="background: var(--orange-light); color: var(--orange);">
                            <i class="fas fa-eye"></i>
                            Lihat (Preview)
                        </a>
                    </div>
                </div>
            </div>

            <!-- Catatan Verifikator -->
            <?php if(isset($pengajuan->catatan) && !empty($pengajuan->catatan)): ?>
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-comment me-2"></i> Catatan Verifikator
                </h3>
                <div class="catatan-box">
                    <p><?= nl2br($pengajuan->catatan) ?></p>
                </div>
            </div>
            <?php elseif(isset($pengajuan->catatan_admin) && !empty($pengajuan->catatan_admin)): ?>
            <div class="mb-4">
                <h3 class="section-title">
                    <i class="fas fa-comment me-2"></i> Catatan Verifikator
                </h3>
                <div class="catatan-box">
                    <p><?= nl2br($pengajuan->catatan_admin) ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Tombol Kembali -->
            <div class="text-center mt-4">
                <a href="<?= base_url('tak/riwayat') ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

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
</script>

</body>
</html>