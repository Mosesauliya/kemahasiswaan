<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Kemahasiswaan FIK Telkom University</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #1a2632;
            overflow: hidden;
        }
        
        /* Left panel – branding */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, #2C3E50 0%, #1a2632 60%, #E67E22 200%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(230,126,34,0.15) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            border-radius: 50%;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(230,126,34,0.08) 0%, transparent 70%);
            top: 50px; right: -50px;
            border-radius: 50%;
        }

        .left-panel .logo-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }

        .left-panel .logo-wrap img {
            height: 52px;
            width: auto;
            object-fit: contain;
        }

        .left-panel .logo-text {
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        .left-panel h1 {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .left-panel h1 span { color: #E67E22; }

        .left-panel p {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            line-height: 1.7;
            max-width: 380px;
            position: relative;
            z-index: 1;
            margin-bottom: 2.5rem;
        }

        /* Flow diagram on left panel */
        .flow-steps {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .flow-step {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .flow-step .dot {
            width: 8px; height: 8px;
            background: #E67E22;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .flow-step span {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.55);
            font-weight: 500;
        }

        .flow-step .arrow {
            width: 1px;
            height: 16px;
            background: rgba(230,126,34,0.3);
            margin-left: 3.5px;
        }

        /* Right panel – form */
        .right-panel {
            width: 480px;
            background: #faf9f7;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 3.5rem;
            position: relative;
        }

        .right-panel .form-header {
            margin-bottom: 2rem;
        }

        .right-panel .form-header h2 {
            font-family: 'Playfair Display', serif;
            color: #2C3E50;
            font-size: 1.9rem;
            margin-bottom: 0.3rem;
        }

        .right-panel .form-header p {
            color: #888;
            font-size: 0.85rem;
        }

        /* Tab switch */
        .tab-login {
            display: flex;
            background: #ede9e3;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 1.8rem;
        }

        .tab-login button {
            flex: 1;
            padding: 0.55rem;
            border: none;
            border-radius: 7px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            color: #888;
            background: transparent;
            cursor: pointer;
            transition: all 0.25s;
        }

        .tab-login button.active {
            background: white;
            color: #2C3E50;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Alert */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.82rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-error   { background: #fde8e8; color: #c0392b; border-left: 3px solid #e74c3c; }
        .alert-success { background: #e8f8e8; color: #196f3d; border-left: 3px solid #27ae60; }

        /* Form fields */
        .form-group { margin-bottom: 1.2rem; }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 100%;
            border: 1.5px solid #e0dbd4;
            border-radius: 10px;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.88rem;
            color: #2C3E50;
            background: white;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230,126,34,0.12);
        }

        input:focus + i, .input-wrap:focus-within i { color: #E67E22; }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #bbb;
            font-size: 0.85rem;
            left: auto;
            transition: color 0.2s;
        }

        .pw-toggle:hover { color: #E67E22; }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #E67E22;
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .btn-login:hover {
            background: #cf6d17;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(230,126,34,0.35);
        }

        .btn-login:active { transform: translateY(0); }

        /* Register link */
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: #888;
        }

        .register-link a {
            color: #E67E22;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .register-link a:hover { opacity: 0.75; }

        /* Role pills */
        .role-hint {
            background: #f4f0eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.76rem;
            color: #888;
        }

        .role-hint strong { color: #2C3E50; }

        .role-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 0.5rem;
        }

        .role-pill {
            padding: 0.2rem 0.7rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            cursor: pointer;
            border: 1.5px solid #e0dbd4;
            color: #666;
            transition: all 0.2s;
        }

        .role-pill:hover { border-color: #E67E22; color: #E67E22; }

        /* Responsive */
        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 2rem; }
        }
    </style>
</head>
<body>

<!-- Left Branding Panel -->
<div class="left-panel">
    <div class="logo-wrap">
        <img src="<?= base_url('assets/Tel-U_logo.png') ?>"
             alt="Telkom University"
             onerror="this.src='https:/via.placeholder.com/52x52/2C3E50/FFFFFF?text=TU'">
        <div class="logo-text">Telkom University<br>Fakultas Industri Kreatif</div>
    </div>

    <h1>Portal<br>Kemaha<span>siswaan</span><br>FIK</h1>

    <p>Sistem pengajuan dan monitoring proposal kegiatan kemahasiswaan secara digital, transparan, dan terintegrasi.</p>

    <div class="flow-steps">
        <div class="flow-step"><div class="dot"></div><span>Mahasiswa mengajukan proposal</span></div>
        <div class="flow-step"><div class="arrow"></div></div>
        <div class="flow-step"><div class="dot"></div><span>Dosen Pembina mereview</span></div>
        <div class="flow-step"><div class="arrow"></div></div>
        <div class="flow-step"><div class="dot"></div><span>BEM / DPM menyetujui</span></div>
        <div class="flow-step"><div class="arrow"></div></div>
        <div class="flow-step"><div class="dot"></div><span>Ka. Prodi memverifikasi</span></div>
        <div class="flow-step"><div class="arrow"></div></div>
        <div class="flow-step"><div class="dot"></div><span>TPA Kemahasiswaan final approve</span></div>
    </div>
</div>

<!-- Right Form Panel -->
<div class="right-panel">
    <div class="form-header">
        <h2>Selamat Datang</h2>
        <p>Masuk menggunakan akun SSO / NIM Anda</p>
    </div>

    <!-- Tab: Login / Daftar -->
    <div class="tab-login">
        <button class="active" onclick="switchTab('login', this)">Masuk</button>
        <button onclick="window.location='<?= site_url('login/register') ?>'">Daftar Akun</button>
    </div>

    <!-- Alert -->
    <?php if ($error): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= $error ?>
    </div>
    <?php endif; ?>

    <?php if ($success): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?= $success ?>
    </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="<?= site_url('login/proses') ?>">
        <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()) ?>

        <div class="form-group">
            <label>NIM / Username</label>
            <div class="input-wrap">
                <input type="text" name="username" placeholder="Masukkan NIM atau username" autocomplete="username" required>
                <i class="fas fa-id-card"></i>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrap">
                <input type="password" name="password" id="pw-field" placeholder="••••••••" autocomplete="current-password" required>
                <i class="fas fa-eye pw-toggle" id="pw-toggle" onclick="togglePw()"></i>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fas fa-sign-in-alt"></i> Masuk ke Portal
        </button>

        <?php /* ── MICROSOFT LOGIN — di-comment sementara atas permintaan pembimbing ──
        <div style="display: flex; align-items: center; margin: 1.5rem 0 1rem; color: #ccc;">
            <div style="flex: 1; height: 1px; background: #e0dbd4;"></div>
            <span style="padding: 0 10px; font-size: 0.75rem; color: #888; font-weight: 600; text-transform: uppercase;">atau</span>
            <div style="flex: 1; height: 1px; background: #e0dbd4;"></div>
        </div>

        <button type="button" class="btn-login" onclick="openMicrosoftModal()" style="background: #2f2f2f; border: 1px solid #444; color: white;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 23 23" style="margin-right: 8px;">
                <path fill="#f35325" d="M0 0h11v11H0z"/>
                <path fill="#80a300" d="M12 0h11v11H12z"/>
                <path fill="#00a1f1" d="M0 12h11v11H0z"/>
                <path fill="#ffb900" d="M12 12h11v11H12z"/>
            </svg>
            Masuk dengan Microsoft
        </button>
        */ ?>
    </form>

    <?php /* ── Modal & Style Microsoft — di-comment sementara ──
    <!-- Modal Simulasi Microsoft SSO Login -->
    <div id="microsoftModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 9999; align-items: center; justify-content: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <div style="background: white; width: 440px; padding: 44px; box-shadow: 0 4px 28px rgba(0,0,0,0.2); position: relative; text-align: left; color: #333; border-radius: 4px;">
            <div style="margin-bottom: 24px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="108" height="24" viewBox="0 0 137 32">
                    <path fill="#f35325" d="M0 0h15v15H0z"/>
                    <path fill="#80a300" d="M16 0h15v15H16z"/>
                    <path fill="#00a1f1" d="M0 16h15v15H0z"/>
                    <path fill="#ffb900" d="M16 16h15v15H16z"/>
                    <text x="36" y="22" font-family="'Segoe UI', Arial" font-weight="600" font-size="21" fill="#737373">Microsoft</text>
                </svg>
            </div>
            <div id="ms-step-email">
                <h3 style="font-size: 1.5rem; margin-bottom: 8px; font-weight: 600; color: #1b1b1b;">Sign in</h3>
                <p style="font-size: 0.9rem; color: #505050; margin-bottom: 20px;">Use your Telkom University Microsoft account</p>
                <div style="margin-bottom: 20px;">
                    <input type="email" id="ms-email" placeholder="someone@telkomuniversity.ac.id" style="width: 100%; padding: 8px 10px; font-size: 0.95rem; border: none; border-bottom: 1px solid #0067b8; outline: none; border-radius: 0; background: transparent;" required>
                    <div id="ms-error" style="color: #e81123; font-size: 0.82rem; margin-top: 8px; display: none;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 36px;">
                    <button type="button" onclick="closeMicrosoftModal()" style="padding: 6px 16px; font-size: 0.9rem; background: #cccccc; color: #333; border: none; border-radius: 0; cursor: pointer;">Cancel</button>
                    <button type="button" onclick="goToPasswordStep()" style="padding: 6px 32px; font-size: 0.9rem; background: #0067b8; color: white; border: none; border-radius: 0; cursor: pointer; font-weight: 600;">Next</button>
                </div>
            </div>
            <div id="ms-step-password" style="display: none;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 0.9rem; color: #505050;">
                    <button type="button" onclick="backToEmailStep()" style="border: none; background: transparent; cursor: pointer; padding: 0; display: inline-flex; align-items: center;">
                        <i class="fas fa-arrow-left" style="font-size: 0.95rem; color: #505050;"></i>
                    </button>
                    <span id="ms-display-email" style="font-weight: 500; word-break: break-all;">email@telkomuniversity.ac.id</span>
                </div>
                <h3 style="font-size: 1.5rem; margin-bottom: 8px; font-weight: 600; color: #1b1b1b;">Enter password</h3>
                <div style="margin-bottom: 20px;">
                    <input type="password" id="ms-password" placeholder="Password" style="width: 100%; padding: 8px 10px; font-size: 0.95rem; border: none; border-bottom: 1px solid #0067b8; outline: none; border-radius: 0; background: transparent;" required>
                    <div id="ms-error-pw" style="color: #e81123; font-size: 0.82rem; margin-top: 8px; display: none;"></div>
                </div>
                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 36px;">
                    <button type="button" onclick="closeMicrosoftModal()" style="padding: 6px 16px; font-size: 0.9rem; background: #cccccc; color: #333; border: none; border-radius: 0; cursor: pointer;">Cancel</button>
                    <button type="button" onclick="submitMicrosoftLogin()" style="padding: 6px 32px; font-size: 0.9rem; background: #0067b8; color: white; border: none; border-radius: 0; cursor: pointer; font-weight: 600;">Sign in</button>
                </div>
            </div>
            <div id="ms-step-loading" style="display: none; text-align: center; padding: 20px 0;">
                <div style="width: 32px; height: 32px; border: 3px solid rgba(0,103,184,0.2); border-top-color: #0067b8; border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 16px;"></div>
                <p style="font-size: 0.9rem; color: #505050;">Signing in...</p>
            </div>
        </div>
    </div>
    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
    */ ?>

    <div class="register-link">
        Belum punya akun? <a href="<?= site_url('login/register') ?>">Daftar di sini</a>
    </div>
</div>

<script>
function togglePw() {
    const f = document.getElementById('pw-field');
    const t = document.getElementById('pw-toggle');
    const isText = f.type === 'text';
    f.type = isText ? 'password' : 'text';
    t.className = `fas fa-${isText ? 'eye' : 'eye-slash'} pw-toggle`;
}

function switchTab(tab, btn) {
    document.querySelectorAll('.tab-login button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// Isi demo cepat untuk testing (hapus di production)
function fillDemo(role) {
    const map = {
        mahasiswa:     { u: 'demo_mhs',     p: 'password' },
        pembina:       { u: 'demo_pembina', p: 'password' },
        bemdpm:        { u: 'demo_bem',     p: 'password' },
        kaprodi:       { u: 'demo_kaprodi', p: 'password' },
        kemahasiswaan: { u: 'demo_tpa',     p: 'password' },
    };
    const d = map[role];
    if (d) {
        document.querySelector('[name=username]').value = d.u;
        document.getElementById('pw-field').value = d.p;
    }
}

/* ── JS Microsoft — di-comment sementara ──
function openMicrosoftModal() {
    document.getElementById('microsoftModal').style.display = 'flex';
    document.getElementById('ms-step-email').style.display = 'block';
    document.getElementById('ms-step-password').style.display = 'none';
    document.getElementById('ms-step-loading').style.display = 'none';
    document.getElementById('ms-error').style.display = 'none';
    document.getElementById('ms-error-pw').style.display = 'none';
    document.getElementById('ms-email').value = '';
    document.getElementById('ms-password').value = '';
}
function closeMicrosoftModal() {
    document.getElementById('microsoftModal').style.display = 'none';
}
function goToPasswordStep() {
    const email = document.getElementById('ms-email').value.trim();
    const errorEl = document.getElementById('ms-error');
    errorEl.style.display = 'none';
    if (!email || !email.includes('@')) {
        errorEl.textContent = 'Enter a valid email address.';
        errorEl.style.display = 'block';
        return;
    }
    document.getElementById('ms-display-email').textContent = email;
    document.getElementById('ms-step-email').style.display = 'none';
    document.getElementById('ms-step-password').style.display = 'block';
    document.getElementById('ms-password').focus();
}
function backToEmailStep() {
    document.getElementById('ms-step-password').style.display = 'none';
    document.getElementById('ms-step-email').style.display = 'block';
    document.getElementById('ms-error-pw').style.display = 'none';
}
function submitMicrosoftLogin() {
    const email = document.getElementById('ms-email').value.trim();
    const password = document.getElementById('ms-password').value;
    const errorPwEl = document.getElementById('ms-error-pw');
    errorPwEl.style.display = 'none';
    if (!password) {
        errorPwEl.textContent = 'Please enter your password.';
        errorPwEl.style.display = 'block';
        return;
    }
    document.getElementById('ms-step-password').style.display = 'none';
    document.getElementById('ms-step-loading').style.display = 'block';
    const formData = new URLSearchParams();
    formData.append('email', email);
    formData.append('password', password);
    fetch('<?= site_url("login/microsoft") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            window.location.href = data.redirect;
        } else {
            document.getElementById('ms-step-password').style.display = 'block';
            document.getElementById('ms-step-loading').style.display = 'none';
            errorPwEl.textContent = data.message;
            errorPwEl.style.display = 'block';
        }
    })
    .catch(error => {
        document.getElementById('ms-step-password').style.display = 'block';
        document.getElementById('ms-step-loading').style.display = 'none';
        errorPwEl.textContent = 'Connection error. Please try again.';
        errorPwEl.style.display = 'block';
    });
}
*/
</script>
</body>
</html>