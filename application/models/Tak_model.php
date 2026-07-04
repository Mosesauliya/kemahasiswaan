<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tak_model extends CI_Model 
{
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        
        // Cek dan buat tabel jika belum ada
        $this->_create_tables();
    }
    
    /**
     * Create tables if not exists
     */
    private function _create_tables()
    {
        // Tabel pengajuan_tak
        if (!$this->db->table_exists('pengajuan_tak')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `pengajuan_tak` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `kode_pengajuan` VARCHAR(50) NULL,
                    `nim` VARCHAR(20) NOT NULL,
                    `nama_mahasiswa` VARCHAR(100) NOT NULL,
                    `nama_pic` VARCHAR(100) NOT NULL,
                    `judul_kegiatan` VARCHAR(255) NOT NULL,
                    `deskripsi` TEXT NOT NULL,
                    `tanggal_kegiatan` DATE NOT NULL,
                    `lokasi` VARCHAR(255) NOT NULL,
                    `link_sertifikat` VARCHAR(500) NOT NULL,
                    `file_surat_pengajuan` VARCHAR(255) NOT NULL,
                    `file_excel_peserta` VARCHAR(255) NOT NULL,
                    `status` ENUM('pending','diproses','disetujui','ditolak') DEFAULT 'pending',
                    `catatan_admin` TEXT NULL,
                    `nomor_sertifikat` VARCHAR(100) NULL,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_nim` (`nim`),
                    KEY `idx_status` (`status`),
                    KEY `idx_kode_pengajuan` (`kode_pengajuan`),
                    KEY `idx_created_at` (`created_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }
    
    // ==================== DATA MAHASISWA ====================
    
    /**
     * Get mahasiswa data by NIM
     */
    public function get_mahasiswa_data($nim) 
    {
        $this->db->select('nim, nama as nama_mahasiswa, program_studi, email');
        $this->db->where('nim', $nim);
        $query = $this->db->get('mahasiswa');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return (object) array(
                'nim' => $nim,
                'nama_mahasiswa' => $this->session->userdata('nama') ?: 'Mahasiswa',
                'program_studi' => '-',
                'email' => '-'
            );
        }
    }
    
    // ==================== PENGADUAN TAK ====================
    
    /**
     * Insert pengajuan TAK baru
     */
    public function insert_pengajuan($data) 
    {
        // Generate kode pengajuan jika belum ada
        if (!isset($data['kode_pengajuan']) || empty($data['kode_pengajuan'])) {
            $data['kode_pengajuan'] = $this->_generate_kode_pengajuan();
        }
        
        return $this->db->insert('pengajuan_tak', $data);
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
     * Get riwayat pengajuan by NIM dengan pagination
     */
    public function get_riwayat_pengajuan($nim, $limit = null, $offset = 0) 
    {
        $this->db->select('*');
        $this->db->from('pengajuan_tak');
        $this->db->where('nim', $nim);
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get detail pengajuan by ID and NIM
     */
    public function get_pengajuan_by_id($id, $nim) 
    {
        $this->db->where('id', $id);
        $this->db->where('nim', $nim);
        $query = $this->db->get('pengajuan_tak');
        return $query->row();
    }
    
    /**
     * Count total pengajuan by user (NIM)
     */
    public function count_pengajuan_by_user($nim) 
    {
        $this->db->from('pengajuan_tak');
        $this->db->where('nim', $nim);
        return $this->db->count_all_results();
    }
    
    /**
     * Count pengajuan by status
     */
    public function count_pengajuan_by_status($nim, $status) 
    {
        $this->db->from('pengajuan_tak');
        $this->db->where('nim', $nim);
        $this->db->where('status', $status);
        return $this->db->count_all_results();
    }
    
    /**
     * Update status pengajuan (untuk admin)
     */
    public function update_status($id, $status, $catatan_admin = null, $nomor_sertifikat = null) 
    {
        $data = array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        if ($catatan_admin !== null) {
            $data['catatan_admin'] = $catatan_admin;
        }
        
        if ($nomor_sertifikat !== null) {
            $data['nomor_sertifikat'] = $nomor_sertifikat;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('pengajuan_tak', $data);
    }
    
    /**
     * Delete pengajuan (untuk admin)
     */
    public function delete_pengajuan($id) 
    {
        // Get file names first
        $this->db->select('file_surat_pengajuan, file_excel_peserta');
        $this->db->where('id', $id);
        $query = $this->db->get('pengajuan_tak');
        $pengajuan = $query->row();
        
        if ($pengajuan) {
            // Delete files
            $surat_path = FCPATH . 'uploads/surat_pengajuan/' . $pengajuan->file_surat_pengajuan;
            $excel_path = FCPATH . 'uploads/excel_peserta/' . $pengajuan->file_excel_peserta;
            
            if (file_exists($surat_path)) {
                unlink($surat_path);
            }
            if (file_exists($excel_path)) {
                unlink($excel_path);
            }
            
            // Delete record
            $this->db->where('id', $id);
            return $this->db->delete('pengajuan_tak');
        }
        
        return false;
    }
    
    // ==================== STATISTIK UNTUK ADMIN ====================
    
    /**
     * Get all pengajuan (untuk admin)
     */
    public function get_all_pengajuan($limit = null, $offset = 0, $status = null) 
    {
        $this->db->select('*');
        $this->db->from('pengajuan_tak');
        $this->db->order_by('created_at', 'DESC');
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Count all pengajuan (untuk admin)
     */
    public function count_all_pengajuan($status = null) 
    {
        $this->db->from('pengajuan_tak');
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results();
    }
    
    /**
     * Get statistik semua pengajuan (untuk admin)
     */
    public function get_admin_stats() 
    {
        $stats = array();
        
        $stats['total'] = $this->db->count_all('pengajuan_tak');
        $stats['pending'] = $this->db->where('status', 'pending')->count_all_results('pengajuan_tak');
        $stats['diproses'] = $this->db->where('status', 'diproses')->count_all_results('pengajuan_tak');
        $stats['disetujui'] = $this->db->where('status', 'disetujui')->count_all_results('pengajuan_tak');
        $stats['ditolak'] = $this->db->where('status', 'ditolak')->count_all_results('pengajuan_tak');
        
        return $stats;
    }
    
    // ==================== SEARCH ====================
    
    /**
     * Search pengajuan by keyword
     */
    public function search_pengajuan($keyword, $limit = null, $offset = 0) 
    {
        $this->db->select('*');
        $this->db->from('pengajuan_tak');
        $this->db->group_start();
        $this->db->like('judul_kegiatan', $keyword);
        $this->db->or_like('nama_pic', $keyword);
        $this->db->or_like('nim', $keyword);
        $this->db->or_like('kode_pengajuan', $keyword);
        $this->db->or_like('nama_mahasiswa', $keyword);
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Count search results
     */
    public function count_search_pengajuan($keyword) 
    {
        $this->db->from('pengajuan_tak');
        $this->db->group_start();
        $this->db->like('judul_kegiatan', $keyword);
        $this->db->or_like('nama_pic', $keyword);
        $this->db->or_like('nim', $keyword);
        $this->db->or_like('kode_pengajuan', $keyword);
        $this->db->or_like('nama_mahasiswa', $keyword);
        $this->db->group_end();
        
        return $this->db->count_all_results();
    }
    
    // ==================== FUNGSI BANTUAN ====================
    
    /**
     * Get status label
     */
    public function get_status_label($status) 
    {
        $labels = array(
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'diproses' => '<span class="badge badge-info">Diproses</span>',
            'disetujui' => '<span class="badge badge-success">Disetujui</span>',
            'ditolak' => '<span class="badge badge-danger">Ditolak</span>'
        );
        
        return isset($labels[$status]) ? $labels[$status] : '<span class="badge badge-secondary">' . $status . '</span>';
    }
    
    /**
     * Get status class for CSS
     */
    public function get_status_class($status) 
    {
        $classes = array(
            'pending' => 'status-pending',
            'diproses' => 'status-diproses',
            'disetujui' => 'status-disetujui',
            'ditolak' => 'status-ditolak'
        );
        
        return isset($classes[$status]) ? $classes[$status] : 'status-pending';
    }
    
    /**
     * Get status icon
     */
    public function get_status_icon($status) 
    {
        $icons = array(
            'pending' => 'fa-clock',
            'diproses' => 'fa-spinner fa-spin',
            'disetujui' => 'fa-check-circle',
            'ditolak' => 'fa-times-circle'
        );
        
        return isset($icons[$status]) ? $icons[$status] : 'fa-question-circle';
    }
}
?>