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
}