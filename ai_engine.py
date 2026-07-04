from flask import Flask, request, jsonify
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
import re
import random
import datetime
from datetime import datetime
import time
import logging

app = Flask(__name__)

# Setup logging
logging.basicConfig(level=logging.DEBUG)
logger = logging.getLogger(__name__)

# Initialize stemmer
factory = StemmerFactory()
stemmer = factory.create_stemmer()

class DynamicGreetingHandler:
    """
    Handler untuk mendeteksi dan merespon sapaan secara dinamis
    """
    
    def __init__(self):
        self.greeting_patterns = {
            'morning': ['pagi', 'selamat pagi', 'good morning', 'morning'],
            'afternoon': ['siang', 'selamat siang', 'good afternoon', 'afternoon'],
            'evening': ['sore', 'selamat sore', 'good evening'],
            'night': ['malam', 'selamat malam', 'good night', 'night'],
            'hello': ['halo', 'hello', 'hi', 'hey', 'hei', 'hai', 'helo'],
            'how_are_you': ['apa kabar', 'gimana kabar', 'how are you', 'kabar'],
            'thank_you': ['terima kasih', 'thanks', 'thank you', 'makasih', 'mks', 'trims'],
            'welcome': ['sama-sama', 'you\'re welcome', 'kembali kasih'],
            'excuse': ['permisi', 'excuse me', 'maaf', 'sorry'],
            'goodbye': ['bye', 'goodbye', 'sampai jumpa', 'dadah', 'dah', 'see you', 'bye bye'],
            'assalamualaikum': ['assalamualaikum', 'assalamu\'alaikum', 'assalam'],
            'whats_up': ['ada apa', 'what\'s up', 'gimana nih', 'lagi apa'],
            'nice_to_meet': ['senang bertemu', 'nice to meet', 'senang berkenalan', 'senang kenal'],
        }
        
        self.responses = {
            'morning': [
                "Selamat pagi! 🌅 Ada yang bisa saya bantu tentang FIK hari ini?",
                "Pagi! ☀️ Semoga harimu menyenangkan. Ada pertanyaan tentang Fakultas Industri Kreatif?",
                "Selamat pagi! ✨ Saya FIK Assistant, siap membantu Anda!"
            ],
            'afternoon': [
                "Selamat siang! ☀️ Ada yang bisa saya bantu tentang FIK?",
                "Siang! 😊 Waktu yang tepat untuk bertanya tentang Fakultas Industri Kreatif!",
                "Selamat siang! 🌤️ Mari diskusi tentang FIK!"
            ],
            'evening': [
                "Selamat sore! 🌇 Ada yang ingin ditanyakan tentang FIK?",
                "Sore! 🎨 Saya masih siap membantu Anda!",
                "Selamat sore! ✨ Sore yang indah untuk belajar tentang FIK!"
            ],
            'night': [
                "Selamat malam! 🌙 Masih semangat belajar tentang FIK?",
                "Malam! ✨ Ada pertanyaan tentang FIK sebelum beristirahat?",
                "Selamat malam! 😴 Jangan lupa istirahat. Ada yang bisa saya bantu?"
            ],
            'hello': [
                "Halo! 👋 Ada yang bisa saya bantu tentang FIK?",
                "Hello! 😊 Selamat datang di FIK Assistant!",
                "Hi! ✨ Senang bertemu dengan Anda! Ada pertanyaan?"
            ],
            'how_are_you': [
                "Alhamdulillah baik! 😊 Ada yang bisa saya bantu tentang FIK?",
                "Kabar baik! 👍 Semoga Anda juga baik-baik saja. Ada pertanyaan?",
                "Saya sehat! Terima kasih sudah bertanya. Ada yang ingin diketahui tentang FIK?"
            ],
            'thank_you': [
                "Sama-sama! 😊 Senang bisa membantu!",
                "Dengan senang hati! 🤗 Ada lagi yang ingin ditanyakan?",
                "Terima kasih kembali! ✨ Jangan ragu untuk bertanya lagi ya!"
            ],
            'welcome': [
                "😊 Senang bisa membantu!",
                "Siap membantu kapan saja!",
                "Terima kasih kembali!"
            ],
            'excuse': [
                "Ya, silakan! 😊 Ada yang bisa saya bantu?",
                "Iya, ada yang bisa saya bantu tentang FIK?",
                "Silakan, saya siap mendengarkan pertanyaan Anda!"
            ],
            'goodbye': [
                "Sampai jumpa! 👋 Terima kasih sudah berkonsultasi tentang FIK!",
                "Goodbye! 😊 Jangan ragu untuk kembali ya!",
                "Dadah! ✨ Sampai bertemu lagi! Stay creative! 🎨"
            ],
            'assalamualaikum': [
                "Wa'alaikumsalam! 🤲 Ada yang bisa saya bantu?",
                "Wa'alaikumsalam warahmatullahi wabarakatuh\nSelamat datang di FIK Assistant!",
                "Wa'alaikumsalam! 😊 Senang bertemu dengan Anda."
            ],
            'whats_up': [
                "Lagi siap-siap membantu Anda! 😊 Ada yang ingin ditanyakan tentang FIK?",
                "Sedang standby nih! ✨ Ada pertanyaan menarik tentang Fakultas Industri Kreatif?",
                "Siap melayani! 👍 Ada yang mau ditanyakan tentang FIK?"
            ],
            'nice_to_meet': [
                "Saya juga senang berkenalan dengan Anda! 😊 Mari kita eksplorasi FIK bersama!",
                "Senang sekali! 🤗 Ini awal percakapan yang menyenangkan tentang FIK!",
                "Senang berkenalan! ✨ Ada yang ingin ditanyakan tentang FIK?"
            ]
        }
        
        # Casual responses untuk input pendek
        self.casual_responses = {
            'ok': ["Oke! 😊 Ada yang lain?", "Sip! 👍 Siap membantu!", "Baik! ✨ Silakan tanya!"],
            'ya': ["Ya? 😊 Ada pertanyaan?", "Iya? 👂 Silakan tanya!", "Yes? 🤗 Ada yang bisa saya bantu?"],
            'tidak': ["Oh, tidak? 😯 Ada yang ingin ditanyakan?", "Tidak ya? 🤔 Silakan jika ada pertanyaan!", "Oke, tidak masalah! 😊"],
            'hmm': ["Hmm... 🤔 Ada yang membingungkan?", "Menarik... 🧐 Silakan tanya!", "Saya mendengarkan... 👂"],
            'wow': ["Wah! 😲 Ada yang menarik?", "Keren! ✨ Ada pertanyaan?", "Wow! 😄 Silakan tanya!"],
            'hehe': ["Hehe 😄 Ada yang lucu?", "Haha 😂 Ada yang ingin ditanyakan?", "😊"],
            'lol': ["😂 Ada yang lucu ya?", "Haha lucu! Ada pertanyaan?", "😄"],
            'wkwk': ["Wkwk 😂 Ada yang ingin ditanyakan?", "Hahaha! Silakan tanya!", "Lucu ya! 😄"],
        }
        
        # Emoji collections
        self.emojis = {
            'happy': ['😊', '😄', '😃', '😁', '✨', '🌟', '💫', '🎉', '🎊'],
            'friendly': ['🤗', '👋', '👍', '👏', '🙌', '💖', '💕', '💓'],
            'creative': ['🎨', '🧠', '💡', '🔮', '🌈', '🦄', '🚀'],
            'thinking': ['🤔', '🧐', '💭', '💬', '🗯️', '👁️'],
            'academic': ['📚', '🎓', '✏️', '📝', '📖', '📘', '📗', '📙'],
            'fik': ['🏫', '🎭', '🎬', '🎪', '🎤', '🎧', '🎼', '🎸']
        }
    
    def is_greeting(self, text):
        """Check if text is a greeting"""
        text_lower = text.lower().strip()
        
        # Check for exact matches first
        for category, patterns in self.greeting_patterns.items():
            for pattern in patterns:
                if text_lower == pattern or text_lower.startswith(pattern + ' '):
                    logger.debug(f"Greeting detected: {category} - pattern: {pattern}")
                    return category
        
        # Check for contains (for longer sentences)
        for category, patterns in self.greeting_patterns.items():
            for pattern in patterns:
                if pattern in text_lower:
                    logger.debug(f"Greeting detected (contains): {category} - pattern: {pattern}")
                    return category
        
        # Check for casual responses
        if text_lower in self.casual_responses:
            return 'casual_' + text_lower
        
        # Check for very short inputs (1-2 chars)
        if len(text_lower) <= 2 and text_lower.isalpha():
            return 'short_input'
        
        return None
    
    def get_response(self, category, user_name=None):
        """Get appropriate response for greeting category"""
        # Get base response
        if category.startswith('casual_'):
            casual_type = category.replace('casual_', '')
            responses = self.casual_responses.get(casual_type, ["Oke! 😊"])
            response = random.choice(responses)
        elif category == 'short_input':
            responses = ["Hai! 😊", "Ya? 👋", "Halo! ✨", "Saya di sini! 🤗", "Ada pertanyaan?"]
            response = random.choice(responses)
        else:
            responses = self.responses.get(category, ["Halo! Ada yang bisa saya bantu tentang FIK?"])
            response = random.choice(responses)
        
        # Add personal touch if user name is available
        if user_name and category not in ['casual_ok', 'casual_ya', 'casual_tidak', 'short_input']:
            if random.random() > 0.5:  # 50% chance to use name
                response = response.replace('Anda', user_name)
                if '!' in response:
                    parts = response.split('!', 1)
                    response = parts[0] + ' ' + user_name + '!' + parts[1] if len(parts) > 1 else parts[0] + ' ' + user_name + '!'
        
        return response

