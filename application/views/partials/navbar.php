<?php
$active_menu = $active_menu ?? 'dashboard';

$user_nama = '';
$user_foto = '';
$is_logged_in = false;

if (isset($user_data) && is_array($user_data) && isset($user_data['logged_in']) && $user_data['logged_in']) {
    $is_logged_in = true;
    $user_nama = $user_data['nama'] ?? '';
    $user_foto = $user_data['foto'] ?? '';
} elseif (isset($user) && isset($user->nama)) {
    $is_logged_in = true;
    $user_nama = $user->nama;
    $user_foto = $user->foto ?? '';
}
?>
<style>
.header-glass {
  position: absolute;
  top: 24px;
  left: 0;
  right: 0;
  z-index: 50;
}
.navbar-glass {
  background: rgba(0, 0, 0, 0.55);
  backdrop-filter: blur(20px);
  border-radius: 60px;
  padding: 12px 32px;
  border: 1px solid rgba(255,255,255,0.15);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}
.logo-area { display: flex; align-items: center; gap: 16px; }
.logo-icon {
  width: 48px; height: 48px;
  background: #2d3e50;
  border-radius: 14px;
  display: flex;
  align-items: center; justify-content: center;
  color: white; font-weight: bold; font-size: 1.3rem;
}
.logo-text h5 { font-size: 0.9rem; font-weight: 800; color: white; margin: 0; line-height: 1.2; }
.logo-text span { font-size: 0.7rem; color: rgba(255,255,255,0.85); }
.nav-links { display: flex; gap: 2rem; align-items: center; position: relative; }
.nav-links a {
  color: white !important;
  text-decoration: none !important;
  font-weight: 600;
  font-size: 0.9rem;
  border-bottom: 2px solid transparent;
  padding-bottom: 4px;
  transition: all 0.3s ease;
}
.nav-links a.active, .nav-links a:hover {
  border-bottom-color: #f97316 !important;
  color: white !important;
}
.nav-item-dropdown { position: relative; }
.nav-item-dropdown > a {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 0;
  color: white !important;
  text-decoration: none !important;
  font-weight: 600;
  font-size: 0.9rem;
  border-bottom: 2px solid transparent;
  padding-bottom: 4px;
  transition: all 0.3s ease;
  cursor: pointer;
}
.nav-item-dropdown > a i { font-size: 0.7rem; transition: transform 0.3s ease; }
.nav-item-dropdown.open .dropdown-menu-custom {
  opacity: 1 !important;
  visibility: visible !important;
  transform: translateX(-50%) translateY(0) !important;
}
.nav-item-dropdown.open > a i { transform: rotate(180deg); }
.nav-item-dropdown > a.active,
.nav-item-dropdown > a:hover { border-bottom-color: #f97316 !important; }
.dropdown-menu-custom {
  position: absolute;
  top: calc(100% + 16px);
  left: 50%;
  transform: translateX(-50%) translateY(-12px);
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(30px);
  border-radius: 24px;
  padding: 16px 20px;
  min-width: 820px;
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  opacity: 0;
  visibility: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 100;
}
.dropdown-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
.dropdown-item {
  padding: 24px 16px;
  text-align: center;
  border-radius: 16px;
  transition: all 0.3s ease;
  text-decoration: none;
  color: #1f2937 !important;
  background: rgba(249, 115, 22, 0.02);
  min-height: 160px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.dropdown-item:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px rgba(249, 115, 22, 0.15);
  background: #fff7ed;
}
.dropdown-item::after { display: none !important; }
.d-icon-wrapper {
  width: 56px; height: 56px;
  margin: 0 auto 12px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
}
.d-icon-wrapper i { font-size: 1.6rem; }
.dropdown-item:nth-child(1) .d-icon-wrapper { background: #fef3c7; }
.dropdown-item:nth-child(1) .d-icon-wrapper i { color: #D98A3C; }
.dropdown-item:nth-child(2) .d-icon-wrapper { background: #dbeafe; }
.dropdown-item:nth-child(2) .d-icon-wrapper i { color: #2563EB; }
.dropdown-item:nth-child(3) .d-icon-wrapper { background: #e0f2fe; }
.dropdown-item:nth-child(3) .d-icon-wrapper i { color: #3B82F6; }
.dropdown-item:nth-child(4) .d-icon-wrapper { background: #fee2e2; }
.dropdown-item:nth-child(4) .d-icon-wrapper i { color: #DC2626; }
.dropdown-item:nth-child(5) .d-icon-wrapper { background: #d1fae5; }
.dropdown-item:nth-child(5) .d-icon-wrapper i { color: #10B981; }
.d-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; color: #1f2937; white-space: normal; }
.d-desc { font-size: 0.75rem; color: #6b7280; line-height: 1.5; font-weight: 400; max-width: 140px; margin: 0 auto; white-space: normal; }
.btn-mytelu-custom {
  background: #f97316;
  padding: 8px 28px;
  border-radius: 40px;
  font-weight: 700;
  color: white;
  transition: 0.2s;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 10px;
}
.btn-mytelu-custom:hover {
  background: #ea580c;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
}
.user-avatar-small { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }
.mobile-toggle {
  display: none;
  background: rgba(255,255,255,0.15);
  border: 1px solid rgba(255,255,255,0.15);
  border-radius: 12px;
  padding: 8px 14px;
  font-size: 1.4rem;
  color: white;
  cursor: pointer;
}
@media (max-width: 1024px) {
  .dropdown-menu-custom { min-width: unset; width: 90vw; max-width: 600px; left: 50%; transform: translateX(-50%) translateY(-12px); padding: 12px; }
  .nav-item-dropdown.open .dropdown-menu-custom { transform: translateX(-50%) translateY(0) !important; }
  .dropdown-grid { grid-template-columns: repeat(3, 1fr); gap: 6px; }
  .dropdown-item { padding: 16px 12px; min-height: 130px; }
  .d-icon-wrapper { width: 44px; height: 44px; margin-bottom: 8px; }
  .d-icon-wrapper i { font-size: 1.2rem; }
  .d-title { font-size: 0.8rem; white-space: normal; }
  .d-desc { font-size: 0.65rem; max-width: 100px; }
}
@media (max-width: 768px) {
  .navbar-glass { flex-direction: column; align-items: stretch; }
  .nav-links { display: none; flex-direction: column; align-items: center; margin-top: 12px; gap: 16px; }
  .nav-links.open { display: flex !important; }
  .mobile-toggle { display: block; align-self: flex-end; }
  .nav-item-dropdown { width: 100%; text-align: center; }
  .nav-item-dropdown .dropdown-menu-custom,
  .nav-item-dropdown.open .dropdown-menu-custom {
    position: static;
    opacity: 1 !important;
    visibility: visible !important;
    transform: none !important;
    display: none;
    background: transparent;
    backdrop-filter: none;
    padding-left: 0;
    border: none;
    min-width: auto;
    box-shadow: none;
    width: 100%;
    max-width: 100%;
  }
  .nav-item-dropdown.open .dropdown-menu-custom { display: block; }
  .dropdown-grid { grid-template-columns: 1fr 1fr; gap: 4px; }
  .dropdown-item { padding: 12px 8px; min-height: 100px; }
  .d-icon-wrapper { width: 36px; height: 36px; margin-bottom: 6px; }
  .d-icon-wrapper i { font-size: 1rem; }
  .d-title { font-size: 0.7rem; white-space: normal; }
  .d-desc { font-size: 0.6rem; max-width: unset; }
}
</style>
<header class="header-glass">
    <div class="container-custom">
        <div class="navbar-glass" id="navbar">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-paintbrush-fine"></i></div>
                <div class="logo-text">
                    <h5>Unit Kemahasiswaan</h5>
                    <span>Fakultas Industri Kreatif</span>
                </div>
            </div>

            <div class="nav-links" id="navLinks">
                <a href="<?= base_url() ?>" class="<?= $active_menu == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= base_url('berita') ?>" class="<?= $active_menu == 'informasi' ? 'active' : '' ?>">Informasi</a>

                <div class="nav-item-dropdown" id="layananDropdown">
                    <a href="#" id="layananToggle" class="<?= $active_menu == 'layanan' ? 'active' : '' ?>">
                        Layanan <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu-custom">
                        <div class="dropdown-grid">
                            <a href="<?= base_url('beasiswa') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
                                <div class="d-title">Pengajuan Beasiswa</div>
                                <div class="d-desc">Ajukan beasiswa prestasi & bantuan pendidikan</div>
                            </a>
                            <a href="<?= base_url('sertifikat') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-certificate"></i></div>
                                <div class="d-title">Pengajuan Sertifikat</div>
                                <div class="d-desc">Cetak sertifikat prestasi mahasiswa & kegiatan</div>
                            </a>
                            <a href="<?= base_url('proposal') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-clipboard-list"></i></div>
                                <div class="d-title">Pengajuan Proposal</div>
                                <div class="d-desc">Ajukan proposal kegiatan, PKM, & penelitian</div>
                            </a>
                            <a href="<?= base_url('tak') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-file-alt"></i></div>
                                <div class="d-title">Pengajuan TAK</div>
                                <div class="d-desc">Ajukan pengakuan kegiatan & kompetensi mahasiswa</div>
                            </a>
                            <a href="<?= base_url('forum_alumni') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-users"></i></div>
                                <div class="d-title">Layanan Alumni</div>
                                <div class="d-desc">Forum alumni, tracer study, & jejaring karir</div>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('forum_alumni') ?>" class="<?= $active_menu == 'forum_alumni' ? 'active' : '' ?>">Forum Alumni</a>
            </div>

            <?php if ($is_logged_in): ?>
                <a href="<?= base_url('dashboard/profile') ?>" class="btn-mytelu-custom">
                    <?php if (!empty($user_foto)): ?>
                        <img src="<?= base_url('uploads/users/' . $user_foto) ?>" class="user-avatar-small">
                    <?php else: ?>
                        <i class="fas fa-user-circle"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($user_nama) ?>
                </a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-mytelu-custom">
                    <i class="fas fa-sign-in-alt"></i> MyTeLU
                </a>
            <?php endif; ?>

            <button class="mobile-toggle" id="mobileNavBtn"><i class="fas fa-bars"></i></button>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.getElementById('layananToggle');
    var dropdownWrapper = document.getElementById('layananDropdown');
    if (dropdownToggle && dropdownWrapper) {
        dropdownToggle.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownWrapper.classList.toggle('open');
        });
        document.addEventListener('click', function(e) {
            if (!dropdownWrapper.contains(e.target)) {
                dropdownWrapper.classList.remove('open');
            }
        });
    }

    var mobileBtn = document.getElementById('mobileNavBtn');
    var navLinksDiv = document.getElementById('navLinks');
    if (mobileBtn && navLinksDiv) {
        mobileBtn.addEventListener('click', function() {
            navLinksDiv.classList.toggle('open');
        });
    }
});
</script>
