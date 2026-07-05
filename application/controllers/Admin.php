<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Proposal_model');
        $this->load->model('Organisasi_model');
        $this->load->model('Log_model');
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
            'max_size'      => 2048, // 2MB
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
    // HISTORY LOGS & SSO WHITELIST
    // =========================================================================
    public function history_log() {
        // Ambil data whitelist email
        $this->db->order_by('created_at', 'DESC');
        $whitelist = $this->db->get('sso_email_whitelist')->result();

        $data = [
            'title' => 'History Log & Whitelist Email',
            'logs' => $this->Log_model->get_all_logs(),
            'whitelist' => $whitelist,
            'nama_user' => $this->_nama(),
            'role' => $this->_role()
        ];
        
        $this->load->view('admin/logs', $data);
    }

    public function tambah_sso_whitelist() {
        $email = trim($this->input->post('email', TRUE));

        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $cek = $this->db->get_where('sso_email_whitelist', ['email' => $email])->row();
            if ($cek) {
                $this->session->set_flashdata('error', 'Email ini sudah ada dalam whitelist.');
            } else {
                $this->db->insert('sso_email_whitelist', ['email' => $email]);
                $this->session->set_flashdata('success', 'Email berhasil ditambahkan ke whitelist.');
            }
        } else {
            $this->session->set_flashdata('error', 'Format email tidak valid.');
        }
        redirect('admin/history_log');
    }

    public function hapus_sso_whitelist($id) {
        $this->db->delete('sso_email_whitelist', ['id' => $id]);
        $this->session->set_flashdata('success', 'Email berhasil dihapus dari whitelist.');
        redirect('admin/history_log');
    }
}