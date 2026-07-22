<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Tentang Kami' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8fafc;
      color: #1f2937;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .bg-orange-grad {
      background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
      position: relative;
      color: white;
      padding: 160px 0 6rem 0;
      text-align: center;
    }
    .bg-orange-grad::before {
      content: "";
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
      background-size: 32px 32px;
      pointer-events: none;
    }
    .navbar-custom {
      background: white;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      padding: 1rem 0;
    }
    .container-custom {
      width: min(100% - 3rem, 1280px);
      margin-inline: auto;
    }
    .content-box {
      background: white;
      border-radius: 16px;
      padding: 3rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      margin-top: -4rem;
      position: relative;
      z-index: 10;
    }
    .banner-img {
      width: 100%;
      max-height: 450px;
      object-fit: cover;
      border-radius: 16px;
      margin-bottom: 2.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .content-html {
      line-height: 1.8;
      font-size: 1.05rem;
      color: #4b5563;
    }
    .content-html h1, .content-html h2, .content-html h3 {
      color: #1f2937;
      margin-top: 2rem;
      margin-bottom: 1rem;
      font-weight: 700;
    }
    .content-html img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .btn-back {
      background: white;
      color: #f97316;
      border: 2px solid #f97316;
      padding: 0.6rem 2rem;
      border-radius: 25px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      margin-top: 3rem;
      transition: all 0.3s;
    }
    .btn-back:hover {
      background: #f97316;
      color: white;
    }
    
    @media (max-width: 768px) {
        .content-box { padding: 1.5rem; }
    }
  </style>
</head>
<body>

  <?php $this->load->view('partials/navbar', ['active_menu' => 'tentangkami']); ?>

  <div class="bg-orange-grad">
    <div class="container position-relative z-1">
      <h1 class="display-4 fw-bold mb-3"><?= isset($profil) && !empty($profil->judul) ? htmlspecialchars($profil->judul) : 'Tentang Kami' ?></h1>
      <p class="lead opacity-75">Mengenal lebih dekat Fakultas Industri Kreatif Telkom University</p>
    </div>
  </div>

  <div class="container mb-5 flex-grow-1">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="content-box">
          
          <div class="content-html">
            <?php if (isset($profil) && !empty($profil->isi)): ?>
              <?= $profil->isi ?>
            <?php else: ?>
              <p class="text-center text-muted my-5">
                <i class="fas fa-info-circle fa-3x mb-3 text-light"></i><br>
                <i>Konten belum tersedia. Silakan atur melalui panel Admin.</i>
              </p>
            <?php endif; ?>
          </div>

          <div class="text-center">
            <a href="<?= base_url('dashboard') ?>" class="btn-back"><i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('partials/footer'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
