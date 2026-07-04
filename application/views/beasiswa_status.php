<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran Beasiswa - FIK Telkom University</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }
        
        .status-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .status-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
        }
        
        .status-header {
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 4px solid #E67E22;
        }
        
        .status-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .status-header p {
            color: #E67E22;
            font-size: 1rem;
        }
        
        .status-content {
            padding: 40px;
        }
        
        .search-box {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 2px dashed #E67E22;
        }
        
        .search-box h3 {
            color: #2C3E50;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .result-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(230, 126, 34, 0.2);
            transition: all 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(230, 126, 34, 0.1);
            border-color: #E67E22;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }
        
        .status-diproses {
            background: #cce5ff;
            color: #004085;
            border: 1px solid #b8daff;
        }
        
        .status-diterima {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 10px;
        }
        
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: #666;
        }
        
        .detail-value {
            flex: 1;
            color: #2C3E50;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
            margin: 30px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #E67E22, #f39c12);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 16px;
            height: 16px;
            background: #E67E22;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 2px #E67E22;
        }
        
        .timeline-date {
            font-size: 0.8rem;
            color: #E67E22;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .timeline-title {
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        
        .timeline-desc {
            color: #666;
            font-size: 0.9rem;
        }
        
        .btn-kembali {
            background: #2C3E50;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid #2C3E50;
        }
        
        .btn-kembali:hover {
            background: transparent;
            color: #2C3E50;
        }
        
        .btn-search {
            background: #E67E22;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn-search:hover {
            background: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #E67E22;
            opacity: 0.3;
            margin-bottom: 20px;
        }
        
        .empty-state h3 {
            color: #2C3E50;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #666;
        }
        
        @media (max-width: 768px) {
            .status-content {
                padding: 20px;
            }
            
            .detail-item {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-label {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="status-container">
        <div class="status-card">
            <div class="status-header">
                <h1><i class="fas fa-search me-3"></i>Cek Status Beasiswa</h1>
                <p>Masukkan email dan nomor WhatsApp untuk melihat status pendaftaran</p>
            </div>
            
            <div class="status-content">
                <!-- Search Box -->
                <div class="search-box">
                    <h3><i class="fas fa-chevron-right me-2" style="color: #E67E22;"></i>Cek Status Pendaftaran</h3>
                    
                    <form id="searchForm" onsubmit="cekStatus(event)">
                        <div class="mb-3">
                            <label class="form-label fw-600">
                                <i class="fas fa-envelope me-2" style="color: #E67E22;"></i>
                                Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required 
                                   placeholder="Masukkan email yang didaftarkan">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-600">
                                <i class="fas fa-phone-alt me-2" style="color: #E67E22;"></i>
                                No WhatsApp
                            </label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" required 
                                   placeholder="Masukkan nomor WhatsApp">
                        </div>
                        
                        <button type="submit" class="btn-search" id="searchBtn">
                            <i class="fas fa-search me-2"></i>
                            Cek Status
                        </button>
                    </form>
                </div>
                
                <!-- Loading Indicator -->
                <div id="loading" style="display: none; text-align: center; padding: 30px;">
                    <div class="spinner-border text-warning" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Mencari data...</p>
                </div>
                
                <!-- Alert Message -->
                <div id="alertMessage" style="display: none;"></div>
                
                <!-- Results Container -->
                <div id="resultsContainer"></div>
                
                <!-- Back Button -->
                <div class="text-center mt-4">
                    <a href="<?= base_url('beasiswa') ?>" class="btn-kembali">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Halaman Beasiswa
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function showLoading(show = true) {
            document.getElementById('loading').style.display = show ? 'block' : 'none';
            document.getElementById('searchBtn').disabled = show;
        }
        
        function showAlert(message, type = 'error') {
            const alert = document.getElementById('alertMessage');
            alert.style.display = 'block';
            alert.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-custom`;
            alert.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'} me-2"></i>
                ${message}
            `;
            
            setTimeout(() => {
                alert.style.display = 'none';
            }, 5000);
        }
        
        function formatDate(dateString) {
            const options = { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
        
        function getStatusBadge(status) {
            const badges = {
                'pending': '<span class="status-badge status-pending"><i class="fas fa-clock me-1"></i>Menunggu Verifikasi</span>',
                'diproses': '<span class="status-badge status-diproses"><i class="fas fa-sync-alt me-1"></i>Sedang Diproses</span>',
                'diterima': '<span class="status-badge status-diterima"><i class="fas fa-check-circle me-1"></i>Diterima</span>',
                'ditolak': '<span class="status-badge status-ditolak"><i class="fas fa-times-circle me-1"></i>Ditolak</span>'
            };
            return badges[status] || badges.pending;
        }
        
        function displayResults(data) {
            const container = document.getElementById('resultsContainer');
            
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-frown"></i>
                        <h3>Data Tidak Ditemukan</h3>
                        <p>Maaf, tidak ada pendaftaran dengan email dan nomor WhatsApp tersebut.</p>
                        <p class="text-muted">Pastikan Anda memasukkan data yang benar saat mendaftar.</p>
                    </div>
                `;
                return;
            }
            
            let html = '<h3 class="mb-4" style="color: #2C3E50;">Hasil Pencarian:</h3>';
            
            data.forEach(item => {
                html += `
                    <div class="result-card">
                        ${getStatusBadge(item.status)}
                        
                        <h4 style="color: #2C3E50; font-weight: 700; margin-bottom: 15px;">
                            ${item.nama}
                        </h4>
                        
                        <div class="detail-item">
                            <div class="detail-label">Jenis Beasiswa</div>
                            <div class="detail-value">${getJenisBeasiswa(item.jenis_beasiswa)}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Asal Sekolah</div>
                            <div class="detail-value">${item.asal_sekolah}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Nilai Rapor</div>
                            <div class="detail-value">${item.nilai_rapor}</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Tanggal Daftar</div>
                            <div class="detail-value">${formatDate(item.tanggal_daftar)}</div>
                        </div>
                        
                        ${item.catatan_admin ? `
                            <div class="mt-3 p-3 bg-light rounded">
                                <strong><i class="fas fa-sticky-note me-2" style="color: #E67E22;"></i>Catatan Admin:</strong>
                                <p class="mb-0 mt-2">${item.catatan_admin}</p>
                            </div>
                        ` : ''}
                        
                        <hr class="my-3">
                        
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-date">${formatDate(item.tanggal_daftar)}</div>
                                <div class="timeline-title">Pendaftaran Diterima</div>
                                <div class="timeline-desc">Data Anda telah kami terima dan akan segera diproses.</div>
                            </div>
                            
                            ${item.status === 'diproses' ? `
                                <div class="timeline-item">
                                    <div class="timeline-date">${formatDate(item.tanggal_update)}</div>
                                    <div class="timeline-title">Sedang Diproses</div>
                                    <div class="timeline-desc">Tim kami sedang memverifikasi berkas Anda.</div>
                                </div>
                            ` : ''}
                            
                            ${item.status === 'diterima' ? `
                                <div class="timeline-item">
                                    <div class="timeline-date">${formatDate(item.tanggal_update)}</div>
                                    <div class="timeline-title">Diterima</div>
                                    <div class="timeline-desc">Selamat! Anda diterima sebagai penerima beasiswa. Silakan cek email untuk informasi lebih lanjut.</div>
                                </div>
                            ` : ''}
                            
                            ${item.status === 'ditolak' ? `
                                <div class="timeline-item">
                                    <div class="timeline-date">${formatDate(item.tanggal_update)}</div>
                                    <div class="timeline-title">Ditolak</div>
                                    <div class="timeline-desc">Mohon maaf, pendaftaran Anda belum dapat diproses. ${item.catatan_admin ? item.catatan_admin : ''}</div>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }
        
        function getJenisBeasiswa(jenis) {
            const map = {
                'prestasi': 'Beasiswa Prestasi Akademik',
                'kip': 'KIP Kuliah',
                'kreatif': 'Beasiswa Kreatif',
                'afirmasi': 'Beasiswa Afirmasi',
                'telu_unggul': 'Beasiswa Tel-U Unggul',
                'internasional': 'Beasiswa International'
            };
            return map[jenis] || jenis;
        }
        
        async function cekStatus(event) {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const no_hp = document.getElementById('no_hp').value;
            
            if (!email || !no_hp) {
                showAlert('Email dan No HP wajib diisi', 'error');
                return;
            }
            
            showLoading(true);
            
            try {
                const formData = new FormData();
                formData.append('email', email);
                formData.append('no_hp', no_hp);
                
                const response = await fetch('<?= base_url("beasiswa/cek_status") ?>', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    displayResults(result.data);
                } else {
                    showAlert(result.message, 'error');
                    document.getElementById('resultsContainer').innerHTML = '';
                }
                
            } catch (error) {
                console.error('Error:', error);
                showAlert('Terjadi kesalahan koneksi', 'error');
                
            } finally {
                showLoading(false);
            }
        }
    </script>
</body>
</html>