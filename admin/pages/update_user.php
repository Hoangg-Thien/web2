<?php
require 'connect.php';

$user_name = $_POST['username'];
$fullname = $_POST['fullname'];
$user_address = $_POST['address'];
$user_email = $_POST['email'];
$phone = $_POST['phone'];
$user_role = $_POST['role'];
$user_status = $_POST['status'];
$district = $_POST['district'];
$city = $_POST['city'];

$sql = "UPDATE nguoidung SET 
        fullname = ?, 
        user_address = ?, 
        user_email = ?, 
        phone = ?, 
        user_role = ?, 
        user_status = ?,
        district = ?,
        city = ?
        WHERE user_name = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $fullname, $user_address, $user_email, $phone, $user_role, $user_status, $district, $city, $user_name);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Cập nhật thành công"]);
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?> 