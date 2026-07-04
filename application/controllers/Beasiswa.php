<?php
error_reporting(0);
ini_set('display_errors', 0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Beasiswa extends CI_Controller {
    
    private $upload_path;
    
    public function __construct() {
    parent::__construct();
    $this->load->model('beasiswa_model');
    $this->load->library(['form_validation', 'upload', 'email']);
    $this->load->helper(['form', 'url', 'file', 'string']);
    
    // Matikan error reporting ke output (hanya untuk debugging)
    error_reporting(0);
    ini_set('display_errors', 0);
    
    // Set upload path
    $this->upload_path = './uploads/beasiswa/' . date('Y/m/');
}
    
// Modifikasi method index() - gunakan model langsung
public function index() {
    $data['title'] = 'Beasiswa FIK';
    $data['beasiswa_aktif'] = $this->beasiswa_model->get_beasiswa_aktif();
    $data['semua_beasiswa'] = $this->beasiswa_model->get_all_beasiswa();
    $data['statistik'] = $this->beasiswa_model->get_statistik_per_jenis();
    $data['pendaftar_list'] = $this->beasiswa_model->get_all_pendaftaran(); // LANGSUNG PAKAI MODEL
    
    // Get user data if logged in
    $data['user_data'] = $this->session->userdata(); // Ganti $data['user'] jadi $data['user_data']
    
    $this->load->view('beasiswa', $data);
}
    
    public function submit() {
    // Set response header
    header('Content-Type: application/json');
    
    // Validasi input
    $this->_validate_form();
    
    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'status' => 'error',
            'message' => validation_errors('<div>', '</div>')
        ]);
        return;
    }
    
    // Proses upload file
    $upload_results = $this->_process_uploads();
    
    if (isset($upload_results['error'])) {
        echo json_encode([
            'status' => 'error',
            'message' => $upload_results['error']
        ]);
        return;
    }
    
    // Data pendaftaran - SESUAIKAN DENGAN TABEL ANDA
    $data = array(
        'nama' => $this->input->post('nama'),
        'tempat_lahir' => $this->input->post('tempat_lahir'),
        'tanggal_lahir' => $this->input->post('tanggal_lahir'),
        'jenis_beasiswa' => $this->input->post('jenis_beasiswa'),
        'asal_sekolah' => $this->input->post('asal_sekolah'),
        'jurusan' => $this->input->post('jurusan'),
        'tahun_lulus' => $this->input->post('tahun_lulus'),
        'no_hp' => $this->input->post('no_hp'),
        'email' => $this->input->post('email'),
        'alamat' => $this->input->post('alamat'),
        'nilai_rapor' => $this->input->post('nilai_rapor'),
        'peringkat' => $this->input->post('peringkat'),
        'prestasi' => $this->input->post('prestasi'),
        'file_nilai' => $upload_results['nilai']['file_name'],
        'file_foto' => isset($upload_results['foto']) ? $upload_results['foto']['file_name'] : null,
        'file_rekomendasi' => isset($upload_results['rekomendasi']) ? $upload_results['rekomendasi']['file_name'] : null,
        'status' => 'pending',
        'tanggal_daftar' => date('Y-m-d H:i:s')
    );
    
    // Coba insert
    $pendaftaran_id = $this->beasiswa_model->insert_pendaftaran($data);
    
    if ($pendaftaran_id) {
        // Simpan file info
        $this->_save_file_info($pendaftaran_id, $upload_results);
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Pendaftaran beasiswa berhasil!'
        ]);
    } else {
        // Ambil error dari database
        $db_error = $this->db->error();
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menyimpan data: ' . $db_error['message']
        ]);
    }
}
    
    /**
     * Validasi form
     */
    private function _validate_form() {
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|max_length[100]');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('jenis_beasiswa', 'Jenis Beasiswa', 'required|in_list[prestasi,kip,kreatif,afirmasi,telu_unggul,internasional]');
        $this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required|max_length[255]');
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|max_length[100]');
        $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required|exact_length[4]|numeric');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|min_length[10]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[255]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('nilai_rapor', 'Nilai Rapor', 'required|numeric|greater_than[0]|less_than[100]');
        $this->form_validation->set_rules('peringkat', 'Peringkat Kelas', 'max_length[100]');
        
        // Custom error messages
        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter');
        $this->form_validation->set_message('max_length', '{field} maksimal {param} karakter');
        $this->form_validation->set_message('valid_email', 'Format email tidak valid');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka');
        $this->form_validation->set_message('greater_than', '{field} harus lebih besar dari 0');
        $this->form_validation->set_message('less_than', '{field} harus kurang dari 100');
        
    }
    
    /**
     * Proses upload file
     */
    private function _process_uploads() {
        $results = [];
        
        // Buat folder jika belum ada
        if (!is_dir($this->upload_path)) {
            mkdir($this->upload_path, 0777, true);
        }
        
        // Konfigurasi upload
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => 'pdf|jpg|jpeg|png',
            'max_size' => 5120, // 5MB
            'encrypt_name' => true,
            'remove_spaces' => true,
            'detect_mime' => true
        ];
        
        $this->upload->initialize($config);
        
        // Upload file nilai (wajib)
        if (!isset($_FILES['file_nilai']) || $_FILES['file_nilai']['error'] == UPLOAD_ERR_NO_FILE) {
            return ['error' => 'File nilai rapor wajib diupload'];
        }
        
        if (!$this->upload->do_upload('file_nilai')) {
            return ['error' => $this->upload->display_errors()];
        }
        
        $results['nilai'] = $this->upload->data();
        
        // Upload file foto (opsional)
        if (isset($_FILES['file_foto']) && $_FILES['file_foto']['error'] != UPLOAD_ERR_NO_FILE) {
            $config['max_size'] = 2048; // 2MB untuk foto
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('file_foto')) {
                $results['foto'] = $this->upload->data();
            }
        }
        
        // Upload file rekomendasi (opsional)
        if (isset($_FILES['file_rekomendasi']) && $_FILES['file_rekomendasi']['error'] != UPLOAD_ERR_NO_FILE) {
            $config['max_size'] = 5120; // 5MB untuk rekomendasi
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('file_rekomendasi')) {
                $results['rekomendasi'] = $this->upload->data();
            }
        }
        
        return $results;
    }
    
    /**
     * Simpan info file ke database
     */
    private function _save_file_info($pendaftaran_id, $files) {
        foreach ($files as $kategori => $file) {
            if ($kategori == 'error') continue;
            
            $data = [
                'pendaftaran_id' => $pendaftaran_id,
                'file_name' => $file['file_name'],
                'file_type' => $file['file_type'],
                'file_size' => $file['file_size'],
                'file_path' => $this->upload_path . $file['file_name'],
                'kategori' => $kategori,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];
            
            $this->beasiswa_model->insert_file($data);
        }
    }
    
    /**
     * Kirim email konfirmasi ke pendaftar
     */
    private function _send_confirmation_email($data) {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'fik@telkomuniversity.ac.id', // Ganti dengan email Anda
            'smtp_pass' => 'password', // Ganti dengan password Anda
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        
        $this->email->initialize($config);
        
        // Dapatkan nama beasiswa
        $beasiswa = $this->beasiswa_model->get_beasiswa_by_jenis($data['jenis_beasiswa']);
        $nama_beasiswa = $beasiswa ? $beasiswa->nama_beasiswa : ucfirst($data['jenis_beasiswa']);
        
        $this->email->from('fik@telkomuniversity.ac.id', 'Fakultas Industri Kreatif Telkom University');
        $this->email->to($data['email']);
        $this->email->subject('Konfirmasi Pendaftaran Beasiswa ' . $nama_beasiswa);
        
        $message = $this->load->view('emails/beasiswa_confirmation', [
            'data' => $data,
            'nama_beasiswa' => $nama_beasiswa
        ], true);
        
        $this->email->message($message);
        $this->email->send();
    }
    
    /**
     * Kirim notifikasi ke admin
     */
    private function _send_admin_notification($data) {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'fik@telkomuniversity.ac.id',
            'smtp_pass' => 'password',
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8'
        ];
        
        $this->email->initialize($config);
        
        $this->email->from('fik@telkomuniversity.ac.id', 'Fakultas Industri Kreatif');
        $this->email->to('admin.fik@telkomuniversity.ac.id');
        $this->email->subject('Pendaftaran Beasiswa Baru - ' . $data['nama']);
        
        $message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; }
                .header { background: #E67E22; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                td { padding: 10px; border-bottom: 1px solid #ddd; }
                td.label { font-weight: bold; width: 150px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Pendaftaran Beasiswa Baru</h2>
                </div>
                <div class='content'>
                    <p>Ada pendaftaran beasiswa baru dengan detail:</p>
                    <table>
                        <tr><td class='label'>Nama</td><td>: {$data['nama']}</td></tr>
                        <tr><td class='label'>Email</td><td>: {$data['email']}</td></tr>
                        <tr><td class='label'>No HP</td><td>: {$data['no_hp']}</td></tr>
                        <tr><td class='label'>Jenis Beasiswa</td><td>: " . ucfirst($data['jenis_beasiswa']) . "</td></tr>
                        <tr><td class='label'>Asal Sekolah</td><td>: {$data['asal_sekolah']}</td></tr>
                        <tr><td class='label'>Nilai Rapor</td><td>: {$data['nilai_rapor']}</td></tr>
                        <tr><td class='label'>Tanggal Daftar</td><td>: {$data['tanggal_daftar']}</td></tr>
                    </table>
                    <p>Silakan cek panel admin untuk memproses pendaftaran ini.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $this->email->message($message);
        $this->email->send();
    }
    
    /**
     * Lihat status pendaftaran
     */
    public function status() {
        $email = $this->input->get('email');
        
        if (!$email) {
            show_404();
        }
        
        $data['title'] = 'Status Pendaftaran Beasiswa';
        $data['pendaftaran'] = $this->beasiswa_model->get_pendaftaran_by_email($email);
        
        $this->load->view('beasiswa_status', $data);
    }
    
    /**
     * Download file
     */
    public function download($id) {
        $file = $this->db->get_where('beasiswa_files', ['id' => $id])->row();
        
        if (!$file) {
            show_404();
        }
        
        $this->load->helper('download');
        force_download($file->file_path, null);
    }
    
    /**
     * Cek status pendaftaran via AJAX
     */
    public function cek_status() {
        header('Content-Type: application/json');
        
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        
        if (!$email || !$no_hp) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email dan No HP wajib diisi'
            ]);
            return;
        }
        
        $this->db->from('beasiswa_pendaftaran');
        $this->db->where('email', $email);
        $this->db->where('no_hp', $no_hp);
        $this->db->order_by('tanggal_daftar', 'DESC');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $result = $query->result();
            echo json_encode([
                'status' => 'success',
                'data' => $result
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    
    /**
     * Helper untuk mendapatkan nama beasiswa berdasarkan jenis
     */
    public function get_beasiswa_by_jenis($jenis) {
        return $this->db->get_where('beasiswa', ['jenis' => $jenis])->row();
    }
    public function debug_insert() {
    // Data test sederhana
    $test_data = array(
        'nama' => 'TEST USER',
        'email' => 'test@example.com',
        'no_hp' => '08123456789',
        'asal_sekolah' => 'SMK Test',
        'jurusan' => 'RPL',
        'tahun_lulus' => 2025,
        'nilai_rapor' => 85.5,
        'jenis_beasiswa' => 'prestasi',
        'status' => 'pending',
        'tanggal_daftar' => date('Y-m-d H:i:s')
    );
    
    // Coba insert
    $this->db->insert('beasiswa_pendaftaran', $test_data);
    $insert_id = $this->db->insert_id();
    
    // Tampilkan hasil
    echo "<pre>";
    echo "Insert ID: " . $insert_id . "\n\n";
    echo "DB Error: ";
    print_r($this->db->error());
    echo "\n\n";
    echo "Last Query: " . $this->db->last_query();
    echo "</pre>";
}
}