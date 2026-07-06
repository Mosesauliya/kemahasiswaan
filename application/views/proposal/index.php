<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Pengajuan Proposal - Kemahasiswaan FIK | Telkom University</title>

    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

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
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 16px 48px rgba(249, 115, 22, 0.12);
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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
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

        /* ========== HERO SECTION ========== */
        .hero-proposal {
            background: linear-gradient(135deg, #f97316 0%, #fdba74 100%);
            padding: 160px 0 100px;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 88%, 0 100%);
        }

        .hero-proposal::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 20% 30%, rgba(255,255,200,0.2) 2px, transparent 2.5px);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .hero-proposal .wave-bottom {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            line-height: 0;
        }

        .hero-proposal h1 {
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

        .hero-proposal p {
            color: rgba(255,255,255,0.95);
            font-size: 1.2rem;
            text-align: center;
            max-width: 700px;
            margin: 16px auto 0;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        /* Floating Elements */
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

        /* ========== PROPOSAL SECTION ========== */
        .proposal-section {
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

        /* ========== TAB SWITCHER ========== */
        .tab-switcher {
            display: flex;
            gap: 16px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .tab-switcher .tab-btn {
            padding: 12px 36px;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            background: white;
            color: #6b7280;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .tab-switcher .tab-btn:hover {
            border-color: var(--orange);
            color: var(--orange);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(249,115,22,0.1);
        }

        .tab-switcher .tab-btn.active {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            border-color: var(--orange);
            color: white;
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.3);
        }

        .tab-switcher .tab-btn i {
            margin-right: 10px;
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

        /* ========== PROPOSAL LIST ========== */
        .proposal-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .proposal-list-header h5 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .proposal-list-header h5 i {
            color: var(--orange);
        }

        .btn-create {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(249,115,22,0.2);
        }

        .btn-create:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(249,115,22,0.35);
            color: white;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            background: white;
            border-radius: 28px;
            padding: 64px 32px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            box-shadow: 0 25px 50px -12px rgba(249,115,22,0.15);
        }

        .empty-state .icon-wrapper {
            width: 100px;
            height: 100px;
            background: linear-gradient(145deg, var(--orange-light), #fff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: float 3s ease-in-out infinite;
        }

        .empty-state .icon-wrapper i {
            font-size: 3rem;
            color: var(--orange);
        }

        .empty-state h5 {
            color: #1f2937;
            font-size: 1.2rem;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* ========== PROPOSAL TABLE ========== */
        .proposal-table-wrap {
            background: white;
            border-radius: 28px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .proposal-table-wrap:hover {
            box-shadow: 0 25px 50px -12px rgba(249,115,22,0.15);
        }

        .proposal-table {
            width: 100%;
            border-collapse: collapse;
        }

        .proposal-table thead th {
            background: #f8fafc;
            color: #1f2937;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 18px 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .proposal-table tbody td {
            padding: 16px 20px;
            font-size: 0.9rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .proposal-table tbody tr:last-child td {
            border-bottom: none;
        }

        .proposal-table tbody tr {
            transition: all 0.3s ease;
        }

        .proposal-table tbody tr:hover td {
            background: #faf9f7;
            transform: scale(1.01);
        }

        /* ========== STATUS BADGE ========== */
        .status-badge {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-draft    { background: #e8f4fd; color: #2980b9; }
        .status-review   { background: #fff3e0; color: #f97316; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-revision { background: #f3e8ff; color: #8e44ad; }

        /* ========== ACTION BUTTONS ========== */
        .btn-action {
            padding: 8px 16px;
            font-size: 0.8rem;
            border-radius: 30px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 2px;
            text-decoration: none;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-view-pdf  { background: #e8f4fd; color: #2980b9; }
        .btn-view-pdf:hover  { background: #2980b9; color: white; }

        .btn-download-pdf { background: #d1fae5; color: #065f46; }
        .btn-download-pdf:hover { background: #065f46; color: white; }

        .btn-edit-prop { background: #fff3e0; color: #f97316; }
        .btn-edit-prop:hover { background: #f97316; color: white; }

        .btn-resubmit { background: #fee2e2; color: #991b1b; }
        .btn-resubmit:hover { background: #991b1b; color: white; }

        .btn-delete-prop { background: #fee2e2; color: #991b1b; }
        .btn-delete-prop:hover { background: #991b1b; color: white; }

        .btn-detail-prop { background: #e8f0fe; color: #3b5bdb; }
        .btn-detail-prop:hover { background: #3b5bdb; color: white; }

        .btn-pdf-disabled, .btn-edit-disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ========== FORM CONTAINER ========== */
        .form-container {
            background: white;
            border-radius: 32px;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            padding: 20px 32px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .form-header h5 i {
            color: var(--orange);
            margin-right: 10px;
        }

        .form-header #step-indicator {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
        }

        /* ========== STEP PROGRESS ========== */
        .step-progress {
            padding: 24px 32px;
            background: #faf9f7;
            border-bottom: 1px solid #e2e8f0;
        }

        .steps-row {
            display: flex;
            align-items: center;
            gap: 0;
            position: relative;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 60%;
            width: 80%;
            height: 2px;
            background: #e2e8f0;
            z-index: 0;
            transition: background 0.4s ease;
        }

        .step-item.completed:not(:last-child)::after {
            background: var(--orange);
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e2e8f0;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            z-index: 1;
            transition: all 0.3s ease;
            position: relative;
        }

        .step-item.active .step-circle {
            background: var(--orange);
            color: white;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.2);
            transform: scale(1.1);
        }

        .step-item.completed .step-circle {
            background: #22c55e;
            color: white;
        }

        .step-label {
            font-size: 0.75rem;
            margin-top: 8px;
            color: #6b7280;
            font-weight: 500;
            text-align: center;
            max-width: 80px;
        }

        .step-item.active .step-label {
            color: var(--orange);
            font-weight: 700;
        }

        /* ========== FORM BODY ========== */
        .form-body {
            padding: 32px;
        }

        .form-step {
            display: none;
            animation: fadeStep 0.4s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeStep {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .form-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section-title i {
            color: var(--orange);
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--orange);
            width: 18px;
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

        .info-box {
            background: #e8f4fd;
            border-left: 4px solid #3b82f6;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .info-box i {
            margin-right: 8px;
        }

        .char-counter {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: right;
            margin-top: 4px;
        }

        /* ========== BUDGET TABLE ========== */
        .budget-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            border-radius: 16px;
            overflow: hidden;
        }

        .budget-table th {
            background: #f8fafc;
            color: #1f2937;
            font-weight: 600;
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #e2e8f0;
        }

        .budget-table td {
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
        }

        .budget-table td input {
            border: none;
            outline: none;
            width: 100%;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            background: transparent;
        }

        .budget-table td input:focus {
            color: var(--orange);
        }

        .budget-total {
            font-weight: 700;
            color: #1f2937;
        }

        .btn-add-row {
            font-size: 0.85rem;
            color: var(--orange);
            background: none;
            border: 2px dashed var(--orange);
            padding: 10px 24px;
            border-radius: 40px;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-add-row:hover {
            background: var(--orange-light);
            border-color: var(--orange-dark);
            transform: translateY(-2px);
        }

        .btn-remove-row {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 4px;
            font-size: 1rem;
            transition: transform 0.2s ease;
        }

        .btn-remove-row:hover {
            transform: scale(1.2);
        }

        /* ========== REVIEW CARD ========== */
        .review-card {
            background: linear-gradient(145deg, #faf9f7, #ffffff);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 20px 24px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            border-color: var(--orange);
            box-shadow: 0 8px 20px rgba(249,115,22,0.1);
        }

        .review-card h6 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--orange);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .review-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .review-label {
            color: #6b7280;
            min-width: 160px;
            font-weight: 500;
        }

        .review-value {
            color: #1f2937;
            font-weight: 600;
            flex: 1;
        }

        /* ========== FORM NAVIGATION ========== */
        .form-navigation {
            padding: 20px 32px;
            background: #faf9f7;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-nav {
            padding: 10px 28px;
            border-radius: 40px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-prev {
            background: #e2e8f0;
            color: #1f2937;
        }

        .btn-prev:hover {
            background: #cbd5e1;
            transform: translateX(-4px);
        }

        .btn-next {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark));
            color: white;
        }

        .btn-next:hover {
            transform: translateX(4px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }

        .btn-submit {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
        }

        .btn-save-draft {
            background: white;
            color: #1f2937;
            border: 2px solid #e2e8f0 !important;
        }

        .btn-save-draft:hover {
            border-color: var(--orange) !important;
            color: var(--orange);
            transform: translateY(-2px);
        }

        /* ========== TOAST & LOADING ========== */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .custom-toast {
            background: white;
            color: #1f2937;
            padding: 16px 24px;
            border-radius: 16px;
            font-size: 0.9rem;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInToast 0.3s ease;
            border-left: 4px solid var(--orange);
            min-width: 300px;
        }

        .custom-toast.success {
            border-left-color: #22c55e;
        }

        .custom-toast.error {
            border-left-color: #ef4444;
        }

        @keyframes slideInToast {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        #loading-indicator {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(8px);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }

        #loading-indicator .loading-content {
            background: white;
            padding: 32px 48px;
            border-radius: 24px;
            text-align: center;
            animation: fadeInUp 0.3s ease;
        }

        #loading-indicator .loading-content i {
            font-size: 2.5rem;
            color: var(--orange);
            margin-bottom: 12px;
            animation: spin 1s linear infinite;
        }

        /* ========== MODAL ========== */
        .modal-detail .modal-dialog {
            max-width: 700px;
        }

        .modal-content {
            border-radius: 28px;
            overflow: hidden;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            border: none;
            padding: 20px 24px;
        }

        .modal-header .modal-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .modal-header .modal-title i {
            color: var(--orange);
            margin-right: 8px;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 24px;
            background: white;
        }

        .modal-footer {
            background: #faf9f7;
            border-top: 1px solid #e2e8f0;
            padding: 16px 24px;
        }

        .detail-kegiatan-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px;
        }

        .detail-catatan-rejection {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #991b1b;
            margin-bottom: 16px;
        }

        .detail-pdf-available {
            background: #d1fae5;
            border-left: 4px solid #22c55e;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #065f46;
            margin-bottom: 16px;
        }

        .detail-pdf-pending {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #92400e;
            margin-bottom: 16px;
        }

        .detail-section {
            margin-bottom: 20px;
        }

        .detail-section-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--orange);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            font-size: 0.95rem;
            color: #1f2937;
            font-weight: 600;
        }

        .detail-text-block {
            background: #faf9f7;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.6;
            border: 1px solid #e2e8f0;
            max-height: 150px;
            overflow-y: auto;
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
            .detail-grid {
                grid-template-columns: 1fr;
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
            .hero-proposal {
                padding: 120px 0 60px;
            }
            .hero-proposal h1 {
                font-size: 2rem;
            }
            .hero-proposal p {
                font-size: 1rem;
            }
            .tab-switcher {
                flex-direction: column;
                gap: 12px;
                padding: 0 16px;
            }
            .tab-switcher .tab-btn {
                width: 100%;
                justify-content: center;
            }
            .proposal-list-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            .proposal-table-wrap {
                overflow-x: auto;
            }
            .proposal-table {
                min-width: 800px;
            }
            .form-body {
                padding: 16px;
            }
            .step-progress {
                padding: 16px 20px;
            }
            .steps-row .step-label {
                display: none;
            }
            .form-navigation {
                flex-direction: column;
                align-items: stretch;
            }
            .review-row {
                flex-direction: column;
                gap: 2px;
            }
            .review-label {
                min-width: auto;
            }
            .container-custom {
                width: min(100% - 1.5rem, 1280px);
            }
            .toast-container {
                bottom: 16px;
                right: 16px;
                left: 16px;
            }
            .custom-toast {
                min-width: auto;
                width: calc(100% - 32px);
            }
        }
    </style>

    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

</head>
<body>

    <!-- ========== LOADING INDICATOR ========== -->
    <div id="loading-indicator">
        <div class="loading-content">
            <i class="fas fa-spinner"></i>
            <p class="mt-3">Memproses data...</p>
        </div>
    </div>

    <?php $this->load->view('partials/navbar', ['active_menu' => 'layanan']); ?>

    <!-- ========== HERO SECTION ========== -->
    <section class="hero-proposal">
        <div class="floating-elements">
            <div class="element"><i class="fas fa-file-alt"></i></div>
            <div class="element"><i class="fas fa-clipboard-list"></i></div>
            <div class="element"><i class="fas fa-chart-line"></i></div>
            <div class="element"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="container-custom">
            <h1 data-aos="fade-up">Pengajuan Proposal</h1>
            <p data-aos="fade-up" data-aos-delay="100">Dibuat dua tampilan/pilihan untuk proses pengajuan proposal ini yaitu: Proposal Kegiatan Ormawa dan Proposal Kompetisi</p>
        </div>
        <div class="wave-bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" style="width:100%;">
                <path fill="#ffffff" fill-opacity="1" d="M0,64L80,74.7C160,85,320,107,480,106.7C640,107,800,85,960,80C1120,75,1280,85,1360,90.7L1440,96L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
            </svg>
        </div>
    </section>

    <!-- ========== MAIN CONTENT ========== -->
    <section class="proposal-section">
        <div class="container-custom">
            
            <!-- ===== SECTION TITLE ===== -->
            <div class="section-title" data-aos="fade-up">
                <h2>Kelola Proposal</h2>
                <p class="text-muted mt-3">Ajukan proposal kegiatan ormawa atau proposal kompetisi dengan mudah</p>
            </div>

            <!-- ===== TAB SWITCHER ===== -->
            <div class="tab-switcher" data-aos="fade-up">
                <button class="tab-btn active" onclick="switchProposalType('ormawa', this)">
                    <i class="fas fa-users"></i> Proposal Kegiatan Ormawa
                </button>
                <button class="tab-btn" onclick="switchProposalType('kompetisi', this)">
                    <i class="fas fa-trophy"></i> Proposal Kompetisi
                </button>
            </div>

            <!-- ===== VIEW LIST ===== -->
            <div id="view-list">
                <div class="proposal-list-header" data-aos="fade-up">
                    <div>
                        <h5><i class="fas fa-file-alt"></i> Daftar Proposal</h5>
                        <small class="text-muted">Kelola pengajuan proposal kegiatan kemahasiswaan</small>
                    </div>
                    <button class="btn-create" onclick="goToCreate()">
                        <i class="fas fa-plus"></i> Buat Proposal Baru
                    </button>
                </div>

                <div class="empty-state" id="empty-state" data-aos="fade-up">
                    <div class="icon-wrapper">
                        <i class="fas fa-file-circle-plus"></i>
                    </div>
                    <h5>Belum ada proposal</h5>
                    <p>Mulai ajukan proposal kegiatan ormawa atau kompetisi Anda sekarang</p>
                </div>

                <div class="proposal-table-wrap d-none" id="proposal-table" data-aos="fade-up">
                    <table class="table proposal-table mb-0">
                        <thead>
                            <tr>
                                <th width="40">#</th>
                                <th>Nama Kegiatan</th>
                                <th>Ormawa / Komunitas</th>
                                <th>Tanggal Kegiatan</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th width="220">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="proposal-tbody"></tbody>
                    </table>
                </div>
            </div>

            <!-- ===== VIEW FORM ===== -->
            <div id="view-form" class="d-none">
                <div class="mb-4" data-aos="fade-right">
                    <button class="btn-action btn-edit-prop" onclick="backToList()" style="padding:10px 24px; font-size:0.9rem;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Proposal
                    </button>
                </div>

                <div class="form-container" data-aos="fade-up">
                    <div class="form-header">
                        <h5><i class="fas fa-file-edit"></i> Formulir Proposal</h5>
                        <span id="step-indicator">Langkah 1 dari 5</span>
                    </div>

                    <div class="step-progress">
                        <div class="steps-row" id="steps-row">
                            <div class="step-item active" data-step="1">
                                <div class="step-circle">1</div>
                                <div class="step-label">Identitas</div>
                            </div>
                            <div class="step-item" data-step="2">
                                <div class="step-circle">2</div>
                                <div class="step-label">Pendahuluan</div>
                            </div>
                            <div class="step-item" data-step="3">
                                <div class="step-circle">3</div>
                                <div class="step-label">Pelaksanaan</div>
                            </div>
                            <div class="step-item" data-step="4">
                                <div class="step-circle">4</div>
                                <div class="step-label">Anggaran</div>
                            </div>
                            <div class="step-item" data-step="5">
                                <div class="step-circle"><i class="fas fa-check" style="font-size:0.8rem;"></i></div>
                                <div class="step-label">Pengajuan</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <!-- STEP 1 -->
                        <div class="form-step active" id="step-1">
                            <div class="form-section-title"><i class="fas fa-id-card"></i> Identitas Kegiatan</div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Ormawa / Komunitas <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="f_ormawa" placeholder="Contoh: Himpunan Mahasiswa Desain Produk">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tahun Kegiatan <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="f_tahun" placeholder="Contoh: FIK FEST 2026">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tema Kegiatan</label>
                                    <input type="text" class="form-control" id="f_tema" placeholder="Tema spesifik kegiatan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kegiatan <span class="required">*</span></label>
                                    <select class="form-select" id="f_jenis">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option>Seminar / Workshop</option>
                                        <option>Perlombaan / Kompetisi</option>
                                        <option>Bakti Sosial</option>
                                        <option>Festival / Pameran</option>
                                        <option>Pelatihan</option>
                                        <option>Studi Banding / Kunjungan</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Kegiatan <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="f_nama_kegiatan" placeholder="Nama resmi kegiatan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Balai / Divisi</label>
                                    <input type="text" class="form-control" id="f_balai" placeholder="Contoh: Divisi Akademik">
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2 -->
                        <div class="form-step" id="step-2">
                            <div class="form-section-title"><i class="fas fa-scroll"></i> Pendahuluan & Tujuan</div>
                            <div class="info-box"><i class="fas fa-info-circle"></i> Jelaskan latar belakang kegiatan secara singkat, padat, dan jelas sesuai relevansi akademik & kreativitas.</div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Latar Belakang <span class="required">*</span></label>
                                    <textarea class="form-control tinymce-editor" id="f_latar_belakang" rows="5" placeholder="Jelaskan alasan mengapa kegiatan ini perlu dilaksanakan..."></textarea>
                                    <div class="char-counter"><span id="cc_latar">0</span> / 1500</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Tujuan & Manfaat <span class="required">*</span></label>
                                    <textarea class="form-control tinymce-editor" id="f_tujuan" rows="4" placeholder="1. Tujuan Pertama&#10;2. Tujuan Kedua&#10;3. Manfaat bagi peserta..."></textarea>
                                    <div class="char-counter"><span id="cc_tujuan">0</span> / 1000</div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Sasaran Kegiatan <span class="required">*</span></label>
                                    <textarea class="form-control tinymce-editor" id="f_sasaran" rows="3" placeholder="Mahasiswa FIK, Dosen, Komunitas Eksternal..."></textarea>
                                    <div class="char-counter"><span id="cc_sasaran">0</span> / 500</div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3 -->
                        <div class="form-step" id="step-3">
                            <div class="form-section-title"><i class="fas fa-calendar-alt"></i> Waktu & Pelaksanaan</div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal <span class="required">*</span></label>
                                    <input type="date" class="form-control" id="f_tanggal">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Waktu Mulai <span class="required">*</span></label>
                                    <input type="time" class="form-control" id="f_waktu_mulai">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Waktu Selesai</label>
                                    <input type="time" class="form-control" id="f_waktu_selesai">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat / Lokasi <span class="required">*</span></label>
                                    <input type="text" class="form-control" id="f_lokasi" placeholder="Gedung, Ruangan, atau Lokasi Online">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Estimasi Peserta</label>
                                    <input type="number" class="form-control" id="f_peserta" placeholder="Jumlah peserta yang diharapkan">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Susunan Panitia <span class="required">*</span></label>
                                    <textarea class="form-control" id="f_panitia" rows="4" placeholder="Ketua Panitia: (nama)&#10;Sekretaris: (nama)&#10;Bendahara: (nama)&#10;Divisi Acara: (nama)"></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Susunan Acara (Rundown)</label>
                                    <textarea class="form-control" id="f_rundown" rows="4" placeholder="08.00 - 09.00: Registrasi&#10;09.00 - 09.30: Pembukaan&#10;..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4 -->
                        <div class="form-step" id="step-4">
                            <div class="form-section-title"><i class="fas fa-coins"></i> Rencana Anggaran Biaya</div>
                            <div class="info-box"><i class="fas fa-info-circle"></i> Masukkan estimasi biaya kegiatan. Semua nilai dalam Rupiah (IDR).</div>

                            <table class="budget-table mb-2" id="budget-table">
                                <thead>
                                    <tr>
                                        <th width="40">#</th>
                                        <th>Uraian Kegiatan / Item</th>
                                        <th width="90">Volume</th>
                                        <th width="100">Satuan</th>
                                        <th width="140">Harga Satuan (Rp)</th>
                                        <th width="140">Jumlah (Rp)</th>
                                        <th width="40"></th>
                                    </tr>
                                </thead>
                                <tbody id="budget-rows"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align:right; font-weight:700; padding:12px 16px;">TOTAL</td>
                                        <td style="padding:12px 16px;" class="budget-total" id="budget-total">Rp 0</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="button" class="btn-add-row" onclick="addBudgetRow()"><i class="fas fa-plus me-2"></i>Tambah Baris</button>

                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sumber Dana</label>
                                    <select class="form-select" id="f_sumber_dana">
                                        <option value="">-- Pilih Sumber --</option>
                                        <option>Dana Kemahasiswaan FIK</option>
                                        <option>Iuran Peserta / Tiket</option>
                                        <option>Sponsorship Eksternal</option>
                                        <option>Gabungan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dana yang Diajukan ke Kemahasiswaan (Rp)</label>
                                    <input type="text" class="form-control" id="f_dana_ajukan" placeholder="0" oninput="formatRupiah(this)">
                                </div>
                            </div>
                        </div>

                        <!-- STEP 5 -->
                        <div class="form-step" id="step-5">
                            <div class="form-section-title"><i class="fas fa-clipboard-check"></i> Review & Pengajuan</div>
                            <div class="review-card" id="review-identitas">
                                <h6><i class="fas fa-id-card me-2"></i> Identitas Kegiatan</h6>
                            </div>
                            <div class="review-card" id="review-pelaksanaan">
                                <h6><i class="fas fa-calendar me-2"></i> Waktu & Tempat</h6>
                            </div>
                            <div class="review-card" id="review-anggaran">
                                <h6><i class="fas fa-coins me-2"></i> Anggaran</h6>
                            </div>
                            <div class="info-box mt-3">
                                <i class="fas fa-info-circle"></i>
                                Setelah submit, proposal akan diproses oleh Kemahasiswaan. Anda dapat memantau status di halaman daftar proposal.
                            </div>
                        </div>
                    </div>

                    <div class="form-navigation">
                        <div>
                            <button class="btn-nav btn-prev d-none" id="btn-prev" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Sebelumnya
                            </button>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn-nav btn-save-draft" onclick="saveDraft()">
                                <i class="fas fa-save me-2"></i>Simpan Draft
                            </button>
                            <button class="btn-nav btn-next" id="btn-next" onclick="nextStep()">
                                Selanjutnya <i class="fas fa-arrow-right"></i>
                            </button>
                            <button class="btn-nav btn-submit d-none" id="btn-submit" onclick="submitProposal()">
                                <i class="fas fa-paper-plane me-2"></i>Submit Proposal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== DETAIL MODAL ========== -->
    <div class="modal fade modal-detail" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title"><i class="fas fa-file-alt"></i> Detail Proposal</h5>
                        <small style="opacity:0.65; font-size:0.8rem;">Informasi lengkap pengajuan proposal</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detail-modal-body"></div>
                <div class="modal-footer" id="detail-modal-footer">
                    <button type="button" class="btn-nav btn-prev" data-bs-dismiss="modal" style="border:none;">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== TOAST CONTAINER ========== -->
    <div class="toast-container" id="toast-container"></div>

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

        // BASE_URL from PHP
        var BASE_URL = '<?= base_url() ?>';
        
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // ==================== GLOBAL VARIABLES ====================
        let currentStep = 1;
        const totalSteps = 5;
        let currentProposalType = 'ormawa';
        let proposals = [];
        let editingId = null;
        let budgetRowCount = 0;
        let isResubmit = false;

        // Helper functions
        function showLoading(show) {
            const loader = document.getElementById('loading-indicator');
            if (loader) {
                loader.style.display = show ? 'flex' : 'none';
            }
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `custom-toast ${type === 'success' ? 'success' : (type === 'error' ? 'error' : '')}`;
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            `;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }

        function updateCharCount(el, counterId) {
            const counter = document.getElementById(counterId);
            if (counter) counter.textContent = el.value.length;
        }

        function initTinyMCE() {
            var selector = 'textarea.tinymce-editor';
            if (document.querySelector(selector) && typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: selector,
                    height: 300,
                    menubar: false,
                    plugins: 'lists link image preview',
                    toolbar: 'undo redo | bold italic underline | bullist numlist | removeformat',
                    branding: false,
                    promotion: false,
                    setup: function (editor) {
                        editor.on('change', function () {
                            var text = editor.getContent({ format: 'text' });
                            var ccEl = document.getElementById('cc_' + editor.id.replace('f_', ''));
                            if (ccEl) ccEl.textContent = text.length + ' karakter';
                        });
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initTinyMCE();
            const latar = document.getElementById('f_latar_belakang');
            const tujuan = document.getElementById('f_tujuan');
            const sasaran = document.getElementById('f_sasaran');
            if (latar) latar.addEventListener('input', function() { updateCharCount(this, 'cc_latar'); });
            if (tujuan) tujuan.addEventListener('input', function() { updateCharCount(this, 'cc_tujuan'); });
            if (sasaran) sasaran.addEventListener('input', function() { updateCharCount(this, 'cc_sasaran'); });
        });

        // ==================== TAB SWITCH ====================
        function switchProposalType(type, btn) {
            currentProposalType = type;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            loadProposalsFromServer();
        }

        // ==================== PROPOSAL LIST RENDER ====================
        function formatDate(d) {
            if (!d) return '-';
            const date = new Date(d);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function renderProposalList() {
            const filtered = proposals.filter(p => p.type === currentProposalType);
            const emptyEl = document.getElementById('empty-state');
            const tableEl = document.getElementById('proposal-table');
            const tbody = document.getElementById('proposal-tbody');

            if (!emptyEl || !tableEl || !tbody) return;

            if (filtered.length === 0) {
                emptyEl.classList.remove('d-none');
                tableEl.classList.add('d-none');
                return;
            }

            emptyEl.classList.add('d-none');
            tableEl.classList.remove('d-none');

            tbody.innerHTML = filtered.map((p, i) => {
                const status = (p.status || 'draft').toLowerCase();
                const isDisetujui = status === 'disetujui';
                const isDraft = status === 'draft';
                const isDitolak = status === 'ditolak';

                const statusMap = {
                    'draft': { cls: 'status-draft', label: 'Draft' },
                    'submitted': { cls: 'status-review', label: 'Diajukan' },
                    'disetujui': { cls: 'status-approved', label: 'Disetujui' },
                    'ditolak': { cls: 'status-rejected', label: 'Ditolak' }
                };
                const st = statusMap[status] || { cls: 'status-draft', label: status };

                return `
                    <tr>
                        <td>${i + 1}</td>
                        <td><strong>${escapeHtml(p.nama_kegiatan || '-')}</strong><br><small class="text-muted">${escapeHtml(p.jenis || '')}</small></td>
                        <td>${escapeHtml(p.ormawa || '-')}</td>
                        <td>${formatDate(p.tanggal)}</td>
                        <td><span class="status-badge status-draft">${p.type === 'ormawa' ? 'Ormawa' : 'Kompetisi'}</span></td>
                        <td><span class="status-badge ${st.cls}">${st.label}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-1 flex-wrap">
                                <button class="btn-action btn-detail-prop" onclick="openDetailModal('${p.id}')"><i class="fas fa-eye"></i> Detail</button>
                                ${isDisetujui ? `<button class="btn-action btn-view-pdf" onclick="openPdfPreview('${p.id}')"><i class="fas fa-file-pdf"></i> PDF</button>` : '<button class="btn-action btn-pdf-disabled" disabled><i class="fas fa-file-pdf"></i> PDF</button>'}
                                ${(isDraft || isDitolak) ? `<button class="btn-action ${isDitolak ? 'btn-resubmit' : 'btn-edit-prop'}" onclick="editProposal('${p.id}', ${isDitolak})">${isDitolak ? '<i class="fas fa-redo"></i> Ulang' : '<i class="fas fa-edit"></i> Edit'}</button>` : '<button class="btn-action btn-edit-disabled" disabled><i class="fas fa-edit"></i> Edit</button>'}
                                ${(isDraft || isDitolak) ? `<button class="btn-action btn-delete-prop" onclick="deleteProposal('${p.id}')"><i class="fas fa-trash"></i> Hapus</button>` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // ==================== NAVIGATION ====================
        function goToCreate() {
            editingId = null;
            isResubmit = false;
            resetForm();
            document.getElementById('view-list').classList.add('d-none');
            document.getElementById('view-form').classList.remove('d-none');
            goToStep(1);
        }

        function backToList() {
            document.getElementById('view-form').classList.add('d-none');
            document.getElementById('view-list').classList.remove('d-none');
            loadProposalsFromServer();
        }

        function editProposal(id, resubmit = false) {
            const p = proposals.find(x => x.id == id);
            if (!p) return;

            editingId = id;
            isResubmit = resubmit;
            fillFormData(p);

            document.getElementById('view-list').classList.add('d-none');
            document.getElementById('view-form').classList.remove('d-none');
            goToStep(1);

            const btnSubmit = document.getElementById('btn-submit');
            if (btnSubmit) {
                if (isResubmit) {
                    btnSubmit.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Perbaiki & Ajukan Ulang';
                } else {
                    btnSubmit.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Proposal';
                }
            }
        }

        function deleteProposal(id) {
            if (!confirm('Yakin ingin menghapus proposal ini?')) return;
            showLoading(true);
            
            fetch(BASE_URL + 'proposal/hapus/' + id, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.status === 'success') {
                    showToast(result.message, 'success');
                    loadProposalsFromServer();
                } else {
                    showToast(result.message || 'Gagal menghapus', 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showToast('Terjadi kesalahan koneksi', 'error');
            });
        }

        // ==================== STEP NAVIGATION ====================
        function goToStep(n) {
            document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
            const stepEl = document.getElementById(`step-${n}`);
            if (stepEl) stepEl.classList.add('active');

            document.querySelectorAll('.step-item').forEach(el => {
                const s = parseInt(el.dataset.step);
                el.classList.remove('active', 'completed');
                if (s === n) el.classList.add('active');
                if (s < n) el.classList.add('completed');
            });

            const stepIndicator = document.getElementById('step-indicator');
            if (stepIndicator) stepIndicator.textContent = `Langkah ${n} dari ${totalSteps}`;
            
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const btnSubmit = document.getElementById('btn-submit');
            
            if (btnPrev) btnPrev.classList.toggle('d-none', n === 1);
            if (btnNext) btnNext.classList.toggle('d-none', n === totalSteps);
            if (btnSubmit) btnSubmit.classList.toggle('d-none', n !== totalSteps);

            if (n === totalSteps) populateReview();

            currentStep = n;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function nextStep() {
            if (!validateStep(currentStep)) return;
            if (currentStep < totalSteps) goToStep(currentStep + 1);
        }

        function prevStep() {
            if (currentStep > 1) goToStep(currentStep - 1);
        }

        function validateStep(step) {
            const requiredFields = {
                1: ['f_ormawa', 'f_tahun', 'f_nama_kegiatan', 'f_jenis'],
                2: ['f_latar_belakang', 'f_tujuan', 'f_sasaran'],
                3: ['f_tanggal', 'f_waktu_mulai', 'f_lokasi', 'f_panitia'],
                4: [], 5: []
            };
            
            const labels = {
                'f_ormawa': 'Nama Ormawa',
                'f_tahun': 'Tahun Kegiatan',
                'f_nama_kegiatan': 'Nama Kegiatan',
                'f_jenis': 'Jenis Kegiatan',
                'f_latar_belakang': 'Latar Belakang',
                'f_tujuan': 'Tujuan',
                'f_sasaran': 'Sasaran',
                'f_tanggal': 'Tanggal',
                'f_waktu_mulai': 'Waktu Mulai',
                'f_lokasi': 'Lokasi',
                'f_panitia': 'Susunan Panitia'
            };
            
            const fields = requiredFields[step] || [];
            for (const fieldId of fields) {
                var val = '';
                var el = document.getElementById(fieldId);
                if (typeof tinymce !== 'undefined' && tinymce.get(fieldId)) {
                    val = tinymce.get(fieldId).getContent({ format: 'text' }).trim();
                } else if (el) {
                    val = el.value.trim();
                }
                if (!val) {
                    showToast(`${labels[fieldId] || 'Field'} wajib diisi`, 'error');
                    if (el) el.focus();
                    return false;
                }
            }
            return true;
        }

        // ==================== REVIEW ====================
        function populateReview() {
            const getVal = (id, fallback = '-') => {
                if (typeof tinymce !== 'undefined' && tinymce.get(id)) {
                    var c = tinymce.get(id).getContent({ format: 'text' }).trim();
                    return c || fallback;
                }
                const el = document.getElementById(id);
                return el && el.value.trim() ? el.value.trim() : fallback;
            };
            
            const identitasHtml = `
                <h6><i class="fas fa-id-card me-2"></i>Identitas Kegiatan</h6>
                <div class="review-row"><span class="review-label">Nama Kegiatan</span><span class="review-value">${escapeHtml(getVal('f_nama_kegiatan'))}</span></div>
                <div class="review-row"><span class="review-label">Ormawa / Komunitas</span><span class="review-value">${escapeHtml(getVal('f_ormawa'))}</span></div>
                <div class="review-row"><span class="review-label">Jenis Kegiatan</span><span class="review-value">${escapeHtml(getVal('f_jenis'))}</span></div>
                <div class="review-row"><span class="review-label">Tahun</span><span class="review-value">${escapeHtml(getVal('f_tahun'))}</span></div>
            `;
            
            const tanggal = getVal('f_tanggal');
            const formattedDate = tanggal ? new Date(tanggal).toLocaleDateString('id-ID') : '-';
            
            const pelaksanaanHtml = `
                <h6><i class="fas fa-calendar me-2"></i>Waktu & Tempat</h6>
                <div class="review-row"><span class="review-label">Tanggal</span><span class="review-value">${formattedDate}</span></div>
                <div class="review-row"><span class="review-label">Waktu</span><span class="review-value">${getVal('f_waktu_mulai')} – ${getVal('f_waktu_selesai') || '...'}</span></div>
                <div class="review-row"><span class="review-label">Lokasi</span><span class="review-value">${escapeHtml(getVal('f_lokasi'))}</span></div>
                <div class="review-row"><span class="review-label">Estimasi Peserta</span><span class="review-value">${getVal('f_peserta')} orang</span></div>
            `;
            
            const total = document.getElementById('budget-total')?.textContent || 'Rp 0';
            const anggaranHtml = `
                <h6><i class="fas fa-coins me-2"></i>Anggaran</h6>
                <div class="review-row"><span class="review-label">Total RAB</span><span class="review-value">${total}</span></div>
                <div class="review-row"><span class="review-label">Sumber Dana</span><span class="review-value">${escapeHtml(getVal('f_sumber_dana'))}</span></div>
                <div class="review-row"><span class="review-label">Dana Diajukan</span><span class="review-value">Rp ${escapeHtml(getVal('f_dana_ajukan')) || '0'}</span></div>
            `;
            
            const reviewIdentitas = document.getElementById('review-identitas');
            const reviewPelaksanaan = document.getElementById('review-pelaksanaan');
            const reviewAnggaran = document.getElementById('review-anggaran');
            
            if (reviewIdentitas) reviewIdentitas.innerHTML = identitasHtml;
            if (reviewPelaksanaan) reviewPelaksanaan.innerHTML = pelaksanaanHtml;
            if (reviewAnggaran) reviewAnggaran.innerHTML = anggaranHtml;
        }

        // ==================== FORM HELPERS ====================
        function setTinyMCEContent(id, content) {
            if (typeof tinymce !== 'undefined' && tinymce.get(id)) {
                tinymce.get(id).setContent(content || '');
            } else {
                const el = document.getElementById(id);
                if (el) el.value = content || '';
            }
        }

        function fillFormData(p) {
            const setVal = (id, val) => {
                const el = document.getElementById(id);
                if (el && val !== undefined && val !== null) el.value = val;
            };
            setVal('f_ormawa', p.ormawa);
            setVal('f_tahun', p.tahun);
            setVal('f_tema', p.tema);
            setVal('f_jenis', p.jenis);
            setVal('f_nama_kegiatan', p.nama_kegiatan);
            setVal('f_balai', p.balai);
            setTinyMCEContent('f_latar_belakang', p.latar_belakang);
            setTinyMCEContent('f_tujuan', p.tujuan);
            setTinyMCEContent('f_sasaran', p.sasaran);
            setVal('f_tanggal', p.tanggal);
            setVal('f_waktu_mulai', p.waktu_mulai);
            setVal('f_waktu_selesai', p.waktu_selesai);
            setVal('f_lokasi', p.lokasi);
            setVal('f_peserta', p.peserta);
            setVal('f_panitia', p.panitia);
            setVal('f_rundown', p.rundown);
            setVal('f_sumber_dana', p.sumber_dana);
            setVal('f_dana_ajukan', p.dana_diajukan);
        }

        function resetForm() {
            const ids = ['f_ormawa', 'f_tahun', 'f_tema', 'f_jenis', 'f_nama_kegiatan', 'f_balai',
                         'f_latar_belakang', 'f_tujuan', 'f_sasaran', 'f_tanggal', 'f_waktu_mulai',
                         'f_waktu_selesai', 'f_lokasi', 'f_peserta', 'f_panitia', 'f_rundown',
                         'f_sumber_dana', 'f_dana_ajukan'];
            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            // Clear TinyMCE
            if (typeof tinymce !== 'undefined') {
                ['f_latar_belakang', 'f_tujuan', 'f_sasaran'].forEach(function (id) {
                    var ed = tinymce.get(id);
                    if (ed) ed.setContent('');
                });
            }
            const budgetRows = document.getElementById('budget-rows');
            if (budgetRows) budgetRows.innerHTML = '';
            budgetRowCount = 0;
            addBudgetRow();
            updateBudgetTotal();
        }

        // ==================== BUDGET TABLE ====================
        function addBudgetRow() {
            budgetRowCount++;
            const row = document.createElement('tr');
            row.id = `brow-${budgetRowCount}`;
            row.innerHTML = `
                <td>${budgetRowCount}</td>
                <td><input type="text" class="form-control-sm w-100" placeholder="Uraian item..." style="border:none; background:transparent;"></td>
                <td><input type="number" class="form-control-sm w-100 budget-vol" placeholder="1" style="border:none; background:transparent;" onchange="calcRowTotal(this)"></td>
                <td><input type="text" class="form-control-sm w-100" placeholder="Unit" style="border:none; background:transparent;"></td>
                <td><input type="text" class="form-control-sm w-100 budget-harga" placeholder="0" style="border:none; background:transparent;" oninput="calcRowTotal(this); formatRupiah(this)"></td>
                <td class="budget-total row-total" id="rtotal-${budgetRowCount}">Rp 0</td>
                <td><button type="button" class="btn-remove-row" onclick="removeBudgetRow(this)"><i class="fas fa-times"></i></button></td>
            `;
            const budgetRows = document.getElementById('budget-rows');
            if (budgetRows) budgetRows.appendChild(row);
        }

        function removeBudgetRow(btn) {
            const row = btn.closest('tr');
            if (row) row.remove();
            updateBudgetTotal();
        }

        function calcRowTotal(input) {
            const row = input.closest('tr');
            if (!row) return;
            const vol = parseFloat(row.querySelector('.budget-vol')?.value) || 0;
            const hargaRaw = row.querySelector('.budget-harga')?.value || '0';
            const harga = parseFloat(hargaRaw.replace(/\./g, '')) || 0;
            const total = vol * harga;
            const totalCell = row.querySelector('.row-total');
            if (totalCell) totalCell.textContent = 'Rp ' + formatNumber(total);
            updateBudgetTotal();
        }

        function updateBudgetTotal() {
            let grand = 0;
            document.querySelectorAll('.row-total').forEach(el => {
                const val = parseFloat(el.textContent.replace('Rp ', '').replace(/\./g, '')) || 0;
                grand += val;
            });
            const budgetTotal = document.getElementById('budget-total');
            if (budgetTotal) budgetTotal.textContent = 'Rp ' + formatNumber(grand);
        }

        function formatNumber(n) {
            return n.toLocaleString('id-ID');
        }

        function formatRupiah(input) {
            let val = input.value.replace(/\D/g, '');
            if (val) input.value = parseInt(val).toLocaleString('id-ID');
        }

        // ==================== SUBMIT & SAVE ====================
        function collectFormData() {
            const rabItems = [];
            document.querySelectorAll('#budget-rows tr').forEach((row, idx) => {
                const uraian = row.querySelector('td:nth-child(2) input')?.value;
                if (!uraian) return;
                rabItems.push({
                    urutan: idx + 1,
                    uraian: uraian,
                    volume: row.querySelector('.budget-vol')?.value || '1',
                    satuan: row.querySelector('td:nth-child(4) input')?.value || 'Unit',
                    harga_satuan: (row.querySelector('.budget-harga')?.value || '0').replace(/\./g, ''),
                    keterangan: ''
                });
            });

            return {
                proposal_id: editingId,
                tipe_proposal: currentProposalType === 'ormawa' ? 'himpunan' : 'bemdpm',
                nama_kegiatan: document.getElementById('f_nama_kegiatan')?.value || '',
                nama_ormawa: document.getElementById('f_ormawa')?.value || '',
                tahun_kegiatan: document.getElementById('f_tahun')?.value || '',
                tema_kegiatan: document.getElementById('f_tema')?.value || '',
                subtema_kegiatan: '',
                jenis_kegiatan: document.getElementById('f_jenis')?.value || '',
                balai_divisi: document.getElementById('f_balai')?.value || '',
                rekap_proposal: '',
                latar_belakang: (typeof tinymce !== 'undefined' && tinymce.get('f_latar_belakang')) ? tinymce.get('f_latar_belakang').getContent() : (document.getElementById('f_latar_belakang')?.value || ''),
                tujuan_manfaat: (typeof tinymce !== 'undefined' && tinymce.get('f_tujuan')) ? tinymce.get('f_tujuan').getContent() : (document.getElementById('f_tujuan')?.value || ''),
                nama_tema_kegiatan: document.getElementById('f_tema')?.value || '',
                bentuk_kegiatan: document.getElementById('f_jenis')?.value || '',
                peserta: document.getElementById('f_peserta')?.value || '',
                penyelenggara: document.getElementById('f_ormawa')?.value || '',
                tanggal_kegiatan: document.getElementById('f_tanggal')?.value || '',
                waktu_mulai: document.getElementById('f_waktu_mulai')?.value || '',
                waktu_selesai: document.getElementById('f_waktu_selesai')?.value || '',
                lokasi_kegiatan: document.getElementById('f_lokasi')?.value || '',
                jadwal_detail: document.getElementById('f_rundown')?.value || '',
                susunan_acara: document.getElementById('f_rundown')?.value || '',
                susunan_panitia: document.getElementById('f_panitia')?.value || '',
                penutup: '',
                sasaran_kegiatan: (typeof tinymce !== 'undefined' && tinymce.get('f_sasaran')) ? tinymce.get('f_sasaran').getContent() : (document.getElementById('f_sasaran')?.value || ''),
                sumber_dana: document.getElementById('f_sumber_dana')?.value || '',
                dana_diajukan: (document.getElementById('f_dana_ajukan')?.value || '0').replace(/\./g, ''),
                rab_items: rabItems
            };
        }

        function saveDraft() {
            const data = collectFormData();
            if (!data.nama_kegiatan) {
                showToast('Nama kegiatan wajib diisi sebelum menyimpan draft', 'error');
                return;
            }
            
            showLoading(true);
            
            fetch(BASE_URL + 'proposal/simpan_draft', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.status === 'success') {
                    editingId = result.proposal_id;
                    showToast(result.message, 'success');
                    loadProposalsFromServer();
                } else {
                    showToast(result.message || 'Gagal menyimpan draft', 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showToast('Terjadi kesalahan koneksi', 'error');
            });
        }

        function submitProposal() {
            if (!validateStep(4)) return;
            
            const data = collectFormData();
            if (!data.nama_kegiatan) {
                showToast('Data tidak lengkap', 'error');
                return;
            }
            
            showLoading(true);
            
            fetch(BASE_URL + 'proposal/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.status === 'success') {
                    showToast(result.message, 'success');
                    setTimeout(() => {
                        backToList();
                        loadProposalsFromServer();
                    }, 1500);
                } else {
                    showToast(result.message || 'Gagal submit proposal', 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showToast('Terjadi kesalahan koneksi', 'error');
            });
        }

        // ==================== LOAD DATA ====================
        function loadProposalsFromServer() {
            showLoading(true);
            
            fetch(BASE_URL + 'proposal/get_data_json?tipe=' + currentProposalType, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(result => {
                showLoading(false);
                if (result.status === 'success') {
                    proposals = (result.data || []).map(p => ({
                        id: p.id,
                        nama_kegiatan: p.nama_kegiatan,
                        ormawa: p.nama_ormawa,
                        tahun: p.tahun_kegiatan,
                        tema: p.tema_kegiatan,
                        tanggal: p.tanggal_kegiatan,
                        waktu_mulai: p.waktu_mulai,
                        waktu_selesai: p.waktu_selesai,
                        lokasi: p.lokasi_kegiatan,
                        jenis: p.jenis_kegiatan,
                        peserta: p.peserta,
                        latar_belakang: p.latar_belakang,
                        tujuan: p.tujuan_manfaat,
                        sasaran: p.sasaran_kegiatan,
                        total_rab: p.total_rab,
                        sumber_dana: p.sumber_dana,
                        dana_diajukan: p.dana_diajukan,
                        balai: p.balai_divisi,
                        panitia: p.susunan_panitia,
                        rundown: p.susunan_acara,
                        catatan_admin: p.catatan_admin,
                        status: p.status || 'draft',
                        type: p.tipe_proposal === 'himpunan' ? 'ormawa' : 'kompetisi'
                    }));
                    renderProposalList();
                } else {
                    showToast(result.message || 'Gagal memuat data', 'error');
                }
            })
            .catch(error => {
                showLoading(false);
                showToast('Terjadi kesalahan koneksi', 'error');
            });
        }

        // ==================== PDF FUNCTIONS ====================
        function openPdfPreview(id) {
            window.open(BASE_URL + 'proposal/pdf/' + id, '_blank');
        }

        // ==================== DETAIL MODAL ====================
        function openDetailModal(id) {
            const p = proposals.find(x => x.id == id);
            if (!p) return;

            const status = (p.status || 'draft').toLowerCase();
            const statusMap = {
                'draft': { cls: 'status-draft', label: 'Draft' },
                'submitted': { cls: 'status-review', label: 'Diajukan' },
                'disetujui': { cls: 'status-approved', label: 'Disetujui' },
                'ditolak': { cls: 'status-rejected', label: 'Ditolak' }
            };
            const st = statusMap[status] || { cls: 'status-draft', label: status };

            const catatanBlock = (status === 'ditolak' && p.catatan_admin)
                ? `<div class="detail-catatan-rejection"><i class="fas fa-exclamation-circle me-2"></i><strong>Catatan Admin:</strong> ${escapeHtml(p.catatan_admin)}</div>`
                : '';

            const pdfInfo = status === 'disetujui'
                ? `<div class="detail-pdf-available"><i class="fas fa-check-circle me-2"></i>PDF proposal tersedia.</div>`
                : `<div class="detail-pdf-pending"><i class="fas fa-clock me-2"></i>PDF akan tersedia setelah proposal disetujui.</div>`;

            const modalBody = document.getElementById('detail-modal-body');
            if (modalBody) {
                modalBody.innerHTML = `
                    <div class="detail-header-info">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="detail-kegiatan-name">${escapeHtml(p.nama_kegiatan || '-')}</h5>
                                <div class="text-muted" style="font-size:0.85rem;">${escapeHtml(p.ormawa || '-')} &bull; ${escapeHtml(p.jenis || '-')}</div>
                            </div>
                            <span class="status-badge ${st.cls}">${st.label}</span>
                        </div>
                    </div>
                    ${catatanBlock}
                    ${pdfInfo}
                    <div class="detail-section">
                        <div class="detail-section-title"><i class="fas fa-calendar-alt"></i> Waktu & Tempat</div>
                        <div class="detail-grid">
                            <div class="detail-item"><span class="detail-label">Tanggal</span><span class="detail-value">${formatDate(p.tanggal)}</span></div>
                            <div class="detail-item"><span class="detail-label">Waktu</span><span class="detail-value">${p.waktu_mulai || '-'} – ${p.waktu_selesai || '-'}</span></div>
                            <div class="detail-item"><span class="detail-label">Lokasi</span><span class="detail-value">${escapeHtml(p.lokasi || '-')}</span></div>
                            <div class="detail-item"><span class="detail-label">Estimasi Peserta</span><span class="detail-value">${p.peserta ? p.peserta + ' orang' : '-'}</span></div>
                        </div>
                    </div>
                    <div class="detail-section">
                        <div class="detail-section-title"><i class="fas fa-scroll"></i> Pendahuluan</div>
                        <div class="detail-label mb-1">Latar Belakang</div>
                        <div class="detail-text-block">${escapeHtml(p.latar_belakang || '-').replace(/\n/g, '<br>')}</div>
                        <div class="detail-label mt-3 mb-1">Tujuan & Manfaat</div>
                        <div class="detail-text-block">${escapeHtml(p.tujuan || '-').replace(/\n/g, '<br>')}</div>
                    </div>
                    <div class="detail-section">
                        <div class="detail-section-title"><i class="fas fa-coins"></i> Anggaran</div>
                        <div class="detail-grid">
                            <div class="detail-item"><span class="detail-label">Total RAB</span><span class="detail-value">${p.total_rab ? 'Rp ' + Number(p.total_rab).toLocaleString('id-ID') : '-'}</span></div>
                            <div class="detail-item"><span class="detail-label">Sumber Dana</span><span class="detail-value">${escapeHtml(p.sumber_dana || '-')}</span></div>
                            <div class="detail-item"><span class="detail-label">Dana Diajukan</span><span class="detail-value">${p.dana_diajukan ? 'Rp ' + Number(p.dana_diajukan).toLocaleString('id-ID') : '-'}</span></div>
                        </div>
                    </div>
                `;
            }

            const footerEl = document.getElementById('detail-modal-footer');
            if (footerEl) {
                footerEl.innerHTML = '<button type="button" class="btn-nav btn-prev" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Tutup</button>';
                if (status === 'disetujui') {
                    const btnPDF = document.createElement('button');
                    btnPDF.className = 'btn-nav btn-next';
                    btnPDF.innerHTML = '<i class="fas fa-file-pdf me-2"></i>Buka PDF';
                    btnPDF.style.cssText = 'background:linear-gradient(135deg, #e74c3c, #c0392b); border:none;';
                    btnPDF.onclick = () => openPdfPreview(id);
                    footerEl.appendChild(btnPDF);
                }
                if (status === 'ditolak') {
                    const btnResubmit = document.createElement('button');
                    btnResubmit.className = 'btn-nav btn-next';
                    btnResubmit.innerHTML = '<i class="fas fa-redo me-2"></i>Perbaiki & Ajukan Ulang';
                    btnResubmit.style.cssText = 'background:linear-gradient(135deg, #e74c3c, #c0392b); border:none;';
                    btnResubmit.onclick = () => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
                        if (modal) modal.hide();
                        setTimeout(() => editProposal(id, true), 300);
                    };
                    footerEl.appendChild(btnResubmit);
                }
            }

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }

        // ==================== INIT ====================
        document.addEventListener('DOMContentLoaded', function() {
            addBudgetRow();
            loadProposalsFromServer();
        });
    </script>
</body>
</html>