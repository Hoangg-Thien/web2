<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'website';

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt bộ mã ký tự để hỗ trợ tiếng Việt
$conn->set_charset("utf8mb4");
?>
