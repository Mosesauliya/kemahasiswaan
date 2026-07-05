<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

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

        /* Recent News Table */
        .recent-news {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .recent-news h3 {
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
        }

        .badge-status {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-publish {
            background: #d4edda;
            color: #155724;
        }

        .badge-draft {
            background: #fff3cd;
            color: #856404;
        }

        .badge-kategori {
            background: #E67E22;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 15px;
            font-size: 0.7rem;
        }

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
        }

        .btn-edit {
            background: rgba(230, 126, 34, 0.1);
            color: #E67E22;
        }

        .btn-edit:hover {
            background: #E67E22;
            color: white;
        }

        .btn-delete {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
            color: white;
        }

        .btn-view {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .btn-view:hover {
            background: #3498db;
            color: white;
        }

        .featured-star {
            color: #f1c40f;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .featured-star:hover {
            transform: scale(1.2);
        }

        .featured-star.inactive {
            color: #ddd;
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
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <h3>Admin FIK</h3>
                <p>Manajemen Berita & Konten</p>
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
                <a href="<?= base_url('berita/admin') ?>" class="active">
                    <i class="fas fa-dashboard"></i>
                    <span>Berita</span>
                </a>
                <a href="<?= base_url('admin/organisasi') ?>">
                    <i class="fas fa-users"></i>
                    <span>Organisasi</span>
                </a>
                <div class="menu-divider"></div>
                <a href="<?= base_url('berita/admin_list') ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Semua Berita</span>
                </a>
                <a href="<?= base_url('berita/create') ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tulis Berita</span>
                </a>
                
                
                <a href="<?= base_url('berita/kategori/berita') ?>" target="_blank">
                    <i class="fas fa-eye"></i>
                    <span>Lihat Website</span>
                </a>
                <a href="<?= base_url('berita/komentar') ?>">
                    <i class="fas fa-comments"></i>
                    <span>Komentar</span>
                    <?php if($stats['komentar_pending'] > 0): ?>
                        <span class="badge bg-danger ms-auto"><?= $stats['komentar_pending'] ?></span>
                    <?php endif; ?>
                </a>

                <div class="menu-divider"></div>
            
            <a href="<?= base_url('admin/history_log') ?>">
                <i class="fas fa-history"></i>
                <span>History Log</span>
            </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
                <a href="<?= base_url('login/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1>Dashboard Admin</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-label">Total Berita</div>
                    <div class="stat-value"><?= number_format($stats['total']) ?></div>
                    <div class="stat-detail">
                        <span class="text-success"><?= $stats['publish'] ?> Publish</span> • 
                        <span class="text-warning"><?= $stats['draft'] ?> Draft</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-label">Total Views</div>
                    <div class="stat-value"><?= number_format($stats['total_views']) ?></div>
                    <div class="stat-detail">Dari semua berita</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-label">Komentar</div>
                    <div class="stat-value"><?= number_format($stats['total_komentar']) ?></div>
                    <div class="stat-detail">
                        <span class="text-warning"><?= $stats['komentar_pending'] ?> pending</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="stat-label">Kategori</div>
                    <div class="stat-value"><?= number_format($stats['berita'] + $stats['pengumuman'] + $stats['artikel'])?></div>
                    <div class="stat-detail">
                        <span>B:<?= $stats['berita'] ?> P:<?= $stats['pengumuman'] ?> A:<?= $stats['artikel'] ?></span>
                    </div>
                </div>
            </div>

            <!-- Kategori Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Berita</h5>
                            <h2><?= $stats['berita'] ?></h2>
                            <small>Total berita</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pengumuman</h5>
                            <h2><?= $stats['pengumuman'] ?></h2>
                            <small>Total pengumuman</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Artikel</h5>
                            <h2><?= $stats['artikel'] ?></h2>
                            <small>Total artikel</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent News -->
            <div class="recent-news">
                <h3>Berita Terbaru</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Featured</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent as $b): ?>
                            <tr>
                                <td>
                                    <strong><?= substr($b['judul'], 0, 50) ?><?= strlen($b['judul']) > 50 ? '...' : '' ?></strong>
                                </td>
                                <td>
                                    <span class="badge-kategori"><?= ucfirst($b['kategori']) ?></span>
                                </td>
                                <td>
                                    <span class="badge-status badge-<?= $b['status'] ?>">
                                        <?= ucfirst($b['status']) ?>
                                    </span>
                                </td>
                                <td><?= number_format($b['views']) ?></td>
                                <td>
                                    <a href="<?= base_url('berita/toggle_featured/' . $b['id']) ?>" class="featured-star <?= $b['featured'] ? '' : 'inactive' ?>">
                                        <i class="fas fa-star"></i>
                                    </a>
                                </td>
                                <td><?= date('d/m/Y', strtotime($b['created_at'])) ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('berita/edit/' . $b['id']) ?>" class="btn-action btn-edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('berita/detail/' . $b['slug']) ?>" target="_blank" class="btn-action btn-view" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn-action btn-delete" onclick="confirmDelete(<?= $b['id'] ?>, '<?= addslashes($b['judul']) ?>')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus berita: <strong id="deleteTitle"></strong>?</p>
                    <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function confirmDelete(id, title) {
            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('confirmDeleteBtn').href = '<?= base_url("berita/delete/") ?>' + id;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>