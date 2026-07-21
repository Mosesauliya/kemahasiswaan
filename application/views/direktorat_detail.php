<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= htmlspecialchars($title) ?> | FIK Telkom University</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --blue: #1e3a8a;
            --blue-dark: #0f2b66;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1f2937;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--orange); border-radius: 10px; }

        .berita-header {
            position: relative;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .berita-header .bg-image {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }

        .berita-header .bg-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.75) 100%);
            z-index: 1;
        }

        .berita-header .container { position: relative; z-index: 2; padding: 120px 20px 80px; }

        .breadcrumb-custom .breadcrumb { background: transparent; margin-bottom: 20px; }
        .breadcrumb-custom .breadcrumb-item a { color: rgba(255,255,255,0.85); text-decoration: none; font-weight: 500; transition: color .3s; }
        .breadcrumb-custom .breadcrumb-item a:hover { color: var(--orange); }
        .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.5); }
        .breadcrumb-custom .breadcrumb-item.active { color: var(--orange); }

        .berita-header h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 3.2rem;
            line-height: 1.2;
            text-shadow: 0 4px 30px rgba(0,0,0,0.3);
            max-width: 900px;
            margin: 0 auto;
        }

        .berita-meta {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 25px;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .berita-meta span i { margin-right: 6px; color: var(--orange); }

        .container-content { max-width: 1280px; margin: -80px auto 60px; position: relative; z-index: 3; padding: 0 20px; }

        .berita-content {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }

        .berita-content p {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #374151;
            margin-bottom: 1.5rem;
        }

        .sidebar-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            margin-bottom: 24px;
        }
        .sidebar-card h4 { font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; }

        .share-title {
            font-weight: 700; font-size: 0.95rem; margin-bottom: 15px; color: #1f2937;
        }
        .share-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; border-radius: 12px;
            text-decoration: none; font-weight: 500; font-size: 0.88rem;
            transition: all .3s; margin-bottom: 8px; color: #374151;
        }
        .share-btn:hover { background: #f1f5f9; transform: translateX(4px); color: #1f2937; }
        .share-btn i { width: 20px; text-align: center; font-size: 1.1rem; }
        .share-btn:nth-child(2) i { color: #1877f2; }
        .share-btn:nth-child(3) i { color: #1da1f2; }
        .share-btn:nth-child(4) i { color: #25d366; }
        .share-btn:last-child i { color: var(--orange); }

        .btn-outline-custom {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 24px; border-radius: 30px;
            border: 2px solid var(--orange); color: var(--orange);
            font-weight: 600; text-decoration: none; transition: all .3s;
        }
        .btn-outline-custom:hover { background: var(--orange); color: white; }

        @media (max-width: 768px) {
            .berita-header { min-height: 50vh; }
            .berita-header h1 { font-size: 1.8rem; }
            .container-content { margin-top: -40px; }
            .berita-content { padding: 24px; }
            .berita-content p { font-size: 0.95rem; }
            .berita-header .container { padding: 100px 16px 60px; }
        }
    </style>
</head>
<body>
<?php $this->load->view('partials/navbar', ['active_menu' => 'dashboard']); ?>

<!-- Hero Section -->
<div class="berita-header">
    <div class="bg-image" style="background-image: url('<?= base_url($direktorat && $direktorat->gambar ? $direktorat->gambar : 'assets/Direktorat.png') ?>');"></div>
    <div class="container">
        <div class="breadcrumb-custom">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Direktorat</li>
                </ol>
            </nav>
        </div>

        <h1 data-aos="fade-up"><?= htmlspecialchars($direktorat ? $direktorat->judul : 'Direktorat') ?></h1>
    </div>
</div>

<!-- Main Content -->
<div class="container-content">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="berita-content" data-aos="fade-up">
                <?php if ($direktorat): ?>
                    <p><?= nl2br(htmlspecialchars($direktorat->isi)) ?></p>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Konten belum tersedia.</p>
                    </div>
                <?php endif; ?>

                <hr class="my-5">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="<?= base_url() ?>" class="btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                    <div>
                        <small class="text-muted me-2">Bagikan:</small>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="text-decoration-none me-2" style="color: #1877f2;"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($direktorat ? $direktorat->judul : 'Direktorat') ?>" target="_blank" class="text-decoration-none me-2" style="color: #1da1f2;"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="https://wa.me/?text=<?= urlencode(($direktorat ? $direktorat->judul : 'Direktorat') . ' - ' . current_url()) ?>" target="_blank" class="text-decoration-none me-2" style="color: #25d366;"><i class="fab fa-whatsapp fa-lg"></i></a>
                        <a href="#" class="text-decoration-none" id="copyLinkBtn" style="color: var(--orange);"><i class="fas fa-link fa-lg"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Unified Sidebar Card -->
            <div class="sidebar-card" data-aos="fade-left">
                <h4 style="color: #1e3a8a; border-bottom: 2px solid var(--orange); padding-bottom: 12px; margin-bottom: 16px; font-weight: 700; font-size: 1.1rem;">
                    <i class="fas fa-building me-2" style="color: var(--orange);"></i> Tentang Direktorat
                </h4>
                
                <div class="dir-text-wrap" style="font-size: 0.92rem; line-height: 1.8; color: #4b5563; text-align: justify; max-height: 350px; overflow-y: auto; padding-right: 8px; margin-bottom: 20px;">
                    <?= ($direktorat && !empty(trim($direktorat->link))) ? nl2br(htmlspecialchars($direktorat->link)) : 'Direktorat Kemahasiswaan, Karier dan Alumni (KKA) berperan dalam mengelola prestasi, kegiatan mahasiswa, pengembangan karakter, kesejahteraan mahasiswa, pengembangan karier dan kontribusi alumni di lingkungan Fakultas Industri Kreatif Telkom University.' ?>
                </div>

                <div style="border-top: 1px dashed #e2e8f0; padding-top: 16px;">
                    <div class="share-title" style="font-size: 0.85rem; font-weight: 700; color: #64748b; margin-bottom: 12px;">
                        <i class="fas fa-share-alt me-2" style="color: var(--orange);"></i> Bagikan Halaman:
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" class="share-pill" title="Facebook" style="background: #eff6ff; color: #1877f2; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($direktorat ? $direktorat->judul : 'Direktorat') ?>" target="_blank" class="share-pill" title="Twitter" style="background: #f0f9ff; color: #1da1f2; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/?text=<?= urlencode(($direktorat ? $direktorat->judul : 'Direktorat') . ' - ' . current_url()) ?>" target="_blank" class="share-pill" title="WhatsApp" style="background: #f0fdf4; color: #25d366; width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="share-pill" id="copyLinkBtnSidebar" title="Salin Link" style="background: #fff7ed; color: var(--orange); width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: transform 0.2s;"><i class="fas fa-link"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({
    duration: 800,
    once: true,
    offset: 60
});

document.getElementById('copyLinkBtn')?.addEventListener('click', function(e) {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href).then(() => {
        const orig = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check" style="color:#22c55e;"></i>';
        setTimeout(() => this.innerHTML = orig, 2000);
    });
});

document.getElementById('copyLinkBtnSidebar')?.addEventListener('click', function(e) {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href).then(() => {
        const orig = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check me-1" style="color:#22c55e;"></i> Tersalin!';
        setTimeout(() => this.innerHTML = orig, 2000);
    });
});
</script>
</body>
</html>
