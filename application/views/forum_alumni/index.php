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

        .container-custom {
            width: min(100% - 3rem, 1280px);
            margin-inline: auto;
        }

        /* Forum Styles */
        .forum-container {
            max-width: 720px;
            margin: 0 auto;
            padding: 0 20px 60px;
        }

        /* ========== HERO IKATAN ALUMNI (ORANGE THEME) ========== */
        .ikatan-alumni-hero {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fdba74 100%);
            color: white;
            padding: 130px 0 80px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 92%, 0 100%);
        }

        .ikatan-alumni-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.22) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .badge-alumni {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }

        .logo-alumni-hero-wrapper {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: #ffffff;
            padding: 5px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-alumni-hero {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        .hero-title {
            font-size: 2.3rem;
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.02em;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.12);
        }

        .hero-desc {
            font-size: 1.05rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
        }

        .btn-hero-primary {
            background: #ffffff;
            color: #ea580c;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 800;
            font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
            color: #c2410c;
            background: #fff7ed;
        }

        .btn-hero-outline {
            background: rgba(255, 255, 255, 0.18);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.45);
            padding: 12px 24px;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            backdrop-filter: blur(4px);
        }

        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.32);
            color: white;
        }

        .ketua-card-glass {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .ketua-avatar-wrapper {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            padding: 3px;
            background: #ffffff;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .ketua-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .badge-ketua {
            display: inline-block;
            background: #ffffff;
            color: #ea580c;
            font-size: 0.7rem;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 12px;
            text-transform: uppercase;
        }

        .ketua-nama {
            font-size: 1.15rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        .ketua-periode {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.9);
            display: block;
            margin-top: 2px;
        }

        .ketua-quote {
            background: rgba(0, 0, 0, 0.12);
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.95);
            font-style: italic;
            position: relative;
        }

        .quote-icon {
            color: #ffffff;
            margin-right: 6px;
            font-size: 0.9rem;
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

        .post-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        button.media-btn {
            font-family: inherit;
            font-size: inherit;
            cursor: pointer;
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
            display: block;
        }
        
        .comment-meta {
            margin-top: 4px;
            display: flex;
            align-items: center;
        }
        
        .comment-reply-btn {
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            margin-left: 10px;
            transition: color 0.2s;
        }
        
        .comment-reply-btn:hover {
            color: #ea580c;
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
        


        @media (max-width: 768px) {
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

        /* ========== FOOTER ========== */
        .footer {
            background: linear-gradient(115deg, #152b4e 0%, #0f172a 100%);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .footer a:hover {
            color: var(--orange);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'forum_alumni']); ?>

<!-- HERO HEADER IKATAN ALUMNI -->
<section class="ikatan-alumni-hero">
    <div class="container-custom">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if (!empty($ikatan_alumni['logo'])): ?>
                        <div class="logo-alumni-hero-wrapper">
                            <img src="<?= base_url($ikatan_alumni['logo']) ?>" alt="Logo Ikatan Alumni" class="logo-alumni-hero">
                        </div>
                    <?php endif; ?>
                    <div>
                        <div class="badge-alumni">
                            <i class="fas fa-graduation-cap me-2"></i> <?= htmlspecialchars($ikatan_alumni['singkatan'] ?? 'IKA FIK Telkom University') ?>
                        </div>
                    </div>
                </div>
                <h1 class="hero-title mb-3">
                    <?= htmlspecialchars($ikatan_alumni['nama_organisasi'] ?? 'Ikatan Alumni Fakultas Industri Kreatif') ?>
                </h1>
                <p class="hero-desc mb-0">
                    <?= htmlspecialchars($ikatan_alumni['sambutan_ketua'] ?? 'Wadah silaturahmi, sinergi, dan kolaborasi bagi seluruh alumni Fakultas Industri Kreatif Telkom University untuk terus berkarya, berinovasi, dan berdampak bagi masyarakat.') ?>
                </p>
            </div>
            <div class="col-lg-5">
                <div class="ketua-card-glass">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="ketua-avatar-wrapper">
                            <?php 
                            $foto_k = !empty($ikatan_alumni['foto_ketua']) ? base_url($ikatan_alumni['foto_ketua']) : (!empty($ikatan_alumni['logo']) ? base_url($ikatan_alumni['logo']) : base_url('assets/logo-fik.jpeg'));
                            ?>
                            <img src="<?= $foto_k ?>" alt="Foto Ketua / Logo Ikatan Alumni" class="ketua-avatar">
                        </div>
                        <div>
                            <span class="badge-ketua mb-1"><?= htmlspecialchars($ikatan_alumni['jabatan_ketua'] ?? 'Ketua Ikatan Alumni FIK') ?></span>
                            <h3 class="ketua-nama m-0"><?= htmlspecialchars($ikatan_alumni['nama_ketua'] ?? 'Ahmad Rizky Pratama, S.Des.') ?></h3>
                            <span class="ketua-periode"><i class="fas fa-calendar-alt me-1"></i> Periode <?= htmlspecialchars($ikatan_alumni['periode_ketua'] ?? '2024 - 2028') ?></span>
                        </div>
                    </div>
                    <div class="ketua-quote">
                        <i class="fas fa-quote-left quote-icon"></i>
                        <p class="mb-0">"Mempererat jejaring alumni FIK, menyalurkan potensi & sinergi karya kreatif untuk almamater dan Indonesia."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MAIN CONTENT FORUM ALUMNI -->
<div class="forum-container">
    <div class="section-title-box mb-4 text-center">
        <h2 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
            <i class="fas fa-comments me-2" style="color: var(--orange);"></i> Forum Diskusi & Ruang Berbagi Alumni
        </h2>
        <p style="color: #64748b; font-size: 0.92rem; margin-bottom: 0;">
            Sampaikan gagasan, peluang karir, informasi kegiatan, atau kisah inspiratif antar sesama alumni FIK
        </p>
    </div>

    <!-- Create Post Card -->
    <div class="create-post-card" id="createPostCard">
        <form action="<?= base_url('forum_alumni/create_post') ?>" method="POST" enctype="multipart/form-data" id="createPostForm">
            <?= $this->security->get_csrf_token_name() ? '<input type="hidden" name="' . $this->security->get_csrf_token_name() . '" value="' . $this->security->get_csrf_hash() . '">' : '' ?>
            <div class="post-input-area">
                <div class="avatar-circle">
                    <?php if (!empty($user_data['foto'])): ?>
                        <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" alt="">
                    <?php else: ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                </div>
                <div class="post-input">
                    <textarea name="content" id="postContentInput" rows="2" placeholder="Apa yang sedang dipikirkan?" style="cursor: text; background: #fafafc; resize: none; transition: rows 0.2s;" onfocus="expandPostInput()" oninput="this.style.height='auto';this.style.height=(this.scrollHeight)+'px'"></textarea>
                </div>
            </div>

            <!-- Preview area for selected files -->
            <div id="mediaPreviewArea" style="display:none; padding: 8px 16px 0; display:flex; gap:12px; flex-wrap:wrap;"></div>

            <!-- Hidden file inputs -->
            <input type="file" name="post_image" id="postImageInput" accept="image/*" style="display:none" onchange="previewMedia(this,'image')">
            <input type="file" name="post_video" id="postVideoInput" accept="video/*" style="display:none" onchange="previewMedia(this,'video')">

            <div class="post-actions">
                <div class="media-buttons">
                    <button type="button" class="media-btn" onclick="document.getElementById('postImageInput').click()">
                        <i class="fas fa-image"></i> <span>Foto</span>
                    </button>
                    <button type="button" class="media-btn" onclick="document.getElementById('postVideoInput').click()">
                        <i class="fas fa-video"></i> <span>Video</span>
                    </button>
                </div>
                <button type="submit" class="post-submit" id="postSubmitBtn">Posting</button>
            </div>
        </form>
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
                    
                    <div class="post-stats" style="border-bottom: none; margin-bottom: 0; padding-bottom: 0;">
                        <span class="like-btn-trigger <?= $post['user_has_liked'] ? 'liked' : '' ?>" onclick="toggleLike(this, <?= $post['id'] ?>)" style="cursor: pointer; user-select: none;">
                            <i class="fas fa-heart" style="color: <?= $post['user_has_liked'] ? '#f97316' : '#9ca3af' ?>"></i> 
                            <span class="like-count-<?= $post['id'] ?>"><?= number_format($post['likes_count']) ?></span> suka
                        </span>
                        <span onclick="toggleComments(<?= $post['id'] ?>)" style="cursor: pointer; user-select: none;">
                            <i class="fas fa-comment"></i> 
                            <span class="comment-count-<?= $post['id'] ?>" id="comment-count-<?= $post['id'] ?>"><?= number_format($post['comments_count']) ?></span> komentar
                        </span>
                    </div>
                    
                    <div class="comments-section" id="comments-<?= $post['id'] ?>">
                        <div id="comments-list-<?= $post['id'] ?>">
                            <?php if (!empty($post['comments'])): ?>
                                <?php foreach ($post['comments'] as $comment): ?>
                                    <div class="comment-item-container" id="comment-container-<?= $comment['id'] ?>" style="margin-bottom: 15px;">
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
                                                <div class="comment-meta">
                                                    <span class="comment-time"><?= time_ago($comment['created_at']) ?></span>
                                                    <span class="comment-reply-btn" onclick="showReplyInput(<?= $comment['id'] ?>, <?= $post['id'] ?>, '<?= htmlspecialchars($comment['nama'], ENT_QUOTES) ?>')">
                                                        <i class="fas fa-reply"></i> Balas
                                                    </span>
                                                </div>
                                            </div>
                                            <?php if ($comment['user_id'] == $this->session->userdata('user_id')): ?>
                                                <button class="delete-comment" onclick="deleteComment(this, <?= $comment['id'] ?>, <?= $post['id'] ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Nested Replies List -->
                                        <div class="replies-list" id="replies-list-<?= $comment['id'] ?>" style="margin-left: 45px; margin-top: 10px; border-left: 2px solid #e2e8f0; padding-left: 15px;">
                                            <?php if (!empty($comment['replies'])): ?>
                                                <?php foreach ($comment['replies'] as $reply): ?>
                                                    <div class="comment-item reply-item" data-comment-id="<?= $reply['id'] ?>" style="margin-bottom: 10px;">
                                                        <div class="comment-avatar" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                                            <?php if (!empty($reply['user_foto'])): ?>
                                                                <img src="<?= base_url('uploads/users/' . $reply['user_foto']) ?>" alt="">
                                                            <?php else: ?>
                                                                <i class="fas fa-user"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="comment-bubble" style="padding: 6px 12px;">
                                                            <strong><?= htmlspecialchars($reply['nama']) ?></strong>
                                                            <p><?= nl2br(htmlspecialchars($reply['comment'])) ?></p>
                                                            <span class="comment-time" style="font-size: 0.65rem; color: #9ca3af;"><?= time_ago($reply['created_at']) ?></span>
                                                        </div>
                                                        <?php if ($reply['user_id'] == $this->session->userdata('user_id')): ?>
                                                            <button class="delete-comment" onclick="deleteComment(this, <?= $reply['id'] ?>, <?= $post['id'] ?>)">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>

                                        <!-- reply input area -->
                                        <div class="reply-input-container" id="reply-input-container-<?= $comment['id'] ?>" style="margin-left: 45px; display: none; margin-top: 8px; margin-bottom: 10px;">
                                            <div class="comment-input-area" style="padding-top: 6px; margin-top: 6px; border-top: none;">
                                                <div class="comment-avatar" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                                    <?php if (!empty($user_data['foto'])): ?>
                                                        <img src="<?= base_url('uploads/users/' . $user_data['foto']) ?>" alt="">
                                                    <?php else: ?>
                                                        <i class="fas fa-user"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <input type="text" class="comment-input reply-input-field" placeholder="Balas @<?= htmlspecialchars($comment['nama']) ?>..." id="replyInput-<?= $comment['id'] ?>" style="font-size: 0.85rem; padding: 6px 12px;" onkeypress="handleReplyKeyPress(event, <?= $comment['id'] ?>, <?= $post['id'] ?>)">
                                                <button class="comment-send" onclick="submitReply(<?= $comment['id'] ?>, <?= $post['id'] ?>)" style="padding: 4px 10px;">
                                                    <i class="fas fa-paper-plane" style="font-size: 0.85rem;"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php if ($post['top_level_comments_count'] > 5): ?>
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


<!-- Likes Modal -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    let currentPostId = null;
    let currentLikesPostId = null;

    // === Inline Post Creation ===
    function expandPostInput() {
        const ta = document.getElementById('postContentInput');
        if (ta.rows < 4) {
            ta.rows = 4;
            document.getElementById('mediaPreviewArea').style.display = 'flex';
        }
    }

    function previewMedia(input, type) {
        const preview = document.getElementById('mediaPreviewArea');
        // Remove existing preview of same type
        const existing = preview.querySelector('[data-type="' + type + '"]');
        if (existing) existing.remove();

        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const url = URL.createObjectURL(file);
        const wrapper = document.createElement('div');
        wrapper.setAttribute('data-type', type);
        wrapper.style.cssText = 'position:relative; display:inline-block;';

        if (type === 'image') {
            wrapper.innerHTML = `<img src="${url}" style="max-height:140px; max-width:200px; border-radius:8px; object-fit:cover;">
                <button type="button" onclick="removeMedia('image')" style="position:absolute;top:4px;right:4px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:50%;width:22px;height:22px;cursor:pointer;font-size:12px;line-height:22px;text-align:center;">&times;</button>`;
        } else {
            wrapper.innerHTML = `<video src="${url}" style="max-height:140px; max-width:240px; border-radius:8px;" controls></video>
                <button type="button" onclick="removeMedia('video')" style="position:absolute;top:4px;right:4px;background:rgba(0,0,0,0.55);color:#fff;border:none;border-radius:50%;width:22px;height:22px;cursor:pointer;font-size:12px;line-height:22px;text-align:center;">&times;</button>`;
        }

        preview.appendChild(wrapper);
        preview.style.display = 'flex';
    }

    function removeMedia(type) {
        const inputId = type === 'image' ? 'postImageInput' : 'postVideoInput';
        document.getElementById(inputId).value = '';
        const wrapper = document.querySelector('#mediaPreviewArea [data-type="' + type + '"]');
        if (wrapper) wrapper.remove();
    }

    document.getElementById('createPostForm').addEventListener('submit', function(e) {
        const content = document.getElementById('postContentInput').value.trim();
        if (!content) {
            e.preventDefault();
            alert('Konten postingan tidak boleh kosong!');
            return;
        }
        const btn = document.getElementById('postSubmitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memposting...';
    });


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
    // Toggle Like
    window.toggleLike = function(btn, postId) {
        const $btn = $(btn);
        const $heartIcon = $btn.find('i');
        
        if ($btn.data('loading')) return;
        $btn.data('loading', true);
        
        const originalHeartColor = $heartIcon.css('color');
        $heartIcon.removeClass('fa-heart').addClass('fa-spinner fa-spin').css('color', '#f97316');
        
        $.ajax({
            url: '<?= base_url("forum_alumni/toggle_like") ?>',
            type: 'POST',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.liked !== undefined) {
                    const likeCountSpan = $('.like-count-' + postId);
                    likeCountSpan.text(response.count.toLocaleString());
                    
                    $heartIcon.removeClass('fa-spinner fa-spin').addClass('fa-heart');
                    
                    if (response.liked) {
                        $btn.addClass('liked');
                        $heartIcon.css('color', '#f97316');
                        
                        const rect = btn.getBoundingClientRect();
                        const x = rect.left + rect.width / 2;
                        const y = rect.top + rect.height / 2;
                        createHeartPop(x, y);
                        showToast('❤️ Berhasil menyukai postingan!', 'success');
                    } else {
                        $btn.removeClass('liked');
                        $heartIcon.css('color', '#9ca3af');
                        showToast('💔 Batal menyukai postingan', 'info');
                    }
                } else if (response.error) {
                    $heartIcon.removeClass('fa-spinner fa-spin').addClass('fa-heart').css('color', originalHeartColor);
                    showToast(response.error, 'error');
                    if (response.redirect) {
                        setTimeout(() => window.location.href = response.redirect, 1000);
                    }
                }
            },
            error: function(xhr, status, error) {
                $heartIcon.removeClass('fa-spinner fa-spin').addClass('fa-heart').css('color', originalHeartColor);
                showToast('Gagal menyukai postingan: ' + error, 'error');
            },
            complete: function() {
                $btn.data('loading', false);
            }
        });
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
                        <div class="comment-item-container" id="comment-container-${response.comment.id}" style="margin-bottom: 15px;">
                            <div class="comment-item" data-comment-id="${response.comment.id}">
                                <div class="comment-avatar">
                                    ${response.comment.user_foto ? 
                                        `<img src="<?= base_url('uploads/users/') ?>${response.comment.user_foto}" alt="">` : 
                                        '<i class="fas fa-user"></i>'}
                                </div>
                                <div class="comment-bubble">
                                    <strong>${escapeHtml(response.comment.nama)}</strong>
                                    <p>${escapeHtml(response.comment.comment).replace(/\n/g, '<br>')}</p>
                                    <div class="comment-meta">
                                        <span class="comment-time">${response.comment.time_ago}</span>
                                        <span class="comment-reply-btn" onclick="showReplyInput(${response.comment.id}, ${postId}, '${escapeHtml(response.comment.nama)}')">
                                            <i class="fas fa-reply"></i> Balas
                                        </span>
                                    </div>
                                </div>
                                <button class="delete-comment" onclick="deleteComment(this, ${response.comment.id}, ${postId})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="replies-list" id="replies-list-${response.comment.id}" style="margin-left: 45px; margin-top: 10px; border-left: 2px solid #e2e8f0; padding-left: 15px;"></div>
                            <div class="reply-input-container" id="reply-input-container-${response.comment.id}" style="margin-left: 45px; display: none; margin-top: 8px; margin-bottom: 10px;">
                                <div class="comment-input-area" style="padding-top: 6px; margin-top: 6px; border-top: none;">
                                    <div class="comment-avatar" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                        ${response.comment.user_foto ? 
                                            `<img src="<?= base_url('uploads/users/') ?>${response.comment.user_foto}" alt="">` : 
                                            '<i class="fas fa-user"></i>'}
                                    </div>
                                    <input type="text" class="comment-input reply-input-field" placeholder="Balas @${escapeHtml(response.comment.nama)}..." id="replyInput-${response.comment.id}" style="font-size: 0.85rem; padding: 6px 12px;" onkeypress="handleReplyKeyPress(event, ${response.comment.id}, ${postId})">
                                    <button class="comment-send" onclick="submitReply(${response.comment.id}, ${postId})" style="padding: 4px 10px;">
                                        <i class="fas fa-paper-plane" style="font-size: 0.85rem;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    showToast('Komentar berhasil ditambahkan!', 'success');
                    setTimeout(() => location.reload(), 800);
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
    
    // Toggle Comments Section and Focus Input
    window.toggleComments = function(postId) {
        const commentsSection = $('#comments-' + postId);
        const isOpen = commentsSection.toggleClass('show').hasClass('show');
        if (isOpen) {
            $('#commentInput-' + postId).focus();
        }
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
                    
                    // Sembunyikan tombol "Lihat semua komentar" karena semuanya sudah dimuat
                    $('#comments-' + postId).find('.view-more-comments').hide();
                    
                    const currentUserId = '<?= $this->session->userdata('user_id') ?>';
                    
                    response.comments.forEach(comment => {
                        // Build replies HTML
                        let repliesHtml = '';
                        if (comment.replies && comment.replies.length > 0) {
                            comment.replies.forEach(reply => {
                                repliesHtml += `
                                    <div class="comment-item reply-item" data-comment-id="${reply.id}" style="margin-bottom: 10px;">
                                        <div class="comment-avatar" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                            ${reply.user_foto ? 
                                                `<img src="<?= base_url('uploads/users/') ?>${reply.user_foto}" alt="">` : 
                                                '<i class="fas fa-user"></i>'}
                                        </div>
                                        <div class="comment-bubble" style="padding: 6px 12px;">
                                            <strong>${escapeHtml(reply.nama)}</strong>
                                            <p>${escapeHtml(reply.comment).replace(/\n/g, '<br>')}</p>
                                            <span class="comment-time" style="font-size: 0.65rem; color: #9ca3af;">${reply.time_ago}</span>
                                        </div>
                                        ${reply.user_id == currentUserId ? 
                                            `<button class="delete-comment" onclick="deleteComment(this, ${reply.id}, ${postId})">
                                                <i class="fas fa-times"></i>
                                            </button>` : ''}
                                    </div>
                                `;
                            });
                        }

                        // Build main comment HTML
                        const commentHtml = `
                            <div class="comment-item-container" id="comment-container-${comment.id}" style="margin-bottom: 15px;">
                                <div class="comment-item" data-comment-id="${comment.id}">
                                    <div class="comment-avatar">
                                        ${comment.user_foto ? 
                                            `<img src="<?= base_url('uploads/users/') ?>${comment.user_foto}" alt="">` : 
                                            '<i class="fas fa-user"></i>'}
                                    </div>
                                    <div class="comment-bubble">
                                        <strong>${escapeHtml(comment.nama)}</strong>
                                        <p>${escapeHtml(comment.comment).replace(/\n/g, '<br>')}</p>
                                        <div class="comment-meta">
                                            <span class="comment-time">${comment.time_ago}</span>
                                            <span class="comment-reply-btn" onclick="showReplyInput(${comment.id}, ${postId}, '${escapeHtml(comment.nama)}')">
                                                <i class="fas fa-reply"></i> Balas
                                            </span>
                                        </div>
                                    </div>
                                    ${comment.user_id == currentUserId ? 
                                        `<button class="delete-comment" onclick="deleteComment(this, ${comment.id}, ${postId})">
                                            <i class="fas fa-times"></i>
                                        </button>` : ''}
                                </div>
                                <div class="replies-list" id="replies-list-${comment.id}" style="margin-left: 45px; margin-top: 10px; border-left: 2px solid #e2e8f0; padding-left: 15px;">
                                    ${repliesHtml}
                                </div>
                                <div class="reply-input-container" id="reply-input-container-${comment.id}" style="margin-left: 45px; display: none; margin-top: 8px; margin-bottom: 10px;">
                                    <div class="comment-input-area" style="padding-top: 6px; margin-top: 6px; border-top: none;">
                                        <div class="comment-avatar" style="width: 24px; height: 24px; font-size: 0.75rem;">
                                            ${comment.user_foto ? 
                                                `<img src="<?= base_url('uploads/users/') ?>${comment.user_foto}" alt="">` : 
                                                '<i class="fas fa-user"></i>'}
                                        </div>
                                        <input type="text" class="comment-input reply-input-field" placeholder="Balas @${escapeHtml(comment.nama)}..." id="replyInput-${comment.id}" style="font-size: 0.85rem; padding: 6px 12px;" onkeypress="handleReplyKeyPress(event, ${comment.id}, ${postId})">
                                        <button class="comment-send" onclick="submitReply(${comment.id}, ${postId})" style="padding: 4px 10px;">
                                            <i class="fas fa-paper-plane" style="font-size: 0.85rem;"></i>
                                        </button>
                                    </div>
                                </div>
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
    
    // Show/Hide Reply Input
    window.showReplyInput = function(commentId, postId, userName) {
        const container = $('#reply-input-container-' + commentId);
        if (container.is(':visible')) {
            container.slideUp(200);
        } else {
            // Close other reply inputs first (optional, for cleaner UI)
            $('.reply-input-container').slideUp(100);
            
            container.slideDown(200, function() {
                const input = $('#replyInput-' + commentId);
                input.focus();
            });
        }
    }

    // Handle key press on reply input
    window.handleReplyKeyPress = function(e, commentId, postId) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            submitReply(commentId, postId);
        }
    }

    // Submit Reply
    window.submitReply = function(commentId, postId) {
        const replyInput = $('#replyInput-' + commentId);
        const comment = replyInput.val().trim();
        
        if (!comment) {
            showToast('Komentar balasan tidak boleh kosong!', 'error');
            return;
        }
        
        const sendBtn = replyInput.closest('.comment-input-area').find('.comment-send');
        const originalHtml = sendBtn.html();
        sendBtn.html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
        
        $.ajax({
            url: '<?= base_url("forum_alumni/add_comment") ?>',
            type: 'POST',
            data: { post_id: postId, comment: comment, parent_id: commentId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const replyHtml = `
                        <div class="comment-item reply-item" data-comment-id="${response.comment.id}" style="margin-bottom: 10px;">
                            <div class="comment-avatar" style="width: 28px; height: 28px; font-size: 0.8rem;">
                                ${response.comment.user_foto ? 
                                    `<img src="<?= base_url('uploads/users/') ?>${response.comment.user_foto}" alt="">` : 
                                    '<i class="fas fa-user"></i>'}
                            </div>
                            <div class="comment-bubble" style="padding: 6px 12px;">
                                <strong>${escapeHtml(response.comment.nama)}</strong>
                                <p>${escapeHtml(response.comment.comment).replace(/\n/g, '<br>')}</p>
                                <span class="comment-time" style="font-size: 0.65rem; color: #9ca3af;">${response.comment.time_ago}</span>
                            </div>
                            <button class="delete-comment" onclick="deleteComment(this, ${response.comment.id}, ${postId})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    
                    showToast('Balasan komentar berhasil dikirim!', 'success');
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(response.error || 'Gagal mengirim balasan', 'error');
                }
            },
            error: function(xhr, status, error) {
                showToast('Terjadi kesalahan: ' + error, 'error');
            },
            complete: function() {
                sendBtn.html(originalHtml).prop('disabled', false);
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
    

    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Forum Alumni page loaded successfully');
    });
</script>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container-custom">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Fakultas Industri Kreatif</h4>
                <p style="opacity: 0.8;">Menjadi pusat unggulan pendidikan industri kreatif yang menghasilkan lulusan berdaya saing global.</p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    <a href="#"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Tautan Cepat</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="mb-2"><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li class="mb-2"><a href="<?= base_url('sertifikat') ?>">Sertifikat</a></li>
                    <li class="mb-2"><a href="<?= base_url('forum_alumni') ?>">Forum Alumni</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h4 class="mb-3" style="color: var(--orange);">Kontak</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bandung, Jawa Barat</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> fik@telkomuniversity.ac.id</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> (022) 756 5923</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="mb-0">&copy; <?= date('Y') ?> Fakultas Industri Kreatif - Telkom University. All rights reserved.</p>
        </div>
    </div>
</footer>

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