<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beasiswa_model extends CI_Model {
    
    private $table_pendaftaran = 'beasiswa_pendaftaran';
    private $table_beasiswa = 'beasiswa';
    private $table_files = 'beasiswa_files';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Mendapatkan semua data beasiswa yang tersedia
     */
    public function get_all_beasiswa($status = null) {
        $this->db->from($this->table_beasiswa);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('tanggal_mulai', 'ASC');
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * Mendapatkan detail beasiswa by ID
     */
    public function get_beasiswa_by_id($id) {
        return $this->db->get_where($this->table_beasiswa, ['id' => $id])->row();
    }
    
    /**
     * Mendapatkan beasiswa aktif
     */
    public function get_beasiswa_aktif() {
        $this->db->from($this->table_beasiswa);
        $this->db->where('status', 'aktif');
        $this->db->where('tanggal_mulai <=', date('Y-m-d'));
        $this->db->where('tanggal_selesai >=', date('Y-m-d'));
        $this->db->order_by('tanggal_selesai', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan beasiswa by jenis
     */
    public function get_beasiswa_by_jenis($jenis) {
        return $this->db->get_where($this->table_beasiswa, ['jenis' => $jenis])->row();
    }
    
    public function insert_pendaftaran($data) {
    // HAPUS 'id' dari data jika ada
    unset($data['id']);
    
    $this->db->insert($this->table_pendaftaran, $data);
    $insert_id = $this->db->insert_id();
    
    // Debug
    log_message('debug', 'Insert ID: ' . $insert_id);
    
    return $insert_id;
}
    
    /**
     * Update data pendaftaran
     */
    public function update_pendaftaran($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table_pendaftaran, $data);
    }
    
    /**
     * Mendapatkan data pendaftaran by ID
     */
    public function get_pendaftaran_by_id($id) {
        return $this->db->get_where($this->table_pendaftaran, ['id' => $id])->row();
    }
    
    /**
     * Mendapatkan data pendaftaran by email
     */
    public function get_pendaftaran_by_email($email) {
        $this->db->from($this->table_pendaftaran);
        $this->db->where('email', $email);
        $this->db->order_by('tanggal_daftar', 'DESC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan semua pendaftaran (untuk admin)
     */
    public function get_all_pendaftaran($status = null, $limit = null, $offset = 0) {
        $this->db->from($this->table_pendaftaran);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('tanggal_daftar', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Hitung total pendaftaran
     */
    public function count_pendaftaran($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table_pendaftaran);
    }
    
    /**
     * Mendapatkan statistik pendaftaran per jenis beasiswa
     */
    public function get_statistik_per_jenis() {
        $this->db->select('jenis_beasiswa, COUNT(*) as total');
        $this->db->from($this->table_pendaftaran);
        $this->db->group_by('jenis_beasiswa');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mendapatkan statistik pendaftaran per bulan
     */
    public function get_statistik_per_bulan($tahun = null) {
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        $this->db->select("MONTH(tanggal_daftar) as bulan, COUNT(*) as total");
        $this->db->from($this->table_pendaftaran);
        $this->db->where("YEAR(tanggal_daftar)", $tahun);
        $this->db->group_by("MONTH(tanggal_daftar)");
        $this->db->order_by("bulan", "ASC");
        
        return $this->db->get()->result();
    }
    
    /**
     * Menyimpan file upload
     */
    public function insert_file($data) {
        $this->db->insert($this->table_files, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Mendapatkan file berdasarkan pendaftaran ID
     */
    public function get_files_by_pendaftaran($pendaftaran_id) {
        return $this->db->get_where($this->table_files, ['pendaftaran_id' => $pendaftaran_id])->result();
    }
    
    /**
     * Hapus file
     */
    public function delete_file($id) {
        $file = $this->db->get_where($this->table_files, ['id' => $id])->row();
        
        if ($file) {
            // Hapus file fisik
            if (file_exists($file->file_path)) {
                unlink($file->file_path);
            }
            
            // Hapus dari database
            $this->db->where('id', $id);
            return $this->db->delete($this->table_files);
        }
        
        return false;
    }
    
    /**
     * Cek apakah email sudah mendaftar untuk beasiswa tertentu
     */
    public function cek_email_terdaftar($email, $jenis_beasiswa) {
        $this->db->from($this->table_pendaftaran);
        $this->db->where('email', $email);
        $this->db->where('jenis_beasiswa', $jenis_beasiswa);
        $this->db->where('tanggal_daftar >=', date('Y-m-d 00:00:00', strtotime('-30 days')));
        
        return $this->db->count_all_results() > 0;
    }
    
    /**
     * Update status pendaftaran
     */
    public function update_status($id, $status, $catatan = null) {
        $data = [
            'status' => $status,
            'catatan_admin' => $catatan
        ];
        
        $this->db->where('id', $id);
        return $this->db->update($this->table_pendaftaran, $data);
    }
    
    /**
     * Hapus pendaftaran (soft delete atau hard delete)
     */
    public function delete_pendaftaran($id, $hard_delete = false) {
        if ($hard_delete) {
            // Hapus file-file terkait
            $files = $this->get_files_by_pendaftaran($id);
            foreach ($files as $file) {
                $this->delete_file($file->id);
            }
            
            // Hapus data pendaftaran
            $this->db->where('id', $id);
            return $this->db->delete($this->table_pendaftaran);
        } else {
            // Soft delete (jika ada kolom deleted_at)
            // $this->db->where('id', $id);
            // return $this->db->update($this->table_pendaftaran, ['deleted_at' => date('Y-m-d H:i:s')]);
            
            // Jika tidak pakai soft delete, panggil hard delete
            return $this->delete_pendaftaran($id, true);
        }
    }
    
    /**
     * Export data pendaftaran
     */
    public function export_data($status = null, $start_date = null, $end_date = null) {
        $this->db->from($this->table_pendaftaran);
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        if ($start_date) {
            $this->db->where('tanggal_daftar >=', $start_date . ' 00:00:00');
        }
        
        if ($end_date) {
            $this->db->where('tanggal_daftar <=', $end_date . ' 23:59:59');
        }
        
        $this->db->order_by('tanggal_daftar', 'DESC');
        
        return $this->db->get()->result();
    }
}