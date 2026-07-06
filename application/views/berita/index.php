<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title><?= isset($title) ? $title : 'Berita - Fakultas Industri Kreatif | Telkom University' ?></title>

  <!-- Bootstrap 5 + Icons + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #ffffff;
      color: #1f2937;
      overflow-x: hidden;
    }

    :root {
      --orange: #f97316;
      --orange-dark: #ea580c;
      --orange-light: #ffedd5;
      --blue: #1e3a8a;
      --blue-dark: #0f2b66;
      --gray-bg: #f8fafc;
      --border: #e2e8f0;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background: var(--orange);
      border-radius: 10px;
    }

    @keyframes fadeUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .container-custom {
      width: min(100% - 3rem, 1280px);
      margin-inline: auto;
    }

    /* HEADER GLASS */
    .header-glass {
      position: absolute;
      top: 24px;
      left: 0;
      right: 0;
      z-index: 100;
    }

    .navbar-glass {
      background: rgba(0, 0, 0, 0.55);
      backdrop-filter: blur(20px);
      border-radius: 60px;
      padding: 10px 32px;
      border: 1px solid rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      transition: all 0.3s ease;
    }

    .navbar-glass.scrolled {
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(25px);
    }

    .logo-area {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .logo-icon {
      width: 48px;
      height: 48px;
      background: linear-gradient(145deg, var(--orange), var(--orange-dark));
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 1.4rem;
      box-shadow: 0 6px 12px rgba(249,115,22,0.3);
    }

    .logo-text h5 {
      font-size: 0.9rem;
      font-weight: 800;
      color: white;
      margin: 0;
    }

    .logo-text span {
      font-size: 0.7rem;
      color: rgba(255,255,255,0.85);
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      position: relative;
      padding-bottom: 4px;
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0%;
      height: 2px;
      background: var(--orange);
      transition: 0.3s ease;
    }

    .nav-links a:hover::after,
    .nav-links a.active::after {
      width: 100%;
    }

    .btn-mytelu-custom {
      background: linear-gradient(105deg, var(--orange), var(--orange-dark));
      padding: 8px 28px;
      border-radius: 40px;
      font-weight: 700;
      color: white;
      transition: all 0.3s;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn-mytelu-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 20px rgba(249, 115, 22, 0.4);
      color: white;
    }

    .mobile-toggle {
      display: none;
      background: rgba(255,255,255,0.15);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 16px;
      padding: 8px 16px;
      font-size: 1.3rem;
      color: white;
      cursor: pointer;
    }

    /* HERO BERITA */
    .hero-berita {
      background: linear-gradient(125deg, var(--orange) 0%, #fd8b3a 50%, #fef08a 100%);
      padding: 180px 0 100px;
      position: relative;
      overflow: hidden;
      clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
    }

    .hero-berita .wave-bottom {
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      line-height: 0;
    }

    .hero-berita h1 {
      font-size: 3.8rem;
      font-weight: 800;
      background: linear-gradient(135deg, #fff, #ffe0b5);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .search-box {
      max-width: 550px;
      margin: 30px auto 0;
      position: relative;
      z-index: 2;
    }

    .search-box input {
      width: 100%;
      padding: 16px 24px;
      border: none;
      border-radius: 60px;
      background: rgba(255,255,255,0.95);
      font-weight: 500;
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    .search-box input:focus {
      outline: none;
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    .search-box button {
      position: absolute;
      right: 8px;
      top: 8px;
      background: var(--orange);
      border: none;
      padding: 8px 28px;
      border-radius: 50px;
      font-weight: 700;
      transition: 0.2s;
    }

    .search-box button:hover {
      background: var(--orange-dark);
    }

    /* KATEGORI TABS */
    .kategori-tabs {
      display: flex;
      gap: 0.8rem;
      margin-bottom: 2.5rem;
      flex-wrap: wrap;
      border-bottom: 2px solid #eef2ff;
      padding-bottom: 12px;
    }

    .kategori-tab {
      padding: 10px 28px;
      border-radius: 50px;
      background: #f1f5f9;
      color: #334155;
      text-decoration: none;
      font-weight: 700;
      transition: all 0.25s;
    }

    .kategori-tab i {
      margin-right: 6px;
    }

    .kategori-tab:hover,
    .kategori-tab.active {
      background: var(--orange);
      color: white;
      box-shadow: 0 6px 14px rgba(249,115,22,0.3);
      transform: translateY(-2px);
    }

    /* FEATURED CARD */
    .featured-card {
      position: relative;
      border-radius: 32px;
      overflow: hidden;
      height: 460px;
      margin-bottom: 2.5rem;
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.2);
    }

    .featured-card:hover {
      transform: scale(1.01);
      transition: 0.3s;
    }

    .featured-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, #000000dd, #00000066, transparent);
      padding: 2rem;
      color: white;
    }

    /* BERITA CARD */
    .berita-card {
      background: white;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0,0,0,0.04);
      transition: all 0.35s;
      height: 100%;
      border: 1px solid #f0f2f5;
    }

    .berita-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 25px 40px -12px rgba(249,115,22,0.25);
    }

    .berita-card .gambar {
      height: 210px;
      overflow: hidden;
      position: relative;
    }

    .berita-card .gambar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .berita-card:hover .gambar img {
      transform: scale(1.08);
    }

    .badge-kategori {
      position: absolute;
      top: 16px;
      left: 16px;
      background: var(--orange);
      color: white;
      padding: 5px 14px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 700;
      z-index: 2;
    }

    .konten {
      padding: 1.6rem;
    }

    .berita-card h4 {
      font-size: 1.25rem;
      font-weight: 800;
      line-height: 1.4;
    }

    .berita-card h4 a {
      color: #1e293b;
      text-decoration: none;
      transition: 0.2s;
    }

    .berita-card h4 a:hover {
      color: var(--orange);
    }

    .ringkasan {
      color: #6b7280;
      font-size: 0.85rem;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .read-more {
      color: var(--orange);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.85rem;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .read-more:hover {
      gap: 12px;
    }

    /* SIDEBAR */
    .sidebar-card {
      background: white;
      border-radius: 28px;
      padding: 1.8rem;
      box-shadow: 0 12px 28px -8px rgba(0,0,0,0.05);
      border: 1px solid rgba(249,115,22,0.1);
      margin-bottom: 2rem;
    }

    .sidebar-card h4 {
      font-weight: 800;
      border-left: 4px solid var(--orange);
      padding-left: 14px;
    }

    .popular-list,
    .archive-list {
      list-style: none;
      padding: 0;
    }

    .popular-list li,
    .archive-list li {
      padding: 12px 0;
      border-bottom: 1px solid #e2e8f0;
    }

    .popular-list li:last-child,
    .archive-list li:last-child {
      border-bottom: none;
    }

    .popular-list li a,
    .archive-list li a {
      color: #1f2937;
      text-decoration: none;
      font-weight: 600;
      display: block;
    }

    .popular-list li a:hover,
    .archive-list li a:hover {
      color: var(--orange);
    }

    /* PAGINATION */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin: 40px 0;
    }

    .pagination a,
    .pagination span {
      padding: 8px 16px;
      border-radius: 14px;
      text-decoration: none;
      color: #1f2937;
      background: #f1f5f9;
      transition: all 0.3s ease;
      font-weight: 600;
    }

    .pagination a:hover,
    .pagination .active {
      background: var(--orange);
      color: white;
      box-shadow: 0 6px 12px rgba(249,115,22,0.3);
    }

    /* FOOTER */
    .footer {
      background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%);
      color: white;
      padding: 60px 0 30px;
      margin-top: 60px;
    }

    .footer a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
    }

    .footer a:hover {
      color: var(--orange);
    }

    .footer-bottom {
      text-align: center;
      padding-top: 30px;
      margin-top: 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .navbar-glass {
        flex-direction: row;
        flex-wrap: wrap;
        padding: 12px 20px;
      }

      .nav-links {
        display: none;
        width: 100%;
        flex-direction: column;
        margin-top: 16px;
        gap: 14px;
        align-items: flex-start;
      }

      .nav-links.open {
        display: flex;
      }

      .mobile-toggle {
        display: block;
      }

      .hero-berita {
        padding: 140px 0 70px;
      }

      .hero-berita h1 {
        font-size: 2.2rem;
      }

      .featured-card {
        height: 380px;
      }
    }
  </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'informasi']); ?>

