<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Proposal – <?= $proposal->nama_kegiatan ?? '-' ?></title>
<style>
    @page {
        margin: 80px 80px 120px 80px;
    }

    body {
        font-family: Calibri, Arial, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 12px;
        line-height: 1.25;
        color: #000;
    }

    /* === HEADER === */
    .header {
        position: fixed;
        top: -70px;
        left: 0;
        right: -90px;
        height: 100px;
        text-align: right;
        padding-right: 40px;
    }

    .header-logo {
        height: 80px;
        margin-top: 10px;
    }

    /* === FOOTER === */
    .footer {
        position: fixed;
        left: -80px;
        right: -80px;
        bottom: -120px;
        height: 90px;
        width: calc(100% + 160px);
    }

    .footer-text-img {
        position: absolute;
        bottom: 52px;
        left: 50%;
        transform: translateX(-50%);
        width: auto;
        max-width: 95%;
        height: 85px;
        object-fit: contain;
        margin-bottom: -20px;
    }

    .footer-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 30px;
        object-fit: fill;
    }

    /* === CONTENT === */
    .content {
        margin: 0;
        position: relative;
        z-index: 1;
    }

    /* Judul */
    .surat-title {
        text-align: center;
        text-transform: uppercase;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 2px;
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .surat-number {
        text-align: center;
        font-size: 12px;
        margin-top: -2px;
        margin-bottom: 10px;
    }

    .cover-nama {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin: 6px 0 2px;
    }

    .cover-meta {
        text-align: center;
        font-size: 11px;
        color: #555;
        margin-bottom: 16px;
    }

    /* Section title */
    .section-title {
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #333;
        padding-bottom: 2px;
        margin: 12px 0 6px;
    }

    /* Identity (label : value) */
    .identity {
        margin: 8px 0;
        line-height: 1.7;
    }

    .identity-row {
        display: table;
        width: 100%;
        margin-bottom: 2px;
    }

    .identity-label {
        display: table-cell;
        width: 110px;
    }

    .identity-separator {
        display: table-cell;
        width: 15px;
    }

    .identity-value {
        display: table-cell;
    }

    /* Paragraf */
    .content p {
        margin-bottom: 8px;
        text-align: justify;
        text-indent: 0;
    }

    p.indent {
        text-indent: 20px;
    }

    /* Tabel */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 8px 0;
        font-size: 11px;
    }

    th, td {
        border: 1px solid #000;
        padding: 5px 7px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background: #f0f0f0;
        font-weight: bold;
        text-align: center;
    }

    .col-no   { width: 25px; text-align: center !important; }
    .col-r    { text-align: right !important; }
    .col-c    { text-align: center !important; }
    .tbl-total td { font-weight: bold; background: #f5f5f5; }

    /* Tanda tangan */
    .signature-area {
        display: table;
        width: 100%;
        margin-top: 16px;
    }

    .sig-left, .sig-right {
        display: table-cell;
        width: 50%;
        text-align: center;
        vertical-align: top;
        padding: 0 8px;
    }

    .sig-space { height: 45px; display: block; }

    .sig-name {
        font-weight: bold;
        text-decoration: underline;
        display: inline-block;
        border-top: 1px solid #000;
        padding-top: 2px;
        min-width: 110px;
    }

    /* Tembusan */
    .tembusan-list { margin: 0; padding: 0; list-style: none; }
    .tembusan-item { margin-bottom: 3px; }

    b { font-weight: bold; }
</style>
</head>

<?php
/* ═══ HELPERS ═══ */
function _tgl($d) {
    if (!$d || $d === '0000-00-00' || $d === '-') return '-';
    $b = ['','Januari','Februari','Maret','April','Mei','Juni',
          'Juli','Agustus','September','Oktober','November','Desember'];
    $t = strtotime($d);
    return date('d',$t).' '.$b[(int)date('m',$t)].' '.date('Y',$t);
}

function _rp($n) {
    return 'Rp '.number_format((float)$n,0,',','.');
}

function _e($s) {
    return htmlspecialchars(trim((string)($s ?? '-')));
}

function _ok($s) {
    return !empty(trim((string)($s ?? ''))) && trim($s) !== '-';
}

function _paras($text, $cls = '') {
    $t = trim($text ?? '');
    if (!$t) return '<p>-</p>';
    $out = '';
    foreach (array_filter(array_map('trim', explode("\n", $t))) as $l)
        $out .= '<p'.($cls ? ' class="'.$cls.'"' : '').'>'.htmlspecialchars($l).'</p>';
    return $out;
}

function _b64($path) {
    if (!$path || !file_exists($path)) return '';
    $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = in_array($ext,['jpg','jpeg']) ? 'image/jpeg' : 'image/'.$ext;
    return 'data:'.$mime.';base64,'.base64_encode(file_get_contents($path));
}

$p   = $proposal;
$rab = $rab ?? [];

// Assets — ikuti persis cara surat tugas
$logo_b64   = _b64(FCPATH.'assets/Tel-U_logo.png');
$footer_txt = _b64(FCPATH.'assets/footer_text.png');
$footer_wav = _b64(FCPATH.'assets/footer_asset.jpg');

$kode   = _e($p->kode_proposal ?? 'FIK-'.date('Y').'-XXXX');
$nama_k = _e($p->nama_kegiatan ?? '-');
$today  = _tgl(date('Y-m-d'));
?>

<body>

<!-- HEADER — persis seperti surat tugas -->
<div class="header">
    <?php if ($logo_b64): ?>
        <img src="<?= $logo_b64 ?>" class="header-logo" alt="Telkom University Logo">
    <?php else: ?>
        <img src="<?= base_url('assets/Tel-U_logo.png') ?>" class="header-logo" alt="Telkom University Logo">
    <?php endif; ?>
</div>

<!-- FOOTER — persis seperti surat tugas -->
<div class="footer">
    <?php if ($footer_txt): ?>
        <img src="<?= $footer_txt ?>" class="footer-text-img" alt="Footer Text">
    <?php else: ?>
        <img src="<?= base_url('assets/footer_text.png') ?>" class="footer-text-img" alt="Footer text">
    <?php endif; ?>

    <?php if ($footer_wav): ?>
        <img src="<?= $footer_wav ?>" class="footer-wave" alt="Footer Wave">
    <?php else: ?>
        <img src="<?= base_url('assets/footer_asset.jpg') ?>" class="footer-wave" alt="Footer Wave">
    <?php endif; ?>
</div>

<br><br>

<!-- ═══════════════════════════════════════
     CONTENT
═══════════════════════════════════════ -->
<div class="content">

    <!-- JUDUL -->
    <div class="surat-title">Proposal Kegiatan</div>
    <div class="surat-number">Nomor : <?= $kode ?></div>

    <div class="cover-nama"><?= $nama_k ?></div>
    <div class="cover-meta">
        <?= _e($p->nama_ormawa ?? '-') ?> &nbsp;&bull;&nbsp; <?= _tgl($p->tanggal_kegiatan ?? null) ?>
    </div>

    <!-- I. IDENTITAS -->
    <div class="section-title">I. Identitas Kegiatan</div>
    <div class="identity">
        <div class="identity-row">
            <div class="identity-label">Nama Kegiatan</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><b><?= $nama_k ?></b></div>
        </div>
        <div class="identity-row">
            <div class="identity-label">Ormawa / Komunitas</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->nama_ormawa ?? '-') ?></div>
        </div>
        <div class="identity-row">
            <div class="identity-label">Jenis Kegiatan</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->jenis_kegiatan ?? '-') ?></div>
        </div>
        <?php if (_ok($p->tema_kegiatan ?? '')): ?>
        <div class="identity-row">
            <div class="identity-label">Tema Kegiatan</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->tema_kegiatan) ?></div>
        </div>
        <?php endif; ?>
        <?php if (_ok($p->balai_divisi ?? '')): ?>
        <div class="identity-row">
            <div class="identity-label">Balai / Divisi</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->balai_divisi) ?></div>
        </div>
        <?php endif; ?>
        <div class="identity-row">
            <div class="identity-label">Tahun Kegiatan</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->tahun_kegiatan ?? date('Y')) ?></div>
        </div>
    </div>

    <!-- II. WAKTU & TEMPAT -->
    <div class="section-title">II. Waktu &amp; Tempat Pelaksanaan</div>
    <div class="identity">
        <div class="identity-row">
            <div class="identity-label">Tanggal</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _tgl($p->tanggal_kegiatan ?? null) ?></div>
        </div>
        <div class="identity-row">
            <div class="identity-label">Waktu</div>
            <div class="identity-separator">:</div>
            <div class="identity-value">
                <?= _e($p->waktu_mulai ?? '-') ?> &ndash; <?= _e($p->waktu_selesai ?? '...') ?> WIB
            </div>
        </div>
        <div class="identity-row">
            <div class="identity-label">Tempat / Lokasi</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->lokasi_kegiatan ?? '-') ?></div>
        </div>
        <?php if (_ok($p->peserta ?? '')): ?>
        <div class="identity-row">
            <div class="identity-label">Estimasi Peserta</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->peserta) ?> orang</div>
        </div>
        <?php endif; ?>
    </div>

    <!-- III. LATAR BELAKANG -->
    <div class="section-title">III. Latar Belakang</div>
    <?= _paras($p->latar_belakang ?? '', 'indent') ?>

    <!-- IV. TUJUAN & MANFAAT -->
    <div class="section-title">IV. Tujuan &amp; Manfaat</div>
    <?= _paras($p->tujuan_manfaat ?? '') ?>

    <?php if (_ok($p->sasaran_kegiatan ?? '')): ?>
    <!-- V. SASARAN -->
    <div class="section-title">V. Sasaran Kegiatan</div>
    <?= _paras($p->sasaran_kegiatan) ?>
    <?php endif; ?>

    <?php if (_ok($p->susunan_panitia ?? '')): ?>
    <!-- VI. SUSUNAN PANITIA -->
    <div class="section-title">VI. Susunan Panitia</div>
    <?= _paras($p->susunan_panitia) ?>
    <?php endif; ?>

    <?php if (_ok($p->susunan_acara ?? '')): ?>
    <!-- VII. SUSUNAN ACARA -->
    <div class="section-title">VII. Susunan Acara (Rundown)</div>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th style="width:80px;">Waktu</th>
                <th>Kegiatan</th>
                <th style="width:80px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        foreach (array_filter(array_map('trim', explode("\n", $p->susunan_acara))) as $line):
            if (!$line) continue;
            if (preg_match('/^(\d{1,2}[.:]\d{2}(?:\s*[-–]\s*\d{1,2}[.:]\d{2})?)\s*[:\-]\s*(.+)$/u', $line, $m)) {
                $wkt = trim($m[1]); $kgt = trim($m[2]);
            } else { $wkt = '-'; $kgt = $line; }
        ?>
            <tr>
                <td class="col-no"><?= $no++ ?></td>
                <td class="col-c"><?= htmlspecialchars($wkt) ?></td>
                <td><?= htmlspecialchars($kgt) ?></td>
                <td></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- VIII. RAB -->
    <div class="section-title">VIII. Rencana Anggaran Biaya (RAB)</div>
    <?php if (!empty($rab)): ?>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Uraian Kegiatan / Item</th>
                <th style="width:30px;">Vol</th>
                <th style="width:50px;">Satuan</th>
                <th style="width:90px;">Harga Satuan</th>
                <th style="width:90px;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
        <?php $grand = 0;
        foreach ($rab as $i => $item):
            $jml = (float)($item->jumlah ?? 0); $grand += $jml; ?>
            <tr>
                <td class="col-no"><?= $i+1 ?></td>
                <td><?= htmlspecialchars($item->uraian ?? '-') ?></td>
                <td class="col-c"><?= htmlspecialchars($item->volume ?? 1) ?></td>
                <td><?= htmlspecialchars($item->satuan ?? 'Unit') ?></td>
                <td class="col-r"><?= _rp($item->harga_satuan ?? 0) ?></td>
                <td class="col-r"><?= _rp($jml) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="tbl-total">
                <td colspan="5" style="text-align:right;padding-right:8px;"><b>TOTAL KESELURUHAN</b></td>
                <td class="col-r"><b><?= _rp($p->total_rab ?? $grand) ?></b></td>
            </tr>
        </tfoot>
    </table>
    <?php else: ?>
        <p>Rencana anggaran biaya belum tersedia.</p>
    <?php endif; ?>

    <!-- Sumber dana -->
    <div class="identity" style="margin-top:4px;">
        <div class="identity-row">
            <div class="identity-label">Sumber Dana</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><?= _e($p->sumber_dana ?? '-') ?></div>
        </div>
        <div class="identity-row">
            <div class="identity-label">Dana Diajukan</div>
            <div class="identity-separator">:</div>
            <div class="identity-value"><b><?= _rp($p->dana_diajukan ?? 0) ?></b></div>
        </div>
    </div>

    <!-- IX. PENUTUP -->
    <div class="section-title">IX. Penutup</div>
    <p class="indent">
        Demikian proposal kegiatan <b><?= $nama_k ?></b> ini kami susun sebagai bahan
        pertimbangan dan permohonan dukungan. Besar harapan kami agar kegiatan ini mendapat
        persetujuan dan dukungan penuh dari pihak Fakultas Industri Kreatif Telkom University.
        Atas perhatian dan dukungannya, kami mengucapkan terima kasih.
    </p>

    <p>Bandung, <?= $today ?></p>

    <!-- TANDA TANGAN -->
    <div class="signature-area">
        <div class="sig-left">
            <p style="margin:0;">Ketua Ormawa,</p>
            <span class="sig-space">
            <?php
            if (!empty($p->file_ttd_ketua)) {
                $ttd_path = FCPATH . ltrim($p->file_ttd_ketua, '/');
                $ttd_b64  = _b64($ttd_path);
                if ($ttd_b64) echo '<img src="'.$ttd_b64.'" style="height:40px;margin-top:4px;">';
            }
            ?>
            </span>
            <div style="font-weight:bold;text-decoration:underline;line-height:1;margin-bottom:1px;">
                <?= _e($p->nama_pengaju ?? '(..........................)') ?>
            </div>
            <div style="line-height:1;margin-top:0;">
                NIM. <?= _e($p->nim ?? '') ?>
            </div>
        </div>
        <div class="sig-right">
            <p style="margin:0;">Mengetahui,</p>
            <p style="margin:0;font-size:11px;">Pembimbing Kemahasiswaan FIK</p>
            <span class="sig-space"></span>
            <div style="font-weight:bold;text-decoration:underline;line-height:1;margin-bottom:1px;">
                (..........................)
            </div>
            <div style="line-height:1;margin-top:0;">NIDN.</div>
        </div>
    </div>

    <!-- TEMBUSAN -->
    <p style="margin-top:14px;"><b>Tembusan</b></p>
    <div class="tembusan-list">
        <div class="tembusan-item">1. Wakil Dekan Bidang Akademik dan Dukungan Penelitian FIK</div>
        <div class="tembusan-item">2. Wakil Dekan Bidang Keuangan dan Sumber Daya dan Kemahasiswaan FIK</div>
        <div class="tembusan-item">3. Kaprodi <?= _e($p->program_studi ?? 'Terkait') ?></div>
    </div>

</div><!-- /content -->
</body>
</html>