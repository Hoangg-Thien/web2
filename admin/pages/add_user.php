<?php
session_start();
require 'connect.php';

$user_name = $_POST['username'];
$user_pass = $_POST['password'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$user_address = $_POST['address'];
$district = $_POST['district'];
$city = $_POST['city'];
$user_email = $_POST['email'];
$user_role = $_POST['role'];

$hashPass = password_hash($user_pass, PASSWORD_DEFAULT);

$check_sql = "SELECT * FROM nguoidung WHERE user_name = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $user_name);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "error", 
        "message" => "Tên người dùng đã tồn tại"
    ]);
} else {
    $sql = "INSERT INTO nguoidung (user_name, user_pass, hashPass, fullname, phone, user_address, district, city, user_email, user_role, user_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Hoạt động')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $user_name, $user_pass, $hashPass, $fullname, $phone, $user_address, $district, $city, $user_email, $user_role);
    
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success", 
            "message" => "Thêm người dùng thành công"
        ]);
    } else {
        echo json_encode([
            "status" => "error", 
            "message" => "Lỗi: " . $stmt->error
        ]);
    }
    $stmt->close();
}

$check_stmt->close();
$conn->close();
?> 