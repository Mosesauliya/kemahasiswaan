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
        .sidebar-badge {
            margin-left: auto; background: #dc2626; color: #fff;
            font-size: .68rem; font-weight: 700; padding: .15rem .55rem;
            border-radius: 20px; min-width: 20px; text-align: center;
        }

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

        /* ── Stats ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 1.2rem; margin-bottom: 2rem; }
        .stat-card {
            background: white; border-radius: 14px; padding: 1.4rem;
            box-shadow: 0 4px 15px rgba(0,0,0,.06); display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon { width: 50px; height: 50px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
        .stat-icon.orange { background: rgba(230,126,34,.12); color: #E67E22; }
        .stat-icon.green  { background: rgba(39,174,96,.12);  color: #27ae60; }
        .stat-icon.red    { background: rgba(231,76,60,.12);  color: #e74c3c; }
        .stat-value { font-size: 1.8rem; font-weight: 700; color: #2C3E50; line-height: 1; }
        .stat-label { font-size: .78rem; color: #888; margin-top: .2rem; }

        /* ── Toolbar ── */
        .toolbar {
            background: white; border-radius: 14px; padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,.05);
            display: flex; flex-wrap: wrap; gap: .8rem; align-items: center;
        }
        .toolbar .search-box { position: relative; flex: 1; min-width: 200px; }
        .toolbar .search-box input {
            width: 100%; padding: .55rem 1rem .55rem 2.5rem; border: 1.5px solid #e0e0e0;
            border-radius: 10px; font-size: .88rem; font-family: inherit; transition: border .2s;
        }
        .toolbar .search-box input:focus { outline: none; border-color: #E67E22; }
        .toolbar .search-box i { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #aaa; }
        .toolbar select {
            padding: .55rem 1rem; border: 1.5px solid #e0e0e0; border-radius: 10px;
            font-size: .88rem; font-family: inherit; background: white; transition: border .2s;
        }
        .toolbar select:focus { outline: none; border-color: #E67E22; }
        .btn-primary-org {
            background: linear-gradient(135deg, #E67E22, #d35400); color: white; border: none;
            padding: .55rem 1.4rem; border-radius: 10px; font-weight: 600; font-size: .88rem;
            cursor: pointer; transition: all .25s; text-decoration: none; display: inline-flex;
            align-items: center; gap: .5rem;
        }
        .btn-primary-org:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(230,126,34,.4); color: white; }
        .btn-reset-org {
            background: #e8eaed; color: #555; border: none; padding: .55rem 1rem;
            border-radius: 10px; font-size: .88rem; cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: .4rem; transition: background .2s;
        }
        .btn-reset-org:hover { background: #dde; color: #333; }

        /* ── Alert ── */
        .alert-org {
            padding: .9rem 1.2rem; border-radius: 10px; margin-bottom: 1.2rem;
            font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .6rem;
        }
        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-error   { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }

        /* ── Table ── */
        .table-card {
            background: white; border-radius: 14px; overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);
        }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card thead { background: linear-gradient(135deg, #2C3E50, #1a2632); }
        .table-card thead th { color: rgba(255,255,255,.85); font-size: .8rem; font-weight: 600;
            padding: 1rem 1.2rem; text-transform: uppercase; letter-spacing: .05em; }
        .table-card tbody tr { border-bottom: 1px solid #f0f2f5; transition: background .15s; }
        .table-card tbody tr:last-child { border-bottom: none; }
        .table-card tbody tr:hover { background: #fafbfc; }
        .table-card tbody td { padding: .9rem 1.2rem; font-size: .88rem; color: #444; vertical-align: middle; }

        .org-logo-thumb {
            width: 50px; height: 50px; border-radius: 10px; object-fit: cover;
            border: 2px solid #f0f2f5;
        }
        .org-logo-placeholder {
            width: 50px; height: 50px; border-radius: 10px;
            background: linear-gradient(135deg, #f0f2f5, #e0e3e7);
            display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #aaa;
        }

        .badge-kategori {
            display: inline-block; padding: .28rem .75rem; border-radius: 20px;
            font-size: .75rem; font-weight: 600;
        }
        .badge-kat-seni    { background: #fff3cd; color: #856404; }
        .badge-kat-olahraga{ background: #d1ecf1; color: #0c5460; }
        .badge-kat-akademik{ background: #d4edda; color: #155724; }
        .badge-kat-sosial  { background: #f8d7da; color: #721c24; }
        .badge-kat-kerohanian{ background: #e2d9f3; color: #4a235a; }
        .badge-kat-kewirausahaan{ background: #fde8d8; color: #7d2b00; }
        .badge-kat-umum    { background: #e8eaed; color: #555; }

        .toggle-btn {
            width: 46px; height: 24px; border-radius: 12px; border: none; position: relative;
            cursor: pointer; transition: background .3s; flex-shrink: 0;
        }
        .toggle-btn.on  { background: #27ae60; }
        .toggle-btn.off { background: #bdc3c7; }
        .toggle-btn::after {
            content: ''; position: absolute; width: 18px; height: 18px; background: white;
            border-radius: 50%; top: 3px; transition: left .3s; box-shadow: 0 1px 4px rgba(0,0,0,.2);
        }
        .toggle-btn.on::after  { left: 25px; }
        .toggle-btn.off::after { left: 3px; }

        .action-btns { display: flex; gap: .5rem; }
        .btn-edit {
            background: rgba(52,152,219,.1); color: #2980b9; border: none; padding: .4rem .9rem;
            border-radius: 8px; font-size: .8rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: all .2s; display: inline-flex; align-items: center; gap: .35rem;
        }
        .btn-edit:hover { background: #2980b9; color: white; }
        .btn-del {
            background: rgba(231,76,60,.1); color: #e74c3c; border: none; padding: .4rem .9rem;
            border-radius: 8px; font-size: .8rem; font-weight: 600; cursor: pointer;
            transition: all .2s; display: inline-flex; align-items: center; gap: .35rem;
        }
        .btn-del:hover { background: #e74c3c; color: white; }

        .empty-state { text-align: center; padding: 4rem 2rem; color: #aaa; }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state p { font-size: .95rem; }

        /* ── Modal Hapus ── */
        .modal-backdrop-custom {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 1050; align-items: center; justify-content: center;
        }
        .modal-backdrop-custom.show { display: flex; }
        .modal-box {
            background: white; border-radius: 16px; padding: 2rem; max-width: 400px; width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,.25); animation: slideIn .25s ease;
        }
        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-box h5 { font-weight: 700; color: #2C3E50; margin-bottom: .5rem; }
        .modal-box p  { color: #666; font-size: .9rem; margin-bottom: 1.5rem; }
        .modal-actions { display: flex; gap: .8rem; justify-content: flex-end; }
        .btn-cancel { background: #e8eaed; color: #555; border: none; padding: .55rem 1.3rem; border-radius: 10px; cursor: pointer; font-weight: 600; }
        .btn-hapus  { background: #e74c3c; color: white; border: none; padding: .55rem 1.3rem; border-radius: 10px; cursor: pointer; font-weight: 600; }
        .btn-hapus:hover { background: #c0392b; }

        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; padding: 1rem; }
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
            <a href="<?= base_url('admin/organisasi') ?>" class="active">
                <i class="fas fa-users"></i>
                <span>Organisasi</span>
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
        </div>
    </div>

    <!-- Main Content -->
    <main class="admin-main">

        <!-- Header -->
        <div class="admin-header">
            <h1><i class="fas fa-users" style="color:#E67E22; font-size:1.4rem;"></i> Organisasi Kemahasiswaan</h1>
            <div class="user-info">
                <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert-org alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-org alert-error"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-layer-group"></i></div>
                <div>
                    <div class="stat-value"><?= $total ?></div>
                    <div class="stat-label">Total Organisasi</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="stat-value"><?= $total_aktif ?></div>
                    <div class="stat-label">Aktif / Tampil</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><i class="fas fa-eye-slash"></i></div>
                <div>
                    <div class="stat-value"><?= $total - $total_aktif ?></div>
                    <div class="stat-label">Nonaktif</div>
                </div>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="toolbar">
            <form method="GET" action="<?= base_url('admin/organisasi') ?>" style="display:contents;">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Cari nama atau deskripsi..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?= $kat ?>" <?= ($filter_kategori === $kat) ? 'selected' : '' ?>><?= $kat ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="aktif">
                    <option value="">Semua Status</option>
                    <option value="1" <?= ($filter_aktif === '1') ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= ($filter_aktif === '0') ? 'selected' : '' ?>>Nonaktif</option>
                </select>
                <button type="submit" class="btn-primary-org"><i class="fas fa-search"></i> Filter</button>
                <a href="<?= base_url('admin/organisasi') ?>" class="btn-reset-org"><i class="fas fa-times"></i> Reset</a>
            </form>
            <a href="<?= base_url('admin/organisasi_tambah') ?>" class="btn-primary-org" style="margin-left:auto;">
                <i class="fas fa-plus"></i> Tambah Organisasi
            </a>
        </div>

        <!-- Table -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th style="width:70px;">Logo</th>
                        <th>Nama Organisasi</th>
                        <th>Kategori</th>
                        <th style="width:60px;">Urutan</th>
                        <th style="width:80px; text-align:center;">Tampil</th>
                        <th style="width:150px; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($organisasi_list)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada organisasi<?= $search ? ' yang cocok dengan pencarian.' : '.' ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($organisasi_list as $org): ?>
                            <tr id="row-<?= $org->id ?>">
                                <td style="font-weight:600; color:#aaa;"><?= $no++ ?></td>
                                <td>
                                    <?php if ($org->logo): ?>
                                        <img src="<?= base_url($org->logo) ?>" alt="<?= htmlspecialchars($org->nama) ?>"
                                             class="org-logo-thumb"
                                             onerror="this.parentElement.innerHTML='<div class=\'org-logo-placeholder\'><i class=\'<?= htmlspecialchars($org->icon) ?>\'></i></div>'">
                                    <?php else: ?>
                                        <div class="org-logo-placeholder"><i class="<?= htmlspecialchars($org->icon) ?>"></i></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#2C3E50;"><?= htmlspecialchars($org->nama) ?></div>
                                    <div style="font-size:.78rem; color:#999; margin-top:.2rem;"><?= htmlspecialchars(substr($org->deskripsi ?? '', 0, 70)) ?><?= strlen($org->deskripsi ?? '') > 70 ? '…' : '' ?></div>
                                </td>
                                <td>
                                    <?php
                                        $kat_class = [
                                            'Seni & Budaya'  => 'badge-kat-seni',
                                            'Olahraga'       => 'badge-kat-olahraga',
                                            'Akademik'       => 'badge-kat-akademik',
                                            'Sosial'         => 'badge-kat-sosial',
                                            'Kerohanian'     => 'badge-kat-kerohanian',
                                            'Kewirausahaan'  => 'badge-kat-kewirausahaan',
                                        ][$org->kategori] ?? 'badge-kat-umum';
                                    ?>
                                    <span class="badge-kategori <?= $kat_class ?>"><?= htmlspecialchars($org->kategori) ?></span>
                                </td>
                                <td style="text-align:center; font-weight:700; color:#E67E22;"><?= $org->urutan ?></td>
                                <td style="text-align:center;">
                                    <button class="toggle-btn <?= $org->aktif ? 'on' : 'off' ?>"
                                            id="toggle-<?= $org->id ?>"
                                            onclick="toggleAktif(<?= $org->id ?>)"
                                            title="<?= $org->aktif ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' ?>"></button>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('admin/organisasi_edit/' . $org->id) ?>" class="btn-edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="btn-del" onclick="confirmHapus(<?= $org->id ?>, '<?= htmlspecialchars(addslashes($org->nama)) ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal-backdrop-custom" id="hapusModal">
    <div class="modal-box">
        <h5><i class="fas fa-exclamation-triangle" style="color:#e74c3c;"></i> Konfirmasi Hapus</h5>
        <p id="hapusModalText">Apakah Anda yakin ingin menghapus organisasi ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="tutupModal()">Batal</button>
            <a id="hapusModalBtn" href="#" class="btn-hapus"><i class="fas fa-trash"></i> Hapus</a>
        </div>
    </div>
</div>

<script>
function confirmHapus(id, nama) {
    document.getElementById('hapusModalText').textContent = 'Hapus organisasi "' + nama + '"? Data tidak dapat dikembalikan.';
    document.getElementById('hapusModalBtn').href = '<?= base_url('admin/organisasi_hapus/') ?>' + id;
    document.getElementById('hapusModal').classList.add('show');
}
function tutupModal() {
    document.getElementById('hapusModal').classList.remove('show');
}
document.getElementById('hapusModal').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});

function toggleAktif(id) {
    const btn = document.getElementById('toggle-' + id);
    fetch('<?= base_url('admin/organisasi_toggle/') ?>' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.status === 'success') {
            if (data.aktif) {
                btn.classList.replace('off', 'on');
                btn.title = 'Klik untuk nonaktifkan';
            } else {
                btn.classList.replace('on', 'off');
                btn.title = 'Klik untuk aktifkan';
            }
        }
    })
    .catch(console.error);
}
</script>
</body>
</html>
