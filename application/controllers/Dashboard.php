<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Load semua model yang diperlukan
        $this->load->model('Dashboard_model'); // Model utama dashboard
         $this->load->model('Berita_model'); 
        $this->load->model('ChatML_model');    // Model untuk machine learning

        // Load library yang diperlukan
        $this->load->library('session');
        $this->load->library('form_validation');

        // Enable debugging
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        // Set timezone
        date_default_timezone_set('Asia/Jakarta');

        // Cek session untuk chat context
        if (!$this->session->userdata('chat_context')) {
            $this->session->set_userdata('chat_context', [
                'last_interaction' => time(),
                'greeting_count' => 0,
                'conversation_mode' => 'normal',
                'user_name' => null,
                'conversation_history' => [],
                'topic_focus' => null
            ]);
        }
    }

    // ==================== DASHBOARD UTAMA ====================

    /**
     * Halaman Utama Dashboard
     */
    public function index()
    {
        // Cek apakah user sudah login
        $is_logged_in = $this->session->userdata('logged_in');
        $this->load->model('Berita_model');
        // Data untuk dikirim ke view
        $data['title'] = 'Dashboard Fakultas Industri Kreatif - Telkom University';
// Ambil 5 berita terbaru untuk carousel
    $data['berita_list'] = $this->Berita_model->get_latest_berita(5);
        // Data user dari session (jika login)
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
                case 'mahasiswa':
                    $role_display = 'Mahasiswa';
                    break;
                case 'dosen':
                case 'dosen_pembina':
                    $role_display = 'Dosen';
                    break;
                case 'kemahasiswaan':
                    $role_display = 'Staff Kemahasiswaan';
                    break;
                case 'kaprodi':
                    $role_display = 'Kepala Program Studi';
                    break;
                case 'bemdpm':
                    $role_display = 'BEM/DPM';
                    break;
                default:
                    $role_display = ucfirst($data['user_data']['role']);
            }
            $data['user_data']['role_display'] = $role_display;

            // Format waktu login
            $data['user_data']['login_time'] = date('d F Y H:i:s');
        } else {
            $data['user_data'] = null;
        }

        // Load view dashboard
        $this->load->view('dashboard', $data);
    }

    // ==================== CHATML MACHINE LEARNING - PERBAIKAN UTAMA ====================

    /**
     * Process chat message - VERSI PERBAIKAN
     */
    public function process_chat()
    {
        header('Content-Type: application/json');

        $input = trim($this->input->post('message'));
        $mode = $this->input->post('mode');

        // Log untuk debugging
        log_message('debug', '===== CHAT PROCESS START =====');
        log_message('debug', 'User input: ' . $input);
        log_message('debug', 'Mode: ' . ($mode ?: 'general'));

        if (empty($input)) {
            log_message('debug', 'Empty input detected');
            echo json_encode([
                'status' => 'error',
                'message' => 'Pesan tidak boleh kosong'
            ]);
            return;
        }

        try {
            // Validasi input panjang
            if (strlen($input) < 3) {
                log_message('debug', 'Input too short: ' . strlen($input) . ' chars');

                $short_responses = [
                    "Halo! 😊 Ada yang bisa saya bantu tentang FIK?",
                    "Hai! 👋 Silakan tanyakan sesuatu tentang Fakultas Industri Kreatif!",
                    "Ya? 😄 Ada pertanyaan tentang FIK? Saya siap membantu!"
                ];

                $response = $short_responses[array_rand($short_responses)];
                $message_id = $this->ChatML_model->save_log($input, $response);

                echo json_encode([
                    'status' => 'success',
                    'message' => $response,
                    'message_id' => $message_id,
                    'found' => false,
                    'is_short' => true
                ]);
                return;
            }

            // Cek apakah input hanya angka atau karakter spesial
            if (preg_match('/^[0-9\s]+$/', $input)) {
                log_message('debug', 'Input contains only numbers');

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Pertanyaan tidak valid. Silakan gunakan kalimat yang jelas tentang FIK.',
                    'found' => false,
                    'invalid' => true
                ]);
                return;
            }

            if ($mode === 'general') {
                // Deteksi sapaan
                $greeting_response = $this->_detect_greeting($input);

                if ($greeting_response) {
                    log_message('debug', 'Greeting detected');
                    $message_id = $this->ChatML_model->save_log($input, $greeting_response);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $greeting_response,
                        'message_id' => $message_id,
                        'is_greeting' => true
                    ]);
                    return;
                }

                // Deteksi perkenalan nama
                $name_detected = $this->_detect_name_introduction($input);
                if ($name_detected) {
                    log_message('debug', 'Name introduction detected: ' . $name_detected);
                    $response = $this->_generate_name_response($name_detected);
                    $message_id = $this->ChatML_model->save_log($input, $response);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $response,
                        'message_id' => $message_id,
                        'user_name' => $name_detected,
                        'is_name_introduction' => true
                    ]);
                    return;
                }

                // Deteksi pertanyaan tentang bot
                if ($this->_is_bot_related_question($input)) {
                    log_message('debug', 'Bot-related question detected');
                    $response = $this->_answer_about_self($input);
                    $message_id = $this->ChatML_model->save_log($input, $response);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $response,
                        'message_id' => $message_id,
                        'is_about_bot' => true
                    ]);
                    return;
                }

                // Validasi pertanyaan
                $validation = $this->ChatML_model->validate_question($input);

                if (!$validation['valid']) {
                    log_message('debug', 'Question validation failed: ' . $validation['reason']);

                    $message_id = $this->ChatML_model->save_log($input, $validation['reason']);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $validation['reason'],
                        'message_id' => $message_id,
                        'found' => false,
                        'invalid' => true
                    ]);
                    return;
                }

                // Langsung cari jawaban di database
                log_message('debug', 'Searching database for: ' . $input);
                $result = $this->ChatML_model->search_answer($input);

                if ($result['found']) {
                    log_message('debug', 'Found in database with confidence: ' . ($result['confidence'] ?? 'N/A'));
                    log_message('debug', 'Matched keyword: ' . ($result['keyword'] ?? 'unknown'));

                    // Coba enhance dengan AI, tapi fallback ke original jika gagal
                    $final_answer = $result['answer'];
                    $ai_enhanced = false;

                    try {
                        $ai_result = $this->ChatML_model->enhance_answer_with_ai($input, $result['answer']);

                        if ($ai_result['success'] && !empty($ai_result['answer'])) {
                            $final_answer = $ai_result['answer'];
                            $ai_enhanced = true;
                            log_message('debug', 'AI enhancement successful');
                        }
                    } catch (Exception $e) {
                        log_message('error', 'AI enhancement error: ' . $e->getMessage());
                        // Gunakan jawaban asli dari database
                        $final_answer = $result['answer'];
                    }

                    $message_id = $this->ChatML_model->save_log($input, $final_answer);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $final_answer,
                        'message_id' => $message_id,
                        'found' => true,
                        'ai_enhanced' => $ai_enhanced,
                        'confidence' => $result['confidence'] ?? 0,
                        'matched_keyword' => $result['keyword'] ?? 'unknown'
                    ]);
                } else {
                    // Jawaban tidak ditemukan di database
                    log_message('debug', 'No answer found in database');

                    $saved_id = $this->ChatML_model->save_unanswered($input);
                    log_message('debug', 'Saved to unanswered with ID: ' . ($saved_id ?: 'failed'));

                    $fallback_message = $this->_generate_smart_fallback($input);
                    $message_id = $this->ChatML_model->save_log($input, $fallback_message);

                    echo json_encode([
                        'status' => 'success',
                        'message' => $fallback_message,
                        'message_id' => $message_id,
                        'found' => false,
                        'is_fallback' => true,
                        'saved_to_unanswered' => ($saved_id ? true : false)
                    ]);
                }
            }

            log_message('debug', '===== CHAT PROCESS END =====');
        } catch (Exception $e) {
            log_message('error', 'Chat Process Error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());

            echo json_encode([
                'status' => 'error',
                'message' => 'Maaf, terjadi kesalahan teknis. Tim kami sedang memperbaikinya.'
            ]);
        }
    }

    /**
     * Generate smarter fallback response
     */
    private function _generate_smart_fallback($input)
    {
        $responses = [
            "Maaf, saya belum menemukan informasi tentang \"{$input}\" di database FIK saat ini. 😔\n\nPertanyaan Anda sudah saya catat dan akan segera dijawab oleh tim FIK. Sementara itu, Anda bisa mencoba bertanya tentang:\n• Program studi di FIK (DKV, Desain Interior, dll)\n• Fasilitas laboratorium dan studio\n• Jadwal akademik\n• Prosedur administrasi\n\nAtau coba tanyakan dengan kata kunci yang lebih sederhana.",

            "Wah, pertanyaan tentang \"{$input}\" cukup menarik! 🤔\nSayangnya informasi spesifik itu belum tersedia di sistem saya. Tapi tenang, pertanyaan Anda sudah masuk ke dalam sistem dan akan ditangani oleh tim FIK.\n\nAda topik lain tentang Fakultas Industri Kreatif yang ingin Anda tanyakan? Misalnya:\n• \"Apa itu DKV?\"\n• \"Dimana lab komputer?\"\n• \"Fasilitas apa saja di FIK?\"\n• \"Siapa itu Teguh?\"",

            "Hmm, saya belum punya data tentang \"{$input}\" dalam database saya. 🧐\n\nTapi jangan khawatir! Tim FIK akan segera memproses pertanyaan Anda. Sementara itu, Anda bisa mencoba pertanyaan-pertanyaan berikut yang mungkin relevan:\n• Informasi program studi\n• Lokasi laboratorium\n• Jadwal operasional\n• Kontak staff\n\nAtau coba gunakan kata kunci yang lebih spesifik."
        ];

        return $responses[array_rand($responses)];
    }

    /**
     * Save feedback untuk chat
     */
    public function chat_feedback()
    {
        header('Content-Type: application/json');

        $message_id = $this->input->post('message_id');
        $feedback = $this->input->post('feedback');

        log_message('debug', 'Feedback received - ID: ' . $message_id . ', Feedback: ' . $feedback);

        if (empty($message_id) || empty($feedback)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        try {
            $result = $this->ChatML_model->save_feedback($message_id, $feedback);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Terima kasih atas feedback Anda!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan feedback'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Feedback error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Edit message
     */
    public function edit_message()
    {
        header('Content-Type: application/json');

        $message_id = $this->input->post('message_id');
        $new_message = $this->input->post('new_message');

        log_message('debug', 'Edit message - ID: ' . $message_id . ', New: ' . $new_message);

        if (empty($message_id) || empty($new_message)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        try {
            // Update log
            $this->db->where('id', $message_id);
            $this->db->update('_logs', [
                'is_edited' => 1,
                'edited_at' => date('Y-m-d H:i:s')
            ]);

            // Proses pesan baru
            $response = $this->_process_edited_message($new_message, $message_id);

            echo json_encode($response);
        } catch (Exception $e) {
            log_message('error', 'Error in edit_message: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Copy text logging
     */
    public function copy_text()
    {
        header('Content-Type: application/json');

        $message_id = $this->input->post('message_id');
        $text = $this->input->post('text');
        $type = $this->input->post('type') ?: 'unknown';

        if (empty($text)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Text tidak boleh kosong'
            ]);
            return;
        }

        try {
            // Log copy action
            log_message('info', 'Text copied - Type: ' . $type .
                ' - Length: ' . strlen($text) .
                ' - Preview: ' . substr($text, 0, 50));

            echo json_encode([
                'status' => 'success',
                'message' => 'Text ready for copy'
            ]);
        } catch (Exception $e) {
            log_message('error', 'Copy text error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get chat statistics
     */
    public function chat_stats()
    {
        header('Content-Type: application/json');

        try {
            $stats = [
                'total_messages' => $this->db->count_all('_logs'),
                'edited_messages' => $this->db->where('is_edited', 1)->count_all_results('_logs'),
                'today_messages' => $this->db->where('DATE(createdAt)', date('Y-m-d'))->count_all_results('_logs'),
                'unanswered_count' => $this->ChatML_model->get_pending_count(),
                'knowledge_count' => $this->db->count_all('knowledge_base'),
                'last_24h' => $this->db->where('createdAt >=', date('Y-m-d H:i:s', strtotime('-24 hours')))->count_all_results('_logs')
            ];

            echo json_encode([
                'status' => 'success',
                'stats' => $stats
            ]);
        } catch (Exception $e) {
            log_message('error', 'Chat stats error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get recent messages for chat
     */
    public function get_recent_messages()
    {
        header('Content-Type: application/json');

        $limit = $this->input->get('limit') ?: 20;

        try {
            $this->db->select('id, user_request, ai_response, is_edited, edited_at, createdAt');
            $this->db->from('_logs');
            $this->db->order_by('createdAt', 'DESC');
            $this->db->limit($limit);
            $query = $this->db->get();

            $messages = $query->result_array();

            echo json_encode([
                'status' => 'success',
                'messages' => $messages
            ]);
        } catch (Exception $e) {
            log_message('error', 'Get recent messages error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // ==================== METHOD PRIVATE UNTUK CHAT ====================

    /**
     * Deteksi sapaan - improved version
     */
    private function _detect_greeting($input)
    {
        $greetings = [
            'pagi' => ['selamat pagi', 'pagi', 'good morning', 'morning'],
            'siang' => ['selamat siang', 'siang', 'good afternoon', 'afternoon'],
            'sore' => ['selamat sore', 'sore', 'good evening'],
            'malam' => ['selamat malam', 'malam', 'good night', 'night'],
            'halo' => ['halo', 'hello', 'hi', 'hey', 'hai', 'helo'],
            'apa_kabar' => ['apa kabar', 'gimana kabar', 'how are you', 'kabar'],
            'assalamualaikum' => ['assalamualaikum', 'assalamu\'alaikum', 'assalam'],
            'terima_kasih' => ['terima kasih', 'thanks', 'thank you', 'makasih', 'mks']
        ];

        $input_lower = strtolower(trim($input));

        foreach ($greetings as $type => $patterns) {
            foreach ($patterns as $pattern) {
                if ($input_lower === $pattern || strpos($input_lower, $pattern) === 0) {
                    return $this->_generate_greeting_response($type);
                }
            }
        }

        return false;
    }

    /**
     * Generate response untuk sapaan
     */
    private function _generate_greeting_response($type)
    {
        $context = $this->session->userdata('chat_context');
        $user_name = $context['user_name'];

        $responses = [
            'pagi' => [
                "Selamat pagi" . ($user_name ? " $user_name" : "") . "! 🌅 Ada yang bisa saya bantu tentang FIK hari ini?",
                "Pagi yang cerah" . ($user_name ? " $user_name" : "") . "! ☀️ Siap membantu Anda menjelajahi Fakultas Industri Kreatif!",
                "Selamat pagi! ✨ Semoga harimu menyenangkan. Ada pertanyaan tentang FIK?"
            ],
            'siang' => [
                "Selamat siang" . ($user_name ? " $user_name" : "") . "! ☀️ Ada yang bisa saya bantu?",
                "Siang" . ($user_name ? " $user_name" : "") . "! 😊 Waktu yang tepat untuk bertanya tentang FIK!",
                "Selamat siang! 🌤️ Mari diskusi tentang Fakultas Industri Kreatif!"
            ],
            'sore' => [
                "Selamat sore" . ($user_name ? " $user_name" : "") . "! 🌇 Ada yang ingin ditanyakan?",
                "Sore" . ($user_name ? " $user_name" : "") . "! 🎨 Saya masih siap membantu Anda!",
                "Selamat sore! ✨ Sore yang indah untuk belajar tentang FIK!"
            ],
            'malam' => [
                "Selamat malam" . ($user_name ? " $user_name" : "") . "! 🌙 Masih semangat belajar tentang FIK?",
                "Malam" . ($user_name ? " $user_name" : "") . "! ✨ Ada pertanyaan sebelum beristirahat?",
                "Selamat malam! 😴 Jangan lupa istirahat. Ada yang bisa saya bantu?"
            ],
            'halo' => [
                "Halo" . ($user_name ? " $user_name" : "") . "! 👋 Ada yang bisa saya bantu tentang FIK?",
                "Hello" . ($user_name ? " $user_name" : "") . "! 😊 Selamat datang di FIK Assistant!",
                "Hi" . ($user_name ? " $user_name" : "") . "! ✨ Senang bertemu dengan Anda!"
            ],
            'apa_kabar' => [
                "Alhamdulillah baik" . ($user_name ? " $user_name" : "") . "! 😊 Ada yang bisa saya bantu?",
                "Kabar baik! 👍 Semoga Anda juga baik-baik saja. Ada pertanyaan?",
                "Saya sehat! Terima kasih sudah bertanya. Ada yang ingin diketahui tentang FIK?"
            ],
            'assalamualaikum' => [
                "Wa'alaikumsalam" . ($user_name ? " $user_name" : "") . "! 🤲 Ada yang bisa saya bantu?",
                "Wa'alaikumsalam warahmatullahi wabarakatuh. Selamat datang!",
                "Wa'alaikumsalam! 😊 Senang bertemu dengan Anda."
            ],
            'terima_kasih' => [
                "Sama-sama" . ($user_name ? " $user_name" : "") . "! 😊 Senang bisa membantu!",
                "Dengan senang hati! 🤗 Ada lagi yang ingin ditanyakan?",
                "Terima kasih kembali! ✨ Jangan ragu untuk bertanya lagi ya!"
            ]
        ];

        $response_list = $responses[$type] ?? ["Halo! Ada yang bisa saya bantu tentang FIK?"];
        return $response_list[array_rand($response_list)];
    }

    /**
     * Deteksi perkenalan nama
     */
    private function _detect_name_introduction($input)
    {
        $input_lower = strtolower(trim($input));

        $patterns = [
            '/nama (?:saya|aku) (.+)/i',
            '/saya (.+)/i',
            '/panggil (?:saya|aku) (.+)/i',
            '/nama (.+)/i',
            '/my name is (.+)/i',
            '/i am (.+)/i',
            "/aku (.+)/i"
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input_lower, $matches)) {
                $name = trim($matches[1]);
                // Bersihkan dari kata-kata tambahan
                $name = preg_replace('/^(nama|saya|aku|adalah|panggil)\s+/i', '', $name);
                $name = preg_replace('/[^a-z\s]/i', '', $name);

                if (strlen($name) > 1 && strlen($name) < 30) {
                    return ucwords(strtolower($name));
                }
            }
        }

        return false;
    }

    /**
     * Generate response untuk perkenalan nama
     */
    private function _generate_name_response($name)
    {
        $context = $this->session->userdata('chat_context');
        $context['user_name'] = $name;
        $this->session->set_userdata('chat_context', $context);

        $responses = [
            "Senang bertemu dengan Anda, $name! 😊 Ada yang bisa saya bantu tentang FIK?",
            "Halo $name! 👋 Terima kasih sudah memperkenalkan diri. Silakan tanya apa saja tentang FIK!",
            "Hai $name! 😄 Senang berkenalan dengan Anda. Ada pertanyaan seputar Fakultas Industri Kreatif?",
            "Terima kasih $name! ✨ Sekarang kita bisa lebih akrab. Ada yang ingin ditanyakan?"
        ];

        return $responses[array_rand($responses)];
    }

    /**
     * Deteksi pertanyaan tentang bot
     */
    private function _is_bot_related_question($input)
    {
        $input_lower = strtolower($input);
        $keywords = [
            'siapa kamu',
            'kamu siapa',
            'nama kamu',
            'kamu bisa apa',
            'what can you do',
            'apa yang bisa kamu lakukan',
            'kamu robot',
            'apakah kamu robot',
            'apakah kamu ai',
            'kamu manusia',
            'kamu chatbot',
            'fungsi kamu',
            'siapa pembuatmu',
            'siapa yang membuat kamu'
        ];

        foreach ($keywords as $keyword) {
            if (strpos($input_lower, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Jawab pertanyaan tentang bot
     */
    private function _answer_about_self($input)
    {
        $responses = [
            "Saya adalah FIK Assistant, chatbot yang dirancang khusus untuk membantu Anda dengan informasi tentang Fakultas Industri Kreatif! 🤖✨\n\nSaya bisa membantu dengan:\n• Informasi program studi (DKV, Desain Interior, dll)\n• Fasilitas laboratorium dan studio\n• Jadwal akademik\n• Prosedur administrasi\n• Dan masih banyak lagi!",

            "Perkenalkan, saya FIK Assistant! 👋 Saya di sini untuk membantu Anda menjelajahi Fakultas Industri Kreatif. Saya adalah AI yang dilatih dengan database pengetahuan tentang FIK.",

            "Hai! Saya FIK Assistant 😊 Saya adalah asisten virtual yang dibuat oleh tim pengembang FIK untuk memberikan layanan informasi 24/7. Ada yang bisa saya bantu?"
        ];

        return $responses[array_rand($responses)];
    }

    /**
     * Process edited message
     */
    private function _process_edited_message($message, $original_id)
    {
        log_message('debug', 'Processing edited message: ' . $message);

        // Cari jawaban di database
        $result = $this->ChatML_model->search_answer($message);

        if ($result['found']) {
            $final_answer = $result['answer'];
            log_message('debug', 'Found answer for edited message');
        } else {
            $final_answer = $this->_generate_smart_fallback($message);
            $this->ChatML_model->save_unanswered($message);
            log_message('debug', 'No answer for edited message, saved to unanswered');
        }

        $new_id = $this->ChatML_model->save_log($message, $final_answer, 1, $original_id);

        return [
            'status' => 'success',
            'message' => $final_answer,
            'message_id' => $new_id,
            'is_edited_message' => true,
            'original_message_id' => $original_id,
            'found' => $result['found'] ?? false
        ];
    }

    // ==================== ENDPOINT DEBUGGING ====================

    /**
     * Debug endpoint untuk cek koneksi database
     */
    public function debug_database()
    {
        header('Content-Type: application/json');

        try {
            $data = [
                'knowledge_base_count' => $this->db->count_all('knowledge_base'),
                'unanswered_count' => $this->db->count_all('unanswered_questions'),
                'logs_count' => $this->db->count_all('_logs'),
                'database_name' => $this->db->database,
                'hostname' => $this->db->hostname,
                'connection_status' => 'connected'
            ];

            // Test query
            $sample = $this->db->get('knowledge_base', 5)->result_array();
            $data['sample_data'] = array_map(function ($row) {
                return [
                    'id' => $row['id'],
                    'keyword' => $row['keyword'],
                    'preview' => substr($row['description'], 0, 100)
                ];
            }, $sample);

            echo json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Test search endpoint
     */
    public function test_search()
    {
        header('Content-Type: application/json');

        $keyword = $this->input->get('q');

        if (empty($keyword)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Keyword tidak boleh kosong'
            ]);
            return;
        }

        try {
            $result = $this->ChatML_model->search_answer($keyword);

            // Dapatkan juga hasil test langsung
            $test_results = $this->ChatML_model->test_search($keyword);

            echo json_encode([
                'status' => 'success',
                'keyword' => $keyword,
                'search_result' => $result,
                'test_results' => $test_results,
                'knowledge_count' => $this->ChatML_model->count_knowledge()
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    // ==================== FITUR DASHBOARD LAINNYA ====================

   

    /**
     * Halaman Profil Fakultas
     */
    public function profile_fik()
    {
        $data['title'] = 'Profil Fakultas Informatika - Telkom University';
        $data['sejarah'] = $this->Dashboard_model->get_sejarah_fik();
        $data['visi_misi'] = $this->Dashboard_model->get_visi_misi();
        $data['akreditasi'] = $this->Dashboard_model->get_akreditasi_prodi();

        $this->load->view('profile_fik', $data);
    }

    /**
     * Halaman Akademik
     */
    public function akademik()
    {
        $data['title'] = 'Akademik - Fakultas Informatika';
        $data['program_studi'] = $this->Dashboard_model->get_program_studi_detail();
        $data['kalender_akademik'] = $this->Dashboard_model->get_kalender_akademik();

        $this->load->view('akademik', $data);
    }

    /**
     * Halaman Layanan Mahasiswa
     */
    public function layanan()
    {
        $data['title'] = 'Layanan Mahasiswa - Fakultas Informatika';
        $data['layanan_akademik'] = $this->Dashboard_model->get_layanan_akademik();
        $data['layanan_kemahasiswaan'] = $this->Dashboard_model->get_layanan_kemahasiswaan();

        $this->load->view('layanan', $data);
    }

    /**
     * Halaman Riset dan Inovasi
     */
    public function riset_inovasi()
    {
        $data['title'] = 'Riset dan Inovasi - Fakultas Informatika';
        $data['penelitian'] = $this->Dashboard_model->get_penelitian_terbaru();
        $data['publikasi'] = $this->Dashboard_model->get_publikasi_ilmiah();

        $this->load->view('riset_inovasi', $data);
    }

    /**
     * Halaman Kontak
     */
    public function kontak()
    {
        $data['title'] = 'Kontak Kami - Fakultas Informatika';
        $data['kontak_info'] = $this->Dashboard_model->get_kontak_info();

        $this->load->view('kontak', $data);
    }

    /**
     * Kirim Pesan Kontak
     */
    public function kirim_pesan()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'telepon' => $this->input->post('telepon'),
                'pesan' => $this->input->post('pesan'),
                'tanggal' => date('Y-m-d H:i:s')
            );

            if ($this->Dashboard_model->simpan_pesan($data)) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Pesan berhasil dikirim.'
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Gagal mengirim pesan.'
                );
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * Halaman Login
     */
    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $data['title'] = 'Login - Portal Mahasiswa';
        $this->load->view('login', $data);
    }

    /**
     * Proses Login
     */
    public function proses_login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('login');
        } else {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));

            $user = $this->Dashboard_model->cek_login($username, $password);

            if ($user) {
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'nama' => $user->nama,
                    'role' => $user->role,
                    'logged_in' => TRUE
                );

                $this->session->set_userdata($session_data);
                redirect('dashboard/myfik');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('login');
            }
        }
    }

    /**
     * Halaman MyFIK (Portal Mahasiswa)
     */
    public function myfik()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['title'] = 'MyFIK - Portal Mahasiswa';
        $data['user_data'] = $this->Dashboard_model->get_user_data($this->session->userdata('user_id'));

        $this->load->view('myfik', $data);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('dashboard');
    }

    /**
     * Pencarian Global
     */
    public function search()
    {
        $keyword = $this->input->get('q');

        if ($keyword) {
            $data['hasil_pencarian'] = $this->Dashboard_model->search_all($keyword);
            $data['keyword'] = $keyword;
        } else {
            $data['hasil_pencarian'] = array();
            $data['keyword'] = '';
        }

        $data['title'] = 'Hasil Pencarian: "' . $keyword . '"';
        $this->load->view('search_result', $data);
    }

    

    /**
     * AI Engine status
     */
    public function ai_status()
    {
        header('Content-Type: application/json');

        try {
            $is_healthy = $this->ChatML_model->check_ai_engine_health();

            echo json_encode([
                'status' => $is_healthy ? 'online' : 'offline',
                'timestamp' => date('Y-m-d H:i:s'),
                'message' => $is_healthy ? 'AI Engine is running' : 'AI Engine is offline'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Admin panel untuk unanswered questions
     */
    public function admin_chat()
    {
        // Cek session admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('login');
        }

        $data['title'] = 'Admin Panel - Pertanyaan Belum Dijawab';
        $data['bot_name'] = 'FIK Assistant';
        $data['unanswered_count'] = $this->ChatML_model->get_pending_count();
        $data['knowledge_count'] = $this->db->count_all('knowledge_base');

        $this->load->view('chatml/admin_interface', $data);
    }

    /**
     * Get unanswered questions untuk admin
     */
    public function get_unanswered()
    {
        header('Content-Type: application/json');

        // Cek session admin
        if (!$this->session->userdata('logged_in')) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            return;
        }

        try {
            $questions = $this->ChatML_model->get_unanswered_questions();

            echo json_encode([
                'status' => 'success',
                'questions' => $questions,
                'total_pending' => count($questions)
            ]);
        } catch (Exception $e) {
            log_message('error', 'Get unanswered error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Answer question dari admin
     */
    public function answer_question()
    {
        header('Content-Type: application/json');

        // Cek session admin
        if (!$this->session->userdata('logged_in')) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized'
            ]);
            return;
        }

        $question_id = $this->input->post('question_id');
        $answer = $this->input->post('answer');
        $category = $this->input->post('category') ?: 'general';

        log_message('debug', 'Admin answering question ID: ' . $question_id);

        if (empty($question_id) || empty($answer)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        try {
            $question = $this->ChatML_model->get_question_by_id($question_id);

            if (!$question) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Pertanyaan tidak ditemukan'
                ]);
                return;
            }

            $saved = $this->ChatML_model->save_to_knowledge_base(
                $question['question'],
                $answer,
                $category
            );

            if ($saved) {
                $this->ChatML_model->mark_question_answered($question_id);
                log_message('info', 'Question answered and saved to knowledge base: ' . $question['question']);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Jawaban berhasil disimpan ke knowledge base'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Gagal menyimpan jawaban (mungkin duplikat)'
                ]);
            }
        } catch (Exception $e) {
            log_message('error', 'Answer question error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Halaman 404 Custom
     */
    public function page_not_found()
    {
        $data['title'] = 'Halaman Tidak Ditemukan';
        $this->output->set_status_header('404');
        $this->load->view('404', $data);
    }
    /**
     * Halaman Profil User
     */
    public function profile()
    {
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        $data['title'] = 'Profil Saya - FIK Telkom University';

        // Data user dari session
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
            case 'mahasiswa':
                $role_display = 'Mahasiswa';
                break;
            case 'dosen':
            case 'dosen_pembina':
                $role_display = 'Dosen';
                break;
            case 'kemahasiswaan':
                $role_display = 'Staff Kemahasiswaan';
                break;
            case 'kaprodi':
                $role_display = 'Kepala Program Studi';
                break;
            case 'bemdpm':
                $role_display = 'BEM/DPM';
                break;
            default:
                $role_display = ucfirst($data['user_data']['role']);
        }
        $data['user_data']['role_display'] = $role_display;

        // Format waktu login
        $data['user_data']['login_time'] = date('d F Y H:i:s', $this->session->userdata('login_time') ?? time());

        $this->load->view('profile', $data);
    }
    /**
 * Get berita untuk ditampilkan di dashboard via AJAX
 */
public function get_berita()
{
    header('Content-Type: application/json');
    
    try {
        $this->load->model('Berita_model');
        
        $limit = $this->input->get('limit') ?: 5;
        
        // Ambil berita dengan status publish
        $berita = $this->Berita_model->get_latest_berita($limit);
        
        // Format data untuk frontend
        $formatted_berita = [];
        foreach ($berita as $item) {
            $formatted_berita[] = [
                'id' => $item['id'],
                'title' => $item['judul'],
                'slug' => $item['slug'],
                'category' => $item['kategori'],
                'desc' => strip_tags(substr($item['ringkasan'] ?: $item['konten'], 0, 150)) . '...',
                'date' => date('d F Y', strtotime($item['published_at'])),
                'image' => $item['gambar'] ? base_url('uploads/berita/' . $item['gambar']) : null,
                'views' => $item['views'],
                'published_at' => $item['published_at']
            ];
        }
        
        echo json_encode([
            'status' => 'success',
            'data' => $formatted_berita
        ]);
    } catch (Exception $e) {
        log_message('error', 'Get berita error: ' . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage(),
            'data' => []
        ]);
    }
}

 public function get_organisasi_json()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');

        try {
            $list = $this->Organisasi_model->get_aktif();
            $result = [];
            foreach ($list as $org) {
                $result[] = [
                    'name' => $org->nama,
                    'desc' => $org->deskripsi,
                    'logo' => $org->logo,
                    'icon' => $org->icon,
                ];
            }
            echo json_encode(['status' => 'success', 'data' => $result]);
        } catch (Exception $e) {
            log_message('error', 'get_organisasi_json error: ' . $e->getMessage());
            echo json_encode(['status' => 'error', 'data' => []]);
        }
    }
}