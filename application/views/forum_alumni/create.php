<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Buat Postingan Baru - Forum Alumni | Fakultas Industri Kreatif</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1f2937;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #ffedd5;
            --blue: #1e3a8a;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

        /* Header Styles */
        .header-glass {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .container-custom {
            width: min(100% - 3rem, 1280px);
            margin-inline: auto;
        }

        .navbar-glass {
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: #2d3e50;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .logo-text h5 {
            font-size: 0.9rem;
            font-weight: 800;
            color: white;
            margin: 0;
            line-height: 1.2;
        }

        .logo-text span {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.85);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid transparent;
            padding-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-links a.active, .nav-links a:hover {
            border-bottom-color: #f97316;
        }

        /* Dropdown Layanan */
        .dropdown-wrapper {
            position: relative;
        }

        .dropdown-wrapper > a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
        }

        .dropdown-wrapper > a i {
            font-size: 0.7rem;
            transition: transform 0.3s ease;
        }

        .dropdown-wrapper.open > a i {
            transform: rotate(180deg);
        }

        .dropdown-menu-custom {
            position: absolute;
            top: calc(100% + 16px);
            left: 50%;
            transform: translateX(-50%) translateY(-12px);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            border-radius: 24px;
            padding: 16px 20px;
            min-width: 820px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .dropdown-wrapper.open .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .dropdown-item {
            padding: 24px 16px;
            text-align: center;
            border-radius: 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: #1f2937;
            background: rgba(249, 115, 22, 0.02);
            min-height: 160px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .dropdown-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(249, 115, 22, 0.15);
            background: #fff7ed;
        }

        .dropdown-item .d-icon-wrapper {
            width: 56px;
            height: 56px;
            margin: 0 auto 12px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .dropdown-item .d-icon-wrapper i {
            font-size: 1.6rem;
            color: #f97316;
        }

        .dropdown-item .d-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .dropdown-item .d-desc {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .btn-mytelu-custom {
            background: #f97316;
            padding: 8px 28px;
            border-radius: 40px;
            font-weight: 700;
            color: white;
            transition: 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-mytelu-custom:hover {
            background: #ea580c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        .user-avatar-small {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
        }

        .mobile-toggle {
            display: none;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 8px 14px;
            font-size: 1.4rem;
            color: white;
            cursor: pointer;
        }

        /* Create Post Form Styles */
        .create-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 100px 20px 60px;
        }

        .create-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .create-header {
            padding: 24px 28px;
            border-bottom: 1px solid #eef2f6;
        }

        .create-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .create-header h2 i {
            color: #f97316;
            font-size: 1.8rem;
        }

        .create-body {
            padding: 28px;
        }

        /* User Info Bar */
        .user-info-bar {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eef2f6;
        }

        .avatar-large {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #fdba74);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.4rem;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name-large h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
        }

        .user-name-large p {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 4px 0 0;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            display: block;
            color: #374151;
        }

        .form-control {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 18px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 150px;
        }

        /* Media Upload Area */
        .media-upload-area {
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #fafafc;
        }

        .media-upload-area:hover {
            border-color: #f97316;
            background: #fff7ed;
        }

        .media-upload-area i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .media-upload-area p {
            margin: 0;
            color: #6b7280;
        }

        .media-upload-area .upload-hint {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 8px;
        }

        .media-preview-container {
            margin-top: 16px;
            position: relative;
            display: inline-block;
        }

        .media-preview-container img,
        .media-preview-container video {
            max-width: 100%;
            max-height: 300px;
            border-radius: 16px;
            background: #f3f4f6;
        }

        .remove-media-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .remove-media-btn:hover {
            background: rgba(0,0,0,0.9);
            transform: scale(1.05);
        }

        /* Type Selector */
        .type-selector {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .type-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 60px;
            background: white;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .type-btn.active {
            border-color: #f97316;
            background: #fff7ed;
            color: #f97316;
        }

        .type-btn i {
            font-size: 1.2rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 16px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #eef2f6;
        }

        .btn-cancel {
            flex: 1;
            padding: 14px;
            border-radius: 60px;
            font-weight: 600;
            background: white;
            border: 1px solid #e2e8f0;
            color: #4b5563;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
            border-color: #cbd5e1;
        }

        .btn-post {
            flex: 1;
            padding: 14px;
            border-radius: 60px;
            font-weight: 600;
            background: #f97316;
            border: none;
            color: white;
            transition: all 0.2s;
        }

        .btn-post:hover {
            background: #ea580c;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .btn-post:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .alert-custom {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .dropdown-menu-custom {
                min-width: unset;
                width: 90vw;
                max-width: 600px;
            }
            .dropdown-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar-glass { flex-direction: column; align-items: stretch; }
            .nav-links { display: none; flex-direction: column; align-items: center; margin-top: 12px; gap: 16px; }
            .nav-links.open { display: flex !important; }
            .mobile-toggle { display: block; align-self: flex-end; }
            .dropdown-menu-custom { min-width: unset; width: 95vw; max-width: 380px; left: 50%; padding: 10px; }
            .dropdown-grid { grid-template-columns: 1fr 1fr; gap: 4px; }
            .dropdown-item { padding: 12px 8px; min-height: 100px; }
            .dropdown-item .d-icon-wrapper { width: 36px; height: 36px; margin-bottom: 6px; }
            .dropdown-item .d-icon-wrapper i { font-size: 1rem; }
            .dropdown-item .d-title { font-size: 0.7rem; white-space: normal; }
            .dropdown-item .d-desc { font-size: 0.6rem; max-width: unset; }
            .create-container {
                padding: 80px 16px 40px;
            }
            .create-body {
                padding: 20px;
            }
            .type-btn span {
                display: none;
            }
            .type-btn i {
                margin: 0;
            }
        }
    </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'forum_alumni']); ?>

<!-- MAIN CONTENT CREATE POST -->
<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <h2>
                <i class="fas fa-pen-fancy"></i>
                Buat Postingan Baru
            </h2>
        </div>
        
        <div class="create-body">
            <!-- Tampilkan pesan error jika ada -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert-custom alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <!-- User Info -->
            <div class="user-info-bar">
                <div class="avatar-large">
                    <?php if (!empty($user_data['foto'])): ?>
                        <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" alt="">
                    <?php else: ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                </div>
                <div class="user-name-large">
                    <h3><?= htmlspecialchars($user_data['nama']) ?></h3>
                    <p><i class="fas fa-graduation-cap"></i> Alumni Fakultas Industri Kreatif</p>
                </div>
            </div>
            
            <form action="<?= base_url('forum_alumni/store') ?>" method="POST" enctype="multipart/form-data" id="createPostForm">
                <!-- Konten Postingan -->
                <div class="form-group">
                    <label class="form-label">Apa yang ingin Anda bagikan?</label>
                    <textarea name="content" class="form-control" placeholder="Tulis cerita, pengalaman, atau info menarik di sini..." required></textarea>
                </div>
                
                <!-- Tipe Media Selector -->
                <div class="form-group">
                    <label class="form-label">Tambah Media (Opsional)</label>
                    <div class="type-selector">
                        <button type="button" class="type-btn active" data-type="text" id="textTypeBtn">
                            <i class="fas fa-align-left"></i> <span>Teks Saja</span>
                        </button>
                        <button type="button" class="type-btn" data-type="image" id="imageTypeBtn">
                            <i class="fas fa-image"></i> <span>Foto</span>
                        </button>
                        <button type="button" class="type-btn" data-type="video" id="videoTypeBtn">
                            <i class="fas fa-video"></i> <span>Video</span>
                        </button>
                    </div>
                </div>
                
                <!-- Upload Area untuk Foto -->
                <div class="form-group" id="imageUploadArea" style="display: none;">
                    <div class="media-upload-area" id="imageUploadBtn">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Klik untuk upload foto</p>
                        <p class="upload-hint">Format: JPG, PNG, GIF, WEBP (Max 10MB)</p>
                    </div>
                    <div id="imagePreview"></div>
                    <input type="file" name="post_image" id="imageFileInput" accept="image/*" style="display: none;">
                </div>
                
                <!-- Upload Area untuk Video -->
                <div class="form-group" id="videoUploadArea" style="display: none;">
                    <div class="media-upload-area" id="videoUploadBtn">
                        <i class="fas fa-video"></i>
                        <p>Klik untuk upload video</p>
                        <p class="upload-hint">Format: MP4, MOV, WEBM (Max 50MB)</p>
                    </div>
                    <div id="videoPreview"></div>
                    <input type="file" name="post_video" id="videoFileInput" accept="video/*" style="display: none;">
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="<?= base_url('forum_alumni') ?>" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn-post" id="submitBtn">
                        <i class="fas fa-paper-plane"></i> Posting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="container-custom">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="logo-icon" style="background: rgba(255,255,255,0.2);">
                        <i class="fas fa-paintbrush-fine"></i>
                    </div>
                    <div>
                        <h5 style="color: white; margin: 0;">Unit Kemahasiswaan</h5>
                        <span style="color: rgba(255,255,255,0.8); font-size: 0.8rem;">Fakultas Industri Kreatif</span>
                    </div>
                </div>
                <p style="color: rgba(255,255,255,0.8); font-size: 0.85rem; line-height: 1.6;">
                    Membangun generasi kreatif, inovatif, dan berdaya saing global melalui pengembangan minat, bakat, dan prestasi mahasiswa.
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <h6 style="color: white; font-weight: 700; margin-bottom: 20px;">Tautan Cepat</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 10px;"><a href="<?= base_url() ?>" style="color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.85rem;">Dashboard</a></li>
                    <li style="margin-bottom: 10px;"><a href="<?= base_url('berita') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.85rem;">Informasi</a></li>
                    <li style="margin-bottom: 10px;"><a href="<?= base_url('forum_alumni') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.85rem;">Forum Alumni</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h6 style="color: white; font-weight: 700; margin-bottom: 20px;">Ikuti Kami</h6>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="color: white; font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                    <a href="#" style="color: white; font-size: 1.5rem;"><i class="fab fa-twitter"></i></a>
                    <a href="#" style="color: white; font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                    <a href="#" style="color: white; font-size: 1.5rem;"><i class="fab fa-linkedin"></i></a>
                </div>
                <p style="color: rgba(255,255,255,0.7); font-size: 0.75rem; margin-top: 20px;">
                    <i class="fas fa-envelope"></i> humas@telkomuniversity.ac.id
                </p>
            </div>
        </div>
        <hr style="border-color: rgba(255,255,255,0.2); margin: 20px 0;">
        <div style="text-align: center; color: rgba(255,255,255,0.7); font-size: 0.75rem;">
            &copy; <?= date('Y') ?> Fakultas Industri Kreatif - Telkom University. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

    
    // Media Type Selector
    const textTypeBtn = document.getElementById('textTypeBtn');
    const imageTypeBtn = document.getElementById('imageTypeBtn');
    const videoTypeBtn = document.getElementById('videoTypeBtn');
    const imageUploadArea = document.getElementById('imageUploadArea');
    const videoUploadArea = document.getElementById('videoUploadArea');
    const imageFileInput = document.getElementById('imageFileInput');
    const videoFileInput = document.getElementById('videoFileInput');
    const imageUploadBtn = document.getElementById('imageUploadBtn');
    const videoUploadBtn = document.getElementById('videoUploadBtn');
    const imagePreview = document.getElementById('imagePreview');
    const videoPreview = document.getElementById('videoPreview');
    
    let selectedType = 'text';
    
    function updateMediaType(type) {
        selectedType = type;
        
        // Update active class
        textTypeBtn.classList.remove('active');
        imageTypeBtn.classList.remove('active');
        videoTypeBtn.classList.remove('active');
        
        if (type === 'text') {
            textTypeBtn.classList.add('active');
            imageUploadArea.style.display = 'none';
            videoUploadArea.style.display = 'none';
        } else if (type === 'image') {
            imageTypeBtn.classList.add('active');
            imageUploadArea.style.display = 'block';
            videoUploadArea.style.display = 'none';
        } else if (type === 'video') {
            videoTypeBtn.classList.add('active');
            imageUploadArea.style.display = 'none';
            videoUploadArea.style.display = 'block';
        }
    }
    
    textTypeBtn.addEventListener('click', () => updateMediaType('text'));
    imageTypeBtn.addEventListener('click', () => updateMediaType('image'));
    videoTypeBtn.addEventListener('click', () => updateMediaType('video'));
    
    // Image Upload
    if (imageUploadBtn) {
        imageUploadBtn.addEventListener('click', () => imageFileInput.click());
    }
    
    if (imageFileInput) {
        imageFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div class="media-preview-container">
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="remove-media-btn" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Video Upload
    if (videoUploadBtn) {
        videoUploadBtn.addEventListener('click', () => videoFileInput.click());
    }
    
    if (videoFileInput) {
        videoFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    videoPreview.innerHTML = `
                        <div class="media-preview-container">
                            <video controls style="max-height: 250px;">
                                <source src="${e.target.result}" type="video/mp4">
                            </video>
                            <button type="button" class="remove-media-btn" onclick="removeVideo()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    function removeImage() {
        imagePreview.innerHTML = '';
        imageFileInput.value = '';
    }
    
    function removeVideo() {
        videoPreview.innerHTML = '';
        videoFileInput.value = '';
    }
    
    // Form validation before submit
    const form = document.getElementById('createPostForm');
    const submitBtn = document.getElementById('submitBtn');
    const contentTextarea = document.querySelector('textarea[name="content"]');
    
    function validateForm() {
        const content = contentTextarea.value.trim();
        if (!content) {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }
    
    contentTextarea.addEventListener('input', validateForm);
    validateForm();
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        validateForm();
    });
</script>

</body>
</html>