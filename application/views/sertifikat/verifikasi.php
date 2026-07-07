<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | Kemahasiswaan FIK</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 28px;
            padding: 0;
            max-width: 520px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
        }
        .card-header {
            padding: 2.5rem 2.5rem 2rem;
            text-align: center;
        }
        .card-header.valid { background: linear-gradient(135deg, #059669, #10b981); }
        .card-header.invalid { background: linear-gradient(135deg, #dc2626, #ef4444); }
        .status-icon {
            width: 80px; height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.2rem;
            font-size: 2.5rem; color: white;
        }
        .card-header h1 { color: white; font-size: 1.6rem; font-weight: 800; margin-bottom: .4rem; }
        .card-header p { color: rgba(255,255,255,0.85); font-size: 0.9rem; }
        .card-body { padding: 2rem 2.5rem 2.5rem; }
        .info-row {
            display: flex; gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label {
            font-size: 0.8rem; font-weight: 600;
            color: #94a3b8; text-transform: uppercase;
            letter-spacing: .5px; min-width: 140px;
        }
        .info-value { font-weight: 600; color: #1e293b; font-size: 0.95rem; }
        .nomor-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white; font-weight: 700;
            padding: 6px 18px; border-radius: 20px;
            font-size: 1rem; letter-spacing: 1px;
        }
        .qr-section {
            text-align: center;
            background: #f8fafc;
            border-radius: 16px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        .qr-section canvas { border-radius: 12px; }
        .qr-section p { font-size: 0.75rem; color: #94a3b8; margin-top: .8rem; }
        .btn-back {
            display: block; width: 100%; text-align: center;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white; font-weight: 700; font-size: 0.95rem;
            padding: 14px; border-radius: 14px;
            text-decoration: none; margin-top: 1.5rem;
            transition: all .3s;
        }
        .btn-back:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(249,115,22,.4); color: white; }
        .footer-note {
            text-align: center; font-size: 0.75rem; color: #94a3b8; margin-top: 1rem;
        }

        /* Responsive Styles */
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
            .card {
                border-radius: 20px;
            }
            .card-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            .card-header h1 {
                font-size: 1.4rem;
            }
            .card-body {
                padding: 1.5rem 1.25rem 1.75rem;
            }
            .info-row {
                flex-direction: column;
                gap: 0.25rem;
                align-items: flex-start;
                padding: 0.8rem 0;
            }
            .info-label {
                min-width: auto;
                width: 100%;
                font-size: 0.75rem;
            }
            .info-value {
                width: 100%;
                font-size: 0.9rem;
            }
            .nomor-badge {
                font-size: 0.9rem;
                padding: 4px 12px;
                word-break: break-all;
            }
            .qr-section {
                padding: 1rem;
                margin: 1rem 0;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($sertifikat): ?>
        <!-- VALID -->
        <div class="card-header valid">
            <div class="status-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Sertifikat Valid ✓</h1>
            <p>Sertifikat ini telah diverifikasi dan disetujui oleh Kemahasiswaan FIK</p>
        </div>
        <div class="card-body">
            <div class="qr-section">
                <canvas id="qrCanvas"></canvas>
                <p>QR Code Sertifikat</p>
            </div>

            <div class="info-row">
                <span class="info-label">Nomor Sertifikat</span>
                <span class="info-value"><span class="nomor-badge"><?= htmlspecialchars($sertifikat['nomor_sertifikat']) ?></span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Mahasiswa</span>
                <span class="info-value"><?= htmlspecialchars($sertifikat['nama_mahasiswa']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">NIM</span>
                <span class="info-value"><?= htmlspecialchars($sertifikat['nim'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Program Studi</span>
                <span class="info-value"><?= htmlspecialchars($sertifikat['prodi'] ?? '-') ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Kegiatan</span>
                <span class="info-value"><?= htmlspecialchars($sertifikat['judul_kegiatan']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Kegiatan</span>
                <span class="info-value"><?= date('d F Y', strtotime($sertifikat['tanggal_kegiatan'])) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Lokasi</span>
                <span class="info-value"><?= htmlspecialchars($sertifikat['lokasi_kegiatan']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Disetujui</span>
                <span class="info-value"><?= date('d F Y', strtotime($sertifikat['approved_at'])) ?></span>
            </div>

            <a href="<?= base_url() ?>" class="btn-back">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
            <p class="footer-note">
                <i class="fas fa-shield-alt me-1"></i>
                Diverifikasi oleh Sistem Kemahasiswaan FIK — Telkom University
            </p>
        </div>

        <script>
            QRCode.toCanvas(document.getElementById('qrCanvas'), '<?= current_url() ?>', {
                width: 160, margin: 2,
                color: { dark: '#1e293b', light: '#ffffff' }
            });
        </script>

        <?php else: ?>
        <!-- INVALID -->
        <div class="card-header invalid">
            <div class="status-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h1>Sertifikat Tidak Valid</h1>
            <p>Nomor sertifikat <strong><?= htmlspecialchars($nomor) ?></strong> tidak ditemukan dalam sistem kami</p>
        </div>
        <div class="card-body">
            <div style="text-align:center;padding:1.5rem 0;">
                <i class="fas fa-exclamation-triangle" style="font-size:3rem;color:#f59e0b;margin-bottom:1rem;display:block;"></i>
                <p style="color:#64748b;line-height:1.7;">
                    Sertifikat dengan nomor <strong style="color:#1e293b;"><?= htmlspecialchars($nomor) ?></strong> tidak ditemukan.<br>
                    Kemungkinan sertifikat belum disetujui, nomor salah, atau tidak terdaftar.
                </p>
            </div>
            <a href="<?= base_url() ?>" class="btn-back" style="background:linear-gradient(135deg,#64748b,#475569);">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
            <p class="footer-note" style="color:#dc2626;margin-top:1rem;">
                <i class="fas fa-info-circle me-1"></i>
                Jika ada masalah, hubungi Kemahasiswaan FIK
            </p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
