<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_create_tables();
    }

    /**
     * Create tables if not exists
     */
    private function _create_tables()
    {
        // Tabel berita
        if (!$this->db->table_exists('berita')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `berita` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `judul` VARCHAR(255) NOT NULL,
                    `slug` VARCHAR(255) NOT NULL,
                    `kategori` ENUM('berita','pengumuman','artikel') DEFAULT 'berita',
                    `konten` LONGTEXT NOT NULL,
                    `ringkasan` TEXT NULL,
                    `gambar` VARCHAR(255) NULL,
                    `penulis` VARCHAR(100) NULL,
                    `sumber` VARCHAR(255) NULL,
                    `views` INT(11) DEFAULT 0,
                    `status` ENUM('draft','publish') DEFAULT 'draft',
                    `featured` TINYINT(1) DEFAULT 0,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    `published_at` DATETIME NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `slug` (`slug`),
                    KEY `idx_kategori` (`kategori`),
                    KEY `idx_status` (`status`),
                    KEY `idx_featured` (`featured`),
                    KEY `idx_published` (`published_at`),
                    FULLTEXT KEY `ft_search` (`judul`, `konten`, `ringkasan`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }

        // Tabel komentar berita
        if (!$this->db->table_exists('berita_komentar')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `berita_komentar` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `berita_id` INT(11) NOT NULL,
                    `nama` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(100) NULL,
                    `komentar` TEXT NOT NULL,
                    `status` ENUM('pending','approved','spam') DEFAULT 'approved',
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_berita` (`berita_id`),
                    KEY `idx_status` (`status`),
                    CONSTRAINT `fk_komentar_berita` FOREIGN KEY (`berita_id`) REFERENCES `berita` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }

        // Tabel related links
        if (!$this->db->table_exists('berita_related')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `berita_related` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `berita_id` INT(11) NOT NULL,
                    `judul` VARCHAR(255) NOT NULL,
                    `url` VARCHAR(255) NOT NULL,
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_berita` (`berita_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }

    // ==================== CRUD OPERATIONS ====================

    /**
     * Get all berita with pagination
     */
    public function get_all_berita($limit = null, $offset = 0, $kategori = null, $status = 'publish')
    {
        $this->db->select('*');
        $this->db->from('berita');
        
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('published_at', 'DESC');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get berita by ID
     */
    public function get_berita_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('berita');
        return $query->row_array();
    }

    /**
     * Get berita by slug and increment views
     */
    public function get_berita_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $this->db->where('status', 'publish');
        $query = $this->db->get('berita');
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return null;
    }

    /**
     * Update views counter
     */
    public function update_views($id)
    {
        $this->db->set('views', 'views+1', FALSE);
        $this->db->where('id', $id);
        return $this->db->update('berita');
    }

    /**
     * Insert berita
     */
    public function insert_berita($data)
    {
        // Generate slug if not provided
        if (!isset($data['slug']) || empty($data['slug'])) {
            $data['slug'] = $this->_create_slug($data['judul']);
        }
        
        // Set published_at if status is publish
        if ($data['status'] == 'publish' && !isset($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }
        
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('berita', $data);
        return $this->db->insert_id();
    }

    /**
     * Update berita
     */
    public function update_berita($id, $data)
    {
        // Update slug if judul changed
        if (isset($data['judul']) && !isset($data['slug'])) {
            $data['slug'] = $this->_create_slug($data['judul'], $id);
        }
        
        // Update published_at if status changed to publish
        if (isset($data['status']) && $data['status'] == 'publish') {
            $berita = $this->get_berita_by_id($id);
            if (!$berita || $berita['status'] != 'publish') {
                $data['published_at'] = date('Y-m-d H:i:s');
            }
        }
        
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->where('id', $id);
        return $this->db->update('berita', $data);
    }

    /**
     * Delete berita
     */
    public function delete_berita($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('berita');
    }

    /**
     * Create unique slug
     */
    private function _create_slug($title, $id = null)
    {
        $slug = url_title($title, 'dash', true);
        $original_slug = $slug;
        $count = 1;
        
        while ($this->_slug_exists($slug, $id)) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        
        return $slug;
    }

    /**
     * Check if slug exists
     */
    private function _slug_exists($slug, $id = null)
    {
        $this->db->where('slug', $slug);
        
        if ($id) {
            $this->db->where('id !=', $id);
        }
        
        $query = $this->db->get('berita');
        return $query->num_rows() > 0;
    }

    // ==================== FRONTEND FUNCTIONS ====================

    /**
     * Get latest berita untuk ditampilkan di dashboard
     */
    public function get_latest_berita($limit = 5, $kategori = null)
    {
        $this->db->select('id, judul, slug, kategori, ringkasan, konten, gambar, views, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        
        $this->db->order_by('featured', 'DESC');
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get berita by kategori dengan pagination
     */
    public function get_berita_by_kategori($kategori, $limit = 10, $offset = 0)
    {
        $this->db->select('id, judul, slug, kategori, ringkasan, gambar, views, published_at, penulis');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->where('kategori', $kategori);
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count berita by kategori
     */
    public function count_berita($kategori = null, $status = 'publish')
    {
        $this->db->from('berita');
        $this->db->where('status', $status);
        
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Count all berita for admin
     */
    public function count_all_berita($kategori = null, $status = null)
    {
        $this->db->from('berita');
        
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results();
    }

    /**
     * Search berita
     */
    public function search_berita($keyword, $limit = 10, $offset = 0)
    {
        $this->db->select('id, judul, slug, kategori, ringkasan, gambar, views, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->group_start();
        $this->db->like('judul', $keyword);
        $this->db->or_like('konten', $keyword);
        $this->db->or_like('ringkasan', $keyword);
        $this->db->group_end();
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count search berita
     */
    public function count_search_berita($keyword)
    {
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->group_start();
        $this->db->like('judul', $keyword);
        $this->db->or_like('konten', $keyword);
        $this->db->or_like('ringkasan', $keyword);
        $this->db->group_end();
        
        return $this->db->count_all_results();
    }

    /**
     * Get related berita
     */
    public function get_related_berita($id, $kategori, $limit = 3)
    {
        $this->db->select('id, judul, slug, ringkasan, gambar, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->where('kategori', $kategori);
        $this->db->where('id !=', $id);
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get featured berita
     */
    public function get_featured_berita($limit = 3)
    {
        $this->db->select('id, judul, slug, kategori, ringkasan, gambar, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->where('featured', 1);
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get popular berita by views
     */
    public function get_popular_berita($limit = 5)
    {
        $this->db->select('id, judul, slug, views, published_at');
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->order_by('views', 'DESC');
        $this->db->order_by('published_at', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get archive by month/year
     */
    public function get_archive()
    {
        $this->db->select("DATE_FORMAT(published_at, '%Y-%m') as month, DATE_FORMAT(published_at, '%M %Y') as month_name, COUNT(*) as total");
        $this->db->from('berita');
        $this->db->where('status', 'publish');
        $this->db->group_by('month');
        $this->db->order_by('month', 'DESC');
        $this->db->limit(12);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    // ==================== KOMENTAR FUNCTIONS ====================

    /**
     * Get komentar by berita ID (only approved)
     */
    public function get_komentar($berita_id, $limit = null)
    {
        $this->db->from('berita_komentar');
        $this->db->where('berita_id', $berita_id);
        $this->db->where('status', 'approved');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get komentar by ID
     */
    public function get_komentar_by_id($id)
    {
        $this->db->from('berita_komentar');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Add komentar - langsung approved
     */
    public function add_komentar($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('berita_komentar', $data);
        return $this->db->insert_id();
    }

    /**
     * Count komentar by berita ID (only approved)
     */
    public function count_komentar($berita_id)
    {
        $this->db->from('berita_komentar');
        $this->db->where('berita_id', $berita_id);
        $this->db->where('status', 'approved');
        return $this->db->count_all_results();
    }

    /**
     * Get all komentar for admin
     */
    public function get_all_komentar($limit = 50, $offset = 0, $status = null)
    {
        $this->db->select('berita_komentar.*, berita.judul as berita_judul, berita.slug as berita_slug');
        $this->db->from('berita_komentar');
        $this->db->join('berita', 'berita.id = berita_komentar.berita_id');
        
        if ($status) {
            $this->db->where('berita_komentar.status', $status);
        }
        
        $this->db->order_by('berita_komentar.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Update komentar status
     */
    public function update_komentar_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update('berita_komentar', ['status' => $status]);
    }

    /**
     * Delete komentar
     */
    public function delete_komentar($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('berita_komentar');
    }

    /**
     * Get pending komentar count
     */
    public function get_pending_komentar_count()
    {
        $this->db->where('status', 'pending');
        return $this->db->count_all_results('berita_komentar');
    }

    // ==================== ADMIN FUNCTIONS ====================

    /**
     * Get all berita for admin (including drafts)
     */
    public function get_admin_berita($limit = 20, $offset = 0, $kategori = null, $status = null)
    {
        $this->db->select('*');
        $this->db->from('berita');
        
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        
        if ($status) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get dashboard stats
     */
    public function get_stats()
    {
        $stats = [];
        
        // Total berita
        $stats['total'] = $this->db->count_all('berita');
        
        // By kategori
        $stats['berita'] = $this->db->where('kategori', 'berita')->count_all_results('berita');
        $stats['pengumuman'] = $this->db->where('kategori', 'pengumuman')->count_all_results('berita');
        $stats['artikel'] = $this->db->where('kategori', 'artikel')->count_all_results('berita');
        
        // By status
        $stats['publish'] = $this->db->where('status', 'publish')->count_all_results('berita');
        $stats['draft'] = $this->db->where('status', 'draft')->count_all_results('berita');
        
        // Total views
        $this->db->select_sum('views');
        $views = $this->db->get('berita')->row();
        $stats['total_views'] = $views->views ?? 0;
        
        // Featured
        $stats['featured'] = $this->db->where('featured', 1)->count_all_results('berita');
        
        // Total komentar
        $stats['total_komentar'] = $this->db->count_all('berita_komentar');
        
        // Komentar approved & pending
        $stats['komentar_approved'] = $this->db->where('status', 'approved')->count_all_results('berita_komentar');
        $stats['komentar_pending'] = $this->db->where('status', 'pending')->count_all_results('berita_komentar');
        
        return $stats;
    }
}