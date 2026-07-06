<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Pengajuan Sertifikat - Kemahasiswaan FIK | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* ========== RESET & GLOBAL ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1f2937;
            overflow-x: hidden;
        }

        :root {
            --orange: #f97316;
            --orange-dark: #ea580c;
            --orange-light: #fff7ed;
            --blue: #1e3a8a;
            --gray-bg: #f8fafc;
            --border: #e2e8f0;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--orange);
            border-radius: 10px;
        }

        .container-custom {
            width: min(100% - 3rem, 1280px);
            margin-inline: auto;
        }

        /* ========== ANIMATIONS ========== */
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
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ========== HEADER GLASS ========== */
        .header-glass {
            position: absolute;
            top: 24px;
            left: 0;
            right: 0;
            z-index: 50;
            transition: all 0.3s ease;
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
            transition: all 0.3s ease;
        }

        .navbar-glass.scrolled {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(25px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(145deg, var(--orange), var(--orange-dark));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.4rem;
            box-shadow: 0 6px 12px rgba(249,115,22,0.3);
        }

        .logo-text h5 {
            font-size: 0.9rem;
            font-weight: 800;
            color: white;
            margin: 0;
            letter-spacing: -0.3px;
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
            position: relative;
            padding-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 2px;
            background: var(--orange);
            transition: 0.3s ease;
        }

        .nav-links a.active::after,
        .nav-links a:hover::after {
            width: 100%;
        }

        /* Dropdown Layanan - Dashboard Style */
        .dropdown-wrapper { position: relative; }
        .dropdown-wrapper > a { display: flex; align-items: center; gap: 8px; padding: 6px 0; color: white; text-decoration: none; font-weight: 600; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 4px; transition: all 0.3s ease; }
        .dropdown-wrapper > a i { font-size: 0.7rem; transition: transform 0.3s ease; }
        .dropdown-wrapper.open > a i { transform: rotate(180deg); }
        .dropdown-wrapper > a.active, .dropdown-wrapper > a:hover { border-bottom-color: #f97316; }
        .dropdown-menu-custom { position: absolute; top: calc(100% + 16px); left: 50%; transform: translateX(-50%) translateY(-12px); background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(30px); border-radius: 24px; padding: 16px 20px; min-width: 820px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3); opacity: 0; visibility: hidden; transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); z-index: 100; }
        .dropdown-wrapper.open .dropdown-menu-custom { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); }
        .dropdown-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; }
        .dropdown-item { padding: 24px 16px; text-align: center; border-radius: 16px; transition: all 0.3s ease; cursor: pointer; text-decoration: none; color: #1f2937; background: rgba(249, 115, 22, 0.02); min-height: 160px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        .dropdown-item:hover { transform: translateY(-4px); box-shadow: 0 12px 28px rgba(249, 115, 22, 0.15); background: #fff7ed; }
        .dropdown-item .d-icon-wrapper { width: 56px; height: 56px; margin: 0 auto 12px; border-radius: 16px; display: flex; align-items: center; justify-content: center; background: #f8fafc; }
        .dropdown-item .d-icon-wrapper i { font-size: 1.6rem; color: #f97316; }
        .dropdown-item .d-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; color: #1f2937; }
        .dropdown-item .d-desc { font-size: 0.75rem; color: #6b7280; line-height: 1.5; font-weight: 400; max-width: 140px; margin: 0 auto; }

        .btn-mytelu-custom {
            background: linear-gradient(105deg, var(--orange), var(--orange-dark));
            padding: 8px 28px;
            border-radius: 40px;
            font-weight: 700;
            color: white;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-mytelu-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(249, 115, 22, 0.4);
            color: white;
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
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
            transition: all 0.3s ease;
        }

        .mobile-toggle:hover {
            background: rgba(255,255,255,0.25);
        }

        /* ========== BACK BUTTON ========== */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: transparent;
            color: var(--orange);
            padding: 10px 24px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: 2px solid var(--orange);
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: var(--orange);
            color: white;
            transform: translateX(-4px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        /* ========== HERO SECTION ========== */
        .hero-sertifikat {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        .hero-sertifikat::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-sertifikat .wave-bottom {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-sertifikat h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: white;
            text-align: center;
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', serif;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease;
        }

        .hero-sertifikat p {
            color: rgba(255,255,255,0.95);
            font-size: 1.2rem;
            text-align: center;
            max-width: 700px;
            margin: 16px auto 0;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        /* ========== FLOATING ELEMENTS ========== */
        .floating-elements {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .floating-elements .element {
            position: absolute;
            opacity: 0.15;
            color: white;
            animation: float 6s ease-in-out infinite;
        }
        
        .floating-elements .element:nth-child(1) {
            top: 15%;
            left: 5%;
            font-size: 3rem;
            animation-delay: 0s;
        }
        
        .floating-elements .element:nth-child(2) {
            top: 60%;
            right: 8%;
            font-size: 2.5rem;
            animation-delay: 1s;
        }
        
        .floating-elements .element:nth-child(3) {
            bottom: 20%;
            left: 10%;
            font-size: 2rem;
            animation-delay: 0.5s;
        }
        
        .floating-elements .element:nth-child(4) {
            top: 30%;
            right: 15%;
            font-size: 2.8rem;
            animation-delay: 1.5s;
        }

        /* ========== SECTION STYLES ========== */
        .sertifikat-section {
            padding: 60px 0 80px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1f2937;
            position: relative;
            display: inline-block;
            padding-bottom: 16px;
            font-family: 'Playfair Display', serif;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            border-radius: 2px;
        }

        /* ========== INFO CARDS ========== */
        .info-card {
            background: white;
            border-radius: 24px;
            padding: 32px 24px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .info-card:hover::before {
            transform: scaleX(1);
        }

        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -12px rgba(249, 115, 22, 0.2);
            border-color: rgba(249,115,22,0.2);
        }

        .info-card-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(145deg, var(--orange-light), #fff);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            transition: all 0.3s ease;
        }

        .info-card:hover .info-card-icon {
            transform: scale(1.05) rotate(5deg);
        }

        .info-card-icon i {
            font-size: 2.2rem;
            color: var(--orange);
        }

        .info-card h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .info-card p {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-card ul li {
            color: #4b5563;
            font-size: 0.85rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-card ul li i {
            color: var(--orange);
            font-size: 0.8rem;
            width: 20px;
        }

        /* ========== TIMELINE ========== */
        .timeline-section {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 30px;
            padding: 48px 40px;
            margin: 40px 0;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .timeline-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(249,115,22,0.1), transparent);
            border-radius: 50%;
        }

        .timeline-section h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            font-family: 'Playfair Display', serif;
        }

        .timeline-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            gap: 20px;
            flex-wrap: wrap;
        }

        .timeline-steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 5%;
            width: 90%;
            height: 3px;
            background: linear-gradient(90deg, var(--orange), #fdba74, var(--orange));
            border-radius: 2px;
            z-index: 1;
        }

        .timeline-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
            padding: 0 8px;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border: 3px solid var(--orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-weight: 800;
            font-size: 2rem;
            color: var(--orange);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .timeline-step:hover .step-number {
            background: var(--orange);
            color: white;
            transform: scale(1.1) rotate(360deg);
            border-color: white;
        }

        .step-label {
            font-weight: 700;
            color: white;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .step-date {
            font-size: 0.85rem;
            color: #fdba74;
            font-weight: 600;
        }

        /* ========== FORM SECTION ========== */
        .form-section {
            background: white;
            border-radius: 32px;
            padding: 48px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            margin: 40px 0;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 25px 70px rgba(249,115,22,0.1);
        }

        .form-section h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 32px;
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
            font-family: 'Playfair Display', serif;
        }

        .form-section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--orange), var(--orange-dark));
            border-radius: 2px;
        }

        .form-label {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--orange);
            width: 20px;
        }

        .form-label .required {
            color: #ef4444;
            font-weight: 700;
        }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #faf9f7;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
            background: white;
            outline: none;
        }

        /* ========== FILE UPLOAD ========== */
        .file-upload {
            position: relative;
            margin-bottom: 16px;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-area {
            border: 2px dashed var(--orange);
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            background: linear-gradient(145deg, rgba(249,115,22,0.02), rgba(249,115,22,0.05));
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            background: rgba(249,115,22,0.08);
            border-color: var(--orange-dark);
            transform: translateY(-2px);
        }

        .file-upload-area i {
            font-size: 3rem;
            color: var(--orange);
            margin-bottom: 16px;
            transition: transform 0.3s ease;
        }

        .file-upload-area:hover i {
            transform: scale(1.1);
        }

        .file-upload-area h5 {
            color: #1f2937;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .file-upload-area p {
            color: #6b7280;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .file-info {
            display: none;
            background: linear-gradient(145deg, #f0fdf4, #e8fce8);
            border: 1px solid #22c55e;
            border-radius: 16px;
            padding: 16px;
            margin-top: 16px;
            align-items: center;
            gap: 16px;
            animation: fadeInUp 0.3s ease;
        }

        .file-info.show {
            display: flex;
        }

        .file-info i {
            font-size: 2rem;
            color: #22c55e;
        }

        .file-info .file-details {
            flex: 1;
        }

        .file-info .file-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            word-break: break-all;
        }

        .file-info .file-size {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .file-info .file-remove {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
            padding: 0;
        }

        .file-info .file-remove:hover {
            transform: scale(1.1);
        }

        /* ========== SUBMIT BUTTON ========== */
        .btn-submit {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            width: 100%;
            justify-content: center;
            margin-top: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(249, 115, 22, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* ========== STATUS BADGE ========== */
        .badge-status {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-submitted {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ========== RIWAYAT SECTION ========== */
        .table-section {
            background: white;
            border-radius: 28px;
            padding: 36px;
            margin: 40px 0;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .table-section:hover {
            box-shadow: 0 20px 40px rgba(249,115,22,0.08);
        }

        .table-section h3 {
            color: #1f2937;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-section h3 i {
            color: var(--orange);
        }

        .riwayat-item {
            background: #faf9f7;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 20px 24px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
        }

        .riwayat-item:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.1);
            border-color: var(--orange);
        }

        .riwayat-judul {
            font-weight: 800;
            color: #1f2937;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .riwayat-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .riwayat-meta i {
            color: var(--orange);
            width: 16px;
            margin-right: 4px;
        }

        /* ========== LOADING SCREEN ========== */
        .loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(8px);
            z-index: 99999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loading-screen.show {
            display: flex;
            animation: fadeInUp 0.3s ease;
        }

        .loading-card {
            background: white;
            border-radius: 32px;
            padding: 48px 64px;
            text-align: center;
            animation: fadeInUp 0.4s ease;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.3);
        }

        .loading-spinner {
            width: 70px;
            height: 70px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 24px;
        }

        .loading-card i {
            font-size: 3.5rem;
            color: var(--orange);
            margin-bottom: 24px;
            animation: float 2s ease-in-out infinite;
        }

        .loading-card h4 {
            color: #1f2937;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .loading-card p {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0;
        }

        .loading-progress {
            width: 280px;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            margin-top: 24px;
            overflow: hidden;
        }

        .loading-progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, var(--orange), #fdba74);
            border-radius: 3px;
            transition: width 0.3s ease;
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

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .timeline-steps {
                flex-direction: column;
                gap: 24px;
            }
            .timeline-steps::before {
                display: none;
            }
            .timeline-step {
                display: flex;
                align-items: center;
                gap: 20px;
                text-align: left;
                padding: 0;
            }
            .step-number {
                margin: 0;
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                flex-shrink: 0;
            }
            .timeline-step:hover .step-number {
                transform: scale(1.05);
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
            .hero-sertifikat {
                padding: 120px 0 60px;
            }
            .hero-sertifikat h1 {
                font-size: 2rem;
            }
            .form-section {
                padding: 24px;
            }
            .timeline-section {
                padding: 32px 20px;
            }
            .loading-card {
                padding: 30px 40px;
                margin: 0 20px;
            }
}
.btn-download-excel {
    background: #10b981;
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.8rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-download-excel:hover {
    background: #059669;
    transform: translateY(-2px);
    color: white;
}
    </style>
</head>
<body>

<!-- ========== LOADING SCREEN ========== -->
<div id="loadingScreen" class="loading-screen">
    <div class="loading-card">
        <i class="fas fa-certificate"></i>
        <h4>Mengirim Pengajuan...</h4>
        <p>Mohon tunggu, sedang memproses data Anda</p>
        <div class="loading-progress">
            <div class="loading-progress-bar" id="progressBar"></div>
        </div>
        <p class="mt-3" style="font-size: 0.75rem; color: #9ca3af;">
            <i class="fas fa-info-circle me-1"></i> Jangan tutup halaman ini
        </p>
    </div>
</div>

<?php $this->load->view('partials/navbar', ['active_menu' => 'layanan']); ?>

<!-- ========== HERO SECTION ========== -->
<section class="hero-sertifikat">
    <div class="floating-elements">
        <div class="element"><i class="fas fa-certificate"></i></div>
        <div class="element"><i class="fas fa-file-pdf"></i></div>
        <div class="element"><i class="fas fa-file-excel"></i></div>
        <div class="element"><i class="fas fa-stamp"></i></div>
    </div>
    <div class="container-custom">
        <h1 data-aos="fade-up">Pengajuan Sertifikat Kegiatan</h1>
        <p data-aos="fade-up" data-aos-delay="100">Ajukan sertifikat untuk kegiatan mahasiswa • Mudah • Cepat • Terverifikasi</p>
    </div>
    <div class="wave-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- ========== MAIN CONTENT ========== -->
<section class="sertifikat-section">
    <div class="container-custom">
        
        <!-- ===== TOMBOL KEMBALI ===== -->
        <a href="<?= base_url('dashboard') ?>" class="back-button" data-aos="fade-right">
            <i class="fas fa-arrow-left"></i>
            Kembali ke Dashboard
        </a>

        <!-- ===== SECTION TITLE ===== -->
        <div class="section-title" data-aos="fade-up">
            <h2>Pengajuan Sertifikat</h2>
            <p class="text-muted mt-3">Ajukan sertifikat untuk kegiatan yang telah dilaksanakan dengan mudah</p>
        </div>

        <!-- ===== INFO CARDS ===== -->
        <div class="row g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h3>Upload Desain</h3>
                    <p>Upload desain sertifikat dalam format PDF atau gambar</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Format: PDF, JPG, PNG</li>
                        <li><i class="fas fa-check-circle"></i> Maksimal 5MB per file</li>
                        <li><i class="fas fa-check-circle"></i> Resolusi minimal 300 DPI</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <h3>Data Penerima</h3>
                    <p>Upload data penerima dalam format Excel</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Format: XLS, XLSX, CSV</li>
                        <li><i class="fas fa-check-circle"></i> Maksimal 2MB</li>
                        <li><i class="fas fa-check-circle"></i> Template tersedia</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Waktu Proses</h3>
                    <p>Pengajuan diproses dalam waktu maksimal</p>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Review awal: 1×24 jam</li>
                        <li><i class="fas fa-check-circle"></i> Penerbitan: 2×24 jam</li>
                        <li><i class="fas fa-check-circle"></i> Notifikasi via email</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ===== TIMELINE ===== -->
        <div class="timeline-section" data-aos="fade-up">
            <h3>📋 Alur Pengajuan Sertifikat</h3>
            <div class="timeline-steps">
                <div class="timeline-step">
                    <div class="step-number">1</div>
                    <div class="step-label">Upload File</div>
                    <div class="step-date">Desain & Data</div>
                </div>
                <div class="timeline-step">
                    <div class="step-number">2</div>
                    <div class="step-label">Verifikasi</div>
                    <div class="step-date">1×24 jam</div>
                </div>
                <div class="timeline-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Penerbitan</div>
                    <div class="step-date">2×24 jam</div>
                </div>
                <div class="timeline-step">
                    <div class="step-number">4</div>
                    <div class="step-label">Selesai</div>
                    <div class="step-date">Siap Diunduh</div>
                </div>
            </div>
        </div>

        <!-- Form Section - VERSI SEDERHANA TANPA UPLOAD -->
<div class="form-section" id="form-pengajuan" data-aos="fade-up">
    <h2><i class="fas fa-pen-alt me-3"></i>Formulir Pengajuan Sertifikat</h2>
    
    <form id="sertifikatForm" method="post" action="<?= base_url('sertifikat/kirim') ?>">
        <div class="row g-4">
            <!-- Nama PIC -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Nama PIC <span class="required">*</span></label>
                    <input type="text" class="form-control" name="nama_pic" required>
                </div>
            </div>
            
            <!-- NIM (readonly) -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" class="form-control" value="<?= $user_data['nim'] ?? '-' ?>" readonly>
                    <input type="hidden" name="nim" value="<?= $user_data['nim'] ?? '' ?>">
                </div>
            </div>
            
            <!-- Judul Kegiatan -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Judul Kegiatan <span class="required">*</span></label>
                    <input type="text" class="form-control" name="judul_kegiatan" required>
                </div>
            </div>
            
            <!-- Deskripsi Kegiatan -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Deskripsi Kegiatan</label>
                    <textarea class="form-control" name="deskripsi_kegiatan" rows="3"></textarea>
                </div>
            </div>
            
            <!-- Tanggal Kegiatan -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tanggal Kegiatan <span class="required">*</span></label>
                    <input type="date" class="form-control" name="tanggal_kegiatan" required>
                </div>
            </div>
            
            <!-- Lokasi Kegiatan -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Lokasi Kegiatan <span class="required">*</span></label>
                    <input type="text" class="form-control" name="lokasi_kegiatan" required>
                </div>
            </div>
            
            <!-- Catatan Tambahan -->
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea class="form-control" name="catatan_tambahan" rows="2"></textarea>
                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Ajukan Sertifikat
                </button>
            </div>
        </div>
    </form>
</div>

        <!-- ===== RIWAYAT PENGAJUAN ===== -->
<div class="table-section" data-aos="fade-up">
    <h3><i class="fas fa-history me-2"></i>Riwayat Pengajuan Sertifikat</h3>
    
    <?php if (!empty($riwayat) && is_array($riwayat)): ?>
        <?php foreach ($riwayat as $r): ?>
            <?php
                $badge_class = '';
                $badge_text = '';
                
                if (isset($r['status'])) {
                    if ($r['status'] == 'submitted') {
                        $badge_class = 'badge-submitted';
                        $badge_text = 'Menunggu Review';
                    } elseif ($r['status'] == 'approved') {
                        $badge_class = 'badge-approved';
                        $badge_text = 'Disetujui';
                    } elseif ($r['status'] == 'rejected') {
                        $badge_class = 'badge-rejected';
                        $badge_text = 'Ditolak';
                    }
                }
            ?>
            <div class="riwayat-item">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div style="flex: 1;">
                        <div class="riwayat-judul"><?= isset($r['judul_kegiatan']) ? htmlspecialchars($r['judul_kegiatan']) : '-' ?></div>
                        <div class="riwayat-meta">
                            <span><i class="fas fa-barcode"></i> <?= isset($r['kode_pengajuan']) ? htmlspecialchars($r['kode_pengajuan']) : '-' ?></span>
                            <span><i class="fas fa-calendar"></i> <?= isset($r['tanggal_kegiatan']) ? date('d M Y', strtotime($r['tanggal_kegiatan'])) : '-' ?></span>
                            <span><i class="fas fa-map-marker-alt"></i> <?= isset($r['lokasi_kegiatan']) ? htmlspecialchars($r['lokasi_kegiatan']) : '-' ?></span>
                        </div>
                        
                        <?php if (isset($r['status']) && $r['status'] == 'approved'): ?>
                        <div class="mt-3 p-2" style="background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                            <div>
                                <i class="fas fa-file-excel me-2" style="color: #065f46;"></i>
                                <strong>File Export:</strong> Data pengajuan telah tersedia
                            </div>
                            <a href="<?= base_url('sertifikat/download_export/' . $r['id']) ?>" class="btn-download-excel" style="background: #10b981; color: white; padding: 6px 16px; border-radius: 20px; text-decoration: none; font-size: 0.8rem; transition: all 0.3s;">
                                <i class="fas fa-download me-1"></i> Download Excel
                            </a>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($r['status']) && $r['status'] == 'rejected' && !empty($r['catatan_admin'])): ?>
                        <div class="mt-3 p-2" style="background: #fee2e2; border-radius: 12px;">
                            <i class="fas fa-comment me-2" style="color: #991b1b;"></i>
                            <strong>Alasan:</strong> <?= htmlspecialchars($r['catatan_admin']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <span class="badge-status <?= $badge_class ?>"><?= $badge_text ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-4x mb-3" style="color: #cbd5e1;"></i>
            <h5 style="color: #6b7280;">Belum Ada Riwayat Pengajuan</h5>
            <p class="text-muted">Ajukan sertifikat pertama Anda melalui formulir di atas.</p>
        </div>
    <?php endif; ?>
</div>
</section>

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
                    <li class="mb-2"><a href="#">Layanan Mahasiswa</a></li>
                    <li class="mb-2"><a href="#">Forum Alumni</a></li>
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

<!-- ========== SCRIPTS ========== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({ duration: 800, once: true, offset: 50 });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // ==================== LOADING SCREEN ====================
    let progressInterval;
    
    function showLoadingScreen() {
        const loadingScreen = document.getElementById('loadingScreen');
        const progressBar = document.getElementById('progressBar');
        
        if (loadingScreen) {
            loadingScreen.classList.add('show');
            
            let progress = 0;
            if (progressBar) {
                progressBar.style.width = '0%';
                progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress >= 90) {
                        progress = 90;
                        clearInterval(progressInterval);
                    }
                    progressBar.style.width = progress + '%';
                }, 300);
            }
        }
    }
    
    function hideLoadingScreen() {
        const loadingScreen = document.getElementById('loadingScreen');
        const progressBar = document.getElementById('progressBar');
        
        if (progressInterval) {
            clearInterval(progressInterval);
        }
        
        if (progressBar) {
            progressBar.style.width = '100%';
        }
        
        setTimeout(() => {
            if (loadingScreen) {
                loadingScreen.classList.remove('show');
            }
            if (progressBar) {
                progressBar.style.width = '0%';
            }
        }, 500);
    }
    
    function showAlert(message, type) {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: type === 'success' ? 'Berhasil!' : 'Perhatian!',
            text: message,
            confirmButtonColor: '#f97316',
            timer: 3000,
            showConfirmButton: true
        });
    }

    // ==================== FILE UPLOAD HANDLING ====================
    function setupFileUpload(inputId, infoId, nameId, sizeId, maxSizeMB) {
        const input = document.getElementById(inputId);
        const info = document.getElementById(infoId);
        const nameEl = document.getElementById(nameId);
        const sizeEl = document.getElementById(sizeId);
        
        if (!input || !info) return;
        
        input.addEventListener('change', function(e) {
            const file = this.files[0];
            if (!file) return;
            
            const maxSize = maxSizeMB * 1024 * 1024;
            if (file.size > maxSize) {
                showAlert(`File terlalu besar. Maksimal ${maxSizeMB}MB`, 'error');
                this.value = '';
                return;
            }
            
            info.classList.add('show');
            nameEl.textContent = file.name;
            sizeEl.textContent = (file.size / 1024).toFixed(2) + ' KB';
            
            const icon = info.querySelector('i');
            if (file.type.includes('pdf')) {
                icon.className = 'fas fa-file-pdf';
            } else if (file.name.match(/\.(xls|xlsx|csv)$/i)) {
                icon.className = 'fas fa-file-excel';
            } else if (file.type.includes('image')) {
                icon.className = 'fas fa-file-image';
            }
        });
        
        const uploadArea = document.getElementById(inputId + 'UploadArea');
        if (uploadArea) {
            uploadArea.addEventListener('click', function() {
                input.click();
            });
        }
    }

    window.removeFile = function(type) {
        const inputId = type === 'sertifikat' ? 'file_sertifikat' : 'file_penerima';
        const infoId = type + 'Info';
        
        const input = document.getElementById(inputId);
        const info = document.getElementById(infoId);
        
        if (input) input.value = '';
        if (info) info.classList.remove('show');
    };

    // Initialize file uploads
    setupFileUpload('file_sertifikat', 'sertifikatInfo', 'sertifikatName', 'sertifikatSize', 5);
    setupFileUpload('file_penerima', 'penerimaInfo', 'penerimaName', 'penerimaSize', 2);

    // Set max date for date input
    const dateInput = document.getElementById('tanggal_kegiatan');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('max', today);
    }

    // Form submit handler
    const form = document.getElementById('sertifikatForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            const namaPic = document.getElementById('nama_pic')?.value.trim();
            const judulKegiatan = document.getElementById('judul_kegiatan')?.value.trim();
            const tanggalKegiatan = document.getElementById('tanggal_kegiatan')?.value;
            const lokasiKegiatan = document.getElementById('lokasi_kegiatan')?.value.trim();
            const fileSertifikat = document.getElementById('file_sertifikat')?.files[0];
            const filePenerima = document.getElementById('file_penerima')?.files[0];
            
            if (!namaPic) {
                e.preventDefault();
                showAlert('Nama PIC wajib diisi', 'error');
                document.getElementById('nama_pic')?.focus();
                return false;
            }
            
            if (!judulKegiatan) {
                e.preventDefault();
                showAlert('Judul kegiatan wajib diisi', 'error');
                document.getElementById('judul_kegiatan')?.focus();
                return false;
            }
            
            if (!tanggalKegiatan) {
                e.preventDefault();
                showAlert('Tanggal kegiatan wajib diisi', 'error');
                document.getElementById('tanggal_kegiatan')?.focus();
                return false;
            }
            
            if (!lokasiKegiatan) {
                e.preventDefault();
                showAlert('Lokasi kegiatan wajib diisi', 'error');
                document.getElementById('lokasi_kegiatan')?.focus();
                return false;
            }
            
            if (!fileSertifikat) {
                e.preventDefault();
                showAlert('File desain sertifikat wajib diupload', 'error');
                return false;
            }
            
            if (!filePenerima) {
                e.preventDefault();
                showAlert('File data penerima wajib diupload', 'error');
                return false;
            }
            
            showLoadingScreen();
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            
            return true;
        });
    }
    
    // Hide loading screen on page load
    window.addEventListener('load', function() {
        hideLoadingScreen();
    });
    
    // Fix gambar error
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            if(!this.src.includes('placehold.co')) {
                this.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>