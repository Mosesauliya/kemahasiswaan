<?php
echo "Testing 127.0.0.1...\n";
try {
    $mysqli2 = new mysqli('127.0.0.1', 'root', '', 'kemahasiswaan');
    echo "127.0.0.1 succeeded!\n";
} catch (Exception $e) {
    echo '127.0.0.1 failed: ' . $e->getMessage() . "\n";
}
?>
