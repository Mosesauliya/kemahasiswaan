<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sertifikat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sertifikat_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'form']);

        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    public function index()
    {
        $role = $this->session->userdata('role');
        if (in_array($role, ['kemahasiswaan', 'admin'])) {
            redirect('sertifikat/admin');
        }

        $user_id = $this->session->userdata('user_id');
        $data['title']         = 'Pengajuan Sertifikat';
        $data['user_data']     = $this->_get_session_user();
        $data['riwayat']       = $this->Sertifikat_model->get_by_mahasiswa($user_id);
        $data['flash_success'] = $this->session->flashdata('success');
        $data['flash_error']   = $this->session->flashdata('error');

        $this->load->view('sertifikat/index', $data);
    }

    public function kirim()
{
    if ($this->input->method() !== 'post') redirect('sertifikat');

    $this->form_validation->set_rules('nama_pic',         'Nama PIC',         'required|trim');
    $this->form_validation->set_rules('judul_kegiatan',   'Judul Kegiatan',   'required|trim');
    $this->form_validation->set_rules('tanggal_kegiatan', 'Tanggal Kegiatan', 'required');
    $this->form_validation->set_rules('lokasi_kegiatan',  'Lokasi Kegiatan',  'required|trim');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('sertifikat');
    }

    // HAPUS PROSES UPLOAD FILE
    // $file_sertifikat = $this->_upload_file('file_sertifikat', 'sertifikat');
    // $file_penerima   = $this->_upload_file('file_penerima', 'penerima');

    $user_id = $this->session->userdata('user_id');
    $data = [
        'mahasiswa_id'       => $user_id,
        'nim'                => $this->session->userdata('nim') ?? '-',
        'nama_mahasiswa'     => $this->session->userdata('nama'),
        'prodi'              => $this->session->userdata('prodi'),
        'nama_pic'           => $this->input->post('nama_pic', TRUE),
        'judul_kegiatan'     => $this->input->post('judul_kegiatan', TRUE),
        'deskripsi_kegiatan' => $this->input->post('deskripsi_kegiatan', TRUE),
        'tanggal_kegiatan'   => $this->input->post('tanggal_kegiatan'),
        'lokasi_kegiatan'    => $this->input->post('lokasi_kegiatan', TRUE),
        'catatan_tambahan'   => $this->input->post('catatan_tambahan', TRUE),
        // HAPUS file_sertifikat dan file_penerima
    ];

    $kode = $this->Sertifikat_model->insert($data, $user_id);

    if ($kode) {
        $this->session->set_flashdata('success', 'Pengajuan berhasil! Sertifikat telah diterbitkan. Kode: <strong>' . $kode . '</strong>');
    } else {
        $this->session->set_flashdata('error', 'Gagal menyimpan pengajuan. Silakan coba lagi.');
    }
    redirect('sertifikat');
}

// HAPUS method _upload_file() karena tidak digunakan lagi
// private function _upload_file($field, $subfolder) { ... }
    public function admin()
{
    $this->_check_admin();

    $status_filter = $this->input->get('status') ?? '';
    $search        = $this->input->get('q') ?? '';

    // Ambil data dari model
    $pengajuan_list = $this->Sertifikat_model->get_all($status_filter, $search);
    $stats          = $this->Sertifikat_model->get_stats();
    
    // Hitung pending count untuk badge di sidebar
    $pending_count = $stats['submitted'] ?? 0;

   $data = [
    'title' => 'Manajemen Pengajuan Sertifikat',
    'pengajuan_list' => $pengajuan_list,
    'stats' => $stats,
    'status_filter' => $status_filter,
    'search' => $search,
    'flash_success' => $this->session->flashdata('success'),
    'flash_error' => $this->session->flashdata('error')
];

    $this->load->view('sertifikat/admin', $data);
}

    // AJAX: approve atau reject
