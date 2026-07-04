<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tak_admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // ==================== STATISTIK MAHASISWA & DOSEN ====================
    
    public function count_all_mahasiswa() {
        return $this->db->count_all('mahasiswa');
    }

    public function count_all_dosen() {
        return $this->db->count_all('dosen');
    }

    // ==================== STATISTIK TAK ====================
    
    public function count_all_pengajuan() {
        return $this->db->count_all('pengajuan_tak');
    }

    public function count_pengajuan_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('pengajuan_tak');
    }

    public function get_statistik_bulanan() {
        $this->db->select("
            DATE_FORMAT(created_at, '%Y-%m') as bulan,
            COUNT(*) as total,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as diproses,
            SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
            SUM(CASE WHEN status = 'ditolak' THEN 1 ELSE 0 END) as ditolak
        ");
        $this->db->group_by('DATE_FORMAT(created_at, "%Y-%m")');
        $this->db->order_by('bulan', 'DESC');
        $this->db->limit(12);
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    public function get_pengajuan_terbaru($limit = 5) {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.program_studi');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    // ==================== DATA PENGAJUAN ====================

    public function get_all_pengajuan() {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.program_studi');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    public function get_pengajuan_by_status($status) {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.program_studi');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->where('pengajuan_tak.status', $status);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    public function get_pengajuan_detail($id) {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.program_studi, mahasiswa.email');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->where('pengajuan_tak.id', $id);
        $query = $this->db->get('pengajuan_tak');
        return $query->row();
    }

    public function update_pengajuan($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('pengajuan_tak', $data);
    }

    public function delete_pengajuan($id) {
        $this->db->where('id', $id);
        return $this->db->delete('pengajuan_tak');
    }

    public function get_last_no_tak($tahun) {
        $this->db->like('no_tak', 'TAK/FIK/' . $tahun, 'after');
        $this->db->order_by('no_tak', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('pengajuan_tak');
        return $query->row();
    }

    public function get_pengajuan_for_export($status = 'all') {
        $this->db->select('
            pengajuan_tak.id,
            pengajuan_tak.nim,
            mahasiswa.nama as nama_mahasiswa,
            mahasiswa.program_studi,
            pengajuan_tak.nama_pic,
            pengajuan_tak.judul_kegiatan,
            pengajuan_tak.tanggal_kegiatan,
            pengajuan_tak.lokasi,
            pengajuan_tak.status,
            pengajuan_tak.no_tak,
            pengajuan_tak.created_at,
            pengajuan_tak.updated_at
        ');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        
        if ($status != 'all') {
            $this->db->where('pengajuan_tak.status', $status);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    // ==================== HISTORI ====================

    public function insert_histori($data) {
        return $this->db->insert('pengajuan_tak_histori', $data);
    }

    public function get_histori_pengajuan($pengajuan_id) {
        $this->db->where('pengajuan_id', $pengajuan_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak_histori');
        return $query->result();
    }

    // ==================== SEARCH & FILTER ====================

    public function search_pengajuan($keyword) {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->group_start();
        $this->db->like('pengajuan_tak.judul_kegiatan', $keyword);
        $this->db->or_like('pengajuan_tak.nama_pic', $keyword);
        $this->db->or_like('mahasiswa.nama', $keyword);
        $this->db->or_like('pengajuan_tak.nim', $keyword);
        $this->db->or_like('pengajuan_tak.no_tak', $keyword);
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    public function filter_by_date($start_date, $end_date, $status = 'all') {
        $this->db->select('pengajuan_tak.*, mahasiswa.nama as nama_mahasiswa');
        $this->db->join('mahasiswa', 'mahasiswa.nim = pengajuan_tak.nim', 'left');
        $this->db->where('DATE(pengajuan_tak.created_at) >=', $start_date);
        $this->db->where('DATE(pengajuan_tak.created_at) <=', $end_date);
        
        if ($status != 'all') {
            $this->db->where('pengajuan_tak.status', $status);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('pengajuan_tak');
        return $query->result();
    }

    // ==================== DATA MAHASISWA ====================

    public function get_mahasiswa_by_nim($nim) {
        $this->db->where('nim', $nim);
        $query = $this->db->get('mahasiswa');
        return $query->row();
    }

    public function get_all_mahasiswa() {
        $this->db->order_by('nama', 'ASC');
        $query = $this->db->get('mahasiswa');
        return $query->result();
    }
}