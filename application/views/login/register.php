<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Register - Sistem Kemahasiswaan FIK | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #ffedd5;
            --blue: #1e3a8a;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

        .bg-orange-grad {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            position: relative;
        }

        .bg-orange-grad::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .container-custom {
            width: min(100% - 3rem, 480px);
            margin-inline: auto;
        }

        /* ========== REGISTER CARD ========== */
        .register-card {
            background: white;
            border-radius: 32px;
            padding: 48px 40px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.12);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f97316, #fdba74, #f97316);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header .logo-icon {
            width: 64px;
            height: 64px;
            background: #f97316;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            margin: 0 auto 16px;
        }

        .register-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .register-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* ========== FORM ========== */
        .form-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: #f97316;
            width: 18px;
        }

        .form-label .required {
            color: #ef4444;
            font-weight: 700;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #faf9f7;
        }

        .form-control:focus, .form-select:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-valid {
            border-color: #22c55e;
        }

        .form-text {
            color: #6b7280;
            font-size: 0.8rem;
            margin-top: 4px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .form-control {
            padding-right: 48px;
        }

        .input-group-custom .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .input-group-custom .toggle-password:hover {
            color: #f97316;
        }

        /* ========== PASSWORD STRENGTH ========== */
        .password-strength {
            margin-top: 8px;
            display: flex;
            gap: 4px;
        }

        .password-strength .bar {
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: #e2e8f0;
            transition: background 0.3s ease;
        }

        .password-strength .bar.active.weak {
            background: #ef4444;
        }

        .password-strength .bar.active.medium {
            background: #f59e0b;
        }

        .password-strength .bar.active.strong {
            background: #22c55e;
        }

        .password-strength-text {
            font-size: 0.8rem;
            margin-top: 4px;
            font-weight: 500;
        }

        /* ========== TERMS CHECKBOX ========== */
        .form-check {
            margin-top: 8px;
        }

        .form-check-input {
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .form-check-input:checked {
            background-color: #f97316;
            border-color: #f97316;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            border-color: #f97316;
        }

        .form-check-label a {
            color: #f97316;
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
            text-decoration: underline;
        }

        /* ========== SUBMIT BUTTON ========== */
        .btn-register {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 8px;
        }

        .btn-register:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(249, 115, 22, 0.35);
        }

        .btn-register:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-register i {
            transition: transform 0.3s ease;
        }

        .btn-register:hover:not(:disabled) i {
            transform: translateX(4px);
        }

        /* ========== LOGIN LINK ========== */
        .login-link {
            text-align: center;
            margin-top: 24px;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #f97316;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #ea580c;
            text-decoration: underline;
        }

        /* ========== ALERT MESSAGES ========== */
        .alert-custom {
            border-radius: 12px;
            padding: 12px 16px;
            border-left: 4px solid;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
        }

        .alert-custom.success {
            background: #f0fdf4;
            border-left-color: #22c55e;
            color: #166534;
        }

        .alert-custom.error {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        .alert-custom.warning {
            background: #fffbeb;
            border-left-color: #f59e0b;
            color: #92400e;
        }

        .alert-custom i {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 576px) {
            .register-card {
                padding: 32px 24px;
                border-radius: 24px;
            }
            .register-header h2 {
                font-size: 1.5rem;
            }
            .register-header .logo-icon {
                width: 56px;
                height: 56px;
                font-size: 1.5rem;
            }
            .container-custom {
                width: min(100% - 1.5rem, 480px);
            }
        }
    </style>
</head>
<body>

<main>
    <div class="container-custom">
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="logo-icon">
                    <i class="fas fa-paintbrush-fine"></i>
                </div>
                <h2>Buat Akun</h2>
                <p>Daftarkan diri Anda untuk mengakses layanan kemahasiswaan FIK</p>
            </div>

            <!-- Alert Message -->
            <div id="alertContainer" style="display: none;"></div>

            <!-- Register Form -->
            <form id="registerForm" method="POST" autocomplete="off">
                
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" name="nama" id="nama" required 
                           placeholder="Masukkan nama lengkap"
                           value="<?= set_value('nama') ?>">
                    <div class="form-text">Contoh: John Doe</div>
                </div>

                <!-- NIM/NID -->
            <div class="mb-3">
                <label class="form-label">
                    <i class="fas fa-id-card"></i>
                    NIM/NID <span class="required">*</span>
                </label>
                <input type="text" class="form-control" name="nim" id="nim" required 
                    placeholder="Masukkan NIM/NID"
                    value="<?= set_value('nim') ?>">
                <div class="form-text">Nomor Induk Mahasiswa (10-20 digit)</div>
            </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email <span class="required">*</span>
                    </label>
                    <input type="email" class="form-control" name="email" id="email" required 
                           placeholder="Masukkan alamat email"
                           value="<?= set_value('email') ?>">
                    <div class="form-text">Contoh: email@student.telkomuniversity.ac.id</div>
                </div>

                <!-- Program Studi -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-book"></i>
                        Program Studi <span class="required">*</span>
                    </label>
                    <select class="form-select" name="prodi" id="prodi" required>
                        <option value="">Pilih program studi</option>
                        <option value="dkv" <?= set_select('prodi', 'dkv') ?>>Desain Komunikasi Visual</option>
                        <option value="despro" <?= set_select('prodi', 'despro') ?>>Desain Produk</option>
                        <option value="interior" <?= set_select('prodi', 'interior') ?>>Desain Interior</option>
                        <option value="kriya" <?= set_select('prodi', 'kriya') ?>>Kriya Tekstil & Mode</option>
                        <option value="senirupa" <?= set_select('prodi', 'senirupa') ?>>Seni Rupa</option>
                        <option value="film" <?= set_select('prodi', 'film') ?>>Film & Animasi</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-group-custom">
                        <input type="password" class="form-control" name="password" id="password" required 
                               placeholder="Buat password (min. 8 karakter)"
                               minlength="8">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'passwordIcon')">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="bar" id="bar1"></div>
                        <div class="bar" id="bar2"></div>
                        <div class="bar" id="bar3"></div>
                        <div class="bar" id="bar4"></div>
                    </div>
                    <div class="password-strength-text" id="strengthText">Minimal 8 karakter</div>
                    <div class="form-text">Gunakan kombinasi huruf, angka, dan simbol</div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Konfirmasi Password <span class="required">*</span>
                    </label>
                    <div class="input-group-custom">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required 
                               placeholder="Masukkan ulang password">
                        <button type="button" class="toggle-password" onclick="togglePassword('confirm_password', 'confirmIcon')">
                            <i class="fas fa-eye" id="confirmIcon"></i>
                        </button>
                    </div>
                    <div id="confirmError" style="display: none; color: #ef4444; font-size: 0.85rem; margin-top: 4px;">
                        <i class="fas fa-times-circle me-1"></i>Password tidak cocok
                    </div>
                </div>

                <!-- Checkbox Persetujuan -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#" target="_blank">Syarat & Ketentuan</a> dan 
                            <a href="#" target="_blank">Kebijakan Privasi</a> <span class="required">*</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-register" id="registerBtn">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </button>

            </form>

            <!-- Login Link -->
            <div class="login-link">
                Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a>
            </div>
        </div>
    </div>
</main>

<!-- ========== SCRIPTS ========== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ==================== TOGGLE PASSWORD ====================
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    // ==================== PASSWORD STRENGTH ====================
    const passwordInput = document.getElementById('password');
    const strengthBars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4')
    ];
    const strengthText = document.getElementById('strengthText');

    passwordInput.addEventListener('input', function() {
        const val = this.value;
        let strength = 0;
        
        // Reset bars
        strengthBars.forEach(bar => {
            bar.className = 'bar';
        });
        
        if (val.length >= 8) strength += 1;
        if (val.match(/[a-z]/) && val.match(/[A-Z]/)) strength += 1;
        if (val.match(/\d/)) strength += 1;
        if (val.match(/[^a-zA-Z0-9]/)) strength += 1;
        
        // Update bars
        for (let i = 0; i < 4; i++) {
            if (i < strength) {
                if (strength <= 2) {
                    strengthBars[i].classList.add('active', 'weak');
                } else if (strength === 3) {
                    strengthBars[i].classList.add('active', 'medium');
                } else {
                    strengthBars[i].classList.add('active', 'strong');
                }
            }
        }
        
        // Update text
        if (val.length === 0) {
            strengthText.textContent = 'Minimal 8 karakter';
            strengthText.style.color = '#6b7280';
        } else if (strength <= 2) {
            strengthText.textContent = 'Lemah - Tambahkan huruf besar, angka, dan simbol';
            strengthText.style.color = '#ef4444';
        } else if (strength === 3) {
            strengthText.textContent = 'Sedang - Tambahkan simbol untuk lebih kuat';
            strengthText.style.color = '#f59e0b';
        } else {
            strengthText.textContent = 'Kuat - Password aman';
            strengthText.style.color = '#22c55e';
        }
    });

    // ==================== CONFIRM PASSWORD ====================
    const confirmInput = document.getElementById('confirm_password');
    const confirmError = document.getElementById('confirmError');

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        if (confirm.length === 0) {
            confirmError.style.display = 'none';
            confirmInput.className = 'form-control';
            return;
        }
        
        if (password === confirm) {
            confirmError.style.display = 'none';
            confirmInput.className = 'form-control is-valid';
        } else {
            confirmError.style.display = 'block';
            confirmInput.className = 'form-control is-invalid';
        }
    }

    passwordInput.addEventListener('input', checkPasswordMatch);
    confirmInput.addEventListener('input', checkPasswordMatch);

    // ==================== AJAX SUBMIT ====================
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validasi client-side
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        const terms = document.getElementById('terms').checked;
        
        if (password !== confirm) {
            document.getElementById('confirmError').style.display = 'block';
            document.getElementById('confirm_password').className = 'form-control is-invalid';
            return false;
        }
        
        if (!terms) {
            alert('Anda harus menyetujui Syarat & Ketentuan untuk mendaftar.');
            return false;
        }
        
        // Disable button dan show loading
        const btn = document.getElementById('registerBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        
        // Siapkan data
const formData = new FormData(this);

// Kirim AJAX request
fetch('<?= base_url('login/proses_register') ?>', {
    method: 'POST',
    body: formData,
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
})
.then(response => {
    if (!response.ok) {
        throw new Error('Server error: ' + response.status);
    }
    return response.json();
})
.then(data => {
    if (data.status === 'success') {
        showAlert(data.message, 'success');
        document.getElementById('registerForm').reset();
        
        // Reset password strength display
        document.getElementById('password').dispatchEvent(new Event('input'));
        
        setTimeout(() => {
            window.location.href = '<?= base_url('login') ?>';
        }, 2000);
    } else {
        showAlert(data.message, 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
    }
})
.catch(error => {
    console.error('Error:', error);
    showAlert('Terjadi kesalahan pada server. Silakan coba lagi.', 'error');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-user-plus"></i> Daftar Sekarang';
});
    });

    // ==================== SHOW ALERT ====================
    function showAlert(message, type = 'success') {
        const container = document.getElementById('alertContainer');
        container.style.display = 'block';
        
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle'
        };
        
        const colors = {
            'success': 'success',
            'error': 'error',
            'warning': 'warning'
        };
        
        container.innerHTML = `
            <div class="alert-custom ${type}">
                <i class="fas fa-${icons[type] || 'info-circle'}"></i>
                <div>${message}</div>
            </div>
        `;
        
        // Auto dismiss setelah 5 detik
        setTimeout(() => {
            const alert = container.querySelector('.alert-custom');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    container.style.display = 'none';
                }, 500);
            }
        }, 5000);
    }

    // ==================== AUTO DISMISS ALERT (PHP) ====================
    setTimeout(() => {
        document.querySelectorAll('.alert-custom').forEach(alert => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 500);
        });
    }, 5000);
</script>

</body>
</html>