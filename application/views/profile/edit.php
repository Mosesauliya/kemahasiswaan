<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - <?= $title ?> | FIK Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f8fafc 100%);
            color: #1f2937;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-grad: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
        }

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
            background: var(--orange-grad);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .logo-text h5 {
            font-size: 0.9rem;
            font-weight: 800;
            color: white;
            margin: 0;
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

        .edit-container {
            max-width: 900px;
            margin: 120px auto 50px;
            padding: 0 24px;
        }

        .edit-card {
            background: white;
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .edit-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 48px rgba(0,0,0,0.12);
        }

        .edit-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .edit-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--orange-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .edit-header p {
            color: #6b7280;
        }

        .photo-upload {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 32px;
            border-bottom: 2px dashed #e2e8f0;
        }

        .photo-preview {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            margin: 0 auto 20px;
            overflow: hidden;
            background: var(--orange-grad);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease;
            border: 4px solid white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .photo-preview:hover {
            transform: scale(1.05);
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-preview i {
            font-size: 3.5rem;
            color: white;
        }

        .upload-btn {
            background: #f1f5f9;
            border: 2px dashed #cbd5e1;
            padding: 8px 24px;
            border-radius: 40px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: #fff7ed;
            border-color: #f97316;
            color: #f97316;
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 700;
            margin-bottom: 8px;
            color: #1f2937;
            font-size: 0.85rem;
        }

        .form-label i {
            color: #f97316;
            margin-right: 8px;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249,115,22,0.1);
            outline: none;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: #dc2626;
            background-image: none;
        }

        .form-control[readonly] {
            background: #f8fafc;
            cursor: not-allowed;
        }

        .required-star {
            color: #ef4444;
        }

        .invalid-feedback {
            font-size: 0.75rem;
            margin-top: 4px;
            color: #dc2626;
        }

        .btn-save {
            background: var(--orange-grad);
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(249,115,22,0.4);
        }

        .btn-save:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-save .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-save.loading .spinner {
            display: inline-block;
        }

        .btn-save.loading .btn-text {
            display: inline-block;
        }

        .btn-cancel {
            background: white;
            color: #6b7280;
            border: 2px solid #e2e8f0;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-cancel:hover {
            border-color: #f97316;
            color: #f97316;
            transform: translateY(-2px);
        }

        .danger-zone {
            margin-top: 32px;
            background: linear-gradient(135deg, #fef2f2, #fff5f5);
            border: 2px solid #fee2e2;
        }

        .danger-zone .edit-header h2 {
            background: none;
            -webkit-text-fill-color: #dc2626;
            color: #dc2626;
        }

        /* Alert message */
        .alert-fixed {
            position: fixed;
            top: 100px;
            right: 24px;
            z-index: 9999;
            min-width: 300px;
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
            .edit-container {
                margin-top: 140px;
            }
            
            .edit-card {
                padding: 24px;
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

            .btn-save, .btn-cancel {
                width: 100%;
                margin-bottom: 12px;
                text-align: center;
                justify-content: center;
            }

            .alert-fixed {
                top: 80px;
                right: 16px;
                left: 16px;
                min-width: auto;
            }
        }
    </style>
</head>
<body>

<?php $this->load->view('partials/navbar', ['active_menu' => 'dashboard']); ?>

<main>
    <div class="edit-container">
        <!-- Alert dari PHP flashdata -->
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 16px;">
            <i class="fas fa-check-circle me-2"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 16px;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="edit-card">
            <div class="edit-header">
                <h2>Edit Profil</h2>
                <p>Perbarui informasi pribadi Anda di sini</p>
            </div>
            
            <!-- Photo Upload -->
            <div class="photo-upload">
                <div class="photo-preview" onclick="document.getElementById('fotoInput').click()">
                    <?php if (!empty($user->foto) && file_exists('uploads/users/' . $user->foto)): ?>
                        <img src="<?= base_url('uploads/users/' . $user->foto) ?>" alt="Profile Photo" id="photoPreview">
                    <?php else: ?>
                        <i class="fas fa-user-graduate" id="photoIcon"></i>
                        <img src="" alt="Profile Photo" id="photoPreview" style="display: none;">
                    <?php endif; ?>
                </div>
                
                <form action="<?= base_url('profile/update_photo') ?>" method="POST" enctype="multipart/form-data" id="photoForm" style="display: inline-block;">
                    <input type="file" name="foto" id="fotoInput" accept="image/*" style="display: none;">
                    <button type="button" class="upload-btn" onclick="uploadPhoto()">
                        <i class="fas fa-camera me-2"></i>Ganti Foto
                    </button>
                </form>
                <p class="text-muted mt-2" style="font-size: 0.7rem;">Format: JPG, PNG, GIF (Max 2MB) | Klik foto untuk preview</p>
            </div>
            
            <!-- Edit Form - Menggunakan form submit biasa (lebih reliable) -->
            <form action="<?= base_url('profile/update') ?>" method="POST" id="editProfileForm">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label"><i class="fas fa-user"></i>Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($user->nama) ?>" required>
                        <?= form_error('nama', '<div class="invalid-feedback d-block">', '</div>') ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-id-card"></i>NIM/NID <span class="required-star">*</span></label>
                        <input type="text" class="form-control" name="nim" id="nim" value="<?= htmlspecialchars($user->nim) ?>" readonly>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-envelope"></i>Email <span class="required-star">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user->email) ?>" required>
                        <?= form_error('email', '<div class="invalid-feedback d-block">', '</div>') ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-graduation-cap"></i>Program Studi <span class="required-star">*</span></label>
                        <select class="form-select" name="prodi" id="prodi" required>
                            <option value="dkv" <?= ($user->prodi ?? '') == 'dkv' ? 'selected' : '' ?>>Desain Komunikasi Visual</option>
                            <option value="despro" <?= ($user->prodi ?? '') == 'despro' ? 'selected' : '' ?>>Desain Produk</option>
                            <option value="interior" <?= ($user->prodi ?? '') == 'interior' ? 'selected' : '' ?>>Desain Interior</option>
                            <option value="kriya" <?= ($user->prodi ?? '') == 'kriya' ? 'selected' : '' ?>>Kriya Tekstil & Mode</option>
                            <option value="senirupa" <?= ($user->prodi ?? '') == 'senirupa' ? 'selected' : '' ?>>Seni Rupa</option>
                            <option value="film" <?= ($user->prodi ?? '') == 'film' ? 'selected' : '' ?>>Film & Animasi</option>
                        </select>
                        <?= form_error('prodi', '<div class="invalid-feedback d-block">', '</div>') ?>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-phone"></i>Nomor HP</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="<?= htmlspecialchars($user->no_hp ?? '') ?>" placeholder="08123456789">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label"><i class="fas fa-map-marker-alt"></i>Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($user->alamat ?? '') ?></textarea>
                    </div>
                </div>
                
                <div class="d-flex gap-3 justify-content-end mt-4 pt-3">
                    <a href="<?= base_url('profile') ?>" class="btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn-save" id="saveBtn">
                        <span class="spinner"></span>
                        <span class="btn-text"><i class="fas fa-save me-2"></i>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Danger Zone -->
        <div class="edit-card danger-zone">
            <div class="edit-header">
                <h2 style="color: #dc2626;">⚠️ Danger Zone</h2>
                <p>Tindakan ini tidak dapat dibatalkan</p>
            </div>
            
            <div class="text-center">
                <button class="btn" style="background: #dc2626; color: white; border-radius: 50px; padding: 12px 32px; font-weight: 700; transition: all 0.3s ease;" onclick="confirmDelete()" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-trash-alt me-2"></i>Hapus Akun
                </button>
                <p class="text-muted mt-3" style="font-size: 0.75rem;">Menghapus akun akan menghilangkan semua data Anda secara permanen dari sistem</p>
            </div>
        </div>
    </div>
</main>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: var(--orange-grad); color: white; border: none;">
                <h5 class="modal-title" style="font-weight: 700;">
                    <i class="fas fa-key me-2"></i>Ganti Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="changePasswordForm" onsubmit="submitChangePassword(); return false;">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0" name="current_password" id="currentPassword" required style="border-radius: 0 12px 12px 0;">
                        </div>
                        <div class="invalid-feedback" id="currentPasswordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-key text-muted"></i></span>
                            <input type="password" class="form-control border-start-0" name="new_password" id="newPassword" required minlength="8" style="border-radius: 0 12px 12px 0;">
                        </div>
                        <small class="text-muted">Minimal 8 karakter, gunakan kombinasi huruf, angka, dan simbol</small>
                        <div class="invalid-feedback" id="newPasswordError"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                            <input type="password" class="form-control border-start-0" name="confirm_password" id="confirmPassword" required style="border-radius: 0 12px 12px 0;">
                        </div>
                        <div class="invalid-feedback" id="confirmPasswordError"></div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 12px;">Batal</button>
                    <button type="submit" class="btn" style="background: #f97316; color: white; border-radius: 12px; padding: 8px 24px;" id="changePwdBtn">
                        <span class="spinner-border spinner-border-sm me-2" style="display: none;"></span>
                        <span class="btn-text">Simpan Password</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Variabel untuk status
    let isUploading = false;
    
    // Preview photo before upload
    document.getElementById('fotoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Tidak Didukung',
                    text: 'Hanya file JPG, PNG, dan GIF yang diperbolehkan!',
                    confirmButtonColor: '#f97316'
                });
                this.value = '';
                return;
            }
            
            // Validasi ukuran (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Terlalu Besar',
                    text: 'Maksimal ukuran file adalah 2MB!',
                    confirmButtonColor: '#f97316'
                });
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('photoPreview');
                const icon = document.getElementById('photoIcon');
                preview.src = event.target.result;
                preview.style.display = 'block';
                if (icon) icon.style.display = 'none';
            };
            reader.readAsDataURL(file);
            
            // Auto upload setelah preview
            uploadPhoto();
        }
    });
    
    // Upload photo function
    function uploadPhoto() {
        const input = document.getElementById('fotoInput');
        const file = input.files[0];
        if (!file || isUploading) return;
        
        isUploading = true;
        const formData = new FormData();
        formData.append('foto', file);
        
        Swal.fire({
            title: 'Mengunggah...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('<?= base_url("profile/update_photo_ajax") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            isUploading = false;
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#f97316',
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat mengunggah foto.',
                    confirmButtonColor: '#f97316'
                });
                input.value = '';
            }
        })
        .catch(error => {
            isUploading = false;
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan koneksi. Silakan coba lagi.',
                confirmButtonColor: '#f97316'
            });
            input.value = '';
        });
    }
    
    // Loading state untuk form submit biasa
    document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.classList.add('loading');
        
        // Tampilkan loading message
        let loadingToast = document.createElement('div');
        loadingToast.className = 'alert-fixed alert alert-info';
        loadingToast.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan perubahan...';
        document.body.appendChild(loadingToast);
        
        // Hapus loading toast setelah 3 detik (akan tergantikan redirect)
        setTimeout(() => {
            if (loadingToast) loadingToast.remove();
        }, 3000);
    });
    
    // Ganti Password dengan AJAX
    function submitChangePassword() {
        const currentPassword = document.getElementById('currentPassword')?.value;
        const newPassword = document.getElementById('newPassword')?.value;
        const confirmPassword = document.getElementById('confirmPassword')?.value;
        
        // Reset error
        document.querySelectorAll('#changePasswordForm .invalid-feedback').forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        document.querySelectorAll('#changePasswordForm .form-control').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Validasi sederhana
        let hasError = false;
        if (!currentPassword) {
            document.getElementById('currentPasswordError').textContent = 'Password saat ini harus diisi!';
            document.getElementById('currentPasswordError').style.display = 'block';
            document.getElementById('currentPassword').classList.add('is-invalid');
            hasError = true;
        }
        
        if (!newPassword) {
            document.getElementById('newPasswordError').textContent = 'Password baru harus diisi!';
            document.getElementById('newPasswordError').style.display = 'block';
            document.getElementById('newPassword').classList.add('is-invalid');
            hasError = true;
        } else if (newPassword.length < 8) {
            document.getElementById('newPasswordError').textContent = 'Password minimal 8 karakter!';
            document.getElementById('newPasswordError').style.display = 'block';
            document.getElementById('newPassword').classList.add('is-invalid');
            hasError = true;
        }
        
        if (newPassword !== confirmPassword) {
            document.getElementById('confirmPasswordError').textContent = 'Password tidak cocok!';
            document.getElementById('confirmPasswordError').style.display = 'block';
            document.getElementById('confirmPassword').classList.add('is-invalid');
            hasError = true;
        }
        
        if (hasError) return false;
        
        const formData = new FormData();
        formData.append('current_password', currentPassword);
        formData.append('new_password', newPassword);
        formData.append('confirm_password', confirmPassword);
        
        const btn = document.getElementById('changePwdBtn');
        const spinner = btn.querySelector('.spinner-border');
        const btnText = btn.querySelector('.btn-text');
        
        spinner.style.display = 'inline-block';
        btnText.textContent = 'Memproses...';
        btn.disabled = true;
        
        fetch('<?= base_url("profile/change_password_ajax") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            spinner.style.display = 'none';
            btnText.textContent = 'Simpan Password';
            btn.disabled = false;
            
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonColor: '#f97316',
                    timer: 1500
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                    if (modal) modal.hide();
                    document.getElementById('changePasswordForm')?.reset();
                });
            } else {
                let errorMessage = data.message || 'Gagal mengubah password.';
                
                if (data.errors) {
                    if (data.errors.current_password) {
                        document.getElementById('currentPasswordError').textContent = data.errors.current_password;
                        document.getElementById('currentPasswordError').style.display = 'block';
                        document.getElementById('currentPassword').classList.add('is-invalid');
                    }
                    if (data.errors.new_password) {
                        document.getElementById('newPasswordError').textContent = data.errors.new_password;
                        document.getElementById('newPasswordError').style.display = 'block';
                        document.getElementById('newPassword').classList.add('is-invalid');
                    }
                    if (data.errors.confirm_password) {
                        document.getElementById('confirmPasswordError').textContent = data.errors.confirm_password;
                        document.getElementById('confirmPasswordError').style.display = 'block';
                        document.getElementById('confirmPassword').classList.add('is-invalid');
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#f97316'
                });
            }
        })
        .catch(error => {
            spinner.style.display = 'none';
            btnText.textContent = 'Simpan Password';
            btn.disabled = false;
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server. Silakan coba lagi.',
                confirmButtonColor: '#f97316'
            });
        });
        
        return false;
    }
    
    // Confirm delete account
    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Akun?',
            html: 'Apakah Anda yakin ingin menghapus akun?<br><strong class="text-danger">Tindakan ini tidak dapat dibatalkan!</strong>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Konfirmasi Final',
                    input: 'text',
                    inputLabel: 'Ketik <strong class="text-danger">HAPUS</strong> untuk mengonfirmasi',
                    inputPlaceholder: 'HAPUS',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Konfirmasi',
                    cancelButtonText: 'Batal',
                    preConfirm: (value) => {
                        if (value !== 'HAPUS') {
                            Swal.showValidationMessage('Ketik "HAPUS" untuk melanjutkan');
                        }
                        return value;
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value === 'HAPUS') {
                        window.location.href = '<?= base_url("profile/delete_account") ?>';
                    }
                });
            }
        });
    }
    
    // Auto dismiss alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert:not(.alert-fixed)').forEach(alert => {
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }
        });
    }, 1000);
</script>

</body>
</html>