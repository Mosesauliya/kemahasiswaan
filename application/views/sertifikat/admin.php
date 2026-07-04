<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Admin Sertifikat</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- QR Code Generator -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

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

        /* Main Content */
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
            font-size: 2rem;
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

        /* Filter Bar */
        .filter-bar {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .filter-bar .form-control,
        .filter-bar .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .filter-bar .form-control:focus,
        .filter-bar .form-select:focus {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }

        .filter-bar .btn-filter {
            background: #E67E22;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-bar .btn-filter:hover {
            background: #d35400;
            transform: translateY(-2px);
        }

        .filter-bar .btn-reset {
            background: #95a5a6;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-bar .btn-reset:hover {
            background: #7f8c8d;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-bottom-color: #E67E22;
            box-shadow: 0 10px 30px rgba(230, 126, 34, 0.15);
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(230, 126, 34, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card .stat-icon i {
            font-size: 1.8rem;
            color: #E67E22;
        }

        .stat-card .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2C3E50;
        }

        .stat-card .stat-detail {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.5rem;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .table-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 1.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            border-top: none;
            color: #666;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        /* Status Badges */
        .badge-status {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-submitted {
            background: #fff3cd;
            color: #856404;
        }

        .badge-approved {
            background: #d4edda;
            color: #155724;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-view {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .btn-view:hover {
            background: #3498db;
            color: white;
        }

        .btn-approve {
            background: rgba(22, 163, 74, 0.1);
            color: #16a34a;
        }

        .btn-approve:hover {
            background: #16a34a;
            color: white;
        }

        .btn-reject {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }

        .btn-reject:hover {
            background: #dc2626;
            color: white;
        }

        .btn-pdf {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }

        .btn-pdf:hover {
            background: #dc2626;
            color: white;
        }

        .btn-view-pdf {
            background: rgba(230, 126, 34, 0.1);
            color: #E67E22;
        }

        .btn-view-pdf:hover {
            background: #E67E22;
            color: white;
        }

        /* Empty State */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            color: #E67E22;
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        /* Modal */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-header-approve {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .modal-header-reject {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #eee;
        }

        .alert-info {
            background: rgba(230, 126, 34, 0.1);
            border-left: 4px solid #E67E22;
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .text-danger {
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                width: 0;
                display: none;
            }
            
            .admin-main {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-bar .row {
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
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
                <a href="<?= base_url('sertifikat/admin') ?>" class="active">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>
                <a href="<?= base_url('sertifikat/generate') ?>" style="padding-left:2.5rem;font-size:0.85rem;">
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
            <div class="admin-header">
                <h1>Manajemen Pengajuan Sertifikat</h1>
                <div class="user-info">
                    <a href="<?= base_url('sertifikat/export_excel_canva') ?>" class="btn" style="background:#27ae60;color:white;padding:0.5rem 1.2rem;border-radius:25px;text-decoration:none;font-weight:600;font-size:0.85rem;transition:all 0.3s;" title="Export semua data approved ke Excel format Canva">
                        <i class="fas fa-file-excel me-2"></i>Export Excel Canva
                    </a>
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if(isset($flash_success) && $flash_success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $flash_success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if(isset($flash_error) && $flash_error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $flash_error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-label">Total Pengajuan</div>
                    <div class="stat-value"><?= number_format($stats['total'] ?? 0) ?></div>
                    <div class="stat-detail">Semua pengajuan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-label">Menunggu Review</div>
                    <div class="stat-value"><?= number_format($stats['submitted'] ?? 0) ?></div>
                    <div class="stat-detail">
                        <span class="text-warning">Perlu ditindaklanjuti</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Disetujui</div>
                    <div class="stat-value"><?= number_format($stats['approved'] ?? 0) ?></div>
                    <div class="stat-detail">
                        <span class="text-success">Sertifikat diterbitkan</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value"><?= number_format($stats['rejected'] ?? 0) ?></div>
                    <div class="stat-detail">
                        <span class="text-danger">Perlu perbaikan</span>
                    </div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <form method="get" action="">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="q" placeholder="Cari NIM, nama, judul kegiatan..." value="<?= htmlspecialchars($search ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="submitted" <?= ($status_filter ?? '') == 'submitted' ? 'selected' : '' ?>>Menunggu Review</option>
                                <option value="approved" <?= ($status_filter ?? '') == 'approved' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="rejected" <?= ($status_filter ?? '') == 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn-filter">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="<?= base_url('sertifikat/admin') ?>" class="btn-reset ms-2">
                                <i class="fas fa-times me-2"></i>Reset
                            </a>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="text-muted"><?= count($pengajuan_list) ?> data ditemukan</span>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-card">
                <h3><i class="fas fa-list me-2" style="color: #E67E22;"></i>Daftar Pengajuan Sertifikat</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Mahasiswa</th>
                                <th>Judul Kegiatan</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Nomor Sertifikat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pengajuan_list)): ?>
                                <?php foreach ($pengajuan_list as $p): ?>
                                <tr>
                                    <td>
                                        <code style="font-size:0.8rem;"><?= htmlspecialchars($p['kode_pengajuan'] ?? '-') ?></code>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($p['nama_mahasiswa'] ?? '-') ?></strong>
                                        <br>
                                        <small class="text-muted"><?= htmlspecialchars($p['nim'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars(mb_strimwidth($p['judul_kegiatan'] ?? '-', 0, 40, '...')) ?></strong>
                                        <br>
                                        <small class="text-muted">PIC: <?= htmlspecialchars($p['nama_pic'] ?? '-') ?></small>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($p['tanggal_kegiatan'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($p['submitted_at'])) ?></td>
                                    <td>
                                        <?php if ($p['status'] == 'submitted'): ?>
                                            <span class="badge-status badge-submitted">Menunggu</span>
                                        <?php elseif ($p['status'] == 'approved'): ?>
                                            <span class="badge-status badge-approved">Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-rejected">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($p['nomor_sertifikat'])): ?>
                                            <small class="text-muted"><?= htmlspecialchars($p['nomor_sertifikat']) ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">-</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <!-- Detail -->
                                            <button class="btn-action btn-view" title="Detail" onclick="showDetail(<?= $p['id'] ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <?php if ($p['status'] == 'submitted'): ?>
                                                <!-- Setujui -->
                                                <button class="btn-action btn-approve" title="Setujui" onclick="openApprove(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['judul_kegiatan'])) ?>')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <!-- Tolak -->
                                                <button class="btn-action btn-reject" title="Tolak" onclick="openReject(<?= $p['id'] ?>, '<?= htmlspecialchars(addslashes($p['judul_kegiatan'])) ?>')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($p['status'] == 'approved' && !empty($p['file_sertifikat'])): ?>
                                                <!-- Lihat PDF -->
                                                <a href="<?= base_url($p['file_sertifikat']) ?>" target="_blank" class="btn-action btn-view-pdf" title="Lihat Sertifikat">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($p['status'] == 'approved' && !empty($p['qr_code'])): ?>
                                                <!-- Lihat QR -->
                                                <button class="btn-action btn-show-qr" title="Lihat QR Code" style="background:#6366f1;color:white;"
													data-qr="<?= htmlspecialchars($p['qr_code'], ENT_QUOTES) ?>"
													data-nomor="<?= htmlspecialchars($p['nomor_sertifikat'], ENT_QUOTES) ?>">
													<i class="fas fa-qrcode"></i>
												</button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <i class="fas fa-certificate"></i>
                                            <p>Belum ada pengajuan sertifikat</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-certificate me-2"></i>Detail Pengajuan Sertifikat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-warning" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Approve -->
    <div class="modal fade" id="modalApprove" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-approve">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda akan menyetujui pengajuan sertifikat untuk kegiatan <strong id="approveJudul"></strong>.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Sertifikat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nomorSertifikat" placeholder="Contoh: SERT/FIK/2026/001">
                        <div class="text-danger" id="nomorError" style="display: none;">Nomor sertifikat wajib diisi</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">QR Code / Link Verifikasi (Opsional)</label>
                        <input type="text" class="form-control" id="qrCode" placeholder="Kosongkan untuk generate otomatis" oninput="updateQrPreview()">
                        <small class="text-muted">Jika dikosongkan, QR akan di-generate otomatis dari nomor sertifikat</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Preview QR Code</label>
                        <div style="background:#f8f9fa;border-radius:12px;padding:16px;text-align:center;">
                            <canvas id="qrCanvas" style="border-radius:8px;"></canvas>
                            <p class="text-muted mt-2" style="font-size:0.8rem;" id="qrInfo">Isi nomor sertifikat untuk generate QR</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatanApprove" rows="3" placeholder="Tambahkan catatan untuk mahasiswa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="submitApprove()">
                        <i class="fas fa-check me-2"></i>Setujui
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" id="modalReject" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-reject">
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-info" style="background:#fee2e2; border-left-color:#dc2626;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Anda akan menolak pengajuan sertifikat untuk kegiatan <strong id="rejectJudul"></strong>.
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="catatanReject" rows="4" placeholder="Tuliskan alasan penolakan..."></textarea>
                        <div class="text-danger" id="rejectError" style="display: none;">Alasan penolakan wajib diisi</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="submitReject()">
                        <i class="fas fa-times me-2"></i>Tolak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal QR Code Viewer -->
    <div class="modal fade" id="modalQR" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content" style="border-radius:20px;overflow:hidden;">
                <div class="modal-header" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:white;border:none;">
                    <h5 class="modal-title"><i class="fas fa-qrcode me-2"></i>QR Code Sertifikat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p class="text-muted mb-2" style="font-size:0.8rem;">Nomor Sertifikat</p>
                    <p id="qrModalNomor" class="fw-bold text-dark mb-3" style="font-size:0.9rem;"></p>
                    <div style="background:#f8f9fa;border-radius:16px;padding:20px;display:inline-block;">
                        <canvas id="qrModalCanvas"></canvas>
                    </div>
                    <p class="text-muted mt-3 mb-0" style="font-size:0.75rem;" id="qrModalLink"></p>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button class="btn btn-sm" style="background:#6366f1;color:white;border-radius:20px;padding:8px 24px;" onclick="downloadQR()">
                        <i class="fas fa-download me-2"></i>Download QR
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" style="border-radius:20px;padding:8px 24px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let currentId = null;

        // Show Detail Modal
        function showDetail(id) {
            const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
            document.getElementById('detailBody').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            modal.show();

            fetch('<?= base_url("sertifikat/get_detail_json/") ?>' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const p = data.pengajuan;
                        const log = data.log || [];
                        
                        let logHtml = '';
                        log.forEach(l => {
                            const statusClass = l.status_baru === 'approved' ? 'text-success' : (l.status_baru === 'rejected' ? 'text-danger' : 'text-warning');
                            const statusText = l.status_baru === 'approved' ? 'Disetujui' : (l.status_baru === 'rejected' ? 'Ditolak' : 'Menunggu');
                            logHtml += `
                                <div class="d-flex gap-3 mb-2">
                                    <div style="width:80px; font-size:0.8rem;">${l.changed_at}</div>
                                    <div><span class="${statusClass} fw-bold">${statusText}</span></div>
                                    <div class="text-muted">${l.catatan || '-'}</div>
                                </div>
                            `;
                        });

                        document.getElementById('detailBody').innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Kode</th>
                                            <td><code>${p.kode_pengajuan || '-'}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Mahasiswa</th>
                                            <td>${p.nama_mahasiswa || '-'}<br><small class="text-muted">${p.nim || '-'}</small></td>
                                        </tr>
                                        <tr>
                                            <th>Prodi</th>
                                            <td>${p.prodi || '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>PIC</th>
                                            <td>${p.nama_pic || '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Judul Kegiatan</th>
                                            <td>${p.judul_kegiatan || '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Kegiatan</th>
                                            <td>${p.tanggal_kegiatan ? new Date(p.tanggal_kegiatan).toLocaleDateString('id-ID') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td>${p.lokasi_kegiatan || '-'}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th width="40%">Status</th>
                                            <td>
                                                ${p.status == 'submitted' ? '<span class="badge-status badge-submitted">Menunggu</span>' : 
                                                  p.status == 'approved' ? '<span class="badge-status badge-approved">Disetujui</span>' : 
                                                  '<span class="badge-status badge-rejected">Ditolak</span>'}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Sertifikat</th>
                                            <td><strong class="text-warning">${p.nomor_sertifikat || '-'}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>QR Code</th>
                                            <td>${p.qr_code || '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Pengajuan</th>
                                            <td>${p.submitted_at ? new Date(p.submitted_at).toLocaleString('id-ID') : '-'}</td>
                                        </tr>
                                        ${p.approved_at ? `<tr><th>Tanggal Disetujui</th><td>${new Date(p.approved_at).toLocaleString('id-ID')}</td></tr>` : ''}
                                        ${p.rejected_at ? `<tr><th>Tanggal Ditolak</th><td>${new Date(p.rejected_at).toLocaleString('id-ID')}</td></tr>` : ''}
                                        <tr>
                                            <th>File Sertifikat</th>
                                            <td>
                                                ${p.file_sertifikat ? 
                                                    `<a href="<?= base_url() ?>${p.file_sertifikat}" target="_blank" class="btn-action btn-view-pdf" style="width:auto; padding:0.3rem 1rem;">
                                                        <i class="fas fa-file-pdf me-1"></i>Lihat
                                                    </a>` : '-'}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>File Penerima</th>
                                            <td>
                                                ${p.file_penerima ? 
                                                    `<a href="<?= base_url() ?>${p.file_penerima}" target="_blank" class="btn-action btn-view" style="width:auto; padding:0.3rem 1rem;">
                                                        <i class="fas fa-file-excel me-1"></i>Lihat
                                                    </a>` : '-'}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            ${p.catatan_tambahan ? `
                            <div class="mt-3 p-3" style="background:#f8f9fa; border-radius:10px;">
                                <strong>Catatan Mahasiswa:</strong><br>
                                ${p.catatan_tambahan}
                            </div>` : ''}
                            ${p.catatan_admin ? `
                            <div class="mt-3 p-3" style="background:#fff3e0; border-radius:10px;">
                                <strong>Catatan Admin:</strong><br>
                                ${p.catatan_admin}
                            </div>` : ''}
                            <div class="mt-3">
                                <h6 class="fw-bold">Riwayat Status</h6>
                                <div style="max-height:200px; overflow-y:auto; background:#f8f9fa; padding:1rem; border-radius:10px;">
                                    ${logHtml || '<p class="text-muted">Belum ada riwayat</p>'}
                                </div>
                            </div>
                        `;
                    } else {
                        document.getElementById('detailBody').innerHTML = '<p class="text-danger">Gagal memuat data</p>';
                    }
                })
                .catch(error => {
                    document.getElementById('detailBody').innerHTML = '<p class="text-danger">Terjadi kesalahan</p>';
                });
        }

        // Open Approve Modal
        function openApprove(id, judul) {
            currentId = id;
            document.getElementById('approveJudul').textContent = judul;
            document.getElementById('nomorSertifikat').value = '';
            document.getElementById('qrCode').value = '';
            document.getElementById('catatanApprove').value = '';
            document.getElementById('nomorError').style.display = 'none';

            // Reset QR canvas
            const canvas = document.getElementById('qrCanvas');
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById('qrInfo').textContent = 'Isi nomor sertifikat untuk generate QR';

            new bootstrap.Modal(document.getElementById('modalApprove')).show();
        }

        // Update QR when nomor sertifikat changes
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nomorSertifikat').addEventListener('input', updateQrPreview);
        });

        // Generate QR Code preview
        function updateQrPreview() {
            const nomor = document.getElementById('nomorSertifikat').value.trim();
            const customLink = document.getElementById('qrCode').value.trim();
            const canvas = document.getElementById('qrCanvas');
            const qrInfo = document.getElementById('qrInfo');

            const qrData = customLink || (nomor ? '<?= base_url('sertifikat/verifikasi/') ?>' + nomor : '');

            if (!qrData) {
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
                qrInfo.textContent = 'Isi nomor sertifikat untuk generate QR';
                return;
            }

            QRCode.toCanvas(canvas, qrData, { width: 180, margin: 2, color: { dark: '#1e293b', light: '#ffffff' } }, function(error) {
                if (!error) {
                    qrInfo.textContent = customLink ? 'QR dari link custom' : 'QR dari nomor sertifikat';
                }
            });
        }

        // Submit Approve — FIXED: tidak pakai event.target global
        function submitApprove() {
            const nomor = document.getElementById('nomorSertifikat').value.trim();
            if (!nomor) {
                document.getElementById('nomorError').style.display = 'block';
                return;
            }

            // Get button by selector (fix: tidak pakai event.target)
            const btn = document.querySelector('#modalApprove .btn-success');
            const originalText = btn ? btn.innerHTML : '';
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                btn.disabled = true;
            }

            // Generate QR code data
            const customLink = document.getElementById('qrCode').value.trim();
            const qrData = customLink || '<?= base_url('sertifikat/verifikasi/') ?>' + nomor;

            const formData = new URLSearchParams();
            formData.append('id', currentId);
            formData.append('action', 'approve');
            formData.append('nomor_sertifikat', nomor);
            formData.append('qr_code', qrData);
            formData.append('catatan', document.getElementById('catatanApprove').value.trim());

            fetch('<?= base_url("sertifikat/update_status") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData.toString()
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error('Server error ' + response.status + ': ' + text.substring(0, 300));
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalApprove'));
                    if (modal) modal.hide();
                    // Tampilkan notifikasi sukses
                    const alertEl = document.createElement('div');
                    alertEl.className = 'alert alert-success alert-dismissible fade show';
                    alertEl.innerHTML = '<i class="fas fa-check-circle me-2"></i><strong>Berhasil!</strong> Pengajuan sertifikat disetujui. QR Code telah disimpan. <button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                    document.querySelector('.admin-main').prepend(alertEl);
                    setTimeout(() => location.reload(), 1800);
                } else {
                    alert('Gagal: ' + (data.message || 'Unknown error'));
                    if (btn) { btn.innerHTML = originalText; btn.disabled = false; }
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan: ' + error.message);
                if (btn) { btn.innerHTML = originalText; btn.disabled = false; }
            });
        }
        // Open Reject Modal
        function openReject(id, judul) {
            currentId = id;
            document.getElementById('rejectJudul').textContent = judul;
            document.getElementById('catatanReject').value = '';
            document.getElementById('rejectError').style.display = 'none';
            
            new bootstrap.Modal(document.getElementById('modalReject')).show();
        }

        // Submit Reject
        function submitReject() {
            const catatan = document.getElementById('catatanReject').value.trim();
            if (!catatan) {
                document.getElementById('rejectError').style.display = 'block';
                return;
            }

            const formData = new URLSearchParams();
            formData.append('id', currentId);
            formData.append('action', 'reject');
            formData.append('catatan', catatan);

            fetch('<?= base_url("sertifikat/update_status") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('modalReject')).hide();
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan koneksi');
            });
        }

        // Show QR Code Modal
        let currentQrData = '';
        function showQR(qrData, nomor) {
            currentQrData = qrData;
            document.getElementById('qrModalNomor').textContent = nomor;
            document.getElementById('qrModalLink').textContent = qrData;

            const canvas = document.getElementById('qrModalCanvas');
            QRCode.toCanvas(canvas, qrData, {
                width: 220,
                margin: 2,
                color: { dark: '#1e293b', light: '#ffffff' }
            }, function(error) {
                if (error) console.error('QR Error:', error);
            });

            new bootstrap.Modal(document.getElementById('modalQR')).show();
        }

		document.querySelectorAll('.btn-show-qr').forEach(function(btn) {
			btn.addEventListener('click', function() {
				showQR(this.dataset.qr, this.dataset.nomor);
			});
		});

        // Download QR sebagai PNG
        function downloadQR() {
            const canvas = document.getElementById('qrModalCanvas');
            const nomor = document.getElementById('qrModalNomor').textContent.replace(/[^a-zA-Z0-9\-]/g, '_');
            const link = document.createElement('a');
            link.download = 'QR_' + nomor + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        // Auto hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
