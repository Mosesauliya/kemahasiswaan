<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Proposal_model');
        $this->load->model('Organisasi_model');
        $this->load->model('Log_model');
        $this->load->model('Login_model');
        $this->load->model('beasiswa_model');
        $this->load->model('Mitra_model');
        $this->load->model('Direktorat_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'file']);
        $this->_cek_admin();
    }

    private function _cek_admin() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $role = $this->session->userdata('role');
        if (!in_array($role, ['kemahasiswaan', 'kaprodi', 'dosen_pembina', 'admin'])) {
            $this->session->set_flashdata('error', 'Akses ditolak.');
            redirect('proposal');
        }
    }

    private function _uid()  { return $this->session->userdata('user_id'); }
    private function _role() { return $this->session->userdata('role'); }
    private function _nama() { return $this->session->userdata('nama'); }

    public function proposal() {
        $tipe = $this->input->get('tipe');
        $status = $this->input->get('status');
        $search = $this->input->get('q');
        
        $proposals = $this->Proposal_model->get_all_proposals($tipe, $status, $search);
        $stat_counts = $this->Proposal_model->count_by_status();
        
        $data = [
            'title' => 'Manajemen Proposal',
            'proposals' => $proposals,
            'stat_counts' => $stat_counts,
            'status_filter' => $status,
            'tipe_filter' => $tipe,
            'search' => $search,
            'pending_count' => $stat_counts['submitted'] ?? 0,
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        
        $this->load->view('admin/proposal', $data);
    }

    /**
     * Get proposal detail for AJAX
     */
    public function get_proposal_detail($id)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        try {
            $proposal = $this->Proposal_model->get_by_id($id);
            
            if (!$proposal) {
                echo json_encode(['status' => 'error', 'message' => 'Proposal tidak ditemukan']);
                return;
            }
            
            // Ambil data tambahan
            $rab = $this->Proposal_model->get_rab($id);
            $log = $this->Proposal_model->get_log($id);
            
            // Konversi ke array
            $proposal_array = (array) $proposal;
            
            echo json_encode([
                'status' => 'success',
                'data' => $proposal_array,
                'rab' => $rab,
                'log' => $log
            ]);
            
        } catch (Exception $e) {
            log_message('error', 'Error in get_proposal_detail: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan server']);
        }
    }

    /* ==================== METHOD YANG SUDAH ADA SEBELUMNYA ==================== */

    public function detail($id) {
        $proposal = $this->Proposal_model->get_by_id($id);
        if (!$proposal) show_404();

        $data = [
            'title'     => 'Detail Proposal – ' . $proposal->nama_kegiatan,
            'proposal'  => $proposal,
            'rab'       => $this->Proposal_model->get_rab($id),
            'log'       => $this->Proposal_model->get_log($id),
            'revisi'    => $this->Proposal_model->get_revisi($id),
            'nama_user' => $this->_nama(),
            'role'      => $this->_role(),
            'is_admin'  => true,
        ];

        $this->load->view('admin/detail_proposal', $data);
    }

    public function get_proposals_json() {
        if (!$this->input->is_ajax_request()) show_404();

        $tipe   = $this->input->get('tipe');
        $status = $this->input->get('status');

        $proposals = $this->Proposal_model->get_all_proposals($tipe, $status);

        $this->_json([
            'status' => 'success',
            'data'   => $proposals,
            'counts' => $this->Proposal_model->count_by_status(),
        ]);
    }

    /* ==================== METHOD APPROVE/REJECT (SATU VERSI) ==================== */
    
    /**
     * Setujui proposal via AJAX
     */
    public function setujui($id) {
        // Handle both AJAX and regular POST
        $catatan = $this->input->post('catatan') ?? '';
        $result  = $this->Proposal_model->approve((int)$id, $this->_uid(), $catatan);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $result['ok'] ? 'success' : 'error',
                'message' => $result['msg']
            ]);
            return;
        }

        $this->session->set_flashdata($result['ok'] ? 'success' : 'error', $result['msg']);
        redirect('admin/proposal');
    }

    /**
     * Tolak proposal via AJAX
     */
    public function tolak($id) {
        $catatan = $this->input->post('catatan') ?? '';

        if (empty(trim($catatan))) {
            if ($this->input->is_ajax_request()) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'error', 'message' => 'Alasan penolakan wajib diisi.']);
                return;
            }
            $this->session->set_flashdata('error', 'Alasan penolakan wajib diisi.');
            redirect('admin/proposal');
        }

        $result = $this->Proposal_model->reject((int)$id, $this->_uid(), $catatan);

        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $result['ok'] ? 'success' : 'error',
                'message' => $result['msg']
            ]);
            return;
        }

        $this->session->set_flashdata($result['ok'] ? 'success' : 'error', $result['msg']);
        redirect('admin/proposal');
    }

    /**
     * Hapus proposal oleh admin
     */
    public function hapus_proposal($id) {
        $this->_cek_admin();
        $id = (int)$id;

        $proposal = $this->Proposal_model->get_by_id($id);
        if ($proposal) {
            // Hapus file fisik/upload jika ada
            if (!empty($proposal->file_proposal) && file_exists(FCPATH . $proposal->file_proposal)) {
                @unlink(FCPATH . $proposal->file_proposal);
            }
            if (!empty($proposal->file_rab) && file_exists(FCPATH . $proposal->file_rab)) {
                @unlink(FCPATH . $proposal->file_rab);
            }
            
            // Hapus log, rab, revisi, dll terkait proposal
            $this->db->where('proposal_id', $id);
            $this->db->delete('proposal_log');

            $this->db->where('proposal_id', $id);
            $this->db->delete('proposal_rab');

            $this->db->where('proposal_id', $id);
            $this->db->delete('proposal_revisi');

            // Hapus dari database
            $this->db->where('id', $id);
            $this->db->delete('proposal');

            $this->session->set_flashdata('success', 'Proposal berhasil dihapus secara permanen.');
        } else {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan.');
        }
        redirect('admin/proposal');
    }

    public function dashboard() {
        $data = [
            'title'       => 'Dashboard Admin',
            'stat_counts' => $this->Proposal_model->count_by_status(),
            'recent'      => $this->Proposal_model->get_all_proposals(null, 'submitted'),
            'nama_user'   => $this->_nama(),
            'role'        => $this->_role(),
        ];
        $this->load->view('admin/dashboard', $data);
    }

    /* ── JSON helper ── */
    private function _json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // ==================== MANAJEMEN ORGANISASI ====================

    /**
     * Halaman daftar organisasi kemahasiswaan
     */
    public function organisasi() {
        $search   = $this->input->get('q');
        $kategori = $this->input->get('kategori');
        $filter   = $this->input->get('aktif');

        $filter_aktif = ($filter === '1') ? 1 : (($filter === '0') ? 0 : null);

        $data = [
            'title'          => 'Manajemen Organisasi Kemahasiswaan',
            'organisasi_list'=> $this->Organisasi_model->get_all($filter_aktif, $kategori, $search),
            'kategori_list'  => $this->Organisasi_model->get_kategori_list(),
            'total'          => $this->Organisasi_model->count_all(),
            'total_aktif'    => $this->Organisasi_model->count_aktif(),
            'search'         => $search,
            'filter_kategori'=> $kategori,
            'filter_aktif'   => $filter,
            'nama_user'      => $this->_nama(),
            'role'           => $this->_role(),
        ];

        $this->load->view('admin/organisasi', $data);
    }

    /**
     * Tambah organisasi baru (GET = form, POST = proses)
     */
    public function organisasi_tambah() {
        if ($this->input->method() === 'post') {
            $nama      = trim($this->input->post('nama'));
            $deskripsi = trim($this->input->post('deskripsi'));
            $icon      = trim($this->input->post('icon'));
            $kategori  = trim($this->input->post('kategori'));
            $urutan    = (int) $this->input->post('urutan');
            $aktif     = $this->input->post('aktif') ? 1 : 0;

            if (empty($nama)) {
                $this->session->set_flashdata('error', 'Nama organisasi wajib diisi.');
                redirect('admin/organisasi_tambah');
                return;
            }

            $logo_path = '';
            if (!empty($_FILES['logo']['name'])) {
                $upload_result = $this->_upload_logo();
                if ($upload_result['status'] === 'error') {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin/organisasi_tambah');
                    return;
                }
                $logo_path = $upload_result['path'];
            }

            $this->Organisasi_model->insert([
                'nama'      => $nama,
                'deskripsi' => $deskripsi,
                'logo'      => $logo_path,
                'icon'      => $icon ?: 'fas fa-star',
                'kategori'  => $kategori ?: 'Umum',
                'urutan'    => $urutan,
                'aktif'     => $aktif,
            ]);

            $this->session->set_flashdata('success', 'Organisasi berhasil ditambahkan.');
            redirect('admin/organisasi');
            return;
        }

        $data = [
            'title'     => 'Tambah Organisasi',
            'nama_user' => $this->_nama(),
            'role'      => $this->_role(),
        ];
        $this->load->view('admin/organisasi_form', $data);
    }

    /**
     * Edit organisasi (GET = form, POST = proses)
     */
    public function organisasi_edit($id) {
        $org = $this->Organisasi_model->get_by_id($id);
        if (!$org) {
            $this->session->set_flashdata('error', 'Organisasi tidak ditemukan.');
            redirect('admin/organisasi');
            return;
        }

        if ($this->input->method() === 'post') {
            $nama      = trim($this->input->post('nama'));
            $deskripsi = trim($this->input->post('deskripsi'));
            $icon      = trim($this->input->post('icon'));
            $kategori  = trim($this->input->post('kategori'));
            $urutan    = (int) $this->input->post('urutan');
            $aktif     = $this->input->post('aktif') ? 1 : 0;

            if (empty($nama)) {
                $this->session->set_flashdata('error', 'Nama organisasi wajib diisi.');
                redirect('admin/organisasi_edit/' . $id);
                return;
            }

            $update_data = [
                'nama'      => $nama,
                'deskripsi' => $deskripsi,
                'icon'      => $icon ?: 'fas fa-star',
                'kategori'  => $kategori ?: 'Umum',
                'urutan'    => $urutan,
                'aktif'     => $aktif,
            ];

            if (!empty($_FILES['logo']['name'])) {
                $upload_result = $this->_upload_logo();
                if ($upload_result['status'] === 'error') {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin/organisasi_edit/' . $id);
                    return;
                }
                $update_data['logo'] = $upload_result['path'];
            }

            $this->Organisasi_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Organisasi berhasil diperbarui.');
            redirect('admin/organisasi');
            return;
        }

        $data = [
            'title'     => 'Edit Organisasi',
            'org'       => $org,
            'nama_user' => $this->_nama(),
            'role'      => $this->_role(),
        ];
        $this->load->view('admin/organisasi_form', $data);
    }

    /**
     * Hapus organisasi
     */
    public function organisasi_hapus($id) {
        $org = $this->Organisasi_model->get_by_id($id);
        if (!$org) {
            $this->session->set_flashdata('error', 'Organisasi tidak ditemukan.');
        } else {
            $this->Organisasi_model->delete($id);
            $this->session->set_flashdata('success', 'Organisasi berhasil dihapus.');
        }

        if ($this->input->is_ajax_request()) {
            $this->_json(['status' => 'success', 'message' => 'Organisasi dihapus.']);
            return;
        }
        redirect('admin/organisasi');
    }

    /**
     * Toggle status aktif
     */
    public function organisasi_toggle($id) {
        $result = $this->Organisasi_model->toggle_aktif($id);
        if ($this->input->is_ajax_request()) {
            $org = $this->Organisasi_model->get_by_id($id);
            $this->_json([
                'status'  => $result ? 'success' : 'error',
                'aktif'   => $org ? (int)$org->aktif : 0,
                'message' => $result ? 'Status diperbarui.' : 'Gagal memperbarui status.'
            ]);
            return;
        }
        redirect('admin/organisasi');
    }

    /**
     * Helper: upload logo ke assets/organisasi/
     */
    private function _upload_logo() {
        $upload_path = FCPATH . 'assets/organisasi/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|svg|webp',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('logo')) {
            return ['status' => 'error', 'message' => $this->upload->display_errors('', '')];
        }

        $file = $this->upload->data();
        return ['status' => 'success', 'path' => 'assets/organisasi/' . $file['file_name']];
    }

    // =========================================================================
    // KONTEN DIREKTORAT
    // =========================================================================
    public function direktorat() {
        $all = $this->Direktorat_model->get_all();
        $item = !empty($all) ? $all[0] : null;

        if ($this->input->method() === 'post') {
            $judul = trim($this->input->post('judul'));
            $isi   = trim($this->input->post('isi'));

            if (empty($judul)) {
                $this->session->set_flashdata('error', 'Judul wajib diisi.');
                redirect('admin/direktorat');
                return;
            }

            $save_data = [
                'judul' => $judul,
                'isi'   => $isi,
                'link'  => trim($this->input->post('link')),
                'aktif' => $this->input->post('aktif') ? 1 : 0,
            ];

            if (!empty($_FILES['gambar']['name'])) {
                $upload_result = $this->_upload_gambar_direktorat();
                if ($upload_result['status'] === 'error') {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin/direktorat');
                    return;
                }
                $save_data['gambar'] = $upload_result['path'];
            }

            if ($item) {
                $this->Direktorat_model->update($item->id, $save_data);
            } else {
                $save_data['created_at'] = date('Y-m-d H:i:s');
                $this->Direktorat_model->insert($save_data);
                $all = $this->Direktorat_model->get_all();
                $item = !empty($all) ? $all[0] : null;
            }

            $this->session->set_flashdata('success', 'Konten Direktorat berhasil disimpan.');
            redirect('admin/direktorat');
            return;
        }

        $data = [
            'title'     => 'Konten Direktorat',
            'item'      => $item,
            'nama_user' => $this->_nama(),
            'role'      => $this->_role(),
        ];
        $this->load->view('admin/direktorat_form', $data);
    }

    private function _upload_gambar_direktorat() {
        $upload_path = FCPATH . 'assets/direktorat/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|svg|webp',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('gambar')) {
            return ['status' => 'error', 'message' => $this->upload->display_errors('', '')];
        }

        $file = $this->upload->data();
        return ['status' => 'success', 'path' => 'assets/direktorat/' . $file['file_name']];
    }

    // =========================================================================
    // HISTORY LOGS & SSO WHITELIST
    // =========================================================================
    public function history_log() {
        $this->db->select('sso_email_whitelist.*, users.nama, users.role, users.username');
        $this->db->from('sso_email_whitelist');
        $this->db->join('users', 'users.email = sso_email_whitelist.email', 'left');
        $this->db->order_by('sso_email_whitelist.created_at', 'DESC');
        $whitelist = $this->db->get()->result();

        $data = [
            'title' => 'History Log & Whitelist Email',
            'logs' => $this->Log_model->get_all_logs(),
            'whitelist' => $whitelist,
            'blocked_devices' => $this->db->where('attempts >=', 5)->where('last_attempt >=', date('Y-m-d H:i:s', strtotime('-24 hours')))->get('login_attempts')->result(),
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        
        $this->load->view('admin/logs', $data);
    }

    public function unblock_device($id) {
        $this->db->delete('login_attempts', ['id' => $id]);
        $this->session->set_flashdata('success', 'Perangkat berhasil di-unblock.');
        redirect('admin/history_log');
    }

    private function _validate_password_complexity($password) {
        // Wajib campur simbol/special characters, angka, huruf besar, huruf kecil, dan minimal 8 karakter
        $has_uppercase = preg_match('@[A-Z]@', $password);
        $has_lowercase = preg_match('@[a-z]@', $password);
        $has_number    = preg_match('@[0-9]@', $password);
        $has_special   = preg_match('@[^a-zA-Z0-9]@', $password); // Any non-alphanumeric character (includes underscore)

        if (!$has_uppercase || !$has_lowercase || !$has_number || !$has_special || strlen($password) < 8) {
            return false;
        }
        return true;
    }

    public function tambah_sso_whitelist() {
        $email = trim($this->input->post('email', TRUE));
        $password = $this->input->post('password');
        $role = $this->input->post('role', TRUE) ?: 'mahasiswa';

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Format email tidak valid.');
            redirect('admin/history_log');
        }

        if (empty($password)) {
            $this->session->set_flashdata('error', 'Password wajib diisi.');
            redirect('admin/history_log');
        }

        // Validate password complexity
        if (!$this->_validate_password_complexity($password)) {
            $this->session->set_flashdata('error', 'Password tidak memenuhi syarat keamanan! Harus minimal 8 karakter dan mengandung kombinasi huruf besar, huruf kecil, angka, serta simbol/spesial karakter.');
            redirect('admin/history_log');
        }

        // Check if email already exists in users table
        $cek_user = $this->db->get_where('users', ['email' => $email])->row();
        if ($cek_user) {
            $this->session->set_flashdata('error', 'Email ini sudah terdaftar sebagai akun user.');
            redirect('admin/history_log');
        }

        // Insert into database
        $this->db->trans_start();
        
        // Clean up orphaned whitelist if exists
        $this->db->delete('sso_email_whitelist', ['email' => $email]);

        // 1. Insert into sso_email_whitelist
        $this->db->insert('sso_email_whitelist', [
            'email' => $email,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Insert into users table
        $username_prefix = explode('@', $email)[0];
        $user_data = [
            'username'   => $username_prefix,
            'nama'       => ucwords(str_replace('.', ' ', $username_prefix)),
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => $role,
            'status'     => 'aktif',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('users', $user_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal membuat akun dan whitelist.');
        } else {
            $this->session->set_flashdata('success', 'Akun dan email whitelist berhasil dibuat! Silakan klik tombol "Kirim Verifikasi" di tabel untuk mengirim email.');
        }
        redirect('admin/history_log');
    }

    public function hapus_sso_whitelist($id) {
        $whitelist = $this->db->get_where('sso_email_whitelist', ['id' => $id])->row();
        if ($whitelist) {
            $email = $whitelist->email;
            
            $this->db->trans_start();
            // Delete from whitelist
            $this->db->delete('sso_email_whitelist', ['id' => $id]);
            // Delete from users table
            $this->db->delete('users', ['email' => $email]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal menghapus akun dan whitelist.');
            } else {
                $this->session->set_flashdata('success', 'Akun dan email whitelist berhasil dihapus.');
            }
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
        }
        redirect('admin/history_log');
    }



    public function import_sso_whitelist() {
        if (!isset($_FILES['file_excel']['name']) || empty($_FILES['file_excel']['name'])) {
            $this->session->set_flashdata('error', 'Silakan pilih file CSV terlebih dahulu.');
            redirect('admin/history_log');
        }

        $file_name = $_FILES['file_excel']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'csv') {
            $this->session->set_flashdata('error', 'Format file tidak didukung. Silakan gunakan format CSV.');
            redirect('admin/history_log');
        }

        $tmp_file = $_FILES['file_excel']['tmp_name'];
        $file_handle = fopen($tmp_file, 'r');
        
        $success_count = 0;
        $error_messages = [];
        $row_num = 1;

        $this->db->trans_start();

        while (($row = fgetcsv($file_handle, 1000, ",")) !== FALSE) {
            // Skip header if it contains 'email' or 'password'
            if ($row_num === 1 && (stripos($row[0] ?? '', 'email') !== FALSE || (isset($row[1]) && stripos($row[1], 'password') !== FALSE))) {
                $row_num++;
                continue;
            }

            $email = isset($row[0]) ? trim($row[0]) : '';
            $password = isset($row[1]) ? trim($row[1]) : '';
            $role = isset($row[2]) ? strtolower(trim($row[2])) : 'mahasiswa';

            if (empty($email) && empty($password)) {
                continue;
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error_messages[] = "Baris {$row_num}: Format email '{$email}' tidak valid.";
                $row_num++;
                continue;
            }

            if (empty($password)) {
                $error_messages[] = "Baris {$row_num} ({$email}): Password kosong.";
                $row_num++;
                continue;
            }

            if (!$this->_validate_password_complexity($password)) {
                $error_messages[] = "Baris {$row_num} ({$email}): Password tidak memenuhi standar keamanan (wajib campur simbol, angka, huruf besar/kecil, min 8 karakter).";
                $row_num++;
                continue;
            }

            // Validate role
            $allowed_roles = ['mahasiswa', 'kemahasiswaan', 'admin', 'dosen_pembina'];
            if (empty($role) || !in_array($role, $allowed_roles)) {
                $role = 'mahasiswa'; // Fallback to mahasiswa
            }

            // Check if exists
            $cek_user = $this->db->get_where('users', ['email' => $email])->row();

            if ($cek_user) {
                $error_messages[] = "Baris {$row_num}: Email '{$email}' sudah terdaftar sebagai akun user.";
                $row_num++;
                continue;
            }

            // Clean up orphaned whitelist entry if any
            $this->db->delete('sso_email_whitelist', ['email' => $email]);

            // Insert into DB
            $this->db->insert('sso_email_whitelist', [
                'email' => $email,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $username_prefix = explode('@', $email)[0];
            $user_data = [
                'username'   => $username_prefix,
                'nama'       => ucwords(str_replace('.', ' ', $username_prefix)),
                'email'      => $email,
                'password'   => password_hash($password, PASSWORD_DEFAULT),
                'role'       => $role,
                'status'     => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('users', $user_data);
            
            $success_count++;
            $row_num++;
        }

        fclose($file_handle);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal memproses file import.');
        } else {
            $msg = "Import selesai. Berhasil membuat {$success_count} akun.";
            if (!empty($error_messages)) {
                $msg .= "<br><strong>Detail Kesalahan:</strong><br>" . implode("<br>", $error_messages);
                $this->session->set_flashdata('error', $msg);
            } else {
                $this->session->set_flashdata('success', $msg);
            }
        }

        redirect('admin/history_log');
    }

    /**
     * Halaman manajemen pendaftaran beasiswa
     */
    public function beasiswa() {
        $status = $this->input->get('status');
        $search = $this->input->get('q');

        $this->db->from('beasiswa_pendaftaran');
        if ($status) {
            $this->db->where('status', $status);
        }
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('asal_sekolah', $search);
            $this->db->group_end();
        }
        $this->db->order_by('tanggal_daftar', 'DESC');
        $pendaftaran = $this->db->get()->result();

        $stat_counts = [];
        $stats = $this->beasiswa_model->get_statistik_per_jenis();
        
        $statuses = ['pending', 'diproses', 'diterima', 'ditolak'];
        foreach ($statuses as $st) {
            $this->db->where('status', $st);
            $stat_counts[$st] = $this->db->count_all_results('beasiswa_pendaftaran');
        }
        
        $data = [
            'title' => 'Manajemen Pendaftaran Beasiswa',
            'pendaftaran' => $pendaftaran,
            'stat_counts' => $stat_counts,
            'status_filter' => $status,
            'search' => $search,
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];

        $this->load->view('admin/beasiswa', $data);
    }

    /**
     * Ambil detail beasiswa via AJAX
     */
    public function get_beasiswa_detail($id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        $pendaftaran = $this->beasiswa_model->get_pendaftaran_by_id($id);
        if (!$pendaftaran) {
            echo json_encode(['status' => 'error', 'message' => 'Pendaftaran tidak ditemukan']);
            return;
        }

        $files = $this->db->get_where('beasiswa_files', ['pendaftaran_id' => $id])->result();

        echo json_encode([
            'status' => 'success',
            'data' => $pendaftaran,
            'files' => $files
        ]);
    }

    /**
     * Setujui beasiswa via AJAX
     */
    public function setujui_beasiswa($id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        $catatan = $this->input->post('catatan') ?? '';
        
        $update_data = [
            'status' => 'diterima',
            'catatan_admin' => $catatan
        ];
        
        $result = $this->beasiswa_model->update_pendaftaran($id, $update_data);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil disetujui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status']);
        }
    }

    /**
     * Tolak beasiswa via AJAX
     */
    public function tolak_beasiswa($id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        header('Content-Type: application/json');
        
        $catatan = $this->input->post('catatan') ?? '';
        if (empty(trim($catatan))) {
            echo json_encode(['status' => 'error', 'message' => 'Alasan penolakan wajib diisi.']);
            return;
        }
        
        $update_data = [
            'status' => 'ditolak',
            'catatan_admin' => $catatan
        ];
        
        $result = $this->beasiswa_model->update_pendaftaran($id, $update_data);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil ditolak']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui status']);
        }
    }

    /**
     * Hapus pendaftaran beasiswa
     */
    public function hapus_beasiswa($id) {
        $this->_cek_admin();
        $id = (int)$id;
        
        $pendaftaran = $this->beasiswa_model->get_pendaftaran_by_id($id);
        if ($pendaftaran) {
            $this->beasiswa_model->delete_pendaftaran($id, true);
            $this->session->set_flashdata('success', 'Pendaftaran beasiswa berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Pendaftaran beasiswa tidak ditemukan.');
        }
        redirect('admin/beasiswa');
    }

   /**
     * Halaman Edit Hero Dashboard Front-End
     */
 public function edit_hero() {
    $json_path = FCPATH . 'assets/hero_setting.json';

    $default_text = [
        'nav_logo' => 'logo-fik.jpeg',

        'hero_title_line1' => 'Sesuaikan Ke',
        'hero_title_line2' => 'kebutuhanmu',

        'card1_title' => 'Complete chapters', 'card1_sub' => 'to earn certificates',
        'card2_title' => 'Forum Alumni',      'card2_sub' => 'Jaringan profesional',
        'card3_title' => 'MyTeLU',            'card3_sub' => 'Dashboard interaktif',
        'card4_title' => 'Beasiswa',          'card4_sub' => 'Peluang bantuan biaya',
        'card5_title' => 'Karier',            'card5_sub' => 'Persiapan dunia kerja',

        'achievement_title'    => 'Mahasiswa Berprestasi',
        'active_students'      => '762918',
        'active_students_desc' => 'Mahasiswa Aktif<br>Berdasarkan MR 2025 ganjil<br>Keadaan Tanggal 30 Oktober 2025',
        'country_count'        => '50',
        'country_label'        => 'Negara',

        'winner1_text' => 'Juara 1 Kategori Ilustrasi Digital dan Juara 3 Kategori Motion Graphic dalam Festival Kreatif Mahasiswa 2025 Cabang Desain Komunikasi Visual, Bandung.',
        'winner2_text' => 'Juara 3 Kategori Fotografi Komersial dan Juara 2 Kategori Desain Konten Media Sosial dalam Creative Student Award 2025 Cabang Desain Komunikasi Visual, Malang.',

        'alumni_count'      => '2156104',
        'alumni_label'      => 'Alumni<br>Berdasarkan MR 2024',
        'telu_daerah'       => '39',
        'telu_daerah_label' => 'TelU Daerah',
        'telu_luar'         => '1',
        'telu_luar_label'   => 'TelU Luar Negeri',
    ];

    // Ambil data lama di awal, supaya bisa dipakai sebagai fallback saat proses upload logo
    $current_text = file_exists($json_path)
        ? array_merge($default_text, json_decode(file_get_contents($json_path), true) ?: [])
        : $default_text;

    if ($this->input->method() === 'post') {

        // ===== Upload gambar hero =====
        if (!empty($_FILES['hero_image']['name'])) {
            $config['upload_path']   = FCPATH . 'assets/';
            $config['allowed_types'] = 'png';
            $config['file_name']     = 'mahasiswa.png';
            $config['overwrite']     = TRUE;
            $config['max_size']      = 5120;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('hero_image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('admin/edit_hero');
                return;
            }
        }

        // ===== Upload logo navbar =====
        $nav_logo_filename = $current_text['nav_logo'];

        if (!empty($_FILES['nav_logo']['name'])) {
            $logo_ext = strtolower(pathinfo($_FILES['nav_logo']['name'], PATHINFO_EXTENSION));

            if (!in_array($logo_ext, ['png', 'jpg', 'jpeg'])) {
                $this->session->set_flashdata('error', 'Logo harus berformat PNG, JPG, atau JPEG.');
                redirect('admin/edit_hero');
                return;
            }

            $new_logo_filename = 'nav-logo.' . $logo_ext;

            $config_logo['upload_path']   = FCPATH . 'assets/';
            $config_logo['allowed_types'] = 'png|jpg|jpeg';
            $config_logo['file_name']     = $new_logo_filename;
            $config_logo['overwrite']     = TRUE;
            $config_logo['max_size']      = 2048;

            $this->upload->initialize($config_logo);

            if (!$this->upload->do_upload('nav_logo')) {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('admin/edit_hero');
                return;
            }

            // Hapus file logo lama kalau ekstensinya berbeda dari yang baru
            $old_logo = $current_text['nav_logo'];
            if ($old_logo !== $new_logo_filename
                && strpos($old_logo, 'nav-logo.') === 0
                && file_exists(FCPATH . 'assets/' . $old_logo)) {
                @unlink(FCPATH . 'assets/' . $old_logo);
            }

            $nav_logo_filename = $new_logo_filename;
        }

        $data_text = [
            'nav_logo' => $nav_logo_filename,

            'hero_title_line1' => $this->input->post('hero_title_line1', TRUE),
            'hero_title_line2' => $this->input->post('hero_title_line2', TRUE),

            'card1_title' => $this->input->post('card1_title', TRUE),
            'card1_sub'   => $this->input->post('card1_sub', TRUE),
            'card2_title' => $this->input->post('card2_title', TRUE),
            'card2_sub'   => $this->input->post('card2_sub', TRUE),
            'card3_title' => $this->input->post('card3_title', TRUE),
            'card3_sub'   => $this->input->post('card3_sub', TRUE),
            'card4_title' => $this->input->post('card4_title', TRUE),
            'card4_sub'   => $this->input->post('card4_sub', TRUE),
            'card5_title' => $this->input->post('card5_title', TRUE),
            'card5_sub'   => $this->input->post('card5_sub', TRUE),

            'achievement_title'    => $this->input->post('achievement_title', TRUE),
            'active_students'      => $this->input->post('active_students', TRUE),
            'active_students_desc' => $this->input->post('active_students_desc', TRUE),
            'country_count'        => $this->input->post('country_count', TRUE),
            'country_label'        => $this->input->post('country_label', TRUE),

            'winner1_text' => $this->input->post('winner1_text', TRUE),
            'winner2_text' => $this->input->post('winner2_text', TRUE),

            'alumni_count'      => $this->input->post('alumni_count', TRUE),
            'alumni_label'      => $this->input->post('alumni_label', TRUE),
            'telu_daerah'       => $this->input->post('telu_daerah', TRUE),
            'telu_daerah_label' => $this->input->post('telu_daerah_label', TRUE),
            'telu_luar'         => $this->input->post('telu_luar', TRUE),
            'telu_luar_label'   => $this->input->post('telu_luar_label', TRUE),
        ];

        $write_status = file_put_contents($json_path, json_encode($data_text));

        if ($write_status === false) {
            $this->session->set_flashdata('error', 'Gagal menyimpan konfigurasi! Pastikan folder "assets/" memiliki izin tulis (writable).');
        } else {
            $this->session->set_flashdata('success', 'Tampilan Hero Dashboard berhasil diperbarui.');
        }

        redirect('admin/edit_hero');
        return;
    }

    $data = [
        'title'        => 'Edit Hero Dashboard',
        'nama_user'    => $this->_nama(),
        'role'         => $this->_role(),
        'current_text' => $current_text
    ];

    $this->load->view('admin/edit_hero', $data);
}
    // =========================================================================
    // CRUD MITRA KERJASAMA & INTERNATIONAL RECOGNITIONS
    // =========================================================================

    public function mitra() {
        $data = [
            'title' => 'Manajemen Mitra & Recognitions',
            'mitra_list' => $this->Mitra_model->get_all_mitra(),
            'recog_list' => $this->Mitra_model->get_all_recog(),
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        $this->load->view('admin/mitra', $data);
    }

    public function mitra_tambah($type = 'mitra') {
        if (!in_array($type, ['mitra', 'recog'])) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            $name = trim($this->input->post('name'));
            $default_icon = trim($this->input->post('default_icon'));
            $urutan = (int)$this->input->post('urutan');
            $aktif = $this->input->post('aktif') ? 1 : 0;

            if (empty($name)) {
                $this->session->set_flashdata('error', 'Nama wajib diisi.');
                redirect('admin/mitra_tambah/' . $type);
                return;
            }

            $logo_path = '';
            if (!empty($_FILES['logo']['name'])) {
                $upload_result = $this->_upload_mitra_logo();
                if ($upload_result['status'] === 'error') {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect('admin/mitra_tambah/' . $type);
                    return;
                }
                $logo_path = $upload_result['path'];
            }

            $insert_data = [
                'name' => $name,
                'logo' => $logo_path,
                'default_icon' => $default_icon ?: ($type == 'mitra' ? 'fas fa-handshake' : 'fas fa-trophy'),
                'urutan' => $urutan,
                'aktif' => $aktif
            ];

            if ($type === 'mitra') {
                $this->Mitra_model->insert_mitra($insert_data);
            } else {
                $this->Mitra_model->insert_recog($insert_data);
            }

            $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
            redirect('admin/mitra');
            return;
        }

        $data = [
            'title' => 'Tambah ' . ($type == 'mitra' ? 'Mitra Kerjasama' : 'International Recognition'),
            'type' => $type,
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        $this->load->view('admin/mitra_form', $data);
    }

    public function mitra_edit($type, $id) {
        if (!in_array($type, ['mitra', 'recog'])) {
            show_404();
        }

        $item = ($type === 'mitra') ? $this->Mitra_model->get_mitra_by_id($id) : $this->Mitra_model->get_recog_by_id($id);
        if (!$item) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan.');
            redirect('admin/mitra');
            return;
        }

        if ($this->input->method() === 'post') {
            $name = trim($this->input->post('name'));
            $default_icon = trim($this->input->post('default_icon'));
            $urutan = (int)$this->input->post('urutan');
            $aktif = $this->input->post('aktif') ? 1 : 0;

            if (empty($name)) {
                $this->session->set_flashdata('error', 'Nama wajib diisi.');
                redirect("admin/mitra_edit/{$type}/{$id}");
                return;
            }

            $update_data = [
                'name' => $name,
                'default_icon' => $default_icon ?: ($type == 'mitra' ? 'fas fa-handshake' : 'fas fa-trophy'),
                'urutan' => $urutan,
                'aktif' => $aktif
            ];

            if (!empty($_FILES['logo']['name'])) {
                $upload_result = $this->_upload_mitra_logo();
                if ($upload_result['status'] === 'error') {
                    $this->session->set_flashdata('error', $upload_result['message']);
                    redirect("admin/mitra_edit/{$type}/{$id}");
                    return;
                }
                $update_data['logo'] = $upload_result['path'];
            }

            if ($type === 'mitra') {
                $this->Mitra_model->update_mitra($id, $update_data);
            } else {
                $this->Mitra_model->update_recog($id, $update_data);
            }

            $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
            redirect('admin/mitra');
            return;
        }

        $data = [
            'title' => 'Edit ' . ($type == 'mitra' ? 'Mitra Kerjasama' : 'International Recognition'),
            'type' => $type,
            'item' => $item,
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        $this->load->view('admin/mitra_form', $data);
    }

    public function mitra_hapus($type, $id) {
        if (!in_array($type, ['mitra', 'recog'])) {
            show_404();
        }

        if ($type === 'mitra') {
            $this->Mitra_model->delete_mitra($id);
        } else {
            $this->Mitra_model->delete_recog($id);
        }

        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('admin/mitra');
    }

    public function mitra_toggle($type, $id) {
        if (!in_array($type, ['mitra', 'recog'])) {
            show_404();
        }

        if ($type === 'mitra') {
            $result = $this->Mitra_model->toggle_mitra($id);
        } else {
            $result = $this->Mitra_model->toggle_recog($id);
        }

        if ($this->input->is_ajax_request()) {
            $item = ($type === 'mitra') ? $this->Mitra_model->get_mitra_by_id($id) : $this->Mitra_model->get_recog_by_id($id);
            $this->_json([
                'status' => $result ? 'success' : 'error',
                'aktif' => $item ? (int)$item->aktif : 0,
                'message' => $result ? 'Status diperbarui.' : 'Gagal memperbarui status.'
            ]);
            return;
        }
        redirect('admin/mitra');
    }

    private function _upload_mitra_logo() {
        $upload_path = FCPATH . 'assets/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|svg|webp',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('logo')) {
            return ['status' => 'error', 'message' => $this->upload->display_errors('', '')];
        }

        $file = $this->upload->data();
        return ['status' => 'success', 'path' => 'assets/' . $file['file_name']];
    }

    // =========================================================================
    // TESTIMONI ALUMNI CRUD
    // =========================================================================

    public function testimoni() {
        $this->_cek_admin();
        $this->load->model('Testimoni_model');
        $data['title'] = 'Kelola Testimoni Alumni';
        
        $data['testimoni_list'] = $this->Testimoni_model->get_all_testimoni();
        $this->load->view('admin/testimoni', $data);
    }

    public function testimoni_edit($id) {
        $this->_cek_admin();
        $this->load->model('Testimoni_model');
        $item = $this->Testimoni_model->get_testimoni_by_id($id);
        if (!$item) {
            $this->session->set_flashdata('error', 'Testimoni tidak ditemukan.');
            redirect('admin/testimoni');
        }
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama', 'Nama', 'required');
            $this->form_validation->set_rules('posisi', 'Posisi', 'required');
            $this->form_validation->set_rules('testimoni', 'Testimoni', 'required');
            
            if ($this->form_validation->run()) {
                $foto_path = $item->foto;
                if (!empty($_FILES['foto']['name'])) {
                    $upload = $this->_upload_testimoni_photo();
                    if ($upload['status'] === 'success') {
                        if ($item->foto && file_exists(FCPATH . $item->foto)) {
                            @unlink(FCPATH . $item->foto);
                        }
                        $foto_path = $upload['path'];
                    } else {
                        $this->session->set_flashdata('error', 'Gagal upload foto: ' . $upload['message']);
                        redirect('admin/testimoni_edit/' . $id);
                    }
                }
                
                $data = [
                    'nama' => $this->input->post('nama'),
                    'posisi' => $this->input->post('posisi'),
                    'testimoni' => $this->input->post('testimoni'),
                    'rating' => (int)$this->input->post('rating'),
                    'foto' => $foto_path,
                    'linkedin' => $this->input->post('linkedin'),
                    'pinterest' => $this->input->post('pinterest'),
                    'urutan' => (int)$this->input->post('urutan'),
                    'aktif' => $this->input->post('aktif') ? 1 : 0
                ];
                
                $this->Testimoni_model->update_testimoni($id, $data);
                $this->session->set_flashdata('success', 'Testimoni alumni berhasil diperbarui.');
                redirect('admin/testimoni');
            }
        }
        
        $data['title'] = 'Edit Testimoni Alumni';
        $data['item'] = $item;
        $this->load->view('admin/testimoni_form', $data);
    }

    public function testimoni_hapus($id) {
        $this->_cek_admin();
        $this->load->model('Testimoni_model');
        $item = $this->Testimoni_model->get_testimoni_by_id($id);
        if ($item) {
            if ($item->foto && file_exists(FCPATH . $item->foto)) {
                @unlink(FCPATH . $item->foto);
            }
            $this->Testimoni_model->delete_testimoni($id);
            $this->session->set_flashdata('success', 'Testimoni alumni berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Testimoni tidak ditemukan.');
        }
        redirect('admin/testimoni');
    }

    public function testimoni_toggle($id) {
        $this->_cek_admin();
        $this->load->model('Testimoni_model');
        $result = $this->Testimoni_model->toggle_testimoni($id);
        
        if ($this->input->is_ajax_request()) {
            $item = $this->Testimoni_model->get_testimoni_by_id($id);
            $this->_json([
                'status' => $result ? 'success' : 'error',
                'aktif' => $item ? (int)$item->aktif : 0,
                'message' => $result ? 'Status kelayakan tampil diperbarui.' : 'Gagal memperbarui status.'
            ]);
            return;
        }
        redirect('admin/testimoni');
    }

    private function _upload_testimoni_photo() {
        $upload_path = FCPATH . 'assets/testimoni/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|gif|svg|webp',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('foto')) {
            return ['status' => 'error', 'message' => $this->upload->display_errors('', '')];
        }

        $file = $this->upload->data();
        return ['status' => 'success', 'path' => 'assets/testimoni/' . $file['file_name']];
    }

        public function tentang_kami() {
        $this->load->model('Profil_model');

        if ($this->input->method() === 'post') {
            $data = [
                'judul' => $this->input->post('judul'),
                'isi'   => $this->input->post('isi')
            ];

            if ($this->Profil_model->update_tentang_kami($data)) {
                $this->session->set_flashdata('success', 'Halaman Tentang Kami berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('success', 'Tidak ada perubahan yang disimpan.');
            }
            redirect('admin/tentang_kami');
        }

        $data = [
            'title'     => 'Edit Tentang Kami',
            'item'      => $this->Profil_model->get_tentang_kami(),
            'nama_user' => $this->_nama(),
            'role'      => $this->_role(),
        ];

        $this->load->view('admin/tentang_kami_form', $data);
    }

    public function forum_alumni() {
        $json_path = FCPATH . 'assets/ikatan_alumni_setting.json';
        $default_ikatan_alumni = [
            'nama_organisasi' => 'Ikatan Alumni Fakultas Industri Kreatif',
            'singkatan'       => 'IKA FIK Telkom University',
            'logo'            => 'logo-fik.jpeg',
            'nama_ketua'      => 'Ahmad Rizky Pratama, S.Des.',
            'jabatan_ketua'   => 'Ketua Ikatan Alumni FIK',
            'periode_ketua'   => '2024 - 2028',
            'foto_ketua'      => '',
            'sambutan_ketua'  => 'Wadah silaturahmi, sinergi, dan kolaborasi bagi seluruh alumni Fakultas Industri Kreatif Telkom University untuk terus berkarya, berinovasi, dan berdampak bagi masyarakat.'
        ];
        $ikatan_alumni = file_exists($json_path) ? array_merge($default_ikatan_alumni, json_decode(file_get_contents($json_path), true) ?: []) : $default_ikatan_alumni;

        $this->db->select('p.*, u.nama, u.username, u.role');
        $this->db->from('forum_alumni_posts p');
        $this->db->join('users u', 'u.id = p.user_id');
        $this->db->order_by('p.created_at', 'DESC');
        $posts = $this->db->get()->result_array();

        $data = [
            'title'         => 'Ikatan Alumni & Moderasi Forum',
            'posts'         => $posts,
            'ikatan_alumni' => $ikatan_alumni,
            'nama_user'     => $this->_nama(),
            'role'          => $this->_role(),
        ];

        $this->load->view('admin/forum_alumni', $data);
    }

    public function edit_ikatan_alumni() {
        $json_path = FCPATH . 'assets/ikatan_alumni_setting.json';
        $default_data = [
            'nama_organisasi' => 'Ikatan Alumni Fakultas Industri Kreatif',
            'singkatan'       => 'IKA FIK Telkom University',
            'logo'            => 'logo-fik.jpeg',
            'nama_ketua'      => 'Ahmad Rizky Pratama, S.Des.',
            'jabatan_ketua'   => 'Ketua Ikatan Alumni FIK',
            'periode_ketua'   => '2024 - 2028',
            'foto_ketua'      => '',
            'sambutan_ketua'  => 'Wadah silaturahmi, sinergi, dan kolaborasi bagi seluruh alumni Fakultas Industri Kreatif Telkom University untuk terus berkarya, berinovasi, dan berdampak bagi masyarakat.'
        ];

        $current_data = file_exists($json_path)
            ? array_merge($default_data, json_decode(file_get_contents($json_path), true) ?: [])
            : $default_data;

        if ($this->input->method() === 'post') {
            $logo_file = $current_data['logo'];
            $foto_ketua_file = $current_data['foto_ketua'];

            // Upload logo
            if (!empty($_FILES['logo']['name'])) {
                $upload_path = FCPATH . 'uploads/alumni/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $config = [
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|webp|svg',
                    'file_name'     => 'logo_alumni_' . time(),
                    'overwrite'     => TRUE,
                    'max_size'      => 5120
                ];
                $this->upload->initialize($config);
                if ($this->upload->do_upload('logo')) {
                    $logo_file = 'uploads/alumni/' . $this->upload->data('file_name');
                }
            }

            // Upload foto ketua
            if (!empty($_FILES['foto_ketua']['name'])) {
                $upload_path = FCPATH . 'uploads/alumni/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }
                $config_foto = [
                    'upload_path'   => $upload_path,
                    'allowed_types' => 'jpg|jpeg|png|webp',
                    'file_name'     => 'ketua_alumni_' . time(),
                    'overwrite'     => TRUE,
                    'max_size'      => 5120
                ];
                $this->upload->initialize($config_foto);
                if ($this->upload->do_upload('foto_ketua')) {
                    $foto_ketua_file = 'uploads/alumni/' . $this->upload->data('file_name');
                }
            }

            $update_data = [
                'nama_organisasi' => $this->input->post('nama_organisasi', TRUE) ?: $current_data['nama_organisasi'],
                'singkatan'       => $this->input->post('singkatan', TRUE) ?: $current_data['singkatan'],
                'logo'            => $logo_file,
                'nama_ketua'      => $this->input->post('nama_ketua', TRUE) ?: $current_data['nama_ketua'],
                'jabatan_ketua'   => $this->input->post('jabatan_ketua', TRUE) ?: $current_data['jabatan_ketua'],
                'periode_ketua'   => $this->input->post('periode_ketua', TRUE) ?: $current_data['periode_ketua'],
                'foto_ketua'      => $foto_ketua_file,
                'sambutan_ketua'  => $this->input->post('sambutan_ketua', TRUE) ?: $current_data['sambutan_ketua'],
            ];

            file_put_contents($json_path, json_encode($update_data, JSON_PRETTY_PRINT));
            $this->session->set_flashdata('success', 'Informasi & Profil Ikatan Alumni berhasil diperbarui!');
            redirect('admin/forum_alumni');
        }
    }

    public function approve_forum_post($id) {
        $this->db->where('id', $id);
        $this->db->update('forum_alumni_posts', [
            'status' => 'approved',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->session->set_flashdata('success', 'Postingan forum berhasil disetujui!');
        redirect('admin/forum_alumni');
    }

    public function reject_forum_post($id) {
        $this->db->where('id', $id);
        $this->db->update('forum_alumni_posts', [
            'status' => 'rejected',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        $this->session->set_flashdata('success', 'Postingan forum berhasil ditolak!');
        redirect('admin/forum_alumni');
    }

    public function get_forum_comments($post_id) {
        $this->db->select('c.*, u.nama, u.username, u.role');
        $this->db->from('forum_alumni_comments c');
        $this->db->join('users u', 'u.id = c.user_id');
        $this->db->where('c.post_id', $post_id);
        $this->db->order_by('c.created_at', 'ASC');
        $comments = $this->db->get()->result_array();
        
        header('Content-Type: application/json');
        echo json_encode($comments);
        exit;
    }

    public function delete_forum_comment($id) {
        $this->db->where('id', $id);
        $comment = $this->db->get('forum_alumni_comments')->row();
        
        if ($comment) {
            $this->db->where('id', $id);
            $this->db->delete('forum_alumni_comments');
            
            // Decrement comments count
            $this->db->set('comments_count', 'comments_count-1', FALSE);
            $this->db->where('id', $comment->post_id);
            $this->db->update('forum_alumni_posts');
            
            $this->session->set_flashdata('success', 'Komentar berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Komentar tidak ditemukan.');
        }
        redirect('admin/forum_alumni');
    }

    public function delete_forum_post($id) {
        // Fetch files associated with the post to delete them from folder
        $this->db->where('id', $id);
        $post = $this->db->get('forum_alumni_posts')->row();
        
        if ($post) {
            // Delete post image if exists
            if ($post->image && file_exists('./uploads/forum_posts/' . $post->image)) {
                @unlink('./uploads/forum_posts/' . $post->image);
            }
            // Delete post video if exists
            if ($post->video && file_exists('./uploads/forum_posts/' . $post->video)) {
                @unlink('./uploads/forum_posts/' . $post->video);
            }
            
            // Delete comments associated with the post
            $this->db->where('post_id', $id);
            $this->db->delete('forum_alumni_comments');
            
            // Delete likes associated with the post
            $this->db->where('post_id', $id);
            $this->db->delete('forum_alumni_likes');
            
            // Delete the post
            $this->db->where('id', $id);
            $this->db->delete('forum_alumni_posts');
            
            $this->session->set_flashdata('success', 'Postingan forum beserta semua komentar dan berkas lampirannya berhasil dihapus secara permanen!');
        } else {
            $this->session->set_flashdata('error', 'Postingan tidak ditemukan.');
        }
        redirect('admin/forum_alumni');
    }

}