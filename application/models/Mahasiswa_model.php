<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all mahasiswa with filters
     */
    public function get_all($prodi = null, $angkatan = null, $limit = 100, $offset = 0)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa');
        
        if ($prodi) {
            $this->db->where('program_studi', $prodi);
        }
        
        if ($angkatan) {
            $this->db->where('angkatan', $angkatan);
        }
        
        $this->db->order_by('angkatan', 'DESC');
        $this->db->order_by('nama', 'ASC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get mahasiswa by ID
     */
    public function get_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('mahasiswa');
        return $query->row();
    }

    /**
     * Get mahasiswa by NIM
     */
    public function get_by_nim($nim)
    {
        $this->db->where('nim', $nim);
        $query = $this->db->get('mahasiswa');
        return $query->row();
    }

    /**
     * Insert mahasiswa
     */
    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('mahasiswa', $data);
        return $this->db->insert_id();
    }

    /**
     * Update mahasiswa
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('mahasiswa', $data);
    }

    /**
     * Delete mahasiswa
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('mahasiswa');
    }

    /**
     * Get statistics
     */
    public function get_statistics()
    {
        $stats = [
            'total' => $this->db->count_all('mahasiswa'),
            'aktif' => $this->db->where('status', 'aktif')->count_all_results('mahasiswa'),
            'cuti' => $this->db->where('status', 'cuti')->count_all_results('mahasiswa'),
            'nonaktif' => $this->db->where('status', 'nonaktif')->count_all_results('mahasiswa'),
            'lulus' => $this->db->where('status', 'lulus')->count_all_results('mahasiswa')
        ];
        
        return $stats;
    }

    /**
     * Count mahasiswa with filters
     */
    public function count_all($prodi = null, $angkatan = null)
    {
        if ($prodi) {
            $this->db->where('program_studi', $prodi);
        }
        
        if ($angkatan) {
            $this->db->where('angkatan', $angkatan);
        }
        
        return $this->db->count_all_results('mahasiswa');
    }

    /**
     * Get distinct angkatan
     */
    public function get_angkatan_list()
    {
        $this->db->distinct();
        $this->db->select('angkatan');
        $this->db->from('mahasiswa');
        $this->db->order_by('angkatan', 'DESC');
        $query = $this->db->get();
        
        $result = [];
        foreach ($query->result() as $row) {
            if ($row->angkatan) {
                $result[] = $row->angkatan;
            }
        }
        
        return $result;
    }

    /**
     * Get prodi list
     */
    public function get_prodi_list()
    {
        $this->db->distinct();
        $this->db->select('program_studi');
        $this->db->from('mahasiswa');
        $this->db->where('program_studi IS NOT NULL');
        $this->db->order_by('program_studi', 'ASC');
        $query = $this->db->get();
        
        $result = [];
        foreach ($query->result() as $row) {
            if ($row->program_studi) {
                $result[] = $row->program_studi;
            }
        }
        
        return $result;
    }

    /**
     * Search mahasiswa
     */
    public function search($keyword, $limit = 20)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa');
        $this->db->group_start();
        $this->db->like('nim', $keyword);
        $this->db->or_like('nama', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->group_end();
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
}