public function update_status()
{
    header('Content-Type: application/json');
    $this->_check_admin_ajax();

    // Log untuk debugging
    log_message('debug', 'update_status called with POST: ' . print_r($_POST, true));

    $id      = (int) $this->input->post('id');
    $action  = $this->input->post('action'); // 'approve' atau 'reject'
    $catatan = $this->input->post('catatan', TRUE);

    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
        return;
    }

    if (!in_array($action, ['approve', 'reject'])) {
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
        return;
    }

    // Jika reject, catatan wajib diisi
    if ($action === 'reject' && empty(trim($catatan))) {
        echo json_encode(['status' => 'error', 'message' => 'Alasan penolakan wajib diisi.']);
        return;
    }

    $extra = [];
    if ($action === 'approve') {
        $nomor = $this->input->post('nomor_sertifikat', TRUE);
        if (empty(trim($nomor))) {
            echo json_encode(['status' => 'error', 'message' => 'Nomor sertifikat wajib diisi.']);
            return;
        }
        $extra['nomor_sertifikat'] = $nomor;
        $extra['qr_code']          = $this->input->post('qr_code', TRUE);
    }

    $admin_id = $this->session->userdata('user_id');
    $result   = $this->Sertifikat_model->update_status($id, $action, $catatan, $admin_id, $extra);

    if ($result) {
        $label = ($action === 'approve') ? 'Disetujui' : 'Ditolak';
        echo json_encode([
            'status' => 'success', 
            'message' => 'Pengajuan berhasil ' . $label . '.', 
            'new_status' => ($action === 'approve' ? 'approved' : 'rejected')
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Gagal mengubah status. Pastikan status pengajuan masih "Menunggu".'
        ]);
    }
}
    // AJAX: detail pengajuan untuk modal
    public function get_detail_json($id)
    {
        header('Content-Type: application/json');
        $this->_check_admin_ajax();

        $pengajuan = $this->Sertifikat_model->get_by_id($id);
        if (!$pengajuan) {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
            return;
        }
        $log = $this->Sertifikat_model->get_log($id);
        echo json_encode(['status' => 'success', 'pengajuan' => $pengajuan, 'log' => $log]);
    }


    private function _get_session_user()
    {
        $role = $this->session->userdata('role');
        $map  = ['mahasiswa' => 'Mahasiswa', 'kemahasiswaan' => 'Staff Kemahasiswaan', 'admin' => 'Admin', 'dosen' => 'Dosen'];
        return [
            'user_id'      => $this->session->userdata('user_id'),
            'nama'         => $this->session->userdata('nama'),
            'nim'          => $this->session->userdata('nim'),
            'role'         => $role,
            'prodi'        => $this->session->userdata('prodi'),
            'role_display' => $map[$role] ?? ucfirst($role),
        ];
    }

    private function _check_admin()
    {
        if (!in_array($this->session->userdata('role'), ['kemahasiswaan', 'admin'])) {
            show_error('Akses ditolak.', 403);
        }
    }

    private function _check_admin_ajax()
    {
        if (!in_array($this->session->userdata('role'), ['kemahasiswaan', 'admin'])) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }
    }
    /**
 * Download file export Excel
 */
