<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Log_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    /* ─── Halaman Login ─── */
    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->_redirect_after_login());
        }
        $data = [
            'title' => 'Login – Kemahasiswaan FIK Telkom University',
            'error' => $this->session->flashdata('error'),
            'success' => $this->session->flashdata('success'),
        ];
        $this->load->view('login/index', $data);
    }

    /* ─── Proses Login ─── */
    public function proses() {
        $this->form_validation->set_rules('username', 'Username/NIM', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->Login_model->cek_login($username, $password);

        if ($user) {
            $session_data = [
                'user_id'    => $user->id,
                'username'   => $user->username ?? $user->nim,
                'nama'       => $user->nama,
                'nim'        => $user->nim     ?? null,
                'nidn'       => $user->nidn    ?? null,
                'role'       => $user->role,
                'prodi'      => $user->program_studi ?? null,
                'foto'       => $user->foto    ?? null,
                'logged_in'  => TRUE,
            ];
            $this->session->set_userdata($session_data);
            
            // Catat ke log history
            $this->Log_model->insert_log($user->id, $user->nama, $user->role, 'Login Berhasil');
            
            redirect($this->_redirect_after_login($user->role));
        } else {
            $this->session->set_flashdata('error', 'NIM/Username atau password salah.');
            redirect('login');
        }
    }

    /* ─── Halaman Registrasi ─── */
    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect($this->_redirect_after_login());
        }
        $data = [
            'title' => 'Registrasi Akun – Kemahasiswaan FIK',
            'error' => $this->session->flashdata('error'),
            'success' => $this->session->flashdata('success'),
        ];
        $this->load->view('login/register', $data);
    }

    public function proses_register() {

    // Deteksi AJAX lebih awal
    $is_ajax = $this->input->is_ajax_request();

    $this->form_validation->set_rules('nim',  'NIM',  
        'required|trim|min_length[10]|max_length[20]|is_unique[users.nim]');
    $this->form_validation->set_rules('nama', 'Nama', 
        'required|trim|min_length[3]');
    $this->form_validation->set_rules('email', 'Email', 
        'required|valid_email|trim|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 
        'required|min_length[8]');
    $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 
        'required|matches[password]');
    $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
    $this->form_validation->set_rules('terms', 'Syarat & Ketentuan', 'required');

    $this->form_validation->set_message('is_unique', '{field} sudah terdaftar.');
    $this->form_validation->set_message('matches',   'Konfirmasi password tidak cocok.');

    if ($this->form_validation->run() == FALSE) {
        if ($is_ajax) {
            header('Content-Type: application/json');  // ← pakai header() native
            echo json_encode([
                'status'  => 'error',
                'message' => strip_tags(validation_errors())
            ]);
            exit; // ← pakai exit bukan return
        }
        $this->session->set_flashdata('error', validation_errors());
        redirect('login/register');
        return;
    }

    $nim = $this->input->post('nim', TRUE);

    $data = [
        'username'      => $nim,
        'nim'           => $nim,
        'nama'          => $this->input->post('nama',  TRUE),
        'email'         => $this->input->post('email', TRUE),
        'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'program_studi' => $this->input->post('prodi', TRUE),
        'role'          => 'mahasiswa',
        'status'        => 'aktif',
    ];

    if ($this->Login_model->register($data)) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'success',
                'message' => 'Registrasi berhasil! Silakan login menggunakan NIM dan password Anda.'
            ]);
            exit;
        }
        $this->session->set_flashdata('success', 'Registrasi berhasil!');
        redirect('login');
    } else {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data. Silakan coba lagi.'
            ]);
            exit;
        }
        $this->session->set_flashdata('error', 'Gagal registrasi.');
        redirect('login/register');
    }
}

    /* ─── Logout ─── */
    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Berhasil logout. Sampai jumpa!');
        redirect('login');
    }

    /* ─── Login dengan Microsoft (SSO) ─── */
    public function microsoft() {
        header('Content-Type: application/json');

        // Pastikan hanya request POST/AJAX
        if ($this->input->method() !== 'post') {
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
            exit;
        }

        $email = trim($this->input->post('email', TRUE));
        $password = $this->input->post('password');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Format email Microsoft tidak valid.']);
            exit;
        }

        if (empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Password tidak boleh kosong.']);
            exit;
        }

        // 1. Cek apakah email di-whitelist di sso_email_whitelist
        $this->db->where('email', $email);
        $this->db->limit(1);
        $whitelist = $this->db->get('sso_email_whitelist')->row();

        if (!$whitelist) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email Microsoft Anda belum di-whitelist oleh Admin.'
            ]);
            exit;
        }

        // 2. Cari di database tabel users berdasarkan email
        $this->db->where('email', $email);
        $this->db->where('status', 'aktif');
        $this->db->limit(1);
        $user = $this->db->get('users')->row();

        if ($user) {
            // Verifikasi password (menggunakan method yang sama dengan Login_model)
            $password_correct = false;
            if (password_verify($password, $user->password)) {
                $password_correct = true;
            } elseif ($user->password === md5($password)) {
                $password_correct = true;
            }

            if ($password_correct) {
                $session_data = [
                    'user_id'    => $user->id,
                    'username'   => $user->username ?? $user->nim,
                    'nama'       => $user->nama,
                    'nim'        => $user->nim     ?? null,
                    'nidn'       => $user->nidn    ?? null,
                    'role'       => $user->role,
                    'prodi'      => $user->program_studi ?? null,
                    'foto'       => $user->foto    ?? null,
                    'logged_in'  => TRUE,
                    'login_time' => time(), // Simpan waktu login
                ];
                $this->session->set_userdata($session_data);

                // Catat ke log history
                $this->Log_model->insert_log($user->id, $user->nama, $user->role, 'Login Berhasil (Microsoft SSO)');

                echo json_encode([
                    'status'   => 'success',
                    'redirect' => base_url($this->_redirect_after_login($user->role))
                ]);
                exit;
            } else {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Password yang Anda masukkan salah.'
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Email Microsoft terdaftar di Whitelist, namun tidak ditemukan akun user yang aktif dengan email tersebut.'
            ]);
            exit;
        }
    }

    /* ─── Helper Redirect ─── */
    private function _redirect_after_login($role = null) {
        $role = $role ?? $this->session->userdata('role');
        
        switch ($role) {
            case 'kemahasiswaan': 
            case 'kaprodi':       
            case 'dosen_pembina': 
            case 'bemdpm':        
                return 'proposal?tipe=semua';
            default:              
                return 'dashboard'; // Mahasiswa diarahkan ke dashboard
        }
    }
}