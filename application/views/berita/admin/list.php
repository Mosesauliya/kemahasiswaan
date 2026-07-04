<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
    <style>
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
        }

        .admin-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
        }

        .btn-add {
            background: #E67E22;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid #E67E22;
        }

        .btn-add:hover {
            background: transparent;
            color: #E67E22;
        }

        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .filter-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-form .form-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-form label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .filter-form select,
        .filter-form input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .filter-form button {
            background: #E67E22;
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-form button:hover {
            background: #d35400;
        }

        .filter-form .reset-btn {
            background: #95a5a6;
        }

        .filter-form .reset-btn:hover {
            background: #7f8c8d;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .badge-kategori {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }

        .badge-berita { background: #E67E22; }
        .badge-pengumuman { background: #2C3E50; }
        .badge-artikel { background: #27ae60; }

        .badge-status {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-publish { background: #d4edda; color: #155724; }
        .badge-draft { background: #fff3cd; color: #856404; }

        .action-btns {
            display: flex;
            gap: 0.3rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-edit { background: rgba(230, 126, 34, 0.1); color: #E67E22; }
        .btn-edit:hover { background: #E67E22; color: white; }
        .btn-delete { background: rgba(231, 76, 60, 0.1); color: #e74c3c; }
        .btn-delete:hover { background: #e74c3c; color: white; }
        .btn-view { background: rgba(52, 152, 219, 0.1); color: #3498db; }
        .btn-view:hover { background: #3498db; color: white; }
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
                <a href="<?= base_url('berita/admin') ?>">
                    <i class="fas fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('berita/admin_list') ?>" class="active">
                    <i class="fas fa-newspaper"></i>
                    <span>Semua Berita</span>
                </a>
                <a href="<?= base_url('berita/create') ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tulis Berita</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('berita/komentar') ?>">
                    <i class="fas fa-comments"></i>
                    <span>Komentar</span>
                </a>
                
                <div class="menu-divider"></div>

                <a href="<?= base_url('tak_admin') ?>">
                    <i class="fas fa-file-signature"></i>
                    <span>TAK</span>
                </a>
                <a href="<?= base_url('admin/proposal') ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>
                <a href="<?= base_url('sertifikat/admin') ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
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
                <h1>Semua Berita</h1>
                <a href="<?= base_url('berita/create') ?>" class="btn-add">
                    <i class="fas fa-plus-circle me-2"></i>Tulis Berita Baru
                </a>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form method="GET" class="filter-form">
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori">
                            <option value="">Semua Kategori</option>
                            <option value="berita" <?= $kategori_filter == 'berita' ? 'selected' : '' ?>>Berita</option>
                            <option value="pengumuman" <?= $kategori_filter == 'pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                            <option value="artikel" <?= $kategori_filter == 'artikel' ? 'selected' : '' ?>>Artikel</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="">Semua Status</option>
                            <option value="publish" <?= $status_filter == 'publish' ? 'selected' : '' ?>>Publish</option>
                            <option value="draft" <?= $status_filter == 'draft' ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit"><i class="fas fa-filter me-2"></i>Filter</button>
                    </div>
                    
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <a href="<?= base_url('berita/admin_list') ?>" class="reset-btn" style="display: inline-block; padding: 0.5rem 2rem; background: #95a5a6; color: white; text-decoration: none; border-radius: 8px;">
                            <i class="fas fa-redo me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table id="beritaTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                        <?php foreach($berita as $b): ?>
                        <tr>
                            <td>#<?= $b['id'] ?></td>
                            <td>
                                <strong><?= substr($b['judul'], 0, 50) ?><?= strlen($b['judul']) > 50 ? '...' : '' ?></strong>
                                <br>
                                <small class="text-muted">Slug: <?= $b['slug'] ?></small>
                            </td>
                            <td>
                                <span class="badge-kategori badge-<?= $b['kategori'] ?>">
                                    <?= ucfirst($b['kategori']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge-status badge-<?= $b['status'] ?>">
                                    <?= ucfirst($b['status']) ?>
                                </span>
                            </td>
                            <td><?= number_format($b['views']) ?></td>
                            <td>
                                <?php if($b['featured']): ?>
                                    <i class="fas fa-star" style="color: #f1c40f;"></i>
                                <?php else: ?>
                                    <i class="far fa-star" style="color: #ddd;"></i>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($b['created_at'])) ?>
                                <br>
                                <small class="text-muted">Published: <?= $b['published_at'] ? date('d/m/Y', strtotime($b['published_at'])) : '-' ?></small>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="<?= base_url('berita/edit/' . $b['id']) ?>" class="btn-action btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('berita/toggle_featured/' . $b['id']) ?>" class="btn-action btn-view" title="Toggle Featured">
                                        <i class="fas fa-star"></i>
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

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Showing <?= (($current_page - 1) * 20) + 1 ?> to <?= min($current_page * 20, $total) ?> of <?= $total ?> entries
                </div>
                <nav>
                    <ul class="pagination">
                        <?php if($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>&kategori=<?= $kategori_filter ?>&status=<?= $status_filter ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&kategori=<?= $kategori_filter ?>&status=<?= $status_filter ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>&kategori=<?= $kategori_filter ?>&status=<?= $status_filter ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#beritaTable').DataTable({
                "paging": false,
                "searching": true,
                "ordering": true,
                "info": false
            });
        });

        function confirmDelete(id, title) {
            document.getElementById('deleteTitle').textContent = title;
            document.getElementById('confirmDeleteBtn').href = '<?= base_url("berita/delete/") ?>' + id;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>