public function download_export($id)
{
    // Cek login
    if (!$this->session->userdata('logged_in')) {
        redirect('login');
    }
    
    // Ambil data pengajuan
    $pengajuan = $this->Sertifikat_model->get_by_id($id);
    
    if (!$pengajuan) {
        show_404();
    }
    
    // Cek kepemilikan (hanya pemilik atau admin yang bisa download)
    $user_id = $this->session->userdata('user_id');
    $role = $this->session->userdata('role');
    
    if ($pengajuan['mahasiswa_id'] != $user_id && !in_array($role, ['admin', 'kemahasiswaan'])) {
        show_error('Akses ditolak.', 403);
    }
    
    // Cek file export
    if (empty($pengajuan['file_export']) || !file_exists(FCPATH . $pengajuan['file_export'])) {
        // Jika file tidak ada, generate ulang
        $data_pengajuan = [
            'kode_pengajuan' => $pengajuan['kode_pengajuan'],
            'judul_kegiatan' => $pengajuan['judul_kegiatan'],
            'tanggal_kegiatan' => $pengajuan['tanggal_kegiatan'],
            'lokasi_kegiatan' => $pengajuan['lokasi_kegiatan'],
            'nama_pic' => $pengajuan['nama_pic'],
            'nim' => $pengajuan['nim'],
            'nama_mahasiswa' => $pengajuan['nama_mahasiswa'],
            'prodi' => $pengajuan['prodi'],
            'deskripsi_kegiatan' => $pengajuan['deskripsi_kegiatan'],
            'catatan_tambahan' => $pengajuan['catatan_tambahan'],
        ];
        
        $this->Sertifikat_model->regenerate_export($id, $data_pengajuan);
        
        // Ambil ulang data pengajuan
        $pengajuan = $this->Sertifikat_model->get_by_id($id);
    }
    
    $filepath = FCPATH . $pengajuan['file_export'];
    $filename = 'pengajuan_' . $pengajuan['kode_pengajuan'] . '.xls';
    
    // Download file
    $this->load->helper('download');
    force_download($filename, file_get_contents($filepath));
}

    /**
     * Export Excel untuk Canva Bulk Design
     * Format kolom: nama_mahasiswa, nim, prodi, judul_kegiatan, tanggal_kegiatan,
     *               lokasi_kegiatan, nomor_sertifikat, nama_pic, tanggal_pengajuan
     */
    public function export_excel_canva()
    {
        $this->_check_admin();

        // Ambil semua sertifikat yang sudah approved
        $this->db->where('status', 'approved');
        $this->db->order_by('approved_at', 'DESC');
        $data = $this->db->get('pengajuan_sertifikat')->result_array();

        // Set header untuk download Excel
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="Sertifikat_Canva_' . date('Ymd_His') . '.xls"');
        header('Cache-Control: max-age=0');

        // BOM untuk UTF-8 agar Excel baca dengan benar
        echo "\xEF\xBB\xBF";

        // Buat konten HTML table (format .xls via HTML)
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head><meta charset="UTF-8">
        <style>
            th { background-color: #f97316; color: white; font-weight: bold; padding: 8px; border: 1px solid #ddd; text-align: center; }
            td { padding: 6px 10px; border: 1px solid #ddd; vertical-align: middle; }
            tr:nth-child(even) td { background-color: #fff7ed; }
            .header-row td { background: #1e293b; color: white; font-size: 14pt; font-weight: bold; text-align: center; }
            .info-row td { background: #f1f5f9; font-size: 9pt; color: #64748b; }
        </style>
        </head><body>';

        echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse; font-family:Arial, sans-serif; font-size:10pt;">';

        // Header utama
        echo '<tr class="header-row"><td colspan="10" style="padding:14px;font-size:14pt;font-weight:bold;background:#1e293b;color:white;text-align:center;">DATA SERTIFIKAT KEGIATAN — FORMAT CANVA BULK DESIGN</td></tr>';
        echo '<tr class="info-row"><td colspan="10" style="padding:6px;font-size:9pt;color:#64748b;background:#f1f5f9;">Export tanggal: ' . date('d-m-Y H:i:s') . ' | Total: ' . count($data) . ' sertifikat disetujui</td></tr>';
        echo '<tr><td colspan="10" style="height:4px;background:#f97316;"></td></tr>';

        // Kolom header — sesuai format Canva Bulk Design
        echo '<tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Judul Kegiatan</th>
            <th>Tanggal Kegiatan</th>
            <th>Lokasi Kegiatan</th>
            <th>Nomor Sertifikat</th>
            <th>Nama PIC / Penanggung Jawab</th>
            <th>Tanggal Disetujui</th>
        </tr>';

        // Data rows
        if (empty($data)) {
            echo '<tr><td colspan="10" style="text-align:center;color:#999;padding:20px;">Belum ada sertifikat yang disetujui</td></tr>';
        } else {
            foreach ($data as $i => $row) {
                $tanggal_kegiatan = !empty($row['tanggal_kegiatan'])
                    ? date('d/m/Y', strtotime($row['tanggal_kegiatan']))
                    : '-';
                $tanggal_approved = !empty($row['approved_at'])
                    ? date('d/m/Y', strtotime($row['approved_at']))
                    : '-';

                echo '<tr>
                    <td style="text-align:center;">' . ($i + 1) . '</td>
                    <td><strong>' . htmlspecialchars($row['nama_mahasiswa'] ?? '-') . '</strong></td>
                    <td style="text-align:center;mso-number-format:\'\@\';">' . htmlspecialchars($row['nim'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($row['prodi'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($row['judul_kegiatan'] ?? '-') . '</td>
                    <td style="text-align:center;">' . $tanggal_kegiatan . '</td>
                    <td>' . htmlspecialchars($row['lokasi_kegiatan'] ?? '-') . '</td>
                    <td style="text-align:center;font-weight:bold;color:#f97316;">' . htmlspecialchars($row['nomor_sertifikat'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($row['nama_pic'] ?? '-') . '</td>
                    <td style="text-align:center;">' . $tanggal_approved . '</td>
                </tr>';
            }
        }

        echo '</table></body></html>';
        exit;
    }

    /**
     * Halaman Generate Sertifikat (pilih data + template)
     */
    public function generate()
    {
        $this->_check_admin();

        // Ambil semua data yang sudah approved
        $this->db->where('status', 'approved');
        $this->db->order_by('approved_at', 'DESC');
        $data['sertifikat_list'] = $this->db->get('pengajuan_sertifikat')->result_array();
        $data['title']           = 'Generate Sertifikat';

        // Scan folder custom template (tanpa butuh tabel DB)
        $custom_dir   = FCPATH . 'templates/sertifikat/custom/';
        $custom_files = [];
        if (is_dir($custom_dir)) {
            $idx = 1;
            foreach (glob($custom_dir . '*.{png,jpg,jpeg}', GLOB_BRACE) as $filepath) {
                $filename = basename($filepath);
                // Nama template: nama file tanpa ekstensi, underscores → spasi
                $name = ucwords(str_replace(['_', '-'], ' ', pathinfo($filename, PATHINFO_FILENAME)));
                $custom_files[] = [
                    'id'   => $idx++,
                    'name' => $name,
                    'file' => $filename,
                ];
            }
        }
        $data['custom_templates'] = $custom_files;

        $this->load->view('sertifikat/generate', $data);
    }

    /**
     * AJAX: Upload template custom ke folder templates/sertifikat/custom/
     * Tidak butuh tabel database. Response JSON: { success, id, name, url }
     */
    public function upload_template()
    {
        header('Content-Type: application/json');
        $this->_check_admin_ajax();

        $custom_dir = FCPATH . 'templates/sertifikat/custom/';

        // Pastikan folder ada
        if (!is_dir($custom_dir)) {
            mkdir($custom_dir, 0755, true);
        }

        if (empty($_FILES['template_file']['name'])) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada file yang diunggah.']);
            return;
        }

        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg'];
        $file_type     = $_FILES['template_file']['type'];
        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(['success' => false, 'message' => 'Tipe file tidak didukung. Gunakan PNG/JPG.']);
            return;
        }

        // Ukuran maks 5 MB
        if ($_FILES['template_file']['size'] > 5 * 1024 * 1024) {
            echo json_encode(['success' => false, 'message' => 'Ukuran file melebihi batas 5 MB.']);
            return;
        }

        // Nama template yang diinput (opsional), fallback ke nama file
        $template_name = $this->input->post('template_name', TRUE);
        if (empty($template_name)) {
            $template_name = pathinfo($_FILES['template_file']['name'], PATHINFO_FILENAME);
        }
        $template_name = preg_replace('/[^a-zA-Z0-9\s_-]/', '', $template_name);

        // Buat nama file unik agar tidak tumpang-tindih
        $ext       = strtolower(pathinfo($_FILES['template_file']['name'], PATHINFO_EXTENSION));
        $safe_name = 'custom_' . date('YmdHis') . '_' . uniqid() . '.' . $ext;
        $dest      = $custom_dir . $safe_name;

        if (!move_uploaded_file($_FILES['template_file']['tmp_name'], $dest)) {
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan file ke server.']);
            return;
        }

        // Hitung id urut berdasarkan jumlah file yang sudah ada
        $existing = glob($custom_dir . '*.{png,jpg,jpeg}', GLOB_BRACE);
        $new_id   = count($existing);

        $url = base_url('templates/sertifikat/custom/' . $safe_name);
        $display_name = ucwords(str_replace(['_', '-'], ' ', $template_name));

        echo json_encode([
            'success' => true,
            'id'      => $new_id,
            'name'    => $display_name,
            'url'     => $url,
        ]);
    }

    /**
     * Endpoint JSON: ambil semua data approved untuk AJAX
     */
    public function get_approved_json()
    {
        header('Content-Type: application/json');
        $this->_check_admin_ajax();

        $this->db->where('status', 'approved');
        $this->db->order_by('approved_at', 'DESC');
        $rows = $this->db->get('pengajuan_sertifikat')->result_array();

        echo json_encode(['status' => 'success', 'data' => $rows]);
    }

    /**
     * Halaman verifikasi sertifikat publik (via QR Code)
     */
    public function verifikasi()
    {
        // Ambil semua segment URI mulai dari segment ke-4 ke bawah
        $segments = $this->uri->segment_array();
        // Segment 1: sertifikat, Segment 2: verifikasi, Segment 3 dst: nomor sertifikat
        $nomor_segments = array_slice($segments, 2);
        
        if (empty($nomor_segments)) {
            show_404();
        }

        $nomor_sertifikat = implode('/', $nomor_segments);

        $this->db->where('nomor_sertifikat', $nomor_sertifikat);
        $this->db->where('status', 'approved');
        $sertifikat = $this->db->get('pengajuan_sertifikat')->row_array();

        $data['title']       = 'Verifikasi Sertifikat - ' . $nomor_sertifikat;
        $data['sertifikat']  = $sertifikat;
        $data['nomor']       = $nomor_sertifikat;

        $this->load->view('sertifikat/verifikasi', $data);
    }
}
