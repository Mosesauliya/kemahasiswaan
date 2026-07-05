<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    private $table = 'activity_logs';

    public function __construct() {
        parent::__construct();
        $this->_ensure_table();
    }

    /**
     * Buat tabel activity_logs jika belum ada
     */
    private function _ensure_table() {
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table}` (
                    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `user_id` INT(11) NULL,
                    `nama` VARCHAR(100) NULL,
                    `role` VARCHAR(50) NULL,
                    `action` VARCHAR(255) NOT NULL,
                    `ip_address` VARCHAR(45) NULL,
                    `user_agent` TEXT NULL,
                    `created_at` DATETIME NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        }
    }

    /**
     * Insert log aktivitas baru
     */
    public function insert_log($user_id, $nama, $role, $action) {
        $data = array(
            'user_id'    => $user_id,
            'nama'       => $nama,
            'role'       => $role,
            'action'     => $action,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert($this->table, $data);
    }

    /**
     * Ambil semua data log diurutkan berdasarkan waktu terbaru
     */
    public function get_all_logs($limit = 1000) {
        $this->db->order_by('created_at', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit);
        }
        return $this->db->get($this->table)->result();
    }
}
