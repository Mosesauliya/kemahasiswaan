<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Admin Kemahasiswaan</title>
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

        /* Card and Table */
        .logs-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            padding: 2rem;
        }

        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 380px;
        }

        .table th {
            background: #2C3E50;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            border: none;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: #2C3E50;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }

        .badge-role {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .role-admin { background: #e11d48; color: white; }
        .role-mahasiswa { background: #0284c7; color: white; }
        .role-dosen { background: #059669; color: white; }
        .role-kemahasiswaan { background: #d97706; color: white; }
        .top-grids {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .panel-card {
            background: white;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .panel-card h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .panel-card h4 i { color: #E67E22; }

        .btn-custom {
            background: #E67E22;
            color: white;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .btn-custom:hover { background: #d35400; color: white; }

        .file-dropzone {
            border: 2px dashed #e0dbd4;
            border-radius: 10px;
            padding: 1.2rem;
            text-align: center;
            background: #faf8f5;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        .file-dropzone:hover { border-color: #E67E22; background: #fffdfa; }
        .file-dropzone i { font-size: 1.8rem; color: #ccc; margin-bottom: 0.5rem; }
        .file-dropzone span { display: block; font-size: 0.78rem; color: #888; }
        .file-dropzone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

        .btn-delete-item {
            background: rgba(231,76,60,0.1);
            color: #e74c3c;
            border: none;
            border-radius: 6px;
            padding: 0.35rem 0.7rem;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-delete-item:hover { background: #e74c3c; color: white; }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
                <p>Kemahasiswaan FIK</p>
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
                
                <a href="<?= base_url('admin/history_log') ?>" class="active">
                    <i class="fas fa-history"></i>
                    <span>History Log</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-home"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="admin-header">
                <h1>History Log & Whitelist Email</h1>
                <div class="user-info">
                    <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i><?= $nama_user ?? 'Admin' ?></span>
                    <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:10px; margin-bottom:1.5rem;">
                    <i class="fas fa-check-circle me-2"></i><?= $this->session->flashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:10px; margin-bottom:1.5rem;">
                    <i class="fas fa-exclamation-circle me-2"></i><?= $this->session->flashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- SSO Whitelist Management (Manual Input Only) -->
            <div class="mb-4">
                <!-- Manual Add -->
                <div class="panel-card">
                    <h4><i class="fas fa-plus"></i> Whitelist Email Microsoft</h4>
                    <form action="<?= base_url('admin/history_log/tambah_sso') ?>" method="POST">
                        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>
                        <div class="row align-items-end">
                            <div class="col-md-9 mb-3 mb-md-0">
                                <label class="form-label" style="font-size:0.8rem; font-weight:600; color:#555;">Email Microsoft Telkom U</label>
                                <input type="email" name="email" class="form-control" placeholder="example@telkomuniversity.ac.id" style="border-radius:8px; font-size:0.85rem;" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn-custom w-100">
                                    <i class="fas fa-save me-1"></i> Whitelist Email
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Whitelisted Emails List -->
            <div class="logs-card mb-4">
                <h3 class="mb-3" style="font-size:1.1rem; font-weight:700; color:#2C3E50;"><i class="fas fa-key me-2 text-warning"></i>Daftar Email Whitelist Microsoft</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Email Microsoft</th>
                                <th>Tanggal Ditambahkan</th>
                                <th width="120" style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($whitelist)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3 text-muted">Belum ada email yang di-whitelist. Silakan import atau tambah manual.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($whitelist as $w): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div style="display:inline-flex; gap:1.5px; vertical-align:middle; margin-right:6px;">
                                            <span style="width:5px; height:5px; background:#f35325; display:inline-block;"></span>
                                            <span style="width:5px; height:5px; background:#80a300; display:inline-block;"></span>
                                            <span style="width:5px; height:5px; background:#00a1f1; display:inline-block;"></span>
                                            <span style="width:5px; height:5px; background:#ffb900; display:inline-block;"></span>
                                        </div>
                                        <strong><?= htmlspecialchars($w->email) ?></strong>
                                    </td>
                                    <td><small><?= date('d M Y H:i', strtotime($w->created_at)) ?></small></td>
                                    <td style="text-align:center;">
                                        <a href="<?= base_url('admin/history_log/hapus_sso/' . $w->id) ?>" class="btn-delete-item" onclick="return confirm('Hapus email ini dari whitelist?')">
                                            <i class="fas fa-trash me-1"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- History Logs List (Original) -->
            <div class="logs-card">
                <h3 class="mb-3" style="font-size:1.1rem; font-weight:700; color:#2C3E50;"><i class="fas fa-history me-2 text-primary"></i>History Log Aktivitas</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Waktu</th>
                                <th>Nama Pengguna</th>
                                <th>Role</th>
                                <th>Aktivitas</th>
                                <th>IP Address</th>
                                <th>Browser / OS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($logs)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada history log aktivitas.</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach($logs as $log): ?>
                                    <?php 
                                        $role_class = 'role-default';
                                        if ($log->role == 'admin') $role_class = 'role-admin';
                                        elseif ($log->role == 'mahasiswa' || $log->role == 'alumni') $role_class = 'role-mahasiswa';
                                        elseif ($log->role == 'kemahasiswaan' || $log->role == 'kaprodi') $role_class = 'role-kemahasiswaan';
                                        elseif ($log->role == 'dosen_pembina') $role_class = 'role-dosen';
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><strong><?= date('d M Y H:i', strtotime($log->created_at)) ?></strong></td>
                                        <td><?= $log->nama ?: '<i>Unknown</i>' ?></td>
                                        <td><span class="badge-role <?= $role_class ?>"><?= strtoupper($log->role ?: 'GUEST') ?></span></td>
                                        <td><span class="text-success"><i class="fas fa-check-circle me-1"></i><?= $log->action ?></span></td>
                                        <td><code class="text-dark bg-light px-2 py-1 rounded"><?= $log->ip_address ?: '-' ?></code></td>
                                        <td><small class="text-muted"><?= htmlspecialchars($log->user_agent) ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
