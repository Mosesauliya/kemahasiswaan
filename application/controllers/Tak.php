<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tak extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tak_model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('download');

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman TAK');
            redirect('login');
        }

        // Set session untuk testing (opsional, hapus jika sudah production)
        if (!$this->session->userdata('nim')) {
            $this->session->set_userdata('nim', $this->session->userdata('user_id') ?: '12345678');
            $this->session->set_userdata('nama', $this->session->userdata('nama') ?: 'User');
        }
    }

    /**
     * Halaman utama form pengajuan TAK
     */
    public function index()
    {
        // Ambil data user dari session
        $user_data = $this->_get_user_data();
        
        $data['title'] = 'Pengajuan TAK Kolektif - Kemahasiswaan FIK';
        $data['user_data'] = $user_data;
        
        // Buat folder upload jika belum ada
        $this->_buat_folder_upload();
        
        $this->load->view('tak/pengajuan', $data);
    }

    /**
     * Submit pengajuan TAK
     */
    public function submit_pengajuan()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Validasi form
        $this->form_validation->set_rules('nama_pic', 'Nama PIC', 'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('judul_kegiatan', 'Judul Kegiatan', 'required|trim|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi Kegiatan', 'required|trim|min_length[10]');
        $this->form_validation->set_rules('tanggal_kegiatan', 'Tanggal Kegiatan', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi Kegiatan', 'required|trim|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('link_sertifikat', 'Link Sertifikat', 'required|valid_url');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors('<div class="alert alert-danger">', '</div>'));
            redirect('tak');
        }

        // Buat folder upload
        $this->_buat_folder_upload();

        $upload_path_surat = FCPATH . 'uploads/surat_pengajuan/';
        $upload_path_excel = FCPATH . 'uploads/excel_peserta/';

        // Upload Surat Pengajuan
        $config['upload_path'] = $upload_path_surat;
        $config['allowed_types'] = 'pdf|doc|docx';
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('surat_pengajuan')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Upload surat gagal: ' . $error);
            redirect('tak');
        }
        
        $surat_data = $this->upload->data();

        // Upload Excel Peserta
        $config_excel['upload_path'] = $upload_path_excel;
        $config_excel['allowed_types'] = 'xlsx|xls|csv';
        $config_excel['max_size'] = 2048; // 2MB
        $config_excel['encrypt_name'] = TRUE;

        $this->upload->initialize($config_excel);

        if (!$this->upload->do_upload('excel_peserta')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Upload excel gagal: ' . $error);
            redirect('tak');
        }
        
        $excel_data = $this->upload->data();
        
        // Generate kode pengajuan unik
        $kode_pengajuan = $this->_generate_kode_pengajuan();
        
        // Data pengajuan
        $pengajuan_data = array(
            'kode_pengajuan' => $kode_pengajuan,
            'nim' => $this->session->userdata('nim'),
            'nama_mahasiswa' => $this->session->userdata('nama'),
            'nama_pic' => $this->input->post('nama_pic', TRUE),
            'judul_kegiatan' => $this->input->post('judul_kegiatan', TRUE),
            'deskripsi' => $this->input->post('deskripsi', TRUE),
            'tanggal_kegiatan' => $this->input->post('tanggal_kegiatan'),
            'lokasi' => $this->input->post('lokasi', TRUE),
            'link_sertifikat' => $this->input->post('link_sertifikat', TRUE),
            'file_surat_pengajuan' => $surat_data['file_name'],
            'file_excel_peserta' => $excel_data['file_name'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->Tak_model->insert_pengajuan($pengajuan_data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Pengajuan TAK berhasil dikirim. Kode pengajuan: ' . $kode_pengajuan);
            redirect('tak/riwayat');
        } else {
            $error = $this->db->error();
            $this->session->set_flashdata('error', 'Gagal menyimpan data: ' . $error['message']);
            redirect('tak');
        }
    }

    /**
     * Generate kode pengajuan unik
     * Format: TAK/YYYYMMDD/XXXX
     */
    private function _generate_kode_pengajuan()
    {
        $prefix = 'TAK';
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        return $prefix . '/' . $date . '/' . $random;
    }

    /**
     * Halaman riwayat pengajuan TAK dengan statistik
     */
    public function riwayat()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $user_data = $this->_get_user_data();
        $nim = $this->session->userdata('nim');
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;
        
        // Ambil data pengajuan
        $data['pengajuan'] = $this->Tak_model->get_riwayat_pengajuan($nim, $per_page, $offset);
        
        // ========== HITUNG STATISTIK ==========
        $data['total_pengajuan'] = $this->Tak_model->count_pengajuan_by_user($nim);
        $data['total_pending'] = $this->Tak_model->count_pengajuan_by_status($nim, 'pending');
        $data['total_diproses'] = $this->Tak_model->count_pengajuan_by_status($nim, 'diproses');
        $data['total_disetujui'] = $this->Tak_model->count_pengajuan_by_status($nim, 'disetujui');
        $data['total_ditolak'] = $this->Tak_model->count_pengajuan_by_status($nim, 'ditolak');
        
        // Pagination info
        $data['total_pages'] = ceil($data['total_pengajuan'] / $per_page);
        $data['current_page'] = $page;
        $data['per_page'] = $per_page;
        
        $data['title'] = 'Riwayat Pengajuan TAK - Kemahasiswaan FIK';
        $data['user_data'] = $user_data;
        
        $this->load->view('tak/riwayat', $data);
    }

    /**
     * Detail pengajuan TAK
     */
    public function detail($id)
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $user_data = $this->_get_user_data();
        $nim = $this->session->userdata('nim');
        
        $data['pengajuan'] = $this->Tak_model->get_pengajuan_by_id($id, $nim);

        if (empty($data['pengajuan'])) {
            show_404();
        }

        $data['title'] = 'Detail Pengajuan TAK - ' . $data['pengajuan']->judul_kegiatan;
        $data['user_data'] = $user_data;
        
        $this->load->view('tak/detail', $data);
    }

    /**
     * Download template
     */
    public function download_template($type)
    {
        // Buat folder templates jika belum ada
        $template_dir = FCPATH . 'templates/';
        $this->_buat_folder_upload();

        if ($type == 'surat') {
            $file_path = $template_dir . 'template_surat_pengajuan_TAK.docx';
            $file_name = 'Template_Surat_Pengajuan_TAK.docx';

            // Buat file template surat jika belum ada
            if (!file_exists($file_path)) {
                $content = $this->_generate_template_surat();
                file_put_contents($file_path, $content);
            }
        } elseif ($type == 'excel') {
            $file_path = $template_dir . 'template_data_peserta_TAK.xlsx';
            $file_name = 'Template_Data_Peserta_TAK.xlsx';

            // Buat file template excel jika belum ada
            if (!file_exists($file_path)) {
                // Untuk XLSX, kita buat file CSV sebagai alternatif
                $csv_path = $template_dir . 'template_data_peserta_TAK.csv';
                $content = $this->_generate_template_csv();
                file_put_contents($csv_path, $content);
                $file_path = $csv_path;
                $file_name = 'Template_Data_Peserta_TAK.csv';
            }
        } else {
            show_404();
        }

        if (file_exists($file_path)) {
            force_download($file_name, file_get_contents($file_path));
        } else {
            $this->session->set_flashdata('error', 'File template tidak ditemukan');
            redirect('tak');
        }
    }

    /**
     * Generate template surat
     */
    private function _generate_template_surat()
    {
        $content = "===========================================================================\n";
        $content .= "                  SURAT PENGAJUAN TAK KOLEKTIF\n";
        $content .= "===========================================================================\n\n";
        $content .= "Kepada Yth.\n";
        $content .= "Bagian Kemahasiswaan\n";
        $content .= "Fakultas Industri Kreatif\n";
        $content .= "Telkom University\n\n";
        $content .= "Di Tempat\n\n";
        $content .= "Dengan hormat,\n\n";
        $content .= "Yang bertanda tangan di bawah ini:\n\n";
        $content .= "Nama PIC         : [ISI NAMA PIC]\n";
        $content .= "NIM              : [ISI NIM]\n";
        $content .= "Program Studi    : [ISI PRODI]\n";
        $content .= "No. HP           : [ISI NO HP]\n\n";
        $content .= "Bersama ini mengajukan permohonan TAK Kolektif untuk kegiatan:\n\n";
        $content .= "Judul Kegiatan    : [ISI JUDUL KEGIATAN]\n";
        $content .= "Tanggal Kegiatan  : [ISI TANGGAL]\n";
        $content .= "Lokasi Kegiatan   : [ISI LOKASI]\n";
        $content .= "Waktu Kegiatan    : [ISI WAKTU]\n";
        $content .= "Jumlah Peserta    : [ISI JUMLAH PESERTA]\n\n";
        $content .= "Deskripsi Kegiatan:\n";
        $content .= "[ISI DESKRIPSI KEGIATAN]\n\n";
        $content .= "Sebagai bahan pertimbangan, bersama ini kami lampirkan:\n";
        $content .= "1. Daftar peserta (Excel)\n";
        $content .= "2. Link sertifikat peserta (Google Drive)\n";
        $content .= "3. Dokumentasi kegiatan (foto/video)\n";
        $content .= "4. Proposal kegiatan (jika ada)\n\n";
        $content .= "Demikian permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.\n\n";
        $content .= "Hormat kami,\n\n\n\n";
        $content .= "(.............................)\n";
        $content .= "PIC Kegiatan\n\n";
        $content .= "Mengetahui,\n";
        $content .= "Ketua Himpunan/Ketua Pelaksana\n\n\n";
        $content .= "(.............................)\n";
        $content .= "\n===========================================================================\n";
        $content .= "Catatan:\n";
        $content .= "1. Isi semua data yang ditandai dengan [ISI ...]\n";
        $content .= "2. Surat harus ditandatangani oleh PIC dan Ketua Pelaksana\n";
        $content .= "3. Surat harus bermaterai Rp10.000\n";
        $content .= "4. Upload dalam format PDF setelah diisi\n";
        $content .= "===========================================================================\n";
        
        return $content;
    }

    /**
     * Generate template CSV
     */
    private function _generate_template_csv()
    {
        $content = "NIM,Nama Mahasiswa,Email,Program Studi,No HP,Status\n";
        $content .= "12345678,Budi Santoso,budi.santoso@student.telkomuniversity.ac.id,Desain Komunikasi Visual,081234567890,Mahasiswa Aktif\n";
        $content .= "87654321,Ani Wijaya,ani.wijaya@student.telkomuniversity.ac.id,Desain Interior,087654321098,Mahasiswa Aktif\n";
        $content .= "11223344,Citra Dewi,citra.dewi@student.telkomuniversity.ac.id,Desain Produk,081122334455,Mahasiswa Aktif\n";
        $content .= "44332211,Dwi Prasetyo,dwi.prasetyo@student.telkomuniversity.ac.id,Kriya Tekstil & Mode,084433221122,Mahasiswa Aktif\n";
        $content .= "55667788,Eka Putra,eka.putra@student.telkomuniversity.ac.id,Film dan Animasi,085566778899,Mahasiswa Aktif\n";
        $content .= "\n===========================================================================\n";
        $content .= "Catatan:\n";
        $content .= "1. Gunakan template ini untuk mengisi data peserta\n";
        $content .= "2. Jangan mengubah header kolom\n";
        $content .= "3. Isi data sesuai dengan format yang sudah ditentukan\n";
        $content .= "4. Simpan file dalam format .xlsx atau .csv\n";
        $content .= "===========================================================================\n";
        
        return $content;
    }

    /**
     * Fungsi untuk membuat folder upload secara otomatis
     */
    private function _buat_folder_upload()
    {
        $folders = [
            FCPATH . 'uploads/',
            FCPATH . 'uploads/surat_pengajuan/',
            FCPATH . 'uploads/excel_peserta/',
            FCPATH . 'templates/'
        ];

        foreach ($folders as $folder) {
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
                chmod($folder, 0777);
            }
        }
    }

    /**
     * Helper function untuk mengambil data user dari session
     */
    private function _get_user_data()
    {
        $role = $this->session->userdata('role');
        $role_display = '';

        switch ($role) {
            case 'mahasiswa':
                $role_display = 'Mahasiswa';
                break;
            case 'dosen':
            case 'dosen_pembina':
                $role_display = 'Dosen';
                break;
            case 'kemahasiswaan':
                $role_display = 'Staff Kemahasiswaan';
                break;
            case 'kaprodi':
                $role_display = 'Kepala Program Studi';
                break;
            case 'bemdpm':
                $role_display = 'BEM/DPM';
                break;
            case 'admin':
                $role_display = 'Admin';
                break;
            default:
                $role_display = ucfirst($role);
        }
        
        return [
            'user_id' => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'nama' => $this->session->userdata('nama'),
            'nim' => $this->session->userdata('nim'),
            'nidn' => $this->session->userdata('nidn'),
            'role' => $role,
            'prodi' => $this->session->userdata('prodi'),
            'foto' => $this->session->userdata('foto'),
            'role_display' => $role_display,
            'logged_in' => true
        ];
    }

    // ==================== DEBUG FUNCTIONS ====================

    /**
     * Fungsi untuk mengecek konfigurasi upload (DEBUG)
     */
    public function cek_konfigurasi()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }

        echo "<h2>Konfigurasi Upload TAK</h2>";

        echo "<h3>Path Information:</h3>";
        echo "FCPATH: " . FCPATH . "<br>";
        echo "BASEPATH: " . BASEPATH . "<br>";
        echo "APPPATH: " . APPPATH . "<br>";
        echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

        echo "<h3>Folder Upload:</h3>";
        $folders = [
            'uploads/' => FCPATH . 'uploads/',
            'uploads/surat_pengajuan/' => FCPATH . 'uploads/surat_pengajuan/',
            'uploads/excel_peserta/' => FCPATH . 'uploads/excel_peserta/',
            'templates/' => FCPATH . 'templates/'
        ];

        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr style='background:#f97316; color:white;'><th>Folder</th><th>Path</th><th>Exists</th><th>Writable</th><th>Permission</th></tr>";

        foreach ($folders as $name => $path) {
            $exists = is_dir($path) ? '✅' : '❌';
            $writable = is_writable($path) ? '✅' : '❌';
            $perms = is_dir($path) ? substr(sprintf('%o', fileperms($path)), -4) : '-';

            echo "<tr>";
            echo "<td>$name</td>";
            echo "<td>$path</td>";
            echo "<td>$exists</td>";
            echo "<td>$writable</td>";
            echo "<td>$perms</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<h3>Statistik Database:</h3>";
        $total_pengajuan = $this->Tak_model->count_pengajuan_by_user($this->session->userdata('nim'));
        echo "Total pengajuan Anda: <strong>$total_pengajuan</strong><br>";

        echo "<h3>Aksi:</h3>";
        echo "<ul>";
        echo "<li><a href='" . site_url('tak') . "'>Halaman Pengajuan TAK</a></li>";
        echo "<li><a href='" . site_url('tak/riwayat') . "'>Halaman Riwayat</a></li>";
        echo "<li><a href='" . site_url('tak/buat_folder_manual') . "'>Buat Folder Manual</a></li>";
        echo "<li><a href='" . site_url('tak/test_upload') . "'>Test Upload</a></li>";
        echo "</ul>";
    }

    /**
     * Buat folder manual (DEBUG)
     */
    public function buat_folder_manual()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }

        $this->_buat_folder_upload();
        
        echo "<h3>Membuat Folder Upload</h3>";
        echo "<p>FCPATH: " . FCPATH . "</p>";
        echo "<pre>";
        
        $folders = [
            FCPATH . 'uploads/',
            FCPATH . 'uploads/surat_pengajuan/',
            FCPATH . 'uploads/excel_peserta/',
            FCPATH . 'templates/'
        ];

        foreach ($folders as $folder) {
            echo "Folder: " . $folder . "\n";
            
            if (!is_dir($folder)) {
                if (mkdir($folder, 0777, true)) {
                    echo "✅ Berhasil dibuat\n";
                    @chmod($folder, 0777);
                } else {
                    echo "❌ Gagal dibuat\n";
                }
            } else {
                echo "✓ Sudah ada\n";
                @chmod($folder, 0777);
            }
            
            if (is_writable($folder)) {
                echo "  ✓ Bisa ditulisi (writable)\n";
            } else {
                echo "  ❌ TIDAK bisa ditulisi\n";
            }
            
            echo "\n";
        }
        
        echo "</pre>";
        echo "<p><a href='" . site_url('tak/cek_konfigurasi') . "'>Kembali ke Cek Konfigurasi</a></p>";
    }

    /**
     * Test upload (DEBUG)
     */
    public function test_upload()
    {
        if ($this->session->userdata('role') != 'admin') {
            show_404();
        }

        $test_path = FCPATH . 'uploads/';
        $this->_buat_folder_upload();

        echo "<h3>Test Upload dengan Path Absolut</h3>";
        echo "<p>FCPATH: " . FCPATH . "</p>";
        echo "<p>Test path: " . $test_path . "</p>";
        echo "<p>Folder exists: " . (is_dir($test_path) ? '✅ YA' : '❌ TIDAK') . "</p>";
        echo "<p>Folder writable: " . (is_writable($test_path) ? '✅ YA' : '❌ TIDAK') . "</p>";

        // Coba buat file test
        $test_file = $test_path . 'test_' . time() . '.txt';

        echo "<h4>Test Write Permission:</h4>";

        if (file_put_contents($test_file, 'Test write permission at ' . date('Y-m-d H:i:s'))) {
            echo "<p style='color:green'>✅ Berhasil membuat file test: " . basename($test_file) . "</p>";
            
            $content = file_get_contents($test_file);
            echo "<p>Isi file: " . $content . "</p>";
            
            if (unlink($test_file)) {
                echo "<p style='color:green'>✅ File test berhasil dihapus</p>";
            } else {
                echo "<p style='color:orange'>⚠️ Gagal menghapus file test</p>";
            }
        } else {
            echo "<p style='color:red'>❌ Gagal membuat file test</p>";
        }

        echo "<hr>";
        echo "<p><a href='" . site_url('tak/cek_konfigurasi') . "'>Kembali ke Cek Konfigurasi</a></p>";
    }
}
?>