<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komentar_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    // Get komentar by berita ID
    public function get_by_berita_id($berita_id, $limit = null) {
        $this->db->select('*');
        $this->db->from('komentar');
        $this->db->where('berita_id', $berita_id);
        $this->db->where('status', 'approved');
        $this->db->order_by('created_at', 'DESC');
        
        if($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Count komentar by berita ID
    public function count_by_berita_id($berita_id) {
        $this->db->where('berita_id', $berita_id);
        $this->db->where('status', 'approved');
        return $this->db->count_all_results('komentar');
    }
    
    // Get komentar by ID
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('komentar');
        return $query->row_array();
    }
    
    // Insert komentar
    public function insert($data) {
        $this->db->insert('komentar', $data);
        return $this->db->insert_id();
    }
    
    // Update komentar status (for moderation)
    public function update_status($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('komentar', ['status' => $status]);
    }
    
    // Delete komentar
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('komentar');
    }
    
    // Get all komentar (for admin)
    public function get_all($limit = null, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        if($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('komentar');
        return $query->result_array();
    }
}
?>