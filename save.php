<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file = $_POST['file'];
    $content = $_POST['content'];

    if (file_exists($file) && is_writable($file)) {
        if (file_put_contents($file, $content) !== false) {
            header("Location: " . $_SERVER['HTTP_REFERER']); 
            exit(); 
        }
    }
}
