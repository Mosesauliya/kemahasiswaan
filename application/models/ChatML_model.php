<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChatML_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        
        // Force database reconnection
        if (!isset($this->db) || !$this->db->conn_id) {
            $this->load->database();
        }
        
        // Check connection
        if (!$this->db->conn_id) {
            log_message('error', 'Database connection failed in ChatML_model');
            throw new Exception('Database connection failed');
        }
        
        log_message('debug', 'ChatML_model loaded, database connected');
        
        // Update database schema for edit features
        $this->update_database_schema();
    }

    /**
     * Update database schema untuk fitur edit - FIXED
     */
    public function update_database_schema() {
        try {
            log_message('debug', 'Checking database schema for edit features');
            
            // Cek tabel _logs
            if ($this->db->table_exists('_logs')) {
                $columns = $this->db->list_fields('_logs');
                $columns = array_map('strtolower', $columns);
                
                // Tambahkan kolom is_edited jika belum ada
                if (!in_array('is_edited', $columns)) {
                    $this->db->query("ALTER TABLE `_logs` ADD COLUMN `is_edited` TINYINT(1) DEFAULT 0");
                    log_message('debug', 'Added column is_edited to _logs table');
                }
                
                // Tambahkan kolom edited_at jika belum ada
                if (!in_array('edited_at', $columns)) {
                    $this->db->query("ALTER TABLE `_logs` ADD COLUMN `edited_at` DATETIME NULL");
                    log_message('debug', 'Added column edited_at to _logs table');
                }
                
                // Tambahkan kolom original_message_id jika belum ada
                if (!in_array('original_message_id', $columns)) {
                    $this->db->query("ALTER TABLE `_logs` ADD COLUMN `original_message_id` INT(11) NULL");
                    log_message('debug', 'Added column original_message_id to _logs table');
                }
            } else {
                // Create table if not exists (should exist, but just in case)
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `_logs` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `user_request` TEXT NOT NULL,
                        `ai_response` TEXT NOT NULL,
                        `feedback` VARCHAR(50) DEFAULT 'Ignored',
                        `is_edited` TINYINT(1) DEFAULT 0,
                        `edited_at` DATETIME NULL,
                        `original_message_id` INT(11) NULL,
                        `createdAt` DATETIME NOT NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('debug', 'Created _logs table with edit features');
            }
            
            // Cek tabel copy_logs jika belum ada
            if (!$this->db->table_exists('copy_logs')) {
                // Buat tabel
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `copy_logs` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `message_id` INT(11) NULL,
                        `text_type` VARCHAR(20) DEFAULT 'unknown',
                        `text_preview` VARCHAR(200) NULL,
                        `text_length` INT(11) DEFAULT 0,
                        `copied_at` DATETIME NULL,
                        `user_ip` VARCHAR(45) NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('debug', 'Created copy_logs table');
            }
            
            // Check if deleted_questions_log exists
            if (!$this->db->table_exists('deleted_questions_log')) {
                $this->db->query("
                    CREATE TABLE IF NOT EXISTS `deleted_questions_log` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `question_id` INT(11) NULL,
                        `question_text` TEXT NULL,
                        `deleted_at` DATETIME NULL,
                        `deleted_by` VARCHAR(50) DEFAULT 'admin',
                        `reason` TEXT NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
                log_message('debug', 'Created deleted_questions_log table');
            }
            
            log_message('debug', 'Database schema update completed successfully');
            return true;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to update database schema: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Validasi pertanyaan - IMPROVED
     */
    public function validate_question($input)
    {
        $input_trimmed = trim($input);
        
        log_message('debug', 'Validating question: ' . substr($input_trimmed, 0, 50));

        // 1. Cek apakah input hanya whitespace
        if (strlen(trim($input_trimmed)) === 0) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak boleh kosong. Silakan tulis pertanyaan Anda.'
            ];
        }

        // 2. Cek apakah hanya karakter acak/tidak bermakna
        $char_count = count_chars($input_trimmed, 1);
        if (!empty($char_count)) {
            $total_chars = strlen($input_trimmed);
            foreach ($char_count as $char => $count) {
                if ($count / $total_chars > 0.7 && ctype_alpha(chr($char))) {
                    return [
                        'valid' => false,
                        'reason' => 'Pertanyaan tidak jelas. Mohon berikan pertanyaan yang lebih spesifik.'
                    ];
                }
            }
        }

        // 3. Cek apakah ada kata bermakna
        $stopwords = [
            'apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'ada',
            'berapa', 'dimana', 'kapan', 'siapa', 'siapakah', 'bagaimana', 'tentang', 'mengenai',
            'seputar', 'terkait', 'banyak', 'saja', 'itu', 'ini', 'tersebut', 'cara',
            'jelaskan', 'tolong', 'dong', 'ya', 'kah', 'lah', 'kan', 'yah', 'gimana',
            'atau', 'apakah', 'dan'
        ];

        $words = preg_split('/\s+/', strtolower($input_trimmed));
        $words = array_filter($words, function ($word) {
            $word = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($word) > 0;
        });

        $meaningful_words = array_filter($words, function ($word) use ($stopwords) {
            $word = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($word) > 1 && !in_array($word, $stopwords);
        });

        // Untuk input sangat pendek (2-4 karakter), lebih toleran
        if (strlen($input_trimmed) <= 4) {
            $clean_text = preg_replace('/[^a-zA-Z0-9]/', '', $input_trimmed);
            if (strlen($clean_text) >= 2) {
                return [
                    'valid' => true,
                    'reason' => ''
                ];
            }
        }

        // Untuk input normal
        if (count($meaningful_words) == 0) {
            if (strlen($input_trimmed) < 10) {
                return [
                    'valid' => true,
                    'reason' => ''
                ];
            }
            
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak mengandung kata kunci yang jelas. Mohon berikan pertanyaan yang lebih spesifik tentang FIK.'
            ];
        }

        // 4. Cek apakah pertanyaan hanya tanda tanya atau karakter khusus
        $clean_text = preg_replace('/[^a-zA-Z0-9\s]/', '', $input_trimmed);
        if (strlen(trim($clean_text)) < 2 && strlen($input_trimmed) > 3) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak valid. Silakan gunakan kata-kata yang jelas.'
            ];
        }

        // 5. Deteksi pengulangan pola
        if (preg_match('/(.{2,3})\1{2,}/', strtolower($input_trimmed))) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak jelas. Mohon berikan pertanyaan yang lebih bermakna.'
            ];
        }

        // 6. Cek apakah hanya angka
        if (ctype_digit(str_replace(' ', '', $input_trimmed))) {
            return [
                'valid' => false,
                'reason' => 'Pertanyaan tidak valid. Silakan gunakan kalimat yang jelas.'
            ];
        }

        return [
            'valid' => true,
            'reason' => ''
        ];
    }

    /**
     * Search answer in database - IMPROVED
     */
    public function search_answer($input)
    {
        $input = strtolower(trim($input));
        log_message('debug', 'Searching answer for: ' . substr($input, 0, 50));

        // Cari di semua kategori knowledge_base
        $this->db->select('keyword, description, tags, category');
        $this->db->from('knowledge_base');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {
            log_message('debug', 'No knowledge base entries found');
            return ['found' => false, 'answer' => ''];
        }

        $knowledge_data = $query->result_array();
        log_message('debug', 'Found ' . count($knowledge_data) . ' knowledge base entries');

        // Extract kata kunci dari input
        $stopwords = [
            'apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'ada',
            'berapa', 'dimana', 'kapan', 'siapa', 'siapakah', 'bagaimana', 'tentang', 'mengenai',
            'seputar', 'terkait', 'banyak', 'saja', 'itu', 'ini', 'tersebut', 'cara',
            'jelaskan', 'tolong', 'dong', 'ya', 'kah', 'lah', 'kan', 'yah', 'gimana',
            'atau', 'apakah'
        ];

        $input_words = explode(' ', $input);
        $meaningful_words = array_filter($input_words, function ($word) use ($stopwords) {
            $clean_word = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($clean_word) > 1 && !in_array($clean_word, $stopwords);
        });

        // Re-index array
        $meaningful_words = array_values($meaningful_words);

        // Untuk input pendek, gunakan semua kata
        if (count($meaningful_words) == 0 && strlen($input) < 10) {
            $meaningful_words = array_filter($input_words, function ($word) {
                return strlen($word) > 0;
            });
            $meaningful_words = array_values($meaningful_words);
        }

        // Jika masih tidak ada kata bermakna, coba cari dengan input asli
        if (count($meaningful_words) == 0) {
            $meaningful_words = [$input];
        }

        log_message('debug', 'Meaningful words: ' . implode(', ', $meaningful_words));

        // Cari kecocokan terbaik dengan scoring
        $best_match = null;
        $highest_score = 0;

        foreach ($knowledge_data as $data) {
            $score = 0;
            $keyword_lower = strtolower($data['keyword']);
            $desc_lower = strtolower($data['description']);
            $tags_lower = strtolower($data['tags']);

            // Gabungkan keyword + tags untuk matching
            $all_searchable = $keyword_lower . ' ' . $tags_lower;

            // 1. EXACT MATCH di keyword (score tertinggi)
            if ($keyword_lower === $input) {
                $score += 100;
                log_message('debug', 'Exact match found: ' . $keyword_lower);
            }

            // 2. Multi-word matching
            $keyword_words = explode(' ', $keyword_lower);
            $all_searchable_words = explode(' ', str_replace(',', ' ', $all_searchable));
            $all_searchable_words = array_map('trim', $all_searchable_words);

            $matched_meaningful_words = 0;
            $matched_words_list = [];

            foreach ($meaningful_words as $word) {
                $found_in_keyword = false;
                $found_in_tags = false;

                // Check di keyword
                foreach ($keyword_words as $kw) {
                    if ($kw === $word || stripos($kw, $word) !== false || stripos($word, $kw) !== false) {
                        $found_in_keyword = true;
                        break;
                    }
                }

                // Check di tags
                if (!$found_in_keyword && !empty($data['tags'])) {
                    $tags = array_map('trim', explode(',', $tags_lower));
                    foreach ($tags as $tag) {
                        if ($tag === $word || stripos($tag, $word) !== false || stripos($word, $tag) !== false) {
                            $found_in_tags = true;
                            break;
                        }
                    }
                }

                if ($found_in_keyword) {
                    $matched_meaningful_words++;
                    $matched_words_list[] = $word;
                    $score += 10;
                } elseif ($found_in_tags) {
                    $matched_meaningful_words++;
                    $matched_words_list[] = $word;
                    $score += 5;
                }
            }

            // Threshold untuk matching
            $required_match_count = 1;
            if (count($meaningful_words) > 1) {
                $required_match_count = ceil(count($meaningful_words) * 0.4);
            }

            if ($matched_meaningful_words < $required_match_count) {
                continue;
            }

            // 3. Bonus untuk match ratio
            if (count($meaningful_words) > 0) {
                $match_ratio = $matched_meaningful_words / count($meaningful_words);
                $score += $match_ratio * 20;

                if ($matched_meaningful_words == count($meaningful_words)) {
                    $score += 15;
                }
            }

            // 4. Phrase matching
            if (stripos($keyword_lower, $input) !== false || stripos($input, $keyword_lower) !== false) {
                $score += 15;
            }

            // 5. Similarity scoring
            $similarity = $this->calculate_similarity($input, $keyword_lower);
            if ($similarity > 50) {
                $score += ($similarity / 10);
            }

            // Track best match
            if ($score > $highest_score) {
                $highest_score = $score;
                $best_match = $data;
                $best_match['score'] = $score;
                $best_match['matched_words'] = $matched_meaningful_words;
                $best_match['total_meaningful'] = count($meaningful_words);
                $best_match['matched_list'] = $matched_words_list;
            }
        }

        // Threshold score
        if ($best_match && $highest_score >= 10) {
            log_message('debug', 'Best match found with score: ' . $highest_score);
            return [
                'found' => true,
                'answer' => $best_match['description'],
                'confidence' => $highest_score,
                'matched_words' => $best_match['matched_words'],
                'total_words' => $best_match['total_meaningful'],
                'category' => $best_match['category'] ?? 'general'
            ];
        }

        log_message('debug', 'No suitable match found (highest score: ' . $highest_score . ')');
        return ['found' => false, 'answer' => '', 'confidence' => 0];
    }

    /**
     * Calculate string similarity
     */
    private function calculate_similarity($str1, $str2) {
        $str1 = strtolower($str1);
        $str2 = strtolower($str2);

        similar_text($str1, $str2, $percent);
        return $percent;
    }

    /**
     * Save log dengan fitur edit - FIXED
     */
    public function save_log($user_request, $ai_response, $is_edited = 0, $original_message_id = null) {
        log_message('debug', 'Saving log - Edited: ' . $is_edited . ' - Original ID: ' . $original_message_id);
        
        $data = array(
            'user_request' => $user_request,
            'ai_response' => $ai_response,
            'feedback' => 'Ignored',
            'is_edited' => $is_edited,
            'createdAt' => date('Y-m-d H:i:s')
        );
        
        if ($is_edited) {
            $data['edited_at'] = date('Y-m-d H:i:s');
        }
        
        if ($original_message_id) {
            $data['original_message_id'] = $original_message_id;
        }

        $this->db->insert('_logs', $data);
        $insert_id = $this->db->insert_id();

        log_message('debug', 'Log saved with ID: ' . $insert_id . 
                   ' - Original ID: ' . $original_message_id . 
                   ' - Is Edited: ' . $is_edited);
        
        return $insert_id;
    }

    /**
     * Save feedback
     */
    public function save_feedback($message_id, $feedback) {
        $data = array(
            'feedback' => $feedback
        );

        $this->db->where('id', $message_id);
        $result = $this->db->update('_logs', $data);
        
        log_message('debug', 'Feedback saved for message ' . $message_id . ': ' . $feedback);
        
        return $result;
    }
    
    /**
     * Enhance answer with AI
     */
    public function enhance_answer_with_ai($question, $base_answer) {
        $api_url = 'http://localhost:5000/generate';
        
        $payload = array(
            'question' => $question,
            'base_answer' => $base_answer,
            'context' => array(
                'timestamp' => date('Y-m-d H:i:s'),
            )
        );
        
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($payload))
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        if ($http_code == 200 && $response) {
            $result = json_decode($response, true);
            
            if ($result && isset($result['status']) && $result['status'] == 'success') {
                log_message('debug', 'AI enhancement successful');
                return array(
                    'success' => true,
                    'answer' => $result['enhanced_answer'],
                    'complexity' => $result['complexity_level'] ?? 'medium',
                    'keywords' => $result['keywords'] ?? array()
                );
            }
        }
        
        log_message('debug', 'AI enhancement failed, using base answer');
        return array(
            'success' => false,
            'answer' => $base_answer,
            'complexity' => 'basic',
            'error' => $curl_error ?: 'AI Engine not responding'
        );
    }

    /**
     * Check AI engine health
     */
    public function check_ai_engine_health() {
        $health_url = 'http://localhost:5000/health';
        
        $ch = curl_init($health_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $is_healthy = $http_code == 200;
        log_message('debug', 'AI Engine health check: ' . ($is_healthy ? 'healthy' : 'unhealthy'));
        
        return $is_healthy;
    }

    // ==================== UNANSWERED QUESTIONS FUNCTIONS ====================

    /**
     * Save unanswered question
     */
    public function save_unanswered($question) {
        try {
            log_message('debug', 'Attempting to save unanswered question: ' . substr($question, 0, 50));
            
            // Cek apakah pertanyaan serupa sudah ada dalam 24 jam terakhir
            $this->db->where('question LIKE', '%' . $question . '%');
            $this->db->where('status', 'pending');
            $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-24 hours')));
            $existing = $this->db->get('unanswered_questions');
            
            if ($existing->num_rows() > 0) {
                log_message('debug', 'Similar question exists, returning existing ID');
                $existing_data = $existing->row_array();
                return $existing_data['id'];
            }
            
            $data = array(
                'question' => $question,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->db->insert('unanswered_questions', $data);
            
            if ($result) {
                $insert_id = $this->db->insert_id();
                log_message('info', 'Saved unanswered question to database, ID: ' . $insert_id . ' - Question: ' . substr($question, 0, 50));
                return $insert_id;
            } else {
                log_message('error', 'Failed to insert unanswered question');
                return false;
            }
        } catch (Exception $e) {
            log_message('error', 'Failed to save unanswered question: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get unanswered questions
     */
    public function get_unanswered_questions() {
        try {
            log_message('debug', 'Getting unanswered questions from database');
            
            $this->db->select('*');
            $this->db->from('unanswered_questions');
            $this->db->where('status', 'pending');
            $this->db->order_by('created_at', 'DESC');
            $query = $this->db->get();
            
            $num_rows = $query->num_rows();
            log_message('debug', 'Unanswered questions count: ' . $num_rows);
            
            if ($num_rows > 0) {
                $results = $query->result_array();
                return $results;
            }
            
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get unanswered questions: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get next unanswered question
     */
    public function get_next_unanswered_question() {
        try {
            $this->db->select('*');
            $this->db->from('unanswered_questions');
            $this->db->where('status', 'pending');
            $this->db->order_by('created_at', 'ASC');
            $this->db->limit(1);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return null;
        } catch (Exception $e) {
            log_message('error', 'Failed to get next unanswered question: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Mark question as answered
     */
    public function mark_question_answered($question_id) {
        try {
            $data = array(
                'status' => 'answered',
                'answered_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->where('id', $question_id);
            $result = $this->db->update('unanswered_questions', $data);
            
            log_message('debug', 'Marked question as answered, ID: ' . $question_id . ', Result: ' . ($result ? 'success' : 'failed'));
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Failed to mark question as answered: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get question by ID
     */
    public function get_question_by_id($question_id) {
        try {
            $this->db->select('*');
            $this->db->from('unanswered_questions');
            $this->db->where('id', $question_id);
            $query = $this->db->get();
            
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
     * Save to knowledge base
     */
    public function save_to_knowledge_base($question, $answer, $category = 'general') {
        try {
            // Generate tags dari pertanyaan
            $tags = $this->extract_tags($question);
            
            $data = array(
                'keyword' => $question,
                'description' => $answer,
                'tags' => implode(',', $tags),
                'category' => $category,
                'created_at' => date('Y-m-d H:i:s')
            );
            
            $result = $this->db->insert('knowledge_base', $data);
            
            if ($result) {
                log_message('info', 'Saved to knowledge base, Category: ' . $category);
            }
            
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Failed to save to knowledge base: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extract tags from question
     */
    private function extract_tags($question) {
        $stopwords = [
            'apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 'dengan', 'pada', 'ada',
            'berapa', 'dimana', 'kapan', 'siapa', 'bagaimana', 'tentang', 'mengenai',
            'seputar', 'terkait', 'banyak', 'saja', 'itu', 'ini', 'tersebut', 'cara',
            'jelaskan', 'tolong', 'dong', 'ya', 'kah', 'lah', 'kan', 'yah', 'gimana',
            'atau', 'apakah', 'dan'
        ];
        
        $words = preg_split('/\s+/', strtolower($question));
        $words = array_filter($words, function($word) use ($stopwords) {
            $clean_word = preg_replace('/[^a-z0-9]/', '', $word);
            return strlen($clean_word) > 2 && !in_array($clean_word, $stopwords);
        });
        
        // Ambil maksimal 5 kata terbaik
        $words = array_slice(array_values($words), 0, 5);
        
        return $words;
    }

    /**
     * Get pending count
     */
    public function get_pending_count() {
        try {
            $this->db->where('status', 'pending');
            $this->db->from('unanswered_questions');
            $count = $this->db->count_all_results();
            log_message('debug', 'Pending count: ' . $count);
            return $count;
        } catch (Exception $e) {
            log_message('error', 'Failed to get pending count: ' . $e->getMessage());
            return 0;
        }
    }

    // ==================== DELETE QUESTIONS FUNCTIONS ====================

    /**
     * Delete question
     */
    public function delete_question($question_id, $reason = '') {
        try {
            // Ambil data pertanyaan sebelum dihapus untuk log
            $question_data = $this->get_question_by_id($question_id);
            
            if (!$question_data) {
                log_message('error', 'Question not found for deletion: ID ' . $question_id);
                return false;
            }
            
            // Simpan ke log penghapusan
            $log_data = [
                'question_id' => $question_id,
                'question_text' => $question_data['question'] ?? '',
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => 'admin',
                'reason' => $reason
            ];
            
            $this->db->insert('deleted_questions_log', $log_data);
            
            // Hapus dari unanswered_questions
            $this->db->where('id', $question_id);
            $result = $this->db->delete('unanswered_questions');
            
            if ($result) {
                log_message('info', 'Question deleted: ID ' . $question_id . ' - Reason: ' . $reason);
            }
            
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Failed to delete question: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete all pending questions
     */
    public function delete_all_pending_questions($reason = '') {
        try {
            // Ambil semua pertanyaan pending sebelum dihapus
            $this->db->select('*');
            $this->db->from('unanswered_questions');
            $this->db->where('status', 'pending');
            $query = $this->db->get();
            $questions = $query->result_array();
            
            $deleted_count = 0;
            
            // Hapus satu per satu untuk logging
            foreach ($questions as $question) {
                if ($this->delete_question($question['id'], $reason . ' (bulk deletion)')) {
                    $deleted_count++;
                }
            }
            
            log_message('info', 'Bulk deletion completed: ' . $deleted_count . ' questions deleted');
            return $deleted_count;
        } catch (Exception $e) {
            log_message('error', 'Failed to delete all pending questions: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get deletion log
     */
    public function get_deletion_log($limit = 50) {
        try {
            $this->db->select('*');
            $this->db->from('deleted_questions_log');
            $this->db->order_by('deleted_at', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get deletion log: ' . $e->getMessage());
            return [];
        }
    }
    
    // ==================== DATABASE DIAGNOSTIC FUNCTIONS ====================
    
    /**
     * Check unanswered table
     */
    public function check_unanswered_table() {
        try {
            // Check if table exists
            $table_exists = $this->db->table_exists('unanswered_questions');
            
            if (!$table_exists) {
                log_message('error', 'Table unanswered_questions does not exist');
                return [
                    'table_exists' => false,
                    'message' => 'Table unanswered_questions does not exist'
                ];
            }
            
            // Get all records
            $all_records = $this->db->get('unanswered_questions')->result_array();
            
            // Get pending records
            $this->db->where('status', 'pending');
            $pending_records = $this->db->get('unanswered_questions')->result_array();
            
            return [
                'table_exists' => true,
                'total_records' => count($all_records),
                'pending_records' => count($pending_records),
                'all_records' => $all_records,
                'pending_records_list' => $pending_records
            ];
        } catch (Exception $e) {
            log_message('error', 'Error checking unanswered table: ' . $e->getMessage());
            return [
                'table_exists' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    // ==================== EDIT MESSAGE FUNCTIONS - FIXED ====================
    
    /**
     * Get message by ID - IMPROVED
     */
    public function get_message_by_id($message_id) {
        try {
            log_message('debug', 'Getting message by ID: ' . $message_id);
            
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->where('id', $message_id);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $message = $query->row_array();
                log_message('debug', 'Message found: ID ' . $message_id);
                return $message;
            }
            
            log_message('debug', 'Message not found: ID ' . $message_id);
            return null;
        } catch (Exception $e) {
            log_message('error', 'Failed to get message by ID: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Update message text - IMPROVED
     */
    public function update_message($message_id, $new_message, $original_message_id = null) {
        try {
            log_message('debug', 'Updating message - ID: ' . $message_id . 
                       ' - New message: ' . substr($new_message, 0, 50));
            
            $data = [
                'user_request' => $new_message,
                'is_edited' => 1,
                'edited_at' => date('Y-m-d H:i:s')
            ];
            
            if ($original_message_id) {
                $data['original_message_id'] = $original_message_id;
            }
            
            $this->db->where('id', $message_id);
            $result = $this->db->update('_logs', $data);
            
            if ($result) {
                log_message('info', 'Message updated successfully - ID: ' . $message_id);
            } else {
                log_message('error', 'Failed to update message - ID: ' . $message_id);
            }
            
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Failed to update message: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get edit history for a message - IMPROVED
     */
    public function get_edit_history($message_id, $limit = 10) {
        try {
            log_message('debug', 'Getting edit history for message: ' . $message_id);
            
            // Get the original message
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->where('id', $message_id);
            $this->db->or_where('original_message_id', $message_id);
            $this->db->order_by('createdAt', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $history = $query->result_array();
                log_message('debug', 'Found ' . count($history) . ' edit history records');
                return $history;
            }
            
            log_message('debug', 'No edit history found for message: ' . $message_id);
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get edit history: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get all edited messages
     */
    public function get_edited_messages($limit = 50) {
        try {
            log_message('debug', 'Getting edited messages');
            
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->where('is_edited', 1);
            $this->db->order_by('edited_at', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $messages = $query->result_array();
                log_message('debug', 'Found ' . count($messages) . ' edited messages');
                return $messages;
            }
            
            log_message('debug', 'No edited messages found');
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get edited messages: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Log copy action - IMPROVED
     */
    public function log_copy_action($message_id, $text, $type = 'unknown', $user_ip = null) {
        try {
            if (!$user_ip) {
                $user_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            }
            
            $data = [
                'message_id' => $message_id,
                'text_type' => $type,
                'text_preview' => substr($text, 0, 200),
                'text_length' => strlen($text),
                'copied_at' => date('Y-m-d H:i:s'),
                'user_ip' => $user_ip
            ];
            
            $result = $this->db->insert('copy_logs', $data);
            
            if ($result) {
                log_message('info', 'Copy action logged - Type: ' . $type . 
                           ' - Length: ' . strlen($text) . 
                           ' - Message ID: ' . ($message_id ?: 'N/A'));
            }
            
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Failed to log copy action: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get copy logs
     */
    public function get_copy_logs($limit = 50) {
        try {
            log_message('debug', 'Getting copy logs');
            
            if (!$this->db->table_exists('copy_logs')) {
                log_message('debug', 'copy_logs table does not exist');
                return [];
            }
            
            $this->db->select('*');
            $this->db->from('copy_logs');
            $this->db->order_by('copied_at', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $logs = $query->result_array();
                log_message('debug', 'Found ' . count($logs) . ' copy logs');
                return $logs;
            }
            
            log_message('debug', 'No copy logs found');
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get copy logs: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get statistics - IMPROVED
     */
    public function get_statistics() {
        try {
            $stats = [];
            
            // Total messages
            $stats['total_messages'] = $this->db->count_all('_logs');
            
            // Edited messages
            $this->db->where('is_edited', 1);
            $stats['edited_messages'] = $this->db->count_all_results('_logs');
            
            // Today's messages
            $today = date('Y-m-d');
            $this->db->where('DATE(createdAt)', $today);
            $stats['today_messages'] = $this->db->count_all_results('_logs');
            
            // This week's messages
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $this->db->where('DATE(createdAt) >=', $week_start);
            $stats['week_messages'] = $this->db->count_all_results('_logs');
            
            // Copy logs count
            if ($this->db->table_exists('copy_logs')) {
                $stats['copy_count'] = $this->db->count_all('copy_logs');
            } else {
                $stats['copy_count'] = 0;
            }
            
            // Calculate percentages
            $stats['edit_percentage'] = $stats['total_messages'] > 0 ? 
                round(($stats['edited_messages'] / $stats['total_messages']) * 100, 2) : 0;
            
            // Get most edited message
            $this->db->select('original_message_id, COUNT(*) as edit_count');
            $this->db->from('_logs');
            $this->db->where('original_message_id IS NOT NULL');
            $this->db->group_by('original_message_id');
            $this->db->order_by('edit_count', 'DESC');
            $this->db->limit(1);
            $most_edited_query = $this->db->get();
            $stats['most_edited_message'] = $most_edited_query->row_array();
            
            log_message('debug', 'Statistics retrieved: ' . json_encode($stats));
            return $stats;
        } catch (Exception $e) {
            log_message('error', 'Failed to get statistics: ' . $e->getMessage());
            return [
                'total_messages' => 0,
                'edited_messages' => 0,
                'today_messages' => 0,
                'week_messages' => 0,
                'copy_count' => 0,
                'edit_percentage' => 0,
                'most_edited_message' => null
            ];
        }
    }
    
    /**
     * Search messages by content
     */
    public function search_messages($keyword, $limit = 20) {
        try {
            log_message('debug', 'Searching messages with keyword: ' . $keyword);
            
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->group_start();
            $this->db->like('user_request', $keyword);
            $this->db->or_like('ai_response', $keyword);
            $this->db->group_end();
            $this->db->order_by('createdAt', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $results = $query->result_array();
                log_message('debug', 'Found ' . count($results) . ' messages with keyword: ' . $keyword);
                return $results;
            }
            
            log_message('debug', 'No messages found with keyword: ' . $keyword);
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to search messages: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get recent messages with edit status
     */
    public function get_recent_messages_with_edit_status($limit = 20) {
        try {
            log_message('debug', 'Getting recent messages with edit status');
            
            $this->db->select('id, user_request, ai_response, is_edited, edited_at, createdAt');
            $this->db->from('_logs');
            $this->db->order_by('createdAt', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $messages = $query->result_array();
                
                // Add edit count for each message
                foreach ($messages as &$message) {
                    if ($message['is_edited']) {
                        $this->db->where('original_message_id', $message['id']);
                        $message['edit_count'] = $this->db->count_all_results('_logs');
                    } else {
                        $message['edit_count'] = 0;
                    }
                }
                
                log_message('debug', 'Found ' . count($messages) . ' recent messages');
                return $messages;
            }
            
            log_message('debug', 'No recent messages found');
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get recent messages: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Clean old copy logs (maintenance)
     */
    public function clean_old_copy_logs($days = 30) {
        try {
            log_message('debug', 'Cleaning copy logs older than ' . $days . ' days');
            
            if (!$this->db->table_exists('copy_logs')) {
                log_message('debug', 'copy_logs table does not exist');
                return 0;
            }
            
            $cutoff_date = date('Y-m-d H:i:s', strtotime('-' . $days . ' days'));
            
            $this->db->where('copied_at <', $cutoff_date);
            $this->db->delete('copy_logs');
            
            $affected_rows = $this->db->affected_rows();
            
            log_message('info', 'Cleaned ' . $affected_rows . ' old copy logs');
            return $affected_rows;
        } catch (Exception $e) {
            log_message('error', 'Failed to clean old copy logs: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Export messages to CSV
     */
    public function export_messages_to_csv($start_date = null, $end_date = null) {
        try {
            log_message('debug', 'Exporting messages to CSV');
            
            $this->db->select('id, user_request, ai_response, is_edited, edited_at, createdAt');
            $this->db->from('_logs');
            
            if ($start_date) {
                $this->db->where('DATE(createdAt) >=', $start_date);
            }
            
            if ($end_date) {
                $this->db->where('DATE(createdAt) <=', $end_date);
            }
            
            $this->db->order_by('createdAt', 'ASC');
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $messages = $query->result_array();
                log_message('debug', 'Exported ' . count($messages) . ' messages to CSV');
                return $messages;
            }
            
            log_message('debug', 'No messages to export');
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to export messages: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get message timeline
     */
    public function get_message_timeline($days = 7) {
        try {
            log_message('debug', 'Getting message timeline for last ' . $days . ' days');
            
            $results = [];
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime('-' . $i . ' days'));
                
                // Total messages
                $this->db->where('DATE(createdAt)', $date);
                $total = $this->db->count_all_results('_logs');
                
                // Edited messages
                $this->db->where('DATE(createdAt)', $date);
                $this->db->where('is_edited', 1);
                $edited = $this->db->count_all_results('_logs');
                
                $results[] = [
                    'date' => $date,
                    'total_messages' => $total,
                    'edited_messages' => $edited,
                    'edit_percentage' => $total > 0 ? round(($edited / $total) * 100, 2) : 0
                ];
            }
            
            log_message('debug', 'Generated timeline with ' . count($results) . ' days');
            return $results;
        } catch (Exception $e) {
            log_message('error', 'Failed to get message timeline: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get all messages with pagination
     */
    public function get_all_messages($limit = 20, $offset = 0) {
        try {
            log_message('debug', 'Getting all messages with limit ' . $limit . ', offset ' . $offset);
            
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->order_by('createdAt', 'DESC');
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $messages = $query->result_array();
                log_message('debug', 'Found ' . count($messages) . ' messages');
                return $messages;
            }
            
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get all messages: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Count total messages
     */
    public function count_total_messages() {
        try {
            return $this->db->count_all('_logs');
        } catch (Exception $e) {
            log_message('error', 'Failed to count total messages: ' . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get messages by date range
     */
    public function get_messages_by_date_range($start_date, $end_date) {
        try {
            log_message('debug', 'Getting messages from ' . $start_date . ' to ' . $end_date);
            
            $this->db->select('*');
            $this->db->from('_logs');
            $this->db->where('DATE(createdAt) >=', $start_date);
            $this->db->where('DATE(createdAt) <=', $end_date);
            $this->db->order_by('createdAt', 'ASC');
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                $messages = $query->result_array();
                log_message('debug', 'Found ' . count($messages) . ' messages in date range');
                return $messages;
            }
            
            return [];
        } catch (Exception $e) {
            log_message('error', 'Failed to get messages by date range: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get message statistics summary
     */
    public function get_message_statistics_summary() {
        try {
            $summary = [];
            
            // Total count
            $summary['total'] = $this->db->count_all('_logs');
            
            // Edited count
            $this->db->where('is_edited', 1);
            $summary['edited'] = $this->db->count_all_results('_logs');
            
            // Today's count
            $today = date('Y-m-d');
            $this->db->where('DATE(createdAt)', $today);
            $summary['today'] = $this->db->count_all_results('_logs');
            
            // This week count
            $week_start = date('Y-m-d', strtotime('monday this week'));
            $this->db->where('DATE(createdAt) >=', $week_start);
            $summary['this_week'] = $this->db->count_all_results('_logs');
            
            // This month count
            $month_start = date('Y-m-01');
            $this->db->where('DATE(createdAt) >=', $month_start);
            $summary['this_month'] = $this->db->count_all_results('_logs');
            
            // Average messages per day
            $this->db->select('DATE(createdAt) as date, COUNT(*) as count');
            $this->db->from('_logs');
            $this->db->group_by('DATE(createdAt)');
            $this->db->order_by('date', 'DESC');
            $this->db->limit(30);
            $daily_query = $this->db->get();
            
            $daily_counts = [];
            if ($daily_query->num_rows() > 0) {
                $daily_counts = $daily_query->result_array();
                $total_daily = array_sum(array_column($daily_counts, 'count'));
                $summary['avg_per_day'] = round($total_daily / count($daily_counts), 2);
            } else {
                $summary['avg_per_day'] = 0;
            }
            
            log_message('debug', 'Generated message statistics summary');
            return $summary;
            
        } catch (Exception $e) {
            log_message('error', 'Failed to get message statistics summary: ' . $e->getMessage());
            return [
                'total' => 0,
                'edited' => 0,
                'today' => 0,
                'this_week' => 0,
                'this_month' => 0,
                'avg_per_day' => 0
            ];
        }
    }
}

/* End of file ChatML_model.php */
/* Location: ./application/models/ChatML_model.php */