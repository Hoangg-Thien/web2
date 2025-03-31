<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'website';

$conn = new mysqLi($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
echo "Kết nối thành công!";
$conn->set_charset("utf8");
?>