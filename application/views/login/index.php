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
    </form>

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
</script>
</body>
</html>