<main>
  <!-- Hero Section -->
  <section class="hero-berita">
    <div class="container-custom text-center position-relative">
      <div data-aos="fade-up" data-aos-duration="800">
        <h1><i class="fas fa-newspaper me-2"></i> Berita & Informasi</h1>
        <p class="lead mt-3" style="color: #fff9f0; max-width: 650px; margin: auto;">
          Dapatkan informasi terkini seputar kegiatan, prestasi, dan pengumuman dari Fakultas Industri Kreatif
        </p>
      </div>

      <form action="<?= base_url('berita/search') ?>" method="GET" class="search-box" data-aos="fade-up" data-aos-delay="200">
        <input type="text" name="q" placeholder="Cari berita, artikel, atau pengumuman..." value="<?= isset($keyword) ? htmlspecialchars($keyword) : '' ?>">
        <button type="submit"><i class="fas fa-search"></i> Cari</button>
      </form>
    </div>
    <div class="wave-bottom">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
        <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
      </svg>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container-custom" style="padding: 60px 0 40px;">
    <div class="row g-5">
      <!-- KOLOM KIRI: DAFTAR BERITA -->
      <div class="col-lg-8">
        <!-- Kategori Tabs -->
        <div class="kategori-tabs" data-aos="fade-right">
          <a href="<?= base_url('berita') ?>" class="kategori-tab <?= !isset($kategori) ? 'active' : '' ?>">
            <i class="fas fa-layer-group"></i> Semua
          </a>
          <a href="<?= base_url('berita/kategori/berita') ?>" class="kategori-tab <?= (isset($kategori) && $kategori == 'berita') ? 'active' : '' ?>">
            <i class="fas fa-bullhorn"></i> Berita
          </a>
          <a href="<?= base_url('berita/kategori/pengumuman') ?>" class="kategori-tab <?= (isset($kategori) && $kategori == 'pengumuman') ? 'active' : '' ?>">
            <i class="fas fa-megaphone"></i> Pengumuman
          </a>
          <a href="<?= base_url('berita/kategori/artikel') ?>" class="kategori-tab <?= (isset($kategori) && $kategori == 'artikel') ? 'active' : '' ?>">
            <i class="fas fa-feather-alt"></i> Artikel
          </a>
        </div>

        <!-- Featured News (Hanya tampil jika tidak dalam kategori dan ada data featured) -->
        <?php if (!empty($featured) && !isset($kategori)) : ?>
          <div class="mb-5" data-aos="zoom-in">
            <?php foreach ($featured as $f) : ?>
              <div class="featured-card">
                <?php if (!empty($f['gambar']) && file_exists('./uploads/berita/' . $f['gambar'])) : ?>
                  <img src="<?= base_url('uploads/berita/' . $f['gambar']) ?>" alt="<?= htmlspecialchars($f['judul']) ?>" style="width:100%; height:100%; object-fit:cover;">
                <?php else : ?>
                  <div style="width:100%; height:100%; background: linear-gradient(135deg, var(--orange), #fdba74); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-newspaper fa-4x" style="color:white; opacity:0.7;"></i>
                  </div>
                <?php endif; ?>
                <div class="featured-overlay">
                  <span class="badge-kategori" style="position:relative; top:0; left:0; display:inline-block; margin-bottom:10px;"><?= ucfirst($f['kategori']) ?></span>
                  <h3 style="font-size:1.8rem;"><?= htmlspecialchars($f['judul']) ?></h3>
                  <p><?= substr(strip_tags($f['ringkasan']), 0, 120) ?>...</p>
                  <a href="<?= base_url('berita/detail/' . $f['slug']) ?>" class="btn btn-light rounded-pill px-4 py-2 mt-2 fw-bold" style="color: var(--orange);">Selengkapnya →</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <!-- Grid Berita (Data dari database) -->
        <div class="row g-4" id="beritaGrid">
          <?php if (!empty($berita)) : ?>
            <?php foreach ($berita as $b) : ?>
              <div class="col-md-6" data-aos="fade-up">
                <div class="berita-card">
                  <div class="gambar">
                    <span class="badge-kategori"><i class="fas fa-tag"></i> <?= ucfirst($b['kategori']) ?></span>
                    <?php if (!empty($b['gambar']) && file_exists('./uploads/berita/' . $b['gambar'])) : ?>
                      <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>">
                    <?php else : ?>
                      <div style="width:100%; height:100%; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-newspaper fa-3x text-secondary"></i>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="konten">
                    <div class="meta mb-2">
                      <i class="far fa-calendar-alt text-orange"></i> <?= date('d F Y', strtotime($b['published_at'])) ?>
                      &nbsp; <i class="fas fa-eye"></i> <?= number_format($b['views']) ?> views
                    </div>
                    <h4><a href="<?= base_url('berita/detail/' . $b['slug']) ?>"><?= htmlspecialchars($b['judul']) ?></a></h4>
                    <p class="ringkasan"><?= substr(strip_tags($b['ringkasan']), 0, 100) ?>...</p>
                    <a href="<?= base_url('berita/detail/' . $b['slug']) ?>" class="read-more">
                      Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div class="col-12 text-center py-5">
              <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
              <h4 class="text-muted">Belum Ada Berita</h4>
              <p class="text-muted">Silakan cek kembali nanti untuk informasi terbaru.</p>
            </div>
          <?php endif; ?>
        </div>

        <!-- Pagination (Data dari controller) -->
        <?php if (isset($total_pages) && $total_pages > 1) : ?>
          <div class="pagination mt-5" data-aos="fade-up">
            <?php if ($current_page > 1) : ?>
              <a href="?page=<?= $current_page - 1 ?><?= isset($kategori) ? '&kategori=' . $kategori : '' ?>">&laquo; Sebelumnya</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
              <?php if ($i == $current_page) : ?>
                <span class="active"><?= $i ?></span>
              <?php else : ?>
                <a href="?page=<?= $i ?><?= isset($kategori) ? '&kategori=' . $kategori : '' ?>"><?= $i ?></a>
              <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages) : ?>
              <a href="?page=<?= $current_page + 1 ?><?= isset($kategori) ? '&kategori=' . $kategori : '' ?>">Selanjutnya &raquo;</a>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- SIDEBAR KANAN -->
      <div class="col-lg-4">
        <!-- Berita Populer -->
        <div class="sidebar-card" data-aos="fade-left">
          <h4><i class="fas fa-chart-line text-orange me-2"></i> Berita Populer 🔥</h4>
          <ul class="popular-list">
            <?php if (!empty($populer)) : ?>
              <?php foreach ($populer as $p) : ?>
                <li>
                  <a href="<?= base_url('berita/detail/' . $p['slug']) ?>"><?= htmlspecialchars($p['judul']) ?></a>
                  <div class="views mt-1"><i class="fas fa-eye"></i> <?= number_format($p['views']) ?> views</div>
                </li>
              <?php endforeach; ?>
            <?php else : ?>
              <li>Belum ada data</li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Arsip -->
        <div class="sidebar-card" data-aos="fade-left" data-aos-delay="100">
          <h4><i class="fas fa-archive me-2"></i> Arsip Bulanan</h4>
          <ul class="archive-list">
            <?php if (!empty($archive)) : ?>
              <?php foreach ($archive as $a) : ?>
                <li>
                  <a href="<?= base_url('berita/archive/' . str_replace('-', '/', $a['month'])) ?>">
                    <?= $a['month_name'] ?>
                    <span class="badge bg-orange rounded-pill float-end"><?= $a['total'] ?></span>
                  </a>
                </li>
              <?php endforeach; ?>
            <?php else : ?>
              <li>Belum ada arsip</li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Statistik Kategori -->
        <div class="sidebar-card" data-aos="fade-left" data-aos-delay="200">
          <h4><i class="fas fa-tags me-2"></i> Kategori</h4>
          <ul class="archive-list">
            <li>
              <a href="<?= base_url('berita/kategori/berita') ?>">
                Berita
                <span class="badge bg-orange rounded-pill float-end"><?= isset($stats['berita']) ? $stats['berita'] : 0 ?></span>
              </a>
            </li>
            <li>
              <a href="<?= base_url('berita/kategori/pengumuman') ?>">
                Pengumuman
                <span class="badge bg-orange rounded-pill float-end"><?= isset($stats['pengumuman']) ? $stats['pengumuman'] : 0 ?></span>
              </a>
            </li>
            <li>
              <a href="<?= base_url('berita/kategori/artikel') ?>">
                Artikel
                <span class="badge bg-orange rounded-pill float-end"><?= isset($stats['artikel']) ? $stats['artikel'] : 0 ?></span>
              </a>
            </li>
          </ul>
        </div>

        <!-- Newsletter / Subscribe (Bonus) -->
        <div class="sidebar-card text-center" data-aos="fade-left" data-aos-delay="300" style="background: linear-gradient(145deg, #fff8f0, #ffffff);">
          <i class="fas fa-bell fa-2x text-orange mb-2"></i>
          <h5 class="fw-bold">Dapatkan Update</h5>
          <p class="small">Langganan newsletter untuk info terbaru</p>
          <div class="input-group mt-2">
            <input type="email" class="form-control rounded-pill" placeholder="Email kamu...">
            <button class="btn rounded-pill px-3" style="background: var(--orange); color:white; border:none;">Subscribe</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Footer -->
<footer class="footer">
  <div class="container-custom">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: var(--orange);">Fakultas Industri Kreatif</h4>
        <p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: var(--orange);">Tautan Cepat</h4>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="mb-2"><a href="<?= base_url('berita') ?>">Berita</a></li>
          <li class="mb-2"><a href="#">Layanan Mahasiswa</a></li>
          <li class="mb-2"><a href="#">Forum Alumni</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: var(--orange);">Kontak</h4>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bandung, Jawa Barat</li>
          <li class="mb-2"><i class="fas fa-envelope me-2"></i> fik@telkomuniversity.ac.id</li>
          <li class="mb-2"><i class="fas fa-phone me-2"></i> (022) 756 5923</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="mb-0">&copy; <?= date('Y') ?> Fakultas Industri Kreatif - Telkom University. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
    offset: 50
  });

  // Navbar scroll effect
  window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
</script>
</body>
</html>