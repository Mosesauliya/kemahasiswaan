<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proposal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Proposal_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'file']);
        $this->_cek_login();
    }

    private function _cek_login()
    {
        if (!$this->session->userdata('logged_in')) redirect('login');
    }

    private function _uid()
    {
        return $this->session->userdata('user_id');
    }
    private function _role()
    {
        return $this->session->userdata('role');
    }
    private function _nama()
    {
        return $this->session->userdata('nama');
    }
    private function _is_admin()
    {
        return in_array($this->_role(), ['admin', 'kemahasiswaan', 'kaprodi', 'dosen_pembina']);
    }

    public function index()
    {
        $tipe   = $this->input->get('tipe');
        $status = $this->input->get('status');

        $proposals = $this->_is_admin()
            ? $this->Proposal_model->get_all_proposals($tipe, $status)
            : $this->Proposal_model->get_my_proposals($this->_uid(), $tipe);

        $data = [
            'title'         => 'Pengajuan Proposal – Kemahasiswaan FIK',
            'proposals'     => $proposals,
            'tipe_aktif'    => $tipe ?? 'himpunan',
            'status_filter' => $status,
            'stat_counts'   => $this->Proposal_model->count_by_status($this->_is_admin() ? null : $this->_uid()),
            'role'          => $this->_role(),
            'nama_user'     => $this->_nama(),
            'is_admin'      => $this->_is_admin(),
            'user_data' => [
                'logged_in' => true,
                'user_id'   => $this->_uid(),
                'nama'      => $this->_nama(),
                'role'      => $this->_role(),
                'foto'      => $this->session->userdata('foto'),
            ],
        ];

        $this->load->view('proposal/index', $data);
    }

    /* ==================== FORM BUAT PROPOSAL ==================== */
    public function buat()
    {
        if ($this->_is_admin()) {
            $this->session->set_flashdata('error', 'Admin tidak dapat membuat proposal.');
            redirect('proposal');
        }

        $data = [
            'title'     => 'Buat Proposal Baru',
            'tipe'      => $this->input->get('tipe') ?? 'himpunan',
            'proposal'  => null,
            'rab_items' => [],
            'revisi'    => [],
            'is_edit'   => false,
            'role'      => $this->_role(),
            'nama_user' => $this->_nama(),
        ];
        $this->load->view('proposal/form', $data);
    }

    /* ==================== FORM EDIT PROPOSAL ==================== */
    public function edit($id)
    {
        if ($this->_is_admin()) {
            $this->session->set_flashdata('error', 'Admin tidak dapat mengedit proposal.');
            redirect('proposal');
        }

        $proposal = $this->Proposal_model->get_by_id($id, $this->_uid());

        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan.');
            redirect('proposal');
        }

        // Hanya draft atau ditolak yang bisa diedit
        if (!in_array($proposal->status, ['draft', 'ditolak'])) {
            $this->session->set_flashdata('error', 'Proposal yang sedang diproses tidak dapat diedit.');
            redirect('proposal');
        }

        $data = [
            'title'     => 'Edit Proposal – ' . $proposal->nama_kegiatan,
            'proposal'  => $proposal,
            'rab_items' => $this->Proposal_model->get_rab($id),
            'revisi'    => $this->Proposal_model->get_revisi($id),
            'is_edit'   => true,
            'role'      => $this->_role(),
            'nama_user' => $this->_nama(),
        ];
        $this->load->view('proposal/form', $data);
    }

    /* ==================== SIMPAN DRAFT (AJAX) ==================== */
    public function simpan_draft()
    {
        if (!$this->input->is_ajax_request()) show_404();
        if ($this->_is_admin()) {
            return $this->_json(['status' => 'error', 'message' => 'Admin tidak dapat menyimpan proposal.']);
        }

        $raw  = json_decode($this->input->raw_input_stream, true) ?? [];
        $data = $this->Proposal_model->sanitize($raw);
        $data['dibuat_oleh'] = $this->_uid();

        $rab = $raw['rab_items']   ?? [];
        $eid = (int)($raw['proposal_id'] ?? 0);

        if ($eid) {
            $existing = $this->Proposal_model->get_by_id($eid, $this->_uid());
            if (!$existing) {
                return $this->_json(['status' => 'error', 'message' => 'Proposal tidak ditemukan.']);
            }
            if (!in_array($existing->status, ['draft', 'ditolak'])) {
                return $this->_json(['status' => 'error', 'message' => 'Proposal tidak dapat diubah.']);
            }
            $ok  = $this->Proposal_model->update($eid, $data, $rab);
            $pid = $eid;
        } else {
            $pid = $this->Proposal_model->create($data, $rab);
            $ok  = (bool)$pid;
        }

        return $this->_json(
            $ok
                ? ['status' => 'success', 'message' => 'Draft berhasil disimpan.', 'proposal_id' => $pid]
                : ['status' => 'error', 'message' => 'Gagal menyimpan draft.']
        );
    }

    /* ==================== SUBMIT PROPOSAL (AJAX) ==================== */
    public function submit()
    {
        if (!$this->input->is_ajax_request()) show_404();
        if ($this->_is_admin()) {
            return $this->_json(['status' => 'error', 'message' => 'Admin tidak dapat mengajukan proposal.']);
        }

        $raw  = json_decode($this->input->raw_input_stream, true) ?? [];
        $data = $this->Proposal_model->sanitize($raw);
        $data['dibuat_oleh'] = $this->_uid();

        $rab = $raw['rab_items']   ?? [];
        $eid = (int)($raw['proposal_id'] ?? 0);

        // Validasi field wajib
        $wajib = [
            'nama_kegiatan'  => 'Nama Kegiatan',
            'nama_ormawa'    => 'Nama Ormawa',
            'latar_belakang' => 'Latar Belakang',
            'tujuan_manfaat' => 'Tujuan & Manfaat',
            'tanggal_kegiatan' => 'Tanggal Kegiatan',
            'lokasi_kegiatan'  => 'Lokasi',
            'susunan_panitia'  => 'Susunan Panitia',
        ];
        foreach ($wajib as $field => $label) {
            if (empty($data[$field])) {
                return $this->_json(['status' => 'error', 'message' => "Field wajib belum diisi: {$label}"]);
            }
        }

        // Simpan/update dulu
        if ($eid) {
            $existing = $this->Proposal_model->get_by_id($eid, $this->_uid());
            if (!$existing) {
                return $this->_json(['status' => 'error', 'message' => 'Proposal tidak ditemukan.']);
            }
            $this->Proposal_model->update($eid, $data, $rab);
            $pid = $eid;
        } else {
            $pid = $this->Proposal_model->create($data, $rab);
            if (!$pid) {
                return $this->_json(['status' => 'error', 'message' => 'Gagal menyimpan proposal.']);
            }
        }

        // Submit
        $result = $this->Proposal_model->submit($pid, $this->_uid());

        return $this->_json(
            $result['ok']
                ? ['status' => 'success', 'message' => $result['msg'], 'proposal_id' => $pid, 'redirect' => site_url('proposal')]
                : ['status' => 'error', 'message' => $result['msg']]
        );
    }

    /* ==================== HAPUS PROPOSAL ==================== */
    public function hapus($id)
    {
        if ($this->_is_admin()) {
            return $this->_json(['status' => 'error', 'message' => 'Admin tidak dapat menghapus proposal.']);
        }

        $ok = $this->Proposal_model->soft_delete($id, $this->_uid());

        if ($this->input->is_ajax_request()) {
            return $this->_json(
                $ok
                    ? ['status' => 'success', 'message' => 'Proposal berhasil dihapus.']
                    : ['status' => 'error', 'message' => 'Gagal hapus. Hanya proposal Draft atau Ditolak yang dapat dihapus.']
            );
        }

        $this->session->set_flashdata(
            $ok ? 'success' : 'error',
            $ok ? 'Proposal berhasil dihapus.' : 'Gagal menghapus proposal.'
        );
        redirect('proposal');
    }

    /* ==================== DETAIL PROPOSAL ==================== */
    public function detail($id)
    {
        $proposal = $this->_is_admin()
            ? $this->Proposal_model->get_by_id($id)
            : $this->Proposal_model->get_by_id($id, $this->_uid());

        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal tidak ditemukan.');
            redirect('proposal');
        }

        $data = [
            'title'       => 'Detail Proposal – ' . $proposal->nama_kegiatan,
            'proposal'    => $proposal,
            'rab'         => $this->Proposal_model->get_rab($id),
            'log'         => $this->Proposal_model->get_log($id),
            'revisi'      => $this->Proposal_model->get_revisi($id),
            'is_admin'    => $this->_is_admin(),
            'role'        => $this->_role(),
            'nama_user'   => $this->_nama(),
            'can_pdf'     => $this->Proposal_model->can_view_pdf($proposal, $this->_role()),
        ];

        $this->load->view('proposal/detail', $data);
    }

    /* ==================== ADMIN: SETUJUI PROPOSAL ==================== */
    public function setujui($id)
    {
        if (!$this->_is_admin()) {
            return $this->_json(['status' => 'error', 'message' => 'Akses ditolak.']);
        }

        $catatan = $this->input->post('catatan') ?? '';
        $result  = $this->Proposal_model->approve($id, $this->_uid(), $catatan);

        return $this->_json(
            $result['ok']
                ? ['status' => 'success', 'message' => $result['msg']]
                : ['status' => 'error', 'message' => $result['msg']]
        );
    }

    /* ==================== ADMIN: TOLAK PROPOSAL ==================== */
    public function tolak($id)
    {
        if (!$this->_is_admin()) {
            return $this->_json(['status' => 'error', 'message' => 'Akses ditolak.']);
        }

        $catatan = $this->input->post('catatan') ?? '';
        $result  = $this->Proposal_model->reject($id, $this->_uid(), $catatan);

        return $this->_json(
            $result['ok']
                ? ['status' => 'success', 'message' => $result['msg']]
                : ['status' => 'error', 'message' => $result['msg']]
        );
    }

    public function pdf($id)
    {
        $proposal = $this->_is_admin()
            ? $this->Proposal_model->get_by_id($id)
            : $this->Proposal_model->get_by_id($id, $this->_uid());

        if (!$proposal) show_404();

        // Cek akses PDF
        if (!$this->Proposal_model->can_view_pdf($proposal, $this->_role())) {
            $this->session->set_flashdata('error', 'PDF hanya tersedia setelah proposal disetujui.');
            redirect('proposal/detail/' . $id);
        }

        $data = [
            'proposal' => $proposal,
            'rab'      => $this->Proposal_model->get_rab($id),
        ];

        // Render HTML template jadi string
        $html = $this->load->view('proposal/pdf_template', $data, TRUE);

        // Generate PDF dengan Dompdf
        $this->_generate_pdf($html, 'Proposal_' . $proposal->kode_proposal, 'inline');
    }

    /* ==================== DOWNLOAD PDF ==================== */
    public function download_pdf($id)
    {
        $proposal = $this->_is_admin()
            ? $this->Proposal_model->get_by_id($id)
            : $this->Proposal_model->get_by_id($id, $this->_uid());

        if (!$proposal) show_404();

        // Cek akses PDF
        if (!$this->Proposal_model->can_view_pdf($proposal, $this->_role())) {
            $this->session->set_flashdata('error', 'PDF hanya tersedia setelah proposal disetujui.');
            redirect('proposal/detail/' . $id);
        }

        $data = [
            'proposal' => $proposal,
            'rab'      => $this->Proposal_model->get_rab($id),
        ];

        // Render HTML template jadi string
        $html = $this->load->view('proposal/pdf_template', $data, TRUE);

        // Nama file download
        $filename = 'Proposal_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $proposal->nama_kegiatan)
            . '_' . date('Ymd');

        // Generate PDF & force download
        $this->_generate_pdf($html, $filename, 'download');
    }

    /* ==================== HELPER: Generate PDF dengan Dompdf ==================== */
    private function _generate_pdf($html, $filename, $mode = 'inline')
    {
        // Load Dompdf via Composer
        require_once APPPATH . '../vendor/autoload.php';

        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);       // Izinkan load gambar dari URL
        $options->set('chroot', FCPATH);              // Izinkan akses file lokal (assets)
        $options->set('isPhpEnabled', false);

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Simpan ke file agar bisa diakses ulang (opsional)
        $output_dir = FCPATH . 'uploads/proposal_pdf/';
        if (!is_dir($output_dir)) mkdir($output_dir, 0755, true);

        file_put_contents($output_dir . $filename . '.pdf', $dompdf->output());

        // Stream ke browser
        if ($mode === 'download') {
            $dompdf->stream($filename . '.pdf', ['Attachment' => true]);
        } else {
            $dompdf->stream($filename . '.pdf', ['Attachment' => false]);
        }
        exit;
    }

    /* ==================== UPLOAD FILE ==================== */
    public function upload_file()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $pid   = (int)$this->input->post('proposal_id');
        $field = $this->input->post('field');

        if (!in_array($field, ['file_ttd_ketua', 'file_lampiran', 'file_sertifikat'])) {
            return $this->_json(['status' => 'error', 'message' => 'Field tidak valid.']);
        }

        $path = FCPATH . 'uploads/proposal/' . $pid . '/';
        if (!is_dir($path)) mkdir($path, 0755, true);

        $config = [
            'upload_path'   => $path,
            'allowed_types' => ($field === 'file_ttd_ketua' || $field === 'file_sertifikat') ? 'jpg|jpeg|png' : 'pdf|doc|docx|jpg|jpeg|png',
            'max_size'      => 5120,
            'encrypt_name'  => true,
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            return $this->_json(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
        }

        $info = $this->upload->data();
        $rel  = 'uploads/proposal/' . $pid . '/' . $info['file_name'];
        $this->Proposal_model->save_file($pid, $field, $rel);

        return $this->_json([
            'status'   => 'success',
            'file_url' => base_url($rel),
            'file_name' => $info['file_name']
        ]);
    }

    public function get_data_json()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $tipe_raw = $this->input->get('tipe'); // 'ormawa' atau 'kompetisi'

        // Konversi ke nilai DB
        $tipe_map = [
            'ormawa'    => 'himpunan',
            'kompetisi' => 'bemdpm',
        ];
        $tipe   = $tipe_map[$tipe_raw] ?? null;
        $status = $this->input->get('status');

        $proposals = $this->_is_admin()
            ? $this->Proposal_model->get_all_proposals($tipe, $status)
            : $this->Proposal_model->get_my_proposals($this->_uid(), $tipe);

        // Attach RAB items to each proposal
        foreach ($proposals as &$p) {
            $p->rab_items = $this->Proposal_model->get_rab($p->id);
        }
        unset($p);

        return $this->_json([
            'status'   => 'success',
            'data'     => $proposals,
            'counts'   => $this->Proposal_model->count_by_status(
                $this->_is_admin() ? null : $this->_uid()
            ),
            'is_admin' => $this->_is_admin(),
        ]);
    }

    /* ==================== HELPER JSON ==================== */
    private function _json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
