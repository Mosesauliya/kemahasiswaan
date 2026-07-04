<?php
// test_chat.php - Letakkan di folder root (htdocs/kemahasiswaan/)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Chat Endpoint</title>
</head>
<body>
    <h2>Test Chat Endpoint</h2>
    
    <div id="result"></div>
    
    <script>
    async function testEndpoint() {
        const result = document.getElementById('result');
        
        try {
            const formData = new FormData();
            formData.append('message', 'Halo apa kabar?');
            formData.append('mode', 'general');
            
            const response = await fetch('<?= base_url("dashboard/process_chat") ?>', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            result.innerHTML = '<h3>Success!</h3>' +
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        } catch (error) {
            result.innerHTML = '<h3 style="color:red">Error!</h3>' +
                '<p>' + error.message + '</p>';
        }
    }
    
    testEndpoint();
    </script>
</body>
</html>