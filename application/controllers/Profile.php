<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);
        
        $data['user'] = $user;
        $data['title'] = 'Profil Saya';
        
        $this->load->view('profile/index', $data);
    }

    public function edit() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);
        
        $data['user'] = $user;
        $data['title'] = 'Edit Profil';
        
        $this->load->view('profile/edit', $data);
    }

    public function update() {
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('nim', 'NIM/NID', 'required');
        $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomor HP', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $user = $this->User_model->get_user_by_id($user_id);
            $data['user'] = $user;
            $data['title'] = 'Edit Profil';
            $this->load->view('profile/edit', $data);
        } else {
            $update_data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'nim' => $this->input->post('nim'),
                'prodi' => $this->input->post('prodi'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->User_model->update_user($user_id, $update_data)) {
                // Update session data
                $this->session->set_userdata('nama', $this->input->post('nama'));
                $this->session->set_userdata('email', $this->input->post('email'));
                
                $this->session->set_flashdata('success', '✅ Profil berhasil diperbarui!');
                redirect('profile');
            } else {
                $this->session->set_flashdata('error', '❌ Gagal memperbarui profil. Silakan coba lagi.');
                redirect('profile/edit');
            }
        }
    }

    /**
     * Update profil via AJAX (tanpa redirect)
     */
    public function update_ajax() {
        $user_id = $this->session->userdata('user_id');
        
        // Set validation rules
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('prodi', 'Program Studi', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            $error_messages = array(
                'nama' => strip_tags(form_error('nama')),
                'email' => strip_tags(form_error('email')),
                'prodi' => strip_tags(form_error('prodi'))
            );
            
            foreach ($error_messages as $field => $error) {
                if (!empty($error)) {
                    $errors[$field] = $error;
                }
            }
            
            $response = array(
                'status' => 'error',
                'message' => 'Validasi gagal. Silakan periksa kembali input Anda.',
                'errors' => $errors
            );
            echo json_encode($response);
            return;
        }
        
        $update_data = array(
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'prodi' => $this->input->post('prodi'),
            'no_hp' => $this->input->post('no_hp'),
            'alamat' => $this->input->post('alamat'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        if ($this->User_model->update_user($user_id, $update_data)) {
            // Update session data
            $this->session->set_userdata('nama', $this->input->post('nama'));
            $this->session->set_userdata('email', $this->input->post('email'));
            
            // Log activity
            $this->User_model->log_activity($user_id, 'update_profile', 'Memperbarui informasi profil');
            
            $response = array(
                'status' => 'success',
                'message' => '✅ Profil berhasil diperbarui!'
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => '❌ Gagal memperbarui profil. Silakan coba lagi.'
            );
        }
        
        echo json_encode($response);
    }

    public function update_photo() {
        $user_id = $this->session->userdata('user_id');
        
        $config['upload_path'] = './uploads/users/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        // Buat folder jika belum ada
        if (!is_dir('./uploads/users/')) {
            mkdir('./uploads/users/', 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('foto')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', strip_tags($error));
        } else {
            $upload_data = $this->upload->data();
            
            // Hapus foto lama jika ada
            $user = $this->User_model->get_user_by_id($user_id);
            if ($user && !empty($user->foto) && file_exists('./uploads/users/' . $user->foto)) {
                unlink('./uploads/users/' . $user->foto);
            }
            
            $update_data = array(
                'foto' => $upload_data['file_name'],
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->User_model->update_user($user_id, $update_data)) {
                // Update session data
                $this->session->set_userdata('foto', $upload_data['file_name']);
                $this->session->set_flashdata('success', '✅ Foto profil berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', '❌ Gagal memperbarui foto profil.');
            }
        }
        
        redirect('profile/edit');
    }

    /**
     * Update foto profil via AJAX (tanpa redirect)
     */
    public function update_photo_ajax() {
        $user_id = $this->session->userdata('user_id');
        
        // Cek apakah ada file yang diupload
        if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada file yang diunggah.']);
            return;
        }
        
        $config['upload_path'] = './uploads/users/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        // Buat folder jika belum ada
        if (!is_dir('./uploads/users/')) {
            mkdir('./uploads/users/', 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('foto')) {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => 'error', 'message' => strip_tags($error)]);
            return;
        }
        
        $upload_data = $this->upload->data();
        
        // Hapus foto lama jika ada
        $user = $this->User_model->get_user_by_id($user_id);
        if ($user && !empty($user->foto) && file_exists('./uploads/users/' . $user->foto)) {
            unlink('./uploads/users/' . $user->foto);
        }
        
        $update_data = array(
            'foto' => $upload_data['file_name'],
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        if ($this->User_model->update_user($user_id, $update_data)) {
            // Update session data
            $this->session->set_userdata('foto', $upload_data['file_name']);
            
            // Log activity
            $this->User_model->log_activity($user_id, 'update_photo', 'Memperbarui foto profil');
            
            echo json_encode([
                'status' => 'success', 
                'message' => '✅ Foto profil berhasil diperbarui!',
                'foto_url' => base_url('uploads/users/' . $upload_data['file_name'])
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => '❌ Gagal memperbarui foto profil.']);
        }
    }

    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $user = $this->User_model->get_user_by_id($user_id);
            $data['user'] = $user;
            $data['title'] = 'Edit Profil';
            $this->load->view('profile/edit', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $user = $this->User_model->get_user_by_id($user_id);
            
            if (password_verify($current_password, $user->password)) {
                $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
                
                if ($this->User_model->update_password($user_id, $new_password)) {
                    // Log activity
                    $this->User_model->log_activity($user_id, 'change_password', 'Mengubah password akun');
                    $this->session->set_flashdata('success', '✅ Password berhasil diubah!');
                } else {
                    $this->session->set_flashdata('error', '❌ Gagal mengubah password.');
                }
            } else {
                $this->session->set_flashdata('error', '❌ Password saat ini salah!');
            }
            
            redirect('profile/edit');
        }
    }

    /**
     * Ganti password via AJAX
     */
    public function change_password_ajax() {
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $errors = array();
            $error_messages = array(
                'current_password' => strip_tags(form_error('current_password')),
                'new_password' => strip_tags(form_error('new_password')),
                'confirm_password' => strip_tags(form_error('confirm_password'))
            );
            
            foreach ($error_messages as $field => $error) {
                if (!empty($error)) {
                    $errors[$field] = $error;
                }
            }
            
            $response = array(
                'status' => 'error',
                'message' => 'Validasi gagal. Silakan periksa kembali input Anda.',
                'errors' => $errors
            );
            echo json_encode($response);
            return;
        }
        
        $current_password = $this->input->post('current_password');
        $user = $this->User_model->get_user_by_id($user_id);
        
        if (password_verify($current_password, $user->password)) {
            $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            
            if ($this->User_model->update_password($user_id, $new_password)) {
                // Log activity
                $this->User_model->log_activity($user_id, 'change_password', 'Mengubah password akun');
                
                $response = array(
                    'status' => 'success',
                    'message' => '✅ Password berhasil diubah!'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => '❌ Gagal mengubah password. Silakan coba lagi.'
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => '❌ Password saat ini salah!',
                'errors' => array('current_password' => 'Password saat ini salah')
            );
        }
        
        echo json_encode($response);
    }

    public function delete_account() {
        $user_id = $this->session->userdata('user_id');
        
        // Hapus foto profil jika ada
        $user = $this->User_model->get_user_by_id($user_id);
        if ($user && !empty($user->foto) && file_exists('./uploads/users/' . $user->foto)) {
            unlink('./uploads/users/' . $user->foto);
        }
        
        if ($this->User_model->delete_user($user_id)) {
            $this->session->sess_destroy();
            $this->session->set_flashdata('success', '✅ Akun berhasil dihapus.');
            redirect('login');
        } else {
            $this->session->set_flashdata('error', '❌ Gagal menghapus akun.');
            redirect('profile');
        }
    }

    /**
     * Get user activity history
     */
    public function get_activities() {
        $user_id = $this->session->userdata('user_id');
        $activities = $this->User_model->get_user_activities($user_id, 10);
        
        echo json_encode(['status' => 'success', 'data' => $activities]);
    }
}
?>