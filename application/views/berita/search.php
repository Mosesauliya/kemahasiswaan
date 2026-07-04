<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <title>Pencarian: <?= htmlspecialchars($keyword) ?> - Fakultas Industri Kreatif</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />
  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: #ffffff; color: #1f2937; overflow-x: hidden; }
    :root { --orange: #f97316; --orange-dark: #ea580c; --orange-light: #ffedd5; --blue: #1e3a8a; }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }
    @keyframes shimmer {
      0% { background-position: -1000px 0; }
      100% { background-position: 1000px 0; }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    .bg-orange-grad { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); position: relative; }
    .container-custom { width: min(100% - 3rem, 1280px); margin-inline: auto; }

    /* HEADER GLASS */
    .header-glass { position: absolute; top: 24px; left: 0; right: 0; z-index: 50; }
    .navbar-glass { background: rgba(0, 0, 0, 0.55); backdrop-filter: blur(20px); border-radius: 60px; padding: 12px 32px; border: 1px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; transition: all 0.3s ease; }
    .navbar-glass.scrolled { background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(25px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    .logo-area { display: flex; align-items: center; gap: 16px; }
    .logo-icon { width: 48px; height: 48px; background: linear-gradient(145deg, var(--orange), var(--orange-dark)); border-radius: 18px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.4rem; box-shadow: 0 6px 12px rgba(249,115,22,0.3); }
    .logo-text h5 { font-size: 0.9rem; font-weight: 800; color: white; margin: 0; letter-spacing: -0.3px; }
    .logo-text span { font-size: 0.7rem; color: rgba(255,255,255,0.85); }
    .nav-links { display: flex; gap: 2rem; align-items: center; }
    .nav-links a { color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; position: relative; padding-bottom: 4px; }
    .nav-links a::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0%; height: 2px; background: var(--orange); transition: 0.3s ease; }
    .nav-links a:hover::after, .nav-links a.active::after { width: 100%; }

    /* Dropdown Menu */
    .nav-item-dropdown { position: relative; }
    .dropdown-menu-custom { position: absolute; top: 100%; left: 0; background: rgba(0, 0, 0, 0.85); backdrop-filter: blur(20px); border-radius: 20px; padding: 0.8rem 0; min-width: 240px; border: 1px solid rgba(255,255,255,0.15); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s ease; z-index: 1000; }
    .nav-item-dropdown:hover .dropdown-menu-custom { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-menu-custom a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: white; text-decoration: none; transition: all 0.2s ease; font-weight: 500; border-bottom: none !important; }
    .dropdown-menu-custom a::after { display: none; }
    .dropdown-menu-custom a:hover { background: rgba(249,115,22,0.3); color: var(--orange); padding-left: 28px; }
    .dropdown-menu-custom i { width: 24px; font-size: 1.1rem; color: var(--orange); }
    .dropdown-toggle-icon { margin-left: 6px; font-size: 0.7rem; transition: transform 0.3s ease; }
    .nav-item-dropdown:hover .dropdown-toggle-icon { transform: rotate(180deg); }

    .btn-mytelu-custom { background: linear-gradient(105deg, var(--orange), var(--orange-dark)); padding: 8px 28px; border-radius: 40px; font-weight: 700; color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; transition: 0.3s; }
    .btn-mytelu-custom:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(249,115,22,0.4); color: white; }
    .user-avatar-small { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; background: white; }
    .mobile-toggle { display: none; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 8px 14px; font-size: 1.4rem; color: white; cursor: pointer; }

    /* HERO SECTION */
    .hero-berita { background: linear-gradient(135deg, #f97316 0%, #fdba74 100%); padding: 160px 0 100px; text-align: center; color: white; position: relative; overflow: hidden; }
    .hero-berita::before { content: ""; position: absolute; inset: 0; background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px); background-size: 32px 32px; pointer-events: none; }
    .hero-berita .wave-bottom { position: absolute; bottom: -2px; left: 0; width: 100%; line-height: 0; }
    .hero-berita h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1rem; position: relative; z-index: 1; animation: fadeInUp 0.8s ease; }
    .hero-berita p { font-size: 1.2rem; max-width: 600px; margin: 0 auto; opacity: 0.9; position: relative; z-index: 1; animation: fadeInUp 0.8s ease 0.1s both; }
    .hero-berita .keyword-highlight { background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 30px; display: inline-block; }

    /* SEARCH BOX */
    .search-box { max-width: 550px; margin: 30px auto 0; position: relative; z-index: 1; }
    .search-box input { width: 100%; padding: 16px 24px; border: none; border-radius: 60px; font-size: 1rem; box-shadow: 0 12px 30px rgba(0,0,0,0.12); transition: all 0.3s ease; background: rgba(255,255,255,0.95); }
    .search-box input:focus { outline: none; box-shadow: 0 12px 30px rgba(0,0,0,0.2); transform: scale(1.02); }
    .search-box button { position: absolute; right: 8px; top: 8px; background: var(--orange); color: white; border: none; padding: 8px 28px; border-radius: 50px; font-weight: 600; transition: all 0.3s ease; cursor: pointer; }
    .search-box button:hover { background: var(--orange-dark); transform: scale(1.02); }

    /* SEARCH STATS */
    .search-stats { background: white; border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 5px 20px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; transition: all 0.3s ease; }
    .search-stats:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(249,115,22,0.1); }
    .search-stats .result-count strong { color: var(--orange); font-size: 1.5rem; margin-right: 5px; }
    .search-stats .result-count { font-size: 1rem; color: #6b7280; }
    .search-stats .suggestion { font-size: 0.85rem; color: var(--orange); }

    /* BERITA CARDS */
    .berita-card { background: white; border-radius: 24px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1); height: 100%; margin-bottom: 30px; opacity: 0; animation: fadeInUp 0.6s ease forwards; }
    .berita-card:nth-child(1) { animation-delay: 0.1s; }
    .berita-card:nth-child(2) { animation-delay: 0.2s; }
    .berita-card:nth-child(3) { animation-delay: 0.3s; }
    .berita-card:nth-child(4) { animation-delay: 0.4s; }
    .berita-card:hover { transform: translateY(-8px); box-shadow: 0 25px 40px -12px rgba(249,115,22,0.25); }
    .berita-card .gambar { height: 210px; overflow: hidden; background: linear-gradient(135deg, #fef3c7 0%, #ffedd5 100%); display: flex; align-items: center; justify-content: center; position: relative; }
    .berita-card .gambar img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .berita-card:hover .gambar img { transform: scale(1.08); }
    .berita-card .gambar i { font-size: 3rem; color: #cbd5e1; transition: transform 0.3s ease; }
    .berita-card:hover .gambar i { transform: scale(1.1); }
    .berita-card .kategori-badge { display: inline-block; background: var(--orange); color: white; padding: 5px 14px; border-radius: 30px; font-size: 0.7rem; font-weight: 700; margin-bottom: 1rem; transition: all 0.3s ease; }
    .berita-card .kategori-badge.pengumuman { background: var(--blue); }
    .berita-card .kategori-badge.artikel { background: #10b981; }
    .berita-card:hover .kategori-badge { transform: translateX(5px); }
    .berita-card .konten { padding: 1.5rem; }
    .berita-card h4 { font-size: 1.2rem; font-weight: 800; margin-bottom: 0.5rem; line-height: 1.4; }
    .berita-card h4 a { color: #1f2937; text-decoration: none; transition: color 0.2s; }
    .berita-card h4 a:hover { color: var(--orange); }
    .berita-card .meta { font-size: 0.75rem; color: #6b7280; margin-bottom: 1rem; }
    .berita-card .meta i { color: var(--orange); margin-right: 4px; }
    .berita-card .ringkasan { color: #6b7280; font-size: 0.85rem; line-height: 1.6; margin-bottom: 1rem; }
    .berita-card .ringkasan mark { background: var(--orange-light); color: var(--orange); padding: 2px 4px; border-radius: 4px; }
    .berita-card .read-more { color: var(--orange); text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; }
    .berita-card .read-more:hover { gap: 12px; }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 4rem 2rem; background: white; border-radius: 24px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); opacity: 0; animation: fadeInUp 0.6s ease forwards; }
    .empty-state i { font-size: 5rem; color: #cbd5e1; margin-bottom: 1.5rem; animation: float 3s ease-in-out infinite; }
    .empty-state h3 { font-size: 1.8rem; color: #1f2937; margin-bottom: 1rem; }
    .empty-state p { color: #6b7280; margin-bottom: 2rem; }

    /* SIDEBAR */
    .sidebar-card { background: white; border-radius: 24px; padding: 1.5rem; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem; transition: all 0.3s ease; opacity: 0; animation: fadeInUp 0.6s ease 0.3s forwards; }
    .sidebar-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .sidebar-card h4 { color: #1f2937; font-weight: 800; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 3px solid var(--orange); display: inline-block; font-size: 1.1rem; }
    .popular-list, .archive-list { list-style: none; padding: 0; }
    .popular-list li, .archive-list li { padding: 12px 0; border-bottom: 1px solid #e2e8f0; transition: all 0.2s ease; }
    .popular-list li:last-child, .archive-list li:last-child { border-bottom: none; }
    .popular-list li a, .archive-list li a { color: #1f2937; text-decoration: none; font-weight: 600; display: block; transition: color 0.2s; }
    .popular-list li a:hover, .archive-list li a:hover { color: var(--orange); transform: translateX(5px); }
    .popular-list .views { font-size: 0.7rem; color: #6b7280; margin-top: 4px; display: inline-block; }
    .archive-list li a { display: flex; justify-content: space-between; align-items: center; }
    .archive-list li span { background: #f1f5f9; padding: 2px 10px; border-radius: 20px; font-size: 0.7rem; transition: all 0.2s; }
    .archive-list li:hover span { background: var(--orange); color: white; }

    /* PAGINATION */
    .pagination { display: flex; justify-content: center; gap: 10px; margin: 40px 0; opacity: 0; animation: fadeInUp 0.6s ease 0.5s forwards; }
    .pagination a, .pagination span { padding: 8px 16px; border-radius: 12px; text-decoration: none; color: #1f2937; background: #f1f5f9; transition: all 0.3s ease; font-weight: 600; }
    .pagination a:hover { background: var(--orange); color: white; transform: translateY(-2px); }
    .pagination .active { background: var(--orange); color: white; box-shadow: 0 6px 12px rgba(249,115,22,0.3); }

    /* BACK TO TOP BUTTON */
    .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px; background: var(--orange); color: white; border: none; border-radius: 50%; cursor: pointer; display: none; align-items: center; justify-content: center; transition: all 0.3s ease; z-index: 100; box-shadow: 0 5px 15px rgba(249,115,22,0.3); }
    .back-to-top:hover { transform: translateY(-5px); background: var(--orange-dark); }
    .back-to-top.show { display: flex; animation: fadeInUp 0.3s ease; }

    /* FOOTER */
    .footer { background: linear-gradient(135deg, var(--blue) 0%, #1e293b 100%); color: white; padding: 60px 0 30px; margin-top: 60px; }
    .footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: color 0.2s; }
    .footer a:hover { color: var(--orange); }
    .footer-bottom { text-align: center; padding-top: 30px; margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .navbar-glass { flex-direction: row; flex-wrap: wrap; padding: 12px 20px; }
      .nav-links { display: none; width: 100%; flex-direction: column; margin-top: 12px; gap: 16px; align-items: flex-start; }
      .nav-links.open { display: flex !important; }
      .mobile-toggle { display: block; }
      .hero-berita { padding: 120px 0 60px; }
      .hero-berita h1 { font-size: 2rem; }
      .dropdown-menu-custom { position: static; opacity: 1; visibility: visible; transform: none; display: none; background: transparent; backdrop-filter: none; padding-left: 20px; border: none; }
      .dropdown-menu-custom.show-mobile { display: block; }
      .nav-item-dropdown .dropdown-toggle-icon { display: inline-block; }
      .back-to-top { bottom: 20px; right: 20px; width: 40px; height: 40px; }
    }
  </style>
</head>
<body>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTopBtn">
  <i class="fas fa-arrow-up"></i>
</button>

<header class="header-glass">
  <div class="container-custom">
    <div class="navbar-glass" id="navbar">
      <div class="logo-area">
        <div class="logo-icon"><i class="fas fa-palette"></i></div>
        <div class="logo-text">
          <h5>Unit Kemahasiswaan</h5>
          <span>Fakultas Industri Kreatif</span>
        </div>
      </div>
      
      <div class="nav-links" id="navLinks">
        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('berita') ?>" class="active">Informasi</a>
        
        <!-- Dropdown Layanan -->
        <div class="nav-item-dropdown">
          <a href="#">Layanan <i class="fas fa-chevron-down dropdown-toggle-icon"></i></a>
          <div class="dropdown-menu-custom">
            <a href="<?= base_url('layanan/beasiswa') ?>"><i class="fas fa-graduation-cap"></i> Pengajuan Beasiswa</a>
            <a href="<?= base_url('layanan/sertifikat') ?>"><i class="fas fa-certificate"></i> Pengajuan Sertifikat</a>
            <a href="<?= base_url('layanan/proposal') ?>"><i class="fas fa-file-alt"></i> Pengajuan Proposal</a>
            <a href="<?= base_url('layanan/tak') ?>"><i class="fas fa-clipboard-list"></i> Pengajuan TAK</a>
            <a href="<?= base_url('layanan/forum_alumni') ?>"><i class="fas fa-users"></i> Layanan Alumni</a>
          </div>
        </div>
        
        <a href="#">Forum Alumni</a>
      </div>
      
      <?php if(isset($user_data) && $user_data && $user_data['logged_in']): ?>
        <a href="<?= base_url('dashboard/profile') ?>" class="btn-mytelu-custom">
          <?php if(!empty($user_data['foto'])): ?>
            <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" class="user-avatar-small">
          <?php else: ?>
            <i class="fas fa-user-circle"></i>
          <?php endif; ?>
          <?= htmlspecialchars($user_data['nama']) ?>
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

<main>
  <section class="hero-berita">
    <div class="container-custom">
      <h1><i class="fas fa-search me-3"></i>Pencarian</h1>
      <p>Hasil pencarian untuk: <span class="keyword-highlight"><strong>"<?= htmlspecialchars($keyword) ?>"</strong></span></p>
      
      <form action="<?= base_url('berita/search') ?>" method="GET" class="search-box">
        <input type="text" name="q" placeholder="Cari berita, artikel, atau pengumuman..." value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit"><i class="fas fa-search"></i> Cari</button>
      </form>
    </div>
    <div class="wave-bottom">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
        <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
      </svg>
    </div>
  </section>

  <div class="container-custom" style="padding: 60px 0;">
    <div class="row">
      <div class="col-lg-8">
        <div class="search-stats" data-aos="fade-up">
          <div class="result-count">
            <i class="fas fa-file-alt me-2" style="color: var(--orange);"></i>
            <strong><?= number_format($total) ?></strong> hasil ditemukan
          </div>
          <?php if($total > 0): ?>
          <div class="suggestion">
            <i class="fas fa-lightbulb me-1"></i> Menampilkan <?= $total > 0 ? 'berita terkait' : 'saran pencarian lain' ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="row">
          <?php if(!empty($berita)): ?>
            <?php foreach($berita as $index => $b): ?>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="<?= 100 + ($index * 50) ?>">
              <div class="berita-card">
                <div class="gambar">
                  <?php if(!empty($b['gambar']) && file_exists('./uploads/berita/' . $b['gambar'])): ?>
                    <img src="<?= base_url('uploads/berita/' . $b['gambar']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>" loading="lazy">
                  <?php else: ?>
                    <i class="fas fa-newspaper"></i>
                  <?php endif; ?>
                </div>
                <div class="konten">
                  <span class="kategori-badge <?= $b['kategori'] ?>">
                    <i class="fas fa-tag me-1"></i> <?= ucfirst($b['kategori']) ?>
                  </span>
                  <h4><a href="<?= base_url('berita/detail/' . $b['slug']) ?>"><?= htmlspecialchars($b['judul']) ?></a></h4>
                  <div class="meta">
                    <i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($b['published_at'])) ?>
                    <i class="fas fa-eye ms-3"></i> <?= number_format($b['views']) ?> views
                  </div>
                  <p class="ringkasan">
                    <?php 
                      $ringkasan = strip_tags($b['ringkasan']);
                      // Highlight keyword in ringkasan
                      $keyword_escaped = preg_quote($keyword, '/');
                      $ringkasan = preg_replace('/(' . $keyword_escaped . ')/iu', '<mark>$1</mark>', $ringkasan);
                      echo substr($ringkasan, 0, 100) . '...';
                    ?>
                  </p>
                  <a href="<?= base_url('berita/detail/' . $b['slug']) ?>" class="read-more">
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12">
              <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-search"></i>
                <h3>Tidak Ditemukan</h3>
                <p>Maaf, tidak ada berita, artikel, atau pengumuman yang sesuai dengan kata kunci <strong>"<?= htmlspecialchars($keyword) ?>"</strong>.</p>
                <a href="<?= base_url('berita') ?>" class="btn-mytelu-custom" style="display: inline-block; background: transparent; border: 2px solid var(--orange); color: var(--orange);">
                  <i class="fas fa-arrow-left me-2"></i>Kembali ke Berita
                </a>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <?php if(isset($total_pages) && $total_pages > 1): ?>
        <div class="pagination">
          <?php if($current_page > 1): ?>
            <a href="?q=<?= urlencode($keyword) ?>&page=<?= $current_page-1 ?>">
              <i class="fas fa-chevron-left me-1"></i> Sebelumnya
            </a>
          <?php endif; ?>
          
          <?php 
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);
            
            if($start_page > 1): ?>
              <a href="?q=<?= urlencode($keyword) ?>&page=1">1</a>
              <?php if($start_page > 2): ?><span>...</span><?php endif; ?>
          <?php endif; ?>
          
          <?php for($i = $start_page; $i <= $end_page; $i++): ?>
            <?php if($i == $current_page): ?>
              <span class="active"><?= $i ?></span>
            <?php else: ?>
              <a href="?q=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
          <?php endfor; ?>
          
          <?php if($end_page < $total_pages): ?>
            <?php if($end_page < $total_pages - 1): ?><span>...</span><?php endif; ?>
            <a href="?q=<?= urlencode($keyword) ?>&page=<?= $total_pages ?>"><?= $total_pages ?></a>
          <?php endif; ?>
          
          <?php if($current_page < $total_pages): ?>
            <a href="?q=<?= urlencode($keyword) ?>&page=<?= $current_page+1 ?>">
              Selanjutnya <i class="fas fa-chevron-right ms-1"></i>
            </a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-4">
        <div class="sidebar-card" data-aos="fade-up" data-aos-delay="200">
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
              <li class="text-muted text-center py-2">Belum ada data</li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="sidebar-card" data-aos="fade-up" data-aos-delay="300">
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
              <li class="text-muted text-center py-2">Belum ada arsip</li>
            <?php endif; ?>
          </ul>
        </div>

        <!-- Tips Pencarian -->
        <div class="sidebar-card" data-aos="fade-up" data-aos-delay="400">
          <h4><i class="fas fa-lightbulb me-2"></i> Tips Pencarian</h4>
          <ul class="popular-list">
            <li><i class="fas fa-check-circle me-2" style="color: var(--orange);"></i> Gunakan kata kunci yang spesifik</li>
            <li><i class="fas fa-check-circle me-2" style="color: var(--orange);"></i> Periksa ejaan kata kunci Anda</li>
            <li><i class="fas fa-check-circle me-2" style="color: var(--orange);"></i> Coba gunakan kata kunci yang lebih umum</li>
            <li><i class="fas fa-check-circle me-2" style="color: var(--orange);"></i> Jelajahi kategori berita untuk informasi terkait</li>
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
        <h4 class="mb-3" style="color: var(--orange);">Fakultas Industri Kreatif</h4>
        <p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
          <a href="#"><i class="fab fa-linkedin-in fa-lg"></i></a>
          <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
        </div>
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
  // Initialize AOS
  AOS.init({ duration: 800, once: true, offset: 50 });

  // Mobile toggle
  const mobileBtn = document.getElementById('mobileNavBtn');
  const navLinks = document.getElementById('navLinks');
  if(mobileBtn) {
    mobileBtn.addEventListener('click', () => { 
      navLinks.classList.toggle('open');
      
      // Handle mobile dropdown
      if(navLinks.classList.contains('open')) {
        const dropdown = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
        if(dropdown) dropdown.classList.add('show-mobile');
      } else {
        const dropdown = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
        if(dropdown) dropdown.classList.remove('show-mobile');
      }
    });
  }

  // Mobile dropdown toggle
  if(window.innerWidth <= 768) {
    const dropdownToggle = document.querySelector('.nav-item-dropdown > a');
    if(dropdownToggle) {
      dropdownToggle.addEventListener('click', function(e) {
        e.preventDefault();
        const dropdownMenu = document.querySelector('.nav-item-dropdown .dropdown-menu-custom');
        if(dropdownMenu) dropdownMenu.classList.toggle('show-mobile');
      });
    }
  }

  // Navbar scroll effect
  window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // Back to Top Button
  const backToTopBtn = document.getElementById('backToTopBtn');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      backToTopBtn.classList.add('show');
    } else {
      backToTopBtn.classList.remove('show');
    }
  });
  
  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // Fix gambar error
  document.querySelectorAll('img').forEach(img => {
    img.addEventListener('error', function() {
      if(!this.src.includes('placehold.co')) {
        this.parentElement.innerHTML = '<i class="fas fa-newspaper"></i>';
      }
    });
  });
</script>
</body>
</html>