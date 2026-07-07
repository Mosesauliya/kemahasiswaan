<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title><?= isset($title) ? $title : 'Arsip Berita - Fakultas Industri Kreatif' ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #ffffff; color: #1f2937; }
    :root { --orange: #f97316; --orange-dark: #ea580c; --orange-light: #ffedd5; --blue: #1e3a8a; }

    .bg-orange-grad { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); position: relative; }
    .bg-orange-grad::before { content: ""; position: absolute; inset: 0; background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px); background-size: 32px 32px; pointer-events: none; }
    .container-custom { width: min(100% - 3rem, 1280px); margin-inline: auto; }

    /* HEADER */
    .header-glass { position: absolute; top: 24px; left: 0; right: 0; z-index: 50; }
    .navbar-glass { background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(20px); border-radius: 60px; padding: 12px 32px; border: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; }
    .logo-area { display: flex; align-items: center; gap: 16px; }
    .logo-icon { width: 48px; height: 48px; background: #2d3e50; border-radius: 14px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.3rem; }
    .logo-text h5 { font-size: 0.9rem; font-weight: 800; color: white; margin: 0; }
    .logo-text span { font-size: 0.7rem; color: rgba(255,255,255,0.85); }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a { color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 4px; transition: all 0.3s ease; }
    .nav-links a.active, .nav-links a:hover { border-bottom-color: #f97316; }
    .btn-mytelu-custom { background: #f97316; padding: 8px 28px; border-radius: 40px; font-weight: 700; color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: 0.2s; }
    .btn-mytelu-custom:hover { background: #ea580c; transform: translateY(-2px); }
    .user-avatar-small { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; background: white; }
    .mobile-toggle { display: none; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 8px 14px; font-size: 1.4rem; color: white; cursor: pointer; }

    /* HERO */
    .hero-berita { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); padding: 160px 0 80px; text-align: center; color: white; position: relative; }
    .hero-berita::before { content: ""; position: absolute; inset: 0; background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px); background-size: 32px 32px; pointer-events: none; }
    .hero-berita h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; position: relative; z-index: 1; }
    .hero-berita p { font-size: 1.2rem; max-width: 600px; margin: 0 auto; opacity: 0.9; position: relative; z-index: 1; }

    /* KATEGORI TABS */
    .kategori-tabs { display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .kategori-tab { padding: 10px 24px; border-radius: 30px; background: #f1f5f9; color: #1f2937; text-decoration: none; font-weight: 600; transition: all 0.3s ease; }
    .kategori-tab:hover, .kategori-tab.active { background: #f97316; color: white; }

    /* BERITA CARDS */
    .berita-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s ease; height: 100%; margin-bottom: 30px; }
    .berita-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(249, 115, 22, 0.15); }
    .berita-card .gambar { height: 200px; overflow: hidden; background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%); display: flex; align-items: center; justify-content: center; }
    .berita-card .gambar img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .berita-card .gambar i { font-size: 3rem; color: #cbd5e1; }
    .berita-card .kategori-badge { display: inline-block; background: #f97316; color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; margin-bottom: 1rem; }
    .berita-card .kategori-badge.pengumuman { background: #1e3a8a; }
    .berita-card .kategori-badge.artikel { background: #10b981; }
    .berita-card .konten { padding: 1.5rem; }
    .berita-card h4 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.5rem; }
    .berita-card h4 a { color: #1f2937; text-decoration: none; }
    .berita-card h4 a:hover { color: #f97316; }
    .berita-card .meta { font-size: 0.75rem; color: #6b7280; margin-bottom: 1rem; }
    .berita-card .meta i { color: #f97316; margin-right: 4px; }
    .berita-card .ringkasan { color: #6b7280; font-size: 0.85rem; line-height: 1.6; margin-bottom: 1rem; }
    .berita-card .read-more { color: #f97316; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; }
    .berita-card .read-more:hover { gap: 12px; }

    /* SIDEBAR */
    .sidebar-card { background: white; border-radius: 20px; padding: 1.5rem; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; }
    .sidebar-card h4 { color: #1f2937; font-weight: 700; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 3px solid #f97316; display: inline-block; }
    .popular-list, .archive-list { list-style: none; padding: 0; }
    .popular-list li, .archive-list li { padding: 12px 0; border-bottom: 1px solid #e2e8f0; }
    .popular-list li:last-child, .archive-list li:last-child { border-bottom: none; }
    .popular-list li a, .archive-list li a { color: #1f2937; text-decoration: none; font-weight: 600; display: block; }
    .popular-list li a:hover, .archive-list li a:hover { color: #f97316; }
    .popular-list .views, .archive-list li span { font-size: 0.75rem; color: #6b7280; margin-top: 4px; display: inline-block; }
    .archive-list li a { display: flex; justify-content: space-between; align-items: center; }
    .archive-list li span { background: #f1f5f9; padding: 2px 10px; border-radius: 20px; }

    /* PAGINATION */
    .pagination { display: flex; justify-content: center; gap: 10px; margin: 40px 0; }
    .pagination a, .pagination span { padding: 8px 16px; border-radius: 10px; text-decoration: none; color: #1f2937; background: #f1f5f9; transition: all 0.3s ease; }
    .pagination a:hover, .pagination .active { background: #f97316; color: white; }

    /* FOOTER */
    .footer { background: linear-gradient(135deg, #1e3a8a 0%, #1e293b 100%); color: white; padding: 60px 0 30px; margin-top: 60px; }
    .footer a { color: rgba(255,255,255,0.7); text-decoration: none; }
    .footer a:hover { color: #f97316; }
    .footer-bottom { text-align: center; padding-top: 30px; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); }

    @media (max-width: 768px) {
      .navbar-glass { flex-direction: column; align-items: stretch; }
      .nav-links { display: none; flex-direction: column; margin-top: 12px; gap: 16px; }
      .nav-links.open { display: flex !important; }
      .mobile-toggle { display: block; }
      .hero-berita { padding: 120px 0 60px; }
      .hero-berita h1 { font-size: 2rem; }
      .kategori-tabs { justify-content: center; }
    }
  </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'informasi']); ?>

<main>
  <section class="hero-berita">
    <div class="container-custom">
      <h1><?= $title ?></h1>
      <p>Arsip berita dan informasi Fakultas Industri Kreatif bulan <?= date('F Y', strtotime($year . '-' . $month . '-01')) ?></p>
    </div>
  </section>

  <div class="container-custom" style="padding: 60px 0;">
    <div class="row">
      <div class="col-lg-8">
        <div class="kategori-tabs">
          <a href="<?= base_url('berita') ?>" class="kategori-tab">Semua</a>
          <a href="<?= base_url('berita/kategori/berita') ?>" class="kategori-tab">Berita</a>
          <a href="<?= base_url('berita/kategori/pengumuman') ?>" class="kategori-tab">Pengumuman</a>
          <a href="<?= base_url('berita/kategori/artikel') ?>" class="kategori-tab">Artikel</a>
        </div>

        <div class="row">
          <?php if(!empty($berita)): ?>
            <?php foreach($berita as $b): ?>
            <div class="col-md-6">
              <div class="berita-card">
                <div class="gambar">
                  <?php if(!empty($b['gambar']) && file_exists('./uploads/berita/' . $b['gambar'])): ?>
                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>">
                  <?php else: ?>
                    <i class="fas fa-newspaper"></i>
                  <?php endif; ?>
                </div>
                <div class="konten">
                  <span class="kategori-badge <?= $b['kategori'] ?>"><?= ucfirst($b['kategori']) ?></span>
                  <h4><a href="<?= base_url('berita/detail/' . $b['slug']) ?>"><?= htmlspecialchars($b['judul']) ?></a></h4>
                  <div class="meta">
                    <i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($b['published_at'])) ?>
                    <i class="fas fa-eye ms-3"></i> <?= number_format($b['views']) ?> views
                  </div>
                  <p class="ringkasan"><?= substr(strip_tags($b['ringkasan']), 0, 100) ?>...</p>
                  <a href="<?= base_url('berita/detail/' . $b['slug']) ?>" class="read-more">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center py-5">
              <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
              <h4 class="text-muted">Belum Ada Berita</h4>
              <p class="text-muted">Tidak ada berita yang dipublikasikan pada bulan ini.</p>
            </div>
          <?php endif; ?>
        </div>

        <?php if(isset($total_pages) && $total_pages > 1): ?>
        <div class="pagination">
          <?php if($current_page > 1): ?>
            <a href="?page=<?= $current_page-1 ?>">&laquo; Sebelumnya</a>
          <?php endif; ?>
          <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <?php if($i == $current_page): ?>
              <span class="active"><?= $i ?></span>
            <?php else: ?>
              <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
          <?php if($current_page < $total_pages): ?>
            <a href="?page=<?= $current_page+1 ?>">Selanjutnya &raquo;</a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-4">
        <div class="sidebar-card">
          <h4><i class="fas fa-fire text-warning me-2"></i> Berita Populer</h4>
          <ul class="popular-list">
            <?php if(!empty($populer)): ?>
              <?php foreach($populer as $p): ?>
              <li>
                <a href="<?= base_url('berita/detail/' . $p['slug']) ?>"><?= htmlspecialchars($p['judul']) ?></a>
                <div class="views"><i class="fas fa-eye"></i> <?= number_format($p['views']) ?> views</div>
              </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>Belum ada data</li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="sidebar-card">
          <h4><i class="fas fa-archive me-2"></i> Arsip</h4>
          <ul class="archive-list">
            <?php if(!empty($archive)): ?>
              <?php foreach($archive as $a): ?>
              <li>
                <a href="<?= base_url('berita/archive/' . str_replace('-', '/', $a['month'])) ?>">
                  <?= $a['month_name'] ?>
                  <span><?= $a['total'] ?></span>
                </a>
              </li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>Belum ada arsip</li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="sidebar-card">
          <h4><i class="fas fa-tags me-2"></i> Kategori</h4>
          <ul class="archive-list">
            <li><a href="<?= base_url('berita/kategori/berita') ?>">Berita <span><?= $this->Berita_model->count_berita('berita') ?></span></a></li>
            <li><a href="<?= base_url('berita/kategori/pengumuman') ?>">Pengumuman <span><?= $this->Berita_model->count_berita('pengumuman') ?></span></a></li>
            <li><a href="<?= base_url('berita/kategori/artikel') ?>">Artikel <span><?= $this->Berita_model->count_berita('artikel') ?></span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container-custom">
    <div class="row">
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: #f97316;">Fakultas Industri Kreatif</h4>
        <p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p>
      </div>
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: #f97316;">Tautan Cepat</h4>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="mb-2"><a href="<?= base_url('berita') ?>">Berita</a></li>
          <li class="mb-2"><a href="#">Layanan Mahasiswa</a></li>
          <li class="mb-2"><a href="#">Forum Alumni</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-4">
        <h4 class="mb-3" style="color: #f97316;">Kontak</h4>
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

<script>
</script>
</body>
</html>