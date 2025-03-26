<?php
session_start();
include 'connect.php';

if(isset($_POST['submit'])) {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT uid, fullname, username, password FROM dangky WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) { 
            $_SESSION['uid'] = $row['uid'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['username'] = $row['username'];
            
            echo "<script>alert('Đăng nhập thành công!'); window.location.href='../index.html';</script>";
            exit();
        } else {
            echo "<script>alert('Sai mật khẩu!'); window.location.href='login-user.html';</script>";
        }
    } else {
        echo "<script>alert('Tài khoản không tồn tại!'); window.location.href='login-user.html';</script>";
    }
}
?>