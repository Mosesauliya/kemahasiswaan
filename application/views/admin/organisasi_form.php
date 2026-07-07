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
            border-radius: 25px; text-decoration: none; font-size: .85rem; transition: background .2s;
        }
        .logout-btn:hover { background: #c0392b; color: #fff; }

        /* ── Breadcrumb ── */
        .breadcrumb-bar {
            display: flex; align-items: center; gap: .5rem;
            font-size: .85rem; color: #888; margin-bottom: 1.5rem;
        }
        .breadcrumb-bar a { color: #E67E22; text-decoration: none; }
        .breadcrumb-bar a:hover { text-decoration: underline; }
        .breadcrumb-bar .sep { color: #ccc; }

        /* ── Form Card ── */
        .form-card {
            background: white; border-radius: 16px; padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
        }
        .form-card h4 { font-weight: 700; color: #2C3E50; margin-bottom: 1.5rem;
            padding-bottom: 1rem; border-bottom: 2px solid #f0f2f5; display: flex; align-items: center; gap: .6rem; }
        .form-card h4 i { color: #E67E22; }

        .form-group { margin-bottom: 1.4rem; }
        .form-group label {
            display: block; font-size: .85rem; font-weight: 600; color: #444; margin-bottom: .45rem;
        }
        .form-group label .req { color: #e74c3c; margin-left: .2rem; }
        .form-control-org {
            width: 100%; padding: .65rem 1rem; border: 2px solid #e8eaed; border-radius: 10px;
            font-size: .9rem; font-family: inherit; transition: border .2s; background: #fafbfc;
        }
        .form-control-org:focus { outline: none; border-color: #E67E22; background: white; }
        textarea.form-control-org { resize: vertical; min-height: 90px; }
        select.form-control-org { cursor: pointer; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* Logo Upload - Drag & Drop */
        .logo-upload-area {
            border: 2.5px dashed #d0d4da; border-radius: 14px; padding: 2.5rem 1.5rem;
            text-align: center; cursor: pointer; transition: all .25s; position: relative;
            background: #fafbfc;
        }
        .logo-upload-area:hover,
        .logo-upload-area.drag-over {
            border-color: #E67E22;
            background: rgba(230,126,34,.06);
            transform: scale(1.01);
        }
        .logo-upload-area.drag-over .upload-icon i { color: #E67E22; transform: translateY(-4px); }
        .logo-upload-area input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .logo-upload-area .upload-icon { font-size: 2.8rem; color: #c5cbd5; margin-bottom: .7rem; transition: all .25s; }
        .logo-upload-area .upload-text { font-size: .95rem; color: #888; }
        .logo-upload-area .upload-text strong { color: #E67E22; }
        .logo-upload-area .upload-hint { font-size: .78rem; color: #bbb; margin-top: .4rem; }

        #logoPreviewWrap { margin-top: 1rem; display: none; }
        .preview-inner {
            display: flex; align-items: center; gap: 1.5rem;
            background: #f8f9fb; border-radius: 12px; padding: 1rem 1.5rem;
            border: 1.5px solid #e8eaed;
        }
        #logoPreviewWrap img {
            width: 90px; height: 90px; border-radius: 12px;
            object-fit: cover; border: 2px solid #e0e3e7; box-shadow: 0 4px 12px rgba(0,0,0,.08); flex-shrink: 0;
        }
        .preview-info { flex: 1; }
        .preview-info .file-name { font-weight: 600; color: #2C3E50; font-size: .9rem; }
        .preview-info .file-size { font-size: .8rem; color: #aaa; margin-top: .2rem; }
        .preview-remove {
            background: none; border: none; color: #e74c3c; font-size: 1.2rem;
            cursor: pointer; padding: .3rem; border-radius: 6px; transition: background .2s;
        }
        .preview-remove:hover { background: rgba(231,76,60,.1); }

        /* Current logo */
        .current-logo-wrap { margin-bottom: .8rem; text-align: center; }
        .current-logo-wrap img {
            max-width: 100px; max-height: 100px; border-radius: 12px;
            object-fit: cover; border: 2px solid #e0e3e7;
        }
        .current-logo-label { font-size: .75rem; color: #888; margin-top: .3rem; }

        /* Icon Picker */
        .icon-picker-wrap { position: relative; }
        .icon-preview { font-size: 1.4rem; color: #E67E22; margin-right: .5rem; vertical-align: middle; }
        .icon-grid {
            display: grid; grid-template-columns: repeat(8, 1fr); gap: .4rem;
            padding: .8rem; border: 2px solid #e8eaed; border-radius: 10px;
            background: #fafbfc; max-height: 150px; overflow-y: auto; margin-top: .4rem;
        }
        .icon-grid button {
            border: 1.5px solid transparent; border-radius: 8px; background: white;
            padding: .4rem; cursor: pointer; font-size: 1rem; transition: all .15s; color: #555;
        }
        .icon-grid button:hover { border-color: #E67E22; background: rgba(230,126,34,.08); color: #E67E22; }
        .icon-grid button.selected { border-color: #E67E22; background: rgba(230,126,34,.12); color: #E67E22; }

        /* Toggle Aktif */
        .toggle-field { display: flex; align-items: center; gap: 1rem; margin-top: .3rem; }
        .toggle-switch { position: relative; width: 52px; height: 28px; flex-shrink: 0; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; inset: 0; border-radius: 14px; background: #bdc3c7;
            cursor: pointer; transition: background .3s;
        }
        .toggle-slider::after {
            content: ''; position: absolute; width: 22px; height: 22px; background: white;
            border-radius: 50%; top: 3px; left: 3px; transition: left .3s; box-shadow: 0 1px 4px rgba(0,0,0,.2);
        }
        .toggle-switch input:checked + .toggle-slider { background: #27ae60; }
        .toggle-switch input:checked + .toggle-slider::after { left: 27px; }
        .toggle-label { font-size: .9rem; color: #444; font-weight: 500; }

        /* Alert */
        .alert-org {
            padding: .9rem 1.2rem; border-radius: 10px; margin-bottom: 1.2rem;
            font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: .6rem;
        }
        .alert-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }

        /* Buttons */
        .form-footer { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 2px solid #f0f2f5; }
        .btn-submit {
            background: linear-gradient(135deg, #E67E22, #d35400); color: white; border: none;
            padding: .7rem 2rem; border-radius: 10px; font-weight: 700; font-size: .95rem;
            cursor: pointer; transition: all .25s; display: flex; align-items: center; gap: .6rem;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(230,126,34,.4); }
        .btn-back {
            background: #e8eaed; color: #555; border: none; padding: .7rem 1.5rem;
            border-radius: 10px; font-weight: 600; font-size: .9rem; cursor: pointer;
            text-decoration: none; display: flex; align-items: center; gap: .5rem; transition: background .2s;
        }
        .btn-back:hover { background: #dde; color: #333; }

        /* ── Mobile Responsive ── */
        .hamburger-btn {
            display: none; background: none; border: none;
            font-size: 1.4rem; color: #2C3E50; cursor: pointer; padding: .3rem;
        }
        .sidebar-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.45); z-index: 99; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform .3s ease;
                z-index: 100;
            }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main { margin-left: 0; padding: 1rem; }

            .hamburger-btn { display: flex; align-items: center; }

            .admin-header {
                flex-wrap: wrap;
                gap: .6rem;
                padding-bottom: .8rem;
                margin-bottom: 1.2rem;
            }
            .admin-header h1 { font-size: 1.2rem; flex: 1; }
            .admin-header .user-info span { display: none; }
            .logout-btn { padding: .4rem .9rem; font-size: .8rem; }

            .form-row { grid-template-columns: 1fr; }

            .form-card { padding: 1.2rem; border-radius: 12px; }
            .form-card h4 { font-size: 1rem; }

            .form-footer { flex-direction: column; }
            .btn-submit, .btn-back { width: 100%; justify-content: center; }

            .logo-upload-area { padding: 1.5rem 1rem; }
            .logo-upload-area .upload-icon { font-size: 2rem; }
            .logo-upload-area .upload-text { font-size: .85rem; }

            .preview-inner { flex-direction: column; text-align: center; }
            #logoPreviewWrap img { width: 70px; height: 70px; }

            .icon-grid { grid-template-columns: repeat(6, 1fr); }

            .breadcrumb-bar { font-size: .78rem; }
        }
    </style>
</head>
<body>
<div class="admin-wrapper">

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <div class="admin-sidebar" id="adminSidebar">
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
            <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <h1><i class="fas fa-<?= isset($org) ? 'edit' : 'plus-circle' ?>" style="color:#E67E22; font-size:1.4rem;"></i> <?= $title ?></h1>
            <div class="user-info">
                <span><i class="fas fa-user-circle me-2" style="color: #E67E22;"></i> <?= $this->session->userdata('nama') ?></span>
                <a href="<?= base_url('login/logout') ?>" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <a href="<?= base_url('admin/organisasi') ?>"><i class="fas fa-users"></i> Organisasi</a>
            <span class="sep">›</span>
            <span><?= isset($org) ? 'Edit: ' . htmlspecialchars($org->nama) : 'Tambah Baru' ?></span>
        </div>

        <!-- Flash error -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-org alert-error"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="form-card">
            <h4><i class="fas fa-building"></i> <?= isset($org) ? 'Edit Organisasi' : 'Tambah Organisasi Baru' ?></h4>

            <?php
                $action = isset($org)
                    ? base_url('admin/organisasi_edit/' . $org->id)
                    : base_url('admin/organisasi_tambah');
            ?>
            <form method="POST" action="<?= $action ?>" enctype="multipart/form-data">

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama">Nama Organisasi <span class="req">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control-org"
                           placeholder="cth: UKM Basket Telkom University"
                           value="<?= htmlspecialchars(isset($org) ? $org->nama : '') ?>" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Singkat</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control-org"
                              placeholder="Deskripsikan organisasi ini secara singkat..."><?= htmlspecialchars(isset($org) ? ($org->deskripsi ?? '') : '') ?></textarea>
                </div>

                <div class="form-row">
                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" class="form-control-org">
                            <?php
                                $katList = ['Seni & Budaya', 'Olahraga', 'Akademik', 'Sosial', 'Kerohanian', 'Kewirausahaan', 'Umum'];
                                $selKat  = isset($org) ? $org->kategori : 'Umum';
                                foreach ($katList as $kat):
                            ?>
                                <option value="<?= $kat ?>" <?= ($selKat === $kat) ? 'selected' : '' ?>><?= $kat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Urutan -->
                    <div class="form-group">
                        <label for="urutan">Urutan Tampil</label>
                        <input type="number" id="urutan" name="urutan" class="form-control-org"
                               min="0" placeholder="0"
                               value="<?= isset($org) ? (int)$org->urutan : 0 ?>">
                    </div>
                </div>

                <!-- Logo Upload -->
                <div class="form-group">
                    <label>Logo / Gambar Organisasi</label>

                    <?php if (isset($org) && $org->logo): ?>
                        <div class="current-logo-wrap">
                            <img src="<?= base_url($org->logo) ?>" alt="Logo saat ini"
                                 onerror="this.src=''; this.style.display='none';">
                            <div class="current-logo-label">Logo saat ini &mdash; Upload baru untuk mengganti</div>
                        </div>
                    <?php endif; ?>

                    <div class="logo-upload-area" id="dropZone">
                        <input type="file" id="logo" name="logo" accept="image/*" onchange="previewLogo(this.files[0])">
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="upload-text"><strong>Klik untuk pilih gambar</strong> atau <strong>seret & lepas</strong> di sini</div>
                        <div class="upload-hint">JPG, PNG, GIF, SVG, WebP &middot; Maks. 2MB</div>
                    </div>

                    <div id="logoPreviewWrap">
                        <div class="preview-inner">
                            <img id="logoPreview" src="" alt="Preview">
                            <div class="preview-info">
                                <div class="file-name" id="logoFileName"></div>
                                <div class="file-size" id="logoFileSize"></div>
                            </div>
                            <button type="button" class="preview-remove" onclick="removeLogo()" title="Hapus foto">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Icon Fallback -->
                <div class="form-group">
                    <label>Icon Fallback <small style="font-weight:400; color:#aaa;">(tampil jika logo gagal dimuat)</small></label>
                    <div style="display:flex; align-items:center; gap:.5rem; margin-bottom:.5rem;">
                        <i id="iconPreviewEl" class="<?= htmlspecialchars(isset($org) ? $org->icon : 'fas fa-star') ?> icon-preview"></i>
                        <input type="text" id="icon" name="icon" class="form-control-org"
                               style="flex:1;"
                               value="<?= htmlspecialchars(isset($org) ? $org->icon : 'fas fa-star') ?>"
                               placeholder="cth: fas fa-star"
                               oninput="updateIconPreview(this.value)">
                    </div>
                    <div class="icon-grid" id="iconGrid"></div>
                </div>

                <!-- Status Aktif -->
                <div class="form-group">
                    <label>Status Tampil di Dashboard</label>
                    <div class="toggle-field">
                        <label class="toggle-switch">
                            <input type="checkbox" id="aktif" name="aktif" value="1"
                                   <?= (!isset($org) || $org->aktif) ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="aktifLabel"><?= (!isset($org) || $org->aktif) ? 'Aktif – Tampil di Dashboard' : 'Nonaktif – Tidak Tampil' ?></span>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="form-footer">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> <?= isset($org) ? 'Simpan Perubahan' : 'Tambahkan Organisasi' ?>
                    </button>
                    <a href="<?= base_url('admin/organisasi') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>

    </main>
</div>

<script>
// ── Logo Preview & Drag & Drop ──
function previewLogo(file) {
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Maks. 2MB.');
        return;
    }
    const wrap = document.getElementById('logoPreviewWrap');
    const img  = document.getElementById('logoPreview');
    const name = document.getElementById('logoFileName');
    const size = document.getElementById('logoFileSize');
    const reader = new FileReader();
    reader.onload = e => {
        img.src = e.target.result;
        name.textContent = file.name;
        size.textContent = (file.size / 1024).toFixed(1) + ' KB';
        wrap.style.display = 'block';
        document.getElementById('dropZone').style.display = 'none';
    };
    reader.readAsDataURL(file);
}

function removeLogo() {
    document.getElementById('logo').value = '';
    document.getElementById('logoPreviewWrap').style.display = 'none';
    document.getElementById('dropZone').style.display = 'block';
    document.getElementById('logoPreview').src = '';
}

// Drag & Drop events
const dropZone = document.getElementById('dropZone');

['dragenter', 'dragover'].forEach(ev => {
    dropZone.addEventListener(ev, e => {
        e.preventDefault(); e.stopPropagation();
        dropZone.classList.add('drag-over');
    });
});

['dragleave', 'drop'].forEach(ev => {
    dropZone.addEventListener(ev, e => {
        e.preventDefault(); e.stopPropagation();
        dropZone.classList.remove('drag-over');
    });
});

dropZone.addEventListener('drop', e => {
    const file = e.dataTransfer.files[0];
    if (!file) return;
    // Masukkan file ke input supaya ikut ter-submit form
    const dt = new DataTransfer();
    dt.items.add(file);
    document.getElementById('logo').files = dt.files;
    previewLogo(file);
});

// Klik pada dropzone buka file picker (kecuali klik di input sendiri)
dropZone.addEventListener('click', e => {
    if (e.target.tagName !== 'INPUT') {
        document.getElementById('logo').click();
    }
});

document.getElementById('logo').addEventListener('change', function() {
    if (this.files[0]) previewLogo(this.files[0]);
});

// ── Icon Picker ──
const ICONS = [
    'fas fa-star','fas fa-users','fas fa-music','fas fa-palette','fas fa-futbol',
    'fas fa-basketball-ball','fas fa-fist-raised','fas fa-dove','fas fa-mask',
    'fas fa-map-marker-alt','fas fa-newspaper','fas fa-drafting-compass',
    'fas fa-theater-masks','fas fa-hands-helping','fas fa-laptop-code',
    'fas fa-code','fas fa-rocket','fab fa-google','fas fa-pray','fas fa-om',
    'fas fa-cross','fas fa-mosque','fas fa-church','fas fa-mountain',
    'fas fa-guitar','fas fa-first-aid','fas fa-flag','fas fa-trophy',
    'fas fa-graduation-cap','fas fa-book','fas fa-chess','fas fa-running',
    'fas fa-swimming-pool','fas fa-volleyball-ball','fas fa-table-tennis',
    'fas fa-camera','fas fa-microphone','fas fa-film','fas fa-heart',
];

function buildIconGrid() {
    const grid = document.getElementById('iconGrid');
    const cur  = document.getElementById('icon').value.trim();
    grid.innerHTML = '';
    ICONS.forEach(ic => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.title = ic;
        btn.innerHTML = '<i class="' + ic + '"></i>';
        if (ic === cur) btn.classList.add('selected');
        btn.addEventListener('click', () => {
            document.getElementById('icon').value = ic;
            updateIconPreview(ic);
            grid.querySelectorAll('button').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
        });
        grid.appendChild(btn);
    });
}

function updateIconPreview(val) {
    const el = document.getElementById('iconPreviewEl');
    el.className = (val.trim() || 'fas fa-star') + ' icon-preview';
}

buildIconGrid();

// ── Toggle Label ──
document.getElementById('aktif').addEventListener('change', function() {
    document.getElementById('aktifLabel').textContent = this.checked
        ? 'Aktif – Tampil di Dashboard'
        : 'Nonaktif – Tidak Tampil';
});

// ── Sidebar Toggle (Mobile) ──
function toggleSidebar() {
    document.getElementById('adminSidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>
</body>
</html>
