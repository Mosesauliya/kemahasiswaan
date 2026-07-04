<?php
// test_upload.php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['test_file'])) {
    $upload_dir = __DIR__ . '/uploads/surat_pengajuan/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $file = $_FILES['test_file'];
    $target_path = $upload_dir . basename($file['name']);
    
    echo "<h3>Hasil Upload Test</h3>";
    echo "<pre>";
    echo "File asli: " . $file['name'] . "\n";
    echo "Ukuran: " . $file['size'] . " bytes\n";
    echo "Tipe: " . $file['type'] . "\n";
    echo "Tmp name: " . $file['tmp_name'] . "\n";
    echo "Error: " . $file['error'] . "\n";
    echo "Target path: " . $target_path . "\n";
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        echo "✅ File berhasil diupload ke: " . $target_path . "\n";
        echo "Folder writable: " . (is_writable($upload_dir) ? 'Ya' : 'Tidak') . "\n";
    } else {
        echo "❌ Gagal upload file\n";
        echo "Error: " . error_get_last()['message'] . "\n";
    }
    echo "</pre>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; }
        .info { background: #f0f0f0; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Test Upload File</h2>
        
        <div class="info">
            <strong>Informasi:</strong><br>
            Upload Path: <?= __DIR__ ?>/uploads/surat_pengajuan/<br>
            Folder exists: <?= is_dir(__DIR__ . '/uploads/surat_pengajuan/') ? 'Ya' : 'Tidak' ?><br>
            Folder writable: <?= is_writable(__DIR__ . '/uploads/surat_pengajuan/') ? 'Ya' : 'Tidak' ?><br>
        </div>
        
        <form method="POST" enctype="multipart/form-data">
            <div style="margin: 10px 0;">
                <label>Pilih file PDF/DOC:</label><br>
                <input type="file" name="test_file" accept=".pdf,.doc,.docx" required>
            </div>
            <button type="submit">Upload Test</button>
        </form>
        
        <p style="margin-top: 20px;">
            <a href="<?= base_url('tak/create_upload_folders') ?>">Buat Folder Upload (via Controller)</a>
        </p>
    </div>
</body>
</html>