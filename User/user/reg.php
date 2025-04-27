<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connect.php';

if (isset($_POST['submit'])) {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['user_name']);
    $email = trim($_POST['user_email']);
    $password = $_POST['user_pass'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['user_address']);
    $district = trim($_POST['district']);
    $city = trim($_POST['city']);
    $user_role = "Khách hàng";
    $user_status = "Hoạt động"; // hoặc giá trị bạn muốn

    // Kiểm tra các trường bắt buộc
    if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($phone) || empty($address) || empty($district) || empty($city)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin.'); window.location.href='regis.php';</script>";
        exit();
    }

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ.'); window.location.href='regis.php';</script>";
        exit();
    }
    // Kiểm tra độ mạnh của mật khẩu
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
        echo "<script>
        alert('Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
        window.location.href='regis.php';
        </script>";
        exit();
    }


    // Kiểm tra tên đăng nhập hoặc email đã tồn tại
    $stmt = $conn->prepare("SELECT user_name FROM nguoidung WHERE user_name = ? OR user_email = ?");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Tên đăng nhập hoặc email đã tồn tại.'); window.location.href='regis.php';</script>";
        $stmt->close();
        exit();
    }
    $stmt->close();


    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Chèn dữ liệu
    $stmt = $conn->prepare("INSERT INTO nguoidung (fullname, user_name, user_email, user_pass ,hashPass, phone, user_address, user_role, user_status, district, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }
    $stmt->bind_param("sssssssssss", $fullname, $username, $email, $password, $hashed_password, $phone, $address, $user_role, $user_status, $district, $city);

    if ($stmt->execute()) {
        session_start(); // 👉 Thêm dòng này để khởi động session

    // 👉 Lưu thông tin user vào session
    $_SESSION['user'] = [
        'fullname' => $fullname,
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'district' => $district,
        'city' => $city
    ];
        echo "<script>
                alert('Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...');
                window.location.href='login-user.php';
              </script>";
    } else {
        error_log("Lỗi đăng ký: " . $stmt->error);
        echo "<script>alert('Lỗi khi đăng ký. Vui lòng thử lại!'); window.location.href='regis.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>