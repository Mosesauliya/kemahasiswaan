<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function cek_login($username, $password) {
        $this->db->from('users');
        $this->db->group_start();
            $this->db->where('username', $username);
            $this->db->or_where('nim', $username);
            $this->db->or_where('email', $username);
        $this->db->group_end();
        $this->db->where('status', 'aktif');
        $this->db->limit(1);

        $user = $this->db->get()->row();

        if (!$user) return false;
        if (password_verify($password, $user->password)) return $user;
        if ($user->password === md5($password))           return $user;

        return false;
    }

    /**
     * Registrasi mahasiswa baru
     */
    public function register($data) {
        return $this->db->insert('users', $data);
    }

    /**
     * Cek apakah NIM sudah terdaftar
     */
    public function nim_exists($nim) {
        return $this->db->where('nim', $nim)->count_all_results('users') > 0;
    }
}