class FeedbackAwareResponseHandler:
    """
    Handler khusus untuk menangani feedback negatif
    """
    
    def __init__(self):
        self.negative_feedback_patterns = [
            "tidak membantu", "tidak berguna", "kurang membantu", 
            "gak ngebantu", "ga jelas", "ngga membantu", "nggak membantu",
            "jawaban tidak membantu", "jawabanmu tidak membantu",
            "saya tidak puas", "kurang puas", "bukan ini yang saya mau",
            "membingungkan", "tidak jelas", "salah", "kecewa",
            "gak jelas", "ga membantu", "ngga membantu"
        ]
        
        self.feedback_responses = {
            'unhelpful': [
                "Maaf jika jawaban saya kurang membantu 🙏\n\nBoleh ceritakan lebih detail:\n1️⃣ Apa yang sebenarnya Anda butuhkan?\n2️⃣ Ada bagian spesifik yang masih membingungkan?\n3️⃣ Atau mau langsung saya arahkan ke customer service?",
                
                "Oh tidak! 😔 Saya minta maaf kalau jawaban saya tidak membantu.\n\nBantu saya untuk memperbaiki ya:\n• Apa yang membuat jawaban saya kurang membantu?\n• Informasi apa yang sebenarnya Anda cari?\n• Atau Anda ingin bertanya tentang topik lain?",
                
                "Terima kasih atas feedback-nya! 🙏 Saya catat bahwa jawaban saya kurang membantu.\n\nMari coba lagi:\n🎯 Sebenarnya Anda ingin tahu tentang apa?\n🎯 Bisa jelaskan dengan kata-kata yang berbeda?\n🎯 Atau ingin saya cari informasi lebih lanjut?"
            ],
            'unclear': [
                "Saya minta maaf kalau penjelasan saya kurang jelas 😅\n\nMari saya coba ulang. Bisa beri tahu:\n• Kata atau konsep apa yang membingungkan?\n• Anda lebih suka penjelasan singkat atau detail?\n• Butuh contoh konkret?",
                
                "Oke, saya akan coba lebih jelas ya! ✨\n\nUntuk membantu saya:\n🎯 Ini untuk tugas akademik atau kebutuhan pribadi?\n🎯 Anda lebih suka penjelasan teknis atau praktis?\n🎯 Atau ingin saya berikan contoh?",
                
                "Maaf kalau masih membingungkan 🙏\n\nMungkin saya bisa:\n1️⃣ Menjelaskan dengan cara yang berbeda\n2️⃣ Memberikan contoh kasus\n3️⃣ Menunjukkan langkah-langkah praktis\n\nAnda pilih yang mana?"
            ],
            'dissatisfied': [
                "Saya turut prihatin mendengar Anda tidak puas 😔\n\nUntuk memberikan layanan yang lebih baik:\n📞 Saya bisa hubungkan Anda dengan customer service\n📝 Atau Anda ingin saya eskalasi ke tim khusus?\n✨ Atau coba tanyakan hal lain yang bisa saya bantu?",
                
                "Terima kasih atas kejujurannya 🙏 Saya akan berusaha lebih baik.\n\nSekarang, apa yang bisa saya lakukan untuk membantu Anda?\n• Coba tanyakan dengan cara yang berbeda?\n• Atau fokus pada topik lain tentang FIK?"
            ],
            'misunderstanding': [
                "Sepertinya ada kesalahpahaman ya! 🤔\n\nMari kita klarifikasi:\n1️⃣ Bisa ulangi pertanyaan Anda dengan kata-kata yang berbeda?\n2️⃣ Atau ada konteks khusus yang saya lewatkan?\n3️⃣ Mungkin Anda maksud tentang topik lain yang mirip?",
                
                "Maaf, sepertinya saya salah memahami pertanyaan Anda 😅\n\nBisa jelaskan ulang dengan lebih detail? Saya akan berusaha lebih baik."
            ],
            'general': [
                "Terima kasih atas masukan Anda! 🙏\n\nCatatan Anda sangat berharga untuk perbaikan saya.\n\nSekarang, apa yang bisa saya lakukan untuk membantu Anda dengan lebih baik?",
                
                "Saya hargai feedback Anda. Ini akan membantu saya belajar dan berkembang.\n\nAda pertanyaan lain yang bisa saya bantu?"
            ]
        }
    
    def is_negative_feedback(self, user_input):
        """Deteksi jika input user adalah feedback negatif"""
        user_input_lower = user_input.lower().strip()
        
        # Cek pattern umum
        for pattern in self.negative_feedback_patterns:
            if pattern in user_input_lower:
                logger.debug(f"Negative feedback detected: {pattern}")
                return True
        
        return False
    
    def get_feedback_based_response(self, user_input, previous_response=None):
        """
        Generate response khusus untuk feedback negatif
        """
        user_input_lower = user_input.lower().strip()
        
        # Response berdasarkan tipe feedback
        if any(phrase in user_input_lower for phrase in ["tidak membantu", "kurang membantu", "gak ngebantu", "ngga membantu"]):
            return random.choice(self.feedback_responses['unhelpful'])
        
        elif any(phrase in user_input_lower for phrase in ["ga jelas", "tidak jelas", "membingungkan", "gak jelas"]):
            return random.choice(self.feedback_responses['unclear'])
        
        elif any(phrase in user_input_lower for phrase in ["saya tidak puas", "kurang puas", "kecewa"]):
            return random.choice(self.feedback_responses['dissatisfied'])
        
        elif any(phrase in user_input_lower for phrase in ["bukan ini", "salah", "bukan yang saya maksud"]):
            return random.choice(self.feedback_responses['misunderstanding'])
        
        else:
            return random.choice(self.feedback_responses['general'])

