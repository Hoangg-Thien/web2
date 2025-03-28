<?php
session_start();
include 'connect.php';

if(isset($_POST['submit'])) {
    $username = trim($_POST['user_name']); 
    $password = $_POST['hashPass']; 
    $stmt = $conn->prepare("SELECT user_id, fullname, user_name, hashPass FROM nguoidung WHERE user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if(password_verify($password, $row['hashPass'])) { 
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['user_name'] = $row['user_name'];
            
            echo "<script>alert('Đăng nhập thành công!'); window.location.href='../index.html';</script>";
            exit();
        } else {
            echo "<script>alert('Sai mật khẩu!'); window.location.href='login-user.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Tài khoản không tồn tại!'); window.location.href='login-user.html';</script>";
        exit();
    }
}
?>
