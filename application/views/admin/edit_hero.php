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
        body { font-family: 'Montserrat', sans-serif; background-color: #f8f9fa; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar { width: 280px; background: linear-gradient(135deg, #2C3E50, #1a2632); color: white; position: fixed; height: 100vh; overflow-y: auto; }
        .sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu { padding: 1.5rem 0; }
        .sidebar-menu a { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem; color: rgba(255,255,255,0.8); text-decoration: none; border-left: 3px solid transparent; transition: 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(230, 126, 34, 0.2); color: white; border-left-color: #E67E22; }
        .sidebar-menu a i { width: 20px; color: #E67E22; }
        .admin-main { flex: 1; margin-left: 280px; padding: 2rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #eee; }
        .table-card { background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .form-control { border-radius: 10px; padding: 0.7rem 1rem; }
        .form-control:focus { border-color: #E67E22; box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1); }
        .btn-simpan { background: #E67E22; color: white; padding: 0.7rem 2rem; border-radius: 10px; border: none; font-weight: 600; }
        .btn-simpan:hover { background: #d35400; color: white;}
        .section-divider { margin: 2.5rem 0 1.5rem; padding-top: 1.5rem; border-top: 2px dashed #eee; }
        .section-divider:first-of-type { border-top: none; padding-top: 0; margin-top: 0; }

        /* ===== Drag & Drop Upload ===== */
        .upload-dropzone {
            position: relative;
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: 0.25s;
            background: #fafafa;
        }
        .upload-dropzone:hover {
            border-color: #E67E22;
            background: rgba(230, 126, 34, 0.05);
        }
        .upload-dropzone.dragover {
            border-color: #E67E22;
            background: rgba(230, 126, 34, 0.1);
            transform: scale(1.01);
        }
        .upload-dropzone.has-file {
            border-style: solid;
            border-color: #2ecc71;
            background: rgba(46, 204, 113, 0.05);
        }
        .dropzone-content i {
            color: #E67E22;
        }
        .dropzone-content p {
            margin: 0;
            color: #555;
        }
        .dropzone-filename {
            font-weight: 600;
            color: #2C3E50;
            margin-top: 0.5rem;
            word-break: break-all;
        }
        .dropzone-remove {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.75rem;
            line-height: 24px;
            display: none;
        }
        .upload-dropzone.has-file .dropzone-remove {
            display: block;
        }

        /* === MOBILE RESPONSIVE === */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            overflow-x: hidden;
            max-width: 100%;
        }

        .mobile-topbar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1100;
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 54px;
            padding: 0 0.75rem;
            gap: 0.5rem;
        }

        .hamburger-btn {
            display: none;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: none;
            border-radius: 8px;
            width: 38px;
            height: 38px;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .hamburger-btn:hover {
            background: rgba(230, 126, 34, 0.6);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
            min-width: 0;
            justify-content: flex-end;
        }

        .topbar-username {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.78rem;
            font-weight: 500;
            flex: 1;
            min-width: 0;
        }

        .topbar-username i {
            color: #E67E22;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .topbar-username .name-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: block;
            min-width: 0;
        }

        .topbar-logout {
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.38rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            white-space: nowrap;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .topbar-logout:hover {
            background: #c0392b;
            color: white;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .mobile-topbar {
                display: block;
            }

            .hamburger-btn {
                display: flex;
            }

            .admin-sidebar {
                position: fixed !important;
                left: -280px !important;
                z-index: 1000;
                transition: left 0.3s ease;
                width: 280px !important;
                display: block !important;
            }

            .admin-sidebar.open {
                left: 0 !important;
            }

            .admin-main {
                margin-left: 0 !important;
                padding: 1rem !important;
                padding-top: 4.5rem !important;
                max-width: 100vw;
                overflow-x: hidden;
            }

            .admin-header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .admin-header h1 {
                font-size: 1.3rem !important;
                word-break: break-word;
            }

            .admin-header .user-info>span,
            .admin-header .user-info .logout-btn {
                display: none;
            }

            .admin-header .user-info {
                width: 100%;
                justify-content: stretch;
            }

            .admin-header .user-info .btn {
                flex: 0 0 100%;
                text-align: center;
                padding: 0.65rem 1rem;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Topbar -->
    <div class="mobile-topbar" id="mobileTopbar">
        <div class="topbar-inner">
            <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <i class="fas fa-bars" id="hamburgerIcon"></i>
            </button>
            <div class="topbar-right">
                <span class="topbar-username">
                    <i class="fas fa-user-circle"></i>
                    <span class="name-text"><?= $nama_user ?? $this->session->userdata('nama') ?></span>
                </span>
                <a href="<?= base_url('login/logout') ?>" class="topbar-logout">
                    <i class="fas fa-sign-out-alt"></i>Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-wrapper">
        <div class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <h3>Admin FIK</h3>
                <p>Manajemen Dashboard</p>
            </div>

            <div class="sidebar-menu">
                <a href="<?= base_url('admin/edit_hero') ?>" class="<?= ($this->uri->segment(2) == 'edit_hero') ? 'active' : '' ?>">
                    <i class="fas fa-desktop"></i>
                    <span>Dashboard</span>
                </a>

                <a href="<?= base_url('admin/proposal') ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>

                <a href="<?= base_url('admin/beasiswa') ?>">
                    <i class="fas fa-graduation-cap"></i><span>Beasiswa</span>
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

                <a href="<?= base_url('admin/tentang_kami') ?>" >
                    <i class="fas fa-info-circle"></i><span>Tentang Kami</span>
                </a>

                <div class="menu-divider"></div>

                <a href="<?= base_url('admin/forum_alumni') ?>">
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

                <a href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>

        <div class="admin-main">
            <div class="admin-header">
                <h1>Edit Tampilan Hero</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $nama_user ?? $this->session->userdata('nama') ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn btn btn-danger rounded-pill" style="display: none;">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?></div>
            <?php endif; ?>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?></div>
            <?php endif; ?>

            <div class="table-card">
                <form action="<?= base_url('admin/edit_hero') ?>" method="POST" enctype="multipart/form-data">
                    <!-- ==================== 0. LOGO NAVBAR ==================== -->
                    <div class="section-divider" style="border-top:none;padding-top:0;margin-top:0;">
                        <h5 class="mb-4 text-primary"><i class="fas fa-tag me-2"></i> 0. Logo Navbar (Pojok Kiri Atas)</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Upload Logo Baru (.png, .jpg, .jpeg)</label>

                                <div class="upload-dropzone" id="logoDropZone">
                                    <button type="button" class="dropzone-remove" id="logoDropZoneRemove" title="Hapus file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="file" class="d-none" name="nav_logo" id="logoUploadInput" accept=".png,.jpg,.jpeg">
                                    <div class="dropzone-content" id="logoDropZoneContent">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block"></i>
                                        <p>Tarik & lepas logo di sini</p>
                                        <p class="small">atau <span class="text-primary text-decoration-underline">klik untuk memilih file</span></p>
                                        <p class="dropzone-filename" id="logoDropZoneFilename"></p>
                                    </div>
                                </div>

                                <small class="text-muted">Logo ini akan tampil di navbar bagian kiri atas.</small>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Preview:</label><br>
                                <img id="logoPreviewImg"
                                    src="<?= base_url('assets/' . ($current_text['nav_logo'] ?? 'logo-fik.jpeg')) . '?v=' . time() ?>"
                                    alt="Preview Logo"
                                    style="height: 80px; width:80px; background:#eee; border-radius:10px; padding:8px; object-fit:contain;">
                            </div>
                        </div>
                    </div>

                    <!-- ==================== 1. GAMBAR HERO ==================== -->
                    <div class="section-divider">
                        <h5 class="mb-4 text-primary"><i class="fas fa-image me-2"></i> 1. Gambar Mahasiswa (Hero)</h5>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label class="form-label">Upload Gambar Baru (.png saja)</label>

                                <div class="upload-dropzone" id="dropZone">
                                    <button type="button" class="dropzone-remove" id="dropZoneRemove" title="Hapus file">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="file" class="d-none" name="hero_image" id="uploadInput" accept=".png">
                                    <div class="dropzone-content" id="dropZoneContent">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block"></i>
                                        <p>Tarik & lepas gambar di sini</p>
                                        <p class="small">atau <span class="text-primary text-decoration-underline">klik untuk memilih file</span></p>
                                        <p class="dropzone-filename" id="dropZoneFilename"></p>
                                    </div>
                                </div>

                                <small class="text-muted">Pastikan gambar berformat PNG transparan.</small>
                            </div>
                            <div class="col-md-6 mt-3 mt-md-0">
                                <label class="form-label">Preview:</label><br>
                                <img id="previewImg" src="<?= base_url('assets/mahasiswa.png') . '?v=' . time() ?>" 
                                    alt="Preview" style="height: 150px; background: #eee; border-radius: 10px; padding: 10px; object-fit: contain;">
                            </div>
                        </div>
                    </div>

                    <!-- ==================== 2. JUDUL SAMPING GAMBAR ==================== -->
                    <div class="section-divider">
                        <h5 class="mb-4 text-primary"><i class="fas fa-heading me-2"></i> 2. Judul Samping Gambar</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Baris 1</label>
                                <input type="text" class="form-control" name="hero_title_line1" value="<?= htmlspecialchars($current_text['hero_title_line1'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Baris 2</label>
                                <input type="text" class="form-control" name="hero_title_line2" value="<?= htmlspecialchars($current_text['hero_title_line2'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== 3. FLOATING CARDS ==================== -->
                    <div class="section-divider">
                        <h5 class="mb-4 text-primary"><i class="fas fa-comment-alt me-2"></i> 3. Teks Floating Cards</h5>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-certificate text-warning"></i> Card 1</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Teks Tebal (Title)</label>
                                        <input type="text" class="form-control" name="card1_title" value="<?= htmlspecialchars($current_text['card1_title'] ?? '') ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label small">Teks Bawah (Subtitle)</label>
                                        <input type="text" class="form-control" name="card1_sub" value="<?= htmlspecialchars($current_text['card1_sub'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-users text-warning"></i> Card 2</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Teks Tebal (Title)</label>
                                        <input type="text" class="form-control" name="card2_title" value="<?= htmlspecialchars($current_text['card2_title'] ?? '') ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label small">Teks Bawah (Subtitle)</label>
                                        <input type="text" class="form-control" name="card2_sub" value="<?= htmlspecialchars($current_text['card2_sub'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-chalkboard text-warning"></i> Card 3</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Teks Tebal (Title)</label>
                                        <input type="text" class="form-control" name="card3_title" value="<?= htmlspecialchars($current_text['card3_title'] ?? '') ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label small">Teks Bawah (Subtitle)</label>
                                        <input type="text" class="form-control" name="card3_sub" value="<?= htmlspecialchars($current_text['card3_sub'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-lightbulb text-warning"></i> Card 4</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Teks Tebal (Title)</label>
                                        <input type="text" class="form-control" name="card4_title" value="<?= htmlspecialchars($current_text['card4_title'] ?? '') ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label small">Teks Bawah (Subtitle)</label>
                                        <input type="text" class="form-control" name="card4_sub" value="<?= htmlspecialchars($current_text['card4_sub'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-3 border rounded">
                                    <h6><i class="fas fa-rocket text-warning"></i> Card 5</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Teks Tebal (Title)</label>
                                        <input type="text" class="form-control" name="card5_title" value="<?= htmlspecialchars($current_text['card5_title'] ?? '') ?>" required>
                                    </div>
                                    <div>
                                        <label class="form-label small">Teks Bawah (Subtitle)</label>
                                        <input type="text" class="form-control" name="card5_sub" value="<?= htmlspecialchars($current_text['card5_sub'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ==================== 4. ACHIEVEMENT CARD (Mahasiswa Berprestasi) ====================
                    <div class="section-divider">
                        <h5 class="mb-4 text-primary"><i class="fas fa-trophy me-2"></i> 4. Kartu Prestasi (Achievement)</h5>

                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label class="form-label small">Judul Kartu</label>
                                <input type="text" class="form-control" name="achievement_title" value="<?= htmlspecialchars($current_text['achievement_title'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Jumlah Mahasiswa Aktif (angka)</label>
                                <input type="number" class="form-control" name="active_students" value="<?= htmlspecialchars($current_text['active_students'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small">Deskripsi Mahasiswa Aktif (boleh pakai &lt;br&gt; untuk baris baru)</label>
                                <input type="text" class="form-control" name="active_students_desc" value="<?= htmlspecialchars($current_text['active_students_desc'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Jumlah Negara</label>
                                <input type="number" class="form-control" name="country_count" value="<?= htmlspecialchars($current_text['country_count'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small">Label Negara</label>
                                <input type="text" class="form-control" name="country_label" value="<?= htmlspecialchars($current_text['country_label'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small"><i class="fas fa-trophy text-warning"></i> Teks Prestasi 1</label>
                                <textarea class="form-control" name="winner1_text" rows="3" required><?= htmlspecialchars($current_text['winner1_text'] ?? '') ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small"><i class="fas fa-camera-retro text-warning"></i> Teks Prestasi 2</label>
                                <textarea class="form-control" name="winner2_text" rows="3" required><?= htmlspecialchars($current_text['winner2_text'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Jumlah Alumni</label>
                                <input type="number" class="form-control" name="alumni_count" value="<?= htmlspecialchars($current_text['alumni_count'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small">Label Alumni (boleh pakai &lt;br&gt;)</label>
                                <input type="text" class="form-control" name="alumni_label" value="<?= htmlspecialchars($current_text['alumni_label'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label small">TelU Daerah (angka)</label>
                                <input type="number" class="form-control" name="telu_daerah" value="<?= htmlspecialchars($current_text['telu_daerah'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Label</label>
                                <input type="text" class="form-control" name="telu_daerah_label" value="<?= htmlspecialchars($current_text['telu_daerah_label'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">TelU Luar Negeri (angka)</label>
                                <input type="number" class="form-control" name="telu_luar" value="<?= htmlspecialchars($current_text['telu_luar'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small">Label</label>
                                <input type="text" class="form-control" name="telu_luar_label" value="<?= htmlspecialchars($current_text['telu_luar_label'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                     -->

                    <div class="text-end mt-4">
                        <button type="submit" class="btn-simpan"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const icon = document.getElementById('hamburgerIcon');
        
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
        
        if (sidebar.classList.contains('open')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    }

    const uploadInput = document.getElementById('uploadInput');
    const previewImg = document.getElementById('previewImg');
    const dropZone = document.getElementById('dropZone');
    const dropZoneFilename = document.getElementById('dropZoneFilename');
    const dropZoneRemove = document.getElementById('dropZoneRemove');

    const logoUploadInput = document.getElementById('logoUploadInput');
const logoPreviewImg = document.getElementById('logoPreviewImg');
const logoDropZone = document.getElementById('logoDropZone');
const logoDropZoneFilename = document.getElementById('logoDropZoneFilename');
const logoDropZoneRemove = document.getElementById('logoDropZoneRemove');
const logoDefaultSrc = logoPreviewImg.src;

logoDropZone.addEventListener('click', function(e) {
    if (e.target.closest('#logoDropZoneRemove')) return;
    logoUploadInput.click();
});

logoUploadInput.addEventListener('change', function() {
    handleLogoFiles(this.files);
});

['dragenter', 'dragover'].forEach(evt => {
    logoDropZone.addEventListener(evt, function(e) {
        e.preventDefault();
        e.stopPropagation();
        logoDropZone.classList.add('dragover');
    });
});

['dragleave', 'dragend'].forEach(evt => {
    logoDropZone.addEventListener(evt, function(e) {
        e.preventDefault();
        e.stopPropagation();
        logoDropZone.classList.remove('dragover');
    });
});

logoDropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    logoDropZone.classList.remove('dragover');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        logoUploadInput.files = files;
        handleLogoFiles(files);
    }
});

logoDropZoneRemove.addEventListener('click', function(e) {
    e.stopPropagation();
    logoUploadInput.value = '';
    logoDropZone.classList.remove('has-file');
    logoDropZoneFilename.textContent = '';
    logoPreviewImg.src = logoDefaultSrc;
});

function handleLogoFiles(files) {
    const file = files[0];
    if (!file) return;

    if (!file.type.match('image/(png|jpe?g)')) {
        alert('Harap pilih file berformat PNG, JPG, atau JPEG');
        logoUploadInput.value = '';
        logoDropZone.classList.remove('has-file');
        logoDropZoneFilename.textContent = '';
        return;
    }

    logoDropZone.classList.add('has-file');
    logoDropZoneFilename.textContent = file.name;

    const reader = new FileReader();
    reader.onload = function(e) {
        logoPreviewImg.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

    // Klik area dropzone (kecuali tombol hapus) akan membuka file dialog
    dropZone.addEventListener('click', function(e) {
        if (e.target.closest('#dropZoneRemove')) return;
        uploadInput.click();
    });

    // Saat file dipilih lewat dialog biasa
    uploadInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    // Highlight saat file diseret di atas dropzone
    ['dragenter', 'dragover'].forEach(evt => {
        dropZone.addEventListener(evt, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('dragover');
        });
    });

    ['dragleave', 'dragend'].forEach(evt => {
        dropZone.addEventListener(evt, function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('dragover');
        });
    });

    // Saat file dilepas (drop)
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            // Masukkan file hasil drop ke input asli agar ikut ter-submit form
            uploadInput.files = files;
            handleFiles(files);
        }
    });

    // Hapus file yang sudah dipilih
    dropZoneRemove.addEventListener('click', function(e) {
        e.stopPropagation();
        uploadInput.value = '';
        dropZone.classList.remove('has-file');
        dropZoneFilename.textContent = '';
        previewImg.src = "<?= base_url('assets/mahasiswa.png') . '?v=' . time() ?>";
    });

    function handleFiles(files) {
        const file = files[0];
        if (!file) return;

        // Validasi tipe file: hanya PNG
        if (!file.type.match('image/png')) {
            alert('Harap pilih file berformat PNG');
            uploadInput.value = '';
            dropZone.classList.remove('has-file');
            dropZoneFilename.textContent = '';
            return;
        }

        dropZone.classList.add('has-file');
        dropZoneFilename.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
</script>
</body>
</html>
