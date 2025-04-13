<?php
    session_start();

    require './pages/connect.php';

    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
    
        // Truy vấn thông tin người dùng
        $sql = "SELECT * FROM nguoidung WHERE user_name = '$username' LIMIT 1";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
        
            if (password_verify($password, $user['hashPass'])) {
                if ($user['user_role'] === 'Quản lý') {
                    // Đăng nhập thành công và có quyền
                    $_SESSION['fullname'] = $user['user_name'];
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_role'] = $user['user_role'];
                    header("Location: /web2/admin/pages/usermanage.php");
                    exit();
                } else {
                    // Đúng mật khẩu nhưng không phải quản lý
                    $error_message = "Bạn không có quyền truy cập trang này.";
                }
            } else {
                // Sai mật khẩu
                $error_message = "Mật khẩu không đúng.";
            }
        } else {
            // Tài khoản không tồn tại
            $error_message = "Tài khoản không tồn tại.";
        }        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url('./img/background.jpg');
        background-size: cover; 
        background-position: center;
    }
    
    .login-container {
        display: flex;
        width: 800px;
        height: 400px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .left-panel {
        width: 40%;
        background-color: #4e7de1;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        border-radius: 20px 0 0 20px;
    }
    
    .left-panel h2 {
        font-size: 28px;
        margin-bottom: 10px;
    }
    
    .left-panel p {
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .register-btn {
        background: transparent;
        color: white;
        border: 1px solid white;
        padding: 10px 30px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .right-panel {
        width: 60%;
        background-color: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .right-panel h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    
    .input-group {
        margin-bottom: 20px;
        position: relative;
    }
    
    .input-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        background-color: #f8f8f8;
    }
    
    .input-group i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }
    
    .forgot-password {
        text-align: right;
        margin-bottom: 20px;
        font-size: 12px;
    }
    
    .forgot-password a {
        color: #888;
        text-decoration: none;
    }
    
    .login-btn {
        background-color: #4e7de1;
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .login-btn:hover {
        background-color: #3d6ad0;
    }

</style>
<body>
<div class="login-container">
        <div class="left-panel">
            <h2>Welcome, Admin!</h2>
        </div>
        <div class="right-panel">
            <h2>Đăng nhập</h2>

            <!-- Thông báo lỗi -->
            <?php if (isset($error_message)) : ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="input-group">
                    <input id="user" name="user" type="text" placeholder="Tên đăng nhập" required>
                    <i>👤</i>
                </div>
                <div class="input-group">
                    <input id="pass" name="pass" type="password" placeholder="Mật khẩu" required>
                    <i>🔒</i>
                </div>
                <div class="forgot-password">
                    <a href="./index.php">Quên mật khẩu?</a>
                </div>
                <button type="submit" name="login" class="login-btn">Đăng nhập</button>
            </form>
        </div>
    </div>
</body>
</html>