class AnswerNaturalizer:
    """
    Kelas untuk membuat jawaban database menjadi lebih natural
    TANPA mengubah informasi penting
    """
    
    def __init__(self):
        # Kata-kata formal yang bisa diganti
        self.formal_to_casual = {
            'adalah': 'itu',
            'merupakan': 'adalah',
            'ialah': 'yaitu',
            'tersebut': 'ini',
            'dapat': 'bisa',
            'melakukan': 'ngerjain',
            'menggunakan': 'pakai',
            'memiliki': 'punya',
            'terdapat': 'ada',
            'sebagai': 'buat',
            'untuk': 'buat',
            'bagi': 'untuk',
            'kepada': 'ke',
            'merupakan': 'adalah'
        }
        
        # Pengantar untuk berbagai tipe jawaban
        self.intros = {
            'definition': [
                "Jadi gini, ",
                "Begini penjelasannya, ",
                "Intinya sih, ",
                "Kalau dijabarin, ",
                "Singkatnya, "
            ],
            'location': [
                "Lokasinya ada di ",
                "Tempatnya di ",
                "Berada di ",
                "Bisa ditemukan di ",
                "Letaknya di "
            ],
            'procedure': [
                "Nih caranya:\n",
                "Ikuti langkah-langkah ini:\n",
                "Gini langkah-langkahnya:\n",
                "Prosedurnya:\n"
            ],
            'list': [
                "Berikut daftarnya:\n",
                "Ini dia:\n",
                "Antara lain:\n"
            ],
            'general': [
                "Begini, ",
                "Oh, itu.. ",
                "Jadi, ",
                "Nah, "
            ]
        }
        
        # Penutup yang friendly
        self.outros = [
            "\n\nGimana, sudah cukup jelas? 😊",
            "\n\nSemoga membantu ya! ✨",
            "\n\nAda yang mau ditanyakan lagi?",
            "\n\nOke, itu informasinya!",
            "\n\nSemoga penjelasannya membantu! 🙏"
        ]
    
    def detect_answer_type(self, answer):
        """Deteksi tipe jawaban"""
        answer_lower = answer.lower()
        
        if any(word in answer_lower for word in ['langkah', 'prosedur', 'cara', 'tahap', 'step']):
            return 'procedure'
        elif any(word in answer_lower for word in ['berada di', 'terletak di', 'lokasi', 'di gedung', 'di lantai']):
            return 'location'
        elif any(word in answer_lower for word in ['adalah', 'yaitu', 'merupakan']):
            return 'definition'
        elif any(word in answer_lower for word in ['1.', '2.', '3.', 'pertama', 'kedua', 'ketiga', '-']):
            return 'list'
        else:
            return 'general'
    
    def naturalize(self, answer, question, intent='general'):
        """
        Membuat jawaban lebih natural tanpa mengubah informasi
        """
        if not answer:
            return answer
        
        # Jangan naturalize jika jawaban sudah cukup pendek
        if len(answer.split()) < 20:
            return answer
        
        answer_type = self.detect_answer_type(answer)
        
        # Pilih intro yang sesuai
        intro = random.choice(self.intros.get(answer_type, self.intros['general']))
        
        # Untuk list, pertahankan format asli tapi tambahkan intro
        if answer_type == 'list' and ('1.' in answer or '2.' in answer or '-' in answer):
            # Hapus intro dari jawaban asli jika ada
            lines = answer.split('\n')
            clean_lines = []
            for line in lines:
                if not any(line.lower().startswith(word) for word in ['berikut', 'daftar', 'antara lain']):
                    clean_lines.append(line)
            
            if clean_lines:
                answer = '\n'.join(clean_lines)
        
        # Untuk location, pastikan tidak double intro
        elif answer_type == 'location':
            # Hapus kata "berada di", "terletak di" dari awal jika ada
            answer = re.sub(r'^(berada di|terletak di|lokasi|berlokasi di)\s+', '', answer, flags=re.IGNORECASE)
        
        # Untuk definition, pastikan natural
        elif answer_type == 'definition':
            # Ganti beberapa kata formal
            for formal, casual in self.formal_to_casual.items():
                answer = re.sub(r'\b' + formal + r'\b', casual, answer, flags=re.IGNORECASE)
        
        # Untuk procedure, tambahkan panduan
        elif answer_type == 'procedure':
            # Jika prosedur dalam format list, pertahankan
            pass
        
        # Gabungkan intro dengan jawaban
        # Pastikan tidak double kalimat
        first_sentence = answer.split('.')[0] if '.' in answer else answer
        
        # Jika jawaban sudah memiliki intro sendiri, gunakan apa adanya
        if any(first_sentence.lower().startswith(word) for word in ['berikut', 'ini', 'ada', 'dapat']):
            naturalized = answer
        else:
            naturalized = intro + answer[0].lower() + answer[1:] if answer else answer
        
        # Tambahkan outro (30% chance)
        if random.random() > 0.7:
            naturalized += random.choice(self.outros)
        
        return naturalized

