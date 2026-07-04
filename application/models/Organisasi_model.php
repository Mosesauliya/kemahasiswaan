<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Organisasi_model extends CI_Model
{
    private $table = 'organisasi';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->_ensure_table();
    }

    // ==================== SCHEMA MANAGEMENT ====================

    /**
     * Buat tabel organisasi jika belum ada, dan seed data awal
     */
    private function _ensure_table()
    {
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table}` (
                    `id`          INT(11)       NOT NULL AUTO_INCREMENT,
                    `nama`        VARCHAR(255)  NOT NULL,
                    `deskripsi`   TEXT          NULL,
                    `logo`        VARCHAR(255)  NULL COMMENT 'path relatif dari root project',
                    `icon`        VARCHAR(100)  DEFAULT 'fas fa-star' COMMENT 'FontAwesome class fallback',
                    `kategori`    VARCHAR(100)  DEFAULT 'Umum',
                    `aktif`       TINYINT(1)    NOT NULL DEFAULT 1,
                    `urutan`      INT(11)       NOT NULL DEFAULT 0,
                    `created_at`  DATETIME      NULL,
                    `updated_at`  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    KEY `idx_aktif` (`aktif`),
                    KEY `idx_urutan` (`urutan`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");

            // Seed data dari hardcode lama di dashboard
            $this->_seed_initial_data();
            log_message('info', 'Table organisasi created and seeded.');
        }
    }

    /**
     * Insert data awal (migrasi dari hardcode JS dashboard)
     */
    private function _seed_initial_data()
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            ['nama' => 'UKM Djawa Tjap Parabola', 'deskripsi' => 'Bidang seni dan kebudayaan khususnya budaya Jawa.',            'logo' => 'assets/UKM Djawa Tjap Parabola.png', 'icon' => 'fas fa-mask',            'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 1,  'created_at' => $now],
            ['nama' => 'UKM Aceh',                'deskripsi' => 'UKM yang bergerak di bidang seni dan kebudayaan kedaerahan Aceh.', 'logo' => 'assets/UKM Aceh.png',                'icon' => 'fas fa-map-marker-alt', 'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 2,  'created_at' => $now],
            ['nama' => 'UKM Tel-U Choir',         'deskripsi' => 'UKM yang bergerak di bidang seni paduan suara.',               'logo' => 'assets/UKM Tel-U Choir.png',         'icon' => 'fas fa-music',          'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 3,  'created_at' => $now],
            ['nama' => 'UKM Basket',              'deskripsi' => 'UKM yang bergerak di bidang olahraga bola basket.',             'logo' => 'assets/UKM Basket.png',              'icon' => 'fas fa-basketball-ball', 'kategori' => 'Olahraga',      'aktif' => 1, 'urutan' => 4,  'created_at' => $now],
            ['nama' => 'UKM Bola',                'deskripsi' => 'UKM yang bergerak di bidang olahraga sepak bola dan futsal.',   'logo' => 'assets/UKM Bola.png',                'icon' => 'fas fa-futbol',         'kategori' => 'Olahraga',      'aktif' => 1, 'urutan' => 5,  'created_at' => $now],
            ['nama' => 'UKM Karate-do',           'deskripsi' => 'UKM yang bergerak di bidang seni bela diri karate.',           'logo' => 'assets/UKM Karate-do.png',           'icon' => 'fas fa-fist-raised',    'kategori' => 'Olahraga',      'aktif' => 1, 'urutan' => 6,  'created_at' => $now],
            ['nama' => 'UKM Merpati Putih',       'deskripsi' => 'UKM yang bergerak di bidang seni bela diri pencak silat Merpati Putih.', 'logo' => 'assets/UKM Merpati Putih.png', 'icon' => 'fas fa-dove',        'kategori' => 'Olahraga',      'aktif' => 1, 'urutan' => 7,  'created_at' => $now],
            ['nama' => 'UKM Bengkel Seni Embun',  'deskripsi' => 'Bidang seni dan kebudayaan tradisional maupun kontemporer.',   'logo' => 'assets/UKM Bengkel Seni Embun.png',  'icon' => 'fas fa-palette',        'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 8,  'created_at' => $now],
            ['nama' => 'UKM Aksara Jurnalistik',  'deskripsi' => 'UKM yang bergerak di bidang jurnalistik dan media kampus.',    'logo' => 'assets/UKM Aksara Jurnalistik.png',  'icon' => 'fas fa-newspaper',      'kategori' => 'Akademik',      'aktif' => 1, 'urutan' => 9,  'created_at' => $now],
            ['nama' => 'UKM Archatel',            'deskripsi' => 'UKM di bidang arsitektur dan desain.',                         'logo' => 'assets/UKM Archatel.png',            'icon' => 'fas fa-drafting-compass','kategori' => 'Akademik',      'aktif' => 1, 'urutan' => 10, 'created_at' => $now],
            ['nama' => 'UKM Balon Kata!',         'deskripsi' => 'UKM seni pertunjukan dan teater.',                             'logo' => 'assets/UKM Balon Kata!.png',         'icon' => 'fas fa-theater-masks',  'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 11, 'created_at' => $now],
            ['nama' => 'UKM CARE Tel-U',          'deskripsi' => 'UKM yang bergerak di bidang sosial dan kepedulian lingkungan.','logo' => 'assets/UKM CARE Tel-U.png',          'icon' => 'fas fa-hands-helping',  'kategori' => 'Sosial',        'aktif' => 1, 'urutan' => 12, 'created_at' => $now],
            ['nama' => 'UKM CCI Tel-U',           'deskripsi' => 'UKM di bidang teknologi dan inovasi digital.',                 'logo' => 'assets/UKM CCI Tel-U.png',           'icon' => 'fas fa-laptop-code',    'kategori' => 'Akademik',      'aktif' => 1, 'urutan' => 13, 'created_at' => $now],
            ['nama' => 'UKM CSC Tel-U',           'deskripsi' => 'UKM Computer Science Club Telkom University.',                 'logo' => 'assets/UKM CSC Tel-U.png',           'icon' => 'fas fa-code',           'kategori' => 'Akademik',      'aktif' => 1, 'urutan' => 14, 'created_at' => $now],
            ['nama' => 'UKM Digistar Telkom',     'deskripsi' => 'UKM di bidang digital startup dan kewirausahaan.',             'logo' => 'assets/UKM Digistar Telkom.png',     'icon' => 'fas fa-rocket',         'kategori' => 'Kewirausahaan', 'aktif' => 1, 'urutan' => 15, 'created_at' => $now],
            ['nama' => 'UKM Google Developer',    'deskripsi' => 'UKM Google Developer Student Club Tel-U.',                    'logo' => 'assets/UKM Google Developer.png',    'icon' => 'fab fa-google',         'kategori' => 'Akademik',      'aktif' => 1, 'urutan' => 16, 'created_at' => $now],
            ['nama' => 'UKM KMB (Buddha)',        'deskripsi' => 'Keluarga Mahasiswa Buddha Telkom University.',                 'logo' => 'assets/UKM KMB (Buddha).png',        'icon' => 'fas fa-pray',           'kategori' => 'Kerohanian',    'aktif' => 1, 'urutan' => 17, 'created_at' => $now],
            ['nama' => 'UKM KMH (Hindu)',         'deskripsi' => 'Keluarga Mahasiswa Hindu Telkom University.',                  'logo' => 'assets/UKM KMH (Hindu).png',         'icon' => 'fas fa-om',             'kategori' => 'Kerohanian',    'aktif' => 1, 'urutan' => 18, 'created_at' => $now],
            ['nama' => 'UKM KMK (Katolik)',       'deskripsi' => 'Keluarga Mahasiswa Katolik Telkom University.',                'logo' => 'assets/UKM KMK (Katolik).png',       'icon' => 'fas fa-cross',          'kategori' => 'Kerohanian',    'aktif' => 1, 'urutan' => 19, 'created_at' => $now],
            ['nama' => 'UKM KMPA Tel-U',          'deskripsi' => 'UKM Kegiatan Mahasiswa Pecinta Alam Telkom University.',       'logo' => 'assets/UKM KMPA Tel-U.png',          'icon' => 'fas fa-mountain',       'kategori' => 'Sosial',        'aktif' => 1, 'urutan' => 20, 'created_at' => $now],
            ['nama' => 'UKM KPM',                 'deskripsi' => 'UKM Kesenian dan Pertunjukan Mahasiswa.',                     'logo' => 'assets/UKM KPM.png',                 'icon' => 'fas fa-guitar',         'kategori' => 'Seni & Budaya', 'aktif' => 1, 'urutan' => 21, 'created_at' => $now],
            ['nama' => 'UKM KSR PMI',             'deskripsi' => 'Korps Sukarela Palang Merah Indonesia Tel-U.',                'logo' => 'assets/UKM KSR PMI.png',             'icon' => 'fas fa-first-aid',      'kategori' => 'Sosial',        'aktif' => 1, 'urutan' => 22, 'created_at' => $now],
            ['nama' => 'UKM LDK AL Fath',         'deskripsi' => 'Lembaga Dakwah Kampus Al-Fath Telkom University.',            'logo' => 'assets/UKM LDK AL Fath.png',         'icon' => 'fas fa-mosque',         'kategori' => 'Kerohanian',    'aktif' => 1, 'urutan' => 23, 'created_at' => $now],
            ['nama' => 'UKM PMK (Kristen)',       'deskripsi' => 'Persekutuan Mahasiswa Kristen Telkom University.',             'logo' => 'assets/UKM PMK (Kristen).png',       'icon' => 'fas fa-church',         'kategori' => 'Kerohanian',    'aktif' => 1, 'urutan' => 24, 'created_at' => $now],
            ['nama' => 'UKM Paskibra',            'deskripsi' => 'UKM Paskibra Telkom University.',                             'logo' => 'assets/UKM Paskibra.png',            'icon' => 'fas fa-flag',           'kategori' => 'Sosial',        'aktif' => 1, 'urutan' => 25, 'created_at' => $now],
        ];

        $this->db->insert_batch($this->table, $data);
    }

    // ==================== CRUD ====================

    /**
     * Ambil semua organisasi
     */
    public function get_all($filter_aktif = null, $kategori = null, $search = null)
    {
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('nama', 'ASC');

        if ($filter_aktif !== null) {
            $this->db->where('aktif', $filter_aktif);
        }
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama', $search);
            $this->db->or_like('deskripsi', $search);
            $this->db->or_like('kategori', $search);
            $this->db->group_end();
        }

        return $this->db->get($this->table)->result();
    }

    /**
     * Ambil hanya yang aktif (untuk dashboard publik)
     */
    public function get_aktif()
    {
        return $this->db->where('aktif', 1)
                        ->order_by('urutan', 'ASC')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Ambil satu organisasi by ID
     */
    public function get_by_id($id)
    {
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    /**
     * Tambah organisasi baru
     */
    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update organisasi
     */
    public function update($id, $data)
    {
        $this->db->where('id', (int)$id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Hapus organisasi
     */
    public function delete($id)
    {
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    /**
     * Toggle status aktif
     */
    public function toggle_aktif($id)
    {
        $org = $this->get_by_id($id);
        if (!$org) return false;
        return $this->db->where('id', (int)$id)
                        ->update($this->table, ['aktif' => $org->aktif ? 0 : 1]);
    }

    /**
     * Hitung total
     */
    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    /**
     * Hitung yang aktif
     */
    public function count_aktif()
    {
        return $this->db->where('aktif', 1)->count_all_results($this->table);
    }

    /**
     * Ambil semua kategori unik
     */
    public function get_kategori_list()
    {
        $result = $this->db->distinct()
                           ->select('kategori')
                           ->order_by('kategori')
                           ->get($this->table)
                           ->result();
        return array_column($result, 'kategori');
    }
}
