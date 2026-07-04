<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 280px;
            background: linear-gradient(135deg, #2C3E50, #1a2632);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .sidebar-header p {
            margin: 0.5rem 0 0;
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.8rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(230, 126, 34, 0.2);
            color: white;
            border-left-color: #E67E22;
        }

        .sidebar-menu a i {
            width: 20px;
            color: #E67E22;
        }

        .admin-main {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #eee;
        }

        .admin-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
        }

        .btn-back {
            background: #95a5a6;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #7f8c8d;
            color: white;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .form-label {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #E67E22;
            box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
        }

        .image-preview {
            margin-top: 1rem;
            border-radius: 15px;
            overflow: hidden;
            max-width: 300px;
            border: 2px solid #ddd;
            position: relative;
        }

        .image-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-preview .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e74c3c;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .image-preview .remove-image:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        .btn-save {
            background: #E67E22;
            color: white;
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #E67E22;
        }

        .btn-save:hover {
            background: transparent;
            color: #E67E22;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(230, 126, 34, 0.3);
        }

        .btn-draft {
            background: #95a5a6;
            color: white;
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }

        .btn-draft:hover {
            background: #7f8c8d;
        }

        .char-counter {
            text-align: right;
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.3rem;
        }

        .current-image {
            margin: 1rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .current-image img {
            max-height: 100px;
            border-radius: 8px;
            margin-right: 1rem;
        }

        .alert {
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                display: none;
            }
            
            .admin-main {
                margin-left: 0;
                padding: 1rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar">
            <div class="sidebar-header">
                <h3>Admin FIK</h3>
                <p>Manajemen Berita & Konten</p>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= base_url('berita/admin') ?>">
                    <i class="fas fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= base_url('berita/admin_list') ?>" class="active">
                    <i class="fas fa-newspaper"></i>
                    <span>Semua Berita</span>
                </a>
                <a href="<?= base_url('berita/create') ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tulis Berita</span>
                </a>
                
                <div class="menu-divider"></div>
                
                <a href="<?= base_url('tak_admin') ?>">
                    <i class="fas fa-file-signature"></i>
                    <span>TAK</span>
                </a>
                <a href="<?= base_url('admin/proposal') ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Proposal</span>
                </a>
                <a href="<?= base_url('sertifikat/admin') ?>">
                    <i class="fas fa-certificate"></i>
                    <span>Sertifikat</span>
                </a>

                <div class="menu-divider"></div>
                
                <a href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <div class="admin-header">
                <h1>Edit Berita</h1>
                <a href="<?= base_url('berita/admin_list') ?>" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if($this->session->flashdata('error') || validation_errors()): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $this->session->flashdata('error') ?>
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <div class="form-container">
                <?= form_open_multipart('berita/edit/' . $berita['id'], ['id' => 'beritaForm']) ?>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" id="judul" 
                                   placeholder="Masukkan judul berita" 
                                   value="<?= set_value('judul', $berita['judul']) ?>" required>
                            <div class="char-counter">
                                <span id="judulCounter"><?= strlen($berita['judul']) ?></span>/255 karakter
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="berita" <?= set_select('kategori', 'berita', $berita['kategori'] == 'berita') ?>>Berita</option>
                                <option value="pengumuman" <?= set_select('kategori', 'pengumuman', $berita['kategori'] == 'pengumuman') ?>>Pengumuman</option>
                                <option value="artikel" <?= set_select('kategori', 'artikel', $berita['kategori'] == 'artikel') ?>>Artikel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" 
                                   placeholder="Nama penulis" 
                                   value="<?= set_value('penulis', $berita['penulis']) ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Sumber (opsional)</label>
                            <input type="text" class="form-control" name="sumber" 
                                   placeholder="Contoh: Humas FIK, Antara News, dll"
                                   value="<?= set_value('sumber', $berita['sumber']) ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ringkasan / Excerpt</label>
                        <textarea class="form-control" name="ringkasan" id="ringkasan" 
                                  rows="3" placeholder="Ringkasan singkat berita (maks 500 karakter)"><?= set_value('ringkasan', $berita['ringkasan']) ?></textarea>
                        <div class="char-counter">
                            <span id="ringkasanCounter"><?= strlen($berita['ringkasan']) ?></span>/500 karakter
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konten Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="konten" id="konten" rows="15"><?= set_value('konten', $berita['konten']) ?></textarea>
                    </div>

                    <!-- Current Image -->
                    <?php if($berita['gambar']): ?>
                    <div class="current-image">
                        <label class="form-label">Gambar Saat Ini</label>
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url('uploads/berita/' . $berita['gambar']) ?>" alt="Current Image">
                            <div class="ms-3">
                                <p class="mb-1"><strong>Filename:</strong> <?= $berita['gambar'] ?></p>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hapus_gambar" id="hapusGambar" value="1">
                                    <label class="form-check-label text-danger" for="hapusGambar">
                                        <i class="fas fa-trash me-1"></i>Hapus gambar ini
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label">Ganti Gambar (kosongkan jika tidak ingin mengganti)</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                        
                        <!-- Image Preview for new image -->
                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <img src="" alt="Preview" id="previewImg">
                            <button type="button" class="remove-image" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1" <?= $berita['featured'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star text-warning me-1"></i> Jadikan sebagai Featured / Berita Pilihan
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Status Publikasi</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" <?= $berita['status'] == 'draft' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusDraft">
                                        <span class="badge bg-secondary">Draft</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusPublish" value="publish" <?= $berita['status'] == 'publish' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusPublish">
                                        <span class="badge bg-success">Publish</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i>Update Berita
                        </button>
                        <a href="<?= base_url('berita/detail/' . $berita['slug']) ?>" target="_blank" class="btn-draft" style="background: #3498db;">
                            <i class="fas fa-eye me-2"></i>Preview
                        </a>
                    </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('konten', {
            height: 400,
            toolbar: [
                { name: 'document', items: [ 'Source', '-', 'Preview' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize' ] }
            ]
        });

        // Character counters
        document.getElementById('judul').addEventListener('keyup', function() {
            document.getElementById('judulCounter').textContent = this.value.length;
        });

        document.getElementById('ringkasan').addEventListener('keyup', function() {
            document.getElementById('ringkasanCounter').textContent = this.value.length;
        });

        // Image preview for new image
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('removeImage').addEventListener('click', function() {
            document.getElementById('gambar').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('previewImg').src = '';
        });

        // Form validation and Loading state
        document.getElementById('beritaForm').addEventListener('submit', function(e) {
            // Update CKEditor content to textarea
            if (window.CKEDITOR && CKEDITOR.instances.konten) {
                CKEDITOR.instances.konten.updateElement();
            }

            const judul = document.getElementById('judul').value.trim();
            const kategori = document.querySelector('select[name="kategori"]').value;
            const konten = document.getElementById('konten').value.trim();

            if (!judul || judul.length < 5) {
                e.preventDefault();
                alert('Judul berita harus diisi dan minimal 5 karakter!');
                document.getElementById('judul').focus();
                return false;
            }

            if (!kategori) {
                e.preventDefault();
                alert('Kategori harus dipilih!');
                return false;
            }

            if (!konten || konten === '' || konten.length < 20) {
                e.preventDefault();
                alert('Konten berita harus diisi dan minimal 20 karakter!');
                if (CKEDITOR.instances.konten) {
                    CKEDITOR.instances.konten.focus();
                } else {
                    document.getElementById('konten').focus();
                }
                return false;
            }

            // Show loading and disable submit button
            const btn = document.querySelector('button[type="submit"]');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
                btn.disabled = true;
            }
        });
    </script>
</body>
</html>