class AnswerExpander:
    """
    Kelas untuk menambah konteks pada jawaban pendek
    HANYA untuk jawaban yang sangat pendek
    """
    
    def __init__(self):
        # Konteks tambahan berdasarkan intent
        self.context_additions = {
            'location': [
                " Untuk info lebih lanjut tentang lokasi ini, bisa tanya ke petugas atau cek peta kampus ya!",
                " Kalau kesulitan menemukan lokasinya, tanya aja ke security atau teman kampus.",
                " Pastikan cek jam operasional sebelum berkunjung ya!"
            ],
            'person': [
                " Untuk menghubungi beliau, sebaiknya buat janji dulu ya.",
                " Beliau biasanya ada di ruangan saat jam kerja.",
                " Siapkan pertanyaan dengan baik sebelum bertemu ya!"
            ],
            'time': [
                " Jadwal bisa berubah saat libur nasional atau acara khusus.",
                " Selalu cek update terbaru di portal akademik ya!",
                " Jangan lupa set reminder biar nggak lupa!"
            ],
            'method': [
                " Ikuti langkah-langkahnya dengan urut ya.",
                " Kalau ada yang bingung, tanya ke petugas yang bertugas.",
                " Siapkan dokumen yang diperlukan sebelum memulai."
            ],
            'definition': [
                " Semoga penjelasannya membantu ya!",
                " Ada yang mau ditanyakan lebih lanjut?",
                " Kalau butuh contoh, bisa tanya lagi!"
            ],
            'general': [
                " Semoga informasinya membantu!",
                " Ada yang ingin ditanyakan lagi?",
                " Jangan ragu untuk bertanya lebih lanjut ya!"
            ]
        }
    
    def needs_expansion(self, answer):
        """Cek apakah jawaban perlu ditambah konteks"""
        word_count = len(answer.split())
        return word_count < 30  # Hanya untuk jawaban sangat pendek
    
    def expand(self, answer, intent='general'):
        """Tambah konteks minimal pada jawaban pendek"""
        if not self.needs_expansion(answer):
            return answer
        
        # Pilih konteks tambahan yang sesuai
        additions = self.context_additions.get(intent, self.context_additions['general'])
        addition = random.choice(additions)
        
        return answer + addition

