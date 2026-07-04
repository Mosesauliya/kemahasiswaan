<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Admin Proposal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
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

        /* Sidebar Badge */
        .sidebar-badge {
            margin-left: auto;
            background: #dc2626;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            min-width: 20px;
            text-align: center;
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

        .badge-draft {
            background: #e9ecef;
            color: #495057;
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

        .alert-success {
            background: #d4edda;
            border-left: 4px solid #16a34a;
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
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

        /* Detail sections */
        .detail-section {
            margin-bottom: 1.5rem;
        }

        .detail-section-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #E67E22;
            margin-bottom: 0.8rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .detail-item .label {
            font-size: 0.75rem;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
        }

        .detail-item .value {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2C3E50;
        }

        .detail-text-block {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.9rem;
            max-height: 150px;
            overflow-y: auto;
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

            .detail-grid {
                grid-template-columns: 1fr;
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
                <p>Manajemen Proposal</p>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= base_url('admin/proposal') ?>" class="active">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>
                <a href="<?= base_url('sertifikat/admin') ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>
                <a href="<?= base_url('tak_admin') ?>">
                    <i class="fas fa-file-signature"></i>
                    <span>TAK</span>
                </a>
                <a href="<?= base_url('berita/admin') ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Berita</span>
                </a>
                <a href="<?= base_url('admin/organisasi') ?>">
                    <i class="fas fa-users"></i>
                    <span>Organisasi</span>
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
                <h1>Manajemen Proposal</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <?php
            $counts = $stat_counts ?? ['draft'=>0, 'submitted'=>0, 'disetujui'=>0, 'ditolak'=>0];
            $total_all = array_sum($counts);
            $pending_count = $counts['submitted'] ?? 0;
            ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-label">Total Proposal</div>
                    <div class="stat-value"><?= number_format($total_all) ?></div>
                    <div class="stat-detail">Semua proposal</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-label">Menunggu Review</div>
                    <div class="stat-value"><?= number_format($counts['submitted']) ?></div>
                    <div class="stat-detail">
                        <span class="text-warning">Perlu ditindaklanjuti</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Disetujui</div>
                    <div class="stat-value"><?= number_format($counts['disetujui']) ?></div>
                    <div class="stat-detail">
                        <span class="text-success">Siap diimplementasikan</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value"><?= number_format($counts['ditolak']) ?></div>
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
                            <input type="text" class="form-control" name="q" placeholder="Cari nama kegiatan, pengaju, ormawa..." value="<?= htmlspecialchars($search ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="submitted" <?= ($status_filter ?? '') == 'submitted' ? 'selected' : '' ?>>Menunggu Review</option>
                                <option value="disetujui" <?= ($status_filter ?? '') == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                                <option value="ditolak" <?= ($status_filter ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                <option value="draft" <?= ($status_filter ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="tipe">
                                <option value="">Semua Tipe</option>
                                <option value="himpunan" <?= ($tipe_filter ?? '') == 'himpunan' ? 'selected' : '' ?>>Ormawa / Himpunan</option>
                                <option value="bemdpm" <?= ($tipe_filter ?? '') == 'bemdpm' ? 'selected' : '' ?>>BEM / DPM</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn-filter w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <h3><i class="fas fa-inbox me-2" style="color: #E67E22;"></i>Daftar Proposal</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Kode</th>
                                <th>Nama Kegiatan</th>
                                <th>Pengaju</th>
                                <th>Ormawa</th>
                                <th>Tipe</th>
                                <th>Tgl Diajukan</th>
                                <th>Tgl Kegiatan</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($proposals)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($proposals as $p): ?>
                                <tr onclick="openDetail(<?= $p->id ?>)" style="cursor: pointer;">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <code style="font-size:0.8rem;"><?= htmlspecialchars($p->kode_proposal ?? '-') ?></code>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($p->nama_kegiatan ?? '-') ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($p->nama_pengaju ?? '-') ?></td>
                                    <td><?= htmlspecialchars($p->nama_ormawa ?? '-') ?></td>
                                    <td>
                                        <?php if ($p->tipe_proposal == 'himpunan'): ?>
                                            <span class="badge bg-info text-white">Ormawa</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary text-white">BEM/DPM</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($p->created_at)) ?></td>
                                    <td>
                                        <?php if (!empty($p->tanggal_kegiatan) && $p->tanggal_kegiatan != '0000-00-00'): ?>
                                            <?= date('d/m/Y', strtotime($p->tanggal_kegiatan)) ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($p->status == 'submitted'): ?>
                                            <span class="badge-status badge-submitted">Menunggu</span>
                                        <?php elseif ($p->status == 'disetujui'): ?>
                                            <span class="badge-status badge-approved">Disetujui</span>
                                        <?php elseif ($p->status == 'ditolak'): ?>
                                            <span class="badge-status badge-rejected">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-draft">Draft</span>
                                        <?php endif; ?>
                                    </td>
                                    <td onclick="event.stopPropagation()">
                                        <div class="action-btns">
                                            <!-- Detail -->
                                            <button class="btn-action btn-view" title="Detail" onclick="openDetail(<?= $p->id ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <?php if ($p->status == 'submitted'): ?>
                                                <!-- Setujui -->
                                                <button class="btn-action btn-approve" title="Setujui" onclick="openApprove(<?= $p->id ?>, '<?= htmlspecialchars(addslashes($p->nama_kegiatan)) ?>')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <!-- Tolak -->
                                                <button class="btn-action btn-reject" title="Tolak" onclick="openReject(<?= $p->id ?>, '<?= htmlspecialchars(addslashes($p->nama_kegiatan)) ?>')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>

                                            <?php if ($p->status == 'disetujui'): ?>
                                                <!-- PDF -->
                                                <a href="<?= base_url('proposal/pdf/'.$p->id) ?>" target="_blank" class="btn-action btn-pdf" title="Lihat PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <p>Belum ada proposal</p>
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
                    <h5 class="modal-title"><i class="fas fa-file-alt me-2"></i>Detail Proposal</h5>
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
                    <button type="button" class="btn btn-success" id="modalApproveBtn" style="display: none;">Setujui</button>
                    <button type="button" class="btn btn-danger" id="modalRejectBtn" style="display: none;">Tolak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Approve -->
    <div class="modal fade" id="modalApprove" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-approve">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Setujui Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-success">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda akan menyetujui proposal <strong id="approveNama"></strong>.
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
                    <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>Tolak Proposal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Anda akan menolak proposal <strong id="rejectNama"></strong>.
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let currentApproveId = null;
        let currentRejectId = null;
        let currentDetailId = null;

        // Open Detail Modal - Perbaiki
function openDetail(id) {
    currentDetailId = id;
    
    // Tampilkan loading
    document.getElementById('detailBody').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-warning" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat data...</p>
        </div>
    `;
    
    // Sembunyikan tombol approve/reject dulu
    document.getElementById('modalApproveBtn').style.display = 'none';
    document.getElementById('modalRejectBtn').style.display = 'none';
    
    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
    modal.show();
    
    // Fetch data
    fetch('<?= base_url("admin/get_proposal_detail/") ?>' + id, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            const p = data.data;
            
            // Format tanggal
            const fmtDate = (d) => {
                if (!d || d === '0000-00-00' || d === null) return '-';
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const date = new Date(d);
                if (isNaN(date.getTime())) return '-';
                return date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
            };

            // Format rupiah
            const fmtRp = (n) => {
                if (!n && n !== 0) return 'Rp 0';
                return 'Rp ' + Number(n).toLocaleString('id-ID');
            };

            // Status badge
            let statusBadge = '';
            if (p.status == 'submitted') statusBadge = '<span class="badge-status badge-submitted">Menunggu Review</span>';
            else if (p.status == 'disetujui') statusBadge = '<span class="badge-status badge-approved">Disetujui</span>';
            else if (p.status == 'ditolak') statusBadge = '<span class="badge-status badge-rejected">Ditolak</span>';
            else statusBadge = '<span class="badge-status badge-draft">Draft</span>';

            // Catatan admin
            let catatanHtml = '';
            if (p.catatan_admin && p.catatan_admin.trim() !== '') {
                if (p.status == 'ditolak') {
                    catatanHtml = `
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Catatan Penolakan:</strong> ${p.catatan_admin}
                        </div>
                    `;
                } else if (p.status == 'disetujui') {
                    catatanHtml = `
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Catatan:</strong> ${p.catatan_admin}
                        </div>
                    `;
                }
            }

            // Nama pengaju
            const namaPengaju = p.nama_pengaju || '-';
            const nim = p.nim || '-';
            const jenisKegiatan = p.jenis_kegiatan || '-';
            const tipeProposal = p.tipe_proposal == 'himpunan' ? 'Ormawa / Himpunan' : 'BEM / DPM';

            document.getElementById('detailBody').innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="mb-1">${p.nama_kegiatan || '-'}</h5>
                        <small class="text-muted">${p.kode_proposal || '-'} • ${p.nama_ormawa || '-'}</small>
                    </div>
                    ${statusBadge}
                </div>

                ${catatanHtml}

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fas fa-id-card"></i> Identitas</div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Pengaju</div>
                            <div class="value">${namaPengaju}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">NIM</div>
                            <div class="value">${nim}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Jenis Kegiatan</div>
                            <div class="value">${jenisKegiatan}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Tipe Proposal</div>
                            <div class="value">${tipeProposal}</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fas fa-calendar-alt"></i> Waktu & Tempat</div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Tanggal Kegiatan</div>
                            <div class="value">${fmtDate(p.tanggal_kegiatan)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Waktu</div>
                            <div class="value">${p.waktu_mulai || '-'} – ${p.waktu_selesai || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Lokasi</div>
                            <div class="value">${p.lokasi_kegiatan || '-'}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Estimasi Peserta</div>
                            <div class="value">${p.peserta || '-'} orang</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fas fa-scroll"></i> Pendahuluan</div>
                    <div class="mb-2"><strong>Latar Belakang</strong></div>
                    <div class="detail-text-block mb-3">${p.latar_belakang ? p.latar_belakang.replace(/\n/g,'<br>') : '-'}</div>
                    <div class="mb-2"><strong>Tujuan & Manfaat</strong></div>
                    <div class="detail-text-block">${p.tujuan_manfaat ? p.tujuan_manfaat.replace(/\n/g,'<br>') : '-'}</div>
                </div>

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fas fa-coins"></i> Anggaran</div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="label">Total RAB</div>
                            <div class="value">${fmtRp(p.total_rab)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Dana Diajukan</div>
                            <div class="value" style="color: #E67E22;">${fmtRp(p.dana_diajukan)}</div>
                        </div>
                        <div class="detail-item">
                            <div class="label">Sumber Dana</div>
                            <div class="value">${p.sumber_dana || '-'}</div>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <div class="detail-section-title"><i class="fas fa-history"></i> Riwayat</div>
                    <div class="detail-item">
                        <div class="label">Tanggal Pengajuan</div>
                        <div class="value">${p.created_at ? new Date(p.created_at).toLocaleString('id-ID') : '-'}</div>
                    </div>
                </div>
            `;

            // Show/hide action buttons in modal footer
            const approveBtn = document.getElementById('modalApproveBtn');
            const rejectBtn = document.getElementById('modalRejectBtn');
            
            if (p.status === 'submitted') {
                approveBtn.style.display = 'inline-block';
                rejectBtn.style.display = 'inline-block';
                
                approveBtn.onclick = () => {
                    bootstrap.Modal.getInstance(document.getElementById('modalDetail')).hide();
                    openApprove(p.id, p.nama_kegiatan);
                };
                
                rejectBtn.onclick = () => {
                    bootstrap.Modal.getInstance(document.getElementById('modalDetail')).hide();
                    openReject(p.id, p.nama_kegiatan);
                };
            } else {
                approveBtn.style.display = 'none';
                rejectBtn.style.display = 'none';
            }
        } else {
            document.getElementById('detailBody').innerHTML = '<p class="text-danger">Gagal memuat data: ' + (data.message || 'Unknown error') + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('detailBody').innerHTML = '<p class="text-danger">Terjadi kesalahan koneksi</p>';
    });
}

        // Open Approve Modal
        function openApprove(id, nama) {
            currentApproveId = id;
            document.getElementById('approveNama').textContent = nama;
            document.getElementById('catatanApprove').value = '';
            
            new bootstrap.Modal(document.getElementById('modalApprove')).show();
        }

        // Submit Approve - Perbaiki
function submitApprove() {
    if (!currentApproveId) return;
    
    const catatan = document.getElementById('catatanApprove').value.trim();
    
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    btn.disabled = true;

    const formData = new URLSearchParams();
    formData.append('catatan', catatan);

    fetch('<?= base_url("admin/setujui/") ?>' + currentApproveId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Tutup modal approve
            bootstrap.Modal.getInstance(document.getElementById('modalApprove')).hide();
            
            // Tampilkan pesan sukses
            alert('Proposal berhasil disetujui!');
            
            // Reload halaman
            location.reload();
        } else {
            alert('Error: ' + data.message);
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

// Submit Reject - Perbaiki
function submitReject() {
    if (!currentRejectId) return;
    
    const catatan = document.getElementById('catatanReject').value.trim();
    if (!catatan) {
        document.getElementById('rejectError').style.display = 'block';
        return;
    }
    
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
    btn.disabled = true;

    const formData = new URLSearchParams();
    formData.append('catatan', catatan);

    fetch('<?= base_url("admin/tolak/") ?>' + currentRejectId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData.toString()
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // Tutup modal reject
            bootstrap.Modal.getInstance(document.getElementById('modalReject')).hide();
            
            // Tampilkan pesan sukses
            alert('Proposal telah ditolak');
            
            // Reload halaman
            location.reload();
        } else {
            alert('Error: ' + data.message);
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan koneksi');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

        // Open Reject Modal
        function openReject(id, nama) {
            currentRejectId = id;
            document.getElementById('rejectNama').textContent = nama;
            document.getElementById('catatanReject').value = '';
            document.getElementById('rejectError').style.display = 'none';
            
            new bootstrap.Modal(document.getElementById('modalReject')).show();
                            }
    </script>
</body>
</html>