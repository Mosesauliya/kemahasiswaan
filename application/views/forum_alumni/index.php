<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Forum Alumni - Fakultas Industri Kreatif | Telkom University</title>

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
            min-width: 700px;
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
            grid-template-columns: repeat(4, 1fr);
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

        /* Forum Styles */
        .forum-container {
            max-width: 680px;
            margin: 0 auto;
            padding: 100px 20px 40px;
        }
        
        .create-post-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #eef2f6;
        }
        
        .post-input-area {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .avatar-circle {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #fdba74);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .post-input {
            flex: 1;
        }
        
        .post-input textarea {
            width: 100%;
            border: none;
            resize: none;
            font-size: 1rem;
            padding: 12px 0;
            font-family: inherit;
            background: #fafafc;
            cursor: pointer;
        }
        
        .post-input textarea:focus {
            outline: none;
        }
        
        .post-input textarea[readonly] {
            background: #fafafc;
            cursor: pointer;
        }
        
        .post-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid #eef2f6;
        }
        
        .media-buttons {
            display: flex;
            gap: 16px;
        }
        
        .media-btn {
            background: none;
            border: none;
            color: #6b7280;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 40px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .media-btn:hover {
            background: #f3f4f6;
            color: #f97316;
        }
        
        .post-submit {
            background: #f97316;
            color: white;
            border: none;
            padding: 8px 28px;
            border-radius: 40px;
            font-weight: 600;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        
        .post-submit:hover {
            background: #ea580c;
            transform: translateY(-1px);
        }
        
        .post-card {
            background: white;
            border-radius: 20px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #eef2f6;
            transition: all 0.2s;
        }
        
        .post-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px 8px;
        }
        
        .post-user {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .user-info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
        }
        
        .user-info span {
            font-size: 0.7rem;
            color: #6b7280;
        }
        
        .post-menu {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s;
        }
        
        .post-menu:hover {
            background: #f3f4f6;
            color: #ef4444;
        }
        
        .post-content {
            padding: 0 20px 12px;
        }
        
        .post-text {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 12px;
            white-space: pre-wrap;
        }
        
        .post-media {
            margin-top: 12px;
            border-radius: 16px;
            overflow: hidden;
        }
        
        .post-media img,
        .post-media video {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            background: #f3f4f6;
        }
        
        .post-stats {
            padding: 8px 20px;
            display: flex;
            gap: 20px;
            font-size: 0.75rem;
            color: #6b7280;
            border-top: 1px solid #eef2f6;
            border-bottom: 1px solid #eef2f6;
        }
        
        .post-stats span {
            cursor: pointer;
        }
        
        .post-stats span:hover {
            color: #f97316;
        }
        
        .post-engagement {
            display: flex;
            padding: 4px 12px;
        }
        
        .engagement-btn {
            flex: 1;
            background: none;
            border: none;
            padding: 10px;
            border-radius: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #6b7280;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .engagement-btn:hover {
            background: #f3f4f6;
        }
        
        .engagement-btn.liked {
            color: #f97316;
        }
        
        .engagement-btn.liked i {
            animation: heartBeat 0.3s ease;
        }
        
        @keyframes heartBeat {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        
        .heart-pop {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            font-size: 3rem;
            color: #f97316;
            animation: heartPop 0.6s ease-out forwards;
        }
        
        @keyframes heartPop {
            0% {
                transform: scale(0) translateY(0);
                opacity: 1;
            }
            50% {
                transform: scale(1.2) translateY(-30px);
                opacity: 0.9;
            }
            100% {
                transform: scale(0.5) translateY(-60px);
                opacity: 0;
            }
        }
        
        .comments-section {
            padding: 12px 20px 16px;
            background: #fafafc;
            border-top: 1px solid #eef2f6;
            display: none;
        }
        
        .comments-section.show {
            display: block;
        }
        
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            position: relative;
        }
        
        .comment-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #fdba74);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .comment-bubble {
            flex: 1;
            background: white;
            padding: 8px 12px;
            border-radius: 16px;
            border: 1px solid #eef2f6;
        }
        
        .comment-bubble strong {
            font-size: 0.8rem;
            display: block;
            margin-bottom: 4px;
        }
        
        .comment-bubble p {
            font-size: 0.8rem;
            margin: 0;
            line-height: 1.4;
        }
        
        .comment-time {
            font-size: 0.6rem;
            color: #9ca3af;
            margin-top: 4px;
            display: block;
        }
        
        .comment-input-area {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eef2f6;
        }
        
        .comment-input {
            flex: 1;
            padding: 8px 16px;
            border: 1px solid #eef2f6;
            border-radius: 40px;
            font-size: 0.85rem;
            font-family: inherit;
        }
        
        .comment-input:focus {
            outline: none;
            border-color: #f97316;
        }
        
        .comment-send {
            background: #f97316;
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .comment-send:hover {
            background: #ea580c;
        }
        
        .delete-comment {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 0.7rem;
            padding: 4px;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: 0;
            top: 0;
        }
        
        .delete-comment:hover {
            background: #f3f4f6;
            color: #ef4444;
        }
        
        .view-more-comments {
            color: #6b7280;
            font-size: 0.75rem;
            cursor: pointer;
            margin-bottom: 12px;
            display: inline-block;
        }
        
        .view-more-comments:hover {
            color: #f97316;
        }
        
        .modal-custom {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        
        .modal-custom.show {
            display: flex;
        }
        
        .modal-content-custom {
            background: white;
            border-radius: 24px;
            width: 90%;
            max-width: 500px;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .modal-header-custom {
            padding: 20px 24px;
            border-bottom: 1px solid #eef2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header-custom h3 {
            margin: 0;
            font-size: 1.2rem;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #9ca3af;
        }
        
        .modal-body-custom {
            padding: 24px;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .modal-body-custom textarea {
            width: 100%;
            border: 1px solid #eef2f6;
            border-radius: 16px;
            padding: 16px;
            font-family: inherit;
            resize: vertical;
        }
        
        .modal-body-custom textarea:focus {
            outline: none;
            border-color: #f97316;
        }
        
        .modal-footer-custom {
            padding: 16px 24px;
            border-top: 1px solid #eef2f6;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .btn-cancel {
            background: none;
            border: 1px solid #eef2f6;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .btn-submit-comment {
            background: #f97316;
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 40px;
            font-weight: 500;
            cursor: pointer;
        }
        
        .btn-submit-comment:hover {
            background: #ea580c;
        }
        
        .like-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #eef2f6;
        }
        
        .like-item:last-child {
            border-bottom: none;
        }
        
        .like-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #fdba74);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .like-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .like-info {
            flex: 1;
        }
        
        .like-info strong {
            display: block;
            font-size: 0.9rem;
        }
        
        .like-info span {
            font-size: 0.7rem;
            color: #6b7280;
        }
        
        .like-badge {
            color: #f97316;
            font-size: 0.7rem;
            background: #fff7ed;
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 16px;
        }
        
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #333;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @media (max-width: 1024px) {
            .dropdown-menu-custom {
                min-width: unset;
                width: 90vw;
                max-width: 600px;
            }
            .dropdown-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .navbar-glass {
                flex-direction: column;
                align-items: stretch;
            }
            .nav-links {
                display: none;
                flex-direction: column;
                align-items: center;
                margin-top: 12px;
                gap: 16px;
            }
            .nav-links.open {
                display: flex !important;
            }
            .mobile-toggle {
                display: block;
                align-self: flex-end;
            }
            .dropdown-menu-custom {
                left: 50%;
                width: 95vw;
                max-width: 380px;
            }
            .dropdown-grid {
                grid-template-columns: 1fr;
            }
            .forum-container {
                padding: 80px 16px 40px;
            }
            .post-header, .post-content, .post-stats, .comments-section {
                padding-left: 16px;
                padding-right: 16px;
            }
            .media-btn span {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- HEADER -->
<header class="header-glass">
    <div class="container-custom">
        <div class="navbar-glass">
            <div class="logo-area">
                <div class="logo-icon"><i class="fas fa-paintbrush-fine"></i></div>
                <div class="logo-text">
                    <h5>Unit Kemahasiswaan</h5>
                    <span>Fakultas Industri Kreatif</span>
                </div>
            </div>
            
            <div class="mobile-toggle" id="mobileNavBtn">
                <i class="fas fa-bars"></i>
            </div>
            
            <div class="nav-links" id="navLinks">
                <a href="<?= base_url() ?>">Dashboard</a>
                <a href="<?= base_url('berita') ?>">Informasi</a>
                
                <!-- DROPDOWN LAYANAN -->
                <div class="dropdown-wrapper" id="layananDropdown">
                    <a href="#" id="layananToggle">
                        Layanan <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu-custom">
                        <div class="dropdown-grid">
                            <a href="<?= base_url('beasiswa') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
                                <div class="d-title">Pengajuan Beasiswa</div>
                                <div class="d-desc">Ajukan beasiswa prestasi & bantuan pendidikan</div>
                            </a>
                            <a href="<?= base_url('sertifikat') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-certificate"></i></div>
                                <div class="d-title">Pengajuan Sertifikat</div>
                                <div class="d-desc">Cetak sertifikat prestasi mahasiswa & kegiatan</div>
                            </a>
                            <a href="<?= base_url('proposal') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-clipboard-list"></i></div>
                                <div class="d-title">Pengajuan Proposal</div>
                                <div class="d-desc">Ajukan proposal kegiatan, PKM, & penelitian</div>
                            </a>
                            <a href="<?= base_url('tak') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-file-alt"></i></div>
                                <div class="d-title">Pengajuan TAK</div>
                                <div class="d-desc">Ajukan pengakuan kegiatan & kompetensi mahasiswa</div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="<?= base_url('forum_alumni') ?>" class="active">Forum Alumni</a>
            </div>
            
            <?php if (isset($user_data) && $user_data && $user_data['logged_in']): ?>
                <a href="<?= base_url('dashboard/profile') ?>" class="btn-mytelu-custom">
                    <?php if (!empty($user_data['foto'])): ?>
                        <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" class="user-avatar-small">
                    <?php else: ?>
                        <i class="fas fa-user-circle"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($user_data['nama']) ?>
                </a>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-mytelu-custom">
                    <i class="fas fa-sign-in-alt"></i> MyTeLU
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- MAIN CONTENT FORUM ALUMNI -->
<div class="forum-container">
    <!-- Create Post Card -->
    <div class="create-post-card">
        <div class="post-input-area">
            <div class="avatar-circle">
                <?php if (!empty($user_data['foto'])): ?>
                    <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" alt="">
                <?php else: ?>
                    <i class="fas fa-user"></i>
                <?php endif; ?>
            </div>
            <div class="post-input">
                <a href="<?= base_url('forum_alumni/create') ?>" style="text-decoration: none;">
                    <textarea rows="2" placeholder="Apa yang sedang dipikirkan?" readonly style="cursor: pointer; background: #fafafc;"></textarea>
                </a>
            </div>
        </div>
        <div class="post-actions">
            <div class="media-buttons">
                <a href="<?= base_url('forum_alumni/create') ?>" class="media-btn" style="text-decoration: none;">
                    <i class="fas fa-image"></i> <span>Foto</span>
                </a>
                <a href="<?= base_url('forum_alumni/create') ?>" class="media-btn" style="text-decoration: none;">
                    <i class="fas fa-video"></i> <span>Video</span>
                </a>
            </div>
            <a href="<?= base_url('forum_alumni/create') ?>" class="post-submit" style="text-decoration: none;">Posting</a>
        </div>
    </div>
    
    <!-- Posts Feed -->
    <div id="postsFeed">
        <?php if (empty($posts)): ?>
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h4>Belum ada postingan</h4>
                <p class="text-muted">Jadilah yang pertama untuk memposting di forum alumni!</p>
            </div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card" data-post-id="<?= $post['id'] ?>">
                    <div class="post-header">
                        <div class="post-user">
                            <div class="avatar-circle" style="width: 40px; height: 40px;">
                                <?php if (!empty($post['user_foto'])): ?>
                                    <img src="<?= base_url('uploads/users/' . $post['user_foto']) ?>" alt="">
                                <?php else: ?>
                                    <i class="fas fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <div class="user-info">
                                <h4><?= htmlspecialchars($post['nama']) ?></h4>
                                <span><?= time_ago($post['created_at']) ?></span>
                            </div>
                        </div>
                        <?php if ($post['user_id'] == $this->session->userdata('user_id')): ?>
                            <button class="post-menu" onclick="deletePost(<?= $post['id'] ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="post-content">
                        <div class="post-text"><?= nl2br(htmlspecialchars($post['content'])) ?></div>
                        <?php if (!empty($post['image'])): ?>
                            <div class="post-media">
                                <img src="<?= base_url('uploads/forum_posts/' . $post['image']) ?>" alt="Post image">
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($post['video'])): ?>
                            <div class="post-media">
                                <video controls>
                                    <source src="<?= base_url('uploads/forum_posts/' . $post['video']) ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="post-stats">
                        <span onclick="showLikes(<?= $post['id'] ?>)">
                            <i class="fas fa-heart" style="color: <?= $post['likes_count'] > 0 ? '#f97316' : '#9ca3af' ?>"></i> 
                            <span class="like-count-<?= $post['id'] ?>"><?= number_format($post['likes_count']) ?></span> suka
                        </span>
                        <span onclick="toggleComments(<?= $post['id'] ?>)">
                            <i class="fas fa-comment"></i> 
                            <span class="comment-count-<?= $post['id'] ?>"><?= number_format($post['comments_count']) ?></span> komentar
                        </span>
                    </div>
                    
                    <div class="post-engagement">
                        <button class="engagement-btn like-btn <?= $post['user_has_liked'] ? 'liked' : '' ?>" onclick="toggleLike(this, <?= $post['id'] ?>)">
                            <i class="fas fa-heart"></i> Suka
                        </button>
                        <button class="engagement-btn" onclick="openCommentModal(<?= $post['id'] ?>)">
                            <i class="fas fa-comment"></i> Komentar
                        </button>
                    </div>
                    
                    <div class="comments-section" id="comments-<?= $post['id'] ?>">
                        <div id="comments-list-<?= $post['id'] ?>">
                            <?php if (!empty($post['comments'])): ?>
                                <?php foreach ($post['comments'] as $comment): ?>
                                    <div class="comment-item" data-comment-id="<?= $comment['id'] ?>">
                                        <div class="comment-avatar">
                                            <?php if (!empty($comment['user_foto'])): ?>
                                                <img src="<?= base_url('uploads/users/' . $comment['user_foto']) ?>" alt="">
                                            <?php else: ?>
                                                <i class="fas fa-user"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="comment-bubble">
                                            <strong><?= htmlspecialchars($comment['nama']) ?></strong>
                                            <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                                            <span class="comment-time"><?= time_ago($comment['created_at']) ?></span>
                                        </div>
                                        <?php if ($comment['user_id'] == $this->session->userdata('user_id')): ?>
                                            <button class="delete-comment" onclick="deleteComment(this, <?= $comment['id'] ?>, <?= $post['id'] ?>)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($post['comments_count'] > 3): ?>
                            <div class="view-more-comments" onclick="loadMoreComments(<?= $post['id'] ?>)">
                                Lihat semua <?= number_format($post['comments_count']) ?> komentar
                            </div>
                        <?php endif; ?>
                        <div class="comment-input-area">
                            <div class="comment-avatar" style="width: 28px; height: 28px;">
                                <?php if (!empty($user_data['foto'])): ?>
                                    <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" alt="">
                                <?php else: ?>
                                    <i class="fas fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <input type="text" class="comment-input" placeholder="Tulis komentar..." id="commentInput-<?= $post['id'] ?>">
                            <button class="comment-send" onclick="submitComment(<?= $post['id'] ?>)">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Comment Modal -->
<div class="modal-custom" id="commentModal">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3><i class="fas fa-comment"></i> Buat Komentar</h3>
            <button class="modal-close" onclick="closeCommentModal()">&times;</button>
        </div>
        <div class="modal-body-custom">
            <textarea id="modalCommentText" rows="4" placeholder="Tulis komentar Anda..."></textarea>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-cancel" onclick="closeCommentModal()">Batal</button>
            <button class="btn-submit-comment" id="modalSubmitComment">Kirim</button>
        </div>
    </div>
</div>

<!-- Likes Modal -->
<div class="modal-custom" id="likesModal">
    <div class="modal-content-custom" style="max-width: 400px;">
        <div class="modal-header-custom">
            <h3><i class="fas fa-heart" style="color: #f97316;"></i> Daftar Penyuka</h3>
            <button class="modal-close" onclick="closeLikesModal()">&times;</button>
        </div>
        <div class="modal-body-custom" id="likesList">
            <div style="text-align: center; padding: 20px;">
                <i class="fas fa-spinner fa-spin"></i> Memuat...
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-cancel" onclick="closeLikesModal()">Tutup</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    let currentPostId = null;
    let currentLikesPostId = null;
    
    // Dropdown functionality
    function initDropdown() {
        const dropdownToggle = document.getElementById('layananToggle');
        const dropdownWrapper = document.getElementById('layananDropdown');
        
        if (dropdownToggle && dropdownWrapper) {
            dropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownWrapper.classList.toggle('open');
            });
            document.addEventListener('click', function(e) {
                if (!dropdownWrapper.contains(e.target)) {
                    dropdownWrapper.classList.remove('open');
                }
            });
        }
    }
    
    // Mobile toggle
    function initMobileToggle() {
        const mobileBtn = document.getElementById('mobileNavBtn');
        const navLinksDiv = document.getElementById('navLinks');
        if(mobileBtn) {
            mobileBtn.addEventListener('click', () => {
                navLinksDiv.classList.toggle('open');
            });
        }
    }
    
    // Toast notification
    function showToast(message, type = 'success') {
        $('.toast-notification').remove();
        const icon = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
        const bgColor = type === 'success' ? '#10b981' : (type === 'error' ? '#ef4444' : '#3b82f6');
        const toast = $(`
            <div class="toast-notification" style="background: ${bgColor};">
                <i class="fas ${icon}"></i>
                <span>${message}</span>
            </div>
        `);
        $('body').append(toast);
        setTimeout(() => {
            toast.fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }
    
    // Heart Pop Animation
    function createHeartPop(x, y) {
        const heart = document.createElement('div');
        heart.className = 'heart-pop';
        heart.innerHTML = '❤️';
        heart.style.left = x + 'px';
        heart.style.top = y + 'px';
        document.body.appendChild(heart);
        setTimeout(() => heart.remove(), 600);
    }
    
    // Toggle Like
    window.toggleLike = function(btn, postId) {
        // Simpan reference ke button
        const $btn = $(btn);
        const originalHtml = $btn.html();
        
        // Tampilkan loading
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url("forum_alumni/toggle_like") ?>',
            type: 'POST',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.liked !== undefined) {
                    const likeCountSpan = $('.like-count-' + postId);
                    likeCountSpan.text(response.count.toLocaleString());
                    
                    if (response.liked) {
                        btn.classList.add('liked');
                        const rect = btn.getBoundingClientRect();
                        const x = rect.left + rect.width / 2;
                        const y = rect.top + rect.height / 2;
                        createHeartPop(x, y);
                        showToast('❤️ Berhasil menyukai postingan!', 'success');
                    } else {
                        btn.classList.remove('liked');
                        showToast('💔 Batal menyukai postingan', 'info');
                    }
                    
                    const statsHeart = $(`.post-stats span:first-child i`);
                    if (response.count > 0) {
                        statsHeart.css('color', '#f97316');
                    } else {
                        statsHeart.css('color', '#9ca3af');
                    }
                } else if (response.error) {
                    showToast(response.error, 'error');
                    if (response.redirect) {
                        setTimeout(() => window.location.href = response.redirect, 1000);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                showToast('Gagal menyukai postingan: ' + error, 'error');
            },
            complete: function() {
                $btn.html(originalHtml).prop('disabled', false);
            }
        });
    }
    
    // Show Likes Modal
    window.showLikes = function(postId) {
        currentLikesPostId = postId;
        $('#likesList').html('<div style="text-align: center; padding: 20px;"><i class="fas fa-spinner fa-spin"></i> Memuat daftar penyuka...</div>');
        $('#likesModal').addClass('show');
        
        $.ajax({
            url: '<?= base_url("forum_alumni/get_likes") ?>',
            type: 'POST',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.likes) {
                    if (response.likes.length === 0) {
                        $('#likesList').html(`
                            <div style="text-align: center; padding: 40px;">
                                <i class="fas fa-heart-broken" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                                <p style="color: #6b7280;">Belum ada yang menyukai postingan ini</p>
                                <p style="font-size: 0.75rem; color: #9ca3af;">Jadilah yang pertama!</p>
                            </div>
                        `);
                    } else {
                        let likesHtml = '';
                        const currentUserId = '<?= $this->session->userdata('user_id') ?>';
                        
                        response.likes.forEach(like => {
                            const isCurrentUser = (like.user_id == currentUserId);
                            likesHtml += `
                                <div class="like-item">
                                    <div class="like-avatar">
                                        ${like.user_foto ? 
                                            `<img src="<?= base_url('uploads/users/') ?>${like.user_foto}" alt="">` : 
                                            '<i class="fas fa-user"></i>'}
                                    </div>
                                    <div class="like-info">
                                        <strong>${escapeHtml(like.nama)}</strong>
                                        <span>${like.time_ago}</span>
                                    </div>
                                    ${isCurrentUser ? '<div class="like-badge"><i class="fas fa-heart"></i> Anda</div>' : ''}
                                </div>
                            `;
                        });
                        $('#likesList').html(likesHtml);
                    }
                } else {
                    $('#likesList').html(`
                        <div style="text-align: center; padding: 40px;">
                            <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ef4444; margin-bottom: 12px; display: block;"></i>
                            <p style="color: #6b7280;">Gagal memuat daftar penyuka</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#likesList').html(`
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 3rem; color: #ef4444; margin-bottom: 12px; display: block;"></i>
                        <p style="color: #6b7280;">Terjadi kesalahan. Silakan coba lagi.</p>
                    </div>
                `);
            }
        });
    }
    
    window.closeLikesModal = function() {
        $('#likesModal').removeClass('show');
        currentLikesPostId = null;
    }
    
    // Submit Comment from input
    window.submitComment = function(postId) {
        const commentInput = $('#commentInput-' + postId);
        const comment = commentInput.val().trim();
        
        if (!comment) {
            showToast('Komentar tidak boleh kosong!', 'error');
            return;
        }
        
        const sendBtn = commentInput.closest('.comment-input-area').find('.comment-send');
        const originalHtml = sendBtn.html();
        sendBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url("forum_alumni/add_comment") ?>',
            type: 'POST',
            data: { post_id: postId, comment: comment },
            dataType: 'json',
            timeout: 30000,
            success: function(response) {
                if (response.success) {
                    const commentHtml = `
                        <div class="comment-item" data-comment-id="${response.comment.id}">
                            <div class="comment-avatar">
                                ${response.comment.user_foto ? 
                                    `<img src="<?= base_url('uploads/users/') ?>${response.comment.user_foto}" alt="">` : 
                                    '<i class="fas fa-user"></i>'}
                            </div>
                            <div class="comment-bubble">
                                <strong>${escapeHtml(response.comment.nama)}</strong>
                                <p>${escapeHtml(response.comment.comment).replace(/\n/g, '<br>')}</p>
                                <span class="comment-time">${response.comment.time_ago}</span>
                            </div>
                            <button class="delete-comment" onclick="deleteComment(this, ${response.comment.id}, ${postId})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    $('#comments-list-' + postId).append(commentHtml);
                    commentInput.val('');
                    
                    const commentCountSpan = $('.comment-count-' + postId);
                    let currentCount = parseInt(commentCountSpan.text().replace(/\./g, '')) || 0;
                    commentCountSpan.text((currentCount + 1).toLocaleString());
                    
                    showToast('Komentar berhasil ditambahkan!', 'success');
                } else {
                    showToast(response.error || 'Gagal menambahkan komentar', 'error');
                    if (response.redirect) {
                        setTimeout(() => window.location.href = response.redirect, 1000);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                showToast('Terjadi kesalahan: ' + error, 'error');
            },
            complete: function() {
                sendBtn.html(originalHtml).prop('disabled', false);
            }
        });
    }
    
    // Open Comment Modal
    window.openCommentModal = function(postId) {
        currentPostId = postId;
        $('#modalCommentText').val('');
        $('#commentModal').addClass('show');
    }
    
    window.closeCommentModal = function() {
        $('#commentModal').removeClass('show');
        currentPostId = null;
    }
    
    // Submit from modal
    $('#modalSubmitComment').click(function() {
        if (!currentPostId) return;
        
        const comment = $('#modalCommentText').val().trim();
        if (!comment) {
            showToast('Komentar tidak boleh kosong!', 'error');
            return;
        }
        
        const submitBtn = $(this);
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url("forum_alumni/add_comment") ?>',
            type: 'POST',
            data: { post_id: currentPostId, comment: comment },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const commentHtml = `
                        <div class="comment-item" data-comment-id="${response.comment.id}">
                            <div class="comment-avatar">
                                ${response.comment.user_foto ? 
                                    `<img src="<?= base_url('uploads/users/') ?>${response.comment.user_foto}" alt="">` : 
                                    '<i class="fas fa-user"></i>'}
                            </div>
                            <div class="comment-bubble">
                                <strong>${escapeHtml(response.comment.nama)}</strong>
                                <p>${escapeHtml(response.comment.comment).replace(/\n/g, '<br>')}</p>
                                <span class="comment-time">${response.comment.time_ago}</span>
                            </div>
                            <button class="delete-comment" onclick="deleteComment(this, ${response.comment.id}, ${currentPostId})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    $('#comments-list-' + currentPostId).append(commentHtml);
                    closeCommentModal();
                    
                    const commentCountSpan = $('.comment-count-' + currentPostId);
                    let currentCount = parseInt(commentCountSpan.text().replace(/\./g, '')) || 0;
                    commentCountSpan.text((currentCount + 1).toLocaleString());
                    
                    showToast('Komentar berhasil ditambahkan!', 'success');
                } else {
                    showToast(response.error || 'Gagal menambahkan komentar', 'error');
                    if (response.redirect) {
                        setTimeout(() => window.location.href = response.redirect, 1000);
                    }
                }
            },
            error: function() {
                showToast('Terjadi kesalahan', 'error');
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Toggle Comments Section
    window.toggleComments = function(postId) {
        $('#comments-' + postId).toggleClass('show');
    }
    
    // Load More Comments
    window.loadMoreComments = function(postId) {
        $.ajax({
            url: '<?= base_url("forum_alumni/get_comments") ?>',
            type: 'POST',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.comments) {
                    const commentsList = $('#comments-list-' + postId);
                    commentsList.empty();
                    const currentUserId = '<?= $this->session->userdata('user_id') ?>';
                    
                    response.comments.forEach(comment => {
                        const commentHtml = `
                            <div class="comment-item" data-comment-id="${comment.id}">
                                <div class="comment-avatar">
                                    ${comment.user_foto ? 
                                        `<img src="<?= base_url('uploads/users/') ?>${comment.user_foto}" alt="">` : 
                                        '<i class="fas fa-user"></i>'}
                                </div>
                                <div class="comment-bubble">
                                    <strong>${escapeHtml(comment.nama)}</strong>
                                    <p>${escapeHtml(comment.comment).replace(/\n/g, '<br>')}</p>
                                    <span class="comment-time">${comment.time_ago}</span>
                                </div>
                                ${comment.user_id == currentUserId ? 
                                    `<button class="delete-comment" onclick="deleteComment(this, ${comment.id}, ${postId})">
                                        <i class="fas fa-times"></i>
                                    </button>` : ''}
                            </div>
                        `;
                        commentsList.append(commentHtml);
                    });
                }
            }
        });
    }
    
    // Delete Comment
    window.deleteComment = function(btn, commentId, postId) {
        if (!confirm('Hapus komentar ini?')) return;
        
        $.ajax({
            url: '<?= base_url("forum_alumni/delete_comment") ?>',
            type: 'POST',
            data: { comment_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $(btn).closest('.comment-item').remove();
                    
                    const commentCountSpan = $('.comment-count-' + postId);
                    let currentCount = parseInt(commentCountSpan.text().replace(/\./g, '')) || 0;
                    commentCountSpan.text(Math.max(0, currentCount - 1).toLocaleString());
                    
                    showToast('Komentar berhasil dihapus', 'success');
                } else {
                    showToast('Gagal menghapus komentar', 'error');
                }
            }
        });
    }
    
    // Delete Post
    window.deletePost = function(postId) {
        if (!confirm('Hapus postingan ini? Tindakan ini tidak dapat dibatalkan.')) return;
        window.location.href = '<?= base_url("forum_alumni/delete_post/") ?>' + postId;
    }
    
    // Escape HTML helper
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Enter key to submit comment
    $(document).on('keypress', '.comment-input', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            const postId = $(this).attr('id').split('-')[1];
            submitComment(postId);
        }
    });
    
    // Close modal on escape
    $(document).keydown(function(e) {
        if (e.key === 'Escape') {
            if ($('#commentModal').hasClass('show')) {
                closeCommentModal();
            }
            if ($('#likesModal').hasClass('show')) {
                closeLikesModal();
            }
        }
    });
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        initDropdown();
        initMobileToggle();
        
        // Test AJAX connection
        console.log('Forum Alumni page loaded successfully');
    });
</script>

</body>
</html>

<?php
// Helper function time_ago
function time_ago($timestamp) {
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
?>