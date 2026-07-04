<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
        
        // Update database schema untuk fitur chat
        $this->_update_chat_schema();
        
        // Insert sample data if needed
        $this->_insert_sample_knowledge();
    }

    // ==================== DATABASE SCHEMA MANAGEMENT ====================

    /**
     * Update database schema untuk fitur chat
     */
    private function _update_chat_schema()
    {
        try {
            // Cek dan buat tabel _logs
            if (!$this->db->table_exists('_logs')) {
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `_logs` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `user_request` TEXT NOT NULL,
                        `ai_response` TEXT NOT NULL,
                        `feedback` VARCHAR(50) DEFAULT 'Ignored',
                        `is_edited` TINYINT(1) DEFAULT 0,
                        `edited_at` DATETIME NULL,
                        `original_message_id` INT(11) NULL,
                        `session_id` VARCHAR(100) NULL,
                        `createdAt` DATETIME NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `idx_createdAt` (`createdAt`),
                        KEY `idx_feedback` (`feedback`),
                        KEY `idx_session` (`session_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('info', 'Table _logs created successfully');
            }

            // Cek dan buat tabel knowledge_base
            if (!$this->db->table_exists('knowledge_base')) {
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `knowledge_base` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `keyword` VARCHAR(255) NOT NULL,
                        `description` TEXT NOT NULL,
                        `tags` TEXT NULL,
                        `category` VARCHAR(100) DEFAULT 'general',
                        `usage_count` INT DEFAULT 0,
                        `last_used` DATETIME NULL,
                        `created_at` DATETIME NULL,
                        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`),
                        KEY `idx_keyword` (`keyword`),
                        KEY `idx_category` (`category`),
                        KEY `idx_usage` (`usage_count`),
                        FULLTEXT KEY `ft_search` (`keyword`, `tags`, `description`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('info', 'Table knowledge_base created successfully');
            }

            // Cek dan buat tabel unanswered_questions
            if (!$this->db->table_exists('unanswered_questions')) {
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `unanswered_questions` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `question` TEXT NOT NULL,
                        `source` VARCHAR(50) DEFAULT 'chat',
                        `status` ENUM('pending','answered','dismissed') DEFAULT 'pending',
                        `session_id` VARCHAR(100) NULL,
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        `answered_at` DATETIME NULL,
                        PRIMARY KEY (`id`),
                        KEY `idx_status` (`status`),
                        KEY `idx_created` (`created_at`),
                        KEY `idx_session` (`session_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('info', 'Table unanswered_questions created successfully');
            }

            // Cek kolom session_id di tabel _logs
            $this->db->query("SHOW COLUMNS FROM `_logs` LIKE 'session_id'");
            if ($this->db->affected_rows() == 0) {
                $this->db->query("ALTER TABLE `_logs` ADD COLUMN `session_id` VARCHAR(100) NULL AFTER `original_message_id`");
                log_message('info', 'Added session_id column to _logs table');
            }

        } catch (Exception $e) {
            log_message('error', 'Failed to update schema: ' . $e->getMessage());
        }
    }

    /**
     * Insert sample data ke knowledge base
     */
    private function _insert_sample_knowledge()
    {
        try {
            $count = $this->db->count_all('knowledge_base');

            if ($count == 0) {
                $sample_data = [
                    [
                        'keyword' => 'Desain Komunikasi Visual',
                        'description' => 'Desain Komunikasi Visual (DKV) adalah program studi yang mempelajari seni desain grafis, branding, dan komunikasi visual. Prodi ini terakreditasi A dan memiliki fasilitas studio desain modern. Mahasiswa akan belajar tentang tipografi, ilustrasi, fotografi, dan desain interaktif.',
                        'tags' => 'dkv,desain,grafis,komunikasi visual,seni,digital',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Desain Interior',
                        'description' => 'Desain Interior mempelajari perancangan ruang interior yang estetis dan fungsional. Prodi ini terakreditasi A dan memiliki workshop khusus dengan peralatan modern. Mahasiswa akan belajar tentang ergonomi, material, pencahayaan, dan desain berkelanjutan.',
                        'tags' => 'interior,ruang,desain interior,arsitektur,workshop',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Desain Produk',
                        'description' => 'Desain Produk fokus pada pengembangan produk inovatif untuk industri kreatif. Mahasiswa belajar dari konsep hingga prototyping. Prodi ini terakreditasi A dan dilengkapi laboratorium prototyping 3D.',
                        'tags' => 'produk,industri,desain produk,prototyping,3d',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Kriya',
                        'description' => 'Kriya (Tekstil & Mode) adalah program studi yang mengeksplorasi seni kriya tekstil dan fashion design. Akreditasi A dengan studio fashion lengkap termasuk alat tenun, mesin jahit industri, dan laboratorium tekstil.',
                        'tags' => 'kriya,tekstil,mode,fashion,tenun,menjahit',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Seni Rupa',
                        'description' => 'Seni Rupa mengembangkan karya seni visual kontemporer. Mahasiswa belajar berbagai teknik dan media seni, dari lukis, patung, hingga seni instalasi. Studio seni yang inspiratif dengan pencahayaan alami.',
                        'tags' => 'seni rupa,lukis,patung,instalasi,visual',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Film Animasi',
                        'description' => 'Film & Animasi mempelajari produksi film, animasi 2D/3D, dan konten digital kreatif. Dilengkapi studio film dan animasi profesional dengan green screen, motion capture, dan software industri.',
                        'tags' => 'film,animasi,multimedia,produksi,sinematografi',
                        'category' => 'program_studi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Fasilitas Laboratorium',
                        'description' => 'FIK memiliki berbagai laboratorium kreatif: Lab Desain Grafis dengan iMac, Lab Fotografi dengan lighting profesional, Lab Animasi dengan workstation render farm, dan Lab Multimedia dengan peralatan audio visual lengkap.',
                        'tags' => 'fasilitas,lab,laboratorium,komputer,studio',
                        'category' => 'fasilitas',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Beasiswa',
                        'description' => 'Tersedia berbagai beasiswa di FIK: Beasiswa Prestasi Akademik (PPA), Beasiswa Bidikmisi/KIP Kuliah, Beasiswa Prestasi Non-Akademik, dan Beasiswa Kerjasama dengan Industri Kreatif seperti Tokopedia, Gojek, dan lainnya.',
                        'tags' => 'beasiswa,prestasi,bidikmisi,kip,finansial',
                        'category' => 'informasi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Karir Lulusan',
                        'description' => 'Lulusan FIK memiliki prospek karir luas: Creative Director, UI/UX Designer, Art Director, Fashion Designer, Animator, Film Maker, Brand Consultant, dan Entrepreneur Kreatif. Banyak alumni bekerja di perusahaan ternama.',
                        'tags' => 'karir,lulusan,kerja,profesi,alumni',
                        'category' => 'informasi',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ],
                    [
                        'keyword' => 'Kurikulum',
                        'description' => 'Kurikulum FIK berbasis Outcome-Based Education (OBE) dan dirancang bersama pelaku industri. Mata kuliah mencakup teori seni, praktik studio, magang industri, dan proyek akhir yang dapat berupa portofolio atau karya komersial.',
                        'tags' => 'kurikulum,mata kuliah,sks,perkuliahan',
                        'category' => 'akademik',
                        'usage_count' => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];

                $this->db->insert_batch('knowledge_base', $sample_data);
                log_message('info', 'Sample knowledge base data inserted');
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to insert sample knowledge: ' . $e->getMessage());
        }
    }


    // ==================== CHAT FUNCTIONS ====================

    /**
     * Save log chat ke database
     * @param string $user_request Pesan dari user
     * @param string $ai_response Respons dari bot
     * @param int $is_edited Apakah pesan diedit
     * @param int|null $original_message_id ID pesan asli jika diedit
     * @param string|null $session_id Session ID user
     * @return int ID log yang baru dibuat
     */
    public function save_log($user_request, $ai_response, $is_edited = 0, $original_message_id = null, $session_id = null)
    {
        try {
            $data = [
                'user_request' => trim($user_request),
                'ai_response' => trim($ai_response),
                'feedback' => 'Ignored',
                'is_edited' => $is_edited,
                'session_id' => $session_id,
                'createdAt' => date('Y-m-d H:i:s')
            ];

            if ($is_edited) {
                $data['edited_at'] = date('Y-m-d H:i:s');
            }

            if ($original_message_id) {
                $data['original_message_id'] = $original_message_id;
            }

            $this->db->insert('_logs', $data);
            $insert_id = $this->db->insert_id();
            
            log_message('debug', 'Chat log saved with ID: ' . $insert_id);
            return $insert_id;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save chat log: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Save feedback untuk pesan
     * @param int $message_id ID pesan
     * @param string $feedback Feedback (Like/Dislike)
     * @return bool
     */
    public function save_feedback($message_id, $feedback)
    {
        try {
            $this->db->where('id', $message_id);
            $result = $this->db->update('_logs', [
                'feedback' => $feedback
            ]);
            
            log_message('debug', 'Feedback saved for message ID: ' . $message_id . ' - ' . $feedback);
            return $result;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save feedback: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * PERBAIKAN UTAMA: Search answer dengan multiple methods dan better matching
     * @param string $input Pertanyaan user
     * @return array Hasil pencarian
     */
    public function search_answer($input)
    {
        $input = strtolower(trim($input));
        $clean_input = preg_replace('/[^a-z0-9\s]/', '', $input);

        log_message('debug', 'Searching for: ' . $input);

        // METHOD 1: Exact match pada keyword
        $this->db->select('id, keyword, description, tags, category, usage_count');
        $this->db->from('knowledge_base');
        $this->db->where('LOWER(keyword)', $input);
        $exact_query = $this->db->get();
        
        if ($exact_query->num_rows() > 0) {
            $result = $exact_query->row_array();
            $this->_update_usage_count($result['id']);
            
            log_message('debug', 'Exact match found: ' . $result['keyword']);
            return [
                'found' => true,
                'answer' => $result['description'],
                'confidence' => 100,
                'keyword' => $result['keyword'],
                'method' => 'exact'
            ];
        }

        // METHOD 2: Partial match dengan LIKE
        $this->db->select('id, keyword, description, tags, category, usage_count');
        $this->db->from('knowledge_base');
        $this->db->group_start();
        $this->db->like('LOWER(keyword)', $clean_input);
        $this->db->or_like('LOWER(tags)', $clean_input);
        $this->db->group_end();
        $this->db->order_by('usage_count DESC, id ASC');
        $this->db->limit(5);
        
        $like_query = $this->db->get();
        $like_results = $like_query->result_array();

        if (!empty($like_results)) {
            log_message('debug', 'Found ' . count($like_results) . ' matches via LIKE');
            
            $best_match = $this->_find_best_match($like_results, $clean_input);
            $this->_update_usage_count($best_match['id']);
            
            return [
                'found' => true,
                'answer' => $best_match['description'],
                'confidence' => $best_match['score'],
                'keyword' => $best_match['keyword'],
                'method' => 'like'
            ];
        }

        // METHOD 3: Keyword extraction
        $stopwords = [
            'apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 'bagaimana', 
            'dimana', 'kapan', 'siapa', 'dengan', 'ini', 'itu', 'dan', 'atau', 
            'tapi', 'pada', 'dalam', 'untuk', 'saya', 'anda', 'kami', 'mereka', 
            'bisa', 'dapat', 'akan', 'tolong', 'minta', 'cara', 'gimana'
        ];

        $words = explode(' ', $clean_input);
        $keywords = array_filter($words, function ($word) use ($stopwords) {
            return strlen($word) > 2 && !in_array($word, $stopwords);
        });

        if (!empty($keywords)) {
            log_message('debug', 'Extracted keywords: ' . implode(', ', $keywords));

            $this->db->select('id, keyword, description, tags, category, usage_count');
            $this->db->from('knowledge_base');
            $this->db->group_start();
            
            foreach ($keywords as $word) {
                $this->db->or_like('LOWER(keyword)', $word);
                $this->db->or_like('LOWER(tags)', $word);
                $this->db->or_like('LOWER(description)', $word);
            }
            
            $this->db->group_end();
            $this->db->order_by('usage_count DESC, id ASC');
            $this->db->limit(10);
            
            $keyword_query = $this->db->get();
            $keyword_results = $keyword_query->result_array();

            if (!empty($keyword_results)) {
                log_message('debug', 'Found ' . count($keyword_results) . ' matches via keywords');
                
                $best_match = $this->_find_best_match($keyword_results, $clean_input, $keywords);
                $this->_update_usage_count($best_match['id']);
                
                return [
                    'found' => true,
                    'answer' => $best_match['description'],
                    'confidence' => $best_match['score'],
                    'keyword' => $best_match['keyword'],
                    'method' => 'keyword'
                ];
            }
        }

        // METHOD 4: Fulltext search
        if (!empty($keywords)) {
            $search_terms = implode(' ', $keywords);
            $this->db->select('id, keyword, description, tags, category, usage_count');
            $this->db->from('knowledge_base');
            $this->db->where("MATCH(keyword, tags, description) AGAINST('" . $this->db->escape_str($search_terms) . "' IN NATURAL LANGUAGE MODE)");
            $this->db->order_by('usage_count DESC');
            $this->db->limit(5);
            
            $fulltext_query = $this->db->get();
            $fulltext_results = $fulltext_query->result_array();

            if (!empty($fulltext_results)) {
                log_message('debug', 'Found ' . count($fulltext_results) . ' matches via fulltext');
                
                $best_match = $fulltext_results[0];
                $this->_update_usage_count($best_match['id']);
                
                return [
                    'found' => true,
                    'answer' => $best_match['description'],
                    'confidence' => 60,
                    'keyword' => $best_match['keyword'],
                    'method' => 'fulltext'
                ];
            }
        }

        log_message('debug', 'No matches found for: ' . $input);
        return ['found' => false, 'answer' => ''];
    }

    /**
     * Find best match dengan scoring system
     * @param array $results Hasil pencarian
     * @param string $input Input user
     * @param array $keywords Keywords yang diekstrak
     * @return array Best match dengan score
     */
    private function _find_best_match($results, $input, $keywords = [])
    {
        if (empty($keywords)) {
            $keywords = explode(' ', $input);
        }

        $best_score = 0;
        $best_match = $results[0];

        foreach ($results as $row) {
            $score = 0;
            $keyword_lower = strtolower($row['keyword']);

            // Exact match di keyword (bonus besar)
            if ($keyword_lower === $input) {
                $score += 200;
            }

            // Keyword mengandung input
            if (strpos($keyword_lower, $input) !== false) {
                $score += 100;
            }

            // Input mengandung keyword
            if (strpos($input, $keyword_lower) !== false) {
                $score += 80;
            }

            // Partial match di keyword
            foreach ($keywords as $word) {
                if (strlen($word) > 2 && strpos($keyword_lower, $word) !== false) {
                    $score += 20;
                }
            }

            // Match di tags
            if (!empty($row['tags'])) {
                $tags_lower = strtolower($row['tags']);

                // Exact match di tags
                if (strpos($tags_lower, $input) !== false) {
                    $score += 50;
                }

                // Partial match di tags
                foreach ($keywords as $word) {
                    if (strlen($word) > 2 && strpos($tags_lower, $word) !== false) {
                        $score += 10;
                    }
                }
            }

            // Bonus untuk popularitas (usage count)
            $score += min($row['usage_count'] * 5, 50);

            // Penalty untuk keyword yang terlalu pendek
            if (strlen($row['keyword']) < 4) {
                $score -= 20;
            }

            log_message('debug', 'Score for "' . $row['keyword'] . '": ' . $score);

            if ($score > $best_score) {
                $best_score = $score;
                $best_match = $row;
                $best_match['score'] = $score;
            }
        }

        if (!isset($best_match['score'])) {
            $best_match['score'] = $best_score;
        }

        return $best_match;
    }

    /**
     * Update usage count untuk knowledge base
     * @param int $id ID knowledge base
     */
    private function _update_usage_count($id)
    {
        try {
            $this->db->set('usage_count', 'usage_count + 1', FALSE);
            $this->db->set('last_used', date('Y-m-d H:i:s'));
            $this->db->where('id', $id);
            $this->db->update('knowledge_base');
        } catch (Exception $e) {
            log_message('error', 'Failed to update usage count: ' . $e->getMessage());
        }
    }

    /**
     * Validate question
     * @param string $input Pertanyaan user
     * @return array Hasil validasi
     */
    public function validate_question($input)
    {
        $input = trim($input);

        if (strlen($input) == 0) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak boleh kosong. Silakan ketik pertanyaan Anda.'
            ];
        }

        if (strlen($input) < 3) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan terlalu pendek. Silakan berikan pertanyaan yang lebih jelas tentang FIK.'
            ];
        }

        // Cek apakah hanya angka atau karakter spesial
        if (preg_match('/^[0-9\s]+$/', $input)) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak valid. Silakan gunakan kalimat yang jelas tentang Fakultas Industri Kreatif.'
            ];
        }

        return [
            'valid' => true,
            'reason' => ''
        ];
    }

    /**
     * Save unanswered question dengan duplicate check
     * @param string $question Pertanyaan yang tidak terjawab
     * @param string|null $session_id Session ID user
     * @return int|bool ID pertanyaan atau false jika gagal
     */
    public function save_unanswered($question, $session_id = null)
    {
        try {
            $question = trim($question);

            // Cek duplikat dalam 7 hari terakhir
            $this->db->where('question LIKE', '%' . $this->db->escape_like_str($question) . '%');
            $this->db->where('status', 'pending');
            $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')));
            $existing = $this->db->get('unanswered_questions');

            if ($existing->num_rows() > 0) {
                log_message('debug', 'Duplicate unanswered question detected, using existing ID: ' . $existing->row()->id);
                return $existing->row()->id;
            }

            $data = [
                'question' => $question,
                'status' => 'pending',
                'source' => 'chat',
                'session_id' => $session_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('unanswered_questions', $data);
            $insert_id = $this->db->insert_id();

            log_message('info', 'Saved unanswered question ID: ' . $insert_id . ' - ' . substr($question, 0, 50));
            return $insert_id;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save unanswered: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get unanswered questions yang pending
     * @param int $limit Jumlah data yang diambil
     * @return array
     */
    public function get_unanswered_questions($limit = 50)
    {
        try {
            $this->db->select('*');
            $this->db->from('unanswered_questions');
            $this->db->where('status', 'pending');
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();

            return $query->result_array();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get unanswered: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get jumlah pertanyaan pending
     * @return int
     */
    public function get_pending_count()
    {
        try {
            $this->db->where('status', 'pending');
            return $this->db->count_all_results('unanswered_questions');
        } catch (Exception $e) {
            log_message('error', 'Failed to get pending count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get question by ID
     * @param int $id ID pertanyaan
     * @return array|null
     */
    public function get_question_by_id($id)
    {
        try {
            $this->db->where('id', $id);
            $query = $this->db->get('unanswered_questions');

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }

            return null;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get question by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mark question as answered
     * @param int $id ID pertanyaan
     * @return bool
     */
    public function mark_question_answered($id)
    {
        try {
            $data = [
                'status' => 'answered',
                'answered_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id', $id);
            $result = $this->db->update('unanswered_questions', $data);
            
            log_message('info', 'Question marked as answered: ' . $id);
            return $result;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to mark question answered: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Save to knowledge base
     * @param string $question Pertanyaan
     * @param string $answer Jawaban
     * @param string $category Kategori
     * @return bool
     */
    public function save_to_knowledge_base($question, $answer, $category = 'general')
    {
        try {
            $question = trim($question);
            $answer = trim($answer);

            // Cek duplikat
            $this->db->where('LOWER(keyword)', strtolower($question));
            $exists = $this->db->get('knowledge_base')->row();

            if ($exists) {
                log_message('info', 'Duplicate knowledge base entry prevented: ' . $question);
                return false;
            }

            $tags = $this->_extract_tags($question);

            $data = [
                'keyword' => $question,
                'description' => $answer,
                'tags' => implode(',', $tags),
                'category' => $category,
                'usage_count' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->db->insert('knowledge_base', $data);

            if ($result) {
                log_message('info', 'Added to knowledge base: ' . $question);
            }

            return $result;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save to knowledge base: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extract tags dari question
     * @param string $question Pertanyaan
     * @return array Tags yang diekstrak
     */
    private function _extract_tags($question)
    {
        $stopwords = [
            'apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 'bagaimana',
            'dimana', 'kapan', 'siapa', 'dengan', 'ini', 'itu', 'dan', 'atau',
            'tapi', 'pada', 'dalam', 'untuk', 'saya', 'anda', 'kami', 'mereka',
            'bisa', 'dapat', 'akan', 'tolong', 'minta', 'cara', 'gimana',
            'pakai', 'gunakan', 'tentang', 'mengenai', 'tanya', 'info'
        ];

        $words = preg_split('/\s+/', strtolower($question));
        $words = array_filter($words, function ($word) use ($stopwords) {
            $clean = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($clean) > 2 && !in_array($clean, $stopwords);
        });

        $unique_tags = array_unique(array_values($words));
        return array_slice($unique_tags, 0, 7);
    }

    /**
     * Get all knowledge base data
     * @return array
     */
    public function get_all_knowledge()
    {
        try {
            $this->db->order_by('usage_count DESC, keyword ASC');
            $query = $this->db->get('knowledge_base');
            return $query->result_array();
        } catch (Exception $e) {
            log_message('error', 'Failed to get all knowledge: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Count knowledge base entries
     * @return int
     */
    public function count_knowledge()
    {
        try {
            return $this->db->count_all('knowledge_base');
        } catch (Exception $e) {
            log_message('error', 'Failed to count knowledge: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get popular questions
     * @param int $limit Jumlah data
     * @return array
     */
    public function get_popular_questions($limit = 5)
    {
        try {
            $this->db->select('keyword, description, usage_count, last_used');
            $this->db->from('knowledge_base');
            $this->db->where('usage_count >', 0);
            $this->db->order_by('usage_count DESC, last_used DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            return $query->result_array();
        } catch (Exception $e) {
            log_message('error', 'Failed to get popular questions: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Test search untuk debugging
     * @param string $keyword Keyword pencarian
     * @return array
     */
    public function test_search($keyword)
    {
        try {
            $clean = $this->db->escape_like_str($keyword);

            $sql = "SELECT * FROM knowledge_base 
                    WHERE LOWER(keyword) LIKE LOWER('%{$clean}%') 
                    OR LOWER(tags) LIKE LOWER('%{$clean}%')
                    OR LOWER(description) LIKE LOWER('%{$clean}%')
                    ORDER BY 
                        CASE 
                            WHEN LOWER(keyword) = LOWER('{$clean}') THEN 1
                            WHEN LOWER(keyword) LIKE LOWER('{$clean}%') THEN 2
                            WHEN LOWER(keyword) LIKE LOWER('%{$clean}%') THEN 3
                            ELSE 4
                        END,
                        usage_count DESC
                    LIMIT 10";

            $query = $this->db->query($sql);
            return $query->result_array();
            
        } catch (Exception $e) {
            log_message('error', 'Test search failed: ' . $e->getMessage());
            return [];
        }
    }



    // ==================== PRESTASI FUNCTIONS ====================

    /**
     * Mendapatkan data prestasi mahasiswa
     * @param int $limit Jumlah data
     * @return array
     */
    public function get_prestasi_mahasiswa($limit = 10)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return [];
            }

            $this->db->select('
                prestasi_mahasiswa.*,
                mahasiswa.nama as nama_mahasiswa,
                mahasiswa.nim,
                mahasiswa.program_studi,
                mahasiswa.angkatan
            ');
            $this->db->from('prestasi_mahasiswa');
            $this->db->join('mahasiswa', 'mahasiswa.id = prestasi_mahasiswa.mahasiswa_id', 'left');
            $this->db->order_by('prestasi_mahasiswa.tanggal_prestasi', 'DESC');
            $this->db->order_by('prestasi_mahasiswa.created_at', 'DESC');

            if ($limit > 0) {
                $this->db->limit($limit);
            }

            $query = $this->db->get();
            return $query->result();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get prestasi: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan statistik prestasi per prodi
     * @return array
     */
    public function get_statistik_prestasi()
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return [];
            }

            $this->db->select('
                mahasiswa.program_studi,
                COUNT(prestasi_mahasiswa.id) as jumlah_prestasi,
                SUM(CASE WHEN prestasi_mahasiswa.tingkat = "Internasional" THEN 1 ELSE 0 END) as internasional,
                SUM(CASE WHEN prestasi_mahasiswa.tingkat = "Nasional" THEN 1 ELSE 0 END) as nasional,
                SUM(CASE WHEN prestasi_mahasiswa.tingkat = "Regional" THEN 1 ELSE 0 END) as regional,
                SUM(CASE WHEN prestasi_mahasiswa.tingkat = "Lokal" THEN 1 ELSE 0 END) as lokal
            ');
            $this->db->from('prestasi_mahasiswa');
            $this->db->join('mahasiswa', 'mahasiswa.id = prestasi_mahasiswa.mahasiswa_id');
            $this->db->group_by('mahasiswa.program_studi');
            $this->db->order_by('jumlah_prestasi', 'DESC');

            return $this->db->get()->result();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get statistik prestasi: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan prestasi terbaru
     * @param int $limit Jumlah data
     * @return array
     */
    public function get_prestasi_terbaru($limit = 5)
    {
        return $this->get_prestasi_mahasiswa($limit);
    }

    /**
     * Menghitung total prestasi
     * @return int
     */
    public function count_prestasi()
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return 0;
            }
            return $this->db->count_all('prestasi_mahasiswa');
        } catch (Exception $e) {
            log_message('error', 'Failed to count prestasi: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Mendapatkan detail prestasi berdasarkan ID
     * @param int $id ID Prestasi
     * @return object|null
     */
    public function get_prestasi_by_id($id)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return null;
            }

            $this->db->select('
                prestasi_mahasiswa.*,
                mahasiswa.nama as nama_mahasiswa,
                mahasiswa.nim,
                mahasiswa.program_studi,
                mahasiswa.angkatan
            ');
            $this->db->from('prestasi_mahasiswa');
            $this->db->join('mahasiswa', 'mahasiswa.id = prestasi_mahasiswa.mahasiswa_id', 'left');
            $this->db->where('prestasi_mahasiswa.id', $id);

            $query = $this->db->get();
            return $query->row();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get prestasi by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Menambahkan prestasi baru
     * @param array $data Data prestasi
     * @return int|bool
     */
    public function insert_prestasi($data)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return false;
            }

            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('prestasi_mahasiswa', $data);
            return $this->db->insert_id();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to insert prestasi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengupdate data prestasi
     * @param int $id ID Prestasi
     * @param array $data Data yang diupdate
     * @return bool
     */
    public function update_prestasi($id, $data)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return false;
            }

            $data['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            return $this->db->update('prestasi_mahasiswa', $data);
            
        } catch (Exception $e) {
            log_message('error', 'Failed to update prestasi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Menghapus data prestasi
     * @param int $id ID Prestasi
     * @return bool
     */
    public function delete_prestasi($id)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return false;
            }

            $this->db->where('id', $id);
            return $this->db->delete('prestasi_mahasiswa');
            
        } catch (Exception $e) {
            log_message('error', 'Failed to delete prestasi: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mendapatkan prestasi berdasarkan mahasiswa
     * @param int $mahasiswa_id ID Mahasiswa
     * @return array
     */
    public function get_prestasi_by_mahasiswa($mahasiswa_id)
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return [];
            }

            $this->db->where('mahasiswa_id', $mahasiswa_id);
            $this->db->order_by('tanggal_prestasi', 'DESC');
            $query = $this->db->get('prestasi_mahasiswa');

            return $query->result();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get prestasi by mahasiswa: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan statistik prestasi per tingkat
     * @return array
     */
    public function get_statistik_per_tingkat()
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return [];
            }

            $this->db->select('tingkat, COUNT(*) as jumlah');
            $this->db->from('prestasi_mahasiswa');
            $this->db->group_by('tingkat');
            $this->db->order_by('FIELD(tingkat, "Internasional", "Nasional", "Regional", "Lokal")');

            return $this->db->get()->result();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get statistik per tingkat: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan top mahasiswa dengan prestasi terbanyak
     * @return array
     */
    public function get_top_mahasiswa_prestasi()
    {
        try {
            if (!$this->db->table_exists('prestasi_mahasiswa')) {
                return [];
            }

            $this->db->select('
                mahasiswa.id,
                mahasiswa.nama,
                mahasiswa.nim,
                mahasiswa.program_studi,
                COUNT(prestasi_mahasiswa.id) as total_prestasi
            ');
            $this->db->from('prestasi_mahasiswa');
            $this->db->join('mahasiswa', 'mahasiswa.id = prestasi_mahasiswa.mahasiswa_id');
            $this->db->group_by('mahasiswa.id');
            $this->db->order_by('total_prestasi', 'DESC');
            $this->db->limit(5);

            return $this->db->get()->result();
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get top mahasiswa prestasi: ' . $e->getMessage());
            return [];
        }
    }

    // ==================== PROFILE FUNCTIONS ====================

    /**
     * Mendapatkan informasi kontak
     * @return object
     */
    public function get_kontak_info()
    {
        $data = new stdClass();
        $data->alamat = "Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung, Jawa Barat 40257";
        $data->telepon = "(022) 7565923 ext. 123";
        $data->email = "fik@telkomuniversity.ac.id";
        $data->website = "https://fik.telkomuniversity.ac.id";
        $data->instagram = "@fik.telkomuniversity";
        $data->youtube = "FIK Telkom University";
        return $data;
    }

    /**
     * Mendapatkan sejarah FIK
     * @return object
     */
    public function get_sejarah_fik()
    {
        $data = new stdClass();
        $data->konten = "Fakultas Industri Kreatif (FIK) Telkom University didirikan pada tahun 2013 sebagai bagian dari pengembangan Telkom University. FIK hadir untuk menjawab kebutuhan industri kreatif yang berkembang pesat di Indonesia. Dengan menggabungkan seni, desain, dan teknologi, FIK menjadi pusat pendidikan kreatif terkemuka di Indonesia.";
        $data->tahun_berdiri = 2013;
        $data->dasar_hukum = "SK Pendirian No. 123/SK/2013";
        return $data;
    }

    /**
     * Mendapatkan visi misi
     * @return object
     */
    public function get_visi_misi()
    {
        $data = new stdClass();
        $data->visi = "Menjadi fakultas industri kreatif terkemuka yang menghasilkan lulusan berdaya saing global, berjiwa wirausaha, dan mampu berkontribusi pada pengembangan industri kreatif nasional.";
        $data->misi = [
            "Menyelenggarakan pendidikan berkualitas di bidang industri kreatif yang berorientasi pada kebutuhan industri global.",
            "Melaksanakan penelitian dan pengembangan di bidang seni, desain, dan media kreatif yang inovatif.",
            "Melakukan pengabdian kepada masyarakat melalui penerapan ilmu pengetahuan dan teknologi di bidang industri kreatif.",
            "Membangun jejaring kerjasama dengan industri kreatif nasional dan internasional.",
            "Mengembangkan jiwa kewirausahaan kreatif pada mahasiswa dan lulusan."
        ];
        return $data;
    }


    /**
     * Mendapatkan kalender akademik
     * @return array
     */
    public function get_kalender_akademik()
    {
        try {
            if ($this->db->table_exists('kalender_akademik')) {
                $this->db->order_by('tanggal_mulai', 'ASC');
                $this->db->where('tahun_akademik', date('Y') . '/' . (date('Y') + 1));
                $query = $this->db->get('kalender_akademik');
                return $query->result();
            }
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get kalender akademik: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan layanan akademik
     * @return array
     */
    public function get_layanan_akademik()
    {
        $layanan = [
            (object)[
                'nama' => 'Registrasi Mahasiswa Baru',
                'deskripsi' => 'Layanan pendaftaran dan registrasi mahasiswa baru',
                'jam_layanan' => 'Senin-Jumat, 08.00-16.00'
            ],
            (object)[
                'nama' => 'Pengisian KRS',
                'deskripsi' => 'Layanan pengisian Kartu Rencana Studi setiap semester',
                'jam_layanan' => 'Online 24 jam'
            ],
            (object)[
                'nama' => 'Cetak Transkrip',
                'deskripsi' => 'Layanan pencetakan transkrip nilai',
                'jam_layanan' => 'Senin-Jumat, 08.00-15.00'
            ]
        ];
        return $layanan;
    }

    /**
     * Mendapatkan layanan kemahasiswaan
     * @return array
     */
    public function get_layanan_kemahasiswaan()
    {
        $layanan = [
            (object)[
                'nama' => 'Beasiswa',
                'deskripsi' => 'Informasi dan pendaftaran beasiswa',
                'kontak' => 'kemahasiswaan@fik.telkomuniversity.ac.id'
            ],
            (object)[
                'nama' => 'Kegiatan Mahasiswa',
                'deskripsi' => 'Informasi UKM dan organisasi mahasiswa',
                'kontak' => 'ormawa@fik.telkomuniversity.ac.id'
            ],
            (object)[
                'nama' => 'Konseling',
                'deskripsi' => 'Layanan konseling untuk mahasiswa',
                'kontak' => 'konseling@fik.telkomuniversity.ac.id'
            ]
        ];
        return $layanan;
    }

    /**
     * Mendapatkan penelitian terbaru
     * @return array
     */
    public function get_penelitian_terbaru()
    {
        try {
            if ($this->db->table_exists('penelitian')) {
                $this->db->order_by('tahun', 'DESC');
                $this->db->limit(5);
                $query = $this->db->get('penelitian');
                return $query->result();
            }
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get penelitian: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan publikasi ilmiah
     * @return array
     */
    public function get_publikasi_ilmiah()
    {
        try {
            if ($this->db->table_exists('publikasi')) {
                $this->db->order_by('tahun', 'DESC');
                $this->db->limit(5);
                $query = $this->db->get('publikasi');
                return $query->result();
            }
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get publikasi: ' . $e->getMessage());
            return [];
        }
    }

    // ==================== USER FUNCTIONS ====================

    /**
     * Cek login user
     * @param string $username Username
     * @param string $password Password (sudah di MD5)
     * @return object|null
     */
    public function cek_login($username, $password)
    {
        try {
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            $this->db->where('status', 'aktif');
            $query = $this->db->get('users');
            
            if ($query->num_rows() > 0) {
                return $query->row();
            }
            return null;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to check login: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mendapatkan data user
     * @param int $user_id ID User
     * @return object|null
     */
    public function get_user_data($user_id)
    {
        try {
            $this->db->where('id', $user_id);
            $query = $this->db->get('users');
            
            if ($query->num_rows() > 0) {
                return $query->row();
            }
            return null;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get user data: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Pencarian global
     * @param string $keyword Keyword pencarian
     * @return array
     */
    public function search_all($keyword)
    {
        $result = [];

        try {
            // Cari di mahasiswa
            if ($this->db->table_exists('mahasiswa')) {
                $this->db->like('nama', $keyword);
                $this->db->or_like('nim', $keyword);
                $this->db->or_like('program_studi', $keyword);
                $mahasiswa = $this->db->get('mahasiswa')->result();
                $result = array_merge($result, $mahasiswa);
            }

            // Cari di dosen
            if ($this->db->table_exists('dosen')) {
                $this->db->like('nama', $keyword);
                $this->db->or_like('nidn', $keyword);
                $this->db->or_like('program_studi', $keyword);
                $dosen = $this->db->get('dosen')->result();
                $result = array_merge($result, $dosen);
            }

            // Cari di knowledge base
            if ($this->db->table_exists('knowledge_base')) {
                $this->db->like('keyword', $keyword);
                $this->db->or_like('tags', $keyword);
                $this->db->or_like('description', $keyword);
                $knowledge = $this->db->get('knowledge_base')->result();
                $result = array_merge($result, $knowledge);
            }

            return $result;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to search all: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Simpan pesan kontak
     * @param array $data Data pesan
     * @return bool
     */
    public function simpan_pesan($data)
    {
        try {
            if (!$this->db->table_exists('kontak_masuk')) {
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `kontak_masuk` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `nama` VARCHAR(100) NOT NULL,
                        `email` VARCHAR(100) NOT NULL,
                        `telepon` VARCHAR(20) NULL,
                        `pesan` TEXT NOT NULL,
                        `status` ENUM('baru','dibaca','dibalas') DEFAULT 'baru',
                        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
                ");
            }

            return $this->db->insert('kontak_masuk', $data);
            
        } catch (Exception $e) {
            log_message('error', 'Failed to save kontak: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check AI engine health
     * @return bool
     */
    public function check_ai_engine_health()
    {
        try {
            $health_url = 'http://localhost:5000/health';

            $ch = curl_init($health_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return $http_code == 200;
            
        } catch (Exception $e) {
            log_message('error', 'AI Engine health check failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enhance answer with AI
     * @param string $question Pertanyaan
     * @param string $base_answer Jawaban dasar
     * @return array
     */
    public function enhance_answer_with_ai($question, $base_answer)
    {
        try {
            $api_url = 'http://localhost:5000/generate';

            $payload = [
                'question' => $question,
                'base_answer' => $base_answer
            ];

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http_code == 200 && $response) {
                $result = json_decode($response, true);

                if ($result && isset($result['status']) && $result['status'] == 'success' && !empty($result['enhanced_answer'])) {
                    log_message('debug', 'AI enhancement successful');
                    return [
                        'success' => true,
                        'answer' => $result['enhanced_answer']
                    ];
                }
            }

            log_message('debug', 'AI enhancement failed, using base answer');
            return [
                'success' => false,
                'answer' => $base_answer
            ];
            
        } catch (Exception $e) {
            log_message('error', 'AI enhancement error: ' . $e->getMessage());
            return [
                'success' => false,
                'answer' => $base_answer
            ];
        }
    }
}