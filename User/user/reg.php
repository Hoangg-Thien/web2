<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

if(isset($_POST['submit'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['user_name']);
    $email = trim($_POST['user_email']);
    $password = $_POST['user_pass']; 
    $phone = trim($_POST['phone']);
    $address = trim($_POST['user_address']);
    $district = trim($_POST['district']);
    $city = trim($_POST['city']);
    $user_role = "user"; 


    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($phone) || empty($address) || empty($district) || empty($city)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.'); window.location.href='regis.html';</script>";
        exit();
    }


    $stmt = $conn->prepare("SELECT user_id FROM nguoidung WHERE user_name = ? OR user_email = ?");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại.'); window.location.href='regis.html';</script>";
        exit();
    }
    $stmt->close();


    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

   
    $stmt = $conn->prepare("INSERT INTO nguoidung (fullname, user_name, user_email, user_pass, hashPass, phone, user_address, user_role, district, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ssssssssss", $fullname, $username, $email, $password, $hashed_password, $phone, $address, $user_role, $district, $city);

    if ($stmt->execute()) {
        echo "<script>
                alert('Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...');
                window.location.href='login-user.html';
              </script>";
    } else {
        echo "<script>alert('Lỗi khi đăng ký. Vui lòng thử lại!'); window.location.href='regis.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
