<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Proposal – <?= $proposal->nama_kegiatan ?? '-' ?></title>
<style>
    @page {
        margin: 140px 60px 100px 60px;
    }
    @page :first {
        margin: 60px;
    }

    body {
        font-family: Calibri, Arial, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 12px;
        line-height: 1.5;
        color: #000;
    }

    /* === HEADER === */
    .header {
        position: fixed;
        top: -120px;
        left: 0;
        right: 0;
        height: 115px;
        padding-bottom: 5px;
    }

    /* === FOOTER === */
    .footer {
        position: fixed;
        left: -60px;
        right: -60px;
        bottom: -100px;
        height: 60px;
    }

    .footer-text {
        text-align: center;
        font-size: 9px;
        color: #666;
        border-top: 1px solid #ccc;
        padding-top: 5px;
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
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 2px;
    }

    .surat-number {
        text-align: center;
        font-size: 11px;
        margin-top: -2px;
        margin-bottom: 20px;
    }

    /* Section title */
    .section-title {
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        border-bottom: 1px solid #000;
        padding-bottom: 2px;
        margin: 18px 0 8px;
    }

    /* Identity (label : value) */
    .identity {
        margin: 8px 0;
        line-height: 1.5;
    }

    .identity-row {
        display: table;
        width: 100%;
        margin-bottom: 2px;
    }

    .identity-label {
        display: table-cell;
        width: 150px;
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
        text-indent: 30px;
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
    .signature-container {
        width: 100%;
        margin-top: 30px;
        font-size: 11px;
    }

    .sig-table {
        width: 100%;
        border: none;
    }

    .sig-table td {
        border: none;
        padding: 10px;
        vertical-align: top;
        text-align: center;
    }

    .sig-space {
        height: 60px;
    }

    .sig-name {
        font-weight: bold;
        text-decoration: underline;
    }

    b { font-weight: bold; }
</style>
</head>

<?php
/* ═══ HELPERS ═══ */
function _tgl($d) {
    if (!$d || $d === '0000-00-00' || $d === '-') return '-';
    $h = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $b = ['','Januari','Februari','Maret','April','Mei','Juni',
          'Juli','Agustus','September','Oktober','November','Desember'];
    $t = strtotime($d);
    return $h[(int)date('w',$t)].', '.date('d',$t).' '.$b[(int)date('m',$t)].' '.date('Y',$t);
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

function _plain($s) {
    $t = trim((string)($s ?? ''));
    if (!$t || $t === '-') return '-';
    $t = html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $t = strip_tags($t);
    $t = trim($t);
    return htmlspecialchars($t ?: '-');
}

function _paras($text, $cls = '') {
    $t = trim($text ?? '');
    if (!$t) return '<p>-</p>';
    if (strip_tags($t) !== $t) {
        $clean = strip_tags($t, '<p><br><b><strong><em><i><ul><li><ol><span>');
        return $cls ? '<div class="'.$cls.'">'.$clean.'</div>' : $clean;
    }
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

// Load Tel-U Logo (Emblem only, without text)
$logo_b64 = _b64(FCPATH.'assets/nav-logo.png');

// Try to load Ormawa Logo dynamically
$logo_ormawa_b64 = '';
if (!empty($p->nama_ormawa)) {
    $ci =& get_instance();
    $orm_query = trim($p->nama_ormawa);
    $org = $ci->db->select('logo')->from('organisasi')->like('nama', $orm_query)->get()->row();
    if (!$org) {
        $words = explode(' ', $orm_query);
        foreach ($words as $w) {
            if (strlen($w) > 2 && !in_array(strtolower($w), ['ukm', 'hima', 'fik'])) {
                $org = $ci->db->select('logo')->from('organisasi')->like('nama', $w)->get()->row();
                if ($org && !empty($org->logo)) break;
            }
        }
    }
    if ($org && !empty($org->logo)) {
        $logo_ormawa_path = FCPATH . ltrim($org->logo, '/');
        $logo_ormawa_b64 = _b64($logo_ormawa_path);
    }
}

$kode   = _e($p->kode_proposal ?? 'FIK-'.date('Y').'-XXXX');
$nama_k = _e($p->nama_kegiatan ?? '-');
$today  = _tgl(date('Y-m-d'));

$tglMulai = p_date_format($p->tanggal_kegiatan);
$tglSelesai = p_date_format($p->tanggal_selesai);
$tglString = ($tglSelesai && $tglSelesai !== $tglMulai) ? "$tglMulai s.d. $tglSelesai" : $tglMulai;

function p_date_format($date) {
    if (empty($date)) return '';
    return _tgl($date);
}

// Decode JSON fields
$sumber_dana_list = json_decode($p->sumber_dana, true) ?? [];
$rundown_list = json_decode($p->susunan_acara, true) ?? [];
$risiko_list = json_decode($p->manajemen_risiko, true) ?? [];

// Extract speaker name dynamically
$extracted_speaker = '-';
foreach ($rundown_list as $r_item) {
    $act = strtolower($r_item['kegiatan'] ?? '');
    $pengisi = trim($r_item['pengisi'] ?? '');
    if (preg_match('/(materi|seminar|talkshow|sharing|pembicara|narasumber)/i', $act)) {
        if ($pengisi && !in_array(strtolower($pengisi), ['mc', 'panitia', 'seluruh panitia', 'moderator', '-'])) {
            $extracted_speaker = $pengisi;
            break;
        }
    }
}
if ($extracted_speaker === '-') {
    if (preg_match('/dipaparkan oleh (Bapak |Ibu )?([A-Z][a-zA-Z\s\.,]+)/', $p->jenis_kegiatan ?? '', $matches)) {
        $extracted_speaker = trim($matches[2]);
    }
}

// Calculate sums
$dana_internal = 0;
$dana_usaha = 0;
$dana_sponsor = 0;
foreach ($sumber_dana_list as $sd) {
    $s = strtolower($sd['sumber'] ?? '');
    $n = (float)($sd['nominal'] ?? 0);
    if (strpos($s, 'kemahasiswaan') !== false || strpos($s, 'internal') !== false || strpos($s, 'fakultas') !== false) {
        $dana_internal += $n;
    } elseif (strpos($s, 'sponsor') !== false) {
        $dana_sponsor += $n;
    } else {
        $dana_usaha += $n;
    }
}

// === BINDING PEJABAT LEMBAR PENGESAHAN DARI TEMPLATE DOKUMEN FIK 2026 ===
$kaprodi_list = [
    's1 desain komunikasi visual' => ['nama' => 'Arief Budiman, S.Sn., M.Sn.', 'nip' => '20840003'],
    'dkv'                         => ['nama' => 'Arief Budiman, S.Sn., M.Sn.', 'nip' => '20840003'],
    's1 desain interior'          => ['nama' => 'Togar Mulya Raja, S.Ds., M.Ds.', 'nip' => '20840001'],
    'di'                          => ['nama' => 'Togar Mulya Raja, S.Ds., M.Ds.', 'nip' => '20840001'],
    's1 kriya'                    => ['nama' => 'Mochammad Sigit Ramadhan, S.Pd., M.Sn.', 'nip' => '20890001'],
    'kriya'                       => ['nama' => 'Mochammad Sigit Ramadhan, S.Pd., M.Sn.', 'nip' => '20890001'],
    's1 desain produk'            => ['nama' => 'Terbit Setya Pambudi, ST., M.Ds.', 'nip' => '15870010'],
    'dp'                          => ['nama' => 'Terbit Setya Pambudi, ST., M.Ds.', 'nip' => '15870010'],
    's1 seni rupa'                => ['nama' => 'Ganjar Gumilar, S.Sn., M.Sn.', 'nip' => '23900020'],
    'senirupa'                    => ['nama' => 'Ganjar Gumilar, S.Sn., M.Sn.', 'nip' => '23900020'],
    'seni rupa'                   => ['nama' => 'Ganjar Gumilar, S.Sn., M.Sn.', 'nip' => '23900020'],
    's1 film dan animasi'         => ['nama' => 'Anggar Erdhina Adi, S.Sn., M.Ds.', 'nip' => '17830068'],
    'film'                        => ['nama' => 'Anggar Erdhina Adi, S.Sn., M.Ds.', 'nip' => '17830068']
];

$pembina_list = [
    'imagi'     => ['nama' => 'Putu Raka Setya Putra, S.Ds., M.Ds.', 'nip' => '23940001'],
    'kmdi'      => ['nama' => 'Mohd. Ridho Kurniawan, S.Ds., M.Ds. / Teddy Ageng Maulana, S.Sn., M.Sn.', 'nip' => '24980005 / 22730003'],
    'serat'     => ['nama' => 'Jeng Oetari, S.Sn., M.Ds.', 'nip' => '23980019'],
    'indec'     => ['nama' => 'Alvian Fajar, S.Ds., M.Ds.', 'nip' => '20900023'],
    'hawasemu'  => ['nama' => 'Adrian Permana Zen, S.Ds., MA.', 'nip' => '20900013'],
    'digistar'  => ['nama' => 'Adrian Permana Zen, S.Ds., MA.', 'nip' => '20900013'],
    'bem'       => ['nama' => 'Isnan Purnama, S.E., M.M.', 'nip' => '22930026'],
    'dpm'       => ['nama' => 'Isnan Purnama, S.E., M.M.', 'nip' => '22930026']
];

$prodi_raw = trim($p->program_studi ?? '');
$prodi_clean = preg_replace('/[^a-z0-9]/', '', strtolower($prodi_raw));
$kaprodi_nama = '..................................................';
$kaprodi_nip = '..................................................';
$prodi_label = _ok($prodi_raw) ? ucwords(str_replace(['s1', '_'], ['S1 ', ' '], strtolower($prodi_raw))) : '';

if (!empty($prodi_clean)) {
    foreach ($kaprodi_list as $key => $val) {
        $key_clean = preg_replace('/[^a-z0-9]/', '', strtolower($key));
        if (strpos($prodi_clean, $key_clean) !== false || strpos($key_clean, $prodi_clean) !== false) {
            $kaprodi_nama = $val['nama'];
            $kaprodi_nip = $val['nip'];
            break;
        }
    }
}

$ormawa_raw = trim($p->nama_ormawa ?? '');
$ormawa_clean = preg_replace('/[^a-z0-9]/', '', strtolower($ormawa_raw));
$pembina_nama = '..................................................';
$pembina_nip = '..................................................';
$ormawa_label = _ok($ormawa_raw) ? _e($ormawa_raw) : 'Himpunan/Prodi';

if (!empty($ormawa_clean)) {
    foreach ($pembina_list as $key => $val) {
        $key_clean = preg_replace('/[^a-z0-9]/', '', strtolower($key));
        if (strpos($ormawa_clean, $key_clean) !== false || strpos($key_clean, $ormawa_clean) !== false) {
            $pembina_nama = $val['nama'];
            $pembina_nip = $val['nip'];
            break;
        }
    }
}

if ($pembina_nama === '..................................................' && is_array($panitia_list)) {
    foreach ($panitia_list as $m) {
        $jbt = strtolower($m['jabatan'] ?? '');
        if (strpos($jbt, 'pembina') !== false || strpos($jbt, 'pembimbing') !== false) {
            if (!empty($m['nama'])) $pembina_nama = $m['nama'];
            if (!empty($m['nim'])) $pembina_nip = $m['nim'];
            break;
        }
    }
}

// === PENGELOMPOKAN ANGGARAN RAB DINAMIS SESUAI TEMPLATE ===
$categories = [
    'Kebutuhan Acara'        => [],
    'Kebutuhan Dekorasi'     => [],
    'Kebutuhan Konsumsi'     => [],
    'Kebutuhan Administrasi' => []
];

$total_out = 0;
foreach ($rab as $item) {
    $jml = (float)($item->jumlah ?? 0);
    $total_out += $jml;
    
    $katInput = trim($item->kategori ?? '');
    if (!empty($katInput) && isset($categories[$katInput])) {
        $categories[$katInput][] = $item;
        continue;
    }
    
    $uraian = strtolower($item->uraian ?? '');
    $ket = strtolower($item->keterangan ?? '');
    $satuan = strtolower($item->satuan ?? '');
    $combined = $uraian . ' ' . $ket . ' ' . $satuan;
    
    if (preg_match('/(makan|minum|snack|konsumsi|tumpeng|kue|prasmanan|lunch|dinner|food|drink|water|aqua|nasi|catering|katering|kopi|teh|roti|sirup|buah)/i', $combined)) {
        $categories['Kebutuhan Konsumsi'][] = $item;
    } elseif (preg_match('/(dekor|backdrop|banner|spanduk|photobooth|dekorasi|kain|lampu|balon|panggung|stage|lighting|flowers|bunga|umbul|flyer|poster|pamflet)/i', $combined)) {
        $categories['Kebutuhan Dekorasi'][] = $item;
    } elseif (preg_match('/(print|cetak|kertas|jilid|materai|tinta|surat|administrasi|atk|pulpen|buku|proposal|sertifikat|stamp|stempel|amplop|kwitansi|nota)/i', $combined)) {
        $categories['Kebutuhan Administrasi'][] = $item;
    } else {
        $categories['Kebutuhan Acara'][] = $item;
    }
}
?>

<body>

<!-- ═══════════════════════════════════════
     COVER (Halaman 1)
     ═══════════════════════════════════════ -->
<div class="cover-page" style="page-break-after: always; height: 100%;">
    <table style="width: 100%; height: 860px; border: none; border-collapse: collapse; margin: 0; padding: 0;">
        <tr style="border: none;">
            <td style="border: none; padding: 0; text-align: center; vertical-align: top; height: 100px;">
                <div style="font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; margin-top: 30px;">PROPOSAL KEGIATAN</div>
            </td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 20px 0; text-align: center; vertical-align: middle; height: 150px;">
                <h2 style="font-size: 20px; font-weight: bold; text-transform: uppercase; line-height: 1.4; margin-bottom: 8px;"><?= $nama_k ?></h2>
                <?php if (_ok($p->tema_kegiatan ?? '')): ?>
                    <div style="font-size: 13px; font-style: italic; font-weight: normal; text-transform: uppercase;">TEMA: <?= _e($p->tema_kegiatan) ?></div>
                <?php endif; ?>
            </td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 20px 0; text-align: center; vertical-align: middle; height: 320px;">
                <?php if ($logo_b64): ?>
                    <img src="<?= $logo_b64 ?>" style="height: 260px; width: auto;" alt="Telkom University Logo">
                <?php endif; ?>
            </td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 0 0 40px 0; text-align: center; vertical-align: bottom; height: 200px;">
                <div style="font-size: 14px; line-height: 1.5; font-weight: bold; text-transform: uppercase; text-align: center;">
                    <div><?= _e($p->nama_ormawa ?? 'NAMA ORMAWA') ?></div>
                    <div>FAKULTAS INDUSTRI KREATIF</div>
                    <div>TELKOM UNIVERSITY</div>
                    <div style="margin-top: 6px;"><?= _e($p->tahun_kegiatan ?? date('Y')) ?></div>
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- ═══════════════════════════════════════
     HEADER & FOOTER (Mulai Halaman 2)
     ═══════════════════════════════════════ -->
<div class="header">
    <table style="width: 100%; border: none; margin: 0; padding: 0; border-collapse: collapse;">
        <tr style="border: none;">
            <td style="width: 95px; border: none; padding: 0; text-align: left; vertical-align: middle;">
                <?php if ($logo_b64): ?>
                    <img src="<?= $logo_b64 ?>" style="height: 68px; width: auto;" alt="Logo">
                <?php endif; ?>
            </td>
            <td style="border: none; padding: 0 5px; text-align: center; line-height: 1.3; vertical-align: middle;">
                <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;"><?= _e($p->nama_ormawa ?? '-') ?> FAKULTAS INDUSTRI KREATIF</div>
                <div style="font-size: 11px; font-weight: bold; text-transform: uppercase;">TELKOM UNIVERSITY</div>
                <div style="font-size: 11px; font-weight: bold; text-transform: uppercase; margin: 3px 0;"><?= $nama_k ?> & TAHUN <?= _e($p->tahun_kegiatan ?? '2026') ?></div>
                <div style="font-size: 9.5px; font-weight: normal; color: #000; margin-top: 2px;">Jalan Telekomunikasi, Terusan Buah Batu, Bandung 40257, Indonesia</div>
                <div style="border-bottom:1px solid #000; width:100%; margin-top:2px;"></div>
            </td>
            <td style="width: 95px; border: none; padding: 0; text-align: right; vertical-align: middle;">
                <?php if (!empty($logo_ormawa_b64)): ?>
                    <img src="<?= $logo_ormawa_b64 ?>" style="height: 62px; max-width: 85px; object-fit: contain;" alt="Logo Ormawa">
                <?php else: ?>
                    <div style="width: 80px; height: 50px; border: 1px solid #000; display: inline-block; font-size: 8px; text-align: center; vertical-align: middle; line-height: 1.1; padding-top: 15px; font-weight: bold; background: #fff;">
                        LOGO<br>ORMAWA
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <div style="border-bottom: 3px double #000; font-size: 1px; line-height: 1px; margin-top: 8px; clear: both;">&nbsp;</div>
</div>

<div class="footer">
    <div class="footer-text">
        Proposal Kegiatan - <?= _e($p->nama_ormawa ?? '-') ?> | Halaman ini dibuat otomatis oleh Sistem Kemahasiswaan FIK
    </div>
</div>

<!-- ═══════════════════════════════════════
     REKAP PROPOSAL (Halaman 2)
     ═══════════════════════════════════════ -->
<div class="content" style="page-break-after: always; padding-top: 10px;">
    <div style="text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; margin-bottom: 20px;">REKAP PROPOSAL</div>
    
    <table style="width: 100%;">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th style="width: 180px;">Kegiatan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-no">1</td>
                <td><b>Nama dan Tema</b></td>
                <td><?= $nama_k ?><?php if (_ok($p->tema_kegiatan ?? '')): ?>; Tema: <?= _e($p->tema_kegiatan) ?><?php endif; ?></td>
            </tr>
            <tr>
                <td class="col-no">2</td>
                <td><b>Penyelenggara</b></td>
                <td><?= _e($p->nama_ormawa ?? '-') ?></td>
            </tr>
            <tr>
                <td class="col-no">3</td>
                <td><b>Afiliansi</b></td>
                <td><?= _e($p->balai_divisi ?? '-') ?></td>
            </tr>
            <tr>
                <td class="col-no">4</td>
                <td><b>Tempat</b></td>
                <td><?= _e($p->lokasi_kegiatan ?? '-') ?></td>
            </tr>
            <tr>
                <td class="col-no">5</td>
                <td><b>Jadwal</b></td>
                <td><?= $tglString ?> (Pukul <?= _e($p->waktu_mulai ?? '-') ?> s.d. <?= _e($p->waktu_selesai ?? '-') ?> WIB)</td>
            </tr>
            <tr>
                <td class="col-no">6</td>
                <td><b>Pembicara</b></td>
                <td><?= _e($extracted_speaker) ?></td>
            </tr>
            <tr>
                <td class="col-no">7</td>
                <td><b>Anggaran Total</b></td>
                <td><?= _rp($p->total_rab ?? 0) ?></td>
            </tr>
            <tr>
                <td class="col-no">8</td>
                <td><b>Pengajuan Dana Internal</b></td>
                <td><?= _rp($dana_internal) ?></td>
            </tr>
            <tr>
                <td class="col-no">9</td>
                <td><b>Dana Usaha Mandiri</b></td>
                <td><?= _rp($dana_usaha) ?></td>
            </tr>
            <tr>
                <td class="col-no">10</td>
                <td><b>Dana Sponsor</b></td>
                <td><?= _rp($dana_sponsor) ?></td>
            </tr>
            <tr>
                <td class="col-no">11</td>
                <td><b>Bentuk Kegiatan</b></td>
                <td><?= _e($p->jenis_kegiatan ?? '-') ?></td>
            </tr>
            <tr>
                <td class="col-no">12</td>
                <td><b>Target Peserta Kegiatan</b></td>
                <td><?= _e($p->peserta) ?> orang (<?= _plain($p->sasaran_kegiatan) ?>)</td>
            </tr>
            <tr>
                <td class="col-no">13</td>
                <td><b>Tolak Ukur Keberhasilan</b></td>
                <td><?= _plain($p->tolak_ukur_keberhasilan ?? '-') ?></td>
            </tr>
            <tr>
                <td class="col-no">14</td>
                <td><b>Monitoring Kegiatan</b></td>
                <td><?= _plain($p->monitoring_kegiatan ?? '-') ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ═══════════════════════════════════════
     BAB ISI PROPOSAL
     ═══════════════════════════════════════ -->
<div class="content">

    <div class="surat-title">PROPOSAL KEGIATAN</div>
    <div class="surat-number">Nomor : <?= $kode ?></div>

    <!-- LATAR BELAKANG / PENDAHULUAN -->
    <div class="section-title">Latar Belakang/ Pendahuluan</div>
    <?= _paras($p->latar_belakang ?? '', 'indent') ?>

    <!-- NAMA DAN TEMA -->
    <div class="section-title">Nama dan Tema Kegiatan</div>
    <p class="indent">Kegiatan ini bernama <b><?= $nama_k ?></b>.</p>
    <?php if (_ok($p->tema_kegiatan ?? '')): ?>
        <p class="indent">Tema Kegiatan ini adalah <b><?= _e($p->tema_kegiatan) ?></b>.</p>
    <?php endif; ?>

    <!-- TUJUAN DAN MANFAAT KEGIATAN -->
    <div class="section-title">Tujuan dan Manfaat Kegiatan</div>
    <?php 
    $tujuan_manfaat_html = _paras($p->tujuan_manfaat ?? '', 'indent');
    $tujuan_manfaat_html = str_ireplace(
        ['tujuan:', 'manfaat:', 'tujuan :', 'manfaat :'],
        ['<b>Tujuan:</b>', '<b>Manfaat:</b>', '<b>Tujuan:</b>', '<b>Manfaat:</b>'],
        $tujuan_manfaat_html
    );
    echo $tujuan_manfaat_html;
    ?>

    <!-- WAKTU DAN TEMPAT KEGIATAN -->
    <div class="section-title">Waktu dan Tempat Kegiatan</div>
    <p class="indent">Kegiatan akan dilaksanakan pada:</p>
    <table style="width: 100%; border: none; margin: 5px 0 10px 30px; font-size: 12px; border-collapse: collapse;">
        <tr style="border: none;">
            <td style="width: 100px; border: none; padding: 2px 0; font-family: Calibri, sans-serif;">Hari, tanggal</td>
            <td style="width: 15px; border: none; padding: 2px 0; text-align: center;">:</td>
            <td style="border: none; padding: 2px 0;"><?= $tglString ?></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 2px 0; font-family: Calibri, sans-serif;">Waktu</td>
            <td style="border: none; padding: 2px 0; text-align: center;">:</td>
            <td style="border: none; padding: 2px 0;">Pukul <?= _e($p->waktu_mulai ?? '-') ?> - <?= _e($p->waktu_selesai ?? '-') ?> WIB</td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 2px 0; font-family: Calibri, sans-serif;">Tempat</td>
            <td style="border: none; padding: 2px 0; text-align: center;">:</td>
            <td style="border: none; padding: 2px 0;"><?= str_ireplace('(atau)', '<b>(atau)</b>', _e($p->lokasi_kegiatan ?? '-')) ?></td>
        </tr>
    </table>

    <!-- PESERTA -->
    <div class="section-title">Peserta</div>
    <p class="indent">Sasaran kegiatan ini adalah <?= _plain($p->sasaran_kegiatan ?? '-') ?> dengan target peserta <?= _e($p->peserta ?? '0') ?> orang.</p>

    <!-- PENYELENGGARA -->
    <div class="section-title">Penyelenggara</div>
    <p class="indent">Penyelenggara kegiatan ini adalah <b><?= _e($p->nama_ormawa ?? '-') ?></b>.</p>
    <table style="width: 100%; border: none; margin: 5px 0 10px 30px; font-size: 12px; border-collapse: collapse;">
        <tr style="border: none;">
            <td style="width: 120px; border: none; padding: 2px 0; font-family: Calibri, sans-serif;">Nama Penyelenggara</td>
            <td style="width: 15px; border: none; padding: 2px 0; text-align: center;">:</td>
            <td style="border: none; padding: 2px 0;"><?= _e($p->nama_pengaju ?? '-') ?></td>
        </tr>
        <tr style="border: none;">
            <td style="border: none; padding: 2px 0; font-family: Calibri, sans-serif;">Nomor Kontak</td>
            <td style="border: none; padding: 2px 0; text-align: center;">:</td>
            <td style="border: none; padding: 2px 0;"><?= _e($p->no_hp ?? '-') ?></td>
        </tr>
    </table>

    <!-- BENTUK KEGIATAN -->
    <div class="section-title">Bentuk Kegiatan</div>
    <p class="indent"><?= _e($p->jenis_kegiatan ?? '-') ?></p>

    <!-- SUSUNAN ACARA -->
    <div class="section-title">Susunan Acara</div>
    <?php if (!empty($rundown_list) && is_array($rundown_list)): ?>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th style="width: 100px;">Jam</th>
                <th style="width: 60px;">Durasi</th>
                <th>Kegiatan</th>
                <th>Pengisi</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rundown_list as $idx => $item): ?>
            <tr>
                <td class="col-no"><?= $idx+1 ?></td>
                <td class="col-c"><?= htmlspecialchars($item['jam'] ?? '-') ?></td>
                <td class="col-c"><?= htmlspecialchars($item['durasi'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['kegiatan'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['pengisi'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['lokasi'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['keterangan'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>-</p>
    <?php endif; ?>

    <!-- MANAJEMEN RISIKO -->
    <div class="section-title">Manajemen Risiko</div>
    <?php if (!empty($risiko_list) && is_array($risiko_list)): ?>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Uraian Kegiatan</th>
                <th>Identifikasi Bahaya</th>
                <th style="width: 90px;">Tingkat Risiko</th>
                <th>Pengendalian Risiko</th>
                <th>Penanggungjawab</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($risiko_list as $idx => $item): ?>
            <tr>
                <td class="col-no"><?= $idx+1 ?></td>
                <td><?= htmlspecialchars($item['uraian_kegiatan'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['bahaya'] ?? '-') ?></td>
                <td class="col-c"><?= htmlspecialchars($item['tingkat'] ?? 'Rendah') ?></td>
                <td><?= htmlspecialchars($item['pengendalian'] ?? '-') ?></td>
                <td><?= htmlspecialchars($item['penanggungjawab'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>-</p>
    <?php endif; ?>

    <!-- MONITORING KEGIATAN -->
    <div class="section-title">Monitoring Kegiatan</div>
    <?= _paras($p->monitoring_kegiatan ?? '', 'indent') ?>

    <!-- SUSUNAN PANITIA -->
    <div class="section-title">Susunan Panitia</div>
    <?php 
    $panitia_list = json_decode($p->susunan_panitia ?? '', true);
    if (is_array($panitia_list) && !empty($panitia_list)):
        $grouped = [];
        foreach ($panitia_list as $p_item) {
            $grp = trim($p_item['kelompok'] ?? $p_item['divisi'] ?? 'Panitia Pelaksana');
            if (empty($grp)) $grp = 'Panitia Pelaksana';
            $grouped[$grp][] = $p_item;
        }
    ?>
        <table style="width: 100%; border: none; margin: 8px 0 15px; border-collapse: collapse; font-size: 11px;">
            <?php foreach ($grouped as $grp_name => $members): ?>
                <tr style="border: none;">
                    <td colspan="3" style="border: none; padding: 6px 0 2px; font-weight: bold; font-size: 11.5px; border-bottom: 1px solid #999;">
                        <?= htmlspecialchars($grp_name) ?>
                    </td>
                </tr>
                <?php foreach ($members as $m): ?>
                    <tr style="border: none;">
                        <td style="width: 190px; border: none; padding: 3px 0 3px 10px; font-weight: bold; vertical-align: top;">
                            <?= htmlspecialchars($m['jabatan'] ?? '-') ?>
                        </td>
                        <td style="border: none; padding: 3px 5px; vertical-align: top;">
                            : <?= htmlspecialchars($m['nama'] ?? '-') ?>
                        </td>
                        <td style="width: 130px; border: none; padding: 3px 0; text-align: right; vertical-align: top; color: #444;">
                            <?= htmlspecialchars($m['nim'] ?? '') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <?= _paras($p->susunan_panitia ?? '', 'indent') ?>
    <?php endif; ?>

    <!-- RINCIAN ANGGARAN BIAYA -->
    <div class="section-title">Rincian Anggaran Biaya</div>
    
    <!-- Pemasukan -->
    <p><b>Rencana Anggaran Pemasukan:</b></p>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Detail</th>
                <th>Keterangan</th>
                <th style="width:150px;">Total Rincian</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $idx_p = 1;
        $total_p = 0;
        foreach ($sumber_dana_list as $sd): 
            $nominal = (float)($sd['nominal'] ?? 0);
            $total_p += $nominal;
        ?>
            <tr>
                <td class="col-no"><?= $idx_p++ ?></td>
                <td><?= htmlspecialchars($sd['sumber'] ?? '-') ?></td>
                <td><?= htmlspecialchars($sd['keterangan'] ?? '-') ?></td>
                <td class="col-r"><?= _rp($nominal) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="tbl-total">
                <td colspan="3" style="text-align:right;"><b>TOTAL</b></td>
                <td class="col-r"><b><?= _rp($total_p) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <!-- Rencana Anggaran Pengeluaran (Summary dinamis per kategori) -->
    <p><b>Rencana Anggaran Pengeluaran:</b></p>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Detail</th>
                <th style="width:150px;">Total Rincian</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no_cat = 1;
            foreach ($categories as $catName => $items):
                $catTotal = 0;
                foreach ($items as $it) {
                    $catTotal += (float)($it->jumlah ?? 0);
                }
            ?>
            <tr>
                <td class="col-no"><?= $no_cat++ ?></td>
                <td><?= $catName ?></td>
                <td class="col-r"><?= _rp($catTotal) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="tbl-total">
                <td colspan="2" style="text-align:right;"><b>TOTAL</b></td>
                <td class="col-r"><b><?= _rp($total_out) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <!-- Rincian Rencana Anggaran Pengeluaran (Dinamis per kategori) -->
    <p><b>Rincian Rencana Anggaran Pengeluaran:</b></p>
    <?php 
    foreach ($categories as $catName => $items):
    ?>
        <p style="margin-top: 15px; font-weight: bold; text-decoration: underline;"><?= $catName ?></p>
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Detail</th>
                    <th>Keterangan</th>
                    <th style="width:60px;">Kuantitas</th>
                    <th style="width:90px;">Harga</th>
                    <th style="width:90px;">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $subtotal = 0;
            if (!empty($items)):
                $no_item = 1;
                foreach ($items as $item):
                    $jml = (float)($item->jumlah ?? 0);
                    $subtotal += $jml;
            ?>
                <tr>
                    <td class="col-no"><?= $no_item++ ?></td>
                    <td><?= htmlspecialchars($item->uraian ?? '-') ?></td>
                    <td><?= htmlspecialchars($item->satuan ?? 'Unit') ?></td>
                    <td class="col-c"><?= htmlspecialchars($item->volume ?? 1) ?></td>
                    <td class="col-r"><?= _rp($item->harga_satuan ?? 0) ?></td>
                    <td class="col-r"><?= _rp($jml) ?></td>
                </tr>
            <?php 
                endforeach;
            else:
            ?>
                <tr>
                    <td class="col-no">1</td>
                    <td>-</td>
                    <td>-</td>
                    <td class="col-c">-</td>
                    <td class="col-r">Rp 0</td>
                    <td class="col-r">Rp 0</td>
                </tr>
            <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="tbl-total">
                    <td colspan="5" style="text-align:right;"><b>SUBTOTAL</b></td>
                    <td class="col-r"><b><?= _rp($subtotal) ?></b></td>
                </tr>
            </tfoot>
        </table>
    <?php endforeach; ?>

    <!-- DESAIN SERTIFIKAT -->
    <?php if (_ok($p->file_sertifikat ?? '')): ?>
        <div class="section-title">Desain Sertifikat</div>
        <div style="text-align: center; margin: 15px 0;">
            <img src="<?= _b64(FCPATH . $p->file_sertifikat) ?>" style="max-width: 90%; max-height: 250px; border: 1px solid #ccc; padding: 3px; border-radius: 4px;" alt="Sertifikat Mockup">
        </div>
    <?php endif; ?>

    <!-- PENUTUP -->
    <div class="section-title">Penutup</div>
    <p class="indent">
        Demikian proposal kegiatan <b><?= $nama_k ?></b> ini kami susun sebagai bahan
        pertimbangan dan permohonan dukungan. Besar harapan kami agar kegiatan ini mendapat
        persetujuan dan dukungan penuh dari pihak Fakultas Industri Kreatif Telkom University.
        Atas perhatian dan dukungannya, kami mengucapkan terima kasih.
    </p>

    <p style="margin-top: 30px;">Bandung, <?= $today ?></p>

    <!-- LEMBAR PENGESAHAN -->
    <div style="page-break-before: always; padding-top: 10px;">
        <div style="text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; margin-bottom: 20px;">LEMBAR PENGESAHAN</div>
        
        <?php
        $ketua_kegiatan_nama = '..................................................';
        $ketua_kegiatan_nim = '';
        if (is_array($panitia_list)) {
            foreach ($panitia_list as $m) {
                $jbt = strtolower($m['jabatan'] ?? '');
                if (strpos($jbt, 'ketua pelaksana') !== false || strpos($jbt, 'ketua kegiatan') !== false || $jbt === 'ketua') {
                    if (!empty($m['nama'])) $ketua_kegiatan_nama = $m['nama'];
                    if (!empty($m['nim'])) $ketua_kegiatan_nim = $m['nim'];
                    break;
                }
            }
        }
        ?>
        <table class="sig-table">
            <!-- PEMOHON -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; padding-bottom: 5px;">Pemohon,</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Ketua Ormawa</b>
                    <div class="sig-space"></div>
                    <span class="sig-name"><?= _e($p->nama_pengaju ?? '..........................') ?></span><br>
                    NIM. <?= _e($p->nim ?? '..........................') ?>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Ketua Kegiatan</b>
                    <div class="sig-space"></div>
                    <span class="sig-name"><?= _e($ketua_kegiatan_nama) ?></span><br>
                    NIM. <?= _e($ketua_kegiatan_nim) ?>
                </td>
            </tr>

            <!-- PENANGGUNG JAWAB -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; padding: 15px 0 5px;">Penanggung Jawab,</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Ketua Program Studi <?= _ok($prodi_label) ? $prodi_label : '' ?></b>
                    <div class="sig-space"></div>
                    <span class="sig-name"><?= $kaprodi_nama ?></span><br>
                    NIP/NIDN. <?= $kaprodi_nip ?>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Dosen Pembina / Pembimbing <?= $ormawa_label ?></b>
                    <div class="sig-space"></div>
                    <span class="sig-name"><?= $pembina_nama ?></span><br>
                    NIP/NIDN. <?= $pembina_nip ?>
                </td>
            </tr>

            <!-- MENYETUJUI -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; padding: 15px 0 5px;">Menyetujui,</td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Wakil Dekan Bidang Keuangan,<br>Sumber Daya dan Kemahasiswaan FIK</b>
                    <div class="sig-space"></div>
                    <span class="sig-name">Dr. Ira Wirasari, S.Sos., M.Ds.</span><br>
                    NIP. 14810009
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b>Kepala Urusan Kemahasiswaan<br>Fakultas Industri Kreatif</b>
                    <div class="sig-space"></div>
                    <span class="sig-name">Isnan Purnama, S.E., M.M.</span><br>
                    NIP. 22930026
                </td>
            </tr>

            <!-- MENGETAHUI -->
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; padding: 15px 0 5px;">Mengetahui,</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; vertical-align: top;">
                    <b>Dekan Fakultas Industri Kreatif</b>
                    <div class="sig-space"></div>
                    <span class="sig-name">Dandi Yunidar, S.Sn., M.Ds., Ph.D.</span><br>
                    NIP. 14760039
                </td>
            </tr>
        </table>
    </div>

    <!-- LAMPIRAN -->
    <div style="page-break-before: always; padding-top: 10px;">
        <div style="text-align: center; font-size: 14px; font-weight: bold; text-transform: uppercase; margin-bottom: 20px;">LAMPIRAN</div>

        <p><b>Ketua Program Studi</b></p>
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Ketua Program Studi</th>
                    <th>Nama</th>
                    <th>NIP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kaprodi_list as $prodi => $data): ?>
                <tr>
                    <td class="col-no"><?php static $no_kp = 1; echo $no_kp++; ?></td>
                    <td><?= htmlspecialchars(ucwords($prodi)) ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td><?= htmlspecialchars($data['nip']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top: 20px;"><b>Pembina Organisasi Mahasiswa</b></p>
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th>Pembina Ormawa</th>
                    <th>Nama</th>
                    <th>NIP</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pembina_list as $ormawa => $data): ?>
                <tr>
                    <td class="col-no"><?php static $no_pb = 1; echo $no_pb++; ?></td>
                    <td><?= htmlspecialchars(strtoupper($ormawa)) ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td><?= htmlspecialchars($data['nip']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top: 20px; font-size: 10px; color: #555;">
            Informasi Kemahasiswaan: Instagram: <b>kemahasiswaan_fik</b> | 
            Desty Page: <b>https://desty.page/kemahasiswaan_fik</b> | 
            Atribut Kemahasiswaan: <b>https://bit.ly/BerkasKemahasiswaanFIK2026</b> | 
            Hotline WA: <b>0823-1285-2869</b>
        </p>
    </div>

</div>
</body>
</html>