class QuestionAnalyzer:
    """
    Kelas untuk menganalisis pertanyaan user
    """
    
    def __init__(self):
        self.intent_patterns = {
            'location': [
                r'(?:dimana|di mana|letak|lokasi|tempat)\s+(.+?)\??$',
                r'(?:di|ke)\s+(.+?)\s+(?:dimana|di mana)\??$'
            ],
            'person': [
                r'(?:siapa|siapakah)\s+(.+?)\??$',
                r'(?:nama)\s+(.+?)\s+(?:siapa)\??$'
            ],
            'time': [
                r'(?:kapan|jam berapa|waktu|jadwal)\s+(.+?)\??$',
                r'(?:pukul|tanggal)\s+(.+?)\??$'
            ],
            'method': [
                r'(?:bagaimana|cara|gimana|prosedur|langkah)\s+(.+?)\??$',
                r'bagaimana\s+(?:cara|caranya)\s+(.+?)\??$'
            ],
            'quantity': [
                r'(?:berapa|jumlah|banyak|total)\s+(.+?)\??$'
            ],
            'definition': [
                r'(?:apa|apakah|apa itu|pengertian|definisi)\s+(.+?)\??$'
            ]
        }
        
        self.fik_keywords = [
            'fik', 'fakultas', 'industri kreatif', 'dkv', 'desain interior', 
            'desain produk', 'kriya', 'seni rupa', 'film', 'animasi',
            'laboratorium', 'lab', 'studio', 'dosen', 'mahasiswa',
            'beasiswa', 'krs', 'skripsi', 'akademik', 'jadwal'
        ]
    
    def detect_intent(self, question):
        """Deteksi intent dari pertanyaan"""
        q = question.lower().strip()
        
        # Check patterns
        for intent, patterns in self.intent_patterns.items():
            for pattern in patterns:
                if re.search(pattern, q, re.IGNORECASE):
                    logger.debug(f"Intent detected: {intent}")
                    return intent
        
        # Check keywords
        if any(word in q for word in ['dimana', 'di mana', 'lokasi', 'letak']):
            return 'location'
        elif any(word in q for word in ['siapa', 'siapakah', 'nama']):
            return 'person'
        elif any(word in q for word in ['kapan', 'jam', 'waktu', 'jadwal']):
            return 'time'
        elif any(word in q for word in ['bagaimana', 'gimana', 'cara', 'prosedur']):
            return 'method'
        elif any(word in q for word in ['berapa', 'jumlah', 'total']):
            return 'quantity'
        else:
            return 'general'
    
    def extract_keywords(self, question):
        """Ekstrak keyword penting dari pertanyaan"""
        stopwords = ['apa', 'adalah', 'yang', 'di', 'ke', 'dari', 'untuk', 
                     'bagaimana', 'dimana', 'kapan', 'siapa', 'dengan', 'ini',
                     'itu', 'dan', 'atau', 'tapi', 'pada', 'dalam', 'untuk',
                     'saya', 'anda', 'kami', 'mereka', 'bisa', 'dapat']
        
        words = re.findall(r'\b[a-z]{3,}\b', question.lower())
        keywords = [w for w in words if w not in stopwords]
        
        return keywords[:5]  # Max 5 keywords
    
    def is_fik_related(self, question):
        """Cek apakah pertanyaan terkait FIK"""
        q_lower = question.lower()
        for keyword in self.fik_keywords:
            if keyword in q_lower:
                return True
        return False

