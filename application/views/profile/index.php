<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - <?= $title ?> | FIK Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8fafc 100%);
            color: #1f2937;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #ffedd5;
            --orange-grad: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            --blue: #1e3a8a;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

        /* Header Navigation */
        .header-glass {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            z-index: 50;
        }

        .navbar-glass {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(20px);
            border-radius: 60px;
            padding: 12px 32px;
            border: 1px solid rgba(255,255,255,0.15);
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
            background: linear-gradient(135deg, #f97316, #fdba74);
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
            position: relative;
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


        .mobile-toggle { display: none; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 8px 14px; font-size: 1.4rem; color: white; cursor: pointer; }
        .btn-mytelu-custom { background: #f97316; padding: 8px 28px; border-radius: 40px; font-weight: 700; color: white; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
        .btn-mytelu-custom:hover { background: #ea580c; color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3); }
        .user-avatar-small { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }

        /* Main Container */
        .profile-container {
            max-width: 1280px;
            margin: 100px auto 50px;
            padding: 0 24px;
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border-radius: 32px;
            padding: 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px -12px rgba(0,0,0,0.15);
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 1;
        }

        .welcome-banner h1 {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 8px;
        }

        .welcome-banner p {
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
        }

        .welcome-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            margin-top: 16px;
        }

        /* Profile Grid */
        .profile-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 32px;
        }

        /* Profile Card Sidebar */
        .profile-sidebar {
            background: white;
            border-radius: 32px;
            padding: 32px 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            position: sticky;
            top: 100px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .profile-sidebar:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .profile-avatar-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 24px;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #f97316, #fdba74);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar i {
            font-size: 4rem;
            color: white;
        }

        .online-status {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 20px;
            height: 20px;
            background: #22c55e;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profile-name {
            font-size: 1.4rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 8px;
            color: #1f2937;
        }

        .profile-role {
            text-align: center;
            display: inline-block;
            width: 100%;
            padding: 6px 16px;
            background: #fff7ed;
            color: #f97316;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.3rem;
            font-weight: 800;
            color: #f97316;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #6b7280;
        }

        .sidebar-info {
            margin-bottom: 16px;
        }

        .sidebar-info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-info-item i {
            width: 32px;
            height: 32px;
            background: #fff7ed;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f97316;
            font-size: 0.9rem;
        }

        .sidebar-info-item .info-text {
            flex: 1;
        }

        .sidebar-info-item .info-label {
            font-size: 0.7rem;
            color: #6b7280;
        }

        .sidebar-info-item .info-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1f2937;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-sidebar {
            flex: 1;
            padding: 12px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-edit-profile {
            background: #f97316;
            color: white;
            border: none;
        }

        .btn-edit-profile:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249,115,22,0.3);
        }

        .btn-change-pwd {
            background: white;
            color: #f97316;
            border: 2px solid #f97316;
        }

        .btn-change-pwd:hover {
            background: #f97316;
            color: white;
            transform: translateY(-2px);
        }

        /* Main Content Cards */
        .profile-main {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .info-card {
            background: white;
            border-radius: 32px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .card-header-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f1f5f9;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e3a8a;
        }

        .card-title i {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #fff7ed, #ffedd5);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f97316;
            font-size: 1.1rem;
        }

        .badge-complete {
            background: #f0fdf4;
            color: #22c55e;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .info-field {
            padding: 12px;
            background: #f8fafc;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .info-field:hover {
            background: #fff7ed;
            transform: translateX(4px);
        }

        .info-field-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-field-value {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .info-field-value i {
            color: #f97316;
            font-size: 0.9rem;
        }

        /* Activity Timeline */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #f97316, #fdba74);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 24px;
        }

        .timeline-dot {
            position: absolute;
            left: -26px;
            top: 4px;
            width: 12px;
            height: 12px;
            background: #f97316;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 3px #ffedd5;
        }

        .timeline-date {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .timeline-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .timeline-desc {
            font-size: 0.8rem;
            color: #6b7280;
        }

        /* Alert Custom */
        .alert-custom {
            border-radius: 20px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            color: #166534;
        }

        .alert-error {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-sidebar {
                position: static;
                max-width: 400px;
                margin: 0 auto;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .profile-container {
                margin-top: 120px;
            }
            
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
            .nav-links.open { display: flex !important; }
            .mobile-toggle { display: block; align-self: flex-end; }

            .welcome-banner {
                padding: 24px;
            }
            
            .welcome-banner h1 {
                font-size: 1.5rem;
            }
            
            .info-card {
                padding: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-sidebar, .info-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .info-card:nth-child(1) { animation-delay: 0.1s; }
        .info-card:nth-child(2) { animation-delay: 0.2s; }
    </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'dashboard']); ?>

<main>
    <div class="profile-container">
        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle fa-lg"></i>
            <div><?= $this->session->flashdata('success') ?></div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert-custom alert-error">
            <i class="fas fa-exclamation-circle fa-lg"></i>
            <div><?= $this->session->flashdata('error') ?></div>
        </div>
        <?php endif; ?>
        
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>Selamat Datang, <?= htmlspecialchars($user->nama) ?>! 👋</h1>
                <p>Kelola profil Anda dan pantau perkembangan aktivitas kemahasiswaan di sini</p>
                <div class="welcome-badge">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Terakhir login: <?= date('d F Y H:i', strtotime($user->updated_at ?? date('Y-m-d H:i:s'))) ?>
                </div>
            </div>
        </div>
        
        <!-- Profile Grid -->
        <div class="profile-grid">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        <?php if (!empty($user->foto) && file_exists('uploads/users/' . $user->foto)): ?>
                            <img src="<?= base_url('uploads/users/' . $user->foto) ?>" alt="Profile Photo">
                        <?php else: ?>
                            <i class="fas fa-user-graduate"></i>
                        <?php endif; ?>
                    </div>
                    <div class="online-status"></div>
                </div>
                
                <div class="profile-name"><?= htmlspecialchars($user->nama) ?></div>
                <div class="profile-role">
                    <?php 
                    $role_labels = [
                        'mahasiswa' => '🎓 Mahasiswa',
                        'pembina' => '👨‍🏫 Dosen Pembina',
                        'bemdpm' => '🏛️ BEM/DPM',
                        'kaprodi' => '📚 Kepala Program Studi',
                        'kemahasiswaan' => '⚙️ TPA Kemahasiswaan'
                    ];
                    $user_role = isset($user->role) ? $user->role : 'mahasiswa';
                    echo $role_labels[$user_role] ?? '🎓 Mahasiswa';
                    ?>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?= date('Y') ?></div>
                        <div class="stat-label">Tahun Akademik</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= date('d M Y', strtotime($user->created_at ?? date('Y-m-d'))) ?></div>
                        <div class="stat-label">Bergabung</div>
                    </div>
                </div>
                
                <div class="sidebar-info">
                    <div class="sidebar-info-item">
                        <i class="fas fa-envelope"></i>
                        <div class="info-text">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= htmlspecialchars($user->email) ?></div>
                        </div>
                    </div>
                    <div class="sidebar-info-item">
                        <i class="fas fa-id-card"></i>
                        <div class="info-text">
                            <div class="info-label">NIM/NID</div>
                            <div class="info-value"><?= htmlspecialchars($user->nim) ?></div>
                        </div>
                    </div>
                    <?php if (isset($user->no_hp) && !empty($user->no_hp)): ?>
                    <div class="sidebar-info-item">
                        <i class="fas fa-phone"></i>
                        <div class="info-text">
                            <div class="info-label">Nomor HP</div>
                            <div class="info-value"><?= htmlspecialchars($user->no_hp) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="action-buttons">
                    <a href="<?= base_url('profile/edit') ?>" class="btn-sidebar btn-edit-profile">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <button class="btn-sidebar btn-change-pwd" onclick="showChangePasswordModal()">
                        <i class="fas fa-key me-2"></i>Ganti PW
                    </button>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="profile-main">
                <!-- Informasi Pribadi -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-user-circle"></i>
                            Informasi Pribadi
                        </div>
                        <div class="badge-complete">
                            <i class="fas fa-check-circle me-1"></i>Terverifikasi
                        </div>
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-field">
                            <div class="info-field-label">Nama Lengkap</div>
                            <div class="info-field-value">
                                <i class="fas fa-user"></i>
                                <?= htmlspecialchars($user->nama) ?>
                            </div>
                        </div>
                        
                        <div class="info-field">
                            <div class="info-field-label">NIM/NID</div>
                            <div class="info-field-value">
                                <i class="fas fa-id-card"></i>
                                <?= htmlspecialchars($user->nim) ?>
                            </div>
                        </div>
                        
                        <div class="info-field">
                            <div class="info-field-label">Email</div>
                            <div class="info-field-value">
                                <i class="fas fa-envelope"></i>
                                <?= htmlspecialchars($user->email) ?>
                            </div>
                        </div>
                        
                        <div class="info-field">
                            <div class="info-field-label">Program Studi</div>
                            <div class="info-field-value">
                                <i class="fas fa-graduation-cap"></i>
                                <?php 
                                $prodi_labels = [
                                    'dkv' => 'Desain Komunikasi Visual',
                                    'despro' => 'Desain Produk',
                                    'interior' => 'Desain Interior',
                                    'kriya' => 'Kriya Tekstil & Mode',
                                    'senirupa' => 'Seni Rupa',
                                    'film' => 'Film & Animasi'
                                ];
                                echo $prodi_labels[$user->prodi] ?? $user->prodi;
                                ?>
                            </div>
                        </div>
                        
                        <?php if (isset($user->no_hp) && !empty($user->no_hp)): ?>
                        <div class="info-field">
                            <div class="info-field-label">Nomor HP</div>
                            <div class="info-field-value">
                                <i class="fas fa-phone"></i>
                                <?= htmlspecialchars($user->no_hp) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($user->alamat) && !empty($user->alamat)): ?>
                        <div class="info-field">
                            <div class="info-field-label">Alamat</div>
                            <div class="info-field-value">
                                <i class="fas fa-map-marker-alt"></i>
                                <?= htmlspecialchars($user->alamat) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Aktivitas Terbaru -->
                <div class="info-card">
                    <div class="card-header-custom">
                        <div class="card-title">
                            <i class="fas fa-history"></i>
                            Aktivitas Terbaru
                        </div>
                        <div class="badge-complete">
                            <i class="fas fa-clock me-1"></i>Riwayat
                        </div>
                    </div>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date"><?= date('d F Y H:i') ?></div>
                            <div class="timeline-title">Login ke Dashboard</div>
                            <div class="timeline-desc">Anda telah login ke sistem kemahasiswaan</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date"><?= date('d F Y', strtotime('-1 day')) ?></div>
                            <div class="timeline-title">Mengunjungi Informasi</div>
                            <div class="timeline-desc">Membaca update terbaru dari fakultas</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date"><?= date('d F Y', strtotime('-3 day')) ?></div>
                            <div class="timeline-title">Profil Diperbarui</div>
                            <div class="timeline-desc">Informasi profil telah diperbaharui</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none;">
            <div class="modal-header" style="border-bottom: 2px solid #f97316; background: linear-gradient(135deg, #f97316, #fdba74); color: white; border-radius: 24px 24px 0 0;">
                <h5 class="modal-title" style="font-weight: 700;">
                    <i class="fas fa-key me-2"></i>
                    Ganti Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('profile/change_password') ?>" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control" name="current_password" required style="border-radius: 0 12px 12px 0;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" class="form-control" name="new_password" id="newPassword" required minlength="8" style="border-radius: 0 12px 12px 0;">
                        </div>
                        <small class="text-muted">Minimal 8 karakter, gunakan kombinasi huruf, angka, dan simbol</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-check-circle text-muted"></i></span>
                            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required style="border-radius: 0 12px 12px 0;">
                        </div>
                        <div id="passwordMatchError" style="display: none; color: #ef4444; font-size: 0.85rem; margin-top: 8px;">
                            <i class="fas fa-times-circle me-1"></i>Password tidak cocok
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 12px;">Batal</button>
                    <button type="submit" class="btn" style="background: #f97316; color: white; border-radius: 12px;" onclick="return validatePassword()">
                        <i class="fas fa-save me-2"></i>Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function showChangePasswordModal() {
        var myModal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
        myModal.show();
    }
    
    function validatePassword() {
        var newPass = document.getElementById('newPassword').value;
        var confirmPass = document.getElementById('confirmPassword').value;
        var errorDiv = document.getElementById('passwordMatchError');
        
        if (newPass !== confirmPass) {
            errorDiv.style.display = 'block';
            return false;
        }
        
        if (newPass.length < 8) {
            alert('Password minimal 8 karakter!');
            return false;
        }
        
        errorDiv.style.display = 'none';
        return true;
    }
    
    // Auto dismiss flash messages after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert-custom').forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);
</script>

</body>
</html>