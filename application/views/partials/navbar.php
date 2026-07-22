<?php
$active_menu = $active_menu ?? 'dashboard';

$user_nama = '';
$user_foto = '';
$is_logged_in = false;

if (isset($user_data) && is_array($user_data) && isset($user_data['logged_in']) && $user_data['logged_in']) {
    $is_logged_in = true;
    $user_nama = $user_data['nama'] ?? '';
    $user_foto = $user_data['foto'] ?? '';
} elseif (isset($user) && isset($user->nama)) {
    $is_logged_in = true;
    $user_nama = $user->nama;
    $user_foto = $user->foto ?? '';
}

$nav_logo_file = 'nav-logo1.jpeg';
$hero_json_path = FCPATH . 'assets/hero_setting.json';
if (file_exists($hero_json_path)) {
    $hero_json_data = json_decode(file_get_contents($hero_json_path), true);
    if (!empty($hero_json_data['nav_logo']) && file_exists(FCPATH . 'assets/' . $hero_json_data['nav_logo'])) {
        $nav_logo_file = $hero_json_data['nav_logo'];
    }
}
$nav_logo_version = file_exists(FCPATH . 'assets/' . $nav_logo_file) ? filemtime(FCPATH . 'assets/' . $nav_logo_file) : time();

// Fetch notifications for bell (Sertifikat & Forum Alumni)
$navbar_notifications = [];
if ($is_logged_in) {
    $CI =& get_instance();
    $CI->load->database();
    $current_user_id = $CI->session->userdata('user_id');
    if ($current_user_id) {
        // 1. Get Sertifikat Notifications
        $sertifikat_notifs = $CI->db->where('mahasiswa_id', $current_user_id)
            ->where_in('status', ['approved', 'rejected'])
            ->get('pengajuan_sertifikat')
            ->result_array();
        
        foreach ($sertifikat_notifs as &$n) {
            $n['notif_type'] = 'sertifikat';
            $n['judul'] = $n['judul_kegiatan'];
        }

        // 2. Get Proposal Notifications (submitted, disetujui, ditolak)
        $CI->db->select('p.id, p.nama_kegiatan AS judul, p.status, p.updated_at, p.created_at');
        $CI->db->from('proposal p');
        $CI->db->where('p.dibuat_oleh', $current_user_id);
        $CI->db->where_in('p.status', ['submitted', 'disetujui', 'ditolak']);
        $CI->db->where('p.deleted_at IS NULL', NULL, FALSE);
        $proposal_notifs = $CI->db->get()->result_array();

        foreach ($proposal_notifs as &$n) {
            $n['notif_type'] = 'proposal';
        }
        unset($n);

        // 3. Get Forum Alumni Notifications (including pending)
        $forum_notifs = $CI->db->where('user_id', $current_user_id)
            ->where_in('status', ['pending', 'approved', 'rejected'])
            ->get('forum_alumni_posts')
            ->result_array();

        $CI->load->helper('text');
        foreach ($forum_notifs as &$n) {
            $n['notif_type'] = 'forum';
            $n['judul'] = character_limiter(strip_tags($n['content']), 30);
        }

        // 4. Get TAK Notifications
        $tak_notifs = [];
        $current_user_nim = $CI->session->userdata('nim');
        if ($current_user_nim) {
            $tak_notifs = $CI->db->where('nim', $current_user_nim)
                ->where_in('status', ['pending', 'diproses', 'disetujui', 'ditolak'])
                ->get('pengajuan_tak')
                ->result_array();
            
            foreach ($tak_notifs as &$n) {
                $n['notif_type'] = 'tak';
                $n['judul'] = $n['judul_kegiatan'];
            }
            unset($n);
        }


        // Merge all arrays
        $merged_notifs = array_merge($sertifikat_notifs, $proposal_notifs, $forum_notifs);

        // Sort by updated_at / created_at DESC
        usort($merged_notifs, function($a, $b) {
            $t1_str = !empty($a['updated_at']) ? $a['updated_at'] : (!empty($a['created_at']) ? $a['created_at'] : '');
            $t2_str = !empty($b['updated_at']) ? $b['updated_at'] : (!empty($b['created_at']) ? $b['created_at'] : '');
            $t1 = strtotime($t1_str);
            $t2 = strtotime($t2_str);
            return $t2 - $t1;
        });

        // Limit to 5
        $navbar_notifications = array_slice($merged_notifs, 0, 5);
    }
}
?>
<style>
/* ========== BELL NOTIFICATION STYLES ========== */
.nav-item-bell {
  position: relative;
  display: inline-block;
  margin-right: 12px;
}
.btn-bell {
  background: rgba(255, 255, 255, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: white;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  cursor: pointer;
  position: relative;
  transition: all 0.3s ease;
}
.btn-bell:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: scale(1.05);
}
.bell-badge {
  position: absolute;
  top: -2px;
  right: -2px;
  background: #ef4444;
  color: white;
  font-size: 0.65rem;
  font-weight: 700;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid rgba(0, 0, 0, 0.55);
}
.bell-dropdown-menu {
  position: absolute;
  top: calc(100% + 16px);
  right: 0;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(20px);
  border-radius: 20px;
  width: 320px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.3);
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 1000;
}
.nav-item-bell.open .bell-dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}
.bell-dropdown-header {
  padding: 14px 18px;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-weight: 700;
  color: #1e293b;
  font-size: 0.9rem;
}
.bell-dropdown-body {
  max-height: 350px;
  overflow-y: auto;
}
.bell-notif-item {
  padding: 12px 18px;
  display: flex;
  gap: 12px;
  border-bottom: 1px solid #f1f5f9;
  transition: all 0.2s ease;
  cursor: pointer;
  text-decoration: none !important;
  color: #334155 !important;
}
.bell-notif-item:hover {
  background: #f8fafc;
}
.bell-notif-item.unread {
  background: #eff6ff;
}
.bell-notif-item.unread:hover {
  background: #e0f2fe;
}
.bell-notif-icon {
  font-size: 1.2rem;
  padding-top: 2px;
}
.bell-notif-content {
  flex: 1;
}
.bell-notif-text {
  font-size: 0.8rem;
  line-height: 1.4;
  text-align: left;
}
.bell-notif-time {
  font-size: 0.7rem;
  color: #94a3b8;
  margin-top: 4px;
  text-align: left;
}
.bell-notif-empty {
  padding: 30px;
  text-align: center;
  color: #94a3b8;
}
.bell-notif-empty i {
  font-size: 2.2rem;
  margin-bottom: 10px;
}
.bell-notif-empty p {
  font-size: 0.8rem;
  margin: 0;
}
@media (max-width: 768px) {
  .nav-item-bell {
    margin-left: auto !important;
    margin-right: 6px !important;
  }
  .bell-dropdown-menu {
    position: fixed;
    top: 70px;
    left: 12px;
    right: 12px;
    width: auto;
    max-width: none;
    z-index: 100000;
  }
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
.logo-area { display: flex; align-items: center; gap: 16px; flex-shrink: 0; }
.logo-icon {
  width: 48px; height: 48px;
  background: white;
  border-radius: 14px;
  display: flex;
  align-items: center; justify-content: center;
  padding: 2px;
  overflow: hidden;
}
.logo-text h5 { font-size: 0.9rem; font-weight: 800; color: white; margin: 0; line-height: 1.2; }
.logo-text span { font-size: 0.7rem; color: rgba(255,255,255,0.85); }
.nav-links { display: flex; gap: 1.5rem; align-items: center; position: relative; flex: 1; justify-content: center; }
.nav-links a {
  color: white !important;
  text-decoration: none !important;
  font-weight: 600;
  font-size: 0.9rem;
  border-bottom: 2px solid transparent;
  padding: 6px 0 4px;
  transition: all 0.3s ease;
}
.nav-links a.active, .nav-links a:hover {
  border-bottom-color: #f97316 !important;
  color: white !important;
}
.nav-item-dropdown { position: relative; }
.nav-item-dropdown > a {
  display: flex;
  align-items: center;
  gap: 8px;
  color: white !important;
  text-decoration: none !important;
  font-weight: 600;
  font-size: 0.9rem;
  border-bottom: 2px solid transparent;
  padding: 6px 0 4px;
  transition: all 0.3s ease;
  cursor: pointer;
}
.navbar-glass > .btn-mytelu-custom {
  margin-left: auto;
}
.nav-item-dropdown > a i { font-size: 0.7rem; transition: transform 0.3s ease; }
.nav-item-dropdown.open .dropdown-menu-custom {
  opacity: 1 !important;
  visibility: visible !important;
  transform: translateX(-50%) translateY(0) !important;
}
.nav-item-dropdown.open > a i { transform: rotate(180deg); }
.nav-item-dropdown > a.active,
.nav-item-dropdown > a:hover { border-bottom-color: #f97316 !important; }
.dropdown-menu-custom {
  position: absolute;
  top: calc(100% + 32px);
  left: 50%;
  transform: translateX(-50%) translateY(-12px);
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(30px);
  border-radius: 24px;
  padding: 16px 20px;
  width: max-content;
  max-width: 90vw;
  box-shadow: 0 30px 60px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.3);
  opacity: 0;
  visibility: hidden;
  transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 100;
}
.dropdown-grid { display: flex; flex-wrap: nowrap; gap: 12px; }
.dropdown-item {
  width: 200px;
  flex: 0 0 200px;
  padding: 24px 16px;
  text-align: center;
  border-radius: 16px;
  transition: all 0.3s ease;
  text-decoration: none;
  color: #1f2937 !important;
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
.dropdown-item::after { display: none !important; }
.d-icon-wrapper {
  width: 56px; height: 56px;
  margin: 0 auto 12px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
}
.d-icon-wrapper i { font-size: 1.6rem; }
.dropdown-item:nth-child(1) .d-icon-wrapper { background: #fef3c7; }
.dropdown-item:nth-child(1) .d-icon-wrapper i { color: #D98A3C; }
.dropdown-item:nth-child(2) .d-icon-wrapper { background: #dbeafe; }
.dropdown-item:nth-child(2) .d-icon-wrapper i { color: #2563EB; }
.dropdown-item:nth-child(3) .d-icon-wrapper { background: #e0f2fe; }
.dropdown-item:nth-child(3) .d-icon-wrapper i { color: #3B82F6; }
.dropdown-item:nth-child(4) .d-icon-wrapper { background: #fee2e2; }
.dropdown-item:nth-child(4) .d-icon-wrapper i { color: #DC2626; }
.dropdown-item:nth-child(5) .d-icon-wrapper { background: #d1fae5; }
.dropdown-item:nth-child(5) .d-icon-wrapper i { color: #10B981; }
.d-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 6px; color: #1f2937; white-space: normal; }
.d-desc { font-size: 0.75rem; color: #6b7280; line-height: 1.5; font-weight: 400; max-width: 140px; margin: 0 auto; white-space: normal; }
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
  gap: 10px;
}
.btn-mytelu-custom:hover {
  background: #ea580c;
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
}
.user-avatar-small { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }
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
.sidebar-close { display: none; }
.sidebar-account { display: none; }
@media (max-width: 1024px) {
  .dropdown-menu-custom { min-width: unset; width: 90vw; max-width: 600px; left: 50%; transform: translateX(-50%) translateY(-12px); padding: 12px; }
  .nav-item-dropdown.open .dropdown-menu-custom { transform: translateX(-50%) translateY(0) !important; }
  .dropdown-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; }
  .dropdown-item { width: calc(33.333% - 6px); flex: 1 1 calc(33.333% - 6px); min-width: 120px; padding: 16px 12px; min-height: 130px; }
  .d-icon-wrapper { width: 44px; height: 44px; margin-bottom: 8px; }
  .d-icon-wrapper i { font-size: 1.2rem; }
  .d-title { font-size: 0.8rem; white-space: normal; }
  .d-desc { font-size: 0.65rem; max-width: 100px; }
}
@media (max-width: 768px) {
  .header-glass {
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  .header-glass .container-custom {
    width: 100% !important;
    max-width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
  }
  .navbar-glass {
    border-radius: 0 !important;
    border-left: none !important;
    border-right: none !important;
    border-top: none !important;
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 10px 16px !important;
    box-sizing: border-box !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    align-items: center !important;
    justify-content: space-between !important;
  }
  .nav-links {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    margin: 0 !important;
    width: 85% !important;
    max-width: 320px !important;
    height: 100vh !important;
    flex: none;
    justify-content: flex-start;
    flex-direction: column;
    align-items: stretch;
    background: #1e293b;
    border-right: 1px solid rgba(255,255,255,0.08);
    padding: 20px 16px;
    padding-bottom: 40px;
    gap: 4px;
    z-index: 99999;
    display: flex !important;
    transform: translateX(-100%);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    overflow-y: auto;
    overscroll-behavior: contain;
  }
  .nav-links.open { transform: translateX(0) !important; }
  .nav-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.75);
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: all 0.35s ease;
  }
  .nav-overlay.open {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
  }
  .mobile-toggle { display: block; margin-left: 0 !important; margin-right: 0 !important; padding: 6px 10px; }
  .desktop-account { display: none; }
  .sidebar-close {
    display: flex;
    align-self: flex-end;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 1.2rem;
    color: white;
    cursor: pointer;
    margin-bottom: 8px;
  }
  .sidebar-close:hover { background: rgba(249, 115, 22, 0.3); }
  .sidebar-account {
    display: flex;
    padding: 14px 16px;
    border-radius: 12px;
    color: white !important;
    text-decoration: none;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    margin-top: 12px;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.06);
  }
  .sidebar-account:hover { background: rgba(249, 115, 22, 0.3); border-color: #f97316; }
  .nav-links > a,
  .nav-item-dropdown > a {
    padding: 14px 16px;
    border-radius: 12px;
    border-bottom: none;
    font-size: 0.95rem;
    color: rgba(255,255,255,0.85) !important;
    text-decoration: none;
  }
  .nav-links > a:hover,
  .nav-item-dropdown > a:hover { background: rgba(255,255,255,0.08); }
  .nav-links > a.active,
  .nav-item-dropdown > a.active {
    background: rgba(249, 115, 22, 0.2);
    color: #f97316 !important;
  }
  .nav-item-dropdown { width: 100%; }
  .nav-item-dropdown > a { justify-content: space-between; }
  .nav-item-dropdown .dropdown-menu-custom,
  .nav-item-dropdown.open .dropdown-menu-custom {
    position: static;
    opacity: 1 !important;
    visibility: visible !important;
    transform: none !important;
    display: none;
    background: rgba(255,255,255,0.05);
    backdrop-filter: none;
    padding: 8px;
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    margin: 4px 8px 8px;
    min-width: auto;
    box-shadow: none;
    width: auto;
    max-width: 100%;
  }
  .nav-item-dropdown.open .dropdown-menu-custom { display: block; }
  .dropdown-grid { grid-template-columns: 1fr; gap: 4px; }
  .dropdown-item {
    padding: 10px 12px;
    min-height: unset;
    border-radius: 10px;
    background: rgba(255,255,255,0.03);
    color: rgba(255,255,255,0.85) !important;
    flex-direction: row;
    justify-content: flex-start;
    gap: 10px;
  }
  .dropdown-item:hover { background: rgba(249, 115, 22, 0.15); }
  .d-icon-wrapper { width: 28px; height: 28px; margin: 0; border-radius: 8px; }
  .d-icon-wrapper i { font-size: 0.75rem; }
  .d-title { font-size: 0.75rem; color: white !important; margin: 0; }
  .d-desc { display: none; }
}
.nav-item-account {
  position: relative;
}
.account-dropdown-menu {
  position: absolute;
  top: calc(100% + 12px);
  right: 0;
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(20px);
  border-radius: 16px;
  min-width: 180px;
  padding: 8px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  border: 1px solid rgba(255, 255, 255, 0.3);
  opacity: 0;
  visibility: hidden;
  transform: translateY(-10px);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: 1000;
}
.nav-item-account:hover .account-dropdown-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}
.account-dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  border-radius: 10px;
  color: #334155 !important;
  text-decoration: none !important;
  font-size: 0.85rem;
  font-weight: 600;
  transition: background 0.2s ease, color 0.2s ease;
}
.account-dropdown-item:hover {
  background: #fff7ed;
  color: #f97316 !important;
}
.account-dropdown-item i {
  width: 16px;
  text-align: center;
}

/* ========== GLOBAL SINGLE SCROLLBAR & OVERFLOW PROTECTION ========== */
html {
  overflow-x: hidden !important;
  max-width: 100% !important;
  width: 100% !important;
  margin: 0 !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

body, main {
  max-width: 100% !important;
  width: 100% !important;
  margin: 0 !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
}

section, .org-bg-orange, .alumni-quote-section, .partner-section, .recognition-section, footer, .footer {
  width: 100% !important;
  max-width: 100% !important;
  margin-left: 0 !important;
  margin-right: 0 !important;
  padding-left: 0 !important;
  padding-right: 0 !important;
  box-sizing: border-box !important;
}

@media (max-width: 768px) {
  html {
    overflow-x: hidden !important;
    max-width: 100% !important;
    width: 100% !important;
  }
  body, main {
    max-width: 100% !important;
    width: 100% !important;
    margin: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  section, .hero-wrap, .org-bg-orange, .alumni-quote-section, .partner-section, .recognition-section, footer, .footer {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    left: 0 !important;
    right: 0 !important;
    transform: none !important;
    box-sizing: border-box !important;
  }

  .header-glass {
    max-width: 100% !important;
  }

  .container, .container-fluid, .container-custom {
    max-width: 100% !important;
    width: 100% !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    box-sizing: border-box !important;
  }

  .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  footer, .footer {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-top: 40px !important;
    box-sizing: border-box !important;
    overflow: visible !important;
  }

  footer .container, .footer .container,
  footer .container-custom, .footer .container-custom {
    padding-left: 20px !important;
    padding-right: 20px !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

  footer .row, .footer .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  .footer-bottom {
    padding-top: 20px !important;
    margin-top: 20px !important;
    text-align: center !important;
    border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
  }

  .footer-bottom p {
    font-size: 0.78rem !important;
    line-height: 1.6 !important;
    text-align: center !important;
    white-space: normal !important;
    word-break: break-word !important;
    color: rgba(255, 255, 255, 0.85) !important;
  }

  /* Form & Element Overflow Fix */
  .search-box {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
  }

  .search-box input {
    padding-right: 90px !important;
    font-size: 0.82rem !important;
  }

  .search-box button {
    padding: 8px 16px !important;
    font-size: 0.8rem !important;
  }

  .card, .berita-card, .featured-card, .sidebar-card, .wizard-card, .tak-card {
    max-width: 100% !important;
    box-sizing: border-box !important;
  }
}
</style>
<header class="header-glass">
    <div class="container-custom">
        <div class="navbar-glass" id="navbar">
            <div class="logo-area">
                    <div class="logo-icon"><img src="<?= base_url('assets/' . $nav_logo_file) . '?v=' . $nav_logo_version ?>" alt="Logo" style="width:100%;height:100%;object-fit:cover;transform:scale(1.35);border-radius:10px;"></div>                <div class="logo-text">
                    <h5>Fakultas Industri Kreatif</h5>
                    <span>Kemahasiswaan FIK</span>
                </div>
            </div>

            <div class="nav-links" id="navLinks">
                <button class="sidebar-close" id="sidebarClose"><i class="fas fa-times"></i></button>
                <a href="<?= base_url() ?>" class="<?= $active_menu == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= base_url('berita') ?>" class="<?= $active_menu == 'informasi' ? 'active' : '' ?>">Informasi</a>

                <div class="nav-item-dropdown" id="layananDropdown">
                    <a href="#" id="layananToggle" class="<?= $active_menu == 'layanan' ? 'active' : '' ?>">
                        Layanan <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu-custom">
                        <div class="dropdown-grid">
                            <!-- a) Pengajuan Proposal -->
                            <a href="<?= base_url('proposal') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-clipboard-list"></i></div>
                                <div class="d-title">Pengajuan Proposal</div>
                                <div class="d-desc">Ajukan proposal kegiatan, PKM, & penelitian</div>
                            </a>
                            <!-- b) Pengajuan Sertifikat -->
                            <a href="<?= base_url('sertifikat') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-certificate"></i></div>
                                <div class="d-title">Pengajuan Sertifikat</div>
                                <div class="d-desc">Cetak sertifikat prestasi mahasiswa & kegiatan</div>
                            </a>
                            <!-- c) Pengajuan TAK Kolektif -->
                            <a href="<?= base_url('tak') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-file-alt"></i></div>
                                <div class="d-title">Pengajuan TAK Kolektif</div>
                                <div class="d-desc">Ajukan pengakuan kegiatan & kompetensi mahasiswa</div>
                            </a>
                            <!-- d) Pengajuan Beasiswa (Dihide/Comment Out Sementara)
                            <a href="<?= base_url('beasiswa') ?>" class="dropdown-item">
                                <div class="d-icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
                                <div class="d-title">Pengajuan Beasiswa</div>
                                <div class="d-desc">Ajukan beasiswa prestasi & bantuan pendidikan</div>
                            </a>
                            -->
                        </div>
                    </div>
                </div>

                <a href="<?= base_url('forum_alumni') ?>" class="<?= $active_menu == 'forum_alumni' ? 'active' : '' ?>">Ikatan Alumni</a>
                <a href="<?= base_url('tentangkami') ?>" class="<?= $active_menu == 'tentangkami' ? 'active' : '' ?>">Tentang Kami</a>

                <?php if ($is_logged_in): ?>
                    <a href="<?= base_url('profile') ?>" class="btn-mytelu-custom sidebar-account">
                        <?php if (!empty($user_foto)): ?>
                            <img src="<?= base_url('uploads/users/' . $user_foto) ?>" class="user-avatar-small">
                        <?php else: ?>
                            <i class="fas fa-user-circle"></i>
                        <?php endif; ?>
                        <?= htmlspecialchars($user_nama) ?>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn-mytelu-custom sidebar-account">
                        <i class="fas fa-sign-in-alt"></i> Log in
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($is_logged_in): ?>
                <!-- Bell Notification -->
                <div class="nav-item-bell" id="bellDropdownWrapper">
                    <button class="btn-bell" id="bellBtn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="bell-badge" id="bellBadge" style="display: none;">0</span>
                    </button>
                    <div class="bell-dropdown-menu" id="bellDropdown">
                        <div class="bell-dropdown-header">
                            <span>Notifikasi Terbaru</span>
                            <a href="#" id="markAllReadBtn" style="font-size: 0.75rem; color: #f97316; text-decoration: none; font-weight: 600;">Tandai semua dibaca</a>
                        </div>
                        <div class="bell-dropdown-body" id="bellDropdownBody">
                            <?php if (!empty($navbar_notifications)): ?>
                                <?php foreach ($navbar_notifications as $notif): ?>
                                    <?php 
                                        if ($notif['notif_type'] === 'forum') {
                                            $notif_url = base_url('forum_alumni');
                                        } elseif ($notif['notif_type'] === 'proposal') {
                                            $notif_url = base_url('proposal');
                                        } else {
                                            $notif_url = base_url('sertifikat');
                                        }
                                        $notif_time_id = isset($notif['updated_at']) ? strtotime($notif['updated_at']) : time();
                                    ?>
                                    <a href="<?= $notif_url ?>" class="bell-notif-item" data-id="<?= $notif['id'] ?>_<?= $notif_time_id ?>">
                                        <div class="bell-notif-icon">
                                            <?php if (in_array($notif['status'], ['approved', 'disetujui'])): ?>
                                                <i class="fas fa-check-circle text-success"></i>
                                            <?php elseif (in_array($notif['status'], ['pending', 'submitted'])): ?>
                                                <i class="fas fa-hourglass-half text-warning"></i>
                                            <?php else: ?>
                                                <i class="fas fa-times-circle text-danger"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="bell-notif-content">
                                            <div class="bell-notif-text">
                                                <?php if ($notif['notif_type'] === 'forum'): ?>
                                                    <?php if ($notif['status'] === 'pending'): ?>
                                                        Postingan forum Anda <strong>"<?= htmlspecialchars($notif['judul']) ?>"</strong> sedang ditinjau oleh admin.
                                                    <?php else: ?>
                                                        Postingan forum Anda <strong>"<?= htmlspecialchars($notif['judul']) ?>"</strong> <?= $notif['status'] === 'approved' ? 'telah disetujui oleh admin' : 'telah ditolak' ?>.
                                                    <?php endif; ?>
                                                <?php elseif ($notif['notif_type'] === 'proposal'): ?>
                                                    <?php if ($notif['status'] === 'submitted'): ?>
                                                        Proposal <strong><?= htmlspecialchars($notif['judul']) ?></strong> sedang ditinjau oleh admin.
                                                    <?php elseif ($notif['status'] === 'disetujui'): ?>
                                                        Proposal <strong><?= htmlspecialchars($notif['judul']) ?></strong> telah disetujui oleh admin.
                                                    <?php else: ?>
                                                        Proposal <strong><?= htmlspecialchars($notif['judul']) ?></strong> ditolak, silakan perbaiki dan ajukan ulang.
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if ($notif['status'] === 'submitted'): ?>
                                                        Pengajuan sertifikat <strong><?= htmlspecialchars($notif['judul']) ?></strong> sedang ditinjau oleh admin.
                                                    <?php elseif ($notif['status'] === 'approved'): ?>
                                                        Pengajuan sertifikat <strong><?= htmlspecialchars($notif['judul']) ?></strong> telah disetujui oleh admin.
                                                    <?php else: ?>
                                                        Pengajuan sertifikat <strong><?= htmlspecialchars($notif['judul']) ?></strong> telah ditolak oleh admin.
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="bell-notif-time">
                                                <?php 
                                                    $notif_time = !empty($notif['updated_at']) ? $notif['updated_at'] : (!empty($notif['created_at']) ? $notif['created_at'] : '');
                                                ?>
                                                <i class="far fa-clock me-1"></i> <?= !empty($notif_time) ? date('d M Y H:i', strtotime($notif_time)) : '-' ?>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bell-notif-empty">
                                    <i class="fas fa-bell-slash"></i>
                                    <p>Tidak ada notifikasi baru</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <div class="nav-item-account desktop-account">
                <a href="<?= base_url('profile') ?>" class="btn-mytelu-custom">
                    <?php if (!empty($user_foto)): ?>
                        <img src="<?= base_url('uploads/users/' . $user_foto) ?>" class="user-avatar-small">
                    <?php else: ?>
                        <i class="fas fa-user-circle"></i>
                    <?php endif; ?>
                    <?= htmlspecialchars($user_nama) ?>
                </a>
                <div class="account-dropdown-menu">
                    <a href="<?= base_url('profile') ?>" class="account-dropdown-item">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </a>
                    <a href="<?= base_url('logout') ?>" class="account-dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
            <?php else: ?>
                <a href="<?= base_url('login') ?>" class="btn-mytelu-custom desktop-account">
                    <i class="fas fa-sign-in-alt"></i> Log in
                </a>
            <?php endif; ?>

            <button class="mobile-toggle" id="mobileNavBtn"><i class="fas fa-bars"></i></button>
            <div class="nav-overlay" id="navOverlay"></div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.getElementById('layananToggle');
    var dropdownWrapper = document.getElementById('layananDropdown');
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

    var mobileBtn = document.getElementById('mobileNavBtn');
    var navLinksDiv = document.getElementById('navLinks');
    var overlay = document.getElementById('navOverlay');

    var sidebarClose = document.getElementById('sidebarClose');

    function openSidebar() {
        navLinksDiv.classList.add('open');
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        navLinksDiv.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (mobileBtn && navLinksDiv) {
        mobileBtn.addEventListener('click', function() {
            if (!navLinksDiv.classList.contains('open')) {
                openSidebar();
            }
        });
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Bell Notification Javascript
    const bellBtn = document.getElementById('bellBtn');
    const bellDropdownWrapper = document.getElementById('bellDropdownWrapper');
    const bellBadge = document.getElementById('bellBadge');
    const markAllReadBtn = document.getElementById('markAllReadBtn');
    
    if (bellBtn && bellDropdownWrapper) {
        function updateBellBadge() {
            let readNotifs = JSON.parse(localStorage.getItem('read_bell_notifs') || '[]');
            let notifItems = document.querySelectorAll('.bell-notif-item');
            let unreadCount = 0;
            
            notifItems.forEach(item => {
                const id = item.getAttribute('data-id');
                if (!readNotifs.includes(id)) {
                    item.style.display = 'flex';
                    unreadCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (unreadCount > 0) {
                bellBadge.textContent = unreadCount;
                bellBadge.style.display = 'flex';
                const emptyState = document.querySelector('.bell-notif-empty');
                if (emptyState) emptyState.style.display = 'none';
            } else {
                bellBadge.style.display = 'none';
                let body = document.getElementById('bellDropdownBody');
                if (body) {
                    let emptyState = body.querySelector('.bell-notif-empty');
                    if (!emptyState) {
                        body.innerHTML = `
                            <div class="bell-notif-empty">
                                <i class="fas fa-bell-slash"></i>
                                <p>Tidak ada notifikasi baru</p>
                            </div>
                        `;
                    } else {
                        emptyState.style.display = 'block';
                    }
                }
            }
        }
        
        updateBellBadge();
        
        bellBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            bellDropdownWrapper.classList.toggle('open');
        });
        
        document.addEventListener('click', function(e) {
            if (!bellDropdownWrapper.contains(e.target)) {
                bellDropdownWrapper.classList.remove('open');
            }
        });

        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                let readNotifs = JSON.parse(localStorage.getItem('read_bell_notifs') || '[]');
                let notifItems = document.querySelectorAll('.bell-notif-item');
                
                notifItems.forEach(item => {
                    const id = item.getAttribute('data-id');
                    if (!readNotifs.includes(id)) {
                        readNotifs.push(id);
                    }
                });
                
                localStorage.setItem('read_bell_notifs', JSON.stringify(readNotifs));
                updateBellBadge();
                bellDropdownWrapper.classList.remove('open');
            });
        }

        // Mark individual notification as read when clicked (with navigation delay for storage write)
        document.querySelectorAll('.bell-notif-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href');
                const id = this.getAttribute('data-id');
                
                let readNotifs = JSON.parse(localStorage.getItem('read_bell_notifs') || '[]');
                if (!readNotifs.includes(id)) {
                    readNotifs.push(id);
                    localStorage.setItem('read_bell_notifs', JSON.stringify(readNotifs));
                }
                
                updateBellBadge();
                
                // Navigate after short timeout to ensure storage is flushed
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 50);
            });
        });
    }
});
</script>
