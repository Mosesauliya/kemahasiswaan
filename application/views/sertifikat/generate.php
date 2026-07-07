<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Sertifikat | Admin Sertifikat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar (sama persis dengan admin.php) ── */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .sidebar-header p {
            margin: 0.5rem 0 0;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(230, 126, 34, 0.2);
            color: white;
            border-left-color: #E67E22;
        }

        .sidebar-menu a i {
            width: 20px;
            color: #E67E22;
        }

        .sidebar-menu .menu-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 1rem 0;
        }

        /* ── Main Content ── */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .admin-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
        }

        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-header .user-info span {
            color: #666;
        }

        .admin-header .user-info .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .admin-header .user-info .logout-btn:hover {
            background: #c0392b;
        }

        /* ── Steps Bar ── */
        .steps-bar {
            display: flex;
            background: white;
            border-radius: 15px;
            padding: 0.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            gap: 0.3rem;
        }

        .step-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: none;
            background: transparent;
            color: #adb5bd;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s;
        }

        .step-btn .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #e9ecef;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #adb5bd;
        }

        .step-btn.active {
            background: linear-gradient(135deg, #E67E22, #d35400);
            color: white;
            box-shadow: 0 4px 15px rgba(230,126,34,0.35);
        }

        .step-btn.active .step-num {
            background: rgba(255,255,255,0.25);
            color: white;
        }

        .step-btn.done {
            color: #27ae60;
        }

        .step-btn.done .step-num {
            background: #d4edda;
            color: #27ae60;
        }

        .step-divider {
            width: 1px;
            background: #e9ecef;
            margin: 0.5rem 0;
        }

        /* ── Panels / Cards ── */
        .panel {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }

        .panel-title {
            font-size: 1rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .panel-title i { color: #E67E22; }

        /* ── Table (sama style dengan admin.php) ── */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        thead th {
            background: #2C3E50;
            color: white;
            padding: 0.9rem 1rem;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s;
        }

        tbody tr:hover { background: #fff8f0; }

        tbody tr.selected {
            background: #fff3e4;
            border-left: 3px solid #E67E22;
        }

        tbody td {
            padding: 0.9rem 1rem;
            color: #444;
            vertical-align: middle;
        }

        .radio-col { width: 40px; text-align: center; }

        .badge-nomor {
            background: rgba(230,126,34,0.12);
            color: #E67E22;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .selected-indicator { color: #27ae60; display: none; }
        tr.selected .selected-indicator { display: inline; }
        tr.selected .unselected-indicator { display: none; }

        /* ── Search (sama style dengan filter-bar admin.php) ── */
        .filter-bar {
            background: white;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .filter-bar .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            font-family: 'Montserrat', sans-serif;
        }

        .filter-bar .form-control:focus {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230,126,34,0.1);
        }

        /* ── Template Grid ── */
        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.2rem;
        }

        .template-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            background: #f8f9fa;
        }

        .template-card:hover {
            border-color: #E67E22;
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(230,126,34,0.15);
        }

        .template-card.selected {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230,126,34,0.2);
        }

        .template-card img {
            width: 100%;
            display: block;
            height: 170px;
            object-fit: cover;
        }

        .template-card-info {
            padding: 0.9rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
        }

        .template-card-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: #2C3E50;
        }

        .template-card-desc {
            font-size: 0.75rem;
            color: #888;
        }

        .template-check {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: #e9ecef;
            border: 2px solid #dee2e6;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 0.75rem;
            transition: all 0.25s;
        }

        .template-card.selected .template-check {
            background: #E67E22;
            border-color: #E67E22;
        }

        .template-label {
            position: absolute; top: 8px; left: 8px;
            background: rgba(44,62,80,0.85);
            color: white; font-size: 0.7rem; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
        }

        /* ── Selected info bar ── */
        .selected-bar {
            background: #fff8f0;
            border: 1px solid rgba(230,126,34,0.25);
            border-left: 4px solid #E67E22;
            border-radius: 10px;
            padding: 0.9rem 1.2rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .selected-bar .sel-name { font-weight: 700; color: #2C3E50; font-size: 0.92rem; }
        .selected-bar .sel-meta { color: #888; font-size: 0.8rem; }

        /* ── Preview area ── */
        #cert-preview-wrap {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 380px;
        }

        #cert-canvas-container {
            position: relative;
            display: inline-block;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 4px;
            overflow: hidden;
            container-type: inline-size;
            width: 100%;
            max-width: 660px;
        }

        #cert-template-img {
            display: block;
            width: 100%;
            height: auto;
        }

        #cert-text-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0 8%;
            pointer-events: none;
        }

        .cert-intro  { font-size: 1.8cqw; color: #374151; margin-bottom: 6px; font-family: 'Montserrat', sans-serif; }
        .cert-name   { font-size: 4.6cqw; font-weight: 800; color: #1e3a5f; margin-bottom: 4px; font-family: 'Montserrat', sans-serif; text-align: center; }
        .cert-nim    { font-size: 1.9cqw; color: #6b7280; margin-bottom: 14px; font-family: 'Montserrat', sans-serif; }
        .cert-desc   { font-size: 1.85cqw; color: #374151; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; }
        .cert-event  { font-size: 2.8cqw; font-weight: 700; color: #1f2937; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; text-align: center; }
        .cert-date   { font-size: 1.8cqw; color: #6b7280; margin-bottom: 14px; font-family: 'Montserrat', sans-serif; }
        .cert-nomor  { font-size: 1.6cqw; color: #9ca3af; letter-spacing: 1px; font-family: 'Montserrat', sans-serif; }

        /* ── Signature block (Dean of School) ── */
        #cert-signature-wrap {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            margin-top: 10px;
        }
        #cert-signature-wrap .sig-role {
            font-size: 1.8cqw;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #d35400;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        /* Ruang kosong buat tempel gambar tanda tangan (upload logo/ttd manual) */
        #cert-signature-wrap .sig-space {
            width: 220px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        #cert-signature-wrap .sig-space img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        #cert-signature-wrap .sig-name {
            font-size: 1.85cqw;
            font-weight: 700;
            color: #2C3E50;
            white-space: nowrap;
            margin-top: 2px;
        }
        #cert-signature-wrap .sig-nip {
            font-size: 1.5cqw;
            color: #6b7280;
            margin-top: 1px;
        }

        /* ── Buttons (sama style dengan admin.php) ── */
        .btn-orange {
            background: linear-gradient(135deg, #E67E22, #d35400);
            color: white; border: none;
            padding: 0.6rem 1.5rem; border-radius: 25px;
            font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-orange:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(230,126,34,0.4); }
        .btn-orange:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

        .btn-secondary-custom {
            background: #95a5a6; color: white; border: none;
            padding: 0.6rem 1.5rem; border-radius: 25px;
            font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-secondary-custom:hover { background: #7f8c8d; }

        .btn-green-custom {
            background: #27ae60; color: white; border: none;
            padding: 0.6rem 1.5rem; border-radius: 25px;
            font-family: 'Montserrat', sans-serif; font-size: 0.88rem; font-weight: 600;
            cursor: pointer; transition: all 0.3s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-green-custom:hover { background: #1e8449; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(39,174,96,0.35); }

        .btn-group-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1.2rem;
            flex-wrap: wrap;
            gap: 10px;
        }

        /* ── Info alert ── */
        .info-alert {
            background: #fff8f0;
            border: 1px solid rgba(230,126,34,0.3);
            border-radius: 10px;
            padding: 0.8rem 1.2rem;
            margin-bottom: 1.2rem;
            font-size: 0.85rem;
            color: #7f4c00;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .info-alert i { color: #E67E22; flex-shrink: 0; }

        /* ── Adjuster controls ── */
        .text-controls {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
            align-items: flex-end;
        }
        .text-controls label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #888;
            display: block;
            margin-bottom: 4px;
        }

        /* ── Step Panel animation ── */
        .step-panel { display: none; }
        .step-panel.active { display: block; animation: fadeIn .25s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        /* ── Loading overlay ── */
        #download-loading {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            align-items: center; justify-content: center;
            flex-direction: column; gap: 16px;
        }
        #download-loading.show { display: flex; }
        #download-loading p { color: white; font-size: 1rem; font-weight: 600; margin: 0; }
        .spinner-circle {
            width: 50px; height: 50px;
            border: 4px solid rgba(255,255,255,0.2);
            border-top-color: #E67E22;
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 768px) {
            .admin-sidebar { width: 0; display: none; }
            .admin-main { margin-left: 0; }
            .template-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>
<div class="admin-wrapper">

    <!-- Sidebar (sama persis dengan admin.php) -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <h3>Admin FIK</h3>
            <p>Manajemen Sertifikat</p>
        </div>

        <div class="sidebar-menu">
            <a href="<?= base_url('admin/proposal') ?>">
                <i class="fas fa-file-alt"></i>
                <span>Proposal</span>
            </a>
            <a href="<?= base_url('sertifikat/admin') ?>">
                <i class="fas fa-certificate"></i>
                <span>Sertifikat</span>
            </a>
            <a href="<?= base_url('sertifikat/generate') ?>" class="active" style="padding-left:2.5rem;font-size:0.85rem;">
                <i class="fas fa-magic"></i>
                <span>Generate Sertifikat</span>
            </a>
            <a href="<?= base_url('sertifikat/export_excel_canva') ?>" style="padding-left:2.5rem;font-size:0.85rem;">
                <i class="fas fa-file-excel"></i>
                <span>Export Excel Canva</span>
            </a>
            <a href="<?= base_url('berita/admin') ?>">
                <i class="fas fa-newspaper"></i>
                <span>Berita</span>
            </a>

            <div class="menu-divider"></div>

            <a href="<?= base_url('dashboard') ?>">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="admin-main">

        <!-- Header -->
        <div class="admin-header">
            <h1>Generate Sertifikat PDF</h1>
            <div class="user-info">
                <span><i class="fas fa-user-circle me-2" style="color:#E67E22;"></i><?= $this->session->userdata('nama') ?></span>
                <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>

        <!-- Steps Bar -->
        <div class="steps-bar">
            <button class="step-btn active" id="btn-step-1" onclick="goStep(1)">
                <span class="step-num">1</span> Pilih Data
            </button>
            <div class="step-divider"></div>
            <button class="step-btn" id="btn-step-2" onclick="if(selectedRow) goStep(2)">
                <span class="step-num">2</span> Pilih Template
            </button>
            <div class="step-divider"></div>
            <button class="step-btn" id="btn-step-3" onclick="if(selectedTemplate) goStep(3)">
                <span class="step-num">3</span> Preview & Download
            </button>
        </div>

        <!-- ─── STEP 1: Pilih Data ─── -->
        <div class="step-panel active" id="step-1">

            <!-- Filter / Search -->
            <div class="filter-bar">
                <div class="row g-2 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text" style="border-color:#e0e0e0;background:#fff;">
                                <i class="fas fa-search" style="color:#E67E22;"></i>
                            </span>
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="Cari nama mahasiswa, NIM, judul kegiatan, nomor sertifikat..."
                                oninput="filterTable()" style="border-left:none;">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <small class="text-muted">Total: <strong><?= count($sertifikat_list) ?></strong> sertifikat disetujui</small>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-title">
                    <i class="fas fa-list-check"></i> Data Sertifikat yang Sudah Disetujui
                </div>

                <div class="info-alert">
                    <i class="fas fa-info-circle"></i>
                    Klik salah satu baris data, lalu klik tombol <strong>Generate</strong> untuk lanjut ke pemilihan template.
                </div>

                <div class="table-container">
                    <table id="mainTable">
                        <thead>
                            <tr>
                                <th class="radio-col"></th>
                                <th>Nama Mahasiswa</th>
                                <th>NIM / Prodi</th>
                                <th>Judul Kegiatan</th>
                                <th>Tgl Kegiatan</th>
                                <th>Nomor Sertifikat</th>
                                <th>Disetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($sertifikat_list)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center;padding:40px;color:#aaa;">
                                    <i class="fas fa-inbox" style="font-size:2rem;display:block;margin-bottom:10px;opacity:.4;"></i>
                                    Belum ada sertifikat yang disetujui
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($sertifikat_list as $s): ?>
                            <tr onclick="selectRow(this, <?= htmlspecialchars(json_encode($s), ENT_QUOTES) ?>)">
                                <td class="radio-col">
                                    <i class="far fa-circle unselected-indicator" style="color:#dee2e6;"></i>
                                    <i class="fas fa-check-circle selected-indicator"></i>
                                </td>
                                <td><strong><?= htmlspecialchars($s['nama_mahasiswa']) ?></strong></td>
                                <td>
                                    <?= htmlspecialchars($s['nim'] ?? '-') ?>
                                    <br><small class="text-muted"><?= htmlspecialchars($s['prodi'] ?? '-') ?></small>
                                </td>
                                <td style="max-width:200px;">
                                    <?= htmlspecialchars(mb_strimwidth($s['judul_kegiatan'], 0, 55, '...')) ?>
                                    <br><small class="text-muted">PIC: <?= htmlspecialchars($s['nama_pic'] ?? '-') ?></small>
                                </td>
                                <td><?= date('d/m/Y', strtotime($s['tanggal_kegiatan'])) ?></td>
                                <td><span class="badge-nomor"><?= htmlspecialchars($s['nomor_sertifikat'] ?? '-') ?></span></td>
                                <td><?= date('d M Y', strtotime($s['approved_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="btn-group-actions">
                    <span id="sel-info" style="color:#aaa;font-size:.85rem;">
                        <i class="fas fa-hand-pointer me-1"></i> Belum ada yang dipilih
                    </span>
                    <button class="btn-orange" id="btn-next-1" onclick="goStep(2)" disabled>
                        <i class="fas fa-magic"></i> Generate Sertifikat
                    </button>
                </div>
            </div>
        </div>

        <!-- ─── STEP 2: Pilih Template ─── -->
        <div class="step-panel" id="step-2">
            <div class="panel">
                <div class="panel-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-palette text-warning me-2"></i>Pilih Template Sertifikat</span>

                    <!-- Tombol Import Template Sendiri -->
                    <div>
                        <input type="file" id="customTemplateInput" accept="image/png, image/jpeg, image/jpg" style="display:none;" onchange="handleCustomTemplateUpload(this)">
                        <button class="btn btn-sm btn-outline-secondary" id="btn-import-template" onclick="document.getElementById('customTemplateInput').click()" style="border-radius:20px; font-family:'Montserrat'; font-size:0.8rem; font-weight:600;">
                            <i class="fas fa-upload me-1" style="color:#E67E22;"></i> Import Template Sendiri
                        </button>
                    </div>
                </div>

                <div class="selected-bar" id="sel-data-bar"></div>

                <div class="template-grid" id="templateGridContainer">
                    <?php
                    $templates = [
                        ['id'=>1, 'name'=>'Steel Wave',  'desc'=>'Elegan biru abu modern'],
                        ['id'=>2, 'name'=>'Black Gold',  'desc'=>'Eksklusif hitam & emas'],
                        ['id'=>3, 'name'=>'Blue Bubble', 'desc'=>'Segar biru dinamis'],
                        ['id'=>4, 'name'=>'Navy Grid',   'desc'=>'Profesional navy modern'],
                        ['id'=>5, 'name'=>'Royal Blue',  'desc'=>'Formal biru royal & emas'],
                    ];
                    foreach ($templates as $t): ?>
                    <div class="template-card" id="tpl-card-<?= $t['id'] ?>"
                         onclick="selectTemplate(<?= $t['id'] ?>, '<?= $t['name'] ?>', false)">
                        <span class="template-label">Template <?= $t['id'] ?></span>
                        <img src="<?= base_url('templates/sertifikat/template'.$t['id'].'.png') ?>"
                             alt="<?= $t['name'] ?>" loading="lazy">
                        <div class="template-card-info">
                            <div>
                                <div class="template-card-name"><?= $t['name'] ?></div>
                                <div class="template-card-desc"><?= $t['desc'] ?></div>
                            </div>
                            <div class="template-check"><i class="fas fa-check"></i></div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php
                    // Template custom yang sudah pernah diupload sebelumnya (tersimpan permanen di server)
                    // $custom_templates dikirim dari controller, berisi array ['id'=>..., 'name'=>..., 'file'=>...]
                    if (!empty($custom_templates)):
                        foreach ($custom_templates as $ct): ?>
                    <div class="template-card" id="tpl-card-custom-<?= $ct['id'] ?>"
                         onclick="selectTemplate('custom-<?= $ct['id'] ?>', '<?= htmlspecialchars($ct['name']) ?>', true, '<?= base_url('templates/sertifikat/custom/'.$ct['file']) ?>')">
                        <span class="template-label" style="background:#27ae60;">Custom Upload</span>
                        <img src="<?= base_url('templates/sertifikat/custom/'.$ct['file']) ?>"
                             alt="<?= htmlspecialchars($ct['name']) ?>" loading="lazy">
                        <div class="template-card-info">
                            <div>
                                <div class="template-card-name"><?= htmlspecialchars($ct['name']) ?></div>
                                <div class="template-card-desc">Template yang diunggah</div>
                            </div>
                            <div class="template-check"><i class="fas fa-check"></i></div>
                        </div>
                    </div>
                    <?php endforeach; endif; ?>
                </div>

                <div class="btn-group-actions">
                    <button class="btn-secondary-custom" onclick="goStep(1)">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button class="btn-orange" id="btn-next-2" onclick="goStep(3)" disabled>
                        <i class="fas fa-eye"></i> Lihat Preview
                    </button>
                </div>
            </div>
        </div>

        <!-- ─── STEP 3: Preview & Download ─── -->
        <div class="step-panel" id="step-3">
            <div class="panel">
                <div class="panel-title"><i class="fas fa-eye"></i> Preview Sertifikat</div>

                <div class="selected-bar" id="sel-data-bar-3"></div>

                <!-- Preview -->
                <div id="cert-preview-wrap">
                    <div id="cert-canvas-container" style="position:relative;display:inline-block;">
                        <img id="cert-template-img" src="" alt="Template">
                        <div id="cert-text-overlay">
                            <!-- Judul CERTIFICATE di atas -->
                            <div class="cert-title-main" style="font-size: 5cqw; font-weight: 800; color: #d35400; letter-spacing: 2px; margin-bottom: 2px; text-transform: uppercase;">Certificate</div>

                            <!-- Nomor Sertifikat di bawah judul -->
                            <div class="cert-nomor" id="prev-nomor" style="font-size: 1.6cqw; font-weight: 700; color: #2C3E50; letter-spacing: 1px; margin-bottom: 12px; text-transform: uppercase;">Certificate Number: 020/S-AKD05/IK-DEK/2026</div>

                            <!-- Kalimat pembuka / partisipasi -->
                            <div class="cert-intro" style="font-size: 1.75cqw; font-style: italic; color: #7f8c8d; margin-bottom: 6px;">THIS CERTIFICATE IS PRESENT TO</div>

                            <!-- Nama Penerima besar dengan garis bawah -->
                            <div class="cert-name-container" style="border-bottom: 2px solid #E67E22; padding-bottom: 4px; margin-bottom: 12px; min-width: 280px; text-align: center;">
                                <div class="cert-name" id="prev-nama" style="font-size: 4cqw; font-weight: 800; color: #2C3E50; font-family: 'Montserrat', sans-serif;">TEGUH AKBAR, ST</div>
                            </div>

                            <!-- Keterangan Partisipasi & Kegiatan -->
                            <div class="cert-desc" id="prev-desc" style="font-size: 1.75cqw; color: #7f8c8d; margin-bottom: 6px;">For the Participation as <strong style="color: #d35400;" id="prev-role">Committee</strong> at :</div>
                            <div class="cert-event" id="prev-judul" style="font-size: 2.6cqw; font-weight: 700; color: #2C3E50; text-transform: uppercase; margin-bottom: 6px; text-align: center;">BERWARA ADVERTISING EXHIBITION & AWARD</div>

                            <!-- Waktu & Tempat -->
                            <div class="cert-date" id="prev-tanggal" style="font-size: 1.6cqw; color: #7f8c8d; text-transform: uppercase; font-weight: 600; margin-bottom: 8px;">HELD AT SCHOOL OF CREATIVE INDUSTRIES</div>

                            <!-- Tanda tangan Dean of School, di tengah, di bawah tanggal -->
                            <div id="cert-signature-wrap">
                                <div class="sig-role" id="sig-role">Dean of School</div>
                                <div class="sig-space" id="sig-space">
                                    <img id="sig-image" src="" alt="Tanda tangan" style="display:none;">
                                </div>
                                <div class="sig-name" id="sig-nama">Dandi Yunidar, S.Sn., M.Ds., Ph.D.</div>
                                <div class="sig-nip" id="sig-nip">NIP: 14760039</div>
                            </div>
                        </div>
                        <!-- QR Code di pojok kiri bawah (sesuai layout gambar) -->
                        <div id="cert-qr-wrap" style="
                            position:absolute; bottom:5%; left:4%;
                            background:white; padding:6px; border-radius:6px;
                            box-shadow:0 3px 12px rgba(0,0,0,0.12);
                            display:flex; flex-direction:column; align-items:center; gap:2px;
                            border: 1px solid #ddd;
                        ">
                            <canvas id="cert-qr-canvas"></canvas>
                            <span id="cert-qr-label" style="font-size:4.5px;color:#7f8c8d;font-family:monospace;max-width:70px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:700;">verify</span>
                        </div>
                    </div>
                </div>

                <!-- Text controls -->
                <div class="text-controls">
                    <div>
                        <label>Posisi Teks (Atas ↕ Bawah)</label>
                        <input type="range" id="posY" min="15" max="85" value="50" style="width:180px;" oninput="adjustText()">
                        <span style="color:#888;font-size:.8rem;" id="posY-val">50%</span>
                    </div>
                    <div>
                        <label>Warna Nama</label>
                        <input type="color" id="nameColor" value="#1e3a5f" oninput="adjustText()">
                    </div>
                    <div>
                        <label>Warna Teks Isi</label>
                        <input type="color" id="textColor" value="#374151" oninput="adjustText()">
                    </div>
                    <div>
                        <label>Jabatan Penandatangan</label>
                        <input type="text" id="deanRole" value="Dean of School" style="border:1px solid #e0e0e0;border-radius:8px;padding:6px 10px;font-size:0.8rem;font-family:'Montserrat';width:200px;" oninput="updateSignature()">
                    </div>
                    <div>
                        <label>Nama Dean / Penandatangan</label>
                        <input type="text" id="deanName" value="Dandi Yunidar, S.Sn., M.Ds., Ph.D." style="border:1px solid #e0e0e0;border-radius:8px;padding:6px 10px;font-size:0.8rem;font-family:'Montserrat';width:230px;" oninput="updateSignature()">
                    </div>
                    <div>
                        <label>NIP</label>
                        <input type="text" id="deanNip" value="14760039" style="border:1px solid #e0e0e0;border-radius:8px;padding:6px 10px;font-size:0.8rem;font-family:'Montserrat';width:140px;" oninput="updateSignature()">
                    </div>
                    <div>
                        <label>Gambar Tanda Tangan (opsional)</label>
                        <input type="file" id="sigImageInput" accept="image/png, image/jpeg" style="font-size:0.78rem;" onchange="handleSignatureImageUpload(this)">
                    </div>
                </div>

                <div class="btn-group-actions">
                    <button class="btn-secondary-custom" onclick="goStep(2)">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <div style="display:flex;gap:10px;">
                        <button class="btn-orange" onclick="downloadPDF()">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                        <button class="btn-green-custom" onclick="downloadPNG()">
                            <i class="fas fa-image"></i> Download PNG
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /admin-main -->
</div><!-- /admin-wrapper -->

<!-- Loading overlay -->
<div id="download-loading">
    <div class="spinner-circle"></div>
    <p id="loading-text">Sedang membuat file, harap tunggu...</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const BASE_URL = '<?= base_url() ?>';
    let selectedRow      = null;
    let selectedTemplate = null;   // id template (angka, atau 'custom-<id>')
    let selectedTemplateUrl = null; // url gambar template yang sedang dipakai (kalau custom)

    /* ── Step navigation ── */
    function goStep(n) {
        if (n === 2 && !selectedRow)      { alert('Pilih data sertifikat terlebih dahulu!'); return; }
        if (n === 3 && !selectedTemplate) { alert('Pilih template terlebih dahulu!'); return; }

        document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('step-' + n).classList.add('active');

        [1,2,3].forEach(i => {
            const btn = document.getElementById('btn-step-' + i);
            btn.classList.remove('active','done');
            if (i < n) btn.classList.add('done');
            if (i === n) btn.classList.add('active');
        });

        if (n === 2) renderSelBar();
        if (n === 3) renderPreview();
    }

    /* ── Pilih baris ── */
    function selectRow(tr, data) {
        document.querySelectorAll('#mainTable tbody tr').forEach(r => r.classList.remove('selected'));
        tr.classList.add('selected');
        selectedRow = data;
        document.getElementById('sel-info').innerHTML =
            `<i class="fas fa-check-circle" style="color:#27ae60;margin-right:6px;"></i>
             Dipilih: <strong>${data.nama_mahasiswa}</strong> — ${data.judul_kegiatan.substring(0,45)}...`;
        document.getElementById('btn-next-1').disabled = false;
    }

    /* ── Pilih template ──
       id            : id template (angka untuk bawaan, 'custom-<id>' untuk hasil upload)
       name          : nama template
       isCustom      : true kalau ini template hasil upload
       customUrl     : url gambar template di server (khusus custom)
    */
    function selectTemplate(id, name, isCustom, customUrl) {
        document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
        const cardId = isCustom ? ('tpl-card-' + id) : ('tpl-card-' + id);
        const card = document.getElementById(cardId);
        if (card) card.classList.add('selected');

        selectedTemplate    = id;
        selectedTemplateUrl = isCustom ? customUrl : (BASE_URL + 'templates/sertifikat/template' + id + '.png');
        document.getElementById('btn-next-2').disabled = false;
    }

    /* ── Handle Custom Template Upload ──
       File langsung diupload ke server (endpoint: sertifikat/upload_template) supaya
       benar-benar tersimpan permanen dan tidak hilang saat pindah step / reload halaman.
       Lihat catatan controller di bagian bawah chat.
    */
    function handleCustomTemplateUpload(input) {
        const file = input.files[0];
        if (!file) return;

        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (PNG/JPG)!');
            return;
        }

        const btn = document.getElementById('btn-import-template');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mengunggah...';

        const formData = new FormData();
        formData.append('template_file', file);
        formData.append('template_name', file.name.replace(/\.[^/.]+$/, ''));

        fetch(BASE_URL + 'sertifikat/upload_template', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            if (!resp.success) {
                throw new Error(resp.message || 'Upload gagal');
            }

            // resp harus berisi: { success: true, id: <id_baru>, name: <nama>, url: <url_gambar_di_server> }
            const container = document.getElementById('templateGridContainer');
            const cardHtml = `
                <div class="template-card selected" id="tpl-card-custom-${resp.id}"
                     onclick="selectTemplate('custom-${resp.id}', '${resp.name}', true, '${resp.url}')">
                    <span class="template-label" style="background:#27ae60;">Custom Upload</span>
                    <img src="${resp.url}" alt="${resp.name}">
                    <div class="template-card-info">
                        <div>
                            <div class="template-card-name">${resp.name}</div>
                            <div class="template-card-desc">Template yang diunggah</div>
                        </div>
                        <div class="template-check"><i class="fas fa-check"></i></div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('afterbegin', cardHtml);

            selectTemplate('custom-' + resp.id, resp.name, true, resp.url);
        })
        .catch(err => {
            alert('Gagal mengunggah template: ' + err.message);
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
            input.value = ''; // reset input supaya bisa upload file yang sama lagi kalau perlu
        });
    }

    /* ── Render info bar ── */
    function renderSelBar() {
        const d = selectedRow;
        const html = `
            <div>
                <div class="sel-name">${d.nama_mahasiswa}</div>
                <div class="sel-meta">${d.nim ?? '-'} · ${d.prodi ?? '-'} · ${d.judul_kegiatan.substring(0,55)}</div>
            </div>
            <span class="badge-nomor">${d.nomor_sertifikat ?? '-'}</span>`;
        document.querySelectorAll('#sel-data-bar, #sel-data-bar-3').forEach(el => el.innerHTML = html);
    }

    /* ── Render preview ── */
    function renderPreview() {
        renderSelBar();
        const img = document.getElementById('cert-template-img');
        img.onload = function() { renderQR(); };

        img.src = selectedTemplateUrl;
        if (img.complete) renderQR();

        const d = selectedRow;
        document.getElementById('prev-nama').textContent  = d.nama_mahasiswa;
        document.getElementById('prev-judul').textContent = d.judul_kegiatan;

        // ── Tanggal kegiatan: tampilkan APA ADANYA sesuai data, tidak menerka/menambah rentang tanggal.
        // Kalau di data ada tanggal_kegiatan_selesai (rentang beberapa hari), baru ditampilkan sebagai range.
        // Kalau tidak ada, tampilkan tanggal tunggal.
        const months = ['January','February','March','April','May','June','July',
                        'August','September','October','November','December'];

        function formatSingleDate(dateStr) {
            const dt = new Date(dateStr);
            return `${months[dt.getMonth()].toUpperCase()} ${dt.getDate()}, ${dt.getFullYear()}`;
        }

        let tanggalStr = '';
        if (d.tanggal_kegiatan) {
            if (d.tanggal_kegiatan_selesai && d.tanggal_kegiatan_selesai !== d.tanggal_kegiatan) {
                // ada rentang tanggal beneran dari database
                const start = new Date(d.tanggal_kegiatan);
                const end   = new Date(d.tanggal_kegiatan_selesai);
                if (start.getMonth() === end.getMonth() && start.getFullYear() === end.getFullYear()) {
                    tanggalStr = `FROM ${months[start.getMonth()].toUpperCase()} ${start.getDate()} – ${end.getDate()}, ${end.getFullYear()}`;
                } else {
                    tanggalStr = `FROM ${formatSingleDate(d.tanggal_kegiatan)} TO ${formatSingleDate(d.tanggal_kegiatan_selesai)}`;
                }
            } else {
                // hanya satu tanggal → tampilkan sebagai tanggal tunggal, bukan rentang
                tanggalStr = `ON ${formatSingleDate(d.tanggal_kegiatan)}`;
            }
        }

        const lokasi = d.lokasi_kegiatan ? d.lokasi_kegiatan.toUpperCase() : 'SCHOOL OF CREATIVE INDUSTRIES';
        document.getElementById('prev-tanggal').textContent =
            tanggalStr ? `HELD AT ${lokasi} ${tanggalStr}` : `HELD AT ${lokasi}`;

        document.getElementById('prev-nomor').textContent = 'CERTIFICATE NUMBER: ' + (d.nomor_sertifikat ?? '-');

        // Isi deskripsi sesuai role / prodi (Committee/Participant/Presenter)
        const role = d.prodi ? d.prodi : 'Committee';
        const roleCapitalized = role.charAt(0).toUpperCase() + role.slice(1);
        document.getElementById('prev-desc').innerHTML = `For the Participation as <strong style="color: #d35400;" id="prev-role">${roleCapitalized}</strong> at :`;

        // Isi tanda tangan Dean of School (ambil dari field input, atau default dari data kalau ada)
        updateSignature();

        adjustText();
    }

    /* ── Render QR Code di pojok kiri bawah sertifikat ── */
    function renderQR() {
        const d = selectedRow;
        const qrUrl = d.qr_code
            ? d.qr_code
            : BASE_URL + 'sertifikat/verifikasi/' + encodeURIComponent(d.nomor_sertifikat ?? '');

        document.getElementById('cert-qr-label').textContent = d.nomor_sertifikat ?? 'verify';

        const img  = document.getElementById('cert-template-img');
        const size = Math.max(70, Math.round(img.clientWidth * 0.10));

        const canvas = document.getElementById('cert-qr-canvas');
        QRCode.toCanvas(canvas, qrUrl, {
            width:  size,
            margin: 1,
            color: { dark: '#000000', light: '#ffffff' }
        }, function(err) {
            if (err) console.error('QR render error:', err);
        });
    }

    /* ── Update tanda tangan Dean of School (jabatan + nama + NIP) ── */
    function updateSignature() {
        const role = document.getElementById('deanRole').value || 'Dean of School';
        const nama = document.getElementById('deanName').value || 'Dandi Yunidar, S.Sn., M.Ds., Ph.D.';
        const nip  = document.getElementById('deanNip').value || '14760039';
        document.getElementById('sig-role').textContent = role;
        document.getElementById('sig-nama').textContent = nama;
        document.getElementById('sig-nip').textContent  = 'NIP: ' + nip;
    }

    /* ── Upload gambar tanda tangan (ditampilkan langsung di ruang kosong tanda tangan) ── */
    function handleSignatureImageUpload(input) {
        const file = input.files[0];
        if (!file) return;

        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar (PNG/JPG)!');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('sig-image');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }

    /* ── Adjust teks posisi & warna ── */
    function adjustText() {
        const posY = parseInt(document.getElementById('posY').value);
        document.getElementById('posY-val').textContent = posY + '%';

        const overlay = document.getElementById('cert-text-overlay');
        overlay.style.justifyContent = posY < 38 ? 'flex-start'
                                     : posY > 62 ? 'flex-end' : 'center';
        overlay.style.paddingTop    = posY < 38 ? posY + '%' : '0';
        overlay.style.paddingBottom = posY > 62 ? (100 - posY) + '%' : '0';

        const nc = document.getElementById('nameColor').value;
        const tc = document.getElementById('textColor').value;
        document.getElementById('prev-nama').style.color  = nc;
        document.getElementById('prev-judul').style.color = nc;
        document.querySelectorAll('.cert-intro, .cert-desc, .cert-date, .cert-nomor')
            .forEach(el => el.style.color = tc);
    }

    /* ── Filter tabel ── */
    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#mainTable tbody tr').forEach(tr => {
            tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    }

    /* ── Download PDF ── */
    async function downloadPDF() {
        const loading = document.getElementById('download-loading');
        document.getElementById('loading-text').textContent = 'Sedang membuat PDF, harap tunggu...';
        loading.classList.add('show');
        try {
            const canvas = await html2canvas(document.getElementById('cert-canvas-container'), {
                scale: 3, useCORS: true, allowTaint: true, backgroundColor: '#fff', logging: false
            });
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
            pdf.addImage(canvas.toDataURL('image/jpeg', 0.97), 'JPEG', 0, 0,
                pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
            pdf.save('Sertifikat_' + selectedRow.nama_mahasiswa.replace(/\s+/g,'_') +
                     '_' + (selectedRow.nomor_sertifikat ?? '').replace(/\//g,'-') + '.pdf');
        } catch(e) {
            alert('Gagal membuat PDF: ' + e.message);
        } finally {
            loading.classList.remove('show');
        }
    }

    /* ── Download PNG ── */
    async function downloadPNG() {
        const loading = document.getElementById('download-loading');
        document.getElementById('loading-text').textContent = 'Sedang membuat gambar...';
        loading.classList.add('show');
        try {
            const canvas = await html2canvas(document.getElementById('cert-canvas-container'), {
                scale: 3, useCORS: true, allowTaint: true, backgroundColor: '#fff', logging: false
            });
            const a = document.createElement('a');
            a.download = 'Sertifikat_' + selectedRow.nama_mahasiswa.replace(/\s+/g,'_') + '.png';
            a.href = canvas.toDataURL('image/png');
            a.click();
        } catch(e) {
            alert('Gagal: ' + e.message);
        } finally {
            loading.classList.remove('show');
        }
    }
</script>
</body>
</html>
