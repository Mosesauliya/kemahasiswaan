<?php
// setup_folders.php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

$folders = [
    FCPATH . 'uploads',
    FCPATH . 'uploads/surat_pengajuan',
    FCPATH . 'uploads/excel_peserta',
    FCPATH . 'templates'
];

echo "<h3>Setup Folders untuk Upload</h3>";
echo "<pre>";

foreach ($folders as $folder) {
    echo "Memproses: " . $folder . "\n";
    
    if (!file_exists($folder)) {
        if (mkdir($folder, 0777, true)) {
            echo "✅ Folder berhasil dibuat\n";
        } else {
            echo "❌ Gagal membuat folder\n";
        }
    } else {
        echo "✓ Folder sudah ada\n";
    }
    
    // Coba ubah permission
    if (file_exists($folder)) {
        if (chmod($folder, 0777)) {
            echo "  Permission folder diubah ke 0777\n";
        } else {
            echo "  Gagal mengubah permission\n";
        }
    }
    
    // Cek writable
    if (is_writable($folder)) {
        echo "  Folder dapat ditulisi (writable)\n";
    } else {
        echo "  Folder TIDAK dapat ditulisi (not writable)\n";
    }
    
    echo "\n";
}

// Buat file test di folder uploads
$test_file = FCPATH . 'uploads/test.txt';
if (file_put_contents($test_file, 'Test write permission')) {
    echo "✅ Berhasil membuat file test\n";
    unlink($test_file);
    echo "  File test dihapus\n";
} else {
    echo "❌ Gagal membuat file test\n";
}

echo "\n";
echo "Current FCPATH: " . FCPATH . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "</pre>";
?>