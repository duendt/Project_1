<?php

function view($view, $data = []) {
    // Extract data thành các biến riêng lẻ
    extract($data);
    
    // Bắt đầu output buffering
    ob_start();
    
    // Include view file
    require_once __DIR__ . "/../Views/{$view}.php";
    
    // Lấy nội dung từ buffer và xóa buffer
    $content = ob_get_clean();
    
    // Load layout
    require_once __DIR__ . "/../Views/layouts/main.php";
} 