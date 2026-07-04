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

        .badge-pending {
            background: #e74c3c;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 20px;
            font-size: 0.7rem;
            margin-left: auto;
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
        }

        .stat-card.pending:hover {
            border-bottom-color: #e74c3c;
        }

        .stat-card.approved:hover {
            border-bottom-color: #27ae60;
        }

        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card.pending .stat-icon {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .stat-card.approved .stat-icon {
            background: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }

        .stat-card.total .stat-icon {
            background: rgba(230, 126, 34, 0.1);
            color: #E67E22;
        }

        .stat-card .stat-icon i {
            font-size: 1.8rem;
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

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.8rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
            color: #2C3E50;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .filter-tab:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .filter-tab.active {
            background: #E67E22;
            color: white;
        }

        .filter-tab.pending.active {
            background: #e74c3c;
        }

        .filter-tab.approved.active {
            background: #27ae60;
        }

        /* Comments Table */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .comment-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }

        .comment-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .comment-item.pending {
            border-left-color: #e74c3c;
            background: #fff5f5;
        }

        .comment-item.approved {
            border-left-color: #27ae60;
            background: #f0fff4;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .comment-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .comment-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #E67E22, #f39c12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .comment-author-info h4 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: #2C3E50;
        }

        .comment-author-info .comment-email {
            font-size: 0.8rem;
            color: #E67E22;
            margin-bottom: 0;
        }

        .comment-meta {
            text-align: right;
        }

        .comment-date {
            font-size: 0.8rem;
            color: #999;
            margin-bottom: 0.3rem;
        }

        .comment-date i {
            margin-right: 0.3rem;
            color: #E67E22;
        }

        .comment-badge {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-pending {
            background: #e74c3c;
            color: white;
        }

        .badge-approved {
            background: #27ae60;
            color: white;
        }

        .badge-spam {
            background: #95a5a6;
            color: white;
        }

        .comment-content {
            margin: 1rem 0;
            padding: 1rem;
            background: white;
            border-radius: 10px;
        }

        .comment-content p {
            margin: 0;
            line-height: 1.6;
            color: #2C3E50;
        }

        .comment-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .comment-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            border: none;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-approve {
            background: #27ae60;
            color: white;
        }

        .btn-approve:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .btn-pending {
            background: #e74c3c;
            color: white;
        }

        .btn-pending:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-spam {
            background: #95a5a6;
            color: white;
        }

        .btn-spam:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-view {
            background: #3498db;
            color: white;
        }

        .btn-view:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .berita-info {
            font-size: 0.9rem;
            background: #f0f0f0;
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }

        .berita-info i {
            color: #E67E22;
            margin-right: 0.5rem;
        }

        .berita-info a {
            color: #2C3E50;
            text-decoration: none;
            font-weight: 600;
        }

        .berita-info a:hover {
            color: #E67E22;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #2C3E50;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #666;
            max-width: 400px;
            margin: 0 auto;
        }

        /* Modal */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #eee;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                display: none;
            }
            
            .admin-main {
                margin-left: 0;
                padding: 1rem;
            }
            
            .comment-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .comment-meta {
                text-align: left;
            }
            
            .comment-footer {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .comment-actions {
                width: 100%;
                flex-wrap: wrap;
            }
            
            .btn-action {
                flex: 1;
                text-align: center;
                justify-content: center;
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
                <a href="<?= base_url('berita/admin') ?>">
                    <i class="fas fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('berita/admin_list') ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Semua Berita</span>
                </a>
                <a href="<?= base_url('berita/create') ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tulis Berita</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('berita/komentar') ?>" class="active">
                    <i class="fas fa-comments"></i>
                    <span>Komentar</span>
                    <?php 
                    $this->load->model('Berita_model');
                    $pending_count = $this->Berita_model->get_pending_komentar_count();
                    if($pending_count > 0): 
                    ?>
                    <span class="badge-pending"><?= $pending_count ?> baru</span>
                    <?php endif; ?>
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
                <h1>Manajemen Komentar</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <?php
                $total = count($komentar);
                $pending = 0;
                $approved = 0;
                $spam = 0;
                
                foreach($komentar as $k) {
                    if($k['status'] == 'pending') $pending++;
                    elseif($k['status'] == 'approved') $approved++;
                    elseif($k['status'] == 'spam') $spam++;
                }
                ?>
                
                <div class="stat-card total">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-label">Total Komentar</div>
                    <div class="stat-value"><?= $total ?></div>
                </div>
                
                <div class="stat-card pending">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value"><?= $pending ?></div>
                </div>
                
                <div class="stat-card approved">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-label">Approved</div>
                    <div class="stat-value"><?= $approved ?></div>
                </div>
                
                <div class="stat-card" style="border-bottom-color: #95a5a6;">
                    <div class="stat-icon" style="background: rgba(149, 165, 166, 0.1); color: #95a5a6;">
                        <i class="fas fa-ban"></i>
                    </div>
                    <div class="stat-label">Spam</div>
                    <div class="stat-value"><?= $spam ?></div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <a href="?status=pending" class="filter-tab pending <?= $status_filter == 'pending' ? 'active' : '' ?>">
                    <i class="fas fa-clock me-2"></i>Pending (<?= $pending ?>)
                </a>
                <a href="?status=approved" class="filter-tab approved <?= $status_filter == 'approved' ? 'active' : '' ?>">
                    <i class="fas fa-check-circle me-2"></i>Approved (<?= $approved ?>)
                </a>
                <a href="?status=spam" class="filter-tab <?= $status_filter == 'spam' ? 'active' : '' ?>">
                    <i class="fas fa-ban me-2"></i>Spam (<?= $spam ?>)
                </a>
            </div>

            <!-- Comments List -->
            <div class="table-container">
                <?php if(!empty($komentar)): ?>
                    <?php foreach($komentar as $k): ?>
                    <div class="comment-item <?= $k['status'] ?>" id="comment-<?= $k['id'] ?>">
                        <div class="comment-header">
                            <div class="comment-author">
                                <div class="comment-avatar">
                                    <?= strtoupper(substr($k['nama'], 0, 1)) ?>
                                </div>
                                <div class="comment-author-info">
                                    <h4><?= htmlspecialchars($k['nama']) ?></h4>
                                    <?php if($k['email']): ?>
                                    <p class="comment-email">
                                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($k['email']) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="comment-meta">
                                <div class="comment-date">
                                    <i class="far fa-calendar-alt"></i> <?= date('d F Y H:i', strtotime($k['created_at'])) ?>
                                </div>
                                <span class="comment-badge badge-<?= $k['status'] ?>">
                                    <?= ucfirst($k['status']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="comment-content">
                            <p><?= nl2br(htmlspecialchars($k['komentar'])) ?></p>
                        </div>

                        <div class="comment-footer">
                            <div class="berita-info">
                                <i class="fas fa-newspaper"></i>
                                Pada berita: 
                                <a href="<?= base_url('berita/detail/') ?>" target="_blank">
                                    <?= htmlspecialchars($k['berita_judul']) ?>
                                </a>
                            </div>

                            <div class="comment-actions">
                                <?php if($k['status'] != 'approved'): ?>
                                <a href="#" class="btn-action btn-approve" onclick="updateStatus(<?= $k['id'] ?>, 'approved')">
                                    <i class="fas fa-check-circle"></i> Setujui
                                </a>
                                <?php endif; ?>
                                
                                <?php if($k['status'] != 'pending'): ?>
                                <a href="#" class="btn-action btn-pending" onclick="updateStatus(<?= $k['id'] ?>, 'pending')">
                                    <i class="fas fa-clock"></i> Tandai Pending
                                </a>
                                <?php endif; ?>
                                
                                <?php if($k['status'] != 'spam'): ?>
                                <a href="#" class="btn-action btn-spam" onclick="updateStatus(<?= $k['id'] ?>, 'spam')">
                                    <i class="fas fa-ban"></i> Tandai Spam
                                </a>
                                <?php endif; ?>
                                
                                <a href="#" class="btn-action btn-delete" onclick="confirmDelete(<?= $k['id'] ?>)">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                
                                <a href="<?= base_url('berita/detail/' .  '#komentar-' . $k['id']) ?>" target="_blank" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h3>Belum Ada Komentar</h3>
                        <p>Saat ini belum ada komentar yang perlu dimoderasi.</p>
                    </div>
                <?php endif; ?>
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
                    <div class="text-center mb-4">
                        <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: #e74c3c;"></i>
                    </div>
                    <p class="text-center">Apakah Anda yakin ingin menghapus komentar ini?</p>
                    <p class="text-center text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    <p class="mt-3" id="successMessage">Status komentar berhasil diupdate.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update status komentar via AJAX
        function updateStatus(id, status) {
            if(confirm('Ubah status komentar ini menjadi ' + status + '?')) {
                $.ajax({
                    url: '<?= base_url("berita/update_komentar/") ?>' + id,
                    type: 'POST',
                    data: { status: status },
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            // Show success message
                            document.getElementById('successMessage').textContent = response.message;
                            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                            successModal.show();
                            
                            // Reload page after 1 second
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            }
        }

        // Confirm delete
        function confirmDelete(id) {
            document.getElementById('confirmDeleteBtn').href = '<?= base_url("berita/delete_komentar/") ?>' + id;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.comment-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Filter by status
        $('#statusFilter').on('change', function() {
            var status = $(this).val();
            if(status === '') {
                $('.comment-item').show();
            } else {
                $('.comment-item').hide();
                $('.comment-item.' + status).show();
            }
        });
    </script>
</body>
</html>