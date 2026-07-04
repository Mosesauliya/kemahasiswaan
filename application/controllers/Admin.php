<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Proposal_model');
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
}