<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/regis.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon"> 
    <title>Đăng Ký Tài Khoản</title>
</head>
<style>
  .input-group {
  position: relative;
}

.input-group input {
  width: 100%;
  padding-right: 40px; /* tạo khoảng trống cho icon và dấu sao */
  box-sizing: border-box;
}

.required-star {
  position: absolute;
  top: 50%;
  right: 35px; /* điều chỉnh nếu icon nằm quá sát */
  transform: translateY(-50%);
  color: red;
  font-size: 14px;
  pointer-events: none;
}
</style>
<body>
    <div class="form-container">
        <h2>Đăng Ký Tài Khoản</h2>
        <form id="registration-form" action="reg.php" method="POST">
          <div class="input-group">
            <input type="text" name="fullname" placeholder="Họ và Tên" required>
            <span class="required-star">*</span>
            <i class="fa-regular fa-user icon"></i>
          </div>
          <div class="input-group">
            <input type="text" name="user_name" placeholder="Tên Đăng Nhập" required>
            <span class="required-star">*</span>
            <i class="fa-regular fa-user icon"></i>
          </div>
          <div class="input-group">
            <input type="email" name="user_email" placeholder="Email" required>
            <span class="required-star">*</span>
            <i class="fa-regular fa-envelope icon"></i>
          </div>
          <div class="input-group">
            <input type="password" name="user_pass" placeholder="Mật Khẩu" required>
            <span class="required-star">*</span>
            <i class="fa-solid fa-lock icon"></i>
          </div>
          <div class="input-group">
            <input type="tel" name="phone" placeholder="Số Điện Thoại" required>
            <span class="required-star">*</span>
            <i class="fa-solid fa-phone icon"></i>
          </div>
          <div class="input-group">
            <input type="text" name="user_address" placeholder="Địa Chỉ" required>
            <i class="fa-solid fa-location-dot icon"></i>
          </div>
          <div class="input-group">
            <input type="text" name="district" placeholder="Quận/Huyện" required>
            <i class="fa-solid fa-city icon"></i>
          </div>
          <div class="input-group">
            <input type="text" name="city" placeholder="Thành Phố" required>
            <i class="fa-solid fa-city icon"></i>
          </div>
          <button type="submit" name="submit">Đăng Ký</button>
          <p>Bạn đã có tài khoản? <a target="_blank" href="../user/login-user.php">Đăng nhập ngay</a></p>
        </form>
        <div id="notification" class="hidden"></div>
    </div>
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const fields = ["fullname", "user_name", "user_email", "hashPass", "phone", "user_address", "district", "city"];

    fields.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        const errorElement = document.createElement("p");
        errorElement.style.color = "red";
        errorElement.style.fontSize = "14px";
        errorElement.style.display = "none";
        input.parentNode.appendChild(errorElement);

        input.addEventListener("input", function () {
            if (!input.value.trim()) {
                errorElement.textContent = "Trường này không được để trống!";
                errorElement.style.display = "block";
            } else {
                errorElement.style.display = "none";
            }
        });

        input.addEventListener("blur", function () {
            if (!input.value.trim()) {
                errorElement.textContent = "Trường này không được để trống!";
                errorElement.style.display = "block";
            } else {
                errorElement.style.display = "none";
            }
        });
    });
});
</script>

</html>