# Initialize handlers
greeting_handler = DynamicGreetingHandler()
feedback_handler = FeedbackAwareResponseHandler()
naturalizer = AnswerNaturalizer()
expander = AnswerExpander()
analyzer = QuestionAnalyzer()

@app.route('/generate', methods=['POST'])
def generate_answer():
    """
    Main endpoint untuk generate jawaban
    """
    try:
        data = request.json
        question = data.get('question', '').strip()
        base_answer = data.get('base_answer', '').strip()
        context = data.get('context', {})
        
        logger.debug(f"Generate request - Question: {question}")
        logger.debug(f"Base answer length: {len(base_answer)} chars")
        
        if not question:
            return jsonify({
                'status': 'error',
                'message': 'Question is required'
            }), 400
        
        # PERBAIKAN: Cek feedback negatif
        if feedback_handler.is_negative_feedback(question):
            logger.debug("Negative feedback detected")
            previous_response = context.get('previous_response', '')
            feedback_response = feedback_handler.get_feedback_based_response(question, previous_response)
            
            return jsonify({
                'status': 'success',
                'is_feedback': True,
                'feedback_type': 'negative',
                'enhanced_answer': feedback_response,
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
        
        # Cek greeting
        greeting_type = greeting_handler.is_greeting(question)
        if greeting_type:
            logger.debug(f"Greeting detected: {greeting_type}")
            user_name = context.get('user_name')
            response = greeting_handler.get_response(greeting_type, user_name)
            
            return jsonify({
                'status': 'success',
                'is_greeting': True,
                'greeting_type': greeting_type,
                'enhanced_answer': response,
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
        
        # Analisis pertanyaan
        intent = analyzer.detect_intent(question)
        keywords = analyzer.extract_keywords(question)
        is_fik_related = analyzer.is_fik_related(question)
        
        logger.debug(f"Intent: {intent}, Keywords: {keywords}, FIK related: {is_fik_related}")
        
        if base_answer:
            # PERBAIKAN: Naturalize dulu
            naturalized = naturalizer.naturalize(base_answer, question, intent)
            
            # PERBAIKAN: Expand hanya jika sangat pendek
            final_answer = expander.expand(naturalized, intent)
            
            # Hitung statistik
            word_count = len(final_answer.split())
            original_words = len(base_answer.split())
            
            logger.debug(f"Original words: {original_words}, Final words: {word_count}")
            
            return jsonify({
                'status': 'success',
                'original_answer': base_answer,
                'enhanced_answer': final_answer,
                'transformation_applied': True,
                'was_expanded': expander.needs_expansion(base_answer),
                'intent': intent,
                'keywords': keywords,
                'is_fik_related': is_fik_related,
                'statistics': {
                    'original_words': original_words,
                    'final_words': word_count,
                    'word_increase': word_count - original_words
                },
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
        else:
            # Fallback response
            if is_fik_related:
                fallback = f"Maaf, saya belum menemukan informasi tentang '{question}' di database FIK. 😔\n\nPertanyaan Anda akan dicatat untuk dijawab tim FIK. Sementara itu, Anda bisa mencoba bertanya tentang program studi, fasilitas, atau jadwal di FIK."
            else:
                fallback = "Maaf, saya hanya bisa membantu dengan pertanyaan seputar Fakultas Industri Kreatif (FIK) Telkom University. 😊\n\nSilakan tanya tentang program studi, fasilitas, jadwal, atau informasi FIK lainnya!"
            
            return jsonify({
                'status': 'success',
                'enhanced_answer': fallback,
                'is_fallback': True,
                'intent': intent,
                'keywords': keywords,
                'is_fik_related': is_fik_related,
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
    
    except Exception as e:
        logger.error(f"Error in generate_answer: {str(e)}")
        return jsonify({
            'status': 'error',
            'message': str(e)
        }), 500

@app.route('/detect_greeting', methods=['POST'])
def detect_greeting_endpoint():
    """Endpoint untuk deteksi greeting"""
    try:
        data = request.json
        question = data.get('question', '').strip()
        user_name = data.get('user_name')
        
        if not question:
            return jsonify({'status': 'error', 'message': 'Question required'}), 400
        
        greeting_type = greeting_handler.is_greeting(question)
        
        if greeting_type:
            response = greeting_handler.get_response(greeting_type, user_name)
            
            return jsonify({
                'status': 'success',
                'is_greeting': True,
                'greeting_type': greeting_type,
                'response': response,
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
        else:
            return jsonify({
                'status': 'success',
                'is_greeting': False,
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            })
    
    except Exception as e:
        logger.error(f"Error in detect_greeting: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/analyze_question', methods=['POST'])
def analyze_question_endpoint():
    """Endpoint untuk analisis pertanyaan"""
    try:
        data = request.json
        question = data.get('question', '').strip()
        
        if not question:
            return jsonify({'status': 'error', 'message': 'Question required'}), 400
        
        intent = analyzer.detect_intent(question)
        keywords = analyzer.extract_keywords(question)
        is_fik_related = analyzer.is_fik_related(question)
        greeting_type = greeting_handler.is_greeting(question)
        is_feedback = feedback_handler.is_negative_feedback(question)
        
        return jsonify({
            'status': 'success',
            'analysis': {
                'question': question,
                'intent': intent,
                'keywords': keywords,
                'is_fik_related': is_fik_related,
                'is_greeting': greeting_type is not None,
                'greeting_type': greeting_type,
                'is_negative_feedback': is_feedback,
                'word_count': len(question.split()),
                'char_count': len(question),
                'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            }
        })
    
    except Exception as e:
        logger.error(f"Error in analyze_question: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/naturalize', methods=['POST'])
def naturalize_endpoint():
    """Endpoint untuk testing naturalization"""
    try:
        data = request.json
        answer = data.get('answer', '').strip()
        question = data.get('question', '').strip()
        
        if not answer or not question:
            return jsonify({'status': 'error', 'message': 'Answer and question required'}), 400
        
        intent = analyzer.detect_intent(question)
        naturalized = naturalizer.naturalize(answer, question, intent)
        
        return jsonify({
            'status': 'success',
            'original': answer,
            'naturalized': naturalized,
            'intent': intent,
            'answer_type': naturalizer.detect_answer_type(answer),
            'statistics': {
                'original_words': len(answer.split()),
                'naturalized_words': len(naturalized.split()),
                'increase': len(naturalized.split()) - len(answer.split())
            },
            'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        })
    
    except Exception as e:
        logger.error(f"Error in naturalize: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/feedback/test', methods=['POST'])
def test_feedback():
    """Endpoint untuk test feedback detection"""
    try:
        data = request.json
        user_input = data.get('user_input', '').strip()
        
        if not user_input:
            return jsonify({'status': 'error', 'message': 'User input required'}), 400
        
        is_feedback = feedback_handler.is_negative_feedback(user_input)
        response = feedback_handler.get_feedback_based_response(user_input) if is_feedback else "Not a feedback"
        
        return jsonify({
            'status': 'success',
            'is_negative_feedback': is_feedback,
            'suggested_response': response,
            'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        })
    
    except Exception as e:
        logger.error(f"Error in test_feedback: {str(e)}")
        return jsonify({'status': 'error', 'message': str(e)}), 500

@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'FIK Assistant AI Engine',
        'version': '2.0',
        'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
        'modules': {
            'greeting_handler': 'active',
            'feedback_handler': 'active',
            'naturalizer': 'active',
            'expander': 'active',
            'analyzer': 'active'
        },
        'features': [
            'Natural Language Transformation',
            'Greeting Detection',
            'Feedback Detection',
            'Question Analysis',
            'Smart Fallback'
        ]
    })

@app.route('/', methods=['GET'])
def index():
    """API info"""
    return jsonify({
        'service': 'FIK Assistant AI Engine',
        'version': '2.0',
        'description': 'AI Engine untuk membantu pertanyaan seputar Fakultas Industri Kreatif',
        'endpoints': {
            'POST /generate': 'Generate enhanced answer',
            'POST /detect_greeting': 'Detect and respond to greetings',
            'POST /analyze_question': 'Analyze question intent and keywords',
            'POST /naturalize': 'Test natural transformation',
            'POST /feedback/test': 'Test feedback detection',
            'GET /health': 'Health check'
        },
        'features': [
            'Natural language transformation tanpa menghilangkan informasi',
            'Greeting detection dengan 12+ tipe sapaan',
            'Negative feedback detection dengan respons empatik',
            'Question analysis dengan intent detection',
            'Smart fallback untuk pertanyaan di luar scope',
            'FIK-specific keyword recognition'
        ],
        'transformation_examples': [
            {
                'before': 'Laboratorium komputer berada di Gedung A lantai 3.',
                'after': 'Lokasinya ada di Gedung A lantai 3.'
            },
            {
                'before': '1. Login ke SITS. 2. Pilih menu KRS. 3. Submit.',
                'after': 'Nih caranya:\n1. Login ke SITS\n2. Pilih menu KRS\n3. Submit'
            }
        ],
        'timestamp': datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    })

def print_banner():
    """Print startup banner"""
    banner = """
    ╔═══════════════════════════════════════════════════════════════════╗
    ║                                                                   ║
    ║   🚀 FIK ASSISTANT AI ENGINE v2.0                                ║
    ║   💬 Natural Language Transformation                             ║
    ║                                                                   ║
    ╚═══════════════════════════════════════════════════════════════════╝
    
    🌟 **FITUR UTAMA**:
       • Natural transformation tanpa kehilangan informasi
       • Greeting detection (12+ tipe sapaan)
       • Feedback detection dengan respons empatik
       • Question analysis dengan intent detection
       • Smart fallback untuk pertanyaan di luar scope
    
    🎯 **TRANSFORMASI**:
       • Definition: "adalah" → "itu", "merupakan" → "adalah"
       • Location: "berada di" → "lokasinya di"
       • Procedure: Tambah panduan langkah
    
    📊 **ANALISIS PERTANYAAN**:
       • Intent detection (location, person, time, method, quantity, definition)
       • Keyword extraction
       • FIK relevance check
    
    ⚡ SERVER: http://localhost:5000
    """
    print(banner)

if __name__ == '__main__':
    print_banner()
    app.run(host='0.0.0.0', port=5000, debug=True)