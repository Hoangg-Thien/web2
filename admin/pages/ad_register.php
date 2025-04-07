<?php
session_start();
require_once 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $check_sql = "SELECT * FROM nguoidung WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Tên người dùng đã tồn tại']);
    } else {
        $sql = "INSERT INTO nguoidung (username, password, fullname, phone, address, district, city, email, role) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $username, $hashed_password, $fullname, $phone, $address, $district, $city, $email, $role);
        
        if($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Thêm người dùng thành công']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi thêm người dùng: ' . $conn->error]);
        }
    }
    exit;
}
?>