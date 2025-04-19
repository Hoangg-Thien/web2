<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Kết nối thành công";

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'c07db';

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt bộ mã ký tự để hỗ trợ tiếng Việt
$conn->set_charset("utf8mb4");
?>
