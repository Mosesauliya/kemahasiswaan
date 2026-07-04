<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            border: 2px dashed #ddd;
            position: relative;
            display: none;
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

        .alert {
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }

        /* Responsive */
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
                <a href="<?= base_url('berita/admin_list') ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>Semua Berita</span>
                </a>
                <a href="<?= base_url('berita/create') ?>" class="active">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tulis Berita</span>
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
                <h1>Tulis Berita Baru</h1>
                <a href="<?= base_url('berita/admin_list') ?>" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Alert Messages -->
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <div class="form-container">
                <?= form_open_multipart('berita/create', ['id' => 'beritaForm']) ?>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul" id="judul" 
                                   placeholder="Masukkan judul berita" 
                                   value="<?= set_value('judul') ?>" required>
                            <div class="char-counter">
                                <span id="judulCounter">0</span>/255 karakter
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="berita" <?= set_select('kategori', 'berita') ?>>Berita</option>
                                <option value="pengumuman" <?= set_select('kategori', 'pengumuman') ?>>Pengumuman</option>
                                <option value="artikel" <?= set_select('kategori', 'artikel') ?>>Artikel</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" class="form-control" name="penulis" 
                                   placeholder="Nama penulis" 
                                   value="<?= set_value('penulis', $this->session->userdata('nama')) ?>">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Sumber (opsional)</label>
                            <input type="text" class="form-control" name="sumber" 
                                   placeholder="Contoh: Humas FIK, Antara News, dll"
                                   value="<?= set_value('sumber') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ringkasan / Excerpt</label>
                        <textarea class="form-control" name="ringkasan" id="ringkasan" 
                                  rows="3" placeholder="Ringkasan singkat berita (maks 500 karakter)"><?= set_value('ringkasan') ?></textarea>
                        <div class="char-counter">
                            <span id="ringkasanCounter">0</span>/500 karakter
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konten Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="konten" id="konten" rows="15"><?= set_value('konten') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Gambar Featured</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <small class="text-muted">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB</small>
                        
                        <!-- Image Preview -->
                        <div class="image-preview" id="imagePreview">
                            <img src="" alt="Preview" id="previewImg">
                            <button type="button" class="remove-image" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1">
                                <label class="form-check-label" for="featured">
                                    <i class="fas fa-star text-warning me-1"></i> Jadikan sebagai Featured / Berita Pilihan
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Status Publikasi</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusDraft" value="draft" checked>
                                    <label class="form-check-label" for="statusDraft">
                                        <span class="badge bg-secondary">Draft</span> Simpan sebagai draft
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusPublish" value="publish">
                                    <label class="form-check-label" for="statusPublish">
                                        <span class="badge bg-success">Publish</span> Publikasikan langsung
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <button type="button" class="btn-draft" onclick="saveAsDraft()">
                            <i class="fas fa-save me-2"></i>Simpan sebagai Draft
                        </button>
                        <button type="submit" class="btn-save" name="submit_type" value="publish">
                            <i class="fas fa-paper-plane me-2"></i>Publikasikan
                        </button>
                    </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Initialize CKEditor
        CKEDITOR.replace('konten', {
            height: 400,
            toolbar: [
                { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'about', items: [ 'About' ] }
            ],
            removeButtons: 'Save,NewPage,Print,Flash,Iframe',
            format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
            removeDialogTabs: 'image:advanced;link:advanced'
        });

        // Character counters
        document.getElementById('judul').addEventListener('keyup', function() {
            document.getElementById('judulCounter').textContent = this.value.length;
        });

        document.getElementById('ringkasan').addEventListener('keyup', function() {
            document.getElementById('ringkasanCounter').textContent = this.value.length;
        });

        // Image preview
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

        // Save as draft function
        function saveAsDraft() {
            document.getElementById('statusDraft').checked = true;
            document.getElementById('beritaForm').submit();
        }

        // Form validation
        document.getElementById('beritaForm').addEventListener('submit', function(e) {
            const judul = document.getElementById('judul').value.trim();
            const kategori = document.querySelector('select[name="kategori"]').value;
            const konten = CKEDITOR.instances.konten.getData().trim();

            if (!judul) {
                e.preventDefault();
                alert('Judul berita harus diisi!');
                document.getElementById('judul').focus();
                return false;
            }

            if (!kategori) {
                e.preventDefault();
                alert('Kategori harus dipilih!');
                return false;
            }

            if (!konten || konten === '') {
                e.preventDefault();
                alert('Konten berita harus diisi!');
                CKEDITOR.instances.konten.focus();
                return false;
            }
        });

        // Initialize Select2 if needed
        // $('.form-select').select2();

        // Show loading on submit
        document.getElementById('beritaForm').addEventListener('submit', function() {
            const btn = document.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            btn.disabled = true;
        });
    </script>
</body>
</html>