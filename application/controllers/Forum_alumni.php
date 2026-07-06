<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum_alumni extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('ForumAlumniModel');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library(array('form_validation', 'session', 'upload'));
        
        // HANYA untuk halaman yang memerlukan login (create post, delete post)
        // Method like dan comment TIDAK memerlukan login
    }
    
    public function index() {
        // Ambil data dari session (bisa dari berbagai role)
        $user_id = $this->session->userdata('user_id');
        $user_nama = $this->session->userdata('nama');
        $user_foto = $this->session->userdata('foto');
        $user_role = $this->session->userdata('role');
        $user_nim = $this->session->userdata('nim');
        $user_nidn = $this->session->userdata('nidn');
        
        // Jika nama kosong tapi user_id ada, ambil dari database
        if (empty($user_nama) && $user_id) {
            $this->db->select('nama, foto');
            $this->db->where('id', $user_id);
            $user = $this->db->get('users')->row();
            if ($user) {
                $user_nama = $user->nama;
                $user_foto = $user->foto;
                // Update session
                $this->session->set_userdata('nama', $user_nama);
                $this->session->set_userdata('foto', $user_foto);
            }
        }
        
        // Tampilkan nama berdasarkan role (untuk tampilan yang lebih baik)
        $display_name = $user_nama;
        if ($user_role == 'mahasiswa' && !empty($user_nim)) {
            $display_name = $user_nama . ' (' . $user_nim . ')';
        } elseif ($user_role == 'dosen_pembina' && !empty($user_nidn)) {
            $display_name = $user_nama . ' (Dosen)';
        } elseif ($user_role == 'kemahasiswaan') {
            $display_name = $user_nama . ' (Admin)';
        }
        
        $data['title'] = 'Forum Alumni';
        $data['posts'] = $this->ForumAlumniModel->get_posts(20);
        $data['user_data'] = array(
            'user_id' => $user_id,
            'nama' => $display_name,
            'nama_asli' => $user_nama,
            'foto' => $user_foto,
            'role' => $user_role,
            'nim' => $user_nim,
            'nidn' => $user_nidn,
            'logged_in' => $this->session->userdata('logged_in') ? true : false
        );
        
        $this->load->view('forum_alumni/index', $data);
    }
    
    // Menampilkan halaman create postingan (HARUS LOGIN)
    public function create() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $user_id = $this->session->userdata('user_id');
        $user_nama = $this->session->userdata('nama');
        $user_foto = $this->session->userdata('foto');
        $user_role = $this->session->userdata('role');
        
        if (empty($user_nama) && $user_id) {
            $this->db->select('nama, foto');
            $this->db->where('id', $user_id);
            $user = $this->db->get('users')->row();
            if ($user) {
                $user_nama = $user->nama;
                $user_foto = $user->foto;
                $this->session->set_userdata('nama', $user_nama);
                $this->session->set_userdata('foto', $user_foto);
            }
        }
        
        $data['title'] = 'Buat Postingan Baru - Forum Alumni';
        $data['user_data'] = array(
            'user_id' => $user_id,
            'nama' => $user_nama,
            'foto' => $user_foto,
            'role' => $user_role,
            'logged_in' => true
        );
        
        $this->load->view('forum_alumni/create', $data);
    }
    
    // Proses store postingan (HARUS LOGIN)
    public function store() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->form_validation->set_rules('content', 'Konten', 'required|min_length[1]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('forum_alumni/create');
        }
        
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');
        
        $image_name = null;
        $video_name = null;
        
        // Handle image upload
        if (!empty($_FILES['post_image']['name'])) {
            $config['upload_path'] = './uploads/forum_posts/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp|heic';
            $config['max_size'] = 10240;
            $config['file_name'] = 'post_' . time() . '_' . bin2hex(random_bytes(8));
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('post_image')) {
                $upload_data = $this->upload->data();
                $image_name = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('forum_alumni/create');
            }
        }
        
        // Handle video upload
        if (!empty($_FILES['post_video']['name'])) {
            $config['upload_path'] = './uploads/forum_posts/videos/';
            $config['allowed_types'] = 'mp4|mov|avi|wmv|webm|mkv';
            $config['max_size'] = 51200;
            $config['file_name'] = 'video_' . time() . '_' . bin2hex(random_bytes(8));
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('post_video')) {
                $upload_data = $this->upload->data();
                $video_name = 'videos/' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('forum_alumni/create');
            }
        }
        
        $post_data = array(
            'user_id' => $user_id,
            'content' => $content,
            'image' => $image_name,
            'video' => $video_name
        );
        
        $post_id = $this->ForumAlumniModel->create_post($post_data);
        
        if ($post_id) {
            $this->session->set_flashdata('success', 'Postingan berhasil dibuat!');
            redirect('forum_alumni');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat postingan.');
            redirect('forum_alumni/create');
        }
    }
    
    // Method create_post untuk form di halaman utama (HARUS LOGIN)
    public function create_post() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $this->form_validation->set_rules('content', 'Konten', 'required|min_length[1]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('forum_alumni');
        }
        
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');
        
        $image_name = null;
        $video_name = null;
        
        // Handle image upload
        if (!empty($_FILES['post_image']['name'])) {
            $config['upload_path'] = './uploads/forum_posts/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
            $config['max_size'] = 10240;
            $config['file_name'] = 'post_' . time() . '_' . bin2hex(random_bytes(8));
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('post_image')) {
                $upload_data = $this->upload->data();
                $image_name = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('forum_alumni');
            }
        }
        
        // Handle video upload
        if (!empty($_FILES['post_video']['name'])) {
            $config['upload_path'] = './uploads/forum_posts/videos/';
            $config['allowed_types'] = 'mp4|mov|avi|wmv|webm';
            $config['max_size'] = 51200;
            $config['file_name'] = 'video_' . time() . '_' . bin2hex(random_bytes(8));
            
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('post_video')) {
                $upload_data = $this->upload->data();
                $video_name = 'videos/' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('forum_alumni');
            }
        }
        
        $post_data = array(
            'user_id' => $user_id,
            'content' => $content,
            'image' => $image_name,
            'video' => $video_name
        );
        
        $post_id = $this->ForumAlumniModel->create_post($post_data);
        
        if ($post_id) {
            $this->session->set_flashdata('success', 'Postingan berhasil dibuat!');
        } else {
            $this->session->set_flashdata('error', 'Gagal membuat postingan.');
        }
        
        redirect('forum_alumni');
    }
    
    public function delete_post($post_id) {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $post = $this->ForumAlumniModel->get_post($post_id);
        
        if ($post && $post['user_id'] == $user_id) {
            if ($post['image'] && file_exists('./uploads/forum_posts/' . $post['image'])) {
                unlink('./uploads/forum_posts/' . $post['image']);
            }
            
            if ($post['video'] && file_exists('./uploads/forum_posts/' . $post['video'])) {
                unlink('./uploads/forum_posts/' . $post['video']);
            }
            
            $deleted = $this->ForumAlumniModel->delete_post($post_id, $user_id);
            
            if ($deleted) {
                $this->session->set_flashdata('success', 'Postingan berhasil dihapus.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus postingan.');
            }
        } else {
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk menghapus postingan ini.');
        }
        
        redirect('forum_alumni');
    }
    
    // PERBAIKAN: toggle_like TIDAK memerlukan login
    public function toggle_like() {
        // Set header JSON
        $this->output->set_content_type('application/json');
        
        $post_id = $this->input->post('post_id');
        
        // Wajib login untuk melakukan like
        $user_id = $this->session->userdata('user_id');
        
        if (!$user_id) {
            echo json_encode(['error' => 'Silakan login terlebih dahulu untuk berinteraksi.', 'redirect' => base_url('login')]);
            return;
        }
        
        if (!$post_id || !$user_id) {
            echo json_encode(['error' => 'Invalid request']);
            return;
        }
        
        $result = $this->ForumAlumniModel->toggle_like($post_id, $user_id);
        echo json_encode($result);
    }
    
    // PERBAIKAN: get_likes TIDAK memerlukan login
    public function get_likes() {
        $this->output->set_content_type('application/json');
        
        $post_id = $this->input->post('post_id');
        
        if (!$post_id) {
            echo json_encode(['error' => 'Invalid post ID']);
            return;
        }
        
        $this->db->select('l.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_likes l');
        $this->db->join('users u', 'u.id = l.user_id', 'left');
        $this->db->where('l.post_id', $post_id);
        $this->db->order_by('l.created_at', 'DESC');
        $likes = $this->db->get()->result_array();
        
        foreach ($likes as &$like) {
            $like['time_ago'] = $this->time_ago($like['created_at']);
            // Jika user_id dimulai dengan 'guest_', tampilkan sebagai Tamu
            if (strpos($like['user_id'], 'guest_') === 0) {
                $like['nama'] = 'Tamu';
                $like['user_foto'] = null;
            }
        }
        
        echo json_encode(['success' => true, 'likes' => $likes, 'total' => count($likes)]);
    }
    
    // PERBAIKAN: add_comment TIDAK memerlukan login
    public function add_comment() {
        $this->output->set_content_type('application/json');
        
        $post_id = $this->input->post('post_id');
        $comment = trim($this->input->post('comment'));
        $user_id = $this->session->userdata('user_id');
        $user_nama = $this->session->userdata('nama');
        
        // Wajib login untuk komentar
        if (!$user_id) {
            echo json_encode(['error' => 'Silakan login terlebih dahulu untuk berinteraksi.', 'redirect' => base_url('login')]);
            return;
        }
        
        if (!$post_id) {
            echo json_encode(['error' => 'Post ID tidak ditemukan']);
            return;
        }
        
        if (empty($comment)) {
            echo json_encode(['error' => 'Komentar tidak boleh kosong']);
            return;
        }
        
        $this->db->where('id', $post_id);
        $post_exists = $this->db->get('forum_alumni_posts')->num_rows();
        
        if ($post_exists == 0) {
            echo json_encode(['error' => 'Postingan tidak ditemukan']);
            return;
        }
        
        $comment_data = array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        $insert = $this->db->insert('forum_alumni_comments', $comment_data);
        
        if ($insert) {
            $comment_id = $this->db->insert_id();
            
            $this->db->set('comments_count', 'comments_count+1', FALSE);
            $this->db->where('id', $post_id);
            $this->db->update('forum_alumni_posts');
            
            // Return comment data
            $comment_data_result = array(
                'id' => $comment_id,
                'post_id' => $post_id,
                'user_id' => $user_id,
                'comment' => $comment,
                'created_at' => date('Y-m-d H:i:s'),
                'nama' => $user_nama,
                'user_foto' => null,
                'time_ago' => $this->time_ago(date('Y-m-d H:i:s'))
            );
            
            echo json_encode(['success' => true, 'comment' => $comment_data_result]);
        } else {
            echo json_encode(['error' => 'Gagal menyimpan komentar ke database']);
        }
    }
    
    public function delete_comment() {
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(['error' => 'Silakan login terlebih dahulu']);
            return;
        }
        
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $comment_id = $this->input->post('comment_id');
        $user_id = $this->session->userdata('user_id');
        
        if (!$comment_id || !$user_id) {
            echo json_encode(['error' => 'Invalid request']);
            return;
        }
        
        $this->db->where('id', $comment_id);
        $comment = $this->db->get('forum_alumni_comments')->row();
        
        if ($comment && $comment->user_id == $user_id) {
            $this->db->where('id', $comment_id);
            $deleted = $this->db->delete('forum_alumni_comments');
            
            if ($deleted) {
                $this->db->set('comments_count', 'comments_count-1', FALSE);
                $this->db->where('id', $comment->post_id);
                $this->db->update('forum_alumni_posts');
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Gagal menghapus komentar']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Anda tidak memiliki izin']);
        }
    }
    
    public function get_comments() {
        $this->output->set_content_type('application/json');
        
        $post_id = $this->input->post('post_id');
        
        if (!$post_id) {
            echo json_encode(['error' => 'Invalid post ID']);
            return;
        }
        
        $this->db->select('c.*, u.nama, u.foto as user_foto');
        $this->db->from('forum_alumni_comments c');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->where('c.post_id', $post_id);
        $this->db->order_by('c.created_at', 'ASC');
        $comments = $this->db->get()->result_array();
        
        foreach ($comments as &$comment) {
            $comment['time_ago'] = $this->time_ago($comment['created_at']);
            // Jika user_id dimulai dengan 'guest_', tampilkan sebagai Tamu
            if (strpos($comment['user_id'], 'guest_') === 0) {
                $comment['nama'] = 'Tamu';
                $comment['user_foto'] = null;
            }
        }
        
        echo json_encode(['comments' => $comments]);
    }
    
    private function time_ago($timestamp) {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        
        $minutes = round($seconds / 60);
        $hours = round($seconds / 3600);
        $days = round($seconds / 86400);
        $weeks = round($seconds / 604800);
        $months = round($seconds / 2629440);
        $years = round($seconds / 31553280);
        
        if ($seconds <= 60) {
            return "Baru saja";
        } else if ($minutes <= 60) {
            return ($minutes == 1) ? "1 menit yang lalu" : "$minutes menit yang lalu";
        } else if ($hours <= 24) {
            return ($hours == 1) ? "1 jam yang lalu" : "$hours jam yang lalu";
        } else if ($days <= 7) {
            return ($days == 1) ? "kemarin" : "$days hari yang lalu";
        } else if ($weeks <= 4.3) {
            return ($weeks == 1) ? "1 minggu yang lalu" : "$weeks minggu yang lalu";
        } else if ($months <= 12) {
            return ($months == 1) ? "1 bulan yang lalu" : "$months bulan yang lalu";
        } else {
            return ($years == 1) ? "1 tahun yang lalu" : "$years tahun yang lalu";
        }
    }
}