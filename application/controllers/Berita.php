<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berita_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
    }

    // ==================== FRONTEND PAGES ====================

    /**
     * Halaman utama berita
     */
    public function index()
    {
        $data['title'] = 'Berita - Fakultas Industri Kreatif';
        
        // Get featured berita
        $data['featured'] = $this->Berita_model->get_featured_berita(3);
        
        // Get latest berita by kategori
        $data['berita_terbaru'] = $this->Berita_model->get_latest_berita(5, 'berita');
        $data['pengumuman_terbaru'] = $this->Berita_model->get_latest_berita(3, 'pengumuman');
        $data['artikel_terbaru'] = $this->Berita_model->get_latest_berita(3, 'artikel');
        
        // Get popular berita
        $data['populer'] = $this->Berita_model->get_popular_berita(5);
        
        // Get archive
        $data['archive'] = $this->Berita_model->get_archive();
        
        // Get stats
        $data['stats'] = $this->Berita_model->get_stats();
        
        // Data user dari session (jika login)
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'nim' => $this->session->userdata('nim'),
                'nidn' => $this->session->userdata('nidn'),
                'role' => $this->session->userdata('role'),
                'prodi' => $this->session->userdata('prodi'),
                'foto' => $this->session->userdata('foto'),
                'logged_in' => true
            ];
            
            // Format role untuk tampilan
            $role_display = '';
            switch ($data['user_data']['role']) {
                case 'mahasiswa': $role_display = 'Mahasiswa'; break;
                case 'dosen': case 'dosen_pembina': $role_display = 'Dosen'; break;
                case 'kemahasiswaan': $role_display = 'Staff Kemahasiswaan'; break;
                case 'kaprodi': $role_display = 'Kepala Program Studi'; break;
                case 'bemdpm': $role_display = 'BEM/DPM'; break;
                default: $role_display = ucfirst($data['user_data']['role']);
            }
            $data['user_data']['role_display'] = $role_display;
        } else {
            $data['user_data'] = null;
        }
        
        $this->load->view('berita/index', $data);
    }

    /**
     * Halaman kategori berita
     */
    public function kategori($kategori)
    {
        // Validate kategori
        $allowed = ['berita', 'pengumuman', 'artikel'];
        if (!in_array($kategori, $allowed)) {
            show_404();
        }
        
        $data['title'] = ucfirst($kategori) . ' - Fakultas Industri Kreatif';
        $data['kategori'] = $kategori;
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data['berita'] = $this->Berita_model->get_berita_by_kategori($kategori, $limit, $offset);
        $data['total'] = $this->Berita_model->count_berita($kategori);
        $data['total_pages'] = ceil($data['total'] / $limit);
        $data['current_page'] = $page;
        
        // Get popular
        $data['populer'] = $this->Berita_model->get_popular_berita(5);
        
        // Get archive
        $data['archive'] = $this->Berita_model->get_archive();
        
        // Data user
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'role' => $this->session->userdata('role'),
                'logged_in' => true
            ];
        } else {
            $data['user_data'] = null;
        }
        
        $kategori_display = [
            'berita' => 'Berita',
            'pengumuman' => 'Pengumuman',
            'artikel' => 'Artikel'
        ];
        $data['kategori_display'] = $kategori_display[$kategori];
        
        $this->load->view('berita/kategori', $data);
    }

    /**
     * Halaman detail berita
     */
    public function detail($slug)
    {
        $berita = $this->Berita_model->get_berita_by_slug($slug);
        
        if (!$berita) {
            show_404();
        }
        
        // Update views
        $this->Berita_model->update_views($berita['id']);
        $berita = $this->Berita_model->get_berita_by_slug($slug); // Refresh data
        
        $data['title'] = $berita['judul'] . ' - FIK';
        $data['berita'] = $berita;
        
        // Get related berita
        $data['related'] = $this->Berita_model->get_related_berita($berita['id'], $berita['kategori'], 3);
        
        // Get komentar (hanya yang status approved)
        $data['komentar'] = $this->Berita_model->get_komentar($berita['id']);
        $data['total_komentar'] = $this->Berita_model->count_komentar($berita['id']);
        
        // Get popular
        $data['populer'] = $this->Berita_model->get_popular_berita(5);
        
        // Data user
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'role' => $this->session->userdata('role'),
                'logged_in' => true
            ];
        } else {
            $data['user_data'] = null;
        }
        
        $this->load->view('berita/detail', $data);
    }

    /**
     * Search berita
     */
    public function search()
    {
        $keyword = $this->input->get('q');
        
        if (!$keyword) {
            redirect('berita');
        }
        
        $data['title'] = 'Hasil Pencarian: "' . $keyword . '"';
        $data['keyword'] = $keyword;
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data['berita'] = $this->Berita_model->search_berita($keyword, $limit, $offset);
        $data['total'] = $this->Berita_model->count_search_berita($keyword);
        $data['total_pages'] = ceil($data['total'] / $limit);
        $data['current_page'] = $page;
        
        // Get popular
        $data['populer'] = $this->Berita_model->get_popular_berita(5);
        
        // Get archive
        $data['archive'] = $this->Berita_model->get_archive();
        
        // Data user
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'role' => $this->session->userdata('role'),
                'logged_in' => true
            ];
        } else {
            $data['user_data'] = null;
        }
        
        $this->load->view('berita/search', $data);
    }

    /**
     * Archive by month
     */
    public function archive($year, $month)
    {
        $data['title'] = 'Arsip ' . date('F Y', strtotime($year . '-' . $month . '-01'));
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->where("DATE_FORMAT(published_at, '%Y-%m')", $year . '-' . $month);
        $total = $this->db->count_all_results();
        
        $this->db->select('id, judul, slug, kategori, ringkasan, gambar, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->where("DATE_FORMAT(published_at, '%Y-%m')", $year . '-' . $month);
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        
        $data['berita'] = $query->result_array();
        $data['total'] = $total;
        $data['total_pages'] = ceil($total / $limit);
        $data['current_page'] = $page;
        $data['year'] = $year;
        $data['month'] = $month;
        
        // Get popular
        $data['populer'] = $this->Berita_model->get_popular_berita(5);
        
        // Get archive
        $data['archive'] = $this->Berita_model->get_archive();
        
        // Data user
        $is_logged_in = $this->session->userdata('logged_in');
        if ($is_logged_in) {
            $data['user_data'] = [
                'user_id' => $this->session->userdata('user_id'),
                'username' => $this->session->userdata('username'),
                'nama' => $this->session->userdata('nama'),
                'role' => $this->session->userdata('role'),
                'logged_in' => true
            ];
        } else {
            $data['user_data'] = null;
        }
        
        $this->load->view('berita/archive', $data);
    }

    /**
     * Add komentar - REVISED
     * Komentar langsung diset approved agar langsung tampil
     */
    public function add_komentar()
    {
        // Set JSON response header
        $this->output->set_content_type('application/json');
        
        $this->form_validation->set_rules('berita_id', 'ID Berita', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email');
        $this->form_validation->set_rules('komentar', 'Komentar', 'required|min_length[5]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => strip_tags(validation_errors())
            ]));
            return;
        }
        
        // Check if berita exists
        $berita_id = $this->input->post('berita_id');
        $berita = $this->Berita_model->get_berita_by_id($berita_id);
        
        if (!$berita) {
            $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan.'
            ]));
            return;
        }
        
        // Prepare data
        $data = [
            'berita_id' => $berita_id,
            'nama' => htmlspecialchars($this->input->post('nama')),
            'email' => htmlspecialchars($this->input->post('email')),
            'komentar' => nl2br(htmlspecialchars($this->input->post('komentar'))),
            'status' => 'approved', // Langsung approved agar tampil
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $komentar_id = $this->Berita_model->add_komentar($data);
        
        if ($komentar_id) {
            // Get the newly added comment
            $komentar_baru = $this->Berita_model->get_komentar_by_id($komentar_id);
            
            $this->output->set_output(json_encode([
                'status' => 'success',
                'message' => 'Komentar berhasil ditambahkan!',
                'komentar' => [
                    'id' => $komentar_baru['id'],
                    'nama' => $komentar_baru['nama'],
                    'email' => $komentar_baru['email'],
                    'komentar' => $komentar_baru['komentar'],
                    'created_at' => date('d F Y H:i', strtotime($komentar_baru['created_at'])),
                    'created_at_raw' => $komentar_baru['created_at']
                ]
            ]));
        } else {
            $this->output->set_output(json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan komentar. Silakan coba lagi.'
            ]));
        }
    }

    // ==================== ADMIN CRUD ====================

    /**
     * Admin dashboard berita
     */
    public function admin()
    {
        // Cek login dan role admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $data['title'] = 'Admin Berita - FIK';
        $data['stats'] = $this->Berita_model->get_stats();
        
        // Get recent berita
        $data['recent'] = $this->Berita_model->get_admin_berita(10);
        
        $this->load->view('berita/admin/index', $data);
    }

    /**
     * List all berita for admin
     */
    public function admin_list()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $data['title'] = 'Daftar Berita - Admin';
        
        // Filters
        $kategori = $this->input->get('kategori');
        $status = $this->input->get('status');
        
        // Pagination
        $page = $this->input->get('page') ?: 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $data['berita'] = $this->Berita_model->get_admin_berita($limit, $offset, $kategori, $status);
        $data['total'] = $this->Berita_model->count_all_berita($kategori, $status);
        $data['total_pages'] = ceil($data['total'] / $limit);
        $data['current_page'] = $page;
        $data['kategori_filter'] = $kategori;
        $data['status_filter'] = $status;
        
        $this->load->view('berita/admin/list', $data);
    }

    /**
     * Create berita
     */
    public function create()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $data['title'] = 'Tulis Berita Baru - Admin';
        
        $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|in_list[berita,pengumuman,artikel]');
        $this->form_validation->set_rules('konten', 'Konten', 'required|min_length[20]');
        $this->form_validation->set_rules('ringkasan', 'Ringkasan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,publish]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('berita/admin/create', $data);
        } else {
            $slug = url_title($this->input->post('judul'), 'dash', TRUE);
            
            // Check if slug exists
            $slug_check = $this->Berita_model->get_berita_by_slug($slug);
            if ($slug_check) {
                $slug = $slug . '-' . time();
            }
            
            $berita_data = [
                'judul' => $this->input->post('judul'),
                'slug' => $slug,
                'kategori' => $this->input->post('kategori'),
                'konten' => $this->input->post('konten'),
                'ringkasan' => $this->input->post('ringkasan') ?: substr(strip_tags($this->input->post('konten')), 0, 200) . '...',
                'penulis' => $this->session->userdata('nama'),
                'status' => $this->input->post('status'),
                'featured' => $this->input->post('featured') ? 1 : 0,
                'published_at' => ($this->input->post('status') == 'publish') ? date('Y-m-d H:i:s') : null
            ];
            
            // Handle image upload
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = './uploads/berita/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                $config['max_size'] = 2048; // 2MB
                $config['encrypt_name'] = TRUE;
                
                // Create directory if not exists
                if (!is_dir($config['upload_path'])) {
                    mkdir($config['upload_path'], 0777, TRUE);
                }
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $berita_data['gambar'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('berita/admin/create', $data);
                    return;
                }
            }
            
            $berita_id = $this->Berita_model->insert_berita($berita_data);
            
            if ($berita_id) {
                $this->session->set_flashdata('success', 'Berita berhasil disimpan.');
                redirect('berita/admin_list');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan berita.');
                redirect('berita/create');
            }
        }
    }

    /**
     * Edit berita
     */
    public function edit($id)
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $berita = $this->Berita_model->get_berita_by_id($id);
        
        if (!$berita) {
            show_404();
        }
        
        $data['title'] = 'Edit Berita - Admin';
        $data['berita'] = $berita;
        
        $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|in_list[berita,pengumuman,artikel]');
        $this->form_validation->set_rules('konten', 'Konten', 'required|min_length[20]');
        $this->form_validation->set_rules('ringkasan', 'Ringkasan', 'max_length[500]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[draft,publish]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('berita/admin/edit', $data);
        } else {
            $berita_data = [
                'judul' => $this->input->post('judul'),
                'kategori' => $this->input->post('kategori'),
                'konten' => $this->input->post('konten'),
                'ringkasan' => $this->input->post('ringkasan'),
                'status' => $this->input->post('status'),
                'featured' => $this->input->post('featured') ? 1 : 0
            ];
            
            // Update slug if judul berubah
            if ($berita['judul'] != $this->input->post('judul')) {
                $slug = url_title($this->input->post('judul'), 'dash', TRUE);
                $slug_check = $this->Berita_model->get_berita_by_slug($slug);
                if ($slug_check && $slug_check['id'] != $id) {
                    $slug = $slug . '-' . time();
                }
                $berita_data['slug'] = $slug;
            }
            
            // Handle image upload
            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path'] = './uploads/berita/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('gambar')) {
                    // Delete old image
                    if ($berita['gambar'] && file_exists('./uploads/berita/' . $berita['gambar'])) {
                        unlink('./uploads/berita/' . $berita['gambar']);
                    }
                    
                    $upload_data = $this->upload->data();
                    $berita_data['gambar'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('berita/admin/edit', $data);
                    return;
                }
            }
            
            // Update published_at if status changed to publish
            if ($berita['status'] != 'publish' && $this->input->post('status') == 'publish') {
                $berita_data['published_at'] = date('Y-m-d H:i:s');
            }
            
            if ($this->Berita_model->update_berita($id, $berita_data)) {
                $this->session->set_flashdata('success', 'Berita berhasil diupdate.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate berita.');
            }
            
            redirect('berita/admin_list');
        }
    }

    /**
     * Delete berita
     */
    public function delete($id)
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $berita = $this->Berita_model->get_berita_by_id($id);
        
        if ($berita) {
            // Delete image
            if ($berita['gambar'] && file_exists('./uploads/berita/' . $berita['gambar'])) {
                unlink('./uploads/berita/' . $berita['gambar']);
            }
            
            // Delete all comments first
            $this->db->where('berita_id', $id);
            $this->db->delete('berita_komentar');
            
            // Delete berita
            $this->Berita_model->delete_berita($id);
            $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Berita tidak ditemukan.');
        }
        
        redirect('berita/admin_list');
    }

    /**
     * Toggle featured
     */
    public function toggle_featured($id)
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $berita = $this->Berita_model->get_berita_by_id($id);
        
        if ($berita) {
            $featured = $berita['featured'] ? 0 : 1;
            $this->Berita_model->update_berita($id, ['featured' => $featured]);
            $this->session->set_flashdata('success', 'Status featured berhasil diubah.');
        }
        
        redirect('berita/admin_list');
    }

    /**
     * Komentar management
     */
    public function komentar()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $data['title'] = 'Manajemen Komentar - Admin';
        
        $status = $this->input->get('status') ?: 'pending';
        $search = $this->input->get('search');
        
        $this->db->select('berita_komentar.*, berita.judul as berita_judul, berita.slug as berita_slug');
        $this->db->from('berita_komentar');
        $this->db->join('berita', 'berita.id = berita_komentar.berita_id');
        
        if ($status != 'all') {
            $this->db->where('berita_komentar.status', $status);
        }
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('berita_komentar.nama', $search);
            $this->db->or_like('berita_komentar.komentar', $search);
            $this->db->or_like('berita.judul', $search);
            $this->db->group_end();
        }
        
        $this->db->order_by('berita_komentar.created_at', 'DESC');
        $query = $this->db->get();
        
        $data['komentar'] = $query->result_array();
        $data['status_filter'] = $status;
        $data['search'] = $search;
        
        // Count stats
        $data['stats'] = [
            'pending' => $this->db->where('status', 'pending')->count_all_results('berita_komentar'),
            'approved' => $this->db->where('status', 'approved')->count_all_results('berita_komentar'),
            'spam' => $this->db->where('status', 'spam')->count_all_results('berita_komentar'),
            'total' => $this->db->count_all('berita_komentar')
        ];
        
        $this->load->view('berita/admin/komentar', $data);
    }

    /**
     * Update komentar status
     */
    public function update_komentar($id)
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $status = $this->input->post('status');
        
        if ($status && in_array($status, ['approved', 'pending', 'spam'])) {
            $this->db->where('id', $id);
            $this->db->update('berita_komentar', ['status' => $status]);
            $this->session->set_flashdata('success', 'Status komentar berhasil diupdate.');
        }
        
        redirect('berita/komentar');
    }

    /**
     * Delete komentar
     */
    public function delete_komentar($id)
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }
        
        $this->db->where('id', $id);
        $this->db->delete('berita_komentar');
        
        $this->session->set_flashdata('success', 'Komentar berhasil dihapus.');
        redirect('berita/komentar');
    }
}