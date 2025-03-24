<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

if(isset($_POST['submit'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Kiểm tra dữ liệu nhập vào
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.'); window.location.href='register.html';</script>";
        exit();
    }

    // Kiểm tra xem username hoặc email đã tồn tại chưa
    $stmt = $conn->prepare("SELECT uid FROM dangky WHERE username = ? OR email = ?");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại.'); window.location.href='register.html';</script>";
        exit();
    }
    $stmt->close();

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Chèn dữ liệu vào database
    $stmt = $conn->prepare("INSERT INTO dangky (fullname, username, email, password, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ssssss", $fullname, $username, $email, $hashed_password, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>
                alert('Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...');
                window.location.href='login-user.html';
              </script>";
    } else {
        echo "<script>alert('Lỗi khi đăng ký. Vui lòng thử lại!'); window.location.href='register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>