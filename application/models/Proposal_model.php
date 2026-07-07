<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function generate_kode($tipe = 'himpunan') {
        $prefix = ($tipe === 'bemdpm') ? 'BEM' : 'HMP';
        $year   = date('Y');
        $this->db->where('YEAR(created_at)', $year)->where('tipe_proposal', $tipe);
        $count  = $this->db->count_all_results('proposal');
        return $prefix . '-' . $year . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }

    public function get_my_proposals($user_id, $tipe = null) {
        $this->db->select('p.*, u.nama AS nama_pengaju, u.nim, u.program_studi');
        $this->db->from('proposal p');
        $this->db->join('users u', 'u.id = p.dibuat_oleh', 'left');
        $this->db->where('p.dibuat_oleh', $user_id);
        $this->db->where('p.deleted_at IS NULL', NULL, FALSE);
        if ($tipe) $this->db->where('p.tipe_proposal', $tipe);
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_all_proposals($tipe = null, $status = null, $search = null)
{
    $this->db->select('p.*, u.nama AS nama_pengaju, u.nim, u.program_studi');
    $this->db->from('proposal p');
    $this->db->join('users u', 'u.id = p.dibuat_oleh', 'left');
    $this->db->where('p.deleted_at IS NULL', NULL, FALSE);
    
    if ($tipe) {
        $this->db->where('p.tipe_proposal', $tipe);
    }
    
    if ($status) {
        $this->db->where('p.status', $status);
    }
    
    if ($search) {
        $this->db->group_start();
        $this->db->like('p.nama_kegiatan', $search);
        $this->db->or_like('p.nama_ormawa', $search);
        $this->db->or_like('u.nama', $search);
        $this->db->or_like('p.kode_proposal', $search);
        $this->db->group_end();
    }
    
    $this->db->order_by('p.created_at', 'DESC');
    return $this->db->get()->result();
}

    public function get_by_id($id, $owner_id = null)
{
    $this->db->select('p.*, u.nama AS nama_pengaju, u.nim, u.program_studi, u.email AS email_pengaju');
    $this->db->from('proposal p');
    $this->db->join('users u', 'u.id = p.dibuat_oleh', 'left');
    $this->db->where('p.id', $id);
    $this->db->where('p.deleted_at IS NULL', NULL, FALSE);
    
    if ($owner_id) {
        $this->db->where('p.dibuat_oleh', $owner_id);
    }
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return null;
}
    /* ─────────────────────────────────────────────
       CRUD
    ───────────────────────────────────────────── */

    public function create($data, $rab_items = []) {
        $this->db->trans_start();

        $data['kode_proposal'] = $this->generate_kode($data['tipe_proposal'] ?? 'himpunan');
        $data['status']        = 'draft';
        $data['created_at']    = date('Y-m-d H:i:s');
        $data['updated_at']    = date('Y-m-d H:i:s');

        $this->db->insert('proposal', $data);
        $id = $this->db->insert_id();

        if ($id && !empty($rab_items)) {
            $this->_save_rab($id, $rab_items);
        }

        $this->_log($id, null, 'draft', $data['dibuat_oleh'], 'Proposal dibuat');

        $this->db->trans_complete();
        return $this->db->trans_status() ? $id : false;
    }

    public function update($id, $data, $rab_items = []) {
        $this->db->trans_start();

        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id)->update('proposal', $data);

        if (!empty($rab_items)) {
            $this->db->where('proposal_id', $id)->delete('proposal_rab');
            $this->_save_rab($id, $rab_items);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function soft_delete($id, $user_id) {
        // Hanya bisa hapus jika draft atau ditolak
        $this->db->where('id', $id)
                 ->where('dibuat_oleh', $user_id)
                 ->where_in('status', ['draft', 'ditolak']);
        return $this->db->update('proposal', [
            'deleted_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /* ─────────────────────────────────────────────
       WORKFLOW
    ───────────────────────────────────────────── */

    /**
     * Mahasiswa submit proposal → status: submitted
     */
    public function submit($id, $user_id) {
        $proposal = $this->get_by_id($id, $user_id);
        if (!$proposal) return ['ok' => false, 'msg' => 'Proposal tidak ditemukan.'];

        

        $this->db->where('id', $id)->update('proposal', [
            'status'     => 'submitted',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->_log($id, $proposal->status, 'submitted', $user_id, 'Proposal diajukan oleh mahasiswa');
        return ['ok' => true, 'msg' => 'Proposal berhasil dibuat!'];
    }

    /**
     * Admin setujui → status: disetujui
     * Setelah disetujui, mahasiswa baru bisa lihat PDF
     */
    public function approve($id, $admin_id, $catatan = '') {
        $proposal = $this->get_by_id($id);
        if (!$proposal) return ['ok' => false, 'msg' => 'Proposal tidak ditemukan.'];

        if ($proposal->status !== 'submitted') {
            return ['ok' => false, 'msg' => 'Hanya proposal berstatus "Diajukan" yang dapat disetujui.'];
        }

        $this->db->where('id', $id)->update('proposal', [
            'status'          => 'disetujui',
            'catatan_admin'   => $catatan,
            'reviewed_by'     => $admin_id,
            'reviewed_at'     => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        $this->_log($id, 'submitted', 'disetujui', $admin_id, $catatan ?: 'Proposal disetujui oleh admin');
        return ['ok' => true, 'msg' => 'Proposal berhasil disetujui.'];
    }

    /**
     * Admin tolak → status: ditolak
     * Mahasiswa wajib perbaiki lalu submit ulang
     */
    public function reject($id, $admin_id, $catatan) {
        if (empty(trim($catatan))) {
            return ['ok' => false, 'msg' => 'Alasan penolakan wajib diisi.'];
        }

        $proposal = $this->get_by_id($id);
        if (!$proposal) return ['ok' => false, 'msg' => 'Proposal tidak ditemukan.'];

        if ($proposal->status !== 'submitted') {
            return ['ok' => false, 'msg' => 'Hanya proposal berstatus "Diajukan" yang dapat ditolak.'];
        }

        $this->db->where('id', $id)->update('proposal', [
            'status'            => 'ditolak',
            'catatan_admin'     => $catatan,
            'catatan_penolakan' => $catatan,
            'reviewed_by'       => $admin_id,
            'reviewed_at'       => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        // Simpan ke tabel revisi agar mahasiswa tahu apa yang harus diperbaiki
        $this->db->insert('proposal_revisi', [
            'proposal_id'    => $id,
            'catatan_revisi' => $catatan,
            'dibuat_oleh'    => $admin_id,
            'dibuat_at'      => date('Y-m-d H:i:s'),
        ]);

        $this->_log($id, 'submitted', 'ditolak', $admin_id, $catatan);
        return ['ok' => true, 'msg' => 'Proposal ditolak. Mahasiswa akan diberitahu untuk perbaikan.'];
    }

    /* ─────────────────────────────────────────────
       CEK AKSES PDF
       Mahasiswa hanya boleh lihat PDF jika sudah disetujui
    ───────────────────────────────────────────── */

    public function can_view_pdf($proposal, $role) {
        if ($role === 'admin') return true;
        return $proposal->status === 'disetujui';
    }

    /* ─────────────────────────────────────────────
       RAB
    ───────────────────────────────────────────── */

    private function _save_rab($proposal_id, $rab_items) {
        $total  = 0;
        $urutan = 1;
        foreach ($rab_items as $item) {
            if (empty(trim($item['uraian'] ?? ''))) continue;
            $harga  = (float)str_replace(['.', ','], ['', '.'], $item['harga_satuan'] ?? '0');
            $vol    = (float)($item['volume'] ?? 1);
            $jumlah = $vol * $harga;
            $total += $jumlah;
            $this->db->insert('proposal_rab', [
                'proposal_id'  => $proposal_id,
                'urutan'       => $urutan++,
                'uraian'       => $item['uraian'],
                'volume'       => $vol,
                'satuan'       => $item['satuan'] ?? 'Unit',
                'harga_satuan' => $harga,
                'jumlah'       => $jumlah,
                'keterangan'   => $item['keterangan'] ?? '',
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }
        $this->db->where('id', $proposal_id)->update('proposal', ['total_rab' => $total]);
        return $total;
    }

    public function get_rab($proposal_id) {
        return $this->db->where('proposal_id', $proposal_id)
            ->order_by('urutan')->get('proposal_rab')->result();
    }

    /* ─────────────────────────────────────────────
       LOG & REVISI
    ───────────────────────────────────────────── */

    private function _log($proposal_id, $status_lama, $status_baru, $user_id, $catatan = '') {
        $this->db->insert('proposal_log', [
            'proposal_id'    => $proposal_id,
            'status_lama'    => $status_lama,
            'status_baru'    => $status_baru,
            'catatan'        => $catatan,
            'dilakukan_oleh' => $user_id,
            'dilakukan_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function get_log($proposal_id) {
        $this->db->select('pl.*, u.nama AS nama_user, u.role AS role_user');
        $this->db->from('proposal_log pl');
        $this->db->join('users u', 'u.id = pl.dilakukan_oleh', 'left');
        $this->db->where('proposal_id', $proposal_id);
        $this->db->order_by('dilakukan_at', 'ASC');
        return $this->db->get()->result();
    }

    public function get_revisi($proposal_id) {
        $this->db->select('pr.*, u.nama AS nama_reviewer');
        $this->db->from('proposal_revisi pr');
        $this->db->join('users u', 'u.id = pr.dibuat_oleh', 'left');
        $this->db->where('pr.proposal_id', $proposal_id);
        $this->db->order_by('pr.dibuat_at', 'DESC');
        return $this->db->get()->result();
    }

    /* ─────────────────────────────────────────────
       STATISTIK
    ───────────────────────────────────────────── */

    public function count_by_status($user_id = null) {
        $this->db->select('status, COUNT(*) AS jumlah');
        $this->db->from('proposal');
        $this->db->where('deleted_at IS NULL', NULL, FALSE);
        if ($user_id) $this->db->where('dibuat_oleh', $user_id);
        $this->db->group_by('status');
        $rows = $this->db->get()->result();

        $counts = array_fill_keys(['draft','submitted','disetujui','ditolak'], 0);
        foreach ($rows as $r) {
            if (isset($counts[$r->status])) $counts[$r->status] = (int)$r->jumlah;
        }
        return $counts;
    }

    /* ─────────────────────────────────────────────
       SANITIZE
    ───────────────────────────────────────────── */

    public function sanitize($raw) {
        return [
            'tipe_proposal'      => in_array($raw['tipe_proposal'] ?? '', ['himpunan','bemdpm'])
                                        ? $raw['tipe_proposal'] : 'himpunan',
            'nama_kegiatan'      => trim($raw['nama_kegiatan']      ?? ''),
            'nama_ormawa'        => trim($raw['nama_ormawa']        ?? ''),
            'tahun_kegiatan'     => trim($raw['tahun_kegiatan']     ?? ''),
            'tema_kegiatan'      => trim($raw['tema_kegiatan']      ?? ''),
            'jenis_kegiatan'     => trim($raw['jenis_kegiatan']     ?? ''),
            'balai_divisi'       => trim($raw['balai_divisi']       ?? ''),
            'latar_belakang'     => trim($raw['latar_belakang']     ?? ''),
            'tujuan_manfaat'     => trim($raw['tujuan_manfaat']     ?? ''),
            'sasaran_kegiatan'   => trim($raw['sasaran_kegiatan'] ?? ''),
            'peserta'            => (trim($raw['peserta'] ?? '') !== '') ? (int)trim($raw['peserta']) : null,
            'tanggal_kegiatan'   => (trim($raw['tanggal_kegiatan'] ?? '') !== '') ? $raw['tanggal_kegiatan'] : null,
            'waktu_mulai'        => (trim($raw['waktu_mulai'] ?? '') !== '') ? $raw['waktu_mulai'] : null,
            'waktu_selesai'      => (trim($raw['waktu_selesai'] ?? '') !== '') ? $raw['waktu_selesai'] : null,
            'lokasi_kegiatan'    => trim($raw['lokasi_kegiatan']    ?? ''),
            'susunan_acara'      => trim($raw['susunan_acara']      ?? ''),
            'susunan_panitia'    => trim($raw['susunan_panitia']    ?? ''),
            'sumber_dana'        => trim($raw['sumber_dana']        ?? ''),
            'dana_diajukan'      => (float)str_replace(['.', ','], ['', '.'], $raw['dana_diajukan'] ?? '0'),
        ];
    }

    public function save_file($id, $field, $path) {
        $allowed = ['file_ttd_ketua', 'file_lampiran', 'file_pdf_output'];
        if (!in_array($field, $allowed)) return false;
        return $this->db->where('id', $id)->update('proposal', [
            $field       => $path,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}