<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Montserrat', sans-serif; background: #f0f2f5; }

        /* ── Sidebar ── */
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 280px; background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white; position: fixed; height: 100vh; overflow-y: auto; z-index: 100;
        }
        .sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-header h3 { margin: 0; font-size: 1.3rem; font-weight: 700; }
        .sidebar-header p  { margin: 0.5rem 0 0; font-size: 0.8rem; opacity: 0.7; }
        .sidebar-menu { padding: 1.5rem 0; }
        .sidebar-menu a {
            display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8); text-decoration: none; transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active { background: rgba(230, 126, 34, 0.2); color: white; border-left-color: #E67E22; }
        .sidebar-menu a i { width: 20px; color: #E67E22; }
        .sidebar-menu .menu-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 1rem 0; }
        
        /* ── Main ── */
        .admin-main { flex: 1; margin-left: 280px; padding: 2rem; }
        .admin-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 2rem; padding-bottom: 1.2rem; border-bottom: 2px solid #e8eaed;
        }
        .admin-header h1 { font-size: 1.8rem; font-weight: 700; color: #2C3E50; }
        .admin-header .user-info { display: flex; align-items: center; gap: 1rem; }
        .admin-header .user-info span { color: #666; font-size: .88rem; }
        .logout-btn {
            background: #e74c3c; color: white; padding: .45rem 1.3rem;
            border-radius: 25px; text-decoration: none; font-size: .85rem;
            transition: background .2s;
        }
        .logout-btn:hover { background: #c0392b; color: #fff; }

        /* ── Table Card ── */
        .table-card {
            background: white; border-radius: 14px; padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,.05); margin-top: 1rem;
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: .5rem; }
        th { font-weight: 700; color: #7f8c8d; text-align: left; padding: 1rem .8rem; border-bottom: 2px solid #f0f2f5; font-size: .88rem; }
        td { padding: 1rem .8rem; border-bottom: 1px solid #f0f2f5; font-size: .9rem; vertical-align: middle; color: #2c3e50; }
        tr:hover td { background-color: #fafbfc; }

        .btn-approve {
            background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: none;
            padding: .45rem 1rem; border-radius: 8px; font-size: .8rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: .3rem; transition: all 0.2s;
        }
        .btn-approve:hover { background: #2ecc71; color: white; }

        .btn-reject {
            background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: none;
            padding: .45rem 1rem; border-radius: 8px; font-size: .8rem; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: .3rem; transition: all 0.2s;
        }
        .btn-reject:hover { background: #e74c3c; color: white; }

        .empty-state { text-align: center; padding: 3rem 1rem; color: #95a5a6; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: #bdc3c7; }

        .badge-status {
            font-size: 0.75rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;
        }
        .status-pending { background: rgba(243, 156, 18, 0.15); color: #d35400; }
        .status-approved { background: rgba(46, 204, 113, 0.15); color: #27ae60; }
        .status-rejected { background: rgba(231, 76, 60, 0.15); color: #c0392b; }

        .media-preview {
            max-width: 120px; border-radius: 8px; border: 1px solid #e2e8f0; cursor: pointer; transition: transform 0.2s;
        }
        .media-preview:hover { transform: scale(1.05); }

        .btn-close-circle {
            position: absolute;
            right: 15px;
            top: 15px;
            z-index: 1060;
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        }
        .btn-close-circle:hover {
            background: rgba(231, 76, 60, 0.9);
            border-color: white;
            transform: scale(1.1);
        }

        /* === MOBILE RESPONSIVE === */
        * { box-sizing: border-box; }
        html, body { overflow-x: hidden; max-width: 100%; }
        .mobile-topbar { display: none; position: fixed; top: 0; left: 0; right: 0; z-index: 1100; background: linear-gradient(135deg, #2C3E50, #1a2632); box-shadow: 0 2px 12px rgba(0,0,0,0.3); }
        .topbar-inner { display: flex; align-items: center; justify-content: space-between; height: 54px; padding: 0 0.75rem; gap: 0.5rem; }
        .hamburger-btn { display: none; background: rgba(255,255,255,0.15); color: white; border: none; border-radius: 8px; width: 38px; height: 38px; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; flex-shrink: 0; }
        .hamburger-btn:hover { background: rgba(230,126,34,0.6); }
        .topbar-right { display: flex; align-items: center; gap: 0.5rem; flex: 1; min-width: 0; justify-content: flex-end; }
        .topbar-username { display: flex; align-items: center; gap: 0.35rem; color: rgba(255,255,255,0.9); font-size: 0.78rem; font-weight: 500; flex: 1; min-width: 0; }
        .topbar-username i { color: #E67E22; font-size: 1rem; flex-shrink: 0; }
        .topbar-username .name-text { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; min-width: 0; }
        .topbar-logout { background: #e74c3c; color: white; border: none; border-radius: 8px; padding: 0.38rem 0.8rem; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 0.3rem; white-space: nowrap; flex-shrink: 0; }
        .topbar-logout:hover { background: #c0392b; color: white; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px); }
        .sidebar-overlay.active { display: block; }
        @media (max-width: 768px) {
            .mobile-topbar { display: block; } .hamburger-btn { display: flex; }
            .admin-sidebar { position: fixed !important; left: -280px !important; z-index: 1000; transition: left 0.3s ease; width: 280px !important; display: block !important; }
            .admin-sidebar.open { left: 0 !important; }
            .admin-main { margin-left: 0 !important; padding: 1rem !important; padding-top: 4.5rem !important; max-width: 100vw; overflow-x: hidden; }
            .admin-header { flex-direction: column !important; align-items: stretch !important; gap: 0.75rem; }
            .admin-header h1 { font-size: 1.3rem !important; word-break: break-word; }
            .admin-header .user-info > span, .admin-header .user-info .logout-btn { display: none; }
            
            .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%; }

            .table-stackable thead { display: none; }
            .table-stackable tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 0;
                background: #fff;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            }
            .table-stackable td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #f1f5f9;
                padding: 0.8rem 1rem;
                font-size: 0.85rem;
                text-align: right;
                gap: 1rem;
                white-space: normal;
            }
            .table-stackable td::before {
                content: attr(data-label);
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.72rem;
                color: #64748b;
                text-align: left;
                flex-shrink: 0;
            }
            .table-stackable td:last-child { border-bottom: 0; justify-content: flex-end; }
        }

        /* ── Drag & Drop Zone ── */
        .admin-drop-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 16px 12px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
        }

        .admin-drop-zone:hover,
        .admin-drop-zone.dragover {
            border-color: #f97316;
            background: #fff7ed;
        }

        .admin-drop-zone .drop-icon {
            font-size: 2rem;
            color: #f97316;
            margin-bottom: 6px;
            display: block;
        }

        .admin-drop-zone .drop-text {
            font-size: 0.82rem;
            color: #475569;
            margin: 0;
        }

        .img-preview-box {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 3px solid #f97316;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-bottom: 6px;
        }
    </style>
</head>
<body>

    <!-- Mobile Topbar -->
    <div class="mobile-topbar" id="mobileTopbar">
        <div class="topbar-inner">
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topbar-right">
                <div class="topbar-username">
                    <i class="fas fa-user-circle"></i>
                    <span class="name-text"><?= htmlspecialchars($nama_user) ?></span>
                </div>
                <a href="<?= base_url('logout') ?>" class="topbar-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
                <p>Kemahasiswaan FIK</p>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= base_url('admin/edit_hero') ?>">
                    <i class="fas fa-desktop"></i>
                    <span>Dashboard</span>
                </a>

                <a href="<?= base_url('admin/proposal') ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>

                <a href="<?= base_url('admin/beasiswa') ?>">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Beasiswa</span>
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

                <a href="<?= base_url('admin/direktorat') ?>">
                    <i class="fas fa-building"></i>
                    <span>Direktorat</span>
                </a>

                <a href="<?= base_url('admin/mitra') ?>">
                    <i class="fas fa-handshake"></i>
                    <span>Mitra & Recog</span>
                </a>

                <a href="<?= base_url('admin/testimoni') ?>">
                    <i class="fas fa-comments"></i>
                    <span>Testimoni Alumni</span>
                </a>

                <a href="<?= base_url('admin/tentang_kami') ?>">
                    <i class="fas fa-info-circle"></i>
                    <span>Tentang Kami</span>
                </a>

                <div class="menu-divider"></div>

                <a href="<?= base_url('admin/forum_alumni') ?>" class="active">
                    <i class="fas fa-comments"></i>
                    <span>Forum Alumni</span>
                    <?php 
                    $CI =& get_instance();
                    $pending_posts = $CI->db->where('status', 'pending')->count_all_results('forum_alumni_posts');
                    if ($pending_posts > 0): 
                    ?>
                        <span class="badge bg-danger ms-auto"><?= $pending_posts ?></span>
                    <?php endif; ?>
                </a>

                <a href="<?= base_url('admin/history_log') ?>">
                    <i class="fas fa-history"></i>
                    <span>History Log</span>
                </a>

                <div class="menu-divider"></div>

                <a href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>Kelola Ikatan Alumni & Moderasi Forum</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= htmlspecialchars($nama_user) ?></span>
                    <a href="<?= base_url('logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </header>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; border:none; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
                    <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-warning text-white font-weight-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEditIkatanAlumni" style="border-radius: 10px; padding: 0.6rem 1.2rem;">
                    <i class="fas fa-user-shield me-2"></i> Edit Profil & Ketua Ikatan Alumni
                </button>
            </div>

            <div class="table-card">
                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs border-bottom-0 mb-3" id="moderasiTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active font-weight-bold" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" style="border-radius: 8px 8px 0 0;">
                            Pending Approval 
                            <?php if ($pending_posts > 0): ?>
                                <span class="badge bg-danger ms-1"><?= $pending_posts ?></span>
                            <?php endif; ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link font-weight-bold" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" style="border-radius: 8px 8px 0 0;">Disetujui</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link font-weight-bold" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" style="border-radius: 8px 8px 0 0;">Ditolak</button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="moderasiTabContent">
                    
                    <!-- PENDING POSTS -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel">
                        <?php 
                        $p_posts = array_filter($posts, function($p) { return $p['status'] === 'pending'; });
                        if (empty($p_posts)): 
                        ?>
                            <div class="empty-state">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Tidak ada postingan yang menunggu moderasi.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-stackable">
                                    <thead>
                                        <tr>
                                            <th width="60">#</th>
                                            <th width="200">Pengirim</th>
                                            <th>Konten Postingan</th>
                                            <th width="150">Lampiran Media</th>
                                            <th width="180">Waktu Kirim</th>
                                            <th width="200" style="text-align:center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($p_posts as $p): ?>
                                            <tr>
                                                <td data-label="No"><?= $no++ ?></td>
                                                <td data-label="Pengirim">
                                                    <strong><?= htmlspecialchars($p['nama']) ?></strong>
                                                    <br><small class="text-muted"><?= htmlspecialchars(ucfirst($p['role'])) ?></small>
                                                </td>
                                                <td data-label="Konten">
                                                    <div style="max-height:100px; overflow-y:auto; font-size:0.88rem; white-space:pre-wrap; line-height:1.4; color:#334155;"><?= htmlspecialchars($p['content']) ?></div>
                                                </td>
                                                <td data-label="Media">
                                                    <?php if ($p['image']): ?>
                                                        <img src="<?= base_url('uploads/forum_posts/' . $p['image']) ?>" class="media-preview" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('image', '<?= base_url('uploads/forum_posts/' . $p['image']) ?>')">
                                                    <?php elseif ($p['video']): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('video', '<?= base_url('uploads/forum_posts/' . $p['video']) ?>')" style="font-size:0.75rem; border-radius:6px;">
                                                            <i class="fas fa-video me-1"></i> Lihat Video
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size:0.8rem;">Tidak ada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="Waktu"><small><?= date('d M Y H:i', strtotime($p['created_at'])) ?></small></td>
                                                <td data-label="Aksi" style="text-align:center;">
                                                    <div class="action-btns justify-content-center">
                                                        <a href="<?= base_url('admin/forum_alumni/approve/' . $p['id']) ?>" class="btn-approve" onclick="showActionConfirm('<?= base_url('admin/forum_alumni/approve/' . $p['id']) ?>', 'Setujui Postingan', 'Apakah Anda yakin ingin menyetujui postingan ini agar tampil di forum?', 'approve', event)">
                                                            <i class="fas fa-check"></i> Setujui
                                                        </a>
                                                        <a href="<?= base_url('admin/forum_alumni/reject/' . $p['id']) ?>" class="btn-reject" onclick="showActionConfirm('<?= base_url('admin/forum_alumni/reject/' . $p['id']) ?>', 'Tolak Postingan', 'Apakah Anda yakin ingin menolak postingan ini?', 'reject', event)">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- APPROVED POSTS -->
                    <div class="tab-pane fade" id="approved" role="tabpanel">
                        <?php 
                        $a_posts = array_filter($posts, function($p) { return $p['status'] === 'approved'; });
                        if (empty($a_posts)): 
                        ?>
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <p>Belum ada postingan yang disetujui.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-stackable">
                                    <thead>
                                        <tr>
                                            <th width="60">#</th>
                                            <th width="200">Pengirim</th>
                                            <th>Konten Postingan</th>
                                            <th width="150">Lampiran Media</th>
                                            <th width="180">Waktu Kirim</th>
                                            <th width="150" style="text-align:center;">Komentar</th>
                                            <th width="120" style="text-align:center;">Status</th>
                                            <th width="100" style="text-align:center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($a_posts as $p): ?>
                                            <tr>
                                                <td data-label="No"><?= $no++ ?></td>
                                                <td data-label="Pengirim">
                                                    <strong><?= htmlspecialchars($p['nama']) ?></strong>
                                                    <br><small class="text-muted"><?= htmlspecialchars(ucfirst($p['role'])) ?></small>
                                                </td>
                                                <td data-label="Konten">
                                                    <div style="max-height:100px; overflow-y:auto; font-size:0.88rem; white-space:pre-wrap; line-height:1.4; color:#334155;"><?= htmlspecialchars($p['content']) ?></div>
                                                </td>
                                                <td data-label="Media">
                                                    <?php if ($p['image']): ?>
                                                        <img src="<?= base_url('uploads/forum_posts/' . $p['image']) ?>" class="media-preview" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('image', '<?= base_url('uploads/forum_posts/' . $p['image']) ?>')">
                                                    <?php elseif ($p['video']): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('video', '<?= base_url('uploads/forum_posts/' . $p['video']) ?>')" style="font-size:0.75rem; border-radius:6px;">
                                                            <i class="fas fa-video me-1"></i> Lihat Video
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size:0.8rem;">Tidak ada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="Waktu"><small><?= date('d M Y H:i', strtotime($p['created_at'])) ?></small></td>
                                                <td data-label="Komentar" style="text-align:center;">
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-view-comments" data-post-id="<?= $p['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalComments" style="font-size:0.75rem; border-radius:8px; font-weight:600; padding: 5px 10px;">
                                                        <i class="fas fa-comments me-1"></i> <?= $p['comments_count'] ?> Komentar
                                                    </button>
                                                </td>
                                                <td data-label="Status" style="text-align:center;">
                                                    <span class="badge-status status-approved">Disetujui</span>
                                                </td>
                                                <td data-label="Aksi" style="text-align:center;">
                                                    <a href="<?= base_url('admin/forum_alumni/delete/' . $p['id']) ?>" class="btn-reject" onclick="showActionConfirm('<?= base_url('admin/forum_alumni/delete/' . $p['id']) ?>', 'Hapus Postingan', 'Apakah Anda yakin ingin menghapus postingan ini secara permanen beserta seluruh komentar & berkas media?', 'delete', event)">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- REJECTED POSTS -->
                    <div class="tab-pane fade" id="rejected" role="tabpanel">
                        <?php 
                        $r_posts = array_filter($posts, function($p) { return $p['status'] === 'rejected'; });
                        if (empty($r_posts)): 
                        ?>
                            <div class="empty-state">
                                <i class="fas fa-ban"></i>
                                <p>Tidak ada postingan yang ditolak.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-stackable">
                                    <thead>
                                        <tr>
                                            <th width="60">#</th>
                                            <th width="200">Pengirim</th>
                                            <th>Konten Postingan</th>
                                            <th width="150">Lampiran Media</th>
                                            <th width="180">Waktu Kirim</th>
                                            <th width="150" style="text-align:center;">Komentar</th>
                                            <th width="120" style="text-align:center;">Status</th>
                                            <th width="100" style="text-align:center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($r_posts as $p): ?>
                                            <tr>
                                                <td data-label="No"><?= $no++ ?></td>
                                                <td data-label="Pengirim">
                                                    <strong><?= htmlspecialchars($p['nama']) ?></strong>
                                                    <br><small class="text-muted"><?= htmlspecialchars(ucfirst($p['role'])) ?></small>
                                                </td>
                                                <td data-label="Konten">
                                                    <div style="max-height:100px; overflow-y:auto; font-size:0.88rem; white-space:pre-wrap; line-height:1.4; color:#334155;"><?= htmlspecialchars($p['content']) ?></div>
                                                </td>
                                                <td data-label="Media">
                                                    <?php if ($p['image']): ?>
                                                        <img src="<?= base_url('uploads/forum_posts/' . $p['image']) ?>" class="media-preview" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('image', '<?= base_url('uploads/forum_posts/' . $p['image']) ?>')">
                                                    <?php elseif ($p['video']): ?>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalPreviewMedia" onclick="previewMedia('video', '<?= base_url('uploads/forum_posts/' . $p['video']) ?>')" style="font-size:0.75rem; border-radius:6px;">
                                                            <i class="fas fa-video me-1"></i> Lihat Video
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size:0.8rem;">Tidak ada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="Waktu"><small><?= date('d M Y H:i', strtotime($p['created_at'])) ?></small></td>
                                                <td data-label="Komentar" style="text-align:center;">
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-view-comments" data-post-id="<?= $p['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalComments" style="font-size:0.75rem; border-radius:8px; font-weight:600; padding: 5px 10px;">
                                                        <i class="fas fa-comments me-1"></i> <?= $p['comments_count'] ?> Komentar
                                                    </button>
                                                </td>
                                                <td data-label="Status" style="text-align:center;">
                                                    <span class="badge-status status-rejected">Ditolak</span>
                                                </td>
                                                <td data-label="Aksi" style="text-align:center;">
                                                    <a href="<?= base_url('admin/forum_alumni/delete/' . $p['id']) ?>" class="btn-reject" onclick="showActionConfirm('<?= base_url('admin/forum_alumni/delete/' . $p['id']) ?>', 'Hapus Postingan', 'Apakah Anda yakin ingin menghapus postingan ini secara permanen beserta seluruh komentar & berkas media?', 'delete', event)">
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <!-- Modal Preview Media -->
    <div class="modal fade" id="modalPreviewMedia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; background: #000; position: relative;">
                <button type="button" class="btn-close-circle" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
                <div class="modal-body p-0 d-flex justify-content-center align-items-center" style="min-height: 300px; background: #000;">
                    <div id="mediaPreviewContent" class="w-100 text-center">
                        <!-- Dinamis via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Umum -->
    <div class="modal fade" id="modalConfirmAction" tabindex="-1" aria-hidden="true" style="z-index: 1080;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i id="confirmIcon" class="fas fa-exclamation-circle text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 id="confirmTitle" class="font-weight-bold mb-2" style="color: #2C3E50;">Konfirmasi</h5>
                    <p id="confirmMessage" class="text-muted mb-4" style="font-size: 0.9rem;">Apakah Anda yakin ingin melakukan tindakan ini?</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">Batal</button>
                        <a id="confirmBtnYes" href="#" class="btn btn-primary px-4" style="border-radius: 10px; font-weight: 600;">Ya, Lanjutkan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Komentar -->
    <div class="modal fade" id="modalComments" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-weight-bold" style="color: #2C3E50;">Moderasi Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="commentsLoading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="commentsContainer" class="d-none">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Pengirim</th>
                                        <th>Komentar</th>
                                        <th width="120" style="text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="commentsList">
                                    <!-- Dinamis via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Ikatan Alumni -->
    <div class="modal fade" id="modalEditIkatanAlumni" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <form action="<?= base_url('admin/edit_ikatan_alumni') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title font-weight-bold" style="color: #2C3E50;">
                            <i class="fas fa-edit text-warning me-2"></i> Edit Informasi & Ketua Ikatan Alumni
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label font-weight-bold text-secondary">Nama Organisasi</label>
                                <input type="text" name="nama_organisasi" class="form-control" value="<?= htmlspecialchars($ikatan_alumni['nama_organisasi'] ?? 'Ikatan Alumni Fakultas Industri Kreatif') ?>" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label font-weight-bold text-secondary">Singkatan / Label</label>
                                <input type="text" name="singkatan" class="form-control" value="<?= htmlspecialchars($ikatan_alumni['singkatan'] ?? 'IKA FIK Telkom University') ?>" style="border-radius: 8px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-secondary">Upload Logo Ikatan Alumni</label>
                                <div class="admin-drop-zone" id="logoDropZone" onclick="document.getElementById('logoInput').click()">
                                    <input type="file" name="logo" id="logoInput" accept="image/*" class="d-none" onchange="handlePreview(this, 'logoPreview', 'logoFileName')">
                                    <div id="logoPreviewContainer">
                                        <?php if (!empty($ikatan_alumni['logo'])): ?>
                                            <img src="<?= base_url($ikatan_alumni['logo']) ?>" id="logoPreview" class="img-preview-box">
                                        <?php else: ?>
                                            <img id="logoPreview" class="img-preview-box d-none">
                                            <i class="fas fa-cloud-upload-alt drop-icon" id="logoDefaultIcon"></i>
                                        <?php endif; ?>
                                    </div>
                                    <p class="drop-text" id="logoFileName"><strong>Tarik & lepas Logo</strong> atau <u>Pilih Berkas</u></p>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">PNG, JPG, WEBP (Kosongkan jika tak diubah)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-secondary">Upload Foto Ketua Ikatan Alumni</label>
                                <div class="admin-drop-zone" id="fotoKetuaDropZone" onclick="document.getElementById('fotoKetuaInput').click()">
                                    <input type="file" name="foto_ketua" id="fotoKetuaInput" accept="image/*" class="d-none" onchange="handlePreview(this, 'fotoKetuaPreview', 'fotoKetuaFileName')">
                                    <div id="fotoKetuaPreviewContainer">
                                        <?php if (!empty($ikatan_alumni['foto_ketua'])): ?>
                                            <img src="<?= base_url($ikatan_alumni['foto_ketua']) ?>" id="fotoKetuaPreview" class="img-preview-box">
                                        <?php else: ?>
                                            <img id="fotoKetuaPreview" class="img-preview-box d-none">
                                            <i class="fas fa-user-circle drop-icon" id="fotoKetuaDefaultIcon"></i>
                                        <?php endif; ?>
                                    </div>
                                    <p class="drop-text" id="fotoKetuaFileName"><strong>Tarik & lepas Foto Ketua</strong> atau <u>Pilih Berkas</u></p>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">PNG, JPG, WEBP (Kosongkan jika tak diubah)</small>
                                </div>
                            </div>

                            <hr class="my-2" style="opacity: 0.1;">

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-secondary">Nama Ketua Sekarang</label>
                                <input type="text" name="nama_ketua" class="form-control" value="<?= htmlspecialchars($ikatan_alumni['nama_ketua'] ?? '') ?>" placeholder="Misal: Ahmad Rizky Pratama, S.Des." style="border-radius: 8px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label font-weight-bold text-secondary">Periode Jabatan</label>
                                <input type="text" name="periode_ketua" class="form-control" value="<?= htmlspecialchars($ikatan_alumni['periode_ketua'] ?? '') ?>" placeholder="Misal: Periode 2024 - 2028" style="border-radius: 8px;">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-secondary">Jabatan / Gelar Ketua</label>
                                <input type="text" name="jabatan_ketua" class="form-control" value="<?= htmlspecialchars($ikatan_alumni['jabatan_ketua'] ?? 'Ketua Ikatan Alumni FIK') ?>" style="border-radius: 8px;">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label font-weight-bold text-secondary">Deskripsi / Sambutan Ringkas</label>
                                <textarea name="sambutan_ketua" class="form-control" rows="3" style="border-radius: 8px; resize: vertical;"><?= htmlspecialchars($ikatan_alumni['sambutan_ketua'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                        <button type="submit" class="btn btn-warning text-white font-weight-bold" style="border-radius: 8px;"><i class="fas fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            }
        }

        document.querySelectorAll('.btn-view-comments').forEach(btn => {
            btn.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const listContainer = document.getElementById('commentsList');
                const loading = document.getElementById('commentsLoading');
                const tableContainer = document.getElementById('commentsContainer');
                
                loading.classList.remove('d-none');
                tableContainer.classList.add('d-none');
                listContainer.innerHTML = '';
                
                fetch('<?= base_url('admin/forum_alumni/comments/') ?>' + postId)
                    .then(res => res.json())
                    .then(data => {
                        loading.classList.add('d-none');
                        tableContainer.classList.remove('d-none');
                        
                        if (data.length === 0) {
                            listContainer.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4">Belum ada komentar pada postingan ini.</td></tr>';
                        } else {
                            data.forEach(c => {
                                const dateStr = new Date(c.created_at).toLocaleString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'});
                                listContainer.innerHTML += `
                                    <tr>
                                        <td>
                                            <strong>${escapeHtml(c.nama)}</strong>
                                            <br><small class="text-muted">${escapeHtml(c.role)}</small>
                                        </td>
                                        <td>
                                            <div style="font-size:0.88rem; white-space:pre-wrap; line-height:1.4; color:#334155;">${escapeHtml(c.comment)}</div>
                                            <small class="text-muted" style="font-size:0.75rem;">${dateStr}</small>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="<?= base_url('admin/forum_alumni/delete_comment/') ?>${c.id}" class="btn-reject" onclick="showActionConfirm('<?= base_url('admin/forum_alumni/delete_comment/') ?>${c.id}', 'Hapus Komentar', 'Apakah Anda yakin ingin menghapus komentar ini?', 'delete', event)">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            });
                        }
                    })
                    .catch(err => {
                        loading.classList.add('d-none');
                        listContainer.innerHTML = '<tr><td colspan="3" class="text-center text-danger py-4">Gagal memuat komentar.</td></tr>';
                    });
            });
        });
        
        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function previewMedia(type, url) {
            const container = document.getElementById('mediaPreviewContent');
            container.innerHTML = '';
            if (type === 'image') {
                container.innerHTML = `<img src="${url}" class="img-fluid" style="max-height:80vh; max-width:100%; object-fit:contain;">`;
            } else if (type === 'video') {
                container.innerHTML = `<video src="${url}" controls class="w-100" style="max-height:80vh;" autoplay></video>`;
            }
            
            // Stop video playing when modal is hidden
            const modal = document.getElementById('modalPreviewMedia');
            modal.addEventListener('hidden.bs.modal', function () {
                container.innerHTML = '';
            }, { once: true });
        }

        function showActionConfirm(url, title, message, type, event) {
            if (event) event.preventDefault();
            
            const modalEl = document.getElementById('modalConfirmAction');
            const confirmIcon = document.getElementById('confirmIcon');
            const confirmTitle = document.getElementById('confirmTitle');
            const confirmMessage = document.getElementById('confirmMessage');
            const confirmBtnYes = document.getElementById('confirmBtnYes');
            
            // Set content
            confirmTitle.textContent = title;
            confirmMessage.textContent = message;
            confirmBtnYes.setAttribute('href', url);
            
            // Set styles based on type
            confirmIcon.className = 'fas';
            if (type === 'approve') {
                confirmIcon.classList.add('fa-check-circle', 'text-success');
                confirmBtnYes.className = 'btn btn-success px-4';
                confirmBtnYes.textContent = 'Ya, Setujui';
            } else if (type === 'reject') {
                confirmIcon.classList.add('fa-times-circle', 'text-danger');
                confirmBtnYes.className = 'btn btn-danger px-4';
                confirmBtnYes.textContent = 'Ya, Tolak';
            } else if (type === 'delete') {
                confirmIcon.classList.add('fa-trash-alt', 'text-danger');
                confirmBtnYes.className = 'btn btn-danger px-4';
                confirmBtnYes.textContent = 'Ya, Hapus';
            } else {
                confirmIcon.classList.add('fa-exclamation-circle', 'text-warning');
                confirmBtnYes.className = 'btn btn-primary px-4';
                confirmBtnYes.textContent = 'Ya, Lanjutkan';
            }
            
            // Trigger bootstrap modal
            const confirmModal = new bootstrap.Modal(modalEl);
            confirmModal.show();
        }

        // Preview & Drag-and-Drop for Admin Modal
        function handlePreview(input, previewId, labelId) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgEl = document.getElementById(previewId);
                    imgEl.src = e.target.result;
                    imgEl.classList.remove('d-none');
                    
                    const container = imgEl.parentElement;
                    const icon = container.querySelector('.drop-icon');
                    if (icon) icon.classList.add('d-none');
                    
                    document.getElementById(labelId).innerHTML = '<span class="text-success font-weight-bold"><i class="fas fa-check-circle me-1"></i>' + escapeHtml(file.name) + '</span>';
                };
                reader.readAsDataURL(file);
            }
        }

        function setupDragDrop(zoneId, inputId, previewId, labelId) {
            const zone = document.getElementById(zoneId);
            const input = document.getElementById(inputId);
            if (!zone || !input) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                zone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.add('dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                zone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.remove('dragover');
                }, false);
            });

            zone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    input.files = files;
                    handlePreview(input, previewId, labelId);
                }
            }, false);
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupDragDrop('logoDropZone', 'logoInput', 'logoPreview', 'logoFileName');
            setupDragDrop('fotoKetuaDropZone', 'fotoKetuaInput', 'fotoKetuaPreview', 'fotoKetuaFileName');
        });
    </script>
</body>
</html>
